<?
session_start();
include ('../../../librerias/phpexcel/PHPExcel.php');
require_once("../../../librerias/Recordset.php");
$Id = stripslashes($_POST["condiciones"]);

	if ($Id!="")
	{
	
	
	
	
//SELECT id_parroquia FROM ciudadano INNER JOIN registro_mecanismo ON (ciudadano.`id_ciudadano`=registro_mecanismo.`id_ciudadano`) WHERE id_registro_mecanismo = 126	
	
		$rsusuario = new Recordset();
		$rsusuario->sql = "SELECT CONCAT(nombres, ' ',apellidos) AS usuario FROM seg_usuario WHERE usuario = '".$_SESSION["user"]."'";
		$rsusuario->abrir();
		if($rsusuario->total_registros > 0)
			{													
				$rsusuario->siguiente();
				$elusuario = $rsusuario->fila["usuario"];	
			}
		$rsusuario->cerrar();
		unset($rsusuario);
		
		$rssolicitud = new Recordset();
		$rssolicitud->sql = "SELECT ciudadano.id_ciudadano, IF(ciudadano.`id_parroquia` IS NULL,0,1) AS q, DATE_FORMAT(fecha_registro,'%d/%m/%Y') AS fecha_registro, fecha_registro AS fecha_r, n_expediente, IF(comunicacion=0,'Escrita','Verbal') AS comunicacion, IF(caso=0,'Con Competencia','Sin Competencia') AS caso, 
								CONCAT( nombres,' ',apellidos) AS nombres, ciudadano.`cedula` , IF(ISNULL(ciudadano.`email`) = TRUE,'No posee',ciudadano.email) AS correo, ciudadano.`direccion`, LENGTH(ciudadano.`direccion`) as cant_di, 
								IF(ISNULL(ciudadano.`otra_direccion`) = TRUE,'No posee',ciudadano.`otra_direccion`) AS otra_direccion, ciudadano.`telf_habitacion`, ciudadano.`telf_movil`, 
								parroquia.`parroquia`, municipio.`municipio`, estado.`estado`, mecanismo.`mecanismo`
								
							FROM registro_mecanismo INNER JOIN ciudadano ON registro_mecanismo.`id_ciudadano` = ciudadano.`id_ciudadano` 
											LEFT JOIN parroquia ON ciudadano.`id_parroquia` = parroquia.`id_parroquia`
											LEFT JOIN municipio ON parroquia.`id_municipio` = municipio.`id_municipio`
											LEFT JOIN estado ON municipio.`id_estado` = estado.`id_estado`
											INNER JOIN mecanismo ON (registro_mecanismo.`id_mecanismo`=mecanismo.`id_mecanismo`)
							WHERE id_registro_mecanismo =".$Id;
		$rssolicitud->abrir();
		if($rssolicitud->total_registros != 0)
			{	
				$rssolicitud->siguiente();
				$n_expediente = $rssolicitud->fila["n_expediente"];
				$id_ciudadano = $rssolicitud->fila["id_ciudadano"];
				$fecha = $rssolicitud->fila["fecha_registro"];	
				$fecha_r = $rssolicitud->fila["fecha_r"];					
				$comunicacion = $rssolicitud->fila["comunicacion"];
				if($comunicacion=="Verbal"){$eltipo = "N&deg; Mecanismo";} else { $eltipo = "N&deg; Expediente";}
				$eltipo = $rssolicitud->decodificar($eltipo);
				$caso = $rssolicitud->fila["caso"];
				$cedula = $rssolicitud->fila["cedula"];
				$nombres = $rssolicitud->decodificar($rssolicitud->fila["nombres"]);
				$direccion = $rssolicitud->decodificar($rssolicitud->fila["direccion"]);
				$correo = $rssolicitud->fila["correo"];
				$telf_habitacion = $rssolicitud->fila["telf_habitacion"];
				$telf_movil = $rssolicitud->fila["telf_movil"];	
				$otra_direccion = $rssolicitud->decodificar($rssolicitud->fila["otra_direccion"]);	
				$parroquia = $rssolicitud->decodificar($rssolicitud->fila["parroquia"]);	
				$municipio = $rssolicitud->decodificar($rssolicitud->fila["municipio"]);
				$estado = $rssolicitud->decodificar($rssolicitud->fila["estado"]);	
				$mecanismo = $rssolicitud->decodificar($rssolicitud->fila["mecanismo"]);																												
				$suiche = $rssolicitud->fila["q"];					
				
				if($suiche==0)
				{
					$aqa = new Recordset();
					$aqa->sql = "SELECT municipio.`municipio`, estado.`estado`
										FROM ciudadano INNER JOIN municipio ON ciudadano.`id_municipio` = municipio.`id_municipio` INNER JOIN estado ON municipio.`id_estado` = estado.`id_estado`
										WHERE ciudadano.`id_ciudadano`=".$id_ciudadano;
					$aqa->abrir();
					if($aqa->total_registros != 0)
						{	
							$aqa->siguiente();				
							$parroquia = "--";	
							$municipio = $aqa->decodificar($aqa->fila["municipio"]);
							$estado = $aqa->decodificar($aqa->fila["estado"]);																		
						
						}	
				$aqa->cerrar();
				unset($aqa);
				}					
			
			}
		$rssolicitud->cerrar();
		unset($rssolicitud);


		$sentencia = "SELECT interposicion_mecanismo.`interposicion_mecanismo`
							FROM registro_mecanismo 
								INNER JOIN registro_mecanismo_interposicion ON (registro_mecanismo.`id_registro_mecanismo` = registro_mecanismo_interposicion.`id_registro_mecanismo`)
								INNER JOIN interposicion_mecanismo ON (interposicion_mecanismo.`id_interposicion_mecanismo` = registro_mecanismo_interposicion.`id_interposicion_mecanismo`)	
							WHERE registro_mecanismo.id_registro_mecanismo = ".$Id;   
		$rsdocu = new Recordset();
		$rsdocu->sql = $sentencia;
		$rsdocu->abrir();
		if($rsdocu->total_registros != 0)
			{	
				for($j = 0; $j < $rsdocu->total_registros; $j++)
				{
					$rsdocu->siguiente();
					if($in==""){				
						$in = html_entity_decode($rsdocu->fila["interposicion_mecanismo"]);
					} else if($in!="") {			
						$in = $in.", ".html_entity_decode($rsdocu->fila["interposicion_mecanismo"]);		
					}
				}		
			}
		$rsdocu->cerrar();
		unset($rsdocu);

		$rssolicitud = new Recordset();
		$rssolicitud->sql = "SELECT nombre_instancia_pp, IF(ISNULL(rif_instancia_pp) = TRUE,'No posee',rif_instancia_pp) AS rif_instancia_pp, direccion_instancia_pp, IF(ISNULL(ente_financiero) = TRUE,'No posee',ente_financiero) AS ente_financiero, 
								IF(ISNULL(nombre_proyecto) = TRUE,'No posee',nombre_proyecto) AS nombre_proyecto, IF(ISNULL(monto_financiado) = TRUE,'No posee',monto_financiado) AS monto_financiado, 
								IF(pertenece_comite = 0,'Si Pertenece','No Pertenece') AS pertenece_comite, IF(nombre_comite = '','No posee',nombre_comite) AS nombre_comite 
							FROM registro_mecanismo
							WHERE id_registro_mecanismo =".$Id;
		$rssolicitud->abrir();
		if($rssolicitud->total_registros != 0)
			{	
				$rssolicitud->siguiente();
				if($rssolicitud->fila["nombre_instancia_pp"]!=""){
					$part1=0;
					$nombre_instancia_pp = $rssolicitud->decodificar($rssolicitud->fila["nombre_instancia_pp"]);
					$rif_instancia_pp = $rssolicitud->fila["rif_instancia_pp"];		
					$direccion_instancia_pp = $rssolicitud->decodificar($rssolicitud->fila["direccion_instancia_pp"]);
					$ente_financiero = $rssolicitud->decodificar($rssolicitud->fila["ente_financiero"]);
					$nombre_proyecto = $rssolicitud->decodificar($rssolicitud->fila["nombre_proyecto"]);
					$monto_financiado = $rssolicitud->fila["monto_financiado"];
					$pertenece_comite = $rssolicitud->fila["pertenece_comite"];
					$nombre_comite = $rssolicitud->decodificar($rssolicitud->fila["nombre_comite"]);	
				} else {
					$part1=1;				
				}
			}
		$rssolicitud->cerrar();
		unset($rssolicitud);			

		$rssolicitud = new Recordset();
		$rssolicitud->sql = "SELECT nombre_organizacion_sindical, direccion_organizacion_sindical, rif_organizacion_sindical, telef_oficina, IF(otro_telef = '','No posee',otro_telef) AS otro_telef
							FROM registro_mecanismo
							WHERE	id_registro_mecanismo=".$Id;
		$rssolicitud->abrir();
		if($rssolicitud->total_registros != 0)
			{	
				$rssolicitud->siguiente();
				if($rssolicitud->fila["nombre_organizacion_sindical"]!="")
				{
					$part2=0;				
					$nombre_organizacion_sindical = $rssolicitud->decodificar($rssolicitud->fila["nombre_organizacion_sindical"]);
					$direccion_organizacion_sindical = $rssolicitud->decodificar($rssolicitud->fila["direccion_organizacion_sindical"]);		
					$rif_organizacion_sindical = $rssolicitud->fila["rif_organizacion_sindical"];
					$telef_oficina = $rssolicitud->fila["telef_oficina"];
					$otro_telef = $rssolicitud->fila["otro_telef"];																						
				} else {
					$part2=1;
				}
			}
			
		$rssolicitud->cerrar();
		unset($rssolicitud);	
		
		$rssolicitud = new Recordset();
		$rssolicitud->sql = "SELECT actores_involucrados, LENGTH(actores_involucrados) AS log_acto
								FROM registro_mecanismo
								WHERE id_registro_mecanismo=".$Id;
		$rssolicitud->abrir();
		if($rssolicitud->total_registros != 0)
			{	
				$rssolicitud->siguiente();
				if($rssolicitud->fila["actores_involucrados"]!="")
				{					
					$part3=0;
					$actores_involucrados = $rssolicitud->decodificar($rssolicitud->fila["actores_involucrados"]);
				} else {
					$part3=1;
				}
			}
		$rssolicitud->cerrar();
		unset($rssolicitud);	
		
		$rssolicitud = new Recordset();
		$rssolicitud->sql = "SELECT escena_suceso, LENGTH(escena_suceso) AS log_esce
								FROM registro_mecanismo
								WHERE	id_registro_mecanismo=".$Id;
		$rssolicitud->abrir();
		if($rssolicitud->total_registros != 0)
			{	
				$rssolicitud->siguiente();
				if($rssolicitud->fila["escena_suceso"]!="")
					{
						$part4=0;				
						$escena_suceso = $rssolicitud->decodificar($rssolicitud->fila["escena_suceso"]);
					} else {
						$part4=1;				
					}
			}
		$rssolicitud->cerrar();
		unset($rssolicitud);

		$rssolicitud = new Recordset();
		$rssolicitud->sql = "SELECT relatoria_caso, LENGTH(relatoria_caso) AS log_relat
								FROM registro_mecanismo
								WHERE id_registro_mecanismo=".$Id;
		$rssolicitud->abrir();
		if($rssolicitud->total_registros != 0)
			{
				$rssolicitud->siguiente();
				if($rssolicitud->fila["relatoria_caso"]!="")
					{
						$part6=0;				
						$relatoria_caso = $rssolicitud->decodificar($rssolicitud->fila["relatoria_caso"]);
					} else {
						$part6=1;				
					}
			}
		$rssolicitud->cerrar();
		unset($rssolicitud);			

		$rssolicitud = new Recordset();
		$rssolicitud->sql = "SELECT observacion, LENGTH(observacion) AS log_obser
							FROM registro_mecanismo
							WHERE id_registro_mecanismo=".$Id;
		$rssolicitud->abrir();
		if($rssolicitud->total_registros != 0)
			{
				$rssolicitud->siguiente();
				if($rssolicitud->fila["observacion"]!="")
					{
						$part7=0;					
						$observacion = $rssolicitud->decodificar($rssolicitud->fila["observacion"]);
					} else {
						$part7=1;				
					}
			}
		$rssolicitud->cerrar();
		unset($rssolicitud);
					

	} else {
		echo "Error Consulte al administrador";
		exit();

	}

