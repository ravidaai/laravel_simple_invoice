<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/13/2019
 * Time: 5:10 PM
 */

namespace App\Http\Controllers\Admin;


use App\Models\Branch;
use App\Models\City;
use App\Models\Company;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BranchesController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'branches';
    }
    //////////////////////////
    public function getIndex()
    {
        return view('admin.branches.view', parent::$data);
    }
    /////////////////////////////////////////
    public function getList(Request $request)
    {
        $branch = new Branch();

        $length = $request->get('length');
        $start = $request->get('start');
        $name = $request->get('name');

        $info = $branch->getBranchesPaginated($start, $length, $name);
        $count = $branch->countBranchesPaginated($name);
        $datatable = Datatables::of($info)->setTotalRecords($count);

        $datatable->editColumn('is_primary', function ($row) {
            if ($row->is_primary == 1)
            {
                return 'Yes';
            }
            else
            {
                return 'No';
            }
        });

        $datatable->editColumn('company_id', function ($row)
        {
            return (!empty(optional($row->company)->name) ? optional($row->company)->name : '-');
        });

        $datatable->editColumn('country_id', function ($row)
        {
            return (!empty(optional($row->country)->name) ? optional($row->country)->name : '-');
        });

        $datatable->editColumn('city_id', function ($row)
        {
            return (!empty(optional($row->city)->name) ? optional($row->city)->name : '-');
        });

        $datatable->editColumn('status', function ($row)
        {
            $data['id'] = $row->id;
            $data['status'] = $row->status;

            return view('admin.branches.parts.status', $data)->render();
        });

        $datatable->addColumn('actions', function ($row)
        {
            $data['id_hash'] = $row->id_hash;
            $data['btn_edit'] = parent::$data['btn_edit'];

            return view('admin.branches.parts.actions', $data)->render();
        });
        $datatable->escapeColumns(['*']);
        return $datatable->make(true);
    }
    ////////////////////////
    public function getAdd()
    {
        $country = new Country();
        $city = new City();
        $company = new Company();

        parent::$data['countries'] = $country->getAllCountriesActive();
        parent::$data['cities'] = $city->getAllCitiesActive();
        parent::$data['companies'] = $company->getAllCompaniesActive();

        return view('admin.branches.add', parent::$data);
    }
    /////////////////////////////////////////
    public function postAdd(Request $request)
    {
        $company_id = $request->get('company_id');
        $is_primary = $request->get('is_primary');
        $country_id = $request->get('country_id');
        $city_id = $request->get('city_id');
        $address_one = $request->get('address_one');
        $address_two = $request->get('address_two');
        $postal_code = $request->get('postal_code');
        $status = (int)$request->get('status');

        $validator = Validator::make([
            'company_id' => $company_id,
            'is_primary' => $is_primary,
            'country_id' => $country_id,
            'city_id' => $city_id,
            'address_one' => $address_one,
            'address_two' => $address_two,
            'postal_code' => $postal_code,
            'status' => $status
        ], [
            'company_id' => 'required|numeric',
            'is_primary' => 'required|numeric',
            'country_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'address_one' => 'required',
            'address_two' => 'required',
            'postal_code' => 'required',
            'status' => 'required|numeric|in:0,1'
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), $validator->messages()->first(), null,null);
        }
        //////////////////////////
        $branch = new Branch();
        $add = $branch->addBranch($company_id, $is_primary, $country_id, $city_id, $address_one, $address_two, $postal_code, $status);
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

        $branch = new Branch();

        $city = new City();
        $country = new Country();
        $company = new Company();
        $info = $branch->getBranch($id);
        if (!$info)
        {
            $request->session()->flash('danger', trans('messages.not_found'));
            return redirect(route('admin.branches.view'));
        }
        parent::$data['info'] = $info;
        parent::$data['cities'] = $city->getAllCitiesActive();
        parent::$data['countries'] = $country->getAllCountriesActive();
        parent::$data['companies'] = $company->getAllCompaniesActive();

        return view('admin.branches.edit', parent::$data);
    }
    ///////////////////////////////////////////////
    public function postEdit(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $branch = new Branch();
        $info = $branch->getBranch($id);
        if (!$info)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.not_found'), null,null);
        }

        $company_id = $request->get('company_id');
        $is_primary = $request->get('is_primary');
        $country_id = $request->get('country_id');
        $city_id = $request->get('city_id');
        $address_one = $request->get('address_one');
        $address_two = $request->get('address_two');
        $postal_code = $request->get('postal_code');
        $status = (int)$request->get('status');

        $validator = Validator::make([
            'company_id' => $company_id,
            'is_primary' => $is_primary,
            'country_id' => $country_id,
            'city_id' => $city_id,
            'address_one' => $address_one,
            'address_two' => $address_two,
            'postal_code' => $postal_code,
            'status' => $status
        ], [
            'company_id' => 'required|numeric',
            'is_primary' => 'required|numeric',
            'country_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'address_one' => 'required',
            'address_two' => 'required',
            'postal_code' => 'required',
            'status' => 'required|numeric|in:0,1'
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), $validator->messages()->first(), null,null);
        }
        //////////////////////////////////////////////////////////
        $update = $branch->updateBranch($info, $company_id, $is_primary, $country_id, $city_id, $address_one, $address_two, $postal_code, $status);
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
        $branch = new Branch();
        $info = $branch->getBranch($id);
        if (!$info)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.not_found'), null,null);
        }
        $delete = $branch->deleteBranch($info);
        if (!$delete)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.error'), null,null);
        }
        return $this->respondGeneral(true, 200, trans('alert.success'), trans('messages.deleted'), null,null);
    }
}