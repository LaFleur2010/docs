<?php
require_once "config.php";

$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "SELECT DISTINCT desc_sol FROM tb_det_sol WHERE desc_sol LIKE '%$q%' ";
$rsd = mysql_query($sql);

while($rs = mysql_fetch_array($rsd)) {
	$desc_sol 	= $rs['desc_sol'];
	$id_det		= $rs['id_det'];
	
	echo $desc_sol."\n";
}
?>