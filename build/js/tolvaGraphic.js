$(document).ready(function(){

    getGraphic(getTurn(), moment().format('YYYY-MM-DD'));
    getReview(getTurn(),moment(new Date($("#single_cal1").val())).format('YYYY-MM-DD'));


    var hora = moment().format('HH:mm');
    if (hora>='14:30' && hora<='15:30') {
        $("#checkLogin").show();
    }
    else if (hora>='22:59' && hora<='23:59') {
        $("#checkLogin").show();
    }
    else{
        $("#checkLogin").hide();
        $("#checkLogin").show();
    }

    var lastInputTime = 0;
    var typingDelay = 50;
    scan = false;
    
    $("#empNumScanned").on('input',function(e){
        var currentTime = new Date().getTime();
        if (currentTime - lastInputTime < typingDelay) {
            scan = true;

        } else {
            scan = false;

        }
        lastInputTime = currentTime;



    });

    $("#empNumScanned").keypress(function(event) {
      // Verificar si la tecla presionada es "Enter"
      if (event.which === 13) {
        $("#saveVisitedUser").click();
      }
    });
    

    $("#empNumScanned").on("contextmenu",function(){
        return false;
    });
    $('#empNumScanned').on("cut copy paste",function(e) {
        e.preventDefault();
    });

    $("#saveVisitedUser").on('click', function(event) {
        event.preventDefault();
        
        if (!scan) {
            new PNotify({
                title: 'Error',
                text: 'Debe escanear el numero de empleado',
                type: 'error',
                styling: 'bootstrap3'
            });
        }
        else{
            //console.log("Escaneado")
            var name = $("#userConfirm").val();
            var empNum = $("#empNumScanned").val();
            if ((name == "Ramon Martinez" && empNum == "C854474270") || (name == "Gabriel Aldana" && empNum == "C854473664")) {
                //console.log("Usuario valido");
                fecha = moment().format('YYYY-MM-DD HH:mm');
               $.ajax({
                    url: 'cont/tolvas_counter.php',
                    type: 'POST',
                    data: {
                            request: 'setLoggon',
                            name: name,
                            date: fecha,
                            turno: getTurn()
                    },
                })
                .done(function(data) {
                    //console.log(data);
                    //window.location.reload();
                    var Datos = JSON.parse(data);
                    //console.log(Datos);
                    if (Datos['response']=='success') {
                        getReview(getTurn(),fecha);
                        $("#empNumScanned").val("");
                        $("#modalRegistroVisita").modal('hide');
                        new PNotify({
                            title: 'Exito',
                            text: 'Revision diaria realizada',
                            type: 'success',
                            styling: 'bootstrap3'
                        });
                    }
                    else{
                        $("#empNumScanned").val("");
                        $("#modalRegistroVisita").modal('hide');
                        new PNotify({
                            title: 'Error',
                            text: 'Ya ha registrado la revision diaria',
                            type: 'error',
                            styling: 'bootstrap3'
                        });
                    }
                    
                })
                .fail(function() {
                    //console.log("error");
                })
            }
            else  {
                if ($("#empNumScanned").val()=="") {
                    new PNotify({
                        title: 'Error',
                        text: 'Ingrese el numero de empleado',
                        type: 'error',
                        styling: 'bootstrap3'
                    });
                }
               else{
                    new PNotify({
                        title: 'Error',
                        text: 'Usuario no valido',
                        type: 'error',
                        styling: 'bootstrap3'
                    });
               }
            }
            
        }
        /*var name = $("#userConfirm").val();
        */
        

    });

    $("#checkLogin").on('click', function(event) {
        event.preventDefault();
        
        $("#modalRegistroVisita").modal('show');
    });

    //console.log(getTurn())
    $("#searchTolvaButton").on('click', function(event) {
        event.preventDefault();
        var date = moment(new Date($("#single_cal1").val())).format('YYYY-MM-DD');
        var turno = $("#turnoSearch").val();

        $("#review_list").html("");
        getGraphic(turno, date);
        getReview(turno, date);

        var currentDate = moment().format('YYYY-MM-DD');
        if (date!=currentDate) {
            $("#checkLogin").hide()
        }
        else{
            $("#checkLogin").show();
        }
        

    });

    $("#turno").on('change',  function(event) {
        event.preventDefault();
        getRouteOwners($("#turno").val());
    });

    $("#routeOwner").on('click', function(event) {
        event.preventDefault();

        $("#modalRouteOwner").modal('show');
        getRouteOwners($("#turno").val());
       
    });
    $("#saveRoutes").on('click', function(event) {
        event.preventDefault();
            var turno = $("#turno").val();
            var Ruta11_Name = $("#RUTA11_Name").val();
            var Ruta11_PL = $("#RUTA11_PL").val()

            var Ruta12_Name = $("#RUTA12_Name").val();
            var Ruta12_PL = $("#RUTA12_PL").val()

            var Ruta13_Name = $("#RUTA13_Name").val();
            var Ruta13_PL = $("#RUTA13_PL").val()

            var Ruta14_Name = $("#RUTA14_Name").val();
            var Ruta14_PL = $("#RUTA14_PL").val()

            var Ruta15_Name = $("#RUTA15_Name").val();
            var Ruta15_PL = $("#RUTA15_PL").val()

            var Ruta16_Name = $("#RUTA16_Name").val();
            var Ruta16_PL = $("#RUTA16_PL").val()

            var Ruta17_Name = $("#RUTA17_Name").val();
            var Ruta17_PL = $("#RUTA17_PL").val()

            var Ruta18_Name = $("#RUTA18_Name").val();
            var Ruta18_PL = $("#RUTA18_PL").val()

            var Ruta19_Name = $("#RUTA19_Name").val();
            var Ruta19_PL = $("#RUTA19_PL").val()

            var Ruta20_Name = $("#RUTA20_Name").val();
            var Ruta20_PL = $("#RUTA20_PL").val()

            var Ruta21_Name = $("#RUTA21_Name").val();
            var Ruta21_PL = $("#RUTA21_PL").val()

            var Ruta22_Name = $("#RUTA22_Name").val();
            var Ruta22_PL = $("#RUTA22_PL").val()

            var Ruta23_Name = $("#RUTA23_Name").val();
            var Ruta23_PL = $("#RUTA23_PL").val();

            var datos = {
                request           : 'setRoutesOwners',
                turno               : turno,
                Ruta11_Name  : Ruta11_Name,
                Ruta11_PL       : Ruta11_PL,

                Ruta12_Name  : Ruta12_Name,
                Ruta12_PL       : Ruta12_PL,
                
                Ruta13_Name  : Ruta13_Name,
                Ruta13_PL       : Ruta13_PL,
                
                Ruta14_Name  : Ruta14_Name,
                Ruta14_PL       : Ruta14_PL,
                
                Ruta15_Name  : Ruta15_Name,
                Ruta15_PL       : Ruta15_PL,

                Ruta16_Name  : Ruta16_Name,
                Ruta16_PL       : Ruta16_PL,

                Ruta17_Name  : Ruta17_Name,
                Ruta17_PL       : Ruta17_PL,

                Ruta18_Name  : Ruta18_Name,
                Ruta18_PL       : Ruta18_PL,

                Ruta19_Name  : Ruta19_Name,
                Ruta19_PL       : Ruta19_PL,

                Ruta20_Name  : Ruta20_Name,
                Ruta20_PL       : Ruta20_PL,

                Ruta21_Name  : Ruta21_Name,
                Ruta21_PL       : Ruta21_PL,

                Ruta22_Name  : Ruta22_Name,
                Ruta22_PL       : Ruta22_PL,

                Ruta23_Name  : Ruta23_Name,
                Ruta23_PL       : Ruta23_PL
            }
            
            $.ajax({
                url: 'cont/tolvas_counter.php',
                type: 'POST',
                data: datos,
            })
            .done(function(info) {
                var data = JSON.parse(info);
                //console.log(data);
            })
            .fail(function() {
                //console.log("error");
            })
            .always(function() {
                getGraphic(getTurn(), moment().format('YYYY-MM-DD'));
            });
            
    });
    //setInterval(getGraphic, 60 * 1000);
});

