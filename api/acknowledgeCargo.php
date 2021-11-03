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

    if ($cargo->getStatus() >= 2) {
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Cargo already acknowledged or cancelled.';

        header('Location: /index.php?page=cargoInfo&id=' . $cargo->getId());
        exit();
    }

    try {
        $cargo->setAcceptedBy($_SESSION ['operator']['id']);
        DB_utils::acknowledgeCargo($cargo, $_POST ['id'], $_POST ['value']);

        Utils::highlightPageItem('cargo_request', 'accepted_by', $cargo->getId());
        Utils::highlightPageItem('cargo_request', 'acceptance', $cargo->getId());
        error_log('------- before --------');
        Utils::highlightPageItem('cargo_request', 'plate_number', $cargo->getId());
        error_log('------- after --------');

        Utils::insertCargoAuditEntry('cargo_request', 'acceptance', $cargo->getId(), date("Y-m-d H:i:s"));
        Utils::insertCargoAuditEntry('cargo_request', 'accepted_by', $cargo->getId(), $cargo->getAcceptedBy());
        Utils::insertCargoAuditEntry('cargo_request', 'status', $cargo->getId(), 2);

        // Set the trigger for the generation of the Match page
        DB_utils::writeValue('changes', '1');

        // Add a notification to the originator of the cargo
        $note = new Notification();
        $note->setUserId($cargo->getOriginator());
        $note->setOriginatorId($_SESSION['operator']['id']);
        $note->setKind(3);
        $note->setEntityKind(1);
        $note->setEntityId($cargo->getId());

        DB_utils::addNotification($note);

        // Send a notification e-mail to the recipient
        $acceptor = DB_utils::selectUserById($cargo->getAcceptedBy());
        $originator = DB_utils::selectUserById($cargo->getOriginator());
        $recipient = DB_utils::selectUserById($cargo->getRecipient());

        $email['subject'] = 'cargo acknowledged by ' . $acceptor->getName();
        $email['title'] = 'ROHEL | E-mail';
        $email['header'] = 'A cargo was acknowldged by ' . $acceptor->getName();
        $email['body-1'] = 'has acknowledged a cargo bound for <strong>' . $cargo->getToCity() . '</strong>' . '.';
        $email['body-2'] = 'The loading date is <strong>' . date(Utils::$PHP_DATE_FORMAT, $cargo->getLoadingDate()) . '</strong>';
        $email['originator']['e-mail'] = $recipient->getUsername();
        $email['originator']['name'] = $recipient->getName();
        $email['recipient']['e-mail'] = $originator->getUsername();
        $email['recipient']['name'] = $originator->getName();
        $email['link']['url'] = Mails::$BASE_HREF.'/?page=cargoInfo&id='.$cargo->getId();
        $email['link']['text'] = 'View the updated cargo';
        $email['bg-color'] = Mails::$BG_ACKNOWLEDGED_COLOR;
        $email['tx-color'] = Mails::$TX_ACKNOWLEDGED_COLOR;

        Mails::emailNotification($email);
    }
    catch (ApplicationException $ae) {
        return null;
    }
    catch (Exception $e) {
        Utils::handleException($e);
        return null;
    }

    echo $_POST['value'];
}
else {
    header('Location: /index.php?page=cargo');
    exit();
}