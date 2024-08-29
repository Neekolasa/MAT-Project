$(document).ready(function(){

	getTablaChecadas();
	
});


function getTablaChecadas(){
	$.ajax({
		url: 'cont/table_checadas.php',
		type: 'GET',
		data: {request: 'checkData'},
	})
	.done(function(info) {
		var Data = JSON.parse(info);
		//onsole.log(Data);
		var tabla_ch = $('#data_salidas').DataTable({
			  	dom: 'frtlip',
			    destroy: true,
			    responsive: true,
			    order:[7, 'desc'],
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
			    columns: [
				    { data: "Badge" },
				    { data: "Nombre" },
				    { data: "TiempoSalidaDesayuno" },
				    { data: "TiempoEntradaDesayuno" },
				    { data: "TiempoSalidaComida" },
				    { data: "TiempoEntradaComida"},
				    { data: "Area"},
				    { data: "Hora"}
				    //{ data: "TOTALMOVIMIENTOS"}
				   
				  ]
			});
			tabla_ch.rows().remove();

		
		tabla_ch.rows.add(Data);
		
	});
}