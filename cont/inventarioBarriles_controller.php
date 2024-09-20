<?php
	include '../../connection.php';
	$request = $_REQUEST['request'];
	if($request == "empty"){
		 $sqlStatement = "SELECT PN, SN, RestQty, Status, UoM, LastUpdate, Mtype 
                     FROM ChkBTS_SNMaster 
                     WHERE Status LIKE '%EMPTY%' 
                     AND LastUpdate >= DATEADD(DAY, -15, GETDATE())";
	 }
	else{
		   $sqlStatement = "SELECT PN, SN, RestQty, Status, UoM, LastUpdate, Mtype FROM ChkBTS_SNMaster WHERE Status NOT LIKE '%EMPTY%'"; 
	
	}
	$sqlQuery = sqlsrv_query($conn, $sqlStatement);

	    $info = array();
	    while ($data = sqlsrv_fetch_array($sqlQuery, SQLSRV_FETCH_ASSOC)) {
	        $lastUpdate = $data['LastUpdate'];
	        if ($lastUpdate instanceof DateTime) {
	            $lastUpdate = $lastUpdate->format('Y-m-d'); 
	        }

	        array_push($info, array(
	            "PN" => $data['PN'],
	            "SN" => $data['SN'],
	            "RestQty" => $data['RestQty'],
	            "Status" => $data['Status'],
	            "UoM" => $data['UoM'],
	            "LastUpdate" => $lastUpdate,
	            "Mtype" => $data['Mtype']
	        ));
	    }

	    echo json_encode(array($info,"response"=>"success"));
?>