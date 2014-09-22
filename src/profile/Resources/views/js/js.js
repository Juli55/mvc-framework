$(document).ready(function(){
	$('#logout').click(function(){
		$.ajax({
			          
		    type: "POST",
			async: true,
	        url: dir_back+'includes/logout/logout.class.php',
	        success: function(result) {

		    	window.location.replace('');
			        
			},
		});
	});
});	