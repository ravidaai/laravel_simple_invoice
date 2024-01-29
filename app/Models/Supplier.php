<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends BaseModel
{
    use SoftDeletes;

    protected $table = 'suppliers';
    protected $fillable = [
        'name', 'display_name', 'email', 'mobile', 'url', 'country_id', 'address', 'postal_code', 'status',
    ];
    protected $hidden = [
    ];

    protected $appends = [
        'id_hash', 'humans_date'
    ];
    ////////////////////////////
    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id', 'id');
    }
    //////////////////////////////////
    function addSupplier($name, $display_name, $email, $mobile, $url, $country_id, $address, $postal_code, $status)
    {
        $this->name = $name;
        $this->display_name = $display_name;
        $this->email = $email;
        $this->mobile = $mobile;
        $this->url = $url;
        $this->country_id = $country_id;
        $this->address = $address;
        $this->postal_code = $postal_code;
        $this->status = $status;

        $this->save();
        return $this;
    }
    /////////////////////////////////////////
    function updateSupplier($obj, $name, $display_name, $email, $mobile, $url, $country_id, $address, $postal_code, $status)
    {
        $obj->name = $name;
        $obj->display_name = $display_name;
        $obj->email = $email;
        $obj->mobile = $mobile;
        $obj->url = $url;
        $obj->country_id = $country_id;
        $obj->address = $address;
        $obj->postal_code = $postal_code;
        $obj->status = $status;

        $obj->save();
        return $obj;
    }
    /////////////////////
    function getSupplier($id)
    {
        return $this->find($id);
    }
    ////////////////////////////
    function getAllSuppliersActive()
    {
        return $this->where('status','=',1)->get();
    }
    /////////////////////////
    function deleteSupplier($obj)
    {
        return $obj->delete();
    }
    ///////////////////////////
    function getSuppliersPaginated($skip = 0, $take = 5, $name = null)
    {
        $query = $this;
        if (!is_null($name))
        {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }
        return $query->skip($skip)->take($take);
    }
    //////////////////////////////////////////
    function countSuppliersPaginated($name = null)
    {
        $query = $this;
        if (!is_null($name))
        {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }
        return $query->count('id');
    }
    //////////////////////////////////////////
    function countSuppliersDashboard()
    {
        return $this->count('id');
    }
}
