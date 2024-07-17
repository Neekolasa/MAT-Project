function getData() {
			// Show spinner and loading message
			$('#spinner').show();
			$('#loadingMessage').show();
			
			$.ajax({
				url: 'cont/adjustCKT_controller.php',
				type: 'POST',
				data: {request: 'getValues'},
			})
			.done(function(info) {
				var Data = JSON.parse(info);
				console.log(Data);
				// Hide spinner and loading message
				$('#spinner').hide();
				$('#loadingMessage').hide();
				var tabla = $('#tableAjusteCKT').DataTable({
                    dom: 'rtlp',
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
                      {data: "PN"},
                      { data:"Qty"}
                     
                    ]
                });
                tabla.rows().remove();
                  
               
                tabla.rows.add(Data);
			})
			.fail(function() {
				console.log("error");
				// Hide spinner and loading message
				$('#spinner').hide();
				$('#loadingMessage').hide();
			})
		}