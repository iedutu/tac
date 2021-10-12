<?php

use PHPMailer\PHPMailer\PHPMailer;

$uploaddir = dirname(__FILE__).'/../archive/documents/';
$file_url = 'http://'.$_SERVER['HTTP_HOST'].$rpath.'archive/documents/';
$filename = '';

if (! isset ( $_SESSION ['operator_id'] )) {
	header ( 'Location: index.php?page=login' );
	exit ();
}

if(Utils::authorized('details', Utils::$QUERY)) {
	if (isset ( $_POST ['_submitted'] )) {
		DB::insert ( 'cargo_comments', array (
				'operator' => $_SESSION['operator'],
				'SYS_CREATION_DATE' => date('Y-m-d H:i:s'),
				'comment' => $_POST ['_comment'],
				'cargo_id' => $_GET ['id']
		) );
		
		Utils::cargo_audit ('cargo_comments', 'NEW-ENTRY', null, $_GET ['id'] );
		
		DB::commit ();

		try {
			// Send any relevant e-mail
			$mail = new PHPMailer ();
		    include "../lib/mail-settings.php";

			$mail->Subject = "New cargo comment from " . $_SESSION ['operator'];
				
			$cargo_message = $_POST['_comment'];
			$url = 'http://www.rohel.ro/new/cargo/index.php?page=details&type=cargo&id='.$_GET ['id'];

			if($_SESSION['operator'] == $_POST['_originator']) {
				$mail->addAddress ( $_POST['_recipient'], $_POST['_recipient'] );
				$_SESSION ['message'] = '<p style="color: #00CC00">Comment sent to '.$_POST['_recipient'].'</p>';
			}
			else {
				$mail->addAddress ( $_POST['_originator'], $_POST['_originator'] );
				$_SESSION ['message'] = '<p style="color: #00CC00">Comment sent to '.$_POST['_originator'].'</p>';
			}
				
			ob_start ();
			include_once (dirname ( __FILE__ ) . "/../html/cargo_comment.html");
			$body = ob_get_clean ();
			$mail->msgHTML ( $body, dirname ( __FILE__ ), true ); // Create message bodies and embed images

            $mail->send ();
        } catch (\PHPMailer\PHPMailer\Exception $e) {
            $_SESSION['email_error'] = $e->errorMessage(); //Pretty error messages from PHPMailer
        } catch (Exception $e) {
            $_SESSION['email_error'] = $e->getMessage(); //Boring error messages from anything else!
        }
	}

	include "header.php";
	echo '
<div id="contents">
	<div class="features"><br>';
	
	if(isset($_SESSION['message'])) {
		echo '<h4>'.$_SESSION['message'].'</h4>';
		unset($_SESSION['message']);
	}
	
	$results = DB::queryFirstRow ( "SELECT * FROM cargo_request where (id=%d)", $_GET['id'] );
	if ($results != null) {
		$originator_country_match = DB::queryOneField($_SESSION['operator_class']['country'], "SELECT ".$_SESSION['operator_class']['country']." FROM cargo_users WHERE username=%s", $results['originator']);
		$recipient_country_match = DB::queryOneField($_SESSION['operator_class']['country'], "SELECT ".$_SESSION['operator_class']['country']." FROM cargo_users WHERE username=%s", $results['recipient']);
		
		if(($originator_country_match == '1') || ($recipient_country_match == '1')) {
			$editable = false;
			
			// Who can edit the cargo
			// 1. The one who created it
			if($_SESSION['operator'] == $results['originator']) {
				$editable = true;
			}
			// 2. The originator group
			// 3. The recipent group
			
			if($originator_country_match == '1') {
				$editable = true;
			}
			
			// Needed for the inline modifications
			$_SESSION['cargo_id'] = $results['id'];
			
			echo '
				<h1>Cargo details</h1>
				';
			
			$loading_date = 'N/A';
			$unloading_date = 'N/A';
			$expiration = 'N/A';
			$acceptance = 'N/A';
			$accepted_by = 'N/A';
		
			if(($results['loading_date'] != null) && ($results['loading_date'] != 0)){
				$loading_date = date('Y-m-d 23:59:59', strtotime($results['loading_date']));
			}
		
			if(($results['unloading_date'] != null) && ($results['unloading_date'] != 0)){
				$unloading_date = date('Y-m-d 23:59:59', strtotime($results['unloading_date']));
			}
		
			if(($results['expiration'] != null) && ($results['expiration'] != 0)){
				$expiration = date('Y-m-d 23:59:59', strtotime($results['expiration']));
			}
		
			if(($results['acceptance'] != null) && ($results['acceptance'] != 0)){
				$acceptance = date('Y-m-d H:i:s (e)', strtotime($results['acceptance']));
				$accepted_by = $results['accepted_by'];
			}
		
			$status = '';
			
			switch($results['status']) {
				case 0: $status = '<b>NEW</b>'; break;
				case 1: $status = '<b style="color: #00CC00">ACCEPTED</b>'; break;
				case 2: $status = '<b style="color: #FF0000">EXPIRED</b>'; break;
				case 3: $status = '<b style="color: #FF0000">CANCELLED</b>'; break;
				default: $status = 'ERROR';
			}

			// Expired notice
			$expired = false;
			if(Utils::isPast($expiration) && ($results['status'] == 0)) {
				$editable = false;
				$expired = true;
				$status = '<b style="color: #FF0000">EXPIRED</b>';
			}
			
			// Cancellation
			if($results['status'] == 3) {
				$editable = false;
				$status = '<b style="color: #FF0000">CANCELLED</b>';
			}
			
			echo '
			<table border="0" cellpadding="2" cellspacing="0" class="message">
				<tr valign="top">
					<td width="180px">
						Status:
					</td>
					<td>
						'.$status.'
					</td>
				</tr>
			';
			
			if($results['status'] > 0) {
				echo '
				<tr>
					<td>
						Accepted at:
					</td>
					<td>
						<b style="color: #00CC00">'.$acceptance.'</b>
					</td>
				</tr>
				<tr>
					<td>
						Accepted by:
					</td>
					<td>
						<b style="color: #00CC00">'.$accepted_by.'</b>
					</td>
				</tr>
				';
			}
			
			echo '
				<tr>
					<td>
						Originator:
					</td>
					<td>
						'.$results['originator'].'
					</td>
				</tr>
				<tr>
					<td>
						Recipient:
					</td>
					<td>
						'.$results['recipient'].'
					</td>
				</tr>
				<tr>
					<td>
						Client:
					</td>
					<td>
			';
			
			Utils::displayDynamicField($editable, 'client', $results['client'], 'N/A', NULL);
			
			echo '
					</td>
				</tr>
				<tr>
					<td>
						From:
					</td>
					<td>
						'.$results['from_city'].'
					</td>
				</tr>
				<tr>
					<td>
						To:
					</td>
					<td>
						'.$results['to_city'].'
					</td>
				</tr>
				<tr>
					<td>
						Loading
					</td>
					<td>
			';
			
			Utils::displayDynamicField($editable, 'loading_date', $loading_date, 'N/A', NULL);
			
			echo '
					</td>
				</tr>
				<tr>
					<td>
						Unloading
					</td>
					<td>
			';
			
			Utils::displayDynamicField($editable, 'unloading_date', $unloading_date, 'N/A', NULL);
			
			echo '
					</td>
				</tr>
				<tr>
					<td>
						Goods description
					</td>
					<td>
						'.(($results['description'] == NULL)?'N/A':$results['description']).'
					</td>
				</tr>
				<tr>
					<td>
						Number of collies
					</td>
					<td>
			';
			
			Utils::displayDynamicField($editable, 'collies', $results['collies'], 'N/A', NULL);
			
			echo '
					</td>
				</tr>
				<tr>
					<td>
						Gross weight
					</td>
					<td>
			';
			
			Utils::displayDynamicField($editable, 'weight', $results['weight'], 'N/A', NULL); echo ' kg';
			
			echo '
					</td>
				</tr>
				<tr>
					<td>
						Volume
					</td>
					<td>
			';
			
			Utils::displayDynamicField($editable, 'volume', $results['volume'], 'N/A', 0); echo ' cbm';
			
			echo '
					</td>
				</tr>
				<tr>
					<td>
						Loading meters
					</td>
					<td>
			';
			
			Utils::displayDynamicField($editable, 'loading_meters', $results['loading_meters'], 'N/A', 0); echo ' m';
			
			echo '
					</td>
				</tr>
				<tr>
					<td>
						Other comments
					</td>
					<td>
						'.(($results['comments'] == NULL)?'N/A':$results['comments']).'
					</td>
				</tr>
				<tr>
					<td>
						Freight
					</td>
					<td>
						'.(($results['freight'] == NULL)?'N/A':$results['freight']).'
					</td>
				</tr>
				<tr>
					<td>
						PIC
					</td>
					<td>
						'.(($results['pic'] == NULL)?'N/A':$results['pic']).'
					</td>
				</tr>
				<tr>
					<td>
						Request expires on
					</td>
					<td>
			';
			
			// 09.06.2017 - Expiration date can be changed by the originator
			Utils::displayDynamicField(($editable || ($expired && ($_SESSION['operator'] == $results['originator']))), 'expiration', $expiration, 'N/A', NULL);
			
			echo '
					</td>
				</tr>
				<tr>
					<td>
						Plate number
					</td>
					<td>
			';
			
			Utils::displayDynamicField((($recipient_country_match == '1') && ($results['status'] == 0)), 'plate_number', $results['plate_number'], 'N/A', NULL);

			echo '
					</td>
				</tr>
				<tr>
					<td>
						AMETA
					</td>
					<td>
			';
			
			Utils::displayDynamicField((($recipient_country_match == '1') && ($results['status'] == 0)), 'ameta', $results['ameta'], 'N/A', NULL);

			echo '
					</td>
				</tr>
			';
			
			if(($recipient_country_match == '1') && ($results['status'] == 0) && ($results['originator'] != $_SESSION['operator'])) {
				echo '
				<tr>
					<td>
						<br>
						<span><a style="font-size: 25px;color: #FFFFFF" href="?page=confirmCargo&id='.$results['id'].'" class="btn">Accept cargo</a></span>
					</td>
					<td>
						&nbsp;
					</td>
				</tr>
				';
			}
			
			echo '
			</table>';

// if($_SESSION['debug']) {
	if (($results['originator'] == $_SESSION['operator']) && ($results['status']<2)) {
		echo '
				<br><br>
				<p>
					<span><a href="?page=cancel_cargo&id='.$results['id'].'" class="btn">Cancel request</a></span>
				</p>
		';
	}
// }			
			
			// Comments section
			echo '<br>
				<h1>Comments</h1>';
				
			$comments = DB::query ( "SELECT * FROM cargo_comments where (cargo_id=%d) order by SYS_CREATION_DATE desc", $_GET['id'] );
			if ($comments != null) {
				echo '
			<table border="0" cellpadding="5" cellspacing="5" class="message">
				<tr valign="top">
					<td>
						Date
					</td>
					<td>
						Originator
					</td>
					<td>
						Message
					</td>
				</tr>
				';
				
				foreach ( $comments as $row ) {
					echo '
				<tr valign="top">
					<td>
						'.date('Y-m-d H:i', strtotime($row['SYS_CREATION_DATE'])).'
					</td>
					<td>
						'.$row['operator'].'
					</td>
					<td>
						'.$row['comment'].'
					</td>
				</tr>
					';
				}
				
				echo '
			</table>
			<br>
			';
			}
?>		
			<form action="index.php?page=details&id=<?=$_GET['id'];?>" method="post" name="_main" id="_main" onSubmit="javascript: return checkEntriesComments()">
				<input type="hidden" name="_submitted" />
				<input type="hidden" name="_recipient" value="<?=$results['recipient'];?>" />
				<input type="hidden" name="_originator" value="<?=$results['originator'];?>" />
				<table border=0 cellpadding=3 cellspacing=0 class="message">
					<tr valign="middle">
						<td width="219px" valign="middle">
							<input type="text" name="_comment" id="_comment"
								   onFocus="this.select();" onBlur="validateEntry('_comment')" /> <span
								   id="_commentError" style="display: none;">Please enter a valid text</span>
						</td>
						<td valign="middle">
							<input type="submit" id="_submit" value="Add comment" onClick="javascript: return checkEntriesComments()" />
						</td>
					</tr>
				</table>
			</form>
<?php
			
			echo '
		</div>
	</div>
			';
		}
		else {
			echo '<br>
				<h1>Unauthorized access</h1>
				';		
			echo '
		</div>
	</div>
			';
		}
	}
	else {
		echo '<br>
			<h1>No data found</h1>
			';		
		echo '
		</div>
	</div>
			';
	}
}
else {
?>
<div id="contents">
	<div class="features">
		<h1>Your account does not have access to this information</h1>
		<h2>Please contact webmaster@rohel.ro for authorization.</h2>
	</div>
</div>
<?php
}
?>