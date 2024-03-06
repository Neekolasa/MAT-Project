$('.otherMot').hide();
$('#weekGraphicComparativo').hide();
$('#weekGraphic').removeClass();
$('#weekGraphic').addClass('col-sm-12');
$('#weekGraphic').addClass('col-md-12');

$(document).ready(function(){
	 $('#single_calendar').daterangepicker({
	 		startDate: moment(),
      singleDatePicker: true,
      singleClasses: "picker_1",
      locale: {
        format: 'YYYY-MM-DD',
        daysOfWeek: [
          "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"
        ],
        monthNames: [
          "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        ],
        firstDay: 1 // Lunes como primer día de la semana
      },
      maxDate: moment()
    }, function (start, end, label) {
      console.log(start.toISOString(), end.toISOString(), label);
    });

	if ($('#motivoTM').val()=='Otro') {
		$('.otherMot').show();
	}

	$("#modalTiempo_button").on('click',function(e){
		//e.preventDefault();
		$("#modalTiempo").modal('show');
		console.log('click');

		$('#dateCreated').val(moment().format('YYYY-MM-DD h:mm:ss a'));
		$('#motivoTM').on('change',function(){
			var motivo = this.value;
			if (motivo=='Otro') {
				$('.otherMot').show();
			}
			else
			{
				$('.otherMot').hide();
			}
		});
	});

	$('#buscarTM').on('click',function(){
		fechaInicial = $('#reportrange_right').data('daterangepicker').startDate.format('YYYY-MM-DD');
		fechaFinal = $('#reportrange_right').data('daterangepicker').endDate.format('YYYY-MM-DD');

		turno = $('#turno').val();
		if (turno == 'A') {
			horaInicio = '06:00';
			horaFin = '15:36';
			$('#weekGraphicComparativo').hide();
			$('#weekGraphic').removeClass();
			$('#weekGraphic').addClass('col-sm-12');
			$('#weekGraphic').addClass('col-md-12');
			comparar = false;
		}
		else if (turno == 'B') {
			horaInicio = '15:36';
			horaFin = '00:10';
			$('#weekGraphicComparativo').hide();
			$('#weekGraphic').removeClass();
			$('#weekGraphic').addClass('col-sm-12');
			$('#weekGraphic').addClass('col-md-12');
			var nextDay = moment(fechaFinal).add(1, 'days').format('YYYY-MM-DD');
    		fechaFinal = nextDay;
    		comparar = false;
		}
		else if(turno == 'Comparativo'){
			horaInicio = '06:00';
			horaFin = '15:36';
			comparar = true;
		}

		if (comparar) {
			horaInicioB = '15:36';
			horaFinB = '00:10';
			var datosC = {
				fechaInicial: fechaInicial,
				fechaFinal: fechaFinal,
				turno: 'B',
				horaInicio : horaInicio,
				horaFin : horaFin,
				horaInicioB : horaInicioB,
				horaFinB : horaFinB,
				request: 'getGraphicComparativo'
			}
			$.ajax({
				url: 'cont/tiempoMuertoController.php',
				type: 'GET',
				data: datosC
			})
			.done(function(info) {
				var Data = JSON.parse(info);
				
				if (Data === undefined || Data.length == 0) {
				    new PNotify({
						title: 'Error',
						text: 'No se encontro informacion de uno o varios dias',
						type: 'error',
						styling: 'bootstrap3'
					});
				   $("#tableTM").clear().draw();
				}
				else{
					new PNotify({
						title: 'Exito',
						text: 'Se ha actualizado la informacion para turno comparativo',
						type: 'success',
						styling: 'bootstrap3'
					});
					
					google.charts.load('current', { packages: ['corechart'] });
					google.charts.setOnLoadCallback(drawChartB);

					function drawChartB() {
					    var optionsB = {
					        title: "Tiempo muerto por rango de fechas turno B",
					        height: 500,
					        legend: { position: 'none' },
					        annotations: {
					            textStyle: {
					                fontSize: 20,
					            }
					        }
					    };

					    var dataRowsB = [['Dia', 'Minutos', { role: 'style' }, { role: 'annotation' }]];

					    for (var i = 0; i < Data.length; i++) {
					        var mes = Data[i]['Fecha'];
					        var minutos = parseInt(Data[i]['Minutos']);
					        var color = '#66ccff';

					        dataRowsB.push([mes.toString(), minutos, color, minutos.toString()]);
					    }

					    var dataB = new google.visualization.arrayToDataTable(dataRowsB);

					    var chartB = new google.visualization.LineChart(document.getElementById('weekGraphicComparativo'));

					    chartB.draw(dataB, optionsB);
					}
					$('#weekGraphicComparativo').show();
					$('#weekGraphic').removeClass();
					$('#weekGraphic').addClass('col-sm-6');
					$('#weekGraphic').addClass('col-md-6');
					comparar = true;
				}
			})

		}

		if (comparar) {
			var datos = {
				fechaInicial: fechaInicial,
				fechaFinal: fechaFinal,
				turno: 'A',
				horaInicio : horaInicio,
				horaFin : horaFin,
				request: 'getGraphic'
			}
		}
		else{
			var datos = {
				fechaInicial: fechaInicial,
				fechaFinal: fechaFinal,
				turno: turno,
				horaInicio : horaInicio,
				horaFin : horaFin,
				request: 'getGraphic'
			}
		}
		
		



		$.ajax({
			url: 'cont/tiempoMuertoController.php',
			type: 'GET',
			data: datos
		})
		.done(function(info) {
			var Data = JSON.parse(info);
			console.log(Data);
			if (Data === undefined || Data.length == 0) {
			    new PNotify({
					title: 'Error',
					text: 'No se encontro informacion de uno o varios dias',
					type: 'error',
					styling: 'bootstrap3'
				});
			}
			else{
				if (comparar) {
					text1 = 'Se ha actualizado la informacion para turno A';
					text2 = 'Tiempo muerto por rango de fechas turno A';
				}
				else{
					text1 = 'Se ha actualizado la informacion para turno '+turno;
					text2 = 'Tiempo muerto por rango de fechas turno '+turno;
				}
				new PNotify({
					title: 'Exito',
					text: text1,
					type: 'success',
					styling: 'bootstrap3'
				});
				google.charts.load('current', { packages: ['corechart'] });
				google.charts.setOnLoadCallback(drawChart);

				function drawChart() {
				    var options = {
				        title: text2,
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
				        var mes = Data[i]['Fecha'];
				        var minutos = parseInt(Data[i]['Minutos']);
				        var color = '#66ccff';

				        dataRows.push([mes.toString(), minutos, color, minutos.toString()]);
				    }

				    var data = new google.visualization.arrayToDataTable(dataRows);

				    var chart = new google.visualization.LineChart(document.getElementById('weekGraphic'));

				    chart.draw(data, options);
				}
			}
			
			
			

		});


		var datos = {
			fechaInicial: fechaInicial,
			fechaFinal: fechaFinal,
			turno: turno,
			horaInicio : horaInicio,
			horaFin : horaFin,
			request: 'getRangeTM'
		}
		$.ajax({
				url: 'cont/tiempoMuertoController.php',
				type: 'GET',
				data: datos
			})
			.done(function(info) {
				//console.log(info);
				var tableTM = $('#tableTM').DataTable({
					    dom: 'frtlip',
					    destroy: true,
					    responsive: true,
					   
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
						    { data: "codigo" },
						    { data: "minutoTM" },
						    { data: "motivo" },
						    { data: "personasAfectadas" },
						    { data: "comentarios" },
						    { data: "fecha"}
						   
						   
						  ]
					});

					tableTM.clear().draw();
				    var Datos = JSON.parse(info);

				    console.log(Datos);
				    tableTM.rows.add(Datos).draw();
			});
			
		
		

	});


	$('#tiempoMuertoSubmit').on('click',function(){
		tiempoMinutos = $('#tiempoMinutos').val();
		motivoTM = $('#motivoTM').val();
		if (motivoTM == 'Otro') {
			motivoTM = $('#motivoOther').val().replace(/[^a-zA-Z0-9 ]/g, '');
			motivoTM = motivoTM.replaceAll(' ','_');
		}
		codigosTM = $('#codigosTM').val();
		personasTM = $('#personasTM').val();
		comentariosAdd = $('#comentariosAdd').val();
		dateCreated = $('#dateCreated').val();
		turno = $('#turno_add').val();

		fecha = $('#single_calendar').val();
		

		if (tiempoMinutos == '' || motivoTM == '' || codigosTM == '' || personasTM == '' || dateCreated == '' || tiempoMinutos<1) {
			new PNotify({
				title: 'Error',
				text: 'Rellene los campos requeridos',
				type: 'error',
				styling: 'bootstrap3'
			});

		}
		else{
			
			
			
			var Datos = {
				codigo: codigosTM,
				minutoTM : tiempoMinutos,
				motivo: motivoTM,
				personasAfectadas : personasTM,
				comentarios : comentariosAdd,
				fecha : fecha,
				turno : turno,
				request : 'addTM'
			}
			//console.log($('#turno_add').val());
			$.ajax({
				url: 'cont/tiempoMuertoController.php',
				type: 'GET',
				data: Datos
			})
			.done(function(info) {
				var Data = JSON.parse(info);
				if (Data['response']=='success'){
					new PNotify({
						title: 'Exito',
						text: 'Tiempo muerto registrado correctamente',
						type: 'success',
						styling: 'bootstrap3'
					});
					tableTiempoMuerto();
					reloadGraphics();

				}
				else{
					new PNotify({
						title: 'Error',
						text: 'Compruebe la informacion e intente de nuevo',
						type: 'error',
						styling: 'bootstrap3'
					});
				}
			});


						
		}

	});

	tableTiempoMuerto();
	


});

function tableTiempoMuerto(){
	$.ajax({
		url: 'cont/tiempoMuertoController.php',
		type: 'GET',
		data: {request: 'getTM'},
	})
	.done(function(info) {
		//console.log(info);
		var tableTM = $('#tableTM').DataTable({
			    dom: 'frtlip',
			    destroy: true,
			    responsive: true,
			   	order:[[5, 'desc']],
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
				    { data: "codigo" },
				    { data: "minutoTM" },
				    { data: "motivo" },
				    { data: "personasAfectadas" },
				    { data: "comentarios" },
				    { data: "fecha"}
				    //{ data: "TOTALMOVIMIENTOS"}
				   
				  ]
			});

			tableTM.rows().remove();
    		
    		var Datos=(JSON.parse(info));
    		//console.log(Datos);
    		tableTM.rows.add(Datos);
	});
	

}