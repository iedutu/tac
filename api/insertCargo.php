<?php
session_start ();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

use PHPMailer\PHPMailer\PHPMailer;
use Rohel\Notification;
use Rohel\Request;

if (! Utils::authorized(Utils::$INSERT)) {
    AppLogger::getLogger()->info("User not authorized to insert data in the database.");
    header ( 'Location: /' );
    exit ();
}

if (isset ( $_POST ['_submitted'] )) {
    $cargo = new Request();

    try {
        DB::getMDB()->startTransaction();
        $cargo->setStatus(AppStatuses::$CARGO_NEW);
        $cargo->setClient($_POST ['client']);
        $cargo->setOriginator($_SESSION['operator']['id']);
        $cargo->setRecipient($_POST ['recipient']);
        $cargo->setFromCity($_POST ['from_city']);
        $cargo->setFromAddress($_POST ['from_address']);
        $cargo->setToCity($_POST ['to_city']);
        $cargo->setToAddress($_POST ['to_address']);
        if(!empty($_POST ['rohel_cargo_expiration'])) $cargo->setExpiration(strtotime($_POST ['rohel_cargo_expiration']));
        if(!empty($_POST ['rohel_cargo_loading'])) $cargo->setLoadingDate(strtotime($_POST ['rohel_cargo_loading']));
        if(!empty($_POST ['rohel_cargo_unloading'])) $cargo->setUnloadingDate(strtotime($_POST ['rohel_cargo_unloading']));
        $cargo->setDescription($_POST ['description']);
        $cargo->setCollies($_POST ['collies']);
        $cargo->setWeight($_POST ['weight']);
        $cargo->setLoadingMeters($_POST ['loading']);
        $cargo->setVolume($_POST ['volume']);
        $cargo->setInstructions($_POST ['instructions']);
        if(!empty($_POST['freight'])) $cargo->setFreight($_POST ['freight']);
        if(!empty($_POST['adr'])) $cargo->setAdr($_POST ['adr']);
        $cargo->setOrderType($_POST ['order_type']);
        $cargo->setDimensions($_POST ['dimensions']);
        $cargo->setPackage($_POST ['package']);

        $cargo->setId(DB_utils::insertRequest($cargo));
        // Keep a record of what happened
        Utils::insertCargoAuditEntry('cargo_request', 'NEW-ENTRY', null, $cargo->getId());

        // Set the trigger for the generation of the Match page
        DB_utils::writeValue('changes', '1');
        DB::getMDB()->commit();

        // Add a notification to the receiver of the cargo
        $note = new Notification();
        $note->setUserId($cargo->getRecipient());
        $note->setOriginatorId($_SESSION['operator']['id']);
        $note->setKind(AppStatuses::$NOTIFICATION_KIND_NEW);
        $note->setEntityKind(AppStatuses::$NOTIFICATION_ENTITY_KIND_CARGO);
        $note->setEntityId($cargo->getId());

        DB_utils::addNotification($note);

        // Send a notification e-mail to the recipient
        $originator = DB_utils::selectUserById($cargo->getOriginator());
        $recipient = DB_utils::selectUserById($cargo->getRecipient());

        $email['subject'] = 'New cargo received from '.$originator->getName();
        $email['title'] = 'ROHEL | E-mail';
        $email['header'] = ' You have a new cargo from '.$originator->getName();
        $email['body-1'] = 'has introduced a new cargo for your consideration and acknowledgement.';
        $email['body-2'] = 'The loading date is <strong>'.date(Utils::$PHP_DATE_FORMAT, $cargo->getLoadingDate()).'</strong>';
        $email['originator']['e-mail'] = $originator->getUsername();
        $email['originator']['name'] = $originator->getName();
        $email['recipient']['e-mail'] = $recipient->getUsername();
        $email['recipient']['name'] = $recipient->getName();
        $email['link']['url'] = Mails::$BASE_HREF.'/?page=cargoInfo&id='.$cargo->getId();
        $email['link']['text'] = 'View & acknowledge the new order';
        $email['bg-color'] = Mails::$BG_NEW_COLOR;
        $email['tx-color'] = Mails::$TX_NEW_COLOR;

        Mails::emailNotification($email);
    }
    catch (ApplicationException $ae) {
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Application error ('.$ae->getCode().':'.$ae->getMessage().'). Please contact your system administrator.';
        return;
    }
    catch (Exception $e) {
        Utils::handleException($e);
        $_SESSION['alert']['type'] = 'error';
        $_SESSION['alert']['message'] = 'Application error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';
        return;
    }

    $_SESSION['alert']['type'] = 'success';
    $_SESSION['alert']['message'] = 'A new notification was added into the system for the cargo. '.$recipient->getName().' was notified by e-mail.';

    header ( "Location: /?page=cargo" );
    exit();
}

header ( "Location: /" );
exit();