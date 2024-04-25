$(document).ready(function(){
	/*if(isUserOnMobile()){
		$(".pc").hide();
	}
	else {
		$(".pc").show();
	}*/

	$("#insertar_material").on('click',function(e){
		e.preventDefault();

		num_material = $("#num_material").val();
		awp_material = $("#apw_material").val();

		descripcion_material = $("#descripcion_material").val();
		medida_material = $("#medida_material").val();
		std_pack = $("#std_pack").val();
		mtype_material = $("#mtype_material").val();

		if (num_material.length==0 || awp_material.length==0) {
		
			new PNotify({
                title: 'Ha ocurrido un error',
                text: 'Ingrese un numero de parte o APW valido',
                type: 'error',
                styling: 'bootstrap3'
            });
		}
		else{
			let datos = {
				num_material: num_material,
				awp_material: awp_material,
				descripcion_material: descripcion_material,
				medida_material: medida_material,
				std_pack: std_pack,
				mtype_material: mtype_material

			}


			$.ajax({
				url: 'cont/add_material.php',
				type: 'GET',
				data: datos,
			})
			.done(function(data) {
				if (data == '1') {
					new PNotify({
		                title: 'Insercion correcta',
		                text: 'Se agrego un nuevo material a la base de datos',
		                type: 'success',
		                styling: 'bootstrap3'
		            });

		            $("#modal_agregar").modal('hide');

		            $("#num_material").val("");
					$("#apw_material").val("");

					$("#descripcion_material").val("");
					
					$("#std_pack").val("");
					$("#mtype_material").val("");


				}
				else{
					new PNotify({
		                title: 'Ha ocurrido un error',
		                text: 'Numero de parte ya existe en Base de Datos',
		                type: 'error',
		                styling: 'bootstrap3'
            		});
				}	
			});
			
		}
		



	});
});