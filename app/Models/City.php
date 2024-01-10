<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/12/2019
 * Time: 2:16 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class City extends BaseModel
{
    use SoftDeletes;

    protected $table = 'cities';
    protected $fillable = [
        'name', 'country_id', 'status',
    ];
    protected $hidden = [
    ];

    protected $appends = [
        'id_hash', 'humans_date'
    ];
    //////////////////////////////////
    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id', 'id');
    }
    //////////////////////////////////
    function addCity($name, $country_id, $status)
    {
        $this->name = $name;
        $this->country_id = $country_id;
        $this->status = $status;

        $this->save();
        return $this;
    }
    /////////////////////////////////////////
    function updateCity($obj, $name, $country_id, $status)
    {
        $obj->name = $name;
        $obj->country_id = $country_id;
        $obj->status = $status;

        $obj->save();
        return $obj;
    }
    /////////////////////
    function getCity($id)
    {
        return $this->find($id);
    }
    ////////////////////////////
    function getAllCitiesActive()
    {
        return $this->where('status','=',1)->get();
    }
    /////////////////////////
    function deleteCity($obj)
    {
        return $obj->delete();
    }
    ///////////////////////////
    function getCitiesPaginated($skip = 0, $take = 5, $name = null)
    {
        $query = $this;
        if (!is_null($name))
        {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }
        return $query->skip($skip)->take($take);
    }
    //////////////////////////////////////////
    function countCitiesPaginated($name = null)
    {
        $query = $this;
        if (!is_null($name))
        {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }
        return $query->count('id');
    }
}