$(document).ready(function(){

	$("#material_data").keyup(function(event) {
	    if (event.keyCode === 13) {
	    	var numMaterial = $("#material_data").val();
	        $.ajax({
	        	url: 'cont/scanServices.php',
	        	type: 'GET',
	        	data: {request: 'services',
	        				info:numMaterial},
	        })
	        .done(function(data) {
	        	var Data = JSON.parse(data);
	        	if (Data['response']=='success') {
	        		console.log(Data);
	        		$("#material_data").val("");
	        	}
	        	else{
	        		
	        	}
	        	
	        })
	      
	        
	    }
});

});