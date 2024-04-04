$(document).ready(function(){
	
 var dataRegistry = [];

    $('#PNSN_Master').keypress(function (event) {
        if (event.which === 13) {
            var SNPN_Master = $('#PNSN_Master').val().trim();
            var SN_Master = $('#SN_Master').val().trim();

            if (SNPN_Master !== '' && SN_Master !== '') {
                var currentTime = new Date();
                currentTime.setHours(currentTime.getHours());
                var formattedTime = currentTime.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });

                var data = {
                    'SN': SNPN_Master,
                    'MSN': SN_Master,
                    'scanHour': formattedTime
                };

                // Verificar si el dato ya existe en el registro
                var existingIndex = dataRegistry.findIndex(function (item) {
                    return item.SN === data.SN && item.MSN === data.MSN;
                });

                if (existingIndex !== -1) {
                    // Eliminar fila existente en la tabla
                    var masterTable = $('#master').DataTable();
                    masterTable.row(existingIndex).remove().draw(false);

                    // Eliminar dato existente del registro
                    dataRegistry.splice(existingIndex, 1);
                }

                // Agregar nuevo dato a la tabla y al registro
                addData(data);
                dataRegistry.push(data);

                // Limpiar los campos de entrada
                $('#PNSN_Master').val('');
               
            }
        }
    });

    // Resto de tu código...
});

function addData(data){
	var master = $('#master').DataTable({
		dom: 'frtlip',
		destroy: true,
		responsive: true,
			
		language: {
	       	url: 'http://10.215.156.203/materiales/rutas/build/traduccion.json',
	   		},
	   	columns: [
			//{ data: "PN" },
			{ data: "SN" },
			{ data: "MSN" },
			{ data: "scanHour" }  
		]
	});
	
	master.row.add(data);
	
	//console.log(data);
}