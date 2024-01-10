@extends('admin.layout.master')

@section('title')
    Edit supplier
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
                    <i class="m-nav__link-icon flaticon-user"></i>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="{{ route('admin.suppliers.view') }}" class="m-nav__link">
                    <span class="m-nav__link-text">
                        Suppliers
                    </span>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="javascript:;" class="m-nav__link">
                    <span class="m-nav__link-text">
                        Edit Supplier
                    </span>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="{{ route('admin.suppliers.edit', ['id' => $info->id]) }}" class="m-nav__link m--font-brand">
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
                        Edit Supplier
                    </h3>
                </div>
            </div>
        </div>
        <!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right" id="frmEditSupplier" action="{{ route('admin.suppliers.edit', ['id' => $info->id_hash]) }}" method="post" enctype="multipart/form-data">
            <div class="m-portlet__body">
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-2">Name</label>
                    <div class="col-lg-3">
                        <input type='text' class="form-control m-input" name="name" value="{{ $info->name }}" placeholder="Name"/>
                    </div>
                    <label class="col-form-label col-lg-2">Display Name</label>
                    <div class="col-lg-3">
                        <input type='text' class="form-control m-input" name="display_name" value="{{ $info->display_name }}" placeholder="Display Name"/>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-2">Email</label>
                    <div class="col-lg-3">
                        <input type='text' class="form-control m-input" name="email" value="{{ $info->email }}" placeholder="Email"/>
                    </div>
                    <label class="col-form-label col-lg-2">Mobile</label>
                    <div class="col-lg-3">
                        <input type='text' class="form-control m-input" name="mobile" value="{{ $info->mobile }}" placeholder="Mobile"/>
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
                    <label class="col-form-label col-lg-2">URL</label>
                    <div class="col-lg-3">
                        <input type='text' class="form-control m-input" name="url" value="{{ $info->url }}" placeholder="URL"/>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-2">Address</label>
                    <div class="col-lg-3">
                        <input type='text' class="form-control m-input" name="address" value="{{ $info->address }}" placeholder="Address"/>
                    </div>
                    <label class="col-form-label col-lg-2">Postal Code</label>
                    <div class="col-lg-3">
                        <input type='text' class="form-control m-input" name="postal_code" value="{{ $info->postal_code }}" placeholder="Postal Code"/>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-form-label col-lg-2">Status</label>
                    <div class="col-8">
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
                                <a href="{{ route('admin.suppliers.view') }}" class="btn m-btn btn-{{ $btn_cancel }} m-btn--wide">Cancel</a>
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
    <script src="assets/admin/demo/default/general/js/scripts/suppliers.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            Suppliers.init();
        });
    </script>
@stop
