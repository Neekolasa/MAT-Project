<?php
	include '../../connection.php';
	$request = $_REQUEST['request'];

	if ($request == 'getAdjust') {
		//Dia anterior
		/*$sqlStatement = "
			SELECT PN, ContType, SUM(Qty) AS TotalSinDescuento, UoM, SAPProcess, CONVERT(date, ScanDate) AS ScanDate
			FROM ChkComp_MainMov
			WHERE SN LIKE '%NO%' AND CONVERT(date, ScanDate) >= DATEADD(day, -1, CONVERT(date, GETDATE()))
			GROUP BY PN, SAPProcess, ContType, UoM, CONVERT(date, ScanDate)
			ORDER BY TotalSinDescuento DESC;
		";*/

		//Dia de hoy
		$sqlStatement="
		SELECT PN, ContType, SUM(Qty) AS TotalSinDescuento, UoM, SAPProcess, CONVERT(date, ScanDate) AS ScanDate
			FROM ChkComp_MainMov
			WHERE SN LIKE '%NO%' AND CONVERT(date, ScanDate) >= CONVERT(date, GETDATE())
			GROUP BY PN, SAPProcess, ContType, UoM, CONVERT(date, ScanDate)
			ORDER BY TotalSinDescuento DESC";
		$sql_query = sqlsrv_query($conn, $sqlStatement);
		if ($sql_query === false) {
			$response = array('response' => 'fail');
		}
		else{
			$datos = array();
			while ($info = sqlsrv_fetch_array($sql_query, SQLSRV_FETCH_ASSOC)) {
				array_push($datos, array(
					"PN"=>$info['PN'],
					"ContType"=>$info['ContType'],
					"TotalSinDescuento"=>$info['TotalSinDescuento'],
					"UoM"=>$info['UoM'],
					"SAPProcess"=>$info['SAPProcess'],
					"ScanDate"=>$info['ScanDate']->format('Y-m-d')

				));
			}
			$response = array('response' => 'success', 'data' => $datos);
			
		}
		echo json_encode($response);
	}
	/*elseif ($request == 'autoAdjust') {
		$sqlStatement_SNLO="
		SELECT * FROM ChkP_SNLO WHERE SN IN(
			SELECT SN FROM Smk_Inv WHERE Status = 'O' AND PN IN (
				SELECT PN FROM ChkComp_MainMov WHERE SN = 'NOSN' AND CONVERT(date, ChkComp_MainMov.ScanDate) >= DATEADD(day, -1, CONVERT(date, GETDATE()))
			)
		)
		";
		$sql_query = sqlsrv_query($conn, $sqlStatement);
		if ($sql_query === false) {
			$response = array('response' => 'fail');
		}
		else{
			$datos = array();
			while ($info = sqlsrv_fetch_array($sql_query, SQLSRV_FETCH_ASSOC)) {
				array_push($datos, array(
					"SN"=>$info['SN'],
					"stdPack"=>$info['stdPack'],
					"leftOver"=>$info['leftOver'],
					"AuditStatus"=>$info['AuditStatus']

				));
			}
			$response = array('response' => 'success', 'data' => $datos);
			
		}
		echo json_encode($response);
	}*/
	elseif ($request == 'setAdjust') {
		$sqlStatement = "
			SELECT DISTINCT Smk_Inv.PN,ChkP_SNLO.SN, ChkP_SNLO.stdPack, ChkComp_MainMov.Qty as 'QtyDescuento', ChkP_SNLO.leftOver as 'QtyActual', leftOver - ChkComp_MainMov.Qty AS 'Restante'
				FROM ChkP_SNLO 
				JOIN Smk_Inv ON ChkP_SNLO.SN = Smk_Inv.SN
				JOIN ChkComp_MainMov ON Smk_Inv.PN = ChkComp_MainMov.PN
			WHERE Smk_Inv.Status = 'O'
			AND ChkComp_MainMov.SN = 'NOSN'
			AND (leftOver - ChkComp_MainMov.Qty)>0
			AND CONVERT(DATE, ChkComp_MainMov.ScanDate) = CONVERT(DATE, GETDATE())
		";
		$array="";
		$response = array();
		$sql_query = sqlsrv_query($conn, $sqlStatement);
		if ($sql_query === false) {
			$response = array('response' => 'fail');
		}
		else{
			$datos = array();

			while ($info = sqlsrv_fetch_array($sql_query, SQLSRV_FETCH_ASSOC)) {
				$sqlSNLO = "UPDATE ChkP_SNLO SET leftOver ='$info[Restante]' WHERE SN =  '$info[SN]'";
				$sqlCompUpdate = "UPDATE ChkComp_MainMov SET SN = '$info[SN]', Status = 'OKK' WHERE SN = 'NOSN' AND PN = '$info[PN]'";
				$sapInsert = "INSERT INTO Smk_SAP (SN,PN,UoM,Qty,ISloc,FSloc,Module,InpDate,Station) VALUES ('$info[SN]','$info[PN]','PC','$info[QtyDescuento]','0007','0002','SMK SCANNER',GETDATE(),'A')
				";
				$sql_querySNLO = sqlsrv_query($conn, $sqlSNLO);
				$sql_queryCompUpdate = sqlsrv_query($conn, $sqlCompUpdate);
				$sql_queryInsert = sqlsrv_query($conn, $sapInsert);

				if ($sql_querySNLO===true && $sqlCompUpdate===true && $sapInsert===true) {
					$response = array('response' => 'success');
				}
				else{
					$response = array('response' => 'fail');
				}
			}
			$response = array('response' => 'success');
			
		}

		echo json_encode($response);
	}
	elseif ($request == 'getStdOver') {
		$sqlStatement = "
			SELECT DISTINCT Smk_Inv.PN,ChkP_SNLO.SN, ChkP_SNLO.stdPack, ChkComp_MainMov.Qty as 'QtyDescuento', ChkP_SNLO.leftOver as 'QtyActual', leftOver - ChkComp_MainMov.Qty AS 'Restante'
			FROM ChkP_SNLO 
			JOIN Smk_Inv ON ChkP_SNLO.SN = Smk_Inv.SN
			JOIN ChkComp_MainMov ON Smk_Inv.PN = ChkComp_MainMov.PN
			WHERE Smk_Inv.Status = 'O'
			AND ChkComp_MainMov.SN = 'NOSN'
			AND (leftOver - ChkComp_MainMov.Qty)<0
		";
		$sqlQuery = sqlsrv_query($conn,$sqlStatement);
		$datos = array();
		while ($info = sqlsrv_fetch_array($sqlQuery,SQLSRV_FETCH_ASSOC)) {
			array_push($datos, array(
				"PN"=>$info['PN'],
				"SN"=>$info['SN'],
				"StdPack"=>$info['stdPack'],
				"QtyDescuento"=>$info['QtyDescuento'],
				"QtyActual"=>$info['QtyActual'],
				"Restante"=>$info['Restante']

			));
		}
		if ($sqlQuery===false) {
			$response = array("response"=>"fail");
		}
		else{
			echo json_encode(array("response"=>"success","data"=>$datos));
		}
		
	}
	

?>