<?php

class Am_Newsletter_Plugin_Mailjet extends Am_Newsletter_Plugin
{
    const API_URL = 'https://api.mailjet.com/v3/REST/';

    protected $_isDebug = false;

    function _initSetupForm(Am_Form_Setup $form)
    {
        $form->addText('apikey_public', array('class' => 'el-wide'))
            ->setLabel('API Public Key')
            ->addRule('required');

        $form->addPassword('apikey_private', array('class' => 'el-wide'))
            ->setLabel('API Private Key')
            ->addRule('required');
    }

    function isConfigured()
    {
        return $this->getConfig('apikey_public') && $this->getConfig('apikey_private');
    }

    function getLists()
    {
        $resp = $this->doRequest('contactslist');
        $ret = array();
        foreach ($resp['Data'] as $l) {
            $ret[$l['ID']] = array('title' => $l['Name']);
        }
        return $ret;
    }

    function changeSubscription(User $user, array $addLists, array $deleteLists)
    {
        foreach ($addLists as $ID) {
            $this->doRequest("contactslist/{$ID}/managecontact", array(
                'Email' => $user->email,
                'Name' => $user->getName(),
                'Action' => 'addforce'
            ));
        }
        foreach ($deleteLists as $ID) {
            $this->doRequest("contactslist/{$ID}/managecontact", array(
                'Email' => $user->email,
                'Name' => $user->getName(),
                'Action' => 'remove'
            ));
        }
        return true;
    }

    function doRequest($method, $params = array())
    {
        $req = new Am_HttpRequest();
        $req->setAuth($this->getConfig('apikey_public'), $this->getConfig('apikey_private'));
        $req->setMethod($params ? 'POST' : 'GET');
        $req->setUrl(self::API_URL . $method);
        if ($params)
        {
            $req->setHeader('Content-Type: application/json');
            $req->setBody(json_encode($params));
        }
        $resp = $req->send();
        $this->log($req, $resp, $method);
        if (!$body = $resp->getBody())
            return array();

        return json_decode($body, true);
    }

    function log($req, $resp, $title)
    {
        if (!$this->_isDebug) return;

        $l = $this->getDi()->invoiceLogRecord;
        $l->paysys_id = $this->getId();
        $l->title = $title;
        $l->add($req);
        $l->add($resp);
    }
}