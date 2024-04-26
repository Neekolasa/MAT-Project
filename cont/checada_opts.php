<?php 

	include '../../connection.php';
	$request = $_GET['request'];

	if ($request == 'GETOPTS') {
		$sql_request = "SELECT 
						    ID,
						    CONVERT(VARCHAR(5), TiempoSalida, 108) AS TiempoSalida,
						    CONVERT(VARCHAR(5), TiempoEntrada, 108) AS TiempoEntrada
						FROM Horarios
						--WHERE TiempoSalida<'19:20' 
						ORDER BY TiempoSalida;";
		$sql_request_two = "SELECT 
						    ID,
						    CONVERT(VARCHAR(5), TiempoSalida, 108) AS TiempoSalida,
						    CONVERT(VARCHAR(5), TiempoEntrada, 108) AS TiempoEntrada
						FROM Horarios
						--WHERE TiempoSalida>='19:20' 
						ORDER BY TiempoSalida;";

		$sql_query = sqlsrv_query($conn,$sql_request);
		$sql_query_two = sqlsrv_query($conn,$sql_request_two);

		$arrayOptions['Desayuno'] = array();
		$arrayOptions['Comida'] = array();
		while ($data = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
			array_push($arrayOptions['Desayuno'],array(
				"ID" => $data['ID'],
				"TiempoSalida" => $data['TiempoSalida'],
				"TiempoEntrada" => $data['TiempoEntrada']
			));
			//$desayuno.="<option value='$data[ID]'> $data[TiempoSalida] - $data[TiempoEntrada] <option>";
		}
		unset($data);
		while ($data = sqlsrv_fetch_array($sql_query_two,SQLSRV_FETCH_ASSOC)) {
			array_push($arrayOptions['Comida'],array(
				"ID" => $data['ID'],
				"TiempoSalida" => $data['TiempoSalida'],
				"TiempoEntrada" => $data['TiempoEntrada']
			));
		}

		echo json_encode($arrayOptions);
		//echo $desayuno;
	}
	else if($request=='getData'){
		$num_empleado = $_GET['num_empleado'];


		$sql_request = "SELECT 
						    SP.Badge,
						    SP.Nombre,
						    SP.Area,
						    HDesayuno.ID AS IDDesayuno,
						    SUBSTRING(CONVERT(varchar, HDesayuno.TiempoSalida, 108), 1, 5) AS TiempoSalidaDesayuno,
						    SUBSTRING(CONVERT(varchar, HDesayuno.TiempoEntrada, 108), 1, 5) AS TiempoEntradaDesayuno,
						    HComida.ID AS IDComida,
						    SUBSTRING(CONVERT(varchar, HComida.TiempoSalida, 108), 1, 5) AS TiempoSalidaComida,
						    SUBSTRING(CONVERT(varchar, HComida.TiempoEntrada, 108), 1, 5) AS TiempoEntradaComida
						FROM SalidasPersonal AS SP
						JOIN Horarios AS HDesayuno ON SP.Desayuno = HDesayuno.ID
						JOIN Horarios AS HComida ON SP.Comida = HComida.ID
						WHERE SP.Badge = '$num_empleado'";
		$sql_query = sqlsrv_query($conn,$sql_request);

		$arrayModify['User'] = array();
		while ($data = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
			array_push($arrayModify['User'], array(
				'Nombre' => $data['Nombre'],
				'Area' => $data['Area'],
				'TiempoSalidaDesayuno' => $data['TiempoSalidaDesayuno'],
				'TiempoEntradaDesayuno' => $data['TiempoEntradaDesayuno'],
				'TiempoSalidaComida' => $data['TiempoSalidaComida'],
				'TiempoEntradaComida' => $data['TiempoEntradaComida'],
				'IDDesayuno' => $data['IDDesayuno'],
				'IDComida' => $data['IDComida']
			));
		}

		echo json_encode($arrayModify);
	}

?>