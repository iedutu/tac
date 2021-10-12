<?php ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-Frame-Options" content="allow">
<title>Transport international marfa</title>
<link rel="stylesheet" href="../css/style.css" type="text/css">
<script src="../js/functions.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jquery.js" type="text/javascript" charset="utf-8"></script>
<script src="../js/jeditable.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">

$(function() {
      
  $(".click").editable("update.php", { 
      indicator : "<img src='../images/indicator.gif'>",
      tooltip   : "Click to edit...",
      style  : "inherit"
  });
  $(".country").editable("update.php", { 
	  loadurl : "country.php",
	  type   : "select",
	  submit : "OK",
	  callback : function(value, settings) {
			 location.reload(true);
		 }
  });  
  $(".city").editable("update.php", { 
	  loadurl : "city.php",
	  type   : "select",
	  submit : "OK",
	  callback : function(value, settings) {
			 location.reload(true);
		 }
  });  
});
</script>
</head>
<body>
	<div id="header">
		<div>
			<div class="logo">
				<a href="<?=Utils::authorized(null, Utils::$ADMIN)?'index.php?page=admin':'index.php';?>"><img src="<?=$rpath;?>images/rohel-01.png"
					width="300" border="0"></a>
			</div>
			<ul id="navigation">
<?php
				if (Utils::authorized(null, Utils::$ADMIN)) {
					if ((isset ( $_GET ['page'] )) && ($_GET ['page'] == 'admin')) {
						echo '<li class="active">';
					} else {
						echo '<li>';
					}
					
					echo '<a href="index.php?page=admin">'._("Users").'</a></li>';
				}
				else {
					if (Utils::authorized(null, Utils::$INSERT)) {
						if ((isset ( $_GET ['page'] )) && ($_GET ['page'] == 'new')) {
							echo '<li class="active">';
						} else {
							echo '<li>';
						}
						
						echo '<a href="index.php?page=new">'._("New ".$_SESSION['app']).'</a></li>';
					}

					if (Utils::authorized(null, Utils::$REPORTS)) {
						if ((isset ( $_GET ['page'] )) && ($_GET ['page'] == 'reports')) {
							echo '<li class="active">';
						} else {
							echo '<li>';
						}
						
						echo '<a href="index.php?page=reports">'._("Reports").'</a></li>';
					}
				}
				
				if(isset($_SESSION['operator_id'])) {
					echo '<br><li><img width="15" height="15" src="../images/'.$_SESSION['operator_class']['country'].'.png"> '.$_SESSION['operator'].' (<a href="index.php?page=logout">Logout</a>)</li>';
				}
				else {
					echo '<li>&nbsp;</li>';
				}
?>	
			</ul>
		</div>
	</div>
