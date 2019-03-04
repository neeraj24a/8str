<?php

class Am_Newsletter_Plugin_Sendy extends Am_Newsletter_Plugin
{
    public function _initSetupForm(Am_Form_Setup $form)
    {
        $form->addText('url', array('class' => 'el-wide'))
            ->setLabel("Sendy URL\n" .
                'url of your setup of Sendy')
            ->addRule('required');
    }

    public function changeSubscription(User $user, array $addLists, array $deleteLists)
    {
        $email = $user->get($this->getConfig('email_field', 'email'));
        if (empty($email)) return true;
        foreach ($addLists as $listId) {
            $ret = $this->doRequest('/subscribe', array(
                'name' => $user->getName(),
                'email' => $email,
                'list' => $listId,
                'boolean' => 'true'
            ));
            if ($ret != '1') return false;
        }
        foreach ($deleteLists as $listId) {
            $ret = $this->doRequest('/unsubscribe', array(
                'email' => $email,
                'list' => $listId,
                'boolean' => 'true'
            ));
            if ($ret != '1') return false;
        }
        return true;
    }
    function doRequest($path, array $vars)
    {
        $req = new Am_HttpRequest($this->getConfig('url') . $path, Am_HttpRequest::METHOD_POST);
        $req->addPostParameter($vars);
        $res = $req->send();
        return $res->getBody();
    }
}