<?php 
	include '../../connection.php';
	$request = $_REQUEST['request'];
	if ($request == 'getList') {
		$sql_statement = "
			WITH NumeroSerieConRownum AS (
			    SELECT 
			        NC.PN,
			        COALESCE(RS.Serial, RSNH.Serial) AS Serial,
			        COALESCE(CASE 
			            WHEN RSNH.Located = 'Ramp' THEN 'Ramp'
			            ELSE RSNH.Located
			        END, 'NA') AS Locacion,
			        CASE 
						WHEN RS.PN IS NOT NULL AND RSNH.PN IS NULL THEN 'Sin liberar en recibos'
			            WHEN RSNH.Located = 'Ramp' THEN 'Listo para almacenar'
			            WHEN RSNH.Located <> 'Ramp' THEN
			                CASE 
			                    WHEN S.ID IS NOT NULL THEN 'Surtido'
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
			)
			SELECT 
			    PN, 
			    Locacion,
			    Estatus,
			    MAX(Fecha) AS Fecha
			FROM NumeroSerieConRownum
			WHERE RowNum = 1
			GROUP BY PN, Locacion, Estatus
			ORDER BY Fecha ASC;
		";

		$sql_query = sqlsrv_query($conn, $sql_statement);
		if ($sql_query === false) {
			$response = array('response' => 'fail');
		}
		else{
			$datos = array();

			while ($dat = sqlsrv_fetch_array($sql_query, SQLSRV_FETCH_ASSOC)) {
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
					array(	'PN'=>"<div style='background-color:$color; color:$textColor;'>".$dat['PN']."</div>",
								'Location'=>"<div style = 'background-color:$color; color:$textColor;'>".$dat['Locacion']."</div>",
								'Status'=>"<div style = 'background-color:$color; color:$textColor;'>".$dat['Estatus']."</div>",
								'FechaLlegada'=>"<div style = 'background-color:$color; color:$textColor;'>".$fecha."</div>"
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
			return '#CA23B5';
		}
		elseif ($stat == 'Sin liberar en recibos') {
			return '#F6384A';
		}
		elseif ($stat == 'Listo para almacenar') {
			return '#F59533';
		}
		elseif ($stat == 'Material en punto de uso / Sin surtir') {
			return '#FAF667';
		}
		elseif ($stat == 'Surtido') {
			return '#35E231';
		}
	}

?>