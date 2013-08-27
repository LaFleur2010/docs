<?php
$con=mysql_connect("localhost","intrauser","intranetmgyt");

if($con){
	mysql_select_db("produccion",$con);
}
else{
	die("No se puede conectar a la base de datos");
}
?>