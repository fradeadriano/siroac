<?
if(!stristr($_SERVER['SCRIPT_NAME'],"reporte_list.php")){
	$hmtl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Listado de Usuarios</title>
</head>
<body>
<form action="nprivilegio.php" name="ilegal" id="ilegal" method="post">
	<input type="hidden" name="archivo" value="'.$_SERVER['SCRIPT_NAME'].'" />
</form>
</body>
</html>
<script language="javascript" type="text/javascript">
	document.getElementById("ilegal").submit();
</script>';
	die($hmtl);
}
require_once("../../../librerias/Recordset.php");
$z = stripslashes($_GET["condiciones"]);
$rslista = new Recordset();
$where="";
$caaa = 0;
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
								$caaa = 1;
								$azxa = $desgloce[1];
						break;
						case "campo2"://fecha
							$sub_desgloce = explode("_",$desgloce[1]);
							$trib_desgloce = explode("-",$rslista->formatofecha($sub_desgloce[1]));
							if($where!="")
								{	
									$where = $where." AND registro_mecanismo.fecha_registro BETWEEN '".$rslista->formatofecha($sub_desgloce[0])."' AND '".$rslista->formatofecha($sub_desgloce[1])."'";
								
								} else {
									$where = $where." WHERE registro_mecanismo.fecha_registro BETWEEN '".$rslista->formatofecha($sub_desgloce[0])."' AND '".$rslista->formatofecha($sub_desgloce[1])."'";
								}					
							$dsdf = " AND registro_mecanismo.fecha_registro BETWEEN '".$rslista->formatofecha($sub_desgloce[0])."' AND '".$rslista->formatofecha($sub_desgloce[1])."'";
				
						
						break;
						case "campo3"://
							if($where!="")
								{
									$where = $where." AND registro_mecanismo.caso=".$desgloce[1];
								} else {
									$where = $where." WHERE registro_mecanismo.caso=".$desgloce[1];								
								}	
						break;
					}	
			}

	$rslista->sql = "SELECT IF(ISNULL(registro_mecanismo.asesoria),'0','1') AS tipo_meca, registro_mecanismo.id_mecanismo, registro_mecanismo.`n_expediente`, mecanismo.mecanismo, DATE_FORMAT(registro_mecanismo.`fecha_registro`,'%d-%m-%Y') AS fecha_registro, 
							IF(registro_mecanismo.`caso`=0,'Si','no') AS competencia , CONCAT(ciudadano.`nombres`,', ',ciudadano.`apellidos`,', CI.:',ciudadano.`cedula` ) AS ciudadano, IF(registro_mecanismo.`observacion` ='','No Posee',registro_mecanismo.`observacion`) AS observacion
						 ,  IF(registro_mecanismo.sub_tipo_mecanismo='ac','Asesoria',IF(registro_mecanismo.sub_tipo_mecanismo='djp','DJP','Datos Filiatorios')) AS tipo
					 FROM registro_mecanismo INNER JOIN mecanismo ON (registro_mecanismo.`id_mecanismo` = mecanismo.`id_mecanismo`)
											 INNER JOIN ciudadano ON (registro_mecanismo.`id_ciudadano` = ciudadano.`id_ciudadano`)						  
					 $where
					 ";
	$rslista->abrir();

	if($caaa == 1){
		if($azxa == 2){	
			if ($trib_desgloce[0]>=2017){	
				$a=1;		
				$rsdocu = new Recordset();
				$rsdocu->sql = "SELECT COUNT(registro_mecanismo.`id_registro_mecanismo`) AS total_djp
								FROM registro_mecanismo
								WHERE registro_mecanismo.`id_mecanismo` = ".$azxa." $dsdf AND sub_tipo_mecanismo = 'df' AND registro_mecanismo.`asesoria` IS NOT NULL ";
				$rsdocu->abrir();
					if($rsdocu->total_registros > 0)
						{
							$rsdocu->siguiente();
							$totall_df = $rsdocu->fila["total_djp"];									
						}
				$rsdocu->cerrar();
				unset($rsdocu);	
	
				$rsdocu0 = new Recordset();
				$rsdocu0->sql = "SELECT COUNT(registro_mecanismo.`id_registro_mecanismo`) AS total_djp
								FROM registro_mecanismo
								WHERE registro_mecanismo.`id_mecanismo` = ".$azxa." $dsdf AND sub_tipo_mecanismo = 'djp' AND registro_mecanismo.`asesoria` IS NOT NULL ";
				$rsdocu0->abrir();
					if($rsdocu0->total_registros > 0)
						{
							$rsdocu0->siguiente();
							$totall_djp = $rsdocu0->fila["total_djp"];									
						}
				$rsdocu0->cerrar();
				unset($rsdocu0);	
	
				$rsdocu1 = new Recordset();
				$rsdocu1->sql = "SELECT COUNT(registro_mecanismo.`id_registro_mecanismo`) AS total
								FROM registro_mecanismo
								WHERE registro_mecanismo.`id_mecanismo` = ".$azxa." $dsdf AND registro_mecanismo.`asesoria` IS NULL ";
				$rsdocu1->abrir();
					if($rsdocu1->total_registros > 0)
						{
							$rsdocu1->siguiente();
							$totall = $rsdocu1->fila["total"];									
						}
				$rsdocu1->cerrar();
				unset($rsdocu1);	

			} else {
				if ($trib_desgloce[1] >=10){
					$a=1;
					$rsdocu = new Recordset();
					$rsdocu->sql = "SELECT COUNT(registro_mecanismo.`id_registro_mecanismo`) AS total_djp
									FROM registro_mecanismo
									WHERE registro_mecanismo.`id_mecanismo` = ".$azxa." $dsdf AND sub_tipo_mecanismo = 'df' AND registro_mecanismo.`asesoria` IS NOT NULL ";
					$rsdocu->abrir();
						if($rsdocu->total_registros > 0)
							{
								$rsdocu->siguiente();
								$totall_df = $rsdocu->fila["total_djp"];									
							}
					$rsdocu->cerrar();
					unset($rsdocu);	
		
					$rsdocu0 = new Recordset();
					$rsdocu0->sql = "SELECT COUNT(registro_mecanismo.`id_registro_mecanismo`) AS total_djp
									FROM registro_mecanismo
									WHERE registro_mecanismo.`id_mecanismo` = ".$azxa." $dsdf AND sub_tipo_mecanismo = 'djp' AND registro_mecanismo.`asesoria` IS NOT NULL ";
					$rsdocu0->abrir();
						if($rsdocu0->total_registros > 0)
							{
								$rsdocu0->siguiente();
								$totall_djp = $rsdocu0->fila["total_djp"];									
							}
					$rsdocu0->cerrar();
					unset($rsdocu0);	
		
					$rsdocu1 = new Recordset();
					$rsdocu1->sql = "SELECT COUNT(registro_mecanismo.`id_registro_mecanismo`) AS total
									FROM registro_mecanismo
									WHERE registro_mecanismo.`id_mecanismo` = ".$azxa." $dsdf AND registro_mecanismo.`asesoria` IS NULL ";
					$rsdocu1->abrir();
						if($rsdocu1->total_registros > 0)
							{
								$rsdocu1->siguiente();
								$totall = $rsdocu1->fila["total"];									
							}
					$rsdocu1->cerrar();
					unset($rsdocu1);	
				} else {
					$a=2;
					$rsdocu = new Recordset();
					$rsdocu->sql = "SELECT COUNT(registro_mecanismo.`id_registro_mecanismo`) AS total_djp
									FROM registro_mecanismo
									WHERE registro_mecanismo.`id_mecanismo` = ".$azxa." $dsdf AND registro_mecanismo.`asesoria` IS NOT NULL ";
					$rsdocu->abrir();
						if($rsdocu->total_registros > 0)
							{
								$rsdocu->siguiente();
								$totall_df = $rsdocu->fila["total_djp"];									
							}
					$rsdocu->cerrar();
					unset($rsdocu);	
		
					$rsdocu0 = new Recordset();
					$rsdocu0->sql = "SELECT COUNT(registro_mecanismo.`id_registro_mecanismo`) AS total_djp
									FROM registro_mecanismo
									WHERE registro_mecanismo.`id_mecanismo` = ".$azxa." $dsdf AND registro_mecanismo.`asesoria` IS NOT NULL ";
					$rsdocu0->abrir();
						if($rsdocu0->total_registros > 0)
							{
								$rsdocu0->siguiente();
								$totall_djp = $rsdocu0->fila["total_djp"];									
							}
					$rsdocu0->cerrar();
					unset($rsdocu0);	
		
					$rsdocu1 = new Recordset();
					$rsdocu1->sql = "SELECT COUNT(registro_mecanismo.`id_registro_mecanismo`) AS total
									FROM registro_mecanismo
									WHERE registro_mecanismo.`id_mecanismo` = ".$azxa." $dsdf AND registro_mecanismo.`asesoria` IS NULL ";
					$rsdocu1->abrir();
						if($rsdocu1->total_registros > 0)
							{
								$rsdocu1->siguiente();
								$totall = $rsdocu1->fila["total"];									
							}
					$rsdocu1->cerrar();
					unset($rsdocu1);					
				}
			}

		}
	}
