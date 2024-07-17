<?php 
	include '../../connection.php';
	$request = $_REQUEST['request'];
	if ($request == "getData") {
		$SNMaster = $_REQUEST['snMaster'];
		$params = array($SNMaster);
		$sqlStatement = "SELECT Id, 'S0FV55900'+SNMaster as SNMaster, 'S0FV55900'+SNChild as SNChild,Smk_Inv.PN,Smk_Inv.Qty as Cant FROM Rcv_ScanMaster JOIN Smk_Inv ON '0FV55900'+SNChild = Smk_Inv.SN WHERE 'S0FV55900'+SNMaster = ? ";
		$sqlQuery = sqlsrv_query($conn,$sqlStatement,$params);
		$data = array();
		$cont = 0;
		while ($dato = sqlsrv_fetch_array($sqlQuery, SQLSRV_FETCH_ASSOC)) {
			$cont = $cont + $dato['Cant'];
			array_push($data, array(
				"SNMaster"=>$dato['SNMaster'],
				"SNChild"=>$dato['SNChild'],
				"PN"=>$dato['PN'],
				"Cant"=>$dato['Cant']
			));
		}
	
		echo json_encode(array("dato"=>$data,"Qty"=>sizeof($data),"Sum"=>$cont));
	}

?>