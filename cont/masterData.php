<?php
	include '../../connection.php';
	$SN = $_GET['SN'];
	$SN_Master = $_GET['MSN'];
	date_default_timezone_set('America/Monterrey');
	//$SN = '';

	//$sqlSelectPN = "SELECT PN FROM Smk_Inv WHERE SN ='$SN'";
	
	//$sqlPnQuery = sqlsrv_query($conn,$sqlSelectPN);
	//$pn = sqlsrv_fetch_array($sqlPnQuery, SQLSRV_FETCH_ASSOC);

	$arrayDatos = array(
		//'PN' => $pn['PN'], 
		'SN' => $SN,
		'MSN' => $SN_Master,
		'scanHour' => date('h:i A', strtotime('-1 hour', strtotime(date("h:i A"))))
	);

	/*$arrayDatos = array(
		'PN' => '3232323232', 
		'SN' => $SN,
		'MSN' => $SN_Master,
		'scanHour' => '12:10'
	);*/

	echo json_encode($arrayDatos);
?>

