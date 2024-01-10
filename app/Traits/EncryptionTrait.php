<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/12/2019
 * Time: 12:19 PM
 */

namespace App\Traits;


use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

trait EncryptionTrait
{
    function encrypt($data)
    {
        return (app()->environment() == "local") ? $data : Crypt::encrypt($data);
    }
    ///////////////////////
    function decrypt($data)
    {
        if (app()->environment() == "local") {
            return $data;
        }

        try {
            return Crypt::decrypt($data);
        } catch (DecryptException $e) {
            return false;
        }
    }
}