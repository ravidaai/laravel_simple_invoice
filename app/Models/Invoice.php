<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/25/2019
 * Time: 1:49 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends BaseModel
{
    use SoftDeletes;

    protected $table = 'invoices';
    protected $fillable = [
        'contact_id', 'company_id', 'currency_id', 'invoice_date', 'due_date', 'number', 'subtotal', 'discount', 'total', 'tax', 'tax_percentage', 'paid', 'terms', 'note', 'studio'
    ];
    protected $hidden = [
    ];

    protected $appends = [
        'id_hash', 'humans_date'
    ];
    //////////////////////////////////
    public function contact()
    {
        return $this->belongsTo('App\Models\Contact', 'contact_id', 'id');
    }
    //////////////////////////////////
    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id');
    }
    //////////////////////////////////
    public function currency()
    {
        return $this->belongsTo('App\Models\Currency', 'currency_id', 'id');
    }
    //////////////////////////////////
    public function items()
    {
        return $this->hasMany('App\Models\InvoiceItem', 'invoice_id', 'id');
    }
    //////////////////////////////////
    public function payments()
    {
        return $this->hasMany('App\Models\InvoicePayment', 'invoice_id', 'id');
    }
    //////////////////////////////////
    function addInvoice($data)
    {
        return $this->create($data);
    }
    /////////////////////////////////////////
    function updateInvoice($id, $data)
    {
        return $this->find($id)->update($data);
    }
    /////////////////////
    function getInvoice($id)
    {
        return $this->find($id);
    }
    ////////////////////////////
    function getAllInvoicesActive()
    {
        return $this->where('status','=',1)->get();
    }
    /////////////////////////
    function deleteInvoice($obj)
    {
        return $obj->delete();
    }
    /////////////////////
    function getLastInvoiceNumber()
    {
        return $this->orderBy('id','desc')->first(['number']);
    }
    ///////////////////////////
    function getInvoicesPaginated($skip = 0, $take = 5, $number = null)
    {
        $query = $this;
        if (!is_null($number))
        {
            $query = $query->where('number', 'LIKE', '%' . $number . '%');
        }
        return $query->skip($skip)->take($take);
    }
    //////////////////////////////////////////
    function countInvoicesPaginated($number = null)
    {
        $query = $this;
        if (!is_null($number))
        {
            $query = $query->where('number', 'LIKE', '%' . $number . '%');
        }
        return $query->count('id');
    }
    ///////////////////////////
    function getInvoicesReport($skip = 0, $take = 5, $start_date, $end_date, $item_id, $contact_id, $studio)
    {
        $query = $this;
        if (!is_null($start_date) && !is_null($end_date))
        {
            $query = $query->whereBetween('invoice_date', [$start_date,$end_date]);
        }
        if (!is_null($item_id))
        {
            $query = $query->whereHas('items', function($query) use ($item_id) {
                $query->where('item_id',$item_id);
            });
        }
        if (!is_null($contact_id))
        {
            $query = $query->where('contact_id', $contact_id);
        }
        if (!is_null($studio))
        {
            $query = $query->where('studio', $studio);
        }
        return $query->skip($skip)->take($take);
    }
    //////////////////////////////////////////
    function countInvoicesReport($start_date, $end_date, $item_id, $contact_id, $studio)
    {
        $query = $this;
        if (!is_null($start_date) && !is_null($end_date))
        {
            $query = $query->whereBetween('invoice_date', [$start_date,$end_date]);
        }
        if (!is_null($item_id))
        {
            $query = $query->whereHas('items', function($query) use ($item_id) {
                $query->where('item_id',$item_id);
            });
        }
        if (!is_null($contact_id))
        {
            $query = $query->where('contact_id', $contact_id);
        }
        if (!is_null($studio))
        {
            $query = $query->where('studio', $studio);
        }
        return $query->count('id');
    }
    //////////////////////////////////////////
    function countInvoicesDashboard($paid = null)
    {
        $query = $this;
        if (!is_null($paid))
        {
            $query = $query->where('paid', $paid);
        }
        return $query->count('id');
    }
    //////////////////////////////////////////
    function sumInvoicesDashboard($paid = null)
    {
        $query = $this;
        if (!is_null($paid))
        {
            $query = $query->where('paid', $paid);
        }
        return $query->sum('total');
    }
    //////////////////////////////////////////
    function sumInvoicesByInvoiceId($id)
    {
       return $this->where('id','=',$id)->sum('total');
    }
    //////////////////////////////////////////
    function countInvoicesStatistics($start_date = null, $end_date = null, $item_id = null, $contact_id = null, $studio = null, $paid = null)
    {
        $query = $this;
        if (!is_null($start_date) && !is_null($end_date))
        {
            $query = $query->whereBetween('invoice_date', [$start_date,$end_date]);
        }
        if (!is_null($item_id))
        {
            $query = $query->whereHas('items', function($query) use ($item_id) {
                $query->where('item_id',$item_id);
            });
        }
        if (!is_null($contact_id))
        {
            $query = $query->where('contact_id', $contact_id);
        }
        if (!is_null($studio))
        {
            $query = $query->where('studio', $studio);
        }
        if (!is_null($paid))
        {
            $query = $query->where('paid', $paid);
        }
        return $query->count('id');
    }
    //////////////////////////////////////////
    function sumInvoicesStatistics($start_date = null, $end_date = null, $item_id = null, $contact_id = null, $studio = null, $paid = null)
    {
        $query = $this;
        if (!is_null($start_date) && !is_null($end_date))
        {
            $query = $query->whereBetween('invoice_date', [$start_date,$end_date]);
        }
        if (!is_null($item_id))
        {
            $query = $query->whereHas('items', function($query) use ($item_id) {
                $query->where('item_id',$item_id);
            });
        }
        if (!is_null($contact_id))
        {
            $query = $query->where('contact_id', $contact_id);
        }
        if (!is_null($studio))
        {
            $query = $query->where('studio', $studio);
        }
        if (!is_null($paid))
        {
            $query = $query->where('paid', $paid);
        }
        return $query->sum('total');
    }
}