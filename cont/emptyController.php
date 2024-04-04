<?php
	include '../../connection.php';
	$request = $_REQUEST['request'];
	$fechaActual = date('Y-m-d');
	$horaInicioTurnoA = '06:00';
	$horaFinTurnoA = '15:36';
	$horaInicioTurnoB = '15:37';
	$horaFinTurnoB = '00:15';
	//$turno = $_REQUEST['turno'];
	if ($request == 'getCriticalTable') {
		$turno = $_REQUEST['turno'];

		if ($turno == 'B') {
		    $fechaSiguiente = date('Y-m-d', strtotime($fecha . ' + 1 day'));
    
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
		            AND CONVERT(date, Smk_InvDet.ActionDate) >= '".$fechaActual." 15:37'
		            AND CONVERT(date, Smk_InvDet.ActionDate) <= '".$fechaSiguiente." 00:15'
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
		} else {
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
		            AND CONVERT(date, Smk_InvDet.ActionDate) = '".$fechaActual."'
		            AND CONVERT(time, Smk_InvDet.ActionDate) BETWEEN '06:00' AND '15:36'
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
		}
		
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
			        "Fecha" => $dat['Fecha'],
			        "Actions" => "<button class='btn btn-primary' onclick='seeLinks(\"".$dat['SN']."\")'><i class='fa fa-link'></i> Ver enlaces</button>"
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
		$turno = $_REQUEST['turno'];
		if ($turno == 'B') {
		    $fechaSiguiente = date('Y-m-d', strtotime($fechaActual . ' + 1 day'));
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
		            CONVERT(date, Smk_InvDet.ActionDate) >= CONVERT(datetime, '$fechaActual $horaInicioTurnoB')
		            AND CONVERT(date, Smk_InvDet.ActionDate) < CONVERT(datetime, '$fechaSiguiente $horaFinTurnoB')
		        GROUP BY 
		            Smk_InvDet.Badge,
		            Sy_Users.Name,
		            Sy_Users.LastName
		        HAVING 
		            COUNT(CASE WHEN COALESCE(Smk_InvDet.Action, 'NA') = 'EMPTY' THEN 1 ELSE NULL END) > 0
		        ORDER BY 
		            SeriesVacias DESC;
		    ";
		} else {
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
		            CONVERT(datetime, Smk_InvDet.ActionDate) >= CONVERT(datetime, '$fechaActual $horaInicioTurnoA')
	            	AND CONVERT(datetime, Smk_InvDet.ActionDate) <= CONVERT(datetime, '$fechaActual $horaFinTurnoA')
		        GROUP BY 
		            Smk_InvDet.Badge,
		            Sy_Users.Name,
		            Sy_Users.LastName
		        HAVING 
		            COUNT(CASE WHEN COALESCE(Smk_InvDet.Action, 'NA') = 'EMPTY' THEN 1 ELSE NULL END) > 0
		        ORDER BY 
		            SeriesVacias DESC;
		    ";
		}
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
		$turno = $_REQUEST['turno'];
		if ($turno == 'B') {
	    $fechaSiguiente = date('Y-m-d', strtotime($fechaActual . ' + 1 day'));
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
	            CONVERT(datetime, Smk_InvDet.ActionDate) >= CONVERT(datetime, '$fechaActual $horaInicioTurnoB')
	            AND CONVERT(datetime, Smk_InvDet.ActionDate) < CONVERT(datetime, '$fechaSiguiente $horaFinTurnoB')
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
	} else {
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
	            CONVERT(datetime, Smk_InvDet.ActionDate) >= CONVERT(datetime, '$fechaActual $horaInicioTurnoA')
	            AND CONVERT(datetime, Smk_InvDet.ActionDate) <= CONVERT(datetime, '$fechaActual $horaFinTurnoA')
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
	}
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
		$turno = $_REQUEST['turno'];
		$fecha = $_REQUEST['fecha'];

		$response = array();
		if ($turno == 'B') {
			$fechaSiguiente = date('Y-m-d', strtotime($fecha . ' + 1 day'));

			$sqlStatement_getCriticalTable="
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
			        AND Smk_InvDet.ActionDate BETWEEN '".$fecha." ".$horario['horaEntrada']."' AND '".$fechaSiguiente." ".$horario['horaSalida']."'
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

			$sqlQuery_getCriticalTable = sqlsrv_query($conn,$sqlStatement_getCriticalTable);
			if ($sqlQuery_getCriticalTable!==false) {
				$data = array();
				while ($dat = sqlsrv_fetch_array($sqlQuery_getCriticalTable,SQLSRV_FETCH_ASSOC)) {
					$data[] = array(
				        "PN" => "$dat[PN]",
				        "SN" => $dat['SN'],
				        "Badge" => "$dat[Badge]",
				        "Name" => $dat['Name'],
				        "Action" => $dat['Action'],	
				        "Fecha" => "$dat[Fecha]",
				        "Actions" => "<button class='btn btn-primary' onclick='seeLinks(\"".$dat['SN']."\")'><i class='fa fa-link'></i> Ver enlaces</button>"

				    );
				}
				array_push($response,array('getCriticalTable'=>$data));
				
			}
			else{
				$response = array('response' => 'fail');
			}

			$sqlStatement_getEmptyUsers="
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
				    Smk_InvDet.ActionDate BETWEEN '".$fecha." ".$horario['horaEntrada']."' AND '".$fechaSiguiente." ".$horario['horaSalida']."'
				GROUP BY 
				    Smk_InvDet.Badge,
				    Sy_Users.Name,
				    Sy_Users.LastName
				HAVING 
				    COUNT(CASE WHEN COALESCE(Smk_InvDet.Action, 'NA') = 'EMPTY' THEN 1 ELSE NULL END) > 0
				ORDER BY 
				    SeriesVacias DESC;
			";

			$sqlQuery_getEmptyUsers = sqlsrv_query($conn,$sqlStatement_getEmptyUsers);
			if ($sqlQuery_getEmptyUsers!==false) {
				$data = array();
				while ($dat = sqlsrv_fetch_array($sqlQuery_getEmptyUsers,SQLSRV_FETCH_ASSOC)) {
					$data[] = array(
				        "Badge" => "$dat[Badge]",
				        "Name" => $dat['Name'],
				        "LastName" => $dat['LastName'],
				        "SeriesVacias" => "$dat[SeriesVacias]",
				        "Fecha" => "$dat[Fecha]"
				    );
				}
				array_push($response,array('getEmptyUsers'=>$data));
				
			}
			else{
				$response = array('response' => 'fail');
			}

		$sqlStatement_getEmptyNumbers = "
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
			    Smk_InvDet.ActionDate BETWEEN '".$fecha." ".$horario['horaEntrada']."' AND '".$fechaSiguiente." ".$horario['horaSalida']."'
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
		$sqlQuery_getEmptyNumbers = sqlsrv_query($conn,$sqlStatement_getEmptyNumbers);
		if ($sqlQuery_getEmptyNumbers!==false) {
			$data = array();
			while ($dat = sqlsrv_fetch_array($sqlQuery_getEmptyNumbers,SQLSRV_FETCH_ASSOC)) {
				$data[] = array(
			        "PartNumber" => "$dat[NumeroDeParte]",
			        "EmptySeries" => "$dat[SeriesVaciadas]",
			        "Badge" => "$dat[Badge]",
			        "Name" => $dat['Nombre'],
			        "Fecha" => "$dat[Fecha]"
			    );
			}
			 array_push($response,array('getEmptyNumbers'=>$data));
		}
		else{
			 $response = array('response' => 'fail');
		}
		
		echo json_encode($response);


			

		}
		else{
			$fechaSiguiente = date('Y-m-d', strtotime($fecha . ' + 1 day'));

			$sqlStatement_getCriticalTable="
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
			        AND Smk_InvDet.ActionDate BETWEEN '".$fecha." ".$horario['horaEntrada']."' AND '".$fecha." ".$horario['horaSalida']."'
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

			$sqlQuery_getCriticalTable = sqlsrv_query($conn,$sqlStatement_getCriticalTable);
			if ($sqlQuery_getCriticalTable!==false) {
				$data = array();
				while ($dat = sqlsrv_fetch_array($sqlQuery_getCriticalTable,SQLSRV_FETCH_ASSOC)) {
					$data[] = array(
				        "PN" => "$dat[PN]",
				        "SN" => $dat['SN'],
				        "Badge" => "$dat[Badge]",
				        "Name" => $dat['Name'],
				        "Action" => $dat['Action'],	
				        "Fecha" => "$dat[Fecha]",
				        "Actions" => "<button class='btn btn-primary' onclick='seeLinks(\"".$dat['SN']."\")'><i class='fa fa-link'></i> Ver enlaces</button>"
				    );
				}
				array_push($response,array('getCriticalTable'=>$data));
				
			}
			else{
				$response = array('response' => 'fail');
			}
		
			$sqlStatement_getEmptyUsers="
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
					    Smk_InvDet.ActionDate BETWEEN '".$fecha." ".$horario['horaEntrada']."' AND '".$fecha." ".$horario['horaSalida']."'
					GROUP BY 
					    Smk_InvDet.Badge,
					    Sy_Users.Name,
					    Sy_Users.LastName
					HAVING 
					    COUNT(CASE WHEN COALESCE(Smk_InvDet.Action, 'NA') = 'EMPTY' THEN 1 ELSE NULL END) > 0
					ORDER BY 
					    SeriesVacias DESC;
				";

				$sqlQuery_getEmptyUsers = sqlsrv_query($conn,$sqlStatement_getEmptyUsers);
				if ($sqlQuery_getEmptyUsers!==false) {
					$data = array();
					while ($dat = sqlsrv_fetch_array($sqlQuery_getEmptyUsers,SQLSRV_FETCH_ASSOC)) {
						$data[] = array(
					        "Badge" => "$dat[Badge]",
					        "Name" => $dat['Name'],
					        "LastName" => $dat['LastName'],
					        "SeriesVacias" => "$dat[SeriesVacias]",
					        "Fecha" => "$dat[Fecha]"
					    );
					}
					array_push($response,array('getEmptyUsers'=>$data));
					
				}
				else{
					$response = array('response' => 'fail');
				}
			$sqlStatement_getEmptyNumbers = "
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
				    Smk_InvDet.ActionDate BETWEEN '".$fecha." ".$horario['horaEntrada']."' AND '".$fecha." ".$horario['horaSalida']."'
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
			$sqlQuery_getEmptyNumbers = sqlsrv_query($conn,$sqlStatement_getEmptyNumbers);
			if ($sqlQuery_getEmptyNumbers!==false) {
				$data = array();
				while ($dat = sqlsrv_fetch_array($sqlQuery_getEmptyNumbers,SQLSRV_FETCH_ASSOC)) {
					$data[] = array(
				        "PartNumber" => "$dat[NumeroDeParte]",
				        "EmptySeries" => "$dat[SeriesVaciadas]",
				        "Badge" => "$dat[Badge]",
				        "Name" => $dat['Nombre'],
				        "Fecha" => "$dat[Fecha]"
				    );
				}
				 array_push($response,array('getEmptyNumbers'=>$data));
			}
			else{
				 $response = array('response' => 'fail');
			}
			echo json_encode($response);
		}
		//echo 'Hora entrada '.$horario['horaEntrada']."\n".'Hora salida '.$horario['horaSalida']."\n".'Fecha Inicial '.$fecha."\n".'Fecha Final '.$fechaSiguiente;
		//echo $horario['horaEntrada']." ".$horario['horaSalida'];	
		

	}
	elseif ($request == 'getByPN') {
		$partNumber = $_REQUEST['partNumber'];
		$params = array($partNumber);

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
		            AND Smk_Inv.PN = '$partNumber'
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
		   
		    $sqlQuery = sqlsrv_query($conn,$sqlStatement,$params);
			if ($sqlQuery!==false) {
				$data = array();
				while ($dat = sqlsrv_fetch_array($sqlQuery,SQLSRV_FETCH_ASSOC)) {
					$data[] = array(
				        "PN" => $dat['PN'],
				        "SN" => $dat['SN'],
				        "Badge" => $dat['Badge'],
				        "Name" => $dat['Name'],
				        "Action" => $dat['Action'],	
				        "Fecha" => $dat['Fecha'],
				        "Actions" => "<button class='btn btn-primary' onclick='seeLinks(\"".$dat['SN']."\")'><i class='fa fa-link'></i> Ver enlaces</button>"
				    );
				}
				 $response = array('response' => 'success', 'data' => $data);
			}
			else{
				 $response = array('response' => 'fail');
			}
			
			echo json_encode($response);
	}
	elseif ($request == 'getLinksInfo') {
		$serial = $_REQUEST['serial'];

		$sqlStatement = "
			SELECT        
				IdKanban,
				ContType,
				Qty, 
				UoM, 
				COALESCE(CONVERT(varchar, MAX(ChkComp_MainMov.ScanDate), 1) + ' ' + RIGHT(CONVERT(varchar, MAX(ChkComp_MainMov.ScanDate), 100), 7), 'NA') AS Fecha, 
				Route, 
				ChkComp_MainMov.Badge,
				COALESCE(Sy_Users.Name +' '+ Sy_Users.LastName, 'CHECKPOINT') AS [Name],
				Status
			FROM ChkComp_MainMov FULL JOIN Sy_Users ON ChkComp_MainMov.Badge = Sy_Users.Badge
			WHERE (SN = '$serial')
			group by IdKanban, Qty, UoM, SNScanDate, Route, ChkComp_MainMov.Badge, Status, ContType,Sy_Users.Name,Sy_Users.LastName
			ORDER BY SNScanDate DESC;

		";
		$sqlStatement_stdPack = "
			SELECT 
			    ChkComp_MainMov.PN,
			    SUM(Qty) AS CantidadEnlazada,
			    PFEP_MasterV2.StdPack
			FROM 
			    ChkComp_MainMov 
			JOIN 
			    PFEP_MasterV2 ON ChkComp_MainMov.PN = PFEP_MasterV2.PN
			WHERE 
			    (SN = '$serial')
			GROUP BY 
			    ChkComp_MainMov.PN, 
			    PFEP_MasterV2.StdPack;
		";
		
		$sqlQuery = sqlsrv_query($conn, $sqlStatement);
		if ($sqlQuery !== false) {
		    $data = array();
		    while ($dat = sqlsrv_fetch_array($sqlQuery, SQLSRV_FETCH_ASSOC)) {
		        $data[] = array(
		            "IdKanban" => "$dat[IdKanban]",
		            "ContType" => $dat['ContType'],
		            "Qty" => "$dat[Qty]",
		            "UoM" => $dat['UoM'],
		            "Fecha" => "$dat[Fecha]",
		            "Route" => $dat['Route'],
		            "Badge" => "$dat[Badge]",
		            "Name" => $dat['Name'],
		            "Status" => $dat['Status']
		        );
		    }
		    if (empty($data)) {
		        $response = array('response' => 'empty');
		    } else {
		        $response = array('response'=>'success','getLinkInfo' => $data);
		    }
		} else {
		    $response = array('response' => 'fail');
		}

		$sqlQuery_stdPack = sqlsrv_query($conn, $sqlStatement_stdPack);
		if ($sqlQuery_stdPack !== false) {
		    $data = array();
		    while ($dat = sqlsrv_fetch_array($sqlQuery_stdPack, SQLSRV_FETCH_ASSOC)) {
		        $data[] = array(
		            "PN" => "$dat[PN]",
		            "CantidadEnlazada" => "$dat[CantidadEnlazada]",
		            "StdPack" => "$dat[StdPack]"
		        );
		    }
		    if (empty($data)) {
		        $response = array('response' => 'empty');
		    } else {
		        array_push($response,array("getStdPack"=>$data));
		    }
		} else {
		    $response = array('response' => 'fail');
		}
		echo json_encode($response);
	}
?>