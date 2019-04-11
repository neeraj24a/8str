<?php

/**
 * This Plugin force user to accept your Agreement if user did not do it before.
 * Also you can reset Accept status for all users in database if you changed your agreement
 * and you want that all users accept new one.
 */

class Am_Plugin_ForceIAgree extends Am_Plugin
{
    const PLUGIN_STATUS = self::STATUS_PRODUCTION;
    const PLUGIN_COMM = self::COMM_FREE;
    const PLUGIN_REVISION = '5.5.0';

    protected $_configPrefix = 'misc.';

    
    
    static function getDbXml()
    {
        return <<<CUT
<schema version="4.0.0">
    <table name="user">
        <field name="require_consent" type="varchar" len='255' notnull="0" />
    </table> 
</schema>
CUT;
        
    }
    function init()
    {
        $this->getDi()->front->registerPlugin(new Am_Mvc_Controller_Plugin_ForceIAgree($this));
    }

    function _initSetupForm(Am_Form_Setup $form)
    {
        $form->addProlog(sprintf('<div class="info">
            <a href="%s" class="link">%s</a></div>',
                $this->getDi()->url("admin-force-i-agree"), ___('Request to update consent for Users')
        ));

        $form->setTitle(___('Update User Consent'));

        $form->addText('redirect_url', array('class' => 'el-wide', 'placeholder' => ROOT_URL))
            ->setLabel(___("Redirect URL\n" .
                'aMember will redirect user to this url after user click Accept ' .
                'button. User will be redirected to aMember root url in case of ' .
                'this option is empty'));

        $form->addText('page_title', array('class' => 'el-wide'))
            ->setLabel(___('Page Title'))
            ->setValue('New Terms & Conditions');

        $form->addHtmleditor('msg', null, array('showInPopup' => true))
            ->setLabel(___("Message\n" .
                'This message will be shown on accept page. ' .
                'You can clarify situation for user here ' 
               ))
            ->setValue('<div class="am-info">' . ___('We updated our Terms & Conditions. Please accept new one.') . '</div>' . '%button%');

        $form->addText('button_title')
            ->setLabel(___('Button Title'))
            ->setValue('I Accept');
    }

    function onAuthGetOkRedirect(Am_Event $e)
    {
        if ($this->needShow($e->getUser())) {
            $url = $e->getReturn();
            $this->getDi()->session->ns($this->getId())->redirect = $url;
            $e->setReturn($this->getDi()->url("misc/{$this->getId()}"));
            $e->stop();
        }
    }

    function onGridUserInitGrid(Am_Event_Grid $e)
    {
        $e->getGrid()->actionAdd(new Am_Grid_Action_Group_ResetIAgreeStatus);
    }

    function directAction(Am_Mvc_Request $request, Am_Mvc_Response $response, array $invokeArgs)
    {
        $this->getDi()->auth->requireLogin();
        $user = $this->getDi()->auth->getUser();
        $redirect = $this->getDi()->session->ns($this->getId())->redirect ?:
            $this->getConfig('redirect_url', $this->getDi()->surl('', false));
        $documents = [];
        if(!$user->require_consent){
            return $response->redirectLocation($redirect);
        }else{
            $rc = json_decode($user->require_consent, true);
            foreach($rc as $type){
                if((!$this->getDi()->userConsentTable->hasConsent($user, $type)) && ($document = $this->getDi()->agreementTable->getCurrentByType($type))){
                    $documents[] = $document;
                }
            }
        }
        
        if(empty($documents)){
            $user->updateQuick('require_consent', null);
            return $response->redirectLocation($redirect);
        }
        $form = new Am_Form();

        foreach($documents as $agreement){
            $el = $form->addStatic($agreement->type, array('class' => 'no-label'));
            $el->setContent('<div class="agreement">' . $agreement->body . '</div>');
            $form->addAdvCheckbox('i_agree['.$agreement->type.']')->setLabel(___('Accept "%s"', $agreement->title))
                ->addRule('required');
            
            
        }
        $form->setDataSources(array($request));
        $form->addSaveButton(___($this->getConfig('button_title', 'Submit')));
        
        
        

        if ($form->isSubmitted() && $form->validate()) {
            $vars = $form->getValue();
            foreach($vars['i_agree'] as $type=>$accepted){
                $this->getDi()->userConsentTable->recordConsent($user, $type, $request->getClientIp(), ___('Accepted from force-i-agree plugin'));
            }
            $user->updateQuick('require_consent', null);
            $response->redirectLocation($redirect);

        } else {
            $view = $this->getDi()->view;
            $view->layoutNoMenu = true;
            $view->title = ___($this->getConfig('page_title'));

            $tmp = new Am_SimpleTemplate();
            $tmp->assign('button', (string) $form);

            $view->content = $tmp->render($this->getConfig('msg', '%button%'));
            $view->display('layout.phtml');
        }
    }

