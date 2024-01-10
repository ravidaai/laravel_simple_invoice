<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/17/2019
 * Time: 2:33 PM
 */

namespace App\Traits;


use stdClass;

trait ResponseTrait
{
    function respondGeneral($status, $code, $alert = null, $message, $errors = null, $data = null)
    {
        $data = is_null($data) ? new stdClass() : $data;
        return response()->json(['status' => $status, 'code' => $code, 'message' => $alert . ' ' . $message, 'errors' => $errors, 'data' => $data]);
    }

    function generalResponse($status, $code, $message = null, $errors = null, $data = null)
    {
        $data = is_null($data) ? new stdClass() : $data;
        return response()->json(['status' => $status, 'code' => $code, 'message' => $message, 'errors' => $errors, 'data' => $data]);
    }
}