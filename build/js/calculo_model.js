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



	$("#btn_confirm").on('click', function(event) {
		event.preventDefault();
		var requerimiento_diario = $("#requerimiento").val();
		var requerimiento_hora = requerimiento_diario/9;
		$("#requerimiento_hora").val("Requerimiento por hora = "+requerimiento_hora.toFixed(2));

		var requerimiento_tresH = requerimiento_hora*8;
		$("#requerimiento_tres").val("Requerimiento por tres horas = "+requerimiento_tresH.toFixed(2));

		/*var material_dimenssions = {
			"H" : "0.5",
			"W" : "0.5",
			"D" : "4.5"
		}*/
		var material_dimenssions = {
			"D" : $("#D").val(),
			//"R" : "3",
			"H" : $("#H").val()
		}
		//var material_vol = material_dimenssions["H"] * material_dimenssions["W"] * material_dimenssions["D"];
		var material_vol = Math.PI * ((material_dimenssions["D"] / 2) * (material_dimenssions["D"] / 2)) * material_dimenssions["H"];
		//= 3.1416 * 0.25 * 0.25 * 4.5 
		var MT = {
			"H" : "27.5",
			"W" : "34",
			"L" : "49"
		}
		var JT = {
			"H" : "17",
			"W" : "34",
			"L" : "49"
		}
		var S2 = {
			"H" : "15",
			"W" : "22.4",
			"L" : "13.5"
		}
		var S4 = {
			"H" : "13.5",
			"W" : "11.3",
			"L" : "22"
		}
		var S8 = {
			"H" : "15",
			"W" : "7.5",
			"L" : "12.5"
		}
		var tolvaVol = {
			"MT": MT["H"]*MT["W"]*MT["L"],
			"JT" : JT["H"]*JT["W"]*JT["L"],
			"8S" : S8["H"]*S8["W"]*S8["L"],
			"4S" : S4["H"]*S4["W"]*S4["L"],
			"2S" : S2["H"]*S2["W"]*S2["L"]
		}
		
		max_materialMT_Tolva = ((tolvaVol["MT"]/material_vol)*.2075);
		max_materialJT_Tolva = ((tolvaVol["JT"]/material_vol)*.2075);
		max_material8S_Tolva = ((tolvaVol["8S"]/material_vol)*.2075);
		max_material4S_Tolva = ((tolvaVol["4S"]/material_vol)*.2075);
		max_material2S_Tolva = ((tolvaVol["2S"]/material_vol)*.2075);

		$("#MT").text("Piezas maximas en Tolva MT = " +Math.round(max_materialMT_Tolva.toFixed(2)));
		$("#JT").text("Piezas maximas en Tolva JT = " +Math.round(max_materialJT_Tolva.toFixed(2)));
		$("#8S").text("Piezas maximas en Tolva 8S = " +Math.round(max_material8S_Tolva.toFixed(2)));
		$("#4S").text("Piezas maximas en Tolva 4S = " +Math.round(max_material4S_Tolva.toFixed(2)));
		$("#2S").text("Piezas maximas en Tolva 2S = " +Math.round(max_material2S_Tolva.toFixed(2)));
		
		
		var diff_MT = Math.abs(requerimiento_tresH - max_materialMT_Tolva);
		var diff_JT = Math.abs(requerimiento_tresH - max_materialJT_Tolva);
		var diff_2S = Math.abs(requerimiento_tresH - max_material2S_Tolva);
		var diff_4S = Math.abs(requerimiento_tresH - max_material4S_Tolva);
		var diff_8S = Math.abs(requerimiento_tresH - max_material8S_Tolva);

		// Encontramos la menor diferencia
		var minDiff = Math.min(diff_MT, diff_JT, diff_2S, diff_4S, diff_8S);

		// Elegimos la tolva cuyo límite esté más cerca de requerimiento_tresH
		if (minDiff === diff_MT) {
		    $("#tolva").val("Tolva óptima MT");
		} else if (minDiff === diff_JT) {
		    $("#tolva").val("Tolva óptima JT");
		} else if (minDiff === diff_2S) {
		    $("#tolva").val("Tolva óptima 2S");
		} else if (minDiff === diff_4S) {
		    $("#tolva").val("Tolva óptima 4S");
		} else {
		    $("#tolva").val("Tolva óptima 8S");
		}
	});
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