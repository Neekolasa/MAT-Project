<?php 
	include '../../connection.php';
	$request = $_REQUEST['request'];
	if ($request == 'getList') {
		$sql_statement = "
			WITH NumeroSerieConRownum AS (
			    SELECT 
			        NC.PN,
			        COALESCE(RS.Serial, RSNH.Serial) AS Serial,
					Map.R + Map.S + Map.L + Map.P AS Locacion,
			        --COALESCE(CASE 
			            --WHEN RSNH.Located = 'Ramp' THEN 'Ramp'
			            --ELSE RSNH.Located
			        --END, 'NA') AS Locacion,
					NC.DOH as DOH,
					NC.ETA as ETA,
					M.Mtype as Mtype,
			        CASE 
						WHEN RS.PN IS NOT NULL AND RSNH.PN IS NULL THEN 'Sin liberar en recibos'
			            WHEN RSNH.Located = 'Ramp' THEN 'Listo para almacenar'
			            WHEN RSNH.Located <> 'Ramp' THEN
			                CASE 
			                    WHEN S.ID IS NOT NULL THEN 'Surtido '+RIGHT(CONVERT(varchar, S.ActionDate, 100), 7)
			                    ELSE 'Material en punto de uso / Sin surtir'
			                END
			            ELSE 'Sin llegada a planta'
			        END AS Estatus,
			       	ISNULL(CONVERT(varchar, RSNH.ScanDate, 1) + ' ' + RIGHT(CONVERT(varchar, RSNH.ScanDate, 100), 7), CONVERT(varchar, Rs.ScanDate, 1) + ' ' + RIGHT(CONVERT(varchar, Rs.ScanDate, 100), 7)) AS Fecha,
			        ROW_NUMBER() OVER (PARTITION BY NC.PN ORDER BY CASE WHEN 
			            CASE 
			                WHEN RSNH.Located = 'Ramp' THEN 'Listo para almacenar'
			                WHEN RSNH.Located <> 'Ramp' THEN
			                    CASE 
			                        WHEN S.ID IS NOT NULL THEN 'Surtido'
			                        ELSE 'Material en punto de uso / Sin surtir'
			                    END
			                ELSE 'Sin llegada a planta'
			            END = 'Surtido' THEN 0 ELSE 1 END, ISNULL(CONVERT(varchar, RSNH.ScanDate, 1) + ' ' + RIGHT(CONVERT(varchar, RSNH.ScanDate, 100), 7), 'NA') DESC) AS RowNum
			    FROM numerosCriticos NC
			    LEFT JOIN Rcv_SNH RSNH ON NC.PN = RSNH.PN AND CONVERT(DATE, RSNH.ScanDate) = CONVERT(DATE, GETDATE())
			    LEFT JOIN Rcv_Scan RS ON NC.PN = RS.PN AND CONVERT(DATE, RS.ScanDate) = CONVERT(DATE, GETDATE())
			    LEFT JOIN Smk_InvDet S ON S.SN = CONVERT(varchar, RSNH.SN) AND S.Action IN ('PARTIAL', 'EMPTY', 'OPEN')
				LEFT JOIN PFEP_MasterV2 M ON NC.PN = M.PN
				LEFT JOIN PFEP_Map Map ON NC.PN = Map.PN
			)
			SELECT 
			    PN,
				DOH,
				ETA,
				Mtype,
			    Locacion,
			    Estatus,
			    MAX(Fecha) AS Fecha
			FROM NumeroSerieConRownum
			WHERE RowNum = 1 AND DOH<'1.0'
			GROUP BY PN, DOH,ETA,Mtype,Locacion, Estatus
			ORDER BY Fecha ASC;
		";

		/*$sql_statement="
			WITH NumeroSerieConRownum AS (
		    SELECT 
		        NC.PN,
		        COALESCE(RS.Serial, RSNH.Serial) AS Serial,
		        Map.R + Map.S + Map.L + Map.P AS Locacion,
		        NC.DOH AS DOH,
		        NC.ETA AS ETA,
		        M.Mtype AS Mtype,
		        CASE 
		            WHEN RS.PN IS NOT NULL AND RSNH.PN IS NULL THEN 'Sin liberar en recibos'
		            WHEN RSNH.Located = 'Ramp' THEN 'Listo para almacenar'
		            WHEN RSNH.Located <> 'Ramp' THEN
		                CASE 
		                    WHEN S.ID IS NOT NULL THEN 'Surtido '+RIGHT(CONVERT(varchar, S.ActionDate, 100), 7)
		                    ELSE 'Material en punto de uso / Sin surtir'
		                END
		            ELSE 'Sin llegada a planta'
		        END AS Estatus,
		        ISNULL(CONVERT(varchar, RSNH.ScanDate, 1) + ' ' + RIGHT(CONVERT(varchar, RSNH.ScanDate, 100), 7), CONVERT(varchar, Rs.ScanDate, 1) + ' ' + RIGHT(CONVERT(varchar, Rs.ScanDate, 100), 7)) AS Fecha,
		        ROW_NUMBER() OVER (PARTITION BY NC.PN ORDER BY CASE 
		            WHEN CASE 
		                WHEN RSNH.Located = 'Ramp' THEN 'Listo para almacenar'
		                WHEN RSNH.Located <> 'Ramp' THEN
		                    CASE 
		                        WHEN S.ID IS NOT NULL THEN 'Surtido'
		                        ELSE 'Material en punto de uso / Sin surtir'
		                    END
		                ELSE 'Sin llegada a planta'
		            END = 'Surtido' THEN 0 ELSE 1 END, ISNULL(CONVERT(varchar, RSNH.ScanDate, 1) + ' ' + RIGHT(CONVERT(varchar, RSNH.ScanDate, 100), 7), 'NA') DESC) AS RowNum
		    FROM numerosCriticos NC
		    LEFT JOIN Rcv_SNH RSNH ON NC.PN = RSNH.PN AND CONVERT(DATE, RSNH.ScanDate) >= CONVERT(DATE, DATEADD(DAY, -1, GETDATE())) AND CONVERT(DATE, RSNH.ScanDate) <= CONVERT(DATE, GETDATE())
		    LEFT JOIN Rcv_Scan RS ON NC.PN = RS.PN AND CONVERT(DATE, RS.ScanDate) >= CONVERT(DATE, DATEADD(DAY, -1, GETDATE())) AND CONVERT(DATE, RS.ScanDate) <= CONVERT(DATE, GETDATE())
		    LEFT JOIN Smk_InvDet S ON S.SN = CONVERT(varchar, RSNH.SN) AND S.Action IN ('PARTIAL', 'EMPTY', 'OPEN')
		    LEFT JOIN PFEP_MasterV2 M ON NC.PN = M.PN
		    LEFT JOIN PFEP_Map Map ON NC.PN = Map.PN
		)
		SELECT 
		    PN,
		    DOH,
		    ETA,
		    Mtype,
		    Locacion,
		    Estatus,
		    MAX(Fecha) AS Fecha
		FROM NumeroSerieConRownum
		WHERE RowNum = 1 AND DOH < '1.0'
		GROUP BY PN, DOH, ETA, Mtype, Locacion, Estatus
		ORDER BY Fecha ASC;


		";*/

		$sql_query = sqlsrv_query($conn, $sql_statement);
		if ($sql_query === false) {
			$response = array('response' => 'fail');
		}
		else{
			$datos = array();

			while ($dat = sqlsrv_fetch_array($sql_query, SQLSRV_FETCH_ASSOC)) {

				/*$sqlCheckReserved = "SELECT COUNT(DISTINCT Smk_InvDet.SN) AS Total FROM Smk_InvDet JOIN Smk_Inv ON Smk_InvDet.PN = Smk_Inv.PN WHERE Smk_Inv.PN = ? AND Smk_InvDet.ActionDate >= CONVERT(Date, GETDATE()) AND Smk_InvDet.Action='PUT AWAY';";
			    $params = array($dat['PN']);
			    $stmt = sqlsrv_query($conn, $sqlCheckReserved, $params);

			    if ($stmt !== false) {
			        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
			        if ($row['Total'] > 0) {
			            $estatus = 'Material en punto de uso / Sin surtir';
			        } else {
			            $estatus = $dat['Estatus'];
			        }
			    } else {
			       
			    }*/
			    if ($dat['Estatus']=='Listo para almacenar') {
			    	$sqlCheckReserved = "SELECT COUNT(DISTINCT Smk_InvDet.SN) AS Total FROM Smk_InvDet JOIN Smk_Inv ON Smk_InvDet.PN = Smk_Inv.PN WHERE Smk_Inv.PN = ? AND Smk_InvDet.ActionDate >= CONVERT(Date, GETDATE()) AND Smk_InvDet.Action='PUT AWAY';";
				    $params = array($dat['PN']);
				    $stmt = sqlsrv_query($conn, $sqlCheckReserved, $params);

				    if ($stmt !== false) {
				        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
				        if ($row['Total'] > 0) {
				            $dat['Estatus'] = 'Material en punto de uso / Sin surtir';
				        } else {
				            $dat['Estatus'] = $dat['Estatus'];
				        }
				    } else {
				       
				    }
			    }
			    else{
			    	$estatus = $dat['Estatus'];
			    }

				$color = getColors($dat['Estatus']);
				if ($dat['Estatus']=='Sin llegada a planta' || $dat['Estatus'] == 'Sin liberar en recibos' || $dat['Estatus'] == 'Listo para almacenar') {
					$textColor = '#FFFFFF';
				}
				else{
					$textColor = '#000000';
				}
				if (is_null($dat['Fecha'])) {
					$fecha = 'NA';
				}
				else{
					$fecha = $dat['Fecha'];
				}
				array_push($datos, 
					array(	'PN'=>$dat['PN'],
								'Location'=>$dat['Locacion'],
								'Status'=>$color.$dat['Estatus'],
								'FechaLlegada'=>$fecha,
								'DOH'=>$dat['DOH'],
								'ETA'=>$dat['ETA'],
								'Mtype'=>$dat['Mtype']
					));
			}
			if (empty($datos)) {
                $response = array('response' => 'fail');
            } else {
                $response = array('response' => 'success', 'data' => $datos);
            }
		}
		echo json_encode($response);
	}

	function getColors($status){
		$stat = $status;
		if ($stat == 'Sin llegada a planta') {
			return "<span style='opacity:0'>5. </span>";
		}
		elseif ($stat == 'Sin liberar en recibos') {
			return "<span style='opacity:0'>3. </span>";
		}
		elseif ($stat == 'Listo para almacenar') {
			return "<span style='opacity:0'>2. </span>";
		}
		elseif ($stat == 'Material en punto de uso / Sin surtir') {
			return "<span style='opacity:0'>1. </span>";
		}
		elseif ($stat == 'Surtido') {
			return "<span style='opacity:0'>4. </span>";
		}
		else{
			return "<span style='opacity:0'>4. </span>";
		}
	}

?>