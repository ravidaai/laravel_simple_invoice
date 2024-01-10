<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/13/2019
 * Time: 2:19 PM
 */

namespace App\Http\Controllers\Admin;


use App\Models\Supplier;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SuppliersController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'suppliers';
    }
    //////////////////////////
    public function getIndex()
    {
        return view('admin.suppliers.view', parent::$data);
    }
    /////////////////////////////////////////
    public function getList(Request $request)
    {
        $supplier = new Supplier();

        $length = $request->get('length');
        $start = $request->get('start');
        $name = $request->get('name');

        $info = $supplier->getSuppliersPaginated($start, $length, $name);
        $count = $supplier->countSuppliersPaginated($name);
        $datatable = Datatables::of($info)->setTotalRecords($count);

        $datatable->editColumn('country_id', function ($row)
        {
            return (!empty(optional($row->country)->name) ? optional($row->country)->name : '-');
        });

        $datatable->editColumn('status', function ($row)
        {
            $data['id'] = $row->id;
            $data['status'] = $row->status;

            return view('admin.suppliers.parts.status', $data)->render();
        });

        $datatable->addColumn('actions', function ($row)
        {
            $data['id_hash'] = $row->id_hash;
            $data['btn_edit'] = parent::$data['btn_edit'];

            return view('admin.suppliers.parts.actions', $data)->render();
        });
        $datatable->escapeColumns(['*']);
        return $datatable->make(true);
    }
    ////////////////////////
    public function getAdd()
    {
        $country = new Country();

        parent::$data['countries'] = $country->getAllCountriesActive();
        return view('admin.suppliers.add', parent::$data);
    }
    /////////////////////////////////////////
    public function postAdd(Request $request)
    {
        $name = $request->get('name');
        $display_name = $request->get('display_name');
        $email = $request->get('email');
        $mobile = $request->get('mobile');
        $url = $request->get('url');
        $country_id = $request->get('country_id');
        $address = $request->get('address');
        $postal_code = $request->get('postal_code');
        $status = (int)$request->get('status');

        $validator = Validator::make([
            'name' => $name,
            'display_name' => $display_name,
            'email' => $email,
            'mobile' => $mobile,
            'url' => $url,
            'country_id' => $country_id,
            'address' => $address,
            'postal_code' => $postal_code,
            'status' => $status
        ], [
            'name' => 'required|unique:suppliers,name,0,id,deleted_at,NULL',
            'display_name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'url' => 'required',
            'country_id' => 'required',
            'address' => 'required',
            'postal_code' => 'required',
            'status' => 'required|numeric|in:0,1'
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), $validator->messages()->first(), null,null);
        }
        //////////////////////////
        $supplier = new Supplier();
        $add = $supplier->addSupplier($name, $display_name, $email, $mobile, $url, $country_id, $address, $postal_code, $status);
        if (!$add)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.error'), null,null);
        }
        return $this->respondGeneral(true, 200, trans('alert.success'), trans('messages.added'), null, $add);
    }
    //////////////////////////////////////////////
    public function getEdit(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $supplier = new Supplier();
        $country = new Country();
        $info = $supplier->getSupplier($id);
        if (!$info)
        {
            $request->session()->flash('danger', trans('messages.not_found'));
            return redirect(route('admin.suppliers.view'));
        }
        parent::$data['info'] = $info;
        parent::$data['countries'] = $country->getAllCountriesActive();
        return view('admin.suppliers.edit', parent::$data);
    }
    ///////////////////////////////////////////////
    public function postEdit(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $supplier = new Supplier();
        $info = $supplier->getSupplier($id);
        if (!$info)
        {
            return $this->respondGeneral(true, 500, trans('alert.success'), trans('messages.not_found'), null,null);
        }

        $name = $request->get('name');
        $display_name = $request->get('display_name');
        $email = $request->get('email');
        $mobile = $request->get('mobile');
        $url = $request->get('url');
        $country_id = $request->get('country_id');
        $address = $request->get('address');
        $postal_code = $request->get('postal_code');
        $status = (int)$request->get('status');

        $validator = Validator::make([
            'name' => $name,
            'display_name' => $display_name,
            'email' => $email,
            'mobile' => $mobile,
            'url' => $url,
            'country_id' => $country_id,
            'address' => $address,
            'postal_code' => $postal_code,
            'status' => $status
        ], [
            'name' => 'required|unique:suppliers,name,' . $id . ',id,deleted_at,NULL',
            'display_name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'url' => 'required',
            'country_id' => 'required',
            'address' => 'required',
            'postal_code' => 'required',
            'status' => 'required|numeric|in:0,1'
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), $validator->messages()->first(), null,null);
        }
        //////////////////////////////////////////////////////////
        $update = $supplier->updateSupplier($info, $name, $display_name, $email, $mobile, $url, $country_id, $address, $postal_code, $status);
        if (!$update)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.error'), null,null);
        }
        return $this->respondGeneral(true, 200, trans('alert.success'), trans('messages.updated'), null, $update);
    }
    //////////////////////////////////////////////
    public function getDelete($id)
    {
        $id = $this->decrypt($id);
        ///////////////////////////
        $supplier = new Supplier();
        $info = $supplier->getSupplier($id);
        if (!$info)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.not_found'), null,null);
        }
        $delete = $supplier->deleteSupplier($info);
        if (!$delete)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.error'), null,null);
        }
        return $this->respondGeneral(true, 200, trans('alert.success'), trans('messages.deleted'), null,null);
    }
    /////////////////////////////////
    public function postSupplierInfo(Request $request)
    {
        $supplier_id = $request->get('supplier_id');
        ////////////////////////////////
        $supplier = new Supplier();
        $info = $supplier->getSupplier($supplier_id);
        if (!$info)
        {
            return response()->json(['status' => 'error', 'message' => null, 'suppliers' => null]);
        }
        return response()->json(['status' => 'success', 'message' => null, 'suppliers' => $info]);
    }
}
