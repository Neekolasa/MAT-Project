$(document).ready(function(){
	updatePedidos();
	setInterval(function(){
		updatePedidos();
		console.log("Pedidos updated");
	},60000);

	$("#addPetition_button").on('click', function(event) {
		event.preventDefault();
		var pedido= $("#pn_pedido").val();
		if (pedido=="") {
			new PNotify({
		            title: 'Error',
		            text: 'Ingrese un valor',
		            type: 'warning',
		            nonblock: {
		                nonblock: true
		            },
		            styling: 'bootstrap3'
		        });
		}
		else{
			$.ajax({
				url: 'cont/pedidosController.php',
				type: 'GET',
				data: {request: 'addPedido',
						 partNumber: pedido
				},
			})
			.done(function(info) {
				var Data = JSON.parse(info);
				if (Data['response']=='success') {
					new PNotify({
			            title: 'Exito',
			            text: 'Se ha agregado el pedido',
			            type: 'success',
			            nonblock: {
			                nonblock: true
			            },
			            styling: 'bootstrap3'
		       		});
					updatePedidos();
		       		
				}
				else if (Data['response']=='NoData') {
					new PNotify({
			            title: 'Error',
			            text: 'No se encontraron series en reserva',
			            type: 'error',
			            nonblock: {
			                nonblock: true
			            },
			            styling: 'bootstrap3'
			        });
			       
				}
				else if (Data['response']=='error') {
					new PNotify({
			            title: 'Error',
			            text: 'Numero de parte no valido',
			            type: 'error',
			            nonblock: {
			                nonblock: true
			            },
			            styling: 'bootstrap3'
			        });
			        
				}
				$("#pn_pedido").val("")
			})
			.fail(function() {
				console.log("error");
			});
			
			//;
		}
		
	    
	});
	 $("#pn_pedido").on('keyup', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {

            $("#addPetition_button").click();
        }
                /* Act on the event */
    });

	 $("#delBadge").on('keyup', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {

            $("#delButton").click();
        }
    });

	 $("#delButton").on('click', function(event) {
	 	var badge = $.trim($("#delBadge").val());
	 	var id = $.trim($("#delID").val());
	 	if (badge=="") {
	 		new PNotify({
				title: 'Error',
				text: 'Debe ingresar un numero de empleado valido',
				type: 'error',
				nonblock: {
				    nonblock: true
				},
				styling: 'bootstrap3'
			});
			$("#delBadge").val("")
	 	}
	 	else{
	 		delPedidos(id,badge);
	 	}
	 	
	 });
});

function getPedidos(){

	$.ajax({
		url: 'cont/pedidosController.php',
		type: 'GET',
		data: {request: 'getPedidoList'},
	})
	.done(function(info) {
		var Data = JSON.parse(info);
		//console.log(Data);
		var tabla = $('#table_pedidos').DataTable({
		        dom: 'frtlip', 
		        destroy: true,
		        order:[[0, 'asc']],
		        responsive: true,
		         
		        language: {
		             url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
		        },
		        className: "center-block",
		        columnDefs: [
		            { className: "text-center", targets: "_all" } // Esto centrará todo el texto en las celdas
		        ],
		        columns: [
		            {data: "ID"},
		            { data: "PN"},
		            { data: "Serial" },
		            { data: "Location" },
		            { data: "Descripcion" },
		            { data: "PedidoHora" },
		            { data: "PedidoSurtido"},
		            { data: "TiempoAccion"},
		            { data: "FechaPedido"},
		            { data: "Surtidor"},
		            { data: "EstatusPedido" },
		            { data: "Acciones" }
		           
		                     
		            ]
		    });
		    tabla.rows().remove();   

		    tabla.rows.add(Data['data']);
	})
	.fail(function() {
		console.log("error");
	});
	
}
function getPedidosCompletados(){
	$.ajax({
		url: 'cont/pedidosController.php',
		type: 'GET',
		data: {request: 'getPedidoCompleteList'},
	})
	.done(function(info) {
		var Data = JSON.parse(info);
		//console.log(Data);
		var tabla = $('#tableCompletePedidos').DataTable({
		        dom: 'frtlip', 
		        destroy: true,
		        order:[[0, 'desc']],
		        responsive: true,
		         
		        language: {
		             url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
		        },
		        className: "center-block",
		        columnDefs: [
		            { className: "text-center", targets: "_all" } // Esto centrará todo el texto en las celdas
		        ],
		        columns: [
		            {data: "ID"},
		            { data: "PN"},
		            { data: "Serial" },
		            { data: "Location" },
		            { data: "Descripcion" },
		            { data: "PedidoHora" },
		            { data: "PedidoSurtido"},
		            { data: "TiempoAccion"},
		            { data: "FechaPedido"},
		            { data: "Surtidor"},
		            { data: "EstatusPedido" }
		           
		                     
		            ]
		    });
		    tabla.rows().remove();   

		    tabla.rows.add(Data['data']);
	})
	.fail(function() {
		console.log("error");
	});
	
}
function attPedidos(){
	$.ajax({
		url: 'cont/pedidosController.php',
		type: 'GET',
		data: {request: 'autoCompletePedidos'},
	})
	.done(function(info) {
		var Data = JSON.parse(info);
		if (Data['response']=='success') {
			new PNotify({
		            title: 'Exito',
		            text: 'Se han completado los pedidos surtidos',
		            type: 'success',
		            nonblock: {
		                nonblock: true
		            },
		            styling: 'bootstrap3'
		        });
		}
	})
	.fail(function() {
		console.log("error");
	})
	
}

function updatePedidos(){
	attPedidos();
	getPedidosCompletados();
	getPedidos();
}

function delPedidosModal(id){
	$("#delID").val("");
	$("#delID").val(id);
	$("#delModal").modal('show');

}

function delPedidos(id,badge){
	$.ajax({
		url: 'cont/pedidosController.php',
		data: {request: 'delPedido',
				  ID: id,
				  badge: badge
	},
	})
	.done(function(info) {
		var data = JSON.parse(info);
		if (data['response']=='success') {
			new PNotify({
				title: 'Exito',
				text: 'Pedido '+id+' eliminado.',
				type: 'success',
				nonblock: {
				    nonblock: true
				},
				styling: 'bootstrap3'
			});
			getPedidos();
			$("#delModal").modal('hide');
		}
		else if (data['response']=='NoFound') {
			new PNotify({
				title: 'Usuario no encontrado',
				text: 'Usuario no encontrado o no pertenece a barriles',
				type: 'error',
				nonblock: {
				    nonblock: true
				},
				styling: 'bootstrap3'
			});
		}
		else if (data['response']=='fail') {
			new PNotify({
				title: 'Error',
				text: 'Numero de empleado no valido',
				type: 'error',
				nonblock: {
				    nonblock: true
				},
				styling: 'bootstrap3'
			});
		}
		//console.log(data);
	})
	.fail(function() {
		new PNotify({
				title: 'Error',
				text: 'Error interno',
				type: 'error',
				nonblock: {
				    nonblock: true
				},
				styling: 'bootstrap3'
			});
	})
	
}