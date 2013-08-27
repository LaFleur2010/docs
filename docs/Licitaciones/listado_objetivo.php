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

<?php
	
	$num = $_POST['num'];

	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS",$co);

	$sql = "SELECT * FROM tb_p_objetivo where num_cot = '$num'";
	$rs  = mysql_query($sql,$con);
	$val = mysql_num_rows($rs);

	if ($val > 0) {
		
		while ($row = mysql_fetch_array($rs)) {
			
			$materiales = $row['materiales'];
		}
	}

?>