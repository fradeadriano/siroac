<?
if(!stristr($_SERVER['SCRIPT_NAME'],"ciudadano.php")){
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
require_once("../../../../librerias/Recordset.php");
require_once("../../../../librerias/bitacora.php");
//require("lay.php");
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
							<form action="" method="post" name="form_ciu" id="form_ciu" autocomplete="off" target="_self">
							<input type="hidden"  name="spam" value="<? echo $_SESSION["spam"]; ?>"/>
							<input type="hidden" name="elegido" id="elegido" value="<? echo $_POST["elegido"]; ?>" />
							<table align="center" width="80%"  border="0" cellspacing="0"  cellpadding="3">											
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
										Tel&eacute;fono M&oacute;vil:
									</td>
									<td>
										<input type="text" name="tmovil" id="tmovil" maxlength="12" onkeypress="return validar(event,numeros+'-')" onkeyup="mascara(this,'-',p_telefonico,false)">&nbsp;<span class="mensaje">*</span>&nbsp;<span style="font-size:9px">Ejm. 0412-01234567</span>
									</td>
								</tr>								
								<tr>
									<td align="right" height="20" width="140">
										Tel&eacute;fono Habitaci&oacute;n:
									</td>
									<td>
										<input type="text" name="thabitacion" id="thabitacion" maxlength="12" onkeypress="return validar(event,numeros+'-')" onkeyup="mascara(this,'-',p_telefonico,false)">&nbsp;&nbsp;&nbsp;<span style="font-size:9px">Ejm. 0243-01234567</span>
									</td>
								</tr>																																	
                                <tr >
                                    <td align="right" height="20" width="140" valign="top">
										Direcci&oacute;n:                                  
                                    </td>
									<td>
										<textarea name="direccion" id="direccion" onblur="formatotexto(this);" style="width:295px; height:50px"></textarea>&nbsp;<span class="mensaje">*</span>
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
									<td style="display:none">
										<? 
										/*$rsmuni = new Recordset();
										$rsmuni->sql = "SELECT id_municipio, municipio FROM municipio WHERE id_estado = 4 order by municipio"; 
										$rsmuni->llenarcombo($opciones = "\"municipio\"", $checked = "", $fukcion = "onchange=\"cargar_parroquias(this.value)\"" , $diam = "style=\"width:300px; Height:20px;\""); 
										$rsmuni->cerrar(); 
										unset($rsmuni);*/																						
										?>&nbsp;<span class="mensaje">*</span>
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
										<input type="hidden" name="id_municipio" id="id_municipio">
										<input type="hidden" name="id_ciudadano" id="id_ciudadano">
										<input type="hidden" name="accion" id="accion" />
										<input type="button" name="registrar" id="registrar" value="Registrar" title="Registrar" onclick="subb();" />
										&nbsp;
										<input type="reset" name="cancelar" id="cancelar" value="Cancelar" title="Cancelar" />	
										&nbsp;
										<input type="button" class="botones" onclick="closeMessage();" id="regresar" name="regresar" value="Regresar" title="Regresar" />									
									</td>
								</tr>
								<tr style="display:none"><td><iframe width="400" height="230" src="modulos/mecanismo/peticion/asesoria/save_ciudadano.php" name="salvar_ciudadano" id="salvar_ciudadano" frameborder="1"  />a</td></tr>
							</table>
							</form>								
						</fieldset>						
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>