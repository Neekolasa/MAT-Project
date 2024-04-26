$(document).ready(function(){
	if(isUserOnMobile()){
    $(".pc").hide();
    }
    else {
      $(".pc").show();
    }
	$('#table_material').hide();
	
	$('#dataSearch').on('click',function(e){
		e.preventDefault();

		var data = $('#material').val();
		//console.log(data);

		$.ajax({
			url: 'cont/data_material.php',
			type: 'GET',
			data: {material: data,
					request: 'info'},
		})
		.done(function(data) {
			//console.log(Data);
			var Data = JSON.parse(data);
			
			var tabla_material = $('#table_material').DataTable({
			    dom: 'frtlip',
			    destroy: true,
			    responsive: true,
			    order:[[4, 'DESC']],
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
				    { data: "PN" },
				    { data: "SN" },
				    { data: "Loc" },
				    { data: "Status" },
				    { data: "UltimoCambio" },
				    { data: "Action"}
				    //{ data: "TOTALMOVIMIENTOS"}
				   
				  ]
			});
			tabla_material.rows().remove();
    		//console.log(Datos);
    		tabla_material.rows.add(Data);
    		$('#table_material').show();
    		$('#material').val('');
		})
		.fail(function() {
			console.log("error");
		});
		
	});
});

function info(sn){
	$.ajax({
		url: 'cont/data_material.php',
		type: 'GET',
		data: {serialNumber: sn,
				request: 'getDetailInfo'}
	})
	.done(function(data) {
		var Datos = JSON.parse(data);
		PN = Datos[0].MaterialData.PN;
		SN = Datos[0].MaterialData.SN;
		$('#num_material').val(PN);
		$('#sn_number').val(SN);
		//console.log(Datos[0].ActionsData);
		
		var tabla_au = $('#mov_data').DataTable({
			    dom: 't',
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
				    { data: "action" },
				    { data: "actionDate" },
				    { data: "name" }
				    //{ data: "TOTALMOVIMIENTOS"}
				   
				  ]
			});
			tabla_au.rows().remove();
    		
    		tabla_au.rows.add(Datos[0].ActionsData);


    		

	})
	.fail(function() {
		console.log("error");
	});
	
}