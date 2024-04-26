<?php 
	include '../../connection.php';
	$num_material 		= strtoupper($_GET['num_material']);
	$awp_material 		= $_GET['awp_material'];
	$medida_material 	= $_GET['medida_material'];
	$std_pack 			= $_GET['std_pack'];
	$mtype_material 	= strtoupper($_GET['mtype_material']);
	$descripcion_material = strtoupper($_GET['descripcion_material']);

	$sql_request = "
	IF NOT EXISTS (SELECT 1 FROM calculo_cable WHERE NP = '$num_material') 
	BEGIN
    INSERT INTO calculo_cable(NP,DESCRIPTION,UOM,STDPACK,MTYPE,APW) VALUES (
				'$num_material',
				'$descripcion_material',
				'$medida_material',
				'$std_pack',
				'$mtype_material',
				'$awp_material');
	END
	ELSE
	BEGIN
	    PRINT 'false';
	END";


	$sql_query = sqlsrv_query($conn,$sql_request);

	if ($sql_query) {
		echo true;
	}
	else {
		echo false;
	}
	


?>