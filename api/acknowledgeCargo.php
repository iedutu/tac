<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

if(isset($_POST['id'])) {
    // TODO: Ensure you do not need any date related checks before updating

    $table = '';

    error_log(('ID: '.$_POST['id'].', Value: '.$_POST['value']));

    try {
        DB::getMDB()->update('cargo_request', array(
            'acceptance' => date("Y-m-d H:i:s"),
            'accepted_by' => $_SESSION ['operator']['id'],
            $_POST ['id'] => $_POST ['value'],
            'status' => 2
        ), "id=%d", $_SESSION['entry-id']);

        Utils::insertCargoAuditEntry('cargo_request', 'acceptance', $_SESSION['entry-id'], date("Y-m-d H:i:s"));
        Utils::insertCargoAuditEntry('cargo_request', 'accepted_by', $_SESSION['entry-id'], $_SESSION ['operator']['username']);
        Utils::insertCargoAuditEntry('cargo_request', 'status', $_SESSION['entry-id'], 1);

        // Set the trigger for the generation of the Match page
        DB_utils::writeValue('changes', '1');

        // Add a notification to the receiver of the cargo request
        DB_utils::addNotification($_SESSION['originator-id'], 3, 1, $_SESSION['entry-id']);

        // TODO: Send a proper acknowledgement e-mail.
        // Utils::email_notification($_POST['id'], $_POST['value'], $_SESSION['entry-id']);
        DB::getMDB()->commit();
    }
    catch (MeekroDBException $mdbe) {
        Utils::handleMySQLException($mdbe);
        return null;
    }
    catch (Exception $e) {
        Utils::handleException($e);
        return null;
    }

    echo $_POST['value'];
}