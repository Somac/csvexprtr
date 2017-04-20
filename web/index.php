<?php
include ("header.php");
if(isset($_GET["error"])) {
	$error = $_GET["error"];
}
?>
<div class="container">
	<?php include("errors.php");?>
	<div class="row">
		<div class="col-md-4">
			<img src='images/csvlogo.png' class='logo'>
		</div>
		<div class="col-md-8">
			<h1>CSV XPRTR</h1>
			<p>Welcome to my CSV wage calculator web application.</p>
			<p>Here you can upload your CSV-files while I do the hard work of calculating the wages for you.</p>
			<p>This page uses cookies as user recognition. You can browse your old uploads <a href='csv'>here</a>.</p>
			<p><button type="button" class="custom-btn" data-toggle="modal" data-target="#info-modal">Click here</button>to see the requirements for the CSV-file</p>
			<div id="inputfiles">
				<form action="web/upload.php" method="post" enctype="multipart/form-data" id="csvform">
					<label class="radio-inline"><input type="radio" class="radios" name="settings" value="0" id="default" checked>Use default settings <a data-toggle="modal" href="#default-modal"><span class="glyphicon glyphicon-info-sign"></span></a></label>
					<label class="radio-inline"><input type="radio" class="radios" name="settings" value="1" id="custom">Use custom settings</label><br>
					<div id="customs">
						<div class="row">
							<div class="col-md-12"><h3>Custom settings</h3></div>
							<div class="col-md-6">
								<label for="hourlywage">Hourly wage ($)</label>
								<input type="number" min="1" step="any" class="form-control" name="hourlywage" value="3.75">
							</div>
							<div class="col-md-6">
								<label for="eveningcompensation">Evening work compensation ($)</label>
								<input type="number" min="1" step="any" class="form-control" name="eveningcompensation" value="1.15">
							</div>
							<div class="col-md-6">
								<label for="overtimefirst">Overtime compensation first two hours (%)</label>
								<input type="number" min="1" max="100" class="form-control" name="overtimefirst" value="25">
							</div>
							<div class="col-md-6">
								<label for="overtimesecond">Overtime compensation next two hours (%)</label>
								<input type="number" min="1" max="100" class="form-control" name="overtimesecond" value="50">
							</div>
							<div class="col-md-6">
								<label for="overtimethird">Overtime compensation after four hours (%)</label>
								<input type="number" min="1" max="100" class="form-control" name="overtimethird" value="100">
							</div>
						</div>
					</div>
					<label for="csvfile">CSV-File</label>
					<input class="draganddrop" type="file" name="csvfile" id="csvfile">
					<input type="submit" class="custom-btn gren" name="submit">
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Modals -->
<div id="info-modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">CSV-file info</h4>
			</div>
			<div class="modal-body">
				<p>File format is CSV (Comma Separated Values).</p>
				<p>Every data row specifies one work shift and split shifts are allowed (=more than one work shift per day for one person).</p>
				<p>All timestamps are given in 15-minute increments.</p>
				<p></p>
				<p>Here are some more instructions:</p>
				<img src="images/info2.png" class="img-responsive">
				<img src="images/info1.png" class="img-responsive">
			</div>
			<div class="modal-footer">
				<button type="button" class="custom-btn" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div id="default-modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Wage Calculation-info</h4>
			</div>
			<div class="modal-body">
				<p>Wage Calculation Guidelines Hourly wage for all employees is <strong>$3.75</strong>. For currency calculations round dollar amounts to the nearest cent. For time to decimal conversions round to two decimal places. </p>
				<p>Evening work compensation is <strong>+$1.15/hour</strong> for hours between 18:00 - 06:00.</p>
				<p>Overtime compensation is paid when daily working hours exceeds 8 hours.</p>
				<p>The overtime hours will be paid at the higher rate. Other extra compensations are not included in hourly wage when calculating overtime compensations. Overtime Compensation depends on the amount of daily overtime work hours: </p>
				<table class="table">
				<thead>
					<tr><th>Time</th><th>Percentage</th></tr>
				</thead>
				<tbody>
				<tr><td>First 2 Hours after 8 Hours</td> <td>25%</td></tr>
				<tr><td>Next 2 Hours</td> <td>50%</td></tr>
				<tr><td>After That</td> <td>100%</td></tr>
				</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="custom-btn" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<?php 
include ("footer.php");?>