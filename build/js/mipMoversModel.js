$(document).ready(function(){
	var userLogged = sessionStorage.getItem('userLogged');
    var fullname = sessionStorage.getItem('fullname');
    var permission = sessionStorage.getItem('permission');
    
    /*if (userLogged!= 'beacon') {
        $("#moverSearchPN").hide();
    }*/
    if (permission == 'delivery') {
        $("#moverMainForm").show();
        $("#updateStatusForm").hide();
        $("#shipmentForm").hide();
        $("#extraCommentsNonShipped").show();
        $("#updateShippedStatus").hide();
        $("#shipmentForm").hide()
        $("#buttonMasiveMaterial").show();  
    }
    else if(permission == 'spmk'){
        $("#moverMainForm").hide();
        $("#updateStatusForm").show();
        $("#moverPrepared").show();
        $("#moverSended").show();
        $("#moverShipped").hide();
        $("#shipmentForm").hide()
        $("#buttonMasiveMaterial").hide();
        $("#extraCommentsNonShipped").show();
        $("#updateShippedStatus").hide();
    }
    else{
        $("#moverMainForm").hide();
        $("#buttonMasiveMaterial").hide();
        $("#moverPrepared").hide();
        $("#moverSended").hide();
        $("#moverShipped").show();
        $('#statusMover option:eq(2)').prop('selected', true);
        
        //NEW FORMS
        $("#updateStatusForm").hide();
        $("#extraCommentsNonShipped").hide();
        $("#hideUOMShipped").hide();

        $("#shipmentForm").show()

        $("#updateShippedStatus").show();
    }

    getCreatedMovers(userLogged);
    getProccesMovers(userLogged);
    getFinishedMovers(userLogged);
    getShippedMovers(userLogged);

    $("#moverPNInput").keyup(function(event) {
        if (event.keyCode== 13) {
            $("#moverPNButton").click();
        }
    });
    $("#moverPNButton").on('click', function(event) {
        event.preventDefault();
        var searchedPN = $("#moverPNInput").val();
        var userLogged = sessionStorage.getItem("userLogged");
        $.ajax({
            url: 'cont/moverController.php',
            type: 'POST',
            data: {request: 'getMoverByPN',
                      searchedPN: searchedPN,
                      userLogged: userLogged},
        })
        .done(function(information) {
            var Data = JSON.parse(information);
            //console.log(Data);
            var tabla = $('#tableMoverCreated').DataTable({
                    dom: 'frtlip',
                    destroy: true,
                    order:[[6, 'asc']],
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
                    columns: [
                      {data: "ID"},
                      { data: "RequestUser" },
                      { data: "ShipPlant" },
                      { data: "ShipInstructions" },
                      { data: "AdditionalComments" },
                      { data: "Status" },
                      { data: "CreatedDate"},
                      { data: "Action"}
                     
                    ]
                });
                tabla.rows().remove();
                  
               
                tabla.rows.add(Data);

        });
        
        /*
             */
    });
    /*$('#inputID').on('keyup', function () {
        tabla = $("#tableMoverCreated").DataTable();
        tabla.column(0).search(this.value).draw();
    });*/ //SEARCH BY ID

    $("#authorizedMovers").on('click', function(event) {
    	event.preventDefault();
    	$("#modalCreatedMovers").modal('show');

    	$.ajax({
    		url: 'cont/moverController.php',
    		type: 'GET',
    		data: {	request: 'getCreatedMoverInfo',
                        subRequest: 'getAllMovers',
    					userLogged: userLogged},
    	})
    	.done(function(information) {
    		var Data = JSON.parse(information);
    		//console.log(Data);
    		var tabla = $('#tableMoverCreated').DataTable({
                    dom: 'frtlip',
                    destroy: true,
                    order:[[6, 'asc']],
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
                    columns: [
                      {data: "ID"},
                      { data: "RequestUser" },
                      { data: "ShipPlant" },
                      { data: "ShipInstructions" },
                      { data: "AdditionalComments" },
                      { data: "Status" },
                      { data: "CreatedDate"},
                      { data: "Action"}
                     
                    ]
                });
                tabla.rows().remove();
                  
               
                tabla.rows.add(Data);
    	})
    	

    	/* Act on the event */
    });

    $("#queueMovers_container").on('click', function(event) {
        event.preventDefault();
        $("#modalCreatedMovers").modal('show');

        $.ajax({
            url: 'cont/moverController.php',
            type: 'GET',
            data: { request: 'getCreatedMoverInfo',
                        subRequest: 'getProccesMovers',
                        userLogged: userLogged},
        })
        .done(function(information) {
            var Data = JSON.parse(information);
            //console.log(Data);
            var tabla = $('#tableMoverCreated').DataTable({
                    dom: 'frtlip',
                    destroy: true,
                    order:[[6, 'asc']],
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
                    columns: [
                      { data: "ID" },
                      { data: "RequestUser" },
                      { data: "ShipPlant" },
                      { data: "ShipInstructions" },
                      { data: "AdditionalComments" },
                      { data: "Status" },
                      { data: "CreatedDate"},
                      { data: "Action"}
                     
                    ]
                });
                tabla.rows().remove();
                  
               
                tabla.rows.add(Data);
        })
    });

    $("#finishedMovers_container").on('click', function(event) {
        event.preventDefault();
        $("#modalCreatedMovers").modal('show');

        $.ajax({
            url: 'cont/moverController.php',
            type: 'GET',
            data: { request: 'getCreatedMoverInfo',
                        subRequest: 'getFinishedMovers',
                        userLogged: userLogged},
        })
        .done(function(information) {
            var Data = JSON.parse(information);
            //console.log(Data);
            var tabla = $('#tableMoverCreated').DataTable({
                    dom: 'frtlip',
                    destroy: true,
                    order:[[0, 'desc']],
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
                    columns: [
                      { data: "ID" },  
                      { data: "RequestUser" },
                      { data: "ShipPlant" },
                      { data: "ShipInstructions" },
                      { data: "AdditionalComments" },
                      { data: "Status" },
                      { data: "CreatedDate"},
                      { data: "Action"}
                     
                    ]
                });
                tabla.rows().remove();
                  
               
                tabla.rows.add(Data);
        })
    });

    $("#shippedMovers_container").on('click', function(event) {
        event.preventDefault();
        $("#modalCreatedMovers").modal('show');

        $.ajax({
            url: 'cont/moverController.php',
            type: 'GET',
            data: { request: 'getCreatedMoverInfo',
                        subRequest: 'getShippedMovers',
                        userLogged: userLogged},
        })
        .done(function(information) {
            var Data = JSON.parse(information);
            //console.log(Data);
            var tabla = $('#tableMoverCreated').DataTable({
                    dom: 'frtlip',
                    destroy: true,
                    order:[[0, 'desc']],
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
                    columns: [
                      { data: "ID" },
                      { data: "RequestUser" },
                      { data: "ShipPlant" },
                      { data: "ShipInstructions" },
                      { data: "AdditionalComments" },
                      { data: "Status" },
                      { data: "CreatedDate"},
                      { data: "Action"}
                     
                    ]
                });
                tabla.rows().remove();
                  
               
                tabla.rows.add(Data);
        })
    });

    $("#updateStatus").on('click', function(event) {
        event.preventDefault();
        var userLogged = $("#moverUserLogged").val();
        var moverUniqueID = $("#moverUniqueID").val();
        var statusMover = $("#statusMover").val();   
        var permission = sessionStorage.getItem('permission');

        $.ajax({
            url: 'cont/moverController.php',
            type: 'GET',
            data: {request: 'updateStatus',
                    statusMover: statusMover,
                    userLogged: userLogged,
                    moverUniqueID: moverUniqueID
                },
        })
        .done(function(information) {
            var Data = JSON.parse(information);
            if (Data['response']=='success') {
                new PNotify({
                        title: 'Exito',
                        text: 'Se ha actualizado el estatus del mover',
                        type: 'success',
                        styling: 'bootstrap3'
                    });
                getCreatedMovers(userLogged);
                getProccesMovers(userLogged);
                getFinishedMovers(userLogged);
                getShippedMovers(userLogged);

            }
            else{
                //console.log(Data);
                new PNotify({
                        title: 'Error',
                        text: 'Ha ocurrido un error en la consulta',
                        type: 'error',
                        styling: 'bootstrap3'
                    });
            }
        });
    });

    $("#addExtraComment").on('click', function(event) {
        event.preventDefault();
        var userLogged = $("#moverUserLogged").val();
        var moverUniqueID = $("#moverUniqueID").val();
        var commentAdded = $("#extraComments").val();
        var permission = sessionStorage.getItem('permission');
        
        $.ajax({
            url: 'cont/moverController.php',
            type: 'GET',
            data: {
                    request: 'addExtraComment',
                    commentAdded : commentAdded,
                    moverUniqueID: moverUniqueID,
                    permission: permission,
                    userLogged: userLogged,
                    createdDate : moment().format('MM-DD-YYYY HH:mm')},
        })
        .done(function(information) {
            var Data = JSON.parse(information);
             if (Data['response']=='success') {
                new PNotify({
                        title: 'Exito',
                        text: 'Se han agregado los comentarios',
                        type: 'success',
                        styling: 'bootstrap3'
                    });

                $("#extraComments").val("");
                $.ajax({
        url: 'cont/moverController.php',
        type: 'GET',
        data: {request: 'getMoverComment',
                  UniqueID : moverUniqueID},
    })
    .done(function(information) {
        var Data = JSON.parse(information);

        var tabla = $('#table_comments').DataTable({
                    dom: 'rt',
                    destroy: true,
                    responsive: true,
                    order:[[3, 'asc']],
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
                    columns: [
                      { data: "FullName" },
                      { data: "NewAreaComment" },
                      { data: "Comment" },
                      { data: "FormattedDate" }
                     
                    ]
                });
                tabla.rows().remove();
                  
               
                tabla.rows.add(Data['data']);
    });

            }
            else{
                new PNotify({
                        title: 'Error',
                        text: 'Ha ocurrido un error en la consulta',
                        type: 'error',
                        styling: 'bootstrap3'
                    });
            }
        });
    });

    $("#updateShippedStatus").on('click', function(event) {
        event.preventDefault();
        permission = sessionStorage.getItem('permission');
        moverUniqueID = $("#moverUniqueID").val();
        shippedStatusMover = $("#shippedStatusMover").val();
        userLogged = userLogged;
        deliveryNumber = $("#deliveryNumber").val();
        shippedQty = $("#shippedQty").val();
        shippedUom = $("#shippedUom").val();
        shippedMoverBox = $("#shippedMoverBox").val();
        extraShippedComments = $("#extraShippedComments").val();
       
        var commentString ="";

        if (deliveryNumber != "") {
            commentString = commentString+"<span style='font-weight: bold; !important'>Delivery: </span> <span style='color:green'>"+deliveryNumber+"</span><br/>";
        }
        if (shippedQty != "") {
            commentString = commentString+"<span style='font-weight: bold; !important'>Cantidad: </span> <span style='color:green'>"+shippedQty+" "+shippedUom+"</span><br/>";
        }
        if (shippedMoverBox != "") {
             commentString = commentString+"<span style='font-weight: bold; !important'>Caja o placas: </span><span style='color:green'>"+shippedMoverBox+"</span><br/>";
        }
        if (extraShippedComments != "") {
            commentString = commentString +extraShippedComments;

        }

        $.ajax({
            url: 'cont/moverController.php',
            type: 'GET',
            data: {request: 'updateStatus',
                    statusMover: shippedStatusMover,
                    userLogged: userLogged,
                    moverUniqueID: moverUniqueID
                },
        })
        .done(function(information) {
            var Data = JSON.parse(information);
            if (Data['response']=='success') {
                new PNotify({
                        title: 'Exito',
                        text: 'Se ha actualizado el estatus del mover',
                        type: 'success',
                        styling: 'bootstrap3'
                    });
                getCreatedMovers(userLogged);
                getProccesMovers(userLogged);
                getFinishedMovers(userLogged);
                getShippedMovers(userLogged);

            }
            else{
               // console.log("sdsdsdsds");
                new PNotify({
                        title: 'Error',
                        text: 'Ha ocurrido un error en la consulta',
                        type: 'error',
                        styling: 'bootstrap3'
                    });
            }
        });

        $.ajax({
            url: 'cont/moverController.php',
            type: 'GET',
            data: {
                    request: 'addExtraComment',
                    commentAdded : commentString,
                    moverUniqueID: moverUniqueID,
                    permission: permission,
                    userLogged: userLogged,
                    createdDate : moment().format('MM-DD-YYYY HH:mm')},
        })
        .done(function(information) {
            var Data = JSON.parse(information);
             if (Data['response']=='success') {
                new PNotify({
                        title: 'Exito',
                        text: 'Se han agregado los comentarios',
                        type: 'success',
                        styling: 'bootstrap3'
                    });

             
           
                $("#deliveryNumber").val("");
                $("#shippedQty").val("");
                //$("#shippedMoverBox").val("");
                $("#extraShippedComments").val("");
                $.ajax({
        url: 'cont/moverController.php',
        type: 'GET',
        data: {request: 'getMoverComment',
                  UniqueID : moverUniqueID},
    })
    .done(function(information) {
        var Data = JSON.parse(information);

        var tabla = $('#table_comments').DataTable({
                    dom: 'rt',
                    destroy: true,
                    responsive: true,
                    order:[[3, 'asc']],
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
                    columns: [
                      { data: "FullName" },
                      { data: "NewAreaComment" },
                      { data: "Comment" },
                      { data: "FormattedDate" }
                     
                    ]
                });
                tabla.rows().remove();
                  
               
                tabla.rows.add(Data['data']);
    });

            }
            else{
                new PNotify({
                        title: 'Error',
                        text: 'Ha ocurrido un error en la consulta',
                        type: 'error',
                        styling: 'bootstrap3'
                    });
            }
        });
    });

});

