<?php
session_start ();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

if(!empty($_GET['page'])) {
    $_SESSION['page'] = $_GET['page'];
}

if(!empty($_GET['id'])) {
    $_SESSION['id'] = $_GET['id'];
}

if (!empty( $_POST ['_signin'] )) { // Regular sign-in
    $username = $_POST ['username'];
    $password = hash("sha256", $_POST ['password']);

    try {
        $user = DB_utils::selectUser($username);
        if ($user != null) {    // user exists
            if (strtoupper($password) == strtoupper($user->getPassword())) {  // correct password
                $_SESSION['app'] = 'cargo';
                $_SESSION['operator']['id'] = $user->getId();
                $_SESSION['operator']['username'] = $user->getUsername();
                $_SESSION['operator']['name'] = $user->getName();
                $_SESSION['operator']['insert'] = $user->getInsert() == 1;
                $_SESSION['operator']['reports'] = $user->getReports() == 1;
                $_SESSION['operator']['country-id'] = $user->getCountryId();
                $_SESSION['operator']['country-name'] = $user->getCountryName();
                $_SESSION['operator']['office-name'] = $user->getOffice();
                $_SESSION['operator']['avatar'] = rand(1, 50);

                // Audit the user login
                Utils::insertUserAuditEntry();

                if (!empty($_SESSION['page'])) {
                    if (!empty($_SESSION['id'])) {
                        unset($_SESSION['page']);
                        unset($_SESSION['id']);
                        header('Location: /?page=' . $_GET['page'] . '&id=' . $_GET['id']);
                    } else {
                        unset($_SESSION['page']);
                        header('Location: /?page=' . $_GET['page']);
                    }
                } else {
                    header('Location: /');
                }

                return;
            } else {
                AppLogger::getLogger()->debug('Wrong password. Got ' . $password . ', expected ' . $user->getPassword());
                $_SESSION['alert']['type'] = 'error';
                $_SESSION['alert']['width'] = 12;
                $_SESSION['alert']['message'] = 'Wrong username/password.';
            }
        } else {
            $_SESSION['alert']['type'] = 'error';
            $_SESSION['alert']['width'] = 12;
            $_SESSION['alert']['message'] = 'No such user found in the system.';
        }
    }
    catch(ApplicationException $ae) {
        return false;
    }
    catch(Exception $e) {
        Utils::handleException($e);
        return false;
    }
}
else {
    if (!empty( $_POST ['_forgot_password'] )) { // Forgot password
        if(Utils::addResetKey($_POST ['email'])) {
            $_SESSION['alert']['type']='success';
            $_SESSION['alert']['width']=12;
            $_SESSION['alert']['message']='Your change request was processed. Please check your inbox for further details.';
        }
        else {
            $_SESSION['alert']['type']='error';
            $_SESSION['alert']['width']=12;
            $_SESSION['alert']['message']='An error occurred while trying to reset your password.';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head><base href="../../../">
    <meta charset="utf-8" />
    <title>ROHEL | Login Page</title>
    <meta name="description" content="Login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="/assets/css/pages/login/login-1.css" rel="stylesheet" type="text/css" />
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <!--end::Layout Themes-->

    <!--begin::Favicon stuff-->
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/media/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/media/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/media/favicon-16x16.png">
    <link rel="manifest" href="/assets/media/site.webmanifest">
    <link rel="mask-icon" href="/assets/media/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/assets/media/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/assets/media/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <!--end::Favicon stuff-->
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-static page-loading">
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <!--begin::Aside-->
        <div class="login-aside d-flex flex-column flex-row-auto" style="background-color: #7EBFDB;">
            <!--begin::Aside Top-->
            <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
                <!--begin::Aside header-->
                <a href="#" class="text-center mb-15">
                    <img src="/assets/media/logos/package.svg" alt="logo" class="h-300px" />
                </a>
                <!--end::Aside header-->
                <!--begin::Aside title
                <h3 class="font-weight-bolder text-center font-size-h2 font-size-h1-lg text-white">ROHEL
                    <br />TRANS</h3>
                end::Aside title-->
            </div>
            <!--end::Aside Top-->
            <!--begin::Aside Bottom
            <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" style="background-image: url('/assets/media/svg/illustrations/data-points.svg')"></div>
                end::Aside Bottom-->
        </div>
        <!--begin::Aside-->
        <!--begin::Content-->
        <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
            <!--begin::Content body-->
            <div class="d-flex flex-column-fluid flex-center">
                <!--begin::Signin-->
                <div class="login-form login-signin">
                    <!--begin::Form-->
                    <form class="form" novalidate="novalidate" id="kt_login_signin_form" action="" method="post">
                        <input type="hidden" name="_signin" value="true">
                        <!--begin::Title-->
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Welcome</h3>
                            <span class="text-muted font-weight-bold font-size-h4">Please enter your e-mail address and application password below</span>
                        </div>
                        <!--end::Title-->

                        <!--begin::Error messages-->
                        <?php include $_SERVER["DOCUMENT_ROOT"]."/pages/internal/displayAlert.php"; ?>
                        <!--end::Error messages-->

                        <!--begin::Form group-->
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">Email</label>
                            <input class="form-control form-control-solid h-auto p-6 rounded-lg" type="text" name="username" autocomplete="off" />
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <div class="d-flex justify-content-between mt-n5">
                                <label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>
                                <a href="javascript:;" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5" id="kt_login_forgot">Forgot Password ?</a>
                            </div>
                            <input class="form-control form-control-solid h-auto p-6 rounded-lg" type="password" name="password" autocomplete="off" />
                        </div>
                        <!--end::Form group-->

                        <!--begin::Action-->
                        <div class="pb-lg-0 pb-5">
                            <button
                                    data-sitekey="6LcJhhwdAAAAANuI9vrDD9clsIdHtEwYxdjYSrwC"
                                    data-action='submit'
                                    type="button"
                                    id="kt_login_signin_submit"
                                    class="g-recaptcha btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">
                                Sign In
                            </button>
                        </div>
                        <!--end::Action-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Signin-->
                <!--begin::Signup-->
                <div class="login-form login-signup">
                    <!--begin::Form-->
                    <form class="form" novalidate="novalidate" id="kt_login_signup_form">
                        <!--begin::Title-->
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Sign Up</h3>
                            <p class="text-muted font-weight-bold font-size-h4">Enter your details to create your account. Your request will be processed and you will be notified if accepted.</p>
                        </div>
                        <!--end::Title-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6" type="text" placeholder="Fullname" name="fullname" autocomplete="off" />
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6" type="email" placeholder="Email" name="email" autocomplete="off" />
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6" type="password" placeholder="Password" name="password" autocomplete="off" />
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6" type="password" placeholder="Confirm password" name="cpassword" autocomplete="off" />
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group d-flex align-items-center">
                            <label class="checkbox mb-0">
                                <input type="checkbox" name="agree" />
                                <span></span>
                            </label>
                            <div class="pl-2">I Agree the
                                <a href="#" class="ml-1">terms and conditions</a></div>
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group d-flex flex-wrap pb-lg-0 pb-3">
                            <button type="button" id="kt_login_signup_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">Submit</button>
                            <button type="button" id="kt_login_signup_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">Cancel</button>
                        </div>
                        <!--end::Form group-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Signup-->
                <!--begin::Forgot-->
                <div class="login-form login-forgot">
                    <!--begin::Form-->
                    <form class="form" novalidate="novalidate" id="kt_login_forgot_form" action="" method="post">
                        <input type="hidden" name="_forgot_password" id="_forgot_password" value="true" />
                        <!--begin::Title-->
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Forgotten Password ?</h3>
                            <p class="text-muted font-weight-bold font-size-h4">Enter your email to reset your password</p>
                        </div>
                        <!--end::Title-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6" type="email" placeholder="Email" name="email" id="email" autocomplete="off" />
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group d-flex flex-wrap pb-lg-0">
                            <button
                                    data-sitekey="6LccLxodAAAAAGlQMXfgvzb-oN8fJIpM4RdbfggT"
                                    data-action='submit'
                                    type="button"
                                    id="kt_login_forgot_submit"
                                    class="g-recaptcha btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">
                                Submit
                            </button>
                            <button type="button" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">Cancel</button>
                        </div>
                        <!--end::Form group-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Forgot-->
            </div>
            <!--end::Content body-->
            <!--begin::Content footer-->
            <div class="d-flex justify-content-lg-start justify-content-center align-items-end py-7 py-lg-0">
                <a href="/?page=help" class="text-primary font-weight-bolder font-size-h5">Help</a>
                <a href="http://www.rohel.ro/contact/" class="text-primary ml-10 font-weight-bolder font-size-h5">Contact Us</a>
            </div>
            <!--end::Content footer-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Login-->
</div>
<!--end::Main-->
<script>const HOST_URL = "https://preview.keenthemes.com/keen/theme/tools/preview";</script>
<!--begin::Global Config(global config for global JS scripts)-->
<script>const KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#0BB783", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#D7F9EF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->
<script src="/assets/plugins/global/plugins.bundle.js"></script>
<script src="/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
<script src="/assets/js/scripts.bundle.js"></script>
<!--end::Global Theme Bundle-->
<!--begin::Page Scripts(used by this page)-->
<script src="/assets/js/login.js"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
<!--end::Page Scripts-->
</body>
<!--end::Body-->
</html>