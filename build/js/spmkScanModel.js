$(document).ready(function(){
	$("#scannedLocation").on('keyup', function(e) {
		if (e.key === 'Enter' || e.keyCode === 13) {
			$("#scannedMaterial").focus();
		}

	});	
	$("#scannedMaterial").on('keyup', function(e) {
		if (e.key === 'Enter' || e.keyCode === 13) {
			$("#btnInsert").click();
		}

	});	

	$("#btnInsert").on('click', function(event) {
		event.preventDefault();
		var scannedLocation = $("#scannedLocation").val();
		var scannedMaterial = $("#scannedMaterial").val();
		scannedMaterial = scannedMaterial.replace("3S","");
		scannedMaterial = scannedMaterial.replace("A","");
		scannedMaterial = scannedMaterial.replace("S","");
		
		if (scannedLocation == '' || scannedMaterial == '') {
			new PNotify({
				title: 'Atencion',
				text: 'Rellene todos los campos',
				type: 'error',
				nonblock: {
				    nonblock: true
				},
				styling: 'bootstrap3'
			});
		}
		else{
			sendScan(scannedMaterial,scannedLocation);
		}
		
	});
});


function sendScan(snScanner,locScanner){
	$.ajax({
		url: 'cont/spmkScanController.php',
		data: {request: 'insertScan',
                  locScanner: locScanner,
                  snScanner: snScanner
	},
	})
	.done(function(info) {
		var data = JSON.parse(info);
		if (data['response']=='success') 
		{
			new PNotify({
				title: 'Exito',
				text: 'Escaneada la serie '+snScanner,
				type: 'success',
				nonblock: {
				    nonblock: true
				},
				styling: 'bootstrap3'
			});
			$("#scannedMaterial").val('');
			$("#scannedMaterial").focus();
			
		}
		else{
			new PNotify({
				title: 'Error',
				text: 'Ha ocurrido un error al escanear la serie',
				type: 'error',
				nonblock: {
				    nonblock: true
				},
				styling: 'bootstrap3'
			});
		}
	})
	.fail(function() {
		
	})
	.always(function() {
		$("#scannedMaterial").val('');
		$("#scannedMaterial").focus();
	});
	
}