<?php
	include('../../connection.php');
	$material_nombre = $_GET['material_nombre'];

	//echo $material_nombre;
	$sql_request = "SELECT data_inventario.PartNumber AS NP, data_inventario.Description as DESCRIPTION, data_inventario.UOM as UOM, PFEP_MasterV2.StdPack,data_inventario.Mtype as MTYPE, APW AS APW FROM data_inventario JOIN PFEP_MasterV2 on data_inventario.PartNumber = PFEP_MasterV2.PN WHERE PartNumber LIKE '$material_nombre%' AND (data_inventario.Mtype = 'CABLE' OR data_inventario.Mtype = 'BATTERY CABLE' OR data_inventario.Mtype = 'CONDUIT')";

	$sql_query = sqlsrv_query($conn,$sql_request);
	$datos = array();
	while ($data = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
		$datos = $data;		
	}

	echo json_encode($datos);
?>