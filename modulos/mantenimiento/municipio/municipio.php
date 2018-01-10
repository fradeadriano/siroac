<?
if(!stristr($_SERVER['SCRIPT_NAME'],"index.php")){
	$hmtl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ciudadanos</title>
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
require_once("librerias/bitacora.php");
require("lay.php");

if (!isset($_SESSION["spam"]))
    $_SESSION["spam"] = rand(1, 99999999);
	if ((isset($_POST["spam"]) && isset($_SESSION["spam"])) && $_POST["spam"] == $_SESSION["spam"]) 
		{
			$var_accion = stripslashes($_POST["accion"]);
			
			if(isset($_POST["accion"]))
			{
				switch($_POST["accion"])
				{
					case "Registrar":
						$municipio = stripslashes($_POST["municipio"]);
						$estado = stripslashes($_POST["estado"]);
						
						$search = new Recordset();
						$search->sql = "SELECT * FROM municipio WHERE municipio = '".$search->decodificar($municipio)."'";
							$search->abrir();
							if($search->total_registros == 0)
							{
								$ins = new Recordset();
								$ins->sql = "INSERT INTO municipio(id_estado, municipio)
												VALUES ('".$estado."', '".$municipio."')";
								$ins->abrir();
								$ins->cerrar();
								unset($ins);		
								/*bitacora*/ 
									$descrp_bitacora=": ".$municipio." en el siguiente estado: ".$estado;
									bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Municipio","Registro de Municipio: '".$descrp_bitacora."'.");
								/*bitacora*/ 
								$mensaje = 1;															
							} else {
								$mensaje = 2;
							}
					break;
					case "Modificar":
						if (isset($_POST["id_municipio"]) && $_POST["id_municipio"]!=""){
							$rsagregar1 = new Recordset();
							$rsagregar1->sql = "SELECT id_municipio, id_estado FROM municipio WHERE id_municipio = '".$_POST["id_municipio"]."'";
							$rsagregar1->abrir();
							if($rsagregar1->total_registros != 0)
							{
								$rsagregar1->siguiente();
								$change = 1;
								$consul = "";
								
								if (strcasecmp($rsagregar1->fila["municipio"],stripslashes($_POST["municipio"])) != 0)
									{
										$change = 0;
										$consul = "municipio = '".trim(stripslashes($_POST["municipio"]))."'";
										$bi = "municipio=".stripslashes($_POST["municipio"]).", ";
									}

								if ($rsagregar1->fila["estado"] != stripslashes($_POST["estado"]))
									{
										$change = 0;
										if ($consul!=""){
											$consul = $consul . ", id_estado = '".trim(stripslashes($_POST["estado"]))."'";
										} else { 
											$consul = "id_estado = '".trim(stripslashes($_POST["estado"]))."'";
										}																
										$bi = "id_estado=".stripslashes($_POST["estado"]).", ";
									}

								if ($change == 0)
									{								
										$rsagregar2 = new Recordset();
										$rsagregar2->sql = "UPDATE municipio SET $consul WHERE (id_municipio = ".$_POST["id_municipio"].");";
										$rsagregar2->abrir();
										$mensaje = 4;
										bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Modificaci&oacute;n del Municipio", "Se modific&oacute; el Municipio identificado n&uacute;mero: &ldquo;(".stripslashes($_POST["id_municipio"]).")&rdquo; Los datos modificados fueron: $bi");
										$rsagregar2->cerrar();
										unset($rsagregar2);
									} else {
										$mensaje = 5;
									}	
							} else {
								$mensaje = 3;
							}
							$rsagregar1->cerrar();
							unset($rsagregar1);
						} else {
								$mensaje = 5;
						}
					break;

					case "Eliminar":
						if (isset($_POST["id_municipio"]) && stripslashes($_POST["id_municipio"])!="")
						{					
							$rsverif= new Recordset();
							$rsverif->sql = "SELECT id_municipio FROM parroquia WHERE id_municipio = '".stripslashes($_POST["id_municipio"])."'";
							$rsverif->abrir();
							if($rsverif->total_registros == 0){
								$rsinsert= new Recordset();
								$rsinsert->sql = "DELETE FROM municipio WHERE id_municipio = '".stripslashes($_POST["id_municipio"])."'";
								$rsinsert->abrir();
								bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Eliminaci&oacute;n del Municipio", "Se elimin&oacute; el Municipio &rdquo;".stripslashes($_POST["id_municipio"])."&bdquo;");
								$mensaje = "6";
							}else{
								$mensaje = "7";
							}
						} else {
							$mensaje = "8";
						}
					break;
				}
			}
			$_SESSION["spam"] = rand(1, 99999999);
		} else {
			$_SESSION["spam"] = rand(1, 99999999);
		}


?>

<table border="0" align="center" width="700">
	<tr>
		<td>
			<table width="99%" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="45px"><img src="images/municipio.png"/></td>
					<td class="titulomenu" valign="middle">Registro Municipio</td>
				</tr>
				<tr>
					<td colspan="2"><hr class="pintar_linea" /></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table align="center" width="100%" border="0">
				<tr>
					<td>
						<fieldset>
						<legend class="titulomenu">&nbsp;Datos del Municipio</legend>
							<form action="" method="post" name="form_mun" id="form_mun" autocomplete="off">
							<input type="hidden"  name="spam" value="<? echo $_SESSION["spam"]; ?>"/>
							<input type="hidden" name="elegido" id="elegido" value="<? echo $_POST["elegido"]; ?>" />
							<table align="center" width="80%"  border="0" cellspacing="0"  cellpadding="5">			
								<tr>
									<td colspan="2" align="center" height="30px">
										<input type="hidden" name="ms" id="ms" value="<? echo $mensaje; ?>"/>
										<div id="mensa"  name="mensa" class="escuela" style="width:100%;float:center; font-size:12px;font-weight:bold;"></div>                                    
									</td>
								</tr>								
                                <tr >
                                    <td align="right" height="20" width="120">
										Estado:                                  
                                    </td>
									<td>
										<? 
										$rses = new Recordset();
										$rses->sql = "SELECT id_estado, estado FROM estado order by estado"; 
										$rses->llenarcombo($opciones = "\"estado\"", $checked = "", $fukcion = "" , $diam = "style=\"width:326px; Height:20px;\""); 
										$rses->cerrar(); 
										unset($rses);																						
										?>&nbsp;<span class="mensaje">*</span>
									</td>
                                </tr>
								<tr>
									<td align="right" height="20" width="120">
										Municipio:
									</td>
									<td>
										<input type="text" name="municipio" id="municipio" style="width:320px" onkeypress="return validar(event,letras+'ñ')" >&nbsp;<span class="mensaje">*</span>
									</td>
								</tr>
								<tr><td height="5" colspan="5"></td></tr>								
								<tr>
									<td align="center" colspan="5">
										<input type="hidden" name="id_municipio" id="id_municipio">
										<input type="hidden" name="accion" id="accion" />
										<input type="button" name="registrar" id="registrar" value="Registrar" title="Registrar" onclick="subb();" />
										&nbsp;
										<input type="reset" name="cancelar" id="cancelar" value="Cancelar" title="Cancelar" onclick="cancel_principal();" />										
										&nbsp;
										<input type="button" name="buscar" id="buscar" value="Buscar" title="Buscar" onclick="displayMessage('modulos/mantenimiento/municipio/bsq.php','750','500');" />																				
									</td>
								</tr>																																								
							</table>
							</form>
							<BR /><BR />
							<table class="b_table" align="center" width="90%">
								<tr>
									<td id="listregistros" align="center">
									</td>
								</tr>
							</table>
							<BR />									
						</fieldset>						
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? echo '<script language="javascript" type="text/javascript">cargar_lista("'.'modulos/mantenimiento/municipio/municipio_d.php?pagina=1'.'");</script>'; ?>
<script language="javascript" type="text/javascript">
$(document).ready(function()
{
	valor=$('#ms').val();
	if(valor==1){

		mensaje=acentos('&iexcl;El Municipio ha sido registrado exitosamente!')
		$("#mensa").addClass('exito');
		$('#mensa').html(mensaje);
	}
    
	if(valor==2){

		mensaje=acentos('&iexcl;Registro Rechazado, el Municipio ha sido registrado anteriormente!')
		$("#mensa").addClass('fallo');
		$('#mensa').html(mensaje);
	}
	
	if(valor==3){

		mensaje=acentos('&iexcl;Actualizaci&oacute;n Fallida, el Municipio ya se encuentra registrado!')
		$("#mensa").addClass('fallo');
		$('#mensa').html(mensaje);
	}	
	
	if(valor==4){

		mensaje=acentos('&iexcl;Actualizaci&oacute;n Exitosa, el Municipio fue Actualizado exitosamente!')
		$("#mensa").addClass('exito');
		$('#mensa').html(mensaje);
	}		
	
	if(valor==5){

		mensaje=acentos('&iexcl;Verifique, No ha realizado ningun cambio sobre el registro seleccionado!')
		$("#mensa").addClass('alerta');
		$('#mensa').html(mensaje);
	}		
	
	if(valor==6){

		mensaje=acentos('&iexcl;Eliminaci&oacute;n del Municipio exitosa!')
		$("#mensa").addClass('exito');
		$('#mensa').html(mensaje);
	}		
	
	if(valor==7){

		mensaje=acentos('&iexcl;El Municipio no se elimino por estar vinculado con otra entidad!')
		$("#mensa").addClass('exito');
		$('#mensa').html(mensaje);
	}
	
	if(valor==8){

		mensaje=acentos('&iexcl;Verifique, No ha realizado ninguna eliminaci&oacute;n del Municipio!')
		$("#mensa").addClass('exito');
		$('#mensa').html(mensaje);
	}		
	setTimeout(function(){$(".escuela").fadeOut(6000);},1000); 


});	
</script>