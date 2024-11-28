$(document).ready(function(){
	$("#btnSearch").on('click', function(event) {
		event.preventDefault();
		scanMat = $("#scannedMaterial").val();
		scanMat = scanMat.replace("1P","");
		getLocations(scanMat);
	});

	$("#scannedMaterial").on('keyup', function(e) {
		if (e.key === 'Enter' || e.keyCode === 13) {
			$("#btnSearch").click();
		}

	});	
});

function getLocations(partNumber) {
    $.ajax({
        url: 'cont/locationController.php',
        data: { partNumber: partNumber },
        method: 'POST'  // Si la API requiere POST, puedes agregar este método
    })
    .done(function(info) {
        var Data = JSON.parse(info);
        console.log(Data);
        
        if (Data['response'] == 'success') {
            $("#getMaterial").val(partNumber);
            // Accede a los datos correctamente
            $("#oldLocation").val(Data['data'][0]['oldLoc']);
            $("#newLocation").val(Data['data'][0]['newLoc']);
            $("#scannedMaterial").val("");
            
            new PNotify({
                title: 'Éxito',
                text: 'Locación obtenida',
                type: 'success',
                nonblock: {
                    nonblock: true
                },
                styling: 'bootstrap3'
            });
        } else {
            new PNotify({
                title: 'Error',
                text: 'Ha ocurrido un error',
                type: 'error',
                nonblock: {
                    nonblock: true
                },
                styling: 'bootstrap3'
            });
        }
        
    })
    .fail(function() {
        new PNotify({
            title: 'Error',
            text: 'Ha ocurrido un error',
            type: 'error',
            nonblock: {
                nonblock: true
            },
            styling: 'bootstrap3'
        });
    })
    .always(function() {
        $("#scannedMaterial").val("");
    });
}
