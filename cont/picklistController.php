<?php
	include '../../connection.php'; 
	$request = $_REQUEST['request'];

	if ($request == 'getInfo') {
		$sqlStatement = "
		SELECT 
		    ChkB_SrvMax.PN, 
		    ChkB_SrvMax.SrvMax, 
		    COUNT(ChkBTS_SNMaster.SN) AS 'Activas',
		    ChkB_SrvMax.SrvMax - COUNT(ChkBTS_SNMaster.SN) AS 'Diferencia',
		    COALESCE(PFEP_Map.R + PFEP_Map.S + PFEP_Map.L + PFEP_Map.P, 'NA') AS 'Location',
		    ChkBTS_SNMaster.Mtype,
		    CASE 
		        WHEN (ChkB_SrvMax.SrvMax - COUNT(ChkBTS_SNMaster.SN)) > 0 THEN 
		            'Surtir ' + CAST(ChkB_SrvMax.SrvMax - COUNT(ChkBTS_SNMaster.SN) AS VARCHAR) + ' series'
		        WHEN (ChkB_SrvMax.SrvMax - COUNT(ChkBTS_SNMaster.SN)) < 0 THEN 
		            'Series activas superan la cantidad en servicio maximo'
		        ELSE 
		            'Ok'
		    END AS 'Comentario'
		FROM 
		    ChkB_SrvMax
		LEFT JOIN 
		    ChkBTS_SNMaster 
		ON 
		    ChkB_SrvMax.PN = ChkBTS_SNMaster.PN
		LEFT JOIN 
		    PFEP_Map 
		ON 
		    ChkB_SrvMax.PN = PFEP_Map.PN
		WHERE 
		    ChkBTS_SNMaster.Status <> 'EMPTY'
			AND
			(PFEP_Map.R+S+L+P NOT LIKE '%A%' AND PFEP_Map.R+S+L+P NOT LIKE '%OB%')
		GROUP BY 
		    ChkB_SrvMax.PN, 
		    ChkB_SrvMax.SrvMax,
			ChkBTS_SNMaster.Mtype,
		    PFEP_Map.R + PFEP_Map.S + PFEP_Map.L + PFEP_Map.P
		";

		$sql_query = sqlsrv_query($conn,$sqlStatement);

		$data = array();
		while ($datos = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
			$haystack = $datos["Comentario"];
			$needle = "Surtir";
			if(strpos($haystack, $needle) !== false ){
				array_push($data, array(
					"PN"=>$datos["PN"],
					"SrvMax"=>$datos["SrvMax"],
					"Activas"=>$datos["Activas"],
					"Diferencia"=>$datos["Diferencia"],
					"Location"=>$datos["Location"],
					"Comentario"=>$datos["Comentario"],
					"Mtype"=>$datos["Mtype"]

				));
			}
			
		}
		echo json_encode($data);
	}

?>