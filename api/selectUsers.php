<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

if(!isset($_SESSION['operator']['id'])) {
    exit ();
}

try {
    $results = DB::getMDB()->query ( "SELECT
                                        id, username
                                     FROM 
                                        cargo_users
                                     WHERE
                                        (id<>%d) and (class<2)
                                     ORDER BY name", $_SESSION['operator']['id']);
    $users = array();

    foreach($results as $result){
        $users[$result['username']] = $result['username'];
    }

    echo json_encode($users);
} catch (MeekroDBException $mdbe) {
    Utils::handleMySQLException($mdbe);

    return null;
} catch (Exception $e) {
    Utils::handleException($e);

    return null;
}

return;