?>

<table border="0" class="b_table1" align="center" width="100%" cellpadding="1" cellspacing="1">	
	<tr  height="20">
		<td align="right" colspan="10">
			<table border="0" >
				<tr align="center">
					<td>
						<b>Exportar a</b>&nbsp;
					</td>
					<td align="center">
						<img src="images/excel.png" title="Exportar a Excel" onclick="exprt();" style="cursor:pointer" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					</td>
					<td>
						<b>Total Mecanismos:</b>&nbsp;<? echo "<span class='mensaje'>".$rslista->total_registros."</span>"; ?>
					</td>
				</tr>
				<? 
				if($azxa ==2){
					if($a==1){
				?>
				<tr><td colspan="3" height="2"></td></tr>				
				<tr bgcolor="#EFEFEF">
					<td>
						<b>Peticiones:</b>&nbsp;
					</td>
					<td align="center" colspan="2">
						<b>DJP:</b>&nbsp;<? echo "<span class='mensaje'>".$totall_djp."</span>"; ?>
						&nbsp;&nbsp;&nbsp;
						<b>Datos Filiatorios:</b>&nbsp;<? echo "<span class='mensaje'>".$totall_df."</span>"; ?>
						&nbsp;&nbsp;&nbsp;
						<b>Asesor&iacute;as:</b>&nbsp;<? echo "<span class='mensaje'>".$totall."</span>"; ?>
					</td>				
				</tr>
				<?
					} else {
				?>
				<tr><td colspan="3" height="2"></td></tr>				
				<tr bgcolor="#EFEFEF">
					<td>
						<b>Peticiones:</b>&nbsp;
					</td>
					<td align="center" colspan="2">
						<b>DJP:</b>&nbsp;<? echo "<span class='mensaje'>".$totall_djp."</span>"; ?>
						&nbsp;&nbsp;&nbsp;
						<b>Asesor&iacute;as:</b>&nbsp;<? echo "<span class='mensaje'>".$totall."</span>"; ?>
					</td>				
				</tr>				
				<?	
					}
				} 
				?>			
			</table>							
		</td>
	</tr>
	<tr height="30" valign="middle" class="trcabecera_list2">
		<td width="50">
			N&deg; Expediente
		</td>
		<td width="70">
			Mecanismo
		</td>
		<td width="70">
			Ciudadano
		</td>
		<td width="70">
			Competencia
		</td>		
		<td width="90">
			Fecha Registro
		</td>
		<td width="90">
			Observaci&oacute;n
		</td>		
	</tr>
	<tr><td colspan="4"></td></tr>
