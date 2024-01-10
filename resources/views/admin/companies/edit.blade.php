@extends('admin.layout.master')

@section('title')
    Edit Company
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
                <a href="{{ route('admin.companies.view') }}" class="m-nav__link m-nav__link--icon">
                    <i class="m-nav__link-icon flaticon-home-2"></i>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="{{ route('admin.companies.view') }}" class="m-nav__link">
                    <span class="m-nav__link-text">
                        Companies
                    </span>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="javascript:;" class="m-nav__link">
                    <span class="m-nav__link-text">
                        Edit Company
                    </span>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="{{ route('admin.companies.edit', ['id' => $info->id]) }}" class="m-nav__link m--font-brand">
                    <span class="m-nav__link-text">
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
                        Edit City
                    </h3>
                </div>
            </div>
        </div>
        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right" id="frmEditCompany" action="{{ route('admin.companies.edit', ['id' => $info->id_hash]) }}" method="post" enctype="multipart/form-data">
            <div class="m-portlet__body">
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-2">Name</label>
                    <div class="col-lg-3">
                        <input type='text' class="form-control m-input" name="name" value="{{ $info->name }}" placeholder="Name"/>
                    </div>
                    <label class="col-form-label col-lg-2">Status</label>
                    <div class="col-3">
                        <select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="status">
                            <option value="1" {{ $info->status == '1' ? 'selected' : '' }}>Enable</option>
                            <option value="0" {{ $info->status == '0' ? 'selected' : '' }}>Disable</option>
                        </select>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-2">Country</label>
                    <div class="col-3">
                        <select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="country_id">
                            <option value="" {{ old('country_id') == '' ? 'selected' : '' }}>Select Item</option>
                            @foreach($countries as $row)
                                <option value="{{ $row->id }}" {{ $info->country_id == $row->id ? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label class="col-form-label col-lg-2">City</label>
                    <div class="col-3">
                        <select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="city_id">
                            <option value="" {{ old('city_id') == '' ? 'selected' : '' }}>Select Item</option>
                            @foreach($cities as $row)
                                <option value="{{ $row->id }}" {{ $info->city_id == $row->id ? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-2">Tax Number</label>
                    <div class="col-lg-3">
                        <input type='text' class="form-control m-input" name="tax_number" value="{{ $info->tax_number }}" placeholder="Tax Number"/>
                    </div>
                    <label class="col-form-label col-lg-2">Tax Value</label>
                    <div class="col-lg-3">
                        <input type='text' class="form-control m-input" name="tax_value" value="{{ $info->tax_value }}" placeholder="Tax Value"/>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-2">Image</label>
                    <div class="col-lg-3">
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            <div class="fileinput-new thumbnails img-raised">
                                <img class="avatar-pic image" src="{{ asset('uploads/companies/' . $info->logo) }}" alt="">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnails img-raised image"></div>
                            <div>
                                <br>
                                <span class="btn btn-raised btn-round btn-default btn-file">
                                   <span class="fileinput-new">Choose Image</span>
                                   <span class="fileinput-exists">Change</span>
                                   <input type="file" name="image" />
                                </span>
                                <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput" style="margin-left: 128px;">
                                    Remove</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__foot--fit">
                <div class="m-form__actions m-form__actions">
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-6">
                            <button type="submit" class="btn m-btn btn-{{ $btn_action }} m-btn--wide save"> Save Changes</button>
                            <a href="{{ route('admin.companies.view') }}" class="btn m-btn btn-{{ $btn_cancel }} m-btn--wide">Cancel</a>
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
    <script src="assets/admin/demo/default/general/js/scripts/companies.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            Companies.init();
        });
    </script>
@stop
