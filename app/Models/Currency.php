<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/12/2019
 * Time: 2:16 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends BaseModel
{
    use SoftDeletes;

    protected $table = 'currencies';
    protected $fillable = [
        'name', 'sign', 'status',
    ];
    protected $hidden = [
    ];

    protected $appends = [
        'id_hash', 'humans_date'
    ];
    //////////////////////////////////
    function addCurrency($name, $sign, $status)
    {
        $this->name = $name;
        $this->sign = $sign;
        $this->status = $status;

        $this->save();
        return $this;
    }
    /////////////////////////////////////////
    function updateCurrency($obj, $name, $sign, $status)
    {
        $obj->name = $name;
        $obj->sign = $sign;
        $obj->status = $status;

        $obj->save();
        return $obj;
    }
    /////////////////////
    function getCurrency($id)
    {
        return $this->find($id);
    }
    ////////////////////////////
    function getAllCurrenciesActive()
    {
        return $this->where('status','=',1)->get();
    }
    /////////////////////////
    function deleteCurrency($obj)
    {
        return $obj->delete();
    }
    ///////////////////////////
    function getCurrenciesPaginated($skip = 0, $take = 5, $name = null)
    {
        $query = $this;
        if (!is_null($name))
        {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }
        return $query->skip($skip)->take($take);
    }
    //////////////////////////////////////////
    function countCurrenciesPaginated($name = null)
    {
        $query = $this;
        if (!is_null($name))
        {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }
        return $query->count('id');
    }
}