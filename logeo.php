<?
if(!stristr($_SERVER['SCRIPT_NAME'],"index.php")){
//<form action="sprivelegio.php" name="ilegal" id="ilegal" method="post">
	$hmtl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
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
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><? echo _SISTEMA; ?></title>
<link href="<? echo _HOJA; ?>style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="images/sicca.png" type="image/x-icon">
</head>
<body style="overflow-x: hidden; overflow-y: hidden"> 
<form action="" method="post" name="form" id="form" autocomplete="off">
<table align=center id="Tabla_01" width="1024" height="768" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="3" background="images/logeo/logueo_01.jpg" width="1024" height="272">
		</td>
	</tr>
	<tr>
		<td background="images/logeo/logueo_02.jpg" width="193" height="496">
		</td>
		<td background="images/logeo/logueo_03.jpg" width="633" height="496" align="center" valign="top">
			<br /><br /><br /><br />
			<table border="0" background="images/logeo/cuadro-interno.png" width="360" height="220">
				<tr>
					<td rowspan=3 align=center><img src=images/logeo/lock.png></td>
					<td height=26></td>
				</tr>
				<tr>
					<td valign="middle">
						<table border="0" width="100%" cellpadding="4" cellspacing="2" class="text_logeo">
							<tr>
								<td align="right">Usuario:</td>
								<td ><input type="text" name="usuario" id="usuario" /></td>
							</tr>
							<tr>
								<td align="right">Clave:</td>
								<td><input type="password" name="clave" id="clave" /></td>								
							</tr>				
							<tr><td height="7px"></td></tr>							
							<tr>
								<td align="center" colspan="2">
									<input type="submit" value="Iniciar" />
									<input type="reset" value="Cancelar" />					
								</td>
							</tr>
							<tr>
								<td colspan="2" valign="top" align="center"><br />
									<? if (isset($_SESSION["mensaje"])) { echo "<span class=\"mensaje_fallo\">".$_SESSION["mensaje"]."</span>"; }?>
								</td>
							</tr>																	
						</table>
					</td>
				</tr>				
			</table>		
		</td>
		<td background="images/logeo/logueo_04.jpg" width="198" height="496">	
		</td>
	</tr>

</table>		
</form>
<script language="javascript" type="text/javascript">document.getElementById("usuario").focus();</script>
</body>
</html>