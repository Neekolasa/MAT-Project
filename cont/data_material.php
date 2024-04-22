<?php 
	include '../../connection.php';

	
	$request = $_REQUEST['request'];
	if ($request == 'info') {
		$data_material = $_REQUEST['material'];
		if(strlen($data_material)>8)
		{	
			$data_material=str_replace('S', '', $data_material);
			$sqlStatement = "
				SELECT TOP(20)  
				    PN,
				    SN,
				    Loc,
				    Status,
				    UltimoCambio
				FROM (
				    SELECT 
				        Smk_Inv.PN,
				        Smk_Inv.SN,
				        Loc,
				        Status,
				        CONVERT(NVARCHAR(16), Smk_InvDet.ActionDate, 120) as UltimoCambio,
				        ROW_NUMBER() OVER (PARTITION BY Smk_Inv.SN ORDER BY Smk_InvDet.ActionDate DESC) AS RowNum
				    FROM 
				        Smk_Inv 
				    JOIN 
				        Smk_InvDet ON Smk_Inv.SN = Smk_InvDet.SN
				    WHERE 
				        Smk_Inv.SN='$data_material' 
				) AS Subquery
				WHERE 
				    RowNum = 1
				ORDER BY 
				    UltimoCambio DESC;

			";
			
		}
		else if (strlen($data_material)<8) {

		$sqlStatement = "
			SELECT PFEP_Map.PN, 
			       PFEP_MasterV2.Descrip as SN, 
			       R + S + L + P AS Loc, 
			       'NA' AS Status, 
			       'NA' AS UltimoCambio
			FROM PFEP_Map 
			LEFT JOIN PFEP_MasterV2 ON PFEP_Map.PN = PFEP_MasterV2.PN 
			WHERE PFEP_Map.PN LIKE '%$data_material%' 
			ORDER BY R, S, L, P;";
		}
		else{
				$sqlStatement = "
				SELECT TOP(20)  
				    PN,
				    SN,
				    Loc,
				    Status,
				    UltimoCambio
				FROM (
				    SELECT 
				        Smk_Inv.PN,
				        Smk_Inv.SN,
				        Loc,
				        Status,
				        CONVERT(NVARCHAR(16), Smk_InvDet.ActionDate, 120) as UltimoCambio,
				        ROW_NUMBER() OVER (PARTITION BY Smk_Inv.SN ORDER BY Smk_InvDet.ActionDate DESC) AS RowNum
				    FROM 
				        Smk_Inv 
				    JOIN 
				        Smk_InvDet ON Smk_Inv.SN = Smk_InvDet.SN
				    WHERE 
				        Smk_Inv.PN='$data_material' 
				) AS Subquery
				WHERE 
				    RowNum = 1
				ORDER BY 
				    UltimoCambio DESC;

				";
		}
		
		$sqlQuery = sqlsrv_query($conn,$sqlStatement);
		$datos=[];
		while ($data = sqlsrv_fetch_array($sqlQuery,SQLSRV_FETCH_ASSOC)) {
			if (strlen($data_material)<8)
			{
			array_push($datos,array('PN' => $data['PN'],
									'SN' => $data['SN'],
									'Loc' => $data['Loc'],
									'Status' => getStatus($data['Status']),
									'UltimoCambio' => $data['UltimoCambio'],
									'Action' => "<button id='details' disabled class='btn btn-primary' data-toggle='modal' data-target='#modal_details'>Detalles</button>
									" ));
			}
			else{
			array_push($datos,array('PN' => $data['PN'],
									'SN' => $data['SN'],
									'Loc' => $data['Loc'],
									'Status' => getStatus($data['Status']),
									'UltimoCambio' => $data['UltimoCambio'],
									'Action' => "<button id='details' onclick='info(`$data[SN]`)' class='btn btn-primary' data-toggle='modal' data-target='#modal_details'>Detalles</button>
									" ));
			}
			

		}

		echo json_encode($datos);

	}
	elseif($request == 'getDetailInfo')
	{
		$serialNumber = $_REQUEST['serialNumber'];
		
		$arrayMaterialData = array();
		$arrayActions = [];
		$arrayMerge = array();
		$sqlStatement = "SELECT Smk_Inv.PN, Smk_Inv.SN, Action, 
								CONVERT(NVARCHAR(16), ActionDate, 120) AS ActionDate, 
						       Sy_Users.Name + ' ' + Sy_Users.LastName AS NombreCompleto
						FROM Smk_Inv
						JOIN Smk_InvDet ON Smk_Inv.SN = Smk_InvDet.SN
						JOIN Sy_Users ON Smk_InvDet.Badge = Sy_Users.Badge
						WHERE Smk_Inv.SN = '$serialNumber'
						ORDER BY LastUpdate DESC";

		$sqlQuery = sqlsrv_query($conn,$sqlStatement);

		while ($data = sqlsrv_fetch_array($sqlQuery,SQLSRV_FETCH_ASSOC)) {
			$arrayMaterialData = array(	'PN' => $data['PN'],
										'SN' => $data['SN']);
			
			array_push($arrayActions, array('action' => $data['Action'],
											'actionDate' => $data['ActionDate'],
											'name'=>$data['NombreCompleto']));
		}
		
		$arrayMerge []= array('MaterialData'=>$arrayMaterialData,
							'ActionsData'=>$arrayActions);
		echo json_encode($arrayMerge);
	}
	else{
		echo json_encode(array('response' => 'error'));
	}

	
function getStatus($status)
{
	if($status =='O'){
		return 'Abierto';
	}
	else if($status =='A')
	{
		return 'Cerrado';
	}
	else if($status =='E'){
		return 'Vacio';
	}
	else {
		return $status;
	}
}
?>