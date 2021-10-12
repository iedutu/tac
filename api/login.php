<?php
session_start ();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

$success = false;
$message = "Not attempted";
$page = "/";

$username = $_POST ['username'];
$password = hash("sha256", $_POST ['password']);

try {
    $row = DB::getMDB()->queryFirstRow("SELECT * FROM cargo_users WHERE username=%s and password=%s", $username, $password);
}
catch (MeekroDBException $mdbe) {
    error_log("Database error: ".$mdbe->getMessage());
    $_SESSION['alert']['type'] = 'error';
    $_SESSION['alert']['message'] = 'Database error ('.$mdbe->getCode().':'.$mdbe->getMessage().'). Please contact your system administrator.';

    return 0;
}
catch (Exception $e) {
    error_log("Database error: ".$e->getMessage());
    $_SESSION['alert']['type'] = 'error';
    $_SESSION['alert']['message'] = 'Database error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';

    return 0;
}

if ($row == null) {
    $message = "No such valid username/password combination.";
} else {
    $_SESSION['app'] = 'cargo';
    $_SESSION['class'] = $row['class'];
    $_SESSION['operator_id'] = $row['id'];
    $_SESSION['operator'] = $row['username'];
    $_SESSION['operator_class'] = array();
    $_SESSION['operator_class']['insert'] = ($row['insert'] == 1) ? true : false;
    $_SESSION['operator_class']['reports'] = ($row['reports'] == 1) ? true : false;

// One country per username
    if ($row['turkey'] == 1) {
        $_SESSION['operator_class']['country'] = 'turkey';
    }
    if ($row['greece'] == 1) {
        $_SESSION['operator_class']['country'] = 'greece';
    }
    if ($row['serbia'] == 1) {
        $_SESSION['operator_class']['country'] = 'serbia';
    }
    if ($row['romania'] == 1) {
        $_SESSION['operator_class']['country'] = 'romania';
    }
    if ($row['moldova'] == 1) {
        $_SESSION['operator_class']['country'] = 'moldova';
    }

// Multiple countries per username
    $_SESSION['operator_class']['turkey'] = $row['turkey'];
    $_SESSION['operator_class']['serbia'] = $row['serbia'];
    $_SESSION['operator_class']['romania'] = $row['romania'];
    $_SESSION['operator_class']['greece'] = $row['greece'];
    $_SESSION['operator_class']['moldova'] = $row['moldova'];

    $_SESSION['login_error'] = 0;

    $params = '';
    if (isset($_POST['page'])) {
        if (isset($_POST['id'])) {
            $params = '?page=' . $_POST['page'] . '&id=' . $_POST['id'];
            if (isset($_POST['type'])) {
                $params = '?page=' . $_POST['page'] . '&type=' . $_POST['type'] . '&id=' . $_POST['id'];
            }
        } else {
            $params = '?page=' . $_POST['page'];
        }
    }

    $page = "/index.php".$params;
    $success = true;
    $message = "Login successful!";

    // TODO: Insert audit record for successful login.
}

echo json_encode(array("valid"=>$success));