<?php 
include ("header.php");
include ("../ajax/functions.php");
?>
<div class="container">
	<h1>Your CSV-uploads</h1>
	<div ng-app="myApp" ng-controller="customersCtrl"> 
		<table class="table">
			<thead>
				<tr>
					<th>File id</th>
					<th>File name</th>
					<th>Wage time</th>
					<th>Upload time</th>
					<th>Number of employees in file</th>
					<th>More info</th>
				</tr>
			</thead>
			<tbody>
				<?php echo csvFunction($user_id);?>
			</tbody>
		</table>
	</div>
</div>
<?php include ("footer.php");?>