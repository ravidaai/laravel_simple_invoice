@extends('admin.dashboard.layout.master')
@section('subContent')
    @include('admin.layout.error')
    <div class="m-portlet m-portlet--full-height m-portlet--tabs">
        <div class="m-portlet__head">
            <div class="m-portlet__head-tools" id="tabs">
                <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--brand" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">
                            <i class="flaticon-share m--hide"></i>
                            My Profile
                        </a>
                    </li>
                </ul>
            </div>
            {{--<div class="m-portlet__head-tools">--}}
                {{--<ul class="m-portlet__nav">--}}
                    {{--<li class="m-portlet__nav-item m-portlet__nav-item--last">--}}
                        {{--<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">--}}
                            {{--<a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">--}}
                                {{--<i class="la la-gear"></i>--}}
                            {{--</a>--}}
                            {{--<div class="m-dropdown__wrapper">--}}
                                {{--<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>--}}
                                {{--<div class="m-dropdown__inner">--}}
                                    {{--<div class="m-dropdown__body">--}}
                                        {{--<div class="m-dropdown__content">--}}
                                            {{--<ul class="m-nav">--}}
                                                {{--<li class="m-nav__section m-nav__section--first">--}}
                                                                    {{--<span class="m-nav__section-text">--}}
                                                                        {{--Quick Actions--}}
                                                                    {{--</span>--}}
                                                {{--</li>--}}
                                                {{--<li class="m-nav__item">--}}
                                                    {{--<a href="" class="m-nav__link">--}}
                                                        {{--<i class="m-nav__link-icon flaticon-share"></i>--}}
                                                        {{--<span class="m-nav__link-text">--}}
                                                                            {{--Create Post--}}
                                                                        {{--</span>--}}
                                                    {{--</a>--}}
                                                {{--</li>--}}
                                                {{--<li class="m-nav__item">--}}
                                                    {{--<a href="" class="m-nav__link">--}}
                                                        {{--<i class="m-nav__link-icon flaticon-chat-1"></i>--}}
                                                        {{--<span class="m-nav__link-text">--}}
                                                                            {{--Send Messages--}}
                                                                        {{--</span>--}}
                                                    {{--</a>--}}
                                                {{--</li>--}}
                                                {{--<li class="m-nav__item">--}}
                                                    {{--<a href="" class="m-nav__link">--}}
                                                        {{--<i class="m-nav__link-icon flaticon-multimedia-2"></i>--}}
                                                        {{--<span class="m-nav__link-text">--}}
                                                                            {{--Upload File--}}
                                                                        {{--</span>--}}
                                                    {{--</a>--}}
                                                {{--</li>--}}
                                                {{--<li class="m-nav__section">--}}
                                                                    {{--<span class="m-nav__section-text">--}}
                                                                        {{--Useful Links--}}
                                                                    {{--</span>--}}
                                                {{--</li>--}}
                                                {{--<li class="m-nav__item">--}}
                                                    {{--<a href="" class="m-nav__link">--}}
                                                        {{--<i class="m-nav__link-icon flaticon-info"></i>--}}
                                                        {{--<span class="m-nav__link-text">--}}
                                                                            {{--FAQ--}}
                                                                        {{--</span>--}}
                                                    {{--</a>--}}
                                                {{--</li>--}}
                                                {{--<li class="m-nav__item">--}}
                                                    {{--<a href="" class="m-nav__link">--}}
                                                        {{--<i class="m-nav__link-icon flaticon-lifebuoy"></i>--}}
                                                        {{--<span class="m-nav__link-text">--}}
                                                                            {{--Support--}}
                                                                        {{--</span>--}}
                                                    {{--</a>--}}
                                                {{--</li>--}}
                                                {{--<li class="m-nav__separator m-nav__separator--fit m--hide"></li>--}}
                                                {{--<li class="m-nav__item m--hide">--}}
                                                    {{--<a href="#" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">--}}
                                                        {{--Submit--}}
                                                    {{--</a>--}}
                                                {{--</li>--}}
                                            {{--</ul>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="m_user_profile_tab_1">
                <form class="m-form m-form--fit m-form--label-align-right" method="post">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group m--margin-top-10 m--hide">
                            <div class="alert m-alert m-alert--default" role="alert">
                                The example form below demonstrates common HTML form elements that receive updated styles from Bootstrap with additional classes.
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-10 ml-auto">
                                <h3 class="m-form__section">
                                    1. Personal Information
                                </h3>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-2 col-form-label">
                                User Name
                            </label>
                            <div class="col-7">
                                <input class="form-control m-input" type="text" value="{{ $info->username }}" readonly>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-2 col-form-label">
                                Name
                            </label>
                            <div class="col-7">
                                <input class="form-control m-input" name="name" type="text" value="{{ $info->name }}">
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="example-text-input" class="col-2 col-form-label">
                                Email
                            </label>
                            <div class="col-7">
                                <input class="form-control m-input" name="email" type="text" value="{{ $info->email }}">
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions">
                            <div class="row">
                                <div class="col-2"></div>
                                <div class="col-7">
                                    <button type="submit" class="btn btn-brand m-btn m-btn--air m-btn--custom save">
                                        Save Changes
                                    </button>
                                    &nbsp;&nbsp;
                                    <a href="{{ route('admin.dashboard.view') }}" class="btn btn-secondary m-btn m-btn--air m-btn--custom">Cancel</a>
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