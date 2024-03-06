<?php  

	$fecha_inicio	= $_GET['fecha_inicio'];
	$fecha_fin		= $_GET['fecha_fin'];
	$turno_inicio	= $_GET['turno_inicio'];
	$turno_fin		= $_GET['turno_fin'];
	$tipo_turno		= $_GET['tipo_turno'];

	$fechas = array();
	$fechas = getDates($fecha_inicio,$fecha_fin);

	if ($tipo_turno == 'B') {
		$fechaAd = date('Y-m-d', strtotime($fecha_inicio . ' + 1 day'));
		$fechasB = array();
		array_push($fechasB,$fecha_inicio);
		array_push($fechasB,$fechaAd);
		
		$consultaComponente = getBData($fechasB,'15:36','0:15','COMPONENTE');

		$consultaPoliducto = getBData($fechasB,'15:36','0:15','POLIDUCTO');

		$consultaTolvasSE = getTolvasSE($fechasB,$tipo_turno);

		$consultaFullComponente = getBData($fechasB,'15:36','0:15','FULL_COMPONENTE');
		$consultaFullPoliducto = getBData($fechasB,'15:36','0:15','FULL_POLIDUCTO');
	
	}
	elseif ($tipo_turno == 'A') {
		
		$consultaComponente = getData($fechas,'06:00','15:36','COMPONENTE');

		$consultaPoliducto = getData($fechas,'06:00','15:36','POLIDUCTO');

		$consultaTolvasSE = getTolvasSE($fechas,$tipo_turno);

		$consultaFullComponente = getData($fechas,'06:00','15:36','FULL_COMPONENTE');
		$consultaFullPoliducto = getData($fechas,'06:00','15:36','FULL_POLIDUCTO');

		//$consultaTolvasPersonas
		
	}
	elseif ($tipo_turno== 'Comparativo'){

		$consultaComponente = getData($fechas,'06:00','15:36','COMPONENTE');

		$consultaPoliducto = getData($fechas,'06:00','15:36','POLIDUCTO');

		$consultaFullComponente = getData($fechas,'06:00','15:36','FULL_COMPONENTE');
		$consultaFullPoliducto = getData($fechas,'06:00','15:36','FULL_POLIDUCTO');

		$consultaTolvasSE = getTolvasSE($fechas,'A');

		$fechaAd = date('Y-m-d', strtotime($fecha_inicio . ' + 1 day'));
		$fechasB = array();
		array_push($fechasB,$fecha_inicio);
		array_push($fechasB,$fechaAd);

		$consultaComponenteB = getBData($fechasB,'15:36','0:15','COMPONENTE');

		$consultaPoliductoB = getBData($fechasB,'15:36','0:15','POLIDUCTO');

		$consultaTolvasSEB = getTolvasSE($fechasB,'B');

		$consultaFullComponenteB = getBData($fechasB,'15:36','0:15','FULL_COMPONENTE');
		$consultaFullPoliductoB = getBData($fechasB,'15:36','0:15','FULL_POLIDUCTO');

	}

	$arrayRes['info'] = array();
	for ($i=0; $i <count($consultaComponente) ; $i++) { 
		array_push($arrayRes['info'], array(
											'tolvas'=> ($consultaComponente[$i]+$consultaPoliducto[$i]+$consultaTolvasSE[$i]),
											'tolvasSC' => $consultaTolvasSE[$i],
											'componente'=>$consultaComponente[$i],
											'poliducto'=>$consultaPoliducto[$i],
											'eficiencia'=>round((($consultaComponente[$i]+$consultaPoliducto[$i])/2000)*100).'%',
											'fecha' => $fechas[$i]));
	}

	if (count($consultaComponente)==1) {
		if ($tipo_turno=='Comparativo') {
			$arrayRes['infoB']=array();
			for ($i=0; $i <count($consultaComponenteB) ; $i++) { 
				array_push($arrayRes['infoB'], array(
					'tolvas'=> ($consultaComponenteB[$i]+$consultaPoliductoB[$i]+$consultaTolvasSEB[$i]),
					'tolvasSC' => $consultaTolvasSEB[$i],
					'componente'=>$consultaComponenteB[$i],
					'poliducto'=>$consultaPoliductoB[$i],
					'eficiencia'=>round((($consultaComponenteB[$i]+$consultaPoliductoB[$i])/2000)*100).'%',
					'fecha' => $fechas[$i]));
			}
			$arrayRes['fullTolvas'] = array();
			$arrayRes['fullTolvasB'] = array();
			array_push($arrayRes['fullTolvas'],combinarTablasTolvas($consultaFullComponente,$consultaFullPoliducto));
			$combArray = combinarTablasTolvas($consultaFullComponente,$consultaFullPoliducto);
			$sum = obtenerSumatoriaComponentePoliducto($combArray);

			$combArrayB = combinarTablasTolvas($consultaFullComponenteB,$consultaFullPoliductoB);
			$sumB = obtenerSumatoriaComponentePoliducto($combArrayB);

			$arrayRes['totales'] = array();
			$arrayRes['totalesB'] = array();
			array_push($arrayRes['totales'],$sum);
			array_push($arrayRes['totalesB'],$sumB);
			array_push($arrayRes['fullTolvasB'],combinarTablasTolvas($consultaFullComponenteB,$consultaFullPoliductoB));
			$arrayRes['tolvasPersonas'] = array();
			array_push($arrayRes['tolvasPersonas'],getTolvasPersonas($fechas,'A'));
			
			$arrayRes['infoH']=array();
			$tolvasH = getTolvasHora($fechas,'','','A');
				foreach ($tolvasH as $key) {
					array_push($arrayRes['infoH'],array('horas'=>getTime($key['Hora']),'tolvas'=>$key['Tolvas']));
				}

			//$arrayRes['infoHA']=array();
			
			//$arrayRes['infoHA']=$arrayRes['infoH'];
				

				$arrayRes['infoHB']=array();

				$fechaAd = date('Y-m-d', strtotime($fecha_inicio . ' + 1 day'));
				$fechasB = array();
				array_push($fechasB,$fecha_inicio);
				array_push($fechasB,$fechaAd);
				$tolvasH = getTolvasHora($fechasB,'','','B');
				foreach ($tolvasH as $key) {
					array_push($arrayRes['infoHB'],array('horas'=>getTime($key['Hora']),'tolvas'=>$key['Tolvas']));
				}
				
			//$arrayRes['tolvasPersonasB'] = array();
				//array_push($arrayRes['tolvasPersonasB'],getTolvasPersonas($fechas,'B'));

				//echo json_encode($arrayRes);

		}
		else{
			if ($tipo_turno=='B') {
				$arrayRes['infoH']=array();

				$fechaAd = date('Y-m-d', strtotime($fecha_inicio . ' + 1 day'));
				$fechasB = array();
				array_push($fechasB,$fecha_inicio);
				array_push($fechasB,$fechaAd);
				$tolvasH = getTolvasHora($fechasB,'','','B');
				foreach ($tolvasH as $key) {
					array_push($arrayRes['infoH'],array('horas'=>getTime($key['Hora']),'tolvas'=>$key['Tolvas']));
				}
				$arrayRes['tolvasPersonas'] = array();
				array_push($arrayRes['tolvasPersonas'],getTolvasPersonas($fechasB,'B'));

				$arrayRes['fullTolvas'] = array();
				$arrayRes['totales'] = array();
				array_push($arrayRes['fullTolvas'],combinarTablasTolvas($consultaFullComponente,$consultaFullPoliducto));
				array_push($arrayRes['totales'],obtenerSumatoriaComponentePoliducto(combinarTablasTolvas($consultaFullComponente,$consultaFullPoliducto)));
				//echo json_encode($arrayRes);

				
			}
			elseif ($tipo_turno=='A') {
				$arrayRes['infoH']=array();

				$tolvasH = getTolvasHora($fechas,'','','A');
				foreach ($tolvasH as $key) {
					array_push($arrayRes['infoH'],array('horas'=>getTime($key['Hora']),'tolvas'=>$key['Tolvas']));
				}

				$arrayRes['tolvasPersonas'] = array();
				array_push($arrayRes['tolvasPersonas'],getTolvasPersonas($fechas,'A'));


				$arrayRes['fullTolvas'] = array();
				$arrayRes['totales'] = array();
				array_push($arrayRes['fullTolvas'],combinarTablasTolvas($consultaFullComponente,$consultaFullPoliducto));
				array_push($arrayRes['totales'],obtenerSumatoriaComponentePoliducto(combinarTablasTolvas($consultaFullComponente,$consultaFullPoliducto)));
				//echo json_encode($arrayRes);

				
			}

		}

	}
	

	//echo json_encode($arrayRes['infoHB']);
	echo json_encode($arrayRes);

	function getTime($date){
		$dateTime = date('h:ia', strtotime($date));
	    $hour = date('h', strtotime($date));
	    $minute = date('i', strtotime($date));

	    // Si los minutos son mayores o iguales a 30, redondeamos la hora al siguiente valor
	    if ($minute >= 30) {
	        $hour = (int)$hour + 1;
	    }

	    // Aseguramos que la hora tenga dos dígitos, agregando un cero si es necesario
	    $hour = str_pad($hour, 2, '0', STR_PAD_LEFT);

	    // Establecemos los minutos en 00
	    $minute = '00';

	    // Determinamos si es AM o PM
	    $ampm = date('A', strtotime($date));

	    // Concatenamos la hora y los minutos con AM o PM para obtener el resultado final
	    $roundedTime = $hour . ':' . $minute . ' ' . $ampm;

	    return $roundedTime;
	}


	function getTolvasHora($fechas,$turno_inicio,$turno_fin,$tipo_turno){
		$serverName = "10.215.156.203\IFV55";
		$connectionInfo = array( 	"Database"=>"SMS",
									"UID"=>"sa", 
									"PWD"=>"System@dm1n"
								);
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		if ($tipo_turno=="B") {
			$b = 0;
			$var=array();
			for ($i=0; $i < count($fechas) ; $i++) {
				$b += 1;
				if ($b>= count($fechas)) {
					break;
				}

				//$rak = sqlsrv_query($conn,"SELECT     count(*) as tolvas FROM [SMS].[dbo].[ChkComp_MainMov] WHERE scandate BETWEEN '$fechas[$i] 15:36' AND '$fechas[$b] 0:09'and status = 'OKK'");
				$rak = sqlsrv_query($conn,"SELECT CONVERT(CHAR(13), scandate, 120)  + ':00:00' AS Hora, COUNT(scandate) as Tolvas
					FROM [SMS].[dbo].[ChkComp_MainMov]
					WHERE scandate BETWEEN '$fechas[$i] 15:36' AND '$fechas[$b] 0:09'and sn <>'0FV559000000000' and badge <>'-1' 
					GROUP BY CONVERT(CHAR(13), scandate, 120)
					");
				//$rak = sqlsrv_query($conn, "SELECT count(SN) as tolvas FROM ChkComp_MainMov WHERE ScanDate BETWEEN '$fechas[$i] 15:36' AND '$fechas[$b] 0:09' AND SN LIKE 'N%'");
				
				while ($res = sqlsrv_fetch_array($rak,SQLSRV_FETCH_ASSOC)) {
					array_push($var, $res);
				}
				

			}

			return $var;
		}
		elseif ($tipo_turno=="A"){
			$var=array();
			
			foreach ($fechas as $key) {
				//$rak = sqlsrv_query($conn,"SELECT     count(*) as tolvas FROM [SMS].[dbo].[ChkComp_MainMov] WHERE scandate BETWEEN '$key 06:00' AND '$key 15:36'and status = 'OKK'");
				$rak = sqlsrv_query($conn,"SELECT CONVERT(CHAR(13), scandate, 120)  + ':00:00' AS Hora, COUNT(scandate) as Tolvas
					FROM [SMS].[dbo].[ChkComp_MainMov]
					WHERE scandate BETWEEN '$key 06:00' AND '$key 15:36'and sn <>'0FV559000000000' and badge <>'-1' 
					GROUP BY CONVERT(CHAR(13), scandate, 120) order by Hora
					");

				while ($res = sqlsrv_fetch_array($rak,SQLSRV_FETCH_ASSOC)) {
					array_push($var, $res);

				}
				
			}
			return $var;
		}


	}
	function obtenerSumatoriaComponentePoliducto($tabla_combinada) {
    $sumatoriaComponente = 0;
    $sumatoriaPoliducto = 0;
    $sumatoriaTotal = 0;

    foreach ($tabla_combinada as $empleado) {
        $sumatoriaComponente += $empleado["COMPONENTE"];
        $sumatoriaPoliducto += $empleado["POLIDUCTO"];
        $sumatoriaTotal += $empleado["TOTAL"];
    }

    return [
        "TOTAL_COMPONENTE" => $sumatoriaComponente,
        "TOTAL_POLIDUCTO" => $sumatoriaPoliducto,
        "TOTALES" => $sumatoriaTotal
    ];
}
	function getTolvasPersonas($fechas,$tipo_turno){
		$serverName = "10.215.156.203\IFV55";
		$connectionInfo = array( 	"Database"=>"SMS",
									"UID"=>"sa", 
									"PWD"=>"System@dm1n"
								);
		$conn = sqlsrv_connect( $serverName, $connectionInfo);

		if ($tipo_turno=="B") {
			$b = 0;
			$var=array();
			for ($i=0; $i < count($fechas) ; $i++) {
				$b += 1;
				if ($b>= count($fechas)) {
					break;
				}

				//$rak = sqlsrv_query($conn,"SELECT     count(*) as tolvas FROM [SMS].[dbo].[ChkComp_MainMov] WHERE scandate BETWEEN '$fechas[$i] 15:36' AND '$fechas[$b] 0:09'and status = 'OKK'");
				$rak = sqlsrv_query($conn,"SELECT ChkComp_MainMov.Badge,Sy_Users.Name, Sy_Users.LastName, count(ChkComp_MainMov.IdKanban) as Tolvas
					  FROM Sy_Users full join ChkComp_MainMov on ChkComp_MainMov.Badge=Sy_Users.Badge  
					  WHERE ScanDate  >= '$fechas[$i] 15:36' and ScanDate < '$fechas[$b] 00:10'and sn <>'0FV559000000000' and ChkComp_MainMov.badge <>'-1' group by ChkComp_MainMov.Badge, Name, LastName order by Tolvas asc");

		
				while ($res = sqlsrv_fetch_array($rak,SQLSRV_FETCH_ASSOC)) {
					$rest=["Badge"=>$res['Badge'],
							"Name"=>$res['Name'],
							"LastName"=>$res['LastName'],
							"Tolvas"=>$res['Tolvas'],
							"Eficiencia"=>((($res['Tolvas'])*100)/250)."%"];
					array_push($var,$rest);
					
					
					
				}
				
				
			}

			return $var;
		}
		elseif ($tipo_turno=="A"){
			$var=array();
			
			foreach ($fechas as $key) {
				//$rak = sqlsrv_query($conn,"SELECT     count(*) as tolvas FROM [SMS].[dbo].[ChkComp_MainMov] WHERE scandate BETWEEN '$key 06:00' AND '$key 15:36'and status = 'OKK'");
				$rak = sqlsrv_query($conn, "SELECT ChkComp_MainMov.Badge,Sy_Users.Name, Sy_Users.LastName, count(ChkComp_MainMov.IdKanban) as Tolvas FROM Sy_Users full join ChkComp_MainMov on ChkComp_MainMov.Badge=Sy_Users.Badge WHERE ScanDate  >= '$key 06:00' and ScanDate < '$key 15:36'and sn <>'0FV559000000000' and ChkComp_MainMov.badge <>'-1' group by ChkComp_MainMov.Badge, Name, LastName order by Tolvas asc");
				

				while ($res = sqlsrv_fetch_array($rak,SQLSRV_FETCH_ASSOC)) {
						
					$rest=["Badge"=>$res['Badge'],
							"Name"=>$res['Name'],
							"LastName"=>$res['LastName'],
							"Tolvas"=>$res['Tolvas'],
							"Eficiencia"=>((($res['Tolvas'])*100)/250)."%"];
					array_push($var,$rest);
					
					
					
				}
				
			}
			return $var;
		}
	}
	function getTolvasSE($fechas,$tipo_turno){
		$serverName = "10.215.156.203\IFV55";
		$connectionInfo = array( 	"Database"=>"SMS",
									"UID"=>"sa", 
									"PWD"=>"System@dm1n"
								);
		$conn = sqlsrv_connect( $serverName, $connectionInfo);

		if ($tipo_turno=="B") {
			$b = 0;
			$var=array();
			for ($i=0; $i < count($fechas) ; $i++) {
				$b += 1;
				if ($b>= count($fechas)) {
					break;
				}

				//$rak = sqlsrv_query($conn,"SELECT     count(*) as tolvas FROM [SMS].[dbo].[ChkComp_MainMov] WHERE scandate BETWEEN '$fechas[$i] 15:36' AND '$fechas[$b] 0:09'and status = 'OKK'");
				$rak = sqlsrv_query($conn, "SELECT count(*) as tolvas FROM ChkComp_MainMov WHERE ScanDate BETWEEN '$fechas[$i] 15:36' AND '$fechas[$b] 0:09' AND SN LIKE 'N%';
					");

				$rak2 = sqlsrv_query($conn,"SELECT count(*) as tolvas2 FROM ChkComp_MainMov WHERE ScanDate BETWEEN '$fechas[$i] 15:36' AND '$fechas[$b] 0:09' AND SN IS NULL");
		
				$sum = 0;
				while ($res = sqlsrv_fetch_array($rak,SQLSRV_FETCH_ASSOC)) {
						while ($res2 = sqlsrv_fetch_array($rak2,SQLSRV_FETCH_ASSOC)) {
						$sum = $res['tolvas']+$res2['tolvas2'];
						array_push($var,$sum);
					
					}
					
				}
				
			}

			return $var;
		}
		elseif ($tipo_turno=="A"){
			$var=array();
			
			foreach ($fechas as $key) {
				//$rak = sqlsrv_query($conn,"SELECT     count(*) as tolvas FROM [SMS].[dbo].[ChkComp_MainMov] WHERE scandate BETWEEN '$key 06:00' AND '$key 15:36'and status = 'OKK'");
				$rak = sqlsrv_query($conn, "SELECT count(*) as tolvas FROM ChkComp_MainMov WHERE ScanDate BETWEEN '$key 06:00' AND '$key 15:36' AND SN LIKE 'N%';
					");

				$rak2 = sqlsrv_query($conn,"SELECT count(*) as tolvas2 FROM ChkComp_MainMov WHERE ScanDate BETWEEN '$key 06:00' AND '$key 15:36' AND SN IS NULL");
		
				$sum = 0;
				while ($res = sqlsrv_fetch_array($rak,SQLSRV_FETCH_ASSOC)) {
						while ($res2 = sqlsrv_fetch_array($rak2,SQLSRV_FETCH_ASSOC)) {
						$sum = $res['tolvas']+$res2['tolvas2'];
						array_push($var,$sum);
					
					}
					
				}
				
			}
			return $var;
		}
	}

	function getBData($fechas,$turno_inicio,$turno_fin,$consulta){
		$serverName = "10.215.156.203\IFV55";
		$connectionInfo = array( 	"Database"=>"SMS",
									"UID"=>"sa", 
									"PWD"=>"System@dm1n"
								);
		$conn = sqlsrv_connect( $serverName, $connectionInfo);

		if ($consulta=='COMPONENTE') {
			$b = 0;
			$var=array();
			for ($i=0; $i < count($fechas) ; $i++) {
				$b += 1;
				if ($b>= count($fechas)) {
					break;
				}

				$rak = sqlsrv_query($conn,"SELECT Count(*) as COMPONENTE FROM [SMS].[dbo].[ChkComp_MainMov]  where scandate >= '$fechas[$i] $turno_inicio' and scandate < '$fechas[$b] $turno_fin'and sn <>'0FV559000000000' and badge <>'-1'");
				
				while ($res = sqlsrv_fetch_array($rak,SQLSRV_FETCH_ASSOC)) {
					array_push($var, $res['COMPONENTE']);
				}
				

			}

			return $var;
		}
		else if($consulta=='POLIDUCTO'){
			$b = 0;
			$var=array();
			for ($i=0; $i < count($fechas) ; $i++) {
				$b += 1;
				if ($b>= count($fechas)) {
					break;
				}

				$rak = sqlsrv_query($conn,"SELECT Count(*) as POLIDUCTO FROM [SMS].[dbo].[ChkComp_MainMov]  where scandate >= '$fechas[$i] $turno_inicio' and scandate < '$fechas[$b] $turno_fin' and sn ='0FV559000000000'");
				while ($res = sqlsrv_fetch_array($rak,SQLSRV_FETCH_ASSOC)) {
					array_push($var, $res['POLIDUCTO']);
				}
				

			}

			return $var;
		}
		elseif ($consulta=="FULL_COMPONENTE"){
			$b = 0;
			$var=array();
			for ($i=0; $i < count($fechas) ; $i++) {
				$b += 1;
				if ($b>= count($fechas)) {
					break;
				}

				//$rak = sqlsrv_query($conn,"SELECT Count(*) as COMPONENTE FROM [SMS].[dbo].[ChkComp_MainMov]  where scandate >= '$fechas[$i] $turno_inicio' and scandate < '$fechas[$b] $turno_fin'and sn <>'0FV559000000000' and badge <>'-1'");
				$rak = sqlsrv_query($conn,"SELECT Route, COUNT(Route) AS COMPONENTE
					FROM [SMS].[dbo].[ChkComp_MainMov]
					WHERE scandate BETWEEN '$fechas[$i] $turno_inicio' AND '$fechas[$b] $turno_fin'and sn <>'0FV559000000000' and badge <>'-1' 
					GROUP BY Route");
				
				while ($res = sqlsrv_fetch_array($rak,SQLSRV_FETCH_ASSOC)) {
					array_push($var, $res);
				}
				

			}

			return $var;

		}
		elseif ($consulta=="FULL_POLIDUCTO"){
			$b = 0;
			$var=array();
			for ($i=0; $i < count($fechas) ; $i++) {
				$b += 1;
				if ($b>= count($fechas)) {
					break;
				}

				//$rak = sqlsrv_query($conn,"SELECT Count(*) as COMPONENTE FROM [SMS].[dbo].[ChkComp_MainMov]  where scandate >= '$fechas[$i] $turno_inicio' and scandate < '$fechas[$b] $turno_fin'and sn <>'0FV559000000000' and badge <>'-1'");
				$rak = sqlsrv_query($conn,"SELECT Route, COUNT(Route) AS POLIDUCTO
					FROM [SMS].[dbo].[ChkComp_MainMov]
					WHERE scandate BETWEEN '$fechas[$i] $turno_inicio' AND '$fechas[$b] $turno_fin'and sn ='0FV559000000000' 
					GROUP BY Route");
				
				while ($res = sqlsrv_fetch_array($rak,SQLSRV_FETCH_ASSOC)) {
					array_push($var, $res);
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



		if ($consulta=='COMPONENTE') {
			$var=array();
			
			foreach ($fechas as $key) {
				$rak = sqlsrv_query($conn,"SELECT Count(*) as COMPONENTE FROM [SMS].[dbo].[ChkComp_MainMov]  where scandate >= '$key $turno_inicio' and scandate < '$key $turno_fin'and sn <>'0FV559000000000' and badge <>'-1'");
				//echo "SELECT Count(*) as COMPONENTE FROM [SMS].[dbo].[ChkComp_MainMov]  where scandate >= '$key $turno_inicio' and scandate < '$key $turno_fin'and sn <>'0FV559000000000' and badge <>'-1'";
				/*
				$rak=sqlsrv_query($conn,"SELECT Route, COUNT(Route) AS COMPONENTE FROM ChkComp_MainMov WHERE scandate BETWEEN '$key $turno_inicio' AND '$key $turno_fin'and sn <>'0FV559000000000' and badge <>'-1' GROUP BY Route");*/

				while ($res = sqlsrv_fetch_array($rak,SQLSRV_FETCH_ASSOC)) {
					array_push($var, $res['COMPONENTE']);
				}
				
			}
			return $var;
		}
		else if($consulta=='POLIDUCTO')
		{
			$var=array();
			
			foreach ($fechas as $key) {
				/*
				$rak=sqlsrv_query($conn,"SELECT Route, COUNT(Route) AS POLIDUCTO FROM ChkComp_MainMov WHERE scandate BETWEEN '$key $turno_inicio' AND '$key $turno_fin'and sn ='0FV559000000000' GROUP BY Route");*/
				$rak = sqlsrv_query($conn,"SELECT Count(*) as POLIDUCTO FROM [SMS].[dbo].[ChkComp_MainMov]  where scandate >= '$key $turno_inicio' and scandate < '$key $turno_fin' and sn ='0FV559000000000'");
				//echo "SELECT Count(*) as POLIDUCTO FROM [SMS].[dbo].[ChkComp_MainMov]  where scandate >= '$key $turno_inicio' and scandate < '$key $turno_fin'and sn ='0FV559000000000'";
				while ($res = sqlsrv_fetch_array($rak,SQLSRV_FETCH_ASSOC)) {
					array_push($var, $res['POLIDUCTO']);
				}
				
			}
			return $var;
		}
		elseif ($consulta=="FULL_COMPONENTE"){
			$var=array();
			
			foreach ($fechas as $key) {
				/*
				$rak=sqlsrv_query($conn,"SELECT Route, COUNT(Route) AS POLIDUCTO FROM ChkComp_MainMov WHERE scandate BETWEEN '$key $turno_inicio' AND '$key $turno_fin'and sn ='0FV559000000000' GROUP BY Route");*/
				$rak = sqlsrv_query($conn,"SELECT        Route as Route, COUNT(Route) AS COMPONENTE
								FROM [SMS].[dbo].[ChkComp_MainMov]
								WHERE scandate BETWEEN '$key $turno_inicio' AND '$key $turno_fin'and sn <>'0FV559000000000' and badge <>'-1' 
								GROUP BY Route");
				//echo "SELECT Count(*) as POLIDUCTO FROM [SMS].[dbo].[ChkComp_MainMov]  where scandate >= '$key $turno_inicio' and scandate < '$key $turno_fin'and sn ='0FV559000000000'";
				while ($res = sqlsrv_fetch_array($rak,SQLSRV_FETCH_ASSOC)) {
					array_push($var, $res);
				}
				
			}
			return $var;

		}
		elseif ($consulta == "FULL_POLIDUCTO"){
			$var=array();
			
			foreach ($fechas as $key) {
				/*
				$rak=sqlsrv_query($conn,"SELECT Route, COUNT(Route) AS POLIDUCTO FROM ChkComp_MainMov WHERE scandate BETWEEN '$key $turno_inicio' AND '$key $turno_fin'and sn ='0FV559000000000' GROUP BY Route");*/
				$rak = sqlsrv_query($conn,"SELECT        Route as Route, COUNT(Route) AS POLIDUCTO
								FROM [SMS].[dbo].[ChkComp_MainMov]
								WHERE scandate BETWEEN '$key $turno_inicio' AND '$key $turno_fin'and sn ='0FV559000000000' 
								GROUP BY Route");
				//echo "SELECT Count(*) as POLIDUCTO FROM [SMS].[dbo].[ChkComp_MainMov]  where scandate >= '$key $turno_inicio' and scandate < '$key $turno_fin'and sn ='0FV559000000000'";
				while ($res = sqlsrv_fetch_array($rak,SQLSRV_FETCH_ASSOC)) {
					array_push($var, $res);
				}
				
			}
			return $var;

		}


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

function combinarTablasTolvas($tabla_uno, $tabla_dos) {
    // Convertir la tabla_uno en un diccionario asociativo para facilitar el acceso por Route (Código de empleado)
    $dict_tabla_uno = [];
    foreach ($tabla_uno as $empleado_uno) {
        $Route = $empleado_uno["Route"];
        $COMPONENTE = isset($empleado_uno["COMPONENTE"]) ? $empleado_uno["COMPONENTE"] : 0;
        $dict_tabla_uno[$Route] = ["COMPONENTE" => $COMPONENTE, "POLIDUCTO" => 0];
    }

    // Crear un arreglo final combinando ambas tablas utilizando solo Route, COMPONENTE y POLIDUCTO
    $tabla_final = [];
    foreach ($tabla_dos as $empleado_dos) {
        $Route = $empleado_dos["Route"];
        $COMPONENTE = isset($empleado_dos["COMPONENTE"]) ? $empleado_dos["COMPONENTE"] : 0;
        $POLIDUCTO = isset($empleado_dos["POLIDUCTO"]) ? $empleado_dos["POLIDUCTO"] : 0;
        
        // Verificar si el Route existe en la tabla_uno
        if (isset($dict_tabla_uno[$Route])) {
            $COMPONENTE_tabla_uno = $dict_tabla_uno[$Route]["COMPONENTE"];
            $POLIDUCTO_tabla_uno = $dict_tabla_uno[$Route]["POLIDUCTO"];
        } else {
            // Si no existe en la tabla_uno, el valor de COMPONENTE y POLIDUCTO será 0
            $COMPONENTE_tabla_uno = 0;
            $POLIDUCTO_tabla_uno = 0;
        }

        // Crear un nuevo arreglo con Route, COMPONENTE y POLIDUCTO combinados
        $empleado_completo = [
            "Route" => $Route,
            "COMPONENTE" => $COMPONENTE_tabla_uno + $COMPONENTE, // Sumar los valores de COMPONENTE de ambas tablas
            "POLIDUCTO" => $POLIDUCTO_tabla_uno + $POLIDUCTO, // Sumar los valores de POLIDUCTO de ambas tablas
            "TOTAL" => $COMPONENTE_tabla_uno + $COMPONENTE + $POLIDUCTO_tabla_uno + $POLIDUCTO, // Suma total de COMPONENTE y POLIDUCTO individual
        ];
        $tabla_final[] = $empleado_completo;

        // Eliminar el registro del Route en el diccionario para evitar duplicados
        unset($dict_tabla_uno[$Route]);
    }

    // Agregar los registros restantes de la tabla_uno que no tienen información en la tabla_dos
    foreach ($dict_tabla_uno as $Route => $datos_uno) {
        $empleado_completo = [
            "Route" => $Route,
            "COMPONENTE" => $datos_uno["COMPONENTE"],
            "POLIDUCTO" => $datos_uno["POLIDUCTO"],
            "TOTAL" => $datos_uno["COMPONENTE"] + $datos_uno["POLIDUCTO"], // Suma total de COMPONENTE y POLIDUCTO individual
        ];
        $tabla_final[] = $empleado_completo;
    }

    return $tabla_final;
}


?>