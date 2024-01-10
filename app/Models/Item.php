<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/13/2019
 * Time: 12:04 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends BaseModel
{
    use SoftDeletes;

    protected $table = 'items';
    protected $fillable = [
        'name', 'description', 'type', 'price', 'status',
    ];
    protected $hidden = [
    ];

    protected $appends = [
        'id_hash', 'humans_date'
    ];
    //////////////////////////////////
    function addItem($name, $description, $type, $price, $status)
    {
        $this->name = $name;
        $this->description = $description;
        $this->type = $type;
        $this->price = $price;
        $this->status = $status;

        $this->save();
        return $this;
    }
    /////////////////////////////////////////
    function updateItem($obj, $name, $description, $type, $price, $status)
    {
        $obj->name = $name;
        $obj->description = $description;
        $obj->type = $type;
        $obj->price = $price;
        $obj->status = $status;

        $obj->save();
        return $obj;
    }
    /////////////////////
    function getItem($id)
    {
        return $this->find($id);
    }
    ////////////////////////////
    function getAllItemsActive()
    {
        return $this->where('status','=',1)->get();
    }
    /////////////////////////
    function getItemInfo($item_id)
    {
        return $this->where('id', '=', $item_id)->first();
    }
    ///////////////////////////
    function deleteItem($obj)
    {
        return $obj->delete();
    }
    ///////////////////////////
    function getItemsPaginated($skip = 0, $take = 5, $name = null)
    {
        $query = $this;
        if (!is_null($name))
        {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }
        return $query->skip($skip)->take($take);
    }
    //////////////////////////////////////////
    function countItemsPaginated($name = null)
    {
        $query = $this;
        if (!is_null($name))
        {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }
        return $query->count('id');
    }
}