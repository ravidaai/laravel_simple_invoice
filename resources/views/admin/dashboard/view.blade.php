@extends('admin.layout.master')

@section('title')
    Dashboard
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
                <a href="{{ route('admin.dashboard.view') }}" class="m-nav__link m-nav__link--icon">
                    <i class="m-nav__link-icon flaticon-line-graph"></i>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="{{ route('admin.dashboard.view') }}" class="m-nav__link">
                    <span class="m-nav__link-text">
                        Dashboard
                    </span>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="{{ route('admin.dashboard.view') }}" class="m-nav__link">
                    <span class="m-nav__link-text">
                        Statistics
                    </span>
                </a>
            </li>
        </ul>
    </div>
@stop


@section('content')
    <div class="m-portlet ">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-md-12 col-lg-6 col-xl-3">
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
				            {{ number_format($no_of_invoices) }}
				        </span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-brand" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <!--end::Total Profit-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">
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
				            {{ number_format($no_of_paid_invoices) }}
				        </span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <!--end::New Feedbacks-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">
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
				            {{ number_format($no_of_unpaid_invoices) }}
				        </span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <!--end::New Orders-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::New Users-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                No. of Contacts
                            </h4><br>
                            <span class="m-widget24__desc">
                                No. of Contacts
				        </span>
                            <span class="m-widget24__stats m--font-success">
				            {{ number_format($no_of_contact) }}
				        </span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-success" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <span class="m-widget24__number"></span>
                        </div>
                    </div>
                    <!--end::New Users-->
                </div>
            </div>
        </div>
    </div>
    <div class="m-portlet ">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-md-12 col-lg-6 col-xl-3">
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
				            {{ number_format($total_of_invoices) }}
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
                <div class="col-md-12 col-lg-6 col-xl-3">
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
				            {{ number_format($total_of_paid_invoices) }}
				        </span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <!--end::Total Profit-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">
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
				            {{ number_format($total_of_unpaid_invoices) }}
				        </span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-purple" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <!--end::New Feedbacks-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::New Orders-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                No. of Companies
                            </h4><br>
                            <span class="m-widget24__desc">
				            No. of Companies
				        </span>
                            <span class="m-widget24__stats m--font-metal">
				            {{ number_format($no_of_company) }}
				        </span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-metal" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <!--end::New Orders-->
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')

@stop