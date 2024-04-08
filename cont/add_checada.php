<?php 
	include '../../connection.php';
	include 'encriptar.php';

	$array_excludes = array('80124238','80019367');

	/*$dataCheck['fk_badge']=='80124238' || $dataCheck['fk_badge']=='80019367' || $dataCheck['fk_badge']=='54512947' /*Pablo|| $dataCheck['fk_badge']=='54498748' || $dataCheck['fk_badge'] == '80050501*/
	
	$num_empleado = $_GET['num_empleado'];
	if ($_GET['request']	 == 'register') {
		$nombre_empleado = $_GET['nombre_empleado'];
		$salida_almuerzo = $_GET['salida_almuerzo'];
		$salida_comida 	 = $_GET['salida_comida'];
		$area_emp		 = $_GET['area_emp'];

		$sql_statement = "INSERT INTO SalidasPersonal 
							VALUES('$num_empleado','$nombre_empleado','$area_emp',$salida_almuerzo,$salida_comida)";
		$sql_query = sqlsrv_query($conn,$sql_statement);
		if ($sql_query == true) {
			echo json_encode(array('response' => 'success'));
		}
		else{
			echo json_encode(array('response' => 'fail'));
		}
	}
	else if($_GET['request'] == 'delete'){
		$sql_statement = "DELETE FROM SalidasPersonal
						  WHERE Badge = '$num_empleado'";
		$sql_query = sqlsrv_query($conn,$sql_statement);
		if ($sql_query == true) {
			echo json_encode(array('response' => 'success'));
		}
		else{
			echo json_encode(array('response' => 'fail'));
		}
	}
	else if($_GET['request'] == 'update'){
		$nombre_empleado = $_GET['nombre_empleado'];
		$salida_almuerzo = $_GET['salida_almuerzo'];
		$salida_comida 	 = $_GET['salida_comida'];
		$area_emp		 = $_GET['area_emp'];

		$sql_statement = "
		UPDATE SalidasPersonal
		   SET 	Nombre 		= '$nombre_empleado',
		      	Area   		= '$area_emp',
		      	Desayuno 	= $salida_almuerzo,
		      	Comida 		= $salida_comida
		 WHERE Badge = '$num_empleado'";

		$sql_query = sqlsrv_query($conn,$sql_statement);

		if ($sql_query == true) {
			echo json_encode(array('response' => 'success'));
		}
		else{
			echo json_encode(array('response' => 'fail'));
		}

	}
	else if($_GET['request'] == 'reg_admin'){
		$username = $_GET['username'];

		$password = $_GET['password'];

		$enc_password = encrypt($password,'APTIV');

		$sql_statement = "INSERT INTO rutas_admin VALUES ('$username','$enc_password')";
		$sql_query = sqlsrv_query($conn,$sql_statement);

		if ($sql_query == true) {
			echo json_encode(array('response' => 'success'));
		}
		else{
			echo json_encode(array('response' => 'fail'));
		}

	}
	elseif ($_GET['request'] == 'reg_checada') {
		

		date_default_timezone_set('America/Mexico_City');
		$unaHoraMenos = strtotime('-1 hour');
		$dataCheck = array(	'scanDate' => date('Y-m-d'),
							'scanHour' => date('H:i:s',strtotime('-1 hour')),
							'fk_badge' => strtoupper($_GET['num_empleado']));
		/*$dataCheck = array(	'scanDate' => date('Y-m-d'),
							'scanHour' => date('H:i:s',$unaHoraMenos),
							'scanHour' => date('H:i:s'),
							'fk_badge' => $_GET['num_empleado']);*/
		
		

		/*COMPROBAR QUE NO TENGA CHECADAS REGISTRADAS*/
		$sql_CheckStatement = "
								SELECT COUNT(*) as count
								FROM RegistroSalidas
								WHERE ScanDate = '$dataCheck[scanDate]'
								--AND ScanHour > '00:00'
								AND fk_badge = '$dataCheck[fk_badge]'";

		$sql_CheckQuery 	= sqlsrv_query($conn,$sql_CheckStatement);
		/*********************************************/

		if ($sql_CheckQuery !== false) {
	    $row = sqlsrv_fetch_array($sql_CheckQuery);
	    $row_count = $row['count'];
	    
		    if ($row_count > 0) {
				$sql_CheckNull = "
				    SELECT TOP 1 RS.ID, RS.SA, RS.EA, RS.SC, RS.EC, HDesayuno.TiempoSalida AS TiempoSalidaSa, HDesayuno.TiempoEntrada AS TiempoSalidaEa, HComida.TiempoSalida AS TiempoSalidaSc, HComida.TiempoEntrada AS TiempoSalidaEc
				    FROM RegistroSalidas AS RS
				    JOIN SalidasPersonal AS SP ON RS.fk_badge = SP.Badge
				    JOIN Horarios AS HDesayuno ON SP.Desayuno = HDesayuno.ID
				    JOIN Horarios AS HComida ON SP.Comida = HComida.ID
				    WHERE RS.fk_badge = '{$dataCheck['fk_badge']}'
				    AND (RS.SA IS NULL OR RS.EA IS NULL OR RS.SC IS NULL OR RS.EC IS NULL)";
				$sql_CheckQuery = sqlsrv_query($conn, $sql_CheckNull);

				if ($sql_CheckQuery && sqlsrv_has_rows($sql_CheckQuery)) {
				    $row = sqlsrv_fetch_array($sql_CheckQuery);

				    // Seleccionar el primer valor nulo (SA, EA, SC o EC)
				    $columnToUpdate = null;
				    foreach (['SA', 'EA', 'SC', 'EC'] as $column) {
				        $timeField = "TiempoSalida" . ucfirst(strtolower($column)); // Corregido
				        $timeToCheck = $row[$timeField]->format('H:i:s'); // Convertir a cadena de tiempo
				        $referenceTime = $dataCheck['scanHour'];

				        // Convertir las horas en segundos
				        $timeToCheckInSeconds = strtotime($timeToCheck);
				        $referenceTimeInSeconds = strtotime($referenceTime);

				        // Calcular la diferencia en minutos
				        $diffMinutes = abs(($timeToCheckInSeconds - $referenceTimeInSeconds) / 60);

				        if (is_null($row[$column])) {
				            // Si la diferencia es menor o igual a 5 minutos, el estado es 'OK', de lo contrario es 'BAD'
				            if (in_array($dataCheck['fk_badge'],$array_excludes)){
				           		$updateValue = 'OK';
				           	}
					        elseif (in_array($column, ['SA', 'SC'])) {
					          
					            $referenceTime = $dataCheck['scanHour'];
							    $timeToCheck = strtotime($timeToCheck);
							    $referenceTime = strtotime($referenceTime);
							    $lowerLimit = $timeToCheck - 5 * 60; 
							    $upperLimit = $timeToCheck + 10 * 60; 

							    if ($referenceTime >= $lowerLimit && $referenceTime <= $upperLimit) {
							        $updateValue = 'OK';
							    } else {
							        if ($referenceTime < $lowerLimit) {
							            $updateValue = 'BEF'; // (Excede 5 minutos antes)
							        } elseif ($referenceTime > $upperLimit) {
							            $updateValue = 'AFT'; // (Excede 10 minutos después)
							        } else {
							            $updateValue = 'BAD';
							        }
							    }
					        } 
					        elseif (in_array($column, ['EA', 'EC'])) {
					            
					            $referenceTime = $dataCheck['scanHour'];
					            $timeToCheck = strtotime($timeToCheck);
						        $referenceTime = strtotime($referenceTime);
						        $lowerLimit = $timeToCheck - 10 * 60;
						        $upperLimit = $timeToCheck + 5 * 60;
						       
						        if ($referenceTime >= $lowerLimit && $referenceTime <= $upperLimit) {
						            $updateValue = 'OK';
						        } else {
						        	
						            if ($referenceTime < $lowerLimit) {
							            $updateValue = 'BEF'; // (Excede 5 minutos antes)
							        } elseif ($referenceTime > $upperLimit) {
							            $updateValue = 'AFT'; // (Excede 10 minutos después)
							        } else {
							            $updateValue = 'BAD';
							        }
						        }		        
							}
						
				           $columnToUpdate = $column;
				           break;
				        }
				    }

				    // Actualizar solo el primer valor nulo encontrado
				    if (!is_null($columnToUpdate)) {
				        $updateSQL = "
				            UPDATE RegistroSalidas
				            SET $columnToUpdate = '$updateValue',
				            ScanHour = GETDATE()
				            WHERE ID = " . $row['ID'];
				        $sql_InsertQuery = sqlsrv_query($conn,$updateSQL);
				        if ($sql_InsertQuery==true) {
							echo json_encode(array('response' => 'success'));
						}
						else{
							echo json_encode(array('response' => 'fail'));
						}
				        // Ejecutar la consulta de actualización
				        // Supongamos que $updateResult es el resultado de la consulta de actualización
				    }
				}




			}
		    else {
		    	/*OBTENER HORA DE SALIDA A DESAYUNO*/
		    	$sql_SAStatement = "SELECT 
		    						   SUBSTRING(CONVERT(varchar, HDesayuno.TiempoSalida, 108), 1, 5) AS TiempoSalidaDesayuno
		    						FROM SalidasPersonal AS SP
		    						JOIN Horarios AS HDesayuno ON SP.Desayuno = HDesayuno.ID
		    						JOIN Horarios AS HComida ON SP.Comida = HComida.ID WHERE Badge = '$dataCheck[fk_badge]'";
		    	$sql_SAQuery = sqlsrv_query($conn,$sql_SAStatement);
		    	$time = sqlsrv_fetch_array($sql_SAQuery);

		    	if ($sql_SAQuery!=true) {
					echo json_encode(array('response' => 'fail'));
				}
				else{
					if (in_array($dataCheck['fk_badge'],$array_excludes)) {
						$status = 'OK';
					}
					else{
						echo 'dsdsds';
						$status = getStatus($dataCheck['scanHour'],$time['TiempoSalidaDesayuno']);
					}
					

			        $sql_InsertStatement = "INSERT INTO RegistroSalidas
			        			(ScanDate, ScanHour, SA, fk_badge)
								VALUES ('$dataCheck[scanDate]', '$dataCheck[scanHour]', '$status', '$dataCheck[fk_badge]')";

					$sql_InsertQuery = sqlsrv_query($conn,$sql_InsertStatement);
					if ($sql_InsertQuery==true) {
						echo json_encode(array('response' => 'success'));
					}
					else{
						echo json_encode(array('response' => 'fail'));
					}
				}
			
		    	
				//echo json_encode($sql_InsertStatement);
		    }
		} 
		else {
		   // echo json_encode(array('response' => 'fail'));
		}



		//echo json_encode($dataCheck);
	}
	function getStatus($hora,$salida){

		
		if ($hora>=restarMinutos($salida) && $hora<=sumarMinutos($salida)) {
			return 'OK';
		}
		else{
			return 'BAD';
		}
	}
	function restarMinutos($tiempo) {
    list($horas, $minutos) = explode(":", $tiempo);
    
    $totalMinutos = ($horas * 60) + $minutos - 5;
    
    if ($totalMinutos < 0) {
        $totalMinutos += 1440; // Agregar un día en minutos (24 horas * 60 minutos)
    }
    
    $nuevasHoras = floor($totalMinutos / 60);
    $nuevosMinutos = $totalMinutos % 60;
    
    return sprintf("%02d:%02d", $nuevasHoras, $nuevosMinutos);
}

	function sumarMinutos($salida) {
    list($horas, $minutos) = explode(":", $salida);
    
    $totalMinutos = ($horas * 60) + $minutos + 5;
    
    $nuevasHoras = floor($totalMinutos / 60);
    $nuevosMinutos = $totalMinutos % 60;
    
    return sprintf("%02d:%02d", $nuevasHoras, $nuevosMinutos);
}


?>