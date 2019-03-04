<?php

/**
 * @table paysystems
 * @id paypal
 * @title PayPal Plus
 * @visible_link http://www.paypal.com/
 * @recurring no
 * @logo_url paypal.png
 */
class Am_Paysystem_PaypalPlus extends Am_Paysystem_Abstract
{
    const PLUGIN_STATUS = self::STATUS_BETA;
    const PLUGIN_REVISION = '5.4.1';
    const SANDBOX_ENDPOINT = 'https://api.sandbox.paypal.com';
    const LIVE_ENDPOINT = 'https://api.paypal.com';
    const PAYMENT_KEY = 'PAYPAL-PLUS-PAYMENT-ID';

    protected
        $defaultTitle = "PayPal Plus",
        $defaultDescription = "pay with PayPal",
        $_canAutoCreate = false;

    function getRecurringType()
    {
        return self::REPORTS_NOT_RECURRING;
    }

    function getSupportedCurrencies()
    {
        return array('EUR');
    }

    function _initSetupForm(\Am_Form_Setup $form)
    {
        $form->addText('client_id', array('size' => 60))->setLabel(___("OAuth client_id"));
        $form->addText('secret', array('size' => 60))->setLabel(___("OAuth Secret"));
        $form->addAdvCheckbox('testing')->setLabel('Test mode');
        $form->addText('secret', array('size' => 60))->setLabel(
            ___("Paypal interface language\n
                en_US - english, de_DE - german, default is german")
            );
    }

    function getReadme()
    {
        return <<<CUT
Create Paypal application as explained in this article: 
    https://developer.paypal.com/webapps/developer/docs/integration/direct/make-your-first-call/#create-a-paypal-app
When you create an app, PayPal generates a set of OAuth keys for the application (the keys consist of a client_id and secret). 
These keys are created for both the Sandbox and Live environments.
CUT;
    }

    function _process(Invoice $invoice, $request, $result)
    {
        $api = $this->getApi();

        $items = array(
        );
        foreach ($invoice->getItems() as $item)
        {
            $item = array(
                'name' => $item->item_title,
                'quantity' => intval($item->qty),
                'price' => floatval($item->first_price),
                'currency' => $invoice->currency
            );
            $items['items'][] = $item;
        }
        $data = array(
            'intent' => 'sale',
            'redirect_urls' => array(
                'return_url' => $this->getPluginUrl('thanks'),
                'cancel_url' => $this->getCancelUrl()
            ),
            'payer' => array(
                'payment_method' => 'paypal'
            ),
            'transactions' => array(
                array(
                    'amount' => array(
                        'currency' => $invoice->currency,
                        'total' => floatval($invoice->first_total),
                        'details' => array(
                            'subtotal' => floatval($invoice->first_subtotal),
                            'tax' => $invoice->first_tax,
                        )
                    ),
                    'description' => $invoice->getLineDescription(),
                    'invoice_number' => $invoice->public_id,
                    'item_list' => $items,
                )
            ),
        );
        $payment = $api->createPayment($data, $invoice);

        if (empty($payment['id']))
            throw new Am_Exception_InternalError("No transaction id was returned. Create request wasn't successful.");

        $invoice->data()->set(self::PAYMENT_KEY, $payment['id'])->update();
        $a = new Am_Paysystem_Action_HtmlTemplate_PaypalPlus($this->getDir(), 'confirm.phtml');
        $a->payment = $payment;
        $a->approval_url = $this->getApprovalUrl($payment);
        $a->invoice = $invoice;
        $a->country = $invoice->getCountry() ? : 'DE';
        $a->mode   = $this->getConfig('testing') ? 'sandbox' : 'live';
        $a->language = $this->getConfig('language', 'de_DE');
        $result->setAction($a); 
    }

    function getApprovalUrl($payment)
    {
        foreach (@$payment['links'] as $r)
            if (@$r['rel'] == 'approval_url')
                return @$r['href'];
    }

    /**
     * 
     * @return \Am_PaypalRestAPI
     */
    function getApi()
    {
        return new Am_PaypalRestAPI(
            $this->getDi(), ($this->getConfig('testing') ? self::SANDBOX_ENDPOINT : self::LIVE_ENDPOINT), $this->getConfig('client_id'), $this->getConfig('secret')
        );
    }

    function createThanksTransaction($request, $response, array $invokeArgs)
    {
        return new Am_Paysystem_Transaction_PaypalPlus($this, $request, $response, $invokeArgs);
    }
    
    function processRefund(\InvoicePayment $payment, \Am_Paysystem_Result $result, $amount)
    {
        $api = $this->getApi();
        $req = $api->createApiRequest($api->getEndpoint(sprintf('/v1/payments/sale/%s/refund',$payment->getInvoice()->data()->get(self::PAYMENT_KEY))), "POST");
        $ret = $api->_processRequest($req, new stdClass, $payment->getInvoice());
        if(@$ret['state'] == 'completed')
            return true;
    }

}

class Am_PaypalRestAPI
{

