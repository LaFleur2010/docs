<?
/**********************************************************************************************************************************
			NECESARIO PARA VER SI LA SESION ESTA ACTIVA O SI TIENE PERMISOS DE ACCESO
**********************************************************************************************************************************/
require("lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php
//
//Definimos el nivel de acceso  (esto es un bonus track para definir que ciertos usuarios puedan entrar a algunas paginas y a otras no)
// Si los usuarios normales tienen acceso=10, para que  accedan todos los usuarios le damos acceso mayor a 10.
$nivel_acceso =10;
if ($nivel_acceso < $_SESSION['usuario_nivel']){
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}
//Hasta aquí lo comun para todas las paginas restringidas
//*********************************************************************************************************************************
	include('inc/config_db.php');	// CONECCION A LA BASE DE DATOS
	require('inc/lib.db.php');
	$fecha	= date("Y-m-d");		// FECHA DE HOY
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Procesando...</title>
</head>
<body>
<form id="f_eli" name="f_eli" method="post" action="">
<?php
/***********************************************************************************************************************
		ELIMINAMOS EL DOCUMENTO
***********************************************************************************************************************/	 			
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$id_d			= $_GET['id'];
	$cod			= $_GET['cod'];
	$tabla			= $_GET['tabla'];
	$dest			= $_GET['dest'];
	$usuario_pyc	= $_GET['usuario'];
	
		$sqld = "DELETE FROM $tabla WHERE id_det = $id_d ";
		mysql_query($sqld,$co);
		
		if(dbExecute($sqld))
		{
			echo"<input type='hidden' name='elimina_item' id='elimina_item' value='$cod' />";
			echo"<input type='hidden' name='usuario' id='usuario' value='$usuario_pyc' />";
			echo "<script language='Javascript'>
				document.f_eli.action='$dest';
				document.f_eli.submit();
        	</script>";
		}else
			{ 
				echo"<input type='hidden' name='elimina_item' id='elimina_item' value='$cod' />";
				echo"<input type='hidden' name='usuario' id='usuario' value='$usuario_pyc' />";
				echo "<script language='Javascript'>
           			alert('¡ERROR! Al Eliminar Item');
					document.f_eli.action='$dest';
					document.f_eli.submit();
        		</script>";
			}
?>
</form>
</body>
</html>
