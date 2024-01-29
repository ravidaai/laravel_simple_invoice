<?php


namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends BaseModel
{
    use SoftDeletes;

    protected $table = 'contacts';
    protected $fillable = [
        'name', 'display_name', 'company_id', 'email', 'mobile', 'url', 'country_id', 'city_id', 'address', 'postal_code', 'status',
    ];
    protected $hidden = [
    ];

    protected $appends = [
        'id_hash', 'humans_date'
    ];
    //////////////////////////////////
    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id');
    }
    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id', 'id');
    }
    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }
    //////////////////////////////////
    function addContact($name, $display_name, $company_id, $email, $mobile, $url, $country_id, $city_id, $address, $postal_code, $status)
    {
        $this->name = $name;
        $this->display_name = $display_name;
        $this->company_id = $company_id;
        $this->email = $email;
        $this->mobile = $mobile;
        $this->url = $url;
        $this->country_id = $country_id;
        $this->city_id = $city_id;
        $this->address = $address;
        $this->postal_code = $postal_code;
        $this->status = $status;

        $this->save();
        return $this;
    }
    /////////////////////////////////////////
    function updateContact($obj, $name, $display_name, $company_id, $email, $mobile, $url, $country_id, $city_id, $address, $postal_code, $status)
    {
        $obj->name = $name;
        $obj->display_name = $display_name;
        $obj->company_id = $company_id;
        $obj->email = $email;
        $obj->mobile = $mobile;
        $obj->url = $url;
        $obj->country_id = $country_id;
        $obj->city_id = $city_id;
        $obj->address = $address;
        $obj->postal_code = $postal_code;
        $obj->status = $status;

        $obj->save();
        return $obj;
    }
    /////////////////////
    function getContact($id)
    {
        return $this->find($id);
    }
    ////////////////////////////
    function getAllContactsActive()
    {
        return $this->where('status','=',1)->get();
    }
    /////////////////////////
    function deleteContact($obj)
    {
        return $obj->delete();
    }
    ///////////////////////////
    function getContactsPaginated($skip = 0, $take = 5, $name = null)
    {
        $query = $this;
        if (!is_null($name))
        {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }
        return $query->skip($skip)->take($take);
    }
    //////////////////////////////////////////
    function countContactsPaginated($name = null)
    {
        $query = $this;
        if (!is_null($name))
        {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }
        return $query->count('id');
    }
    //////////////////////////////////////////
    function countContactsDashboard()
    {
        return $this->count('id');
    }
}
