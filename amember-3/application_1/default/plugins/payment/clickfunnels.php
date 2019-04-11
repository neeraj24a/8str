<?php

class Am_Paysystem_Clickfunnels extends Am_Paysystem_Abstract
{

    const
        PLUGIN_STATUS = self::STATUS_BETA,
        PLUGIN_REVISION = '5.4.1';

    protected
        $defaultTitle = 'ClickFunnels',
        $defaultDescription = '';

    public
        function __construct(Am_Di $di, array $config)
    {

        parent::__construct($di, $config);
        foreach ($di->paysystemList->getList() as $k => $p)
        {
            if ($p->getId() == $this->getId())
                $p->setPublic(false);
        }
        $di->billingPlanTable->customFields()->add(
            new Am_CustomFieldText(
            'clickfunnels_id', "Clickfunnels product ID", "please see product readme"
            , array(/* ,'required' */)
        ));
    }

    public
        function _initSetupForm(Am_Form_Setup $form)
    {
        
    }

    public
        function canAutoCreate()
    {
        return true;
    }

    protected
        function _afterInitSetupForm(Am_Form_Setup $form)
    {
        parent::_afterInitSetupForm($form);
        $form->removeElementByName($this->_configPrefix . $this->getId() . '.auto_create');
    }

    function getConfig($key = null, $default = null)
    {
        switch ($key)
        {
            case 'testing' : return false;
            case 'auto_create' : return true;
            default: return parent::getConfig($key, $default);
        }
    }

    public
        function _process(Invoice $invoice, Am_Mvc_Request $request, Am_Paysystem_Result $result)
    {
        
    }

    public
        function createTransaction(Am_Mvc_Request $request, Am_Mvc_Response $response, array $invokeArgs)
    {
        return new Am_Paysystem_Transaction_Clickfunnels($this, $request, $response, $invokeArgs);
    }

    public
        function getRecurringType()
    {
        return self::REPORTS_REBILL;
    }

    public
        function getSupportedCurrencies()
    {
        return array('USD');
    }

    public
        function getReadme()
    {
        $ipn = $this->getPluginUrl('ipn');
        return <<<CUT
In your ClickFunnels account go to Funnels -> Edit Funnel -> Settings -> Webhooks -> Manage Your Funnel Webhooks -> + New Webhook. 
In the form specify: 
URL: {$ipn}
EVENT: purchase_created
ADAPTER: Attributes 


In order to setup integration between aMember product and ClickFunnel, 
create product in aMember with the same settings, then go to ClickFullens -> Edit Funnel,   switch to Order Form step, Open Products tab. 
In that tab you will see list of the products. In order to get product id, right click on Product Edit button and copy edit url. 
Example: https://app.clickfunnels.com/products/xxxxxxx/edit?all=false&funnel_step_id=43434347
Here xxxxxxx  is product ID that you have to specify in amember CP -> Manage products -> Edit Product -> Clickfunnel Product ID. 

CUT;
    }

}

class Am_Paysystem_Transaction_Clickfunnels extends Am_Paysystem_Transaction_Incoming
{

    protected
        $_autoCreateMap = array(),
        $req = array();

    function __construct($plugin, $request, $response, $invokeArgs)
    {

        parent::__construct($plugin, $request, $response, $invokeArgs);
        $this->req = json_decode($request->getRawBody(), true);
    }

    function generateInvoiceExternalId()
    {
        return $this->req['subscription_id'] ? : $this->req['charge_id'];
    }

    function generateUserExternalId()
    {
        return $this->req['contact']['email'];
    }

    function fetchUserInfo()
    {

        $ret = array();
        foreach (array(
        'name_f' => 'first_name',
        'name_l' => 'last_name',
        'email' => 'email',
        'street' => 'address',
        'city' => 'city',
        'status' => 'state',
        'country' => 'country',
        'zip' => 'zip',
        'phone' => 'phone'
        ) as $k => $v)
        {
            $ret[$k] = $this->req['contact'][$v]? : $this->req['contact']['contact_profile'][$v];
        }
        return $ret;
    }

    public
        function autoCreateGetProducts()
    {
        $products = array();
        foreach ($this->req['products'] as $p)
        {
            $pl = Am_Di::getInstance()->billingPlanTable->findFirstByData('clickfunnels_id', $p['id']);
            if (!$pl)
                continue;
            $p = $pl->getProduct();
            if ($p)
                $products[] = $p;
        }
        return $products;
    }

    public
        function findInvoiceId()
    {
        return $this->req['charge_id'];
    }

    public
        function getUniqId()
    {
        return $this->req['charge_id'];
    }

    public
        function validateSource()
    {
        return is_array($this->req) && ($this->req['event'] == 'created');
    }

    public
        function getAmount()
    {
        $amt = $this->req['original_amount_cents'] / 100;

        return $amt;
    }

    public
        function validateStatus()
    {
        return ($this->req['status'] == 'paid');
    }

    public
        function validateTerms()
    {
        return doubleval($this->getAmount()) == doubleval($this->invoice->isFirstPayment() ? $this->invoice->first_period : $this->invoice->second_period);
    }

}
