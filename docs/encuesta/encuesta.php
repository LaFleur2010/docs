<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- DESARROLLADO POR DIEGO FUENTES ACEITUNO SOFTTIME, MAYO 2013-->
<?php error_reporting(0); ?>
<?php
if($_SESSION['Ingreso']!="si"){
	session_unset();
	session_destroy();
	echo "<script>location.href='Index.php';</script>";
}
?>
<html>
<head>

<link rel="stylesheet" type="text/css" href="estilo.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<script type="text/javascript" src="inc/funciones.js" language="javascript"></script>	

</head>
<body>

<?php
include("inc/funcion.php");
$link = conectarse();
?>

<?php

	$sql = "SELECT  max(Numero)as dato  FROM encuesta";
	$rs = mysql_query($sql,$link);
	$id = mysql_fetch_array($rs);
	$id['dato'] = $id['dato'] + 1;
	
?>

<br>
<br>
<div style="margin-top:-5px; margin-right:10px; float:right; border:0px solid #000;">
<img src="img/logo1.png" width="150">
</div>
<br style="clear:both;" />
<div id="menu">

<ul>
<a href="?modulo=centro"><li class="btn_menu">Ingreso de Encuestas</li></a>
<a href="?modulo=estadisticas"><li class="btn_menu">Estadisticas</li></a>
<a href="cerrar.php" onclick="return cerrar();"><li class="btn_menu">Cerrar Sesi&oacute;n</li></a>
</ul>


</div>

<div id="centro">

<?php

	$modulo = $_GET['modulo'];
	switch ($modulo) {
		case 'ingreso':
			$modulo_cargar = "modulos/centro.php";
		break;
		case 'estadisticas':
			$modulo_cargar = "modulos/estadisticas.php";
		break;

		case 'wea':
			$modulo_cargar = "modulos/wea.php";
		break;		


		default:
			$modulo_cargar = "modulos/centro.php";
			break;
	}
	include($modulo_cargar);

?>

</div>
<br style="clear:both;" />
<br>
<hr width="600">
<p class="copy">&copy; Desarrollado por Diego Fuentes Aceituno 2013</p>
<br />
</body>
</html>