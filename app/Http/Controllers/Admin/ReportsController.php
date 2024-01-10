<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/12/2019
 * Time: 1:03 PM
 */

namespace App\Http\Controllers\Admin;

use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Item;
use App\Models\Contact;
use App\Models\Invoice;

class ReportsController extends AdminController
{
    use ResponseTrait;

    public function __construct()
    {
        parent::__construct();
    }
    //////////////////////////
    public function getItems(Request $request)
    {
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $item_id = $request->get('item_id');
        $contact_id = $request->get('contact_id');
        $studio = $request->get('studio');
        ///////////////////////////////////////
        $item = new Item();
        $contact = new Contact();
        $invoice = new Invoice();
        parent::$data['items'] = $item->getAllItemsActive();
        parent::$data['contacts'] = $contact->getAllContactsActive();
        parent::$data['active_menu'] = 'reports_items';
        parent::$data['no_of_invoices'] = $invoice->countInvoicesStatistics($start_date,$end_date,$item_id,$contact_id,$studio,null);
        parent::$data['no_of_paid_invoices'] = $invoice->countInvoicesStatistics($start_date,$end_date,$item_id,$contact_id,$studio,1);
        parent::$data['no_of_unpaid_invoices'] = $invoice->countInvoicesStatistics($start_date,$end_date,$item_id,$contact_id,$studio,0);
        parent::$data['total_of_invoices'] = $invoice->sumInvoicesStatistics($start_date,$end_date,$item_id,$contact_id,$studio,null);
        parent::$data['total_of_paid_invoices'] = $invoice->sumInvoicesStatistics($start_date,$end_date,$item_id,$contact_id,$studio,1);
        parent::$data['total_of_unpaid_invoices'] = $invoice->sumInvoicesStatistics($start_date,$end_date,$item_id,$contact_id,$studio,0);
        ///////////////////////////////////////////////////////
        return view('admin.reports.items', parent::$data);
    }
    /////////////////////////////////////////
    public function getList(Request $request)
    {
        $invoice = new Invoice();
        //////////////////////////////////////
        $length = $request->get('length');
        $start = $request->get('start');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $item_id = $request->get('item_id');
        $contact_id = $request->get('contact_id');
        $studio = $request->get('studio');

        $info = $invoice->getInvoicesReport($start, $length, $start_date, $end_date, $item_id, $contact_id, $studio);
        $count = $invoice->countInvoicesReport($start_date, $end_date, $item_id, $contact_id, $studio);
        $datatable = Datatables::of($info)->setTotalRecords($count);

        $datatable->editColumn('company_id', function ($row)
        {
            return (!empty(optional($row->company)->name) ? optional($row->company)->name : '-');
        });

        $datatable->editColumn('number', function ($row)
        {
            return 'CR-' . str_pad($row->number,7,0,0);
        });

        $datatable->editColumn('contact_id', function ($row)
        {
            return (!empty(optional($row->contact)->name) ? optional($row->contact)->name : '-');
        });

        $datatable->editColumn('paid', function ($row) {
            if ($row->paid == 1)
            {
                return 'Paid';
            }
            else
            {
                return 'Not Paid';
            }
        });

        $datatable->addColumn('actions', function ($row)
        {
            $data['id_hash'] = $row->id_hash;
            $data['btn_edit'] = parent::$data['btn_edit'];

            return view('admin.invoices.parts.actions', $data)->render();
        });
        $datatable->escapeColumns(['*']);
        return $datatable->make(true);
    }
    /////////////////////////////////////////////////
    public function postStatistics(Request $request)
    {
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $item_id = $request->get('item_id');
        $contact_id = $request->get('contact_id');
        $studio = $request->get('studio');
        ///////////////////////////////////////
        $invoice = new Invoice();
        parent::$data['no_of_invoices'] = number_format($invoice->countInvoicesStatistics($start_date,$end_date,$item_id,$contact_id,$studio,null));
        parent::$data['no_of_paid_invoices'] = number_format($invoice->countInvoicesStatistics($start_date,$end_date,$item_id,$contact_id,$studio,1));
        parent::$data['no_of_unpaid_invoices'] = number_format($invoice->countInvoicesStatistics($start_date,$end_date,$item_id,$contact_id,$studio,0));
        parent::$data['total_of_invoices'] = number_format($invoice->sumInvoicesStatistics($start_date,$end_date,$item_id,$contact_id,$studio,null));
        parent::$data['total_of_paid_invoices'] = number_format($invoice->sumInvoicesStatistics($start_date,$end_date,$item_id,$contact_id,$studio,1));
        parent::$data['total_of_unpaid_invoices'] = number_format($invoice->sumInvoicesStatistics($start_date,$end_date,$item_id,$contact_id,$studio,0));
        //////////////////////////////////////
        return $this->generalResponse(true,200,null,null,parent::$data);
    }
}