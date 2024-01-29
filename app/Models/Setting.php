<?php


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
