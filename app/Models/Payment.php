<?php


namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends BaseModel
{
    use SoftDeletes;

    protected $table = 'company_payments';
    protected $fillable = [
        'name', 'iban', 'swift_code', 'address', 'company_id', 'status',
    ];
    protected $hidden = [
    ];

    protected $appends = [
        'id_hash', 'humans_date'
    ];
    //////////////////////////////////
    function addPayment($name, $iban, $swift_code, $address, $company_id, $status)
    {
        $this->name = $name;
        $this->iban = $iban;
        $this->swift_code = $swift_code;
        $this->address = $address;
        $this->company_id = $company_id;
        $this->status = $status;

        $this->save();
        return $this;
    }
    /////////////////////////////////////////
    function updatePayment($obj, $name, $iban, $swift_code, $address, $company_id, $status)
    {
        $obj->name = $name;
        $obj->iban = $iban;
        $obj->swift_code = $swift_code;
        $obj->address = $address;
        $obj->company_id = $company_id;
        $obj->status = $status;

        $obj->save();
        return $obj;
    }
    /////////////////////
    function getPayment($id)
    {
        return $this->find($id);
    }
    ////////////////////////////
    function getAllPaymentActive()
    {
        return $this->where('status','=',1)->get();
    }
    /////////////////////////
    function deletePayment($obj)
    {
        return $obj->delete();
    }
    ///////////////////////////
    function getPaymentsPaginated($skip = 0, $take = 5, $name = null)
    {
        $query = $this;
        if (!is_null($name))
        {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }
        return $query->skip($skip)->take($take);
    }
    //////////////////////////////////////////
    function countPaymentsPaginated($name = null)
    {
        $query = $this;
        if (!is_null($name))
        {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }
        return $query->count('id');
    }
}
