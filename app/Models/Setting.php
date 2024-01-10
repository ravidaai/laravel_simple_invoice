<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/12/2019
 * Time: 1:54 PM
 */

namespace App\Models;


class Setting extends BaseModel
{
    public $timestamps = false;

    protected $table = 'settings';

    protected $fillable = [
        'setting',
    ];
    ////////////////////////////////////
    function editSetting($obj, $setting)
    {
        $obj->setting = $setting;

        $obj->save();
        return $obj;
    }
    /////////////////////////
    function getSetting($id)
    {
        return $this->find($id);
    }
}