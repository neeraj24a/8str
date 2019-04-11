<?php

class Am_Plugin_MadmimiFull extends Am_Plugin
{
    protected $api;
    
    const ACTIVE_SUB = 'madmimi-active-sub';
    const ACTIVE_UNSUB = 'madmimi-active-unsub';
    const INACTIVE_SUB = 'madmimi-inactive-sub';
    const INACTIVE_UNSUB = 'madmimi-inactive-unsub';
    const EXPIRE_SUB = 'madmimi-expire-sub';
    const EXPIRE_UNSUB = 'madmimi-expire-unsub';
    
    protected $activecampaign = null;
    
    protected $_configPrefix = 'misc.';
    
    
    function _initSetupForm(Am_Form_Setup $form)
    {
        $form->addText('username', array('size' => 20))
            ->setLabel('Madmimi Username')
            ->addRule('required');        
        $form->addSecretText('api_key', array('size' => 40))
            ->setLabel('Madmimi API Key')
            ->addRule('required');
    }
    
    public function init() 
    {        
        $lists = array();
        if(!$this->isConfigured()) return $lists;
            
        $app_lists = $this->getDi()->cacheFunction->call(array($this, 'getLists'), array(), array(), 3600);
        
        foreach ($app_lists as $k => $v)
        {
            $lists[$k] = $v['title'];
        }

        class_exists('Am_Record_WithData', true);

        // AFTER PURCHASE PRODUCT
        // subscribe to
        $f = new Am_CustomFieldMulti_Select(
            self::ACTIVE_SUB, 
            "SUBSCRIBE to Mad Mimi List\n"
            . "after ACTIVATE this product");
        $f->options = $lists;
        $this->getDi()->productTable->customFields()->add($f);
        
        // unsubscribe from
        $f = new Am_CustomFieldMulti_Select(
            self::ACTIVE_UNSUB, 
            "UNSUBSCRIBE from Mad Mimi List\n"
            . "after ACTIVATE this product");
        $f->options = $lists;
        $this->getDi()->productTable->customFields()->add($f);

        // AFTER NON PAID PRODUCT
        // subscribe to
        $f = new Am_CustomFieldMulti_Select(
            self::INACTIVE_SUB, 
            "SUBSCRIBE to Mad Mimi List\nafter NON PAID this product");
        $f->options = $lists;
        $this->getDi()->productTable->customFields()->add($f);
        
        // unsubscribe from
        $f = new Am_CustomFieldMulti_Select(
            self::INACTIVE_UNSUB, 
            "UNSUBSCRIBE from Mad Mimi List\n"
            . "after NON PAID this product");
        $f->options = $lists;
        $this->getDi()->productTable->customFields()->add($f);

        // AFTER EXPIRE PRODUCT
        // subscribe to
        $f = new Am_CustomFieldMulti_Select(
            self::EXPIRE_SUB, 
            "SUBSCRIBE to Mad Mimi List\n"
            . "after EXPIRE this product");
        $f->options = $lists;
        $this->getDi()->productTable->customFields()->add($f);
        
        // unsubscribe from
        $f = new Am_CustomFieldMulti_Select(
            self::EXPIRE_UNSUB, 
            "UNSUBSCRIBE from Mad Mimi List\n"
            . "after EXPIRE this product");
        $f->options = $lists;
        $this->getDi()->productTable->customFields()->add($f);
    }

    function isConfigured()
    {
        return $this->getConfig('api_key') && $this->getConfig('username');
    }

    function getApi()
    {
        return new Am_MadmimiFull_Api($this);
    }

    function onSubscriptionChanged(Am_Event_SubscriptionChanged $event, User $oldUser = null)
    {
        $pAdded = $event->getAdded();
        $pDeleted = $event->getDeleted();
        
        $user = $event->getUser();
        
        $lAdded = $lDeleted = array();
        
        foreach ($pAdded as $pId)
        {
            $product = $this->getDi()->productTable->load($pId);
            
            if($lists = $product->data()->get(self::ACTIVE_SUB))
            {
                foreach($lists as $list)
                if(!in_array($list, $lAdded))
                    $lAdded[] = $list;
            }
            
            if($lists = $product->data()->get(self::ACTIVE_UNSUB))
            {
                foreach($lists as $list)
                if(!in_array($list, $lDeleted))
                    $lDeleted[] = $list;
            }
            
        }

        foreach ($pDeleted as $pId)
        {
            $product = $this->getDi()->productTable->load($pId);
            
            if(
                // expired after all rebill times:
                ($invoiceId = $this
                    ->getDi()
                    ->db
                    ->selectCell(""
                        . "SELECT invoice_id "
                        . "FROM ?_access "
                        . "WHERE user_id=?d "
                        . "AND product_id=?d "
                        . "ORDER BY expire_date "
                        . "DESC",
                    $user->pk(), 
                    $product->pk()))
                && ($invoice = $this->getDi()->invoiceTable->load($invoiceId))
                && ($invoice->status == Invoice::RECURRING_FINISHED)
            ){
                if($lists = $product->data()->get(self::EXPIRE_SUB))
                {
                    foreach($lists as $list)
                    if(!in_array($list, $lAdded)) {
                        $lAdded[] = $list;
                    }
                }
                
                if($lists = $product->data()->get(self::EXPIRE_UNSUB))
                {
                    foreach($lists as $list)
                    if(!in_array($list, $lDeleted)) {
                        $lDeleted[] = $list;
                    }
                }
                
            } else
            {
                if($lists = $product->data()->get(self::INACTIVE_SUB))
                {
                    foreach($lists as $list)
                    if(!in_array($list, $lAdded)) {
                        $lAdded[] = $list;
                    }
                }
                
                if($lists = $product->data()->get(self::INACTIVE_UNSUB))
                {
                    foreach($lists as $list)
                    if(!in_array($list, $lDeleted)) {
                        $lDeleted[] = $list;
                    }
                }
                
            }
        }
        $this->update($user, $lAdded, $lDeleted);
    }
    
