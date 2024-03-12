<?php
	include '../../connection.php';
	$request = $_REQUEST['request'];

	if ($request == 'getCriticalTable') {
		$sqlStatement = "
			SELECT 
			    COALESCE(Smk_Inv.PN, 'NA') AS PN,
			    COALESCE(Smk_InvDet.SN, 'NA') AS SN,
			    COALESCE(Smk_InvDet.Badge, 'NA') AS Badge,
			    COALESCE(Sy_Users.Name + ' ' + Sy_Users.LastName, 'NA') AS [Name],
			    COALESCE(Smk_InvDet.Action, 'NA') AS Action,
			    COALESCE(CONVERT(varchar, MAX(Smk_InvDet.ActionDate), 1) + ' ' + RIGHT(CONVERT(varchar, MAX(Smk_InvDet.ActionDate), 100), 7), 'NA') AS Fecha
			FROM 
			    Smk_InvDet 
			FULL JOIN 
			    Smk_Inv ON Smk_Inv.SN = Smk_InvDet.SN
			JOIN 
			    Sy_Users ON Smk_InvDet.Badge = Sy_Users.Badge 
			WHERE 
			    Action = 'EMPTY'
				AND CONVERT(date, Smk_InvDet.ActionDate) = CONVERT(date, GETDATE())
			GROUP BY 
			    Smk_Inv.PN,
			    Smk_InvDet.SN,
			    Smk_InvDet.Badge,
			    Sy_Users.Name,
			    Sy_Users.LastName,
			    Smk_InvDet.Action
			ORDER BY 
			    MAX(Smk_InvDet.ActionDate) DESC;
		";
		$sqlQuery = sqlsrv_query($conn,$sqlStatement);
		if ($sqlQuery!==false) {
			$data = array();
			while ($dat = sqlsrv_fetch_array($sqlQuery,SQLSRV_FETCH_ASSOC)) {
				$data[] = array(
			        "PN" => $dat['PN'],
			        "SN" => $dat['SN'],
			        "Badge" => $dat['Badge'],
			        "Name" => $dat['Name'],
			        "Action" => $dat['Action'],	
			        "Fecha" => $dat['Fecha']
			    );
			}
			 $response = array('response' => 'success', 'data' => $data);
		}
		else{
			 $response = array('response' => 'fail');
		}
		
		echo json_encode($response);
	}
	elseif ($request == 'getEmptyUsers') {
		$sqlStatement = "
			SELECT 
			    COALESCE(Smk_InvDet.Badge, 'NA') AS Badge,
			    COALESCE(Sy_Users.Name, 'NA') AS Name,
			    COALESCE(Sy_Users.LastName, 'NA') AS LastName,
			    COUNT(CASE WHEN COALESCE(Smk_InvDet.Action, 'NA') = 'EMPTY' THEN 1 ELSE NULL END) AS SeriesVacias,
			    COALESCE(CONVERT(varchar, MAX(Smk_InvDet.ActionDate), 1) + ' ' + RIGHT(CONVERT(varchar, MAX(Smk_InvDet.ActionDate), 100), 7), 'NA') AS Fecha
			FROM 
			    Smk_InvDet 
			JOIN 
			    Sy_Users ON Smk_InvDet.Badge = Sy_Users.Badge 
			WHERE 
			    CONVERT(date, Smk_InvDet.ActionDate) = CONVERT(date, GETDATE())
			GROUP BY 
			    Smk_InvDet.Badge,
			    Sy_Users.Name,
			    Sy_Users.LastName
			HAVING 
			    COUNT(CASE WHEN COALESCE(Smk_InvDet.Action, 'NA') = 'EMPTY' THEN 1 ELSE NULL END) > 0
			ORDER BY 
			    SeriesVacias DESC;

		";
		$sqlQuery = sqlsrv_query($conn,$sqlStatement);
		if ($sqlQuery!==false) {
			$data = array();
			while ($dat = sqlsrv_fetch_array($sqlQuery,SQLSRV_FETCH_ASSOC)) {
				$data[] = array(
			        "Badge" => $dat['Badge'],
			        "Name" => $dat['Name'],
			        "LastName" => $dat['LastName'],
			        "SeriesVacias" => $dat['SeriesVacias'],
			        "Fecha" => $dat['Fecha']
			    );
			}
			 $response = array('response' => 'success', 'data' => $data);
		}
		else{
			 $response = array('response' => 'fail');
		}
		
		echo json_encode($response);
	}
	elseif ($request == 'getEmptyNumbers') {
		$sqlStatement = "
			SELECT 
			    COALESCE(Smk_Inv.PN, 'NA') AS NumeroDeParte,
			    COUNT(DISTINCT CASE WHEN COALESCE(Smk_InvDet.Action, 'NA') = 'EMPTY' THEN Smk_InvDet.SN ELSE NULL END) AS SeriesVaciadas,
			    COALESCE(Smk_InvDet.Badge, 'NA') AS Badge,
			    COALESCE(Sy_Users.Name +' '+Sy_Users.LastName, 'NA') AS Nombre,
			    COALESCE(CONVERT(varchar, MAX(Smk_InvDet.ActionDate), 1) + ' ' + RIGHT(CONVERT(varchar, MAX(Smk_InvDet.ActionDate), 100), 7), 'NA') AS Fecha
			FROM 
			    Smk_InvDet 
			LEFT JOIN 
			    Smk_Inv ON Smk_Inv.SN = Smk_InvDet.SN
			LEFT JOIN 
			    Sy_Users ON Smk_InvDet.Badge = Sy_Users.Badge 
			WHERE 
			    CONVERT(date, Smk_InvDet.ActionDate) = CONVERT(date, GETDATE())
			GROUP BY 
			    Smk_Inv.PN,
			    Smk_InvDet.Badge,
			    Sy_Users.Name,
				Sy_Users.LastName
			HAVING 
			    COUNT(DISTINCT CASE WHEN COALESCE(Smk_InvDet.Action, 'NA') = 'EMPTY' THEN Smk_InvDet.SN ELSE NULL END) > 0
			ORDER BY 
			    SeriesVaciadas DESC;
		";
		$sqlQuery = sqlsrv_query($conn,$sqlStatement);
		if ($sqlQuery!==false) {
			$data = array();
			while ($dat = sqlsrv_fetch_array($sqlQuery,SQLSRV_FETCH_ASSOC)) {
				$data[] = array(
			        "PartNumber" => $dat['NumeroDeParte'],
			        "EmptySeries" => $dat['SeriesVaciadas'],
			        "Badge" => $dat['Badge'],
			        "Name" => $dat['Nombre'],
			        "Fecha" => $dat['Fecha']
			    );
			}
			 $response = array('response' => 'success', 'data' => $data);
		}
		else{
			 $response = array('response' => 'fail');
		}
		
		echo json_encode($response);
	}
	elseif ($request == 'getByTurn') {
		$horario = ($_REQUEST['horario']);

		echo $horario['horaEntrada']." ".$horario['horaSalida'];		
	}
?>