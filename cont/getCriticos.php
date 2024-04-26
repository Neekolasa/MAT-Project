<?php
	include '../../connection.php';

	
	$request = $_GET['request'];
	if ($request == 'insert') {
		$datos = $_GET['datos'];
		$sql_query = sqlsrv_query($conn,"DELETE FROM numerosCriticos");

		for ($i=0; $i < count($datos); $i++) { 
			$data = strval($datos[$i]);
			$sql_statement= "INSERT INTO numerosCriticos VALUES ('$data','PENDING')";
			$sql_query = sqlsrv_query($conn,$sql_statement);
			//echo "$sql_statement";
		}
		

		echo json_encode(array('response' => 'success'));


	}
	else if ($request == 'getTableCriticos'){
		$sql_statement = "
		WITH NumerosCriticosStatus AS (
			    SELECT PN, Status
			    FROM numerosCriticos
			),
			NumeroSerieConRownum AS (
			    SELECT 
			        NC.PN,
			        COALESCE(RS.Serial, RSNH.Serial) AS Serial,
			        CASE 
			            WHEN RSNH.Located = 'Ramp' THEN 'RAMP'
			            ELSE RSNH.Located
			        END AS Locacion,
			        CASE 
			            WHEN RS.PN IS NOT NULL AND CONVERT(DATE, RS.ScanDate) = CONVERT(DATE, GETDATE()) THEN 'SIN LIBERAR'
			            WHEN RSNH.PN IS NOT NULL AND CONVERT(DATE, RSNH.ScanDate) = CONVERT(DATE, GETDATE()) AND RSNH.Located = 'Ramp' THEN 'RAMP'
			            WHEN RSNH.PN IS NOT NULL AND CONVERT(DATE, RSNH.ScanDate) = CONVERT(DATE, DATEADD(DAY, -1, GETDATE())) AND RSNH.Located <> 'Ramp' THEN 'RACKED'
			            ELSE 'PENDIENTE'
			        END AS Estatus,
			        ROW_NUMBER() OVER (PARTITION BY NC.PN, COALESCE(RS.Serial, RSNH.Serial) ORDER BY (SELECT NULL)) AS rn
			    FROM NumerosCriticosStatus NC
			    LEFT JOIN Rcv_Scan RS ON NC.PN = RS.PN AND CONVERT(DATE, RS.ScanDate) IN (CONVERT(DATE, GETDATE()), CONVERT(DATE, DATEADD(DAY, -1, GETDATE())))
			    LEFT JOIN Rcv_SNH RSNH ON NC.PN = RSNH.PN AND CONVERT(DATE, RSNH.ScanDate) IN (CONVERT(DATE, GETDATE()), CONVERT(DATE, DATEADD(DAY, -1, GETDATE())))
			)
			SELECT PN, Serial, Locacion,
			    CASE 
			        WHEN Locacion = 'RAMP' THEN 'RAMP' 
			        ELSE Estatus
			    END AS Estatus
			FROM NumeroSerieConRownum
			WHERE rn = 1;
";

		$sql_query = sqlsrv_query($conn,$sql_statement);
		$datos = array();
		while ($data = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
			if ($data['Estatus']=="SIN LIBERAR") {
				$status = "<b style='color:orange'>Sin Liberar</b>";
			}
			else if($data['Estatus']=="PENDIENTE")
			{
				$status = "<b style='color:red'>Pendiente</b>";
			}
			else if($data['Estatus']=="RAMP")
			{
				$status = "<b style='color:MediumSeaGreen'>Rampa</b>";
			}
			else if($data['Estatus']=="RACKED")
			{
				$status = "<b style='color:green'>Racked</b>";
			}
			else{
				$status = "";
			}
			if ($data['Serial']!="") {
				$serial = '0FV55900'.strval($data['Serial']);
			}
			else{
				
				$serial = strval($data['Serial']);
			}
			array_push($datos, array(
										'PN' => $data['PN'],
										'Serial' => $serial,
										'Estatus'=> $status ));
		}



		echo json_encode($datos);
		
	}


	

?>