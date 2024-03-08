var scrollEnabled = true; // Variable para controlar si el scroll está habilitado
var scrolldelay;
// Función para detener el scroll
function stopScroll() {
    clearTimeout(scrolldelay); // Limpia el temporizador actual
    scrollEnabled = false; // Deshabilita el scroll
}

// Función para reanudar el scroll después de 2 minutos de inactividad
function resumeScroll() {
    scrollEnabled = true; // Habilita el scroll
    pageScroll(); // Reinicia el scroll
}

// Función para animar el scroll hacia abajo
function pageScroll() {
    if (scrollEnabled) {
        window.scrollBy(0, 1); // Desplaza la página hacia abajo
        if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
            scrollToTop();
        } else {
            scrolldelay = setTimeout(pageScroll, 20); // Establece un retraso para el próximo scroll hacia abajo
        }
    }
}

// Función para animar el scroll hacia arriba
function scrollToTop() {
    if (scrollEnabled) {
        var currentScroll = document.documentElement.scrollTop || document.body.scrollTop;
        if (currentScroll > 0) {
            window.scrollTo(0, currentScroll - 20); // Modifica el valor para un desplazamiento más suave
            setTimeout(scrollToTop, 20); // Establece un retraso para el próximo scroll hacia arriba
        } else {
            setTimeout(pageScroll, 20); // Cuando llegamos al tope, vuelve a llamar a pageScroll para bajar de nuevo
        }
    }
}

// Detener el scroll cuando el usuario interactúa con la página
window.addEventListener('scroll', stopScroll);

// Reanudar el scroll después de 2 minutos de inactividad
setTimeout(resumeScroll, 120000); // 2 minutos = 120,000 milisegundos

