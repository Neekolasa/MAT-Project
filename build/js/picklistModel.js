$(document).ready(function(){
	getInfo()
});
function getInfo(){
	$.ajax({
		url: 'cont/picklistController.php',
		type: 'GET',
		data: {request: 'getInfo'},
	})
	.done(function(info) {
		var rest = JSON.parse(info);
		console.log(rest);
		var tabla = $('#tablePicklist').DataTable({
            dom: 'frtlip',
            destroy: true,
            order:[[4, 'asc']],
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
               { data: "PN" },
               {data: "Mtype"},
              { data:"SrvMax" },
              { data: "Activas" },
              { data: "Diferencia" },
              { data: "Location" },
              { data: "Comentario" }        
            ]
        });
        tabla.rows().remove();
                  
               
        tabla.rows.add(rest);
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
	
}