<?php
if(isset($error)){
	if($error == "noSubmit") {
		$msg = "Your submit didn't go trough. Try again.";
	} elseif($error == "errorLoadingFile") {
		$msg = "There was an error loading your CSV-file.";
	} elseif($error == "fileSubmitted") {
		$msg = "File has already been submitted.";
	} else {
		$msg = "Unknown error occured.";
	}
	?>
	<div class="alert alert-danger alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
  	<strong>Error!</strong><br> <?php echo $msg;?>
	</div>
	<?php 
}