    function getProductIds($options)
    {
        return $this->getDi()->productTable->extractProductIds($options);
    }

    function needShow(User $user)
    {
        $needShow = false;
        if($rc = $user->require_consent){
            $rc = json_decode($rc, true);
            foreach((array)$rc as $type)
            {
                if(!$this->getDi()->userConsentTable->hasConsent($user, $type)){
                    $needShow = true;
                    $consent[] = $type;
                }
            }
        }
        
        if(!$needShow && $user->require_consent){
            $user->updateQuick('require_consent', null);
        }
        return $needShow;
    }

    public function getReadme()
    {
        return <<<CUT
This plugin allow to re-request user concent for agreement document. 

CUT;
    }
}

class Am_Grid_Action_Group_ResetIAgreeStatus extends Am_Grid_Action_Group_Abstract
{
    var $title = 'Request User Consent update for all "Terms & Policty" Documents';

    protected $needConfirmation = true;

    public function handleRecord($id, $record)
    {
        $user = $this->grid->getDi()->userTable->load($id);
        
        $types = Am_Di::getInstance()->agreementTable->getTypes();
        
        if(!empty($types))
            $user->updateQuick('require_consent', json_encode($types));
    }
}

class AdminForceIAgreeController extends Am_Mvc_Controller
{
    function checkAdminPermissions(Admin $admin)
    {
        return $admin->isSuper();
    }

    function indexAction()
    {
        $form = new Am_Form_Admin('fia');
        $access = ['Products' => $this->getDi()->productTable->getProductOptions()];
        if($this->getDi()->modules->isEnabled('aff')){
            $access['Affiliate Program']=['aff' => ___('User is Affiliate')];
        }
        $form->addMagicSelect('access', ['class' => 'am-combobox'])
            ->setLabel(___("Reset Accept Status for Active Users of\n" .
                "leave empty to reset for all users"))
            ->loadOptions($access);
        $form->addMagicSelect('agreement')
            ->setLabel(___('Terms Documents that user have to accept'))
            ->loadOptions($this->getDi()->agreementTable->getTypeOptions());
        $form->addSaveButton(___('Reset'));

        if ($form->isSubmitted()) {
            $var = $form->getValue();
            if($var['agreement']){
                $agreement = json_encode($var['agreement']);
                if(in_array('aff', $var['access'])){
                    $conditions[] = ' u.is_affiliate>0 ';
                }
                $product_ids = array_filter($var['access'], 'intval');
                if($product_ids){
                    $conditions[] = ' u.user_id = a.user_id ';
                }
                $where = !empty($conditions)? "WHERE ".implode(' AND ',$conditions) : "";
                
                $q = $this->getDi()->db->queryResultOnly("
                    UPDATE ?_user u{, (SELECT user_id FROM ?_access a where a.product_id IN (?a) AND a.begin_date<=? AND a.expire_date>=?) a}
                    SET require_consent=? $where
                    ",
                    ($product_ids ? $product_ids : DBSIMPLE_SKIP), sqlDate('now'), sqlDate('now'), $agreement
            );
                
            }
            
            $this->_response->redirectLocation($this->getDi()->url('admin-setup/force-i-agree', false));
        }

        $this->view->title = ___('Reset Consent Status for Users');
        $this->view->content = (string) $form;
        $this->view->display('admin/layout.phtml');
    }

}

class Am_Mvc_Controller_Plugin_ForceIAgree extends Zend_Controller_Plugin_Abstract
{
    public function __construct(Am_Plugin_ForceIAgree $plugin)
    {
        $this->plugin = $plugin;
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        if (stripos($this->getRequest()->getControllerName(), 'admin') === 0)
            return; //exception for admin

        if ($request->getModuleName() == 'default' &&
            $request->getControllerName() == 'login' &&
            $request->getActionName() == 'logout')
            return; //exception for logout

        if ($request->getModuleName() == 'default' &&
            $request->getControllerName() == 'upload' &&
            $request->getActionName() == 'get')
            return; //exception for theme logo

        $di = Am_Di::getInstance();
        if ($di->auth->getUserId() &&
            $this->needShow($di->auth->getUser())) {
            $request->setControllerName('direct')
                ->setActionName('index')
                ->setModuleName('default')
                ->setParam('type', 'misc')
                ->setParam('plugin_id', 'force-i-agree');
        }
    }

    protected function needShow(User $user)
    {
        return $this->plugin->needShow($user);
    }
}