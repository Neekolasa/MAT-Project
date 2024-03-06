$(document).ready(function(){
	pageScroll();
	$('#titleCriticos').text('Llegadas de material critico FV55 '+ moment().format('DD/MM/YYYY'));
	getCriticalNumbers();
	setInterval(getCriticalNumbers, 60 * 1000)

});
function pageScroll() {
    // Desplaza la página hacia abajo
    window.scrollBy(0, 1);

    // Verifica si hemos llegado al final de la página
    if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
        // Si hemos llegado al final de la página, desplaza suavemente hacia arriba
        scrollToTop();
    } else {
        // Establece un retraso para el próximo scroll hacia abajo
        scrolldelay = setTimeout(pageScroll, 10); // Reducir el valor para una animación más rápida
    }
}

function scrollToTop() {
    // Obtiene la posición actual de desplazamiento vertical
    var currentScroll = document.documentElement.scrollTop || document.body.scrollTop;

    // Si no hemos alcanzado el tope, sigue desplazándote hacia arriba
    if (currentScroll > 0) {
        window.scrollTo(0, currentScroll - 5); // Modifica el valor para un desplazamiento más suave
        setTimeout(scrollToTop, 10); // Reducir el valor para una animación más rápida
    } else {
        // Cuando llegamos al tope, vuelve a llamar a pageScroll para bajar de nuevo
        setTimeout(pageScroll, 10); // Reducir el valor para una animación más rápida
    }
}



function getCriticalNumbers(){
	new PNotify({
                        title: 'Criticos actualizados',
                        text: 'Se ha actualizado el estatus de los criticos',
                        type: 'success',
                        styling: 'bootstrap3'
                    });
	$.ajax({
		url: 'cont/criticosController.php',
		type: 'GET',
		data: {request: 'getList'},
	})
	.done(function(info) {
		var Data = JSON.parse(info);
		//console.log(Data);
            //console.log(Data);
            var tabla = $('#table_criticos').DataTable({
                    dom: 'irtlp',
                    "columnDefs": [
				        {"className": "text-center", "targets": "_all"}
				      ],
                    destroy: true,
                    order:[[3, 'asc']],
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
                    paging: false,
                    columns: [
                      {data: "PN"},
                      { data: "Location" },
                      { data: "Status" },
                      { data: "FechaLlegada" }
                     
                    ]
                });
                tabla.rows().remove();
                  
               
                tabla.rows.add(Data.data);
	})
	.fail(function() {
		console.log("error");
	});
	
}