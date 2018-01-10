<?
if(!stristr($_SERVER['SCRIPT_NAME'],"index.php")){
	$hmtl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
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
require_once("librerias/Recordset.php");
require_once("lay.php");

?>
<script type="text/javascript" src="librerias/jq.js"></script>
<table border="0" align="center" width="900">	
	<tr>
		<td align="right">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="45px"><img src="images/mecanismo.png"/></td>
					<td class="titulomenu" valign="middle">Listado de Mecanismos</td>
				</tr>
				<tr>
					<td colspan="2" ><hr class="pintar_linea" /></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="center">
		<form action="" name="FormPla" id="FormPla" method="post">
			<fieldset style="width:98%; border-color:#EFEFEF"> 
			<legend class="titulomenu">Filtrado Mecanismos</legend>
			<table border="0" class="b_table_b"  cellpadding="2" cellspacing="0" id="contenedor_rept">
				<tr>
					<td valign="bottom"  align="right" width="132">
						Mecanismos:&nbsp;
					</td>
					<td>
						<? 
						$rses = new Recordset();
						$rses->sql = "SELECT id_mecanismo, mecanismo FROM mecanismo order by mecanismo"; 
						$rses->llenarcombo($opciones = "\"mecanismo\"", $checked = "", $fukcion = "" , $diam = "style=\"width:100px; Height:20px;\""); 
						$rses->cerrar(); 
						unset($rsun);																						
						?>								
					</td>
					<td width="10"></td>								
					<td valign="bottom" align="right">
						Fecha Registro Entre:&nbsp; 
					</td>		
					<td valign="bottom" colspan="5">
						<input type="text" name="desde" id="desde" style="width:70px" onkeyup="this.value=formateafecha(this.value);" />&nbsp;y&nbsp;
						<input type="text" name="hasta" id="hasta" onkeyup="this.value=formateafecha(this.value);" style="width:70px"/>
						&nbsp;<span style="font-size:9px">ejmp.(dd/mm/yyyy)</span>
					</td>					
					<td width="10"></td>							
				</tr>
				<tr><td height="10" colspan="6" ></td></tr>																
				<tr>
					<td valign="bottom" align="right">
						Con Competencia:&nbsp;
					</td>
					<td>
						<select name="competencia"  id="competencia">
							<option selected="selected"></option>
							<option id="0" value="0">Si</option>
							<option id="1" value="1">No</option>
						</select>								
					</td>
				</tr>
				<tr><td height="10" colspan="6" ></td></tr>
				<tr><td height="20" class="mensaje" align="right" colspan="6" valign="bottom">Solo los Campos de Fecha son Obligatorios</td></tr>				
				<tr><td height="10" colspan="6" ></td></tr>																														
				<tr>

					<td colspan="6" align="center">
						<input type="button" name="btnFiltra" id="btnFiltra" value="Filtrar" title="Filtrar" onclick="doit();" />
						&nbsp;&nbsp;
						<input type="reset" name="btnCancelar" id="btnCancelar" value="Cancelar" title="Cancelar" onclick="limp();"  />								
					</td>								
				</tr>														
			</table>
			</fieldset>
		</form>
		</td>
	</tr>
	<tr>
		<td id="zone" align="center">
			No Existen Datos a Mostrar!!
		</td>
	</tr>	
</table>