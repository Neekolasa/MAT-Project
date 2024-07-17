<?php 
	include '../../connection.php';
	$request = $_REQUEST['request'];
	if ($request == 'getValues') {
		$sql_statement = "WITH CombinedData AS (
		    SELECT 
		        COALESCE(MSpec_A, '-') AS PN,
		        (COALESCE(Length_A, 0) * Quantity) * 0.001 AS LenM,
		        Quantity,
		        COALESCE(Terminal_A, '-') AS Terminal_PN,
		        COALESCE(Seal_A, '-') AS Seal_PN
		    FROM LP_CAO_Tickets Tk
		    LEFT JOIN PE_Leadcodes L ON (Tk.Leadcode = L.Leadcode)
		    WHERE [Status] = '30'
		    
		    UNION ALL
		    
		    SELECT 
		        COALESCE(MSpec_B, '-') AS PN,
		        (COALESCE(Length_B, 0) * Quantity) * 0.001 AS LenM,
		        Quantity,
		        COALESCE(Terminal_B, '-') AS Terminal_PN,
		        COALESCE(Seal_B, '-') AS Seal_PN
		    FROM LP_CAO_Tickets Tk
		    LEFT JOIN PE_Leadcodes L ON (Tk.Leadcode = L.Leadcode)
		    WHERE [Status] = '30'
		    
		    UNION ALL
		    
		    SELECT 
		        COALESCE(NULL, '-') AS PN,
		        0 AS LenM,
		        Quantity,
		        COALESCE(Terminal_C, '-') AS Terminal_PN,
		        COALESCE(Seal_C, '-') AS Seal_PN
		    FROM LP_CAO_Tickets Tk
		    LEFT JOIN PE_Leadcodes L ON (Tk.Leadcode = L.Leadcode)
		    WHERE [Status] = '30'
		    
		    UNION ALL
		    
		    SELECT 
		        COALESCE(NULL, '-') AS PN,
		        0 AS LenM,
		        Quantity,
		        COALESCE(Terminal_D, '-') AS Terminal_PN,
		        COALESCE(Seal_D, '-') AS Seal_PN
		    FROM LP_CAO_Tickets Tk
		    LEFT JOIN PE_Leadcodes L ON (Tk.Leadcode = L.Leadcode)
		    WHERE [Status] = '30'
		)

		-- LengthM Calculation
		SELECT PN, SUM(LenM) AS LengthM
		FROM CombinedData
		GROUP BY PN

		UNION ALL

		-- Total Terminal Calculation
		SELECT Terminal_PN AS PN, SUM(Quantity) AS Quantity
		FROM CombinedData
		GROUP BY Terminal_PN

		UNION ALL

		-- Total Seal Calculation
		SELECT Seal_PN AS PN, SUM(Quantity) AS Quantity
		FROM CombinedData
		GROUP BY Seal_PN;
		";

		$sql_query = sqlsrv_query($conn,$sql_statement);
		$datos = array();
		while ($data = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
			array_push($datos, array(
				"PN" => $data["PN"],
				"Qty"=> $data["LengthM"]

			));


		}

		echo json_encode($datos);
	}

 ?>