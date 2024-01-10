<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/12/2019
 * Time: 2:37 PM
 */

namespace App\Http\Controllers\Admin;


use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CitiesController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'cities';
    }
    //////////////////////////
    public function getIndex()
    {
        return view('admin.cities.view', parent::$data);
    }
    /////////////////////////////////////////
    public function getList(Request $request)
    {
        $city = new City();

        $length = $request->get('length');
        $start = $request->get('start');
        $name = $request->get('name');

        $info = $city->getCitiesPaginated($start, $length, $name);
        $count = $city->countCitiesPaginated($name);
        $datatable = Datatables::of($info)->setTotalRecords($count);

        $datatable->editColumn('country_id', function ($row)
        {
            return (!empty(optional($row->country)->name) ? optional($row->country)->name : '-');
        });

        $datatable->editColumn('status', function ($row)
        {
            $data['id'] = $row->id;
            $data['status'] = $row->status;

            return view('admin.cities.parts.status', $data)->render();
        });

        $datatable->addColumn('actions', function ($row)
        {
            $data['id_hash'] = $row->id_hash;
            $data['btn_edit'] = parent::$data['btn_edit'];

            return view('admin.cities.parts.actions', $data)->render();
        });
        $datatable->escapeColumns(['*']);
        return $datatable->make(true);
    }
    ////////////////////////
    public function getAdd()
    {
        $country = new Country();
        parent::$data['countries'] = $country->getAllCountriesActive();

        return view('admin.cities.add', parent::$data);
    }
    /////////////////////////////////////////
    public function postAdd(Request $request)
    {
        $name = $request->get('name');
        $country_id = $request->get('country_id');
        $status = (int)$request->get('status');

        $validator = Validator::make([
            'name' => $name,
            'country_id' => $country_id,
            'status' => $status
        ], [
            'name' => 'required|unique:cities,name,0,id,deleted_at,NULL',
            'country_id' => 'required|numeric',
            'status' => 'required|numeric|in:0,1'
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), $validator->messages()->first(), null,null);
        }
        //////////////////////////
        $city = new City();
        $add = $city->addCity($name, $country_id, $status);
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

        $city = new City();
        $country = new Country();
        $info = $city->getCity($id);
        if (!$info)
        {
            $request->session()->flash('danger', trans('messages.not_found'));
            return redirect(route('admin.cities.view'));
        }
        parent::$data['info'] = $info;
        parent::$data['countries'] = $country->getAllCountriesActive();

        return view('admin.cities.edit', parent::$data);
    }
    ///////////////////////////////////////////////
    public function postEdit(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $city = new City();
        $info = $city->getCity($id);
        if (!$info)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.not_found'), null,null);
        }

        $name = $request->get('name');
        $country_id = $request->get('country_id');
        $status = (int)$request->get('status');

        $validator = Validator::make([
            'name' => $name,
            'country_id' => $country_id,
            'status' => $status
        ], [
            'name' => 'required|unique:cities,name,' . $id . ',id,deleted_at,NULL',
            'country_id' => 'required|numeric',
            'status' => 'required|numeric|in:0,1'
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), $validator->messages()->first(), null,null);
        }
        //////////////////////////////////////////////////////////
        $update = $city->updateCity($info, $name, $country_id, $status);
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
        $city = new City();
        $info = $city->getCity($id);
        if (!$info)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.not_found'), null,null);
        }
        $delete = $city->deleteCity($info);
        if (!$delete)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.error'), null,null);
        }
        return $this->respondGeneral(true, 200, trans('alert.success'), trans('messages.deleted'), null,null);
    }
}