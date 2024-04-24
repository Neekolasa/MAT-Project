<?php 
//ini_set('memory_limit','-1');
	include '../../connection.php';

	$request = $_GET['request'];

	if ($request == 'GET') {
		
		echo json_encode(getData('2023-08-10'));
		//echo json_encode("dsdsdsdsd");
		//getData('2023-08-10');
	

	}

	elseif($request == 'Clean'){
		cleanData(Date('Y-m-d'));
	}

	function cleanData($date){
		$serverName = "10.215.156.203\IFV55";
		$connectionInfo = array( 	"Database"=>"SMS",
									"UID"=>"sa", 
									"PWD"=>"System@dm1n"
								);
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( $conn === false ) {
		     die( print_r( sqlsrv_errors(), true));
		}

		//$sql_statement = "SELECT * FROM AuditoriaSloc7 WHERE ScanDate < '$date'";
		$sql_statement = "DELETE FROM AuditoriaSloc7 WHERE ScanDate < '$date'";
		
		$sql_query = sqlsrv_query($conn,$sql_statement);

		if ($sql_query == true) {

			echo json_encode(['response' => 'success']);
		}
		else {
			echo json_encode(['response' => 'fail']);
		}
	}

	function getData($date){
		$serverName = "10.215.156.203\IFV55";
		$connectionInfo = array( 	"Database"=>"SMS",
									"UID"=>"sa", 
									"PWD"=>"System@dm1n"
								);
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( $conn === false ) {
		     die( print_r( sqlsrv_errors(), true));
		}
		$fechaActual = new DateTime();

		// Restar 15 días
		$fechaActual->sub(new DateInterval('P15D'));

		// Obtener la nueva fecha en formato 'Y-m-d'
		$fechaAnterior = $fechaActual->format('Y-m-d');

		//$sql_statement = "SELECT SerialNumber as Serie,Smk_Inv.PN as Material,Smk_Inv.Qty,Location as Localizacion,Smk_Inv.Status as SMK_Status, convert(VARCHAR, ScanDate) as Fecha  FROM AuditoriaSloc7 LEFT JOIN Smk_Inv ON AuditoriaSloc7.SerialNumber = Smk_Inv.SN WHERE ScanDate = '$date'";
		$sql_statement = "SELECT COALESCE(Hy.Qty,0) As Qty, COALESCE(Hy.PN,'0') as Material,Au.SerialNumber As Serie, Au.ScanDate,COALESCE(Au.[Location],'No data') as Localizacion, convert(VARCHAR, Au.ScanDate) as Fecha,COALESCE(Inv.[Status],'NO STORED') As SMK_Status FROM AuditoriaSloc7 Au LEFT JOIN Rcv_SNH Hy ON (Au.SerialNumber = Hy.SN) LEFT JOIN Smk_Inv Inv ON (Au.SerialNumber = Inv.SN) WHERE Au.ScanDate > '$fechaAnterior' ORDER BY ScanDate DESC";
		
		$sql_query = sqlsrv_query($conn,$sql_statement);
		
		$dataAuditoria = array();
		
		while ($data = sqlsrv_fetch_array($sql_query, SQLSRV_FETCH_ASSOC)) {
		    $encodedData = array(
		        "Serie" => $data['Serie'],
		        "Material" => isBlank($data['Material'], ''),
		        "Cantidad" => round(isBlank($data['Qty'], '')),
		        "Localizacion" => (formatearString((isBlank($data['Localizacion'],'')))),
		        "SMK_Status" => isBlank($data['SMK_Status'], 'SMK'),
		        "Fecha" => isBlank($data['Fecha'], '')
		    );

		    // Codificar los caracteres en UTF-8 si es necesario
		    $encodedData = array_map('utf8_encode', $encodedData);

		    array_push($dataAuditoria, $encodedData);
		}
		
		return ($dataAuditoria);
	



		

	}

	function isBlank($index,$data){
		if (!isset($index)){
			
			if ($data == 'SMK')
			{
				return '<b>No Stored</b>';
			}

			else{
				return "<b>No Data</b>";
			}
			
		}
		else{
			if ($index === 'A')
			{
				return "<b style='color:green;'>A</b>";
			}
			elseif ($index === 'O')
			{
				return "<b style='color:orange;'>O</b>";
			}
			elseif ($index === 'E')
			{
				return "<b style='color:red;'>E</b>";
			}
			elseif ($index == "")
			{
				return "<b>No Data</b>";
			}
			else{
				return $index;
			}
			
		}

	}
	function formatearString($string){
		return $string;
	}
	/*function formatearString($cadena) {
    // Verificar si el string contiene solo números
    if (ctype_digit($cadena)) {
        // Añadir ceros a la izquierda y los guiones en las posiciones adecuadas
        $parte1 = str_pad(substr($cadena, 0, 2), 2, '0', STR_PAD_LEFT);
        $parte2 = str_pad(substr($cadena, 2, 2), 2, '0', STR_PAD_LEFT);
        $parte3 = str_pad(substr($cadena, 4, 2), 2, '0', STR_PAD_LEFT);
        $parte4 = str_pad(substr($cadena, 6, 2), 2, '0', STR_PAD_LEFT);
        $cadenaFormateada = $parte1 . '-' . $parte2 . '-' . $parte3 . '-' . $parte4;
        return $cadenaFormateada;
    } else {
        // Si el string no contiene solo números, devolverlo sin cambios
        return $cadena;
    }
}*/
function formatBytes($bytes) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $i = floor(log($bytes, 1024));
    return round($bytes / pow(1024, $i), 2) . ' ' . $units[$i];
}

// Obtener la memoria utilizada al inicio




?>