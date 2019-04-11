<?php
/**
 * Class represents records from table invoice_refund
 * {autogenerated}
 * @property int $invoice_refund_id
 * @property int $invoice_id
 * @property int $invoice_payment_id
 * @property int $user_id
 * @property string $paysys_id
 * @property string $receipt_id
 * @property string $transaction_id
 * @property datetime $dattm
 * @property string $currency
 * @property double $amount
 * @property int $refund_type
 * @property double $base_currency_multi
 * @see Am_Table
 * @package Am_Invoice
 */
class InvoiceRefund extends Am_Record_WithData
{
    /** @var User */
    protected $_user;
    /** @var Invoice */
    protected $_invoice;
    /** by customer request - ACCESS does not stopped */
    const REFUND = 0;
    /** chargeback */
    const CHARGEBACK = 1;
    /** quickly after the order - ACCESS will be revoked */
    const VOID = 2;

    public function setFromTransaction(Invoice $invoice, Am_Paysystem_Transaction_Interface $transaction, $refundType)
    {
        $this->dattm = $transaction->getTime()->format('Y-m-d H:i:s');
        $this->invoice_id = $invoice->invoice_id;
        $this->invoice_public_id = $invoice->public_id;
        $this->user_id = $invoice->user_id;
        $this->currency = $invoice->currency;
        $this->amount = $transaction->getAmount();
        $this->paysys_id = $transaction->getPaysysId();
        $this->receipt_id = $transaction->getReceiptId();
        $this->transaction_id = $transaction->getUniqId();
        $this->refund_type = $refundType;
        return $this;
    }

    public function insert($reload = true)
    {
        if ($this->currency == Am_Currency::getDefault()) {
            $this->base_currency_multi = 1.0;
        } else {
            $this->base_currency_multi = $this->getDi()->currencyExchangeTable->getRate($this->currency, sqlDate($this->dattm));
        }

        $ret = parent::insert($reload);
        $this->setDisplayInvoiceId();
        $this->getDi()->hook->call('refundAfterInsert', array(
            'invoice' => $this->getInvoice(),
            'refund'  => $this,
            'user'    => $this->getInvoice()->getUser(),
        ));
        return $ret;
    }

    /**
     * @return Invoice
     */
    public function getInvoice()
    {
        if (empty($this->_invoice))
            $this->_invoice = $this->getDi()->invoiceTable->load($this->invoice_id);
        return $this->_invoice;
    }

    /**
     * @return User
     */
    public function getUser(){
        if (empty($this->_user))
            $this->_user = $this->getDi()->userTable->load($this->user_id);
        return $this->_user;
    }

    /**
     * Set Invoice ID wich will be displayed in pdf invoice
     */
    protected function setDisplayInvoiceId()
    {
        $this->display_invoice_id = $this->getDi()->hook->filter(
            "{$this->getInvoice()->public_id}/R{$this->getInvoice()->getRefundsCount()}",
            Am_Event::SET_DISPLAY_INVOICE_REFUND_ID,
            array('record' => $this));
        $this->updateSelectedFields('display_invoice_id');
    }

    function getDisplayInvoiceId()
    {
        return $this->display_invoice_id ? $this->display_invoice_id : ($this->getInvoice()->public_id . '/' . $this->receipt_id);
    }
}

/**
 * @package Am_Invoice
 */
class InvoiceRefundTable extends Am_Table_WithData
{
    protected $_key = 'invoice_refund_id';
    protected $_table = '?_invoice_refund';
    protected $_recordClass = 'InvoiceRefund';

    public function insert(array $values, $returnInserted = false)
    {
        if (empty($values['dattm']))
            $values['dattm'] = $this->getDi()->sqlDateTime;
        return parent::insert($values, $returnInserted);
    }

    function selectLast($num, $dateThreshold = null)
    {
        return $this->selectObjects("SELECT ir.*,
            (SELECT GROUP_CONCAT(item_title SEPARATOR ', ') FROM ?_invoice_item WHERE invoice_id=ir.invoice_id) AS items,
            u.login, u.email, CONCAT(u.name_f, ' ', u.name_l) AS name, u.name_f, u.name_l,
            ir.invoice_public_id AS public_id
            FROM ?_invoice_refund ir
            LEFT JOIN ?_user u USING (user_id)
            {WHERE ir.dattm > ?}
            ORDER BY ir.dattm DESC LIMIT ?d",
            $dateThreshold ?: DBSIMPLE_SKIP, $num);
    }

    function getRefundsCount($invoiceId){
        return $this->_db->selectCell("SELECT COUNT(*) FROM ?_invoice_refund WHERE invoice_id=?d", $invoiceId);
    }
}