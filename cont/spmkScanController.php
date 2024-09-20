<?php 
	include '../../connection.php';
	if ($_REQUEST['request']=='insertScan') {
		$snScanner = $_REQUEST['snScanner'];
		$locScanner = $_REQUEST['locScanner'];

		$sqlStatement = "INSERT INTO AuditoriaSloc7 VALUES ('$snScanner',GETDATE(),'$locScanner')";

		$sqlQuery = sqlsrv_query($conn,$sqlStatement);

		if ($sqlQuery) {
			echo json_encode(array('response' => 'success'));
		}
		else{
			echo json_encode(array('response' => 'error'));
		}

		
	}
?>