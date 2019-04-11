<?php

/**
 * @table paysystems
 * @id authorize-dpm
 * @title Authorize.Net DPM Integration
 * @visible_link http://www.authorize.net/
 * @recurring none
 * @logo_url authorizenet.png
 * @country US
 */
class Am_Paysystem_AuthorizeDpm extends Am_Paysystem_CreditCard
{
    const PLUGIN_STATUS = self::STATUS_BETA;
    const PLUGIN_DATE = '$Date$';
    const PLUGIN_REVISION = '5.6.0';

    const LIVE_URL = "https://secure2.authorize.net/gateway/transact.dll";
    const SANDBOX_URL = 'https://test.authorize.net/gateway/transact.dll';

    protected $_pciDssNotRequired = true;
    protected $defaultTitle = "Authorize.Net DPM Credit Card Billing";
    protected $defaultDescription = "accepts all major credit cards";

    public function getRecurringType()
    {
        return self::REPORTS_NOT_RECURRING;
    }

    function getSupportedCurrencies()
    {
        return array('AUS', 'USD', 'CAD', 'GBP', 'NZD');
    }

    public function _initSetupForm(Am_Form_Setup $form)
    {
        $id = $this->getId();
        $form->addText("login")->setLabel("API Login ID\n" .
            'can be obtained from the same page as Transaction Key (see below)');
        $form->addText('signature_key', array('class' => 'am-el-wide'))
            ->setLabel("Signature Key\n" .
                "API Credentials & Keys from the General Security Settings section")
            ->addRule('required');

        $form->addAdvCheckbox("testing")->setLabel("Test Mode Enabled");
    }

    public function _doBill(Invoice $invoice, $doFirst, CcRecord $cc, Am_Paysystem_Result $result)
    {
        //nop
    }

    protected function createController(Am_Mvc_Request $request, Am_Mvc_Response $response, array $invokeArgs)
    {
        return new Am_Mvc_Controller_AuthorizeDpm($request, $response, $invokeArgs);
    }

    function createTransaction(Am_Mvc_Request $request, Am_Mvc_Response $response, array $invokeArgs)
    {
        return new Am_Paysystem_Transaction_AuthorizeDpm($this, $request, $response, $invokeArgs);
    }

    public function createForm($actionName)
    {
        class_exists('Am_Form_CreditCard', true);
        return new Am_Form_AuthorizeDpm($this);
    }

    public function onInitForm(Am_Form_AuthorizeDpm $form)
    {
        $i = $this->invoice;

        $p = array(
            'x_type' => 'AUTH_CAPTURE',
            'x_amount' => $i->first_total,
            'x_currency_code' => $i->currency,
            'x_fp_sequence' => $i->pk(),
            'x_fp_timestamp' => time(),
            'x_relay_response' => "TRUE",
            'x_relay_url' => $this->getPluginUrl('ipn'),
            'x_login' => $this->getConfig('login'),
            'x_invoice_num' => $i->public_id,
            'x_customer_ip' => $_SERVER['REMOTE_ADDR'],
            'x_test_request' => $this->getConfig('testing') ? 'TRUE' : 'FALSE'
        );
        $p['x_fp_hash'] = hash_hmac("sha512", implode("^", array(
                    $p['x_login'],
                    $p['x_fp_sequence'],
                    $p['x_fp_timestamp'],
                    $p['x_amount'],
                    $p['x_currency_code'],
                )), hex2bin($this->getConfig("signature_key")));
        foreach ($p as $k => $v) {
            $form->addHidden($k, array('value' => $v));
        }
    }

}

class Am_Paysystem_Transaction_AuthorizeDpm extends Am_Paysystem_Transaction_Incoming
{
    const APPROVED = 1;

    public function getUniqId()
    {
        return $this->request->getParam('x_trans_id');
    }

    public function findInvoiceId()
    {
        return $this->request->getParam('x_invoice_num');
    }

