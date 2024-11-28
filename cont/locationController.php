<?php
	include '../../connection.php';

	$partNumber = $_REQUEST['partNumber'];

	$sqlStatement = "SELECT 
	                    ISNULL(PFEP_Map.R + PFEP_Map.S + PFEP_Map.L + PFEP_Map.P, 'No Location') AS newLoc, 
	                    ISNULL(PFEP_Map_Mirror.R + PFEP_Map_Mirror.S + PFEP_Map_Mirror.L + PFEP_Map_Mirror.P, 'No Location') AS oldLoc 
	                 FROM PFEP_Map 
	                 FULL JOIN PFEP_Map_Mirror ON PFEP_Map.PN = PFEP_Map_Mirror.PN 
	                 WHERE PFEP_Map.PN LIKE '%$partNumber%'";

	$sqlQuery = sqlsrv_query($conn, $sqlStatement);

	// Inicializamos un arreglo para la respuesta
	$response = array();

	if ($sqlQuery === false) {
	    $response['response'] = 'error';
	    $response['message'] = 'Error executing query';
	} else {
	    $resultData = array();
	    while ($row = sqlsrv_fetch_array($sqlQuery, SQLSRV_FETCH_ASSOC)) {
	        $resultData[] = $row;
	    }
	    
	    if (count($resultData) > 0) {
	        $response['response'] = 'success';
	        $response['data'] = $resultData;
	    } else {
	        // Si no hay resultados
	        $response['response'] = 'success';
	        $response['data'][] = array('oldLoc' => 'No Location', 'newLoc' => 'No Location');
	    }
	}

	// Enviar la respuesta en formato JSON
	echo json_encode($response);



?>