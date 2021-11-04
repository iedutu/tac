<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

if(!isset($_SESSION['operator']['id'])) {
    exit ();
}

try {
    $results = DB::getMDB()->query ( "SELECT
                                        a.id as 'id', a.username as 'username'
                                     FROM 
                                        cargo_users a,
                                        cargo_offices b,
                                        cargo_countries c  
                                     WHERE
                                        (a.office_id = b.id) and
                                        (b.country = c.id) and
                                        (a.id<>%d) and
                                        (c.id<>%d) and
                                        (a.class<2)
                                     ORDER BY a.name", $_SESSION['operator']['id'], $_SESSION['operator']['country-id']);
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