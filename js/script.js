$( document ).ready(function() {
	//active class naviin
	var pathname = window.location.pathname.split("/")[2];
	if(pathname == "csv") {
		$('#csv').addClass("active");
	} else if(pathname == "") {
		$('#home').addClass("active");
	} else {
		$('#csv').addClass("active");
	}
	$("#csvform").submit( function(submitEvent) {
		var filename = $("#csvfile").val();
		var extension = filename.replace(/^.*\./, '');
		if (extension == filename) {
			extension = '';
		} else {
			extension = extension.toLowerCase();
		}
		switch (extension) {
			case 'csv':
			break;
			default:  	
				submitEvent.preventDefault();
		}
	});
});

$('.radios').on('click', function(){
	if($(this).val() == '1') {
		$('#customs').fadeIn();
	} else {
		$('#customs').fadeOut();   
	}
});