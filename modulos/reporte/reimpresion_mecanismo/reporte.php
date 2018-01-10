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
<script type="text/javascript" src="librerias/jquery.autocomplete.js"></script>
<table border="0" align="center" width="900">	
	<tr>
		<td align="right">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="45px"><img src="images/mecanismo.png"/></td>
					<td class="titulomenu" valign="middle">Reimpresi&oacute;n de Mecanismo</td>
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
			<legend class="titulomenu">B&uacute;squeda</legend>
			<table border="0" class="b_table_b"  cellpadding="2" cellspacing="0" id="contenedor_rept">
				<tr>
					<td valign="bottom"  align="right" width="132">
						Mecanismos:
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
					<td valign="bottom">
						<input type="text" name="desde" id="desde" style="width:70px" onkeyup="this.value=formateafecha(this.value);" />&nbsp;y&nbsp;
						<input type="text" name="hasta" id="hasta" onkeyup="this.value=formateafecha(this.value);" style="width:70px"/>
						&nbsp;<span style="font-size:9px">ejmp.(dd/mm/yyyy)</span>
					</td>																			
				</tr>
				<tr><td height="10" colspan="5" ></td></tr>																
				<tr>
					<td valign="bottom"  align="right" width="132">
						Nombre, Apellido &oacute; C&eacute;dula del Ciudadano:
					</td>
					<td colspan="3">
						<textarea name="ciudadano" id="ciudadano" style="width:200px; height:35px;" ></textarea>											
						<input type="hidden" name="id_ciudadano" id="id_ciudadano"  />							
					</td>
					<td valign="bottom">
						N&deg; Expediente:&nbsp;
						<textarea name="expediente" id="expediente" style="width:190px; height:35px;" ></textarea>											
						<input type="hidden" name="id_registro_mecanismo" id="id_registro_mecanismo"  />
					</td>				
				</tr>
				<tr><td height="10" colspan="5" ></td></tr>
				<tr><td height="20" class="mensaje" align="right" colspan="6" valign="bottom">Solo los Campos de Fecha son Obligatorios</td></tr>				
				<tr><td height="10" colspan="6" ></td></tr>																														
				<tr>

					<td colspan="6" align="center">
						<input type="button" name="btnFiltra" id="btnFiltra" value="Filtrar" title="Filtrar" onclick="doit();" />
						&nbsp;&nbsp;
						<input type="reset" name="btnCancelar" id="btnCancelar" value="Cancelar" title="Cancelar" onclick="limp();" />								
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
<script language="javascript" type="text/javascript">
	$("#ciudadano").autocomplete("modulos/reporte/reimpresion_mecanismo/lista.php", { 
		width: 204,
		matchContains: true,
		mustMatch: false,
		minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		//selectFirst: false
	});

	$("#ciudadano").result(function(event, data, formatted) {
		try {
			$("#id_ciudadano").val(data[1]);
		} catch(e) {
			e.name;		
		}
	});
	
	$("#expediente").autocomplete("modulos/reporte/reimpresion_mecanismo/lista_expe.php", { 
		width: 193,
		matchContains: true,
		mustMatch: false,
		minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		//selectFirst: false
	});

	$("#expediente").result(function(event, data, formatted) {
		try {
			$("#id_registro_mecanismo").val(data[1]);
		} catch(e) {
			e.name;		
		}
	});	
</script>