$(document).ready(function(){
	//pageScroll();
    
    $(".alert-icon").addClass("blinking");

    getCriticalNumbers();
	$('#titleCriticos').text('Llegadas de material critico FV55 '+ moment().format('DD/MM/YYYY'));
	
	setInterval(getCriticalNumbers, 60 * 1000);

    $('#newUpload-info').on('click', function(event) {
        event.preventDefault();
        var fileInput = $('#file-upload')[0];
       

        if (fileInput.files.length>0) {
            var fileName = fileInput.files[0].name;
            if (/paros|criticos/i.test(fileName)) {
                var file = fileInput.files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                    var data = new Uint8Array(e.target.result);
                    var workbook = XLSX.read(data, { type: 'array' });

                    var columnData = [];

                   var cellDOH;
                    [workbook.Sheets[workbook.SheetNames[1]], workbook.Sheets[workbook.SheetNames[2]]].forEach(function(worksheet) {
                        var range = XLSX.utils.decode_range(worksheet['!ref']);
                        for (var i = 2; i <= range.e.r; ++i) {
                            var cellAddress = 'D' + (i + 1);
                            var cell = worksheet[cellAddress];

                            var cellDOHAddress =  'I' + (i+1);
                            var cellDOH = worksheet[cellDOHAddress];
                            var DOHValue = (typeof cellDOH === 'undefined' || cellDOH.v === undefined) ? '0.0' : cellDOH.v.toFixed(2);

                            var cellETAAddress =  'L' + (i+1);
                            var cellETA = worksheet[cellETAAddress];
                            var ETAValue = (typeof cellETA === 'undefined' || cellETA.v === undefined) ? 'TBD' : cellETA.v;
                            if (cell && cell.v) {
                               
                                    columnData.push({
                                        "PN" : cell.v.toString(),
                                        "DOH" : DOHValue.toString(),
                                        "ETA" : ETAValue.toString()

                                    });
                              
                            }
                        }
                    });
                    console.log(columnData);
                    sendResults(columnData);

                };

                reader.readAsArrayBuffer(file);
            }
            else{
                new PNotify({
                    title: 'Error',
                    text: 'Seleccione el archivo de paros potenciales',
                    type: 'error',
                    styling: 'bootstrap3'
                });
            }
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



});

// Función para detener el scroll
/*function stopScroll() {
    clearTimeout(scrolldelay); // Limpia el temporizador actual
    scrollEnabled = false; // Deshabilita el scroll
}

// Función para reanudar el scroll después de 2 minutos de inactividad
function resumeScroll() {
    scrollEnabled = true; // Habilita el scroll
    pageScroll(); // Reinicia el scroll
}

function pageScroll() {
    if (scrollEnabled) {
        window.scrollBy(0, 1); // Desplaza la página hacia abajo
        if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
            scrollToTop();
        } else {
            scrolldelay = setTimeout(pageScroll, 20); // Establece un retraso para el próximo scroll hacia abajo
        }
    }
}

// Función para animar el scroll hacia arriba
function scrollToTop() {
    if (scrollEnabled) {
        var currentScroll = document.documentElement.scrollTop || document.body.scrollTop;
        if (currentScroll > 0) {
            window.scrollTo(0, currentScroll - 20); // Modifica el valor para un desplazamiento más suave
            setTimeout(scrollToTop, 20); // Establece un retraso para el próximo scroll hacia arriba
        } else {
            setTimeout(pageScroll, 20); // Cuando llegamos al tope, vuelve a llamar a pageScroll para bajar de nuevo
        }
    }
}*/

/*function getCriticalNumbers(){
	new PNotify({
                        title: 'Criticos actualizados',
                        text: 'Se ha actualizado el estatus de los criticos',
                        type: 'success',
                        styling: 'bootstrap3'
                    });
	$.ajax({
		url: 'cont/criticosController.php',
		type: 'GET',
		data: {request: 'getList'},
	})
	.done(function(info) {
		var Data = JSON.parse(info);
		//console.log(Data);
            //console.log(Data);
            var tabla = $('#table_criticos').DataTable({
                    dom: 'irtlp',
                    "columnDefs": [
				        {"className": "text-center", "targets": "_all"}
				      ],
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
                    paging: false,
                    columns: [
                      {data: "PN"},
                      {data: "DOH"},
                      {data: "ETA"},
                      {data: "Mtype"},
                      { data: "Location" },
                      { data: "Status" },
                      { data: "FechaLlegada" }
                     
                    ]
                });
                tabla.rows().remove();
                  
               
                tabla.rows.add(Data.data);
                //Colors
                tabla.rows().every(function() {
                var data = this.data();
                var status = data.Status;
                var colors = getColorByStatus(status);

                // Aplicar color de fondo
                if (colors.backgroundColor) {
                    this.nodes().to$().css('background-color', colors.backgroundColor);
                }

                // Aplicar color de texto
                if (colors.textColor) {
                    this.nodes().to$().css('color', colors.textColor);
                }
            });
	})
	.fail(function() {
		console.log("error");
	});
	
}*/
function getCriticalNumbers() {
    new PNotify({
        title: 'Criticos actualizados',
        text: 'Se ha actualizado el estatus de los criticos',
        type: 'success',
        styling: 'bootstrap3'
    });

    $.ajax({
        url: 'cont/criticosController.php',
        type: 'GET',
        data: {
            request: 'getList'
        },
    }).done(function(info) {
        var Data = JSON.parse(info);
        var tabla = $('#table_criticos').DataTable({
            dom: 'irtlp',
            "columnDefs": [{
                "className": "text-center",
                "targets": "_all"
            }],
            destroy: true,
            order: [
                [6, 'asc']
            ],
            responsive: true,
           
            language: {
                url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
            },
            className: "center-block",
            autoWidth: true,
            paging: false,
            columns: [{
                    data: "PN"
                },
                {
                    data: "DOH"
                },
                {
                    data: "ETA"
                },
                {
                    data: "Mtype"
                },
                {
                    data: "Location"
                },
                {
                    data: "Status"
                },
                {
                    data: "FechaLlegada"
                }

            ]
        });
        tabla.rows().remove();
        tabla.rows.add(Data.data).draw();
        tabla.columns.adjust().draw();

        // Aplicar colores
        tabla.rows().every(function() {
            var data = this.data();
            var status = data.Status;
            var colors = getColorByStatus(status);

            if (colors.backgroundColor) {
                this.nodes().to$().css('background-color', colors.backgroundColor);
            }
            if (colors.textColor) {
                this.nodes().to$().css('color', colors.textColor);
            }
        });

        // Ordenar por color
        tabla.order([5, 'asc']).draw();

    }).fail(function() {
        console.log("error");
    });
}


function getColorByStatus(status) {
    var color = '';
    var textColor = '#000000'; // color de texto predeterminado

    switch (status) {
        case "<span style='opacity:0'>5. </span>Sin llegada a planta":
            color = '#CA23B5';
            break;
        case "<span style='opacity:0'>3. </span>Sin liberar en recibos":
            color = '#F6384A';
            break;
        case "<span style='opacity:0'>2. </span>Listo para almacenar":
            color = '#F59533';
            break;
        case "<span style='opacity:0'>1. </span>Material en punto de uso / Sin surtir":
            color = '#FAF667';
            break;
        case "<span style='opacity:0'>4. </span>Surtido":
            color = '#35E231';
            break;
        default:
            color = ''; // color de fondo predeterminado
    }

    // Si el estado es uno de los especificados, cambia el color de texto a blanco
    if (status === "<span style='opacity:0'>5. </span>Sin llegada a planta" || status === "<span style='opacity:0'>3. </span>Sin liberar en recibos" || status === "<span style='opacity:0'>2. </span>Listo para almacenar") {
        textColor = '#FFFFFF'; // color de texto blanco
    }

    return {
        backgroundColor: color,
        textColor: textColor
    };
}

function sendResults(results) {
    $.ajax({
        url: 'cont/updateCriticals.php',
        type: 'POST', 
        dataType: 'json',
        data: {
                    results: JSON.stringify(results),
                    request: 'updateV2',
                   },
    })
    .done(function(response) {
        
        if (response['response']=='success') {
            new PNotify({
                title: 'Exito',
                text: 'Informacion de criticos actualizada',
                type: 'success',
                styling: 'bootstrap3'
            });
            getCriticalNumbers();
        }
        else{
            new PNotify({
                title: 'Error',
                text: response['message'],
                type: 'error',
                styling: 'bootstrap3'
            });
        }     
        //console.log(response['response']);
     
    }).fail(function(){
      new PNotify({
              title: 'Error',
              text: 'Ah ocurrido un error, verifique la informacion',
              type: 'error',
              styling: 'bootstrap3'
          });
    });    
}