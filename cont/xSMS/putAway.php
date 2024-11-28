<?php
    include '../../../connection.php';

    // Obtener los parámetros REQUEST
    $snNumber = $_REQUEST['snNumber'];
    $snLocation = $_REQUEST['snLocation'];

    // Inicializar array de respuesta
    $response = array();

    // Preparar la consulta SQL para seleccionar datos
    $sqlSelect = "SELECT SN, PN, Qty, UoM FROM Rcv_SNH WHERE SN = ?";

    // Preparar la consulta usando SQL Server (evita inyecciones SQL)
    if ($stmtSelect = sqlsrv_prepare($conn, $sqlSelect, array(&$snNumber))) {

        // Ejecutar la consulta SELECT
        if (sqlsrv_execute($stmtSelect)) {

            // Verificar si se obtuvieron resultados
            if ($row = sqlsrv_fetch_array($stmtSelect, SQLSRV_FETCH_ASSOC)) {

                // Almacenar los valores recuperados
                $sn = $row['SN'];
                $pn = $row['PN'];
                $qty = $row['Qty'];
                $uom = $row['UoM'];

                // Preparar la consulta de INSERT con parámetros
                $sqlInsert = "INSERT INTO xSmk_Inv (SN, PN, Qty, Location, Status, UoM, DateColumn) 
                              VALUES (?, ?, ?, ?, 'A', ?, GETDATE())";
                
                // Preparar la inserción
                $paramsInsert = array($sn, $pn, $qty, $snLocation, $uom);
                $stmtInsert = sqlsrv_prepare($conn, $sqlInsert, $paramsInsert);

                // Ejecutar la consulta de INSERT
                if (sqlsrv_execute($stmtInsert)) {
                   	$response = array('response' => 'success');  // Inserción exitosa
                } else {
                    $response = array('response' => 'error');   // Fallo en la inserción
                }

            } else {
                // Si no se encontraron resultados en la consulta SELECT
                $response = array('response' => 'fail'); 
            }
        } else {
            // Si hubo un error al ejecutar la consulta SELECT
            $response = array('response' => 'error');
        }
    } else {
        // Si hubo un error al preparar la consulta SELECT
        $response = array('response' => 'error');
    }

    // Retornar la respuesta en formato JSON
    echo json_encode($response);
?>
