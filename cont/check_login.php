<?php 
	include '../../connection.php';
	include 'encriptar.php';
	$username = $_GET['username'];
	$password = $_GET['password'];
	$enc_password = encrypt($password,'APTIV');

	$sql_statement = "SELECT COUNT(*) AS count FROM rutas_admin WHERE username = '$username' AND password='$enc_password'";
	$sql_query = sqlsrv_query($conn, $sql_statement);

	if ($sql_query !== false) {
	    $row = sqlsrv_fetch_array($sql_query);
	    $row_count = $row['count'];
	    
	    if ($row_count > 0) {
	        echo json_encode(array('response' => 'success'));
	    } else {
	        echo json_encode(array('response' => 'fail'));
	    }
	} else {
	    echo json_encode(array('response' => 'fail'));
	}
	//echo json_encode($row_count);

?>