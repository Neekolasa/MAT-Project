$(document).ready(function(){

	$("#config").on('click',function(e){
		e.preventDefault();
		//console.log('config');
		//$("#modal_acciones").modal('show');
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
						$("#modal_actions").modal('show');

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

	$("#reg_horario").on('click',function(e){
		e.preventDefault();
		$("#modal_actions").modal('hide');
		$("#modal_agregar").modal('show');
	});

	$("#del_horario").on('click',function(e){
		e.preventDefault();
		$("#modal_actions").modal('hide');
		$("#del_modal").modal('show');

	});

	$("#edit_horario").on('click',function(e){
		e.preventDefault();
		$("#modal_actions").modal('hide');
		$("#edit_modal").modal('show');

	});

	$("#add_admin").on('click',function(e){
		e.preventDefault();
		$("#modal_actions").modal('hide');
		$("#modal_administrator").modal('show');
	});

	


	$("#insertar_horario").on('click',function(e){
		e.preventDefault();
		

		var datos = {
			num_empleado 	: cleanString($("#add_num_empleado").val()),
			nombre_empleado : $("#nombre_empleado").val(),
			salida_almuerzo : $("#salida_almuerzo").val(),
			salida_comida 	: $("#salida_comida").val(),
			area_emp		: $("#area_emp").val(),
			turno_checada : $("#turno_checada").val(),
			request 		: 'register'
		}
		//console.log(datos);
		if(datos['num_empleado'] == "" || datos['nombre_empleado']  == "" || datos['salida_almuerzo'] == ""
			|| datos['salida_comida'] == "" )
		{
			new PNotify({
	                title: 'Alerta',
	                text: 'Llene todos los campos requeridos',
	                type: 'danger',
	                styling: 'bootstrap3'
	            });
		}
		else {
			Swal.fire({
			  title: 'Confirmar',
			  text: "Quiere agregar este nuevo usuario?",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Agregar',
			  cancelButtonText: "Cancelar",
			}).then((result) => {
			  if (result.isConfirmed) {
			    $.ajax({
					url: 'cont/add_checada.php',
					type: 'GET',
					data: datos,
				})
				.done(function(info) {
					Data = JSON.parse(info);
					if (Data['response']=='success') {
						new PNotify({
			                title: 'Exito!',
			                text: 'Se ha agregado un nuevo horario',
			                type: 'success',
			                styling: 'bootstrap3'
			            });
			            getTablaChecadas();
			            $("#add_num_empleado").val("");
			            $("#nombre_empleado").val("");

					}
					else{
						new PNotify({
			                title: 'Error',
			                text: 'Ha ocurrido un error durante la solicitud',
			                type: 'danger',
			                styling: 'bootstrap3'
			            });
					}
				});
			  }
			});
			
			
			
		}
		//console.log(datos);
	});

	$("#delete_button").on('click',function(e){
		e.preventDefault();

		var datos = {
			num_empleado : cleanString($("#num_empleado_del").val()),
			request : 'delete'
		}
		if (datos['num_empleado']=="") {
			new PNotify({
	                title: 'Alerta',
	                text: 'Llene todos los campos requeridos',
	                type: 'danger',
	                styling: 'bootstrap3'
	            });
		}
		else{
			Swal.fire({
			  title: 'Confirmar',
			  text: "Desea eliminar este horario? No podra recuperarlo",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Si, eliminar!',
			  cancelButtonText: "Cancelar",
			}).then((result) => {
			  if (result.isConfirmed) {
			    $.ajax({
					url: 'cont/add_checada.php',
					type: 'GET',
					data: datos,
				})
				.done(function(info) {
					Data = JSON.parse(info);
					if (Data['response']=='success') {
						new PNotify({
			                title: 'Exito!',
			                text: 'Se ha elminado este horario',
			                type: 'success',
			                styling: 'bootstrap3'
			            });
			            getTablaChecadas();
			            $("#num_empleado_del").val("");
			           

					}
					else{
						new PNotify({
			                title: 'Error',
			                text: 'Ha ocurrido un error durante la solicitud',
			                type: 'danger',
			                styling: 'bootstrap3'
			            });
					}
				});
			  }
			});

		}
		//console.log(datos);
	});

	$("#num_empleado_edit").on('keyup',function(e){
		var data = {
			num_empleado : cleanString($("#num_empleado_edit").val()),
			request : 'getData'
		}
		
		$.ajax({
			url: 'cont/checada_opts.php',
			type: 'GET',
			data: data
		})
		.done(function(data) {
			Datos = JSON.parse(data)
			//console.log(Datos['User'][0].Nombre);
			$("#nombre_empleado_edit").val(Datos['User'][0].Nombre);
			$("#salida_almuerzo_edit").html('');
			$("#salida_almuerzo_edit").append("<option value='"+Datos['User'][0].IDDesayuno+"'>"+Datos['User'][0].TiempoSalidaDesayuno+" - "+Datos['User'][0].TiempoEntradaDesayuno+"</option>");
			$("#salida_comida_edit").html('');
			$("#salida_comida_edit").append("<option value='"+Datos['User'][0].IDComida+"'>"+Datos['User'][0].TiempoSalidaComida+" - "+Datos['User'][0].TiempoEntradaComida+"</option>");
			
			$.ajax({
				url: 'cont/checada_opts.php',
				type: 'GET',
				data: {request: 'GETOPTS'},
			})
			.done(function(info) {
				Data = JSON.parse(info);

			
				$.each(Data['Desayuno'], function(index, val) {
					if (Datos['User'][0].IDDesayuno==val['ID']) {

					}
					else{
						$("#salida_almuerzo_edit").append("<option value='"+val['ID']+"'>"+val['TiempoSalida']+" - "+val['TiempoEntrada']+"</option>");
				
					}
				});


				$.each(Data['Comida'], function(index, val) {
					if (Datos['User'][0].IDComida==val['ID']) {
						// statement
					}
					else{
						$("#salida_comida_edit").append("<option value='"+val['ID']+"'>"+val['TiempoSalida']+" - "+val['TiempoEntrada']+"</option>");
				
					}
				});
			

			});

			if (Datos['User'][0].Area=="Ruta Interna") {
				$('#area_emp_edit option:eq(0)').prop('selected', true);
			}
			else{
				$('#area_emp_edit option:eq(1)').prop('selected', true)
			}
		});
		
	});

	$("#edit_button").on('click',function(e){
		e.preventDefault();
		var datos = {
			num_empleado 	: cleanString($("#num_empleado_edit").val()),
			nombre_empleado : $("#nombre_empleado_edit").val(),
			salida_almuerzo : $("#salida_almuerzo_edit").val(),
			salida_comida 	: $("#salida_comida_edit").val(),
			area_emp		: $("#area_emp_edit").val(),
			turno_checada : $("#turno_checada").val(),
			request 		: 'update'
		}
		//console.log(datos);
		if(datos['num_empleado_edit'] == "" || datos['nombre_empleado_edit']  == "" || datos['salida_almuerzo_edit'] == ""
			|| datos['salida_comida_edit'] == "" )
		{
			new PNotify({
	                title: 'Alerta',
	                text: 'Llene todos los campos requeridos',
	                type: 'danger',
	                styling: 'bootstrap3'
	            });
		}
		else {
			Swal.fire({
			  title: 'Confirmar',
			  text: "Quiere actualizar este usuario?",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Actualizar!',
			  cancelButtonText: "Cancelar",
			}).then((result) => {
			  if (result.isConfirmed) {
			    $.ajax({
					url: 'cont/add_checada.php',
					type: 'GET',
					data: datos,
				})
				.done(function(info) {
					Data = JSON.parse(info);
					if (Data['response']=='success') {
						new PNotify({
			                title: 'Exito!',
			                text: 'Se ha actualizado este horario',
			                type: 'success',
			                styling: 'bootstrap3'
			            });
			            getTablaChecadas();
			            cleanString($("#num_empleado_edit").val(""));
			            $("#nombre_empleado_edit").val("");

					}
					else{
						new PNotify({
			                title: 'Error',
			                text: 'Ha ocurrido un error durante la solicitud',
			                type: 'danger',
			                styling: 'bootstrap3'
			            });
					}
				});
			  }
			});
			
			
			
		}

	});

	$("#reg_admin").on('click',function(e){
		e.preventDefault();
		var datos = {
			num_empleado : "",
			username : $("#username_admin").val(),
			password : $("#password_admin").val(),
			request : 'reg_admin'
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
			Swal.fire({
			  title: 'Confirmar',
			  text: "Quiere agregar este usuario?",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Agregar!',
			  cancelButtonText: "Cancelar",
			}).then((result) => {
			  if (result.isConfirmed) {
			    $.ajax({
					url: 'cont/add_checada.php',
					type: 'GET',
					data: datos,
				})
				.done(function(info) {
					Data = JSON.parse(info);
					if (Data['response']=='success') {
						new PNotify({
			                title: 'Exito!',
			                text: 'Se ha agregado un nuevo admin',
			                type: 'success',
			                styling: 'bootstrap3'
			            });
			            $("#username_admin").val("");
			            $("#password_admin").val("");

					}
					else{
						new PNotify({
			                title: 'Error',
			                text: 'Ha ocurrido un error durante la solicitud',
			                type: 'danger',
			                styling: 'bootstrap3'
			            });
					}
				});
			  }
			});
		}
	})

});
function cleanString(string){

	return string.replace("C8", "");
    
}