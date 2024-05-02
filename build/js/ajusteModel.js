$(document).ready(function(){
	getAdjustTable();
	getAvailableAdjustTable();
	getDifferentAdjustTable();

	
	$("#serialNumber").on('keyup', function(e) {
		if (e.key === 'Enter' || e.keyCode === 13) {
			if ($("#badge").val()!="") {
				if ($("#serialNumber").val()!="") {
					var serialNumber = $("#serialNumber").val().replaceAll("S","").replaceAll("s","");
					var action = $("#action").val();
					var badge = $("#badge").val();
					$("#lastAction").html( "<b>Ultima accion: </b> <b style='color:red'> "+action+" "+serialNumber+"</b>");
					

					$.ajax({
						url: 'cont/ajusteController.php',
						type: 'POST',
						data: {request: 'setUpdate',
                                  order: action.toLowerCase(),
                                  serial: serialNumber,
                                  badge:badge
					}
					})
					.done(function(info) {
						var Data = JSON.parse(info);
						if (Data['response']=='success') {
							if (action == 'Open') {
								new PNotify({
								    title: 'Exito',
								    text: 'Se ha abierto la serie '+serialNumber,
								    type: 'success',
								    nonblock: {
								        nonblock: true
								    },
								    styling: 'bootstrap3'
								});
							}
							else if (action == 'Empty') {
								new PNotify({
								    title: 'Exito',
								    text: 'Se ha vaciado la serie '+serialNumber,
								    type: 'success',
								    nonblock: {
								        nonblock: true
								    },
								    styling: 'bootstrap3'
								});
							}
							else if (action == 'Revive') {
								new PNotify({
								    title: 'Exito',
								    text: 'Se ha revivido la serie '+serialNumber,
								    type: 'success',
								    nonblock: {
								        nonblock: true
								    },
								    styling: 'bootstrap3'
								});
							}
							
						}
						else{
							new PNotify({
							    title: 'Error de respuesta',
							    text: Data['response'],
							    type: 'error',
							    nonblock: {
							        nonblock: true
							    },
							    styling: 'bootstrap3'
							});
						}
					})
					.fail(function() {
						console.log("error");
					});
					

					$("#serialNumber").val('');
					
				}
				else{
					new PNotify({
						    title: 'Error',
						    text: 'Debe ingresar una serie valida',
						    type: 'error',
						    nonblock: {
						        nonblock: true
						    },
						    styling: 'bootstrap3'
						});
				}
				
			}
			else{
				new PNotify({
						    title: 'Error',
						    text: 'Debe iniciar sesion',
						    type: 'error',
						    nonblock: {
						        nonblock: true
						    },
						    styling: 'bootstrap3'
						});
			}
			
		}

	});
	$("#enter").on('click', function() {
			if ($("#badge")!="") {
				$.ajax({
			    	url: 'cont/partial_discount_controller_user.php',
			    	type: 'GET',
			    	data: {request: 'setBadge',
					badge: $("#badge").val()},
			    })
			    .done(function(data) {
			    	var info = JSON.parse(data);
			    	if (info['response']=='success') {
						new PNotify({
						    title: 'Exito',
						    text: 'Usuario valido',
						    type: 'success',
						    nonblock: {
						        nonblock: true
						    },
						    styling: 'bootstrap3'
						});
						$("#salir").removeAttr('hidden');
						$("#badge").attr('disabled', '');
						$("#enter").attr('hidden', '');
						$("#serialNumber").focus();
						
						
					}
					else{
						new PNotify({
						    title: 'Error',
						    text: 'Ingrese un usuario valido',
						    type: 'error',
						    nonblock: {
						        nonblock: true
						    },
						    styling: 'bootstrap3'
						});

					}
			    })
			    .fail(function() {
			    	console.log("error");
			    })
			    
			    sessionStorage.setItem('badge',$("#badge").val());
			}
			else{
				new PNotify({
		        title: 'Error',
		        text: 'Debe ingresar un numero de empleado valido',
		        type: 'warning',
		        nonblock: {
			        nonblock: true
			    },
		        styling: 'bootstrap3'
		    });
			}
		/* Act on the event */
	});

	$("#badge").on('keyup', function(e) {

		if (e.key === 'Enter' || e.keyCode === 13) {
			if ($("#badge")!="") {
				$.ajax({
			    	url: 'cont/partial_discount_controller_user.php',
			    	type: 'GET',
			    	data: {request: 'setBadge',
					badge: $("#badge").val()},
			    })
			    .done(function(data) {
			    	var info = JSON.parse(data);
			    	if (info['response']=='success') {
						new PNotify({
						    title: 'Exito',
						    text: 'Usuario valido',
						    type: 'success',
						    nonblock: {
						        nonblock: true
						    },
						    styling: 'bootstrap3'
						});
						$("#salir").removeAttr('hidden');
						$("#badge").attr('disabled', '');
						$("#enter").attr('hidden', '');
						$("#serialNumber").focus();
						
					}
					else{
						new PNotify({
						    title: 'Error',
						    text: 'Ingrese un usuario valido',
						    type: 'error',
						    nonblock: {
						        nonblock: true
						    },
						    styling: 'bootstrap3'
						});

					}
			    })
			    .fail(function() {
			    	console.log("error");
			    })
			    
			    sessionStorage.setItem('badge',$("#badge").val());
			}
			else{
				new PNotify({
		        title: 'Error',
		        text: 'Debe ingresar un numero de empleado valido',
		        type: 'warning',
		        nonblock: {
			        nonblock: true
			    },
		        styling: 'bootstrap3'
		    });
			}
		    

		}
	});
	$("#salir").on('click', function(event) {
		event.preventDefault();
		new PNotify({
		        title: 'Exito',
		        text: 'Sesion cerrada',
		        type: 'success',
		        nonblock: {
			        nonblock: true
			    },
		        styling: 'bootstrap3'
		    });
		$("#adjustModal").modal('hide');
		$("#badge").val("");
		$("#enter").removeAttr('hidden');
		sessionStorage.removeItem('badge');
	});
	timeout=setInterval(startAdjust, 60000);


	$("#adjustMaterial").on('click', function(event) {
		event.preventDefault();
		$("#adjustModal").modal('show');
		var badge = sessionStorage.getItem('badge');
		if (badge && badge.length > 0) {
		    $("#badge").val(badge);
		    $("#badge").attr('disabled', '');
		    $("#salir").removeAttr('hidden');
		   
		} else {
		    $("#badge").removeAttr('disabled');
		    $("#salir").attr('hidden','');
		    $("#enter").removeAttr('hidden');
		}
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