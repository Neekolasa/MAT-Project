$(document).ready(function(){
	$('#buscar_ruta').on('click',function(e){
		e.preventDefault();
		
		var turno_inicio = "";
		var turno_fin = "";
		if ($('#turno').val() == "A") {
			turno_inicio = "06:00";
			turno_fin = "15:36";
		}
		else if ($('#turno').val() == "B") {
			turno_inicio = "15:36";
			turno_fin = "00:10";
		}
		else
		{
			turno_inicio = "06:00";
			turno_fin = "15:36";
		}
		var datos = {
			fecha_inicio: $('#reportrange_right').data('daterangepicker').startDate.format('YYYY-MM-DD'),
			fecha_fin: $('#reportrange_right').data('daterangepicker').endDate.format('YYYY-MM-DD'),
			turno_inicio: turno_inicio,
			turno_fin: turno_fin

		}

		$.ajax({
			url: 'cont/ver_mercado.php',
			type: 'GET',
			data: datos,
		}).done(function(datos){


		});
		console.log(datos);

	});
});