<?php 
	include '../../connection.php';
	include 'encriptar.php';
	$userName = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	$permission = $_REQUEST['permission'];
	$fullname = $_REQUEST['fullname'];

	$password = encrypt($password,'neeko');
	$permission = encrypt($permission,'neeko');
	$fullname = encrypt($fullname,'neeko');

	$data = array($userName,$password,$fullname,$permission);
	$sql_statement = "INSERT INTO moverPersonal(userName,Password,FullName,mainPermission) VALUES (?, ?, ?, ?)";

	$sql_query=sqlsrv_query($conn,$sql_statement,$data);

	if ($sql_query === false) {
	    // Manejar el error
	    echo json_encode(array('response' => 'fail'));
	} else {
	    echo json_encode(array('response' => 'success'));
	}


?>