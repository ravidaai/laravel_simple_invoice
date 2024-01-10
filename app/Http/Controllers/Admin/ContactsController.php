<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/13/2019
 * Time: 2:19 PM
 */

namespace App\Http\Controllers\Admin;


use App\Models\City;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ContactsController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'contacts';
    }
    //////////////////////////
    public function getIndex()
    {
        return view('admin.contacts.view', parent::$data);
    }
    /////////////////////////////////////////
    public function getList(Request $request)
    {
        $contact = new Contact();

        $length = $request->get('length');
        $start = $request->get('start');
        $name = $request->get('name');

        $info = $contact->getContactsPaginated($start, $length, $name);
        $count = $contact->countContactsPaginated($name);
        $datatable = Datatables::of($info)->setTotalRecords($count);

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

            return view('admin.contacts.parts.status', $data)->render();
        });

        $datatable->addColumn('actions', function ($row)
        {
            $data['id_hash'] = $row->id_hash;
            $data['btn_edit'] = parent::$data['btn_edit'];

            return view('admin.contacts.parts.actions', $data)->render();
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

        return view('admin.contacts.add', parent::$data);
    }
    /////////////////////////////////////////
    public function postAdd(Request $request)
    {
        $name = $request->get('name');
        $display_name = $request->get('display_name');
        $company_id = $request->get('company_id');
        $email = $request->get('email');
        $mobile = $request->get('mobile');
        $url = $request->get('url');
        $country_id = $request->get('country_id');
        $city_id = $request->get('city_id');
        $address = $request->get('address');
        $postal_code = $request->get('postal_code');
        $status = (int)$request->get('status');

        $validator = Validator::make([
            'name' => $name,
            'display_name' => $display_name,
            'company_id' => $company_id,
            'email' => $email,
            'mobile' => $mobile,
            'url' => $url,
            'country_id' => $country_id,
            'city_id' => $city_id,
            'address' => $address,
            'postal_code' => $postal_code,
            'status' => $status
        ], [
            'name' => 'required|unique:contacts,name,0,id,deleted_at,NULL',
            'display_name' => 'required',
            'company_id' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'url' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
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
        $contact = new Contact();
        $add = $contact->addContact($name, $display_name, $company_id, $email, $mobile, $url, $country_id, $city_id, $address, $postal_code, $status);
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

        $contact = new Contact();
        $country = new Country();
        $city = new City();
        $company = new Company();
        $info = $contact->getContact($id);
        if (!$info)
        {
            $request->session()->flash('danger', trans('messages.not_found'));
            return redirect(route('admin.contacts.view'));
        }
        parent::$data['info'] = $info;
        parent::$data['countries'] = $country->getAllCountriesActive();
        parent::$data['cities'] = $city->getAllCitiesActive();
        parent::$data['companies'] = $company->getAllCompaniesActive();

        return view('admin.contacts.edit', parent::$data);
    }
    ///////////////////////////////////////////////
    public function postEdit(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $contact = new Contact();
        $info = $contact->getContact($id);
        if (!$info)
        {
            return $this->respondGeneral(true, 500, trans('alert.success'), trans('messages.not_found'), null,null);
        }

        $name = $request->get('name');
        $display_name = $request->get('display_name');
        $company_id = $request->get('company_id');
        $email = $request->get('email');
        $mobile = $request->get('mobile');
        $url = $request->get('url');
        $country_id = $request->get('country_id');
        $city_id = $request->get('city_id');
        $address = $request->get('address');
        $postal_code = $request->get('postal_code');
        $status = (int)$request->get('status');

        $validator = Validator::make([
            'name' => $name,
            'display_name' => $display_name,
            'company_id' => $company_id,
            'email' => $email,
            'mobile' => $mobile,
            'url' => $url,
            'country_id' => $country_id,
            'city_id' => $city_id,
            'address' => $address,
            'postal_code' => $postal_code,
            'status' => $status
        ], [
            'name' => 'required|unique:contacts,name,' . $id . ',id,deleted_at,NULL',
            'display_name' => 'required',
            'company_id' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'url' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
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
        $update = $contact->updateContact($info, $name, $display_name, $company_id, $email, $mobile, $url, $country_id, $city_id, $address, $postal_code, $status);
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
        $contact = new Contact();
        $info = $contact->getContact($id);
        if (!$info)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.not_found'), null,null);
        }
        $delete = $contact->deleteContact($info);
        if (!$delete)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.error'), null,null);
        }
        return $this->respondGeneral(true, 200, trans('alert.success'), trans('messages.deleted'), null,null);
    }
    /////////////////////////////////
    public function postContactInfo(Request $request)
    {
        $contact_id = $request->get('contact_id');
        ////////////////////////////////
        $contact = new Contact();
        $info = $contact->getContact($contact_id);
        if (!$info)
        {
            return response()->json(['status' => 'error', 'message' => null, 'companies' => null]);
        }
        return response()->json(['status' => 'success', 'message' => null, 'contacts' => $info]);
    }
}
