$(document).ready(function(){
	//pageScroll();
    
    getCriticalNumbers();
	$('#titleCriticos').text('Llegadas de material critico FV55 '+ moment().format('DD/MM/YYYY'));
	
	setInterval(getCriticalNumbers, 60 * 1000);

    $('#newUpload-info').on('click', function(event) {
        event.preventDefault();
        var fileInput = $('#file-upload')[0];
        if (fileInput.files.length>0) {
            var file = fileInput.files[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                var data = new Uint8Array(e.target.result);
                var workbook = XLSX.read(data, { type: 'array' });

                var columnData = [];

               
                [workbook.Sheets[workbook.SheetNames[1]], workbook.Sheets[workbook.SheetNames[2]]].forEach(function(worksheet) {
                    var range = XLSX.utils.decode_range(worksheet['!ref']);
                    for (var i = 2; i <= range.e.r; ++i) {
                        var cellAddress = 'D' + (i + 1);
                        var cell = worksheet[cellAddress];
                        if (cell && cell.v) {
                          
                            
                            columnData.push(cell.v.toString());
                            
                            
                        }
                    }
                });
                sendResults(columnData);
            };

            reader.readAsArrayBuffer(file);
        }
    });



});

// Función para detener el scroll
function stopScroll() {
    clearTimeout(scrolldelay); // Limpia el temporizador actual
    scrollEnabled = false; // Deshabilita el scroll
}

// Función para reanudar el scroll después de 2 minutos de inactividad
function resumeScroll() {
    scrollEnabled = true; // Habilita el scroll
    pageScroll(); // Reinicia el scroll
}

function pageScroll() {
    if (scrollEnabled) {
        window.scrollBy(0, 1); // Desplaza la página hacia abajo
        if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
            scrollToTop();
        } else {
            scrolldelay = setTimeout(pageScroll, 20); // Establece un retraso para el próximo scroll hacia abajo
        }
    }
}

// Función para animar el scroll hacia arriba
function scrollToTop() {
    if (scrollEnabled) {
        var currentScroll = document.documentElement.scrollTop || document.body.scrollTop;
        if (currentScroll > 0) {
            window.scrollTo(0, currentScroll - 20); // Modifica el valor para un desplazamiento más suave
            setTimeout(scrollToTop, 20); // Establece un retraso para el próximo scroll hacia arriba
        } else {
            setTimeout(pageScroll, 20); // Cuando llegamos al tope, vuelve a llamar a pageScroll para bajar de nuevo
        }
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

function sendResults(results) {
    $.ajax({
        url: 'cont/updateCriticals.php',
        type: 'POST', 
        dataType: 'json',
        data: {
                    results: JSON.stringify(results),
                    request: 'update',
                   },
    })
    .done(function(response) {
        
        if (response['response']=='success') {
            new PNotify({
                title: 'Exito',
                text: 'Informacion de criticos actualizada',
                type: 'success',
                styling: 'bootstrap3'
            });
            getCriticalNumbers();
        }
        else{
            new PNotify({
                title: 'Error',
                text: response['message'],
                type: 'error',
                styling: 'bootstrap3'
            });
        }     
        //console.log(response['response']);
     
    }).fail(function(){
      new PNotify({
              title: 'Error',
              text: 'Ah ocurrido un error, verifique la informacion',
              type: 'error',
              styling: 'bootstrap3'
          });
    });    
}