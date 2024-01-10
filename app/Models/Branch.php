<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/12/2019
 * Time: 2:16 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends BaseModel
{
    use SoftDeletes;

    protected $table = 'branches';
    protected $fillable = [
        'company_id', 'is_primary', 'country_id', 'city_id', 'address_one', 'address_two', 'postal_code', 'status',
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
    function addBranch($company_id, $is_primary, $country_id, $city_id, $address_one, $address_two, $postal_code, $status)
    {
        $this->company_id = $company_id;
        $this->is_primary = $is_primary;
        $this->country_id = $country_id;
        $this->city_id = $city_id;
        $this->address_one = $address_one;
        $this->address_two = $address_two;
        $this->postal_code = $postal_code;
        $this->status = $status;

        $this->save();
        return $this;
    }
    /////////////////////////////////////////
    function updateBranch($obj, $company_id, $is_primary, $country_id, $city_id, $address_one, $address_two, $postal_code, $status)
    {
        $obj->company_id = $company_id;
        $obj->is_primary = $is_primary;
        $obj->country_id = $country_id;
        $obj->city_id = $city_id;
        $obj->address_one = $address_one;
        $obj->address_two = $address_two;
        $obj->postal_code = $postal_code;
        $obj->status = $status;

        $obj->save();
        return $obj;
    }
    /////////////////////
    function getBranch($id)
    {
        return $this->find($id);
    }
    ////////////////////////////
    function getAllBranchesActive()
    {
        return $this->where('status','=',1)->get();
    }
    /////////////////////////
    function deleteBranch($obj)
    {
        return $obj->delete();
    }
    ///////////////////////////
    function getBranchesPaginated($skip = 0, $take = 5, $name = null)
    {
        $query = $this;
        if (!is_null($name))
        {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }
        return $query->skip($skip)->take($take);
    }
    //////////////////////////////////////////
    function countBranchesPaginated($name = null)
    {
        $query = $this;
        if (!is_null($name))
        {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }
        return $query->count('id');
    }
}