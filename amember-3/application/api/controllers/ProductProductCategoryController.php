<?php

class Api_ProductProductCategoryController extends Am_Mvc_Controller_Api
{
    function indexAction()
    {
        $this->_response->ajaxResponse($this->getDi()->productCategoryTable->getCategoryProducts());
    }
}

