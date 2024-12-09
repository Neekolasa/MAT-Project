<?php
	include '../../connection.php';
	$request = $_REQUEST['request'];
	if($request == "empty"){
		 $sqlStatement = "SELECT 
	    PN, 
	    SN, 
	    RestQty, 
	    Status, 
	    UoM, 
	    RIGHT('0000' + CAST(YEAR(LastUpdate) AS VARCHAR(4)), 4) + '-' +
	    RIGHT('00' + CAST(MONTH(LastUpdate) AS VARCHAR(2)), 2) + '-' +
	    RIGHT('00' + CAST(DAY(LastUpdate) AS VARCHAR(2)), 2) + ' ' +
	    RIGHT('00' + CAST((CASE WHEN DATEPART(HOUR, LastUpdate) % 12 = 0 THEN 12 ELSE DATEPART(HOUR, LastUpdate) % 12 END) AS VARCHAR(2)), 2) + ':' +
	    RIGHT('00' + CAST(DATEPART(MINUTE, LastUpdate) AS VARCHAR(2)), 2) + ' ' +
	    (CASE WHEN DATEPART(HOUR, LastUpdate) >= 12 THEN 'PM' ELSE 'AM' END) AS LastUpdate,
	    Mtype
	FROM 
	    ChkBTS_SNMaster 
	WHERE 
	    Status LIKE '%EMPTY%' 
	    AND LastUpdate >= DATEADD(DAY, -15, GETDATE())";
	 }
	else{
		   $sqlStatement = "
		SELECT 
		    PN, 
		    SN, 
		    RestQty, 
		    Status, 
		    UoM, 
		    RIGHT('0000' + CAST(YEAR(LastUpdate) AS VARCHAR(4)), 4) + '-' +
		    RIGHT('00' + CAST(MONTH(LastUpdate) AS VARCHAR(2)), 2) + '-' +
		    RIGHT('00' + CAST(DAY(LastUpdate) AS VARCHAR(2)), 2) + ' ' +
		    RIGHT('00' + CAST((CASE WHEN DATEPART(HOUR, LastUpdate) % 12 = 0 THEN 12 ELSE DATEPART(HOUR, LastUpdate) % 12 END) AS VARCHAR(2)), 2) + ':' +
		    RIGHT('00' + CAST(DATEPART(MINUTE, LastUpdate) AS VARCHAR(2)), 2) + ' ' +
		    (CASE WHEN DATEPART(HOUR, LastUpdate) >= 12 THEN 'PM' ELSE 'AM' END) AS LastUpdate,
		    Mtype
		FROM 
		    ChkBTS_SNMaster 
		WHERE 
		    Status NOT LIKE '%EMPTY%'
		"; 
	
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