<?php
if (! isset ( $_SESSION ['start_date_reports_plm'] )) {
	$_SESSION ['start_date_reports_plm'] =  date('Y-m-d', time() - (Utils::$REPORTS_PERIOD * 24 * 60 * 60));
}

if (! isset ( $_SESSION ['end_date_reports_plm'] )) {
	$_SESSION ['end_date_reports_plm'] = date('Y-m-d', time());
}

if (Utils::authorized ( 'main', Utils::$REPORTS )) {
	include "header.php";

?>
<div id="contents">
	<div class="features">
		<br>
		<br>
		<h1>Reports</h1>
		<h2>Please select the time period, before generating a report:</h2>
		<h2>From <b style="font-size: 25px;color: #848484" id="start_date_reports" title="Click to edit..." class="click" style="display: inline"><?=$_SESSION ['start_date_reports_plm'];?></b> till <b style="font-size: 25px;color: #848484" id="end_date_reports" title="Click to edit..." class="click" style="display: inline"><?=$_SESSION ['end_date_reports_plm'];?></b>.</h2>
		<div>
				<a href="export.php?action=1">Download <?=$_SESSION['app'];?> report</a> <br>
				<a href="export.php?action=2">Download audit report</a>
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
