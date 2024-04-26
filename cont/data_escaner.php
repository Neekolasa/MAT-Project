<?php
	include '../../connection.php';
	$request = $_GET['request'];
	if ($request == 'dataEscaner'){
		$badge = $_GET['badge'];

		$fecha = (Date('Y-m-d'));
		
		$sql_request = "SELECT
		    Badge,
		    Name,
		    LastName,
		    SUM(CASE WHEN Action = 'CHANGE' THEN 1 ELSE 0 END) AS CONTINGENCIA,
		    SUM(CASE WHEN Action = 'PUT AWAY' THEN 1 ELSE 0 END) AS RACKEO,
		    SUM(CASE WHEN Action = 'CHANGE' THEN 1 ELSE 0 END) + SUM(CASE WHEN Action = 'PUT AWAY' THEN 1 ELSE 0 END) AS TotalAcciones
		FROM (
		    SELECT
		        Su.Badge,
		        Su.Name,
		        Su.LastName,
		        Sid.Action,
		        Sid.ActionDate
		    FROM Sy_Users Su
		    LEFT JOIN Smk_InvDet Sid ON Sid.Badge = Su.Badge
		    WHERE Su.Badge = '$badge' AND Sid.ActionDate >= '$fecha 00:00') 
			Subquery
			GROUP BY Badge, Name, LastName
			ORDER BY TotalAcciones";

		$sql_request_tolva = "
		SELECT
		    Sy_Users.Name + ' ' + Sy_Users.LastName AS Nombre,
		    SUM(CASE WHEN sn <> '0FV559000000000' THEN 1 ELSE 0 END) AS COMPONENTE,
		    SUM(CASE WHEN sn = '0FV559000000000' THEN 1 ELSE 0 END) AS POLIDUCTO,
		    SUM(CASE WHEN sn <> '0FV559000000000' THEN 1 ELSE 0 END) + SUM(CASE WHEN sn = '0FV559000000000' THEN 1 ELSE 0 END) AS Total
		FROM
		    Sy_Users
		JOIN
		    ChkComp_MainMov ON ChkComp_MainMov.Badge = Sy_Users.Badge
		WHERE
		    scandate >= '$fecha 00:00:00'
		    AND scandate < '$fecha 23:59:59'
		    AND Sy_Users.badge = '$badge'
		GROUP BY
		    Sy_Users.Name + ' ' + Sy_Users.LastName";

		//echo $sql_request;
		$sql_query = sqlsrv_query($conn,$sql_request);
		$sql_query_tolva = sqlsrv_query($conn,$sql_request_tolva);
		
		$arrayUserData['SMKT'] = array();
		$arrayUserData['Rutas'] = array();
		while ($dataUser = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
			$arrayUserData['SMKT'] = $dataUser;
		}
		unset($dataUser);

		while ($dataUser = sqlsrv_fetch_array($sql_query_tolva,SQLSRV_FETCH_ASSOC)) {
			$arrayUserData['Rutas'] = $dataUser;
		}


		//$arrayUserData = combinarTablas($arrayContingencia,$arrayRackeo);

		//echo json_encode($arrayRackeo);
		echo json_encode($arrayUserData);

  		

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

?>