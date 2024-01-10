@extends('admin.layout.master')

@section('title')
    Categories Management
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
                    <i class="m-nav__link-icon flaticon-placeholder"></i>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="{{ route('admin.categories.view') }}" class="m-nav__link">
                    <span class="m-nav__link-text">
                        Categories
                    </span>
                </a>
            </li>
            <li class="m-nav__separator">
                -
            </li>
            <li class="m-nav__item">
                <a href="{{ route('admin.categories.view') }}" class="m-nav__link">
                    <span class="m-nav__link-text">
                        Categories Management
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
                    <label class="col-lg-2 col-form-label">Name</label>
                    <div class="col-lg-8">
                        <input type='text' class="form-control m-input m-input--air searchable clear" name="name" id="name" placeholder="Name"/>
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
                        Categories Management
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="{{ route('admin.categories.add') }}"
                           class="btn m-btn--air btn-{{ $btn_action }} m-btn m-btn--custom m-btn--bolder">
                        <span>
                            <span>
                                New Category
                            </span>
                        </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <!--begin: Datatable -->
            <table class="table table-striped- table-bordered table-hover table-checkable" id="categories_table">
                <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Status</th>
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
    <script src="assets/admin/demo/default/general/js/scripts/categories.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            Categories.init();
        });
    </script>
@stop
