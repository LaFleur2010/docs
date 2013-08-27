<?
// Necesario para ver si la session esta activa  o si se tiene permiso de accseso
require("../lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php

if($_SESSION['usd_sol_lee'] != "1")
{
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}//Hasta aquí lo comun para todas las paginas restringidas

//**********************************************************************************************************************
	include('../inc/config_db.php');	// CONECCION A LA BASE DE DATOS
	require("../inc/lib.db.php");		// FUNCIONES VARIAS
/**********************************************************************************************************************/
	
	$est  = "Presente";
	$fe   = date("Y-m-d");
	$hr	  = date("H:i:s");	
	$num  = 2;	
//**********************************************************************************************************************
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Procesando...</title>

<script type="text/javascript" language="JavaScript" src="../inc/funciones.js"></script>

</head>
<body>
<form id="f7" name="f7" method="post" action="oc_fsr.php">
<?php

 $us	= $_SESSION['usuario_nombre'];
/*********************************************************************************************************************************
				MODIFICAMOS EL ESTADO DE RECEPCION DE LA SOLICITUD
*********************************************************************************************************************************/	
if($_POST['adquisiciones'] == "Modificar")
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS",$co);
													
		$SqlUpd = "UPDATE tb_det_sol SET num_oc 	 = '".$_POST['num_oc']."'
										WHERE id_det = '".$_POST['id']."' ";
		if(dbExecute($SqlUpd))
		{
			echo"<input type='hidden' name='modifica' id='modifica' value='".$_POST['id']."' />";
			echo "<script language='Javascript'>
				
				alert('La Modificacion se Realizo Correctamente');
				document.f7.submit();
			</script>";
		}else{
			echo"<input type='hidden' name='modifica' id='modifica' value='".$_POST['id']."' />";
			echo "<script language='Javascript'>
				
				alert('ERROR: No se pudo Modificar la OC');
				document.f7.submit();
			</script>";
		}
}
?>
</form>
</body>
</html>
