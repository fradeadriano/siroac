<?
require_once("../../../librerias/Recordset.php");
echo '<link href="css/style.css" rel="stylesheet" type="text/css" />';
$pagina = intval($_GET["pagina"]);

if($pagina == 0)
	$pagina = 1;
if(isset($_GET["b_id"]) && $_GET["b_id"]!=""){
	$idVALOR = $_GET["b_id"];
	$cond = "AND ciudadano.id_ciudadano =".$idVALOR;
}
	
$search = new Recordset();
$search->sql = "SELECT ciudadano.id_ciudadano, ciudadano.cedula, CONCAT(ciudadano.nombres,', ',ciudadano.apellidos) AS nombre, ciudadano.apellidos, ciudadano.nombres, 
					IF(ciudadano.email IS NULL,'<u>No Posee</u>',ciudadano.email) AS email, ciudadano.email as correo, ciudadano.telf_habitacion AS thabitacion, ciudadano.telf_movil AS tmovil, ciudadano.direccion, 
					IF(ciudadano.otra_direccion IS NULL, '<u>No Posee</u>',IF(ciudadano.otra_direccion<>'',ciudadano.otra_direccion,'<u>No Posee</u>')) AS otra_dir, ciudadano.otra_direccion, municipio.`id_municipio`, parroquia.`id_parroquia`, municipio.municipio, parroquia.parroquia, estado.`id_estado`, estado.`estado`  
				FROM ciudadano LEFT JOIN parroquia ON ciudadano.`id_parroquia` = parroquia.`id_parroquia`
								LEFT JOIN municipio ON parroquia.`id_municipio` = municipio.`id_municipio`
								LEFT JOIN estado ON municipio.`id_estado` = estado.`id_estado`
				WHERE ciudadano.id_ciudadano <> 1 $cond
				ORDER BY ciudadano.cedula DESC";
$search->paginar($pagina,10);
?>
<table>
	<tr class="trcabecera">
		<td width="40">C&eacute;dula</td>
		<td width="200">Ciudadano</td>												
		<td width="200">Tel&eacute;fonos</td>	
		<td width="40">M&aacute;s Informaci&oacute;n</td>														
		<td>Acci&oacute;n</td>
	</tr>
<? 
	if($search->total_registros != 0)
	{
		for($i = 1; $i <= $search->total_registros; $i++)
		{
			$search->siguiente();
			
			$onclick1 = "subir('Modificar','".$search->fila["id_ciudadano"]."', '".$search->fila["nombres"]."', '".$search->fila["apellidos"]."', '".$search->fila["cedula"]."', '".$search->fila["correo"]."', '".$search->fila["tmovil"]."', '".$search->fila["direccion"]."', '".$search->fila["otra_direccion"]."', '".$search->fila["id_parroquia"]."', '".$search->fila["id_municipio"]."', '".$search->fila["id_estado"]."', '".$search->fila["thabitacion"]."')";	
			$onclick2 = "subir('Eliminar','".$search->fila["id_ciudadano"]."', '".$search->fila["nombres"]."', '".$search->fila["apellidos"]."', '".$search->fila["cedula"]."', '".$search->fila["correo"]."', '".$search->fila["tmovil"]."', '".$search->fila["direccion"]."', '".$search->fila["otra_direccion"]."', '".$search->fila["id_parroquia"]."', '".$search->fila["id_municipio"]."', '".$search->fila["id_estado"]."', '".$search->fila["thabitacion"]."')";	

			$abc = "*<b>Direcci&oacute;n:</b> ".$search->fila["direccion"]."<br>";
			$abc = $abc."*<b>Otra Direcci&oacute;n:</b> ".$search->fila["otra_dir"]."<br>";
			$abc = $abc."*<b>Parroquia:</b> ".$search->fila["parroquia"]."<br>";			
			$abc = $abc."*<b>Municipio:</b> ".$search->fila["municipio"]."<br>";				
			$abc = $abc."*<b>Estado:</b> ".$search->fila["estado"]."<br>";							
			$abc = $abc."*<b>Email:</b> ".$search->fila["email"];			
?>
	<tr align="center" <? if($i % 2 == 0) echo " class=\"trresaltado\"" ?>>
		<td><? echo $search->fila["cedula"]; ?></td>
		<td><? echo $search->fila["nombre"]; ?></td>
		<td><? if ($search->fila["thabitacion"]=="") { echo $search->fila["tmovil"]; } else { echo $search->fila["tmovil"]." // ".$search->fila["thabitacion"]; } ?></td>
		<td>
			<a style="cursor:help">
				<img src="images/contenido.png" border="0" /><span class="tooltip" style="text-align:justify"><? echo $abc; ?></span>
			</a>
		</td>		
        <td align="center" width="80">
			<img src="images/modificar.png" style="cursor:pointer" onclick="<? echo $onclick1; ?>;" title="Modificar" />
			<img src="images/eliminar.png" style="cursor:pointer" onclick="<? echo $onclick2; ?>;" title="Eliminar" />
        </td>			
	</tr>
<?
		}
?>
    <tr>
    	<td colspan="5"><? $search->CrearPaginadorAjax("modulos/mantenimiento/ciudadano/ciudadano_d.php","images/paginador/","cargar_lista") ?></td>
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