    protected
        $di, $endpoint, $client_id, $secret;

    const
        TOKEN_KEY = 'paypal-rest-token';

    function __construct(Am_Di $di, $endpoint, $client_id, $secret)
    {
        $this->di = $di;
        $this->endpoint = $endpoint;
        $this->client_id = $client_id;
        $this->secret = $secret;
    }

    /**
     * 
     * @return Am_Di
     */
    function getDi()
    {
        return $this->di;
    }

    function getEndpoint($function)
    {
        return $this->endpoint . $function;
    }

    function requestToken()
    {
        $req = new Am_HttpRequest($this->getEndpoint('/v1/oauth2/token'));
        $req->setMethod(Am_HttpRequest::METHOD_POST);
        $req->setHeader('Accept', 'application/json');
        $req->setAuth($this->client_id, $this->secret);
        $req->addPostParameter('grant_type', 'client_credentials');

        $resp = $req->send();

        if ($resp->getStatus() !== 200)
            throw new Am_Exception_InternalError(___("Can't obtaint OAuth2 token"));

        $ret = json_decode($resp->getBody(), true);

        if (empty($ret['access_token']))
            throw new Am_Exception_InternalError(___('Token is empy in response object'));
        return $ret;
    }

    function getToken()
    {
        $token = $this->getDi()->store->get(self::TOKEN_KEY);
        if (empty($token))
        {
            $token = $this->requestToken();
            $this->getDi()->store->set(self::TOKEN_KEY, $token['access_token'], "+" . $token['expires_in'] . " seconds");
            $token = $token['access_token'];
        }
        return $token;
    }

    function createPayment($data, Invoice $invoice)
    {
        $req = $this->createApiRequest($this->getEndpoint('/v1/payments/payment'), "POST");

        return $this->_processRequest($req, $data, $invoice);
    }

    function _processRequest(Am_HttpRequest $req, $data, Invoice $invoice)
    {

        $log = $invoice->getDi()->invoiceLogRecord;
        $log->setInvoice($invoice);
        $log->title = $req->getMethod() . ': ' . $req->getUrl();
        $log->add(array('request' => $data), true);

        $req->setBody(json_encode($data));
        $req->setHeader('Content-Type', 'application/json');

        $resp = $req->send();
        $body = $resp->getBody();
        $ret = json_decode($body, true);
        $log->add(array('response' => $ret), true);
        
        if (@$ret['message'])
        {
            throw new Am_Exception_InputError($ret['message']);
        }


        return $ret;
    }

    function executePayment($payment_id, $payer_id, $invoice)
    {
        $req = $this->createApiRequest($this->getEndpoint(sprintf('/v1/payments/payment/%s/execute', $payment_id)), 'POST');
        return $this->_processRequest($req, array('payer_id' => $payer_id), $invoice);
    }

    function createApiRequest($uri, $method = 'GET')
    {
        $req = new Am_HttpRequest($uri);
        $req->setMethod($method);
        $req->setHeader('Authorization', "Bearer " . $this->getToken());
        return $req;
    }

}

class Am_Paysystem_Action_HtmlTemplate_PaypalPlus extends Am_Paysystem_Action_HtmlTemplate
{

    protected
        $_template,
        $_path;

    public
        function __construct($path, $template)
    {
        $this->_template = $template;
        $this->_path = $path;
    }

    public
        function process(Am_Mvc_Controller $action = null)
    {
        $action->view->addBasePath($this->_path);

        $action->view->assign($this->getVars());
        $action->view->headScript()->appendFile('https://www.paypalobjects.com/webstatic/ppplus/ppplus.min.js');
        $action->renderScript($this->_template);

        throw new Am_Exception_Redirect;
    }

}

class Am_Paysystem_Transaction_PaypalPlus extends Am_Paysystem_Transaction_Incoming_Thanks
{

    public
        function getUniqId()
    {
        return $this->request->get('paymentId');
    }

    function findInvoiceId()
    {
        $invoice = $this->getPlugin()->getDi()->invoiceTable->findFirstByData(Am_Paysystem_PaypalPlus::PAYMENT_KEY, $this->request->get('paymentId'));
        if ($invoice)
            return $invoice->public_id;
    }

    public
        function validateSource()
    {
        return true;
    }

    public
        function validateStatus()
    {
        $payment_id = $this->request->get('paymentId');

        if ($this->invoice->data()->get(Am_Paysystem_PaypalPlus::PAYMENT_KEY) != $this->request->get('paymentId'))
            throw new Am_Exception_InternalError('Payment was created for different invoice');

        $ret = $this->getPlugin()->getApi()->executePayment($payment_id, $this->request->get('PayerID'), $this->invoice);
        return (@$ret['state'] == 'approved');
    }

    public
        function validateTerms()
    {
        return true;
    }

    function processValidated()
    {
        $this->invoice->addPayment($this);
    }

}
