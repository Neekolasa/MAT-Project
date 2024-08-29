<?php
include '../../connection.php';
	if($_GET['queue']=='getMaterialPN'){
		$material_SN = $_GET['material_sn'];

		$sql_statement = "SELECT Qty,PN FROM Smk_Inv WHERE SN = '$material_SN'";
		$sql_query = sqlsrv_query($conn,$sql_statement);
		
		$material_info = [];
		while ($result = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
			array_push($material_info,array('PN' => $result['PN'], 
											'Qty' => $result['Qty']));
		}
		echo json_encode($material_info);
	}
	elseif($_GET['queue']=='setDiscount'){
		$badge = $_GET['badge'];
		$discount = $_GET['discount'];
		$cantidad_descontada = $_GET['cantidad_descontada'];
		$material_sn = $_GET['material_sn'];
		$material_pn = $_GET['material_pn'];
		date_default_timezone_set('America/Monterrey');
		$fecha = date('Y-m-d H:i:s');
		if ($cantidad_descontada<=0) {
			
			$sql_statement="UPDATE Smk_Inv SET Qty = '0' WHERE SN = '$material_sn'";
			$sql_statement2="UPDATE Smk_Inv SET Status = 'E' WHERE SN ='$material_sn'";

			$sql_statement3= "INSERT INTO Smk_InvDet VALUES ('$material_sn','PARTIAL','$fecha','$badge','$material_pn')";
			$sql_statement4= "INSERT INTO Smk_InvDet VALUES ('$material_sn','EMPTY','$fecha','$badge','$material_pn')";
			
			$sql_query1 = sqlsrv_query($conn,$sql_statement);
			$sql_query2 = sqlsrv_query($conn,$sql_statement2);
			$sql_query3 = sqlsrv_query($conn,$sql_statement3);
			$sql_query4 = sqlsrv_query($conn,$sql_statement4);
			if ($sql_query1 == true AND $sql_query2 == true AND $sql_query3== true AND $sql_query4==true) {
				echo json_encode(array('response' => 'success'));
			}
			else{
				echo json_encode(array('response' => 'fail'));
			}
		}
		else{
			$sql_statementCheckIsOpen="
				SELECT Status FROM Smk_Inv WHERE SN = '$material_sn';

			";
			
			$sql_statement="UPDATE Smk_Inv SET Qty = '$cantidad_descontada' WHERE SN = '$material_sn'";
			$sqlSNLO = "UPDATE ChkP_SNLO SET leftOver = '$cantidad_descontada' WHERE SN = '$material_sn'";

			$sql_statement3= "INSERT INTO Smk_InvDet VALUES ('$material_sn','PARTIAL','$fecha','$badge','$material_pn')";
			$sqlStatement_SAP = "
				INSERT INTO Smk_SAP
				           (SN,PN,UoM,Qty,ISloc,FSloc,Module,InpDate,Station)
				     VALUES
				           ('$material_sn',
							'$material_pn',
							'PC',
							'$discount',
							'0007',
							'0002',
							'SMK SCANNER',
							GETDATE(),
							'A')
			";

			$sql_queryCheckIsOpen = sqlsrv_query($conn,$sql_statementCheckIsOpen);
			while ($data = sqlsrv_fetch_array($sql_queryCheckIsOpen,SQLSRV_FETCH_ASSOC)) {
				$status = $data['Status'];
			}
			if ($status == "O") {
				$sql_query1 = sqlsrv_query($conn,$sql_statement);
				$sql_querySap = sqlsrv_query($conn,$sqlStatement_SAP);
				$sql_query3 = sqlsrv_query($conn,$sql_statement3);
				$sqlQuerySnlo = sqlsrv_query($conn,$sqlSNLO);
				if ($sql_query1 == true AND $sql_query3== true) {
					echo json_encode(array('response' => 'success'));
				}
				else{
					
				}
			}
			else{
				echo json_encode(array('response' => 'closed'));
			}

			
		}

	}
	elseif($_GET['queue']=='getActualQty'){	
		$serialNumber = $_GET['sn'];
		$sql_statement = "SELECT Qty,PN FROM Smk_Inv WHERE SN = '$serialNumber'";

		$sql_query = sqlsrv_query($conn,$sql_statement);
		$datos = [];
		while ($data = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
			array_push($datos, array('Qty'=>$data['Qty'],
										'PN'=>$data['PN']));
		}

		echo json_encode($datos);
	}
	elseif ($_GET['queue']=='setActualQty') {
		$serialNumber = $_GET['sn'];
		$new_qty = $_GET['new_qty'];
		$partNumber = $_GET['partNumber'];
		date_default_timezone_set('America/Monterrey');
		$fecha = date('Y-m-d H:i:s');
		$badge = $_GET['badge'];

		$sql_statement="UPDATE Smk_Inv SET Qty = '$new_qty' WHERE SN = '$serialNumber'";
		$sql_statement2= "INSERT INTO Smk_InvDet VALUES ('$serialNumber','CHANGE','$fecha','$badge','$partNumber')";
		$sql_statement3="UPDATE ChkP_SNLO SET leftOver = '$new_qty' WHERE SN = '$serialNumber'";

		//echo "$sql_statement\n";
		//echo "$sql_statement2";
		$sql_query = sqlsrv_query($conn,$sql_statement);
		$sql_query2 = sqlsrv_query($conn,$sql_statement2);
		$sql_query3 = sqlsrv_query($conn,$sql_statement3);

		if ($sql_query == true AND $sql_query2 == true) {
			echo json_encode(array('response' => 'success'));
		}
		else{
			echo json_encode(array('response' => 'fail'));
		}

	}

	
?>