//CABECERA DEL REPORTE
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Adriano Frade")
							 ->setLastModifiedBy("Adriano Frade")
							 ->setTitle("Mecanismos Participacion: ".$mecanismo)
							 ->setSubject("Siroac")
							 ->setDescription("$mecanismo")
							 ->setKeywords("Reporte")
							 ->setCategory("Reporte");


$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('SIROAC');
$objDrawing->setDescription('SIROAC');
$objDrawing->setPath('../../../images/contraloria.jpg');
$objDrawing->setCoordinates('A2');
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('SIROAC');
$objDrawing->setDescription('SIROAC');
$objDrawing->setPath('../../../images/LOGOSNCF.jpg');
$objDrawing->setCoordinates('F2');
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

//configuracion de pagina
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
$objPHPExcel->getActiveSheet()->getPageSetup()->setScale(100);

$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.20);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.10);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0.80);
$objPHPExcel->getActiveSheet()->getPageMargins()->setHeader(0.20);
//$objPHPExcel->getActiveSheet()->getPageMargins()->setFooter(0.95);

$objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
$objPHPExcel->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&B'. $objPHPExcel->getProperties()->getTitle() .'&C&H'. $n_expediente. '&RPagina &P de &N');
//$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B'. $objPHPExcel->getProperties()->getTitle() . '&RPagina &P de &N');

