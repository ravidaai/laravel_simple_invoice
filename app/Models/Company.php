<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/13/2019
 * Time: 2:18 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends BaseModel
{
    use SoftDeletes;

    protected $table = 'companies';
    protected $fillable = [
        'name', 'country_id', 'city_id', 'tax_number', 'tax_value', 'logo', 'status',
    ];
    protected $hidden = [
    ];

    protected $appends = [
        'id_hash', 'humans_date'
    ];
    //////////////////////////////////
    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }
    /////////////////////////
    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id', 'id');
    }
    /////////////////////////
    public function branches()
    {
        return $this->hasMany('App\Models\Branch', 'company_id', 'id');
    }
    /////////////////////////
    public function payments()
    {
        return $this->hasMany('App\Models\Payment', 'company_id', 'id');
    }
    //////////////////////////////////
    function addCompany($name, $country_id, $city_id, $tax_number, $tax_value, $logo, $status)
    {
        $this->name = $name;
        $this->country_id = $country_id;
        $this->city_id = $city_id;
        $this->tax_number = $tax_number;
        $this->tax_value = $tax_value;
        $this->logo = $logo;
        $this->status = $status;

        $this->save();
        return $this;
    }
    /////////////////////////////////////////
    function updateCompany($obj, $name, $country_id, $city_id, $tax_number, $tax_value, $logo, $status)
    {
        $obj->name = $name;
        $obj->country_id = $country_id;
        $obj->city_id = $city_id;
        $obj->tax_number = $tax_number;
        $obj->tax_value = $tax_value;
        $obj->logo = $logo;
        $obj->status = $status;

        $obj->save();
        return $obj;
    }
    /////////////////////
    function getCompany($id)
    {
        return $this->find($id);
    }
    ////////////////////////////
    function getAllCompaniesActive()
    {
        return $this->where('status','=',1)->get();
    }
    /////////////////////////
    function deleteCompany($obj)
    {
        return $obj->delete();
    }
    ///////////////////////////
    function getCompanyInfo($company_id)
    {
        return $this->where('id', '=', $company_id)->first();
    }
    ///////////////////////////
    function getCompaniesPaginated($skip = 0, $take = 5, $name = null)
    {
        $query = $this;
        if (!is_null($name))
        {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }
        return $query->skip($skip)->take($take);
    }
    //////////////////////////////////////////
    function countCompaniesPaginated($name = null)
    {
        $query = $this;
        if (!is_null($name))
        {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }
        return $query->count('id');
    }
    //////////////////////////////////////////
    function countCompaniesDashboard()
    {
        return $this->count('id');
    }
}
