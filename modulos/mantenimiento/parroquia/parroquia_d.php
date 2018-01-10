<?
require_once("../../../librerias/Recordset.php");
echo '<link href="css/style.css" rel="stylesheet" type="text/css" />';
$pagina = intval($_GET["pagina"]);

if($pagina == 0)
	$pagina = 1;
if(isset($_GET["b_id"]) && $_GET["b_id"]!=""){
	$idVALOR = $_GET["b_id"];
	$cond = "WHERE parroquia.`id_parroquia` =".$idVALOR;
}
	
$search = new Recordset();
$search->sql = "SELECT parroquia.`id_parroquia`, parroquia.`parroquia`, municipio.municipio, estado.`estado`, estado.`id_estado`, parroquia.`id_municipio` 
				FROM parroquia 
					INNER JOIN municipio ON (parroquia.`id_municipio` = municipio.`id_municipio`) 
					INNER JOIN estado ON (municipio.`id_estado` = estado.`id_estado`)  $cond
				ORDER BY estado.`estado` ASC";
$search->paginar($pagina,10);
?>
<table>
	<tr class="trcabecera">
		<td width="40">C&oacute;digo</td>															
		<td width="200">Parroquia</td>
		<td width="200">Municipio</td>												
		<td width="100">Estado</td>	
		<td>Acci&oacute;n</td>
	</tr>
<? 
	if($search->total_registros != 0)
	{
		for($i = 1; $i <= $search->total_registros; $i++)
		{
			$search->siguiente();
			$onclick1 = "subir('Modificar','".$search->fila["id_parroquia"]."', '".$search->fila["id_estado"]."', '".$search->fila["id_municipio"]."', '".$search->fila["parroquia"]."', '".$search->fila["municipio"]."', '".$search->fila["estado"]."')";	
			$onclick2 = "subir('Eliminar','".$search->fila["id_parroquia"]."', '".$search->fila["id_estado"]."', '".$search->fila["id_municipio"]."', '".$search->fila["parroquia"]."', '".$search->fila["municipio"]."', '".$search->fila["estado"]."')";		
?>
	<tr align="center" <? if($i % 2 == 0) echo " class=\"trresaltado\"" ?>>
		<td><? echo $search->fila["id_parroquia"]; ?></td>
		<td><? echo $search->fila["parroquia"]; ?></td>
		<td><? echo $search->fila["municipio"]; ?></td>
		<td><? echo $search->fila["estado"]; ?></td>		
        <td align="center" width="80">
			<img src="images/modificar.png" style="cursor:pointer" onclick="<? echo $onclick1; ?>;" title="Modificar" />
			<img src="images/eliminar.png" style="cursor:pointer" onclick="<? echo $onclick2; ?>;" title="Eliminar" />
        </td>			
	</tr>
<?
		}
?>
    <tr>
    	<td colspan="5"><? $search->CrearPaginadorAjax("modulos/mantenimiento/parroquia/parroquia_d.php","images/paginador/","cargar_lista") ?></td>
    </tr>
<?
	} else {
?>
    <tr>
    	<td colspan="5"><br />&iexcl;No Ex&iacute;sten Datos a Mostrar!<br />&nbsp;</td>
    </tr>
<?
	}
?>
</table>