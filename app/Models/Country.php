<?php


namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends BaseModel
{
    use SoftDeletes;

    protected $table = 'countries';
    protected $fillable = [
        'name', 'status',
    ];
    protected $hidden = [
    ];

    protected $appends = [
        'id_hash', 'humans_date'
    ];
    //////////////////////////////////
    function addCountry($name, $status)
    {
        $this->name = $name;
        $this->status = $status;

        $this->save();
        return $this;
    }
    /////////////////////////////////////////
    function updateCountry($obj, $name, $status)
    {
        $obj->name = $name;
        $obj->status = $status;

        $obj->save();
        return $obj;
    }
    /////////////////////
    function getCountry($id)
    {
        return $this->find($id);
    }
    ////////////////////////////
    function getAllCountriesActive()
    {
        return $this->where('status','=',1)->get();
    }
    /////////////////////////
    function deleteCountry($obj)
    {
        return $obj->delete();
    }
    ///////////////////////////
    function getCountriesPaginated($skip = 0, $take = 5, $name = null)
    {
        $query = $this;
        if (!is_null($name))
        {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }
        return $query->skip($skip)->take($take);
    }
    //////////////////////////////////////////
    function countCountriesPaginated($name = null)
    {
        $query = $this;
        if (!is_null($name))
        {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }
        return $query->count('id');
    }
}
