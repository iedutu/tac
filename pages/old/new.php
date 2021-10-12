<?php
if (! Utils::authorized(null, Utils::$INSERT)) {
	header ( 'Location: index.php?page=login' );
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
	
	header ( "Location: index.php?page=main" );	
} else {
	include "header.php";

	?>
	<br><br>
<div id="contents">
	<div class="features">
		<h1>New request</h1>
		<p>In order to create a new request, please fill in the blank cases, using TAB or the mouse. If changes are needed, you can access the info sheet again and save the new data using the ENTER button.</p>
		<div>
			<form action="index.php?page=new" method="post" name="_main" id="_main" onSubmit="javascript: return checkEntriesCargo()">
				<input type="hidden" name="_submitted" />
				<table border=0 cellpadding=3 cellspacing=0 class="message">
					<tr valign="middle">
						<td width="219px">Request recipient</td>
						<td><select name="_recipient">
<?php
	$limit = 2;
	if(isset($_SESSION['debug']) && ($_SESSION['debug'] == true)) {
		$limit = 3;
	}
	
	$emails = DB::queryOneColumn ( 'username', "SELECT * FROM cargo_users where (username <> %s) and (class < %d)", $_SESSION ['operator'], $limit );
	foreach ( $emails as $email ) {
		echo '							<option value="' . $email . '">' . $email . '</option>';
	}
?>
							</select>
						</td>
					</tr>
					<tr valign="middle">
						<td>Client_1</td>
						<td>
							<input type="text" name="_client" id="_client" onFocus="this.select();">
						</td>
					</tr>
					<tr valign="middle">
						<td>From:</td>
						<td>
							<input type="text" name="_from" id="_from" onFocus="this.select();"
								   onFocus="this.select();" onBlur="validateEntry('_from')" /> <span
							       id="_fromError" style="display: none;">Please enter a positive integer value</span>
						</td>
					</tr>
					<tr valign="middle">
						<td>To:</td>
						<td>
							<input type="text" name="_to" id="_to" onFocus="this.select();"
								   onFocus="this.select();" onBlur="validateEntry('_to')" /> <span
							       id="_toError" style="display: none;">Please enter a positive integer value</span>
						</td>
					</tr>
					<tr valign="middle">
						<td>Loading on</td>
						<td>
							<input type="text" name="_loading" id="_loading" onFocus="this.select();"
								   onFocus="this.select();" onBlur="validateDate('_loading')" /> <span
							       id="_loadingError" style="display: none;">Please enter a valid date (YYYY-MM-DD)</span>
						</td>
					</tr>
					<tr valign="middle">
						<td>Unloading on</td>
						<td>
							<input type="text" name="_unloading" id="_unloading" onFocus="this.select();"
								   onFocus="this.select();" onBlur="validateDateEmpty('_unloading')" /> <span
							       id="_unloadingError" style="display: none;">Please enter a valid date (YYYY-MM-DD)</span>
						</td>
					</tr>
					<tr valign="middle">
						<td>Goods description</td>
						<td>
							<input type="text" name="_description" id="_description" onFocus="this.select();"
								   onFocus="this.select();" onBlur="validateEntry('_description')" /> <span
							       id="_descriptionError" style="display: none;">Please enter a positive integer value</span>
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
							<input type="text" name="_weight" id="_weight" onFocus="this.select();"
								   onFocus="this.select();" onBlur="validateNumberEmpty('_weight')" /> kg <span
							       id="_weightError" style="display: none;">Please enter a positive integer value</span>
						</td>
					</tr>
					<tr valign="middle">
						<td>Volume</td>
						<td>
							<input type="text" name="_volume" id="_volume" onFocus="this.select();"
								   onFocus="this.select();" onBlur="validateNumberEmpty('_volume')" /> cbm <span
							       id="_volumeError" style="display: none;">Please enter a positive integer value</span>
						</td>
					</tr>
					<tr valign="middle">
						<td>Loading meters</td>
						<td>
							<input type="text" name="_loading_meters" id="_loading_meters" onFocus="this.select();"
								   onFocus="this.select();" onBlur="validateNumberEmpty('_loading_meters')" /> m <span
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
						<td>Request expiration</td>
						<td>
							<input type="text" name="_expiration" id="_expiration" onFocus="this.select();"
								   onFocus="this.select();" onBlur="validateDate('_expiration')" /> <span
							       id="_expirationError" style="display: none;">Please enter a valid date (YYYY-MM-DD)</span>
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