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
						$nombres = stripslashes($_POST["nombres"]);
						$apellidos = stripslashes($_POST["apellidos"]);					
						$cedula = stripslashes($_POST["cedula"]);
						$tmovil = stripslashes($_POST["tmovil"]);						
						$direccion = stripslashes($_POST["direccion"]);
						
						if (isset($_POST["thabitacion"]) && stripslashes($_POST["thabitacion"])!= "") 
						{
							$campo_odireccion = ", telf_habitacion"; 
							$odireccion = ", '".stripslashes($_POST["thabitacion"])."'"; 
						}					
						
						if (isset($_POST["odireccion"]) && stripslashes($_POST["odireccion"])!= "") {							
							if($campo_odireccion !=""){
								$campo_odireccion = $campo_odireccion.", otra_direccion"; 
								$odireccion = $odireccion.", '".stripslashes($_GET["odireccion"])."'"; 						
							} else {
								$campo_odireccion = ", otra_direccion"; 
								$odireccion = ", '".stripslashes($_POST["odireccion"])."'"; 						
							}							
						}					
	
						if (isset($_POST["email"]) && stripslashes($_POST["email"])!= "") {
							if($campo_odireccion !=""){
								$campo_odireccion = $campo_odireccion.", email"; 
								$odireccion = $odireccion.", '".stripslashes($_GET["email"])."'"; 						
							} else {
								$campo_odireccion = $campo_odireccion.", email"; 
								$odireccion = $odireccion.", '".stripslashes($_POST["email"])."'"; 
							}								
						}										
						
						if (isset($_POST["id_parroquia"]) && stripslashes($_POST["id_parroquia"])!= "") {							
							if($campo_odireccion !=""){
								$campo_odireccion = $campo_odireccion.", id_parroquia"; 
								$odireccion = $odireccion.", '".stripslashes($_POST["id_parroquia"])."'"; 						
							} else {
								$campo_odireccion = ", id_parroquia"; 
								$odireccion = ", '".stripslashes($_POST["id_parroquia"])."'"; 						
							}					
							
						} else if(isset($_POST["municipio"]) && stripslashes($_POST["municipio"])!= "") {
							
							if($campo_odireccion !=""){
								$campo_odireccion = $campo_odireccion.", id_municipio"; 
								$odireccion = $odireccion.", '".stripslashes($_POST["municipio"])."'"; 						
							} else {
								$campo_odireccion = ", id_municipio"; 
								$odireccion = ", '".stripslashes($_POST["municipio"])."'"; 						
							}					
						}										

						$search = new Recordset();
						$search->sql = "SELECT * FROM ciudadano WHERE cedula = '".$cedula."'";
							$search->abrir();
							if($search->total_registros == 0)
							{
								$ins = new Recordset();
								$ins->sql = "INSERT INTO ciudadano(cedula, nombres, apellidos, telf_movil, direccion $campo_odireccion )
												VALUES ('".$cedula."', '".$nombres."', '".$apellidos."', '".$tmovil."', '".$direccion."' $odireccion )";
								$ins->abrir();
								$ins->cerrar();
								unset($ins);		
								/*bitacora*/ 
									$descrp_bitacora="C&eacute;dula: ".$cedula.", Nombre y Apellido: ".$nombres.", ".$apellidos.", Tel&eacute;fonos: ".$thabitacion." ".$tmovi.", Direcci&oacute;n: ".$direccion.", Parroquia_n: ".$id_parroquia.", Otra Direcci&oacute;n: ".$odireccion.", Email: ".stripslashes($_POST["email"]);
									bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro de Ciudadanos","Se registro un Ciudadano con los siguientes datos: '".$descrp_bitacora."'.");
								/*bitacora*/ 
								$mensaje = 1;															
							} else {
								$mensaje = 2;
							}
					break;
					case "Modificar":
						if (isset($_POST["id_ciudadano"]) && $_POST["id_ciudadano"]!=""){
							$rsagregar1 = new Recordset();
							$rsagregar1->sql = "SELECT cedula, nombres, apellidos, email, telf_habitacion, telf_movil, direccion, otra_direccion, id_parroquia FROM ciudadano WHERE id_ciudadano = '".$_POST["id_ciudadano"]."'";
							$rsagregar1->abrir();
							if($rsagregar1->total_registros != 0)
							{
								$rsagregar1->siguiente();
								$change = 1;
								$consul = "";
								
								if (strcasecmp($rsagregar1->fila["cedula"],stripslashes($_POST["cedula"])) != 0)
									{
										$change = 0;
										$consul = "cedula = '".trim(stripslashes($_POST["cedula"]))."'";
										$bi = "cedula=".stripslashes($_POST["cedula"]).", ";
									}

								if (strcasecmp($rsagregar1->fila["nombres"],stripslashes($_POST["nombres"])) != 0)
									{
										$change = 0;
										if ($consul!=""){
											$consul = $consul .", nombres = '".trim(stripslashes($_POST["nombres"]))."'";
										} else { 
											$consul = "nombres = '".trim(stripslashes($_POST["nombres"]))."'";
										}										
										$bi = "nombres=".stripslashes($_POST["nombres"]).", ";
										
									}

								if (strcasecmp($rsagregar1->fila["apellidos"],stripslashes($_POST["apellidos"])) != 0)
									{
										$change = 0;
										if ($consul!=""){
											$consul = $consul . ", apellidos = '".trim(stripslashes($_POST["apellidos"]))."'";
										} else { 
											$consul = "apellidos = '".trim(stripslashes($_POST["apellidos"]))."'";
										}										
										$bi = "apellidos=".stripslashes($_POST["apellidos"]).", ";
									}
									
								if (strcasecmp($rsagregar1->fila["email"],stripslashes($_POST["email"])) != 0)
									{
										$change = 0;
										if ($consul!=""){
											$consul = $consul . ", email = '".trim(stripslashes($_POST["email"]))."'";
										} else { 
											$consul = "email = '".trim(stripslashes($_POST["email"]))."'";
										}																
										$bi = "email=".stripslashes($_POST["email"]).", ";
									}	
									
								if (strcasecmp($rsagregar1->fila["telf_habitacion"],stripslashes($_POST["thabitacion"])) != 0)
									{
										$change = 0;
										if ($consul!=""){
											$consul = $consul . ", telf_habitacion = '".trim(stripslashes($_POST["thabitacion"]))."'";
										} else { 
											$consul = "telf_habitacion = '".trim(stripslashes($_POST["thabitacion"]))."'";
										}																
										$bi = "telf_habitacion=".stripslashes($_POST["thabitacion"]).", ";
									}																		

								if (strcasecmp($rsagregar1->fila["telf_movil"],stripslashes($_POST["tmovil"])) != 0)
									{
										$change = 0;
										if ($consul!=""){
											$consul = $consul . ", telf_movil = '".trim(stripslashes($_POST["tmovil"]))."'";
										} else { 
											$consul = "telf_movil = '".trim(stripslashes($_POST["tmovil"]))."'";
										}																
										$bi = "telf_movil=".stripslashes($_POST["tmovil"]).", ";
									}

								if (strcasecmp($rsagregar1->fila["direccion"],stripslashes($_POST["direccion"])) != 0)
									{
										$change = 0;
										if ($consul!=""){
											$consul = $consul . ", direccion = '".trim(stripslashes($_POST["direccion"]))."'";
										} else { 
											$consul = "direccion = '".trim(stripslashes($_POST["direccion"]))."'";
										}																
										$bi = "direccion=".stripslashes($_POST["direccion"]).", ";
									}

								if (strcasecmp($rsagregar1->fila["otra_direccion"],stripslashes($_POST["odireccion"])) != 0)
									{
										$change = 0;
										if ($consul!=""){
											$consul = $consul . ", otra_direccion = '".trim(stripslashes($_POST["odireccion"]))."'";
										} else { 
											$consul = "otra_direccion = '".trim(stripslashes($_POST["odireccion"]))."'";
										}																
										$bi = "otra_direccion=".stripslashes($_POST["odireccion"]).", ";
									}

								if ($rsagregar1->fila["id_parroquia"] != stripslashes($_POST["id_parroquia"]))
									{
										$change = 0;
										if ($consul!=""){
											$consul = $consul . ", id_parroquia = '".trim(stripslashes($_POST["id_parroquia"]))."'";
										} else { 
											$consul = "id_parroquia = '".trim(stripslashes($_POST["id_parroquia"]))."'";
										}																
										$bi = "id_parroquia=".stripslashes($_POST["id_parroquia"]).", ";
									}

								if ($change == 0)
									{								
										$rsagregar2 = new Recordset();
										$rsagregar2->sql = "UPDATE ciudadano SET $consul WHERE (id_ciudadano = ".$_POST["id_ciudadano"].");";
										$rsagregar2->abrir();
										$mensaje = 4;
										bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Modificaci&oacute;n del Ciudadano", "Se modific&oacute; el Ciudadano identificado n&uacute;mero: &ldquo;(".stripslashes($_POST["id_ciudadano"]).")&rdquo; Los datos modificados fueron: $bi");
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
						if (isset($_POST["id_ciudadano"]) && stripslashes($_POST["id_ciudadano"])!="")
						{					
							$rsverif= new Recordset();
							$rsverif->sql = "SELECT id_registro_mecanismo FROM registro_mecanismo WHERE id_ciudadano = '".stripslashes($_POST["id_ciudadano"])."'";
							$rsverif->abrir();
							if($rsverif->total_registros == 0){
								$rsinsert= new Recordset();
								$rsinsert->sql = "DELETE FROM ciudadano WHERE id_ciudadano = '".stripslashes($_POST["id_ciudadano"])."'";
								$rsinsert->abrir();
								bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Eliminaci&oacute;n del Ciudadano", "Se elimin&oacute; el Ciudadano &rdquo;".stripslashes($_POST["id_ciudadano"])."&bdquo;");
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
					<td width="45px"><img src="images/ciudadano.png"/></td>
					<td class="titulomenu" valign="middle">Registro Ciudadanos</td>
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
						<legend class="titulomenu">&nbsp;Datos del Ciudadano</legend>
							<form action="" method="post" name="form_ciu" id="form_ciu" autocomplete="off">
							<input type="hidden"  name="spam" value="<? echo $_SESSION["spam"]; ?>"/>
							<input type="hidden" name="elegido" id="elegido" value="<? echo $_POST["elegido"]; ?>" />
							<table align="center" width="80%"  border="0" cellspacing="0"  cellpadding="5">			
								<tr>
									<td colspan="2" align="center" height="30px">
										<input type="hidden" name="ms" id="ms" value="<? echo $mensaje; ?>"/>
										<div id="mensa"  name="mensa" class="escuela" style="width:100%;float:center; font-size:12px;font-weight:bold;"></div>                                    
									</td>
								</tr>								
								<tr>
									<td align="right" height="20" width="140">
										Nombres:
									</td>
									<td>
										<input type="text" style="width:220px" name="nombres" onkeypress="return validar(event,letras+'ñ')"  id="nombres">&nbsp;<span class="mensaje">*</span>
									</td>
								</tr>
								<tr>
									<td align="right" height="20" width="140">
										Apellidos:
									</td>
									<td>
										<input type="text" name="apellidos" id="apellidos" style="width:220px" onkeypress="return validar(event,letras+'ñ')" >&nbsp;<span class="mensaje">*</span>
									</td>
								</tr>
								<tr>
									<td align="right" height="20" width="140">
										C&eacute;dula:
									</td>
									<td>
										<input type="text" name="cedula" id="cedula" onkeypress="return validar(event,numeros)" maxlength="10">&nbsp;<span class="mensaje">*</span>&nbsp;<span style="font-size:9px">Ejm. 12123456</span>
									</td>
								</tr>								
								<tr>
									<td align="right" height="20" width="140">
										Email:
									</td>
									<td>
										<input type="text" name="email" id="email" style="width:220px" onblur="validateForm(document.getElementById('email').value);">&nbsp;<span style="font-size:9px">Ejm. alias@dominio.com</span>
									</td>
								</tr>											
								<tr>
									<td align="right" height="20" width="140">
										Tel&eacute;fono Habitaci&oacute;n:
									</td>
									<td>
										<input type="text" name="thabitacion" id="thabitacion" maxlength="12" onkeypress="return validar(event,numeros+'-')" onkeyup="mascara(this,'-',p_telefonico,false)">&nbsp;<span style="font-size:9px">Ejm. 0243-01234567</span>
									</td>
								</tr>											
								<tr>
									<td align="right" height="20" width="140">
										Tel&eacute;fono M&oacute;vil:
									</td>
									<td>
										<input type="text" name="tmovil" id="tmovil" maxlength="12" onkeypress="return validar(event,numeros+'-')" onkeyup="mascara(this,'-',p_telefonico,false)">&nbsp;<span class="mensaje">*</span>&nbsp;<span style="font-size:9px">Ejm. 0243-01234567</span>
									</td>
								</tr>																						
                                <tr >
                                    <td align="right" height="20" width="140" valign="top">
										Direcci&oacute;n:                                  
                                    </td>
									<td>
										<textarea name="direccion" id="direccion" onblur="formatotexto(this);" onkeyup="return maximaLongitud(this.id,150);" style="width:295px; height:30px"></textarea>&nbsp;<span class="mensaje">*</span>
										<br /><span style="font-size:9px">M&aacute;ximo 150 Caracteres</span>
									</td>
                                </tr>
                                <tr >
                                    <td align="right" height="20" width="140" valign="top">
										Otra Direcci&oacute;n:                                  
                                    </td>
									<td>
										<textarea name="odireccion" id="odireccion" onblur="formatotexto(this);" style="width:295px; height:50px"></textarea>
									</td>
                                </tr>
                                <tr >
                                    <td align="right" height="20" width="140">
										Estado:                                  
                                    </td>
									<td>
										<? 
										$rsstado = new Recordset();
										$rsstado->sql = "SELECT id_estado, estado FROM estado order by estado"; 
										$rsstado->llenarcombo($opciones = "\"estado\"", $checked = "", $fukcion = "onchange=\"cargar_municipos(this.value)\"" , $diam = "style=\"width:300px; Height:20px;\""); 
										$rsstado->cerrar(); 
										unset($rsstado);																						
										?>&nbsp;<span class="mensaje">*</span>
									</td>
                                </tr>                                
                                <tr >
                                    <td align="right" height="20" width="140">
										Municipio:                                  
                                    </td>
									<td id="comb_M">
										<select name="municipio" id="municipio" style="width:300px; height:20px;"><option>&nbsp;</option></select>&nbsp;<span class="mensaje">*</span>
									</td>									
									<td>
										<? 
										/*$rsmuni = new Recordset();
										$rsmuni->sql = "SELECT id_municipio, municipio FROM municipio WHERE id_estado = 4 order by municipio"; 
										$rsmuni->llenarcombo($opciones = "\"municipio\"", $checked = "", $fukcion = "onchange=\"cargar_parroquias(this.value)\"" , $diam = "style=\"width:300px; Height:20px;\""); 
										$rsmuni->cerrar(); 
										unset($rsmuni);*/																						
										?>
									</td>
                                </tr>
                                <tr >
                                    <td align="right" height="20" width="140">
										Parroquia:                                  
                                    </td>
									<td id="comb_P">
										<select name="parroquia" id="parroquia" style="width:300px; height:20px;"><option>&nbsp;</option></select>
									</td>
                                </tr>
								<tr>
									<td height="5px" colspan="5">
									</td>
								</tr>	
								<tr><td height="5" colspan="5" align="right" class="mensaje">* Campos Obligatorios</td></tr>																
								<tr><td height="5" colspan="5"></td></tr>								
								<tr>
									<td align="center" colspan="5">
										<input type="hidden" name="id_parroquia" id="id_parroquia">
										<input type="hidden" name="id_ciudadano" id="id_ciudadano">
										<input type="hidden" name="id_municipio" id="id_municipio">
										<input type="hidden" name="accion" id="accion" />
										<input type="button" name="registrar" id="registrar" value="Registrar" title="Registrar" onclick="subb();" />
										&nbsp;
										<input type="reset" name="cancelar" id="cancelar" value="Cancelar" title="Cancelar" onclick="cancel_principal();" />										
										&nbsp;
										<input type="button" name="buscar" id="buscar" value="Buscar" title="Buscar" onclick="displayMessage('modulos/mantenimiento/ciudadano/bsq.php','750','500');" />																				
									</td>
								</tr>																																								
							</table>
							</form>
							<BR /><BR />
							<table class="b_table" align="center" width="90%">
								<tr>
									<td id="listregistros">
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
<? echo '<script language="javascript" type="text/javascript">cargar_lista("'.'modulos/mantenimiento/ciudadano/ciudadano_d.php?pagina=1'.'");</script>'; ?>
<script language="javascript" type="text/javascript">
$(document).ready(function()
{
	valor=$('#ms').val();
	if(valor==1){

		mensaje=acentos('&iexcl;El Ciudadano ha sido registrado exitosamente!')
		$("#mensa").addClass('exito');
		$('#mensa').html(mensaje);
	}
    
	if(valor==2){

		mensaje=acentos('&iexcl;Registro Rechazado, el ciudadano ha sido registrado anteriormente!')
		$("#mensa").addClass('fallo');
		$('#mensa').html(mensaje);
	}
	
	if(valor==3){

		mensaje=acentos('&iexcl;Actualizaci&oacute;n Fallida, el ciudadano ya se encuentra registrado!')
		$("#mensa").addClass('fallo');
		$('#mensa').html(mensaje);
	}	
	
	if(valor==4){

		mensaje=acentos('&iexcl;Actualizaci&oacute;n Exitosa, el ciudadano fue registrado exitosamente!')
		$("#mensa").addClass('exito');
		$('#mensa').html(mensaje);
	}		
	
	if(valor==5){

		mensaje=acentos('&iexcl;Verifique, No ha realizado ningun cambio sobre el registro seleccionado!')
		$("#mensa").addClass('alerta');
		$('#mensa').html(mensaje);
	}		
	
	if(valor==6){

		mensaje=acentos('&iexcl;Eliminaci&oacute;n del Ciudadano exitosa!')
		$("#mensa").addClass('exito');
		$('#mensa').html(mensaje);
	}		
	
	if(valor==7){

		mensaje=acentos('&iexcl;El Ciudadano no se elimino por estar vinculado con otra entidad!')
		$("#mensa").addClass('exito');
		$('#mensa').html(mensaje);
	}
	
	if(valor==8){

		mensaje=acentos('&iexcl;Verifique, No ha realizado ninguna eliminaci&oacute;n del ciudadano!')
		$("#mensa").addClass('exito');
		$('#mensa').html(mensaje);
	}		
	setTimeout(function(){$(".escuela").fadeOut(6000);},1000); 


});	
</script>