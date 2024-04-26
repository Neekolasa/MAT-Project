$(document).ready(function(){
	/*if(isUserOnMobile()){
		$(".pc").hide();
	}
	else {
		$(".pc").show();
	}*/

	currentDate=moment().format('YYYY-MM-DD');
	currentTime=moment().format('HH:mm');
	//console.log(currentDate + " " + currentTime);


	if (currentTime>'05:59' && currentTime<'15:37') {
		turno_emp = 'A';
		fecha = currentDate;
		formattedDate2 = "";

		let datos = {
			fechaIni: fecha,
			fechaFin: formattedDate2,
			turno: turno_emp
		}
		//console.log(datos);
		
		$.ajax({
			url: 'cont/buscar_listaEmp.php',
			type: 'GET',
			data: datos,
		}).done(function(datos){

			//test = JSON.parse(datos);
			
			
				//console.log(datos);
				//table(datos);
				
				tableRackeo(datos);
				//tableContingencia(datos);
				var Datos = JSON.parse(datos);

	    		//$("#totales").toggle();
	    		
	    		
	    		


	    		$("#totales").show();


	    		$("#total_rackeo").html("Total rackeos: "+Datos['totales'][0]['RACKEO_TOTAL']);
	    		$("#total_contingencia").html("Total contingencia: "+Datos['totales'][0]['CONTINGENCIA_TOTAL']);
	    		$("#total_movimientos").html("Total movimientos: "+Datos['totales'][0]['MOVIMIENTOS_TOTAL']);
				

				
				
			
    		
			
			
		});

	}
	else if (currentTime>'15:36' && currentTime<'23:59'){
		turno_emp = 'B';
		fecha = currentDate;
		
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
		//formattedDate2.;
			
		formattedDate = fecha;
		//formattedDate2 = fecha.getFullYear()+"-"+month +"-"+ day;

			//console.log(formattedDate2);

		

		let datos = {
			fechaIni: formattedDate,
			fechaFin: formattedDate2,
			turno: turno_emp
		}
		//console.log(datos);
		

		$.ajax({
			url: 'cont/buscar_listaEmp.php',
			type: 'GET',
			data: datos,
		}).done(function(datos){
			test = JSON.parse(datos);
			if (test['totales'][0]['RACKEO_TOTAL']==0) {
				Swal.fire({
				  position: 'center',
				  icon: 'error',
				  title: 'No se encontró información de este día',
				  showConfirmButton: false,
				  timer: 1500
				});

			}
			else{
				//console.log(datos);
				//table(datos);
				var Datos = JSON.parse(datos);
				tableRackeo(datos);
				//tableContingencia(datos);

				$("#turno option:eq(1)").prop("selected", true);

	    		//$("#totales").toggle();
	    		
	    		
	    		


	    		$("#totales").show();


	    		$("#total_rackeo").html("Total rackeos: "+Datos['totales'][0]['RACKEO_TOTAL']);
	    		$("#total_contingencia").html("Total contingencia: "+Datos['totales'][0]['CONTINGENCIA_TOTAL']);
	    		$("#total_movimientos").html("Total movimientos: "+Datos['totales'][0]['MOVIMIENTOS_TOTAL']);
				

				}
			
    		
			
			
		});

	}
		
	$("#buscar_empleado").on('click',function(e){
		e.preventDefault();

		turno_emp = $('#turno_emp').val();
		fecha = Date.parse($('#single_cal1').val());
		formattedDate2="";

		if (turno_emp!="B") {
			formattedDate = fecha.getFullYear()+"-"+addZero((fecha.getMonth()+1)) +"-"+ addZero(fecha.getDate());

		}
		else{

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
			

			
			formattedDate = fecha.getFullYear()+"-"+addZero((fecha.getMonth()+1)) +"-"+ addZero(fecha.getDate());
			formattedDate2 = fecha.getFullYear()+"-"+month +"-"+ day;

			//console.log(formattedDate2);

		}

		let datos = {
			fechaIni: formattedDate,
			fechaFin: formattedDate2,
			turno: turno_emp
		}
		//console.log(datos);
		

		$.ajax({
			url: 'cont/buscar_listaEmp.php',
			type: 'GET',
			data: datos,
		}).done(function(data){
			test = JSON.parse(data);
			if (test['totales'][0]['RACKEO_TOTAL']==0) {
				Swal.fire({
				  position: 'center',
				  icon: 'error',
				  title: 'No se encontró información de este día',
				  showConfirmButton: false,
				  timer: 1500
				});

			}
			else{
				
				//console.log(data);

				//table(Datos['info']);

				tableRackeo(data);
				//tableContingencia(datos);


	    		//$("#totales").toggle();
	    		var Datos = JSON.parse(data);
	    		
	    		


	    		$("#totales").show();


	    		$("#total_rackeo").html("Total rackeos: "+Datos['totales'][0]['RACKEO_TOTAL']);
	    		$("#total_contingencia").html("Total contingencia: "+Datos['totales'][0]['CONTINGENCIA_TOTAL']);
	    		$("#total_movimientos").html("Total movimientos: "+Datos['totales'][0]['MOVIMIENTOS_TOTAL']);
				

				//var turno = Datos[3].toString();

				

				}
			
    		
			
			
		});
	});


});

function addZero(day){
	if (day<10) {
		return ("0"+day);
	}
	else
		return day;
}
function json2array(json){
    var result = [];
    var keys = Object.keys(json);
    keys.forEach(function(key){
        result.push(json[key]);
    });
    return result;
}

function tableRackeo(datos){
	var tabla_emp = $('#table_empleados').DataTable({
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
			     	{extend :'print',

				     	customize: function ( win ) {
		                    $(win.document.body)
		                        .css( 'font-size', '15px' )
		                        .append(
		                            "<span style='font-size:25px;'>Total rackeo: "+Datos['totales'][0]['RACKEO_TOTAL'] + "</span><br>" +
		                            "<span style='font-size:25px;'>Total contingencia: "+Datos['totales'][0]['CONTINGENCIA_TOTAL'] + "</span><br>" +
		                            "<span style='font-size:25px;'>Total movimientos: "+Datos['totales'][0]['MOVIMIENTOS_TOTAL'] + "</span><br>"
		                        );

		                    $(win.document.body).find( 'table' )
		                        .addClass( 'compact' )
		                        .css( 'font-size', 'inherit' );
	                	},

			     	text: 'Imprimir documento',className:"btn btn-primary text-light boton-margen"},
			     	{extend :'pdf', text: 'Generar PDF',className:"btn btn-primary text-light boton-margen"}
			    ],
			    className: "center-block",
			    columns: [
				    { data: "Badge" },
				    { data: "Name" },
				    { data: "LastName" },
				    { data: "RACKEO" },
				    { data: "CONTINGENCIA" },
				    { data: "TOTAL"}
				    //{ data: "TOTALMOVIMIENTOS"}
				   
				  ]
			});
			tabla_emp.rows().remove();
    		
    		var Datos=(JSON.parse(datos));
    		
    		tabla_emp.rows.add(Datos['info'][0]);
}
