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
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CurrenciesController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'currencies';
    }
    //////////////////////////
    public function getIndex()
    {
        return view('admin.currencies.view', parent::$data);
    }
    /////////////////////////////////////////
    public function getList(Request $request)
    {
        $currency = new Currency();

        $length = $request->get('length');
        $start = $request->get('start');
        $name = $request->get('name');

        $info = $currency->getCurrenciesPaginated($start, $length, $name);
        $count = $currency->countCurrenciesPaginated($name);
        $datatable = Datatables::of($info)->setTotalRecords($count);

        $datatable->editColumn('status', function ($row)
        {
            $data['id'] = $row->id;
            $data['status'] = $row->status;

            return view('admin.currencies.parts.status', $data)->render();
        });

        $datatable->addColumn('actions', function ($row)
        {
            $data['id_hash'] = $row->id_hash;
            $data['btn_edit'] = parent::$data['btn_edit'];

            return view('admin.currencies.parts.actions', $data)->render();
        });
        $datatable->escapeColumns(['*']);
        return $datatable->make(true);
    }
    ////////////////////////
    public function getAdd()
    {
        return view('admin.currencies.add', parent::$data);
    }
    /////////////////////////////////////////
    public function postAdd(Request $request)
    {
        $name = $request->get('name');
        $sign = $request->get('sign');
        $status = (int)$request->get('status');

        $validator = Validator::make([
            'name' => $name,
            'sign' => $sign,
            'status' => $status
        ], [
            'name' => 'required|unique:currencies,name,0,id,deleted_at,NULL',
            'sign' => 'required',
            'status' => 'required|numeric|in:0,1'
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), $validator->messages()->first(), null,null);
        }
        //////////////////////////
        $currency = new Currency();
        $add = $currency->addCurrency($name, $sign, $status);
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

        $currency = new Currency();
        $info = $currency->getCurrency($id);
        if (!$info)
        {
            $request->session()->flash('danger', trans('messages.not_found'));
            return redirect(route('admin.currencies.view'));
        }
        parent::$data['info'] = $info;

        return view('admin.currencies.edit', parent::$data);
    }
    ///////////////////////////////////////////////
    public function postEdit(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $currency = new Currency();
        $info = $currency->getCurrency($id);
        if (!$info)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.not_found'), null,null);
        }

        $name = $request->get('name');
        $sign = $request->get('sign');
        $status = (int)$request->get('status');

        $validator = Validator::make([
            'name' => $name,
            'sign' => $sign,
            'status' => $status
        ], [
            'name' => 'required|unique:currencies,name,' . $id . ',id,deleted_at,NULL',
            'sign' => 'required',
            'status' => 'required|numeric|in:0,1'
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), $validator->messages()->first(), null,null);
        }
        //////////////////////////////////////////////////////////
        $update = $currency->updateCurrency($info, $name, $sign, $status);
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
        $currency = new Currency();
        $info = $currency->getCurrency($id);
        if (!$info)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.not_found'), null,null);
        }
        $delete = $currency->deleteCurrency($info);
        if (!$delete)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.error'), null,null);
        }
        return $this->respondGeneral(true, 200, trans('alert.success'), trans('messages.deleted'), null,null);
    }
}