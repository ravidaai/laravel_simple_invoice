<?php


namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends BaseModel
{
    use SoftDeletes;

    protected $table = 'categories';
    protected $fillable = [
        'name', 'status',
    ];
    protected $hidden = [
    ];

    protected $appends = [
        'id_hash', 'humans_date'
    ];
    //////////////////////////////////
    function addCategory($name, $status)
    {
        $this->name = $name;
        $this->status = $status;

        $this->save();
        return $this;
    }
    /////////////////////////////////////////
    function updateCategory($obj, $name, $status)
    {
        $obj->name = $name;
        $obj->status = $status;

        $obj->save();
        return $obj;
    }
    /////////////////////
    function getCategory($id)
    {
        return $this->find($id);
    }
    ////////////////////////////
    function getAllCategoriesActive()
    {
        return $this->where('status','=',1)->get();
    }
    /////////////////////////
    function deleteCategory($obj)
    {
        return $obj->delete();
    }
    ///////////////////////////
    function getCategoriesPaginated($skip = 0, $take = 5, $name = null)
    {
        $query = $this;
        if (!is_null($name))
        {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }
        return $query->skip($skip)->take($take);
    }
    //////////////////////////////////////////
    function countCategoriesPaginated($name = null)
    {
        $query = $this;
        if (!is_null($name))
        {
            $query = $query->where('name', 'LIKE', '%' . $name . '%');
        }
        return $query->count('id');
    }
    //////////////////////////////////////////
    function countCategoriesDashboard()
    {
        return $this->count('id');
    }
}
