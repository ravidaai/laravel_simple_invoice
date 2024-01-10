<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/12/2019
 * Time: 2:15 PM
 */

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CountriesController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'countries';
    }
    //////////////////////////
    public function getIndex()
    {
        return view('admin.countries.view', parent::$data);
    }
    /////////////////////////////////////////
    public function getList(Request $request)
    {
        $country = new Country();

        $length = $request->get('length');
        $start = $request->get('start');
        $name = $request->get('name');

        $info = $country->getCountriesPaginated($start, $length, $name);
        $count = $country->countCountriesPaginated($name);
        $datatable = Datatables::of($info)->setTotalRecords($count);

        $datatable->editColumn('status', function ($row)
        {
            $data['id'] = $row->id;
            $data['status'] = $row->status;

            return view('admin.countries.parts.status', $data)->render();
        });

        $datatable->addColumn('actions', function ($row)
        {
            $data['id_hash'] = $row->id_hash;
            $data['btn_edit'] = parent::$data['btn_edit'];

            return view('admin.countries.parts.actions', $data)->render();
        });
        $datatable->escapeColumns(['*']);
        return $datatable->make(true);
    }
    ////////////////////////
    public function getAdd()
    {
        return view('admin.countries.add', parent::$data);
    }
    /////////////////////////////////////////
    public function postAdd(Request $request)
    {
        $name = $request->get('name');
        $status = (int)$request->get('status');

        $validator = Validator::make([
            'name' => $name,
            'status' => $status
        ], [
            'name' => 'required|unique:countries,name,0,id,deleted_at,NULL',
            'status' => 'required|numeric|in:0,1'
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), $validator->messages()->first(), null,null);
        }
        //////////////////////////
        $country = new Country();
        $add = $country->addCountry($name, $status);
        if (!$add)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.error'), null,null);
        }
        return $this->respondGeneral(true, 200, trans('alert.success'), trans('messages.added'), null,null);
    }
    //////////////////////////////////////////////
    public function getEdit(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $country = new Country();
        $info = $country->getCountry($id);
        if (!$info)
        {
            $request->session()->flash('danger', trans('messages.not_found'));
            return redirect(route('admin.countries.view'));
        }
        parent::$data['info'] = $info;
        return view('admin.countries.edit', parent::$data);
    }
    ///////////////////////////////////////////////
    public function postEdit(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $country = new Country();
        $info = $country->getCountry($id);
        if (!$info)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.not_found'), null,null);
        }

        $name = $request->get('name');
        $status = (int)$request->get('status');

        $validator = Validator::make([
            'name' => $name,
            'status' => $status
        ], [
            'name' => 'required|unique:countries,name,' . $id . ',id,deleted_at,NULL',
            'status' => 'required|numeric|in:0,1'
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), $validator->messages()->first(), null,null);
        }
        //////////////////////////////////////////////////////////
        $update = $country->updateCountry($info, $name, $status);
        if (!$update)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.error'), null,null);
        }
        return $this->respondGeneral(true, 200, trans('alert.success'), trans('messages.updated'), null,null);
    }
    //////////////////////////////////////////////
    public function getDelete($id)
    {
        $id = $this->decrypt($id);
        ///////////////////////////
        $country = new Country();
        $info = $country->getCountry($id);
        if (!$info)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.not_found'), null,null);
        }
        $delete = $country->deleteCountry($info);
        if (!$delete)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.error'), null,null);
        }
        return $this->respondGeneral(true, 200, trans('alert.success'), trans('messages.deleted'), null,null);
    }
}