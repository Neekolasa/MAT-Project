$(document).ready(function () {
      //verifyLocation();

      try{
        new PNotify({
              title: 'Exito',
              text: 'Bienvenido '+GetParameterValues('name').replaceAll('%20',' '),
              type: 'success',
              styling: 'bootstrap3'
          });
      }
      catch(e){

      }     

     
      var userLogged = sessionStorage.getItem('userLogged');
      var fullname = sessionStorage.getItem('fullname');
      if (userLogged==null || fullname == null) {
        window.location.replace("http://10.215.156.203/materiales/rutas/miplogin.php?response=mustBeLogged");
      }



      $("#userLogged").val(userLogged);



      try{
        var span = $("#username_logged");
        span.text(GetParameterValues('name').replaceAll('%20',' '));
      }
      catch(e){

      }
      
     

      generateTable(userLogged);
      $("#planta_origen").val("FV55");
      $("#usuario_autoriza").val(fullname);
      $("#telefono").val("");
      $("#fecha_creacion").val(moment().format('DD-MM-YYYY HH:mm'));

      $("#planta_destino").val("");
      $("#atencion").val("");
      $("#telefono_atencion").val("");
      $("#intrucciones_envio").val("");
      $("#comentarios_adicionales").val("");



      $('#numero_parte').val("");
      $("#qty").val("");
      $("#description").val("");
      $("#uom").val("");
      $("#mov_type").val("");
      $("#sap_document").val("");



    $("#buttonMasiveMaterial").on('click', function(event) {
      event.preventDefault();
      $("#masiveMaterialModal").modal('show');
    }); 

    $("#downloadTemplate").on('click', function(event) {
      event.preventDefault();
      var ruta = "templates/TemplateMover.xlsx";
      downloadFile(ruta);
    }); 

    $("#upload-info").on('click', function(event) {
      event.preventDefault();
        var fileInput = $('#file-upload')[0];

    // Verificar si se seleccionó un archivo
    if (fileInput.files.length > 0) {
        var file = fileInput.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            var data = new Uint8Array(e.target.result);
            var workbook = XLSX.read(data, { type: 'array' });

            var sheetName = workbook.SheetNames[0];
            var sheet = workbook.Sheets[sheetName];

            var jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1, raw: true });

            var results = [];

            var keys = jsonData[0];

            for (var i = 1; i < jsonData.length; i++) {
              var row = jsonData[i];
              var obj = {};

              for (var j = 0; j < keys.length; j++) {
                  var key = String(keys[j]);
                  var value = String(row[j]);
                  obj[key.replace(/ /g, "_")] = value;
              }

              obj["UniqueID"] = generateSerial();
              
              results.push(obj);
          }
            
            sendResults(results);
        };

        reader.readAsArrayBuffer(file);
    } else {
        new PNotify({
                      title: 'Error',
                       text: 'Seleccione un archivo',
                      type: 'error',
                      styling: 'bootstrap3'
                  });
    }
    });
    $("#newUpload-info").on('click', function(e) {
      e.preventDefault();
      var userLogged = sessionStorage.getItem("userLogged");
      var plantaOrigen = "FV55";
      var fechaCreacion = moment().format('DD-MM-YYYY HH:mm');
      
        var fileInput = $('#file-upload')[0];
        if (fileInput.files.length > 0) {
        var file = fileInput.files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
            var data = new Uint8Array(e.target.result);
            var workbook = XLSX.read(data, { type: 'array' });

            // Obtener la hoja de trabajo actual
            var sheetName = workbook.SheetNames[0];
            var sheet = workbook.Sheets[sheetName];

            var plantaDestino = sheet['B1'] && sheet['B1'].v !== undefined ? sheet['B1'].v.toString() : '';
            var usuarioAutoriza = sheet['B2'] && sheet['B2'].v !== undefined ? sheet['B2'].v.toString() : '';
            var telefonoOrigen = sheet['B3'] && sheet['B3'].v !== undefined ? sheet['B3'].v.toString() : '';
            var atencionUsuario = sheet['B4'] && sheet['B4'].v !== undefined ? sheet['B4'].v.toString() : '';
            var telefonoAtencion = sheet['B5'] && sheet['B5'].v !== undefined ? sheet['B5'].v.toString() : '';
            var instruccionesEnvio = sheet['E1'] && sheet['E1'].v !== undefined ? sheet['E1'].v.toString() : '';
            var comentariosAdicionales = sheet['E2'] && sheet['E2'].v !== undefined ? sheet['E2'].v.toString() : '';

            $("#usuario_autoriza").val(usuarioAutoriza);
            $("#telefono").val(telefonoOrigen);
            $("#fecha_creacion").val(fechaCreacion);
            $("#planta_destino").val(plantaDestino);
            $("#atencion").val(atencionUsuario);
            $("#telefono_atencion").val(telefonoAtencion);
            $("#intrucciones_envio").val(instruccionesEnvio);
            $("#comentarios_adicionales").val(comentariosAdicionales);

            var tablaValores = [];
            for (var i = 9; i <= 100; i++) {
                var fila = {};
                fila['Componente'] = sheet['A' + i] && sheet['A' + i].v.toString() !== undefined ? sheet['A' + i].v.toString() : '';
                fila['Descripcion'] = sheet['B' + i] && sheet['B' + i].v.toString() !== undefined ? sheet['B' + i].v.toString() : '';
                fila['Cantidad'] = sheet['C' + i] && sheet['C' + i].v.toString() !== undefined ? sheet['C' + i].v.toString() : '';
                fila['UoM'] = sheet['D' + i] && sheet['D' + i].v.toString() !== undefined ? sheet['D' + i].v.toString() : '';
                fila['TSA'] = sheet['E' + i] && sheet['E' + i].v.toString() !== undefined ? sheet['E' + i].v.toString() : '';
                fila['Item'] = sheet['F' + i] && sheet['F' + i].v.toString() !== undefined ? sheet['F' + i].v.toString() : '';
                fila['UniqueID'] = generateSerial();
                if (fila['Componente'] || fila['Descripcion'] || fila['Cantidad'] || fila['UoM'] || fila['TSA'] || fila['Item']) {
                    tablaValores.push(fila);
                }
            }  


            var jsonData = {
                userLogged: userLogged,
                plantaOrigen: plantaOrigen,
                fechaCreacion: fechaCreacion,
                plantaDestino: plantaDestino,
                usuarioAutoriza: usuarioAutoriza,
                telefonoOrigen: telefonoOrigen,
                atencionUsuario: atencionUsuario,
                telefonoAtencion: telefonoAtencion,
                instruccionesEnvio: instruccionesEnvio,
                comentariosAdicionales: comentariosAdicionales,
                tablaValores: tablaValores
            };

            var jsonString = JSON.stringify(jsonData);

            //console.log(jsonData.tablaValores);
            sendExcelResults(jsonData.tablaValores)
        };

        reader.readAsArrayBuffer(file);
      }
      else{
        new PNotify({
                      title: 'Error',
                       text: 'Seleccione un archivo',
                      type: 'error',
                      styling: 'bootstrap3'
                  });
      }
      
  });


    $("#agregarMover").on('click', function(e) {
         e.preventDefault();
        permission = sessionStorage.getItem('permission');
        if (permission!='delivery') {
           new PNotify({
                      title: 'Error',
                       text: 'No tiene los permisos necesarios para esto',
                      type: 'error',
                      styling: 'bootstrap3'
                  });
        }
        else{
            moverPartNumber = $('#numero_parte').val();
           moverQty = $("#qty").val();
           moverDescription = $("#description").val();
           moverUom = $("#uom").val();
           moverMovType = $("#mov_type").val();
           moverSapDocument = $("#sap_document").val();

           if (moverPartNumber == "" || moverQty == "" || moverDescription == "" || moverUom == "" || moverMovType == "" || moverSapDocument == "") {
            new PNotify({
                        title: 'Error',
                         text: 'Rellene todos los campos requeridos',
                        type: 'error',
                        styling: 'bootstrap3'
                    });
           }
           else{
          
            

            $.ajax({
              url: 'cont/moverController.php',
              type: 'POST',
              data: {request: 'tempMover',
                        moverPartNumber: moverPartNumber,
                        moverQty: moverQty,
                        moverDescription: moverDescription,
                        moverUom: moverUom,
                        moverMovType: moverMovType,
                        moverSapDocument: moverSapDocument,
                        userLogged: userLogged,
                        uniqueID: generateSerial()},
            })
            .done(function(info) {
              var Data = JSON.parse(info);
              if (Data['response']=='success') {
                new PNotify({
                        title: 'Exito',
                         text: 'Informacion de numero de parte agregada al mover actual',
                        type: 'success',
                        styling: 'bootstrap3'
                    });
                 moverPartNumber = $('#numero_parte').val("");
                 moverQty = $("#qty").val("");
                 moverDescription = $("#description").val("");
                 moverUom = $("#uom").val("");
                 moverMovType = $("#mov_type").val("");
                 moverSapDocument = $("#sap_document").val("");
                 $("#qty").attr('readonly', true);
                $("#sap_document").attr('readonly', true);
                $("#mov_type").attr('readonly', true);
                generateTable(userLogged);
                
              
                
              }
              else{
                new PNotify({
                        title: 'Error',
                         text: 'Ha ocurrido un error durante la consulta',
                        type: 'error',
                        styling: 'bootstrap3'
                    });
              }
            });
            
           }
        }
         
         
   });

    $("#resetForm").on('click', function(event) {
      event.preventDefault();
      $("#planta_origen").val("FV55");//
      $("#usuario_autoriza").val(fullname);//
      $("#telefono").val("");
      $("#fecha_creacion").val(moment().format('DD-MM-YYYY'));//

      $("#planta_destino").val("");//
      $("#atencion").val("");//
      $("#telefono_atencion").val("");
      $("#intrucciones_envio").val("");
      $("#comentarios_adicionales").val("");

      $('#numero_parte').val("");
      $("#qty").val("");
      $("#description").val("");
      $("#uom").val("");
      $("#mov_type").val("");
      $("#sap_document").val("");

      var userLogged = sessionStorage.getItem("userLogged");
      
      $.ajax({
        url: 'cont/moverController.php',
        type: 'GET',
        data: {userLogged: userLogged,
                  request: "deleteTempMoverNumbers"
      },

      })
      .done(function(info) {
        var Data = JSON.parse(info);
        if (Data['response']=='success') {
          new PNotify({
                      title: 'Exito',
                       text: 'Formulario establecido a campos predeterminados',
                      type: 'success',
                      styling: 'bootstrap3'
                  });
          generateTable(userLogged);
        }
        else{
          new PNotify({
                      title: 'Error',
                       text: 'Ha ocurrido un error innesperado',
                      type: 'error',
                      styling: 'bootstrap3'
                  });
        }

        
      })
      
    });



   $("#numero_parte").keyup(function(event) {
    
     if (event.keyCode === 13) {
        moverPartNumber = $("#numero_parte").val();

        $.ajax({
          url: 'cont/moverController.php',
          type: 'POST',
          data: {moverPartNumber: moverPartNumber,
                    request: 'getPartNumberInfo'},
        })
        .done(function(info) {
          var Data = JSON.parse(info);

          if (Data['response'] == 'fail') {
            new PNotify({
                      title: 'Numero de parte no encontrado',
                       text: 'Compruebe su informacion',
                      type: 'error',
                      styling: 'bootstrap3'
                  });
            $("#description").val("");
            $("#uom").val("");
          }
          else{
            new PNotify({
                      title: 'Exito',
                       text: 'Obteniendo informacion de numero de parte '+moverPartNumber,
                      type: 'success',
                      styling: 'bootstrap3'
                  });
            moverDescription = Data['data'][0]['Descrip'];
            moverUom = Data['data'][0]['UoM'];
            $("#description").val(moverDescription);
            $("#uom").val(moverUom);
            $("#uom").removeAttr('disabled');
            $("#qty").attr('readonly', false);
            $("#sap_document").attr('readonly', false);
            $("#mov_type").attr('readonly', false);
          }
         
        });
       


        
          
      }
   });

   $("#sendMover").on('click', function(event) {
     event.preventDefault();
     permission = sessionStorage.getItem('permission');
        if (permission!='delivery') {
           new PNotify({
                      title: 'Error',
                       text: 'No tiene los permisos necesarios para esto',
                      type: 'error',
                      styling: 'bootstrap3'
                  });
        }
        else{
          var plantaOrigen = $("#planta_origen").val();
           var usuarioAutoriza = $("#usuario_autoriza").val();
           var fechaCreacion = $("#fecha_creacion").val();
           var plantaDestino = $("#planta_destino").val();
           var atencionUsuario = $("#atencion").val();
       

          var telefonoOrigen =  $("#telefono").val();
          var telefonoAtencion = $("#telefono_atencion").val();
          var instruccionesEnvio = $("#intrucciones_envio").val();
        
          var comentariosAdicionales = $("#comentarios_adicionales").val();
      

          var userLogged = $("#userLogged").val();
          

           if (plantaOrigen == "" || usuarioAutoriza == "" || fechaCreacion == "" || plantaDestino == "" || atencionUsuario == "") {
            new PNotify({
              title: 'Error',
              text: 'Rellene todos los campos requeridos',
              type: 'error',
              styling: 'bootstrap3'
            });
           }
           else{
            $.ajax({
              url: 'cont/moverController.php',
              type: 'GET',
              data: {request: 'getPromise',
                        userLogged:userLogged
              },
            })
            .done(function(information) {
              var Data = JSON.parse(information);
             
              if (Data['response']=='success') {
                var moverUniqueID = generateSerial();
                $.ajax({
                  url: 'cont/moverController.php',
                  type: 'POST',
                  data: {request:'addMoverData',
                            plantaOrigen: plantaOrigen,
                            usuarioAutoriza: usuarioAutoriza,
                            fechaCreacion: fechaCreacion,
                            plantaDestino: plantaDestino,
                            atencionUsuario: atencionUsuario,
                            telefonoOrigen: telefonoOrigen,
                            telefonoAtencion: telefonoAtencion,
                            instruccionesEnvio: instruccionesEnvio,
                            comentariosAdicionales: comentariosAdicionales,
                            userLogged: userLogged,
                            moverUniqueID: moverUniqueID},
                })
                .done(function(information) {
                  var Data = JSON.parse(information);
                  if (Data['response']=='success') {
                    new PNotify({
                      title: 'Exito',
                      text: 'Se ha creado el mover exitosamente',
                      type: 'success',
                      styling: 'bootstrap3'
                    });
                    generateTable(userLogged);
                    getCreatedMovers(userLogged);

                    $("#planta_origen").val("FV55");//
                    $("#usuario_autoriza").val(usuarioAutoriza);//
                    $("#telefono").val("");
                    $("#fecha_creacion").val(moment().format('MM-DD-YYYY HH:mm'));//

                    $("#planta_destino").val("");//
                    $("#atencion").val("");//
                    $("#telefono_atencion").val("");
                    $("#intrucciones_envio").val("");
                    $("#comentarios_adicionales").val("");

                    $('#numero_parte').val("");
                    $("#qty").val("");
                    $("#description").val("");
                    $("#uom").val("");
                    $("#mov_type").val("");
                    $("#sap_document").val("");

                    moverPartNumber = $('#numero_parte').val("");
                    moverQty = $("#qty").val("");
                    moverDescription = $("#description").val("");
                    moverUom = $("#uom").val("");
                    moverMovType = $("#mov_type").val("");
                    moverSapDocument = $("#sap_document").val("");
                    $("#qty").attr('readonly', true);
                    $("#sap_document").attr('readonly', true);
                    $("#mov_type").attr('readonly', true);
                  }
                  else{
                    new PNotify({
                      title: 'Error',
                      text: 'Ha ocurrido un error innesperado',
                      type: 'error',
                      styling: 'bootstrap3'
                    });
                  }

                });
               
                
                
              }
              else{
                new PNotify({
                  title: 'Error',
                  text: 'Debe agregar al menos un material al mover actual',
                  type: 'error',
                  styling: 'bootstrap3'
                });
              }
            })
            
            
           }
        }
   });
});
function deleteMoverItem (uniqueID,userLogged){

  $.ajax({
    url: 'cont/moverController.php',
    type: 'GET',
    data: {request: 'deleteMoverItem',
              uniqueID:uniqueID,
              userLogged: userLogged
  },
  })
  .done(function(response) {
    var Data = JSON.parse(response);
    if (Data['response']=='success') {
      new PNotify({
        title: 'Exito',
        text: 'Se ha removido del Mover el numero de parte seleccionado',
        type: 'success',
        styling: 'bootstrap3'
      });

      generateTable(userLogged);
    }
    else{
      new PNotify({
        title: 'Error',
        text: 'Ha ocurrido un error innesperado, intente de nuevo',
        type: 'error',
        styling: 'bootstrap3'
      });
    }
  }); 
}
function generateTable(userLogged){
  try{


  $.ajax({
                url: 'cont/moverController.php',
                type: 'POST',
                data: {request: 'getMoverOwner',
                          userLogged: userLogged},
              })
              .done(function(information) {
                var Datatable = JSON.parse(information);
                var tabla = $('#table_mover').DataTable({
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

                      { data: "ID"},
                      { data: "PN" },
                      { data: "Description" },
                      { data: "UoM" },
                      { data: "Qty" },
                      { data: "Action" }
                     
                    ]
                });
                tabla.rows().remove();
                  
               
                tabla.rows.add(Datatable);
            
              
                
              });
  }
  catch(e){

  }
}
function generateSerial() {
    'use strict';
    
    var chars = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz',
        serialLength = 10,
        randomSerial = "",
        i,
        randomNumber;

    for (i = 0; i < serialLength; i++) {
        randomNumber = Math.floor(Math.random() * chars.length);
        randomSerial += chars.substring(randomNumber, randomNumber + 1);
    }

    return randomSerial;
}
function closeSession(){
  $.ajax({
    url: 'cont/moverController.php',
    type: 'POST',
    data: {request: 'delGlobal'},
  })
  .done(function(information) {
    var Data = JSON.parse(information);
    if (Data['response']=='success') {
      sessionStorage.removeItem('userLogged');
      sessionStorage.removeItem('fullname');
      window.location.replace("http://10.215.156.203/materiales/rutas/miplogin.php?response=exit");

    }
    else{
      new PNotify({
          title: 'Error',
          text: 'Ha ocurrido un error inesperado, intende de nuevo',
          type: 'error',
          styling: 'bootstrap3'
      });
    }
  });
}
function verifyLocation(){
  $.ajax({
          url: 'cont/moverController.php',
          type: 'GET',
          data: {request: 'getGlobalUsername'},
        })
        .done(function(information) {     
        $("#userLogged").val(information);

      });
      $.ajax({
          url: 'cont/moverController.php',
          type: 'GET',
          data: {request: 'getGlobalFullName'},
        })
        .done(function(information) {     
        $("#fullname").val(information);

      });        

      var userLogged = $("#userLogged").val();
      var fullname = $("#fullname").val();
}
function GetParameterValues(param) {
  var url = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
  for (var i = 0; i < url.length; i++) {
    var urlparam = url[i].split('=');
    if (urlparam[0] == param) {
      return urlparam[1];
    }
  }
}
function getUsername(callback) {
  $.ajax({
    url: 'cont/moverController.php',
    type: 'GET',
    data: {request: 'getUsernameFunction'},
  })
  .done(function(information) {
    // Llama a la devolución de llamada con la información deseada
    callback(information);
  });
}
function downloadFile(url) {
        // Creamos un elemento <a> temporal
        var link = $("<a>");
        // Asignamos la URL y el nombre de descarga al elemento <a>
        link.attr("href", url)
            .attr("download", "TemplateExcelMover.xlsx")
            .appendTo("body");
        // "Clicamos" en el enlace para iniciar la descarga
        link[0].click();
        // Eliminamos el enlace después de la descarga
        link.remove();
}
function sendResults(results) {
   userLogged = sessionStorage.getItem("userLogged");

    $.ajax({
        url: 'cont/moverController.php',
        type: 'POST', 
        dataType: 'json',
        data: {
                    userLogged: userLogged,
                    results: JSON.stringify(results),
                    request: 'processMasiveData'
                   },
    })
    .done(function(response) {
      if (response['response']=='wrong') {
        new PNotify({
              title: 'Error',
              text: 'Numero de parte '+response['number']+" incorrecto, verifique su informacion",
              type: 'error',
              styling: 'bootstrap3'
          });
      }
      else if(response['response']=='success')
      {
        new PNotify({
              title: 'Exito',
              text: 'Cargando informacion del archivo',
              type: 'success',
              styling: 'bootstrap3'
          });
        $("#masiveMaterialModal").modal('hide');
         

      }
      else{
        new PNotify({
              title: 'Error',
              text: 'Ah ocurrido un error, verifique la informacion',
              type: 'error',
              styling: 'bootstrap3'
          });
      }

      generateTable(userLogged);

     
    }).fail(function(){
      new PNotify({
              title: 'Error',
              text: 'Ah ocurrido un error, verifique la informacion',
              type: 'error',
              styling: 'bootstrap3'
          });
    });    
}
function sendExcelResults(results) {
   userLogged = sessionStorage.getItem("userLogged");

    $.ajax({
        url: 'cont/moverController.php',
        type: 'POST', 
        dataType: 'json',
        data: {
                    userLogged: userLogged,
                    results: JSON.stringify(results),
                    request: 'processExcelMasiveData'
                   },
    })
    .done(function(response) {
      if (response['response']=='wrong') {
        new PNotify({
              title: 'Error',
              text: 'Numero de parte '+response['number']+" incorrecto, verifique su informacion",
              type: 'error',
              styling: 'bootstrap3'
          });
      }
      else if(response['response']=='success')
      {
        new PNotify({
              title: 'Exito',
              text: 'Cargando informacion del archivo',
              type: 'success',
              styling: 'bootstrap3'
          });
        $("#masiveMaterialModal").modal('hide');
         

      }
      else{
        new PNotify({
              title: 'Error',
              text: 'Ah ocurrido un error, verifique la informacion',
              type: 'error',
              styling: 'bootstrap3'
          });
      }

      generateTable(userLogged);

     
    }).fail(function(){
      new PNotify({
              title: 'Error',
              text: 'Ah ocurrido un error, verifique la informacion',
              type: 'error',
              styling: 'bootstrap3'
          });
    });    
}