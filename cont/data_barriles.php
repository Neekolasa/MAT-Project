<?php 
	include '../../connection.php';
	$fecha = $_GET['fecha'];
	$sig_fecha = date("Y-m-d", strtotime($fecha . " +1 day"));


	$sql_statement = "
SELECT
   	(SELECT COUNT(*) FROM ChkBTS_SNDet WHERE Action = 'empty' AND ActionDate >= '$fecha 06:00' AND ActionDate <= '$fecha 15:36') as Empty,
   	(SELECT COUNT(*) FROM ChkBTS_SNDet WHERE Action = 'new' AND ActionDate >= '$fecha 06:00' AND ActionDate <= '$fecha 15:36') as New,
   	(SELECT COUNT(*) FROM ChkBTS_SNDet WHERE Action = 'empty' AND ActionDate >= '$fecha 06:00' AND ActionDate <= '$fecha 15:36') -
   	(SELECT COUNT(*) FROM ChkBTS_SNDet WHERE Action = 'new' AND ActionDate >= '$fecha 06:00' AND ActionDate <= '$fecha 15:36') as Balance,
   	'Turno A' as Turno
UNION ALL
SELECT
   	(SELECT COUNT(*) FROM ChkBTS_SNDet WHERE Action = 'empty' AND ActionDate >= '$fecha 15:37' AND ActionDate <= '$sig_fecha 0:10') as Empty,
   	(SELECT COUNT(*) FROM ChkBTS_SNDet WHERE Action = 'new' AND ActionDate >= '$fecha 15:37' AND ActionDate <= '$sig_fecha 0:10') as New,
   	(SELECT COUNT(*) FROM ChkBTS_SNDet WHERE Action = 'empty' AND ActionDate >= '$fecha 15:37' AND ActionDate <= '$sig_fecha 0:10') -
   	(SELECT COUNT(*) FROM ChkBTS_SNDet WHERE Action = 'new' AND ActionDate >= '$fecha 15:37' AND ActionDate <= '$sig_fecha 0:10') as Balance,
   	'Turno B' as Turno
UNION ALL
SELECT
   	(SELECT COUNT(*) FROM ChkBTS_SNDet WHERE Action = 'empty' AND ActionDate >= '$fecha 0:11' AND ActionDate <= '$fecha 05:59:59') as Empty,
   	(SELECT COUNT(*) FROM ChkBTS_SNDet WHERE Action = 'new' AND ActionDate >= '$fecha 0:11' AND ActionDate <= '$fecha 05:59:59') as New,
   	(SELECT COUNT(*) FROM ChkBTS_SNDet WHERE Action = 'empty' AND ActionDate >= '$fecha 0:11' AND ActionDate <= '$fecha 05:59:59') -
   	(SELECT COUNT(*) FROM ChkBTS_SNDet WHERE Action = 'new' AND ActionDate >= '$fecha 0:11' AND ActionDate <= '$fecha 05:59:59') as Balance,
   	'Turno C' as Turno;";
	//echo $sql_statement;

	$sql_query = sqlsrv_query($conn,$sql_statement);

	$datos = array();
	while ($data = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
		array_push($datos,array('Empty' 	=> $data['Empty'],
								'New' 		=> $data['New'],
								'Balance' 	=> $data['Balance'],
								'Turno' 	=> $data['Turno']));
	}

	echo json_encode($datos);


?>