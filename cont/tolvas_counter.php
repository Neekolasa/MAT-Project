<?php 
    include '../../connection.php';
    $request = $_REQUEST['request'];
    if ($request=='getTolvasInfo') {
    	$turno = $_REQUEST['turno'];
    	$fecha_inicial = $_REQUEST['fecha'];
    	$fecha_inicial = date('Y-m-d', strtotime($fecha_inicial));
    	if ($turno == "A") {
    		$sqlStatement = "
		        WITH Entradas AS (
		            SELECT 
		                Route,
		                ActionDate AS Entrada,
		                ROW_NUMBER() OVER (PARTITION BY Route ORDER BY ActionDate) AS EntradaNumero
		            FROM 
		                ChkComp_RoutesLog 
		            WHERE 
		                Action = 'IN'
		                AND CONVERT(DATE, ActionDate) = CONVERT(DATE, '$fecha_inicial')
		        ),
		        Salidas AS (
		            SELECT 
		                Route,
		                DATEADD(SECOND, 10, ActionDate) AS Salida,

		                ROW_NUMBER() OVER (PARTITION BY Route ORDER BY ActionDate) AS SalidaNumero
		            FROM 
		                ChkComp_RoutesLog 
		            WHERE 
		                Action = 'OUT'
		                AND CONVERT(DATE, ActionDate) = CONVERT(DATE, '$fecha_inicial')
		        )
		        SELECT 
		            E.Route,
		            E.Entrada,
		            S.Salida,
		            ROW_NUMBER() OVER (PARTITION BY E.Route ORDER BY E.Entrada) AS Vueltas,
		            COUNT(ChkComp_MainMov.SN) AS TolvasEnlazadas,
		            ChkComp_RouteOwner.Name +' - '+ChkComp_RouteOwner.ProductionLine  as RouteOwner
		        FROM 
		            Entradas E
		            JOIN Salidas S ON E.Route = S.Route AND E.EntradaNumero = S.SalidaNumero
		            JOIN ChkComp_MainMov ON E.Route = ChkComp_MainMov.Route
		            JOIN ChkComp_RouteOwner ON E.Route = ChkComp_RouteOwner.Route
		        WHERE
		         	
		            (ChkComp_MainMov.ScanDate>=E.Entrada AND ChkComp_MainMov.ScanDate<=S.Salida)
		            AND ChkComp_MainMov.SN IS NOT NULL
		            AND E.Route NOT LIKE '%CRITICO%'
		           	AND (S.Salida>='$fecha_inicial 06:00' AND S.Salida<='$fecha_inicial 15:36')
		            AND ChkComp_RouteOwner.Turno = 'A'
		        GROUP BY E.Route, E.Entrada, S.Salida,ChkComp_RouteOwner.Name,ChkComp_RouteOwner.ProductionLine
		        ORDER BY E.Route ASC
		    ";
		    //echo "$sqlStatement";
    	}
    	else{
    		$fecha_final = date('Y-m-d', strtotime($fecha_inicial . ' +1 day'));
    		$sqlStatement = "
		        WITH Entradas AS (
		            SELECT 
		                Route,
		                ActionDate AS Entrada,
		                ROW_NUMBER() OVER (PARTITION BY Route ORDER BY ActionDate) AS EntradaNumero
		            FROM 
		                ChkComp_RoutesLog 
		            WHERE 
		                Action = 'IN'
		                AND CONVERT(DATE, ActionDate) = CONVERT(DATE, '$fecha_inicial')
		        ),
		        Salidas AS (
		            SELECT 
		                Route,
		                DATEADD(SECOND, 10, ActionDate) AS Salida,

		                ROW_NUMBER() OVER (PARTITION BY Route ORDER BY ActionDate) AS SalidaNumero
		            FROM 
		                ChkComp_RoutesLog 
		            WHERE 
		                Action = 'OUT'
		                AND CONVERT(DATE, ActionDate) = CONVERT(DATE, '$fecha_inicial')
		        )
		        SELECT 
		            E.Route,
		            E.Entrada,
		            S.Salida,
		            ROW_NUMBER() OVER (PARTITION BY E.Route ORDER BY E.Entrada) AS Vueltas,
		            COUNT(ChkComp_MainMov.SN) AS TolvasEnlazadas,
		            ChkComp_RouteOwner.Name +' - '+ChkComp_RouteOwner.ProductionLine  as RouteOwner
		        FROM 
		            Entradas E
		            JOIN Salidas S ON E.Route = S.Route AND E.EntradaNumero = S.SalidaNumero
		            JOIN ChkComp_MainMov ON E.Route = ChkComp_MainMov.Route
		            JOIN ChkComp_RouteOwner ON E.Route = ChkComp_RouteOwner.Route
		        WHERE
		         	
		            (ChkComp_MainMov.ScanDate>=E.Entrada AND ChkComp_MainMov.ScanDate<=S.Salida)
		            AND ChkComp_MainMov.SN IS NOT NULL
		            AND E.Route NOT LIKE '%CRITICO%'
		           	AND (S.Salida>='$fecha_inicial 15:36' AND S.Salida<='$fecha_final 0:30')
		            AND ChkComp_RouteOwner.Turno = 'B'
		        GROUP BY E.Route, E.Entrada, S.Salida,ChkComp_RouteOwner.Name,ChkComp_RouteOwner.ProductionLine
		        ORDER BY E.Route ASC
		    ";

    	}

	    $sqlQuery = sqlsrv_query($conn, $sqlStatement);

	    $datos = array();
	    while ($data = sqlsrv_fetch_array($sqlQuery, SQLSRV_FETCH_ASSOC)) {
	        array_push($datos, array(
	            "Ruta" => routeName($data['Route']),
	            "FullRuta"=>$data['Route'],
	            "Entrada" => $data['Entrada']->format('H:i'), // Formato de fecha y hora
	            "Salida" => $data['Salida']->format('H:i'), // Formato de fecha y hora
	            "Vuelta" => $data['Vueltas']+0,
	            "Tolvas" => $data['TolvasEnlazadas'],
	            "RouteOwner" => $data['RouteOwner']
	          
	        ));
	    }

	    echo json_encode($datos);
    }
    elseif ($request=='getVueltasMax') {
    	$sqlStatement="
    		WITH Entradas AS (
	            SELECT 
	                Route,
	                ActionDate AS Entrada,
	                ROW_NUMBER() OVER (PARTITION BY Route ORDER BY ActionDate) AS EntradaNumero
	            FROM 
	                ChkComp_RoutesLog 
	            WHERE 
	                Action = 'IN'
	                AND CONVERT(DATE, ActionDate) = CONVERT(DATE, GETDATE())
	        ),
	        Salidas AS (
	            SELECT 
	                Route,
	                DATEADD(SECOND, 10, ActionDate) AS Salida,

	                ROW_NUMBER() OVER (PARTITION BY Route ORDER BY ActionDate) AS SalidaNumero
	            FROM 
	                ChkComp_RoutesLog 
	            WHERE 
	                Action = 'OUT'
	                AND CONVERT(DATE, ActionDate) = CONVERT(DATE, GETDATE())
	        )
	        SELECT 
	           TOP 1
	            ROW_NUMBER() OVER (PARTITION BY E.Route ORDER BY E.Entrada) AS Vueltas
	           
	        FROM 
	            Entradas E
	            JOIN Salidas S ON E.Route = S.Route AND E.EntradaNumero = S.SalidaNumero
	            JOIN ChkComp_MainMov ON E.Route = ChkComp_MainMov.Route
	        WHERE
	            (ChkComp_MainMov.ScanDate>=E.Entrada AND ChkComp_MainMov.ScanDate<=S.Salida)
	            AND ChkComp_MainMov.SN IS NOT NULL
	            
	        GROUP BY E.Route, E.Entrada, S.Salida
	        ORDER BY Vueltas DESC

    	";

    	$sqlQuery = sqlsrv_query($conn,$sqlStatement);
    	$datos = array();
    	while ($data = sqlsrv_fetch_array($sqlQuery,SQLSRV_FETCH_ASSOC)) {
    		array_push($datos, array(
    			"Vueltas"=>$data['Vueltas']
    		));
    	}
    	//echo json_encode($datos);
    	$vueltas = $datos[0]['Vueltas'];
    	$return = array();
    	$loop = true;
    	for ($i=0; $i <$vueltas+1 ; $i++) { 
    		if ($loop) {
    			array_push($return, array(
    				"Ruta"
    			));
    			$loop = false;
    		}
    		else{
    			array_push($return, array(
    				"Vuelta ".$i
    			));
    		}

    	}
    	echo json_encode($return);
    	
    }
    elseif ($request == 'getRoutesOwners') {
    	$turno = $_REQUEST['turno'];
    	$sqlStatement = "SELECT * FROM ChkComp_RouteOwner WHERE Turno = '$turno' ORDER BY Route ASC";
    	$sqlQuery = sqlsrv_query($conn, $sqlStatement);

    	$datos = array();
    	while ($data = sqlsrv_fetch_array($sqlQuery, SQLSRV_FETCH_ASSOC)) {
    		array_push($datos, array(
    			"Route"=>$data['Route'],
    			"Name"=>$data['Name'],
    			"ProductionLine"=>$data['ProductionLine']

    		));
    	}
    	echo json_encode($datos);

    }
    elseif ($request == 'setRoutesOwners') {

    	// Arreglo de respuesta
		$response = array();
		$turno = $_REQUEST['turno'];

		// Obtener los valores enviados por el formulario
		$Ruta1_Name = $_REQUEST['Ruta1_Name'];
		$Ruta1_PL = $_REQUEST['Ruta1_PL'];

		$Ruta2_Name = $_REQUEST['Ruta2_Name'];
		$Ruta2_PL = $_REQUEST['Ruta2_PL'];

		$Ruta3_Name = $_REQUEST['Ruta3_Name'];
		$Ruta3_PL = $_REQUEST['Ruta3_PL'];

		$Ruta4_Name = $_REQUEST['Ruta4_Name'];
		$Ruta4_PL = $_REQUEST['Ruta4_PL'];

		$Ruta5_Name = $_REQUEST['Ruta5_Name'];
		$Ruta5_PL = $_REQUEST['Ruta5_PL'];

		$Ruta10_Name = $_REQUEST['Ruta10_Name'];
		$Ruta10_PL = $_REQUEST['Ruta10_PL'];

		$Ruta11_Name = $_REQUEST['Ruta11_Name'];
		$Ruta11_PL = $_REQUEST['Ruta11_PL'];

		$Ruta12_Name = $_REQUEST['Ruta12_Name'];
		$Ruta12_PL = $_REQUEST['Ruta12_PL'];

		$Ruta13_Name = $_REQUEST['Ruta13_Name'];
		$Ruta13_PL = $_REQUEST['Ruta13_PL'];

		$Ruta14_Name = $_REQUEST['Ruta14_Name'];
		$Ruta14_PL = $_REQUEST['Ruta14_PL'];

		$Ruta15_Name = $_REQUEST['Ruta15_Name'];
		$Ruta15_PL = $_REQUEST['Ruta15_PL'];

		$Ruta16_Name = $_REQUEST['Ruta16_Name'];
		$Ruta16_PL = $_REQUEST['Ruta16_PL'];

		$Ruta17_Name = $_REQUEST['Ruta17_Name'];
		$Ruta17_PL = $_REQUEST['Ruta17_PL'];

		$Ruta18_Name = $_REQUEST['Ruta18_Name'];
		$Ruta18_PL = $_REQUEST['Ruta18_PL'];

		$Ruta19_Name = $_REQUEST['Ruta19_Name'];
		$Ruta19_PL = $_REQUEST['Ruta19_PL'];

		$Ruta20_Name = $_REQUEST['Ruta20_Name'];
		$Ruta20_PL = $_REQUEST['Ruta20_PL'];

		$Ruta21_Name = $_REQUEST['Ruta21_Name'];
		$Ruta21_PL = $_REQUEST['Ruta21_PL'];

		$Ruta22_Name = $_REQUEST['Ruta22_Name'];
		$Ruta22_PL = $_REQUEST['Ruta22_PL'];

		$Ruta23_Name = $_REQUEST['Ruta23_Name'];
		$Ruta23_PL = $_REQUEST['Ruta23_PL'];

		// Consultas SQL para actualizar cada campo
		$sqlStatements = array(
			"RUTA1" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta1_Name', ProductionLine='$Ruta1_PL' WHERE Route='RUTA1' AND Turno='$turno'",
			"RUTA2" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta2_Name', ProductionLine='$Ruta2_PL' WHERE Route='RUTA2' AND Turno='$turno'",
			"RUTA3" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta3_Name', ProductionLine='$Ruta3_PL' WHERE Route='RUTA3' AND Turno='$turno'",
			"RUTA4" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta4_Name', ProductionLine='$Ruta4_PL' WHERE Route='RUTA4' AND Turno='$turno'",
			"RUTA5" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta5_Name', ProductionLine='$Ruta5_PL' WHERE Route='RUTA5' AND Turno='$turno'",
			"RUTA10" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta10_Name', ProductionLine='$Ruta10_PL' WHERE Route='RUTA10' AND Turno='$turno'",
		    "RUTA11" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta11_Name', ProductionLine='$Ruta11_PL' WHERE Route='RUTA11' AND Turno='$turno'",
		    "RUTA12" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta12_Name', ProductionLine='$Ruta12_PL' WHERE Route='RUTA12' AND Turno='$turno'",
		    "RUTA13" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta13_Name', ProductionLine='$Ruta13_PL' WHERE Route='RUTA13' AND Turno='$turno'",
		    "RUTA14" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta14_Name', ProductionLine='$Ruta14_PL' WHERE Route='RUTA14' AND Turno='$turno'",
		    "RUTA15" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta15_Name', ProductionLine='$Ruta15_PL' WHERE Route='RUTA15' AND Turno='$turno'",
		    "RUTA16" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta16_Name', ProductionLine='$Ruta16_PL' WHERE Route='RUTA16' AND Turno='$turno'",
		    "RUTA17" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta17_Name', ProductionLine='$Ruta17_PL' WHERE Route='RUTA17' AND Turno='$turno'",
		    "RUTA18" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta18_Name', ProductionLine='$Ruta18_PL' WHERE Route='RUTA18' AND Turno='$turno'",
		    "RUTA19" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta19_Name', ProductionLine='$Ruta19_PL' WHERE Route='RUTA19' AND Turno='$turno'",
		    "RUTA20" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta20_Name', ProductionLine='$Ruta20_PL' WHERE Route='RUTA20' AND Turno='$turno'",
		    "RUTA21" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta21_Name', ProductionLine='$Ruta21_PL' WHERE Route='RUTA21' AND Turno='$turno'",
		    "RUTA22" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta22_Name', ProductionLine='$Ruta22_PL' WHERE Route='RUTA22' AND Turno='$turno'",
		    "RUTA23" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta23_Name', ProductionLine='$Ruta23_PL' WHERE Route='RUTA23' AND Turno='$turno'"
		);

		// Ejecutar las consultas SQL y actualizar el arreglo de respuesta
		foreach ($sqlStatements as $route => $sql) {
		    $sqlQuery = sqlsrv_query($conn, $sql);
		    
		}
		if ($sqlQuery) {
		        // Consulta exitosa
		        $response[] = "Success";
		    } else {
		        // Consulta fallida
		        $response[] = "Fail";
		    }

		// Imprimir el arreglo de respuesta como JSON
		echo json_encode($response);

    }
    elseif ($request == 'setLoggon') {
    	$name = $_REQUEST['name'];
    	$turno = $_REQUEST['turno'];
		$date = date('Y-m-d H:i', strtotime($_REQUEST['date']));
		$dateOne = date('Y-m-d', strtotime($_REQUEST['date']));

		/*CHECK IF LOGIN EXIST*/
		$sqlStatement_Check = "SELECT COUNT(*) AS Visita FROM ChkComp_Checklist WHERE (CONVERT(date, Fecha) = '$dateOne') AND Nombre = '$name'";

		$query_result = sqlsrv_query($conn, $sqlStatement_Check);

		if($query_result === false) {
		    die( print_r( sqlsrv_errors(), true));
		}

		$row = sqlsrv_fetch_array($query_result, SQLSRV_FETCH_ASSOC);

		$count = $row['Visita'];
		//if ($count >= 1) {
		if (false) {
		    $response_array = array('response' => 'fail');
		} else {
			$sqlStatement_Insert = "INSERT INTO ChkComp_Checklist(Nombre, Fecha,Turno) VALUES ('$name','$date','$turno')";
			$query_result = sqlsrv_query($conn, $sqlStatement_Insert);
			if ($query_result) {
				$response_array = array('response' => 'success');
			}
			else{
				$response_array = array('response' => 'error');
			}
		}

		echo json_encode($response_array);
    }
    elseif ($request == 'getReview') {
    	$turno = $_REQUEST['turno'];
    	//$fecha = $_REQUEST['fecha'];
    	$dateOne = date('Y-m-d', strtotime($_REQUEST['fecha']));
    	$sqlStatement = "SELECT * FROM ChkComp_Checklist WHERE Turno = '$turno' AND (CONVERT(date, Fecha)  = '$dateOne')";
    	
    	$query_result = sqlsrv_query($conn,$sqlStatement);
    	$data = array();
    	while ($datos = sqlsrv_fetch_array($query_result,SQLSRV_FETCH_ASSOC)) {
    		array_push($data, array(
    			"Nombre" => $datos['Nombre'],
    			"Fecha" => $datos['Fecha']
    		));
    	}

    	echo json_encode($data);
    }
    function routeName($name) {
    switch ($name) {
    	CASE 'RUTA1':
    		return 'R01';
    	CASE 'RUTA2':
    		return 'R02';
    	CASE 'RUTA3':
    		return 'R03';
    	case 'RUTA4':
            return 'R04';
        case 'RUTA5':
            return 'R05';
        case 'RUTA10':
            return 'R10';
        case 'RUTA11':
            return 'R11';
        case 'RUTA12':
            return 'R12';
        case 'RUTA13':
            return 'R13';
        case 'RUTA14':
            return 'R14';
        case 'RUTA15':
            return 'R15';
        case 'RUTA16':
            return 'R16';
        case 'RUTA17':
            return 'R17';
        case 'RUTA18':
            return 'R18';
        case 'RUTA19':
            return 'R19';
        case 'RUTA20':
            return 'R20';
        case 'RUTA21':
            return 'R21';
        case 'RUTA22':
            return 'R22';
        case 'RUTA23':
            return 'R23';
        default:
            return $name; // Si no coincide con ningún caso, devuelve el nombre original
    }
}
?>