//configuracion de pagina
$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$objPHPExcel->getActiveSheet()->mergeCells('C4:E4');	
$objPHPExcel->getActiveSheet()->mergeCells('C5:E5');	
$objPHPExcel->getActiveSheet()->mergeCells('D8:D8');

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('C4', "CONTRALORIA DEL ESTADO ARAGUA")
            ->setCellValue('C5', "OFICINA DE ATENCION CIUDADANA")
            ->setCellValue('D7', "$mecanismo");						
$objPHPExcel->getActiveSheet()->setTitle("aa");
// Set active sheet index to the first sheet, so Excel opens this as the first sheet

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->getStyle('D7')->getFont()->setSize(13);
$objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->setSize(14);
$objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setSize(14);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(38);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);

$objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getStyle('A9')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D9')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getStyle('A10')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D10')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getStyle('A11')->getFont()->setBold(true);

//$objPHPExcel->getActiveSheet()->getStyle('E10')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F10')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D7')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('D9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('D10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('E9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('A10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('C9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$objPHPExcel->getActiveSheet()->getStyle('A11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

$borders = array(
	  'borders' => array(
		'top' => array(
		  'style' => PHPExcel_Style_Border::BORDER_THIN,
		  'color' => array('argb' => 'FF000000'),
		)
	  ),
	);