    public function validateSource()
    {
        $message = '^' .
                $this->request->getParam('x_trans_id') . '^' .
                $this->request->getParam('x_test_request') . '^' .
                $this->request->getParam('x_response_code') . '^' .
                $this->request->getParam('x_auth_code') . '^' .
                $this->request->getParam('x_cvv2_resp_code') . '^' .
                $this->request->getParam('x_cavv_response') . '^' .
                $this->request->getParam('x_avs_code') . '^' .
                $this->request->getParam('x_method') . '^' .
                $this->request->getParam('x_account_number') . '^' .
                $this->request->getParam('x_amount') . '^' .
                $this->request->getParam('x_company') . '^' .
                $this->request->getParam('x_first_name') . '^' .
                $this->request->getParam('x_last_name') . '^' .
                $this->request->getParam('x_address') . '^' .
                $this->request->getParam('x_city') . '^' .
                $this->request->getParam('x_state') . '^' .
                $this->request->getParam('x_zip') . '^' .
                $this->request->getParam('x_country') . '^' .
                $this->request->getParam('x_phone') . '^' .
                $this->request->getParam('x_fax') . '^' .
                $this->request->getParam('x_email') . '^' .
                $this->request->getParam('x_ship_to_company') . '^' .
                $this->request->getParam('x_ship_to_first_name') . '^' .
                $this->request->getParam('x_ship_to_last_name') . '^' .
                $this->request->getParam('x_ship_to_address') . '^' .
                $this->request->getParam('x_ship_to_city') . '^' .
                $this->request->getParam('x_ship_to_state') . '^' .
                $this->request->getParam('x_ship_to_zip') . '^' .
                $this->request->getParam('x_ship_to_country') . '^' .
                $this->request->getParam('x_invoice_num') . '^';
        return strtoupper($this->request->getParam('x_SHA2_Hash')) == strtoupper(hash_hmac("sha512", $message, hex2bin($this->getPlugin()->getConfig('signature_key'))));
    }

    public function validateStatus()
    {
        return true;
    }

    public function validateTerms()
    {
        $this->assertAmount($this->invoice->first_total, $this->request->getParam('x_amount'));
        return true;
    }

    public function processValidated()
    {
        switch ($this->request->getParam('x_response_code')) {
            case self::APPROVED:
                $this->invoice->addPayment($this);
                $redirect_url = $this->plugin->getRootUrl() .
                    "/thanks?id=" .
                    $this->invoice->getSecureId("THANKS");
                break;
            default:
                $redirect_url = $this->plugin->getRootUrl() .
                    "/cancel?id=" .
                    $this->invoice->getSecureId('CANCEL');
        }

        echo <<<CUT
<html>
    <head>
        <script type="text/javascript">
            window.location="{$redirect_url}";
        </script>
        <noscript>
            <meta http-equiv="refresh" content="1;url={$redirect_url}">
        </noscript>
    </head>
    <body>
    </body>
</html>
CUT;
        exit;
    }

}

class Am_Mvc_Controller_AuthorizeDpm extends Am_Mvc_Controller
{

    /** @var Invoice */
    public $invoice;

    /** @var Am_Paysystem_CreditCard */
    public $plugin;

    /** @var Am_Form_CreditCard */
    public $form;

    public function setPlugin(Am_Paysystem_CreditCard $plugin)
    {
        $this->plugin = $plugin;
    }

    public function setInvoice(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * we only show form, authorize.net process it
     */
    public function ccAction()
    {
        // invoice must be set to this point by the plugin
        if (!$this->invoice)
            throw new Am_Exception_InternalError('Empty invoice - internal error!');
        $this->form = $this->createForm();

        $this->getDi()->hook->call(Bootstrap_Cc::EVENT_CC_FORM, array('form' => $this->form));

        $this->view->form = $this->form;
        $this->view->invoice = $this->invoice;
        $this->view->display_receipt = true;
        $this->view->display('cc/info.phtml');
    }

    public function createForm()
    {
        $form = $this->plugin->createForm($this->_request->getActionName(), $this->invoice);

        $form->setDataSources(array(
            $this->_request,
            new HTML_QuickForm2_DataSource_Array($form->getDefaultValues($this->invoice->getUser()))
        ));

        return $form;
    }

}

class Am_Form_AuthorizeDpm extends Am_Form
{

    protected $plugin = null;

    public function __construct(Am_Paysystem_CreditCard $plugin)
    {
        $this->plugin = $plugin;
        return parent::__construct('cc');
    }

