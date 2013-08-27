<?php
require_once "config.php";
$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "SELECT DISTINCT desc_pno FROM tb_planos WHERE desc_pno LIKE '%$q%' ";
$rsd = mysql_query($sql);

while($rs = mysql_fetch_array($rsd)) {
	$desc_pno 	= $rs['desc_pno'];
	$cod_pno	= $rs['cod_pno'];
	
	echo $desc_pno."\n";
}
?>