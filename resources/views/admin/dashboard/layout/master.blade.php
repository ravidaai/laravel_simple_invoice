@extends('admin.layout.master')

@section('title')
    Profile Management
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
                <a href="{{ route('admin.dashboard.profile') }}" class="m-nav__link m-nav__link--icon">
                    <i class="m-nav__link-icon flaticon-information"></i>
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
                <a href="{{ route('admin.dashboard.profile') }}" class="m-nav__link">
                    <span class="m-nav__link-text">
                        Profile Management
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
                                        <span class="m-card-profile__name">
                                            {{ $info->name }}
                                        </span>
                            <a href="javascript:;" class="m-card-profile__email m-link">
                                {{ $info->email }}
                            </a>
                        </div>
                    </div>
                    <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
                        <li class="m-nav__separator m-nav__separator--fit"></li>
                        <li class="m-nav__section m--hide">
                            <span class="m-nav__section-text">
                                Section
                            </span>
                        </li>
                        <li class="m-nav__item">
                            <a href="{{ route('admin.dashboard.profile') }}" class="m-nav__link">
                                <i class="m-nav__link-icon flaticon-profile-1"></i>
                                <span class="m-nav__link-text">
                                    My Profile
                                </span>
                            </a>
                        </li>
                        <li class="m-nav__item">
                            <a href="{{ route('admin.dashboard.password') }}" class="m-nav__link">
                                <i class="m-nav__link-icon flaticon-share"></i>
                                <span class="m-nav__link-text">
                                    Change Password
                                </span>
                            </a>
                        </li>
                        <li class="m-nav__item">
                            <a href="{{ route('admin.dashboard.logout') }}" class="m-nav__link">
                                <i class="m-nav__link-icon flaticon-logout m--font-danger"></i>
                                <span class="m-nav__link-text m--font-danger">
                                    Logout
                                </span>
                            </a>
                        </li>
                    </ul>
                    {{--<div class="m-portlet__body-separator"></div>--}}
                    {{--<div class="m-widget1 m-widget1--paddingless">--}}
                        {{--<div class="m-widget1__item">--}}
                            {{--<div class="row m-row--no-padding align-items-center">--}}
                                {{--<div class="col">--}}
                                    {{--<h3 class="m-widget1__title">--}}
                                        {{--Member Profit--}}
                                    {{--</h3>--}}
                                    {{--<span class="m-widget1__desc">--}}
                                                    {{--Awerage Weekly Profit--}}
                                                {{--</span>--}}
                                {{--</div>--}}
                                {{--<div class="col m--align-right">--}}
                                                {{--<span class="m-widget1__number m--font-brand">--}}
                                                    {{--+$17,800--}}
                                                {{--</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="m-widget1__item">--}}
                            {{--<div class="row m-row--no-padding align-items-center">--}}
                                {{--<div class="col">--}}
                                    {{--<h3 class="m-widget1__title">--}}
                                        {{--Orders--}}
                                    {{--</h3>--}}
                                    {{--<span class="m-widget1__desc">--}}
                                                    {{--Weekly Customer Orders--}}
                                                {{--</span>--}}
                                {{--</div>--}}
                                {{--<div class="col m--align-right">--}}
                                                {{--<span class="m-widget1__number m--font-danger">--}}
                                                    {{--+1,800--}}
                                                {{--</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="m-widget1__item">--}}
                            {{--<div class="row m-row--no-padding align-items-center">--}}
                                {{--<div class="col">--}}
                                    {{--<h3 class="m-widget1__title">--}}
                                        {{--Issue Reports--}}
                                    {{--</h3>--}}
                                    {{--<span class="m-widget1__desc">--}}
                                                {{--System bugs and issues--}}
                                            {{--</span>--}}
                                {{--</div>--}}
                                {{--<div class="col m--align-right">--}}
                                                {{--<span class="m-widget1__number m--font-success">--}}
                                                    {{---27,49%--}}
                                                {{--</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
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

@section('js')

@stop