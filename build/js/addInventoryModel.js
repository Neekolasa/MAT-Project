$(document).ready(function(){
	$("#btn_sendInventory").on('click', function(event) {
		event.preventDefault();
		var snNumber = $("#num_serial").val();
		var pnNumber = $("#part_number").val();
		var qtyNumber = $("#qty").val();
		var uomNumber = $("#uom").val();

		snNumber = snNumber.toUpperCase();
		pnNumber = pnNumber.toUpperCase();
		qtyNumber = qtyNumber.toUpperCase();
		uomNumber = uomNumber.toUpperCase();
		if (snNumber=="" || pnNumber =="" || qtyNumber== "" || uomNumber == "") {

		}
		else{
			sendData(snNumber,pnNumber,qtyNumber,uomNumber);
		}
		
	});
});

var sendData = (snNumber,pnNumber,qtyNumber,uomNumber) => {
	console.log(snNumber);
	console.log(pnNumber);
	console.log(qtyNumber);
	console.log(uomNumber);
	$.ajax({
		url: 'cont/addInventoryController.php',
		data: {snNumber: snNumber,
				  pnNumber: pnNumber,
				  qtyNumber: qtyNumber,
				  uomNumber: uomNumber
	},
	})
	.done(function(info) {
		var Data = JSON.parse(info);
		if (Data['response'] =='success') {
			new PNotify({
								    title: 'Exito',
								    text: 'Se ha abierto la serie '+snNumber,
								    type: 'success',
								    nonblock: {
								        nonblock: true
								    },
								    styling: 'bootstrap3'
								});
		}
		else{
			new PNotify({
								    title: 'Error',
								    text: Data['error'],
								    type: 'error',
								    nonblock: {
								        nonblock: true
								    },
								    styling: 'bootstrap3'
								});
		}
		
	})
	.always(function() {
		$("#num_serial").val("");
		$("#part_number").val("");
		$("#qty").val("");
		$("#uom").val("");
	});
	
}