    function escape_for_csv($s) {
            // Watch out! We may have quotes! So quote them.
            $s = str_replace('"', '""', $s);
            if(preg_match('/,/', $s) || preg_match('/"/', $s) || preg_match("/\n/", $s)) {
                    // Quote the whole thing b/c we have a newline, comma or quote.
                    return '"'.$s.'"';
            } else {
                    // False alarm. We're good.
                    return $s;
            }
    }
    
    function build_csv(User $user) {
        $arr = array(
            'email' => 'email',
            'name_f' => 'firstName',
            'name_l' => 'lastName'
        );
            $csv = "";
            foreach ($arr as $madmimi_field_name) {
                    $value = $this->escape_for_csv($madmimi_field_name);
                    $csv .= $value . ",";
            }
            $csv = substr($csv, 0, -1);
            $csv .= "\n";
            foreach (array_keys($arr) as $amember_field_name) {
                    $value = $this->escape_for_csv($user->get($amember_field_name));
                    $csv .= $value . ",";
            }
            $csv = substr($csv, 0, -1);
            $csv .= "\n";
            return $csv;
    }

    function update(User $user, array $addLists, array $deleteLists)
    {
        Am_Di::getInstance()->errorLogTable->log('MADMIMIFULL - '.var_export($addLists, true), var_export($deleteLists, true));
        $api = $this->getApi();
        $users = new SimpleXMLElement($res = $api->sendRequest('/audience_members/search.xml',array('query'=>rawurlencode($user->email))));
        if(!@count($users))
        {
            $api->sendRequest('/audience_members',array('csv_file'=>$this->build_csv($user)),  Am_HttpRequest::METHOD_POST);
        }
        foreach ($addLists as $list_id)
        {
            $list_id=rawurlencode($list_id);
            $api->sendRequest("/audience_lists/$list_id/add",array('email'=>$user->email),  Am_HttpRequest::METHOD_POST);
        }
        foreach ($deleteLists as $list_id)
        {
            $list_id=rawurlencode($list_id);
            $api->sendRequest("/audience_lists/$list_id/remove",array('email'=>$user->email),  Am_HttpRequest::METHOD_POST);
        }
    }

    public function getLists()
    {
        $api = $this->getApi();
        $xml = new SimpleXMLElement($api->sendRequest('/audience_lists/lists.xml'));
        $lists = array();
        foreach (@$xml as $l)
            $lists[(string)$l['name']] = array('title'=>(string)$l['name']);
        return $lists;
    }

}

class Am_MadmimiFull_Api extends Am_HttpRequest
{
    /** @var Am_Plugin_Madmimi */
    protected $plugin;
    
    public function __construct($plugin)
    {
        $this->plugin = $plugin;
        parent::__construct();
    }
    public function sendRequest($path, $params = array(), $method = self::METHOD_GET)
    {
        $this->setMethod($method);        
        $this->setHeader('Expect','');
        $params['username'] = $this->plugin->getConfig('username');
        $params['api_key'] = $this->plugin->getConfig('api_key');
        if($method == self::METHOD_GET)
            $this->setUrl($url = 'http://api.madmimi.com'.$path. '?' . http_build_query($params, '', '&'));
        else
        {
            $this->setUrl($url = 'http://api.madmimi.com'.$path);
            foreach($params as $name => $value)
                $this->addPostParameter($name, $value);
        }
        $ret = parent::send();
        if ($ret->getStatus() != '200')
        {
            throw new Am_Exception_InternalError("Madmimi API Error, configured API Key is wrong");
        }
        return $ret->getBody();
    }
}