<?php 

  	$serverName = "10.215.156.203\IFV55";
	$connectionInfo = array( 	"Database"=>"SMS",
								"UID"=>"sa", 
								"PWD"=>"System@dm1n"
							);
	$conn = sqlsrv_connect( $serverName, $connectionInfo);
	if( $conn === false ) {
	     die( print_r( sqlsrv_errors(), true));
	}

?>