$(document).ready(function(){
	getInfo();
});

function getInfo(){
	$.ajax({
		url: 'cont/transactionsSAP.php',
		data: {request: 'getInfo'},
	})
	.done(function(info) {
		getTable(info);
	})
	.fail(function() {
		new PNotify({
		    title: 'Error',
			text: 'Ha ocurrido un error interno',
			type: 'error',
			styling: 'bootstrap3'
		});
	});
}

function removeManual(id){
	$.ajax({
		url: 'cont/transactionsSAP.php',
		data: {request: 'delTransaction',
				idTransaction: id
	},
	})
	.done(function(info) {
		var Data = JSON.parse(info);
		if (Data["response"]=="success") {
			new PNotify({
			    title: 'Exito',
				text: 'Se ha eliminado la transaccion',
				type: 'success',
				styling: 'bootstrap3'
			});
		}
		else{
			new PNotify({
			    title: 'Error',
				text: 'Ha ocurrido un error '+Data["message"],
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
		getInfo();
	});
	
}

function getTable(information){
	var Data = JSON.parse(information);
	if (Data['response']=='success') {
		$('#spinner').hide();
		$('#loadingMessage').hide();
		var tabla = $('#tableTransactions').DataTable({
            dom: 'frtlip',
            destroy: true,
            //order:[[4, 'desc']],
            responsive: true,
            buttons: [
                {extend :'copy', text: 'Copiar al portapapeles',className:"btn btn-primary boton-margen",
                attr:  {
                        id: 'jkjk'
                    }},
                {extend :'excel', text: 'Generar excel',className:"btn btn-primary text-light boton-margen"},
                {extend :'print', text: 'Imprimir documento',className:"btn btn-primary text-light boton-margen"},
                {extend :'pdf', text: 'Generar PDF',className:"btn btn-primary text-light boton-margen"}
            ],
            language: {
                url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
            },
            className: "center-block",
            columnDefs: [
			    { className: "text-center", targets: "_all" } // Esto centrará todo el texto en las celdas
			],
            columns: [
              { data: "PN" },
              { data:"SN" },
              { data: "UoM" },
              { data: "Qty" },
              { data: "UltimoIntento" },
              { data: "Movement" },
              { data: "SapComment"},
              { data: "FechaMovimiento"},
              { data: "CreatedBy"},
              { data: "Action" }             
            ]
        });
        tabla.rows().remove();
                  
               
        tabla.rows.add(Data[0]);
		
	}
}