$objPHPExcel->getActiveSheet()->getStyle('a8:f8')->applyFromArray($borders);



$objPHPExcel->getActiveSheet()->mergeCells('A9:B9');
$objPHPExcel->getActiveSheet()->mergeCells('E9:F9');

$objPHPExcel->getActiveSheet()->mergeCells('A10:B10');
$objPHPExcel->getActiveSheet()->mergeCells('E10:F10');

$objPHPExcel->getActiveSheet()->mergeCells('A11:C11');
$objPHPExcel->getActiveSheet()->mergeCells('D11:F11');

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A9', "Fecha Recepcion:")
            ->setCellValue('C9', "$fecha")
            ->setCellValue('D9', "$eltipo:")
            ->setCellValue('E9', "$n_expediente")
			
			->setCellValue('A10', "Comunicacion:")
			->setCellValue('C10', "$comunicacion")

			->setCellValue('D10', "Caso:")
			->setCellValue('E10', "$caso")
			->setCellValue('A11', "Interposicion de Mecanismo:")			
			->setCellValue('D11', "$in")						
			;
//CABECERA DEL REPORTE

//CIUDADANO ********************************************************************************			


$borders = array(
	  'borders' => array(
		'outline' => array(
		  'style' => PHPExcel_Style_Border::BORDER_THIN,
		  'color' => array('argb' => 'FF000000'),
		)
	  ),
	);
$objPHPExcel->getActiveSheet()->getStyle('a13:f13')->applyFromArray($borders);


$objPHPExcel->getActiveSheet()->mergeCells('A13:F13');

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A13', "DATOS DEL CIUDADANO");

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A13', "DATOS DEL CIUDADANO");

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->getStyle('A13')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle('A13')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A13:F13')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A13:F13')->getFill()->getStartColor()->setARGB('E4E4E4');		
	

$objPHPExcel->getActiveSheet()->mergeCells('A14:B14');
$objPHPExcel->getActiveSheet()->mergeCells('C14:D14');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A14', "Ciudadano:")
			->setCellValue('C14', "$nombres")
            ->setCellValue('E14', "C.I.:")
			->setCellValue('F14', "$cedula");
$objPHPExcel->getActiveSheet()->getStyle('A14')->getFont()->setBold(true);			
$objPHPExcel->getActiveSheet()->getStyle('E14')->getFont()->setBold(true);			
$objPHPExcel->getActiveSheet()->getStyle('A14')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('E14')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('F14')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$objPHPExcel->getActiveSheet()->mergeCells('A15:B15');
$objPHPExcel->getActiveSheet()->mergeCells('C15:D15');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A15', "Telef. Habitacion:")
			->setCellValue('C15', "$telf_habitacion")
            ->setCellValue('E15', "Telef. Movil:")
			->setCellValue('F15', "$telf_movil");
