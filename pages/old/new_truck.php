<?php

use PHPMailer\PHPMailer\PHPMailer;

if (! Utils::authorized(null, Utils::$INSERT)) {
	header ( 'Location: index.php' );
	exit ();
}

if (isset ( $_POST ['_submitted'] )) {
	DB::insert ( 'cargo_truck', array (
			'originator' => $_SESSION['operator'],
			'recipient' => $_POST['_recipient'],
			'operator' => $_SESSION['operator'],
			'SYS_CREATION_DATE' => date('Y-m-d H:i:s'),
			'status' => 0,
			'from_city' => $_POST ['_from'],
			'to_city' => $_POST ['_to'],
			'availability' => (($_POST ['_availability']=='')?null:$_POST ['_availability']),
			'expiration' => (($_POST ['_expiration']=='')?null:$_POST ['_expiration']),
			'details' => $_POST ['_details'],
			'freight' => $_POST ['_freight'],
			'pic' => $_POST ['_pic']
	) );
	
	Utils::cargo_audit ('cargo_truck', 'NEW-ENTRY', null, $_POST ['_recipient'] );
	
	DB::commit ();
	$id = DB::queryOneField('max(id)', 'select max(id) from cargo_truck where originator=%s and recipient=%s', $_SESSION['operator'], $_POST ['_recipient']);
	$url = 'http://www.rohel.ro/new/cargo/index.php?page=details&type=truck&id='.$id;
	
	try {
		// e-mail confirmation
		$mail = new PHPMailer ();
		include "../lib/mail-settings.php";

		$mail->Subject = "New truck from " . $_SESSION ['operator'];
		
		$cargo_details = '
			<table border="0" cellpadding="2" cellspacing="0" class="message">
				<tr>
					<td>
						Originator:
					</td>
					<td>
						'.$_SESSION['operator'].'
					</td>
				</tr>
				<tr>
					<td>
						Recipient:
					</td>
					<td>
						'.$_POST['_recipient'].'
					</td>
				</tr>
				<tr>
					<td>
						Available in:
					</td>
					<td>
						'.$_POST['_from'].'
					</td>
				</tr>
				<tr>
					<td>
						Available for:
					</td>
					<td>
						'.$_POST['_to'].'
					</td>
				</tr>
				<tr>
					<td>
						Available from:
					</td>
					<td>
						'.(($_POST ['_availability']=='')?null:$_POST ['_availability']).'
					</td>
				</tr>
				<tr>
					<td>
						Available until:
					</td>
					<td>
						'.(($_POST ['_expiration']=='')?null:$_POST ['_expiration']).'
					</td>
				</tr>
				<tr>
					<td>
						Details
					</td>
					<td>
						'.(($_POST['_details'] == NULL)?'N/A':$_POST['_details']).'
					</td>
				</tr>
				<tr>
					<td>
						Freight
					</td>
					<td>
						'.(($_POST['_freight'] == NULL)?'N/A':$_POST['_freight']).'
					</td>
				</tr>
				<tr>
					<td>
						PIC
					</td>
					<td>
						'.(($_POST['_pic'] == NULL)?'N/A':$_POST['_pic']).'
					</td>
				</tr>
			</table>
			';

		$mail->addAddress ( $_POST['_recipient'], $_POST['_recipient'] );
		
		ob_start ();
		include_once (dirname ( __FILE__ ) . "/../html/new_truck.html");
		$body = ob_get_clean ();
		$mail->msgHTML ( $body, dirname ( __FILE__ ), true ); // Create message bodies and embed images
		$mail->send ();
    } catch (\PHPMailer\PHPMailer\Exception $e) {
		$_SESSION['email_error'] = $e->errorMessage(); //Pretty error messages from PHPMailer
	} catch (Exception $e) {
		$_SESSION['email_error'] = $e->getMessage(); //Boring error messages from anything else!
	}
	
	$_SESSION ['message'] = '<p style="color: #00CC00">Confirmation e-mail sent to '.$_POST['_recipient'].'</p>';

	header ( "Location: index.php?page=truck" );
	exit();	
} else {
	include "header.php";

	?>
	<br><br>
<div id="contents">
	<div class="features">
		<h1>New truck notice</h1>
		<p>In order to create a new notice, please fill in the blank cases, using TAB or the mouse. If changes are needed, you can access the info sheet again and save the new data using the ENTER button.</p>
		<div>
			<form action="index.php?page=new" method="post" name="_main" id="_main" onSubmit="javascript: return checkEntriesTruck()">
				<input type="hidden" name="_submitted" />
				<table border=0 cellpadding=3 cellspacing=0 class="message">
					<tr valign="middle">
						<td width="219px">Truck recipient</td>
						<td><select name="_recipient">
<?php
	$limit = 2;
	if(isset($_SESSION['debug']) && ($_SESSION['debug'] == true)) {
		$limit = 3;
	}
	
	$emails = DB::queryOneColumn ( 'username', "SELECT * FROM cargo_users where (username <> %s) and (class < %d) and (class > 0) order by username", $_SESSION ['operator'], $limit );
	foreach ( $emails as $email ) {
		echo '							<option value="'.$email.'">'.$email.'</option>';
	}
?>
							</select>
						</td>
					</tr>
					<tr valign="middle">
						<td>Available in</td>
						<td>
							<input type="text" name="_from" id="_from" onFocus="this.select();" onBlur="validateEntry('_from')" /> <span
							       id="_fromError" style="display: none;">Please enter a valid text</span>
						</td>
					</tr>
					<tr valign="middle">
						<td>Available for</td>
						<td>
							<input type="text" name="_to" id="_to" onFocus="this.select();" onBlur="validateEntry('_to')" /> <span
							       id="_toError" style="display: none;">Please enter a valid text</span>
						</td>
					</tr>
					<tr valign="middle">
						<td>Available from</td>
						<td>
							<input type="text" name="_availability" id="_availability" onFocus="this.select();" onBlur="validateDate('_availability')" /> <span
							       id="_availabilityError" style="display: none;">Please enter a valid date (YYYY-MM-DD)</span>
						</td>
					</tr>
					<tr valign="middle">
						<td>Available until</td>
						<td>
							<input type="text" name="_expiration" id="_expiration" onFocus="this.select();" onBlur="validateDateCurrent('_expiration')" /> <span
							       id="_expirationError" style="display: none;">Please enter a valid date (YYYY-MM-DD); not in the past</span>
						</td>
					</tr>
					<tr valign="middle">
						<td>Truck details</td>
						<td>
							<input type="text" name="_details" id="_details" onFocus="this.select();" onBlur="validateEntry('_details')" /> <span
							       id="_detailsError" style="display: none;">Please enter a valid text</span>
						</td>
					</tr>
					<tr valign="middle">
						<td>Freight</td>
						<td>
							<input type="text" name="_freight" id="_freight" onFocus="this.select();">
						</td>
					</tr>
					<tr valign="middle">
						<td>PIC</td>
						<td>
							<input type="text" name="_pic" id="_pic" onFocus="this.select();">
						</td>
					</tr>
					<tr valign="top">
						<td>&nbsp;</td>
						<td><input type="submit" id="_submit" value="Enter" onClick="javascript: return checkEntriesCargo()" /></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>
<?php
}
?>