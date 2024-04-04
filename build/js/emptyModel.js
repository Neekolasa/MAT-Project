getEmptyTable(getTurno());
getEmptyUsers(getTurno());
getEmptyNumbers(getTurno());

$(document).ready(function(){
	$("#partNumberSeach").on('keypress', function(event) {
		if (event.which === 13 || event.keyCode === 13) {
			
			 $("#searchButton").trigger("click");
		}
	})
	$("#searchEmpty_Button").on('click', function(event) {
		event.preventDefault();
		var dateInput = moment($("#single_cal1").val()).format("YYYY-MM-DD");
		var turno = $("#turno").val();
		var horario = getHorario(turno);
		var datos = {
			request: 'getByTurn',
			horario: horario,
			fecha: dateInput,
			turno: turno
		}
		//console.log(datos);

		$.ajax({
			url: 'cont/emptyController.php',
			type: 'GET',
			data: datos,
		})
		.done(function(info) {
			var Data = JSON.parse(info);
			//console.log(Data);
			
			var tabla = $('#tableBajas').DataTable({
	            dom: 'frtlip',
	            "columnDefs": [{
	                "className": "text-center",
	                "targets": "_all"
	            }],
	            destroy: true,
	            order: [
	                [5, 'desc']
	            ],
	            responsive: true,
	           
	            language: {
	                url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
	            },
	            className: "center-block",
	            autoWidth: true,
	            paging: true,
	            columns: [
	            	{data: "PN"},
	                {data: "SN"},
	                {data: "Badge"},
	                {data: "Name"},
	                {data: "Action"},
	                {data: "Fecha"},
	                {data: "Actions"}

	            ]
	        });
	        tabla.rows().remove();
	        tabla.rows.add(Data[0].getCriticalTable).draw();

	        var tabla = $('#emptyUsers').DataTable({
	            dom: 'frtlip',
	            "columnDefs": [{
	                "className": "text-center",
	                "targets": "_all"
	            }],
	            destroy: true,
	            order: [
	                [3, 'desc']
	            ],
	            responsive: true,
	           
	            language: {
	                url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
	            },
	            className: "center-block",
	            autoWidth: true,
	            paging: true,
	            columns: [
	            	{data: "Badge"},
	                {data: "Name"},
	                {data: "LastName"},
	                {data: "SeriesVacias"},
	                {data: "Fecha"}
	            ]
	        });
	        tabla.rows().remove();
	        tabla.rows.add(Data[1].getEmptyUsers).draw();

	        var tabla = $('#emptyNumbers').DataTable({
	            dom: 'frtlip',
	            "columnDefs": [{
	                "className": "text-center",
	                "targets": "_all"
	            }],
	            destroy: true,
	            order: [
	                [1, 'desc']
	            ],
	            responsive: true,
	           
	            language: {
	                url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
	            },
	            className: "center-block",
	            autoWidth: true,
	            paging: true,
	            columns: [
	            	{data: "PartNumber"},
	                {data: "EmptySeries"},
	                {data: "Badge"},
	                {data: "Name"},
	                {data: "Fecha"}
	            ]
	        });
	        tabla.rows().remove();
	        tabla.rows.add(Data[2].getEmptyNumbers).draw();

		})
		
	});
	$("#searchButton").on('click', function(event) {
		event.preventDefault();
		var partNumber = $("#partNumberSeach").val();
		if (partNumber=="") {
			new PNotify({
                title: 'Error',
                text: 'Ingrese un numero de parte',
                type: 'error',
                styling: 'bootstrap3'
            });
		}
		else{
			$.ajax({
				url: 'cont/emptyController.php',
				type: 'GET',
				data: {
					request: 'getByPN',
					partNumber:partNumber
				},
			})
			.done(function(information) {
				var Data = JSON.parse(information);
				if (Data['response']!='fail') {
					var tabla = $('#emptySearchNumber').DataTable({
			            dom: 'frtlip',
			            "columnDefs": [{
			                "className": "text-center",
			                "targets": "_all"
			            }],
			            destroy: true,
			            order: [
			                [5, 'desc']
			            ],
			            buttons: [
					     	{extend :'copy', text: 'Copiar al portapapeles',className:"btn btn-primary boton-margen",
					      	attr:  {
					                id: 'jkjk'
					            }},
					     	{extend :'excel', text: 'Generar excel',className:"btn btn-primary text-light boton-margen"},
					     	{extend :'print', text: 'Imprimir documento',className:"btn btn-primary text-light boton-margen"},
					     	{extend :'pdf', text: 'Generar PDF',className:"btn btn-primary text-light boton-margen"}
					    ],
			            responsive: true,
			           
			            language: {
			                url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
			            },
			            className: "center-block",
			            autoWidth: true,
			            paging: true,
			            columns: [
			            	{data: "PN"},
			                {data: "SN"},
			                {data: "Badge"},
			                {data: "Name"},
			                {data: "Action"},
			                {data: "Fecha"},
			                {data: "Actions"}
			            ]
			        });
			        tabla.rows().remove();
			        tabla.rows.add(Data.data).draw();

			        $("#partNumberSeach").val("");
				}
			})
			.fail(function() {
				console.log("error");
			})
			
			
		}
	});

	$(".closeModal").on('click', function(event) {
		event.preventDefault();
		var table = $("#linksTable").DataTable();
    	table.clear().destroy();
	});
});

