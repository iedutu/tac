<?php

if (isset ( $_POST ['_submitted'] )) {
	$username = $_POST ['_username'];
	$password = md5 ( $_POST ['_password'] );
	
	$row = DB::queryFirstRow("SELECT * FROM cargo_users WHERE username=%s and password=%s", $username, $password );
	if ($row == null) {
		$_SESSION['login_error'] = 1;

		$params = '';
		if(isset($_POST['_page'])) {
			if(isset($_POST['_id'])) {
				$params='?page='.$_POST['_page'].'&id='.$_POST['_id'];
				if(isset($_POST['_type'])) {
					$params='?page='.$_POST['_page'].'&type='.$_POST['_type'].'&id='.$_POST['_id'];
				}
			}
			else {
				$params='?page='.$_POST['_page'];
			}
		}

		header ( 'Location: index.php'.$params );
		exit ();
	} else {
		$_SESSION['app'] = 'cargo';
		$_SESSION['class'] = $row['class'];
		$_SESSION['operator_id'] = $row['id'];
		$_SESSION['operator'] = $row['username'];
		$_SESSION['operator_class'] = array();
		$_SESSION['operator_class']['insert'] = ($row['insert'] == 1)?true:false;
		$_SESSION['operator_class']['reports'] = ($row['reports'] == 1)?true:false;

		// One country per username
		if($row['turkey'] == 1) { $_SESSION['operator_class']['country']='turkey'; }
		if($row['greece'] == 1) { $_SESSION['operator_class']['country']='greece'; }
		if($row['serbia'] == 1) { $_SESSION['operator_class']['country']='serbia'; }
		if($row['romania'] == 1) { $_SESSION['operator_class']['country']='romania'; }
		if($row['moldova'] == 1) { $_SESSION['operator_class']['country']='moldova'; }
		
		// Multiple countries per username
		$_SESSION['operator_class']['turkey'] = $row['turkey']; 
		$_SESSION['operator_class']['serbia'] = $row['serbia']; 
		$_SESSION['operator_class']['romania'] = $row['romania']; 
		$_SESSION['operator_class']['greece'] = $row['greece']; 
		$_SESSION['operator_class']['moldova'] = $row['moldova'];
		
		$_SESSION['login_error'] = 0;

		$params = '';
		if(isset($_POST['_page'])) {
			if(isset($_POST['_id'])) {
				$params='?page='.$_POST['_page'].'&id='.$_POST['_id'];
				if(isset($_POST['_type'])) {
					$params='?page='.$_POST['_page'].'&type='.$_POST['_type'].'&id='.$_POST['_id'];
				}
			}
			else {
				$params='?page='.$_POST['_page'];
			}
		}
		
		header ( 'Location: index.php'.$params );
	}
}
else {
	include "header.php";
?>
<br><br>
<div id="contents">
	<div class="features">
		<h1>Please authenticate</h1>
<?php 
	if((isset ( $_SESSION ['login_error'] )) && ($_SESSION['login_error'] == 1)) {
		echo '<h2 style="color:red;">Wrong username and/or password</h2>';
		$_SESSION['login_error'] = 0;
	}
?>
		<div>
			<form action="?page=login" method="post">
				<input type="hidden" name="_submitted" />
<?php
	if(isset($_GET['page']) && ($_GET['page']!="login")) {
?>
				<input type="hidden" name="_page" value="<?=$_GET['page']?>" />
<?php
		if(isset($_GET['id'])) {
?>
				<input type="hidden" name="_id" value="<?=$_GET['id']?>" />
<?php
		}

		if(isset($_GET['type'])) {
?>
				<input type="hidden" name="_type" value="<?=$_GET['type']?>" />
<?php
		}
	}
?>
				<table border=0 cellpadding=10 cellspacing=0 class="message">
					<tr valign="middle">
						<td>Username</td>
						<td><input type="text" name="_username" id="_username" name="_username"
							onFocus="this.select();" onBlur="validateEntry('_username')" /> <span
							id="_usernameError" style="display: none;">Please enter a valid
								value</span></td>
					</tr>
					<tr valign="middle">
						<td>Password</td>
						<td><input type="password" name="_password" id="_password"
							name="_password" onFocus="this.select();"
							onBlur="validateEntry('_password')" /> <span id="_passwordError"
							style="display: none;">Please enter a valid value</span></td>
					</tr>
					<tr valign="top">
						<td>&nbsp;</td>
						<td><input type="submit" id="_submit" value="Submit" /></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>
<?php
}
?>