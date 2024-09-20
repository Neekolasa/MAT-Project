$(document).ready(function(){
	getInfo('not_empty');

    $("#vacioCheck").on('click',function(event) {
		event.preventDefault();
		getInfo("empty")
	});

});
function getInfo(status){
	if (status == "empty") {
		$.ajax({
			url: 'cont/inventarioBarriles_controller.php',
			data: {request: status
					 
		},
		})
		.done(function(info) {
			getTable(info);
		})

	}
	else{

		$.ajax({
			url: 'cont/inventarioBarriles_controller.php',
			data: {request: status
					 
		},
		})
		.done(function(info) {
			getTable(info);
			
		})

		
	}

}
function getTable(information){
	var Data = JSON.parse(information)
			//console.log(Data[0])
			if (Data['response']=='success') {
				$('#spinner').hide();
				$('#loadingMessage').hide();
				var tabla = $('#tableBarriles').DataTable({
                    dom: 'frtlip',
                    destroy: true,
                    //order:[[4, 'desc']],
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
                      { data:"SN" },
                      { data: "RestQty" },
                      { data: "Status" },
                      { data: "UoM" },
                      { data: "LastUpdate" },
                      { data: "Mtype"}
                     
                    ]
                });
                tabla.rows().remove();
                  
               
                tabla.rows.add(Data[0]);
				new PNotify({
			                title: 'Exito',
			                text: 'Se ha obtenido la informacion',
			                type: 'success',
			                styling: 'bootstrap3'
			            });
			}
			else{
				new PNotify({
			                title: 'Error',
			                text: 'Ha ocurrido un error al obtener la informacion',
			                type: 'error',
			                styling: 'bootstrap3'
			            });
			}
}
