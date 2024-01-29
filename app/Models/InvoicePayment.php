<?php


namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class InvoicePayment extends BaseModel
{
    use SoftDeletes;

    protected $table = 'invoices_payments';

    protected $fillable = [
        'invoice_id', 'amount', 'note', 'type', 'bank_name', 'bank_branch', 'transfer_number'
    ];

    protected $appends = [
        'id_hash', 'humans_date',
    ];
    ////////////////////////////////////
    function getInvoicePayment($id)
    {
        return $this->find($id);
    }
    ////////////////////////////////////
    function addInvoicePayments($data)
    {
        return $this->create($data);
    }
    //////////////////////////////////
    function deleteInvoicePayments($obj)
    {
        return $obj->delete();
    }
    ///////////////////////////////////
    function getPaymentsPaginated($skip = 0, $take = 5, $invoice_id)
    {
        return $this->where('invoice_id', '=', $invoice_id)->skip($skip)->take($take);
    }
    ///////////////////////////////////////////
    function countPaymentsPaginated($invoice_id)
    {
        return $this->where('invoice_id', '=', $invoice_id)->count('id');
    }
    ///////////////////////////////////////////
    function sumPaymentsByInvoice($invoice_id)
    {
        return $this->where('invoice_id', '=', $invoice_id)->sum('amount');
    }
}
