<?php

class AgreementController extends Am_Mvc_Controller
{

    function indexAction()
    {
        $type = $this->getParam('type');
        $doc = $this->getDi()->agreementTable->getCurrentByType($type);

        if (!$doc)
            throw new Am_Exception_InternalError('Unable to find Agreement document by type');
        

        if (isset($_GET['text']))
        {
            echo $doc->body;
        }
        else
        {
            $this->view->headStyle()->appendStyle(".am-common pre {overflow: auto;}");
            $this->view->title = $doc->title;   
            $this->view->content = $doc->body;
            $this->view->display('layout.phtml');
        }
    }

}
