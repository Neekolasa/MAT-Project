<?php 
	include '../../connection.php';
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


 ?>