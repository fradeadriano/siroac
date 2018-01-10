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
//$conjunto = stripslashes($_GET["condiciones"])
$rslista = new Recordset();
$where="";
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
						break;
						case "campo2"://fecha
							$sub_desgloce = explode("_",$desgloce[1]);
							if($where!="")
								{	
									$where = $where." AND registro_mecanismo.fecha_registro BETWEEN '".$rslista->formatofecha($sub_desgloce[0])."' AND '".$rslista->formatofecha($sub_desgloce[1])."'";
								} else {
									$where = $where." WHERE registro_mecanismo.fecha_registro BETWEEN '".$rslista->formatofecha($sub_desgloce[0])."' AND '".$rslista->formatofecha($sub_desgloce[1])."'";
								}
		
						break;
						case "campo3"://
							if($where!="")
								{
									$where = $where." AND registro_mecanismo.id_ciudadano=".$desgloce[1];
								} else {
									$where = $where." WHERE registro_mecanismo.id_ciudadano=".$desgloce[1];								
								}	
						break;
						case "campo4"://
							if($where!="")
								{
									$where = $where." AND registro_mecanismo.id_registro_mecanismo=".$desgloce[1];
								} else {
									$where = $where." WHERE registro_mecanismo.id_registro_mecanismo=".$desgloce[1];								
								}	
						break;						
						
					}	
			}
	

	$rslista->sql = "SELECT IF(ISNULL(registro_mecanismo.asesoria),'0','1') AS tipo_meca, registro_mecanismo.id_mecanismo, registro_mecanismo.asesoria, registro_mecanismo.id_registro_mecanismo, registro_mecanismo.`n_expediente`, mecanismo.mecanismo, DATE_FORMAT(registro_mecanismo.`fecha_registro`,'%d-%m-%Y') AS fecha_registro, 
							IF(registro_mecanismo.`caso`=0,'Si','no') AS competencia , CONCAT(ciudadano.`nombres`,', ',ciudadano.`apellidos`) AS ciudadano, IF(registro_mecanismo.`observacion` ='','No Posee',registro_mecanismo.`observacion`) AS observacion
					 ,  IF(registro_mecanismo.sub_tipo_mecanismo='ac','Asesoria',IF(registro_mecanismo.sub_tipo_mecanismo='djp','DJP','Datos Filiatorios')) AS tipo, registro_mecanismo.sub_tipo_mecanismo
					 FROM registro_mecanismo INNER JOIN mecanismo ON (registro_mecanismo.`id_mecanismo` = mecanismo.`id_mecanismo`)
											 INNER JOIN ciudadano ON (registro_mecanismo.`id_ciudadano` = ciudadano.`id_ciudadano`)						  
					 $where
					 ";
	$rslista->abrir();

?>

<table border="0" class="b_table1" align="center" width="100%" cellpadding="1" cellspacing="1">	
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
		<td width="20">
			Acci&oacute;n
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
		<td title="<? echo $rslista->decodificar($rslista->fila["observacion"]); ?>">
			<? echo substr($rslista->decodificar($rslista->fila["observacion"]),0,35);?>
		</td>
		<td>
			
			<? if (is_null($rslista->fila["sub_tipo_mecanismo"]) == true) {
			?>
				<img src="images/oficio.png" title="Reimprimir Mecanismo" onclick="graphi_s('<? echo $rslista->fila["id_registro_mecanismo"]; ?>','0');" style="cursor:pointer" />
			<? } else { ?>
				<img src="images/oficio.png" title="Reimprimir Mecanismo" onclick="graphi_s('<? echo $rslista->fila["id_registro_mecanismo"]; ?>','1');" style="cursor:pointer" />				
			<? } ?>				

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
<form action="" method="post" name="gra" id="gra">
	<input type="hidden" name="condiciones" id="condiciones" />
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
															