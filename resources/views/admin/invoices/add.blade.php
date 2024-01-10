@extends('admin.layout.master')

@section('title')
    New Invoice
@stop

@section('css')
    <style>
        .input-group-prepend {
            position: absolute;
            right: 17px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1;
        }
        .custom-modal {
            border-top-left-radius: 0rem;
            border-top-right-radius: 0.25rem;
            border-bottom-right-radius: 0.25rem;
            border-bottom-left-radius: 0rem;
        }
    </style>
@stop

@section('breadcrumb')
    <div class="mr-auto">
        <h3 class="m-subheader__title m-subheader__title--separator">
            Dashboard
        </h3>
        <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
            <li class="m-nav__item m-nav__item--home">
                <a href="{{ route('admin.invoices.view') }}" class="m-nav__link m-nav__link--icon">
                    <i class="m-nav__link-icon flaticon-placeholder-2"></i>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="{{ route('admin.invoices.view') }}" class="m-nav__link">
                    <span class="m-nav__link-text">
                        Invoice
                    </span>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="{{ route('admin.invoices.add') }}" class="m-nav__link">
                    <span class="m-nav__link-text">
                        New Invoice
                    </span>
                </a>
            </li>
        </ul>
    </div>
@stop


@section('content')
    @include('admin.layout.error')
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        New Invoice
                    </h3>
                </div>
            </div>
        </div>
        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right" id="frmAddInvoice" action="{{ route('admin.invoices.add') }}" method="post">
            <div class="m-portlet__body">
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-2">Contact</label>
                    <div class="col-3">
                        <select class="form-control m-bootstrap-select" data-live-search="true" name="contact_id" id="contact_id">
                            <option value="" {{ old('contact_id') == '' ? 'selected' : '' }}>Select Item</option>
                            @foreach($contacts as $row)
                                <option value="{{ $row->id }}" {{ old('contact_id') == $row->id ? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-prepend">
                            <a href="javascript:;" class="btn btn-brand m-btn-sm custom-modal" data-id="0" id="addNewContact">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <label class="col-form-label col-lg-2">Company</label>
                    <div class="col-3">
                        <select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" id="company_id" name="company_id">
                            <option value="" {{ old('company_id') == '' ? 'selected' : '' }}>Select Item</option>
                            @foreach($companies as $row)
                            <option value="{{ $row->id }}" {{ old('company_id') == $row->id ? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input id="invoice_tax" name="invoice_tax" type="hidden" value="0">
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-2">Invoice Date</label>
                    <div class="col-lg-3">
                        <input type='text' class="form-control m-input m_datepicker" name="invoice_date" value="{{ old('invoice_date') }}" placeholder="Invoice Date"/>
                    </div>
                    <label class="col-form-label col-lg-2">Due Date</label>
                    <div class="col-3">
                        <input type='text' class="form-control m-input m_datepicker" name="due_date" value="{{ old('due_date') }}" placeholder="Due Date"/>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-2">Currency</label>
                    <div class="col-lg-3">
                        <select class="form-control m-bootstrap-select" data-live-search="true" name="currency_id">
                            <option value="" {{ old('currency_id') == '' ? 'selected' : '' }}>Select Item</option>
                            @foreach($currencies as $row)
                                <option value="{{ $row->id }}" {{ old('sign_id') == $row->id ? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label class="col-form-label col-lg-2">Invoice No.</label>
                    <div class="col-lg-3">
                        <input type='text' class="form-control m-input" name="number" value="{{ 'CR-' . str_pad($invoice_number,7,0,0) }}" placeholder="Invoice Number" readonly/>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <div class="col-10 ml-auto">
                        <h3 class="m-form__section">
                            1. Items
                        </h3>
                    </div>
                </div>
                <div id="invoicesContainer">

                </div>
                <div class="form-group m-form__group row">
                    <div class="col-10 ml-auto">
                        <h3 class="m-form__section">
                            2. Details
                        </h3>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-2"></label>
                    <div class="col-8">
                        <table class="table table-striped- table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Subtotal</th>
                                <th>Discount</th>
                                <th>Tax</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <input type='text' class="form-control m-input" id="invoice_subtotal" name="invoice_subtotal" value="{{ old('subtotal') }}" placeholder="Subtotal"/>
                                </td>
                                <td>
                                    <input type='text' class="form-control m-input" id="invoice_discount" name="invoice_discount" value="{{ old('discount') }}" placeholder="Discount"/>
                                </td>
                                <td>
                                    <input type='text' class="form-control m-input" id="total_tax" name="total_tax" value="" placeholder="Tax"/>
                                </td>
                                <td>
                                    <input type='text' class="form-control m-input" id="invoice_total" name="invoice_total" value="{{ old('total') }}" placeholder="Total"/>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <div class="col-10 ml-auto">
                        <h3 class="m-form__section">
                            2. Notes and Terms
                        </h3>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-2">Notes</label>
                    <div class="col-lg-8">
                        <textarea name="note" id="note" cols="30" rows="5" class="form-control m-input" placeholder="Write something here, ..">{{ old('note') }}</textarea>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-2">Terms</label>
                    <div class="col-lg-8">
                        <textarea name="terms" id="terms" cols="30" rows="5" class="form-control m-input" placeholder="Terms" placeholder="Write something here, ..">{{ old('terms') }}</textarea>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-2">In Studio</label>
                    <div class="col-lg-8">
                        <select class="form-control m-bootstrap-select" data-live-search="true" id="studio" name="studio">
                            <option value="1" {{ old('studio') == 1 ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('studio') == 0 ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions m-form__actions">
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn m-btn btn-{{ $btn_action }} m-btn--wide save"> Save</button>
                            <a href="{{ route('admin.invoices.view') }}" class="btn m-btn btn-{{ $btn_cancel }} m-btn--wide">Cancel</a>
                            {!! csrf_field() !!}
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--end::Form-->
    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
@stop

@section('modal')
    @include('admin.invoices.parts.item')
    @include('admin.invoices.parts.contact')
@stop

@section('js')
    <script src="assets/admin/demo/default/general/js/scripts/items.js" type="text/javascript"></script>
    <script src="assets/admin/demo/default/general/js/scripts/invoices.js" type="text/javascript"></script>
    <script src="assets/admin/demo/default/general/js/scripts/contacts.js" type="text/javascript"></script>

    <script id="row-template" type="text/x-custom-template">
        <div class="form-group row m-form__group invoices">
            <label class="col-form-label col-lg-2"></label>
            <div class="col-2">
            <select id="item_id" class="form-control item_id" name="items[item_id][]">
            <option value="" {{ old('item_id') == '' ? 'selected' : '' }}>Select Item</option>
        @foreach($items as $row)
        <option value="{{ $row->id }}" {{ old('item_id') == $row->id ? 'selected' : '' }}>{{ $row->name }}</option>
                @endforeach
            </select>
            <div class="input-group-prepend">
            <a href="javascript:;" class="btn btn-brand m-btn-sm custom-modal" data-id="0" id="AddNewItem">
            <i class="fa fa-plus"></i>
            </a>
            </div>
            </div>
            <div class="col-lg-2">
            <input type='text' class="form-control m-input description" name="items[description][]" id="description" value="{{ old('description') }}" placeholder="Description"/>
            </div>
            <div class="col-lg-1">
            <input type='text' class="form-control m-input quantity" name="items[quantity][]" id="quantity" value="1" placeholder="Quantity"/>
            </div>
            <div class="col-lg-1">
            <input type='text' class="form-control m-input price" name="items[price][]" id="price" value="{{ old('price', 0) }}" placeholder="Price"/>
            </div>
            <div class="col-lg-1">
            <input type='text' class="form-control m-input tax" id="tax" name="items[tax][]" value="{{ old('tax', 0) }}" placeholder="Tax" readonly/>
        </div>
        <div class="col-lg-1">
            <input type='text' class="form-control m-input subtotal" name="items[total][]" id="subtotal" value="{{ old('total', 0) }}" placeholder="Total" readonly/>
        </div>
        <div class="col-2">
            <a href="javascript:;" class="btn btn-brand m-btn m-btn--custom add">
            <i class="fa fa-plus"></i>
            </a>
            <a href="javascript:;" class="btn btn-danger m-btn m-btn--custom remove">
            <i class="fa fa-minus"></i>
            </a>
            </div>
            </div>
    </script>

    <script>
        $(document).ready(function () {
            Invoices.init();
            Items.init();
            Contacts.init();
            append_invoices();
        });
        //////////////////////////////////////////
        $(document).on('click', '#AddNewItem', function() {
            var itemVal = $(this).data('id');
            if(itemVal == "0"){
                $('#addNewItemModal').modal("show");
            }
        });
        //////////////////////////////////////////
        $(document).on('click', '#addNewContact', function() {
            var contactVal = $(this).data('id');
            if(contactVal == "0"){
                $('#addNewContactModal').modal("show");
            }
        });
    </script>
    <script>
        $(document).on('click', '.add',function() {
            append_invoices();
        });

        function append_invoices() {
            var $template = $.trim($('#row-template').html());
            var $tem = $($template).clone();
            $('#invoicesContainer').append($tem);
            $('select').selectpicker();
            calculateItems();
        }
        //////////////////////////////////////////////
        $(document).on("click", ".remove", function() {

            if ($('#invoicesContainer .form-group.row').length > 1) {
                $(this).closest(".form-group.row").remove();
                calculateItems();
            }
            else {
                Forms.notify('warning', 'Sorry, Can\'t delete last row');
            }
        });
        /////////////////////////////////////////////////
        $(document).on('change', '#company_id,#contact_id', function () {
            var company_id = $('#company_id').val();
            var contact_id = $('#contact_id').val();

            if(company_id != "" && contact_id != "")
            {
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.companies.tax') }}",
                    data: { 'company_id' : company_id, 'contact_id' : contact_id },
                    success: function (data) {
                        $('#invoice_tax').val(data.tax);
                        ////////////////////////////////////////
                        $(".tax").each(function(index) {
                            $(this).val(data.tax);
                        });
                        calculateItems();
                    }
                });
            }
            else
            {
                $('#invoice_tax').val(0);
                ///////////////////////////////////////
                $( ".tax" ).each(function( index ) {
                    $(this).val(0);
                });
                calculateItems();
            }
        });
        ////////////////////////////////////////
        $(document).on('change', '.item_id', function () {
            var that = $(this);
            var item_id = that.val();
            if(item_id == "" || item_id == null)
            {
                that.parents('.invoices').find('.price').val(0);
                calculateItems();
            }
            else
            {
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.items.info') }}",
                    data: { 'item_id' : item_id },
                    success: function (data) {
                        that.parents('.invoices').find('.price').val(data.items.price);
                        calculateItems();
                    }
                });
            }
        });
        ////////////////////////////////////////
        function calculateItems() {
            var invoice_subtotal = 0;
            var invoice_discount = 0;
            var total_tax = 0;
            var invoice_total = 0;
            ////////////////////////////////////////////////
            invoice_discount = $('#invoice_discount').val();
            if(invoice_discount == "" || invoice_discount == null)
            {
                invoice_discount = 0;
            }
            /////////////////////////////////////////////
            $( ".invoices" ).each(function( index ) {
                var quantity = $(this).find('.quantity').val();
                var price = $(this).find('.price').val();
                var tax_value = $('#invoice_tax').val();
                /////////////////////////////////////
                if(quantity == "" || quantity == null)
                {
                    quantity = 1;
                }
                if(price == "" || price == null)
                {
                    price = 0;
                }
                if(tax_value == "" || tax_value == null)
                {
                    tax_value = 0;
                }
                /////////////////////////////////////
                var tax = ((quantity * price) * (tax_value/100));
                var total = (quantity * price) + tax;
                $(this).find('.subtotal').val(total);
                $(this).find('.tax').val(parseFloat(tax).toFixed(2));
                invoice_subtotal += total;
                total_tax += tax;
            });
            /////////////////////////////////////////////
            invoice_total = invoice_subtotal - invoice_discount;
            $('#invoice_subtotal').val(invoice_subtotal);
            $('#total_tax').val(parseFloat(total_tax).toFixed(2));
            $('#invoice_discount').val(invoice_discount);
            $('#invoice_total').val(invoice_total);
        }
        ////////////////////////////////////////
        $(document).on('change', '#invoice_discount', function () {
            calculateItems();
        });
        ////////////////////////////////////////
        $(document).on('change', '.quantity', function () {
            calculateItems();
        });
        ////////////////////////////////////////
        $(document).on('change', '.price', function () {
            calculateItems();
        });
    </script>
@stop