function getReview(turno,fecha){
    $.ajax({
        url: 'cont/tolvas_counter.php',
        type: 'POST',
        data: {
            request: 'getReview',
            turno: turno,
            fecha: fecha
    },
    })
    .done(function(info) {
        var Data = JSON.parse(info);
        //console.log(Data);
        if (Data.length === 0 || Data[0]['Nombre'] === "") {
            $("#review").text("No se ha realizada la revision diaria - "+moment(fecha).format('DD/MM/YYYY'));
        } 
        else {
           $("#review").text(
                "Revision diaria realizada por " + Data[0]["Nombre"] +":"
                
            );
         
           $("#review_list").html("");
           $.each(Data, function(index, val) {
                $("#review_list").append("<li>" + "Revision " + (index + 1) + ": " + moment(val.Fecha.date).format('HH:mm') + "</li>");
                
            });
           //"Dia: " + moment(Data[0]['Fecha']['date']).format('DD/MM/YYYY HH:mm')
        }
    })
    .fail(function() {
        //console.log("error");
    })
    
}

function getRouteOwners(turno){
    $.ajax({
        url: 'cont/tolvas_counter.php',
        type: 'POST',
        data: {  request: 'getRoutesOwners',
                    turno: turno},
    })
    .done(function(info) {
        var datos = JSON.parse(info);
        $("#RUTA11_Name").val(datos[0]['Name']);
        $("#RUTA11_PL").val(datos[0]['ProductionLine'])

        $("#RUTA12_Name").val(datos[1]['Name']);
        $("#RUTA12_PL").val(datos[1]['ProductionLine'])

        $("#RUTA13_Name").val(datos[2]['Name']);
        $("#RUTA13_PL").val(datos[2]['ProductionLine'])

        $("#RUTA14_Name").val(datos[3]['Name']);
        $("#RUTA14_PL").val(datos[3]['ProductionLine'])

        $("#RUTA15_Name").val(datos[4]['Name']);
        $("#RUTA15_PL").val(datos[4]['ProductionLine'])

        $("#RUTA16_Name").val(datos[5]['Name']);
        $("#RUTA16_PL").val(datos[5]['ProductionLine'])

        $("#RUTA17_Name").val(datos[6]['Name']);
        $("#RUTA17_PL").val(datos[6]['ProductionLine'])

        $("#RUTA18_Name").val(datos[7]['Name']);
        $("#RUTA18_PL").val(datos[7]['ProductionLine'])

        $("#RUTA19_Name").val(datos[8]['Name']);
        $("#RUTA19_PL").val(datos[8]['ProductionLine'])

        $("#RUTA20_Name").val(datos[9]['Name']);
        $("#RUTA20_PL").val(datos[9]['ProductionLine'])

        $("#RUTA21_Name").val(datos[10]['Name']);
        $("#RUTA21_PL").val(datos[10]['ProductionLine'])

        $("#RUTA22_Name").val(datos[11]['Name']);
        $("#RUTA22_PL").val(datos[11]['ProductionLine'])

        $("#RUTA23_Name").val(datos[12]['Name']);
        $("#RUTA23_PL").val(datos[12]['ProductionLine']);
            
    })
    .fail(function() {
        //console.log("error");
    })
}

