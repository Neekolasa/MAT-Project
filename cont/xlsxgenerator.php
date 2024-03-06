<?php

	require 'PHPExcel/PHPExcel.php';
	include '../../connection.php';
	$plantillaExcel = '../templates/MoverTemplate.xlsx';

	$uniqueID = $_REQUEST['UniqueID'];
	$userLogged = $_REQUEST['userLogged'];

	$sql_mover = "
	SELECT	
			MoverData.ShipPlant,
			CONVERT(varchar, MoverData.CreatedDate, 101) as CreatedDate,
			MoverData.AuthorizedUser, 
			MoverData.ShipInstructions, 
			MoverData.Telephone, 
			MoverData.OriginPlant, 
			MoverData.RequestUser, 
			MoverData.RequestUserPhone, 
			MoverData.AdditionalComments, 
			MaterialMover.Partnumber, 
			MaterialMover.Description, 
			MaterialMover.QTY, 
			MaterialMover.UoM, 
			MaterialMover.MovementType, 
			MaterialMover.SapDocument 
	FROM MoverData JOIN MaterialMover ON MoverData.UniqueID = MaterialMover.Fk_Mover 
	WHERE MoverData.UniqueID = '$uniqueID'

	";
	$objPHPExcel = PHPExcel_IOFactory::load($plantillaExcel);

	$sql_query = sqlsrv_query($conn,$sql_mover);
	$arrayCount = 0;
	$datos = array();

	while ($data = sqlsrv_fetch_array($sql_query,SQLSRV_FETCH_ASSOC)) {
		$arrayCount ++;

		$datos[] = $data;

		$objPHPExcel->getActiveSheet()->setCellValue('C6', $data['OriginPlant']);
		$cellStyle = $objPHPExcel->getActiveSheet()->getStyle('C6');
	    $font = $cellStyle->getFont();
	    $font->setSize(20);

	    $objPHPExcel->getActiveSheet()->setCellValue('G6', $data['AuthorizedUser']);
		$cellStyle = $objPHPExcel->getActiveSheet()->getStyle('C6');
	    $font = $cellStyle->getFont();
	    $font->setSize(20);

	    $objPHPExcel->getActiveSheet()->setCellValue('K6', $data['Telephone']);
		$cellStyle = $objPHPExcel->getActiveSheet()->getStyle('C6');
	    $font = $cellStyle->getFont();
	    $font->setSize(20);

	    $objPHPExcel->getActiveSheet()->setCellValue('O6', $data['CreatedDate']);
		$cellStyle = $objPHPExcel->getActiveSheet()->getStyle('C6');
	    $font = $cellStyle->getFont();
	    $font->setSize(20);

	    $objPHPExcel->getActiveSheet()->setCellValue('C10', 'EMBARCAR A: '.$data['ShipPlant']);
		$cellStyle = $objPHPExcel->getActiveSheet()->getStyle('C10');
		$cellStyle->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$cellStyle->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	    $font = $cellStyle->getFont();
	    $font->setSize(28);

	    $objPHPExcel->getActiveSheet()->setCellValue('E12', utf8_decode($data['RequestUser']));
		$cellStyle = $objPHPExcel->getActiveSheet()->getStyle('E12');
		$cellStyle->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$cellStyle->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	    $font = $cellStyle->getFont();
	    $font->setSize(12);

	    $objPHPExcel->getActiveSheet()->setCellValue('L12', $data['RequestUserPhone']);
		$cellStyle = $objPHPExcel->getActiveSheet()->getStyle('L12');
		$cellStyle->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$cellStyle->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	    $font = $cellStyle->getFont();
	    $font->setSize(12);

	    $objPHPExcel->getActiveSheet()->setCellValue('K46', utf8_decode($data['ShipInstructions']));
	    $cellStyle = $objPHPExcel->getActiveSheet()->getStyle('K46');
	    $font = $cellStyle->getFont();
	    $font->setSize(19);

	    $fill = $cellStyle->getFill();
	    $fill->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	    $fill->getStartColor()->setARGB('FFFF00');

	  
	  	 $cellStyle = $objPHPExcel->getActiveSheet()->getStyle('L46');
	    $font = $cellStyle->getFont();
	    $font->setSize(19);

	    $fill = $cellStyle->getFill();
	    $fill->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	    $fill->getStartColor()->setARGB('FFFF00');

	    $cellStyle = $objPHPExcel->getActiveSheet()->getStyle('M46');
	    $font = $cellStyle->getFont();
	    $font->setSize(19);

	    $fill = $cellStyle->getFill();
	    $fill->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	    $fill->getStartColor()->setARGB('FFFF00');

	    $cellStyle = $objPHPExcel->getActiveSheet()->getStyle('N46');
	    $font = $cellStyle->getFont();
	    $font->setSize(19);

	    $fill = $cellStyle->getFill();
	    $fill->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	    $fill->getStartColor()->setARGB('FFFF00');

	    $cellStyle = $objPHPExcel->getActiveSheet()->getStyle('O46');
	    $font = $cellStyle->getFont();
	    $font->setSize(19);

	    $fill = $cellStyle->getFill();
	    $fill->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	    $fill->getStartColor()->setARGB('FFFF00');
		    
	    
	    $objPHPExcel->getActiveSheet()->setCellValue('M48', utf8_decode($data['AdditionalComments']));
	    $cellStyle = $objPHPExcel->getActiveSheet()->getStyle('M48');
	    $cellStyle->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	    $cellStyle->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	    $font = $cellStyle->getFont();
	    $font->setSize(12);

	}
	$rowIndex = 15;

	foreach ($datos as $key) {
	    $objPHPExcel->getActiveSheet()->setCellValue('C' . $rowIndex, $key['Partnumber']);
	    $cellStyle = $objPHPExcel->getActiveSheet()->getStyle('C' . $rowIndex);
	    $cellStyle->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	    $cellStyle->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	    $font = $cellStyle->getFont();
	    $font->setSize(12);

	    $objPHPExcel->getActiveSheet()->setCellValue('F' . $rowIndex, $key['Description']);
	    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	    $cellStyle = $objPHPExcel->getActiveSheet()->getStyle('F' . $rowIndex);
	    $cellStyle->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	    $cellStyle->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	    $font = $cellStyle->getFont();
	    $font->setSize(12);

	    $objPHPExcel->getActiveSheet()->setCellValue('I' . $rowIndex, $key['QTY']);
	    $cellStyle = $objPHPExcel->getActiveSheet()->getStyle('I' . $rowIndex);
	    $cellStyle->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	    $cellStyle->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	    $font = $cellStyle->getFont();
	    $font->setSize(12);

	    $objPHPExcel->getActiveSheet()->setCellValue('K' . $rowIndex, $key['UoM']);
	    $cellStyle = $objPHPExcel->getActiveSheet()->getStyle('K' . $rowIndex);
	    $cellStyle->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	    $cellStyle->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	    $font = $cellStyle->getFont();
	    $font->setSize(12);

	    $objPHPExcel->getActiveSheet()->setCellValue('M' . $rowIndex, $key['MovementType']);
	    $cellStyle = $objPHPExcel->getActiveSheet()->getStyle('M' . $rowIndex);
	    $cellStyle->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	    $cellStyle->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	    $font = $cellStyle->getFont();
	    $font->setSize(12);

	    $objPHPExcel->getActiveSheet()->setCellValue('O' . $rowIndex, $key['SapDocument']);
	    $cellStyle = $objPHPExcel->getActiveSheet()->getStyle('O' . $rowIndex);
	    $cellStyle->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	    $cellStyle->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	    $font = $cellStyle->getFont();
	    $font->setSize(12);

	    $rowIndex++;
	}
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');


	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="mover_' . $uniqueID . '.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter->save('php://output');
?>