getEmptyTable();
getEmptyUsers();
getEmptyNumbers();
$(document).ready(function(){
	$("#searchEmpty_Button").on('click', function(event) {
		event.preventDefault();
		var dateInput = moment($("#single_cal1").val()).format("YYYY-MM-DD");
		var turno = $("#turno").val();
		var horario = getHorario(turno);

		$.ajax({
			url: 'cont/emptyController.php',
			type: 'GET',
			data: {
				request: 'getByTurn',
				horario: horario,
				fecha: dateInput,
				turno: turno
		 	},
		})
		.done(function(info) {
			console.log(info);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
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

function getEmptyTable(){
	$.ajax({
		url: 'cont/emptyController.php',
		type: 'POST',
		data: {request: 'getCriticalTable'},
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
function getEmptyUsers(){
	$.ajax({
		url: 'cont/emptyController.php',
		type: 'POST',
		data: {request: 'getEmptyUsers'},
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
function getEmptyNumbers(){
	$.ajax({
		url: 'cont/emptyController.php',
		type: 'POST',
		data: {request: 'getEmptyNumbers'},
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
