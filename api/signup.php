<?php
session_start ();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

use Rohel\Notification;

if (isset ( $_POST ['_submitted'] )) {
    $user = new \Rohel\User();

    try {
        DB::getMDB()->startTransaction();
        $user->setClass(Utils::$USER_CLASS_REGULAR);
        $user->setInsert(1);
        $user->setReports(1);
        $user->setName($_POST['name']);
        $user->setUsername($_POST['email2']);
        $user->setOfficeId($_POST['office']);
        $user->setPassword(UTILS::randomString(Utils::$PASSWORD_LENGTH));

        $user->setId(DB_utils::insertUser($user));
        // Keep a record of what happened
        Utils::insertCargoAuditEntry('cargo_users', 'NEW-ENTRY', null, $user->getId(), $user);

        DB::getMDB()->commit();

        // Send the password by e-mail
        $email['subject'] = 'ROHEL | New application password ';
        $email['title'] = 'ROHEL | E-mail';
        $email['header'] = 'New application password generated';
        $email['body-1'] = 'Hi ' . $user->getName() . '!';
        $email['body-2'] = 'Please use the following password for your next visit to our application: <strong>' . $user->getPassword() . '</strong>';
        $email['recipient']['e-mail'] = $user->getUsername();
        $email['recipient']['name'] = $user->getName();
        $email['originator']['e-mail'] = Mails::$WEBMASTER_EMAIL;
        $email['originator']['name'] = Mails::$WEBMASTER_NAME;
        $email['link']['url'] = Utils::$BASE_URL;
        $email['link']['text'] = 'Application link';
        $email['bg-color'] = Mails::$BG_ACKNOWLEDGED_COLOR;
        $email['tx-color'] = Mails::$TX_CANCELLED_COLOR;

        Mails::emailNotification($email, 'template-2.php');
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
    $_SESSION['alert']['message'] = 'User '.$user->getName().' was added and notified by e-mail.';
}

header ( "Location: /" );
exit();