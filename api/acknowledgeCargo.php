<?php

use Rohel\Notification;

session_start();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

if(!empty($_POST['id'])) {
    // TODO: Ensure you do not need any date related checks before updating

    $cargo = DB_utils::selectRequest($_SESSION['entry-id']);
    if (empty($cargo)) {
        header('Location: /index.php?page=cargo');
        exit();
    }

    if ($cargo->getStatus() > AppStatuses::$CARGO_ACCEPTED) {
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Cargo already closed or cancelled.';

        header('Location: /index.php?page=cargoInfo&id=' . $cargo->getId());
        exit();
    }

    try {
        // Aceptance fileds update
        $cargo->setAcceptedBy($_SESSION ['operator']['id']);
        DB_utils::acknowledgeCargo($cargo);

        Audit::highlightPageItem('cargo_request', 'accepted_by', $cargo->getId());
        Audit::highlightPageItem('cargo_request', 'acceptance', $cargo->getId());
        if(!empty($_POST['value'])) Audit::highlightPageItem('cargo_request', 'plate_number', $cargo->getId());

        Utils::insertCargoAuditEntry('cargo_request', 'acceptance', $cargo->getId(), date("Y-m-d H:i:s"));
        Utils::insertCargoAuditEntry('cargo_request', 'accepted_by', $cargo->getId(), $cargo->getAcceptedBy());

        // Status updates
        if(empty($cargo->getPlateNumber())) {
            Utils::insertCargoAuditEntry('cargo_request', 'status', $cargo->getId(), AppStatuses::$CARGO_ACCEPTED);
        }
        else {
            // Truck is already acknowledged --> moving to Closed
            DB_utils::updateCargoStatus($cargo, AppStatuses::$CARGO_SOLVED);
            Utils::insertCargoAuditEntry('cargo_request', 'status', $cargo->getId(), AppStatuses::$CARGO_SOLVED);
        }

        // Set the trigger for the generation of the Match page
        DB_utils::writeValue('changes', '1');

        // Add a notification to the originator of the cargo
        $note = new Notification();
        $note->setUserId($cargo->getOriginator());
        $note->setOriginatorId($_SESSION['operator']['id']);
        $note->setKind(AppStatuses::$NOTIFICATION_KIND_APPROVED);
        $note->setEntityKind(AppStatuses::$NOTIFICATION_ENTITY_KIND_CARGO);
        $note->setEntityId($cargo->getId());

        DB_utils::addNotification($note);

        // Send a notification e-mail to the recipient
        $acceptor = DB_utils::selectUserById($cargo->getAcceptedBy());
        $originator = DB_utils::selectUserById($cargo->getOriginator());
        $recipient = DB_utils::selectUserById($cargo->getRecipient());

        $email['subject'] = 'Cargo acknowledged by ' . $acceptor->getName();
        $email['title'] = 'ROHEL | E-mail';
        $email['header'] = 'A cargo was acknowldged by ' . $acceptor->getName();
        $email['body-1'] = 'has acknowledged a cargo bound for <strong>' . $cargo->getToCity() . '</strong>' . '.';
        $email['body-2'] = 'The loading date is <strong>' . date(Utils::$PHP_DATE_FORMAT, $cargo->getLoadingDate()) . '</strong>';
        $email['originator']['e-mail'] = $acceptor->getUsername();
        $email['originator']['name'] = $acceptor->getName();
        $email['recipient']['e-mail'] = $originator->getUsername();
        $email['recipient']['name'] = $originator->getName();
        $email['link']['url'] = Mails::$BASE_HREF.'/?page=cargoInfo&id='.$cargo->getId();
        $email['link']['text'] = 'View the updated cargo';
        $email['bg-color'] = Mails::$BG_ACKNOWLEDGED_COLOR;
        $email['tx-color'] = Mails::$TX_ACKNOWLEDGED_COLOR;

        Mails::emailNotification($email);
    }
    catch (ApplicationException $ae) {
        AppLogger::getLogger()->error('Application exception: '.$ae->getMessage());
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Application error: '.$ae->getMessage();
        header('Location: /index.php?page=cargoInfo&id='.$cargo->getId());
        exit();
    }
    catch (Exception $e) {
        Utils::handleException($e);
        AppLogger::getLogger()->error('Application exception: '.$e->getMessage());
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Application error: '.$e->getMessage();
        header('Location: /index.php?page=cargoInfo&id='.$cargo->getId());
        exit();
    }

    $_SESSION['alert']['type'] = 'success';
    $_SESSION['alert']['message'] = 'Cargo successfully acknowledged. An e-mail notification was sent to '.$originator->getName();
    header('Location: /index.php?page=cargoInfo&id='.$cargo->getId());
    exit();
}
else {
    header('Location: /index.php?page=cargo');
    exit();
}