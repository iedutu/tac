<?php
session_start ();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

$success = false;
$message = "Not attempted";

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
    $_SESSION['operator']['id'] = $row['id'];
    $_SESSION['operator']['class'] = $row['class'];
    $_SESSION['operator']['username]'] = $row['username'];
    $_SESSION['operator']['insert'] = $row['insert'] == 1;
    $_SESSION['operator']['reports'] = $row['reports'] == 1;
    $_SESSION['operator']['country-id'] = $row['country_id'];

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

    $page = "/".$params;
    $success = true;
    $message = "Login successful!";

    // TODO: Insert audit record for successful login.
}

echo json_encode(array("valid"=>$success));