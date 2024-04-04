<?php
include '../../connection.php';

$request = $_REQUEST['request'];

if ($request == 'processData') {
    $results = json_decode($_REQUEST['results'], true);
  
    $datos = array();
    foreach ($results as $row) {
        $np = $row['NP'];

        $dailyRequirement = $row['Requerimiento_Diario'];
        $coverHours = $row['Horas_por_cubrir'];
        $hourlyRequirement = round(($dailyRequirement / 9), 2); //PARA TURNO A, MODIFICAR PARA PERMITIR LAS 8 HRS DE TURNO B
        $constantRequirement = round(($hourlyRequirement * $coverHours));

        //$sqlStatement = "SELECT PN, ContType, Qty, UoM FROM DRC_ContQty WHERE PN = '$np'";
        $sqlStatement = "SELECT PN, ContType, Qty, UoM FROM DRC_ContQty WHERE PN = '$np' ORDER BY ABS(Qty - '$constantRequirement')";
        //echo "$sqlStatement\n";
        $sql_query = sqlsrv_query($conn, $sqlStatement);

        if ($sql_query !== false) {
            $contTypes = array(); // Array para almacenar los ContType y sus Qty

            while ($data = sqlsrv_fetch_array($sql_query, SQLSRV_FETCH_ASSOC)) {
                // Almacenar los ContType y sus Qty en un array asociativo
                $contTypes[$data['ContType']] = $data['Qty'];
            }

            // Encontrar el ContType mas optimo
            $bestContType = null;
            $bestQty = null;
            foreach ($contTypes as $contType => $qty) {
                // Verificar si la cantidad es suficiente para el requerimiento constante
                if ($qty >= $constantRequirement) {
                    // Si el ContType es mas optimo que el anterior (o si no se ha establecido ninguno todavia)
                    if ($bestContType === null || $qty < $bestQty) {
                        $bestContType = $contType;
                        $bestQty = $qty;
                    }
                }
            }

            // No se encontró ningún ContType adecuado
if (count($contTypes) > 0) {
    // Si hay algún ContType disponible
    if (count($contTypes) == 1) {
        // Si solo hay un ContType disponible
        $contTypeKeys = array_keys($contTypes);
        $selectedContType = reset($contTypeKeys);
        array_push($datos, array(
            "PN" => "$np",
            "ContType" => "Unico disponible " . $selectedContType,
            "Qty" => "$contTypes[$selectedContType]",
            "Requerimiento_Diario" => "$dailyRequirement",
            "Horas_por_cubrir" => "$coverHours",
            "Requerimiento_por_hora" => "$hourlyRequirement",
            "Requerimiento_Constante" => "$constantRequirement"
        ));
    } else {
        // Si hay más de un ContType disponible
        // Procede como antes
        $contTypeKeys = array_keys($contTypes);
        $selectedContType = reset($contTypeKeys);
        array_push($datos, array(
            "PN" => "$np",
            "ContType" => "$selectedContType",
            "Qty" => "$contTypes[$selectedContType]",
            "Requerimiento_Diario" => "$dailyRequirement",
            "Horas_por_cubrir" => "$coverHours",
            "Requerimiento_por_hora" => "$hourlyRequirement",
            "Requerimiento_Constante" => "$constantRequirement"
        ));
    }
} else {
    // Si no hay ningún ContType disponible, establecer ContType como "Sin datos"
    array_push($datos, array(
        "PN" => "$np",
        "ContType" => "Sin datos",
        "Qty" => "0",
        "Requerimiento_Diario" => "$dailyRequirement",
        "Horas_por_cubrir" => "$coverHours",
        "Requerimiento_por_hora" => "$hourlyRequirement",
        "Requerimiento_Constante" => "$constantRequirement"
    ));
}

        } else {
            // Error al ejecutar la consulta SQL
            echo "Error en la consulta SQL: " . sqlsrv_errors();
        }
    }

    echo json_encode($datos);
} else {
    echo json_encode(["error" => "Solicitud no válida"]);
}
?>