$objPHPExcel->getActiveSheet()->getStyle('A15')->getFont()->setBold(true);			
$objPHPExcel->getActiveSheet()->getStyle('E15')->getFont()->setBold(true);			
$objPHPExcel->getActiveSheet()->getStyle('A15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('E15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('F15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$objPHPExcel->getActiveSheet()->mergeCells('A16:B16');
$objPHPExcel->getActiveSheet()->mergeCells('C16:F16');

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A16', "Direccion:")
			->setCellValue('C16', "$direccion");
$objPHPExcel->getActiveSheet()->getStyle('A16')->getFont()->setBold(true);			
$objPHPExcel->getActiveSheet()->getStyle('A16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('C16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$objPHPExcel->getActiveSheet()->mergeCells('A17:B17');
$objPHPExcel->getActiveSheet()->mergeCells('C17:D17');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A17', "Parroquia:")
			->setCellValue('C17', "$parroquia")
/*            ->setCellValue('E17', "Correo:")
			->setCellValue('F17', "$correo")*/;
$objPHPExcel->getActiveSheet()->getStyle('A17')->getFont()->setBold(true);			
//$objPHPExcel->getActiveSheet()->getStyle('E17')->getFont()->setBold(true);			
$objPHPExcel->getActiveSheet()->getStyle('A17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
/*$objPHPExcel->getActiveSheet()->getStyle('E17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('F17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
*/
$objPHPExcel->getActiveSheet()->mergeCells('A18:B18');
$objPHPExcel->getActiveSheet()->mergeCells('C18:D18');
$objPHPExcel->getActiveSheet()->mergeCells('A19:B19');
$objPHPExcel->getActiveSheet()->mergeCells('C19:D19');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A18', "Municipio:")
			->setCellValue('C18', "$municipio")
            ->setCellValue('A19', "Estado:")
			->setCellValue('C19', "$estado");
$objPHPExcel->getActiveSheet()->getStyle('A18')->getFont()->setBold(true);			
$objPHPExcel->getActiveSheet()->getStyle('A19')->getFont()->setBold(true);			
$objPHPExcel->getActiveSheet()->getStyle('A18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('A19')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('F18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$objPHPExcel->getActiveSheet()->mergeCells('A20:B20');
$objPHPExcel->getActiveSheet()->mergeCells('C20:F20');

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A20', "Otra Direccion:")
			->setCellValue('C20', "$otra_direccion");
$objPHPExcel->getActiveSheet()->getStyle('A20')->getFont()->setBold(true);			
$objPHPExcel->getActiveSheet()->getStyle('A20')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('C20')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A20', "Otra Direccion:")
			->setCellValue('C20', "$otra_direccion");
$objPHPExcel->getActiveSheet()->getStyle('A20')->getFont()->setBold(true);			
$objPHPExcel->getActiveSheet()->getStyle('A20')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('C20')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$objPHPExcel->getActiveSheet()->mergeCells('A21:B21');
$objPHPExcel->getActiveSheet()->mergeCells('C21:D21');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A21', "Correo:")
			->setCellValue('C21', "$correo");
$objPHPExcel->getActiveSheet()->getStyle('A21')->getFont()->setBold(true);			
$objPHPExcel->getActiveSheet()->getStyle('A21')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('C21')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);


//CIUDADANO ********************************************************************************

//INSTANCIA DEL PODER POPULAR ********************************************************************************			
$h=22;
if($part1==0){
	$borders = array(
		  'borders' => array(
			'outline' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN,
			  'color' => array('argb' => 'FF000000'),
			)
		  ),
		);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->applyFromArray($borders);
	
	
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$h.':F'.$h);
	
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$h, "INSTANCIA DEL PODER POPULAR");
	
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setSize(12);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getFill()->getStartColor()->setARGB('E4E4E4');		
	
	$h=$h+1; // ENTER	
	
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$h.':B'.$h);
	$objPHPExcel->getActiveSheet()->mergeCells('C'.$h.':F'.$h);
	//$objPHPExcel->getActiveSheet()->getRowDimension('22')->setRowHeight(20);
	//$objPHPExcel->getActiveSheet()->getStyle('A22:B22')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$h, "Instancia P.P.:")
				->setCellValue('C'.$h, "$nombre_instancia_pp");
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setBold(true);			
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	
	$h=$h+1; // ENTER
		
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$h.':B'.$h);
	$objPHPExcel->getActiveSheet()->mergeCells('C'.$h.':F'.$h);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$h, "Direccion:")
				->setCellValue('C'.$h, "$direccion_instancia_pp");
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setBold(true);			
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	//$objPHPExcel->getActiveSheet()->getStyle('C23')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$h.':F'.$h)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	
	$h=$h+1; // ENTER
		
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$h.':B'.$h);
	$objPHPExcel->getActiveSheet()->mergeCells('C'.$h.':D'.$h);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$h, "Ente Financiero:")
				->setCellValue('C'.$h, "$ente_financiero")
				->setCellValue('E'.$h, "Rif.:")
				->setCellValue('F'.$h, "$rif_instancia_pp");
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setBold(true);			
	$objPHPExcel->getActiveSheet()->getStyle('E'.$h)->getFont()->setBold(true);			
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle('F'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

	$h=$h+1; // ENTER
		
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$h.':B'.$h);
	$objPHPExcel->getActiveSheet()->mergeCells('C'.$h.':F'.$h);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$h, "Nombre Proyecto:")
				->setCellValue('C'.$h, "$nombre_proyecto");
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setBold(true);			
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	
	$h=$h+1; // ENTER
		
	$objPHPExcel->getActiveSheet()->getCell('C'.$h)->setValueExplicit($monto_financiado.' Bs.', PHPExcel_Cell_DataType::TYPE_STRING);
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$h.':B'.$h);
	$objPHPExcel->getActiveSheet()->mergeCells('E'.$h.':F'.$h);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$h, "Monto Financiado:")
				/*->setCellValue('C'.$h, "$monto_financiado")*/
				->setCellValue('D'.$h, "Pertenece Algun Comite:")
				->setCellValue('E'.$h, "$pertenece_comite");
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setBold(true);			
	$objPHPExcel->getActiveSheet()->getStyle('D'.$h)->getFont()->setBold(true);			
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->getStyle('D'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	
	$h=$h+1; // ENTER
		
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$h.':B'.$h);
	$objPHPExcel->getActiveSheet()->mergeCells('C'.$h.':F'.$h);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$h, "Nombre Comite:")
				->setCellValue('C'.$h, "$nombre_comite");
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setBold(true);			
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
}

