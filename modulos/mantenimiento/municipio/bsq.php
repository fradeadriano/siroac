<?
require_once("../../../librerias/Recordset.php");
?>
<form  name="busqueda" autocomplete="off">        
<table width="90%" border="0" align="center">
	<tr>
		<td align="center">
			<fieldset class="fieldset">
			<legend class="titulomenu">B&uacute;squeda Por</legend>            
			<table class="texto" width="500"  align="center" border="0">
				<tr>
					<td align="center"> 
						Estado:
					</td>
					<td> 
						<? 
						$rses = new Recordset();
						$rses->sql = "SELECT id_estado, estado FROM estado order by estado"; 
						$rses->llenarcombo($opciones = "\"estadobsq\"", $checked = "", $fukcion = "" , $diam = "style=\"width:326px; Height:20px;\""); 
						$rses->cerrar(); 
						unset($rses);																						
						?>						
					</td>
				</tr>
				<tr><td height="10" colspan="2"></td></tr>
                <tr>
					<td colspan="2" align="center">
						<input type="button" class="botones" value="Buscar" title="Buscar" onclick="eje();" />
						&nbsp;
						<input type="button" class="botones" onclick="cancel();" name="cancelar" value="Cancelar" title="Cancelar" />
						&nbsp;
						<input type="button" class="botones" onclick="closeMessage();" id="regresar" name="regresar" value="Regresar" title="Regresar" />
						<input type="hidden" name="pagina" value="1" />
					</td>
				</tr>    
			</table>
			</fieldset>
        </td>
    </tr>
	<tr>
		<td align="center" >
			<fieldset>
			<legend class="titulomenu">&nbsp;Listado de Ciudadanos&nbsp;</legend>										
			<table width="100%" border="0">
				<tr>
					<td id="ajaxtd">&nbsp;</td>
				</tr>
			</table>
			</fieldset>										
		</td>
	</tr>    
</table>
</form>
<? echo '<script language="javascript" type="text/javascript">cargar_lista_bsq("'.'modulos/mantenimiento/municipio/bsq_list.php?pagina=1'.'");</script>'; ?>