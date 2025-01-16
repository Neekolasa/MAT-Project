<?php
session_start();
include '../../connection.php';
include 'encriptar.php';

$request = $_REQUEST['request'];

if ($request == 'getPartNumberInfo') {
    $moverPartNumber = $_REQUEST['moverPartNumber'];
    //echo "$moverPartNumber";

    if (empty($moverPartNumber)) {
        $response = array('response' => 'fail');
    } else {
        $sql_statement = "
            SELECT
			    PN,
			    Descrip,
			    CASE
			        WHEN UoM = 'FT' THEN 'M'
			        ELSE UoM
			    END AS UoM
			FROM
			    PFEP_MasterV2
			WHERE
			    PN = ?;
        ";


        $params = array($moverPartNumber);
        $sql_query = sqlsrv_query($conn, $sql_statement, $params);

        if ($sql_query === false) {
            $response = array('response' => 'fail');
        } else {
            $datos = array();

            while ($data = sqlsrv_fetch_array($sql_query, SQLSRV_FETCH_ASSOC)) {
                foreach ($data as $key => $value) {
                   	$cleanedValue = iconv('UTF-8', 'ASCII//IGNORE', $value);
    				$data[$key] = preg_replace('/[^\p{L}\p{N}\s]/u', '', $cleanedValue);
				}

                $datos[] = $data;
            }

            if (empty($datos)) {
                $response = array('response' => 'fail');
            } else {
                $response = array('response' => 'success', 'data' => $datos);
            }
        }
    }

    echo json_encode($response);
}
elseif ($request == 'tempMover') {
	$moverPartNumber = strtoupper($_REQUEST['moverPartNumber']);
	$moverQty = $_REQUEST['moverQty'];
	$moverDescription = $_REQUEST['moverDescription'];
	$moverUom = $_REQUEST['moverUom'];
	$moverMovType = $_REQUEST['moverMovType'];
	$moverSapDocument = $_REQUEST['moverSapDocument'];
	$userLogged = $_REQUEST['userLogged'];
	$uniqueID = $_REQUEST['uniqueID'];

	$sql_statement = "
	    INSERT INTO TempMaterialMover
	    ([Partnumber], [Description], [QTY], [UoM], [MovementType], [SapDocument], [CreatedBy],[UniqueID])
	    VALUES (?, ?, ?, ?, ?, ?, ?,?)
	";
	$params = array($moverPartNumber, $moverDescription, $moverQty, $moverUom, $moverMovType, $moverSapDocument, $userLogged,$uniqueID);

	$sql_query = sqlsrv_query($conn, $sql_statement, $params);
	

	
	if ($sql_query === false) {
	    $response = array('response' => 'fail');
	} else {
	    $response = array('response' => 'success');
	}

	echo json_encode($response);
}
elseif ($request == 'getMoverOwner'){
	$userLogged = $_REQUEST['userLogged'];

	$sql_statement = "SELECT * FROM TempMaterialMover WHERE CreatedBy = '$userLogged'";
	$sql_query = sqlsrv_query($conn,$sql_statement);

	$datos = array();
	while ($data = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
		array_push($datos, array(
							'ID'=>$data['ID'],
							'PN' => $data['Partnumber'],
							'Description' => $data['Description'],
							'UoM' => $data['UoM'],
							'Qty' => $data['QTY'],
							'Action' => "<button id='details' onclick='deleteMoverItem(`$data[UniqueID]`,`$userLogged`)' class='btn btn-danger' data-toggle='modal' data-target='#modal_details'><i class='fa fa-trash'></i> Eliminar</button>
									" 
							));
	}

	echo json_encode($datos);
}
elseif ($request == 'deleteMoverItem') {
	$userLogged = $_REQUEST['userLogged'];
	$uniqueID = $_REQUEST['uniqueID'];

	$sql_statement = "DELETE FROM TempMaterialMover WHERE UniqueID = '$uniqueID' AND CreatedBy = '$userLogged'";
	//echo "$sql_statement";
	$sql_query = sqlsrv_query($conn,$sql_statement);

	if ($sql_query === false) {
	    $response = array('response' => 'fail');
	} else {
	    $response = array('response' => 'success');
	}

	echo json_encode($response);
}
elseif ($request == 'getUserInfo') {
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	$password = encrypt($password,'neeko');

	$sql_statement = "SELECT userName, FullName, mainPermission FROM moverPersonal WHERE userName = ? AND Password = ?";

	$sql_query = sqlsrv_prepare($conn, $sql_statement, array(&$username, &$password));

	if (sqlsrv_execute($sql_query)) {
	    $information = array();
	    while ($data = sqlsrv_fetch_array($sql_query, SQLSRV_FETCH_ASSOC)) {
	        array_push($information, array(
	            'username' => $data['userName'],
	            'fullname' => decrypt($data['FullName'],'neeko'),
	            'permission' => decrypt($data['mainPermission'],'neeko')
	        ));
	    }

	    if (empty($information)) {
	        $response = array('response' => 'fail');
	    } else {
	        $response = array('response' => 'success', 'information' => $information);
	    }
	} else {
	    $response = array('response' => 'error');
	}

	sqlsrv_free_stmt($sql_query);

	echo json_encode($response);
}
elseif ($request == 'setGlobal'){
	if (isset($_REQUEST['username'])) {
		$username = $_REQUEST['username'];
		$fullname = $_REQUEST['fullname'];
		
		$_SESSION['username'] = $username;
		$_SESSION['fullname'] = $fullname;


	}
}
elseif ($request == 'getGlobalUsername') {
	if (isset($_SESSION['username'])) {

		$response = $_SESSION['username'];
	}
	else{
		$response = 'error';
	}

	echo ($response);	
}
elseif ($request == 'getGlobalFullName') {
	if (isset($_SESSION['fullname'])) {

		$response = $_SESSION['fullname'];
	}
	else{
		$response = 'error';
	}

	echo ($response);
}
elseif ($request == 'delGlobal') {
	session_unset(); 
	session_destroy();
	 
	echo json_encode(array('response' => 'success'));
}
elseif($request == 'getPromise'){
	$userLogged = $_REQUEST['userLogged'];

	$sql_statement = "SELECT * FROM TempMaterialMover WHERE CreatedBy = '$userLogged'";
	$sql_query = sqlsrv_query($conn,$sql_statement);
	//echo "$sql_statement";
	if ($sql_query === false) {
    // Error en la consulta
    echo json_encode(array('response' => 'fail'));
	} else {
	    // Verificar si se obtuvieron registros
	    $row_count = sqlsrv_has_rows($sql_query);

	    if ($row_count === false) {
	        echo json_encode(array('response' => 'fail'));
	    } elseif ($row_count === true) {
	        echo json_encode(array('response' => 'success'));
	    } else {
	        echo json_encode(array('response' => 'fail'));
	    }
	    sqlsrv_free_stmt($sql_query);
	}
}
elseif ($request == 'addMoverData') {
	$plantaOrigen           = $_REQUEST['plantaOrigen'];
	$usuarioAutoriza        = $_REQUEST['usuarioAutoriza'];
	$fechaCreacion          = $_REQUEST['fechaCreacion'];
	$plantaDestino          = $_REQUEST['plantaDestino'];
	$atencionUsuario        = $_REQUEST['atencionUsuario'];
	$telefonoOrigen         = $_REQUEST['telefonoOrigen'];
	$telefonoAtencion       = $_REQUEST['telefonoAtencion'];
	$instruccionesEnvio     = $_REQUEST['instruccionesEnvio'];
	$comentariosAdicionales = $_REQUEST['comentariosAdicionales'];
	$userLogged             = $_REQUEST['userLogged'];
	$moverUniqueID          = $_REQUEST['moverUniqueID'];
	try {
	  
		    // Consulta preparada para MoverData
		    $sql_statement = "
		    INSERT INTO MoverData
		           (ShipPlant
		           ,CreatedDate
		           ,AuthorizedUser
		           ,ShipInstructions
		           ,Telephone
		           ,OriginPlant
		           ,RequestUser
		           ,Status
		           ,RequestUserPhone
		           ,AdditionalComments
		           ,CreatedBy
		           ,UniqueID)
	     VALUES
	           (?, GETDATE(), ?, ?, ?, ?, ?, 'NEW', ?, ?, ?, ?);
	    ";

	    $params = array(
	        $plantaDestino,
	        utf8_encode($usuarioAutoriza),
	       utf8_encode($instruccionesEnvio),
	        $telefonoOrigen,
	        $plantaOrigen,
	        utf8_encode($atencionUsuario),
	        $telefonoAtencion,
	        utf8_encode($comentariosAdicionales),
	        $userLogged,
	        $moverUniqueID
	    );

	    $sql_query_insertMoverData = sqlsrv_query($conn, $sql_statement, $params);
	    if (!$sql_query_insertMoverData) {
	        throw new Exception("Error al insertar en MoverData");
	    }

	    // Consulta preparada para moverItems
	    $sql_statement_moverItems = "
	    SELECT * FROM TempMaterialMover WHERE CreatedBy = ?;
	    ";

	    $params_moverItems = array($userLogged);
	    $sql_query_moverItems = sqlsrv_query($conn, $sql_statement_moverItems, $params_moverItems);
	    if (!$sql_query_moverItems) {
	        throw new Exception("Error al seleccionar de TempMaterialMover");
	    }

	    while ($moverItem = sqlsrv_fetch_array($sql_query_moverItems, SQLSRV_FETCH_ASSOC)) {
	        // Consulta preparada para moveMoverItems
	        $sql_moveMoverItems = "
	        INSERT INTO MaterialMover VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);
	        ";

	        $params_moveMoverItems = array(
	            $moverItem['Partnumber'],
	            $moverItem['Description'],
	            $moverItem['QTY'],
	            $moverItem['MovementType'],
	            $moverItem['SapDocument'],
	            $moverItem['CreatedBy'],
	            $moverItem['UoM'],
	            $moverItem['UniqueID'],
	            $moverUniqueID
	        );

	        $sql_queryMoveItems = sqlsrv_query($conn, $sql_moveMoverItems, $params_moveMoverItems);
	        if (!$sql_queryMoveItems) {
	            throw new Exception("Error al insertar en MaterialMover");
	        }
	    }

	    // Consulta preparada para eliminar de TempMaterialMover
	    $sql_delStatement = "DELETE FROM TempMaterialMover WHERE CreatedBy = ?;";
	    $params_del = array($userLogged);
	    $sql_delQuery = sqlsrv_query($conn, $sql_delStatement, $params_del);
	    if (!$sql_delQuery) {
	        throw new Exception("Error al eliminar de TempMaterialMover");
	    }

	    sqlsrv_close($conn);

	    // Todas las consultas se ejecutaron correctamente
	    echo json_encode(array('response' => 'success'));
	} catch (Exception $e) {
	    // Se produjo un error en alguna consulta
	    echo json_encode(array('response' => 'fail', 'error' => $e->getMessage()));
	}
}
elseif( $request == 'getUsernameFunction')
{
	echo $_SESSION['username'];
}
elseif ($request == 'getCreatedMover') {
	$userLogged = $_REQUEST['userLogged'];

	$sql_statement = "SELECT COUNT(*) as MoversCreados FROM MoverData WHERE --CreatedBy = ? AND 
	Status = 'New'";

	$params = array($userLogged);
	$sql_query = sqlsrv_query($conn,$sql_statement,$params);

	$info = array();
	while ($data = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
		array_push($info, array('createdMovers'=>$data['MoversCreados']));
	}

	if ($sql_query === false) {
    // Error en la consulta
    echo json_encode(array('response' => 'fail'));
	} else {
	    // Verificar si se obtuvieron registros
	    $row_count = sqlsrv_has_rows($sql_query);

	    if ($row_count === false) {
	        echo json_encode(array('response' => 'fail'));
	    } elseif ($row_count === true) {
	        echo json_encode(array('response' => 'success', 'info' => $info));
	    } else {
	        echo json_encode(array('response' => 'fail'));
	    }
	    sqlsrv_free_stmt($sql_query);
	}
}
elseif ($request == 'getProccessingMover') {
	$userLogged = $_REQUEST['userLogged'];

	$sql_statement = "SELECT COUNT(*) as processingMovers FROM MoverData WHERE --CreatedBy = ? AND 
	Status = 'Processing'";

	$params = array($userLogged);
	$sql_query = sqlsrv_query($conn,$sql_statement,$params);

	$info = array();
	while ($data = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
		array_push($info, array('processingMovers'=>$data['processingMovers']));
	}

	if ($sql_query === false) {
    // Error en la consulta
    echo json_encode(array('response' => 'fail'));
	} else {
	    // Verificar si se obtuvieron registros
	    $row_count = sqlsrv_has_rows($sql_query);

	    if ($row_count === false) {
	        echo json_encode(array('response' => 'fail'));
	    } elseif ($row_count === true) {
	        echo json_encode(array('response' => 'success', 'info' => $info));
	    } else {
	        echo json_encode(array('response' => 'fail'));
	    }
	    sqlsrv_free_stmt($sql_query);
	}
}
elseif ($request == 'getFinishedMover') {
	$userLogged = $_REQUEST['userLogged'];

	$sql_statement = "SELECT COUNT(*) as finishedMovers FROM MoverData WHERE --CreatedBy = ? AND 
	Status = 'Finished'";

	$params = array($userLogged);
	$sql_query = sqlsrv_query($conn,$sql_statement,$params);

	$info = array();
	while ($data = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
		array_push($info, array('finishedMovers'=>$data['finishedMovers']));
	}

	if ($sql_query === false) {
    
    echo json_encode(array('response' => 'fail'));
	} else {

	    $row_count = sqlsrv_has_rows($sql_query);

	    if ($row_count === false) {
	        echo json_encode(array('response' => 'fail'));
	    } elseif ($row_count === true) {
	        echo json_encode(array('response' => 'success', 'info' => $info));
	    } else {
	        echo json_encode(array('response' => 'fail'));
	    }
	    sqlsrv_free_stmt($sql_query);
	}
}
elseif ($request == 'getShippedMover') {
	$userLogged = $_REQUEST['userLogged'];

	$sql_statement = "SELECT COUNT(*) as shippedMover FROM MoverData WHERE Status = 'Shipped'";

	$params = array($userLogged);
	$sql_query = sqlsrv_query($conn,$sql_statement,$params);

	$info = array();
	while ($data = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
		array_push($info, array('shippedMover'=>$data['shippedMover']));
	}

	if ($sql_query === false) {
    // Error en la consulta
    echo json_encode(array('response' => 'fail'));
	} else {
	    // Verificar si se obtuvieron registros
	    $row_count = sqlsrv_has_rows($sql_query);

	    if ($row_count === false) {
	        echo json_encode(array('response' => 'fail'));
	    } elseif ($row_count === true) {
	        echo json_encode(array('response' => 'success', 'info' => $info));
	    } else {
	        echo json_encode(array('response' => 'fail'));
	    }
	    sqlsrv_free_stmt($sql_query);
	}
}
elseif($request == 'getCreatedMoverInfo'){
	$userLogged = $_REQUEST['userLogged'];
	$subRequest = $_REQUEST['subRequest'];

	if ($subRequest == 'getAllMovers') {
		$paramUser = array($userLogged);

		$sql_statement = "SELECT 
		ID,
		AuthorizedUser,
	    RequestUser, 
	    ShipPlant, 
	    ShipInstructions, 
	    AdditionalComments, 
	    CASE 
	        WHEN Status = 'New' THEN 'Espera de preparación'
	        WHEN Status = 'Processing' THEN 'Preparando mover'
	        WHEN Status = 'Finished' THEN 'Salio a embarques'
	        WHEN Status = 'Shipped' THEN 'Salio de planta'
	        ELSE Status 
	    END AS Status, 
	    CreatedDate, 
	    UniqueID 
		FROM MoverData WHERE --CreatedBy = ? AND 
		Status = 'New'";

		$sql_query = sqlsrv_query($conn,$sql_statement,$paramUser);
		$datos = array();

		while ($info = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
			 $formattedDate = $info['CreatedDate']->format('d-m-Y H:i');
			array_push($datos, array(	"ID"=>$info['ID'],
														"RequestUser"=>utf8_decode($info['AuthorizedUser']),
														"ShipPlant"=>$info['ShipPlant'],
														"ShipInstructions"=>utf8_decode($info['ShipInstructions']),
														"AdditionalComments"=>utf8_decode($info['AdditionalComments']),
														"Status"=>$info['Status'],
														"CreatedDate"=>$formattedDate,
														"Action" => "<button id='details' title = 'Detalles'  onclick='detailsMoverItem(`$info[UniqueID]`,`$userLogged`)' class='btn btn-primary' data-toggle='modal' data-target='#modalMoverDetails'><i class='fa fa-info'></i> </button>
														<button id='details' title = 'Imprimir'  onclick='printMoverItem(`$info[UniqueID]`,`$userLogged`)' class='btn btn-success'><i class='fa fa-print'></i> </button>
														<button id='details' title = 'Ajustes'  onclick='addComment(`$info[UniqueID]`,`$userLogged`)' class='btn btn-info'><i class='fa fa-cog'></i> </button>
										"
			));
			
		}
		echo json_encode($datos);
	}
	elseif ($subRequest == 'getProccesMovers') {
		$paramUser = array($userLogged);

		$sql_statement = "SELECT 
		ID,
		AuthorizedUser,
	    RequestUser, 
	    ShipPlant, 
	    ShipInstructions, 
	    AdditionalComments, 
	    CASE 
	        WHEN Status = 'New' THEN 'Espera de preparación'
	        WHEN Status = 'Processing' THEN 'Preparando mover'
	        WHEN Status = 'Finished' THEN 'Salio a embarques'
	        WHEN Status = 'Shipped' THEN 'Salio de planta'
	        ELSE Status 
	    END AS Status, 
	    CreatedDate, 
	    UniqueID 
		FROM MoverData WHERE Status = 'Processing'";

		$sql_query = sqlsrv_query($conn,$sql_statement,$paramUser);
		$datos = array();

		while ($info = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
			  $formattedDate = $info['CreatedDate']->format('d-m-Y H:i');
			array_push($datos, array(	
														"ID"=>$info['ID'],
														"RequestUser"=>utf8_decode($info['AuthorizedUser']),
														"ShipPlant"=>$info['ShipPlant'],
														"ShipInstructions"=>utf8_decode($info['ShipInstructions']),
														"AdditionalComments"=>utf8_decode($info['AdditionalComments']),
														"Status"=>$info['Status'],
														"CreatedDate"=>$formattedDate,
														"Action" => "<button id='details' title = 'Detalles'  onclick='detailsMoverItem(`$info[UniqueID]`,`$userLogged`)' class='btn btn-primary' data-toggle='modal' data-target='#modalMoverDetails'><i class='fa fa-info'></i> </button>
														<button id='details' title = 'Imprimir'  onclick='printMoverItem(`$info[UniqueID]`,`$userLogged`)' class='btn btn-success'><i class='fa fa-print'></i> </button>
														<button id='details' title = 'Ajustes'  onclick='addComment(`$info[UniqueID]`,`$userLogged`)' class='btn btn-info'><i class='fa fa-cog'></i> </button>
										"
			));
			
		}
		echo json_encode($datos);
	}
	elseif ($subRequest == 'getFinishedMovers') {
		$paramUser = array($userLogged);

		$sql_statement = "SELECT
		ID,
		AuthorizedUser,
	    RequestUser, 
	    ShipPlant, 
	    ShipInstructions, 
	    AdditionalComments, 
	    CASE 
	        WHEN Status = 'New' THEN 'Espera de preparación'
	        WHEN Status = 'Processing' THEN 'Preparando mover'
	        WHEN Status = 'Finished' THEN 'Salio a embarques'
	        WHEN Status = 'Shipped' THEN 'Salio de planta'
	        ELSE Status 
	    END AS Status, 
	    CreatedDate, 
	    UniqueID 
		FROM MoverData WHERE Status = 'Finished'";

		$sql_query = sqlsrv_query($conn,$sql_statement,$paramUser);
		$datos = array();

		while ($info = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
			  $formattedDate = $info['CreatedDate']->format('d-m-Y H:i');
			array_push($datos, array(
														"ID"=>$info['ID'],
														"RequestUser"=>utf8_decode($info['AuthorizedUser']),
														"ShipPlant"=>$info['ShipPlant'],
														"ShipInstructions"=>utf8_decode($info['ShipInstructions']),
														"AdditionalComments"=>utf8_decode($info['AdditionalComments']),
														"Status"=>$info['Status'],
														"CreatedDate"=>$formattedDate,
														"Action" => "<button id='details' title = 'Detalles'  onclick='detailsMoverItem(`$info[UniqueID]`,`$userLogged`)' class='btn btn-primary' data-toggle='modal' data-target='#modalMoverDetails'><i class='fa fa-info'></i> </button>
														<button id='details' title = 'Imprimir'  onclick='printMoverItem(`$info[UniqueID]`,`$userLogged`)' class='btn btn-success'><i class='fa fa-print'></i> </button>
														<button id='details' title = 'Ajustes'  onclick='addComment(`$info[UniqueID]`,`$userLogged`)' class='btn btn-info'><i class='fa fa-cog'></i> </button>
										"
			));
			
		}
		echo json_encode($datos);
	}
	elseif ($subRequest == 'getShippedMovers') {
		$paramUser = array($userLogged);

		$sql_statement = "SELECT 
		    MoverData.ID,
		    MoverData.RequestUser,
		    MoverData.AuthorizedUser, 
		    MoverData.ShipPlant, 
		    MoverData.ShipInstructions, 
		    MoverData.AdditionalComments, 
		    CASE 
		        WHEN MoverData.Status = 'New' THEN 'Espera de preparación'
		        WHEN MoverData.Status = 'Processing' THEN 'Preparando mover'
		        WHEN MoverData.Status = 'Finished' THEN 'Salio a embarques'
		        WHEN MoverData.Status = 'Shipped' THEN 'Salio de planta'
		        ELSE MoverData.Status 
		    END + ' <br> ' + RecentComments.Comment AS Status, 
		    MoverData.CreatedDate, 
		    MoverData.UniqueID 
		FROM 
		    MoverData 
		LEFT JOIN 
		    (SELECT 
		         MoverComments.Fk_mover,
		         MoverComments.Comment,
		         ROW_NUMBER() OVER (PARTITION BY MoverComments.Fk_mover ORDER BY MoverComments.CreatedDate DESC) AS RowNum
		     FROM 
		         MoverComments 
		     WHERE 
		         MoverComments.AreaComment = 'send'
		    ) AS RecentComments ON MoverData.UniqueID = RecentComments.Fk_mover AND RecentComments.RowNum = 1
		WHERE 
		    MoverData.Status = 'Shipped'";

		$sql_query = sqlsrv_query($conn,$sql_statement,$paramUser);
		$datos = array();

		while ($info = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
			  $formattedDate = $info['CreatedDate']->format('d-m-Y H:i');
			array_push($datos, array(
														"ID"=>$info['ID'],
														"RequestUser"=>utf8_decode($info['AuthorizedUser']),
														"ShipPlant"=>$info['ShipPlant'],
														"ShipInstructions"=>utf8_decode($info['ShipInstructions']),
														"AdditionalComments"=>utf8_decode($info['AdditionalComments']),
														"Status"=>utf8_decode($info['Status']),
														"CreatedDate"=>$formattedDate,
														"Action" => "<button id='details' title = 'Detalles'  onclick='detailsMoverItem(`$info[UniqueID]`,`$userLogged`)' class='btn btn-primary' data-toggle='modal' data-target='#modalMoverDetails'><i class='fa fa-info'></i> </button>
														<button id='details' title = 'Imprimir'  onclick='printMoverItem(`$info[UniqueID]`,`$userLogged`)' class='btn btn-success'><i class='fa fa-print'></i> </button>
														<button id='details' title = 'Ajustes' onclick='addComment(`$info[UniqueID]`,`$userLogged`)' class='btn btn-info'><i class='fa fa-cog'></i> </button>
										"
			));
			
		}
		echo json_encode($datos);
	}	
}
elseif($request == 'getCreatedMoverMaterials'){
	$uniqueID = $_REQUEST['UniqueID'];
	$userLogged = $_REQUEST['userLogged'];

	$paramsData = array($uniqueID);

	$sql_statement = "SELECT * FROM MaterialMover WHERE Fk_Mover = ?";
	$sql_query = sqlsrv_query($conn,$sql_statement,$paramsData);

	$dataMaterial = array();
	while ($material = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
		array_push($dataMaterial, array(
																"Partnumber"=>$material['Partnumber'],
																"Description"=>$material['Description'],
																"Qty"=>$material['QTY'],
																"MovementType"=>$material['MovementType'],
																"SapDocument"=>$material['SapDocument'],
																"UoM"=>$material['UoM'],
																"ID"=>$material['UniqueID']

		));
	}

	echo json_encode($dataMaterial);
}
elseif($request == 'updateStatus'){
	$statusMover = $_REQUEST['statusMover'];
	$userLogged = $_REQUEST['userLogged'];
	$moverUniqueID = $_REQUEST['moverUniqueID'];
	$params = array($statusMover, $moverUniqueID);

	$sql_statement = "UPDATE MoverData SET Status = ? WHERE UniqueID = ?";
	$sql_query = sqlsrv_query($conn, $sql_statement, $params);

	if ($sql_query === false) {
	    echo json_encode(array('response' => 'fail'));
	} else {
	    echo json_encode(array('response' => 'success'));
	}
}
elseif ($request == 'addExtraComment') {
	$commentAdded = utf8_encode($_REQUEST['commentAdded']);
	$moverUniqueID = $_REQUEST['moverUniqueID'];
	$permission = $_REQUEST['permission'];
	$userLogged = $_REQUEST['userLogged'];
	$createdDate = $_REQUEST['createdDate'];
	$params = array(utf8_encode($commentAdded),$permission,$userLogged,$moverUniqueID,$createdDate);

	$sql_statement = "INSERT INTO MoverComments (Comment, AreaComment, UserLogged, Fk_Mover, CreatedDate) VALUES (?, ?, ?, ?, ?)";

	$sql_query = sqlsrv_query($conn,$sql_statement,$params);

	if ($sql_query === false) {
	    echo json_encode(array('response' => 'fail'));
	} else {
	    echo json_encode(array('response' => 'success'));
	}
}
elseif ($request == 'getMoverComment') {
	$uniqueID = $_REQUEST['UniqueID'];

	$params = array($uniqueID);
	$sql_statement = "SELECT MoverComments.ID, MoverComments.Comment, MoverComments.AreaComment, MoverComments.UserLogged, MoverComments.Fk_mover,MoverComments.CreatedDate,moverPersonal.FullName,
        CASE 
            WHEN AreaComment = 'delivery' THEN 'Recibos'
            WHEN AreaComment = 'spmk' THEN 'Supermercado'
            WHEN AreaComment = 'send' THEN 'Embarques'
            ELSE AreaComment
        END AS NewAreaComment,
        CONVERT(varchar, CreatedDate, 105) + ' ' + CONVERT(varchar, CreatedDate, 108) AS FormattedDate
    FROM MoverComments JOIN moverPersonal on MoverComments.UserLogged = moverPersonal.userName
    WHERE Fk_Mover = ?";

	$sql_query = sqlsrv_query($conn, $sql_statement, $params);
	$datos = array();

	while ($data = sqlsrv_fetch_array($sql_query, SQLSRV_FETCH_ASSOC)) {
	    //$datos[] = $data;
	    array_push($datos,array(
	    	"FullName"=>decrypt($data['FullName'],'neeko'),
	    	"NewAreaComment"=>$data['NewAreaComment'],
	    	"Comment"=>utf8_decode($data['Comment']),
	    	"FormattedDate"=>$data['FormattedDate']
	    ));
	}

	$response = array();

	if (!empty($datos)) {
	    $response['response'] = 'success';
	    $response['data'] = $datos;
	} else {
	    $response['response'] = 'fail';
	}

	echo json_encode($response);
}
elseif ($request == 'processMasiveData')
{
	$results = json_decode($_REQUEST['results'], true);
	$userLogged = $_REQUEST['userLogged'];

	$datos = array();
	foreach ($results as $key) {
	    $params = array($key['Componente']);

	    $sql_statement = "SELECT Descrip, UoM FROM PFEP_MasterV2 WHERE PN = ?";

	    $sql_query = sqlsrv_query($conn, $sql_statement, $params);
	    $data = sqlsrv_fetch_array($sql_query, SQLSRV_FETCH_ASSOC);

	    if ($data === false || sqlsrv_has_rows($sql_query) === false) {
	        $response = array('response' => 'wrong', 'number' => $key['Componente']);
	        echo json_encode($response);
	        exit; 
	    }
	    else{
	    	$descrip = preg_replace('/[^a-zA-Z0-9 ]/', '', $data['Descrip']);
		    if ($data['UoM'] == "FT") {
		        $uom = "M";
		    } else {
		        $uom = $data['UoM']; 
		    }

		    $componente = $key['Componente'];
		    $qty = $key['Qty'];
		    $tsa = $key['TSA'];
		    $uniqueID = $key['UniqueID'];

		    $sql_statement2 = "
		        INSERT INTO TempMaterialMover
		        ([Partnumber], [Description], [QTY], [UoM], [MovementType], [SapDocument], [CreatedBy],[UniqueID])
		        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
		    ";
		    $fullParams = array($key['Componente'], $descrip, $key['Qty'], $uom, $key['TSA'], $key['Item'], $userLogged, $key['UniqueID']);

		    $sql_query = sqlsrv_query($conn, $sql_statement2, $fullParams);

		    if ($sql_query === false) {
		        $response = array('response' => 'fail');
		    } else {
		        $response = array('response' => 'success');
		    }
	    }

	    

	}

	echo json_encode($response);
}
elseif ($request == 'processExcelMasiveData')
{
	$results = json_decode($_REQUEST['results'], true);
	$userLogged = $_REQUEST['userLogged'];

	$datos = array();
	foreach ($results as $key) {
	    $params = array($key['Componente']);

	    $sql_statement = "SELECT Descrip, UoM FROM PFEP_MasterV2 WHERE PN = ?";

	    $sql_query = sqlsrv_query($conn, $sql_statement, $params);
	    $data = sqlsrv_fetch_array($sql_query, SQLSRV_FETCH_ASSOC);

	    if ($data === false || sqlsrv_has_rows($sql_query) === false) {
	        $response = array('response' => 'wrong', 'number' => $key['Componente']);
	        echo json_encode($response);
	        exit; 
	    }
	    else{
	    	$descrip = preg_replace('/[^a-zA-Z0-9 ]/', '', $data['Descrip']);
		   if ($data['UoM']=='FT') {
		   		$uom = "M";
		   }
		   else{
		   		$uom = $data['UoM'];
		   }
		    
		    

		    $componente = $key['Componente'];
		    $qty = $key['Cantidad'];
		    $tsa = $key['TSA'];
		    $uniqueID = $key['UniqueID'];

		    $sql_statement2 = "
		        INSERT INTO TempMaterialMover
		        ([Partnumber], [Description], [QTY], [UoM], [MovementType], [SapDocument], [CreatedBy],[UniqueID])
		        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
		    ";
		    $fullParams = array($key['Componente'], $descrip, $key['Cantidad'], $uom, $key['TSA'], $key['Item'], $userLogged, $key['UniqueID']);

		    $sql_query = sqlsrv_query($conn, $sql_statement2, $fullParams);

		    if ($sql_query === false) {
		        $response = array('response' => 'fail');
		    } else {
		        $response = array('response' => 'success');
		    }
	    }

	    

	}

	echo json_encode($response);
}
elseif ($request == 'getMoverByPN'){
	$searchedPN = $_REQUEST['searchedPN'];
	$userLogged = $_REQUEST['userLogged'];
	$param = array($searchedPN."");

	$sql_statement = "SELECT 
                MoverData.ID,
                MoverData.AuthorizedUser,
                MoverData.RequestUser, 
                MoverData.ShipPlant, 
                MoverData.ShipInstructions, 
                MoverData.AdditionalComments, 
                CASE 
                    WHEN MoverData.Status = 'New' THEN 'Espera de preparación'
                    WHEN MoverData.Status = 'Processing' THEN 'Preparando mover'
                    WHEN MoverData.Status = 'Finished' THEN 'Salio a embarques'
                    WHEN MoverData.Status = 'Shipped' THEN 'Salio de planta'
                    ELSE MoverData.Status 
                END AS Status, 
                MoverData.CreatedDate, 
                MoverData.UniqueID
                FROM MoverData JOIN MaterialMover ON MoverData.UniqueID = MaterialMover.Fk_Mover WHERE MaterialMover.Partnumber = ?
       ";
       
       $sql_query = sqlsrv_query($conn,$sql_statement,$param);

       $datos = array();

		while ($info = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
			  $formattedDate = $info['CreatedDate']->format('d-m-Y H:i');
			array_push($datos, array(
														"ID"=>$info['ID'],
														"RequestUser"=>utf8_decode($info['AuthorizedUser']),
														"ShipPlant"=>$info['ShipPlant'],
														"ShipInstructions"=>utf8_decode($info['ShipInstructions']),
														"AdditionalComments"=>utf8_decode($info['AdditionalComments']),
														"Status"=>utf8_decode($info['Status']),
														"CreatedDate"=>$formattedDate,
														"Action" => "<button id='details' title = 'Detalles'  onclick='detailsMoverItem(`$info[UniqueID]`,`$userLogged`)' class='btn btn-primary' data-toggle='modal' data-target='#modalMoverDetails'><i class='fa fa-info'></i> </button>
														<button id='details' title = 'Imprimir'  onclick='printMoverItem(`$info[UniqueID]`,`$userLogged`)' class='btn btn-success'><i class='fa fa-print'></i> </button>
														<button id='details' title = 'Ajustes' onclick='addComment(`$info[UniqueID]`,`$userLogged`)' class='btn btn-info'><i class='fa fa-cog'></i> </button>
										"
			));
			
		}

		echo json_encode($datos);
}
elseif ($request == 'deleteTempMoverNumbers'){
	$userLogged = $_REQUEST['userLogged'];
	$param = array($userLogged);
	$sql_statement = "DELETE FROM TempMaterialMover WHERE CreatedBy = ?";
	$sql_query = sqlsrv_query($conn,$sql_statement,$param);

	if ($sql_query === false) {
		        $response = array('response' => 'fail');
		    } else {
		        $response = array('response' => 'success');
		    }
	echo json_encode($response);
}
elseif ($request == 'getGraphicData') {
	$sql_statement = "
	SELECT TOP 30
	    CONVERT(DATE, CreatedDate) AS Fecha, 
	    COUNT(*) AS Registros
	FROM 
	    MoverData
	GROUP BY 
	    CONVERT(DATE, CreatedDate)
	ORDER BY 
	    Fecha DESC;
	    ";
	$sql_query = sqlsrv_query($conn,$sql_statement);
	$datos = array();
	    while ($data = sqlsrv_fetch_array($sql_query, SQLSRV_FETCH_ASSOC)) {
	        array_push($datos, array(
	            "Fecha" => $data['Fecha']->format('Y-m-d'),
	            "Registros"=>$data['Registros']
	          
	        ));
	    }

	    echo json_encode($datos);

}

function limpiarString($cadena) {

    $caracteresEspeciales = array(
        '/[áÁ]/u', '/[éÉ]/u', '/[íÍ]/u', '/[óÓ]/u', '/[úÚ]/u', 
        '/[ñÑ]/u', '/[üÜ]/u' // 
    );

    $cadenaLimpia = preg_replace($caracteresEspeciales, '', $cadena);

    return $cadenaLimpia;
}


?>