//INSTANCIA DEL PODER POPULAR ********************************************************************************			


//MIEMBROS DE ORGANIZACION SINDICAL O GREMIAL ********************************************************************************			
if($part2==0){
	$h=$h+2; // ENTER
	$borders = array(
		  'borders' => array(
			'outline' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN,
			  'color' => array('argb' => 'FF000000'),
			)
		  ),
		);
	$objPHPExcel->getActiveSheet()->getStyle('a'.$h.':f'.$h)->applyFromArray($borders);
	
	
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$h.':F'.$h);
	
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$h, "MIEMBROS DE ORGANIZACION SINDICAL O GREMIAL");
	
	
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setSize(12);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getFill()->getStartColor()->setARGB('E4E4E4');		
	
	$h=$h+1; // ENTER	

	$objPHPExcel->getActiveSheet()->mergeCells('A'.$h.':B'.$h);
	$objPHPExcel->getActiveSheet()->mergeCells('C'.$h.':F'.$h);
	//$objPHPExcel->getActiveSheet()->getRowDimension('22')->setRowHeight(20);
	//$objPHPExcel->getActiveSheet()->getStyle('A22:B22')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$h, "Nomb. Organizacion:")
				->setCellValue('C'.$h, "$nombre_organizacion_sindical");
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setBold(true);			
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

	$h=$h+1; // ENTER	
	
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$h.':B'.$h);
	$objPHPExcel->getActiveSheet()->mergeCells('C'.$h.':F'.$h);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$h, "Direccion:")
				->setCellValue('C'.$h, "$direccion_organizacion_sindical");
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setBold(true);			
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	//$objPHPExcel->getActiveSheet()->getStyle('C23')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$h.':F'.$h)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	
	$h=$h+1; // ENTER	
	
	$telef_ = $telef_oficina." / ".$otro_telef;
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$h.':B'.$h);
	$objPHPExcel->getActiveSheet()->mergeCells('E'.$h.':F'.$h);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$h, "Rif.:")
				->setCellValue('C'.$h, "$rif_organizacion_sindical")
				->setCellValue('D'.$h, "Telefonos:")
				->setCellValue('E'.$h, "$telef_");
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setBold(true);			
	$objPHPExcel->getActiveSheet()->getStyle('D'.$h)->getFont()->setBold(true);			
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objPHPExcel->getActiveSheet()->getStyle('D'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->getStyle('E'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);			
}
//MIEMBROS DE ORGANIZACION SINDICAL O GREMIAL ********************************************************************************						

// Personas, Organismos o Instituciones Involucradas en los Hechos ***********************************************************
if($part3==0){
	$h=$h+2;
	$borders = array(
		  'borders' => array(
			'outline' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN,
			  'color' => array('argb' => 'FF000000'),
			)
		  ),
		);
	$objPHPExcel->getActiveSheet()->getStyle('a'.$h.':f'.$h)->applyFromArray($borders);
	
	
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$h.':F'.$h);
	
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$h, "PERSONAS, ORGANISMOS O INSTITUCIONES INVOLUCRADAS EN LOS HECHOS");			
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setSize(12);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getFill()->getStartColor()->setARGB('E4E4E4');		
	
	
	//$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$h=$h+1; // ENTER				

	$objPHPExcel->getActiveSheet()->mergeCells('A'.$h.':F'.$h);	
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$h, "$actores_involucrados");
	$objPHPExcel->getActiveSheet()->getRowDimension($h)->setRowHeight(80);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);	
}
// Personas, Organismos o Instituciones Involucradas en los Hechos ***********************************************************

// FECHA EN LA CUAL OCURRIO U OCURRIERON LOS HECHOS ***********************************************************
if($part4==0){
	$h=$h+2;
	$borders = array(
		  'borders' => array(
			'outline' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN,
			  'color' => array('argb' => 'FF000000'),
			)
		  ),
		);
	$objPHPExcel->getActiveSheet()->getStyle('a'.$h.':f'.$h)->applyFromArray($borders);
	
	
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$h.':F'.$h);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$h, "FECHA EN LA CUAL OCURRIO U OCURRIERON LOS HECHOS");			
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setSize(12);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getFill()->getStartColor()->setARGB('E4E4E4');	
	
	//$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

	$h=$h+1; // ENTER				
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$h.':F'.$h);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$h, "$escena_suceso");
	$objPHPExcel->getActiveSheet()->getRowDimension($h)->setRowHeight(38);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);	
}
// FECHA EN LA CUAL OCURRIO U OCURRIERON LOS HECHOS ***********************************************************

