<?php
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

        Utils::insertCargoAuditEntry('cargo_request', 'acceptance', $cargo->getId(), date("Y-m-d H:i:s"));
        Utils::insertCargoAuditEntry('cargo_request', 'accepted_by', $cargo->getId(), $cargo->getAcceptedBy());
        Utils::insertCargoAuditEntry('cargo_request', 'status', $cargo->getId(), 2);

        // Set the trigger for the generation of the Match page
        DB_utils::writeValue('changes', '1');

        // Add a notification to the receiver of the cargo request
        DB_utils::addNotification($_SESSION['originator-id'], 3, 1, $cargo->getId());

        // Send a notification e-mail to the recipient
        $acceptor = DB_utils::selectUserById($cargo->getAcceptedBy());
        $originator = DB_utils::selectUserById($cargo->getOriginator());
        $recipient = DB_utils::selectUserById($cargo->getRecipient());

        $email['subject'] = 'Cargo request acknowledged by ' . $acceptor->getName();
        $email['title'] = 'ROHEL | E-mail';
        $email['header'] = 'A cargo request was acknowldged by ' . $acceptor->getName();
        $email['body-1'] = 'has acknowledged a cargo request bound for <strong>' . $cargo->getToCity() . '</strong>' . '.';
        $email['body-2'] = 'The loading date is <strong>' . date(Utils::$PHP_DATE_FORMAT, $cargo->getLoadingDate()) . '</strong>';
        $email['originator']['e-mail'] = $originator->getUsername();
        $email['originator']['name'] = $originator->getName();
        $email['recipient']['e-mail'] = $recipient->getUsername();
        $email['recipient']['name'] = $recipient->getName();
        $email['link']['url'] = 'https://rohel.iedutu.com/?page=cargoInfo&id='.$cargo->getId();
        $email['link']['text'] = 'View the updated cargo request';
        $email['color'] = Mails::$ACKNOWLEDGED_COLOR;

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