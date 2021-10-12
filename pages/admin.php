<?php
if (! isset ( $_SESSION ['operator_id'] )) {
	header ( 'Location: index.php?page=login' );
	exit ();
}

//Add user
if (Utils::authorized ( 'main', Utils::$ADMIN )) {
	if (isset ( $_POST ['submitted_new'] )) {
		if ($_POST ['username_new'] != null) {
			DB::insert ( 'cargo_users', array (
					'username' => $_POST ['username_new']
			));
		}		
	}
}

//Change users
if (Utils::authorized ( 'main', Utils::$ADMIN )) {
	if (isset ( $_POST ['submitted'] )) {
		$results = DB::query ( "SELECT * FROM cargo_users" );
		if ($results != null) {
			foreach ( $results as $row ) {
				$i = $row ['id'];
				
				if ($_POST ['username' . $i] != null) {
					DB::update ( 'cargo_users', array (
							'username' => $_POST ['username' . $i] 
					), "id=%d", $row ['id'] );
				}
				
				if ($_POST ['password' . $i] != null) {
					DB::update ( 'cargo_users', array (
							'password' => md5 ( $_POST ['password' . $i] ) 
					), "id=%d", $row ['id'] );
				}

				Utils::touchUser('cargo_users', 'insert', $i, $row['id']);
				Utils::touchUser('cargo_users', 'reports', $i, $row['id']);
				Utils::touchUser('cargo_users', 'turkey', $i, $row['id']);
				Utils::touchUser('cargo_users', 'greece', $i, $row['id']);
				Utils::touchUser('cargo_users', 'serbia', $i, $row['id']);
				Utils::touchUser('cargo_users', 'romania', $i, $row['id']);
				Utils::touchUser('cargo_users', 'moldova', $i, $row['id']);
			}
			
			DB::commit ();
		}
	}

	include "header.php";
?>

<div id="contents">
	<div class="features">
		<br> <br>
		<h1>User maintenance</h1>
		<div>
			<form action="index.php?page=admin" method="POST" class="message">
				<input type="hidden" name="submitted_new">
				<input type="text" name="username_new">
				<input type="submit" name="submit" value="Add user" />
			</form>
		</div>
		
		<div>
			<form action="index.php?page=admin" method="POST" class="message">
				<input type="hidden" name="submitted">
				<table border=0 cellpadding=2 cellspacing=0>
					<tr valign="top">
						<td>username</td>
						<td>password</td>
						<td>insert</td>
						<td>reports</td>
						<td>turkey</td>
						<td>greece</td>
						<td>serbia</td>
						<td>romania</td>
						<td>moldova</td>
					</tr>
<?php
	$results = DB::query ( "SELECT * FROM cargo_users order by id" );
	if ($results != null) {
		foreach ( $results as $row ) {
			$i = $row ['id'];
			?>
				<tr>
						<td><input type="text"
							name="username<?=$i;?>" id="username<?=$i;?>" value="<?=$row['username'];?>"></td>
						<td><input style="width: 150px;" type="password"
							name="password<?=$i;?>" id="password<?=$i;?>"></td>
						<td><input style="width: 100px;" type="checkbox" name="insert<?=$i;?>"
							id="insert<?=$i;?>" <?php if($row['insert'] == 1) echo "checked";?>></td>
						<td><input style="width: 100px;" type="checkbox" name="reports<?=$i;?>"
							id="reports<?=$i;?>" <?php if($row['reports'] == 1) echo "checked";?>></td>
						<td><input style="width: 100px;" type="checkbox" name="turkey<?=$i;?>"
							id="turkey<?=$i;?>" <?php if($row['turkey'] == 1) echo "checked";?>></td>
						<td><input style="width: 100px;" type="checkbox" name="greece<?=$i;?>"
							id="greece<?=$i;?>" <?php if($row['greece'] == 1) echo "checked";?>></td>
						<td><input style="width: 100px;" type="checkbox" name="serbia<?=$i;?>"
							id="serbia<?=$i;?>" <?php if($row['serbia'] == 1) echo "checked";?>></td>
						<td><input style="width: 100px;" type="checkbox" name="romania<?=$i;?>"
							id="romania<?=$i;?>" <?php if($row['romania'] == 1) echo "checked";?>></td>
						<td><input style="width: 100px;" type="checkbox" name="moldova<?=$i;?>"
							id="moldova<?=$i;?>" <?php if($row['moldova'] == 1) echo "checked";?>></td>
					</tr>
<?php
		}
	}
	?>
			</table>
				<br> <input type="submit" id="_submit" value="Submit" />
			</form>
		</div>
	</div>
</div>
<?php
}
else {
	header ( 'Location: index.php' );
	exit ();
}
?>
