<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/13/2019
 * Time: 1:29 PM
 */

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PaymentsController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'payments';
    }
    //////////////////////////
    public function getIndex()
    {
        return view('admin.payments.view', parent::$data);
    }
    /////////////////////////////////////////
    public function getList(Request $request)
    {
        $payment = new Payment();

        $length = $request->get('length');
        $start = $request->get('start');
        $name = $request->get('name');

        $info = $payment->getPaymentsPaginated($start, $length, $name);
        $count = $payment->countPaymentsPaginated($name);
        $datatable = Datatables::of($info)->setTotalRecords($count);

        $datatable->editColumn('status', function ($row)
        {
            $data['id'] = $row->id;
            $data['status'] = $row->status;

            return view('admin.payments.parts.status', $data)->render();
        });

        $datatable->addColumn('actions', function ($row)
        {
            $data['id_hash'] = $row->id_hash;
            $data['btn_edit'] = parent::$data['btn_edit'];

            return view('admin.payments.parts.actions', $data)->render();
        });
        $datatable->escapeColumns(['*']);
        return $datatable->make(true);
    }
    ////////////////////////
    public function getAdd()
    {
        $company = new Company();
        parent::$data['companies'] = $company->getAllCompaniesActive();

        return view('admin.payments.add', parent::$data);
    }
    /////////////////////////////////////////
    public function postAdd(Request $request)
    {
        $name = $request->get('name');
        $iban = $request->get('iban');
        $swift_code = $request->get('swift_code');
        $address = $request->get('address');
        $company_id = $request->get('company_id');
        $status = (int)$request->get('status');

        $validator = Validator::make([
            'name' => $name,
            'iban' => $iban,
            'swift_code' => $swift_code,
            'address' => $address,
            'company_id' => $company_id,
            'status' => $status
        ], [
            'name' => 'required|unique:company_payments,name,0,id,deleted_at,NULL',
            'iban' => 'required',
            'swift_code' => 'required',
            'address' => 'required',
            'company_id' => 'required|numeric',
            'status' => 'required|numeric|in:0,1'
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), $validator->messages()->first(), null,null);
        }
        //////////////////////////
        $payment = new Payment();
        $add = $payment->addPayment($name, $iban, $swift_code, $address, $company_id, $status);
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

        $payment = new Payment();
        $company = new Company();
        $info = $payment->getPayment($id);
        if (!$info)
        {
            $request->session()->flash('danger', trans('messages.not_found'));
            return redirect(route('admin.payments.view'));
        }
        parent::$data['info'] = $info;
        parent::$data['companies'] = $company->getAllCompaniesActive();
        return view('admin.payments.edit', parent::$data);
    }
    ///////////////////////////////////////////////
    public function postEdit(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $payment = new Payment();
        $info = $payment->getPayment($id);
        if (!$info)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.not_found'), null,null);
        }

        $name = $request->get('name');
        $iban = $request->get('iban');
        $swift_code = $request->get('swift_code');
        $address = $request->get('address');
        $company_id = $request->get('company_id');
        $status = (int)$request->get('status');

        $validator = Validator::make([
            'name' => $name,
            'iban' => $iban,
            'swift_code' => $swift_code,
            'address' => $address,
            'company_id' => $company_id,
            'status' => $status
        ], [
            'name' => 'required|unique:company_payments,name,' . $id . ',id,deleted_at,NULL',
            'iban' => 'required',
            'swift_code' => 'required',
            'address' => 'required',
            'company_id' => 'required|numeric',
            'status' => 'required|numeric|in:0,1'
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), $validator->messages()->first(), null,null);
        }
        //////////////////////////////////////////////////////////
        $update = $payment->updatePayment($info, $name, $iban, $swift_code, $address, $company_id, $status);
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
        $payment = new Payment();
        $info = $payment->getPayment($id);
        if (!$info)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.not_found'), null,null);
        }
        $delete = $payment->deletePayment($info);
        if (!$delete)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.error'), null,null);
        }
        return $this->respondGeneral(true, 200, trans('alert.success'), trans('messages.deleted'), null,null);
    }
}