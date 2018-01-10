<?
require_once("../../../librerias/Recordset.php");
echo '<link href="css/style.css" rel="stylesheet" type="text/css" />';
$pagina = intval($_GET["pagina"]);

if($pagina == 0)
	$pagina = 1;
if(isset($_GET["b_id"]) && $_GET["b_id"]!=""){
	$idVALOR = $_GET["b_id"];
	$cond = " WHERE municipio.`id_municipio` =".$idVALOR;
}
	
$search = new Recordset();
$search->sql = "SELECT municipio.`id_municipio`, municipio.`municipio`, estado.`estado`, municipio.`id_estado` FROM estado INNER JOIN municipio ON (estado.`id_estado`=municipio.`id_estado`) 
				$cond
				ORDER BY municipio.`id_estado` ASC";
$search->paginar($pagina,10);
?>
<table border="0">
	<tr class="trcabecera">
		<td width="40">C&oacute;digo</td>
		<td width="100">Estado</td>														
		<td width="300">Municipio</td>												
		<td>Acci&oacute;n</td>
	</tr>
<? 
	if($search->total_registros != 0)
	{
		for($i = 1; $i <= $search->total_registros; $i++)
		{
			$search->siguiente();
			
			$onclick1 = "subir('Modificar','".$search->fila["id_municipio"]."', '".$search->fila["municipio"]."', '".$search->fila["estado"]."', '".$search->fila["id_estado"]."')";	
			$onclick2 = "subir('Eliminar','".$search->fila["id_municipio"]."', '".$search->fila["municipio"]."', '".$search->fila["estado"]."', '".$search->fila["id_estado"]."')";	
?>
	<tr align="center" <? if($i % 2 == 0) echo " class=\"trresaltado\"" ?>>
		<td><? echo $search->fila["id_municipio"]; ?></td>
		<td><? echo $search->fila["estado"]; ?></td>
		<td><? echo $search->fila["municipio"]; ?></td>		
        <td align="center" width="80">
			<img src="images/modificar.png" style="cursor:pointer" onclick="<? echo $onclick1; ?>;" title="Modificar" />
			<img src="images/eliminar.png" style="cursor:pointer" onclick="<? echo $onclick2; ?>;" title="Eliminar" />
        </td>			
	</tr>
<?
		}
?>
    <tr>
    	<td colspan="5"><? $search->CrearPaginadorAjax("modulos/mantenimiento/municipio/municipio_d.php","images/paginador/","cargar_lista") ?></td>
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