$(document).ready(function(){
	getAdjustTable();
	getAvailableAdjustTable();
	getDifferentAdjustTable();

	$("#badge").keypress(function(e) {
		if (e.key === 'Enter' || e.keyCode === 13) {
			new PNotify({
		        title: 'Exito',
		        text: 'dsdsdsds',
		        type: 'warning',
		        nonblock: {
			        nonblock: true
			    },
		        styling: 'bootstrap3'
		    });
		}
	});
	timeout=setInterval(startAdjust, 60000);


	$("#adjustMaterial").on('click', function(event) {
		event.preventDefault();
		$("#adjustModal").modal('show');
	});
	
});
function clearAutoAdjust() {

    clearTimeout(timeout);
    new PNotify({
		        title: 'Exito',
		        text: 'Se han detenido los ajustes automaticos',
		        type: 'warning',
		        nonblock: {
			        nonblock: true
			    },
		        styling: 'bootstrap3'
		    });
}
function startAdjust(){
	$.ajax({
		url: 'cont/ajusteController.php',
		type: 'POST',
		data: {request: 'setAdjust'},
	})
	.done(function(info) {
		var Data = JSON.parse(info);
		if (Data['response']=='success') {
			new PNotify({
		        title: 'Exito',
		        text: 'Se han realizado los descuentos disponibles',
		        type: 'success',
		        nonblock: {
			        nonblock: true
			    },
		        styling: 'bootstrap3'
		    });
		    getAdjustTable();
			getAvailableAdjustTable();
			getDifferentAdjustTable();

		}
		else{
			new PNotify({
		        title: 'Error',
		        text: 'Ha ocurrido un error en la consulta',
		        type: 'error',
		        nonblock: {
			        nonblock: true
			    },
		        styling: 'bootstrap3'
		    });
		}
	})
	.fail(function() {
		new PNotify({
		        title: 'Error',
		        text: 'Ha ocurrido un error en la consulta',
		        type: 'error',
		        nonblock: {
			        nonblock: true
			    },
		        styling: 'bootstrap3'
		    });
	})
}

function getDifferentAdjustTable(){
	$.ajax({
		url: 'cont/ajusteController.php',
		type: 'POST',
		data: {request: 'getStdOver'},
	})
	.done(function(info) {
		var Data = JSON.parse(info);
		//console.log(Data)
		if (Data['response']=='success') {
			/*new PNotify({
		        title: 'Rutas actualizadas',
		        text: 'Se ha actualizado el estatus de las rutas',
		        type: 'success',
		        styling: 'bootstrap3'
		    });*/
		
				var tabla = $('#table_diferencia').DataTable({
                    dom: 'rtlp',
                    destroy: true,
                    order:[[4, 'desc']],
                    responsive: true,
                    buttons: [
                        {extend :'copy', text: 'Copiar al portapapeles',className:"btn btn-primary boton-margen",
                        attr:  {
                                id: 'jkjk'
                            }},
                        {extend :'excel', text: 'Generar excel',className:"btn btn-primary text-light boton-margen"},
                        {extend :'print', text: 'Imprimir documento',className:"btn btn-primary text-light boton-margen"},
                        {extend :'pdf', text: 'Generar PDF',className:"btn btn-primary text-light boton-margen"}
                    ],
                    language: {
                        url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
                    },
                    className: "center-block",
                    columnDefs: [
			            { className: "text-center", targets: "_all" } // Esto centrará todo el texto en las celdas
			        ],
                    columns: [
                      {data: "PN"},
                      { data:"SN"},
                      { data: "StdPack" },
                      { data: "QtyActual" },
                      { data: "QtyDescuento" },
                      { data: "Diferencia"}
                     
                    ]
                });
                tabla.rows().remove();
                  
               
                tabla.rows.add(Data['data']);
            }
     })
}
function getAdjustTable(){
	$.ajax({
		url: 'cont/ajusteController.php',
		type: 'POST',
		data: {request: 'getAdjust'},
	})
	.done(function(info) {
		var Data = JSON.parse(info);
		//console.log(Data)
		if (Data['response']=='success') {
			
		   // console.log(Data['data'][0]['ScanDate'].date)

		    var tabla = $('#table_ajuste').DataTable({
                    dom: 'frtlip',
                    destroy: true,
                    order:[[3, 'desc']],
                    responsive: true,
                    buttons: [
                        {extend :'copy', text: 'Copiar al portapapeles',className:"btn btn-primary boton-margen",
                        attr:  {
                                id: 'jkjk'
                            }},
                        {extend :'excel', text: 'Generar excel',className:"btn btn-primary text-light boton-margen"},
                        {extend :'print', text: 'Imprimir documento',className:"btn btn-primary text-light boton-margen"},
                        {extend :'pdf', text: 'Generar PDF',className:"btn btn-primary text-light boton-margen"}
                    ],
                    language: {
                        url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
                    },
                    className: "center-block",
                    columnDefs: [
			            { className: "text-center", targets: "_all" } // Esto centrará todo el texto en las celdas
			        ],
                    columns: [
                      {data: "PN"},
                      { data:"Locacion"},
                      { data: "ContType" },
                      { data: "TotalSinDescuento" },
                      { data: "UoM" },
                      { data: "SAPProcess" },
                      { data: "ScanDate" }
                     
                    ]
                });
                tabla.rows().remove();
                  
               
                tabla.rows.add(Data['data']);
		}
		else{

		}
	})
	.fail(function() {
		console.log("error");
	})
	
}

function getAvailableAdjustTable(){
	$.ajax({
		url: 'cont/ajusteController.php',
		type: 'POST',
		data: {request: 'getAvailableAdjust'},
	})
	.done(function(info) {
		var Data = JSON.parse(info);
		//console.log(Data)
		if (Data['response']=='success') {
			/*new PNotify({
		        title: 'Rutas actualizadas',
		        text: 'Se ha actualizado el estatus de las rutas',
		        type: 'success',
		        styling: 'bootstrap3'
		    });*/
		
				var tabla = $('#table_disponible').DataTable({
                    dom: 'frtlip',
                    destroy: true,
                    order:[[4, 'desc']],
                    responsive: true,
                    buttons: [
                        {extend :'copy', text: 'Copiar al portapapeles',className:"btn btn-primary boton-margen",
                        attr:  {
                                id: 'jkjk'
                            }},
                        {extend :'excel', text: 'Generar excel',className:"btn btn-primary text-light boton-margen"},
                        {extend :'print', text: 'Imprimir documento',className:"btn btn-primary text-light boton-margen"},
                        {extend :'pdf', text: 'Generar PDF',className:"btn btn-primary text-light boton-margen"}
                    ],
                    language: {
                        url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
                    },
                    className: "center-block",
                    columnDefs: [
			            { className: "text-center", targets: "_all" } // Esto centrará todo el texto en las celdas
			        ],
                    columns: [
                      {data: "PN"},
                      { data:"SN"},
                      { data: "stdPack" },
                      { data: "QtyActual" },
                      { data: "QtyDescuento" }
                     
                    ]
                });
                tabla.rows().remove();
                  
               
                tabla.rows.add(Data['data']);
			
		}
		else{

		}
	})
	.fail(function() {
		console.log("error");
	})
}