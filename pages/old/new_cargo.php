<?php

use PHPMailer\PHPMailer\PHPMailer;

if (! Utils::authorized(null, Utils::$INSERT)) {
	header ( 'Location: index.php' );
	exit ();
}

if (isset ( $_POST ['_submitted'] )) {
	DB::insert ( 'cargo_request', array (
			'originator' => $_SESSION['operator'],
			'operator' => $_SESSION['operator'],
			'SYS_CREATION_DATE' => date('Y-m-d H:i:s'),
			'status' => 0,
			'client' => $_POST ['_client'],
			'recipient' => $_POST ['_recipient'],
			'from_city' => $_POST ['_from'],
			'to_city' => $_POST ['_to'],
			'expiration' => (($_POST ['_expiration']=='')?null:$_POST ['_expiration']),
			'loading_date' => (($_POST ['_loading']=='')?null:$_POST ['_loading']),
			'unloading_date' => (($_POST ['_unloading']=='')?null:$_POST ['_unloading']),
			'description' => $_POST ['_description'],
			'collies' => $_POST ['_collies'],
			'weight' => $_POST ['_weight'],
			'volume' => $_POST ['_volume'],
			'loading_meters' => $_POST ['_loading_meters'],
			'comments' => $_POST ['_comments'],
			'freight' => $_POST ['_freight'],
			'pic' => $_POST ['_pic'],
			'volume' => $_POST ['_volume']
	) );
	
	Utils::cargo_audit ('cargo_request', 'NEW-ENTRY', null, $_POST ['_recipient'] );
	
	DB::commit ();
	$id = DB::queryOneField('max(id)', 'select max(id) from cargo_request where originator=%s and client=%s', $_SESSION['operator'], $_POST ['_client']);
	$url = 'http://www.rohel.ro/new/cargo/index.php?page=details&type=cargo&id='.$id;
	
	try {
		// e-mail confirmation
		$mail = new PHPMailer ();
		include "../lib/mail-settings.php";

		$mail->Subject = "New cargo from " . $_SESSION ['operator'];
		
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
						Client:
					</td>
					<td>
						'.(($_POST['_client'] == NULL)?'N/A':$_POST['_client']).'
					</td>
				</tr>
				<tr>
					<td>
						From:
					</td>
					<td>
						'.$_POST['_from'].'
					</td>
				</tr>
				<tr>
					<td>
						To:
					</td>
					<td>
						'.$_POST['_to'].'
					</td>
				</tr>
				<tr>
					<td>
						Loading
					</td>
					<td>
						'.(($_POST ['_loading']=='')?'N/A':$_POST ['_loading']).'
					</td>
				</tr>
				<tr>
					<td>
						Unloading
					</td>
					<td>
						'.(($_POST ['_unloading']=='')?'N/A':$_POST ['_unloading']).'
					</td>
				</tr>
				<tr>
					<td>
						Goods description
					</td>
					<td>
						'.(($_POST['_description'] == NULL)?'N/A':$_POST['_description']).'
					</td>
				</tr>
				<tr>
					<td>
						Number of collies
					</td>
					<td>
						'.(($_POST['_collies'] == NULL)?'N/A':$_POST['_collies']).'
					</td>
				</tr>
				<tr>
					<td>
						Gross weight
					</td>
					<td>
						'.(($_POST['_weight'] == 0)?'N/A':$_POST['_weight']).' kg
					</td>
				</tr>
				<tr>
					<td>
						Volume
					</td>
					<td>
						'.(($_POST['_volume'] == 0)?'N/A':$_POST['_volume']).' cbm
					</td>
				</tr>
				<tr>
					<td>
						Loading meters
					</td>
					<td>
						'.(($_POST['_loading_meters'] == 0)?'N/A':$_POST['_loading_meters']).' m
					</td>
				</tr>
				<tr>
					<td>
						Other comments
					</td>
					<td>
						'.(($_POST ['_comments'] == NULL)?'N/A':$_POST ['_comments']).'
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
		include_once (dirname ( __FILE__ ) . "/../html/new_cargo.html");
		$body = ob_get_clean ();
		$mail->msgHTML ( $body, dirname ( __FILE__ ), true ); // Create message bodies and embed images
		$mail->send ();
	} catch (\PHPMailer\PHPMailer\Exception $e) {
		$_SESSION['email_error'] = $e->errorMessage(); //Pretty error messages from PHPMailer
	} catch (Exception $e) {
		$_SESSION['email_error'] = $e->getMessage(); //Boring error messages from anything else!
	}
	
	$_SESSION ['message'] = '<p style="color: #00CC00">Confirmation e-mail sent to '.$_POST['_recipient'].'</p>';

	header ( "Location: index.php?page=cargo" );	
	exit();
} else {
	include "header.php";

	?>
	<br><br>
<div id="contents">
	<div class="features">
		<h1>New cargo request</h1>
		<p>In order to create a new request, please fill in the blank cases, using TAB or the mouse. If changes are needed, you can access the info sheet again and save the new data using the ENTER button.</p>
		<div>
			<form action="index.php?page=new" method="post" name="_main" id="_main" onSubmit="javascript: return checkEntriesCargo()">
				<input type="hidden" name="_submitted" />
				<table border=0 cellpadding=3 cellspacing=0 class="message">
					<tr valign="middle">
						<td width="219px">Cargo recipient</td>
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
						<td>Client</td>
						<td>
							<input type="text" name="_client" id="_client" onFocus="this.select();">
						</td>
					</tr>
					<tr valign="middle">
						<td>From:</td>
						<td>
							<input type="text" name="_from" id="_from" onFocus="this.select();" onBlur="validateEntry('_from')" /> <span
							       id="_fromError" style="display: none;">Please enter a valid text</span>
						</td>
					</tr>
					<tr valign="middle">
						<td>To:</td>
						<td>
							<input type="text" name="_to" id="_to" onFocus="this.select();" onBlur="validateEntry('_to')" /> <span
							       id="_toError" style="display: none;">Please enter a valid text</span>
						</td>
					</tr>
					<tr valign="middle">
						<td>Loading on</td>
						<td>
							<input type="text" name="_loading" id="_loading" onFocus="this.select();" onBlur="validateDate('_loading')" /> <span
							       id="_loadingError" style="display: none;">Please enter a valid date (YYYY-MM-DD)</span>
						</td>
					</tr>
					<tr valign="middle">
						<td>Unloading on</td>
						<td>
							<input type="text" name="_unloading" id="_unloading" onFocus="this.select();" onBlur="validateDateEmpty('_unloading')" /> <span
							       id="_unloadingError" style="display: none;">Please enter a valid date (YYYY-MM-DD)</span>
						</td>
					</tr>
					<tr valign="middle">
						<td>Goods description</td>
						<td>
							<input type="text" name="_description" id="_description" onFocus="this.select();" onBlur="validateEntry('_description')" /> <span
							       id="_descriptionError" style="display: none;">Please enter non-empty text</span>
						</td>
					</tr>
					<tr valign="middle">
						<td>Number of collies</td>
						<td>
							<input type="text" name="_collies" id="_collies"
								   onFocus="this.select();">
						</td>
					</tr>
					<tr valign="middle">
						<td>Gross weight</td>
						<td>
							<input type="text" name="_weight" id="_weight" onFocus="this.select();" onBlur="validateNumberEmpty('_weight')" /> kg <span
							       id="_weightError" style="display: none;">Please enter a positive integer value</span>
						</td>
					</tr>
					<tr valign="middle">
						<td>Volume</td>
						<td>
							<input type="text" name="_volume" id="_volume" onFocus="this.select();" onBlur="validateNumberEmpty('_volume')" /> cbm <span
							       id="_volumeError" style="display: none;">Please enter a positive integer value</span>
						</td>
					</tr>
					<tr valign="middle">
						<td>Loading meters</td>
						<td>
							<input type="text" name="_loading_meters" id="_loading_meters" onFocus="this.select();" onBlur="validateNumberEmpty('_loading_meters')" /> m <span
							       id="_loading_metersError" style="display: none;">Please enter a positive integer value</span>
						</td>
					</tr>
					<tr valign="middle">
						<td>Other comments</td>
						<td>
							<input type="text" name="_comments" id="_comments" onFocus="this.select();">
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
					<tr valign="middle">
						<td>Expires on</td>
						<td>
							<input type="text" name="_expiration" id="_expiration" onFocus="this.select();" onBlur="validateDateCurrent('_expiration')" /> <span
							       id="_expirationError" style="display: none;">Please enter a valid date (YYYY-MM-DD); not in the past</span>
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