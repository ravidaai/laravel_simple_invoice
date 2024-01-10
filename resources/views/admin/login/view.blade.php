
<!DOCTYPE html>

<html lang="en" dir="ltr">
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>
        Panda Invoices | Sign In
    </title>
    <meta name="description" content="Latest updates and statistic charts">
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
    <!--begin::Custom Fonts Styles -->
        {{--<link href="assets/admin/demo/default/general/css/scripts/custom.rtl.css" rel="stylesheet" type="text/css" />--}}
    <!--End::Custom Fonts Styles -->
    <!--end::Base Styles -->
    <link rel="shortcut icon" href="uploads/logo/icon.png">
</head>
<!-- end::Head -->
<!-- end::Body -->
<body  class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-login m-login--signin  m-login--5" id="m_login" style="background-image: url(assets/admin/app/media/img//bg/bg-3.jpg);">
        <div class="m-login__wrapper-1 m-portlet-full-height">
            <div class="m-login__wrapper-1-1">
                <div class="m-login__contanier">
                    <div class="m-login__content">
                        <div class="m-login__logo">
                            <a href="{{ route('admin.login.view') }}">
                                <img src="uploads/logo/logo.png" style="width: 100px;">
                            </a>
                        </div>
                        <div class="m-login__title">
                            <h3>
                                Panda Invoices - Welcome back,..
                            </h3>
                        </div>
                        <div class="m-login__desc">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's.
                        </div>
                    </div>
                </div>
                <div class="m-login__border">
                    <div></div>
                </div>
            </div>
        </div>
        <div class="m-login__wrapper-2 m-portlet-full-height">
            <div class="m-login__contanier">
                <div class="m-login__signin">
                    <div class="m-login__head">
                        <h3 class="m-login__title">
                            Login To Your Account

                        </h3>
                    </div>
                    <form class="m-login__form m-form" action="" method="post">
                        @if(Session::has('danger'))
                            <div class="m-alert m-alert--outline alert alert-danger alert-dismissible fade show" role="alert" style="font-size: 11px;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                <strong>
                                    {{ trans('alert.error') }}
                                </strong>
                                {{ Session::get('danger') }}
                            </div>
                        @endif
                        <div class="form-group m-form__group">
                            <input class="form-control m-input" type="text" value="admin" placeholder="User Name\ Email" name="username" autocomplete="off">
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input m-login__form-input--last" value="123456" type="Password" placeholder="Password" name="password">
                        </div>
                        <div class="row m-login__form-sub">
                            <div class="col m--align-left">
                                <label class="m-checkbox m-checkbox--brand">
                                    <input type="checkbox" name="remember_token">
                                    Remember Me
                                    <span></span>
                                </label>
                            </div>
                            <div class="col m--align-right">
                                <a href="javascript:;" id="m_login_forget_password" class="m-link">
                                    Forget Password ?
                                </a>
                            </div>
                        </div>
                        <div class="m-login__form-action">
                            <button type="submit" class="btn btn-brand m-btn m-btn--pill m-btn--custom m-btn--air">
                                Sign In
                            </button>
                            {{ csrf_field() }}
                        </div>
                    </form>
                </div>
                <div class="m-login__forget-password">
                    <div class="m-login__head">
                        <h3 class="m-login__title">
                            Forget Password?
                        </h3>
                        <div class="m-login__desc">
                            Enter your email to reset your password:
                        </div>
                    </div>
                    <form class="m-login__form m-form" action="">
                        <div class="form-group m-form__group">
                            <input class="form-control m-input" type="text" placeholder="Email" name="email" id="m_email" autocomplete="off">
                        </div>
                        <div class="m-login__form-action">
                            <button id="m_login_forget_password_submit" class="btn btn-brand m-btn m-btn--pill m-btn--custom m-btn--air">
                                Send
                            </button>
                            <button id="m_login_forget_password_cancel" class="btn btn-secondary m-btn m-btn--pill m-btn--custom ">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end:: Page -->
<!--begin::Base Scripts -->
<script src="assets/admin/vendors/base/vendors.bundle.js" type="text/javascript"></script>
<script src="assets/admin/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
<!--end::Base Scripts -->
<!--begin::Page Snippets -->
<script src="assets/admin/snippets/custom/pages/user/login.js" type="text/javascript"></script>
<!--end::Page Snippets -->
</body>
<!-- end::Body -->
</html>
