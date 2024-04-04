<?php
	session_start();
	include '../../connection.php';

	if ($_GET['request'] == 'getBadge') {
		if (isset($_SESSION['badge'])) {
			echo ($_SESSION['badge']);
		} else {
			echo "error";
		}
	} elseif ($_GET['request'] == 'setBadge') {
		if (isset($_GET['badge'])) {
			$badge = $_GET['badge'];

			$sql_statement = "SELECT COUNT(*) AS count FROM Sy_Users WHERE Badge = '$badge'";
			$sql_query = sqlsrv_query($conn, $sql_statement);

			if ($sql_query !== false) {
			    $row = sqlsrv_fetch_array($sql_query);
			    $row_count = $row['count'];
			    
			    if ($row_count > 0) {
			    	$_SESSION['badge'] = $badge;
			        echo json_encode(array('response' => 'success'));
			    } else {
			        echo json_encode(array('response' => 'fail'));
			    }
			} else {
			    echo json_encode(array('response' => 'fail'));
			}


			
			
		} else {
			echo "error";
		}
	}
	 elseif ($_GET['request']=='delBadge'){
	 	session_unset(); 
	 	session_destroy();
	 	echo json_encode(array('response' => 'success'));
	 }
	 else {
		echo "Invalid request";
	}

	
?>