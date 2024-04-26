<?php
	include '../../connection.php';

	$fechaIni = $_GET['fechaIni'];
	$fechaFin = $_GET['fechaFin'];
	$turno = $_GET['turno'];

	$consulta=getConsulta($fechaIni,$fechaFin,$turno);
	//echo $fechaFin;
	//echo json_encode("sdsdsds");
	########################## CONSULTA RACKEO #################################
	$rackeo = sqlsrv_query($conn,implode($consulta[0]));
	$arrayRackeo= array();


	while ($rack = sqlsrv_fetch_array($rackeo,SQLSRV_FETCH_ASSOC)) {
		array_push($arrayRackeo, array('Badge' => $rack['Badge'],
										'Name' => $rack['Name'],
										'LastName' => $rack['LastName'],
										'RACKEO' => $rack['RACKEO']));

	}


	#############################################################################
	/*
SELECT
    Badge,
    Name,
    LastName,
    SUM(RACKEO) AS RACKEO,
    SUM(CONTINGENCIA) AS CONTINGENCIA,
    SUM(RACKEO + CONTINGENCIA) AS TotalAcciones
FROM (
    SELECT
        Su.Badge,
        Su.Name,
        Su.LastName,
        CASE WHEN Sid.Action = 'PUT AWAY' THEN 1 ELSE 0 END AS RACKEO,
        0 AS CONTINGENCIA
    FROM Sy_Users Su
    LEFT JOIN Smk_InvDet Sid ON Sid.Badge = Su.Badge
    WHERE Sid.ActionDate >= '2023-08-10 06:00' AND Sid.ActionDate < '2023-08-10 15:36' AND Sid.Action = 'PUT AWAY'
    
    UNION ALL
    
    SELECT
        Su.Badge,
        Su.Name,
        Su.LastName,
        0 AS RACKEO,
        CASE WHEN Sid.Action = 'CHANGE' THEN 1 ELSE 0 END AS CONTINGENCIA
    FROM Sy_Users Su
    LEFT JOIN Smk_InvDet Sid ON Sid.Badge = Su.Badge
    WHERE Sid.ActionDate >= '2023-08-10 06:00' AND Sid.ActionDate < '2023-08-10 15:36' AND Sid.Action = 'CHANGE'
) CombinedSubquery
GROUP BY Badge, Name, LastName
ORDER BY TotalAcciones ASC;




	*/
	########################## CONSULTA CONTINGENCIA ############################

	$contingencia = sqlsrv_query($conn,implode($consulta[1]));


	$arrayContingencia = array();

	while ($cont = sqlsrv_fetch_array($contingencia,SQLSRV_FETCH_ASSOC)) {
		array_push($arrayContingencia, array('Badge' => $cont['Badge'],
										'Name' => $cont['Name'],
										'LastName' => $cont['LastName'],
										'CONTINGENCIA' => $cont['CONTINGENCIA']));
	}

	$tempArray['info'] = array();
	$tempArray['totales'] = array();
	$arrayCompleto = combinarTablas($arrayRackeo,$arrayContingencia);
	$arrayTotales = calcularTotales($arrayCompleto);

	array_push($tempArray['info'],$arrayCompleto);
	array_push($tempArray['totales'],$arrayTotales);
	
	echo json_encode($tempArray);
	#############################################################################
	//asort($arrayContingencia);
	/*asort($arrayRackeo);

	
	//$tempArray['Success'] = array();

	$sumRackeo = 0;
	$sumRackeos = 0;
	$sumContingencia = 0;
	$sumMovimienos = 0;*/

	/*foreach ($arrayContingencia as $keyContingencia) {
		foreach ($arrayRackeo as $keyRackeo) {
				
				array_push($tempArray['Data'],array(
					'Badge' => $keyContingencia['Badge'],
					'Name' => $keyContingencia['Name'],
					'LastName' => $keyContingencia['LastName'],
					'RACKEO' => getRackeo($keyContingencia['Badge'],$turno,$fechaIni,$fechaFin),
					'CONTINGENCIA' => getContingencia($keyContingencia['Badge'],$turno,$fechaIni,$fechaFin),
					'TOTALMOVIMIENTOS' => intval($keyContingencia['CONTINGENCIA'])+intval(getRackeo($keyContingencia['Badge'],$turno,$fechaIni,$fechaFin))));
				$sumRackeo+= intval(getRackeo($keyContingencia['Badge'],$turno,$fechaIni,$fechaFin));

				$sumRackeos+=getRackeo($keyContingencia['Badge'],$turno,$fechaIni,$fechaFin);
				$sumContingencia+= intval($keyContingencia['CONTINGENCIA']);
				$sumMovimienos+=intval($keyContingencia['CONTINGENCIA'])+intval(getRackeo($keyContingencia['Badge'],$turno,$fechaIni,$fechaFin));

				break;

		}
	}*/
	/*$tempArray['DataR'] = array();
	$tempArray['DataC'] = array();

	foreach ($arrayContingencia as $keyContingencia) {
		array_push($tempArray['DataC'],array(
					'Badge' => $keyContingencia['Badge'],
					'Name' => $keyContingencia['Name'],
					'LastName' => $keyContingencia['LastName'],
					'CONTINGENCIA' => getContingencia($keyContingencia['Badge'],$turno,$fechaIni,$fechaFin)));

				//$sumRackeos+=getRackeo($keyContingencia['Badge'],$turno,$fechaIni,$fechaFin);
				$sumContingencia+= intval($keyContingencia['CONTINGENCIA']);
				$sumMovimienos+=intval($keyContingencia['CONTINGENCIA']);
	}


	foreach ($arrayRackeo as $keyRackeo) {
		array_push($tempArray['DataR'],array(
					'Badge' => $keyRackeo['Badge'],
					'Name' => $keyRackeo['Name'],
					'LastName' => $keyRackeo['LastName'],
					'RACKEO' => getRackeo($keyRackeo['Badge'],$turno,$fechaIni,$fechaFin)));
				$sumRackeo+= intval(getRackeo($keyRackeo['Badge'],$turno,$fechaIni,$fechaFin));

				$sumRackeos+=getRackeo($keyRackeo['Badge'],$turno,$fechaIni,$fechaFin);
				//$sumContingencia+= intval($keyContingencia['CONTINGENCIA']);
				$sumMovimienos+=intval(getRackeo($keyRackeo['Badge'],$turno,$fechaIni,$fechaFin));
	}


	array_push($tempArray,array($sumRackeos));
	array_push($tempArray,array($sumContingencia));
	array_push($tempArray,array($sumMovimienos));
	array_push($tempArray,array($turno));*/


	

	//echo json_encode($tempArray);
	
	
	function getContingencia($badge,$turno,$fechaIni,$fechaFin){
		$serverName = "10.215.156.203\IFV55";
		$connectionInfo = array( 	"Database"=>"SMS",
									"UID"=>"sa", 
									"PWD"=>"System@dm1n"
								);
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( $conn === false ) {
		     die( print_r( sqlsrv_errors(), true));
		}
		if ($turno =='A') {
			$sql = "SELECT  Smk_InvDet.Badge, count(Smk_InvDet.Action) as CONTINGENCIA
  			FROM Sy_Users full join Smk_InvDet on Smk_InvDet.Badge=Sy_Users.Badge  
  			WHERE [ActionDate]  >= '$fechaIni 06:00' and [ActionDate] < '$fechaIni 15:36'and Action ='CHANGE' AND Sy_Users.Badge='$badge' GROUP BY Smk_InvDet.Badge order by CONTINGENCIA asc";
		}
		else if($turno == 'B')
		{
			$sql = "SELECT  Smk_InvDet.Badge, count(Smk_InvDet.Action) as CONTINGENCIA
  			FROM Sy_Users full join Smk_InvDet on Smk_InvDet.Badge=Sy_Users.Badge  
  			WHERE [ActionDate]  >= '$fechaIni 15:36' and [ActionDate] < '$fechaFin 0:00'and Action ='CHANGE' AND Sy_Users.Badge='$badge' GROUP BY Smk_InvDet.Badge order by CONTINGENCIA asc";
		}
		$rackPos = sqlsrv_query($conn,$sql);
		while ($res = sqlsrv_fetch_array($rackPos,SQLSRV_FETCH_ASSOC)) {
			$total=$res['CONTINGENCIA'];
		}
		if (isset($total)) {
			return $total;
		}
		else{
			return '0';
		}

	}
	function getRackeo($badge,$turno,$fechaIni,$fechaFin){

	  	$serverName = "10.215.156.203\IFV55";
		$connectionInfo = array( 	"Database"=>"SMS",
									"UID"=>"sa", 
									"PWD"=>"System@dm1n"
								);
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if( $conn === false ) {
		     die( print_r( sqlsrv_errors(), true));
		}


		if ($turno =='A') {
			$sql = "SELECT  Smk_InvDet.Badge, count(Smk_InvDet.Action) as RACKEO
  			FROM Sy_Users full join Smk_InvDet on Smk_InvDet.Badge=Sy_Users.Badge  
  			WHERE [ActionDate]  >= '$fechaIni 06:00' and [ActionDate] < '$fechaIni 15:36'and Action ='PUT AWAY' AND Sy_Users.Badge='$badge' GROUP BY Smk_InvDet.Badge order by RACKEO asc";
		}
		else if($turno == 'B')
		{
			$sql = "SELECT  Smk_InvDet.Badge, count(Smk_InvDet.Action) as RACKEO
  			FROM Sy_Users full join Smk_InvDet on Smk_InvDet.Badge=Sy_Users.Badge  
  			WHERE [ActionDate]  >= '$fechaIni 15:36' and [ActionDate] < '$fechaFin 0:00'and Action ='PUT AWAY' AND Sy_Users.Badge='$badge' GROUP BY Smk_InvDet.Badge order by RACKEO asc";
		}

		
		$rackPos = sqlsrv_query($conn,$sql);
		while ($res = sqlsrv_fetch_array($rackPos,SQLSRV_FETCH_ASSOC)) {
			$total=$res['RACKEO'];
		}
		if (isset($total)) {
			return $total;
		}
		else{
			return '0';
		}
		

	}

	function getConsulta($fechaIni,$fechaFin,$turno){
		$sql = array();

		if ($turno !='B') {

			array_push($sql, array('sql_rackeo' => "
			SELECT  [SMS].[dbo].[Smk_InvDet].Badge,[SMS].[dbo].[Sy_Users].[Name], [SMS].[dbo].[Sy_Users].LastName, count([SMS].[dbo].[Smk_InvDet].Action) as RACKEO
  			FROM [SMS].[dbo].[Sy_Users] full join[SMS].[dbo].[Smk_InvDet] on [SMS].[dbo].[Smk_InvDet].Badge=[SMS].[dbo].[Sy_Users].Badge  
  			WHERE [ActionDate]  >= '$fechaIni 06:00' and [ActionDate] < '$fechaIni 15:36'and Action ='PUT AWAY' group by [SMS].[dbo].[Smk_InvDet].Badge, Name, LastName order by RACKEO asc"));

  			array_push($sql, array('sql_contingencia' => "
  			SELECT  [SMS].[dbo].[Smk_InvDet].Badge,[SMS].[dbo].[Sy_Users].[Name], [SMS].[dbo].[Sy_Users].LastName, count([SMS].[dbo].[Smk_InvDet].Action) as CONTINGENCIA
		  	FROM [SMS].[dbo].[Sy_Users] full join[SMS].[dbo].[Smk_InvDet] on [SMS].[dbo].[Smk_InvDet].Badge=[SMS].[dbo].[Sy_Users].Badge  
		 	WHERE [ActionDate]  >= '$fechaIni 06:00' and [ActionDate] < '$fechaIni 15:36'and Action ='CHANGE' group by [SMS].[dbo].[Smk_InvDet].Badge, Name, LastName order by CONTINGENCIA asc

  			"));

		}
		else{
			array_push($sql, array('sql_rackeo' => "
			SELECT  [SMS].[dbo].[Smk_InvDet].Badge,[SMS].[dbo].[Sy_Users].[Name], [SMS].[dbo].[Sy_Users].LastName, count([SMS].[dbo].[Smk_InvDet].Action) as RACKEO
  			FROM [SMS].[dbo].[Sy_Users] full join[SMS].[dbo].[Smk_InvDet] on [SMS].[dbo].[Smk_InvDet].Badge=[SMS].[dbo].[Sy_Users].Badge  
  			WHERE [ActionDate]  >= '$fechaIni 15:36' and [ActionDate] < '$fechaFin 0:00'and Action ='PUT AWAY' group by [SMS].[dbo].[Smk_InvDet].Badge, Name, LastName order by RACKEO asc"));

  			array_push($sql, array('sql_contingencia' => "
  			SELECT  [SMS].[dbo].[Smk_InvDet].Badge,[SMS].[dbo].[Sy_Users].[Name], [SMS].[dbo].[Sy_Users].LastName, count([SMS].[dbo].[Smk_InvDet].Action) as CONTINGENCIA
		  	FROM [SMS].[dbo].[Sy_Users] full join[SMS].[dbo].[Smk_InvDet] on [SMS].[dbo].[Smk_InvDet].Badge=[SMS].[dbo].[Sy_Users].Badge  
		 	WHERE [ActionDate]  >= '$fechaIni 15:36' and [ActionDate] < '$fechaFin 0:00'and Action ='CHANGE' group by [SMS].[dbo].[Smk_InvDet].Badge, Name, LastName order by CONTINGENCIA asc

  			"));
		}

		return $sql;
	}
function combinarTablas($tabla_uno, $tabla_dos) {
    // Crear un diccionario temporal para almacenar la información combinada por Badge (Código de empleado)
    $diccionario_temporal = [];

    // Combinar información de tabla_uno
    foreach ($tabla_uno as $empleado_uno) {
        $badge = $empleado_uno["Badge"];
        $rackeo = isset($empleado_uno["RACKEO"]) ? $empleado_uno["RACKEO"] : 0;

        if (!isset($diccionario_temporal[$badge])) {
            $diccionario_temporal[$badge] = [
                "Badge" => $badge,
                "Name" => $empleado_uno["Name"],
                "LastName" => $empleado_uno["LastName"],
                "RACKEO" => $rackeo,
                "CONTINGENCIA" => 0,

            ];
        } else {
            // Si ya existe en el diccionario, actualizamos la información de RACKEO si es mayor
            $diccionario_temporal[$badge]["RACKEO"] = max($diccionario_temporal[$badge]["RACKEO"], $rackeo);
        }
    }

    // Combinar información de tabla_dos
    foreach ($tabla_dos as $empleado_dos) {
        $badge = $empleado_dos["Badge"];
        $contingencia = $empleado_dos["CONTINGENCIA"];

        if (!isset($diccionario_temporal[$badge])) {
            $diccionario_temporal[$badge] = [
                "Badge" => $badge,
                "Name" => $empleado_dos["Name"],
                "LastName" => $empleado_dos["LastName"],
                "RACKEO" => 0,
                "CONTINGENCIA" => $contingencia,
            ];
        } else {
            // Si ya existe en el diccionario, actualizamos la información de CONTINGENCIA si es mayor
            $diccionario_temporal[$badge]["CONTINGENCIA"] = max($diccionario_temporal[$badge]["CONTINGENCIA"], $contingencia);
        }
    }
    foreach ($diccionario_temporal as &$empleado) {
      $empleado["TOTAL"] = $empleado["RACKEO"] + $empleado["CONTINGENCIA"];
    }
    // Generar el arreglo final a partir del diccionario temporal
    $tabla_final = array_values($diccionario_temporal);

    return $tabla_final;
}
function calcularTotales($tabla_combinada) {
    // Inicializar las variables de totales
    $rackeo_total = 0;
    $contingencia_total = 0;

    // Calcular las sumas totales de rackeos y contingencias
    foreach ($tabla_combinada as $empleado) {
        $rackeo_total += $empleado["RACKEO"];
        $contingencia_total += $empleado["CONTINGENCIA"];
    }

    // Agregar las sumas totales al arreglo combinado
    $sumas_totales = [
    	"RACKEO_TOTAL" => $rackeo_total,
    	"CONTINGENCIA_TOTAL" => $contingencia_total,
    	"MOVIMIENTOS_TOTAL" => $rackeo_total+$contingencia_total
    ];

    // Devolver el arreglo combinado con las sumas totales agregadas
    return $sumas_totales;
}


?>

