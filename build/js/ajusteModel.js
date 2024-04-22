$(document).ready(function(){
	getAdjustTable();


});

function getAdjustTable(){
	$.ajax({
		url: 'cont/ajusteController.php',
		type: 'POST',
		data: {request: 'getAdjust'},
	})
	.done(function(info) {
		var Data = JSON.parse(info);
		console.log(Data)
		if (Data['response']=='success') {
			new PNotify({
		        title: 'Rutas actualizadas',
		        text: 'Se ha actualizado el estatus de las rutas',
		        type: 'success',
		        styling: 'bootstrap3'
		    });
		   // console.log(Data['data'][0]['ScanDate'].date)

		    var tabla = $('#table_ajuste').DataTable({
                    dom: 'frtlip',
                    destroy: true,
                    order:[[5, 'asc']],
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
                      {data: "PN"},
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