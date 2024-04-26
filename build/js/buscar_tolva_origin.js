$(document).ready(function(){
	/*if(isUserOnMobile()){
		$(".pc").hide();
	}
	else {
		$(".pc").show();
	}*/

	currentDate=moment().format('YYYY-MM-DD');
	currentTime=moment().format('HH:mm');
	//console.log("asasassa")
	if (currentTime>'05:59' && currentTime<'15:37') {
		turno_inicio = "06:00";
		turno_fin = "15:36";
		fecha_inicio = currentDate;
		fecha_fin = currentDate;
		tipo_turno = 'A'

		var datos = {
			fecha_inicio: fecha_inicio,
			fecha_fin: fecha_fin,
			turno_inicio: turno_inicio,
			turno_fin: turno_fin,
			tipo_turno: 'A'

		}
		$.ajax({
			url: 'cont/buscar_tolva.php',
			type: 'GET',
			data: datos,
			beforeSend: function(){
				 /* construct manually 
				  var bar1 = new ldBar("#ldBar");
				   ldBar stored in the element 
				  var bar2 = document.getElementById('ldBar').ldBar;
				  bar1.set(60);*/
			},
			complete: function(){

			}
		})
		.done(function(datos) {
			//console.log(datos);
			Data = JSON.parse(datos);
			//console.log(Data['infoH']);
			var tabla = $('#data-tolvas').DataTable({
			    dom: 'frt',
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
				    { data: "tolvas" },
				    { data: "tolvasSC" },
				    { data: "componente" },
				    { data: "poliducto" },
				    { data: "eficiencia" },
				    { data: "fecha" }
				   
				  ]
			});
			tabla.rows().remove();
	    	tabla.rows.add((Data['info']));

	    	//console.log(Data);
	    	var tabla_p = $('#data-tolvas-personas').DataTable({
			    dom: 'frtlip',
			    destroy: true,
			    responsive: true,
			   	//order:[[4, 'desc']],
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
				    { data: "Badge" },
				    { data: "Name" },
				    { data: "LastName" },
				    { data: "Tolvas" },
				    { data: "Eficiencia"}
				    
				   
				  ]
			});
			tabla_p.rows().remove();
	    	tabla_p.rows.add(Data['tolvasPersonas'][0]);

	    	

	    	var componente = Data['info'][0]['componente'];
	    	var poliducto = Data['info'][0]['poliducto'];
	    	var total = componente + poliducto;
	    	//console.log(tipo_turno);
	    	dataFullTolvas(Data);
	    	
	    			$('#grupo_b').hide();
	    			$('#grupo_a').removeClass();
	    			$('#grupo_a').addClass('col-sm-12');
	    			$('#grupo_a').addClass('col-md-12');


	    			google.charts.load('current', {packages: ['corechart']});

		    		google.charts.setOnLoadCallback(drawChart);

					function drawChart() {
						var options = {
							title: "Tolvas Turno "+tipo_turno,
							legend: {position: 'none'},
							height: 500,
							annotations: {
							textStyle: {
							fontSize: 20,
							}
						}
					}
				      

					    var data = new google.visualization.arrayToDataTable([['Accion','Total',{ role: 'style' }, { role: 'annotation' }],
					    													['Componente',parseInt(componente),'#66ccff',componente.toString()], 
					    													['Poliducto',parseInt(poliducto),'#33FF9B',poliducto.toString()],
					    													['Total',parseInt(total),'#AFFF33',total.toString()]]);

					    var chart = new google.visualization.ColumnChart(document.getElementById('grupo_a'));
					    
					    chart.draw(data, options);
		    		}

		    		dataTolvashora(Data,tipo_turno);

		    		$('#grafico-FullTolvasB').hide();
	    			$('#grafico-FullTolvasA').removeClass();
	    			$('#grafico-FullTolvasA').addClass('col-sm-12');
	    			$('#grafico-FullTolvasA').addClass('col-md-12');

		    		google.charts.load('current', {packages: ['corechart']});

		    		google.charts.setOnLoadCallback(drawChartTolvas);

					function drawChartTolvas() {
						var options = {
							title: "Grafico rutas turno "+tipo_turno,
							height: 500,
							legend: {position: 'none'},
							annotations: {
							textStyle: {
							fontSize: 20,
							}
						}
					}
						


					    var data = new google.visualization.arrayToDataTable([['Accion','Total',{ role: 'style' }, { role: 'annotation' }],
					    													['Componente',parseInt(Data['totales'][0]['TOTAL_COMPONENTE']),'#66ccff',(Data['totales'][0]['TOTAL_COMPONENTE']).toString()], 
					    													['Poliducto',parseInt(Data['totales'][0]['TOTAL_POLIDUCTO']),'#33FF9B',(Data['totales'][0]['TOTAL_POLIDUCTO']).toString()],
					    													['Total',parseInt(Data['totales'][0]['TOTALES']),'#AFFF33',(Data['totales'][0]['TOTALES']).toString()]]);

					    var chart = new google.visualization.ColumnChart(document.getElementById('grafico-FullTolvasA'));
					    
					    chart.draw(data, options);
					    


		    		}

		    		
	    	


		});
	}
	else if (currentTime>'15:36' && currentTime<'23:59'){
			turno_inicio = "15:36";
			turno_fin = "23:59";
			fecha_inicio = currentDate;
			fecha_fin = currentDate;
			tipo_turno = 'B'

			var fecha2 = new Date();


			fecha2.setDate(fecha2.getDate() + 1);

			
			var ano = fecha2.getFullYear();
			var mes = fecha2.getMonth() + 1; 
			var dia = fecha2.getDate();

			
			mes = mes < 10 ? '0' + mes : mes;
			dia = dia < 10 ? '0' + dia : dia;

			// Crear la cadena en formato "año, mes, día"
			var fechaFormateada = ano + '-' + mes + '-' + dia;
			formattedDate2=fechaFormateada
			fecha_fin = formattedDate2;


			var datos = {
			fecha_inicio: fecha_inicio,
			fecha_fin: fecha_fin,
			turno_inicio: turno_inicio,
			turno_fin: turno_fin,
			tipo_turno: 'B'

		}
		$.ajax({
			url: 'cont/buscar_tolva.php',
			type: 'GET',
			data: datos,
			beforeSend: function(){
				 /* construct manually 
				  var bar1 = new ldBar("#ldBar");
				   ldBar stored in the element 
				  var bar2 = document.getElementById('ldBar').ldBar;
				  bar1.set(60);*/
			},
			complete: function(){

			}
		})
		.done(function(datos) {
			$("#turno option:eq(1)").prop("selected", true);
			//console.log(datos);
			Data = JSON.parse(datos);
			//console.log(Data['infoH']);
			var tabla = $('#data-tolvas').DataTable({
			    dom: 'frt',
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
				    { data: "tolvas" },
				    { data: "tolvasSC" },
				    { data: "componente" },
				    { data: "poliducto" },
				    { data: "eficiencia" },
				    { data: "fecha" }
				   
				  ]
			});
			tabla.rows().remove();
	    	tabla.rows.add((Data['info']));

	    	//console.log(Data['tolvasPersonas'][0]);
	    	var tabla_p = $('#data-tolvas-personas').DataTable({
			    dom: 'frtlip',
			    destroy: true,
			    responsive: true,
			   	//order:[[4, 'desc']],
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
				    { data: "Badge" },
				    { data: "Name" },
				    { data: "LastName" },
				    { data: "Tolvas" },
				    { data: "Eficiencia"}
				    
				   
				  ]
			});
			tabla_p.rows().remove();
	    	tabla_p.rows.add(Data['tolvasPersonas'][0]);

	    	

	    	var componente = Data['info'][0]['componente'];
	    	var poliducto = Data['info'][0]['poliducto'];
	    	var total = componente + poliducto;
	    	//console.log(tipo_turno);
	    	dataFullTolvas(Data);
	    	
	    			$('#grupo_b').hide();
	    			$('#grupo_a').removeClass();
	    			$('#grupo_a').addClass('col-sm-12');
	    			$('#grupo_a').addClass('col-md-12');


	    			google.charts.load('current', {packages: ['corechart']});

		    		google.charts.setOnLoadCallback(drawChart);

					function drawChart() {
						var options = {
							title: "Tolvas Turno "+tipo_turno,
							legend: {position: 'none'},
							height: 500,
							annotations: {
							textStyle: {
							fontSize: 20,
							}
						}
					}
				      

					    var data = new google.visualization.arrayToDataTable([['Accion','Total',{ role: 'style' }, { role: 'annotation' }],
					    													['Componente',parseInt(componente),'#66ccff',componente.toString()], 
					    													['Poliducto',parseInt(poliducto),'#33FF9B',poliducto.toString()],
					    													['Total',parseInt(total),'#AFFF33',total.toString()]]);

					    var chart = new google.visualization.ColumnChart(document.getElementById('grupo_a'));
					    
					    chart.draw(data, options);
		    		}

		    		dataTolvashora(Data,tipo_turno);

		    		$('#grafico-FullTolvasB').hide();
	    			$('#grafico-FullTolvasA').removeClass();
	    			$('#grafico-FullTolvasA').addClass('col-sm-12');
	    			$('#grafico-FullTolvasA').addClass('col-md-12');

		    		google.charts.load('current', {packages: ['corechart']});

		    		google.charts.setOnLoadCallback(drawChartTolvas);

					function drawChartTolvas() {
						var options = {
							title: "Grafico rutas turno "+tipo_turno,
							height: 500,
							legend: {position: 'none'},
							annotations: {
							textStyle: {
							fontSize: 20,
							}
						}
					}
						


					    var data = new google.visualization.arrayToDataTable([['Accion','Total',{ role: 'style' }, { role: 'annotation' }],
					    													['Componente',parseInt(Data['totales'][0]['TOTAL_COMPONENTE']),'#66ccff',(Data['totales'][0]['TOTAL_COMPONENTE']).toString()], 
					    													['Poliducto',parseInt(Data['totales'][0]['TOTAL_POLIDUCTO']),'#33FF9B',(Data['totales'][0]['TOTAL_POLIDUCTO']).toString()],
					    													['Total',parseInt(Data['totales'][0]['TOTALES']),'#AFFF33',(Data['totales'][0]['TOTALES']).toString()]]);

					    var chart = new google.visualization.ColumnChart(document.getElementById('grafico-FullTolvasA'));
					    
					    chart.draw(data, options);
					    


		    		}

		    		
	    	
	    


		});

	}


	$('#buscar_tolva').on('click',function(e){
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
			url: 'cont/buscar_tolva.php',
			type: 'GET',
			data: datos,
			beforeSend: function(){
				 /* construct manually 
				  var bar1 = new ldBar("#ldBar");
				   ldBar stored in the element 
				  var bar2 = document.getElementById('ldBar').ldBar;
				  bar1.set(60);*/
			},
			complete: function(){

			}
		})
		.done(function(datos) {
			new PNotify({
	                title: 'Exito',
	                text: 'Informacion actualizada turno '+tipo_turno,
	                type: 'success',
	                styling: 'bootstrap3'
	            });
			//console.log(datos);
			Data = JSON.parse(datos);
			//console.log(Data['infoH']);
			var tabla = $('#data-tolvas').DataTable({
			    dom: 'frt',
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
				    { data: "tolvas" },
				    { data: "tolvasSC" },
				    { data: "componente" },
				    { data: "poliducto" },
				    { data: "eficiencia" },
				    { data: "fecha" }
				   
				  ]
			});
			tabla.rows().remove();
	    	tabla.rows.add((Data['info']));

	    	//console.log(Data['tolvasPersonas'][0]);
	    	var tabla_p = $('#data-tolvas-personas').DataTable({
			    dom: 'frtlip',
			    destroy: true,
			    responsive: true,
			   	//order:[[4, 'desc']],
			    language: {
			        url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
			    },
			    buttons: [
			     	{extend :'copy', text: 'Copiar al portapapeles',className:"btn btn-primary",
			      	attr:  {
			                id: 'jkjk'
			            }},
			     	{extend :'excel', text: 'Generar excel',className:"btn btn-primary text-light boton-margen"},
			     	{extend :'print', text: 'Imprimir documento',className:"btn btn-primary text-light boton-margen"},
			     	{extend :'pdf', text: 'Generar PDF',className:"btn btn-primary text-light boton-margen"}
			    ],
			    className: "center-block",
			    columns: [
				    { data: "Badge" },
				    { data: "Name" },
				    { data: "LastName" },
				    { data: "Tolvas" },
				    { data: "Eficiencia"}
				    
				   
				  ]
			});
			tabla_p.rows().remove();
	    	tabla_p.rows.add(Data['tolvasPersonas'][0]);

	    	

	    	var componente = Data['info'][0]['componente'];
	    	var poliducto = Data['info'][0]['poliducto'];
	    	var total = componente + poliducto;
	    	//console.log(tipo_turno);
	    	dataFullTolvas(Data);
	    	if (tipo_turno!="Comparativo") {

	    			$('#grupo_b').hide();
	    			$('#grupo_a').removeClass();
	    			$('#grupo_a').addClass('col-sm-12');
	    			$('#grupo_a').addClass('col-md-12');


	    			google.charts.load('current', {packages: ['corechart']});

		    		google.charts.setOnLoadCallback(drawChart);

					function drawChart() {
						var options = {
							title: "Tolvas Turno "+tipo_turno,
							legend: {position: 'none'},
							height: 500,
							annotations: {
							textStyle: {
							fontSize: 20,
							}
						}
					}
				      

					    var data = new google.visualization.arrayToDataTable([['Accion','Total',{ role: 'style' }, { role: 'annotation' }],
					    													['Componente',parseInt(componente),'#66ccff',componente.toString()], 
					    													['Poliducto',parseInt(poliducto),'#33FF9B',poliducto.toString()],
					    													['Total',parseInt(total),'#AFFF33',total.toString()]]);

					    var chart = new google.visualization.ColumnChart(document.getElementById('grupo_a'));
					    
					    chart.draw(data, options);
		    		}
		    		dataTolvashora(Data,tipo_turno);
		    		$("#grafico-tolvas").show();
		    		
		    		
	    		
	    			$("#grafico_tolvasB").hide();
	    			//$("#grafico_tolvasA").hide()
		    		$('#grafico-FullTolvasB').hide();
	    			$('#grafico-FullTolvasA').removeClass();
	    			$('#grafico-FullTolvasA').addClass('col-sm-12');
	    			$('#grafico-FullTolvasA').addClass('col-md-12');

		    		google.charts.load('current', {packages: ['corechart']});

		    		google.charts.setOnLoadCallback(drawChartTolvas);

					function drawChartTolvas() {
						var options = {
							title: "Grafico rutas turno "+tipo_turno,
							height: 500,
							legend: {position: 'none'},
							annotations: {
							textStyle: {
							fontSize: 20,
							}
						}
					}
						


					    var data = new google.visualization.arrayToDataTable([['Accion','Total',{ role: 'style' }, { role: 'annotation' }],
					    													['Componente',parseInt(Data['totales'][0]['TOTAL_COMPONENTE']),'#66ccff',(Data['totales'][0]['TOTAL_COMPONENTE']).toString()], 
					    													['Poliducto',parseInt(Data['totales'][0]['TOTAL_POLIDUCTO']),'#33FF9B',(Data['totales'][0]['TOTAL_POLIDUCTO']).toString()],
					    													['Total',parseInt(Data['totales'][0]['TOTALES']),'#AFFF33',(Data['totales'][0]['TOTALES']).toString()]]);

					    var chart = new google.visualization.ColumnChart(document.getElementById('grafico-FullTolvasA'));
					    
					    chart.draw(data, options);
					    


		    		}

		    		
	    	}
	    	else{
	    			//dataTolvashora(Data,'A');
		    		new PNotify({
		                title: 'Exito',
		                text: 'Informacion actualizada',
		                type: 'success',
		                styling: 'bootstrap3'
		            });
	    			dataArrayA = new Array();
			    	dataArrayA[0]= ['Hora','Total',{ role: 'style' }, { role: 'annotation' }];
			    	arrayColors = ["#66ccff","#33FF9B","#AFFF33"];
			    	var b = 0;
			    	for(var i = 0, length1 = Data['infoH'].length; i < length1; i++){
			    		b++;
			    		if (b>2) {
			    			b=0;
			    		}
			    		dataArrayA[i+1] = [Data['infoH'][i]['horas'],parseInt((Data['infoH'][i]['tolvas'])),arrayColors[b],(Data['infoH'][i]['tolvas']).toString()];
			    		}
			    	//dataArray.push("SDSDSDS");
			    	//console.log(dataArray);
			    	google.charts.load('current', {packages: ['corechart']});

				    		google.charts.setOnLoadCallback(drawChartK);

							function drawChartK() {
								var options = {
									title: "Tolvas por hora turno A",
									height: 500,
									legend: {position: 'none'},
									annotations: {
									textStyle: {
									fontSize: 20,
									}
								}
							}
							//console.log(dataArray);
						      

							    var data = new google.visualization.arrayToDataTable(dataArrayA,false);

							    var chart = new google.visualization.ColumnChart(document.getElementById('grafico-tolvas'));
							    
							    chart.draw(data, options);


				    		}
				    dataArray = new Array();
			    	dataArray[0]= ['Hora','Total',{ role: 'style' }, { role: 'annotation' }];
			    	arrayColors = ["#66ccff","#33FF9B","#AFFF33"];
			    	var b = 0;
			    	for(var i = 0, length1 = Data['infoHB'].length; i < length1; i++){
			    		b++;
			    		if (b>2) {
			    			b=0;
			    		}
			    		dataArray[i+1] = [Data['infoHB'][i]['horas'],parseInt((Data['infoHB'][i]['tolvas'])),arrayColors[b],(Data['infoHB'][i]['tolvas']).toString()];
			    		}
			    	//dataArray.push("SDSDSDS");
			    	//console.log(dataArray);
			    	google.charts.load('current', {packages: ['corechart']});

				    		google.charts.setOnLoadCallback(drawChartKB);

							function drawChartKB() {
								var options = {
									title: "Tolvas por hora turno B",
									height: 500,
									legend: {position: 'none'},
									annotations: {
									textStyle: {
									fontSize: 20,
									}
								}
							}
					//console.log(dataArray);
				      

					    var data = new google.visualization.arrayToDataTable(dataArray,false);

					    var chart = new google.visualization.ColumnChart(document.getElementById('grafico_tolvasB'));
					    
					    chart.draw(data, options);


		    		}
	    			
	    			//dataTolvashoraA(Data)
	    			dataTolvashoraB(Data);
	    			//$("#grafico-tolvas").hide();
	    			$("#grafico_tolvasB").show();
	    			//$("#grafico_tolvasA").show()

	    			$('#grupo_a').removeClass();
			    	$('#grupo_a').addClass('col-sm-6');
			    	$('#grupo_a').addClass('col-md-6');
			    	var componenteB = Data['infoB'][0]['componente'];
			    	var poliductoB = Data['infoB'][0]['poliducto'];
			    	var totalB = componenteB + poliductoB;

			    	google.charts.load('current', {packages: ['corechart']});

		    		google.charts.setOnLoadCallback(drawChart);

					function drawChart() {
						var options = {
							title: "Tolvas Turno A",
							height: 500,
							legend: {position: 'none'},
							annotations: {
							textStyle: {
							fontSize: 20,
							}
						}
					}
						
				      

					    var data = new google.visualization.arrayToDataTable([['Accion','Total',{ role: 'style' }, { role: 'annotation' }],
					    													['Componente',parseInt(componente),'#66ccff',componente.toString()], 
					    													['Poliducto',parseInt(poliducto),'#33FF9B',poliducto.toString()],
					    													['Total',parseInt(total),'#AFFF33',total.toString()]]);

					    var chart = new google.visualization.ColumnChart(document.getElementById('grupo_a'));
					    
					    chart.draw(data, options);


		    		}
		    		google.charts.load('current', {packages: ['corechart']});

		    		google.charts.setOnLoadCallback(drawChart_b);

					function drawChart_b() {
						var options = {
							title: "Tolvas Turno B",
							height: 500,
							legend: {position: 'none'},
							annotations: {
							textStyle: {
							fontSize: 20,
							}
						}
					}
				      


					    var data = new google.visualization.arrayToDataTable([['Accion','Total',{ role: 'style' }, { role: 'annotation' }],
					    													['Componente',parseInt(componenteB),'#66ccff',componenteB.toString()], 
					    													['Poliducto',parseInt(poliductoB),'#33FF9B',poliductoB.toString()],
					    													['Total',parseInt(totalB),'#AFFF33',totalB.toString()]]);

					    var chart = new google.visualization.ColumnChart(document.getElementById('grupo_b'));
					    
					    chart.draw(data, options);

		    		}
		    		$('#grupo_b').show();

		    		$('#grafico-FullTolvasA').removeClass();
			    	$('#grafico-FullTolvasA').addClass('col-sm-6');
			    	$('#grafico-FullTolvasA').addClass('col-md-6');

			    	google.charts.load('current', {packages: ['corechart']});

		    		google.charts.setOnLoadCallback(drawChartTolvasS);

					function drawChartTolvasS() {
						var options = {
							title: "Grafico rutas turno A",
							height: 500,
							legend: {position: 'none'},
							annotations: {
							textStyle: {
							fontSize: 20,
							}
						}
					}
						


					    var data = new google.visualization.arrayToDataTable([['Accion','Total',{ role: 'style' }, { role: 'annotation' }],
					    													['Componente',parseInt(Data['totales'][0]['TOTAL_COMPONENTE']),'#66ccff',(Data['totales'][0]['TOTAL_COMPONENTE']).toString()], 
					    													['Poliducto',parseInt(Data['totales'][0]['TOTAL_POLIDUCTO']),'#33FF9B',(Data['totales'][0]['TOTAL_POLIDUCTO']).toString()],
					    													['Total',parseInt(Data['totales'][0]['TOTALES']),'#AFFF33',(Data['totales'][0]['TOTALES']).toString()]]);

					    var chart = new google.visualization.ColumnChart(document.getElementById('grafico-FullTolvasA'));
					    
					    chart.draw(data, options);
					    


		    		}

		    		google.charts.load('current', {packages: ['corechart']});

		    		google.charts.setOnLoadCallback(drawChartTolvasB);

					function drawChartTolvasB() {
						var options = {
							title: "Grafico rutas turno B",
							height: 500,
							legend: {position: 'none'},
							annotations: {
							textStyle: {
							fontSize: 20,
							}
						}
					}
						


					    var data = new google.visualization.arrayToDataTable([['Accion','Total',{ role: 'style' }, { role: 'annotation' }],
					    													['Componente',parseInt(Data['totalesB'][0]['TOTAL_COMPONENTE']),'#66ccff',(Data['totalesB'][0]['TOTAL_COMPONENTE']).toString()], 
					    													['Poliducto',parseInt(Data['totalesB'][0]['TOTAL_POLIDUCTO']),'#33FF9B',(Data['totalesB'][0]['TOTAL_POLIDUCTO']).toString()],
					    													['Total',parseInt(Data['totalesB'][0]['TOTALES']),'#AFFF33',(Data['totalesB'][0]['TOTALES']).toString()]]);

					    var chart = new google.visualization.ColumnChart(document.getElementById('grafico-FullTolvasB'));
					    
					    chart.draw(data, options);
					    
		    		}
		    		$('#grafico-FullTolvasB').show();
	    	}


		});


	});


});