function getHorario(turno){
	if (turno=='A') {
		var horario = {
			horaEntrada: '06:00',
			horaSalida: '15:36'
		}
		return horario;
	}
	else{
		var horario = {
			horaEntrada: '15:36',
			horaSalida: '00:15'
		}
		return horario;
	}
}

function getEmptyTable(turno){
	$.ajax({
		url: 'cont/emptyController.php',
		type: 'POST',
		data: {
			request: 'getCriticalTable',
			turno: turno
		},
	})
	.done(function(information) {
		var Data = JSON.parse(information);
		//console.log(Data);
		var tabla = $('#tableBajas').DataTable({
            dom: 'frtlip',
            "columnDefs": [{
                "className": "text-center",
                "targets": "_all"
            }],
            destroy: true,
            order: [
                [5, 'desc']
            ],
            buttons: [
		     	{extend :'copy', text: 'Copiar al portapapeles',className:"btn btn-primary boton-margen",
		      	attr:  {
		                id: 'jkjk'
		            }},
		     	{extend :'excel', text: 'Generar excel',className:"btn btn-primary text-light boton-margen"},
		     	{extend :'print', text: 'Imprimir documento',className:"btn btn-primary text-light boton-margen"},
		     	{extend :'pdf', text: 'Generar PDF',className:"btn btn-primary text-light boton-margen"}
		    ],
            responsive: true,
           
            language: {
                url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
            },
            className: "center-block",
            autoWidth: true,
            paging: true,
            columns: [
            	{data: "PN"},
                {data: "SN"},
                {data: "Badge"},
                {data: "Name"},
                {data: "Action"},
                {data: "Fecha"},
                {data: "Actions"}
            ]
        });
        tabla.rows().remove();
        tabla.rows.add(Data.data).draw();
        
	})
	.fail(function() {
		console.log("error");
	});
	
}
function getEmptyUsers(turno){
	$.ajax({
		url: 'cont/emptyController.php',
		type: 'POST',
		data: {
			request: 'getEmptyUsers',
			turno: turno
		},
	})
	.done(function(information) {
		var Data = JSON.parse(information);
		//console.log(Data);
		var tabla = $('#emptyUsers').DataTable({
            dom: 'frtlip',
            "columnDefs": [{
                "className": "text-center",
                "targets": "_all"
            }],
            destroy: true,
            order: [
                [3, 'desc']
            ],
            buttons: [
		     	{extend :'copy', text: 'Copiar al portapapeles',className:"btn btn-primary boton-margen",
		      	attr:  {
		                id: 'jkjk'
		            }},
		     	{extend :'excel', text: 'Generar excel',className:"btn btn-primary text-light boton-margen"},
		     	{extend :'print', text: 'Imprimir documento',className:"btn btn-primary text-light boton-margen"},
		     	{extend :'pdf', text: 'Generar PDF',className:"btn btn-primary text-light boton-margen"}
		    ],
            responsive: true,
           
            language: {
                url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
            },
            className: "center-block",
            autoWidth: true,
            paging: true,
            columns: [
            	{data: "Badge"},
                {data: "Name"},
                {data: "LastName"},
                {data: "SeriesVacias"},
                {data: "Fecha"}
            ]
        });
        tabla.rows().remove();
        tabla.rows.add(Data.data).draw();
        
	})
	.fail(function() {
		console.log("error");
	});
	
}
function getEmptyNumbers(turno){
	$.ajax({
		url: 'cont/emptyController.php',
		type: 'POST',
		data: {
			request: 'getEmptyNumbers',
			turno: turno
		},
	})
	.done(function(information) {
		var Data = JSON.parse(information);
		//console.log(Data);
		var tabla = $('#emptyNumbers').DataTable({
            dom: 'frtlip',
            "columnDefs": [{
                "className": "text-center",
                "targets": "_all"
            }],
            destroy: true,
            order: [
                [1, 'desc']
            ],
            buttons: [
		     	{extend :'copy', text: 'Copiar al portapapeles',className:"btn btn-primary boton-margen",
		      	attr:  {
		                id: 'jkjk'
		            }},
		     	{extend :'excel', text: 'Generar excel',className:"btn btn-primary text-light boton-margen"},
		     	{extend :'print', text: 'Imprimir documento',className:"btn btn-primary text-light boton-margen"},
		     	{extend :'pdf', text: 'Generar PDF',className:"btn btn-primary text-light boton-margen"}
		    ],
            responsive: true,
           
            language: {
                url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
            },
            className: "center-block",
            autoWidth: true,
            paging: true,
            columns: [
            	{data: "PartNumber"},
                {data: "EmptySeries"},
                {data: "Badge"},
                {data: "Name"},
                {data: "Fecha"}
            ]
        });
        tabla.rows().remove();
        tabla.rows.add(Data.data).draw();
        
	})
	.fail(function() {
		console.log("error");
	});
	
}

