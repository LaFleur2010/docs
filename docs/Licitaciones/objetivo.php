<?php
// Necesario para ver si la session esta activa  o si se tiene permiso de accseso
require("../lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php

if($_SESSION['usd_cot_lee'] != "1")
{
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}//Hasta aquí lo comun para todas las paginas restringidas

/*****************************************************************************************************
	SE INCLUYEN ARCHIVOS DE CONFIGURACION Y FUNCIONES
*****************************************************************************************************/
	include('../inc/config_db.php'); 	// Incluimos archivo de configuracion de la conexion
	include('../inc/lib.db.php');		// Incluimos archivo de libreria de funciones PHP
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>presupuesto Objetivo</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../lib/jquery-1.7.1.min.js"></script> 
<script type="text/javascript" language="JavaScript" src="../inc/funciones.js"></script> 

<script type="text/javascript">

function ingresar(){

	var agree=confirm("Esta Seguro Que desea Ingresar el registro ?");
	if (agree){
		parent.$("#Pobjetivo").val("#");
		document.form2.action='objetivo_p.php';
		document.form2.submit();
		return true ;
	}else{
		return false ;
	}
}

//EStA ES LA FUNCION 
function sumar()
{
	var materiales 	= document.getElementsByName("Cmateriales");
	var mantencion	= document.getElementsByName("Cmantencion");
	var combustible	= document.getElementsByName("Ccombustible");
	var maquinarias	= document.getElementsByName("Cmaquinarias");
	var seguridad	= document.getElementsByName("Cseguridad");
	var externos	= document.getElementsByName("Cexternos");
	var colaciones  = document.getElementsByName("Ccolaciones");
	var total_op 	= document.getElementsByName("Coperacionales");
	


	var resultado = eval(parseInt(materiales.value) + parseInt(mantencion.value) + parseInt(combustible.value) + parseInt(maquinarias.value) + parseInt(seguridad.value) + parseInt(externos.value) + parseInt(colaciones.value)); 
	parseInt(total_op.value) = resultado ; 
	alert(total_op);
 
}
</script>


<style type="text/css">

body {
	background-color:#c0c0c0;
	font-size: 10px;
	font-family: arial;
}
a{
	text-decoration: none;
	border: 0px;
}
.ancho_input input{
	width: 95px;
}
</style>

</head>

<?php
	
$num = $_GET['num'];

$co=mysql_connect("$DNS","$USR","$PASS");
mysql_select_db("$BDATOS",$co);

$sql = "SELECT * FROM tb_p_objetivo where num_cot = '$num'";
$rs  = mysql_query($sql,$co);
$val = mysql_num_rows($rs);

	while ($row = mysql_fetch_array($rs)) {
		
		//operacionales
		$materiales 	= $row['materiales'];
		$mantencion		= $row['mantencion'];
		$combustible	= $row['combustibles'];
		$maquinarias	= $row['arri_maquinarias'];
		$seguridad		= $row['imp_seguridad'];
		$externos		= $row['serv_externos'];
		$colaciones		= $row['colaciones'];
		//Remuneraciones
		$sueldos		= $row['sueldos'];
		$bonos			= $row['bonos'];
		$finiquitos		= $row['finiquitos'];
		$h_extras		= $row['horas_extras'];
		//gastos generales
		$g_generales	= $row['gastos_generales'];
		$otros			= $row['otros_gastos'];
		$bancarios		= $row['gastos_bancarios'];
		$fecha 			= $row['fecha'];

	}

	//TOTAL GENERAL
	$total_general 			= $g_generales + $otros + $bancarios;
	//TOTAL OPERACIONAL
	$total_operacional		= $materiales + $mantencion + $combustible + $maquinarias + $seguridad + $externos + $colaciones;
	//TOTAL DE REMUNERACIONES
	$total_remuneraciones	= $sueldos + $bonos + $finiquitos + $h_extras;
	//TOTAL
	$total = $total_remuneraciones + $total_operacional + $total_general;
?>
<body>
<form action="" name="form2" id="form2" method="POST">
	<input type="hidden" name="tipo_ing" id="tipo_ing" value="<?php echo $_GET['tipo']; ?>">
	<input type="hidden" name="num" id="num" value="<?php echo $_GET['num']; ?>">
<fieldset>
<div>	
<div style="float:left;"><h2 align="center">Presupuesto Objetivo</h2></div>
<div style="float:right; margin-right:100px;"><a href="reporteexcel.php" style="text-decoration:none;"><img style="border:none;" src="../imagenes/excel3.png"><br>Exportar</img></a></div>
</div>
</fieldset>
<fieldset>
	<legend>Gastos Operacionles</legend>
<table border="0" ccellpadding="0" cellspacing="5" bgcolor="#F2F2F2">
<tr>
	<td align="center">Materiales</td>
	<td align="center">Mantenci&oacute;n</td>
	<td align="center">Combustibles</td>
	<td align="center">Arri. de Maquinaria</td>
	<td align="center">Implementos de Seg.</td>
	<td align="center">Servicios Exte.</td>
	<td align="center">Colaciones</td>
</tr>
<tr>
	<td class="ancho_input" align="center"><input type="text" onkeyup="sumar(this);" name="Cmateriales" value="<?php echo $materiales; ?>"></td>
	<td class="ancho_input" align="center"><input type="text" onkeyup="sumar(this);" name="Cmantencion" value="<?php echo $mantencion; ?>"></td>
	<td class="ancho_input" align="center"><input type="text" onkeyup="sumar(this);" name="Ccombustible" value="<?php echo $combustible; ?>"></td>
	<td class="ancho_input" align="center"><input type="text" onkeyup="sumar(this);" name="Cmaquinarias" value="<?php echo $maquinarias; ?>"></td>
	<td class="ancho_input" align="center"><input type="text" onkeyup="sumar(this);" name="Cseguridad" value="<?php echo $seguridad; ?>"></td>
	<td class="ancho_input" align="center"><input type="text" onkeyup="sumar(this);" name="Cexternos" value="<?php echo $externos; ?>"></td>
	<td class="ancho_input" align="center"><input type="text" onkeyup="sumar(this);" name="Ccolaciones" value="<?php echo $colaciones; ?>"></td>
</tr>
</table>
</fieldset>
<br>

<fieldset>
<legend>Remuneraciones</legend>
<table border="0" ccellpadding="0" cellspacing="5" bgcolor="#F2F2F2">
<tr>
	<td>Sueldos</td>
	<td>Bonos</td>
	<td>Finiquitos</td>
	<td>Horas Extras</td>
</tr>
<tr>
	<td class="ancho_input" align="center"><input type="text" name="Csueldos" value="<?php echo $sueldos; ?>"></td>
	<td class="ancho_input" align="center"><input type="text" name="Cbonos" value="<?php echo $bonos; ?>"></td>
	<td class="ancho_input" align="center"><input type="text" name="Cfiniquitos" value="<?php echo $finiquitos; ?>"></td>
	<td class="ancho_input" align="center"><input type="text" name="Ch_extras" value="<?php echo $h_extras; ?>"></td>
</tr>
</table>
</fieldset>
<br>

<fieldset>
<legend>Gastos Generales</legend>
<table border="0" ccellpadding="0" cellspacing="5" bgcolor="#F2F2F2">
<tr>
	<td>Gastos Generales</td>
	<td>Otros Gastos</td>
	<td>Gastos Bancarios</td>
</tr>
<tr>
	<td class="ancho_input" align="center"><input type="text" name="Cg_general" value="<?php echo $g_generales; ?>"></td>
	<td class="ancho_input" align="center"><input type="text" name="Cotros_gastos" value="<?php echo $otros; ?>"></td>
	<td class="ancho_input" align="center"><input type="text" name="Cg_bancarios" value="<?php echo $bancarios; ?>"></td>
</tr>
</table>
</fieldset>	
<br>

<fieldset>
<legend>Informe Toral General</legend>
<table border="0" ccellpadding="0" cellspacing="5" bgcolor="#F2F2F2">
<tr>
	<td>Gastos Operacionales</td>
	<td>G. de Remuneraciones</td>
	<td>Gastos Generales</td>
	<td></td>
	<td align="center">Total</td>
</tr>
<tr>
	<td class="ancho_input" align="center"><input type="text"  value="<?php echo $total_operacional; ?>" name="Coperacionales"></td>
	<td class="ancho_input" align="center"><input type="text" name="Cremuneraciones" value="<?php echo $total_remuneraciones; ?>"></td>
	<td class="ancho_input" align="center"><input type="text" name="Cgenerales" value="<?php echo $total_general; ?>"></td>
	<td class="ancho_input" align="center"><input type="hidden" name="igual">&nbsp;&nbsp;=&nbsp;</td>
	<td class="ancho_input" align="center"><input type="text" name="total"  id="total"value="<?php echo $total; ?>"></td>
</tr>
</table>
</fieldset>
<br>

<fieldset>
<table align="center" border="0">
<tr>
<td align="center">
<input type="submit" class="boton_ing" id="ingresa" name="ingresa" onclick="return ingresar();" value="Ingresar">
<input name="modifica" type="submit" class="boton_mod" id="button5" value="Modificar">
<input name="limpia" type="reset" class="boton_lim" id="limpia" value="Limpiar">
</td>
</tr>
<tr>
<td><span style="color:#ff0000;font-size:12px;">(Es importante Ingresar esta Informaci&oacute;n solo si sera ingresada la Cotizacion o Licitaci&oacute;n)</span></td>
</tr>
</table>
</fieldset>

</form>
</body>
</html>
