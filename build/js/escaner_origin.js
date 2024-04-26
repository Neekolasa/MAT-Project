$(document).ready(function () {

	if(isUserOnMobile()){
		$(".pc").hide();
	}
	else {
		$(".pc").show();
	}




	$("#dataSearch").on('click',function(e){
		e.preventDefault();
		dataScaner($("#Badge").val());
	});

});

function dataScaner(value){

	badge = value;

	$.ajax({
		url: 'cont/data_escaner.php',
		type: 'GET',
		data: { request: 'dataEscaner',
				badge: badge},
	})
	.done(function(data) {
		$("#grafico_data").show();
		Datos = JSON.parse(data);
		//console.log(Datos['SMKT']);


		if (Datos['SMKT']['TotalAcciones']>0) {
			google.charts.load('current', {packages: ['corechart']});
		    google.charts.setOnLoadCallback(drawChart);

		    nombre = Datos['SMKT']['Name']+" "+Datos['SMKT']['LastName'];
		    totalRackeos = Datos['SMKT']['RACKEO'];
		    totalContingencia = Datos['SMKT']['CONTINGENCIA'];
		    totalMovimientos = Datos['SMKT']['TotalAcciones'];

		    


			function drawChart() {
				var options = {
					title: "Eficiencia en SPMKT de "+nombre,
					height: 500,
					legend: {position: 'none'},
					annotations: {
					textStyle: {
					fontSize: 20,
						}
					}
				}
					      

				var data = new google.visualization.arrayToDataTable([['Accion','Total',{ role: 'style' }, { role: 'annotation' }],
					   													['Rackeos',parseInt(totalRackeos),'#66ccff',totalRackeos.toString()], 
					   													['Contingencias',parseInt(totalContingencia),'#33FF9B',totalContingencia.toString()],
					   													['Movimientos',parseInt(totalMovimientos),'#AFFF33',totalMovimientos.toString()]]);

				var chart = new google.visualization.ColumnChart(document.getElementById('grafico_data'));
						    
				chart.draw(data, options);
	    	}
		}
		else{
			$("#grafico_data").hide();
			new PNotify({
		            title: 'Atencion',
		            text: 'No hay informacion de SPMKT para este usuario',
		            type: 'notice',
		            styling: 'bootstrap3'
            	});
		}

		if (Datos['Rutas']['Total']>0){
			$("#grafico_tolvas").hide();
			//$("#grafico_tolvas").show();
			google.charts.load('current', {packages: ['corechart']});
		    google.charts.setOnLoadCallback(drawChart_tolva);

		    nombre = Datos['Rutas']['Nombre'];
		    totalComponente = Datos['Rutas']['COMPONENTE'];
		    totalPoliducto = Datos['Rutas']['POLIDUCTO'];
		    totalMovimientosTolva = Datos['Rutas']['Total'];
		    eficiencia = (Math.round((totalMovimientosTolva/250)*100))+"%";

		    


			function drawChart_tolva() {
				var options = {
					title: "Eficiencia del "+eficiencia+" en Rutas de "+nombre,
					height: 500,
					legend: {position: 'none'},
					annotations: {
					textStyle: {
					fontSize: 20,
						}
					}
				}
					      

				var data = new google.visualization.arrayToDataTable([['Accion','Total',{ role: 'style' }, { role: 'annotation' }],
					   													['Componente',parseInt(totalComponente),'#66ccff',totalComponente.toString()], 
					   													['Poliducto',parseInt(totalPoliducto),'#33FF9B',totalPoliducto.toString()],
					   													['TotalMovimientos',parseInt(totalMovimientosTolva),'#AFFF33',totalMovimientosTolva.toString()]]);

				var chart = new google.visualization.ColumnChart(document.getElementById('grafico_tolvas'));
						    
				chart.draw(data, options);
	    	}
		}
		else{
			$("#grafico_tolvas").hide();
			new PNotify({
		            title: 'Atencion',
		            text: 'No hay informacion de Rutas para este usuario',
		            type: 'notice',
		            styling: 'bootstrap3'
            	});
		}		
	});
	
}



