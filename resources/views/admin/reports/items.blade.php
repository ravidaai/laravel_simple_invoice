@extends('admin.layout.master')

@section('title')
    Items Revenue
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
                <a href="{{ route('admin.reports.items') }}" class="m-nav__link m-nav__link--icon">
                    <i class="m-nav__link-icon flaticon-users"></i>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            </li>
            <li class="m-nav__item">
                <a href="{{ route('admin.reports.items') }}" class="m-nav__link">
                    <span class="m-nav__link-text">
                        Items Revenue
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
        <form class="m-form m-form--fit m-form--label-align-right" id="m_form_1" method="post" action="{{ route('admin.reports.statistics') }}">
            <div class="m-portlet__body">
                <div class="form-group m-form__group row">
                    <label class="col-lg-2 col-form-label">Start Date</label>
                    <div class="col-lg-3">
                        <input type='text' class="form-control m_datepicker searchable" name="start_date" id="start_date" placeholder="Start Date" readonly/>
                    </div>
                    <label class="col-lg-2 col-form-label">End Date</label>
                    <div class="col-lg-3">
                        <input type='text' class="form-control m_datepicker searchable" name="end_date" id="end_date" placeholder="End Date" readonly/>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-2">Item</label>
                    <div class="col-3">
                        <select class="form-control m-bootstrap-select m_selectpicker searchable" data-live-search="true" id="item_id" name="item_id">
                            <option value="" {{ old('item_id') == '' ? 'selected' : '' }}>All Items</option>
                            @foreach($items as $row)
                                <option value="{{ $row->id }}" {{ old('item_id') == $row->id ? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label class="col-form-label col-lg-2">Contact</label>
                    <div class="col-3">
                        <select class="form-control m-bootstrap-select m_selectpicker searchable" data-live-search="true" id="contact_id" name="contact_id">
                            <option value="" {{ old('contact_id') == '' ? 'selected' : '' }}>All Contacts</option>
                            @foreach($contacts as $row)
                                <option value="{{ $row->id }}" {{ old('contact_id') == $row->id ? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-2">In Studio</label>
                    <div class="col-3">
                        <select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" id="studio" name="studio">
                            <option value="" {{ old('studio') == '' ? 'selected' : '' }}>All</option>
                            <option value="1" {{ old('studio') == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ old('studio') == '0' ? 'selected' : '' }}>No</option>
                        </select>
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
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--end::Form-->
    </div>
    <div class="m-portlet ">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-md-12 col-lg-6 col-xl-4">
                    <!--begin::Total Profit-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                No. of Invoices
                            </h4><br>
                            <span class="m-widget24__desc">
				            No. of Invoices
				        </span>
                            <span class="m-widget24__stats m--font-brand">
				            <span id="no_of_invoices">{{ number_format($no_of_invoices ?? 0) }}</span>
				        </span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-brand" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <!--end::Total Profit-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-4">
                    <!--begin::New Feedbacks-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                No. of Paid Invoices
                            </h4><br>
                            <span class="m-widget24__desc">
				           No. of Paid Invoices
				        </span>
                            <span class="m-widget24__stats m--font-info">
                                <span id="no_of_paid_invoices">{{ number_format($no_of_paid_invoices ?? 0) }}</span>
				        </span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <!--end::New Feedbacks-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-4">
                    <!--begin::New Orders-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                No. of Unpaid Invoices
                            </h4><br>
                            <span class="m-widget24__desc">
				            No. of Unpaid Invoices
				        </span>
                            <span class="m-widget24__stats m--font-danger">
                                <span id="no_of_unpaid_invoices">{{ number_format($no_of_unpaid_invoices ?? 0) }}</span>
				        </span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <!--end::New Orders-->
                </div>
            </div>
        </div>
    </div>
    <div class="m-portlet ">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-md-12 col-lg-6 col-xl-4">
                    <!--begin::New Users-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                Total Invoices
                            </h4><br>
                            <span class="m-widget24__desc">
                                Total Invoices
				        </span>
                            <span class="m-widget24__stats m--font-accent">
                                <span id="total_of_invoices">{{ number_format($total_of_invoices ?? 0) }}</span>
				        </span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-accent" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <span class="m-widget24__number"></span>
                        </div>
                    </div>
                    <!--end::New Users-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-4">
                    <!--begin::Total Profit-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                Total Paid Invoices
                            </h4><br>
                            <span class="m-widget24__desc">
				            Total Paid Invoices
				        </span>
                            <span class="m-widget24__stats m--font-warning">
                                <span id="total_of_paid_invoices">{{ number_format($total_of_paid_invoices ?? 0) }}</span>
				        </span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <!--end::Total Profit-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-4">
                    <!--begin::New Feedbacks-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                Total Unpaid Invoices
                            </h4><br>
                            <span class="m-widget24__desc">
				           Total Unpaid Invoices
				        </span>
                            <span class="m-widget24__stats m--font-purple">
                                <span id="total_of_unpaid_invoices">{{ number_format($total_of_unpaid_invoices ?? 0) }}</span>
				        </span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-purple" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <!--end::New Feedbacks-->
                </div>
            </div>
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Items Revenue
                    </h3>
                </div>
            </div>
            {{--<div class="m-portlet__head-tools">--}}
                {{--<ul class="m-portlet__nav">--}}
                    {{--<li class="m-portlet__nav-item">--}}
                        {{--<a href="{{ route('admin.users.add') }}"--}}
                           {{--class="btn m-btn--air btn-{{ $btn_action }} m-btn m-btn--custom m-btn--bolder">--}}
                        {{--<span>--}}
                            {{--<span>--}}
                                {{--New User--}}
                            {{--</span>--}}
                        {{--</span>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</div>--}}
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
    <script src="assets/admin/demo/default/general/js/scripts/reports.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            Reports.init();
        });
    </script>
@stop