function addZero(data){
		if (data<10) {
			return '0'+data;
		}
		else{
			return data;
		}
	}

function dataTolvashora(Data,tipo_turno){
	var tablaH = $('#data-tolvas-hora').DataTable({
			    dom: 'frtl',
			    destroy: true,
			    columnDefs: [
   					 { "width": "50%", "targets": 0 },
   					 { "width": "50%", "targets": 1}],
   					 //{ "width": "20%", "targets": 1 }],
			    responsive: true,
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
				    { data: "horas" },
				    { data: "tolvas" }
				   
				  ]
			});
			tablaH.rows().remove();

	    	tablaH.rows.add((Data['infoH']));
	    	//console.log(Data['infoH'][0]['horas']);

	    	dataArray = new Array();
	    	dataArray[0]= ['Hora','Total',{ role: 'style' }, { role: 'annotation' }];
	    	arrayColors = ["#66ccff","#33FF9B","#AFFF33"];
	    	var b = 0;
	    	for(var i = 0, length1 = Data['infoH'].length; i < length1; i++){
	    		b++;
	    		if (b>2) {
	    			b=0;
	    		}
	    		dataArray[i+1] = [Data['infoH'][i]['horas'],parseInt((Data['infoH'][i]['tolvas'])),arrayColors[b],(Data['infoH'][i]['tolvas']).toString()];
	    		}
	    	//dataArray.push("SDSDSDS");
	    	//console.log(dataArray);
	    	google.charts.load('current', {packages: ['corechart']});

		    		google.charts.setOnLoadCallback(drawChartK);

					function drawChartK() {
						var options = {
							title: "Tolvas por hora turno "+tipo_turno,
							height: 500,
							legend: {position: 'none'},
							annotations: {
							textStyle: {
							fontSize: 20,
							}
						}
					}
					//console.log(dataArray);
				      

					    var data = new google.visualization.arrayToDataTable(dataArray,false);

					    var chart = new google.visualization.ColumnChart(document.getElementById('grafico-tolvas'));
					    
					    chart.draw(data, options);


		    		}
}

