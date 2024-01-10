@extends('admin.layout.master')

@section('title')
    Settings Management
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
                <a href="{{ route('admin.settings.view') }}" class="m-nav__link m-nav__link--icon">
                    <i class="m-nav__link-icon flaticon-settings-1"></i>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="{{ route('admin.settings.view') }}" class="m-nav__link">
                    <span class="m-nav__link-text">
                        Settings
                    </span>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="{{ route('admin.settings.view') }}" class="m-nav__link">
                    <span class="m-nav__link-text">
                        Settings Management
                    </span>
                </a>
            </li>
        </ul>
    </div>
@stop

@section('content')
    @include('admin.layout.error')
    <div class="m-portlet m-portlet--full-height m-portlet--tabs">
        <div class="m-portlet__head">
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--brand" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">
                            <i class="flaticon-share m--hide"></i>
                            Edit Settings
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="m_user_profile_tab_1">
                <form class="m-form m-form--fit m-form--label-align-right" id="frmEditSetting" action="{{ route('admin.settings.view') }}" method="post">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group m--margin-top-10 m--hide">
                            <div class="alert m-alert m-alert--default" role="alert">
                                The example form below demonstrates common HTML form elements that receive updated styles from Bootstrap with additional classes.
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-10 ml-auto">
                                <h3 class="m-form__section">
                                    1. Settings
                                </h3>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-2 col-form-label">
                                Email
                            </label>
                            <div class="col-7">
                                <input class="form-control m-input" type="text" name="email" value="{{ $info->email }}">
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-2 col-form-label">
                                Mobile
                            </label>
                            <div class="col-7">
                                <input class="form-control m-input" type="text" name="mobile" value="{{ $info->mobile }}">
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-2 col-form-label">
                                Longitude
                            </label>
                            <div class="col-7">
                                <input class="form-control m-input" type="text" name="longitude" value="{{ $info->longitude }}">
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-2 col-form-label">
                                Latitude
                            </label>
                            <div class="col-7">
                                <input class="form-control m-input" type="text" name="latitude" value="{{ $info->latitude }}">
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-2 col-form-label">
                                Email Password
                            </label>
                            <div class="col-7">
                                <input class="form-control m-input" type="password" name="email_password" value="{{ $info->email_password }}">
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-2 col-form-label">
                                SMTP HOST
                            </label>
                            <div class="col-7">
                                <input class="form-control m-input" type="text" name="smtp_host" value="{{ $info->smtp_host }}">
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-2 col-form-label">
                                SMTP PORT
                            </label>
                            <div class="col-7">
                                <input class="form-control m-input" type="text" name="smtp_port" value="{{ $info->smtp_port }}">
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-2 col-form-label">
                                SMTP TIMEOUT
                            </label>
                            <div class="col-7">
                                <input class="form-control m-input" type="text" name="smtp_timeout" value="{{ $info->smtp_timeout }}">
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-2 col-form-label">
                                SMTP CRYPTO
                            </label>
                            <div class="col-7">
                                <input class="form-control m-input" type="text" name="smtp_crypto" value="{{ $info->smtp_crypto }}">
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions">
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-7">
                                    <button type="submit" class="btn m-btn btn-{{ $btn_action }} m-btn--wide save"> Save Changes </button>
                                    {!! csrf_field() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="assets/admin/demo/default/general/js/scripts/settings.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            Settings.init();
        });
    </script>
@stop









