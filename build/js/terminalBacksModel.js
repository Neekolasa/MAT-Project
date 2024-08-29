$(document).ready(function(){
	$("#snTerminal").on('keypress', function(event) {
		if (event.which === 13 || event.keyCode === 13) {
			$("#locTerminal").focus();

		}
	});

	$("#locTerminal").on('keypress', function(event) {
		if (event.which === 13 || event.keyCode === 13) {
			$("#saveButton").trigger("click");

		}
	});

	$("#saveButton").on('click', function(event) {
		event.preventDefault();
		var snTerminal = $("#snTerminal").val();
		snTerminal = snTerminal.toUpperCase();
		snTerminal = snTerminal.replace("S","");
		var locTerminal = $("#locTerminal").val();

		if (snTerminal == "" || locTerminal == "") {
			new PNotify({
                title: 'Error',
                text: 'Rellene todos los campos',
                type: 'error',
                styling: 'bootstrap3'
            });
            $("#snTerminal").focus();
		}
		else{
			$.ajax({
				url: 'cont/terminalBacks.php',
				data: {request: 'comeBack',
                          SerialNumber: snTerminal,
                          location: locTerminal
			},
			})
			.done(function(info) {
				
				var data = JSON.parse(info);
				console.log(data)
			
				if (data['response']=="success") {
					new PNotify({
                        title: 'Exito',
                        text: 'Se ha guardado la terminal en la locacion asignada',
                        type: 'success',
                		styling: 'bootstrap3'
            		});
				}
				else{
					new PNotify({
                        title: 'Error',
                        text: 'Ha ocurrido un error interno',
                        type: 'error',
                		styling: 'bootstrap3'
            		});
				}
				
			})
			.fail(function() {
				new PNotify({
                        title: 'Error',
                        text: 'Ha ocurrido un error interno',
                        type: 'error',
                		styling: 'bootstrap3'
            		});
			})
			.always(function() {
				$("#snTerminal").val("");
				$("#locTerminal").val("");
				$("#snTerminal").focus();
			});
			

		}

	});


});