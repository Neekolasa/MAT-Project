<?php
	include '../../connection.php';
	$request = $_REQUEST['request'];
	if ($request == "getInfo") {
		$sqlStatement = "
		SELECT 
		    xSmk_PickWIP.Id, 
		    Rcv_SNH.PN, 
		    Rcv_SNH.SN, 
		    xSmk_PickWIP.UoM, 
		    xSmk_PickWIP.Qty, 
		    xSmk_PickWIP.SAPDate as UltimoIntento, 
		    xSmk_PickWIP.Movement, 
		    xSmk_PickWIP.SapComment, 
		    xSmk_PickWIP.CreatedOn as FechaMovimiento, 
		    Sy_Users.Name + ' ' + Sy_Users.LastName as CreatedBy
		FROM 
		    xSmk_PickWIP 
		JOIN 
		    Rcv_SNH ON 
		    Rcv_SNH.SN = 
		    CASE 
		        WHEN LEFT(xSmk_PickWIP.SN, 1) = 'S' 
		        THEN SUBSTRING(xSmk_PickWIP.SN, 2, LEN(xSmk_PickWIP.SN))
		        ELSE xSmk_PickWIP.SN
		    END
		JOIN 
		    Sy_Users ON xSmk_PickWIP.CreatedBy = Sy_Users.Badge
		WHERE 
		    SAPStatus = 'FAIL' 
		    AND (SapComment NOT LIKE '%Deleted%' AND SapComment NOT LIKE '%CreatedTran%' AND SapComment NOT LIKE '%Found%') 
		ORDER BY 
		    SAPDate DESC;
		";
		$sqlQuery = sqlsrv_query($conn, $sqlStatement);

	    $info = array();
	    while ($data = sqlsrv_fetch_array($sqlQuery, SQLSRV_FETCH_ASSOC)) {
	        $lastUpdate = $data['UltimoIntento'];
	        if ($lastUpdate instanceof DateTime) {
	            $lastUpdate = $lastUpdate->format('Y-m-d H:i'); 
	        }
	        $movementDate = $data['FechaMovimiento'];
	        if ($movementDate instanceof DateTime) {
	            $movementDate = $movementDate->format('Y-m-d H:i'); 
	        }

	        array_push($info, array(
	            "PN" => $data['PN'],
	            "SN" => $data['SN'],
	            "UoM" => $data['UoM'],
	            "Qty" => $data['Qty'],
	            "UltimoIntento" => $lastUpdate,
	            "Movement" => $data['Movement'],
	            "SapComment" => $data['SapComment'],
	            "FechaMovimiento" => $movementDate,
	            "CreatedBy" => $data['CreatedBy'],
	            "Action" => "<button class='btn btn-danger' onclick='removeManual(\"" . $data['Id'] . "\")'><i class='fa fa-trash'></i> Omitir</button>"
	        ));
	    }

	    echo json_encode(array($info,"response"=>"success"));
	}
	elseif ($request == "delTransaction") {
		$idTransaction = $_REQUEST['idTransaction'];
		$sqlStatement = "DELETE FROM xSmk_PickWIP WHERE Id = '$idTransaction' ";
		$sqlQuery = sqlsrv_query($conn, $sqlStatement);

		if ($sqlQuery) {
		    echo json_encode(array("response" => "success"));
		} else {
		    $error = sqlsrv_errors();
		    echo json_encode(array("response" => "fail", "message" => $error[0]['message']));
		}

	}
	else{

	}
		
?>