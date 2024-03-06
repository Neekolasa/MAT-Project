$(document).ready(function(){
	$("#downloadTemplate").on('click', function(event) {
	      event.preventDefault();
	      var ruta = "templates/ExampleRequerimiento.xlsx";
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

	                results.push(obj);
	            }
	            
	            // Llamar a la función que realiza la solicitud AJAX dentro del onload del FileReader
	            
	            sendResults(results);
	        };

	        reader.readAsArrayBuffer(file);
	    } else {
	        new PNotify({
	                        title: 'Error',
	                        text: 'Debe seleccionar un archivo',
	                        type: 'error',
	                        styling: 'bootstrap3'
	                    });
	    }
	});



	/*$("#btn_confirm").on('click', function(event) {
		event.preventDefault();
		var requerimiento_diario = $("#requerimiento").val();
		var requerimiento_hora = requerimiento_diario/9;
		$("#requerimiento_hora").val("Requerimiento por hora = "+requerimiento_hora.toFixed(2));

		var requerimiento_tresH = requerimiento_hora*3;
		$("#requerimiento_tres").val("Requerimiento por tres horas = "+requerimiento_tresH.toFixed(2));

		var material_dimenssions = {
			"H" : "0.25",
			"W" : "0.50",
			"D" : "10"
		}
		var material_vol = material_dimenssions["H"] * material_dimenssions["W"] * material_dimenssions["D"];

		var tolva = {
			"8S" : "1406.25",
			"4S" : "3271.744",
			"2S" : "9201.94"
		}
		
		max_material8S_Tolva = tolva["8S"]/material_vol;
		max_material4S_Tolva = tolva["4S"]/material_vol;
		max_material2S_Tolva = tolva["2S"]/material_vol;

		$("#8S").text("Piezas maximas en Tolva 8S = " +max_material8S_Tolva.toFixed(2));
		$("#4S").text("Piezas maximas en Tolva 4S = " +max_material4S_Tolva.toFixed(2));
		$("#2S").text("Piezas maximas en Tolva 2S = " +max_material2S_Tolva.toFixed(2));
		
		
		if (requerimiento_tresH<=max_material8S_Tolva && requerimiento_tresH<max_material4S_Tolva) {
			$("#tolva").val("Tolva optima 8S");
		}
		else if(requerimiento_tresH>=max_material4S_Tolva && requerimiento_hora<max_material8S_Tolva){
			$("#tolva").val("Tolva optima 4S");
		}
		else{
			$("#tolva").val("Tolva optima 2S");
		}
	});*/
});

function sendResults(results) {
	

    $.ajax({
        url: 'cont/calculoController.php',
        type: 'POST', 
        dataType: 'json',
        data: { results: JSON.stringify(results),
        			request: 'processData' },
    })
    .done(function(response) {
    	
    	new PNotify({
              title: 'Exito',
              text: 'Obteniendo informacion de tolvas',
              type: 'success',
              styling: 'bootstrap3'
          });

    	var tabla = $('#tableTolvas').DataTable({
		    dom: 'frtlip',
		    destroy: true,
		    responsive: true,
		    buttons: [
		        {extend :'copy', text: 'Copiar al portapapeles',className:"btn btn-primary boton-margen", attr:  { id: 'jkjk' }},
		        {extend :'excel', text: 'Generar excel',className:"btn btn-primary text-light boton-margen"},
		        {extend :'print', text: 'Imprimir documento',className:"btn btn-primary text-light boton-margen"},
		        {extend :'pdf', text: 'Generar PDF',className:"btn btn-primary text-light boton-margen"}
		    ],
		    language: {
		        url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
		    },
		    className: "center-block",
		    columns: [
		        { data: "PN" },
		        { data: "Horas_por_cubrir" },
		        { data: "Requerimiento_Diario" },
		        { data: "Requerimiento_por_hora" },
		        { data: "Requerimiento_Constante" },
		        { data: "ContType" },
		        { data: "Qty" }
		    ]
		});
        tabla.rows().remove();
                  
               
        tabla.rows.add(response);
    }).fail(function(){
    	new PNotify({
              title: 'Error',
              text: 'Ocurrio un error al obtener la informacion',
              type: 'error',
              styling: 'bootstrap3'
          });
    });   
}
function downloadFile(url) {
        var link = $("<a>");
        link.attr("href", url)
            .attr("download", "ExampleRequerimiento.xlsx")
            .appendTo("body");
        link[0].click();
        link.remove();
}