<?php
$host_name = 'bG9jYWxob3N0';
$user_name = 'c2lyb2Fj';
$pass_word = 'MTIzNA==';
$database_name = 'c2lyb2Fj';
/*$host_name = 'bG9jYWxob3N0';
$user_name = 'c2ljY2E=';
$pass_word = 'ZGVsMWFsOA==';
$database_name = 'c2ljY2E=';*/

$conn = mysql_connect(base64_decode($host_name), base64_decode($user_name), base64_decode($pass_word)) or die ('Error connecting to mysql');
mysql_select_db(base64_decode($database_name));

$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "SELECT registro_mecanismo.`n_expediente`, registro_mecanismo.`id_registro_mecanismo` FROM registro_mecanismo WHERE registro_mecanismo.`n_expediente` LIKE '%$q%'";
$rsd = mysql_query($sql);
while($rs = mysql_fetch_array($rsd)) {
	$cid = $rs['id_registro_mecanismo'];
	$cname = html_entity_decode($rs['n_expediente'], ENT_COMPAT, 'UTF-8');
	echo "$cname|$cid\n";
}echo "<span style='font-weight:bold; color:#990000;'>".html_entity_decode("No Ex&iacute;ste el Expediente", ENT_COMPAT, 'UTF-8')."</span>"; 
?>
