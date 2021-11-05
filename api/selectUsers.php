<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

if(!isset($_SESSION['operator']['id'])) {
    exit ();
}

try {
    $results = DB_utils::selectUsernames($_SESSION['operator']['id']);
    $users = array();

    foreach($results as $result){
        $users[$result['username']] = $result['username'];
    }

    echo json_encode($users);
} catch (ApplicationException $ae) {
    return null;
} catch (Exception $e) {
    Utils::handleException($e);

    return null;
}

return;