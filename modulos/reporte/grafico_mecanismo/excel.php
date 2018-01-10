<?
include ('../../../librerias/phpexcel/PHPExcel.php');
require_once("../../../librerias/Recordset.php");

$z = stripslashes($_POST["condiciones"]);
$critk = "";
//$conjunto = stripslashes($_GET["condiciones"])
$rslista = new Recordset();
if(isset($z) && $z!="")
	{
		$variable = explode("!",$z);
		for ($j=0;$j<count($variable);$j++)
			{
				$variable[$j]."<br>";
				$desgloce = explode(":",$variable[$j]);
				switch($desgloce[0])
					{
						case "campo1": //mecanismo
							if($where!="")
								{
									$where = $where." AND registro_mecanismo.id_mecanismo=".$desgloce[1];
								} else {
									$where = $where." WHERE registro_mecanismo.id_mecanismo=".$desgloce[1];								
								}
								
								$rsdocu = new Recordset();
								$rsdocu->sql = "SELECT mecanismo.`mecanismo` FROM mecanismo WHERE mecanismo.`id_mecanismo`= ".$desgloce[1];
								$rsdocu->abrir();
									if($rsdocu->total_registros > 0)
										{
											$rsdocu->siguiente();
											$tdo = $rsdocu->fila["mecanismo"];									
										}
								$rsdocu->cerrar();
								unset($rsdocu);
															
								if($critk=="")
									{
										$critk = "Mecanismo : ".$tdo;
									} else {
										$critk = $critk.", Mecanismo : ".$tdo;								
									}	
								
																
						break;
						case "campo2"://fecha
							$sub_desgloce = explode("_",$desgloce[1]);
							if($where!="")
								{	
									$where = $where." AND registro_mecanismo.fecha_registro BETWEEN '".$rslista->formatofecha($sub_desgloce[0])."' AND '".$rslista->formatofecha($sub_desgloce[1])."'";
								} else {
									$where = $where." WHERE registro_mecanismo.fecha_registro BETWEEN '".$rslista->formatofecha($sub_desgloce[0])."' AND '".$rslista->formatofecha($sub_desgloce[1])."'";
								}
								
							if($critk=="")
								{
									$critk = "Fecha de Registro: ".$sub_desgloce[0]." y ".$sub_desgloce[1];
								} else {
									$critk = $critk.", Fecha de Registro: ".$sub_desgloce[0]." y ".$sub_desgloce[1];								
								}								
		
						break;
						case "campo3"://
							if($where!="")
								{
									$where = $where." AND registro_mecanismo.caso=".$desgloce[1];
								} else {
									$where = $where." WHERE registro_mecanismo.caso=".$desgloce[1];								
								}	

								if($desgloce[1]==0){ $a="Si"; } else { $a="No"; }								
								if($critk=="")
									{
										$critk = "Competencia : ".$a;
									} else {
										$critk = $critk.", Competencia : ".$a;								
									}									
						break;
					}	
			}
	}

	$rslista->sql = "SELECT registro_mecanismo.`n_expediente`, mecanismo.mecanismo, DATE_FORMAT(registro_mecanismo.`fecha_registro`,'%d-%m-%Y') AS fecha_registro, 
							IF(registro_mecanismo.`caso`=0,'Si','no') AS competencia , CONCAT(ciudadano.`nombres`,', ',ciudadano.`apellidos`) AS ciudadano, IF(registro_mecanismo.`observacion` ='','No Posee',registro_mecanismo.`observacion`) AS observacion
					 FROM registro_mecanismo INNER JOIN mecanismo ON (registro_mecanismo.`id_mecanismo` = mecanismo.`id_mecanismo`)
											 INNER JOIN ciudadano ON (registro_mecanismo.`id_ciudadano` = ciudadano.`id_ciudadano`)						  
					 $where
					 ";
	$rslista->abrir();


$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Adriano Frade")
							 ->setLastModifiedBy("Adriano Frade")
							 ->setTitle("Mecanismos Participacion")
							 ->setSubject("Siroac")
							 ->setDescription("Mecanismos")
							 ->setKeywords("Reporte")
							 ->setCategory("Reporte");


$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('SIROAC');
$objDrawing->setDescription('SIROAC');
$objDrawing->setPath('../../../images/contraloria.jpg');
$objDrawing->setCoordinates('B2');
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('SIROAC');
$objDrawing->setDescription('SIROAC');
$objDrawing->setPath('../../../images/LOGOSNCF.jpg');
$objDrawing->setCoordinates('E2');
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//configuracion de pagina
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(100);

$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.40);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.30);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.55);
$objPHPExcel->getActiveSheet()->getPageMargins()->setHeader(0.05);

$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
$objPHPExcel->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&C&H'. $n_expediente);
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B'. $objPHPExcel->getProperties()->getTitle() . '&RPagina &P de &N');

//configuracion de pagina

$objPHPExcel->getActiveSheet()->mergeCells('C4:D4');	
$objPHPExcel->getActiveSheet()->mergeCells('C5:D5');	
$objPHPExcel->getActiveSheet()->mergeCells('C7:D7');

$objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C4', "CONTRALORIA DEL ESTADO ARAGUA")
            ->setCellValue('C5', "OFICINA DE ATENCION CIUDADANA")
            ->setCellValue('C7', "Listado de Mecanismos");						
$objPHPExcel->getActiveSheet()->setTitle('Listado');
$objPHPExcel->getActiveSheet()->getStyle('C7')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->mergeCells('A9:F9');		
$objPHPExcel->getActiveSheet()->getStyle('A9')->getFont()->setSize(10);

$objPHPExcel->setActiveSheetIndex(0) 
			->setCellValue('A9', $rslista->decodificar("Criterios de B&uacute;squeda: ".$critk));		

if($rslista->total_registros != 0)
	{	
		$objPHPExcel->getActiveSheet()->getStyle('A11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$objPHPExcel->getActiveSheet()->getStyle('B11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('E11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
		$objPHPExcel->getActiveSheet()->getStyle('F11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$objPHPExcel->getActiveSheet()->getStyle('A11')->getFont()->setBold(true);	
		$objPHPExcel->getActiveSheet()->getStyle('B11')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C11')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('D11')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E11')->getFont()->setBold(true);	
		$objPHPExcel->getActiveSheet()->getStyle('F11')->getFont()->setBold(true);

		$k=11;
		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$k.':F'.$k)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$k.':F'.$k)->getFill()->getStartColor()->setARGB('FFB366');						
																																
		$objPHPExcel->setActiveSheetIndex(0) 
					->setCellValue('A'.$k, $rslista->decodificar("N&deg; Expediente"))
					->setCellValue('B'.$k, $rslista->decodificar("Mecanismo"))			
					->setCellValue('C'.$k, $rslista->decodificar("Ciudadano"))	
					->setCellValue('D'.$k, $rslista->decodificar("Competencia"))
					->setCellValue('E'.$k, $rslista->decodificar("Fecha Registro"))	
					->setCellValue('F'.$k, $rslista->decodificar("Observaci&oacute;n"));		
		$k=12;
			for($i=1;$i<=$rslista->total_registros;$i++)
				{
					$borders = array(
						  'borders' => array(
							'outline' => array(
							  'style' => PHPExcel_Style_Border::BORDER_THIN,
							  'color' => array('argb' => 'FF000000'),
							)
						  ),
						);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$k.':F'.$k)->applyFromArray($borders);				
					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$k)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$k)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$k)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);					
					$objPHPExcel->getActiveSheet()->getStyle('A'.$k)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					
					$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);					
					$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);					
					$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

					$objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);					
					$objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);					
					$objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					
					$objPHPExcel->getActiveSheet()->getStyle('D'.$k)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);					
					$objPHPExcel->getActiveSheet()->getStyle('D'.$k)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$k)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);					
					$objPHPExcel->getActiveSheet()->getStyle('D'.$k)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					
					$objPHPExcel->getActiveSheet()->getStyle('E'.$k)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);					
					$objPHPExcel->getActiveSheet()->getStyle('E'.$k)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$k)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);					
					$objPHPExcel->getActiveSheet()->getStyle('E'.$k)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					
					$objPHPExcel->getActiveSheet()->getStyle('F'.$k)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);					
					$objPHPExcel->getActiveSheet()->getStyle('F'.$k)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$k)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);					
					$objPHPExcel->getActiveSheet()->getStyle('F'.$k)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);																									
					
					$rslista->siguiente();
					$objPHPExcel->getActiveSheet()->getStyle('A'.$k)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$k)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$k)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$k)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$k)->getFont()->setSize(10);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$k)->getFont()->setSize(10);

					$objPHPExcel->setActiveSheetIndex(0) 
								->setCellValue('A'.$k, $rslista->fila["n_expediente"])
								->setCellValue('B'.$k, $rslista->fila["mecanismo"])			
								->setCellValue('C'.$k, $rslista->decodificar(ucwords(mb_strtolower($rslista->fila["ciudadano"]))))
								->setCellValue('D'.$k, $rslista->fila["competencia"])	
								->setCellValue('E'.$k, $rslista->fila["fecha_registro"])	
								->setCellValue('F'.$k, $rslista->decodificar($rslista->fila["observacion"]));	
					$k=$k+1;
				}

	} else {
			
			$objPHPExcel->getActiveSheet()->mergeCells('A12:F12');		
			$objPHPExcel->getActiveSheet()->getStyle('A12')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objPHPExcel->getActiveSheet()->getStyle('A12')->getFont()->setSize(13);			
			
			$objPHPExcel->setActiveSheetIndex(0) 
						->setCellValue('A12', $rslista->decodificar("No Ex&iacute;sten Datos a Mostrar!!" ));		
	}
	
$rslista->cerrar();
unset($rslista);

// Rename worksheet
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->getStyle('D7')->getFont()->setSize(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="listado_mecanismos_'.date('d-m-Y').'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

?>
