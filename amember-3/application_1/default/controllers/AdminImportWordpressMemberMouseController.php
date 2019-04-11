<?php
//needed tables:
//wp_users
//wp_usermeta
//mm_products
//mm_orders
//mm_order_items
//mm_transaction_log
//mm_paypal_ipn_log
//mm_authorizenet_cim_charges
//mm_authorizenet_cim_customer_links



class_exists('Am_Paysystem_Abstract', true);


abstract class InvoiceCreator_Abstract
{
    /** User  */
    protected $user;
    protected $order = array();
    protected $paysys_id;

    /** @var DbSimple_Mypdo */
    protected $db_wordpress;

    public function getDi()
    {
        return Am_Di::getInstance();
    }

    public function __construct($paysys_id, DbSimple_Interface $db)
    {
        $this->db_wordpress = $db;
        $this->paysys_id = $paysys_id;
    }

    function process(User $user, array $order)
    {
        $this->user = $user;
        $this->order = $order;
        return $this->doWork();
    }

    abstract function doWork();

    static function factory($paysys_id, DbSimple_Interface $db)
    {
        $class = 'InvoiceCreator_' . ucfirst(toCamelCase($paysys_id));
        if (class_exists($class, false))
            return new $class($paysys_id, $db);
        else
            throw new Exception(sprintf('Unknown Payment System [%s]', $paysys_id));
    }