function getTurno() {
    var horaActual = new Date().getHours();
    var minutosActual = new Date().getMinutes();
    var horaLimiteA = 15; 
    var minutosLimiteA = 36;
    var horaLimiteB = 0; 
    var minutosLimiteB = 15;

    // Si la hora actual es antes de las 15:36, es el turno A
    if (horaActual < horaLimiteA || (horaActual === horaLimiteA && minutosActual <= minutosLimiteA)) {
        return 'A';
    } else {
        // Si la hora actual está después de las 15:36 o antes de las 0:15 del día siguiente, es el turno B
        if ((horaActual === horaLimiteA && minutosActual > minutosLimiteA) || horaActual < horaLimiteB || (horaActual === horaLimiteB && minutosActual < minutosLimiteB)) {
            return 'B';
        } else {
            // Si no, es el turno A (ya que estaría entre las 0:15 y las 15:36 del día siguiente)
            return 'A';
        }
    }
}
function seeLinks(serial){
	var serie = serial;
	$("#linkedSerie").text(serial);
	$.ajax({
		url: 'cont/emptyController.php',
		type: 'GET',
		data: {
			request: 'getLinksInfo',
			serial: serie
		},
	})
	.done(function(information) {
		var Data = JSON.parse(information);
		//console.log(Data);
		if (Data['response']=='empty') {
			new PNotify({
                title: 'Error',
                text: 'No hay movimientos de rutas para este material',
                type: 'error',
                styling: 'bootstrap3'
            });
            var table = $("#linksTable").DataTable();
    		table.clear().destroy();
    		$("#printPN").text('');
			$("#linkedQty").text('');
			$("#stdPackLinked").text('');
		}
		if (Data['response']=='success') {
			$("#printPN").text(Data[0]['getStdPack'][0]['PN']);
			$("#linkedQty").text(Data[0]['getStdPack'][0]['CantidadEnlazada']);
			$("#stdPackLinked").text(Data[0]['getStdPack'][0]['StdPack']);
			var tabla = $('#linksTable').DataTable({
	            dom: 'frtlip',
	            "columnDefs": [{
	                "className": "text-center",
	                "targets": "_all"
	            }],
	            destroy: true,
	            order: [
	                [8, 'desc']
	            ],
	            responsive: true,
	           
	            language: {
	                url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
	            },
	            className: "center-block",
	            autoWidth: true,
	            paging: true,
	            columns: [
	            	{data: "IdKanban"},
	                {data: "ContType"},
	                {data: "Qty"},
	                {data: "UoM"},
	                {data: "Route"},
	                {data: "Badge"},
	                {data: "Name"},
	                {data: "Status"},
	                {data: "Fecha"}
	            ]
	        });
	        tabla.rows().remove();
	        tabla.rows.add(Data['getLinkInfo']).draw();



			new PNotify({
                title: 'Exito',
                text: 'Mostrando movimientos de tolvas para la serie '+serie,
                type: 'success',
                styling: 'bootstrap3'
            });
		}
	})
	.fail(function() {
		console.log("error");
	});
	

	$("#linksModal").modal('show');

}
