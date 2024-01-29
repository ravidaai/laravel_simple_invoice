<?php


namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItem extends BaseModel
{
    use SoftDeletes;

    protected $table = 'invoice_items';
    protected $fillable = [
        'invoice_id', 'item_id', 'description', 'quantity', 'price', 'tax', 'total',
    ];
    protected $hidden = [
    ];

    protected $appends = [
        'id_hash', 'humans_date'
    ];
    //////////////////////////////////
    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_id', 'id');
    }
    //////////////////////////////////
    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice', 'invoice_id', 'id');
    }
    //////////////////////////////////
    function addInvoiceItem($data)
    {
        return $this->create($data);
    }
    /////////////////////
    function getInvoiceItem($id)
    {
        return $this->find($id);
    }
    ////////////////////////////
    function getAllInvoicesItemsActive()
    {
        return $this->where('status','=',1)->get();
    }
    /////////////////////////
    function deleteInvoiceItem($obj)
    {
        return $obj->delete();
    }
    /////////////////////////
    function deleteInvoiceItemByInvoiceId($invoice_id)
    {
        return $this->where('invoice_id','=',$invoice_id)->delete();
    }
}
