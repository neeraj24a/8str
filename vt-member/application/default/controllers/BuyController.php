<?php

/**
 * BuyNow button functionality implementation
 *
 */
class BuyController extends Am_Mvc_Controller
{
    function indexAction()
    {
        if (!$h = $this->_request->getFiltered('h'))
            throw new Am_Exception_InputError("[h] parameter is required");

        if (!$btn = $this->getDi()->buttonTable->findFirstByHash($h))
            throw new Am_Exception_InputError("BuyNow button [$h] not found");

        if ($this->getDi()->auth->getUserId()) // user is logged-in
        {
            $bp = $this->getDi()->billingPlanTable->load($btn->billing_plan_id);
            $pr = $bp->getProduct();

            /* @var $invoice Invoice */
            $invoice = $this->getDi()->invoiceTable->createRecord();
            $invoice->paysys_id = $btn->paysys_id;
            $invoice->user_id = $this->getDi()->auth->getUserId();
            $invoice->add($pr);

            if ($btn->coupon) {
                $invoice->setCouponCode($btn->coupon);
                $invoice->validateCoupon();
            }

            $invoice->calculate();

            if ($errors = $invoice->validate()) {
                throw new Am_Exception_InputError(current($errors));
            }

            $invoice->save();

            $payProcess = new Am_Paysystem_PayProcessMediator($this, $invoice);
            $result = $payProcess->process();
            if ($result->isFailure())
                throw new Am_Exception_InputError($result->getLastError());
        } else {
            if ($btn->saved_form_id) {
                $sf = $this->getDi()->savedFormTable->load($btn->saved_form_id);
            } else {
                $sf = $this->getDi()->savedFormTable->getDefault(SavedForm::D_SIGNUP);
            }

            $redirectUrl = $this->getDi()->surl(array('buy/%s',$h), false);
            $this->getDi()->store->set("am-order-data-$h", json_encode(array(
                'hide-bricks' => array('product', 'paysystem', 'coupon', 'invoice-summary'),
                'redirect' => $redirectUrl), true), '+3 hours');

            $url = $this->getDi()->surl("signup/{$sf->code}", array('order-data' => $h), false);
            $this->_redirect($url);
        }
    }
}