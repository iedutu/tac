<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

if(isset($_POST['id'])) {
    // TODO: Ensure you do not need any date related checks before updating

    $table = '';
    try {
        switch ($_SESSION['app']) {
            case 'cargoInfo':
            {
                $table = 'cargo_request';
                break;
            }
            case 'truckInfo':
            {
                $table = 'cargo_truck';
                break;
            }
            default:
            {
                error_log('In-place editing failed. Requested to change a filed without being notified of which page we are on.');
                return;
            }
        }

        DB::getMDB()->update($table, array(
            $_POST['id'] => $_POST['value'],
            'operator' => $_SESSION['operator'],
        ), "id=%d", $_SESSION['entry-id']);

        Utils::cargo_audit($table, $_POST['id'], $_SESSION['entry-id'], $_POST['value']);
        Utils::email_notification($_POST['id'], $_POST['value'], $_SESSION['entry-id']);
        DB::getMDB()->commit();
    }
    catch (MeekroDBException $mdbe) {
        error_log("Database error: ".$mdbe->getMessage());
    }
    catch (Exception $e) {
        error_log("Database error: ".$e->getMessage());
    }

    echo $_POST['value'];
}
