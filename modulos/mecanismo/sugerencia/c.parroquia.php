<?
	require_once("../../../librerias/Recordset.php");
	$rsparroquia = new Recordset();
	$rsparroquia->sql = "SELECT id_parroquia, parroquia FROM parroquia WHERE id_municipio = '".stripslashes($_GET["mY_id_municipio"])."' ORDER BY parroquia";
	$sel = stripslashes($_GET["selec"]);
?>
<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>																																
			<?   
				$rsparroquia->llenarcombo($opciones = "\"parroquia\"", $checked = "$sel", $fukcion = "onchange=\"parroquia_cargada(this.value)\"", $diam = "style=\"width:300px; Height:20px\""); 
				$rsparroquia->cerrar(); 
				unset($rsparroquia); 
			?>		
		</td>
	</tr>
</table>