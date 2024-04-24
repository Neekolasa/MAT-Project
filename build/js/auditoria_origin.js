$(document).ready(function (){
	if(isUserOnMobile()){
		$(".pc").hide();
		
	}
	else {
		$(".pc").show();
	}

	$.ajax({
		url: 'cont/auditoria_data.php',
		type: 'GET',
		data: {request: 'GET'},
	})
	.done(function(data) {
		//console.log(data);
		//console.log('sdsdsdsd');
		tableAuditoria(data);
	});

});


function tableAuditoria(data){
	var tabla_au = $('#table_auditoria').DataTable({
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
				    { data: "Serie" },
				    { data: "Material" },
				    { data: "Cantidad" },
				    { data: "Localizacion" },
				    { data: "SMK_Status" },
				    { data: "Fecha"}
				    //{ data: "TOTALMOVIMIENTOS"}
				   
				  ]
			});
			tabla_au.rows().remove();
    		
    		var Datos=(JSON.parse(data));
    		//console.log(Datos);
    		tabla_au.rows.add(Datos);
}

function clean(){
	$.ajax({
		url: 'cont/auditoria_data.php',
		type: 'GET',
		data: {request: 'Clean'},
	})
	.done(function(data) {
		Data = JSON.parse(data);
		//Data['response'] == 'success'
		if (Data['response'] == 'success') {
			Swal.fire({
			  position: 'center',
			  icon: 'success',
			  title: 'Se han eliminado registros obsoletos',
			  showConfirmButton: false,
			  timer: 1500
			});
		}
		else{
			Swal.fire({
			  position: 'center',
			  icon: 'error',
			  title: 'No hay datos que eliminar',
			  showConfirmButton: false,
			  timer: 1500
			});

		}
		
		//tableAuditoria(data);
	});
	
}