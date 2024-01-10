@extends('admin.layout.master')

@section('title')
    Edit Branch
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
                <a href="{{ route('admin.branches.view') }}" class="m-nav__link m-nav__link--icon">
                    <i class="m-nav__link-icon flaticon-infinity"></i>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="{{ route('admin.branches.view') }}" class="m-nav__link">
                    <span class="m-nav__link-text">
                        Branches
                    </span>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="javascript:;" class="m-nav__link">
                    <span class="m-nav__link-text">
                        Edit Branch
                    </span>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="{{ route('admin.branches.edit', ['id' => $info->id]) }}" class="m-nav__link m--font-brand">
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
                        Edit Contact
                    </h3>
                </div>
            </div>
        </div>
        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right" id="frmEditBranch" action="{{ route('admin.branches.edit', ['id' => $info->id_hash]) }}" method="post" enctype="multipart/form-data">
            <div class="m-portlet__body">
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-2">Is Primary</label>
                    <div class="col-3">
                        <select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="is_primary">
                            <option value="" {{ $info->is_primary == '' ? 'selected' : '' }}>Select Item</option>

                            <option value="1" {{ $info->is_primary == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ $info->is_primary == '0' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                    <label class="col-form-label col-lg-2">Company</label>
                    <div class="col-3">
                        <select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="company_id">
                            <option value="" {{ old('company_id') == '' ? 'selected' : '' }}>Select Item</option>
                            @foreach($companies as $row)
                                <option value="{{ $row->id }}" {{ $info->company_id == $row->id ? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
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
                    <label class="col-form-label col-lg-2">Address One</label>
                    <div class="col-lg-3">
                        <input type='text' class="form-control m-input" name="address_one" value="{{ $info->address_one }}" placeholder="Address One"/>
                    </div>
                    <label class="col-form-label col-lg-2">Address Two</label>
                    <div class="col-lg-3">
                        <input type='text' class="form-control m-input" name="address_two" value="{{ $info->address_two }}" placeholder="Address Two"/>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-2">Postal Code</label>
                    <div class="col-lg-3">
                        <input type='text' class="form-control m-input" name="postal_code" value="{{ $info->postal_code }}" placeholder="Postal Code"/>
                    </div>
                    <label class="col-form-label col-lg-2">Status</label>
                    <div class="col-3">
                        <select class="form-control m-bootstrap-select m_selectpicker" data-live-search="true" name="status">
                            <option value="1" {{ $info->status == '1' ? 'selected' : '' }}>Enable</option>
                            <option value="0" {{ $info->status == '0' ? 'selected' : '' }}>Disable</option>
                        </select>
                    </div>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-6">
                                <button type="submit" class="btn m-btn btn-{{ $btn_action }} m-btn--wide save"> Save Changes</button>
                                <a href="{{ route('admin.branches.view') }}" class="btn m-btn btn-{{ $btn_cancel }} m-btn--wide">Cancel</a>
                                {!! csrf_field() !!}
                            </div>
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
    <script src="assets/admin/demo/default/general/js/scripts/branches.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            Branches.init();
        });
    </script>
@stop