<?
	if($rslista->total_registros > 0)
		{	
			for ($i=1;$i<=$rslista->total_registros;$i++)
			{
				$rslista->siguiente();
?>				
	<tr <? if($i % 2 == 0) echo " class=\"trresaltado\"" ?> align="center">
		<td>
			<? echo $rslista->fila["n_expediente"]; ?>
		</td>
		<td>
			<? 
				if($rslista->fila["id_mecanismo"]!=2) { 
					echo $rslista->fila["mecanismo"]; } 
				else if ($rslista->fila["id_mecanismo"]==2) 
					{  					
						echo $rslista->fila["mecanismo"]." - <b>".$rslista->fila["tipo"]."</b>"; 
					}
			
			
			?>
		</td>
		<td>
			<? echo $rslista->fila["ciudadano"]; ?>
		</td>		
		<td>
			<? echo $rslista->fila["competencia"]; ?>
		</td>
		<td>
			<? echo $rslista->fila["fecha_registro"]; ?>
		</td>
		<td title="<? echo $rslista->fila["observacion"]; ?>">
			<? echo substr($rslista->fila["observacion"],0,30);?>
		</td>		
	</tr>
<?	
			}
?>
	<tr><td height="11" colspan="11"></td></tr>		    
<?
		} else {
?>	
	<tr class="trresaltado">
		<td colspan="11">
			No Ex&iacute;sten Datos a Mostrar!!
		</td>																					
	</tr>
<?
		}
?>	
</table>		
<form action="" method="post" name="rep" id="rep">
	<input type="hidden" name="condiciones" id="condiciones" value="<? echo stripslashes($_GET["condiciones"]); ?>" />
</form>	
<?
} else {
?>
<table border="0" align="center" width="100%" cellpadding="1" cellspacing="1">	
	<tr align="center">
		<td >
			No Ex&iacute;sten Datos a Mostrar!!
		</td>																					
	</tr>
</table>	
<?
}
?>														