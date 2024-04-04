/*var scrollEnabled = true; 
var scrolldelay;
function stopScroll() {
    clearTimeout(scrolldelay);
    scrollEnabled = false;
}
function resumeScroll() {
    scrollEnabled = true;
    pageScroll();
}
function pageScroll() {
    if (scrollEnabled) {
        window.scrollBy(0, 1);
        if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
            scrollToTop();
        } else {
            scrolldelay = setTimeout(pageScroll, 20);
        }
    }
}
function scrollToTop() {
    if (scrollEnabled) {
        var currentScroll = document.documentElement.scrollTop || document.body.scrollTop;
        if (currentScroll > 0) {
            window.scrollTo(0, currentScroll - 20);
            setTimeout(scrollToTop, 20); 
        } else {
            setTimeout(pageScroll, 20); 
        }
    }
}
window.addEventListener('scroll', stopScroll);
setTimeout(resumeScroll, 120000);*/

$(document).ready(function(){
	//pageScroll();
    
    $(".alert-icon").addClass("blinking");

    getCriticalNumbers();
	$('#titleCriticos').text('Llegadas de material critico FV55 '+ moment().format('DD/MM/YYYY'));
	
	setInterval(getCriticalNumbers, 60 * 1000);

    setInterval(playSound, 10 * 60 * 1000);

    /*$('#newUpload-info').on('click', function(event) {
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
    });*/
    $('#newUpload-info').on('click', function(event) {
        event.preventDefault();
        var fileInput = $('#file-upload')[0];

        if (fileInput.files.length > 0) {
            var fileName = fileInput.files[0].name;
            if (/paros|criticos/i.test(fileName)) {
                var file = fileInput.files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                    var data = new Uint8Array(e.target.result);
                    var workbook = XLSX.read(data, { type: 'array' });

                    var columnData = [];

                    // Iterar sobre la primera pestaña
                    var sheet1 = workbook.Sheets[workbook.SheetNames[1]];
                    if (sheet1) {
                        columnData = processSheet(sheet1);
                    }

                    // Iterar sobre la segunda pestaña si existe
                    var sheet2 = workbook.Sheets[workbook.SheetNames[2]];
                    if (sheet2) {
                        columnData = columnData.concat(processSheet(sheet2));
                    }

                    //console.log(columnData);
                    sendResults(columnData);
                };

                reader.readAsArrayBuffer(file);
            } else {
                new PNotify({
                    title: 'Error',
                    text: 'Seleccione el archivo de paros potenciales',
                    type: 'error',
                    styling: 'bootstrap3'
                });
            }
        } else {
            new PNotify({
                title: 'Error',
                text: 'Seleccione un archivo',
                type: 'error',
                styling: 'bootstrap3'
            });
        }
    });



});
function processSheet(sheet) {
    var columnData = [];
    var range = XLSX.utils.decode_range(sheet['!ref']);
    for (var i = 2; i <= range.e.r; ++i) {
        var cellAddress = 'D' + (i + 1);
        var cell = sheet[cellAddress];

        var cellDOHAddress = 'I' + (i + 1);
        var cellDOH = sheet[cellDOHAddress];
        var DOHValue = (typeof cellDOH === 'undefined' || cellDOH.v === undefined) ? '0.0' : cellDOH.v.toFixed(2);

        var cellETAAddress = 'L' + (i + 1);
        var cellETA = sheet[cellETAAddress];
        var ETAValue = (typeof cellETA === 'undefined' || cellETA.v === undefined) ? 'TBD' : cellETA.v;

        if (cell && cell.v) {
            columnData.push({
                "PN": cell.v.toString(),
                "DOH": DOHValue.toString(),
                "ETA": ETAValue.toString()
            });
        }
    }
    return columnData;
}


function getCriticalNumbers() {
    new PNotify({
        title: 'Criticos actualizados',
        text: 'Se ha actualizado el estatus de los criticos',
        type: 'success',
        styling: 'bootstrap3'
    });
    $('#titleCriticos').text('Llegadas de material critico FV55 '+ moment().format('DD/MM/YYYY'));

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


function getColoredStatus(status) {
    var color = '';
    var textColor = '#000000'; // color de texto predeterminado

    switch (status) {
        case "5. Sin llegada a planta":
            color = '#CA23B5';
            break;
        case "3. Sin liberar en recibos":
            color = '#F6384A';
            break;
        case "2. Listo para almacenar":
            color = '#F59533';
            break;
        case "1. Material en punto de uso / Sin surtir":
            color = '#FAF667';
            break;
        case "4. Surtido":
            color = '#35E231';
            break;
        default:
            color = '#35E231'; // color de fondo predeterminado
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
            color = '#35E231'; // color de fondo predeterminado
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
function playSound() {
    var sound = new Audio('src/notify.wav');
    sound.play();
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