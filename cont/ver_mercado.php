<?php 
	include '../../connection.php';

	$fecha_inicio	= $_GET['fecha_inicio'];
	$fecha_fin		= $_GET['fecha_fin'];
	$turno_inicio	= $_GET['turno_inicio'];
	$turno_fin		= $_GET['turno_fin'];
	$tipo_turno		= $_GET['tipo_turno'];

	
	################### CONSULTA RACKEO EN RANGO DE FECHAS ###########################
	$consultas_rackeo = array();
	$consultas_rackeo = getDates($fecha_inicio,$fecha_fin);

	if ($tipo_turno=='B') {
		$arrayRackeo = getBData($consultas_rackeo,$turno_inicio,$turno_fin,'RACKEO');
	}
	else
	{
		$arrayRackeo = getData($consultas_rackeo,$turno_inicio,$turno_fin,'RACKEO');
	}
	

	//echo json_encode($arrayRackeo);	

	##################################################################################

	################### CONSULTA CONTINGENCIA EN RANGO DE FECHAS ###########################
	$consultas_contingencia = array();
	$consultas_contingencia = getDates($fecha_inicio,$fecha_fin);

	if ($tipo_turno=='B') {
		$arrayContingencia = getBData($consultas_contingencia,$turno_inicio,$turno_fin,'CONTINGENCIA');
	}
	else{
		$arrayContingencia = getData($consultas_contingencia,$turno_inicio,$turno_fin,'CONTINGENCIA');
	}
	

	//echo json_encode($arrayContingencia);	
	##################################################################################

	
	

	################### CONSULTA OBTENER RECIBOS EN RANGO DE FECHAS #########################
	$reciboConsulta = array();
	$consultas = getDates($fecha_inicio,$fecha_fin);

	$arrayRecibos = getData($consultas,'','','RECIBOS');

	//echo json_encode($arrayRecibos);
	##################################################################################

	$sum = 0;
	$datos['info'] = array();

	$sumRackeo			=0;
	$sumContingencia	=0;
	$sumMovimientos		=0;

	for ($i=0; $i <count($arrayContingencia) ; $i++) { 
		array_push($datos['info'], array('recibos' => $arrayRecibos[$i], 
								'rackeo'=>$arrayRackeo[$i],
								'contingencia'=>$arrayContingencia[$i],
								'total' => intval($arrayRackeo[$i])+intval($arrayContingencia[$i]),
								'fecha'=> $consultas[$i]));

		$sumRackeo		+=$arrayRackeo[$i];
		$sumContingencia+=$arrayContingencia[$i];
		$sumMovimientos	+=intval($arrayRackeo[$i])+intval($arrayContingencia[$i]);
	}

	if (count($arrayContingencia) == 1) {
		if ($tipo_turno=="Comparativo") {
			$arrayContingenciaTurnoA=getData($consultas_contingencia,'06:00','15:36','CONTINGENCIA');
			$arrayRackeoTurnoA=getData($consultas_rackeo,'06:00','15:36','RACKEO');

			$sumRackeoA = $arrayRackeoTurnoA[0];
			$sumContingenciaA = $arrayContingenciaTurnoA[0];
			$sumMovimientosA = intval($arrayRackeoTurnoA[0]) + intval($arrayContingenciaTurnoA[0]);

			array_push($datos,array($sumRackeoA));
			array_push($datos,array($sumContingenciaA));
			array_push($datos,array($sumMovimientosA));
#####################################################################################################
			$fechaAd = date('Y-m-d', strtotime($fecha_inicio . ' + 1 day'));
			$fechas = array();
			array_push($fechas,$fecha_inicio);
			array_push($fechas,$fechaAd);
			$arrayContingenciaTurnoB=getBData($fechas,'15:36','0:00','CONTINGENCIA');
			$arrayRackeoTurnoB = getBData($fechas,'15:36','0:00','RACKEO');

			

			
			

			$sumRackeoB = $arrayRackeoTurnoB[0];
			$sumContingenciaB = $arrayContingenciaTurnoB[0];
			$sumMovimientosB = intval($arrayRackeoTurnoB[0]) + intval($arrayContingenciaTurnoB[0]);

			array_push($datos,array($sumRackeoB));
			array_push($datos,array($sumContingenciaB));
			array_push($datos,array($sumMovimientosB));	

		}
		else{
			array_push($datos,array($sumRackeo));
			array_push($datos,array($sumContingencia));
			array_push($datos,array($sumMovimientos));
		}

	}



	
	echo json_encode($datos,JSON_PRETTY_PRINT);

	function getBData($fechas,$turno_inicio,$turno_fin,$consulta){
		$serverName = "10.215.156.203\IFV55";
		$connectionInfo = array( 	"Database"=>"SMS",
									"UID"=>"sa", 
									"PWD"=>"System@dm1n"
								);
		$conn = sqlsrv_connect( $serverName, $connectionInfo);

		if ($consulta=='RACKEO') {
			$b = 0;
			$var=array();
			for ($i=0; $i < count($fechas) ; $i++) {
				$b += 1;
				if ($b>= count($fechas)) {
					break;
				}

				$rak=sqlsrv_query($conn,"SELECT Count(*) as RACKEO FROM   Smk_InvDet WHERE (Action = 'PUT AWAY') AND (ActionDate>= '".$fechas[$i]." $turno_inicio'  AND ActionDate< '".$fechas[$b]." $turno_fin')");
				
				while ($res = sqlsrv_fetch_array($rak,SQLSRV_FETCH_ASSOC)) {
					array_push($var, $res['RACKEO']);
				}
				

			}

			return $var;
		}
		else if($consulta=='CONTINGENCIA'){
			$b = 0;
			$var=array();
			for ($i=0; $i < count($fechas) ; $i++) {
				$b += 1;
				if ($b>= count($fechas)) {
					break;
				}

				$rak=sqlsrv_query($conn,"SELECT Count(*) as CONTINGENCIA FROM   Smk_InvDet WHERE (Action = 'CHANGE') AND (ActionDate>= '".$fechas[$i]." $turno_inicio'  AND ActionDate< '".$fechas[$b]." $turno_fin')");
				while ($res = sqlsrv_fetch_array($rak,SQLSRV_FETCH_ASSOC)) {
					array_push($var, $res['CONTINGENCIA']);
				}
				

			}

			return $var;
		}
	}

	function getData($fechas,$turno_inicio,$turno_fin,$consulta){

		$serverName = "10.215.156.203\IFV55";
		$connectionInfo = array( 	"Database"=>"SMS",
									"UID"=>"sa", 
									"PWD"=>"System@dm1n"
								);
		$conn = sqlsrv_connect( $serverName, $connectionInfo);

		if ($consulta=='RACKEO') {
			$var=array();
			
			foreach ($fechas as $key) {
				$rak=sqlsrv_query($conn,"SELECT Count(*) as RACKEO FROM   Smk_InvDet WHERE (Action = 'PUT AWAY') AND (ActionDate>= '$key $turno_inicio'  AND ActionDate< '$key $turno_fin')");

				while ($res = sqlsrv_fetch_array($rak,SQLSRV_FETCH_ASSOC)) {
					array_push($var, $res['RACKEO']);
				}
				
			}
			return $var;
		}
		else if($consulta=='CONTINGENCIA')
		{
			$var=array();
			$tt=0;
			foreach ($fechas as $key) {
				$rak=sqlsrv_query($conn,"SELECT Count(*) as CONTINGENCIA FROM   Smk_InvDet WHERE (Action = 'CHANGE') AND (ActionDate>= '$key $turno_inicio'  AND ActionDate< '$key $turno_fin')");
				while ($res = sqlsrv_fetch_array($rak,SQLSRV_FETCH_ASSOC)) {
					array_push($var, $res['CONTINGENCIA']);
				}
				
			}
			return $var;
		}
		else
		{
			
			$var=array();
			$tt=0;
			foreach ($fechas as $key) {
				$rak=sqlsrv_query($conn,"SELECT count(*) as RECIBOS FROM  Rcv_SNH WHERE (ScanDate>= '$key 0:00'  AND ScanDate< '$key 23:59' and status<>'0')");
				while ($res = sqlsrv_fetch_array($rak,SQLSRV_FETCH_ASSOC)) {
					array_push($var, $res['RECIBOS']);
				}
				
			}
			return $var;
		}

		
	}


	function diasEntreFechas($fecha_inicio,$fecha_fin){
		$diaInicio = strtotime($fecha_inicio);
		$diaFin = strtotime($fecha_fin);
		$numDias = $diaFin - $diaInicio;
		$numDiasTotal= round(($numDias / (60 * 60 * 24))+1);

		return $numDiasTotal;
	}
	function getDates($startDate, $stopDate) {
    $dateArray = Array();
    $currentDate = date_create($startDate);
    $endDate = date_create($stopDate);
    $interval = new DateInterval('P1D');
    
	$date_range = new DatePeriod($currentDate, $interval, $endDate);
	
	foreach ($date_range as $date) {
		array_push($dateArray,$date->format('Y-m-d'));
	}
	array_push($dateArray,$stopDate);
	
    //2023-07-13 <= 2023-07-20
    //echo "$currentDate - Fecha inicio: $stopDate - Fecha Fin";
    
    return $dateArray;
}

	function lreplace($search, $replace, $subject){
	    $pos = strrpos($subject, $search);
	    if($pos !== false){
	        $subject = substr_replace($subject, $replace, $pos, strlen($search));
	    }
	    return $subject;
	}
?>
                       

                       
