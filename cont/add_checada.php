<?php goto Aq2wK; EZKl9: $num_empleado = $_GET["\156\x75\x6d\137\145\x6d\160\x6c\145\141\x64\x6f"]; goto aLgfw; A5YJY: function getStatus($hora, $salida) { if ($hora >= restarMinutos($salida) && $hora <= sumarMinutos($salida)) { return "\117\x4b"; } else { return "\102\101\x44"; } } goto f7xH0; bvJbf: include "\145\156\143\x72\151\x70\164\141\x72\x2e\x70\x68\160"; goto P8lyB; f7xH0: function restarMinutos($tiempo) { list($horas, $minutos) = explode("\x3a", $tiempo); $totalMinutos = $horas * 60 + $minutos - 5; if ($totalMinutos < 0) { $totalMinutos += 1440; } $nuevasHoras = floor($totalMinutos / 60); $nuevosMinutos = $totalMinutos % 60; return sprintf("\45\60\x32\x64\72\45\60\62\x64", $nuevasHoras, $nuevosMinutos); } goto YUkBe; Aq2wK: include "\x2e\x2e\x2f\56\56\57\x63\157\156\156\145\143\x74\x69\157\x6e\56\x70\x68\160"; goto bvJbf; YUkBe: function sumarMinutos($salida) { list($horas, $minutos) = explode("\72", $salida); $totalMinutos = $horas * 60 + $minutos + 5; $nuevasHoras = floor($totalMinutos / 60); $nuevosMinutos = $totalMinutos % 60; return sprintf("\x25\60\62\x64\72\45\60\x32\x64", $nuevasHoras, $nuevosMinutos); } goto ywoAK; P8lyB: $array_excludes = array("\70\60\61\x32\x34\62\63\70"); goto EZKl9; aLgfw: if ($_GET["\162\x65\161\165\x65\x73\x74"] == "\162\145\147\151\x73\164\x65\162") { $nombre_empleado = $_GET["\x6e\x6f\x6d\142\x72\x65\137\145\x6d\160\x6c\145\141\x64\157"]; $salida_almuerzo = $_GET["\x73\141\x6c\x69\x64\141\x5f\x61\x6c\x6d\x75\145\162\172\x6f"]; $salida_comida = $_GET["\x73\141\x6c\151\144\x61\x5f\143\x6f\x6d\x69\144\x61"]; $area_emp = $_GET["\141\162\145\x61\137\145\x6d\160"]; $turno_checada = $_GET["\164\165\162\x6e\157\137\143\x68\x65\143\141\144\x61"]; $sql_statement = "\x49\x4e\123\x45\122\x54\40\111\x4e\124\x4f\40\x53\x61\x6c\151\144\141\163\120\145\162\163\x6f\156\x61\x6c\40\xa\x9\11\x9\x9\11\x9\11\x56\x41\114\125\105\x53\x28\x27{$num_empleado}\47\x2c\47{$nombre_empleado}\47\x2c\x27{$area_emp}\47\54{$salida_almuerzo}\54{$salida_comida}\x2c\47{$turno_checada}\x27\51"; $sql_query = sqlsrv_query($conn, $sql_statement); if ($sql_query == true) { echo json_encode(array("\x72\145\x73\160\x6f\156\x73\x65" => "\163\x75\143\143\145\163\163")); } else { echo json_encode(array("\162\145\163\160\157\x6e\163\145" => "\x66\141\151\x6c")); } } else { if ($_GET["\162\145\x71\165\x65\163\164"] == "\144\x65\x6c\145\x74\145") { $sql_statement = "\x44\x45\x4c\x45\124\105\x20\106\x52\x4f\115\x20\123\141\x6c\151\144\141\x73\x50\145\162\x73\x6f\x6e\x61\x6c\12\11\x9\x9\11\x9\x9\40\x20\127\x48\105\x52\105\x20\102\x61\x64\x67\x65\40\75\x20\47{$num_empleado}\x27"; $sql_query = sqlsrv_query($conn, $sql_statement); if ($sql_query == true) { echo json_encode(array("\162\x65\163\160\157\156\x73\145" => "\163\165\143\x63\145\x73\163")); } else { echo json_encode(array("\x72\x65\x73\160\x6f\x6e\x73\145" => "\146\141\151\x6c")); } } else { if ($_GET["\x72\145\161\165\145\163\x74"] == "\x75\x70\x64\141\x74\x65") { $nombre_empleado = $_GET["\x6e\157\155\142\x72\x65\x5f\x65\x6d\x70\x6c\145\141\144\157"]; $salida_almuerzo = $_GET["\x73\141\x6c\x69\144\141\x5f\x61\x6c\x6d\165\x65\x72\172\x6f"]; $salida_comida = $_GET["\163\x61\x6c\151\144\141\137\x63\x6f\x6d\x69\x64\141"]; $area_emp = $_GET["\141\x72\x65\141\137\x65\x6d\x70"]; $turno_checada = $_GET["\164\165\x72\156\157\137\x63\150\145\x63\x61\144\x61"]; $sql_statement = "\12\11\x9\x55\120\x44\x41\x54\105\x20\123\x61\x6c\151\x64\x61\x73\120\145\162\x73\157\156\x61\x6c\12\11\x9\40\x20\40\x53\x45\124\x20\11\x4e\x6f\155\142\162\145\x20\x9\11\75\x20\47{$nombre_empleado}\x27\x2c\12\x9\x9\x20\x20\40\x20\40\x20\x9\101\162\x65\x61\x20\x20\40\x9\x9\x3d\x20\x27{$area_emp}\x27\x2c\12\x9\11\x20\40\x20\x20\x20\40\x9\x44\x65\x73\x61\171\x75\x6e\x6f\40\x9\75\x20{$salida_almuerzo}\54\12\11\11\40\40\x20\x20\x20\40\11\x43\157\x6d\x69\144\141\40\x9\11\x3d\40{$salida_comida}\54\12\11\x9\40\x20\40\x20\x20\40\11\164\x75\x72\x6e\x6f\40\x9\x9\x3d\x20\x27{$turno_checada}\x27\xa\x9\x9\40\x57\110\105\x52\x45\40\x42\x61\144\147\x65\40\x3d\40\47{$num_empleado}\47"; $sql_query = sqlsrv_query($conn, $sql_statement); if ($sql_query == true) { echo json_encode(array("\162\145\163\160\x6f\156\163\x65" => "\x73\x75\x63\143\145\x73\163")); } else { echo json_encode(array("\162\145\x73\160\x6f\x6e\163\x65" => "\146\141\151\x6c")); } } else { if ($_GET["\162\145\x71\x75\x65\163\x74"] == "\x72\145\x67\137\141\144\x6d\151\x6e") { $username = $_GET["\165\x73\145\162\156\141\155\x65"]; $password = $_GET["\x70\x61\x73\x73\x77\157\162\x64"]; $enc_password = encrypt($password, "\x41\120\124\x49\126"); $sql_statement = "\111\116\x53\105\x52\124\40\x49\x4e\x54\117\40\162\x75\164\x61\163\x5f\141\x64\x6d\x69\x6e\40\x56\101\114\125\x45\x53\x20\50\x27{$username}\47\x2c\x27{$enc_password}\47\51"; $sql_query = sqlsrv_query($conn, $sql_statement); if ($sql_query == true) { echo json_encode(array("\162\145\x73\x70\x6f\x6e\163\145" => "\x73\x75\143\143\x65\x73\x73")); } else { echo json_encode(array("\162\x65\x73\160\157\156\x73\x65" => "\146\141\151\x6c")); } } elseif ($_GET["\162\x65\161\165\x65\x73\x74"] == "\x72\145\x67\137\143\x68\x65\x63\x61\x64\141") { date_default_timezone_set("\101\155\x65\x72\x69\143\x61\57\x4d\157\x6e\164\145\162\x72\145\171"); $dataCheck = array("\x73\143\x61\156\104\141\164\145" => date("\131\x2d\155\55\x64"), "\163\143\141\156\110\x6f\x75\x72" => date("\x48\x3a\x69\x3a\163"), "\146\x6b\137\x62\141\x64\147\x65" => strtoupper($_GET["\156\165\155\137\x65\155\160\x6c\x65\141\x64\x6f"])); $unaHoraMenos = strtotime("\55\x31\40\x68\157\x75\162"); $sql_CheckStatement = "\xa\11\11\11\11\11\x9\11\11\123\x45\x4c\x45\103\124\40\103\117\x55\x4e\x54\x28\52\x29\x20\x61\x73\x20\143\157\x75\156\164\xa\x9\11\11\x9\11\x9\11\x9\x46\122\117\x4d\x20\122\x65\x67\151\163\164\x72\157\x53\x61\x6c\151\x64\x61\x73\xa\x9\x9\x9\x9\11\11\11\x9\127\110\105\x52\x45\x20\123\x63\141\x6e\x44\x61\x74\x65\x20\x3d\x20\x27{$dataCheck["\x73\x63\141\x6e\x44\141\x74\x65"]}\47\12\x9\11\11\11\11\x9\11\11\x2d\x2d\101\116\x44\40\123\143\x61\x6e\110\157\x75\x72\x20\76\40\x27\x30\x30\x3a\60\x30\47\xa\11\11\11\11\11\x9\x9\x9\x41\116\104\40\x66\153\x5f\142\x61\x64\147\x65\40\75\x20\47{$dataCheck["\146\153\137\142\141\144\x67\x65"]}\x27"; $sql_CheckQuery = sqlsrv_query($conn, $sql_CheckStatement); if ($sql_CheckQuery !== false) { $row = sqlsrv_fetch_array($sql_CheckQuery); $row_count = $row["\143\157\x75\156\x74"]; if ($row_count > 0) { $sql_CheckNull = "\xa\11\x9\x9\x9\40\x20\x20\x20\123\x45\x4c\x45\103\x54\40\124\117\120\x20\61\x20\122\x53\x2e\x49\104\x2c\x20\x52\123\56\123\x41\54\40\122\123\x2e\105\101\x2c\x20\122\123\56\123\103\54\x20\122\x53\56\105\x43\x2c\40\110\x44\145\163\x61\x79\x75\156\x6f\x2e\x54\x69\x65\x6d\160\157\x53\x61\x6c\x69\144\141\x20\x41\x53\x20\124\x69\x65\155\x70\x6f\123\x61\x6c\151\144\141\x53\141\54\40\110\x44\x65\163\141\x79\x75\156\x6f\56\x54\151\x65\155\x70\x6f\x45\156\164\x72\141\144\x61\x20\x41\x53\40\124\151\x65\155\160\157\x53\x61\x6c\151\x64\141\105\141\x2c\x20\110\103\157\155\x69\144\141\x2e\x54\151\x65\x6d\x70\157\123\141\154\151\144\141\x20\x41\123\40\124\x69\x65\155\160\x6f\x53\141\154\151\x64\x61\123\x63\54\40\x48\103\x6f\155\x69\144\141\56\124\151\x65\x6d\160\x6f\105\156\x74\x72\141\144\141\x20\x41\x53\x20\124\151\145\155\x70\x6f\123\x61\154\151\144\x61\x45\x63\12\11\11\11\x9\x20\x20\x20\x20\106\x52\x4f\115\x20\x52\145\x67\x69\163\164\162\157\123\141\154\x69\x64\x61\x73\x20\101\123\x20\x52\123\xa\x9\11\11\11\x20\x20\x20\40\112\117\111\x4e\x20\x53\x61\x6c\151\144\x61\x73\x50\x65\162\163\157\x6e\x61\x6c\40\x41\123\40\123\x50\40\117\x4e\x20\x52\123\x2e\x66\153\137\142\x61\x64\x67\x65\x20\75\x20\123\x50\56\x42\141\x64\x67\x65\12\11\x9\x9\x9\x20\40\40\x20\112\117\x49\x4e\x20\110\157\162\141\162\x69\157\163\40\101\x53\x20\110\x44\145\x73\x61\x79\x75\x6e\x6f\40\117\x4e\40\123\120\x2e\104\145\163\141\x79\165\x6e\x6f\x20\75\40\110\x44\145\x73\141\171\x75\156\157\56\111\x44\12\11\11\11\11\40\40\x20\40\x4a\117\x49\x4e\x20\110\157\162\x61\162\x69\x6f\163\x20\101\123\x20\110\x43\x6f\x6d\x69\x64\141\40\117\x4e\x20\123\120\56\103\157\x6d\x69\x64\x61\40\x3d\40\110\103\x6f\155\151\x64\141\x2e\111\x44\12\x9\11\x9\x9\x20\x20\40\40\127\x48\105\122\105\40\122\123\56\x66\153\137\x62\x61\144\147\x65\x20\x3d\40\47{$dataCheck["\146\153\137\142\x61\x64\x67\x65"]}\x27\xa\11\x9\11\x9\x20\x20\x20\40\x41\116\x44\40\50\x52\123\56\x53\x41\x20\111\x53\x20\x4e\x55\x4c\114\40\117\x52\x20\122\123\56\x45\x41\40\111\x53\x20\x4e\x55\114\x4c\40\117\x52\x20\122\123\56\123\x43\x20\x49\123\40\116\x55\114\114\40\x4f\122\40\x52\x53\56\x45\x43\x20\111\x53\x20\116\x55\x4c\114\51"; $sql_CheckQuery = sqlsrv_query($conn, $sql_CheckNull); if ($sql_CheckQuery && sqlsrv_has_rows($sql_CheckQuery)) { $row = sqlsrv_fetch_array($sql_CheckQuery); $columnToUpdate = null; foreach (array("\123\101", "\105\101", "\123\x43", "\105\103") as $column) { $timeField = "\124\x69\145\x6d\160\x6f\x53\x61\x6c\x69\144\141" . ucfirst(strtolower($column)); $timeToCheck = $row[$timeField]->format("\x48\x3a\x69\x3a\163"); $referenceTime = $dataCheck["\163\x63\141\156\x48\157\165\162"]; $timeToCheckInSeconds = strtotime($timeToCheck); $referenceTimeInSeconds = strtotime($referenceTime); $diffMinutes = abs(($timeToCheckInSeconds - $referenceTimeInSeconds) / 60); if (is_null($row[$column])) { if (in_array($dataCheck["\146\x6b\x5f\x62\141\x64\147\145"], $array_excludes)) { $updateValue = "\x4f\x4b"; } elseif (in_array($column, array("\123\101", "\123\103"))) { $referenceTime = $dataCheck["\x73\143\141\x6e\x48\157\165\x72"]; $timeToCheck = strtotime($timeToCheck); $referenceTime = strtotime($referenceTime); $lowerLimit = $timeToCheck - 5 * 60; $upperLimit = $timeToCheck + 10 * 60; if ($referenceTime >= $lowerLimit && $referenceTime <= $upperLimit) { $updateValue = "\x4f\113"; } else { if ($referenceTime < $lowerLimit) { $updateValue = "\102\105\x46"; } elseif ($referenceTime > $upperLimit) { $updateValue = "\x41\106\124"; } else { $updateValue = "\x42\x41\x44"; } } } elseif (in_array($column, array("\105\101", "\105\103"))) { $referenceTime = $dataCheck["\x73\x63\x61\156\x48\x6f\x75\x72"]; $timeToCheck = strtotime($timeToCheck); $referenceTime = strtotime($referenceTime); $lowerLimit = $timeToCheck - 10 * 60; $upperLimit = $timeToCheck + 5 * 60; if ($referenceTime >= $lowerLimit && $referenceTime <= $upperLimit) { $updateValue = "\x4f\x4b"; } else { if ($referenceTime < $lowerLimit) { $updateValue = "\102\x45\106"; } elseif ($referenceTime > $upperLimit) { $updateValue = "\101\106\124"; } else { $updateValue = "\102\101\104"; } } } $columnToUpdate = $column; break; } } if (!is_null($columnToUpdate)) { $updateSQL = "\12\11\11\11\x9\x20\40\x20\x20\x20\40\x20\40\40\x20\40\40\x55\x50\104\x41\x54\x45\40\x52\x65\147\151\x73\x74\x72\x6f\123\141\154\151\x64\141\163\xa\11\11\11\11\x20\x20\40\40\x20\x20\x20\40\x20\40\x20\x20\123\105\124\x20{$columnToUpdate}\x20\75\x20\47{$updateValue}\47\54\xa\11\11\11\11\40\40\40\40\40\40\40\x20\40\x20\x20\40\123\143\x61\x6e\x48\157\x75\x72\x20\75\x20\107\105\124\x44\101\x54\105\x28\x29\xa\11\x9\11\x9\x20\40\40\40\40\x20\40\x20\x20\x20\40\40\x57\x48\105\122\105\x20\x49\104\x20\x3d\40" . $row["\111\x44"]; $sql_InsertQuery = sqlsrv_query($conn, $updateSQL); if ($sql_InsertQuery == true) { echo json_encode(array("\x72\x65\x73\x70\157\x6e\163\x65" => "\x73\165\x63\x63\145\x73\163")); } else { echo json_encode(array("\162\x65\x73\160\157\156\x73\145" => "\146\141\x69\x6c")); } } } } else { $sql_SAStatement = "\123\105\114\105\x43\124\40\12\11\x9\40\x20\x20\40\x9\11\11\x9\11\11\x20\40\40\123\125\102\x53\124\x52\x49\x4e\x47\x28\103\117\116\126\105\x52\x54\x28\166\x61\x72\x63\150\141\x72\x2c\x20\110\x44\x65\x73\x61\171\165\156\x6f\x2e\124\x69\145\x6d\160\157\123\141\x6c\151\144\141\54\40\61\x30\x38\x29\54\x20\x31\x2c\x20\65\x29\40\x41\123\40\x54\151\x65\155\160\x6f\123\x61\154\x69\144\141\x44\x65\x73\141\171\x75\156\157\xa\11\11\40\x20\40\x20\11\11\11\11\11\11\x46\122\x4f\x4d\40\x53\x61\154\151\144\141\x73\120\x65\162\x73\157\156\141\x6c\x20\101\x53\x20\x53\x50\12\11\11\x20\40\x20\x20\x9\x9\11\x9\11\11\112\117\x49\x4e\40\110\x6f\x72\141\162\151\157\163\40\x41\x53\x20\110\104\x65\163\x61\x79\x75\156\x6f\40\x4f\116\x20\x53\x50\x2e\104\x65\163\x61\x79\x75\156\x6f\40\x3d\40\x48\104\145\x73\x61\x79\x75\x6e\x6f\56\x49\104\12\x9\x9\x20\x20\x20\40\11\x9\11\11\11\x9\x4a\x4f\x49\116\40\110\157\x72\x61\x72\151\x6f\163\x20\101\123\40\110\x43\x6f\155\151\x64\x61\40\x4f\x4e\40\123\x50\56\103\x6f\155\x69\x64\141\40\x3d\40\110\x43\x6f\x6d\151\x64\141\56\111\104\x20\127\x48\105\122\x45\x20\x42\141\144\147\x65\40\x3d\40\x27{$dataCheck["\146\153\x5f\x62\141\x64\147\145"]}\47"; $sql_SAQuery = sqlsrv_query($conn, $sql_SAStatement); $time = sqlsrv_fetch_array($sql_SAQuery); if ($sql_SAQuery != true) { echo json_encode(array("\x72\x65\x73\x70\157\156\163\x65" => "\146\x61\151\154")); } else { if (in_array($dataCheck["\x66\153\137\x62\141\144\147\145"], $array_excludes)) { $status = "\117\x4b"; } else { $status = getStatus($dataCheck["\163\x63\141\156\x48\157\165\162"], $time["\124\x69\145\155\x70\x6f\123\141\x6c\x69\x64\141\104\x65\x73\141\171\165\x6e\157"]); } $sql_InsertStatement = "\111\x4e\x53\x45\122\124\x20\x49\x4e\124\x4f\40\x52\x65\x67\x69\x73\x74\x72\157\123\141\154\151\144\x61\x73\xa\x9\11\x9\x20\x20\x20\x20\40\40\x20\x20\x9\11\x9\50\x53\x63\141\x6e\x44\x61\x74\145\54\40\x53\x63\141\156\110\157\x75\x72\x2c\x20\123\x41\x2c\40\x66\153\137\142\x61\x64\x67\x65\51\xa\11\11\11\x9\x9\11\11\x9\x56\101\114\125\105\123\40\50\x27{$dataCheck["\163\x63\141\156\104\141\164\x65"]}\47\x2c\x20\47{$dataCheck["\163\143\141\156\110\157\x75\162"]}\x27\x2c\40\x27{$status}\x27\54\40\x27{$dataCheck["\146\x6b\x5f\142\x61\144\x67\145"]}\47\x29"; $sql_InsertQuery = sqlsrv_query($conn, $sql_InsertStatement); if ($sql_InsertQuery == true) { echo json_encode(array("\x72\145\x73\160\157\x6e\x73\145" => "\x73\165\143\143\145\163\x73")); } else { echo json_encode(array("\x72\x65\x73\x70\157\x6e\163\145" => "\146\141\151\154")); } } } } else { } } } } } goto A5YJY; ywoAK: ?>