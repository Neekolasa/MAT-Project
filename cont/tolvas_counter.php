<?php 
    include '../../connection.php';
    $request = $_REQUEST['request'];
    if ($request=='getTolvasInfo') {
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
	         	--S.Salida IS NOT NULL AND
	            (ChkComp_MainMov.ScanDate>=E.Entrada AND ChkComp_MainMov.ScanDate<=S.Salida)
	            AND ChkComp_MainMov.SN IS NOT NULL
	            AND E.Route NOT LIKE '%CRITICO%'
	            --AND E.Route = 'RUTA22'
	        GROUP BY E.Route, E.Entrada, S.Salida,ChkComp_RouteOwner.Name,ChkComp_RouteOwner.ProductionLine
	        ORDER BY E.Route ASC
	    ";
	    $sqlQuery = sqlsrv_query($conn, $sqlStatement);

	    $datos = array();
	    while ($data = sqlsrv_fetch_array($sqlQuery, SQLSRV_FETCH_ASSOC)) {
	        array_push($datos, array(
	            "Ruta" => $data['Route'],
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
    	$sqlStatement = "SELECT * FROM ChkComp_RouteOwner ORDER BY Route ASC";
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

		// Obtener los valores enviados por el formulario
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
		    "RUTA11" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta11_Name', ProductionLine='$Ruta11_PL' WHERE Route='RUTA11'",
		    "RUTA12" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta12_Name', ProductionLine='$Ruta12_PL' WHERE Route='RUTA12'",
		    "RUTA13" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta13_Name', ProductionLine='$Ruta13_PL' WHERE Route='RUTA13'",
		    "RUTA14" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta14_Name', ProductionLine='$Ruta14_PL' WHERE Route='RUTA14'",
		    "RUTA15" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta15_Name', ProductionLine='$Ruta15_PL' WHERE Route='RUTA15'",
		    "RUTA16" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta16_Name', ProductionLine='$Ruta16_PL' WHERE Route='RUTA16'",
		    "RUTA17" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta17_Name', ProductionLine='$Ruta17_PL' WHERE Route='RUTA17'",
		    "RUTA18" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta18_Name', ProductionLine='$Ruta18_PL' WHERE Route='RUTA18'",
		    "RUTA19" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta19_Name', ProductionLine='$Ruta19_PL' WHERE Route='RUTA19'",
		    "RUTA20" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta20_Name', ProductionLine='$Ruta20_PL' WHERE Route='RUTA20'",
		    "RUTA21" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta21_Name', ProductionLine='$Ruta21_PL' WHERE Route='RUTA21'",
		    "RUTA22" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta22_Name', ProductionLine='$Ruta22_PL' WHERE Route='RUTA22'",
		    "RUTA23" => "UPDATE ChkComp_RouteOwner SET Name='$Ruta23_Name', ProductionLine='$Ruta23_PL' WHERE Route='RUTA23'"
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
    
?>
