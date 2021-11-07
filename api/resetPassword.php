<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/lib/includes.php";

if(empty($_GET['key'])) {
    header ( 'Location: /' );
    exit();
}

if(Utils::resetPassword($_GET['key'])) {
    $_SESSION['alert']['type']='success';
    $_SESSION['alert']['width']=12;
    $_SESSION['alert']['message']='Your password was successfully changed and the new one has been sent to your inbox. Please use it when logging in below.';
    header ( 'Location: /?page=login' );
    exit();
}

header ( 'Location: /' );
exit();