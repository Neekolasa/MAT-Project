<?php goto jgTX8; jgTX8: include "\x2e\x2e\57\x2e\x2e\57\x63\157\156\156\145\x63\x74\151\x6f\x6e\x2e\x70\150\x70"; goto y6ozk; y6ozk: $request = $_REQUEST["\x72\x65\x71\165\145\x73\x74"]; goto nBbX3; nBbX3: if ($request == "\x73\x65\x72\166\x69\x63\x65\x73") { $numMaterial = $_REQUEST["\x69\156\146\157"]; $sql_query = "\x49\116\123\105\x52\124\x20\x49\x4e\124\x4f\x20\x73\145\162\166\x69\143\145\x73\x70\x61\x72\x74\x20\50\x50\x4e\51\x20\126\101\114\125\x45\x53\50\47{$numMaterial}\x27\x29"; $sql_execute = sqlsrv_query($conn, $sql_query); if ($sql_execute == true) { echo json_encode(array("\162\145\163\x70\157\156\x73\x65" => "\163\165\143\x63\x65\x73\163")); } else { echo json_encode(array("\162\x65\x73\160\x6f\x6e\x73\145" => "\x66\x61\151\154")); } echo json_encode($sql_execute); } goto kg5ZQ; kg5ZQ: ?>