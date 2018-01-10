<?
if(!stristr($_SERVER['SCRIPT_NAME'],"index.php")){
	$hmtl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Peticion</title>
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
			$rssolicitud = new Recordset();
			if(isset($_POST["accion"]))
			{
				switch($_POST["accion"])
				{
					case "Registrar": 
						$campos_ = "id_mecanismo"; 
						$values_ = 5;
						
						if(isset($_POST["id_ciudadano"])){ 
							$campos_ = $campos_.", id_ciudadano"; 
							$values_ = $values_.", ".stripslashes($_POST["id_ciudadano"]); 
							$bti =  "el ciudadano identificado con n#:".stripslashes($_POST["id_ciudadano"]);							
						}
						
						if(isset($_POST["comunicacion"])){ 
							$campos_ = $campos_.", comunicacion"; 
							$values_ = $values_.", ".stripslashes($_POST["comunicacion"]); 
							if($bti!=""){
								$bti = $bti.", comunicaci&oacute;n: ".stripslashes($_POST["comunicacion"]);
							} else {
								$bti = " comunicaci&oacute;n: ".stripslashes($_POST["comunicacion"]);
							}							
							
						}
						
						if(isset($_POST["competencia"])){ 
							$campos_ = $campos_.", caso"; 
							$values_ = $values_.", ".stripslashes($_POST["competencia"]); 
							if($_POST["competencia"]==0){ $pertenece = "CC"; } else { $pertenece = "SC"; }
							if($bti!=""){
								$bti = $bti.", Competencia: ".$pertenece;
							} else {
								$bti = " Competencia: ".$pertenece;
							}							

						}						
						
						if(isset($_POST["instancia_pp"])){ 
							$campos_ = $campos_.", nombre_instancia_pp"; 
							$values_ = $values_.", '".$rssolicitud->codificar($_POST["instancia_pp"])."'"; 
							if($bti!=""){
								$bti = $bti.", Instancia P.P.: ".stripslashes($_POST["instancia_pp"]);
							} else {
								$bti = " Instancia P.P.: ".stripslashes($_POST["instancia_pp"]);
							}							

						}						
										
						if(isset($_POST["direccion_instancia"])){ 
							$campos_ = $campos_.", direccion_instancia_pp"; 
							$values_ = $values_.", '".$rssolicitud->codificar($_POST["direccion_instancia"])."'"; 
							if($bti!=""){
								$bti = $bti.", Direcci&oacute;n Instancia P.P.: ".stripslashes($_POST["direccion_instancia"]);
							} else {
								$bti = " Direcci&oacute;n Instancia P.P.: ".stripslashes($_POST["direccion_instancia"]);
							}

						}						
						
						if(isset($_POST["rif_instancia"])){ 
							$campos_ = $campos_.", rif_instancia_pp"; 
							$values_ = $values_.", '".$_POST["rif_instancia"]."'"; 
							if($bti!=""){	
								$bti = $bti.", Rif. Instancia P.P.: ".stripslashes($_POST["rif_instancia"]);
							} else {
								$bti = " Rif. Instancia P.P.: ".stripslashes($_POST["rif_instancia"]);
							}							

						}						
						
						if(isset($_POST["ente_financiero"])){ 
							$campos_ = $campos_.", ente_financiero"; 
							$values_ = $values_.", '".$_POST["ente_financiero"]."'"; 
							if($bti!=""){
								$bti = $bti.", Ente Financiero: ".stripslashes($_POST["ente_financiero"]);
							} else {
								$bti = " Ente Financiero: ".stripslashes($_POST["ente_financiero"]);
							}							
						}
						
						if(isset($_POST["nombre_proy"])){ 
							$campos_ = $campos_.", nombre_proyecto"; 
							$values_ = $values_.", '".$rssolicitud->codificar($_POST["nombre_proy"])."'"; 
							if($bti!=""){
								$bti = $bti.", Nombre Proyecto: ".stripslashes($_POST["nombre_proy"]);
							} else {
								$bti = " Nombre Proyecto: ".stripslashes($_POST["nombre_proy"]);
							}							

						}	
						
						if(isset($_POST["mon_financiado"])){ 
							$campos_ = $campos_.", monto_financiado"; 
							$values_ = $values_.", '".stripslashes($_POST["mon_financiado"])."'"; 
							if($bti!=""){
								$bti = $bti.", Monto Financiado: ".stripslashes($_POST["mon_financiado"]);
							} else {
								$bti = " Monto Financiado: ".stripslashes($_POST["mon_financiado"]);
							}							

						}	
						
						if(isset($_POST["perte_comite"])){ 
							$campos_ = $campos_.", pertenece_comite"; 
							$values_ = $values_.", ".stripslashes($_POST["perte_comite"]); 
							if($bti!=""){
								$bti = $bti.", Pertenece a Comite: ".stripslashes($_POST["perte_comite"]);
							} else {
								$bti = " Pertenece a Comite: ".stripslashes($_POST["perte_comite"]);
							}							

						}																							

						if(isset($_POST["nomb_comite"])){ 
							$campos_ = $campos_.", nombre_comite"; 
							$values_ = $values_.", '".$rssolicitud->codificar($_POST["nomb_comite"])."'"; 
							if($bti!=""){
								$bti = $bti.", Nombre Comite: ".stripslashes($_POST["nomb_comite"]);
							} else {
								$bti = " Nombre Comite: ".stripslashes($_POST["nomb_comite"]);
							}						

						}	
						
						if(isset($_POST["nom_organizacion"])){ 
							$campos_ = $campos_.", nombre_organizacion_sindical"; 
							$values_ = $values_.", '".$rssolicitud->codificar($_POST["nom_organizacion"])."'"; 
							if($bti!=""){
								$bti = $bti.", Nombre Organizaci&oacute;n Sindical: ".stripslashes($_POST["nom_organizacion"]);
							} else {
								$bti = " Nombre Organizaci&oacute;n Sindical: ".stripslashes($_POST["nom_organizacion"]);
							}							

						}						

						if(isset($_POST["direccion_organizacion"])){ 
							$campos_ = $campos_.", direccion_organizacion_sindical"; 
							$values_ = $values_.", '".$rssolicitud->codificar($_POST["direccion_organizacion"])."'"; 
							if($bti!=""){
								$bti = $bti.", Direccion Organizaci&oacute;n Sindical: ".stripslashes($_POST["direccion_organizacion"]);
							} else {
								$bti = " Direccion Organizaci&oacute;n Sindical: ".stripslashes($_POST["direccion_organizacion"]);
							}							

						}						

						if(isset($_POST["rif_organizacion"])){ 
							$campos_ = $campos_.", rif_organizacion_sindical"; 
							$values_ = $values_.", '".$_POST["rif_organizacion"]."'"; 
							if($bti!=""){
								$bti = $bti.", Rif Organizaci&oacute;n Sindical: ".stripslashes($_POST["rif_organizacion"]);
							} else {
								$bti = " Rif Organizaci&oacute;n Sindical: ".stripslashes($_POST["rif_organizacion"]);
							}							

						}						

						if(isset($_POST["telef_organizacion"])){ 
							$campos_ = $campos_.", telef_oficina"; 
							$values_ = $values_.", '".$_POST["telef_organizacion"]."'"; 
							if($bti!=""){
								$bti = $bti.", Telef. Organizaci&oacute;n Sindical: ".stripslashes($_POST["telef_organizacion"]);
							} else {
								$bti = " Telf. Organizaci&oacute;n Sindical: ".stripslashes($_POST["telef_organizacion"]);
							}							

						}						

						if(isset($_POST["otr_telef_organizacion"])){ 
							$campos_ = $campos_.", otro_telef"; 
							$values_ = $values_.", '".$_POST["otr_telef_organizacion"]."'"; 
							if($bti!=""){
								$bti = $bti.", Otro Telef. Organizaci&oacute;n Sindical: ".stripslashes($_POST["otr_telef_organizacion"]);
							} else {
								$bti = " Otro Telf. Organizaci&oacute;n Sindical: ".stripslashes($_POST["otr_telef_organizacion"]);
							}							 

						}	
						
						if(isset($_POST["hechos"])){ 
							$campos_ = $campos_.", actores_involucrados"; 
							$values_ = $values_.", '".$rssolicitud->codificar($_POST["hechos"])."'"; 
							if($bti!=""){
								$bti = $bti.", Actores Involucrados: ".stripslashes($_POST["hechos"]);
							} else {
								$bti = " Actores Involucrados: ".stripslashes($_POST["hechos"]);
							}							

						}											
						
						if(isset($_POST["fecha_hechos"])){ 
							$campos_ = $campos_.", escena_suceso"; 
							$values_ = $values_.", '".$rssolicitud->codificar($_POST["fecha_hechos"])."'"; 
							if($bti!=""){
								$bti = $bti.", Fecha del Suceso: ".stripslashes($_POST["fecha_hechos"]);
							} else {
								$bti = " Fecha del Suceso: ".stripslashes($_POST["fecha_hechos"]);
							}						

						}	
						
						if(isset($_POST["narracion_hechos"])){ 
							$campos_ = $campos_.", relatoria_caso"; 
							$values_ = $values_.", '".$rssolicitud->codificar($_POST["narracion_hechos"])."'"; 
							if($bti!=""){
								$bti = $bti.", Narracai&oacute;n del hecho: ".stripslashes($_POST["narracion_hechos"]);
							} else {
								$bti = " Narracai&oacute;n del hecho: ".stripslashes($_POST["narracion_hechos"]);
							}							 

						}							
							
						if(isset($_POST["observacion_hechos"])){ 
							$campos_ = $campos_.", observacion"; 
							$values_ = $values_.", '".$rssolicitud->codificar($_POST["observacion_hechos"])."'"; 
							if($bti!=""){
								$bti = $bti.", Observaciones: ".stripslashes($_POST["observacion_hechos"]);
							} else {
								$bti = " Observaciones: ".stripslashes($_POST["observacion_hechos"]);
							}								

						}											
						
						// D-CC-000-00-0000-OAC-CEA																
						$rssolicitud = new Recordset();
						$rssolicitud->sql = "SELECT n_expediente FROM registro_mecanismo WHERE id_mecanismo = 5 AND DATE_FORMAT(fecha_registro,'%Y') = '".date("Y")."' ORDER BY id_registro_mecanismo DESC LIMIT 1";
						$rssolicitud->abrir();
						if($rssolicitud->total_registros > 0)
							{	
								$rssolicitud->siguiente();
								$codviejo = explode("-",$rssolicitud->fila["n_expediente"]);
								$fechanueva = date("Y");
								if ($codviejo[4] == $fechanueva)
								{
									$nuevovalor=(int)$codviejo[2];
									$nuevovalor++;
									$nuevovalor = str_pad($nuevovalor, 3, "0", STR_PAD_LEFT);
									$codnuevo= "R-".$pertenece."-".$nuevovalor."-".date("m")."-".$fechanueva."-OAC-CEA";
								}
								else
								{
									$nuevovalor= str_pad("1", 3, "0", STR_PAD_LEFT);
									$codnuevo=  "R-".$pertenece."-".$nuevovalor."-".date("m")."-".$fechanueva."-OAC-CEA";
								}
							}
							else
							{
								$fechanueva = date("Y");
								$nuevovalor= str_pad("1", 3, "0", STR_PAD_LEFT);
								$codnuevo=  "R-".$pertenece."-".$nuevovalor."-".date("m")."-".$fechanueva."-OAC-CEA";
							}						
										

						$ins = new Recordset();
						$ins->sql = "INSERT INTO registro_mecanismo($campos_, fecha_registro, n_expediente)
										VALUES ($values_, '".date("Y-m-d")."', '$codnuevo')";
						$ins->abrir();
						$ins->cerrar();
						unset($ins);						
						
						$searchId = new Recordset();
						$searchId->sql = "SELECT id_registro_mecanismo FROM registro_mecanismo ORDER BY id_registro_mecanismo DESC LIMIT 1";
							$searchId->abrir();
							if($searchId->total_registros != 0)
							{								
								$searchId->siguiente();									
								$mYId = $searchId->fila["id_registro_mecanismo"]; 
							}				
						$searchId->cerrar();
						unset($searchId);																													
						
						$valor = $_POST["contenedor_1"];
						$sub_valor = explode(":",$valor);
						$ter_valor = $sub_valor[1];
						$tetr_valor = explode("-",$ter_valor);
						$total = count($tetr_valor);
						 for ($k = 0; $k < $total;$k++){
							if($cadenas==""){
								$cadenas = "(".$mYId.",".$tetr_valor[$k].")";
							} else {
							$cadenas = $cadenas.",(".$mYId.",".$tetr_valor[$k].")";
							}
						 }
						$rsinsert = new Recordset();
						$rsinsert->sql = "INSERT INTO `registro_mecanismo_interposicion` (id_registro_mecanismo, id_interposicion_mecanismo) VALUES $cadenas ";
						$rsinsert->abrir();								
						$rsinsert->cerrar();
						unset($rsinsert);	
						if($_POST["contenedor_2"]!="")
						{	
							$cont_pruebas = explode("!", $_POST["contenedor_2"]);
							
							 for ($k = 0; $k < count($cont_pruebas);$k++){
								$particulas = explode(":", $cont_pruebas[$k]);					
								if($cadenasp==""){
									$cadenasp = "(".$mYId.",'".$particulas[0]."','".$particulas[1]."','".$particulas[2]."')";
								} else {
									$cadenasp= $cadenasp.",(".$mYId.",'".$particulas[0]."','".$particulas[1]."','".$particulas[2]."')";
								}
							 }
	
							$rsinsert2 = new Recordset();
							$rsinsert2->sql = "INSERT INTO `registro_mecanismo_prueba` (id_registro_mecanismo, prueba_consignada, n_folios, contenido) VALUES $cadenasp ";
							$rsinsert2->abrir();								
							$rsinsert2->cerrar();
							unset($rsinsert2);
						}
						/*bitacora*/ 
							//$descrp_bitacora="C&eacute;dula: ".$cedula.", Nombre y Apellido: ".$nombres.", ".$apellidos.", Tel&eacute;fonos: ".$thabitacion.", ".$tmovi.", Direcci&oacute;n: ".$direccion.", Parroquia_n: ".$id_parroquia.", Otra Direcci&oacute;n: ".$odireccion.", Email: ".stripslashes($_POST["email"]);
							bitacora($_SESSION["usuario"],date("Y-m-d"),date("H:i:s"),"Registro un Reclamo identificado con n&uacute;mero: $mYId","Se registro un Reclamo con id: -$mYId- y con los siguientes datos: '".$bti."'.");
						/*bitacora*/ 						
						//?calificacion='.$if.'
						$mensaje = 1;
						echo '<form action="modulos/mecanismo/reclamo/xls_reclamo.php" method="get" name="repor_reclamo" id="repor_reclamo">
								<input type="hidden" name="mecanismo" id="mecanismo" >
							 </form>';
						echo '<script language="javascript"> document.getElementById("mecanismo").value = "'.$mYId.'"; document.getElementById("repor_reclamo").target="_blank"; document.repor_reclamo.submit(); </script>';																			
					break;
				}
			}
			$_SESSION["spam"] = rand(1, 99999999);
		} else {
			$_SESSION["spam"] = rand(1, 99999999);
		}
