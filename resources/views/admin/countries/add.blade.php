@extends('admin.layout.master')

@section('title')
    New Country
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
                <a href="{{ route('admin.countries.view') }}" class="m-nav__link m-nav__link--icon">
                    <i class="m-nav__link-icon flaticon-placeholder"></i>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="{{ route('admin.countries.view') }}" class="m-nav__link">
                    <span class="m-nav__link-text">
                        Countries
                    </span>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="{{ route('admin.countries.add') }}" class="m-nav__link">
                    <span class="m-nav__link-text">
                        New Country
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
                        New Country
                    </h3>
                </div>
            </div>
        </div>
        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right" id="frmAddCountry" action="{{ route('admin.countries.add') }}" method="post" data-id="">
            <div class="m-portlet__body">
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-2">Name</label>
                    <div class="col-lg-3">
                        <input type='text' class="form-control m-input" name="name" value="{{ old('name') }}" placeholder="Name"/>
                    </div>
                    <label class="col-form-label col-lg-2">Status</label>
                    <div class="col-3">
                        <select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="status">
                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Enable</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Disable</option>
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
                            <a href="{{ route('admin.countries.view') }}" class="btn m-btn btn-{{ $btn_cancel }} m-btn--wide">Cancel</a>
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
    <script src="assets/admin/demo/default/general/js/scripts/countries.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            Countries.init();
        });
    </script>
@stop