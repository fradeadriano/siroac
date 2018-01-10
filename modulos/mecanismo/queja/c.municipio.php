<?
	require_once("../../../librerias/Recordset.php");
	$rsparroquia = new Recordset();
	$rsparroquia->sql = "SELECT id_municipio, municipio FROM municipio WHERE id_estado = '".stripslashes($_GET["mY_id_estado"])."' ORDER BY municipio";
	$sel = stripslashes($_GET["selec"]);
?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>																																
			<?   
				$rsparroquia->llenarcombo($opciones = "\"municipio\"", $checked = "$sel", $fukcion = "onchange=\"cargar_parroquias(this.value);cargar_id_muni(this.value);\"", $diam = "style=\"width:300px; Height:20px\""); 
				$rsparroquia->cerrar(); 
				unset($rsparroquia); 
			?>&nbsp;<span class="mensaje">*</span>		
		</td>
	</tr>
</table>