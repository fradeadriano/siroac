<?
	session_start();
	require_once("../../../librerias/Recordset.php");
	require_once("../../../librerias/bitacora.php");
	if(isset($_GET["accion"]))
	{
		switch($_GET["accion"])
		{
			case "Registrar":
				$rssolicitud = new Recordset();
				$nombres = $rssolicitud->codificar($_GET["nombres"]);
				$apellidos = $rssolicitud->codificar($_GET["apellidos"]);					
				$cedula = stripslashes($_GET["cedula"]);
				$tmovil = stripslashes($_GET["tmovil"]);					
				$direccion = $rssolicitud->codificar($_GET["direccion"]);
				//$id_parroquia = stripslashes($_GET["id_parroquia"]);										
				
				if (isset($_GET["thabitacion"]) && stripslashes($_GET["thabitacion"])!= "") 
				{
					$campo_odireccion = ", telf_habitacion"; 
					$odireccion = ", '".stripslashes($_GET["thabitacion"])."'"; 
				}	
								
				if (isset($_GET["odireccion"]) && stripslashes($_GET["odireccion"])!= "") {
					if($campo_odireccion !=""){
						$campo_odireccion = $campo_odireccion.", otra_direccion"; 
						$odireccion = $odireccion.", '".stripslashes($_GET["odireccion"])."'";
					} else {
						$campo_odireccion = ", otra_direccion"; 
						$odireccion = ", '".stripslashes($_GET["odireccion"])."'";
					}									
				}					

				if (isset($_GET["email"]) && stripslashes($_GET["email"])!= "") {
					if($campo_odireccion !=""){
						$campo_odireccion = $campo_odireccion.", email"; 
						$odireccion = $odireccion.", '".stripslashes($_GET["email"])."'";
					} else {
						$campo_odireccion = ", email"; 
						$odireccion = ", '".stripslashes($_GET["email"])."'";
					}									
				}										

				if (isset($_GET["id_parroquia"]) && stripslashes($_GET["id_parroquia"])!= "") {							
					if($campo_odireccion !=""){
						$campo_odireccion = $campo_odireccion.", id_parroquia"; 
						$odireccion = $odireccion.", '".stripslashes($_GET["id_parroquia"])."'"; 						
					} else {
						$campo_odireccion = ", id_parroquia"; 
						$odireccion = ", '".stripslashes($_GET["id_parroquia"])."'"; 						
					}					
					
				} else if(isset($_GET["municipio"]) && stripslashes($_GET["municipio"])!= "") {
					
					if($campo_odireccion !=""){
						$campo_odireccion = $campo_odireccion.", id_municipio"; 
						$odireccion = $odireccion.", '".stripslashes($_GET["municipio"])."'"; 						
					} else {
						$campo_odireccion = ", id_municipio"; 
						$odireccion = ", '".stripslashes($_GET["municipio"])."'"; 						
					}					
				}

				
				$search = new Recordset();
				$search->sql = "SELECT id_ciudadano, concat(nombres,', ',apellidos) as nombress, cedula, CONCAT(ciudadano.telf_habitacion,' / ',ciudadano.telf_movil) AS telefono, ciudadano.direccion FROM ciudadano WHERE cedula = '".$cedula."'";
					$search->abrir();
					$search->siguiente();
					if($search->total_registros == 0)
					{
						$ins = new Recordset();
						$ins->sql = "INSERT INTO ciudadano(cedula, nombres, apellidos, telf_movil, direccion $campo_odireccion )
										VALUES ('".$cedula."', '".$nombres."', '".$apellidos."', '".$tmovil."', '".$direccion."' $odireccion )";
						$ins->abrir();
						$ins->cerrar();
						unset($ins);	
						$mensaje = 1;
						/*bitacora*/ 
							$descrp_bitacora="C&eacute;dula: ".$cedula.", Nombre y Apellido: ".$nombres.", ".$apellidos.", Tel&eacute;fonos: ".$thabitacion.", ".$tmovi.", Direcci&oacute;n: ".$direccion.", Parroquia_n: ".$id_parroquia.", Otra Direcci&oacute;n: ".$odireccion.", Email: ".stripslashes($_GET["email"]);
							bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Ciudadanos","Se registro un iudadano con los siguientes datos: '".$descrp_bitacora."'.");
						/*bitacora*/ 
						
						$k = new Recordset();
						$k->sql = "SELECT id_ciudadano, concat(nombres,', ',apellidos) as nombress, cedula, IF(ISNULL(ciudadano.telf_habitacion),ciudadano.telf_movil,CONCAT(ciudadano.telf_movil,' / ',ciudadano.telf_habitacion)) AS telefono, ciudadano.direccion FROM ciudadano WHERE cedula = '".$cedula."'";
						$k->abrir();
						$k->siguiente();
					} else {
						echo '<script language="javascript" type="text/javascript">alert("El Ciudadano ya se encuentra registrado")</script>';
					}
			break;
		}
	}
if ($mensaje==1){
?>
<script language="javascript" type="text/javascript">
function devolver_valores(id,nom,ced,tele,dire)
{
	window.top.document.getElementById("id_ciudadano").value = id;
	window.top.document.getElementById("cedula_ciu").value = ced;
	window.top.document.getElementById("nombre_ciu").value = nom;
	window.top.document.getElementById("telefonos_ciu").value = tele;
	window.top.document.getElementById("direccion_ciu").value = dire;
	window.top.closeMessage();	
}
	devolver_valores('<? echo $k->fila["id_ciudadano"]; ?>', '<? echo $rssolicitud->decodificar($k->fila["nombress"]); ?>', '<? echo $k->fila["cedula"]; ?>', '<? echo $k->fila["telefono"]; ?>', '<? echo $rssolicitud->decodificar($k->fila["direccion"]); ?>');
</script>						
<? } ?>