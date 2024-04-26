<?php
	include '../../connection.php';
	

	$sql = "
	SELECT data_inventario.PartNumber, 
        data_inventario.PartNumber2,
		data_inventario.Description,
        data_inventario.Mtype,
        data_inventario.UOM,
        data_inventario.APW,
        ISNULL(PFEP_Map.R, 0) AS R,
        ISNULL(PFEP_Map.S, 0) AS S,
        ISNULL(PFEP_Map.L, 0) AS L,
        ISNULL(PFEP_Map.P, 0) AS P,
        ISNULL(PFEP_Map.R, 0) + ISNULL(PFEP_Map.S, 0) + ISNULL(PFEP_Map.L, 0) + ISNULL(PFEP_Map.P, 0) AS Location
FROM data_inventario
LEFT JOIN PFEP_Map ON data_inventario.PartNumber2 = PFEP_Map.PN";

/*COMPLETE SQL FILLED BY DATA IN PFEP_MasterV2
$sql = "	SELECT data_inventario.PartNumber, 
        data_inventario.PartNumber2,
		PFEP_MasterV2.Descrip as Description,
        PFEP_MasterV2.MType,
        PFEP_MasterV2.UOM,
        data_inventario.APW,
        ISNULL(PFEP_Map.R, 0) AS R,
        ISNULL(PFEP_Map.S, 0) AS S,
        ISNULL(PFEP_Map.L, 0) AS L,
        ISNULL(PFEP_Map.P, 0) AS P,
        ISNULL(PFEP_Map.R, 0) + ISNULL(PFEP_Map.S, 0) + ISNULL(PFEP_Map.L, 0) + ISNULL(PFEP_Map.P, 0) AS Location
FROM data_inventario
LEFT JOIN PFEP_Map ON data_inventario.PartNumber2 = PFEP_Map.PN JOIN PFEP_MasterV2 ON data_inventario.PartNumber = PFEP_MasterV2.PN";*/

	$sqlQuery = sqlsrv_query($conn, $sql);

	$data_info = array(); // Inicializamos un arreglo para almacenar los datos
	$id = 0;
	while ($data = sqlsrv_fetch_array($sqlQuery, SQLSRV_FETCH_ASSOC)) {
		$id++;
		$description = preg_replace('/[^a-zA-Z0-9 ]/', '', $data['Description']);
		array_push($data_info,array(//'ID'=>$id,
									'PartNumber'=>$data['PartNumber'],
									'PartNumber2'=>$data['PartNumber'],
									'Description'=>$description,
									'Mtype'=>($data['Mtype']),
									'UOM'=>$data['UOM'],
									'APW'=>$data['APW'],
									'R'=>$data['R'],
									'S'=>$data['S'],
									'L'=>$data['L'],
									'P'=>$data['P'],
									'Location'=>$data['Location']));
	    //$data_info[] = $data; // Agregamos cada conjunto de datos al arreglo
	}

	echo json_encode($data_info);
	
?>