function getTurn(){
    var horaActual =  moment().format('HH:mm');
    if (horaActual >= '06:00' && horaActual<='15:36') {
        return 'A'
    }
    else
    {
        return 'B'
    }
}

function getGraphic(turno,fecha){
    new PNotify({
        title: 'Rutas actualizadas',
        text: 'Se ha actualizado el estatus de las rutas',
        type: 'success',
        styling: 'bootstrap3'
    });
    $.ajax({
        url: 'cont/tolvas_counter.php',
        type: 'POST',
        data: {request: 'getTolvasInfo',
                turno:turno,
                fecha:fecha},
    })
    .done(function(data) {
        var Datos = JSON.parse(data);
        //console.log(Datos);

        google.charts.load('current', { packages: ['corechart'] });
        google.charts.setOnLoadCallback(function() {
            drawChart(Datos);
        });
        getTable(Datos);
    })
    .fail(function() {
        new PNotify({
                        title: 'Error',
                        text: 'Error al obtener los datos',
                        type: 'error',
                        styling: 'bootstrap3'
                    });
    })
}
function getTable(datos){
    //console.log(datos);
    var tabla = $('#tableTolvas').DataTable({
         dom: 'frtlip',
         destroy: true,
         order:[[0, 'asc']],
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
            {data: "Ruta"},
            { data: "Entrada" },
            { data: "Salida" },
            { data: "Vuelta" },
            { data: "Tolvas" },
            { data: "RouteOwner" }
           
                     
            ]
        });
        tabla.rows().remove();   
        tabla.rows.add(datos);
}

