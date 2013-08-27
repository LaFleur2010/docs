<?php
require_once "config.php";
$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "SELECT DISTINCT rut_t FROM trabajadores_a WHERE rut_t LIKE '%$q%' ";
$rsd = mysql_query($sql);

while($rs = mysql_fetch_array($rsd)) {
	$rut_t 	= $rs['rut_t'];
	
	echo $rut_t."\n";
}
?>