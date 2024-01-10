@extends('admin.layout.master')

@section('title')
    Invoices Management
@stop

@section('css')
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
                        Invoices
                    </span>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="{{ route('admin.invoices.view') }}" class="m-nav__link">
                    <span class="m-nav__link-text">
                        Invoices Management
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
                        Search
                    </h3>
                </div>
            </div>
        </div>
        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right" id="m_form_1">
            <div class="m-portlet__body">
                <div class="form-group m-form__group row">
                    <label class="col-lg-2 col-form-label">Number</label>
                    <div class="col-lg-8">
                        <input type='text' class="form-control m-input m-input--air searchable clear" id="number" name="number" placeholder="Number"/>
                    </div>
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions m-form__actions">
                    <div class="row">
                        <div class="col-lg-10 ml-lg-auto">
                            <button type="submit" class="btn m-btn--air btn-{{ $btn_action }} m-btn m-btn--custom m-btn--bolder search">
                                Search
                            </button>
                            <button type="submit" class="btn m-btn--air btn-{{ $btn_cancel }} m-btn m-btn--custom m-btn--bolder btn-clear">
                                Clear
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--end::Form-->
    </div>
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Invoices Management
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="{{ route('admin.invoices.add') }}"
                           class="btn m-btn--air btn-{{ $btn_action }} m-btn m-btn--custom m-btn--bolder">
                        <span>
                            <span>
                                New Invoice
                            </span>
                        </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="invoices_table">
                <thead>
                <tr>
                    <th></th>
                    <th>Number</th>
                    <th>Contact</th>
                    <th>Company</th>
                    <th>Invoice Date</th>
                    <th>Due Date</th>
                    <th>Subtotal</th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th>Status Paid</th>
                    <th>Date</th>
                    <th>Tools</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <!-- END EXAMPLE TABLE PORTLET-->
@stop

@section('js')
    <script src="assets/admin/demo/default/general/js/scripts/invoices.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            Invoices.init();
        });
    </script>
@stop