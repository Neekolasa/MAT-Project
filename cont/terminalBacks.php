<?php
	include '../../connection.php';
	if ($_REQUEST['request']=='comeBack') {
		// Recibir variables de la solicitud
		$SerialNumber = $_REQUEST['SerialNumber'];
		$location = $_REQUEST['location'];

		// Array para almacenar resultados de la consulta inicial
		$dataQty = [];

		// Consulta inicial para obtener la cantidad (Qty)
		$sqlInitialStatement = "SELECT Qty FROM ChkBTS_SNDet WHERE SN = '$SerialNumber' AND Action = 'OUT' ORDER BY ActionDate DESC";
		$sql_query = sqlsrv_query($conn, $sqlInitialStatement);

		// Validar la ejecución de la consulta inicial
		/*if ($sql_query === false) {
		    echo json_encode(array('response' => 'error', 'message' => 'Error en la consulta SQL inicial.'));
		    exit;
		}*/

		// Recuperar los resultados de la consulta inicial
		while ($res = sqlsrv_fetch_array($sql_query, SQLSRV_FETCH_ASSOC)) {
		    array_push($dataQty, array('Qty' => $res['Qty']));
		}

		// Verificar que haya al menos un resultado en $dataQty antes de continuar
		if (empty($dataQty)) {
			$dataQty = [];
		    //echo json_encode(array('response' => 'error', 'message' => 'No se encontraron resultados para el numero de serie proporcionado.'));
		    $sqlInitialStatement2 = "SELECT Qty FROM Smk_Inv WHERE SN = '$SerialNumber'";
			$sql_query = sqlsrv_query($conn, $sqlInitialStatement2);
			while ($res = sqlsrv_fetch_array($sql_query, SQLSRV_FETCH_ASSOC)) {
		    		array_push($dataQty, array('Qty' => $res['Qty']));
			}
			
		}



		// Consulta para actualizar el estado
		$sqlStatement = "UPDATE ChkBTS_SNMaster SET Status = 'SMKT' WHERE SN = '$SerialNumber'";
		$location = str_replace("'", "''", $location);
		$sqlStatement2 = "INSERT INTO ChkBTS_SNDet VALUES ('$SerialNumber', 'IN', '$location', GETDATE(), '0.000', '{$dataQty[0]['Qty']}', '0', NULL, NULL, NULL, 'A', 'False',NULL,NULL)";

		// Ejecutar ambas consultas en un bloque de control único
		if (sqlsrv_query($conn, $sqlStatement) && sqlsrv_query($conn, $sqlStatement2)) {
		    // Si ambas consultas se ejecutan correctamente
		   	echo json_encode(array('response' => 'success'));
		    //echo $sqlStatement	;
		} else {
		    // Si alguna de las consultas falla
		    echo json_encode(array('response' => 'error', 'message' => 'Error al ejecutar las consultas.'));
		    //echo $sqlStatement2;
		}
	}

?>