$(document).ready(function(){
	/*if(isUserOnMobile()){
		$(".pc").hide();
	}
	else {
		$(".pc").show();
	}*/


/**************************CALCULO PESO A LONGITUD*******************************/
	$("#material_peso").attr('readonly','readonly');
	$("#material_tara").attr('readonly','readonly');
	
	$("#descripcion").html('-');
	$("#apw").html('-');
	$("#peso_tara").html('');
	$("#metro").html('-');
	$("#feet").html('-');

	
	$("#material_nombre").on('keyup',function(){
		let material_nombre = $("#material_nombre").val();
		//console.log(material_nombre);
		if (material_nombre!='') {
			$("#material_peso").removeAttr('readonly');
			$("#material_tara").removeAttr('readonly');

			$.ajax({
				url: 'cont/conversiones_data.php',
				type: 'GET',
				data: {material_nombre: material_nombre},
			})
			.done(function(data) {

				Datos = JSON.parse(data);
				

				if (Datos.length==0) {
					$("#productos").html('<option>'+Datos['NP']+'</option>');
					$("#descripcion").html('-');
					$("#apw").html('-');
					$("#peso_tara").html('-');
					$("#metro").html('-');
					$("#feet").html('-');

				}
				else{
					$("#descripcion").html(Datos['DESCRIPTION']);
					$("#apw").html(Datos['APW']);
					$("#peso_tara").html('11.6');
					$("#metro").html('-');
					$("#feet").html('-');

				}
				
				

			});

			
			
		}
		else {
			$("#material_peso").attr('readonly','readonly');
			$("#material_tara").attr('readonly','readonly');
			$("#descripcion").html('-');
			$("#apw").html('-');
			$("#peso_tara").html('');
			$("#metro").html('-');
			$("#feet").html('-');	
		}
	});
	$("#material_tara").on('change',function(){
		
		let material_tara = $("#material_tara").val();
		switch (material_tara) {
			case 'NPS':
				peso_tara = 11.6;
				break;
			case 'CARRETE_MADERA_GDE':
				peso_tara = 34.4;
				break;
			case 'BP_NEGRO':
				peso_tara = 19.8;
				break;
			case 'POLIDUCTO':
				peso_tara = 3.5;
				break;
			case 'BP_GRIS':
				peso_tara = 19.4;
				break;
			default:
				break;
			
		}
		$("#peso_tara").html(peso_tara);
		$("#material_peso").keyup();
		//console.log(peso_tara);
	});
	$("#material_peso").on('keyup',function(){

		material_peso = parseFloat($("#material_peso").val());

		if (!isNaN(material_peso)) {
			tara = parseFloat($("#peso_tara").html());
			apw = parseFloat($("#apw").html());
			metro =	(material_peso-tara)/apw;

			$("#metro").html((metro).toFixed(2));
		    
		    feet = metro * 3.28084;
			
			$("#feet").html((feet).toFixed(2));
		}
		else{
			$("#descripcion").html('-');
			$("#metro").html('-');
			$("#feet").html('-');	
		
		}
		
	});



/*************************CALCULO LONGITUD A PESO********************************/
	$("#material_metros_two").attr('readonly','readonly');
	$("#material_tara_two").attr('readonly','readonly');

	$("#descripcion_two").html('-');
	$("#apw_two").html('-');
	$("#peso_tara_two").html('-');
	$("#material_peso_two").html('-');
	$("#feet_two").html('-');

	$("#material_nombre_two").on('keyup',function(){
		let material_nombre = $("#material_nombre_two").val();
		//console.log(material_nombre);
		if (material_nombre!='') {
			$("#material_metros_two").removeAttr('readonly');
			$("#material_tara_two").removeAttr('readonly');

			$.ajax({
				url: 'cont/conversiones_data.php',
				type: 'GET',
				data: {material_nombre: material_nombre},
			})
			.done(function(data) {
				Datos = JSON.parse(data);

				if (Datos.length==0) {
					$("#productos_two").html('<option>'+Datos['NP']+'</option>');
					$("#descripcion_two").html('-');
					$("#apw_two").html('-');
					
					$("#peso_tara_two").html('-');
					$("#material_peso_two").html('-');
					$("#feet_two").html('-');
				}
				else{
					$("#descripcion_two").html(Datos['DESCRIPTION']);
					$("#apw_two").html(Datos['APW']);
					
					$("#peso_tara_two").html('11.6');
					$("#material_peso_two").html('-');
					$("#feet_two").html('-');
				}
				

				//console.log(Datos);

				


			});

			
			
		}
		else {
			$("#material_metros_two").attr('readonly','readonly');
			$("#material_tara_two").attr('readonly','readonly');
			$("#descripcion_two").html('-');
			$("#apw_two").html('-');
			$("#peso_tara").html('-');
			$("#material_peso_two").html('-');
			$("#feet_two").html('-');	
		}
	});

	$("#material_metros_two").on('keyup',function(){

		material_metros = parseFloat($("#material_metros_two").val());

		if (!isNaN(material_metros)) {
			tara = parseFloat($("#peso_tara_two").html());
			apw = parseFloat($("#apw_two").html());
			peso =	(material_metros*apw)+tara;

			$("#material_peso_two").html((peso).toFixed(2));
		    
		    feet = material_metros * 3.28084;
			
			$("#feet_two").html((feet).toFixed(2));
		}
		else{
			$("#descripcion_two").html('-');
			$("#material_metros_two").html('-');
			$("#feet_two").html('-');	
		
		}
		
	});

	$("#material_tara_two").on('change',function(){
		
		let material_tara = $("#material_tara_two").val();
		switch (material_tara) {
			case 'NPS':
				peso_tara = 11.6;
				break;
			case 'CARRETE_MADERA_GDE':
				peso_tara = 34.4;
				break;
			case 'BP_NEGRO':
				peso_tara = 19.8;
				break;
			case 'POLIDUCTO':
				peso_tara = 3.5;
				break;
			case 'BP_GRIS':
				peso_tara = 19.4;
				break;
			default:
				break;
			
		}
		$("#peso_tara_two").html(peso_tara);
		$("#material_metros_two").keyup();
		//console.log(peso_tara);
	});
});