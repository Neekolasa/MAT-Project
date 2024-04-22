<?php 
	include '../../connection.php';

	$request = $_GET['request'];
	
	if ($request == 'checkData') {
		$turnoActual = obtenerTurno();
		$sql_statement = "
			SELECT 
	        SP.Badge,
	        SP.Nombre,
	        SP.Area,
	        SUBSTRING(CONVERT(varchar, HDesayuno.TiempoSalida, 108), 1, 5) AS TiempoSalidaDesayuno,
	        SUBSTRING(CONVERT(varchar, HDesayuno.TiempoEntrada, 108), 1, 5) AS TiempoEntradaDesayuno,
	        SUBSTRING(CONVERT(varchar, HComida.TiempoSalida, 108), 1, 5) AS TiempoSalidaComida,
	        SUBSTRING(CONVERT(varchar, HComida.TiempoEntrada, 108), 1, 5) AS TiempoEntradaComida,
	        RS.SA,
	        RS.EA,
	        RS.SC,
	        RS.EC,
	        --CONVERT(VARCHAR, RS.ScanHour, 100) as ScanHour
	         --CONVERT(VARCHAR(15), RS.ScanHour, 109) AS ScanHour
	         CONVERT(VARCHAR, RS.ScanHour) AS ScanHour
    		
	    FROM SalidasPersonal AS SP
	    JOIN Horarios AS HDesayuno ON SP.Desayuno = HDesayuno.ID
	    JOIN Horarios AS HComida ON SP.Comida = HComida.ID
	    FULL JOIN RegistroSalidas AS RS ON SP.Badge = RS.fk_badge WHERE SP.turno='$turnoActual'
		";
		$sql_query = sqlsrv_query($conn,$sql_statement);

		$arrayCheck = array();
		while ($data = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
			array_push($arrayCheck, array(
									'Badge' => $data['Badge'],
									'Nombre' => $data['Nombre'],
									'TiempoSalidaDesayuno' => getColor($data['TiempoSalidaDesayuno'],$data['SA']),
									'TiempoEntradaDesayuno' => getColor($data['TiempoEntradaDesayuno'],
																$data['EA']),
									'TiempoSalidaComida' => getColor($data['TiempoSalidaComida'],
															$data['SC']),
									'TiempoEntradaComida' => getColor($data['TiempoEntradaComida'],$data['EC']),
									'Area' => $data['Area'],
									'Hora' => formatTime($data['ScanHour'])));
		}
		echo json_encode($arrayCheck);
	}

	function getColor($tiempo,$status){
		if ($status==null) {
			return "<b style='font-size:20px;'>$tiempo</b>";
		}
		else if($status=='OK'){
			return "
			<div class='col-md-12' style='background-color:green;color:white;font-size:20px;>
				<b style='font-size:20px;'>$tiempo</b>
			</div>";
		}
		else if($status=='BEF'){
			return "
			<div class='col-md-12' style='background-color:#AF2CCB;color:white;font-size:20px;>
				<b style='font-size:20px;'>$tiempo</b>
			</div>";
		}
		else
		{
			return "
			<div class='col-md-12' style='background-color:red;color:white;font-size:20px;>
				<b style='font-size:20px;'>$tiempo</b>
			</div>";
		}
	}
	function formatTime($time) {
    $formattedTime = date("h:i:s A", strtotime($time));
    return $formattedTime;
}

function obtenerTurno() {
    date_default_timezone_set('America/Monterrey');
    $hora_actual = date("H:i",strtotime('-1 hour'));

    list($hora, $minuto) = explode(':', $hora_actual);
    $minutos_desde_medianoche = $hora * 60 + $minuto;

    $inicio_turno_A = 6 * 60;
    $fin_turno_A = 15 * 60 + 36; 
    $inicio_turno_B = 15 * 60 + 37;
    $fin_turno_B = 24 * 60 + 36;

    if ($minutos_desde_medianoche >= $inicio_turno_A && $minutos_desde_medianoche <= $fin_turno_A) {
        return 'A';
    } elseif ($minutos_desde_medianoche >= $inicio_turno_B || $minutos_desde_medianoche <= $fin_turno_B) {
        return 'B';
    } else {
        return 'A';
    }
}

?>