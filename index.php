<?php

session_start ();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

$page = "";

if (! isset ( $_SESSION ['operator']['id'] )) {
    // No-one logged-in

    if(!empty($_GET['page'])) {
        if(!empty($_GET['id'])) {
            header ( 'Location: pages/login.php?page='.$_GET['page'].'&id='.$_GET['id'] );
        }
        else {
            header ( 'Location: pages/login.php?page='.$_GET['page'] );
        }
    }
    else {
        header('Location: pages/login.php');
    }

    return;
}
else {
    if (isset ($_GET ['page'])) {
        switch ($_GET ['page']) {
            case 'login':
            {
                header('Location: pages/login.php');
                return;
            }
            case 'logout':
            {
                Utils::logout();
                header('Location: pages/login.php');
                return;
            }
            case 'admin':
            {
                if (!Utils::authorized(null, Utils::$ADMIN)) {
                    $_SESSION['app'] = 'cargo';
                }
                break;
            }
            default:
            {
                $_SESSION['app'] = $_GET['page'];
            }
        }
    }
    else {
        Utils::clean_up();
        $_SESSION['app'] = 'cargo';
    }
}

$_REQUEST['sort']['field'] = null;
$_REQUEST['sort']['sort'] = null;
?>

<!DOCTYPE html>

<html lang="en">

<!--begin::Head-->
<head>
    <base href="">
    <meta charset="utf-8" />
    <?php include 'pages/internal/displayTitle.php'; ?>
    <meta name="description" content="Updates and statistics" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->

    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
    <?php include 'pages/internal/includeStyles.php'; ?>

    <!--end::Page Vendors Styles-->

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
    <style>
        @media print {
            td {
                font-size: 20px;
            }
        }
    </style>
</head>

<!--end::Head-->

<!--begin::Body-->
<body id="kt_body" class="print-content-only header-fixed header-mobile-fixed subheader-enabled aside-enabled aside-static page-loading">

<?php include 'layout.php'; ?>

<?php include 'partials/_extras/offcanvas/quick-user.php'; ?>

<?php include 'partials/_extras/offcanvas/quick-panel.php'; ?>

<?php // include 'partials/_extras/chat.php'; ?>

<!--[html-partial:include:{"file":"partials/_extras/scrolltop.html"}]/-->

<?php // include 'partials/_extras/toolbar.php'; ?>

<!--begin::Global Config(global config for global JS scripts)-->
<script>
    var KTAppSettings = {
        "breakpoints": {
            "sm": 576,
            "md": 768,
            "lg": 992,
            "xl": 1200,
            "xxl": 1200
        },
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#0BB783",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#F3F6F9",
                    "dark": "#212121"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#D7F9EF",
                    "secondary": "#ECF0F3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#212121",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#ECF0F3",
                "gray-300": "#E5EAEE",
                "gray-400": "#D6D6E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#80808F",
                "gray-700": "#464E5F",
                "gray-800": "#1B283F",
                "gray-900": "#212121"
            }
        },
        "font-family": "Poppins"
    };
</script>

<!--end::Global Config-->

<!--begin::Global Theme Bundle(used by all pages)-->
<script src="/assets/plugins/global/plugins.bundle.js"></script>
<script src="/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
<script src="/assets/js/scripts.bundle.js"></script>
<!--end::Global Theme Bundle-->

<!--begin::Page Vendors(used by this page)-->
<script src="/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>

<!--end::Page Vendors-->

<!--begin::Page Scripts(used by this page)-->
<script src="/assets/js/pages/widgets.js"></script>
<!--begin::Page Scripts(used by this page)-->
<?php include 'pages/internal/includeScripts.php'; ?>
<!--end::Page Scripts-->

<!--end::Page Scripts-->
</body>

<!--end::Body-->
</html>
