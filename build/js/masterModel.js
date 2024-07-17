$(document).ready(function(){
	console.log("ready")
	$("#num_master").on('keyup', function(e) {
		if (e.key === 'Enter' || e.keyCode === 13) {
			$("#search_button").click();
		}
		
	});

	$("#search_button").on('click', function(event) {
		event.preventDefault();
		var snMaster = $("#num_master").val();
		if (snMaster!="") {
			$.ajax({
				url: 'cont/masterController.php',
				type: 'GET',
				data: {request: 'getData',
				          snMaster: snMaster
			},
			})
			.done(function(info) {
				var Data = JSON.parse(info);
				console.log(Data);
			
				$("#totalSeries").html("Series enlazadas: "+Data['Qty']+"\n <br>Master: "+snMaster+"\n <br>Cantidad en master: "+Data['Sum']);
				var tabla_au = $('#dataMaster').DataTable({
				    dom: 'frtlip',
				    destroy: true,
				    responsive: true,
				    order:[[1, 'DESC']],
				    language: {
				        url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
				    },
				    buttons: [
				     	{extend :'copy', text: 'Copiar al portapapeles',className:"btn btn-primary boton-margen"},
				     	{extend :'excel', text: 'Generar excel',className:"btn btn-primary text-light boton-margen"},
				     	{extend :'print', text: 'Imprimir documento',className:"btn btn-primary text-light boton-margen"},
				     	{extend :'pdf', text: 'Generar PDF',className:"btn btn-primary text-light boton-margen"}
				    ],
				    className: "center-block",
				    columns: [
				    	{ data: "SNChild" },
					    { data: "SNMaster" },
					    { data: "PN" },
					    { data: "Cant" }
					   
					  ]
				});
				tabla_au.rows().remove();
	    	
	    		//console.log(Datos);
	    		tabla_au.rows.add(Data['dato']);
	    		$("#num_master").val("");
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
				console.log("complete");
			});
			
		}
		else{
			new PNotify({
				title: 'Error',
				text: 'Debe ingresar una serie valida',
				type: 'error',
				nonblock: {
			        nonblock: true
			    },
				styling: 'bootstrap3'
			});
		}
		
	});
})