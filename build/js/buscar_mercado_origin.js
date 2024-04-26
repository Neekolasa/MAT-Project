$(document).ready(function(){
	/*if(isUserOnMobile()){
		$(".pc").hide();
	}
	else {
		$(".pc").show();
	}*/

	currentDate=moment().format('YYYY-MM-DD');
	currentTime=moment().format('HH:mm');

	if (currentTime>'05:59' && currentTime<'15:37') {
		var turno_inicio = "06:00";
		var turno_fin = "15:36";
		var tipo_turno = "A";
		fecha_inicio = currentDate;
		fecha_fin = currentDate;
		
		var datos = {
			fecha_inicio: fecha_inicio,
			fecha_fin: fecha_fin,
			turno_inicio: turno_inicio,
			turno_fin: turno_fin,
			tipo_turno: tipo_turno

		}
		//console.log(datos);

		$.ajax({
			url: 'cont/ver_mercado.php',
			type: 'GET',
			data: datos,
		}).done(function(datos){
			test = (JSON.parse(datos));
			//console.log(test[0]['rackeo']);
			if (test['info'][0]['rackeo']==0) {
				/*Swal.fire({
				  position: 'center',
				  icon: 'error',
				  title: 'No se encontró información de este día',
				  showConfirmButton: false,
				  timer: 1500
				});*/

			}
			else{
				var tabla = $('#date-mercado').DataTable({
				    dom: 'frtlip',
				    destroy: true,
				    responsive: {
                details: {
                    type: 'column', // Establece el modo de visualización de detalles como columna
                }
            },
			    	order:[[4, 'desc']],
				    language: {
				        url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
				    },
				    buttons: [
				     	{extend :'copy', text: 'Copiar al portapapeles',className:"btn btn-primary boton-margen boton-responsivo",
				      	attr:  {
				                id: 'jkjk'
				            }},
				     	{extend :'excel', text: 'Generar excel',className:"btn btn-primary text-light boton-margen boton-responsivo"},
				     	{extend :'print', text: 'Imprimir documento',className:"btn btn-primary text-light boton-margen boton-responsivo"},
				     	{extend :'pdf', text: 'Generar PDF',className:"btn btn-primary text-light boton-margen boton-responsivo"}
				    ],
				    className: "center-block",
				    columns: [
					    { data: "recibos" },
					    { data: "rackeo" },
					    { data: "contingencia" },
					    { data: "total" },
					    { data: "fecha" }
					   
					  ]
				});
				tabla.rows().remove();
	    		
	    		Data = (JSON.parse(datos));
	    		tabla.rows.add(Data['info']);


	    		/*****************************************/

	    		totalRackeos = Data[0];
	    		totalContingencia = Data[1];
	    		totalMovimientos = Data[2];
	    		$('#grafico_b').hide();
	    		$('#grafico_a').removeClass();
	    		$('#grafico_a').addClass('col-sm-12');
	    		$('#grafico_a').addClass('col-md-12');


	    		google.charts.load('current', {packages: ['corechart']});
	    		google.charts.setOnLoadCallback(drawChart);

				function drawChart() {
					var options = {
						title: "SPMKT Turno "+tipo_turno,
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

			    var chart = new google.visualization.ColumnChart(document.getElementById('grafico_a'));
					    
			    chart.draw(data, options);
    		}
		}
			


		});
	}
	else if (currentTime>'15:36' && currentTime<'23:59'){
		var turno_inicio = "15:36";
		var turno_fin = "23:59";
		var tipo_turno = "B";
		
		
			

			
			
		var fecha2 = new Date();


		fecha2.setDate(fecha2.getDate() + 1);

		
		var ano = fecha2.getFullYear();
		var mes = fecha2.getMonth() + 1; 
		var dia = fecha2.getDate();

		
		mes = mes < 10 ? '0' + mes : mes;
		dia = dia < 10 ? '0' + dia : dia;

		// Crear la cadena en formato "año, mes, día"
		var fechaFormateada = ano + '-' + mes + '-' + dia;
		formattedDate2=fechaFormateada;
			//console.log("SIG FECHA "+fecha_arriba);

			fecha_inicio = currentDate;
			fecha_fin = formattedDate2;

		
		var datos = {
			fecha_inicio: fecha_inicio,
			fecha_fin: fecha_fin,
			turno_inicio: turno_inicio,
			turno_fin: turno_fin,
			tipo_turno: tipo_turno

		}
		//console.log(datos);

		$.ajax({
			url: 'cont/ver_mercado.php',
			type: 'GET',
			data: datos,
		}).done(function(datos){
			test = (JSON.parse(datos));
			console.log(JSON.parse(datos));
			if (test['info'][0]['rackeo']==0) {
				/*Swal.fire({
				  position: 'center',
				  icon: 'error',
				  title: 'No se encontró información de este día',
				  showConfirmButton: false,
				  timer: 1500
				});*/

			}
			else{

				$("#turno option:eq(1)").prop("selected", true);

				var tabla = $('#date-mercado').DataTable({
				    dom: 'frtlip',
				    destroy: true,
				    legend: {position: 'none'},
				    responsive: true,
			    	order:[[4, 'desc']],
				    language: {
				        url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
				    },
				    buttons: [
				     	{extend :'copy', text: 'Copiar al portapapeles',className:"btn btn-primary boton-margen",
				      	attr:  {
				                id: 'jkjk'
				            }},
				     	{extend :'excel', text: 'Generar excel',className:"btn btn-primary text-light boton-margen"},
				     	{extend :'print', text: 'Imprimir documento',className:"btn btn-primary text-light boton-margen"},
				     	{extend :'pdf', text: 'Generar PDF',className:"btn btn-primary text-light boton-margen"}
				    ],
				    className: "center-block",
				    columns: [
					    { data: "recibos" },
					    { data: "rackeo" },
					    { data: "contingencia" },
					    { data: "total" },
					    { data: "fecha" }
					   
					  ]
				});
				tabla.rows().remove();
	    		
	    		Data = (JSON.parse(datos));
	    		tabla.rows.add(Data['info']);

	    		totalRackeos = Data[0];
	    		totalContingencia = Data[1];
	    		totalMovimientos = Data[2];

	    		$('#grafico_b').hide();
	    		$('#grafico_a').removeClass();
	    		$('#grafico_a').addClass('col-sm-12');
	    		$('#grafico_a').addClass('col-md-12');

	    		google.charts.load('current', {packages: ['corechart']});

		    	google.charts.setOnLoadCallback(drawChart);

					function drawChart() {
						var options = {
							title: "SPMKT Turno "+tipo_turno,
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

					    var chart = new google.visualization.ColumnChart(document.getElementById('grafico_a'));
					    
					    chart.draw(data, options);
		    		}


			}
			


		});
	}

	$('#buscar_mercado').on('click',function(e){
		e.preventDefault();

		
		var turno_inicio = "";
		var turno_fin = "";
		var tipo_turno = $('#turno').val();
		if (tipo_turno == "A") {
			turno_inicio = "06:00";
			turno_fin = "15:36";
			fecha_inicio = $('#reportrange_right').data('daterangepicker').startDate.format('YYYY-MM-DD');
			fecha_fin = $('#reportrange_right').data('daterangepicker').endDate.format('YYYY-MM-DD');
		}
		else if (tipo_turno == "B") {
			turno_inicio = "15:36";
			turno_fin = "00:10";
			let fecha_temp = $('#reportrange_right').data('daterangepicker').endDate.format('YYYY-MM-DD');
			let fecha = Date.parse(fecha_temp);
			let month= addZero((fecha.getMonth()+1));
			if (month>"12") {
				month = "01";
			}
			let day = addZero((fecha.getDate()+1));
			if (month == '04' || month == '06' || month == '09' || month == '11') {
				if (day>"30") {
					day="01";
					month = addZero((fecha.getMonth()+2));
				}
			}
			else if (month == '02'){
				if (day>"28") {
					day="01";
					month = addZero((fecha.getMonth()+2));
				}
				year = fecha.getFullYear();
				if (year%4 == 0) {
					day="01"
					month = addZero((fecha.getMonth()+2));
					//console.log("DIA "+day+" MES "+month);
				}
			}
			else{
				if (day>"31") {
					day="01";
					month = addZero((fecha.getMonth()+2));
				}

			}
			

			
			
			let fecha_arriba = fecha.getFullYear()+"-"+month +"-"+ day;
			//console.log("SIG FECHA "+fecha_arriba);

			fecha_inicio = $('#reportrange_right').data('daterangepicker').startDate.format('YYYY-MM-DD');
			fecha_fin = fecha_arriba;

		}
		else
		{
			turno_inicio = "06:00";
			turno_fin = "15:36";
			fecha_inicio = $('#reportrange_right').data('daterangepicker').startDate.format('YYYY-MM-DD');
			fecha_fin = $('#reportrange_right').data('daterangepicker').endDate.format('YYYY-MM-DD');
		}
		var datos = {
			fecha_inicio: fecha_inicio,
			fecha_fin: fecha_fin,
			turno_inicio: turno_inicio,
			turno_fin: turno_fin,
			tipo_turno: tipo_turno

		}
		//console.log(datos);

		$.ajax({
			url: 'cont/ver_mercado.php',
			type: 'GET',
			data: datos,
		}).done(function(datos){
			test = (JSON.parse(datos));
			//console.log();
			if (test['info'][0]['rackeo']==0 && test['info'][0]['contingencia']==0) {
				Swal.fire({
				  position: 'center',
				  icon: 'error',
				  title: 'No se encontró información de este día',
				  showConfirmButton: false,
				  timer: 1500
				});

			}
			else{
				new PNotify({
	                title: 'Exito',
	                text: 'Informacion actualizada turno '+tipo_turno,
	                type: 'success',
	                styling: 'bootstrap3'
	            });
				var tabla = $('#date-mercado').DataTable({
				    dom: 'frtlip',
				    destroy: true,
				    responsive: true,
			    	order:[[4, 'desc']],
				    language: {
				        url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
				    },
				    buttons: [
				     	{extend :'copy', text: 'Copiar al portapapeles',className:"btn btn-primary boton-margen",
				      	attr:  {
				                id: 'jkjk'
				            }},
				     	{extend :'excel', text: 'Generar excel',className:"btn btn-primary text-light boton-margen"},
				     	{extend :'print', text: 'Imprimir documento',className:"btn btn-primary text-light boton-margen"},
				     	{extend :'pdf', text: 'Generar PDF',className:"btn btn-primary text-light boton-margen"}
				    ],
				    className: "center-block",
				    columns: [
					    { data: "recibos" },
					    { data: "rackeo" },
					    { data: "contingencia" },
					    { data: "total" },
					    { data: "fecha" }
					   
					  ]
				});
				tabla.rows().remove();
	    		
	    		Data = JSON.parse(datos);//console.log(JSON.parse(info));
	    		tabla.rows.add((Data['info']));

	    		totalRackeos = Data[0];
	    		totalContingencia = Data[1];
	    		totalMovimientos = Data[2];


	    		if (tipo_turno != 'Comparativo') {


	    			$('#grafico_b').hide();
	    			$('#grafico_a').removeClass();
	    			$('#grafico_a').addClass('col-sm-12');
	    			$('#grafico_a').addClass('col-md-12');


	    			google.charts.load('current', {packages: ['corechart']});

		    		google.charts.setOnLoadCallback(drawChart);

					function drawChart() {
						var options = {
							title: "SPMKT Turno "+tipo_turno,
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

					    var chart = new google.visualization.ColumnChart(document.getElementById('grafico_a'));
					    
					    chart.draw(data, options);
		    		}
			      
			    }
			    else{
			    	$('#grafico_a').removeClass();
			    	$('#grafico_a').addClass('col-sm-6');
			    	$('#grafico_a').addClass('col-md-6');
			    	totalRackeosB		= Data[3];
	    			totalContingenciaB	= Data[4];
	    			totalMovimientosB	= Data[5];

			    	google.charts.load('current', {packages: ['corechart']});

		    		google.charts.setOnLoadCallback(drawChart);

					function drawChart() {
						var options = {
							title: "SPMKT Turno A",
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

					    var chart = new google.visualization.ColumnChart(document.getElementById('grafico_a'));
					    
					    chart.draw(data, options);


		    		}
		    		google.charts.load('current', {packages: ['corechart']});

		    		google.charts.setOnLoadCallback(drawChart_b);

					function drawChart_b() {
						var options = {
							title: "SPMKT Turno B",
							height: 500,
							legend: {position: 'none'},
							annotations: {
							textStyle: {
							fontSize: 20,
							}
						}
					}
				      


					    var data = new google.visualization.arrayToDataTable([['Accion','Total',{ role: 'style' }, { role: 'annotation' }],
					    													['Rackeos',parseInt(totalRackeosB),'#66ccff',totalRackeosB.toString()], 
					    													['Contingencias',parseInt(totalContingenciaB),'#33FF9B',totalContingenciaB.toString()],
					    													['Movimientos',parseInt(totalMovimientosB),'#AFFF33',totalMovimientosB.toString()]]);

					    var chart = new google.visualization.ColumnChart(document.getElementById('grafico_b'));
					    
					    chart.draw(data, options);

		    		}
		    		$('#grafico_b').show();

			    }
			}
			


		});
		//console.log(datos);

	});

	function addZero(data){
		if (data<10) {
			return '0'+data;
		}
		else{
			return data;
		}
	}
});