?>
<table border="0" align="center" width="800">
	<tr>
		<td align="center" height="40px">
			<input type="hidden" name="ms" id="ms" value="<? echo $mensaje; ?>"/>
			<div id="mensa"  name="mensa" class="escuela" style="width:100%;float:center; font-size:12px;font-weight:bold;"></div>                                    
		</td>
	</tr>	
	<tr>
		<td align="right">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="45px"><img src="images/mecanismo.png"/></td>
					<td class="titulomenu" valign="middle">Registro de Reclamo</td>
				</tr>
				<tr>
					<td colspan="2" ><hr class="pintar_linea" /></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr> 
		<td>
			<fieldset>
				<form action="" name="form_denuncia" id="form_denuncia" method="post" autocomplete="off">
				<input type="hidden" name="elegido" id="elegido" value="<? echo $_POST["elegido"]; ?>" />
				<input type="hidden"  name="spam" value="<? echo $_SESSION["spam"]; ?>"/>
				<table border="0" width="100%">
					<tr>
						<td height="30" colspan="2" align="center">
						<div id="contenedor_btn" style="width:300px;" align="center">
						<input type="button" name="registrar" id="registrar" value="Registrar" title="Registrar" style="width:90px" onclick="sub_marine();" />&nbsp;&nbsp;
						<input type="reset" name="registrar" id="registrar" value="Cancelar" title="Cancelar" style="width:90px"/>
						</div>
						</td>
					</tr>																																				
					<tr>
						<td valign="top" align="center"><br />
							<table border="0" cellpadding="3" cellspacing="3" id="contenedor" style="width:620px;" >
								<tr>
									<td align="right">
										Comunicaci&oacute;n:
									</td>
									<td><select name="comunicacion" id="comunicacion">
											<option selected="selected"></option>
											<option value="0">Escrita</option>
											<option value="1">Verbal</option>
										</select>&nbsp;<span class="mensaje">*</span>
										</td>
									<td></td>
									<td width="150" align="right">Con Competencia:</td>
									<td align="right" valign="bottom">Si</td>
									<td ><input type="radio" name="competencia" id="0" value="0" checked="checked" /></td>
									<td valign="bottom" align="right">No</td>
									<td><input type="radio" name="competencia" id="1" value="1" /></td>
								</tr>			
								<tr>
									<td width="150" valign="top" align="right">
										Interposici&oacute;n Mecan&iacute;smo:
									</td>
									<td colspan="7">
										<table border="0" id="contenedor" cellpadding="0" cellspacing="0">
											<tr>
												<td colspan="2" width="170" align="right">Por Representantes Elegidos&nbsp;<input type="checkbox" name="repre_elegidos" value="4" /></td>
												<td colspan="2" align="right">Comunidad Organizada&nbsp;<input type="checkbox" name="comuni_orga" id="comuni_orga" value="5"  /></td>
											</tr>
											<tr>
												<td align="right">Individual&nbsp;<input type="checkbox" name="individual" id="individual" value="1" /></td>
												<td align="right">Colectiva&nbsp;<input type="checkbox" name="colectiva" id="colectiva" value="2"  /></td>
												<td align="right">Directa&nbsp;<input type="checkbox" name="directa" id="directa" value="3" /><input type="hidden" name="contenedor_1" id="contenedor_1" />
												</td>
											</tr>
										</table>		
									</td>
									<td valign="bottom" align="left"><span class="mensaje">*</span></td>
								</tr>

								<tr><td height="20"class="mensaje" align="right" colspan="9" valign="bottom">* Campo Obligatorio</td></tr>										
							</table>
						</td>
						<td valign="top" align="center"><br />
							<table id="contenedor" style="width:20%; height:50px">
								<tr>
									<td align="right">
										<b>Fecha:</b>
									</td>
									<td>
										<span class="mensaje"><? echo date("d-m-Y"); ?></span>
									</td>
								</tr>			
							</table>							
						</td>
					</tr>
					<tr><td height="10" colspan="2"></td></tr>
					<tr>
						<td colspan="2" align="center">
							<fieldset style="width:98%">
							<legend class="titulomenu">Datos del Ciudadano</legend>
							<table border="0" cellpadding="0" cellspacing="3" width="100%" id="contenedor">
								<tr>
									<td colspan="6" align="right" valign="middle">
										<input type="hidden" name="id_ciudadano" id="id_ciudadano"/>
										<img src="images/Find.png" title="Busqueda de Ciudadanos"onclick="displayMessage('modulos/mecanismo/reclamo/bsq.php','750','500');" style="cursor:pointer"/>
										&nbsp;&nbsp;&nbsp;<img src="images/agre_ciudadano.png" title="Agregar un Nuevo Ciudadano"onclick="displayMessage('modulos/mecanismo/reclamo/ciudadano.php','750','550');" style="cursor:pointer"/>
										&nbsp;&nbsp;
									</td>
								</tr>
								<tr><td height="5"></td></tr>
								<tr>
									<td align="right">C&eacute;dula:</td><td><input type="text" readonly="true" name="cedula_ciu" id="cedula_ciu" style="width:60px" /></td>
									<td align="right">Nombre y Apellido:</td><td align="left"><input readonly="true" type="text" name="nombre_ciu" id="nombre_ciu" style="width:240px"/></td>
									<td align="right">Tel&eacute;fonos:</td><td align="left"><input readonly="true" type="text" name="telefonos_ciu" id="telefonos_ciu" style="width:180px"/></td>
								</tr>
								<tr><td height="5"></td></tr>
								<tr>
									<td align="right" valign="top">Direcci&oacute;n:</td><td colspan="5"><textarea readonly="true" name="direccion_ciu" id="direccion_ciu" onblur="formatotexto(this);" style="width:678px; height:30px" onkeyup="return maximaLongitud(this.id,150);"></textarea></td>
								</tr>								
								<tr><td height="20"class="mensaje" align="right" colspan="6">Todos Son Obligatorios</td></tr>								
							</table>						
							</fieldset>
						</td>
					</tr>
					<tr><td height="10" colspan="2"></td></tr>					
					<tr>
						<td colspan="2" align="center">
							<fieldset style="width:98%">
							<legend class="titulomenu">Instancia del Poder Popular</legend>
							<table border="0" cellpadding="0" cellspacing="3" width="100%">
								<tr>
									<td colspan="6" align="right" valign="middle">
										Aplica&nbsp;<input type="radio" name="apli_instanciapp" id="si" checked="checked" onclick="ajustes_instanciapp('expandir');" />
										&nbsp;&nbsp;
										No Aplica&nbsp;<input type="radio" name="apli_instanciapp" id="no" onclick="ajustes_instanciapp('contraer');"/>
										<input type="hidden" name="val_instancia" id="val_instancia" value="0" />
									</td>
								</tr>
							</table><div id="instancia" align="center" style="width:100%">
							<table border="0" cellpadding="3"  cellspacing="3" width="100%" id="contenedor" style="display:">
								<tr ><td height="5"></td></tr>
								<tr>
									<td align="right" width="170">Instancia del Poder Popular:</td><td colspan="3"><input type="text" name="instancia_pp" id="instancia_pp" style="width:530px" onkeypress="return validar(event,letras)" />&nbsp;<span class="mensaje">*</span></td>
								</tr>
								<tr>
									<td align="right" valign="top">Direcci&oacute;n:</td><td colspan="3"><textarea name="direccion_instancia" onkeyup="return maximaLongitud(this.id,150);" id="direccion_instancia" onblur="formatotexto(this);" style="width:530px; height:26px"></textarea>&nbsp;<span class="mensaje">*</span>
									<br /><span style="font-size:9px">M&aacute;ximo 150 Caracteres</span></td>
								</tr>								
								<tr>
									<td align="right" valign="top">Rif.:</td><td align="left" valign="top"><input type="text" name="rif_instancia" id="rif_instancia" onkeypress="return validar(event,numeros+'JjgG-')" onkeyup="mascara(this,'-',patron3,false)" maxlength="15" style="width:150px"/>
									<br /><span style="font-size:9px">Ejm. G-0123456789</span></td>
									<td align="right" valign="top">Ente Financiero:</td><td align="left" valign="top"><input type="text" name="ente_financiero" id="ente_financiero" onkeypress="return validar(event,letras)" maxlength="35" style="width:205px"/></td																	
								></tr>
								<tr>
									<td align="right" width="170">Nombre del Proyecto:</td><td colspan="3"><input type="text" name="nombre_proy" id="nombre_proy" onkeypress="return validar(event,letras)" maxlength="75" style="width:530px" /></td>
								</tr>								
								<tr>
									<td align="right">Monto Financiado:</td><td align="left"><input type="text" name="mon_financiado" id="mon_financiado" style="width:150px" onkeyup="format(this)" maxlength="15" />&nbsp;Bs.</td>
									<td align="left" colspan="2">Pertenece Alg&uacute;n Comit&eacute;:&nbsp;Si&nbsp;<input type="radio" name="perte_comite" id="si_pert" value="0" onclick="pertene(this.id);"/>&nbsp;&nbsp;No<input type="radio" checked="checked" name="perte_comite" id="no_pert" value="1" onclick="pertene(this.id);"/></td																	
								></tr>
								<tr>
									<td align="right" valign="top">Indique el nombre Comit&eacute;:</td><td colspan="3"><textarea readonly="false" name="nomb_comite" onkeyup="return maximaLongitud(this.id,150);" id="nomb_comite" onblur="formatotexto(this);" style="width:530px; height:26px"></textarea>
									<br /><span style="font-size:9px">M&aacute;ximo 150 Caracteres</span></td>
								</tr>								
								<tr><td height="3"class="mensaje" align="right" colspan="4">* Campo Obligatorio</td></tr>
							</table></div>						
							</fieldset>
						</td>
					</tr>
					<tr><td height="10" colspan="2"></td></tr>					
					<tr>
						<td colspan="2" align="center">
							<fieldset style="width:98%">
							<legend class="titulomenu">Miembros de Organizaci&oacute;n Sindical o Gremial</legend>
							<table border="0" cellpadding="0" cellspacing="3" width="100%">
								<tr>
									<td colspan="6" align="right" valign="middle">
										Aplica&nbsp;<input type="radio" name="apli_organizacion" id="si" checked="checked" onclick="ajustes_organizacion('expandir');" />
										&nbsp;&nbsp;										
										No Aplica&nbsp;<input type="radio" name="apli_organizacion" id="no" onclick="ajustes_organizacion('contraer');"/>
										<input type="hidden" name="val_organizacion" id="val_organizacion" value="0" />
									</td>
								</tr>
							</table><div id="organizacion" align="center" style="width:100%">
							<table border="0" cellpadding="3"  cellspacing="3" width="100%" id="contenedor" style="display:">
								<tr ><td height="5"></td></tr>
								<tr>
									<td align="right" width="170">Nombre Organizaci&oacute;n:</td><td colspan="5"><input type="text" name="nom_organizacion" maxlength="75" onkeypress="return validar(event,letras)" id="nom_organizacion" style="width:530px" />&nbsp;<span class="mensaje">*</span></td>
								</tr>
								<tr>
									<td align="right" valign="top">Direcci&oacute;n:</td><td colspan="5"><textarea name="direccion_organizacion" onkeyup="return maximaLongitud(this.id,150);" id="direccion_organizacion" onblur="formatotexto(this);" style="width:530px; height:26px"></textarea>&nbsp;<span class="mensaje">*</span>
									<br /><span style="font-size:9px">M&aacute;ximo 150 Caracteres</span></td>
								</tr>								
								<tr>
									<td align="right" valign="top">Rif.:</td><td align="left" valign="top"><input type="text" name="rif_organizacion" id="rif_organizacion" onkeypress="return validar(event,numeros+'JjgG-')" onkeyup="mascara(this,'-',patron3,false)" maxlength="15" style="width:150px"/>&nbsp;<span class="mensaje">*</span>
									<br /><span style="font-size:9px">Ejm. G-0123456789</span></td>
									<td align="right" valign="top">Telf. Oficina:</td><td align="left" valign="top"><input type="text" name="telef_organizacion" id="telef_organizacion" style="width:87px" onkeypress="return validar(event,numeros+'-')" onkeyup="mascara(this,'-',p_telefonico,false)"/>&nbsp;<span class="mensaje">*</span></td>
									<td align="right" valign="top">Otro Telf.:</td><td align="left" valign="top"><input type="text" name="otr_telef_organizacion" id="otr_telef_organizacion" style="width:87px" onkeypress="return validar(event,numeros+'-')" onkeyup="mascara(this,'-',p_telefonico,false)"/>&nbsp;&nbsp;&nbsp;
									<br /><span style="font-size:9px">Ejm. 0243-01234567</span></td>																										
								</tr>
								<tr><td height="3"  colspan="6"class="mensaje" align="right">* Campo Obligatorio</td></tr>
							</table></div>						
							</fieldset>
						</td>
					</tr>
					<tr><td height="10" colspan="2"></td></tr>					
					<tr>
						<td colspan="2" align="center">
							<fieldset style="width:98%">
							<legend class="titulomenu">Personas, Organismos o Instituciones Involucradas en los Hechos</legend>
							<table border="0" cellpadding="0" cellspacing="3" width="100%">
								<tr>
									<td colspan="6" align="right" valign="middle">
										Aplica&nbsp;<input type="radio" name="apli_involucrados" id="si" checked="checked" onclick="ajustes_involucrados('expandir');" />
										&nbsp;&nbsp;										
										No Aplica&nbsp;<input type="radio" name="apli_involucrados" id="no" onclick="ajustes_involucrados('contraer');"/>
										<input type="hidden" name="val_involucrados" id="val_involucrados" value="0" />
									</td>
								</tr>
							</table><div id="involucrados" align="center" style="width:100%">
							<table border="0" cellpadding="3"  cellspacing="3" width="100%" id="contenedor" style="display:">
								<tr ><td height="5"></td></tr>
								<tr>
									<td align="right" valign="top"><textarea name="hechos" id="hechos" onblur="formatotexto(this);" style="width:710px; height:60px" onkeyup="return maximaLongitud(this.id,400);"></textarea>&nbsp;<span class="mensaje">*</span>
									
									</td>
								</tr>
								<tr><td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:9px">M&aacute;ximo 400 Caracteres</span></td></tr>								
								<tr><td height="3" class="mensaje" align="right">* Campo Obligatorio</td></tr>
							</table></div>						
							</fieldset>
						</td>
					</tr>
					<tr><td height="10" colspan="2"></td></tr>					
					<tr>
						<td colspan="2" align="center">
							<fieldset style="width:98%">
							<legend class="titulomenu">Fecha en la cual Ocurri&oacute; u Ocurrieron los Hechos</legend>
							<table border="0" cellpadding="0" cellspacing="3" width="100%">
								<tr>
									<td colspan="6" align="right" valign="middle">
										Aplica&nbsp;<input type="radio" name="apli_fecha" id="si" checked="checked" onclick="ajustes_fecha('expandir');" />
										&nbsp;&nbsp;										
										No Aplica&nbsp;<input type="radio" name="apli_fecha" id="no" onclick="ajustes_fecha('contraer');"/>
										<input type="hidden" name="val_fecha" id="val_fecha" value="0" />
									</td>
								</tr>
							</table><div id="fecha" align="center" style="width:100%">
							<table border="0" cellpadding="3"  cellspacing="3" width="100%" id="contenedor" style="display:">
								<tr ><td height="5"></td></tr>
								<tr>
									<td align="right" valign="top"><textarea name="fecha_hechos" id="fecha_hechos" onblur="formatotexto(this);" style="width:710px; height:30px" onkeyup="return maximaLongitud(this.id,200);"></textarea>&nbsp;<span class="mensaje">*</span></td>
								</tr>								
								<tr><td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:9px">M&aacute;ximo 200 Caracteres</span></td></tr>
								<tr><td height="3" align="right" class="mensaje">* Campo Obligatorio</td></tr>
							</table></div>						
							</fieldset>
						</td>
					</tr>	
					<tr><td height="10" colspan="2"></td></tr>	
					<tr>
						<td colspan="2" align="center">
							<fieldset style="width:98%">
							<legend class="titulomenu">Pruebas Consignadas</legend>
							<table border="0" cellpadding="0" cellspacing="3" width="100%">
								<tr>
									<td colspan="6" align="right" valign="middle">
										Aplica&nbsp;<input type="radio" name="apli_pruebas" id="si" checked="checked" onclick="ajustes_pruebas('expandir');" />
										&nbsp;&nbsp;										
										No Aplica&nbsp;<input type="radio" name="apli_pruebas" id="no" onclick="ajustes_pruebas('contraer');"/>
										<input type="hidden" name="val_prueba" id="val_prueba" value="0" />
									</td>
								</tr>
							</table><div id="pruebas" align="center" style="width:100%">
							<table border="0" cellpadding="3"  cellspacing="3" width="100%" id="contenedor" style="display:">
								<tr ><td height="5"></td></tr>
								<tr>
									<td align="right" width="110">Documentos:</td><td>Si&nbsp;<input type="radio" name="pru_docu" id="si_do" onclick="habilite(this.id);" checked="checked" />&nbsp;&nbsp;&nbsp;No&nbsp;<input type="radio" name="pru_docu" id="no_do" onclick="habilite(this.id);" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;N&deg; Folios:&nbsp;<input type="text" name="docu_folios" id="docu_folios" style="width:40px" maxlength="3" onkeypress="return validar(event,numeros)" />&nbsp;<span style="font-size:9px">Ejm. 2</span></td>
								</tr>
								<tr>
									<td align="right" width="80">Actas:</td><td>Si&nbsp;<input type="radio" name="pru_actas" id="si_act" onclick="habilite(this.id);"/>&nbsp;&nbsp;&nbsp;No&nbsp;<input type="radio" name="pru_actas" id="no_act" checked="checked" onclick="habilite(this.id);"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;N&deg; Folios:&nbsp;<input type="text" readonly="false" name="acta_folios" id="acta_folios" style="width:40px" maxlength="3" onkeypress="return validar(event,numeros)"/></td>
								</tr>
								<tr>
									<td align="right" width="80">Fotograf&iacute;as:</td><td>Si&nbsp;<input type="radio" name="pru_foto" id="si_fo" onclick="habilite(this.id);"/>&nbsp;&nbsp;&nbsp;No&nbsp;<input type="radio" name="pru_foto" id="no_fo" checked="checked" onclick="habilite(this.id);" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;N&deg; Folios:&nbsp;<input type="text" readonly="false" name="foto_folios" id="foto_folios" style="width:40px" maxlength="3" onkeypress="return validar(event,numeros)" /></td>
								</tr>
								<tr> 
									<td align="right" width="80">Otros (Explique):</td><td>Si&nbsp;<input type="radio" name="pru_otro" id="si_pru_otro" onclick="abcd(this.id);"/>&nbsp;&nbsp;&nbsp;No&nbsp;<input type="radio" name="pru_otro" id="no_pru_otro" checked="checked" onclick="abcd(this.id);" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;N&deg; Folios:&nbsp;<input type="text" readonly="false" name="otros_folios" id="otros_folios" style="width:40px" maxlength="3" onkeypress="return validar(event,numeros)"/></td>
								</tr>																																
								<tr>
									<td align="center" valign="top" colspan="2"><textarea name="pru_otro_descr" id="pru_otro_descr" readonly="false" onblur="formatotexto(this);"  onkeyup="return maximaLongitud(this.id,200);" style="width:710px; height:35px"></textarea></td>
								</tr>								
								<tr><td align="left" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:9px">M&aacute;ximo 200 Caracteres</span></td></tr>
								<tr><td height="3" class="mensaje" colspan="2" align="right"><input type="hidden" name="contenedor_2" id="contenedor_2" /></td></tr>
							</table></div>						
							</fieldset>
						</td>
					</tr>	
					<tr><td height="10" colspan="2"></td></tr>										
					<tr>
						<td colspan="2" align="center">
							<fieldset style="width:98%">
							<legend class="titulomenu">Narraci&oacute;n de los Presuntos Actos, Hechos u Omisiones</legend>
							<table border="0" cellpadding="0" cellspacing="3" width="100%">
								<tr>
									<td colspan="6" align="right" valign="middle">
										Aplica&nbsp;<input type="radio" name="apli_narracion" id="si" checked="checked" onclick="ajustes_narracion('expandir');" />
										&nbsp;&nbsp;										
										No Aplica&nbsp;<input type="radio" name="apli_narracion" id="no" onclick="ajustes_narracion('contraer');"/>
										<input type="hidden" name="val_narracion" id="val_narracion" value="0" />
									</td>
								</tr>
							</table><div id="narracion" align="center" style="width:100%">
							<table border="0" cellpadding="3"  cellspacing="3" width="100%" id="contenedor" style="display:">
								<tr ><td height="5"></td></tr>
								<tr>
									<td align="right" valign="top"><textarea name="narracion_hechos" id="narracion_hechos" onblur="formatotexto(this);" style="width:710px; height:350px" onkeyup="return maximaLongitud(this.id,2000);" ></textarea>&nbsp;<span class="mensaje">*</span></td>
								</tr>								
								<tr><td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:9px">M&aacute;ximo 1200 Caracteres</span></td></tr>
								<tr><td height="3" class="mensaje" align="right">* Campo Obligatorio</td></tr>
							</table></div>						
							</fieldset>
						</td>
					</tr>
					<tr><td height="10" colspan="2"></td></tr>					
					<tr>
						<td colspan="2" align="center">
							<fieldset style="width:98%">
							<legend class="titulomenu">Observaciones</legend>
							<table border="0" cellpadding="0" cellspacing="3" width="100%">
								<tr>
									<td colspan="6" align="right" valign="middle">
										Aplica&nbsp;<input type="radio" name="apli_observacion" id="si" checked="checked" onclick="ajustes_observacion('expandir');" />
										&nbsp;&nbsp;										
										No Aplica&nbsp;<input type="radio" name="apli_observacion" id="no" onclick="ajustes_observacion('contraer');"/>
										<input type="hidden" name="val_observacion" id="val_observacion" value="0" />
									</td>
								</tr>
							</table><div id="observacion" align="center" style="width:100%">
							<table border="0" cellpadding="3"  cellspacing="3" width="100%" id="contenedor" style="display:">
								<tr ><td height="5"></td></tr>
								<tr>
									<td align="right" valign="top"><textarea name="observacion_hechos" id="observacion_hechos" onblur="formatotexto(this);" style="width:710px; height:350px" onkeyup="return maximaLongitud(this.id,2000);"></textarea>&nbsp;<span class="mensaje">*</span></td>
								</tr>								
								<tr><td align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:9px">M&aacute;ximo 400 Caracteres</span></td></tr>
								<tr><td height="3" class="mensaje" align="right">* Campo Obligatorio</td></tr>
							</table></div>						
							</fieldset>
						</td>
					</tr>

					<tr><td height="60" colspan="2" align="center" valign="middle">
						<input type="hidden" name="accion" id="accion" />
						<div id="contenedor_btn" style="width:300px;" align="center">
						<input type="button" style="width:90px" name="registrar" id="registrar" value="Registrar" title="Registrar" onclick="sub_marine();" />&nbsp;&nbsp;
						<input type="reset" style="width:90px" name="registrar" id="registrar" value="Cancelar" title="Cancelar" />
						</div>
					</td></tr>																															
				</table>
			</form>
			</fieldset><br />
		</td>
	</tr>
</table>
<script language="javascript" type="text/javascript">
$(document).ready(function()
{
	valor=$('#ms').val();
	if(valor==1){

		mensaje=acentos('&iexcl;El Reclamo ha sido registrado Exitosamente!')
		$("#mensa").addClass('exito');
		$('#mensa').html(mensaje);
	}
	setTimeout(function(){$(".escuela").fadeOut(6000);},1000); 


});	
</script>