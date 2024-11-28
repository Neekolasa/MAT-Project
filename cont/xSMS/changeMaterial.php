<?php 
    include '../../../connection.php';
    
    // Obtener los parámetros REQUEST
    $snNumber = $_REQUEST['snNumber'];
    $snLocation = $_REQUEST['snLocation'];

    // Preparar la consulta SQL para obtener datos
    $sqlSelect = "SELECT SN, PN, Qty, UoM FROM xSmk_Inv WHERE SN = ?";

    // Preparar la consulta usando SQL Server (evita inyecciones SQL)
    if ($stmtSelect = sqlsrv_prepare($conn, $sqlSelect, array(&$snNumber))) {

        // Ejecutar la consulta SELECT
        if (sqlsrv_execute($stmtSelect)) {

            // Verificar si se obtuvieron resultados
            if ($row = sqlsrv_fetch_array($stmtSelect, SQLSRV_FETCH_ASSOC)) {

                // Almacenar los valores en variables
                $sn = $row['SN'];           // Número de serie
                $pn = $row['PN'];           // Número de parte
                $qty = $row['Qty'];         // Cantidad
                $uom = $row['UoM'];         // Unidad de medida

                // Preparar la consulta de INSERT con parámetros
                $sqlInsert = "INSERT INTO xSmk_BTB VALUES (?, ?, ?, ?, NULL, 'BTB', ?, NULL, NULL, NULL, GETDATE())";
                
                // Preparar la inserción
                $paramsInsert = array($sn, $pn, $uom, $qty, $snLocation);
                $stmtInsert = sqlsrv_prepare($conn, $sqlInsert, $paramsInsert);

                // Ejecutar la consulta de INSERT
                if (sqlsrv_execute($stmtInsert)) {
                    $response = array('response' => 'success');  // Inserción exitosa
                } else {
                    $response = array('response' => 'error');  // Fallo en la inserción
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
