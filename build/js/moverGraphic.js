$(document).ready(function(){
	createGraphic()
})

function createGraphic() {
    $.ajax({
        url: 'cont/moverController.php',
        data: {request: 'getGraphicData'},
    })
    .done(function(info) {
        var Datos = JSON.parse(info);


        google.charts.load('current', { packages: ['corechart'] });

        google.charts.setOnLoadCallback(function() {
            drawChart(Datos);
        });
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
    
    // Datos de ejemplo (igual que los que proporcionaste)
    
}

function drawChart(data) {
    var options = {
        title: "Movers solicitados al dia",
        height: 600,
        hAxis: {
            title: 'Fecha',
            slantedText: true,
            slantedTextAngle: -45
        },
        vAxis: {
            title: 'Cantidad de Registros',
            minValue: 0
        },
        bar: { groupWidth: '90%' },
        legend: { position: 'none' },
        fontName: 'Arial',
        fontSize: 12,
        colors: ['#76A7FA'], // Color de las barras
        annotations: {
            alwaysOutside: true, // Coloca las anotaciones fuera de las barras
            textStyle: {
                fontSize: 14,
                color: '#000', // Color del texto de las anotaciones
                bold: true // Texto en negrita
            }
        }
    };

    // Organiza los datos en el formato adecuado para Google Charts
    var dataArray = [['Fecha', 'Registros', { role: 'annotation' }]];
    
    // Itera sobre los datos y agrega los registros por fecha
    data.forEach(function(item) {
        dataArray.push([item.Fecha, item.Registros, item.Registros.toString()]);
    });

    var dataTable = google.visualization.arrayToDataTable(dataArray);

    var chart = new google.visualization.ColumnChart(document.getElementById('moverGraphic'));
    chart.draw(dataTable, options);
}
