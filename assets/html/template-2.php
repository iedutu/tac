<!DOCTYPE html>
<html lang="en-US">
<!--begin::Head-->
<head><base href="<?=Mails::$BASE_HREF?>">
    <meta charset="utf-8" />
    <title>ROHRL | E-mail</title>
    <meta name="description" content="E-mail" />
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
    <link rel="shortcut icon" href="/assets/media/logos/favicon.ico" />
</head>
<!--end::Head--><body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
<div id="wrapper" dir="ltr" style="background-color: #f7f7f7; margin: 0; padding: 70px 0 70px 0; width: 100%; -webkit-text-size-adjust: none;">
    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
        <tr>
            <td align="center" valign="top">
                <div id="template_header_image">
                </div>
                <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container" style="background-color: #ffffff;border: 1px solid #dedede; box-shadow: 0 1px 4px rgba(0,0,0,0.1); border-radius: 3px;">
                    <tr>
                        <td align="center" valign="top">
                            <!-- Header -->
                            <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header" style='background-color: #96588a; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; border-radius: 3px 3px 0 0;'>
                                <tr>
                                    <td id="header_wrapper" style="padding: 36px 48px; display: block; background-color: <?=$email['bg-color']?>;">
                                        <h1 style='font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: center; text-shadow: 0 1px 0 #ab79a1; -webkit-font-smoothing: antialiased; color: <?=$email['tx-color']?>;'>
                                            <?=$email['header']?>
                                        </h1>
                                    </td>
                                </tr>
                            </table>
                            <!-- End Header -->
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">
                            <!-- Body -->
                            <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
                                <tr>
                                    <td valign="top" id="body_content" style="background-color: #ffffff;">
                                        <!-- Content -->
                                        <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                            <tr>
                                                <td valign="top" style="padding: 48px;">
                                                    <div id="body_content_inner"style='color: #636363; font-family: "Helvetica Neue", Helvetica, Roboto,Arial, sans-serif; font-size: 14px; line-height: 150%; text-align: left;'>
                                                        <p style="margin: 0 0 16px;">
                                                            <?=$email['body-1']?>
                                                        </p>
                                                        <?php
                                                        if(!empty($email['body-2'])) {
                                                            echo '
                                                        <p style="margin: 0 0 16px;">
                                                            '.$email['body-2'].'
                                                        </p>
                                                            ';
                                                        }
                                                        ?>
                                                        <ul>
                                                            <li> <a href="<?=$email['link']['url']?>" style="text-decoration: underline; color: #00A4FF;"><?=$email['link']['text']?></a>.</li>
                                                            <li> <a href="mailto:support@rohel.ro" target="_blank" style="text-decoration: underline; color: #00A4FF;">Help & Support</a>.</li>
                                                        </ul>
                                                        <br>
                                                        <p style="margin: 0 0 0px;">Cheers,<br>Team Rohel</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- End Content -->
                                    </td>
                                </tr>
                            </table>
                            <!-- End Body -->
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>