$.ajax({
    url: 'cont/getCriticos.php',
    type: 'GET',
    data: { request: 'getTableCriticos' }
})
.done(function (datos) {
    var Data = JSON.parse(datos);

    // Obtener la instancia de la tabla
    var tc = $('#table_criticos').DataTable({
        dom: 'frtlip',
        destroy: true,
        responsive: true,
        order:[[2, 'desc']],
        language: {
            url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
        },
        buttons: [
            { extend: 'copy', text: 'Copiar al portapapeles', className: "btn btn-primary boton-margen" },
            { extend: 'excel', text: 'Generar excel', className: "btn btn-primary text-light boton-margen" },
            { extend: 'print', text: 'Imprimir documento', className: "btn btn-primary text-light boton-margen" },
            { extend: 'pdf', text: 'Generar PDF', className: "btn btn-primary text-light boton-margen" }
        ],
        className: "center-block",
        columns: [
            { data: "PN" },
            { data: "Serial" },
            { data: "Estatus" }
        ]
    });

    // Limpiar y agregar los nuevos datos
    tc.clear().rows.add(Data).draw();
});

// Configurar una actualización periódica (cada 5 segundos en este caso)
setInterval(function () {
    $.ajax({
        url: 'cont/getCriticos.php',
        type: 'GET',
        data: { request: 'getTableCriticos' }
    })
    .done(function (datos) {
        var Data = JSON.parse(datos);
        //console.log(Data);
        
        var tc = $('#table_criticos').DataTable();

        // Limpiar y agregar los nuevos datos
        tc.clear().rows.add(Data).draw();
    });
}, 60000);