    public function init()
    {
        parent::init();

        $this->setAction($this->plugin->getConfig('testing') ? Am_Paysystem_AuthorizeDpm::SANDBOX_URL : Am_Paysystem_AuthorizeDpm::LIVE_URL);

        $name = $this->addGroup()
            ->setLabel(___("Cardholder Name\n" .
                'cardholder first and last name, exactly as on the card'));
        $name->setSeparator(' ');
        $name->addRule('required', ___('Please enter credit card holder name'));
        $name_f = $name->addText('x_first_name', array('size' => 15));
        $name_f->addRule('required', ___('Please enter credit card holder first name'))->addRule('regex', ___('Please enter credit card holder first name'), '/^[^=:<>{}()"]+$/D');
        $name_l = $name->addText('x_last_name', array('size' => 15));
        $name_l->addRule('required', ___('Please enter credit card holder last name'))->addRule('regex', ___('Please enter credit card holder last name'), '/^[^=:<>{}()"]+$/D');

        $cc = $this->addText('x_card_num', array('autocomplete' => 'off', 'size' => 22, 'maxlength' => 22))
            ->setLabel(___("Credit Card Number\n" .
                'for example: 1111-2222-3333-4444'));
        $cc->addRule('required', ___('Please enter Credit Card Number'))
            ->addRule('regex', ___('Invalid Credit Card Number'), '/^[0-9 -]+$/');


        $expire = $this->addElement(new Am_Form_Element_CreditCardExpire('cc_expire'))
            ->setLabel(___("Card Expire\n" .
                    'Select card expiration date - month and year'))
            ->addRule('required');

        $this->addHidden('x_exp_date');
        $this->addScript()->setScript(<<<CUT
jQuery(function(){
    jQuery('select[name^=cc_expire]').change(function(){
        console.log('here');
        jQuery('input[name=x_exp_date]').val(jQuery('#m-0').val() + '/' + jQuery('#y-0').val().slice(2));
    })
})
CUT
        );

        $code = $this->addPassword('x_card_code', array('autocomplete' => 'off', 'size' => 4, 'maxlength' => 4))
            ->setLabel(___("Credit Card Code\n" .
                'The "Card Code" is a three- or four-digit security code ' .
                'that is printed on the back of credit cards in the card\'s ' .
                'signature panel (or on the front for American Express cards)'));
        $code->addRule('required', ___('Please enter Credit Card Code'))
            ->addRule('regex', ___('Please enter Credit Card Code'), '/^\s*\d{3,4}\s*$/');

        $fieldSet = $this->addFieldset(___('Address Info'))
            ->setLabel(___("Address Info\n" .
                '(must match your credit card statement delivery address)'));

        $street = $fieldSet->addText('x_address')->setLabel(___('Street Address'))
            ->addRule('required', ___('Please enter Street Address'));

        $city = $fieldSet->addText('x_city')->setLabel(___('City'))
            ->addRule('required', ___('Please enter City'));

        $zip = $fieldSet->addText('x_zip')->setLabel(___('ZIP'))
            ->addRule('required', ___('Please enter ZIP code'));

        $country = $fieldSet->addSelect('x_country')->setLabel(___('Country'))
            ->setId('f_cc_country')
            ->loadOptions(Am_Di::getInstance()->countryTable->getOptions(true));
        $country->addRule('required', ___('Please enter Country'));

        $group = $fieldSet->addGroup()->setLabel(___('State'));
        $group->addRule('required', ___('Please enter State'));

        $stateSelect = $group->addSelect('x_state')
            ->setId('f_cc_state')
            ->loadOptions($stateOptions = Am_Di::getInstance()->stateTable->getOptions(@$_REQUEST['x_country'], true));
        $stateText = $group->addText('x_state')->setId('t_cc_state');
        $disableObj = $stateOptions ? $stateText : $stateSelect;
        $disableObj->setAttribute('disabled', 'disabled')->setAttribute('style', 'display: none');

        $buttons = $this->addGroup();
        $buttons->addSubmit('_cc_', array('value' => ___('Subscribe And Pay')));
        $this->plugin->onInitForm($this);
    }

    public function getDefaultValues(User $user)
    {
        return array(
            'x_first_name' => $user->name_f,
            'x_last_name' => $user->name_l,
            'x_address' => $user->street,
            'x_city' => $user->city,
            'x_state' => $user->state,
            'x_country' => $user->country,
            'x_zip' => $user->zip
        );
    }

}