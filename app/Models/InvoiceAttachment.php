<?php
/**
 * Created by PhpStorm.
 * User: Redwan-PC
 * Date: 3/31/2019
 * Time: 3:43 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceAttachment extends BaseModel
{
    use SoftDeletes;

    protected $table = 'invoice_attachements';

    protected $fillable = [
        'invoice_id', 'attachment',
    ];

    protected $appends = [
        'id_hash', 'humans_date', 'full_path_file'
    ];

    public function getFullPathFileAttribute()
    {
        if($this->type == 2)
        {
            return asset('uploads/invoices_attachments/' . $this->attachment);
        }
        return asset('uploads/invoices_attachments/' . $this->attachment);
    }
    ////////////////////////////////////
    function getInvoiceAttachment($id)
    {
        return $this->find($id);
    }
    ////////////////////////////////////
    function addInvoiceAttachments($invoice_id, $attachment)
    {
        $this->invoice_id = $invoice_id;
        $this->attachment = $attachment;

        $this->save();
        return $this;
    }
    //////////////////////////////////
    function deleteInvoiceAttachments($obj)
    {
        return $obj->delete();
    }
    ///////////////////////////////////
    function getInvoiceAttachmentsPaginated($skip = 0, $take = 5, $invoice_id)
    {
        return $this->where('invoice_id', '=', $invoice_id)->skip($skip)->take($take);
    }
    ///////////////////////////////////////////
    function countInvoiceAttachmentsPaginated($invoice_id)
    {
        return $this->where('invoice_id', '=', $invoice_id)->count('id');
    }
}