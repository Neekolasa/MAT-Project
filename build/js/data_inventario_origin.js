$(document).ready(function(){

	data = {
		request : 'GET'
	}

	if (data['request']=='GET') {
		$.ajax({
			url: 'cont/data_inventario.php',
			type: 'GET',
			data: {request: 'GET'},
		})
		.done(function(data) {
			tableInventario(data);
		})
		.fail(function() {
			console.log("error");
		});
		
		

	}
	else{

	}


});

function tableInventario(data){
	var tabla_inv = $('#table_inventario').DataTable({
			    dom: 'frtlip',
			    destroy: true,
			    responsive: true,
			    order:[[5, 'DESC']],
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
			    	//{ data: "ID" },
				    { data: "PartNumber" },
				    { data: "PartNumber2" },
				    { data: "Description" },
				    { data: "Mtype" },
				    { data: "R" },
				    { data: "S" },
				    { data: "L" },
				    { data: "P" },
				    { data: "Location" },
				    { data: "UOM" },
				    { data: "APW" }
				    //{ data: "TOTALMOVIMIENTOS"}
				   
				  ]
			});
			tabla_inv.rows().remove();
    		console.log(Datos);
    		var Datos=(JSON.parse(data));
    		
    		tabla_inv.rows.add(Datos);
}