function dataTolvashoraB(Data){

	    	//console.log(Data['infoH'][0]['horas']);

	    	dataArrayB = new Array();
	    	dataArrayB[0]= ['Hora','Total',{ role: 'style' }, { role: 'annotation' }];
	    	arrayColors = ["#66ccff","#33FF9B","#AFFF33"];
	    	var b = 0;
	    	for(var i = 0, length1 = Data['infoHB'].length; i < length1; i++){
	    		b++;
	    		if (b>2) {
	    			b=0;
	    		}
	    		dataArrayB[i+1] = [Data['infoHB'][i]['horas'],parseInt((Data['infoHB'][i]['tolvas'])),arrayColors[b],(Data['infoHB'][i]['tolvas']).toString()];
	    		}
	    	//dataArray.push("SDSDSDS");
	    	//console.log(dataArray);
	    	google.charts.load('current', {packages: ['corechart']});

		    		google.charts.setOnLoadCallback(drawChartBA);

					function drawChartBA() {
						var options = {
							title: "Tolvas por hora turno B",
							height: 500,
							legend: {position: 'none'},
							annotations: {
							textStyle: {
							fontSize: 20,
							}
						}
					}
						
				      

					    var data = new google.visualization.arrayToDataTable(dataArray,false);

					    var chart = new google.visualization.ColumnChart(document.getElementById('grafico_tolvasB'));
					    
					    chart.draw(data, options);


		    		}
}

function dataFullTolvas(Dato){

	var tablaH = $('#data-rutas').DataTable({
			    dom: 'frtlip',
			    destroy: true,
			    order:[[0, 'asc']],
			   
   					 //{ "width": "20%", "targets": 1 }],
			    responsive: true,
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
				    { data: "Route" },
				    { data: "COMPONENTE" },
				    { data: "POLIDUCTO" },
				    { data: "TOTAL" },
				   
				  ]
			});
			tablaH.rows().remove();
			//var Data = JSON.parse(Dato);
			//console.log(Data['fullTolvas'][0]);
	    	tablaH.rows.add((Data['fullTolvas'][0]));


	    	//dataArray.push("SDSDSDS");
	    	//console.log(dataArray);
	    	
}
