<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/12/2019
 * Time: 12:20 PM
 */

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Invoice;
use App\Models\Company;
use App\Models\Contact;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InvoiceExport;

class DashboardController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'dashboard';
    }
    //////////////////////////
    public function getIndex()
    {
        //$filter = ['invoice_id' => 95];
        //return (new InvoiceExport($filter))->download('invoice.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        $invoice = new Invoice();
        $contact = new Contact();
        $company = new Company();
        parent::$data['no_of_invoices'] = $invoice->countInvoicesDashboard();
        parent::$data['no_of_paid_invoices'] = $invoice->countInvoicesDashboard(1);
        parent::$data['no_of_unpaid_invoices'] = $invoice->countInvoicesDashboard(0);
        parent::$data['no_of_contact'] = $contact->countContactsDashboard();
        parent::$data['total_of_invoices'] = $invoice->sumInvoicesDashboard();
        parent::$data['total_of_paid_invoices'] = $invoice->sumInvoicesDashboard(1);
        parent::$data['total_of_unpaid_invoices'] = $invoice->sumInvoicesDashboard(0);
        parent::$data['no_of_company'] = $company->countCompaniesDashboard();
        return view('admin.dashboard.view', parent::$data);
    }
    ////////////////////////////
    public function getProfile()
    {
        $id = Auth::guard('admin')->user()->id;
        $user = new User();
        parent::$data['info'] = $user->getUser($id);
        return view('admin.dashboard.profile', parent::$data);
    }
    /////////////////////////////////////////////
    public function postProfile(Request $request)
    {
        $id = Auth::guard('admin')->user()->id;
        $user = new User();
        $info = $user->getUser($id);
        if (!$info)
        {
            Session::flash('danger', trans('messages.not_found'));
            return redirect(route('admin.dashboard.profile'));
        }
        $name = $request->get('name');
        $email = $request->get('email');

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
        ], [
            'name' => 'required',
            'email' => 'required',
        ]);
        ///////////////////////
        if ($validator->fails())
        {
            $request->session()->flash('danger', $validator->messages());
            return redirect(route('admin.dashboard.profile'))->withInput();
        }
        $update = $user->updateProfile($info, $name, $email);
        if (!$update)
        {
            Session::flash('danger', trans('messages.error'));
            return redirect(route('admin.dashboard.profile'));
        }
        Session::flash('success', trans('messages.updated'));
        return redirect(route('admin.dashboard.profile'));
    }
    /////////////////////////////
    public function getPassword()
    {
        $id = Auth::guard('admin')->user()->id;
        $user = new User();
        parent::$data['info'] = $user->getUser($id);
        return view('admin.dashboard.password', parent::$data);
    }
    //////////////////////////////////////////////
    public function postPassword(Request $request)
    {
        $id = Auth::guard('admin')->user()->id;
        $user = new User();
        $info = $user->getUser($id);
        if (!$info)
        {
            Session::flash('danger', trans('messages.error'));
            return redirect(route('admin.dashboard.password'));
        }
        $db_password = $info->password;

        $old_password = $request->get('old_password');
        $password = $request->get('password');
        $password_confirmation = $request->get('password_confirmation');

        $validator = Validator::make([
            'old_password' => $old_password,
            'password' => $password,
            'password_confirmation' => $password_confirmation
        ], [
            'old_password' => 'required',
            'password' => 'required|between:6,16|alpha_dash|confirmed',
            'password_confirmation' => 'required|between:6,16'
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            $request->session()->flash('danger', $validator->messages());
            return redirect(route('admin.dashboard.password'))->withInput();
        }
        if (!Hash::check($old_password, $db_password))
        {
            Session::flash('danger', trans('messages.password'));
            return redirect(route('admin.dashboard.password'));
        }
        $save = $user->updatePassword($id, Hash::make($password));
        if (!$save)
        {
            Session::flash('danger', trans('messages.error'));
            return redirect(route('admin.dashboard.password'));
        }
        Session::flash('success', trans('messages.changed'));
        return redirect(route('admin.dashboard.logout'));
    }
}