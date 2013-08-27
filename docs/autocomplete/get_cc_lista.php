<?php

include('../sw/config_db.php');
$q = strtolower($_GET["q"]);
if (!$q) return;

$co=mssql_connect("$SERVER","$USR","$PASS");
mssql_select_db("$BDATOS", $co);

$sql = "SELECT DISTINCT DescCC, CodiCC FROM softland.cwtccos WHERE CodiCC LIKE '$q%' ";
$rsd = mssql_query($sql);
while($rs = mssql_fetch_assoc($rsd)) {
	$DescCC 	= "".utf8_encode($rs['DescCC'])."";
	$CodiCC	 	= $rs['CodiCC'];
	
	echo $CodiCC." ".$DescCC."\n";
}
?>