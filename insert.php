<?php 
	include '../connection.php';

	// Datos para insertar en formato JSON
//$jsonData ='[
 {
  "PartNumber": "M0613202",
  "PartNumber2": "M0613202",
  "Description": "TAPE MARKER BLU LT W=25.40  T=0.030",
  "Mtype": "TAPE",
  "UoM": "M",
  "APW": "0.00194099"
 },
 {
  "PartNumber": "M0613206",
  "PartNumber2": "M0613206",
  "Description": "TAPE MARKER WHT    W=25.40  T=0.030",
  "Mtype": "TAPE",
  "UoM": "M",
  "APW": "0.00194099"
 },
 {
  "PartNumber": "M0613207",
  "PartNumber2": "M0613207",
  "Description": "TAPE MARKER ORN    W=25.40  T=0.030",
  "Mtype": "TAPE",
  "UoM": "M",
  "APW": "0.00194099"
 },
 {
  "PartNumber": "M0613248",
  "PartNumber2": "M0613248",
  "Description": "TAPE MARKER BLU DK    W=25.40  T=0.030",
  "Mtype": "TAPE",
  "UoM": "M",
  "APW": "0.00194099"
 },
 {
  "PartNumber": "M0613302",
  "PartNumber2": "M0613302",
  "Description": "TAPE MARKER BLU LT    W=12.70  T=0.030",
  "Mtype": "TAPE",
  "UoM": "M",
  "APW": "0.00194099"
 }
]';

// Decodificar el JSON a un arreglo asociativo
$data = json_decode($jsonData, true);

try {
    // Establecer la conexión a SQL Server

    // Iterar sobre los datos y realizar las inserciones
    foreach ($data as $row) {
         $np = $row['PartNumber'];
         $np2 = $row['PartNumber2'];
        $description = isset($row['Description']) ? $row['Description'] : null;
        $uom = isset($row['UOM']) ? $row['UOM'] : null;
        //$stdpack = isset($row['STDPACK']) ? $row['STDPACK'] : null;
        $mtype = isset($row['Mtype']) ? $row['Mtype'] : null;
        $apw = isset($row['APW']) ? $row['APW'] : null;

        $sql = "INSERT INTO data_inventario (PartNumber, PartNumber2, Description, UOM, Mtype, APW) VALUES (?, ?, ?, ?, ?, ?)";

     
        $params = array($np,$np2, $description, $uom, $mtype, $apw);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }

       
    }

    

    // Cerrar la conexión a SQL Server
    sqlsrv_close($conn);
    echo "Success";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}


?>