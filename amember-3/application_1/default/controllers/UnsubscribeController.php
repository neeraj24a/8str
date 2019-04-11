<?php

class UnsubscribeController extends Am_Mvc_Controller
{
    function indexAction()
    {
        if (!$e = $this->getParam('e'))
            throw new Am_Exception_InputError("Empty e-mail parameter passed - wrong url");

        $s = $this->getFiltered('s');
        if (!Am_Mail::validateUnsubscribeLink($e, $s, Am_Mail::LINK_USER))
            throw new Am_Exception_InputError(___('Wrongly signed URL, please contact site admin'));

        $this->view->user = $this->getDi()->userTable->findFirstByEmail($e);
        if (!$this->view->user)
            throw new Am_Exception_InputError(___("Wrong parameters, error #1253"));

        if ($this->_request->get('yes')) {
            $this->view->user->unsubscribed = 1;
            $this->view->user->update();
            $this->getDi()->hook->call(Am_Event::USER_UNSUBSCRIBED_CHANGED,
                array('user'=>$this->view->user, 'unsubscribed' => 1));
            return $this->_redirect('member?' .
                http_build_query(array('_msg'=>___('Status of your subscription has been changed.')), '', '&'));
        } elseif ($this->_request->get('no')) {
            return $this->_redirect('member');
        }

        $this->view->e = $e;
        $this->view->s = $s;

        if (!$this->getDi()->blocks->getBlock('member-main-unsubscribe')) {
            $this->getDi()->blocks->add('unsubscribe', new Am_Widget_Unsubscribe());
        }
        $this->view->display('unsubscribe.phtml');
    }
}