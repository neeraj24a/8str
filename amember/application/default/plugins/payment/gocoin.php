<?php

class Am_Paysystem_Gocoin extends Am_Paysystem_Abstract
{
    const PLUGIN_STATUS = self::STATUS_BETA;
    const PLUGIN_REVISION = '5.6.0';

    const GOCOIN_ID = 'gocoin-id';
    
    protected $defaultTitle = 'GoCoin';
    protected $defaultDescription = 'Bitcoin Payment';

    public function getRecurringType()
    {
        return self::REPORTS_NOT_RECURRING;
    }

    function getSupportedCurrencies()
    {
        return array('USD', 'GBP', 'EUR');
    }
    function directAction($request, $response, $invokeArgs)
    {
        switch($request->getActionName()) {
            case 'callback':
                return $this->callbackAction($request);
                break;
            default:
                return parent::directAction($request, $response, $invokeArgs);
                break;
        }
    }

    public function _initSetupForm(Am_Form_Setup $form)
    {
        $form->addText('merchant_id', array('class' => 'am-el-wide'))
            ->setLabel('Merchant ID')
            ->addRule('required');
        $form->addText('api_key', array('class' => 'am-el-wide'))
            ->setLabel('API Key')
            ->addRule('required');
    }

    public function isConfigured()
    {
        return $this->getConfig('merchant_id');
    }
    
    public function _process(Invoice $invoice, Am_Mvc_Request $request, Am_Paysystem_Result $result)
    {
        $req = new Am_HttpRequest('https://api.gocoin.com/api/v1/merchants/'. $this->getConfig('merchant_id') .'/invoices', Am_HttpRequest::METHOD_POST);
        $vars = array(
            'price_currency' => 'BTC',
            'base_price' => $invoice->first_total,
            'base_price_currency' => $invoice->currency,
            'callback_url' => $this->getPluginUrl('ipn'),
            'redirect_url' => $this->getReturnUrl()
        );
        $req->setBody(json_encode($vars));
        $req->setHeader('Content-type', 'application/json');
        $req->setHeader('Accept', 'application/json');
        $req->setHeader('Authorization', 'Bearer ' . $this->getConfig('api_key'));
        $log = Am_Di::getInstance()->invoiceLogRecord;
        $log->setInvoice($invoice);
        $log->paysys_id = $invoice->paysys_id;
        $log->add($req);        
        $res = $req->send();
        $log->add($res);
        if($res->getStatus() != 201)
        {
            throw new Am_Exception_InputError(___('Error happened during payment process. '));
        }
        $resp = json_decode($res->getBody(), true);
        $invoice->data()->set(self::GOCOIN_ID, $resp['id'])->update();
        $action = new Am_Paysystem_Action_Redirect($resp['gateway_url']);
        $result->setAction($action);
    }
    
    function createTransaction($request, $response, array $invokeArgs)
    {
        return new Am_Paysystem_Transaction_Gocoin($this, $request, $response, $invokeArgs);
    }
    
}

class Am_Paysystem_Transaction_Gocoin extends Am_Paysystem_Transaction_Incoming
{
    
    public function __construct($plugin, $request, $response, $invokeArgs)
    {
        parent::__construct($plugin, $request, $response, $invokeArgs);
        $this->vars = json_decode($this->request->getRawBody(), true);
    }

    public function getUniqId()
    {
        return $this->vars['id'];
    }

    public function validateSource()
    {
        return true;
    }

    public function validateStatus()
    {
        return $this->vars['event'] == 'invoice_payment_received';
    }

    public function validateTerms()
    {
        return doubleval($this->vars['payload']['base_price'] == doubleval($this->invoice->first_total));
    }
    
    function findInvoiceId()
    {
        if($invoice = Am_Di::getInstance()->invoiceTable->findFirstByData(Am_Paysystem_Gocoin::GOCOIN_ID, $this->vars['payload']['id']));
            return $invoice->public_id;
    }
    
}
