$(document).ready(function(){
	fecha_barril = Date.parse($("#single_cal1").val());
		var year = fecha_barril.getFullYear();
		var month = ("0" + (fecha_barril.getMonth() + 1)).slice(-2);
		var day = ("0" + fecha_barril.getDate()).slice(-2);

		var formattedDate = year + "-" + month + "-" + day;

		datos = {
			fecha: formattedDate
		}

		$.ajax({
			url: 'cont/data_barriles.php',
			type: 'GET',
			data: datos,
		})
		.done(function(datos) {
			var Data = JSON.parse(datos);
			console.log();
			var tabla_barriles = $('#table_barriles').DataTable({
			  	dom: 'frtlip',
			    destroy: true,
			    responsive: true,
			    order:[[3, 'asc']],
			    buttons: [
			        {extend :'copy', text: 'Copiar al portapapeles',className:"btn btn-primary boton-margen"},
			        {extend :'excel', text: 'Generar excel',className:"btn btn-primary text-light boton-margen"},
			        {extend :'print', text: 'Imprimir documento',className:"btn btn-primary text-light boton-margen"},
			        {extend :'pdf', text: 'Generar PDF',className:"btn btn-primary text-light boton-margen"}
			    ],
			    language: {
			        url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
			    },
			    className: "center-block",
			    columns: [
				    { data: "Empty" },
				    { data: "New" },
				    { data: "Balance" },
				    { data: "Turno" }
				    //{ data: "TOTALMOVIMIENTOS"}
				   
				  ]
			});
			tabla_barriles.rows().remove();

			
			tabla_barriles.rows.add(Data);
		})


	$("#buscar_barriles").on('click',function(e){
		e.preventDefault();
		
		fecha_barril = Date.parse($("#single_cal1").val());
		var year = fecha_barril.getFullYear();
		var month = ("0" + (fecha_barril.getMonth() + 1)).slice(-2);
		var day = ("0" + fecha_barril.getDate()).slice(-2);

		var formattedDate = year + "-" + month + "-" + day;

		datos = {
			fecha: formattedDate
		}

		$.ajax({
			url: 'cont/data_barriles.php',
			type: 'GET',
			data: datos,
		})
		.done(function(datos) {
			var Data = JSON.parse(datos);
			console.log();
			var tabla_barriles = $('#table_barriles').DataTable({
			  	dom: 'frtlip',
			    destroy: true,
			    responsive: true,
			    order:[[3, 'asc']],
			    buttons: [
			        {extend :'copy', text: 'Copiar al portapapeles',className:"btn btn-primary boton-margen"},
			        {extend :'excel', text: 'Generar excel',className:"btn btn-primary text-light boton-margen"},
			        {extend :'print', text: 'Imprimir documento',className:"btn btn-primary text-light boton-margen"},
			        {extend :'pdf', text: 'Generar PDF',className:"btn btn-primary text-light boton-margen"}
			    ],
			    language: {
			        url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
			    },
			    className: "center-block",
			    columns: [
				    { data: "Empty" },
				    { data: "New" },
				    { data: "Balance" },
				    { data: "Turno" }
				    //{ data: "TOTALMOVIMIENTOS"}
				   
				  ]
			});
			tabla_barriles.rows().remove();

			
			tabla_barriles.rows.add(Data);

			new PNotify({
			    title: 'Informacion actualizada',
			    text: 'Informacion del dia obtenida',
			    type: 'success',
			    styling: 'bootstrap3'
			});
		})
		.fail(function() {
			new PNotify({
			    title: 'Error',
			    text: 'No hay informacion de esta fecha',
			    type: 'error',
			    styling: 'bootstrap3'
			});
		});
		
		
	});
});