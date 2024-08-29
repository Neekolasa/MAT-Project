<?php
	include('../../connection.php');
	$material_nombre = $_GET['material_nombre'];

	// Construcción de la consulta SQL
	$sql_request = "SELECT PFEP_MasterV2.PN AS NP, PFEP_MasterV2.Descrip as DESCRIPTION, PFEP_MasterV2.UoM as UOM, PFEP_MasterV2.StdPack, PFEP_MasterV2.Mtype as MTYPE, PFEP_MasterV2.Weight_Gr/1000 AS APW 
	                FROM PFEP_MasterV2 
	                WHERE PN LIKE '$material_nombre%' 
	                AND (PFEP_MasterV2.Mtype = 'CABLE' OR PFEP_MasterV2.Mtype = 'BATTERY CABLE' OR PFEP_MasterV2.Mtype = 'CONDUIT')";

	// Ejecución de la consulta SQL
	$sql_query = sqlsrv_query($conn, $sql_request);

	// Inicialización del arreglo de datos
	$datos = array();

	// Iteración sobre los resultados de la consulta
	while ($data = sqlsrv_fetch_array($sql_query, SQLSRV_FETCH_ASSOC)) {
	    // Aplicar utf8_decode a cada valor del arreglo asociativo
	    $data_decoded = array_map('utf8_decode', $data);
	    $datos[] = $data_decoded;
	}

	// Codificación de los datos en formato JSON y envío al cliente
	echo json_encode($datos);
?>