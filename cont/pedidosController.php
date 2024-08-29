<?php
	include '../../connection.php';
	date_default_timezone_set('America/Mexico_City');
	$request = $_REQUEST['request'];

	if ($request == 'addPedido') {
		$partNumber = $_REQUEST['partNumber'];
		$partNumber = strtoupper($partNumber);
		$params = array($partNumber);

		$sqlStatement = "
			SELECT 
			    Smk_Inv.SN, 
			    Smk_Inv.PN, 
			    Smk_Inv.Loc, 
			    PFEP_MasterV2.Descrip 
			FROM 
			    Smk_Inv 
			LEFT JOIN 
			    ChkBTS_Pedidos ON Smk_Inv.SN = ChkBTS_Pedidos.Serial 
			JOIN 
			    PFEP_MasterV2 ON Smk_Inv.PN = PFEP_MasterV2.PN 
			WHERE 
			    Smk_Inv.PN = ? 
			    AND Smk_Inv.Status = 'A' 
			    AND ChkBTS_Pedidos.Serial IS NULL 
			ORDER BY 
			    Smk_Inv.SN DESC;
		";
		//echo "$sqlStatement";
		$sqlQuery = sqlsrv_query($conn, $sqlStatement, $params);

		$datos = array();

		if ($sqlQuery === false) {
		    // Manejo de errores en caso de que la consulta falle
		    echo json_encode(array("response" => "error"));
		    die();
		}

		if (sqlsrv_has_rows($sqlQuery)) {
		    while ($data = sqlsrv_fetch_array($sqlQuery, SQLSRV_FETCH_ASSOC)) {
		      
		            $partNumber = $partNumber;
		            $serialNumber = $data['SN'];
		            $materialLocation = $data['Loc'];
		            $materialDescription = str_replace('?', '', utf8_decode($data['Descrip']));
		       
		    }

		    $params = array($partNumber,$serialNumber,$materialLocation,$materialDescription,date('H:i:s', strtotime('-1 hour')), date('Y-m-d H:i:s', strtotime('-1 hour')),"PENDIENTE");

		    $sqlInsertStatement = "INSERT INTO ChkBTS_Pedidos(
		    	PN, Serial, Location, Descripcion, PedidoHora, FechaPedido, EstatusPedido
		    ) VALUES(?, ?, ?, ?, ?, ?, ?)";
		   
		   $sqlQueryInsert = sqlsrv_query($conn,$sqlInsertStatement,$params);
		   if ($sqlQueryInsert === false) {
			    // Manejo de errores en caso de que la consulta falle
		   		if( ($errors = sqlsrv_errors() ) != null) {
			      
			    }
			    echo json_encode(array("response" => "error"));
			    die();
			}

		    echo json_encode(array("response" => "success"));

		} else {
		    echo json_encode(array("response" => "NoData"));
		}

	}
	elseif ($request == 'getPedidoMobileList') {
		$sqlStatement = "SELECT * FROM ChkBTS_Pedidos WHERE EstatusPedido NOT LIKE '%COMPLETADO%' ORDER BY FechaPedido ASC";
		$sqlQuery = sqlsrv_query($conn,$sqlStatement);

		$data = array();
		while ($dato = sqlsrv_fetch_array($sqlQuery, SQLSRV_FETCH_ASSOC)) {
		    array_push($data, array(
		        "ID" => isset($dato['ID']) ? $dato['ID'] : "",
		        "PN" => isset($dato['PN']) ? $dato['PN'] : "",
		        "Serial" => isset($dato['Serial']) ? $dato['Serial'] : "",
		        "Location" => isset($dato['Location']) ? $dato['Location'] : "",
		        "Descripcion" => isset($dato['Descripcion']) ? $dato['Descripcion'] : "",
		        "PedidoHora" => isset($dato['PedidoHora']) ? $dato['PedidoHora']->format('H:i:s') : "",
		        "EstatusPedido" => getStatusColor($dato['EstatusPedido']),
		        "Acciones" =>getActionMessage($dato['EstatusPedido'],$dato['ID'])
		    ));
		}

		echo json_encode(array("response" => "success", "data" => $data));
	}
	elseif ($request == 'getPedidoList') {
		$sqlStatement = "SELECT * FROM ChkBTS_Pedidos LEFT JOIN Sy_Users ON ChkBTS_Pedidos.fk_badge = Sy_Users.badge WHERE EstatusPedido NOT LIKE '%COMPLETADO%'  ORDER BY FechaPedido DESC";
		$sqlQuery = sqlsrv_query($conn,$sqlStatement);

		$data = array();
		while ($dato = sqlsrv_fetch_array($sqlQuery, SQLSRV_FETCH_ASSOC)) {
		    array_push($data, array(
		        "ID" => isset($dato['ID']) ? $dato['ID'] : "",
		        "PN" => isset($dato['PN']) ? $dato['PN'] : "",
		        "Serial" => isset($dato['Serial']) ? $dato['Serial'] : "",
		        "Location" => isset($dato['Location']) ? $dato['Location'] : "",
		        "Descripcion" => isset($dato['Descripcion']) ? $dato['Descripcion'] : "",
		        "PedidoHora" => isset($dato['PedidoHora']) ? $dato['PedidoHora']->format('H:i:s') : "",
		        "PedidoSurtido" => isset($dato['PedidoSurtido']) ? $dato['PedidoSurtido']->format('H:i:s') : "",
		        "TiempoAccion" => isset($dato['TiempoAccion']) ? $dato['TiempoAccion'] : "",
		        "FechaPedido" => isset($dato['FechaPedido']) ? $dato['FechaPedido']->format('d-m-Y H:i:s') : "",
		        "EstatusPedido" => getStatusColor($dato['EstatusPedido']),
		        "Surtidor" => isset($dato['Name']) ? $dato['Name'] : "",
		        "Acciones"=>"<button class='btn btn-danger' onclick='delPedidosModal(\"" . $dato['ID'] . "\")'><i class='fa fa-trash'></i></button>"
		    ));
		}

		echo json_encode(array("response" => "success", "data" => $data));
	}
	elseif ($request=='getPedidoCompleteList'){
		$sqlStatement = "SELECT  TOP(100) ID,PN,Serial,Location,Descripcion,PedidoHora,PedidoSurtido, DATEDIFF(MINUTE,PedidoHora,PedidoSurtido)-10 as TiempoAccion, FechaPedido, EstatusPedido,COALESCE(Name,'NA') as Name FROM ChkBTS_Pedidos LEFT JOIN Sy_Users ON fk_badge = Badge WHERE ChkBTS_Pedidos.EstatusPedido LIKE '%COMPLETADO%' ORDER BY FechaPedido DESC";
		$sqlQuery = sqlsrv_query($conn,$sqlStatement);

		$data = array();
		while ($dato = sqlsrv_fetch_array($sqlQuery, SQLSRV_FETCH_ASSOC)) {
		    array_push($data, array(
		        "ID" => isset($dato['ID']) ? $dato['ID'] : "",
		        "PN" => isset($dato['PN']) ? $dato['PN'] : "",
		        "Serial" => isset($dato['Serial']) ? $dato['Serial'] : "",
		        "Location" => isset($dato['Location']) ? $dato['Location'] : "",
		        "Descripcion" => isset($dato['Descripcion']) ? $dato['Descripcion'] : "",
		        "PedidoHora" => isset($dato['PedidoHora']) ? $dato['PedidoHora']->format('H:i:s') : "",
		        "PedidoSurtido" => isset($dato['PedidoSurtido']) ? $dato['PedidoSurtido']->format('H:i:s') : "",
		        "TiempoAccion" => getSurtido(isset($dato['TiempoAccion']) ? $dato['TiempoAccion'] : ""),
		        "FechaPedido" => isset($dato['FechaPedido']) ? $dato['FechaPedido']->format('d-m-Y H:i:s') : "",
		        "EstatusPedido" => getStatusColor($dato['EstatusPedido']),
		        "Surtidor" => isset($dato['Name']) ? $dato['Name'] : ""
		    ));
		}

		echo json_encode(array("response" => "success", "data" => $data));
	}
	elseif ($request == 'takePedido') {
		$ID = $_REQUEST['ID'];
		$badge = $_REQUEST['badge'];

		$params = array("EN PROCESO",$badge,$ID);
		$sqlStatement = "UPDATE ChkBTS_Pedidos SET EstatusPedido = ?, fk_badge = ? WHERE ID = ?";

		$sqlQuery = sqlsrv_query($conn,$sqlStatement,$params);

		if ($sqlQuery === false) {
		    
		    echo json_encode(array("response" => "error"));
		    die();
		}
		echo json_encode(array("response"=>"requestTaken"));

	}
	elseif ($request == 'autoCompletePedidos') {
		// Asumiendo que tienes una conexión $conn usando sqlsrv
		$sqlQuery = "
		    UPDATE ChkBTS_Pedidos
			SET 
			    EstatusPedido = 'COMPLETADO',
			    PedidoSurtido = Smk_InvDet.ActionDate,
			    TiempoAccion = DATEDIFF(MINUTE, DATEADD(SECOND, DATEDIFF(SECOND, '00:00:00', ChkBTS_Pedidos.PedidoHora), ChkBTS_Pedidos.FechaPedido), Smk_InvDet.ActionDate)
			FROM 
			    ChkBTS_Pedidos
			JOIN 
			    Smk_InvDet ON ChkBTS_Pedidos.Serial = Smk_InvDet.SN
			WHERE 
			    Smk_InvDet.Action IN ('EMPTY', 'OPEN')
			    AND ChkBTS_Pedidos.EstatusPedido <> 'COMPLETADO';
		";

		// Ejecutar la consulta
		$stmt = sqlsrv_query($conn, $sqlQuery);

		if ($stmt) {
		    echo json_encode(array('response' => 'success'));
		} else {
		    $errors = sqlsrv_errors();
		    echo json_encode(array('response' => 'error', 'message' => $errors));
		}
	}
	elseif ($request == 'delPedido'){
		$id = $_REQUEST['ID'];
		$badge = $_REQUEST['badge'];

		//Comprobar si existe y tiene permisos
		$sqlCheck = "SELECT count(*) as count FROM Sy_Users WHERE Badge = '$badge' AND (Area = 'BARRELS DR' OR Area = 'ADMIN')";
		$sql_query = sqlsrv_query($conn, $sqlCheck);

		if ($sql_query !== false) {
		    $row = sqlsrv_fetch_array($sql_query);
		    $row_count = $row['count'];
		    
		    if ($row_count > 0) {
		        sqlsrv_query($conn, "SET CONTEXT_INFO 0x" . bin2hex($badge));
				$sql = "DELETE FROM ChkBTS_Pedidos WHERE ID = ?";
				$params = array($id);

				$stmt = sqlsrv_query($conn, $sql, $params);
				if ($stmt) {
				    echo json_encode(array('response' => 'success'));
				} else {
				    $errors = sqlsrv_errors();
				    echo json_encode(array('response' => 'error', 'message' => $errors));
				}
		    } else {
		        echo json_encode(array('response' => 'NoFound'));
		    }
		} else {
		    echo json_encode(array('response' => 'fail'));
		}

		
	}

	function getActionMessage($estatus,$id){
		if ($estatus=="PENDIENTE") {
			return "<button class='btn btn-primary' onclick='atentionMaterial(\"" . $id . "\")'><i class='fa fa-share'></i> Atender</button>";
		}
		else{
			return "NA"; 
		}
	}
	function getStatusColor($estatus){
		if ($estatus == "PENDIENTE") {
			return "<span style='color:red; font-weight: bold;'>Pendiente de surtir</span>";
		}
		elseif ($estatus == "EN PROCESO") {
			return "<span style ='color:#cfae00; font-weight: bold;'>En proceso de surtido</span>";
		}
		else{
			return "<span style = 'color:green; font-weight: bold;'>Surtido completado</span>";
		}
	}
	function getSurtido($tiempo){
		if ($tiempo<=0) {
			return "<span style = 'color:green; font-weight:bold;font-size: 25px;'>".$tiempo."</span>";
		}
		else{
			return "<span style = 'color:red; font-weight:bold;font-size: 25px;'>".$tiempo."</span>";
		}
	}

?>

