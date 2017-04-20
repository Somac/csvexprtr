<?php
$fid = $_GET["fid"];
$pid = $_GET["pid"];
session_start ();
header ( 'Content-Type: text/html; charset=iso-8859-1' );
require_once '../db/PDOc.php';
require_once 'functions.php';
$dbc = new PDOc();
$name = $dbc->getPersonName($pid, $fid);
$dbc = null;
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Raw data for <?php echo $name;?></h4>
</div>
<div class="modal-body">
	<table class="table">
		<thead>
			<tr>
				<th>Date</th>
				<th>Start</th>
				<th>End</th>
				<th>Hours</th>
				<th>Overtime hours</th>
				<th>Evening hours</th>
				<th>Normal wage</th>
				<th>Evening wage</th>
				<th>Overtime wage</th>
				<th>Total wage</th>
			</tr>
		</thead>
		<tbody>
			<?php echo rawData($fid, $pid);?>
		</tbody>
	</table>
</div>
<div class="modal-footer">
	<button type="button" class="custom-btn" data-dismiss="modal">Close</button>
</div>