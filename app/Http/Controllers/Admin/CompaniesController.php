<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/13/2019
 * Time: 2:17 PM
 */

namespace App\Http\Controllers\Admin;


use App\Models\City;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class CompaniesController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'companies';
    }
    //////////////////////////
    public function getIndex()
    {
        return view('admin.companies.view', parent::$data);
    }
    /////////////////////////////////////////
    public function getList(Request $request)
    {
        $company = new Company();

        $length = $request->get('length');
        $start = $request->get('start');
        $name = $request->get('name');

        $info = $company->getCompaniesPaginated($start, $length, $name);
        $count = $company->countCompaniesPaginated($name);
        $datatable = Datatables::of($info)->setTotalRecords($count);

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

            return view('admin.companies.parts.status', $data)->render();
        });

        $datatable->addColumn('actions', function ($row)
        {
            $data['id_hash'] = $row->id_hash;
            $data['btn_edit'] = parent::$data['btn_edit'];

            return view('admin.companies.parts.actions', $data)->render();
        });
        $datatable->escapeColumns(['*']);
        return $datatable->make(true);
    }
    ////////////////////////
    public function getAdd()
    {
        $country = new Country();
        $city = new City();
        parent::$data['countries'] = $country->getAllCountriesActive();
        parent::$data['cities'] = $city->getAllCitiesActive();

        return view('admin.companies.add', parent::$data);
    }
    /////////////////////////////////////////
    public function postAdd(Request $request)
    {
        $name = $request->get('name');
        $country_id = $request->get('country_id');
        $city_id = $request->get('city_id');
        $tax_number = $request->get('tax_number');
        $tax_value = $request->get('tax_value');
        $image = $request->file('image');
        $status = (int)$request->get('status');

        $validator = Validator::make([
            'name' => $name,
            'country_id' => $country_id,
            'city_id' => $city_id,
            'tax_number' => $tax_number,
            'tax_value' => $tax_value,
            'image' => $image,
            'status' => $status
        ], [
            'name' => 'required|unique:companies,name,0,id,deleted_at,NULL',
            'country_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'tax_number' => 'required|numeric',
            'tax_value' => 'required|numeric',
            'image' => 'required|image',
            'status' => 'required|numeric|in:0,1'
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), $validator->messages()->first(), null,null);
        }
        ////////////////////////
        $image_name = '';
        if ($request->hasFile('image') && $image->isValid())
        {
            $destinationPath = 'uploads/companies/';
            $image_name = 'image_' . strtotime(date("Y-m-d H:i:s")) . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $image_name);
            $img = Image::make('uploads/companies/' . $image_name);
            $img->resize(203,50);
            $img->save();
        }
        ////////////////////////
        $company = new Company();
        $add = $company->addCompany($name, $country_id, $city_id, $tax_number, $tax_value, $image_name, $status);
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

        $company = new Company();
        $country = new Country();
        $city = new City();
        $info = $company->getCompany($id);
        if (!$info)
        {
            $request->session()->flash('danger', trans('messages.not_found'));
            return redirect(route('admin.companies.view'));
        }
        parent::$data['info'] = $info;
        parent::$data['countries'] = $country->getAllCountriesActive();
        parent::$data['cities'] = $city->getAllCitiesActive();

        return view('admin.companies.edit', parent::$data);
    }
    ///////////////////////////////////////////////
    public function postEdit(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $company = new Company();
        $info = $company->getCompany($id);
        if (!$info)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.not_found'), null,null);
        }
        $db_image = $info->logo;

        $name = $request->get('name');
        $country_id = $request->get('country_id');
        $city_id = $request->get('city_id');
        $tax_number = $request->get('tax_number');
        $tax_value = $request->get('tax_value');
        $image = $request->file('image');
        $status = (int)$request->get('status');

        $validator = Validator::make([
            'name' => $name,
            'country_id' => $country_id,
            'city_id' => $city_id,
            'tax_number' => $tax_number,
            'tax_value' => $tax_value,
            'image' => $image,
            'status' => $status
        ], [
            'name' => 'required|unique:companies,name,' . $id . ',id,deleted_at,NULL',
            'country_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'tax_number' => 'required|numeric',
            'tax_value' => 'required|numeric',
            'image' => 'nullable|image',
            'status' => 'required|numeric|in:0,1'
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), $validator->messages()->first(), null,null);
        }
        ////////////////////////////
        if ($request->hasFile('image') && $image->isValid())
        {
            @unlink(@'uploads/companies/' . $db_image);
            ///////////////////////////////////////////////
            $destinationPath = 'uploads/companies/';
            $image_name = 'image_' . strtotime(date("Y-m-d H:i:s")) . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $image_name);
            $img = Image::make('uploads/companies/' . $image_name);
            $img->resize(203,50);
            $img->save();
        }
        else
        {
            $image_name = $db_image;
        }
        ////////////////////////////
        $update = $company->updateCompany($info, $name, $country_id, $city_id, $tax_number, $tax_value, $image_name, $status);
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
        $company = new Company();
        $info = $company->getCompany($id);
        if (!$info)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.not_found'), null,null);
        }
        $delete = $company->deleteCompany($info);
        if (!$delete)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.error'), null,null);
        }
        return $this->respondGeneral(true, 200, trans('alert.success'), trans('messages.deleted'), null,null);
    }
    /////////////////////////////////
    public function postCompanyInfo(Request $request)
    {
        $company_id = $request->get('company_id');
        ////////////////////////////////
        $company = new Company();
        $info = $company->getCompanyInfo($company_id);
        if (!$info)
        {
            return response()->json(['status' => 'success', 'message' => null, 'companies' => null]);
        }
        return response()->json(['status' => 'success', 'message' => null, 'companies' => $info]);
    }
    /////////////////////////////////
    public function postTaxInfo(Request $request)
    {
        $tax = 0;
        $company_id = $request->get('company_id');
        $contact_id = $request->get('contact_id');
        ////////////////////////////////
        $company = new Company();
        $company_info = $company->getCompanyInfo($company_id);
        if (!$company_info)
        {
            return response()->json(['status' => 'error', 'message' => null, 'companies' => null]);
        }
        $contact = new Contact();
        $contact_info = $contact->getContact($contact_id);
        if (!$contact_info)
        {
            return response()->json(['status' => 'error', 'message' => null, 'companies' => null]);
        }
        ////////////////////////////////////////
        $company_country_id = $company_info->country_id;
        $contact_country_id = $contact_info->country_id;
        if($company_country_id == $contact_country_id)
        {
            $tax = $company_info->tax_value;
        }
        //////////////////////////////////////
        return response()->json(['status' => 'success', 'message' => null, 'tax' => $tax]);
    }
}
