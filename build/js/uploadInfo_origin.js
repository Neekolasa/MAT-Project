$(document).ready(function(){

$('#upload-info').on('click',function(e){
	e.preventDefault();

	$("#modal_login").modal('show');
	

	


});
$("#ingresar_button").on('click',function(e){
		e.preventDefault();

		var datos = {
			username : $("#username").val(),
			password : $("#password").val()
		}

		if (datos['username']=="" || datos['password']=="") {
			new PNotify({
	                title: 'Alerta',
	                text: 'Llene todos los campos requeridos',
	                type: 'danger',
	                styling: 'bootstrap3'
	            });
		}
		else{
			$.ajax({
				url: 'cont/check_login.php',
				type: 'GET',
				data: datos,
			})
			.done(function(info) {
				Data = JSON.parse(info);
				//console.log(Data);
					if (Data['response']=='success') {
						new PNotify({
			                title: 'Exito!',
			                text: 'Usuario correcto',
			                type: 'success',
			                styling: 'bootstrap3'
			            });
			            $("#username").val("");
						$("#password").val("");
			            $("#modal_login").modal('hide');
						var fileInput = $('#file-upload')[0];

				        if (fileInput.files.length > 0) {
				        	var file = fileInput.files[0];
				            var reader = new FileReader();

				            reader.onload = function(e) {
					            var data = new Uint8Array(e.target.result);
					            var workbook = XLSX.read(data, { type: 'array' });

					            // Supongamos que estamos leyendo la primera hoja del libro de Excel
					            var sheetName = workbook.SheetNames[0];
					            var sheet = workbook.Sheets[sheetName];

					            // Convertir los datos a formato JSON
					             var jsonData = XLSX.utils.sheet_to_json(sheet, {
				                            header: 1,
				                            raw: true,
				                            cellText: false,
				                            cellDates: false,
				                            cellNF: false,
				                            cellFormula: false
				                        });

					            var flatArray = [].concat.apply([], jsonData.map(function(row) {
				                            return row.map(function(cell) {
				                                return String(cell);
				                            });
				                        }));
					            // Mostrar los datos en la consola
					            //console.log('Datos del archivo Excel:', flatArray);

					            console.log(checkDatabase(flatArray));

					           	/*$.ajax({
					            	url: 'cont/getCriticos.php',
					            	type: 'GET',
					            	data: {request: 'insert',
					            			datos: flatArray},
					            })
					            .done(function(data) {
					            	var Data =JSON.parse(data)
					            	//console.log(Data.response);
					            	if(Data.response == 'success'){
					            		new PNotify({
										    title: 'Exito!',
										    text: 'Informacion sobre los criticos del dia cargada',
										    type: 'success',
										    styling: 'bootstrap3'
										});
					            	}

					            	
					            })*/
					            
					            
				        	}

				            reader.readAsArrayBuffer(file);
				        } else {
				                console.log('Por favor, selecciona un archivo Excel antes de hacer clic en Leer Archivo Excel.');
				        }

					}
					else{
						new PNotify({
			                title: 'Error',
			                text: 'Compruebe sus credenciales',
			                type: 'danger',
			                styling: 'bootstrap3'
			            });
					}
				
			});
			
		}
		
	});

function checkDatabase(thisData){
	$.ajax({
		url: 'cont/getCriticos.php',
		type: 'GET',
		data: {datos: thisData}
	})
	.done(function(data) {
		console.log(data);
		
	})
	.fail(function(data){
		
	})
	
}

});