//PRUEBAS CONSIGNADAS ********************************************************************************************************
$rssolicitud = new Recordset();
$rssolicitud->sql = "SELECT prueba_consignada, n_folios, contenido FROM registro_mecanismo_prueba WHERE id_registro_mecanismo=".$Id;
$rssolicitud->abrir();
if($rssolicitud->total_registros != 0)
	{
		$h=$h+2;
		$borders = array(
			  'borders' => array(
				'outline' => array(
				  'style' => PHPExcel_Style_Border::BORDER_THIN,
				  'color' => array('argb' => 'FF000000'),
				)
			  ),
			);
		$objPHPExcel->getActiveSheet()->getStyle('a'.$h.':f'.$h)->applyFromArray($borders);
		
		$objPHPExcel->getActiveSheet()->mergeCells('a'.$h.':f'.$h);
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$h, "PRUEBAS CONSIGNADAS");			
		$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getFill()->getStartColor()->setARGB('E4E4E4');		
	
		$h=$h+1; // ENTER

		$borders = array(
			  'borders' => array(
				'outline' => array(
				  'style' => PHPExcel_Style_Border::BORDER_THIN,
				  'color' => array('argb' => 'FF000000'),
				)
			  ),
			);		
		$objPHPExcel->getActiveSheet()->getStyle('B'.$h.':D'.$h)->applyFromArray($borders);
	
		$objPHPExcel->getActiveSheet()->getStyle('D'.$h)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);					
		$objPHPExcel->getActiveSheet()->mergeCells('B'.$h.':C'.$h);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$h.':D'.$h)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$h.':D'.$h)->getFill()->getStartColor()->setARGB('CCCCCC');				
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B'.$h, "Tipo:")
			->setCellValue('D'.$h, $rssolicitud->decodificar("N&deg; Folio:"));	
		$objPHPExcel->getActiveSheet()->getStyle('B'.$h)->getFont()->setBold(true);			
		$objPHPExcel->getActiveSheet()->getStyle('D'.$h)->getFont()->setBold(true);					
		$objPHPExcel->getActiveSheet()->getStyle('B'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);			
		
		//$h=43;
	
		$h=$h+1; // ENTER		
		$summ = 0;
		for($j = 0; $j < $rssolicitud->total_registros; $j++)
		{
			$rssolicitud->siguiente();
			$prueba_consignada = $rssolicitud->fila["prueba_consignada"];
			$n_folios = $rssolicitud->fila["n_folios"];			
			$contenido = $rssolicitud->fila["contenido"];
			$summ = $summ+$rssolicitud->fila["n_folios"];	
//*
			$objPHPExcel->getActiveSheet()->mergeCells('B'.$h.':C'.$h);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$borders = array(
				  'borders' => array(
					'allborders' => array(
					  'style' => PHPExcel_Style_Border::BORDER_THIN,
					  'color' => array('argb' => 'FF000000'),
					)
				  ),
				);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$h.':D'.$h)->applyFromArray($borders);
//*
				
			if($prueba_consignada=="Otros")
			{
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('B'.$h, "Otros:")
							->setCellValue('D'.$h, "$n_folios");			
				$h=$h+1;								
				$objPHPExcel->getActiveSheet()->mergeCells('B'.$h.':D'.$h);
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('B'.$h, "Se Especifica: $contenido");			
			} else {
				$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('B'.$h, "$prueba_consignada")
							->setCellValue('D'.$h, "$n_folios");				
			}
			$borders = array(
				  'borders' => array(
					'allborders' => array(
					  'style' => PHPExcel_Style_Border::BORDER_THIN,
					  'color' => array('argb' => 'FF000000'),
					)
				  ),
				);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$h.':D'.$h)->applyFromArray($borders);				
			$h=$h+1;
		}
		
		$h=$h+1;
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('C'.$h, "Total Folios:")
			->setCellValue('D'.$h, "$summ");			
		
		$objPHPExcel->getActiveSheet()->getStyle('C'.$h)->getFont()->setBold(true);			
		$objPHPExcel->getActiveSheet()->getStyle('C'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);		
		$borders = array(
			  'borders' => array(
				'allborders' => array(
				  'style' => PHPExcel_Style_Border::BORDER_THIN,
				  'color' => array('argb' => 'FF000000'),
				)
			  ),
			);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$h.':D'.$h)->applyFromArray($borders);				
	}
$rssolicitud->cerrar();
unset($rssolicitud);

//PRUEBAS CONSIGNADAS ********************************************************************************************************

// Narración de los Presuntos Actos, Hechos u Omisiones ----------------------------------------------------------------------
if($part6==0) {
	$h=$h+2;
	$borders = array(
		  'borders' => array(
			'outline' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN,
			  'color' => array('argb' => 'FF000000'),
			)
		  ),
		);
	$objPHPExcel->getActiveSheet()->getStyle('a'.$h.':f'.$h)->applyFromArray($borders);

	$objPHPExcel->getActiveSheet()->mergeCells('a'.$h.':f'.$h);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$h, "NARRACION DE LOS PRESUNTOS ACTOS, HECHO U OMISIONES");			
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setSize(12);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getFill()->getStartColor()->setARGB('E4E4E4');		
	
	
	$h=$h+1;

	$objPHPExcel->getActiveSheet()->mergeCells('a'.$h.':f'.$h);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$h, "$relatoria_caso");
	$objPHPExcel->getActiveSheet()->getRowDimension($h)->setRowHeight(190);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);		
}
// Narración de los Presuntos Actos, Hechos u Omisiones ----------------------------------------------------------------------

