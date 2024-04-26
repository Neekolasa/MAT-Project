$(document).ready(function(){
	$.ajax({
		url: 'cont/checada_opts.php',
		type: 'GET',
		data: {request: 'GETOPTS'},
	})
	.done(function(info) {
		Data = JSON.parse(info);

		$("#salida_almuerzo").html("");
		
		$.each(Data['Desayuno'], function(index, val) {
			
			$("#salida_almuerzo").append("<option value='"+val['ID']+"'>"+val['TiempoSalida']+" - "+val['TiempoEntrada']+"</option>");
		});
		$("#salida_comida").html("");
		$.each(Data['Comida'], function(index, val) {
			
			$("#salida_comida").append("<option value='"+val['ID']+"'>"+val['TiempoSalida']+" - "+val['TiempoEntrada']+"</option>");
		});
	

	});
	
});