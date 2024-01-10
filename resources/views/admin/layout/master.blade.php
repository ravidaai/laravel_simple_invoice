<!DOCTYPE html>
<html dir="ltr" lang="en" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>
        Panda Invoices | @yield('title')
    </title>
    <meta name="description" content="User profile example page">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ asset('/') }}">
    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Web font -->
    <!--begin::Base Styles -->
    <link href="assets/admin/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/demo/default/general/css/plugins/jasny-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css" />
    <!--begin::Custom Fonts Styles -->
    <link href="assets/admin/demo/default/general/css/scripts/custom.css" rel="stylesheet" type="text/css" />
    <!--End::Custom Fonts Styles -->
    @yield('css')
    <style>
        .avatar-pic
        {
            width: 150px;
        }
        .image
        {
            max-width: 300px;
            max-height: 150px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 4px;
            background-color: #fff;
        }
    </style>
    <!--end::Base Styles -->
    <link rel="shortcut icon" href="uploads/logo/icon.png">
    @yield('head')
</head>
<!-- end::Head -->
<!-- end::Body -->
<body  class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <!-- BEGIN: Header -->
    @include('admin.layout.header')
<!-- END: Header -->
    <!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        <!-- BEGIN: Left Aside -->
        <button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
            <i class="la la-close"></i>
        </button>
        <div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
            <!-- BEGIN: Aside Menu -->
        @include("admin.layout.sidebar")
        <!-- END: Aside Menu -->
        </div>
        <!-- END: Left Aside -->
        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <!-- BEGIN: Subheader -->
            <div class="m-subheader ">
                <div class="d-flex align-items-center">
                    @yield('breadcrumb')
                </div>
            </div>
            <!-- END: Subheader -->
            <div class="m-content">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- end:: Body -->
    <!-- begin::Footer -->
@include("admin.layout.footer")
<!-- end::Footer -->
</div>
<!-- end:: Page -->
<!-- begin::Scroll Top -->
<div id="m_scroll_top" class="m-scroll-top">
    <i class="la la-arrow-up"></i>
</div>
@yield('modal')
<!-- end::Scroll Top -->
<!--begin::Base Scripts -->
<script src="assets/admin/vendors/base/vendors.bundle.js" type="text/javascript"></script>
<script src="assets/admin/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
<script src="assets/admin/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>
<script src="assets/admin/demo/default/custom/crud/forms/widgets/select2.js" type="text/javascript"></script>
<script src="assets/admin/demo/default/general/js/plugins/jasny-bootstrap.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js"></script>
<script src="{{ route('admin.common.view') }}"></script>
<script src="assets/admin/demo/default/general/js/scripts/common.js" type="text/javascript"></script>
<script src="assets/admin/demo/default/general/js/scripts/datatable.js" type="text/javascript"></script>
@yield('js')
<!--end::Base Scripts -->
<script>
    ///////////////////////////////////
    $(".m_datepicker").datepicker({
        autoclose: true,
        todayHighlight:'TRUE',
        format: 'yyyy-mm-dd',
        orientation: "bottom left"
    });
    //////////////////////////////////////////
    $('.btn-clear').on('click', function (e) {
        e.preventDefault();
        $('.clear').val('');
        $('.clear').selectpicker("refresh");
    });
</script>
</body>
<!-- end::Body -->
</html>
