<?php
	include '../../connection.php';
	$request                = $_REQUEST['request'];
	if ($request == 'addTM') {
		$codigo 				= $_REQUEST['codigo'];
		$minutoTM   			= $_REQUEST['minutoTM'];
		$motivo  				= $_REQUEST['motivo'];
		$personasAfectadas  	= $_REQUEST['personasAfectadas'];
		$comentarios  			= $_REQUEST['comentarios'];
		$fecha  				= $_REQUEST['fecha'];
		$turno 					= $_REQUEST['turno'];

		//$fechaActual = date('Y-m-d H:i:s.u');

		// Verifica el turno y ajusta la hora
		if ($turno == 'A') {
		    // Si es turno A, ajusta la hora a las 07:00:00.000
		    $fecha = date('Y-m-d 07:00:00.000', strtotime($fecha));
		} else {
		    // Si es turno B, ajusta la hora a las 16:00:00.000
		    $fecha = date('Y-m-d 16:00:00.000', strtotime($fecha));
		}

		// Construye la consulta SQL
		$sql_request = "INSERT INTO rutasTiempoMuerto (codigo, minutoTM, motivo, personasAfectadas, comentarios, fecha, turno)
		VALUES ('$codigo', '$minutoTM', '$motivo', '$personasAfectadas', '$comentarios', '$fecha', '$turno')";
		
		//echo "$sql_request";

		$sql_query = sqlsrv_query($conn,$sql_request);
		if ($sql_query == true) {
			echo json_encode(array('response' => 'success'));
		}
		else{
			echo json_encode(array('response' => 'fail'));
		}

	}
	elseif ($request == 'getTM') {
		$turno = determinarTurno();
		
		if ($turno = 'A') {
			$fecha = date('Y-m-d');
			//$sql_request = "SELECT * FROM rutasTiempoMuerto WHERE fecha BETWEEN '$fecha 06:00' AND '$fecha 15:36'";
			$sql_request = "SELECT * FROM rutasTiempoMuerto WHERE turno = 'A' -- AND fecha BETWEEN '$fecha 06:00' AND '$fecha 15:36'";
		}
		else{
			$fecha = date('Y-m-d', strtotime($fecha . ' +1 day'));
			$sql_request = "SELECT * FROM rutasTiempoMuerto WHERE turno = 'B' -- AND fecha BETWEEN '$fecha 15:37' AND '$fecha 0:15'";
			//$sql_request = "SELECT * FROM rutasTiempoMuerto WHERE fecha BETWEEN '$fecha 15:37' AND '$fecha 0:15'";
		}

		$sql_query = sqlsrv_query($conn,$sql_request);

		$data = array();

		while ($dato = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
			$fechaFormateada = $dato['fecha']->format('Y-m-d');
			array_push($data, array(
				"codigo" => $dato['codigo'],
				"minutoTM" => $dato['minutoTM'],
				"motivo" => str_replace("_", " ", $dato['motivo']),
				"personasAfectadas" => $dato['personasAfectadas'],
				"comentarios" => $dato['comentarios'],
				"fecha" => $fechaFormateada

			));
		}
		echo json_encode($data);

	}
	elseif ($request == 'getMonth'){
		$sql_request = 'SELECT
						    YEAR(fecha) AS Anio,
						    MONTH(fecha) AS Mes,
						    DATENAME(MONTH, fecha) AS NombreMes,
						    SUM(CAST(minutoTM AS INT)) AS SumatoriaMinutos
						FROM
						    rutasTiempoMuerto WHERE
						    YEAR(fecha) = YEAR(GETDATE())
						GROUP BY
						    YEAR(fecha),
						    MONTH(fecha),
						    DATENAME(MONTH, fecha)
						ORDER BY MONTH(fecha)
						';
		$sql_query = sqlsrv_query($conn,$sql_request);
		$datos =  [];
		while ($data = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
			array_push($datos, array(	'Mes' => obtenerMes($data['NombreMes']),
										'Minutos' => $data['SumatoriaMinutos']));
		}

		echo json_encode($datos);

	}
	elseif ($request == 'getYear'){
		$sql_request = 'SELECT
						    YEAR(fecha) AS Anio,
						    SUM(CAST(minutoTM AS INT)) AS SumatoriaMinutos
						FROM
						    rutasTiempoMuerto WHERE
						    YEAR(fecha) = YEAR(GETDATE())
						GROUP BY
						    YEAR(fecha)

						ORDER BY YEAR(fecha)';
		$sql_query = sqlsrv_query($conn,$sql_request);
		$datos =  [];
		while ($data = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
			array_push($datos, array(	'Year' => $data['Anio'],
										'Minutos' => $data['SumatoriaMinutos']));
		}

		echo json_encode($datos);

	}
	elseif ($request == 'getWeek'){
		$sql_request = 'SELECT
						    YEAR(fecha) AS Anio,
						    (DATEPART(WEEKDAY, fecha) + @@DATEFIRST - 2) % 7 + 1 AS DiaSemana,
						    DATENAME(WEEKDAY, fecha) AS NombreDiaSemana,
						    SUM(CAST(minutoTM AS INT)) AS SumatoriaMinutos
						FROM
						    rutasTiempoMuerto
						WHERE
						    YEAR(fecha) = YEAR(GETDATE())
						GROUP BY
						    YEAR(fecha),
						    (DATEPART(WEEKDAY, fecha) + @@DATEFIRST - 2) % 7 + 1,
						    DATENAME(WEEKDAY, fecha)
						    
						ORDER BY
						    YEAR(fecha),
						    DiaSemana
						    ;
						';
		$sql_query = sqlsrv_query($conn,$sql_request);

		$datos =  [];
		while ($data = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
			array_push($datos, array(	'NombreDia' => obtenerDia($data['NombreDiaSemana']),
										'Minutos' => $data['SumatoriaMinutos']));
		}

		echo json_encode($datos);

	}
	elseif ($request == 'getGraphic'){
		$fechaInicial = $_GET['fechaInicial'];
		$fechaFinal = $_GET['fechaFinal'];
		$turno = $_GET['turno'];

		// Formatear las fechas para el uso en la consulta SQL
		$fechaInicialFormatted = date('Y-m-d', strtotime($fechaInicial));
		$fechaFinalFormatted = date('Y-m-d', strtotime($fechaFinal));

		// Inicializar array para almacenar los resultados
		$datos = array();

		// Obtener registros para cada día en el rango de fechas
		$currentDate = strtotime($fechaInicialFormatted);

		while ($currentDate <= strtotime($fechaFinalFormatted)) {
		    $currentDateString = date('Y-m-d', $currentDate);

		    // Construir las fechas y horas para el turno A y B
		    $fechaTurnoAInicio = $currentDateString . ' 06:00:00';
		    $fechaTurnoAFin = $currentDateString . ' 15:36:00';
		    $fechaTurnoBInicio = $currentDateString . ' 15:37:00';
		    $fechaTurnoBFin = date('Y-m-d', strtotime($currentDateString . ' + 1 day')) . ' 00:15:00';

		    // Seleccionar la consulta adecuada según el turno
		    if ($turno == 'A') {
		        /*$sql_request = "
		            SELECT
		                SUM(CAST(minutoTM AS INT)) AS SumatoriaMinutos,
		                CONVERT(CHAR(10), fecha, 120) as Fecha
		            FROM
		                rutasTiempoMuerto
		            WHERE
		                fecha BETWEEN '$fechaTurnoAInicio' AND '$fechaTurnoAFin'
		            GROUP BY
		                YEAR(fecha),
		                (DATEPART(WEEKDAY, fecha) + @@DATEFIRST - 2) % 7 + 1,
		                DATENAME(WEEKDAY, fecha),
		                CONVERT(CHAR(10), fecha, 120)
		            ORDER BY
		                CONVERT(CHAR(10), fecha, 120)
		        ";*/
		        $sql_request = "
		            SELECT
		                SUM(CAST(minutoTM AS INT)) AS SumatoriaMinutos,
		                CONVERT(CHAR(10), fecha, 120) as Fecha
		            FROM
		                rutasTiempoMuerto
		            WHERE
		               	turno = 'A' AND  fecha BETWEEN '$fechaTurnoAInicio' AND '$fechaTurnoAFin'
		            GROUP BY
		                YEAR(fecha),
		                (DATEPART(WEEKDAY, fecha) + @@DATEFIRST - 2) % 7 + 1,
		                DATENAME(WEEKDAY, fecha),
		                CONVERT(CHAR(10), fecha, 120)
		            ORDER BY
		                CONVERT(CHAR(10), fecha, 120)
		        ";
		    } elseif ($turno == 'B') {
		        /*$sql_request = "
		            SELECT
		                SUM(CAST(minutoTM AS INT)) AS SumatoriaMinutos,
		                CONVERT(CHAR(10), fecha, 120) as Fecha
		            FROM
		                rutasTiempoMuerto
		            WHERE
		                fecha BETWEEN '$fechaTurnoBInicio' AND '$fechaTurnoBFin'
		            GROUP BY
		                YEAR(fecha),
		                (DATEPART(WEEKDAY, fecha) + @@DATEFIRST - 2) % 7 + 1,
		                DATENAME(WEEKDAY, fecha),
		                CONVERT(CHAR(10), fecha, 120)
		            ORDER BY
		                CONVERT(CHAR(10), fecha, 120)
		        ";*/
		        $sql_request = "
		            SELECT
		                SUM(CAST(minutoTM AS INT)) AS SumatoriaMinutos,
		                CONVERT(CHAR(10), fecha, 120) as Fecha
		            FROM
		                rutasTiempoMuerto
		            WHERE
		               	turno = 'B' AND fecha BETWEEN '$fechaTurnoBInicio' AND '$fechaTurnoBFin'
		            GROUP BY
		                YEAR(fecha),
		                (DATEPART(WEEKDAY, fecha) + @@DATEFIRST - 2) % 7 + 1,
		                DATENAME(WEEKDAY, fecha),
		                CONVERT(CHAR(10), fecha, 120)
		            ORDER BY
		                CONVERT(CHAR(10), fecha, 120)
		        ";
		    }

		    // Ejecutar la consulta y procesar los resultados
		    if (!empty($sql_request)) {
		        $sql_query = sqlsrv_query($conn, $sql_request);

		        while ($data = sqlsrv_fetch_array($sql_query, SQLSRV_FETCH_ASSOC)) {
		            array_push($datos, array(
		                'Fecha' => obtenerDia($data['Fecha']),
		                'Minutos' => $data['SumatoriaMinutos']
		            ));
		        }
		    }

		    // Avanzar al siguiente día
		    $currentDate = strtotime($currentDateString . ' + 1 day');
		}

		// Convertir el array a formato JSON y enviarlo como respuesta
		echo json_encode($datos);


	}
	elseif ($request == 'getRangeTM'){
		$fechaInicial = $_GET['fechaInicial'];
		$fechaFinal = $_GET['fechaFinal'];
		$turno = $_GET['turno'];

		// Formatear las fechas para el uso en la consulta SQL
		$fechaInicialFormatted = date('Y-m-d', strtotime($fechaInicial));
		$fechaFinalFormatted = date('Y-m-d', strtotime($fechaFinal));

		// Inicializar array para almacenar los resultados
		$data = array();

		// Obtener registros para cada día en el rango de fechas
		$currentDate = strtotime($fechaInicialFormatted);

		while ($currentDate <= strtotime($fechaFinalFormatted)) {
		    $currentDateString = date('Y-m-d', $currentDate);

		    // Construir las fechas y horas para el turno A y B
		    $fechaTurnoAInicio = $currentDateString . ' 06:00:00';
		    $fechaTurnoAFin = $currentDateString . ' 15:36:00';
		    $fechaTurnoBInicio = $currentDateString . ' 15:37:00';
		    $fechaTurnoFinalB = date('Y-m-d', strtotime($currentDateString . ' + 1 day'));

		    // Seleccionar la consulta adecuada según el turno
		    if ($turno == 'A') {
		        //$sql_request = "SELECT * FROM rutasTiempoMuerto WHERE fecha BETWEEN '$fechaTurnoAInicio' AND '$fechaTurnoAFin'";
		        $sql_request = "SELECT ID, codigo, minutoTM, motivo, personasAfectadas, comentarios, CONVERT(varchar, fecha, 23) AS fecha, turno
					 FROM rutasTiempoMuerto WHERE turno = 'A' AND fecha BETWEEN '$fechaInicial 0:00' AND '$fechaFinal 23:59'";
				

		    } elseif ($turno == 'B') {
		        //$sql_request = "SELECT * FROM rutasTiempoMuerto WHERE fecha BETWEEN '$fechaTurnoBInicio' AND '$fechaTurnoBFin'";
		        $sql_request = "SELECT ID, codigo, minutoTM, motivo, personasAfectadas, comentarios, CONVERT(varchar, fecha, 23) AS fecha, turno
				 FROM rutasTiempoMuerto WHERE turno = 'B' AND fecha BETWEEN '$fechaInicial 0:00' AND '$fechaTurnoFinalB 23:59'";
		    } else {
		        // Manejar otro caso o dejar la consulta en blanco según tus necesidades
		        $sql_request = "";
		    }

		  
		 	//echo "$sql_request";
		    // Ejecutar la consulta y procesar los resultados
		    if (!empty($sql_request)) {
		        $sql_query = sqlsrv_query($conn, $sql_request);

		        while ($dato = sqlsrv_fetch_array($sql_query, SQLSRV_FETCH_ASSOC)) {
		            // Verificar si el registro ya está en el array basándote en la ID
		            $exists = false;
		            foreach ($data as $existingData) {
		                if ($existingData['ID'] == $dato['ID']) {
		                    $exists = true;
		                    break;
		                }
		            }

		            // Agregar el registro solo si no existe
		            if (!$exists) {
		                $data[] = array(
		                    "ID" => $dato['ID'],
		                    "codigo" => $dato['codigo'],
		                    "minutoTM" => $dato['minutoTM'],
		                    "motivo" => str_replace("_", " ", $dato['motivo']),
		                    "personasAfectadas" => $dato['personasAfectadas'],
		                    "comentarios" => $dato['comentarios'],
		                    "fecha" => $dato['fecha']
		                );
		            }
		        }
		    }

		    // Avanzar al siguiente día
		    $currentDate = strtotime($currentDateString . ' + 1 day');
		}

		// Convertir el array a formato JSON y enviarlo como respuesta
		echo json_encode($data);



	}
	elseif($request =='getGraphicComparativo'){
		$fechaInicial = $_GET['fechaInicial'];
		$fechaFinal = $_GET['fechaFinal'];
		$turno = 'B';

		// Formatear las fechas para el uso en la consulta SQL
		$fechaInicialFormatted = date('Y-m-d', strtotime($fechaInicial));
		$fechaFinalFormatted = date('Y-m-d', strtotime($fechaFinal));

		// Inicializar array para almacenar los resultados
		$datos = array();

		// Obtener registros para cada día en el rango de fechas
		$currentDate = strtotime($fechaInicialFormatted);

		while ($currentDate <= strtotime($fechaFinalFormatted)) {
		    $currentDateString = date('Y-m-d', $currentDate);

		    // Construir las fechas y horas para el turno A y B
		    $fechaTurnoAInicio = $currentDateString . ' 06:00:00';
		    $fechaTurnoAFin = $currentDateString . ' 15:36:00';
		    $fechaTurnoBInicio = $currentDateString . ' 15:37:00';
		    $fechaTurnoBFin = date('Y-m-d', strtotime($currentDateString . ' + 1 day')) . ' 00:15:00';

		    // Seleccionar la consulta adecuada según el turno
		    if ($turno == 'A') {
		        $sql_request = "
		            SELECT
		                SUM(CAST(minutoTM AS INT)) AS SumatoriaMinutos,
		                CONVERT(CHAR(10), fecha, 120) as Fecha
		            FROM
		                rutasTiempoMuerto
		            WHERE
		                fecha BETWEEN '$fechaTurnoAInicio' AND '$fechaTurnoAFin'
		            GROUP BY
		                YEAR(fecha),
		                (DATEPART(WEEKDAY, fecha) + @@DATEFIRST - 2) % 7 + 1,
		                DATENAME(WEEKDAY, fecha),
		                CONVERT(CHAR(10), fecha, 120)
		            ORDER BY
		                CONVERT(CHAR(10), fecha, 120)
		        ";
		    } elseif ($turno == 'B') {
		        $sql_request = "
		            SELECT
		                SUM(CAST(minutoTM AS INT)) AS SumatoriaMinutos,
		                CONVERT(CHAR(10), fecha, 120) as Fecha
		            FROM
		                rutasTiempoMuerto
		            WHERE
		                fecha BETWEEN '$fechaTurnoBInicio' AND '$fechaTurnoBFin'
		            GROUP BY
		                YEAR(fecha),
		                (DATEPART(WEEKDAY, fecha) + @@DATEFIRST - 2) % 7 + 1,
		                DATENAME(WEEKDAY, fecha),
		                CONVERT(CHAR(10), fecha, 120)
		            ORDER BY
		                CONVERT(CHAR(10), fecha, 120)
		        ";
		    }

		    // Ejecutar la consulta y procesar los resultados
		    if (!empty($sql_request)) {
		        $sql_query = sqlsrv_query($conn, $sql_request);

		        while ($data = sqlsrv_fetch_array($sql_query, SQLSRV_FETCH_ASSOC)) {
		            array_push($datos, array(
		                'Fecha' => obtenerDia($data['Fecha']),
		                'Minutos' => $data['SumatoriaMinutos']
		            ));
		        }
		    }

		    // Avanzar al siguiente día
		    $currentDate = strtotime($currentDateString . ' + 1 day');
		}

		// Convertir el array a formato JSON y enviarlo como respuesta
		echo json_encode($datos);
	}
	function obtenerMes($mes){
		if ($mes =='January') {
			return 'Enero';
		}
		elseif($mes =='February'){
			return 'Febrero';
		}
		elseif($mes =='March'){
			return 'Marzo';
		}
		elseif($mes =='April'){
			return 'Abril';
		}
		elseif($mes =='May'){
			return 'Mayo';
		}
		elseif($mes =='June'){
			return 'Junio';
		}
		elseif($mes =='July'){
			return 'Julio';
		}
		elseif($mes =='August'){
			return 'Agosto';
		}
		elseif($mes =='September'){
			return 'Septiembre';
		}
		elseif($mes =='October'){
			return 'Octubre';
		}
		elseif($mes =='November'){
			return 'Noviembre';
		}
		elseif($mes =='December'){
			return 'Diciembre';
		}
		else{
			return $mes;
		}

	}
	function obtenerDia($dia){
		if ($dia == 'Monday') {
			return 'Lunes';
		}
		elseif ($dia == 'Tuesday') {
			return 'Martes';
		}
		elseif ($dia == 'Wednesday') {
			return 'Miercoles';
		}
		elseif ($dia == 'Thursday') {
			return 'Jueves';
		}
		elseif ($dia == 'Friday') {
			return 'Viernes';
		}
		elseif ($dia == 'Saturday') {
			return 'Sabado';
		}
		elseif ($dia == 'Sunday') {
			return 'Domingo';
		}
		else{
			return $dia;
		}
	}

	if (isset($_GET['getTurno'])) {
		echo determinarTurno();
	}

	function determinarTurno() {
    // Obtiene la hora actual en formato de 24 horas
		date_default_timezone_set('America/Monterrey');
	    $horaActual = date('H:i');

	    // Define los límites de los turnos
	    $horaInicioTurnoA = '06:00';
	    $horaFinTurnoA = '15:36';
	    $horaInicioTurnoB = '15:37';
	    $horaFinTurnoB = '00:10';

	    // Compara la hora actual con los límites de los turnos
	    if ($horaActual >= $horaInicioTurnoA && $horaActual <= $horaFinTurnoA) {
	        return 'A';
	    } elseif (($horaActual >= $horaInicioTurnoB && $horaActual <= '23:59') || ($horaActual >= '00:00' && $horaActual <= $horaFinTurnoB)) {
	        return 'B';
	    } else {
	        return 'Fuera de turno';
	    }
	}



	

?>