<?
$pagina = intval($_GET["pagina"]);
require_once("../../../../librerias/Recordset.php");

if($pagina == 0)
	$pagina = 1;
	
	if(isset($_GET["pa2"]) && $_GET["pa2"]=="cedula")
	$cond = " AND  ciudadano.cedula = '".$_GET["pa1"]."'";
if(isset($_GET["pa2"]) && $_GET["pa2"]=="apellido")
	$cond = " AND  ciudadano.apellidos LIKE '%".$_GET["pa1"]."%'";
if(isset($_GET["pa2"]) && $_GET["pa2"]=="nombre")
	$cond = " AND  ciudadano.nombres LIKE '%".$_GET["pa1"]."%'";
	
$rsli = new Recordset();
$rsli->sql = "SELECT ciudadano.id_ciudadano, ciudadano.cedula, CONCAT(ciudadano.nombres,', ',ciudadano.apellidos) AS nombres, 
					IF(ISNULL(ciudadano.telf_habitacion), ciudadano.telf_movil, CONCAT(ciudadano.telf_habitacion,' / ',ciudadano.telf_movil)) AS telefono, ciudadano.direccion 
				FROM ciudadano 
					  LEFT JOIN parroquia ON (ciudadano.`id_parroquia` = parroquia.`id_parroquia`)    
					  LEFT JOIN municipio ON (parroquia.`id_municipio` = municipio.`id_municipio`) 
					  LEFT JOIN estado ON (municipio.`id_estado` = estado.`id_estado`) 
  				WHERE ciudadano.id_ciudadano <> 1 $cond ORDER BY ciudadano.cedula DESC"; 

$rsli->paginar($pagina,8);
?>
<table align="center" width="100%" border="0">
	<tr class="trcabecera">
		<td width="40">C&eacute;dula</td>
		<td width="200">Ciudadano</td>												
		<td width="200">Tel&eacute;fonos</td>	
        <td width="70">Acci&oacute;n</td>
    </tr>
<?
if($rsli->total_registros > 0){
	for($i = 1; $i <= $rsli->total_registros; $i++){
		$rsli->siguiente();
		$onclick = "devolver('".$rsli->fila["id_ciudadano"]."', '".$rsli->fila["cedula"]."', '".$rsli->fila["nombres"]."', '".$rsli->fila["telefono"]."', '".$rsli->fila["direccion"]."')";
		$condi = "&pa2=".$_GET["pa2"]."&pa1=".$_GET["pa1"];			
?>
    <tr<? if($i % 2 == 0) echo " class=\"trresaltado\"" ?>>
    	<td align="center"><? echo $rsli->fila["cedula"];?></td>
        <td align="center"><? echo $rsli->fila["nombres"];?></td>
        <td align="center"><? echo $rsli->fila["telefono"];?></td>
        <td align="center">
			<img src="images/seleccionar.png" style="cursor:pointer" onclick="<? echo $onclick; ?>;" title="Seleccionar" />&nbsp;&nbsp;
		</td>
    </tr>
<?
	}
?>
    <tr>
    	<td colspan="4"><? $rsli->CrearPaginadorAjax("modulos/mecanismo/peticion/caso/bsq_list.php","images/paginador/","cargar_lista_bsq",$condi) ?></td>
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
<script language="javascript" type="text/javascript">
if(!document.getElementById("divcontenedor")){
	var formu = document.createElement("form");
	formu.action = "../../sprivelegio.php";
	formu.method = "post";
	
	var oculto = document.createElement("input");
	oculto.type = "hidden";
	oculto.name = "archivo";
	oculto.value = "<? echo $_SERVER['SCRIPT_NAME']; ?>";
	
	formu.appendChild(oculto);
	document.appendChild(formu);
	formu.submit();
}
</script>