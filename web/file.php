<?php 
$id = $_GET["id"];
include ("../web/header.php");
include ("../ajax/functions.php");?>
<div class="container">
	<h1 class="text-center"><?php echo fileTitle($id, $user_id);?></h1>
	<div class="row">
		<div class="col-md-6">
			<div class="borders">
				<h3>File information</h3>
				<table class="table">
					<?php echo infoTable($id, $user_id);?>
				</table>
			</div>
		</div>
		<div class="col-md-6">
			<div class="borders">
				<h3>File statistics</h3>
				<table class="table">
					<?php echo statisticsTable($id, $user_id);?>
				</table>
			</div>
		</div>
		<div class="col-md-12">
			<div class="borders">
				<h3>Employee information</h3>
				<table class="table">
					<thead>
						<tr>
							<th>Person ID</th>
							<th>Person Name</th>
							<th>Monthly Wage</th>
							<th>Total Hours</th>
							<th>Overtime Hours</th>
							<th>Evening Hours</th>
							<th>See raw data</th>
						</tr>
					</thead>
					<?php echo personelTable($id, $user_id);?>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="rawdata" role="dialog">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
      </div>
   </div>
</div>
<script>
$('body').on('hidden.bs.modal', '.modal', function () {
  $(this).removeData('bs.modal');
});
</script>
<?php include ("footer.php");?>