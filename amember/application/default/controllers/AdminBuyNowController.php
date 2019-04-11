<?php

class AdminBuyNowController extends Am_Mvc_Controller_Grid
{
    public function checkAdminPermissions(Admin $admin)
    {
        return $admin->isSuper();
    }

    public function createGrid()
    {
        $ds = new Am_Query($this->getDi()->buttonTable);
        $grid = new Am_Grid_Editable('_button', ___('BuyNow Buttons'), $ds, $this->_request, $this->view);
        $grid->setRecordTitle(___('BuyNow Button'));
        $grid->setEventId('gridButton');

        $grid->addField(new Am_Grid_Field('title', ___('Title'), true));
        $grid->addField(new Am_Grid_Field('billing_plan_id', ___('Product'), true))
            ->setFormatFunction(array($this, 'renderProductId'));
        $grid->addField(new Am_Grid_Field('saved_form_id', ___('Form'), true))
            ->setFormatFunction(array($this, 'renderFormId'));
        $grid->addField(new Am_Grid_Field('paysys_id', ___('Payment System'), true));
        $grid->addField(new Am_Grid_Field_Expandable('hash', ___('Code'), true))
             ->setAjax($this->getDi()->url('admin-buy-now/code?hash={hash}', null,false));
        $grid->addField('_link', ___('Link'), false)
            ->setRenderFunction(array($this, 'renderLink'));
        $grid->setForm(array($this, 'createForm'));
        $grid->setFormValueCallback('paysys_id',
            array('RECORD', 'unserializeList'),
            array('RECORD', 'serializeList'));
        $grid->addCallback(Am_Grid_Editable::CB_VALUES_TO_FORM, function(& $v, $r) {
            if (empty($v['hash'])) {
                $v['hash'] = $this->getDi()->security->randomString(12);
            }
        });

        return $grid;
    }

    public function codeAction()
    {
        $hash = $this->_request->getFiltered('hash');
        $u = $this->getDi()->surl(array('buy/%s', $hash));
        $url = Am_Html::escape($u);
        $urlj = Am_Html::escape(json_encode($u));

        $link = Am_Html::escape("<a href=\"$url\">Order Now</a>");
        $btn = Am_Html::escape("<button onclick='window.location=$urlj;'>Order Now</button>");

        echo <<<CUT
        <strong>Use a link to start purchase</strong>
        <p><code>$link</code></p>
        <br>
        <strong>Use an HTML button to start purchase</strong>
        <p><code>$btn</code></p>
CUT;
    }

    public function renderLink($r, $fn, $g, $fo)
    {
        return $this->renderTd(sprintf('<a href="%s" target="_blank" class="link">%s</a>',
            $this->getDi()->surl("buy/{$r->hash}"),  ___('link')), false);
    }

    public function renderProductId($product = null)
    {
        static $opts;
        if (!$opts) $opts = $this->getDi()->billingPlanTable->getOptions();
        return $opts[$product];
    }

    public function renderFormId($product = null)
    {
        static $opts;
        if (!$product) return '';
        if (!$opts) $opts = $this->getDi()->savedFormTable->getOptions(SavedForm::T_SIGNUP);
        return @$opts[$product];
    }

    public function checkPaysystem($paysys_id, $el)
    {
        $frm = $el;
        while ($frm->getContainer()) $frm = $frm->getContainer();
        $vars = $frm->getValue();
        if (empty($vars['paysys_id'])) return;

        $bp = $this->getDi()->billingPlanTable->load($vars['billing_plan_id']);
        $pr = $bp->getProduct();

        foreach ($vars['paysys_id'] as $paysys_id) {
            $invoice = $this->getDi()->invoiceTable->createRecord();
            $invoice->paysys_id = $paysys_id;
            $invoice->user_id = $this->getDi()->db->selectCell("SELECT user_id FROM ?_user LIMIT 1");
            $invoice->add($pr);
            $invoice->calculate();

            $ps = $this->getDi()->plugins_payment->loadGet($invoice->paysys_id);
            if ($err = $ps->isNotAcceptableForInvoice($invoice)) {
                return "This payment system [{$paysys_id}] is not acceptable for invoice: " . implode(";", $err);
            }
        }
    }

    public function createForm()
    {
        $form = new Am_Form_Admin();

        $form->addText('title', 'class=am-el-wide')
            ->setLabel(___("Title"))
            ->addRule('required');
        $form->addText('comment', 'class=am-el-wide')
            ->setLabel(___("Comment"));

        $form->addText('hash', array('class' => 'am-el-wide'))
            ->setId('button-hash')
            ->setLabel(___("Path\n" .
                'will be used to construct user-friendly url'))
            ->addRule('required')
            ->addRule('callback2', null, array($this, 'checkHash'));

        $button_url = $this->getDi()->rurl('buy/');

        $form->addStatic()
            ->setLabel(___('Permalink'))
            ->setContent(<<<CUT
<div data-button_url="$button_url" id="button-permalink"></div>
CUT
        );

        $form->addScript()
            ->setScript(<<<CUT
jQuery('#button-hash').bind('keyup', function(){
    jQuery('#button-permalink').html(jQuery('#button-permalink').data('button_url') + encodeURIComponent(jQuery(this).val()).replace(/%20/g, '+'))
}).trigger('keyup')
CUT
        );

        $form->addSelect('billing_plan_id')
            ->setLabel(___("Product"))
            ->loadOptions($this->getDi()->billingPlanTable->getOptions())
            ->addRule('required');

        $g = $form->addGroup()
            ->setLabel(___('Coupon'))
            ->setSeparator(' ');
        $g->addText('coupon');
        $g->addAdvCheckbox('use_coupons', null, array('content' => 'allow user to use any coupons'));

        $form->addScript()
            ->setScript(<<<CUT
jQuery(function(){
    jQuery('[name=use_coupons][type=checkbox]').change(function(){
        if (this.checked) {
            jQuery('[name=coupon]').val('').prop('disabled', true);
        } else {
            jQuery('[name=coupon]').prop('disabled', false);
        }
    }).change();
});
CUT
            );

        $form->addSelect('saved_form_id')
            ->setLabel(___("Signup Form\nwill be used if user is not logged-in. " .
                "This form is used only for user registration, so all bricks " .
                "related to purchase (Product, Coupon, Payment System, Invoice Summary) " .
                "will be automatically removed form it."))
            ->loadOptions(array(''=>'[default form]') + $this->getDi()->savedFormTable->getOptions(SavedForm::T_SIGNUP));
        $sel = $form->addMagicSelect('paysys_id')
            ->setLabel(___("Payment System\nif none selected, all enabled will be displayed"))
            ->loadOptions(array_merge(array('free'=>'Free'), $this->getDi()->paysystemList->getOptionsPublic()));
        $sel->addRule('callback2', 'err', array($this, 'checkPaysystem'));

        return $form;
    }

    function checkHash($v, $e)
    {
        $r = $this->grid->getRecord();
        $found = $this->getDi()->db->selectCell('SELECT COUNT(*) FROM ?_button WHERE hash=?
            {AND button_id<>?}', $v, $r->isLoaded() ? $r->pk() : DBSIMPLE_SKIP);
        return $found ? ___('Path should be unique') : null;
    }
}