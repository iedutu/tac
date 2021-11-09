<?php

use PHPMailer\PHPMailer\PHPMailer;
use Rohel\Notification;

session_start ();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";
include $_SERVER["DOCUMENT_ROOT"]."/lib/mail-settings.php";

if (empty($_POST['id'])) {
    header('Location: /index.php?page=cargo');
    exit();
}

try {
    $cargo = DB_utils::selectRequest($_POST ['id']);
    if (empty($cargo)) {
        header('Location: /index.php?page=cargo');
        exit();
    }

    if ($cargo->getStatus() >= AppStatuses::$CARGO_ACCEPTED) {
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Cargo already acknowledged/cancelled and cannot be cancelled. Please contact the recipient directly.';

        header('Location: /index.php?page=cargoInfo&id=' . $cargo->getId());
        exit();
    }

    if ($cargo->getOriginator() != $_SESSION['operator']['id']) {
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'You cannot cancel orders created by others.';

        header('Location: /index.php?page=cargoInfo&id=' . $cargo->getId());
        exit();
    }

    DB_utils::cancelCargo($cargo->getId());
    Utils::insertCargoAuditEntry('cargo_request', 'status', $cargo->getId(), AppStatuses::$CARGO_CANCELLED);

    // Set the trigger for the generation of the Match page
    DB_utils::writeValue('changes', '1');

    // Add a notification to the receiver of the cargo
    $note = new Notification();
    $note->setUserId($cargo->getRecipient());
    $note->setOriginatorId($_SESSION['operator']['id']);
    $note->setKind(AppStatuses::$NOTIFICATION_KIND_CANCELLED);
    $note->setEntityKind(AppStatuses::$NOTIFICATION_ENTITY_KIND_CARGO);
    $note->setEntityId($cargo->getId());

    DB_utils::addNotification($note);

    $_SESSION['alert']['type'] = 'success';
    $_SESSION['alert']['message'] = 'cargo was successfully cancelled.';
    if (!empty($cargo->getAmeta())) {
        $_SESSION['alert']['message'] = 'cargo with ameta ' . $cargo->getAmeta() . ' was successfully cancelled.';
    }

    // Send a notification e-mail to the recipient
    $originator = DB_utils::selectUserById($cargo->getOriginator());
    $recipient = DB_utils::selectUserById($cargo->getRecipient());

    $email['subject'] = 'cargo cancelled by ' . $originator->getName();
    $email['title'] = 'ROHEL | E-mail';
    $email['header'] = 'A cargo was cancelled by ' . $originator->getName();
    $email['body-1'] = 'has cancelled a cargo bound for <strong>' . $cargo->getToCity() . '</strong>' . '.';
    $email['body-2'] = 'The loading date was <strong>' . date(Utils::$PHP_DATE_FORMAT, $cargo->getLoadingDate()) . '</strong>';
    $email['originator']['e-mail'] = $originator->getUsername();
    $email['originator']['name'] = $originator->getName();
    $email['recipient']['e-mail'] = $recipient->getUsername();
    $email['recipient']['name'] = $recipient->getName();
    $email['link']['url'] = Mails::$BASE_HREF.'/?page=cargo';
    $email['link']['text'] = 'View the remaining cargos';
    $email['bg-color'] = Mails::$BG_CANCELLED_COLOR;
    $email['tx-color'] = Mails::$TX_CANCELLED_COLOR;

    Mails::emailNotification($email);
}
catch (ApplicationException $ae) {
    $_SESSION['alert']['type'] = 'error';
    $_SESSION['alert']['message'] = 'Application error ('.$ae->getCode().':'.$ae->getMessage().'). Please contact your system administrator.';
    return 0;
}
catch (Exception $e) {
    Utils::handleException($e);
    $_SESSION['alert']['type'] = 'error';
    $_SESSION['alert']['message'] = 'Application error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';
    return 0;
}


$_SESSION['alert']['message'] .= 'Cancellation e-mail sent to '.$email['recipient']['name'].' ('.$email['recipient']['e-mail'].')';

header ( 'Location: /index.php?page=cargo' );
exit();