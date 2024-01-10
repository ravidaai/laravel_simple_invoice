@extends('admin.layout.master')

@section('title')
    Change Password
@stop

@section('css')

@stop

@section('breadcrumb')
    <div class="mr-auto">
        <h3 class="m-subheader__title m-subheader__title--separator">
            {{ trans('general.dashboard') }}
        </h3>
        <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
            <li class="m-nav__item m-nav__item--home">
                <a href="{{ route('admin.users.view') }}" class="m-nav__link m-nav__link--icon">
                    <i class="m-nav__link-icon flaticon-users"></i>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="{{ route('admin.users.view') }}" class="m-nav__link">
                    <span class="m-nav__link-text">
                        Users
                    </span>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="{{ route('admin.users.password', ['id' => $info->id]) }}" class="m-nav__link">
                    <span class="m-nav__link-text">
                        Change Password
                    </span>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="{{ route('admin.users.password', ['id' => $info->id]) }}" class="m-nav__link m--font-brand">
                    <span class="m-menu__link-text">
                        {{ $info->name }}
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
                        Change Password
                    </h3>
                </div>
            </div>
        </div>
        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right" id="frmChangePassword" action="{{ route('admin.users.password', ['id' => $info->id_hash]) }}" method="post">
            <div class="m-portlet__body">
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-2">
                        Change Password
                    </label>
                    <div class="col-lg-3">
                        <input type='password' class="form-control m-input" name="password" value="{{ old('password') }}" placeholder="Password"/>
                    </div>
                    <label class="col-form-label col-lg-2">
                        Confirm Password
                    </label>
                    <div class="col-lg-3">
                        <input type='password' class="form-control m-input" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Confirm Password"/>
                    </div>
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions m-form__actions">
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn m-btn btn-{{ $btn_action }} m-btn--wide save"> Save Changes</button>
                            <a href="{{ route('admin.users.view') }}" class="btn m-btn btn-{{ $btn_cancel }} m-btn--wide">Cancel</a>
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

@section('js')
    <script src="assets/admin/demo/default/general/js/scripts/users.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            Users.init();
        });
    </script>
@stop