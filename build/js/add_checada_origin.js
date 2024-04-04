var datosIngresados = [];
var reinicioProgramado = null;
var reinicioProgramado2 = null;
var tiempoDeReinicio = 5 * 60 * 1000; // 5 minutos en milisegundos

$(document).ready(function(){

	if (reinicioProgramado2) {
            clearTimeout(refreshPage); // Cancelar el reinicio programado si se agrega un nuevo dato antes de que se cumplan los 5 minutos
        }
        reinicioProgramado2 = setTimeout(refreshPage, tiempoDeReinicio);
	

	$("#num_empleado").focus();

	
	/********************************************************************/
	var lastInputTime = 0;
 	var typingDelay = 100;
 	scan = false;
 	
	$("#num_empleado").on('input',function(e){
		var currentTime = new Date().getTime();
	    if (currentTime - lastInputTime < typingDelay) {
	        scan = true;
	        
	    } else {
	    	scan = false;
	    	//datosIngresados = [];
	    }
	    lastInputTime = currentTime;
	    //console.log(scan);

	});
	$("#num_empleado").on("contextmenu",function(){
       	return false;
    });
	$('#num_empleado').on("cut copy paste",function(e) {
      	e.preventDefault();
   	});

	$("#play").on('click',function(e){
		e.preventDefault();
		var sound = new Howl({
			src: ['http://10.215.156.203/sonido.mp3'],
			//src: ['src/sonido.mp3'],
			autoplay: true,
			html5: true,
			loop: false,
			onend: function() {
				console.log('Finished!');

			}
		});
		sound.play();
		
		//console.log('click');
		 
	});
	/********************************************************************/
	
	$("#add_salida").on('click',function(e){
		e.preventDefault();
	

		num_empleado = cleanString($("#num_empleado").val());
		console.log(num_empleado);
	
		rep = agregarDato(num_empleado);
		/*console.log(num_empleado);
		if (rep) {
			$("#num_empleado").val("");
			console.log(rep)
		}
		else{
			$("#num_empleado").val("");
			console.log(rep)
		}*/

		if (scan && rep) {
			$.ajax({
			url: 'cont/add_checada.php',
			type: 'GET',
			data: {num_empleado: num_empleado,
				   request : 'reg_checada'}
			})
			.done(function(data) {
				//temp_num_empleado = "";
				console.log(data);
				try {
					Datos = JSON.parse(data);
				} catch(e) {
					Datos = {'response':'error'}
					//console.log('try catch');
				}
				
				if(Datos['response']=='success')
				{	
					$("#num_empleado").val("");
					new PNotify({
			                title: 'Chequeo exitoso',
			                text: 'Numero de empleado: '+num_empleado,
			                type: 'success',
			                styling: 'bootstrap3'
			            });
					playSound();
					getTablaChecadas();
					/*var sound = new Howl({
						src: ['http://10.215.156.203/materiales/rutas/src/sonido.mp3'],
						//src: 'src/sonido.mp3',
						autoplay: true,
						html5: true,
						loop: false,
						onend: function() {
					    	console.log('Finished!');

					  	}
					});
					sound.play();*/

				
				}
				else if(Datos['response']=='fail'){
					$("#num_empleado").val("");
					new PNotify({
			                title: 'Error en el chequeo',
			                 text: 'Numero de empleado: '+cleanString(num_empleado),
			                type: 'error',
			                styling: 'bootstrap3'
			            });
				}
				else if (Datos['response']=='error'){
					$("#num_empleado").val("");
					new PNotify({
			                title: 'Error en el chequeo',
			                 text: 'No hay mas salidas para este empleado',
			                type: 'error',
			                styling: 'bootstrap3'
			            });
				}
				//console.log(Datos);


			})
			.fail(function(){
				$("#num_empleado").val("");
				new PNotify({
			                title: 'Error en el chequeo',
			                 text: 'Numero de empleado no existe',
			                type: 'error',
			                styling: 'bootstrap3'
			            });
			});
		}
		else{
			if(!scan){
				$("#num_empleado").val("");
				new PNotify({
			                title: 'Error en el chequeo',
			                 text: 'Debe escanear el numero de empleado',
			                type: 'error',
			                styling: 'bootstrap3'
			            });
				datosIngresados = [];

			}
			if(rep==false){
				$("#num_empleado").val("");
				new PNotify({
			                title: 'Error en el chequeo',
			                 text: 'Ya checo este empleado',
			                type: 'error',
			                styling: 'bootstrap3'
			            });
			}
			
		}
		
		
	});

	

});

function llenarTablaHoy(){
	return 'true';
}
function playSound() {
	var sounds = ['bonk.mp3', 'cuak.mp3'];

    // Seleccionar aleatoriamente un índice del array de sonidos
    var randomIndex = Math.floor(Math.random() * sounds.length);

    // Crear un objeto de sonido con el archivo seleccionado aleatoriamente
    var sound = new Audio('src/' + sounds[randomIndex]);

    // Reproducir el sonido
    sound.play();
}

function cleanString(string){
	return string.replace("C8", "");
	
	
    
}


function agregarDato(dato) {
    if (datosIngresados.length === 0 || !datosIngresados.includes(dato)) {
        datosIngresados = [dato]; // Reemplaza el arreglo con un nuevo arreglo que contiene solo el dato nuevo
        
        if (reinicioProgramado) {
            clearTimeout(reinicioProgramado); // Cancelar el reinicio programado si se agrega un nuevo dato antes de que se cumplan los 5 minutos
        }
        reinicioProgramado = setTimeout(reiniciarArreglo, tiempoDeReinicio);
        
        return true;
    } else {
        return false;
    }
}
function reiniciarArreglo() {
    datosIngresados = [];
    new PNotify({
		title: 'Inactividad',
		text: 'Arreglo reiniciado después de 5 minutos de inactividad.',
		type: 'success',
		styling: 'bootstrap3'
	});

}
function refreshPage(){
 	location.reload();
   
 }