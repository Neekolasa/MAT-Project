<?php 
	include '../../connection.php';
	$request = $_REQUEST['request'];

	if ($request == 'update') {
	    $numbers = json_decode($_REQUEST['results']);

	    $sql_statement = "INSERT INTO numerosCriticos (PN, Status) VALUES (?, 'PENDIENTE')";
	    $sql_cleanTable = "DELETE FROM numerosCriticos";

	    $sql_CleanQuery = sqlsrv_query($conn, $sql_cleanTable);

	    foreach ($numbers as $key => $number) {
	        $params = array($number);
	        
	        $sqlsrv_query = sqlsrv_query($conn, $sql_statement, $params);
	        
	        if (!$sqlsrv_query) {
	            echo json_encode(array("response" => "error", "message" => "Error al insertar número: $number"));
	            exit(); 
	        }
	    }

	    echo json_encode(array("response" => "success"));
	}
	elseif ($request == 'updateV2') {
		$numbers = json_decode($_REQUEST['results']);

		$sql_statement = "INSERT INTO numerosCriticos (PN, Status, DOH, ETA) VALUES (?, ?, ?, ?)";
		$sql_cleanTable = "DELETE FROM numerosCriticos";

		$sql_CleanQuery = sqlsrv_query($conn, $sql_cleanTable);

		foreach ($numbers as $key) {
		    // Usar "?" como marcador de posición para los valores que se insertarán con la consulta preparada
		    $params = array($key->PN, "PENDIENTE", $key->DOH, $key->ETA);
		    
		    $sqlsrv_query = sqlsrv_query($conn, $sql_statement, $params);
		    
		    if (!$sqlsrv_query) {
		        echo json_encode(array("response" => "error", "message" => "Error al insertar número: " . $key->PN));
		        exit(); 
		    }
		}

		echo json_encode(array("response" => "success"));
	}

?>