// OBSERVACIONES **************************************************************************************************************
if($part7==0) {
	$h=$h+2;
	$borders = array(
		  'borders' => array(
			'outline' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN,
			  'color' => array('argb' => 'FF000000'),
			)
		  ),
		);
	$objPHPExcel->getActiveSheet()->getStyle('a'.$h.':f'.$h)->applyFromArray($borders);
	
	$objPHPExcel->getActiveSheet()->mergeCells('a'.$h.':f'.$h);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$h, "OBSERVACIONES");			
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setSize(12);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getFill()->getStartColor()->setARGB('E4E4E4');		
	
	
	$h=$h+1;
	
	$objPHPExcel->getActiveSheet()->mergeCells('a'.$h.':f'.$h);
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$h, "$observacion");
	$objPHPExcel->getActiveSheet()->getRowDimension($h)->setRowHeight(80);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);	
	$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
}
// OBSERVACIONES **************************************************************************************************************

//PIE
	
	$rssolicitud = new Recordset();
	$rssolicitud->sql = "SELECT usuario, accion FROM seg_bitacora WHERE fecha = '".$fecha_r."'";
	$rssolicitud->abrir();
	if($rssolicitud->total_registros != 0)
		{
			for($j = 0; $j < $rssolicitud->total_registros; $j++)
			{
				$rssolicitud->siguiente();
				if(strpos(base64_decode($rssolicitud->fila["accion"]),$Id)===false){
					$usu="";
				} else {
					$vall = $rssolicitud->fila["usuario"];
					break;
				}			
			
			}
		}
		$rssolicitud->cerrar();
		unset($rssolicitud);			
				
		$aaa = new Recordset();
		$aaa->sql = "SELECT CONCAT(seg_usuario.`nombres`,' ',seg_usuario.`apellidos`) as usuario FROM seg_usuario WHERE seg_usuario.`usuario`='".$vall."'";
		$aaa->abrir();
		if($aaa->total_registros != 0)
		{
			$aaa->siguiente();
			$usu = $aaa->fila["usuario"];		
		}	
		$aaa->cerrar();
		unset($aaa);

$h=$h+2;

$objPHPExcel->getActiveSheet()->mergeCells('a'.$h.':C'.$h);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$h, "Ciudadano,");			
$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	

$h=$h+3;

$objPHPExcel->getActiveSheet()->mergeCells('A'.$h.':B'.$h);
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$h, "$cedula")
			->setCellValue('D'.$h, "$nombres");
$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
$objPHPExcel->getActiveSheet()->getStyle('D'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
$h=$h+1;
$objPHPExcel->getActiveSheet()->mergeCells('A'.$h.':B'.$h);
$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':B'.$h)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('D'.$h)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('F'.$h)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$h, "Cedula")
			->setCellValue('D'.$h, "Nombre y Apellido")
			->setCellValue('F'.$h, "Firma");			
$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
$objPHPExcel->getActiveSheet()->getStyle('D'.$h)->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle('D'.$h)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
$objPHPExcel->getActiveSheet()->getStyle('F'.$h)->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle('F'.$h)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
$h=$h+1;
$objPHPExcel->getActiveSheet()->getStyle('F'.$h)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

for ($m=0;$m<5;$m++)
	{
		$h=$h+1;
		$objPHPExcel->getActiveSheet()->getStyle('F'.$h)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$h)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	}
$h=$h+1;
$objPHPExcel->getActiveSheet()->getStyle('F'.$h)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('F'.$h, "Huella");

$h=$h+2;
$objPHPExcel->getActiveSheet()->getStyle('D'.$h)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('D'.$h)->getFont()->setSize(10);
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('D'.$h, "Firma Funcionario Receptor");
$objPHPExcel->getActiveSheet()->getStyle('D'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);				
$objPHPExcel->getActiveSheet()->getStyle('D'.$h)->getFont()->setBold(true);
$h=$h+1;			
$objPHPExcel->getActiveSheet()->mergeCells('A'.$h.':D'.$h);
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$h, "Elaborado por: $usu");
$objPHPExcel->getActiveSheet()->getStyle('D'.$h)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
for ($m=1;$m<=$h;$m++)
	{
		$objPHPExcel->getActiveSheet()->getStyle('A'.$m)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$m)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	}

$objPHPExcel->getActiveSheet()->getStyle('A'.$h.':F'.$h)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//PIE

//EJECUCION
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$mecanismo.'_'.$n_expediente.'_'.date('d-m-Y').'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
//EJECUCION

?>
