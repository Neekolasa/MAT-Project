$(document).ready(function(){
	$("#btn_sendInventory").on('click', function(event) {
		event.preventDefault();
		var snNumber = $("#lmSerial").val();
		snNumber = snNumber.toUpperCase();
		snNumber = snNumber.replace("3S","");
		snNumber = snNumber.replace("A","");

		var PN = $("#part_number").val();
		PN = PN.replace("1P","");
		
		var Qty = $("#qty").val();
		var UoM = $("#uom").val();

	

		if (snNumber == "" || PN == "" || Qty == "" || UoM == "") {
			new PNotify({
			    title: 'Error',
				text: 'Rellene todos los campos',
				type: 'warning',
				styling: 'bootstrap3'
			});
		}
		else{
			sendData(snNumber,PN,Qty,UoM);
		}
		
	
	});

	$("#num_serial").on('keyup', function (e) {
	    if (e.key === 'Enter' || e.keyCode === 13) {
	        //$('#btn_sendInventory').trigger('click');
	        var snNumber = $("#num_serial").val();
			snNumber = snNumber.toUpperCase();
			snNumber = snNumber.replace("3S","");
			snNumber = snNumber.replace("A","");
			$("#num_serial").val(snNumber);
	        lookData(snNumber);
	    }
	});
	$("#btn_sendManual").on('click', function(event) {
    	event.preventDefault();
    	$("#modalIdentity").modal('show');


	});

	$("#password").on('keyup', function (e) {
	    if (e.key === 'Enter' || e.keyCode === 13) {
	    	$('#loginPassword').trigger('click');
	    }
	});
	$("#loginPassword").on('click', function(event) {
		event.preventDefault();
		$.ajax({
			url: 'cont/addInventoryController.php',
			type: 'POST',
			data: {
				request: 'autenticator',
                password: $("#password").val()
		},
		})
		.done(function(info) {
			var Data = JSON.parse(info);
			if (Data['response']=='success') {
				new PNotify({
				    title: 'Exito',
					text: 'Usuario valido',
					type: 'success',
					styling: 'bootstrap3'
				});

		        $("#num_serial").prop('readonly', true);
		        $("#lmSerial").prop('readonly', false);
		        $("#part_number").prop('readonly', false);
		        $("#qty").prop('readonly', false);
		        $("#uom").prop('readonly', false);

		        $("#btn_sendManual").prop('disabled', true);
			}
			else{
				new PNotify({
				    title: 'Error',
					text: 'Este usuario no tiene permisos',
					type: 'error',
					styling: 'bootstrap3'
				});
				console.log($("#loginPassword").val())
			}
			
		})
		.fail(function() {
			new PNotify({
				    title: 'Error',
					text: 'Ha ocurrido un error en la consulta',
					type: 'error',
					styling: 'bootstrap3'
				});
		})
		.always(function() {
			$("#modalIdentity").modal('hide');

		});
		
	});



});
var lookData = (snNumber) => {
	$.ajax({
		url: 'cont/addInventoryController.php',
		type: 'GET',
		data: {	
			request: 'getData',
			snNumber: snNumber
	},
	})
	.done(function(info) {
		var Data = JSON.parse(info)
		//console.log(Data['data'][0]);
		if (Data['response']=='success') {
			new PNotify({
			    title: 'Exito',
				text: 'Informacion obtenida',
				type: 'success',
				styling: 'bootstrap3'
			});
			var SN = Data['data'][0]['SN'];
			var PN = Data['data'][0]['PN'];
			var Qty = Data['data'][0]['Qty'];
			var UoM = Data['data'][0]['UoM'];
			$("#lmSerial").val(SN);
			$("#part_number").val(PN);
			$("#qty").val(Qty);
			$("#uom").val(UoM);

		}
		else{
			new PNotify({
			    title: 'Error',
				text: 'No se encontro informacion, use el boton de descargar series e intente de nuevo',
				type: 'error',
				styling: 'bootstrap3'
			});
		}
		
	})
	.fail(function() {
		$("#num_serial").val("");
	})
	.always(function() {
		$("#num_serial").val("");
	});
	
}
var sendData = (snNumber,pnNumber,qtyNumber,uomNumber) => {
	$.ajax({
		url: 'cont/addInventoryController.php',
		data: {snNumber: snNumber,
				  pnNumber: pnNumber,
				  qtyNumber: qtyNumber,
				  uomNumber: uomNumber,
				  request: "setData"
	},
	})
	.done(function(info) {
		var Data = JSON.parse(info);
		if (Data['response'] =='success') {
			new PNotify({
			    title: 'Exito',
				text: 'Se ha agregado a inventario',
				type: 'success',
				styling: 'bootstrap3'
			});
		}
		else{
			new PNotify({
			    title: 'Error',
				text: 'Ya existe en inventario',
				type: 'error',
				styling: 'bootstrap3'
			});
		}
		
	})
	.fail(function(){
		new PNotify({
			    title: 'Error',
				text: 'Compruebe su informacion por favor',
				type: 'error',
				styling: 'bootstrap3'
			});
	})
	.always(function() {
		$("#lmSerial").val("");
		$("#part_number").val("");
		$("#qty").val("");
		$("#uom").val("");
		$("#num_serial").prop('readonly', false);
		$("#lmSerial").prop('readonly', true);
		$("#part_number").prop('readonly', true);
		$("#qty").prop('readonly', true);
		$("#uom").prop('readonly', true);

		$("#btn_sendManual").prop('disabled', false);
	});
	
}

