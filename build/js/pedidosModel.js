$(document).ready(function(){
	//ACTIVAR AL FINAL
	var userLogged = localStorage.getItem('userLogged');
    if (!userLogged) {
        new PNotify({
            title: 'Error',
            text: 'Debe estar logeado para atender pedidos',
            type: 'error',
            nonblock: {
                nonblock: true
            },
            styling: 'bootstrap3'
        });
        $('#modal_login').modal('show');
    }
    else{
    	$('#user_logged').text('Usuario logeado: ' + localStorage.getItem('userLogged'));
    }

    $('#ingresar_button').on('click', function(event) {
        event.preventDefault();
        $.ajax({
        	url: 'cont/partial_discount_controller_user.php',
        	type: 'GET',
        	data: {request: 'setBadge',
        			  badge: $('#badge').val()
        			},
        })
        .done(function(info) {
        	var Data = JSON.parse(info);
        	if (Data['response']=='success') {
        		localStorage.setItem('userLogged', $('#badge').val());

		        new PNotify({
		            title: 'Exito',
		            text: 'Ha iniciado sesion',
		            type: 'success',
		            nonblock: {
		                nonblock: true
		            },
		            styling: 'bootstrap3'
		        });
		        $('#user_logged').text('Usuario logeado: ' + localStorage.getItem('userLogged'));
		        $('#modal_login').modal('hide');
        	}
        	else{
        		new PNotify({
		            title: 'Error',
		            text: 'Usuario Invalido',
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
		            text: 'Usuario Invalido',
		            type: 'error',
		            nonblock: {
		                nonblock: true
		            },
		            styling: 'bootstrap3'
		        });
        });
        
        
    });

    $('#salir').on('click', function(event) {
    	event.preventDefault();
    	localStorage.removeItem('userLogged');
    	window.location.reload()
    });

	getPedidoMobileList();

})
function getPedidoMobileList(){
	$.ajax({
		url: 'cont/pedidosController.php',
		type: 'POST',
		data: {request: 'getPedidoMobileList'},
	})
	.done(function(info) {
		var Data = JSON.parse(info);
		if (Data["response"]=="success") {
			//console.log(Data["data"]);

			var tabla = $('#tableMobilePedidos').DataTable({
		        dom: 'frt', 
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
		            { data: "Serial" },
		            { data: "PN"},
		            { data: "Location" },
		            { data: "Descripcion" },
		            { data: "PedidoHora" },
		            { data: "EstatusPedido" },
		            { data: "Acciones" }
		           
		                     
		            ]
		    });
		    tabla.rows().remove();   

		    tabla.rows.add(Data['data']);
		}
		
	})
	.fail(function() {
		console.log("error");
	});
	
}
function atentionMaterial(id){
	$.ajax({
		url: 'cont/pedidosController.php',
		type: 'POST',
		data: {ID: id,
				  badge: localStorage.getItem('userLogged'),
				  request: 'takePedido'
				},
	})
	.done(function(info) {
		var Data = JSON.parse(info);
		if (Data['response']=='requestTaken') {
			new PNotify({
				title: 'Exito',
				text: 'Pedido '+id+' aceptado. En proceso de surtido',
				type: 'success',
				nonblock: {
				    nonblock: true
				},
				styling: 'bootstrap3'
			});
			getPedidoMobileList();
		}
		else{
			new PNotify({
				title: 'Error',
				text: 'Ha ocurrido un error con el pedido',
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
	
}