<?php 
	include '../../connection.php';
	$request = $_REQUEST['request'];
	if ($request=="getData") {
		$snNumber = $_REQUEST['snNumber'];
		$sqlStatement = "SELECT SN,PN,Qty,UoM FROM Rcv_SNH WHERE SN = '$snNumber'";

		$sql_query = sqlsrv_query($conn,$sqlStatement);
			$datos = array();
			while ($info = sqlsrv_fetch_array($sql_query, SQLSRV_FETCH_ASSOC)) {
				array_push($datos, array(
					"SN"=>$info["SN"],
					"PN"=>$info["PN"],
					"Qty"=>$info["Qty"],
					"UoM"=>$info["UoM"]

				));
			}
		if (count($datos) > 0) {
	    	$response = array('response' => 'success', 'data' => $datos);
		} else {
		    $response = array('response' => 'fail', 'message' => 'No data found');
		}
		echo json_encode($response);
		
	}
	elseif ($request=="autenticator") {
		$password = $_REQUEST['password'];
		$sqlStatement = "SELECT * FROM Sy_Users WHERE Password = '$password' AND Area LIKE '%Admin%'";
		$sql_query = sqlsrv_query($conn,$sqlStatement);
		if (sqlsrv_has_rows($sql_query)) {
		    echo json_encode(array("response" => "success"));
		} else {
		    echo json_encode(array("response" => "fail"));
		}
	}
	else
	{
		$snNumber = $_REQUEST['snNumber'];
		$pnNumber = $_REQUEST['pnNumber'];
		$qtyNumber = $_REQUEST['qtyNumber'];
		$uomNumber = $_REQUEST['uomNumber'];

		$sqlStatement = "INSERT INTO Smk_Inv VALUES ('$snNumber','$pnNumber','$qtyNumber','08080808','A','$uomNumber','A',GETDATE())";

		$sql_query = sqlsrv_query($conn, $sqlStatement);

		if ($sql_query == true) {
		    echo json_encode(['response' => 'success']);
		} else {
		    // Obtener el detalle del error
		    $errors = sqlsrv_errors();
		    $errorMessage = "Error: ";
		    
		    // Concatenar detalles del error
		    foreach ($errors as $error) {
		        $errorMessage .= "SQLSTATE: " . $error['SQLSTATE'] . "; Code: " . $error['code'] . "; Message: " . $error['message'] . " ";
		    }

		    echo json_encode(['response' => 'fail', 'error' => $errorMessage]);
		}
	}
	


 ?>