function getCreatedMovers(userLogged){
	$.ajax({
		url: 'cont/moverController.php',
		type: 'POST',
		data: {request: 'getCreatedMover',
					userLogged: userLogged
	},
	})
	.done(function(information) {
		var Data = JSON.parse(information);
		if (Data['response']=='success') {
			var createdMovers=Data['info'][0]['createdMovers'];
			$("#createdMovers").text(createdMovers);
		}
		else{
			new PNotify({
					    title: 'Error',
					    text: 'No se pudo cargar la informacion de los movers creados',
					    type: 'error',
					    styling: 'bootstrap3'
					});
		}
		

	});
}
function getProccesMovers(userLogged){
    $.ajax({
        url: 'cont/moverController.php',
        type: 'POST',
        data: {request: 'getProccessingMover',
                    userLogged: userLogged
    },
    })
    .done(function(information) {
        var Data = JSON.parse(information);
        if (Data['response']=='success') {
            var processingMovers=Data['info'][0]['processingMovers'];
            $("#processingMovers").text(processingMovers);
        }
        else{
            new PNotify({
                        title: 'Error',
                        text: 'No se pudo cargar la informacion de los movers en proceso',
                        type: 'error',
                        styling: 'bootstrap3'
                    });
        }
        

    });
}
function getFinishedMovers(userLogged){
    $.ajax({
        url: 'cont/moverController.php',
        type: 'POST',
        data: {request: 'getFinishedMover',
                    userLogged: userLogged
    },
    })
    .done(function(information) {
        var Data = JSON.parse(information);
        if (Data['response']=='success') {
            var finishedMovers=Data['info'][0]['finishedMovers'];
            $("#finishedMovers").text(finishedMovers);
        }
        else{
            new PNotify({
                        title: 'Error',
                        text: 'No se pudo cargar la informacion de los movers creados',
                        type: 'error',
                        styling: 'bootstrap3'
                    });
        }
        

    });  
}
function getShippedMovers(userLogged){
    $.ajax({
        url: 'cont/moverController.php',
        type: 'POST',
        data: {request: 'getShippedMover',
                    userLogged: userLogged
    },
    })
    .done(function(information) {
        var Data = JSON.parse(information);
        if (Data['response']=='success') {
            var shippedMover=Data['info'][0]['shippedMover'];
            $("#shippedMover").text(shippedMover);
        }
        else{
            new PNotify({
                        title: 'Error',
                        text: 'No se pudo cargar la informacion de los movers creados',
                        type: 'error',
                        styling: 'bootstrap3'
                    });
        }
        

    });    
}
function detailsMoverItem(UniqueID,userLogged){
	$.ajax({
		url: 'cont/moverController.php',
		type: 'GET',
		data: {request: 'getCreatedMoverMaterials',
					UniqueID: UniqueID,
					userLogged: userLogged
	},
	})
	.done(function(information) {
		var Data = JSON.parse(information);
		//console.log(Data);

		var tabla = $('#tableMoverItems').DataTable({
                    dom: 'frtlip',
                    destroy: true,
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
                    columns: [
                      { data: "Partnumber" },
                      { data: "Description" },
                      { data: "Qty" },
                      { data: "MovementType" },
                      { data: "SapDocument" },
                      { data: "UoM"}
                    
                     
                    ]
                });
                tabla.rows().remove();
                  
               
                tabla.rows.add(Data);

	});
}
function printMoverItem(UniqueID, userLogged) {
  // Ruta del archivo PHP en el servidor para procesar el Excel
  const urlProcesarExcel = 'cont/xlsxgenerator.php';

  // Crear un objeto FormData para enviar los parámetros al servidor
  const formData = new FormData();
  formData.append('UniqueID', UniqueID);
  formData.append('userLogged', userLogged);

  //console.log(formData);

  // Enviar una solicitud AJAX al servidor para procesar el archivo Excel
  $.ajax({
    url: urlProcesarExcel,
    type: 'POST',
    data: formData,
    processData: false, // Evitar el procesamiento de datos para que FormData funcione correctamente
    contentType: false, // Evitar el establecimiento de Content-Type para que FormData funcione correctamente
    xhrFields: {
      responseType: 'blob' // Indica que esperamos datos binarios como respuesta
    },
    success: function(data, textStatus, jqXHR) {
      const blob = new Blob([data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

      const downloadLink = document.createElement('a');
      downloadLink.href = URL.createObjectURL(blob);
      downloadLink.download = 'Mover_'+userLogged+'_'+UniqueID+'.xlsx';

      downloadLink.click();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      // Manejar errores
      console.error(errorThrown);
    }
  });
}
function addComment(UniqueID,userLogged){
   // console.log(UniqueID);
    //console.log(userLogged)
    $("#moverUniqueID").val(UniqueID);
    $("#moverUserLogged").val(userLogged);
    $("#settingModal").modal('show');

    $.ajax({
        url: 'cont/moverController.php',
        type: 'GET',
        data: {request: 'getMoverComment',
                  UniqueID : UniqueID},
    })
    .done(function(information) {
        var Data = JSON.parse(information);

        var tabla = $('#table_comments').DataTable({
                    dom: 'rt',
                    destroy: true,
                    responsive: true,
                    order:[[3, 'asc']],
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
                    columns: [
                      { data: "FullName" },
                      { data: "NewAreaComment" },
                      { data: "Comment" },
                      { data: "FormattedDate" }
                     
                    ]
                });
                tabla.rows().remove();
                  
               
                tabla.rows.add(Data['data']);
    });
}
