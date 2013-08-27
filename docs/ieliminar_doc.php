<?
error_reporting(0);
// Necesario para ver si la session esta activa  o si se tiene permiso de accseso
require("lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php

if($_SESSION['usd_cot_lee'] != "1")
{
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}//Hasta aquí lo comun para todas las paginas restringidas
//*********************************************************************************************************************************
	include('inc/config_db.php'); 	// Incluimos archivo de configuracion de la conexion
	include('inc/lib.db.php');		// Incluimos archivo de libreria de funciones PHP
	$fecha	= date("Y-m-d");		// FECHA DE HOY
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Procesa2</title>

<script language="javascript">
function Enviar()
{
	document.f2.submit();
}
</script>
</head>

<body>

<form id="feli" name="feli" method="post" action="Licitaciones/documentos.php">

<?php

/*************************************************************
		ELIMINAMOS EL DOCUMENTO
**************************************************************/	 			
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);

		$sqld = "DELETE FROM documentos WHERE id_doc ='".$_GET['id']."' ";
		mysql_query($sqld,$co);
		if(dbExecute($sqld))
		{
			unlink($_GET['ruta']);
			echo"<input type='hidden' name='elimina' id='elimina' value='".$_GET['ods']."' />";
			echo "<script language='Javascript'>
           		alert('EL DOCUMENTO FUE ELIMINADO CORRECTAMENTE');
				document.feli.submit();
        	</script>";
		}else
			{ 
				echo"<input type='hidden' name='elimina' id='elimina' value='".$_GET['ods']."' />";
				echo "<script language='Javascript'>
           			alert('¡ERROR! Al Eliminar el Documento');
					document.feli.submit();
        		</script>";
			}
?>  
</form>
</body>
</html>