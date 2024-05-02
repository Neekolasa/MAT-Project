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
		SELECT ChkComp_MainMov.PN, ContType, SUM(Qty) AS TotalSinDescuento, UoM, R+S+L+P as Locacion, SAPProcess, CONVERT(date, ScanDate) AS ScanDate
			FROM ChkComp_MainMov JOIN PFEP_Map ON ChkComp_MainMov.PN = PFEP_Map.PN
			WHERE SN LIKE '%NO%' AND CONVERT(date, ScanDate) >= CONVERT(date, GETDATE())
			GROUP BY ChkComp_MainMov.PN,R, S, L, P, SAPProcess, ContType, UoM, CONVERT(date, ScanDate)
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
					"Locacion"=>$info['Locacion'],
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
			AND (leftOver - ChkComp_MainMov.Qty)>=0
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
				$sqlUpdateQty = "UPDATE Smk_Inv SET Qty = '$info[Restante]' WHERE SN = '$info[SN]'";

				$sql_querySNLO = sqlsrv_query($conn, $sqlSNLO);
				$sql_queryCompUpdate = sqlsrv_query($conn, $sqlCompUpdate);
				$sql_queryInsert = sqlsrv_query($conn, $sapInsert);
				$sql_queryUpdateQty = sqlsrv_query($conn, $sqlUpdateQty);

				if ($sql_querySNLO===true && $sqlCompUpdate===true && $sapInsert===true && $sql_queryUpdateQty === true) {
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
			AND CONVERT(DATE, ChkComp_MainMov.ScanDate) = CONVERT(DATE, GETDATE())

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
				"Diferencia"=>"<b style='color:red'>".$info['Restante']."</b>"

			));
		}
		if ($sqlQuery===false) {
			$response = array("response"=>"fail");
		}
		else{
			echo json_encode(array("response"=>"success","data"=>$datos));
		}
		
	}
	elseif ($request == 'getAvailableAdjust') {
		$sqlStatement = "
			SELECT DISTINCT Smk_Inv.PN,ChkP_SNLO.SN, ChkP_SNLO.stdPack, ChkComp_MainMov.Qty as 'QtyDescuento', ChkP_SNLO.leftOver as 'QtyActual'
				FROM ChkP_SNLO 
				JOIN Smk_Inv ON ChkP_SNLO.SN = Smk_Inv.SN
				JOIN ChkComp_MainMov ON Smk_Inv.PN = ChkComp_MainMov.PN
			WHERE Smk_Inv.Status = 'O'
			AND ChkComp_MainMov.SN = 'NOSN'
			AND (leftOver - ChkComp_MainMov.Qty)>0
			AND CONVERT(DATE, ChkComp_MainMov.ScanDate) = CONVERT(DATE, GETDATE())
		";
		$sql_query = sqlsrv_query($conn, $sqlStatement);
		if ($sql_query === false) {
			$response = array('response' => 'fail');
		}
		else{
			$datos = array();
			while ($info = sqlsrv_fetch_array($sql_query, SQLSRV_FETCH_ASSOC)) {
				array_push($datos, array(
					"PN"=>$info['PN'],
					"SN"=>$info['SN'],
					"stdPack"=>$info['stdPack'],
					"QtyDescuento"=>"<b style='color:green'>".$info['QtyDescuento']."</b>",
					"QtyActual"=>$info['QtyActual']
				));
			}
			$response = array('response' => 'success', 'data' => $datos);
			
		}
		echo json_encode($response);
	}
	elseif ($request == 'setUpdate') {
		$badge = $_REQUEST['badge'];
		$order = $_REQUEST['order']; //empty,revive
		$serialNumber = $_REQUEST['serial'];
		$serialNumber=str_replace("S", "", $serialNumber);
		if ($order == "open") {
			$params = array($serialNumber);
			$sqlStatement_info = "SELECT SN, PN, Qty, UoM, Status FROM Smk_Inv WHERE SN= ?";
			$sqlQuery_info = sqlsrv_query($conn,$sqlStatement_info,$params);			
			if ($sqlQuery_info===false) {
				echo json_encode(array("response"=>"Bad Response","data"=>'bad'));
			}
			else{
				while ($data = sqlsrv_fetch_array($sqlQuery_info,SQLSRV_FETCH_ASSOC)) {
					$PN = $data['PN'];
					$Qty = $data['Qty'];
					$UoM = $data['UoM'];
					$Status = $data['Status'];
				}
				$params = array($PN,'O');
				$sqlStatement_Opened = "SELECT COUNT(*) as Abiertos FROM Smk_Inv WHERE PN = ? AND Status = ?";
				$sqlQuery_Opened = sqlsrv_query($conn,$sqlStatement_Opened,$params);
				while ($contador = sqlsrv_fetch_array($sqlQuery_Opened, SQLSRV_FETCH_ASSOC)) {
					$seriesAbiertas = $contador['Abiertos'];
				}
				if ($seriesAbiertas>0) {
					echo json_encode(array("response"=>"Ya hay cajas abiertas","data"=>true));
				}
				else{
					if ($Status!='A') {
						echo json_encode(array("response"=>"Caja vacia","data"=>$Status));
					}
					else{
						$sqlStatement_insert = "INSERT INTO ChkP_SNLO(SN,stdPack,leftOver,AuditStatus) VALUES ('$serialNumber','$Qty','$Qty','NEW')";
						$sqlQuery_insert = sqlsrv_query($conn,$sqlStatement_insert);
						
						$sqlStatement_update = "UPDATE Smk_Inv SET Status = 'O' WHERE SN = '$serialNumber'";
						$sqlQuery_update = sqlsrv_query($conn,$sqlStatement_update);
					
						$sqlStatement_SAP = "INSERT INTO Smk_SAP (SN,PN,UoM,Qty,ISloc,FSloc,Module,InpDate,Station) VALUES ('$serialNumber','$PN','$UoM','$Qty','0001','0007','SMK SCANNER',GETDATE(),'A')";
						$sqlQuery_SAP = sqlsrv_query($conn,$sqlStatement_SAP);
						$fecha = date('Y-m-d H:i:s');
						$sqlStatement_insertSmkDet = "INSERT INTO Smk_InvDet VALUES ('$serialNumber','OPEN','$fecha','$badge','$PN')";
						$sqlQuery_SmkDet = sqlsrv_query($conn,$sqlStatement_insertSmkDet);

						echo json_encode(array("response"=>"success"));
					}
				}
			}
			
		}
		elseif ($order == "empty") {
			
			$params = array($serialNumber);
			$sqlStatement_info = "SELECT SN, PN, Qty, UoM, Status FROM Smk_Inv WHERE SN= ?";
			$sqlQuery_info = sqlsrv_query($conn,$sqlStatement_info,$params);			
			if ($sqlQuery_info===false) {
				echo json_encode(array("response"=>"Bad Response","data"=>'bad'));
			}
			else{
				while ($data = sqlsrv_fetch_array($sqlQuery_info,SQLSRV_FETCH_ASSOC)) {
					$PN = $data['PN'];
					$Qty = $data['Qty'];
					$UoM = $data['UoM'];
					$Status = $data['Status'];
				}

				$sqlStatement_updateSNLO = "UPDATE ChkP_SNLO SET leftOver = '0', AuditStatus='EMP' WHERE SN = '$serialNumber'";		
				$sqlQuery_insert = sqlsrv_query($conn,$sqlStatement_updateSNLO);

				$sqlStatement_update = "UPDATE Smk_Inv SET Status = 'E', Qty = '0' WHERE SN = '$serialNumber'";
				$sqlQuery_update = sqlsrv_query($conn,$sqlStatement_update);
				
				$fecha = date('Y-m-d H:i:s');
				$sqlStatement_insertSmkDet = "INSERT INTO Smk_InvDet VALUES ('$serialNumber','EMPTY','$fecha','$badge','$PN')";
				$sqlQuery_SmkDet = sqlsrv_query($conn,$sqlStatement_insertSmkDet);

				if ($Status == "O") {
					$sqlStatement_SAP = "INSERT INTO Smk_SAP (SN,PN,UoM,Qty,ISloc,FSloc,Module,InpDate,Station) VALUES ('$serialNumber','$PN','$UoM','$Qty','0007','0002','SMK SCANNER',GETDATE(),'A')";
					$sqlQuery_SAP = sqlsrv_query($conn,$sqlStatement_SAP);
				}
				elseif ($Status == "A") {
					$sqlStatement_SAP = "INSERT INTO Smk_SAP (SN,PN,UoM,Qty,ISloc,FSloc,Module,InpDate,Station) VALUES ('$serialNumber','$PN','$UoM','$Qty','0001','0002','SMK SCANNER',GETDATE(),'A')";
					$sqlQuery_SAP = sqlsrv_query($conn,$sqlStatement_SAP);
				}
				else{
					$sqlStatement_SAP = "";
				}
				
				
				

				echo json_encode(array("response"=>"success"));
			}
			
		}
		elseif ($order == "revive") {
			$params = array($serialNumber);
			$sqlStatement_info = "SELECT SN, PN, Qty, UoM, Status FROM Rcv_SNH WHERE SN= ?";
			$sqlQuery_info = sqlsrv_query($conn,$sqlStatement_info,$params);			
			if ($sqlQuery_info===false) {
				echo json_encode(array("response"=>"Bad Response","data"=>'bad'));
			}
			else{
				while ($data = sqlsrv_fetch_array($sqlQuery_info,SQLSRV_FETCH_ASSOC)) {
					$PN = $data['PN'];
					$Qty = $data['Qty'];
					$UoM = $data['UoM'];
					$Status = $data['Status'];
				}
				$sqlStatement_updateSNLO = "DELETE FROM ChkP_SNLO WHERE SN = '$serialNumber'";		
				$sqlQuery_insert = sqlsrv_query($conn,$sqlStatement_updateSNLO);

				$sqlStatement_update = "UPDATE Smk_Inv SET Status = 'A', Qty = '$Qty' WHERE SN = '$serialNumber'";
				$sqlQuery_update = sqlsrv_query($conn,$sqlStatement_update);
				
				$sqlStatement_delSAP = "DELETE FROM Smk_SAP WHERE SN = '$serialNumber'";		
				$sqlQuery_delSap = sqlsrv_query($conn,$sqlStatement_delSAP);

				$sqlStatement_SAP = "INSERT INTO Smk_SAP (SN,PN,UoM,Qty,ISloc,FSloc,Module,InpDate,Station) VALUES ('$serialNumber','$PN','$UoM','$Qty','0002','0001','SMK SCANNER',GETDATE(),'A')";
				$sqlQuery_SAP = sqlsrv_query($conn,$sqlStatement_SAP);
				
				$fecha = date('Y-m-d H:i:s');
				$sqlStatement_insertSmkDet = "INSERT INTO Smk_InvDet VALUES ('$serialNumber','REVIVE','$fecha','$badge','$PN')";
				$sqlQuery_SmkDet = sqlsrv_query($conn,$sqlStatement_insertSmkDet);

				echo json_encode(array("response"=>"success"));
			}
		}
		elseif ($order == "change") {
			$newQty = $_REQUEST['newQty'];

			$params = array($serialNumber);
			$sqlStatement_info = "SELECT SN, PN, Qty, UoM, Status FROM Smk_Inv WHERE SN= ?";
			$sqlQuery_info = sqlsrv_query($conn,$sqlStatement_info,$params);			
			if ($sqlQuery_info===false) {
				echo json_encode(array("response"=>"badResponse","data"=>'bad'));
			}
			else{
				while ($data = sqlsrv_fetch_array($sqlQuery_info,SQLSRV_FETCH_ASSOC)) {
					$PN = $data['PN'];
					$Qty = $data['Qty'];
					$UoM = $data['UoM'];
					$Status = $data['Status'];
				}
				

				$sqlStatement_update = "UPDATE Smk_Inv SET Qty = '$newQty' WHERE SN = '$serialNumber'";
				$sqlQuery_update = sqlsrv_query($conn,$sqlStatement_update);
				
				$fecha = date('Y-m-d H:i:s');
				$sqlStatement_insertSmkDet = "INSERT INTO Smk_InvDet VALUES ('$serialNumber','CHANGE','$fecha','$badge','$PN')";
				$sqlQuery_SmkDet = sqlsrv_query($conn,$sqlStatement_insertSmkDet);

				if ($Status == "O") {
					$sqlStatement_updateSNLO = "UPDATE  ChkP_SNLO SET leftOver = '$newQty' WHERE SN = '$serialNumber'";		
					$sqlQuery_insert = sqlsrv_query($conn,$sqlStatement_updateSNLO);
				}
				elseif ($Status == "A") {
					$sqlStatement_updateSNLO="";
				}
				else{
					$sqlStatement_updateSNLO="";
				}
				

				echo json_encode(array("response"=>"success"));
			}
		}
	}
	

?>