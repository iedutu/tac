<?php
if (! isset ( $_SESSION ['operator_id'] )) {
	header ( 'Location: index.php?page=login' );
	exit ();
}

include "header.php";
?>

<div id="contents">
	<div class="features">
		<br><br>
		<h1>Cargo summary</h1>
        <h2>Click <a href="?page=truck">here</a> for the truck summary</h2>
		<p>Please note all records will be kept for up to <?=Utils::$CARGO_PERIOD;?> calendar days from acceptance.</p>
<?php
	if(isset($_SESSION['message'])) {
		echo '<h4>'.$_SESSION['message'].'</h4>';
		unset($_SESSION['message']);
	}
?>		
		<div>
<?php

$condition = '';
$separator = '';

if($_SESSION['operator_class']['turkey']) {
	$condition = $condition.'turkey = 1';
	$separator = ' OR ';
}
if($_SESSION['operator_class']['greece']) {
	$condition = $condition.$separator.'greece = 1';
	$separator = ' OR ';
}
if($_SESSION['operator_class']['serbia']) {
	$condition = $condition.$separator.'serbia = 1';
	$separator = ' OR ';
}
if($_SESSION['operator_class']['romania']) {
	$condition = $condition.$separator.'romania = 1';
}

if($_SESSION['operator_class']['moldova']) {
	$condition = $condition.$separator.'moldova = 1';
}

// 25.01.2017. Removed the OR status=2 clause to clean-up the closed requests.	
$result = DB::query ( "SELECT * FROM cargo_request WHERE 
						(
							((status = 0) AND (SYSDATE() < (expiration + INTERVAL 1 DAY))) OR
							((status = 1) AND (SYSDATE() < (acceptance + INTERVAL %d DAY)))
						)
						AND
						(
							originator in (SELECT username FROM cargo_users WHERE ".$condition.") OR
							recipient in (SELECT username FROM cargo_users WHERE ".$condition.")
						)
					   ORDER BY id", Utils::$CARGO_PERIOD);
if ($result != null) {
	echo '
			<table width="1080" border="1" cellpadding="2" cellspacing="0" class="message">
				<tr valign="center" align="center">
					<td><b>ID</b></td>
					<td><b>From</b></td>
					<td><b>To</b></td>
					<td><b>Expiration</b></td>
					<td><b>Client</b></td>
					<td><b>Loading from</b></td>
					<td><b>Unloading to</b></td>
					<td><b>Status</b></td>
				</tr>
	';
	
	foreach ( $result as $row ) {
		$status = '';
		
		switch($row['status']) {
			case 0: $status = '<b>NEW</b>'; break;
			case 1: $status = '<b style="color: #00CC00">ACCEPTED</b>'; break;
			case 2: $status = '<b style="color: #FF0000">EXPIRED</b>'; break;
			default: $status = 'ERROR';
		}
		
		$bgcolor = "#FFFFFF";
		$originator_country_match = DB::queryOneField($_SESSION['operator_class']['country'], "SELECT ".$_SESSION['operator_class']['country']." FROM cargo_users WHERE username=%s", $row['originator']);

		if($originator_country_match == '1') {
			$bgcolor = "#FFF0B2";
		}
		
		$icon='';
		$user_details_from = DB::queryFirstRow("SELECT * FROM cargo_users WHERE username=%s", $row['originator']);

		if($user_details_from['turkey'] == 1) { $icon_from='../images/turkey.png'; }
		if($user_details_from['greece'] == 1) { $icon_from='../images/greece.png'; }
		if($user_details_from['serbia'] == 1) { $icon_from='../images/serbia.png'; }
		if($user_details_from['romania'] == 1) { $icon_from='../images/romania.png'; }
		if($user_details_from['moldova'] == 1) { $icon_from='../images/moldova.png'; }
		
		$user_details_to = DB::queryFirstRow("SELECT * FROM cargo_users WHERE username=%s", $row['recipient']);

		if($user_details_to['turkey'] == 1) { $icon_to='../images/turkey.png'; }
		if($user_details_to['greece'] == 1) { $icon_to='../images/greece.png'; }
		if($user_details_to['serbia'] == 1) { $icon_to='../images/serbia.png'; }
		if($user_details_to['romania'] == 1) { $icon_to='../images/romania.png'; }
		if($user_details_to['moldova'] == 1) { $icon_to='../images/moldova.png'; }
		
		echo '
				<tr valign="center" bgcolor="'.$bgcolor.'">
					<td><a style="font-size: 16px;color: #003399" href="?page=details&id='.$row['id'].'">'.$row['id'].'</a></td>
					<td><img border="0" width="20" height="20" src="'.$icon_from.'">'.$row['originator'].'</td>
					<td><img border="0" width="20" height="20" src="'.$icon_to.'">'.$row['recipient'].'</td>
					<td>'.date ('Y-m-d', strtotime($row['expiration'])).'</td>
					<td witdh="300">'.$row['client'].'</td>
					<td>'.$row['from_city'].'</td>
					<td>'.$row['to_city'].'</td>
					<td>'.$status.'</td>
				</tr>
		';
	}

	echo '
			</table>
	';
}
else {
	echo '<h3>No available data found. Perhaps you should <a href="index.php?page=new">add a cargo</a> record.</h3>';
}
?>

		</div>
	</div>
</div>

