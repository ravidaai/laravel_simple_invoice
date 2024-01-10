<?php

namespace App\Exports;

use App\Models\Invoice;
use App\Models\InvoicePayment;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

/**
 * Class InvoiceExport
 * @package App\Exports
 *
 * @property $filter
 */

class InvoiceExport implements FromView,ShouldAutoSize, WithEvents
{
    use Exportable;
    /**
     * ClientsExport constructor.
     * @param $filter
     */
    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    public function view(): View
    {
        $invoice_id = 0;
        //////////////////////////////////////////////////////
        if(array_key_exists("invoice_id", $this->filter)) {
            if($this->filter['invoice_id'] != "") {
                ////////////////////////////////////
                $invoice_id = $this->filter['invoice_id'];
            }
        }
        $invoice_payment = new InvoicePayment();
        $invoice = new Invoice();
        $data['info'] = $invoice->getInvoice($invoice_id);
        $data['paid_amount'] = $invoice_payment->sumPaymentsByInvoice($invoice_id);
        return view('admin.invoices.invoice', $data);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event)
            {
                $event->sheet->getDelegate()->getParent()->getDefaultStyle()->getFont()->setSize(14);
                $event->sheet->getDelegate()->getParent()->getDefaultStyle()->getAlignment()->setHorizontal('center');
            },
        ];
    }
}

