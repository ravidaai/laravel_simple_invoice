<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/12/2019
 * Time: 12:31 PM
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends AdminController
{
    use AuthenticatesUsers;

    public function getIndex()
    {
        return view('admin.login.view');
    }
    ///////////////////////////////////////////
    public function postIndex(Request $request)
    {
        $field = filter_var($request->get('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        //////////////////////////////////////////
        $username = $request->get('username');
        $password = $request->get('password');
        $remember_token = $request->get('remember_token');

        $admin[$field] = $username;
        $admin['password'] = $password;
        $admin['status'] = 1;
        ///////////////////////////////
        if (!Auth::guard('admin')->attempt($admin, $remember_token))
        {
            return redirect('admin/login')->with(['danger' => trans('messages.messageError')]);
        }
        return redirect()->intended('/');
    }
    ///////////////////////////
    public function getLogout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}