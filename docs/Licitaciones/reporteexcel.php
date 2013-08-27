<?php
//esto le indica al navegador que muestre el diálogo de descarga aún sin haber descargado todo el contenido
 
header("Content-type: application/vnd.ms-excel;charset=utf-8");
//indicamos al navegador que se está devolviendo un archivo
header("Content-Disposition: attachment; filename=reporte.xls");
//con esto evitamos que el navegador lo grabe en su caché
header("Pragma: no-cache");
header("Expires: 0");
//damos salida a la tabla
?>
<?php
// Necesario para ver si la session esta activa  o si se tiene permiso de accseso
require("../lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php

/*****************************************************************************************************
	SE INCLUYEN ARCHIVOS DE CONFIGURACION Y FUNCIONES
*****************************************************************************************************/
	include('../inc/config_db.php'); 	// Incluimos archivo de configuracion de la conexion
	include('../inc/lib.db.php');		// Incluimos archivo de libreria de funciones PHP
?>

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
<html>
<head>
</head>
<body>
<form action="" name="form2" id="form2" method="POST">
	<input type="hidden" name="tipo_ing" id="tipo_ing" value="<?php echo $_GET['tipo']; ?>">
	<input type="hidden" name="num" id="num" value="<?php echo $_GET['num']; ?>">
<fieldset>
<div>	
<div style="float:left;"><h2 align="center">Presupuesto Objetivo</h2></div>
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
	<td class="ancho_input" align="center"><input type="text" onkeyup="sumar(this;" name="Cexternos" value="<?php echo $externos; ?>"></td>
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
	<td class="ancho_input" align="center"><input type="text" value="<?php echo $total_operacional; ?>" name="Coperacionales"></td>
	<td class="ancho_input" align="center"><input type="text" name="Cremuneraciones" value="<?php echo $total_remuneraciones; ?>"></td>
	<td class="ancho_input" align="center"><input type="text" name="Cgenerales" value="<?php echo $total_general; ?>"></td>
	<td class="ancho_input" align="center"><input type="hidden" name="igual">&nbsp;&nbsp;=&nbsp;</td>
	<td class="ancho_input" align="center"><input type="text" name="total"  id="total"value="<?php echo $total; ?>"></td>
</tr>
</table>
</fieldset>
<br>


</form>
</body>
</html>