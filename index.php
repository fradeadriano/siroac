<?
if(!stristr($_SERVER['SCRIPT_NAME'],"index.php")){
	$hmtl = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Acceso Denegado</title>
</head>
<body background="images/backsystems.jpg">
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
require_once("configuracion.php");
require_once("verificacion.php");
$var__sesion = $_SESSION["usuario"];
if(!isset($var__sesion)){
	require_once("logeo.php");
}else{
	require_once("cabecera.php");
	require_once("cuerpo.php");
	require_once("pie.php");
}
?>