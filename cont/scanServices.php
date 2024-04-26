<?php
	include '../../connection.php';
	$request = $_REQUEST['request'];

	if ($request == 'services') {
		$numMaterial = $_REQUEST['info'];

		$sql_query ="INSERT INTO servicespart (PN) VALUES('$numMaterial')";
		$sql_execute = sqlsrv_query($conn,$sql_query);
		if ($sql_execute == true) {
			echo json_encode(array('response' => 'success'));
		}
		else{
			echo json_encode(array('response' => 'fail'));
		}
		echo json_encode($sql_execute);

	}


?>