function drawChart(data) {
    var options = {
        title: "Tolvas por Ruta y Vuelta",
        height: 900,
        //width:1600,
        annotations: {
            textStyle: {
                fontSize: 20,
            }
        },
        isStacked: true,
        annotations: {
            // Ajustes específicos para la anotación de Vuelta 1
            alwaysOutside: true, // Coloca la anotación siempre fuera de la barra
            datum: {
                role: 'annotation',
                index: 13, // Índice de la columna de datos donde se encuentra la anotación de Vuelta 1
                style: {
                    fontSize: 10, // Tamaño de fuente específico para la anotación de Vuelta 1
                }
            }
        },
        annotations: {
            // Ajustes específicos para la anotación de Vuelta 1
            alwaysOutside: false, // Coloca la anotación siempre fuera de la barra
            datum: {
                role: 'annotation',
                index: 2, // Índice de la columna de datos donde se encuentra la anotación de Vuelta 1
                style: {
                    fontSize: 10, // Tamaño de fuente específico para la anotación de Vuelta 1
                }
            }
        },
        tooltip: { trigger: 'both' },
        hAxis: {
            title: 'Ruta',
            slantedText: false, // Mostrar texto en ángulo
            slantedTextAngle: 90,
            titleTextStyle: {
                fontSize: 14
            },
            textStyle: {
                fontSize: 12
            }
        },
        vAxis: {
            title: 'Tolvas',
            titleTextStyle: {
                fontSize: 14
            },
            textStyle: {
                fontSize: 12
            },
            minValue: 1,
            maxValue: 255,
            gridlines: {
                count: 10
            }
        },
        bar: {
            groupWidth: '90%',
        },
        legend: {
            position: 'top'
        },
        fontName: 'Arial',
        fontSize: '12px',
        colors: ['#FFA07A', '#FFD700', '#87CEEB', '#98FB98', '#FFB6C1', '#FF69B4', '#FF6347', '#9370DB', '#40E0D0', '#FF8C00']
    };

    // Organiza los datos en un formato adecuado para el gráfico de columnas apiladas
    var dataArray = [['Ruta', 'Vuelta 1', 'Vuelta 2',  'Vuelta 3',  'Vuelta 4',  'Vuelta 5',  'Vuelta 6', 'Vuelta 7', 'Vuelta 8', 'Vuelta 9', 'Vuelta 10',   { role: 'annotation' }]];
    var rutas = {}; // Objeto para almacenar las tolvas por ruta y vuelta

    // Itera sobre los datos y organiza las tolvas por ruta y vuelta
    var horario;
    data.forEach(function(item) {

        var ruta = item.Ruta;
        var vuelta = item.Vuelta;
        var tolvas = item.Tolvas;
        var ruteOwner = item.RouteOwner;
        horario = item.Entrada +" - \n"+ item.Salida;
        //console.log(horario)
        if (!rutas[ruta]) {
            rutas[ruta] = {};
        }

        rutas[ruta]['Ruta'] = ruta +' - '+ruteOwner;
        //rutas[ruta]['Horario'] = horario;
        rutas[ruta]['Vuelta ' + vuelta] = tolvas;
    });

    // Agrega las rutas y tolvas al array de datos
    for (var ruta in rutas) {
        var totalTolvas = 0;
        for (var i = 1; i <= 10; i++) {
            totalTolvas += rutas[ruta]['Vuelta ' + i] || 0;
        }
        dataArray.push([
            rutas[ruta]['Ruta'],
            rutas[ruta]['Vuelta 1'] || 0,
            rutas[ruta]['Vuelta 2'] || 0,
            rutas[ruta]['Vuelta 3'] || 0,
            rutas[ruta]['Vuelta 4'] || 0,
            rutas[ruta]['Vuelta 5'] || 0,
            rutas[ruta]['Vuelta 6'] || 0,
            rutas[ruta]['Vuelta 7'] || 0,
            rutas[ruta]['Vuelta 8'] || 0,
            rutas[ruta]['Vuelta 9'] || 0,
            rutas[ruta]['Vuelta 10'] || 0,
            
            totalTolvas // Incluye el total de tolvas como anotación
        ]);
    }

    var data = google.visualization.arrayToDataTable(dataArray);

    var chart = new google.visualization.ColumnChart(document.getElementById('tolvaGraphic'));

    chart.draw(data, options);
}

