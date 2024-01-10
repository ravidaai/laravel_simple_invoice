<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/12/2019
 * Time: 1:03 PM
 */

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'users';
    }
    //////////////////////////
    public function getIndex()
    {
        return view('admin.users.view', parent::$data);
    }
    /////////////////////////////////////////
    public function getList(Request $request)
    {
        $user = new User();

        $length = $request->get('length');
        $start = $request->get('start');
        $username = $request->get('username');
        $name = $request->get('name');
        $email = $request->get('email');

        $info = $user->getUsersPaginated($start, $length, $username, $name, $email);
        $count = $user->countUsersPaginated($username, $name, $email);
        $datatable = Datatables::of($info)->setTotalRecords($count);

        $datatable->editColumn('email', function ($row)
        {
            return (!empty($row->email) ? $row->email : 'N/A');
        });

        $datatable->editColumn('status', function ($row)
        {
            $data['id'] = $row->id;
            $data['status'] = $row->status;

            return view('admin.users.parts.status', $data)->render();
        });

        $datatable->addColumn('actions', function ($row)
        {
            $data['id_hash'] = $row->id_hash;
            $data['btn_edit'] = parent::$data['btn_edit'];
            $data['btn_change_password'] = parent::$data['btn_change_password'];

            return view('admin.users.parts.actions', $data)->render();
        });
        $datatable->escapeColumns(['*']);
        return $datatable->make(true);
    }
    ////////////////////////
    public function getAdd()
    {
        return view('admin.users.add', parent::$data);
    }
    //////////////////////////////////////////////
    public function postAdd(Request $request)
    {
        $username = $request->get('username');
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        $password_confirmation = $request->get('password_confirmation');
        $status = (int)$request->get('status');

        $validator = Validator::make([
            'username' => $username,
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password_confirmation,
            'status' => $status
        ], [
            'username' => 'required|unique:users,username,0,id,deleted_at,NULL',
            'name' => 'required|min:3,max:100',
            'email' => 'required|unique:users,email',
            'password' => 'required|between:6,16|confirmed',
            'password_confirmation' => 'required|between:6,16',
            'status' => 'required|numeric|in:0,1'
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), $validator->messages()->first(), null,null);
        }
        ///////////////////
        $user = new User();
        $add = $user->addUser($username, $name, $email, Hash::make($password), $status);
        if (!$add)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.error'), null,null);
        }
        /////////////////////////////////////
        return $this->respondGeneral(true, 200, trans('alert.success'), trans('messages.added'), null,null);
    }
    //////////////////////////////////////////////
    public function getEdit(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $user = new User();

        $info = $user->getUser($id);
        if (!$info || $id == 1)
        {
            $request->session()->flash('danger', trans('messages.not_found'));
            return redirect(route('admin.users.view'));
        }
        parent::$data['info'] = $info;
        return view('admin.users.edit', parent::$data);
    }
    //////////////////////////////////////////////
    public function postEdit(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $user = new User();
        $info = $user->getUser($id);
        if (!$info || $id == 1)
        {
            return $this->respondGeneral(true, 500, trans('alert.success'), trans('messages.not_found'), null,null);
        }
        $username = $request->get('username');
        $name = $request->get('name');
        $email = $request->get('email');
        $status = (int)$request->get('status');

        $validator = Validator::make([
            'username' => $username,
            'name' => $name,
            'email' => $email,
            'status' => $status
        ], [
            'username' => 'required|unique:users,username,' . $id . ',id,deleted_at,NULL',
            'name' => 'required|min:3,max:100',
            'email' => 'required|unique:users,email,' . $id,
            'status' => 'required|numeric|in:0,1'
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), $validator->messages()->first(), null,null);
        }
        $update = $user->updateUser($info, $username, $name, $email, $status);
        if (!$update)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.error'), null,null);
        }
        //////////////////////////////////////////////
        return $this->respondGeneral(true, 200, trans('alert.success'), trans('messages.updated'), null,null);
    }
    //////////////////////////////////////////////////
    public function getPassword(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $user = new User();
        $info = $user->getUser($id);
        if (!$info || $id == 1)
        {
            $request->session()->flash('danger', trans('messages.not_found'));
            return redirect(route('admin.users.view'));
        }
        parent::$data['info'] = $info;
        return view('admin.users.password', parent::$data);
    }
    //////////////////////////////////////////////
    public function postPassword(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $user = new User();
        $info = $user->getUser($id);
        if (!$info || $id == 1)
        {
            return $this->respondGeneral(true, 500, trans('alert.success'), trans('messages.not_found'), null,null);
        }
        $password = $request->get('password');
        $password_confirmation = $request->get('password_confirmation');

        $validator = Validator::make([
            'password' => $password,
            'password_confirmation' => $password_confirmation
        ], [
            'password' => 'required|between:6,16|confirmed',
            'password_confirmation' => 'required|between:6,16'
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return response()->json(['status' => false, 'code' => 500, 'type' => 'error', 'message' => $validator->messages()->first()]);
        }
        $update = $user->updatePassword($id, Hash::make($password));
        if (!$update)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.error'), null,null);
        }
        return $this->respondGeneral(true, 200, trans('alert.success'), trans('messages.changed'), null,null);
    }
    //////////////////////////////////////////////
    public function getDelete($id)
    {
        $id = $this->decrypt($id);
        ///////////////////
        $user = new User();
        $info = $user->getUser($id);
        if (!$info || $id == 1)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.not_found'), null,null);
        }
        $delete = $user->deleteUser($info);
        if (!$delete)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.error'), null,null);
        }
        return $this->respondGeneral(true, 200, trans('alert.success'), trans('messages.deleted'), null,null);
    }
}