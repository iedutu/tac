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

        switch($_POST['id']) {
            case 'acceptance':
            case 'availability':
            case 'expiration':
            case 'loading_date':
            case 'unloading_date':
            {
                DB::getMDB()->update($table, array(
                    $_POST['id'] => DB::getMDB()->sqleval("str_to_date(%s, %s)", $_POST['value'], Utils::$SQL_DATE_FORMAT),
                    'operator' => $_SESSION['operator']['username'],
                ), "id=%d", $_SESSION['entry-id']);

                break;
            }
            default: {
                DB::getMDB()->update($table, array(
                    $_POST['id'] => $_POST['value'],
                    'operator' => $_SESSION['operator']['username'],
                ), "id=%d", $_SESSION['entry-id']);

                break;
            }
        }

        Utils::insertCargoAuditEntry($table, $_POST['id'], $_SESSION['entry-id'], $_POST['value']);
        Utils::audit_update($table, $_POST['id'], $_SESSION['entry-id']);

        // Set the trigger for the generation of the Match page
        DB_utils::writeValue('changes', '1');

        // Add a notification to the receiver of the cargo request
        DB_utils::addNotification($_SESSION['recipient-id'], 2, $_SESSION['entry-kind'], $_SESSION['entry-id']);

        DB::getMDB()->commit();

        Utils::email_notification($_POST['id'], $_POST['value'], $_SESSION['entry-id']);
    } catch (\PHPMailer\PHPMailer\Exception $me) {
        Utils::handleMailException($me);
        return null;
    } catch (MeekroDBException $mdbe) {
        Utils::handleMySQLException($mdbe);
        return 0;
    } catch (Exception $e) {
        Utils::handleException($e);
        return null;
    }

    echo $_POST['value'];
}
