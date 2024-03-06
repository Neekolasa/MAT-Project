$(document).ready(function(){
	$('#imprimir').on('click',function(e){
		e.preventDefault();
		contenido = "<table border='2' width = '352' height = '176' cellspading='0' cellpadding='0' bordercolorlight='#00000'>";
		contenido+="<tr>";
		contenido+="<td height='176' width='359' style='line-height: 100%;background-image: url(http://10.215.156.203/materiales/rutas/src/LeftRightArrows/right.png);background-repeat: round;'>";
		contenido+="<img id='image_1' style='position: absolute;margin-top: -88px;margin-left: 118px;'>";
		contenido+="</td>";
		contenido+="</tr>";
		contenido+="</table>";
		$('#content').append(contenido 
			//"<div style='all:unset'><img id='image_1' style='all:unset;position: absolute;margin-left: 210px;'><img src='http://10.215.156.203/materiales/rutas/src/LeftRightArrows/right.png' width='520' height='300'></div>"
			);

		JsBarcode('#image_1','03230402',{
			displayValue: false,
			height: 40,
  			width: 2,
  			margin: 0
		});



		w = window.open('','popup');
		html = $('#content').html();
		$(w.document.body).html(html);
		//$('#image').JsBarcode('Hi!');

		

		//console.log('Imprimiendo etiqueta');



	
		
	});
});