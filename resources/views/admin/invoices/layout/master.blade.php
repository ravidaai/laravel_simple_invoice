@extends('admin.layout.master')

@section('title')
    Invoices Management
@stop

@section('css')
    <style>
        .active_menu
        {
            background-color: #f7f8fa;
        }
        .input-group-prepend {
            position: absolute;
            right: 17px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1;
        }
        .input-groups-prepend {
            position: absolute;
            right: 815px;
            top: 368px;
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
                    <i class="m-nav__link-icon flaticon-user-ok"></i>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="{{-- route('admin.invoices.' . $active_sub_menu, $info->id_hash) --}}" class="m-nav__link">
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
    <div class="row">
        <div class="col-xl-3 col-lg-4">
            <div class="m-portlet m-portlet--full-height">
                <div class="m-portlet__body">
                    <div class="m-card-profile">
                        <div class="m-card-profile__title m--hide">
                            Your Profile
                        </div>
                        <div class="m-card-profile__pic">
                            <div class="m-card-profile__pic-wrapper">
                                <img src="assets/admin/app/media/img/users/user4.jpg" alt=""/>
                            </div>
                        </div>
                        <div class="m-card-profile__details">
                            <a href="javascript:;" class="m-card-profile__email m-link">
                                Invoice Number
                            </a>
                            <span class="m-card-profile__name" style="margin-top: 10px;">
                                {{ 'CR-' . str_pad($info->number,7,0,0) }}
                            </span>
                        </div>
                    </div>
                    <input type="hidden" data-id="{{ $info->id_hash }}" id="invoice_id">
                    <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
                        <li class="m-nav__separator m-nav__separator--fit"></li>
                        <li class="m-nav__section m--hide">
                            <span class="m-nav__section-text">
                                Section
                            </span>
                        </li>
                        <li class="m-nav__item {{ $active_sub_menu == 'edit' ? 'active_menu' : '' }}">
                            <a href="{{ route('admin.invoices.edit', $info->id_hash) }}" class="m-nav__link">
                                <i class="m-nav__link-icon flaticon-information {{ $active_sub_menu == 'edit' ? $menu_color : '' }}"></i>
                                <span class="m-nav__link-text {{ $active_sub_menu == 'edit' ? $menu_color : '' }}">
                                    Edit
                                </span>
                            </a>
                        </li>
                        <li class="m-nav__item {{ $active_sub_menu == 'attachment' ? 'active_menu' : '' }}">
                            <a href="{{ route('admin.invoices.attachments', $info->id_hash) }}" class="m-nav__link">
                                <i class="m-nav__link-icon flaticon-attachment {{ $active_sub_menu == 'attachment' ? $menu_color : '' }}"></i>
                                <span class="m-nav__link-text {{ $active_sub_menu == 'attachment' ? $menu_color : '' }}">
                                    Attachments
                                </span>
                            </a>
                        </li>
                        <li class="m-nav__item {{ $active_sub_menu == 'payments' ? 'active_menu' : '' }}">
                            <a href="{{ route('admin.invoices.payments', $info->id_hash) }}" class="m-nav__link">
                                <i class="m-nav__link-icon flaticon-coins {{ $active_sub_menu == 'payments' ? $menu_color : '' }}"></i>
                                <span class="m-nav__link-text {{ $active_sub_menu == 'payments' ? $menu_color : '' }}">
                                    Payments
                                </span>
                            </a>
                        </li>
                        <li class="m-nav__item {{ $active_sub_menu == 'print' ? 'active_menu' : '' }}">
                            <a href="{{ route('admin.invoices.invoice', $info->id_hash) }}" target="_blank" class="m-nav__link">
                                <i class="m-nav__link-icon flaticon-presentation {{ $active_sub_menu == 'print' ? $menu_color : '' }}"></i>
                                <span class="m-nav__link-text {{ $active_sub_menu == 'print' ? $menu_color : '' }}">
                                    Print
                                </span>
                            </a>
                        </li>
                        <li class="m-nav__item" style="cursor: pointer;">
                            <a data-url="{{ route('admin.invoices.delete',['id' => $info->id_hash]) }}" class="m-nav__link delete_invoice_btn">
                                <i class="m-nav__link-icon flaticon-delete m--font-danger"></i>
                                <span class="m-nav__link-text m--font-danger">
                                    Delete
                                </span>
                            </a>
                        </li>
                    </ul>
                    <div class="m-portlet__body-separator"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-8">
            <div id="content">
                @yield('subContent')
            </div>
        </div>
    </div>
@stop

@section('modal')
    @include('admin.layout.delete')
@stop

@section('js')
    <script src="assets/admin/demo/default/general/js/scripts/attachments.js" type="text/javascript"></script>
    <script src="assets/admin/demo/default/general/js/scripts/invoices_payments.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            Attachments.init();
            InvoicesPayments.init();
        });
    </script>
    <script src="assets/admin/demo/default/general/js/scripts/invoices.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            Invoices.init();
        });
    </script>
    @yield('sub-js')
@stop
