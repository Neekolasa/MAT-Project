$(document).ready(function() {
	

		if (GetParameterValues('response')=='mustBeLogged') {
			new PNotify({
			    title: 'Error',
			    text: 'Debe iniciar sesion para esta accion',
			    type: 'error',
			    styling: 'bootstrap3'
			});
		}
		else if(GetParameterValues('response')=='exit'){
			new PNotify({
			    title: 'Exito',
			    text: 'Ha cerrado sesion exitosamente',
			    type: 'success',
			    styling: 'bootstrap3'
			});
		}

	$("#loginButton").on('click', function(event) {
		event.preventDefault();

		
		var username = $("#username").val();
		var password = $("#password").val();

		if (username == "" || password == "") {
			new PNotify({
			    title: 'Error',
			    text: 'Ingrese todos los campos',
			    type: 'error',
			    styling: 'bootstrap3'
			});
		}
		else{
			$.ajax({
				url: 'cont/moverController.php',
				type: 'POST',
				data: {	request: 'getUserInfo',
							username: username,
							password: password
			},
			})
			.done(function(information) {
				var Data = JSON.parse(information);
				console.log(Data)
				if (Data['response']=='success') {
					
					$.ajax({
						url: 'cont/moverController.php',
						type: 'GET',
						data: {	request: 'setGlobal',
									username: Data['information'][0]['username'],
									fullname: Data['information'][0]['fullname']},
					})
					.done(function() {
						if (Data['information'][0]['permission']=='delivery') {
							userLogged = Data['information'][0]['username'];
							fullname = Data['information'][0]['fullname'];
							window.location.replace("http://10.215.156.203/materiales/rutas/mipindex.php?name="+Data['information'][0]['fullname']+"&username="+Data['information'][0]['username']);
							sessionStorage.setItem('userLogged',userLogged);
							sessionStorage.setItem('fullname',fullname);
							sessionStorage.setItem('permission','delivery');
						}
						else if(Data['information'][0]['permission']=='spmk'){
							userLogged = Data['information'][0]['username'];
							fullname = Data['information'][0]['fullname'];
							window.location.replace("http://10.215.156.203/materiales/rutas/mipindex.php?name="+Data['information'][0]['fullname']+"&username="+Data['information'][0]['username']);
							sessionStorage.setItem('userLogged',userLogged);
							sessionStorage.setItem('fullname',fullname);
							sessionStorage.setItem('permission','spmk');
						}
						else{
							userLogged = Data['information'][0]['username'];
							fullname = Data['information'][0]['fullname'];
							window.location.replace("http://10.215.156.203/materiales/rutas/mipindex.php?name="+Data['information'][0]['fullname']+"&username="+Data['information'][0]['username']);
							sessionStorage.setItem('userLogged',userLogged);
							sessionStorage.setItem('fullname',fullname);
							sessionStorage.setItem('permission','send');
						}
					});
					
					
				}
				else{
					new PNotify({
					    title: 'Error',
					    text: 'Compruebe sus credenciales',
					    type: 'error',
					    styling: 'bootstrap3'
					});
				}

				
			});
			
		}


		/* Act on the event */
	});
});


function GetParameterValues(param) {
  var url = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
  for (var i = 0; i < url.length; i++) {
    var urlparam = url[i].split('=');
    if (urlparam[0] == param) {
      return urlparam[1];
    }
  }
}