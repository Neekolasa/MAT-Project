$(document).ready(function(){

	data = {
		request : 'GET'
	}

	if (data['request']=='GET') {
		$.ajax({
			url: 'cont/data_inventario.php',
			type: 'GET',
			data: {request: 'GET'},
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		});
		
		

	}
	else{

	}


});