    protected function _translateProduct($pid)
    {
        static $cache = array();
        if (empty($cache))
        {
            $cache = Am_Di::getInstance()->db->selectCol("
                SELECT `value` as ARRAY_KEY, `id`
                FROM ?_data
                WHERE `table`='product' AND `key`='wmm:id'");
        }
        return @$cache[$pid];
    }

    protected function insertAccess($access, $invoice_id=null, $payment_id=null)
    {
        $a = $this->getDi()->accessRecord;
        $a->setDisableHooks();
        $a->user_id = $this->user->user_id;
        $a->begin_date = $access['access_start_date'];
        $a->expire_date = $access['access_end_date'];

        if (!is_null($invoice_id))
        {
            $a->invoice_id = $invoice_id;
        }

        if (!is_null($payment_id))
        {
            $a->invoice_payment_id = $payment_id;
        }
        $a->product_id = $access['product_id'];
        $a->insert();
    }
}

class InvoiceCreator_Paypal extends InvoiceCreator_Abstract
{
    function doWork()
    {
        /*@var $product Product*/
        if(!($product = Am_Di::getInstance()->productTable->load($this->_translateProduct($this->order['item_id']), false)))
            return;
        /*@var $invoice Invoice*/
        $invoice = $this->getDi()->invoiceRecord;
        $invoice->user_id = $this->user->pk();
        $invoice->public_id = $this->order['iid'];

        /*@var $item InvoiceItem*/
        $item = $invoice->createItem($product);
        $item->qty = $this->order['quantity'];
        $item->first_discount = 0;
        $item->first_shipping = 0;
        $item->first_tax = 0;
        $item->second_discount = 0;
        $item->second_shipping = 0;
        $item->second_tax = 0;
        $item->_calculateTotal();

        $invoice->addItem($item);
        $invoice->paysys_id = 'paypal';
        $invoice->tm_added = $this->order['date_added'];
        $invoice->tm_started = $this->order['date_added'];
        $invoice->calculate();
        $invoice->insert();

        $payments = $this->db_wordpress->select("
            SELECT
                txn_id, subscr_id, received, txn_type, ipn_content
            FROM mm_paypal_ipn_log
            WHERE
                order_id = ?d
                AND (payment_status = ? OR txn_type = ?)
        ", $this->order['order_id'], 'Completed', 'subscr_cancel');

        $cnt = 0;
        foreach ($payments as $p)
        {
            $invoice->data()->set('external_id', $p['subscr_id']);

            if($p['txn_type'] == 'subscr_cancel')
            {
                $invoice->tm_cancelled = $p['received'];
                $invoice->status = Invoice::RECURRING_CANCELLED;
                continue;
            }
            $data = unserialize($p['ipn_content']);
            $amount = ($a = $data['mc_gross']) ? $a : $data['payment_gross'];

            /*@var $payment InvoicePayment*/
            $payment = $this->getDi()->invoicePaymentRecord;
            $payment->user_id = $this->user->user_id;
            $payment->invoice_id = $invoice->pk();
            $payment->currency = $data['mc_currency'];
            $payment->amount = moneyRound($amount);
            $payment->paysys_id = 'paypal';
            $payment->dattm = $p['received'];
            $payment->receipt_id = $p['subscr_id'];
            $payment->transaction_id = 'import-paypal-' . $p['txn_id'];
            $payment->insert();

            // access
            $start = sqlDate($p['received']);
            $period = new Am_Period($cnt ? $invoice->second_period : $invoice->first_period);
            $expire = $period->addTo($start);

            $access = array(
                'product_id' => $product->pk(),
                'access_start_date' => $start,
                'access_end_date' => $expire,
            );
            $this->insertAccess($access, $invoice->pk(), $payment->pk());

            $cnt++;
        }
        $invoice->update();
        $this->user->checkSubscriptions();
    }
}

class InvoiceCreator_AuthorizeCim extends InvoiceCreator_Abstract
{
    function doWork()
    {
        /*@var $product Product*/
        if(!($product = Am_Di::getInstance()->productTable->load($this->_translateProduct($this->order['item_id']), false)))
            return;
        /*@var $invoice Invoice*/
        $invoice = $this->getDi()->invoiceRecord;
        $invoice->user_id = $this->user->pk();
        $invoice->public_id = $this->order['iid'];

        /*@var $item InvoiceItem*/
        $item = $invoice->createItem($product);
        $item->qty = $this->order['quantity'];
        $item->first_discount = 0;
        $item->first_shipping = 0;
        $item->first_tax = 0;
        $item->second_discount = 0;
        $item->second_shipping = 0;
        $item->second_tax = 0;
        $item->_calculateTotal();

        $invoice->addItem($item);
        $invoice->paysys_id = 'authorize-cim';
        $invoice->tm_added = $this->order['date_added'];
        $invoice->tm_started = $this->order['date_added'];
        $invoice->calculate();
        $invoice->insert();

        $payments = $this->db_wordpress->select("
            SELECT
                id, charge_id, amount, transaction_date
            FROM mm_authorizenet_cim_charges
            WHERE order_id = ?d
        ", $this->order['order_id']);

        $cnt = 0;
        foreach ($payments as $p)
        {
            /*@var $payment InvoicePayment*/
            $payment = $this->getDi()->invoicePaymentRecord;
            $payment->user_id = $this->user->user_id;
            $payment->invoice_id = $invoice->pk();
            $payment->currency = $invoice->currency;
            $payment->amount = moneyRound($p['amount']);
            $payment->paysys_id = 'authorize-cim';
            $payment->dattm = $p['transaction_date'];
            $payment->receipt_id = $p['charge_id'];
            $payment->transaction_id = 'import-authorizecim-' . $p['charge_id'];
            $payment->insert();

            $r = $this->db_wordpress->selectRow("
                SELECT tl2.transaction_date, tl2.amount
                FROM mm_transaction_log tl1
                LEFT JOIN mm_transaction_log tl2 ON tl1.refund_id = tl2.id
                WHERE
                    tl1.payment_service_id = ?d
                    AND tl1.payment_service_detail_id = ?d
            ", 3, $p['id']); // 3 - auth-cim
            if(!empty($r['transaction_date']))
            {
                /*@var $refund InvoiceRefund*/
                $refund = $this->getDi()->invoiceRefundRecord;
                $refund->invoice_id = $invoice->pk();
                $refund->user_id = $this->user->pk();
                $refund->paysys_id = $invoice->paysys_id;
                $refund->receipt_id = $refund->transaction_id = "refunded-" . $p['charge_id'];
                $refund->dattm = $r['transaction_date'];
                $refund->currency = $invoice->currency;
                $refund->amount = moneyRound($r['amount']);
                $refund->insert();

                $invoice->updateQuick(array('tm_cancelled' => $r['transaction_date'], 'status' => Invoice::RECURRING_CANCELLED));
            } else
            {
                $start = sqlDate($p['transaction_date']);
                $period = new Am_Period($cnt ? $invoice->second_period : $invoice->first_period);
                $expire = $period->addTo($start);

                $access = array(
                    'product_id' => $product->pk(),
                    'access_start_date' => $start,
                    'access_end_date' => $expire,
                );
                $this->insertAccess($access, $invoice->pk(), $payment->pk());
            }
            $cnt++;
        }
        $invoice->update();
        $this->user->checkSubscriptions();
    }
}


abstract class Am_Import_Abstract extends Am_BatchProcessor
{
    /** @var DbSimple_Mypdo */
    protected $db_wordpress;
    protected $options = array();

    /** @var Am_Session_Ns */
    protected $session;

    public function __construct(DbSimple_Interface $db_wordpress, array $options = array())
    {
        $this->db_wordpress = $db_wordpress;
        $this->options = $options;
        $this->session = $this->getDi()->session->ns(get_class($this));
        parent::__construct(array($this, 'doWork'));
        $this->init();
    }

    public function init()
    {
    }

    public function run(&$context)
    {
        $ret = parent::run($context);
        if ($ret)
            $this->session->unsetAll();
        return $ret;
    }

    /** @return Am_Di */
    public function getDi()
    {
        return Am_Di::getInstance();
    }

    abstract public function doWork(& $context);
}

class Am_Import_Product3 extends Am_Import_Abstract
{
    public function doWork(&$context)
    {
        $importedProducts = $this->getDi()->db->selectCol("SELECT `value` FROM ?_data WHERE `table`='product' AND `key`='wmm:id'");
        $q = $this->db_wordpress->queryResultOnly("SELECT * FROM mm_products");
        while ($r = $this->db_wordpress->fetchRow($q))
        {
            if (in_array($r['id'], $importedProducts))
                continue;
            
            $context++;

            $p = $this->getDi()->productRecord;
            $p->title = $r['name'];
            $p->description = $r['description'];
            $p->currency = $r['currency'];
            $p->is_disabled = $r['status'] ? 1 : 0;
            $p->data()->set('wmm:id', $r['id']);
            $p->insert();

            /*@var $bp BillingPlan*/
            $bp = $p->createBillingPlan();
            $bp->title = 'default';
            if($r['has_trial'])
            {
                $bp->first_price = moneyRound($r['trial_amount']);
                $bp->first_period = $this->parsePeriod($r['trial_duration'], $r['trial_frequency']);
            } else
            {
                $bp->first_price = moneyRound($r['price']);
                $bp->first_period = ($r['rebill_period'] && $r['rebill_frequency'])
                    ? $this->parsePeriod($r['rebill_period'], $r['rebill_frequency'])
                    : Am_Period::MAX_SQL_DATE;
            }

            if($r['rebill_period'] && $r['rebill_frequency'])
            {
                $bp->rebill_times = ($r['do_limit_payments']) ? $r['number_of_payments'] : IProduct::RECURRING_REBILLS;
                $bp->second_price = moneyRound($r['price']);
                $bp->second_period = $this->parsePeriod($r['rebill_period'], $r['rebill_frequency']);
            }

            $bp->insert();
        }
        return true;
    }

    protected function parsePeriod($count, $unit)
    {
        $c = $count;
        switch ($unit)
        {
            case 'days':
                $u = 'd';
                break;
            case 'weeks':
                $c *= 7;
                $u = 'd';
                break;
            case 'months':
                $u = 'm';
                break;
            case 'years':
                $u = 'y';
                break;
            default :
                throw new Am_Exception_InputError("Unknown period unit [{$unit}]");
        }
        return $c . $u;
    }

}

class Am_Import_User3 extends Am_Import_Abstract
{
    function doWork(& $context)
    {
        $maxImported = (int) $this->getDi()->db->selectCell("
            SELECT `value` FROM ?_data WHERE `table`='user' AND `key`='wmm:id' ORDER BY `id` DESC LIMIT 1
        ");
        $count = @$this->options['count'];
        if ($count)
            $count -= $context;
        if ($count < 0)
            return true;
        $q = $this->db_wordpress->queryResultOnly("
            SELECT
                u.*,
                um1.meta_value as first_name,
                um2.meta_value as last_name,
                accl.authnet_customer_id,
                accl.authnet_payment_id
            FROM ?_users u
            LEFT JOIN ?_usermeta um1 on u.ID = um1.user_id and um1.meta_key = 'first_name'
            LEFT JOIN ?_usermeta um2 on u.ID = um2.user_id and um2.meta_key = 'last_name'
            LEFT JOIN mm_authorizenet_cim_customer_links accl on u.ID = accl.membermouse_customer_id
            WHERE u.ID > ?d
            ORDER BY u.ID
            {LIMIT ?d}
        ", $maxImported, $count ? $count : DBSIMPLE_SKIP);

        while ($r = $this->db_wordpress->fetchRow($q))
        {
            if (!$this->checkLimits())
                return;
            $u = $this->getDi()->userRecord;
            $u->email = $r['user_email'];
            $u->added = $r['user_registered'];
            $u->login = $r['user_login'];
            $u->name_f = (string)$r['first_name'];
            $u->name_l = (string)$r['last_name'];
            $u->is_approved = 1;

            $u->data()->set('wmm:id', $r['ID']);
            $u->data()->set('signup_email_sent', 1); // do not send signup email second time
            if($cid = $r['authnet_customer_id'])
                $u->data()->set('authorize_cim_user_profile_id', $cid);
            if($pid = $r['authnet_payment_id'])
                $u->data()->set('authorize_cim_payment_profile_id', $pid);
            

            $u->pass = $r['user_pass'];
            try
            {
                $u->insert();
                if($cid || $pid)
                {
                    $storedCc = $this->getDi()->CcRecordRecord;
                    $storedCc->user_id = $u->pk();
                    $storedCc->cc_expire    =   '1237';
                    $storedCc->cc_number = '0000000000000000';
                    $storedCc->cc = $storedCc->maskCc($storedCc->cc_number);
                    $storedCc->insert();
                }
                $this->insertPayments($r['ID'], $u);
                $context++;
            }
            catch (Am_Exception_Db_NotUnique $e)
            {
                echo "Could not import user: " . $e->getMessage() . "<br />\n";
            }
        }
        return true;
    }

    function insertPayments($id, User $u)
    {
        $orders = $this->db_wordpress->select("
            SELECT
                o.id as order_id, o.order_number as iid, o.payment_id, o.date_added, oi.item_id, oi.quantity
            FROM mm_orders o
            LEFT JOIN mm_order_items oi ON oi.order_id=o.id
            WHERE
                oi.item_id > 0
                AND o.payment_id IN (?a)
                AND o.user_id = ?d
        ", array(1,3), $id);
        foreach ($orders as $order)
        {
            switch ($order['payment_id'])
            {
                case 1:
                    InvoiceCreator_Abstract::factory('paypal', $this->db_wordpress)->process($u, $order);
                    break;
                case 3:
                    InvoiceCreator_Abstract::factory('authorize-cim', $this->db_wordpress)->process($u, $order);
                    break;
                default:
                    break;
            }
        }
    }

}

class AdminImportWordpressMemberMouseController extends Am_Mvc_Controller
{

    /** @var Am_Form_Admin */
    protected $dbForm;

    /** @var DbSimple_Mypdo */
    protected $db_wordpress;

    public function checkAdminPermissions(Admin $admin)
    {
        return $admin->hasPermission(Am_Auth_Admin::PERM_SUPER_USER);
    }

    function indexAction()
    {
        Am_Mail::setDefaultTransport(new Am_Mail_Transport_Null());

        if ($this->_request->get('start'))
        {
            $this->getSession()->wordpress_db = null;
            $this->getSession()->wordpress_import = null;
        }
        elseif ($this->_request->get('import_settings'))
        {
            $this->getSession()->wordpress_import = null;
        }

        if (!$this->getSession()->wordpress_db)
            return $this->askDbSettings();

        $this->db_wordpress = Am_Db::connect($this->getSession()->wordpress_db);
        if (!$this->getSession()->wordpress_import)
            return $this->askImportSettings();

        // disable ALL hooks
        $this->getDi()->hook = new Am_Hook($this->getDi());


        $done = $this->_request->getInt('done', 0);

        $importSettings = $this->getSession()->wordpress_import;
        $import = $this->_request->getFiltered('i', $importSettings['import']);
        $class = "Am_Import_" . ucfirst($import) . "3";
        $importer = new $class($this->db_wordpress, (array) @$importSettings[$import]);

        if ($importer->run($done) === true)
        {
            $this->view->title = ucfirst($import) . " Import Finished";
            $this->view->content = "$done records imported from Wordpress Member Mouse Plugin";
            $this->view->content .= "<br /><br/><a href='" . Am_Di::getInstance()->url('/admin-import-wordpress-member-mouse') . "'>Continue to import other information</a>";
            $this->view->content .= "<br /><br />Do not forget to <a href='" . Am_Di::getInstance()->url('admin-rebuild') . "'>>Rebuild Db</a> after all import operations are done.";
            $this->view->display('admin/layout.phtml');
            $this->getSession()->wordpress_import = null;
        }
        else
        {
            $this->redirectHtml($this->getDi()->url("admin-import-wordpress-member-mouse", array('done'=>$done,'i'=>$import),false), "$done records imported");
        }
    }

    function askImportSettings()
    {
        $this->form = $this->createImportForm($defaults);
        $this->form->addDataSource($this->_request);
        if (!$this->form->isSubmitted())
            $this->form->addDataSource(new HTML_QuickForm2_DataSource_Array($defaults));
        if ($this->form->isSubmitted() && $this->form->validate())
        {
            $val = $this->form->getValue();
            if (@$val['import'])
            {
                $this->getSession()->wordpress_import = array(
                    'import' => $val['import'],
                    'user' => @$val['user'],
                    'pr_link' => @$val['pr_link'],
                );
                $this->_redirect('admin-import-wordpress-member-mouse');
                return;
            }
        }
        $this->view->title = "Import Wordpress Member Mouse Plugin Information";
        $this->view->content = (string) $this->form;
        $this->view->display('admin/layout.phtml');
    }

    function createImportForm(& $defaults)
    {
        $form = new Am_Form_Admin;
        /** count imported */
        $imported_products =
            $this->getDi()->db->selectCell("SELECT COUNT(id) FROM ?_data WHERE `table`='product' AND `key`='wmm:id'");
        $total = $this->db_wordpress->selectCell("SELECT COUNT(*) FROM mm_products");
        if ($imported_products >= $total)
        {
            $cb = $form->addStatic()->setContent("Imported ($imported_products of $total)");
        }
        else
        {
            $cb = $form->addRadio('import', array('value' => 'product'));
        }
        $cb->setLabel('Import Products');

        if ($imported_products)
        {
            $imported_users =
                $this->getDi()->db->selectCell("SELECT COUNT(id) FROM ?_data WHERE `table`='user' AND `key`='wmm:id'");
            $total = $this->db_wordpress->selectCell("SELECT COUNT(*) FROM ?_users");
            if ($imported_users >= $total)
            {
                $cb = $form->addStatic()->setContent("Imported ($imported_users)");
            }
            else
            {
                $cb = $form->addGroup();
                if ($imported_users)
                    $cb->addStatic()->setContent("partially imported ($imported_users of $total total)<br /><br />");
                $cb->addRadio('import', array('value' => 'user'));
                $cb->addStatic()->setContent('<br /><br /># of users (keep empty to import all) ');
                $cb->addInteger('user[count]');
            }
            $cb->setLabel('Import User and Payment Records');
        }
        $form->addSaveButton('Run');

        $defaults = array(
            //'user' => array('start' => 5),
        );
        return $form;
    }

    function askDbSettings()
    {
        $this->form = $this->createMysqlForm();
        if ($this->form->isSubmitted() && $this->form->validate())
        {

            $this->getSession()->wordpress_db = $this->form->getValue();
            $this->_redirect('admin-import-wordpress-member-mouse');
        }
        else
        {
            $this->view->title = "Import Wordpress Membership Information";
            $this->view->content = (string) $this->form;
            $this->view->display('admin/layout.phtml');
        }
    }

    /** @return Am_Form_Admin */
    function createMysqlForm()
    {
        $form = new Am_Form_Admin;

        $el = $form->addText('host')->setLabel('Wordpress  MySQL Hostname');
        $el->addRule('required', 'This field is required');

        $form->addText('user')->setLabel('Wordpress  MySQL Username')
            ->addRule('required', 'This field is required');
        $form->addPassword('pass')->setLabel('Wordpress MySQL Password');
        $form->addText('db')->setLabel('Wordpress MySQL Database Name')
            ->addRule('required', 'This field is required');
        $form->addText('prefix')->setLabel('Wordpress Tables Prefix');

        $dbConfig = $this->getDi()->getParameter('db');
        $form->addDataSource(new HTML_QuickForm2_DataSource_Array(array(
            'host' => $dbConfig['mysql']['host'],
            'user' => $dbConfig['mysql']['user'],
            'prefix' => 'wp_',
        )));

        $el->addRule('callback2', '-', array($this, 'validateDbConnect'));

        $form->addSubmit(null, array('value' => 'Continue...'));
        return $form;
    }

    function validateDbConnect()
    {
        $config = $this->form->getValue();
        try
        {
            $db = Am_Db::connect($config);
            if (!$db)
                return "Check database settings - could not connect to database";
            $db->query("SELECT * FROM ?_users LIMIT 1");
        }
        catch (Exception $e)
        {
            return "Check database settings - " . $e->getMessage();
        }
    }

}
