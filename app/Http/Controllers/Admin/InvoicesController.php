<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/23/2019
 * Time: 1:09 PM
 */

namespace App\Http\Controllers\Admin;


use App\Models\City;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Invoice;
use App\Models\InvoiceAttachment;
use App\Models\InvoiceItem;
use App\Models\InvoicePayment;
use App\Models\Item;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class InvoicesController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        parent::$data['active_menu'] = 'invoices';
    }
    //////////////////////////
    public function getIndex()
    {
        return view('admin.invoices.view', parent::$data);
    }
    /////////////////////////////////////////
    public function getList(Request $request)
    {
        $invoice = new Invoice();

        $length = $request->get('length');
        $start = $request->get('start');
        $number = $request->get('number');

        $info = $invoice->getInvoicesPaginated($start, $length, $number);
        $count = $invoice->countInvoicesPaginated($number);
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
    ////////////////////////
    public function getAdd()
    {
        $country = new Country();
        $city = new City();
        $contact = new Contact();
        $company = new Company();
        $currency = new Currency();
        $items = new Item();
        $invoice = new Invoice();
        $invoice_number = $invoice->getLastInvoiceNumber();
        parent::$data['invoice_number'] = $invoice_number == null ? 1 : $invoice_number->number + 1;
        parent::$data['countries'] = $country->getAllCountriesActive();
        parent::$data['cities'] = $city->getAllCitiesActive();
        parent::$data['contacts'] = $contact->getAllContactsActive();
        parent::$data['companies'] = $company->getAllCompaniesActive();
        parent::$data['currencies'] = $currency->getAllCurrenciesActive();
        parent::$data['items'] = $items->getAllItemsActive();

        return view('admin.invoices.add', parent::$data);
    }
    ////////////////////////
    public function postAdd(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'contact_id' => 'required|numeric',
            'company_id' => 'required|numeric',
            'currency_id' => 'required|numeric',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'number' => 'required|numeric',
            'studio' => 'required|numeric|in:0,1',
            'invoice_discount' => 'required|numeric',
            'items.item_id.*' => 'required|numeric',
            'items.description.*' => 'required',
            'items.quantity.*' => 'required|numeric',
            'items.price.*' => 'required|numeric',
        ]);
        //////////////////////////////////////////////////
        $invoice = new Invoice();
        $invoice_info = $invoice->getLastInvoiceNumber();
        $invoice_number = $invoice_info == null ? 1 : $invoice_info->number + 1;
        /////////////////////////////////////////////////
        $data = [
            'contact_id' => $request->get('contact_id'),
            'company_id' => $request->get('company_id'),
            'currency_id' => $request->get('currency_id'),
            'invoice_date' => $request->get('invoice_date'),
            'due_date' => $request->get('due_date'),
            'number' => $invoice_number,
            'discount' => $request->get('invoice_discount'),
            'terms' => $request->get('terms'),
            'note' => $request->get('note'),
            'items' => $request->get('items'),
            'studio' => $request->get('studio')
        ];
        ////////////////////////////////////////
        $tax = 0;
        $company = new Company();
        $company_info = $company->getCompanyInfo($data['company_id']);
        if (!$company_info)
        {
            return response()->json(['status' => true, 'code' => 500, 'type' => 'error', 'message' => trans('messages.error')]);
        }
        //////////////////////////////////////
        $contact = new Contact();
        $contact_info = $contact->getContact($data['contact_id']);
        if (!$contact_info)
        {
            return response()->json(['status' => true, 'code' => 500, 'type' => 'error', 'message' => trans('messages.error')]);
        }
        ////////////////////////////////////////
        $company_country_id = $company_info->country_id;
        $contact_country_id = $contact_info->country_id;
        if($company_country_id == $contact_country_id)
        {
            $tax = $company_info->tax_value;
        }
        ////////////////////////////////////////
        if ($validator->fails())
        {
            return response()->json(['status' => true, 'code' => 500, 'type' => 'error', 'message' => $validator->messages()->first()]);
        }
        ////////////////////////
        $sub_total = 0;
        $total_tax = 0;
        if(!is_null($data['items']) && is_array($data['items']))
        {
            for ($i=0; $i<count($data['items']['item_id']); $i++)
            {
                $price = $data['items']['price'][$i];
                $quantity = $data['items']['quantity'][$i];
                ///////////////////////////////////////////
                $tax_item = round( ($quantity * $price) * ($tax / 100),2);
                $sub_total += ($quantity * $price) + $tax_item;
                $total_tax += $tax_item;
            }
        }
        $data = array_merge($data, [
            'subtotal' => $sub_total,
            'total' => $sub_total - $data['discount'],
            'tax_percentage' => $tax,
            'tax' => $total_tax,
        ]);
        ///////////////////////////////////
        $invoice = new Invoice();
        $add = $invoice->addInvoice($data);
        if (!$add)
        {
            return response()->json(['status' => true, 'code' => 500, 'type' => 'error', 'message' => trans('messages.error')]);
        }
        if(!is_null($data['items']) && is_array($data['items']))
        {
            for ($i=0; $i<count($data['items']['item_id']); $i++)
            {
                $item_id = $data['items']['item_id'][$i];
                $description = $data['items']['description'][$i];
                $price = $data['items']['price'][$i];
                $quantity = $data['items']['quantity'][$i];
                ///////////////////////////////////////////
                $tax_item = round( ($quantity * $price) * ($tax / 100),2);
                $total = ($quantity * $price) + $tax_item;
                /////////////////////////////////////////
                $data_info = [
                  'invoice_id' => $add->id,
                  'item_id' => $item_id,
                  'description' => $description,
                  'quantity' => $quantity,
                  'price' => $price,
                  'tax' => $tax_item,
                  'total' => $total,
                ];
                $invoice_item = new InvoiceItem();
                $invoice_item->addInvoiceItem($data_info);
            }
        }
        parent::sendEmail($contact_info->email,$contact_info->name,"Pdf Invoice");
        return response()->json(['status' => true, 'code' => 200, 'type' => 'error', 'message' => trans('messages.added')]);
    }
    ////////////////////////
    public function getEdit(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $invoice = new Invoice();
        $country = new Country();
        $city = new City();
        $contact = new Contact();
        $company = new Company();
        $currency = new Currency();
        $item = new Item();
        $info = $invoice->getInvoice($id);
        if (!$info)
        {
            $request->session()->flash('danger', trans('messages.not_found'));
            return redirect(route('admin.invoices.view'));
        }
        parent::$data['info'] = $info;
        parent::$data['cities'] = $city->getAllCitiesActive();
        parent::$data['countries'] = $country->getAllCountriesActive();
        parent::$data['contacts'] = $contact->getAllContactsActive();
        parent::$data['companies'] = $company->getAllCompaniesActive();
        parent::$data['currencies'] = $currency->getAllCurrenciesActive();
        parent::$data['items'] = $item->getAllItemsActive();
        parent::$data['active_sub_menu'] = 'edit';
        parent::$data['tax'] = 0;
        $contact_country_id = optional($info->contact)->country_id;
        $company_country_id = optional($info->company)->country_id;
        if($contact_country_id == $company_country_id)
        {
            parent::$data['tax'] = optional($info->company)->tax_value;
        }

        return view('admin.invoices.edit', parent::$data);
    }
    ////////////////////////
    public function postEdit(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $invoice = new Invoice();
        $info = $invoice->getInvoice($id);
        if (!$info)
        {
            $request->session()->flash('danger', trans('messages.not_found'));
            return redirect(route('admin.invoices.view'));
        }
        /////////////////////////////////////////////////////
        $validator = Validator::make($request->all(),[
            'contact_id' => 'required|numeric',
            'company_id' => 'required|numeric',
            'currency_id' => 'required|numeric',
            'studio' => 'required|numeric|in:0,1',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'invoice_discount' => 'required|numeric',
            'items.item_id.*' => 'required|numeric',
            'items.description.*' => 'required|numeric',
            'items.quantity.*' => 'required|numeric',
            'items.price.*' => 'required|numeric',
        ]);
        //////////////////////////////////////////////////
        $data = [
            'contact_id' => $request->get('contact_id'),
            'company_id' => $request->get('company_id'),
            'currency_id' => $request->get('currency_id'),
            'invoice_date' => $request->get('invoice_date'),
            'due_date' => $request->get('due_date'),
            'discount' => $request->get('invoice_discount'),
            'terms' => $request->get('terms'),
            'note' => $request->get('note'),
            'items' => $request->get('items'),
            'studio' => $request->get('studio')
        ];
        ////////////////////////////////////////
        $tax = 0;
        $company = new Company();
        $company_info = $company->getCompanyInfo($data['company_id']);
        if (!$company_info)
        {
            return response()->json(['status' => true, 'code' => 500, 'type' => 'error', 'message' => trans('messages.error')]);
        }
        //////////////////////////////////////
        $contact = new Contact();
        $contact_info = $contact->getContact($data['contact_id']);
        if (!$contact_info)
        {
            return response()->json(['status' => true, 'code' => 500, 'type' => 'error', 'message' => trans('messages.error')]);
        }
        ////////////////////////////////////////
        $company_country_id = $company_info->country_id;
        $contact_country_id = $contact_info->country_id;
        if($company_country_id == $contact_country_id)
        {
            $tax = $company_info->tax_value;
        }
        ////////////////////////////////////////
        if ($validator->fails())
        {
            return response()->json(['status' => true, 'code' => 500, 'type' => 'error', 'message' => $validator->messages()->first()]);
        }
        ////////////////////////
        $sub_total = 0;
        $total_tax = 0;
        if(!is_null($data['items']) && is_array($data['items']))
        {
            for ($i=0; $i<count($data['items']['item_id']); $i++)
            {
                $price = $data['items']['price'][$i];
                $quantity = $data['items']['quantity'][$i];
                ///////////////////////////////////////////
                $tax_item = round( ($quantity * $price) * ($tax / 100),2);
                $sub_total += ($quantity * $price) + $tax_item;
                $total_tax += $tax_item;
            }
        }
        $data = array_merge($data, [
            'subtotal' => $sub_total,
            'total' => $sub_total - $data['discount'],
            'tax_percentage' => $tax,
            'tax' => $total_tax,
        ]);
        ///////////////////////////////////
        $invoice = new Invoice();
        $edit = $invoice->updateInvoice($id,$data);
        if (!$edit)
        {
            return response()->json(['status' => true, 'code' => 500, 'type' => 'error', 'message' => trans('messages.error')]);
        }
        ///////////////////////////////////
        $invoice_item = new InvoiceItem();
        $invoice_item->deleteInvoiceItemByInvoiceId($id);
        //////////////////////////////////
        if(!is_null($data['items']) && is_array($data['items']))
        {
            for ($i=0; $i<count($data['items']['item_id']); $i++)
            {
                $item_id = $data['items']['item_id'][$i];
                $description = $data['items']['description'][$i];
                $price = $data['items']['price'][$i];
                $quantity = $data['items']['quantity'][$i];
                ///////////////////////////////////////////
                $tax_item = round( ($quantity * $price) * ($tax / 100),2);
                $total = ($quantity * $price) + $tax_item;
                /////////////////////////////////////////
                $data_info = [
                    'invoice_id' => $id,
                    'item_id' => $item_id,
                    'description' => $description,
                    'quantity' => $quantity,
                    'price' => $price,
                    'tax' => $tax_item,
                    'total' => $total,
                ];
                $invoice_item = new InvoiceItem();
                $invoice_item->addInvoiceItem($data_info);
            }
        }
        return response()->json(['status' => true, 'code' => 200, 'type' => 'error', 'message' => trans('messages.added')]);
    }
    ////////////////////////
    public function getAttachmentList(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $invoice_attachment = new InvoiceAttachment();

        $length = $request->get('length');
        $start = $request->get('start');

        $info = $invoice_attachment->getInvoiceAttachmentsPaginated($start, $length, $id);
        $count = $invoice_attachment->countInvoiceAttachmentsPaginated($id);
        $datatable = Datatables::of($info)->setTotalRecords($count);

        $datatable->editColumn('attachment', function ($row)
        {
            $data['attachment'] = $row->attachment;

            return view('admin.invoices.parts.file', $data)->render();
        });

        $datatable->addColumn('actions', function ($row)
        {
            $data['id_hash'] = $row->id_hash;
            $data['btn_edit'] = parent::$data['btn_edit'];

            return view('admin.invoices.parts.delete_attachments', $data)->render();
        });
        $datatable->escapeColumns(['*']);
        return $datatable->make(true);
    }
    ////////////////////////
    public function getAttachment(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $invoice = new Invoice();
        $info = $invoice->getInvoice($id);
        if (!$info)
        {
            $request->session()->flash('danger', trans('messages.not_found'));
            return redirect(route('admin.invoices.view'));
        }
        parent::$data['info'] = $info;
        parent::$data['active_sub_menu'] = 'attachment';

        return view('admin.invoices.attachments', parent::$data);
    }
    ////////////////////////
    public function postAttachment(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $attachment = $request->file('attachment');
        $validator = Validator::make([
            'attachment' => $attachment,
        ], [
            'attachment' => 'required',
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return response()->json(['status' => true, 'code' => 500, 'type' => 'error', 'message' => $validator->messages()->first()]);
        }
        /////////////////////////////////////////////////////////
        if ($request->hasFile('attachment') && $attachment->isValid())
        {
            $destinationPath = 'uploads/invoices_attachments/';
            $attachment_name = 'attachment_' . rand(1, 10000) .'_' . strtotime(date("Y-m-d H:i:s")) . '.' . $attachment->getClientOriginalExtension();
            $attachment->move($destinationPath, $attachment_name);
            //////////////////////////////////////////
            $invoice_attachment = new InvoiceAttachment();
            $add = $invoice_attachment->addInvoiceAttachments($id, $attachment_name);
            if (!$add)
            {
                return response()->json(['status' => true, 'code' => 500, 'type' => 'error', 'message' => trans('messages.error')]);
            }
            return response()->json(['status' => true, 'code' => 200, 'type' => 'success', 'message' => trans('messages.added')]);
        }
        return response()->json(['status' => true, 'code' => 500, 'type' => 'error', 'message' => trans('messages.error')]);
    }
    ////////////////////////
    public function postDeleteAttachment($id)
    {
        $id = $this->decrypt($id);
        ///////////////////////////
        $invoice_attachment = new InvoiceAttachment();
        $info = $invoice_attachment->getInvoiceAttachment($id);
        if (!$info)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.not_found'), null,null);
        }
        $delete = $invoice_attachment->deleteInvoiceAttachments($info);
        if (!$delete)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.error'), null,null);
        }
        return $this->respondGeneral(true, 200, trans('alert.success'), trans('messages.deleted'), null,null);
    }
    ////////////////////////
    public function getDelete($id)
    {
        $id = $this->decrypt($id);
        ///////////////////////////
        $invoice = new Invoice();
        $info = $invoice->getInvoice($id);
        if (!$info)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.not_found'), null,null);
        }
        $delete = $invoice->deleteInvoice($info);
        if (!$delete)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.error'), null,null);
        }
        return $this->respondGeneral(true, 200, trans('alert.success'), trans('messages.deleted'), null,null);
    }
    ////////////////////////
    public function getPaymentList(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $invoices_payment = new InvoicePayment();

        $length = $request->get('length');
        $start = $request->get('start');

        $info = $invoices_payment->getPaymentsPaginated($start, $length, $id);
        $count = $invoices_payment->countPaymentsPaginated($id);
        $datatable = Datatables::of($info)->setTotalRecords($count);

        $datatable->editColumn('type', function ($row)
        {
            if ($row->type == '1')
            {
                return 'Cash';
            }
            elseif($row->type == '2')
            {
                return 'Visa';
            }
            else
            {
                return 'Transfer';
            }

        });

        $datatable->editColumn('bank_name', function ($row)
        {
            return (!empty($row->bank_name) ? $row->bank_name : 'N/A');
        });

        $datatable->editColumn('bank_branch', function ($row)
        {
            return (!empty($row->bank_branch) ? $row->bank_branch : 'N/A');
        });

        $datatable->editColumn('transfer_number', function ($row)
        {
            return (!empty($row->transfer_number) ? $row->transfer_number : 'N/A');
        });

        $datatable->addColumn('actions', function ($row)
        {
            $data['id_hash'] = $row->id_hash;
            $data['btn_edit'] = parent::$data['btn_edit'];

            return view('admin.invoices.parts.delete_payments', $data)->render();
        });
        $datatable->escapeColumns(['*']);
        return $datatable->make(true);
    }
    ///////////////////////////
    public function getPayment(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $invoice = new Invoice();
        $info = $invoice->getInvoice($id);
        if (!$info)
        {
            $request->session()->flash('danger', trans('messages.not_found'));
            return redirect(route('admin.invoices.view'));
        }
        parent::$data['info'] = $info;
        parent::$data['active_sub_menu'] = 'payments';

        return view('admin.invoices.payments', parent::$data);
    }
    /////////////////////////////
    public function postPayment(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $validator = Validator::make($request->all(),[
            'amount' => 'required|numeric',
            'type' => 'required|numeric',
            'note' => 'required',
            'bank_name' => 'nullable|required_if:type,3',
            'bank_branch' => 'nullable|required_if:type,3',
            'transfer_number' => 'nullable|required_if:type,3',
        ]);
        ////////////////////////
        if ($validator->fails())
        {
            return response()->json(['status' => true, 'code' => 500, 'type' => 'error', 'message' => $validator->messages()->first()]);
        }
        ///////////////////////////////////////
        $data = [
            'invoice_id' => $id,
            'amount' => $request->get('amount'),
            'type' => $request->get('type'),
            'note' => $request->get('note'),
            'bank_name' => $request->get('bank_name'),
            'bank_branch' => $request->get('bank_branch'),
            'transfer_number' => $request->get('transfer_number'),
        ];
        ///////////////////////////////////////
        $invoice = new Invoice();
        //////////////////////////////////////
        $amount = $request->get('amount');
        //////////////////////////////////////
        $info = $invoice->getInvoice($id);
        if(!$info)
        {
            return response()->json(['status' => false, 'code' => 500, 'type' => 'error', 'message' => "Invoice Not Found"]);
        }
        if($info->paid == 1)
        {
            return response()->json(['status' => false, 'code' => 500, 'type' => 'error', 'message' => "You Can't Add Credit To Paid Invoice"]);
        }
        $total_invoice = $invoice->sumInvoicesByInvoiceId($id);
        ///////////////////////////////////////
        $invoice_payment = new InvoicePayment();
        $total_paid = $invoice_payment->sumPaymentsByInvoice($id);
        if($total_paid + $amount > $total_invoice)
        {
            return response()->json(['status' => true, 'code' => 500, 'type' => 'error', 'message' => 'You can not add credit more than invoice amount']);
        }
        ///////////////////////////////////////////
        if($total_paid + $amount == $total_invoice)
        {
            $invoice = new Invoice();
            $invoice->updateInvoice($id,['paid' => 1]);
        }
        ///////////////////////////////////////
        $invoice_payment = new InvoicePayment();
        $add = $invoice_payment->addInvoicePayments($data);
        if (!$add)
        {
            return response()->json(['status' => true, 'code' => 500, 'type' => 'error', 'message' => trans('messages.error')]);
        }
        return response()->json(['status' => true, 'code' => 200, 'type' => 'success', 'message' => trans('messages.added')]);
    }
    /////////////////////////////
    public function postDeletePayment($id)
    {
        $id = $this->decrypt($id);
        ///////////////////////////
        $invoice_payment = new InvoicePayment();
        $info = $invoice_payment->getInvoicePayment($id);
        if (!$info)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.not_found'), null,null);
        }
        $delete = $invoice_payment->deleteInvoicePayments($info);
        if (!$delete)
        {
            return $this->respondGeneral(true, 500, trans('alert.error'), trans('messages.error'), null,null);
        }
        return $this->respondGeneral(true, 200, trans('alert.success'), trans('messages.deleted'), null,null);
    }
    /////////////////////////////////////////////
    public function getPrint(Request $request, $id)
    {
        $id = $this->decrypt($id);

        $invoice = new Invoice();
        $invoice_payment = new InvoicePayment();
        $info = $invoice->getInvoice($id);
        if (!$info)
        {
            $request->session()->flash('danger', trans('messages.not_found'));
            return redirect(route('admin.invoices.view'));
        }
        parent::$data['info'] = $info;
        parent::$data['active_sub_menu'] = 'print';
        parent::$data['paid_amount'] = $invoice_payment->sumPaymentsByInvoice($id);

        return view('admin.invoices.invoice', parent::$data);
    }
}