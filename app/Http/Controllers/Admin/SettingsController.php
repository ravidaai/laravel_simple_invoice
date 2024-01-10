<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/12/2019
 * Time: 1:53 PM
 */

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use stdClass;

class SettingsController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'settings';
    }
    //////////////////////////////////////////
    public function getIndex()
    {
        $settings = new Setting();
        $info = $settings->getSetting(1);
        if (!$info)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.not_found'), null,null);
        }
        parent::$data['info'] = json_decode($info->setting);
        return view('admin.settings.view', parent::$data);
    }
    ///////////////////////////////////////////
    public function postIndex(Request $request)
    {
        $setting = new Setting();
        $info = $setting->getSetting(1);
        if (!$info)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.not_found'), null,null);
        }
        ////////////////////////////////////
        $email = $request->get('email');
        $mobile = $request->get('mobile');
        $longitude = $request->get('longitude');
        $latitude = $request->get('latitude');
        $email_password = $request->get('email_password');
        $smtp_host = $request->get('smtp_host');
        $smtp_port = $request->get('smtp_port');
        $smtp_timeout = $request->get('smtp_timeout');
        $smtp_crypto = $request->get('smtp_crypto');

        $validator = Validator::make([
            'email' => $email,
            'mobile' => $mobile,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'email_password' => $email_password,
            'smtp_host' => $smtp_host,
            'smtp_port' => $smtp_port,
            'smtp_timeout' => $smtp_timeout,
            'smtp_crypto' => $smtp_crypto,
        ], [
            'email' => 'required',
            'mobile' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'email_password' => 'required',
            'smtp_host' => 'required',
            'smtp_port' => 'required',
            'smtp_timeout' => 'required',
            'smtp_crypto' => 'required',
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), $validator->messages()->first(), null,null);
        }
        ///////////////////////
        $object = new stdClass;
        $object->email = $email;
        $object->mobile = $mobile;
        $object->longitude = $longitude;
        $object->latitude = $latitude;
        $object->email_password = $email_password;
        $object->smtp_host = $smtp_host;
        $object->smtp_port = $smtp_port;
        $object->smtp_timeout = $smtp_timeout;
        $object->smtp_crypto = $smtp_crypto;
        /////////////////////////////////////////////////////////////
        $update = $setting->editSetting($info, json_encode($object));
        if (!$update)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.error'), null,null);
        }
        return $this->respondGeneral(true, 200, trans('alert.success'), trans('messages.updated'), null,null);
    }
}