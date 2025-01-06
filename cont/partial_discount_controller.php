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
		//$discount = $_GET['discount'];
		$cantidad_descontada = 1;
		$idKanban = $_GET['cantidad_descontada'];
		$material_sn = $_GET['material_sn'];
		//$material_pn = $_GET['material_pn'];
		date_default_timezone_set('America/Monterrey');
		$fecha = date('Y-m-d H:i:s');

		try {
		    // Consulta 1: Obtener datos de DRC_Det
		    $sql_drc_det = "SELECT ID, PN, ContType FROM DRC_Det WHERE Id = '$idKanban'";
		    $result_drc_det = sqlsrv_query($conn, $sql_drc_det);

		    if ($result_drc_det === false || !sqlsrv_has_rows($result_drc_det)) {
		        echo json_encode(array('response' => 'NoKanban'));
		        exit;
		    }

		    $drcDetRow = sqlsrv_fetch_array($result_drc_det, SQLSRV_FETCH_ASSOC);
		    $pn_drcDet = $drcDetRow['PN'];
		    $contType_drcDet = $drcDetRow['ContType'];

		    // Consulta 2: Obtener datos de Smk_Inv
		    $sql_smk_inv = "SELECT PN, SN, Qty, UoM FROM Smk_Inv WHERE SN = '$material_sn'";
		    $result_smk_inv = sqlsrv_query($conn, $sql_smk_inv);

		    if ($result_smk_inv && sqlsrv_has_rows($result_smk_inv)) {
		        $smkInvRow = sqlsrv_fetch_array($result_smk_inv, SQLSRV_FETCH_ASSOC);
		        $pn_smkInv = $smkInvRow['PN'];
		        $sn_smkInv = $smkInvRow['SN'];
		        $qty_smkInv = $smkInvRow['Qty'];
		        $uom_smkInv = $smkInvRow['UoM'];

		        // Consulta 3: Obtener datos de DRC_ContQty
		        $key = $pn_drcDet . ' ' . $contType_drcDet;
		        $sql_drc_cont_qty = "SELECT PN, ContType, Qty FROM DRC_ContQty WHERE PN + ' ' + ContType = '$key'";
		        $result_drc_cont_qty = sqlsrv_query($conn, $sql_drc_cont_qty);
		        $discount = ($result_drc_cont_qty && sqlsrv_has_rows($result_drc_cont_qty))
		            ? sqlsrv_fetch_array($result_drc_cont_qty, SQLSRV_FETCH_ASSOC)['Qty']
		            : 0;
		    } else {
		        // Consulta 4: Obtener datos de Rcv_SNH
		        $sql_rcv_snh = "SELECT SN, PN, Qty, UoM FROM Rcv_SNH WHERE SN = '$material_sn'";
		        $result_rcv_snh = sqlsrv_query($conn, $sql_rcv_snh);

		        if ($result_rcv_snh === false || !sqlsrv_has_rows($result_rcv_snh)) {
		            echo json_encode(array('response' => 'NoSerie'));
		            exit;
		        }

		        $rcvSNHRow = sqlsrv_fetch_array($result_rcv_snh, SQLSRV_FETCH_ASSOC);
		        $snNumber = $rcvSNHRow['SN'];
		        $pnNumber = $rcvSNHRow['PN'];
		        $qtyNumber = $rcvSNHRow['Qty'];
		        $uomNumber = $rcvSNHRow['UoM'];

		        // Inserción en Smk_Inv
		        $sql_insert_smk_inv = "
		            INSERT INTO Smk_Inv
		            VALUES ('$snNumber', '$pnNumber', $qtyNumber, '08080808', 'A', '$uomNumber', 'A', GETDATE())";
		        $insert_result = sqlsrv_query($conn, $sql_insert_smk_inv);

		        if ($insert_result === false) {
		            echo json_encode(array('response' => 'NoReserva'));
		            exit;
		        }

		        // Consulta 3: Obtener datos de DRC_ContQty
		        $key = $pn_drcDet . ' ' . $contType_drcDet;
		        $sql_drc_cont_qty = "SELECT PN, ContType, Qty FROM DRC_ContQty WHERE PN + ' ' + ContType = '$key'";
		        $result_drc_cont_qty = sqlsrv_query($conn, $sql_drc_cont_qty);
		        $discount = ($result_drc_cont_qty && sqlsrv_has_rows($result_drc_cont_qty))
		            ? sqlsrv_fetch_array($result_drc_cont_qty, SQLSRV_FETCH_ASSOC)['Qty']
		            : 0;
		    }

		    // Colocar valores finales
		    $material_pn = $pn_drcDet;
			    $sql_statementCheckIsOpen="
					SELECT Smk_Inv.Status,Smk_Inv.UoM,Smk_Inv.Qty,PFEP_MasterV2.SAPProcess FROM Smk_Inv JOIN PFEP_MasterV2 ON Smk_Inv.PN = PFEP_MasterV2.PN WHERE Smk_Inv.SN = '$sn_smkInv';

				";
				$sql_queryCheckIsOpen = sqlsrv_query($conn,$sql_statementCheckIsOpen);
				while ($data = sqlsrv_fetch_array($sql_queryCheckIsOpen,SQLSRV_FETCH_ASSOC)) {
					$status = $data['Status'];
					$uom = $data['UoM'];
					$qty = $data['Qty'];
					$SAPProcess = $data['SAPProcess'];
				}
				$rest = $qty - $discount;
				if ($SAPProcess == "DIRECT") {
					$sql_statement="UPDATE Smk_Inv SET Qty = '0', Status ='E' WHERE SN = '$sn_smkInv'";
					$sql_statement3= "INSERT INTO Smk_InvDet VALUES ('$sn_smkInv','PARTIAL','$fecha','$badge','$material_pn')";
					if (strlen($sn_smkInv) > 14) {
						    $sn_smkInv = 'S' . $sn_smkInv;
						    $sqlStatement_SAP = "
								INSERT INTO xSmk_PickWIP
								           (SN, UoM, Qty, Movement, FSloc, CreatedOn, CreatedBy)
								     VALUES
								           ('$sn_smkInv',
											'$uom',
											'0',
											'EMPTY',
											'0002',
											GETDATE(),
											'$badge')
							";
						} else {
						    $sqlStatement_SAP = "
								INSERT INTO xSmk_PickWIP
								           (SN, UoM, Qty, Movement, FSloc, CreatedOn, CreatedBy)
								     VALUES
								           ('$sn_smkInv',
											'$uom',
											'0',
											'EMPTY',
											'0002',
											GETDATE(),
											'$badge')
							";
						}
				}
				else{
					$sql_statement="UPDATE Smk_Inv SET Qty = '$rest', Status ='O' WHERE SN = '$sn_smkInv'";
					$sql_statement3= "INSERT INTO Smk_InvDet VALUES ('$sn_smkInv','PARTIAL','$fecha','$badge','$material_pn')";
					if (strlen($sn_smkInv) > 14) {
						    $sn_smkInv = 'S' . $sn_smkInv;
						    $sqlStatement_SAP = "
								INSERT INTO xSmk_PickWIP
								           (SN, UoM, Qty, Movement, FSloc, CreatedOn, CreatedBy)
								     VALUES
								           ('$sn_smkInv',
											'$uom',
											'$discount',
											'PARTIAL',
											'0002',
											GETDATE(),
											'$badge')
							";
						} else {
						    $sqlStatement_SAP = "
								INSERT INTO xSmk_PickWIP
								           (SN, UoM, Qty, Movement, FSloc, CreatedOn, CreatedBy)
								     VALUES
								           ('$sn_smkInv',
											'$uom',
											'$discount',
											'PARTIAL',
											'0002',
											GETDATE(),
											'$badge')
							";
						}
				}
				
				
				

				
				if ($status == "O" || $status=="A") {
					$sql_query1 = sqlsrv_query($conn,$sql_statement);
					$sql_querySap = sqlsrv_query($conn,$sqlStatement_SAP);
					$sql_query3 = sqlsrv_query($conn,$sql_statement3);
					//$sqlQuerySnlo = sqlsrv_query($conn,$sqlSNLO);
					if ($sql_query1 == true AND $sql_query3== true) {
						echo json_encode(array('response' => 'success'));
					}
					else{
						
					}
				}
				else{
					echo json_encode(array('response' => 'closed'));
				}

				
			
		   exit;
		} catch (Exception $e) {
		    echo json_encode(array('response' => 'Error', 'message' => $e->getMessage()));
		    exit;
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
	elseif ($_GET['queue']=='getKanban') {
		$idKanban = $_GET['idKanban'];

		// Realiza la consulta
		$sqlStatement = "SELECT * FROM DRC_Det WHERE Id = ?";
		$params = array($idKanban);
		$sql_query = sqlsrv_query($conn, $sqlStatement, $params);

		// Verifica si hay resultados
		if ($sql_query) {
		    if (sqlsrv_has_rows($sql_query)) {
		        echo json_encode(array("response" => "success"));
		    } else {
		        echo json_encode(array("response" => "fail"));
		    }
		} else {
		    echo json_encode(array("response" => "fail"));
		}
	}
	elseif ($_GET['queue'] == "empty") {
			$serialNumber = $_GET['serialNumber'];
			$badge = $_GET['badge'];
			

			$sqlStatement_info = "SELECT SN, PN, Qty, UoM, Status FROM Smk_Inv WHERE SN= '$serialNumber'";
			$sqlQuery_info = sqlsrv_query($conn,$sqlStatement_info);
			if (!sqlsrv_has_rows($sqlQuery_info)){
				$sql_rcv_snh = "SELECT SN, PN, Qty, UoM FROM Rcv_SNH WHERE SN = '$serialNumber'";
		        $result_rcv_snh = sqlsrv_query($conn, $sql_rcv_snh);

		        if ($result_rcv_snh === false || !sqlsrv_has_rows($result_rcv_snh)) {
		            echo json_encode(array("response"=>"Bad Response","data"=>'bad'));
		            exit;
		        }

		        $rcvSNHRow = sqlsrv_fetch_array($result_rcv_snh, SQLSRV_FETCH_ASSOC);
		        $snNumber = $rcvSNHRow['SN'];
		        $pnNumber = $rcvSNHRow['PN'];
		        $qtyNumber = $rcvSNHRow['Qty'];
		        $uomNumber = $rcvSNHRow['UoM'];

		        // Inserción en Smk_Inv
		        $sql_insert_smk_inv = "
		            INSERT INTO Smk_Inv
		            VALUES ('$snNumber', '$pnNumber', $qtyNumber, '08080808', 'A', '$uomNumber', 'A', GETDATE())";
		        $insert_result = sqlsrv_query($conn, $sql_insert_smk_inv);

		        if ($insert_result === false) {
		            echo json_encode(array("response"=>"Bad Ressponse","data"=>'bad'));
		            
		            exit;
		        }
			}
			else{

				$sqlStatement_info = "SELECT SN, PN, Qty, UoM, Status FROM Smk_Inv WHERE SN= '$serialNumber'";
				$sqlQuery_info = sqlsrv_query($conn,$sqlStatement_info);			
				while ($data = sqlsrv_fetch_array($sqlQuery_info,SQLSRV_FETCH_ASSOC)) {
					$PN = $data['PN'];
					$Qty = $data['Qty'];
					$UoM = $data['UoM'];
					$Status = $data['Status'];
				}
				if ($Status == "E") {
					echo json_encode(array("response"=>"alreadyEmpty"));
					exit;
				}
				//$sqlStatement_updateSNLO = "UPDATE ChkP_SNLO SET leftOver = '0', AuditStatus='EMP' WHERE SN = '$serialNumber'";		
				//$sqlQuery_insert = sqlsrv_query($conn,$sqlStatement_updateSNLO);

				$sqlStatement_update = "UPDATE Smk_Inv SET Status = 'E', Qty = '0' WHERE SN = '$serialNumber'";
				$sqlQuery_update = sqlsrv_query($conn,$sqlStatement_update);
				
				$fecha = date('Y-m-d H:i:s');
				$sqlStatement_insertSmkDet = "INSERT INTO Smk_InvDet VALUES ('$serialNumber','EMPTY','$fecha','$badge','$PN')";
				$sqlQuery_SmkDet = sqlsrv_query($conn,$sqlStatement_insertSmkDet);

				if ($Status == "O") {
					if (strlen($serialNumber) > 14) {
					    $serialNumber = 'S' . $serialNumber;
					    $sqlStatement_SAP = "
					    INSERT INTO xSmk_PickWIP
					               (SN, UoM, Qty, Movement, FSloc, CreatedOn, CreatedBy)
					         VALUES
					               ('$serialNumber',
					                '$UoM',
					                '$Qty',
					                'EMPTY',
					                '0002',
					                GETDATE(),
					                '$badge')
					    ";
					} else {
					    $sqlStatement_SAP = "
					    INSERT INTO xSmk_PickWIP
					               (SN, UoM, Qty, Movement, FSloc, CreatedOn, CreatedBy)
					         VALUES
					               ('$serialNumber',
					                '$UoM',
					                '$Qty',
					                'EMPTY',
					                '0002',
					                GETDATE(),
					                '$badge')
					    ";
					}
					$sqlQuery_SAP = sqlsrv_query($conn,$sqlStatement_SAP);
				}
				elseif ($Status == "A") {
					if (strlen($serialNumber) > 14) {
					    $serialNumber = 'S' . $serialNumber;
					    $sqlStatement_SAP = "
					    INSERT INTO xSmk_PickWIP
					               (SN, UoM, Qty, Movement, FSloc, CreatedOn, CreatedBy)
					         VALUES
					               ('$serialNumber',
					                '$UoM',
					                '$Qty',
					                'EMPTY',
					                '0002',
					                GETDATE(),
					                '$badge')
					    ";
					} else {
					    $sqlStatement_SAP = "
					    INSERT INTO xSmk_PickWIP
					               (SN, UoM, Qty, Movement, FSloc, CreatedOn, CreatedBy)
					         VALUES
					               ('$serialNumber',
					                '$UoM',
					                '$Qty',
					                'EMPTY',
					                '0002',
					                GETDATE(),
					                '$badge')
					    ";
					}
					
					$sqlQuery_SAP = sqlsrv_query($conn,$sqlStatement_SAP);
				}
				else{
					if (strlen($serialNumber) > 14) {
					    $serialNumber = 'S' . $serialNumber;
					    $sqlStatement_SAP = "
					    INSERT INTO xSmk_PickWIP
					               (SN, UoM, Qty, Movement, FSloc, CreatedOn, CreatedBy)
					         VALUES
					               ('$serialNumber',
					                '$UoM',
					                '$Qty',
					                'EMPTY',
					                '0002',
					                GETDATE(),
					                '$badge')
					    ";
					} else {
					    $sqlStatement_SAP = "
					    INSERT INTO xSmk_PickWIP
					               (SN, UoM, Qty, Movement, FSloc, CreatedOn, CreatedBy)
					         VALUES
					               ('$serialNumber',
					                '$UoM',
					                '$Qty',
					                'EMPTY',
					                '0002',
					                GETDATE(),
					                '$badge')
					    ";
					}
					
					$sqlQuery_SAP = sqlsrv_query($conn,$sqlStatement_SAP);
				}
				
				echo json_encode(array("response"=>"success"));
			}
	}
	
?>