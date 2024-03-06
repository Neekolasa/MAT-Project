$(document).ready(function(){

	reloadGraphics();
	
});

function reloadGraphics(){
		weekGraphic();
		monthGraphic();
		yearGraphic();
}
function monthGraphic(){
		$.ajax({
		url: 'cont/tiempoMuertoController.php',
		type: 'GET',
		data: {request: 'getMonth'},
		})
		.done(function(info) {
			var Data = JSON.parse(info);

			google.charts.load('current', { packages: ['corechart'] });
			google.charts.setOnLoadCallback(drawChart);

			function drawChart() {
			    var options = {
			        title: "Tiempo muerto mensual",
			        height: 500,
			        legend: { position: 'none' },
			        annotations: {
			            textStyle: {
			                fontSize: 20,
			            }
			        }
			    };

			    var dataRows = [['Mes', 'Minutos', { role: 'style' }, { role: 'annotation' }]];

			    for (var i = 0; i < Data.length; i++) {
			        var mes = Data[i]['Mes'];
			        var minutos = parseInt(Data[i]['Minutos']);
			        var color = '#66ccff'; // Puedes cambiar esto si deseas diferentes colores para cada mes

			        dataRows.push([mes, minutos, color, minutos.toString()]);
			    }

			    var data = new google.visualization.arrayToDataTable(dataRows);

			    var chart = new google.visualization.LineChart(document.getElementById('historicGraphic'));

			    chart.draw(data, options);
			}
		})
}

function yearGraphic(){
	$.ajax({
		url: 'cont/tiempoMuertoController.php',
		type: 'GET',
		data: {request: 'getYear'},
	})
	.done(function(info) {
		var Data = JSON.parse(info);

		google.charts.load('current', { packages: ['corechart'] });
		google.charts.setOnLoadCallback(drawChart);

		function drawChart() {
		    var options = {
		        title: "Tiempo muerto anual",
		        height: 500,
		        legend: { position: 'none' },
		        annotations: {
		            textStyle: {
		                fontSize: 20,
		            }
		        }
		    };

		    var dataRows = [['Year', 'Minutos', { role: 'style' }, { role: 'annotation' }]];

		    for (var i = 0; i < Data.length; i++) {
		        var mes = Data[i]['Year'];
		        var minutos = parseInt(Data[i]['Minutos']);
		        var color = '#66ccff';

		        dataRows.push([mes.toString(), minutos, color, minutos.toString()]);
		    }

		    var data = new google.visualization.arrayToDataTable(dataRows);

		    var chart = new google.visualization.ColumnChart(document.getElementById('historicYearGraphic'));

		    chart.draw(data, options);
		}
	});
}

function weekGraphic(){
	$.ajax({
		url: 'cont/tiempoMuertoController.php',
		type: 'GET',
		data: {request: 'getWeek'},
	})
	.done(function(info) {
		var Data = JSON.parse(info);

		google.charts.load('current', { packages: ['corechart'] });
		google.charts.setOnLoadCallback(drawChart);

		function drawChart() {
		    var options = {
		        title: "Tiempo muerto semanal",
		        height: 500,
		        legend: { position: 'none' },
		        annotations: {
		            textStyle: {
		                fontSize: 20,
		            }
		        }
		    };

		    var dataRows = [['Dia', 'Minutos', { role: 'style' }, { role: 'annotation' }]];

		    for (var i = 0; i < Data.length; i++) {
		        var mes = Data[i]['NombreDia'];
		        var minutos = parseInt(Data[i]['Minutos']);
		        var color = '#66ccff';

		        dataRows.push([mes.toString(), minutos, color, minutos.toString()]);
		    }

		    var data = new google.visualization.arrayToDataTable(dataRows);

		    var chart = new google.visualization.LineChart(document.getElementById('weekGraphic'));

		    chart.draw(data, options);
		}
	});
}
