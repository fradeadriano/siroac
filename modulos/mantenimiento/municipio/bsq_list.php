<?
$pagina = intval($_GET["pagina"]);
require_once("../../../librerias/Recordset.php");

if($pagina == 0)
	$pagina = 1;
	
	if(isset($_GET["pa1"]) && $_GET["pa1"]!="")
	$cond = "WHERE municipio.id_estado =".$_GET["pa1"];
	
$rsli = new Recordset();
$rsli->sql = "SELECT municipio.`id_municipio`, municipio.`municipio`, estado.`estado`, municipio.`id_estado` FROM estado INNER JOIN municipio ON (estado.`id_estado`=municipio.`id_estado`) 
				$cond ORDER BY municipio.id_estado ASC"; 

$rsli->paginar($pagina,10);
?>
<table align="center" width="100%" border="0">
	<tr class="trcabecera">
		<td width="40">C&oacute;digo</td>
		<td width="100">Estado</td>														
		<td width="200">Municipio</td>												
		<td width="50">Acci&oacute;n</td>
    </tr>
<?
if($rsli->total_registros > 0){
	for($i = 1; $i <= $rsli->total_registros; $i++){
		$rsli->siguiente();
		$onclick = "devolver('".$rsli->fila["id_municipio"]."')";
		$condi = "&pa1=".$_GET["pa1"];			
?>
    <tr<? if($i % 2 == 0) echo " class=\"trresaltado\"" ?>>
    	<td align="center"><? echo $rsli->fila["id_municipio"];?></td>
        <td align="center"><? echo $rsli->fila["estado"];?></td>
        <td align="center"><? echo $rsli->fila["municipio"];?></td>
        <td align="center">
			<img src="images/seleccionar.png" style="cursor:pointer" onclick="<? echo $onclick; ?>;" title="Seleccionar" />&nbsp;&nbsp;
		</td>
    </tr>
<?
	}
?>
    <tr>
    	<td colspan="4"><? $rsli->CrearPaginadorAjax("modulos/mantenimiento/municipio/bsq_list.php","images/paginador/","cargar_lista_bsq",$condi) ?></td>
    </tr>
<?
	unset($rsli);
}else{
?>
	<tr>
        <td colspan="4" class="titulomenu" align="center"><br />&iexcl;No Ex&iacute;sten Datos a Mostrar!<br />&nbsp;</td>
    </tr>
<?
}
?>
</table>