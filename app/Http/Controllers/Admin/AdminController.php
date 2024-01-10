<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/12/2019
 * Time: 12:19 PM
 */

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use App\Traits\ResponseTrait;
use Illuminate\Routing\Controller as BaseController;
use App\Traits\EncryptionTrait;
use Illuminate\Support\Facades\Mail;
use stdClass;

class AdminController extends BaseController
{
    use EncryptionTrait, ResponseTrait;

    public static $data = [];
    /////////////////////////
    public function __construct()
    {
        self::$data['active_menu'] = '';
        self::$data['active_sub_menu'] = '';
        self::$data['menu_color'] = 'm--font-brand';
        ////////////////////////////////////
        self::$data['btn_action'] = 'brand';
        self::$data['btn_edit'] = 'brand';
        self::$data['btn_cancel'] = 'secondary';
        self::$data['btn_change_password'] = 'accent';
        self::$data['btn_permission'] = 'warning';
    }
    //////////////////////////////////////////////////////
    public static function sendEmail($email, $name,  $message)
    {
        $data = new stdClass();
        $data->email = $email;
        $data->name = $name;
        $data->message = $message;
        ////////////////////////////
        $setting_obj = new Setting();
        $info = $setting_obj->getSetting(1);
        $settings = self::$data['setting'] = json_decode($info->setting);
        /////////////////////////////////////////////////
        if($settings->smtp_crypto == 0)
        {
            $encryption = null;
        }
        elseif($settings->smtp_crypto == 1)
        {
            $encryption = 'ssl';
        }
        elseif($settings->smtp_crypto == 2)
        {
            $encryption = 'tls';
        }
        else
        {
            $encryption = null;
        }
        ///////////////////////////////////////////////////////////
        \Config::set('mail.driver', 'smtp');
        \Config::set('mail.host', $settings->smtp_host);
        \Config::set('mail.port', $settings->smtp_port);
        \Config::set('mail.email', $settings->email);
        \Config::set('mail.encryption', $encryption);
        \Config::set('mail.password', $settings->email_password);

        try
        {
            Mail::send('admin.emails.view', ['data' => $data], function ($message) use ($email, $name, $settings) {
                $message->to($email, $name)->subject('Panda Invoice')->from($settings->email, 'Panda Voice Over');
            });
        }
        catch(\Exception $exception)
        {

        }
    }
}