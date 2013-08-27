<?
/**********************************************************************************************************************************
			NECESARIO PARA VER SI LA SESION ESTA ACTIVA O SI TIENE PERMISOS DE ACCESO
**********************************************************************************************************************************/
require("lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php
//
//Definimos el nivel de acceso  (esto es un bonus track para definir que ciertos usuarios puedan entrar a algunas paginas y a otras no)
// Si los usuarios normales tienen acceso=10, para que  accedan todos los usuarios le damos acceso mayor a 10.
$nivel_acceso =12;
if ($nivel_acceso < $_SESSION['usuario_nivel']){
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}
//Hasta aquí lo comun para todas las paginas restringidas
//*********************************************************************************************************************************
?>
<?php
//*********************************************************************************************************************************
	include ('inc/config_db.php');
	require ("inc/lib.db.php");
//*********************************************************************************************************************************
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Procesa</title>

</head>
<form name="formp" action="" method="post">
<?php
$ruta="imagenes/fotos/";
$ext=".jpg";
$rut= $POST['t1'];
 
if($_POST['fe_nulo'] == ""){$_POST['fe_nulo'] = "0000-00-00";}else{$_POST['fe_nulo'] =	cambiarFecha($_POST['fe_nulo'], '/', '-' );}

/**********************************************************************************************************************************	
					INGRESO DE TRABAJADORES
**********************************************************************************************************************************/
/*if($_POST['IngresaTrab']=="Ingresar")
{ 	
	$_POST['t2'] = ucwords($_POST['t2']);
		
	$_POST['t3'] = ucwords($_POST['t3']);
		
	$_POST['t4'] = ucwords($_POST['t4']);
	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
		
	$query="SELECT rut_t FROM trabajadores WHERE rut_t='".$_POST['t1']."' ";
	$result=mysql_query($query,$co);
	$cant=mysql_num_rows($result);
	if($cant==0)
	{
			if($_FILES['archivo_usuario'] != "")
			{
				move_uploaded_file($_FILES['archivo_usuario']['tmp_name'], $ruta.$rut.$ext );
			}
				
			$sqli = "INSERT INTO trabajadores VALUES('".$_POST['t1']."','".$_POST['t2']."','".$_POST['t3']."','".$_POST['t4']."','".$_POST['combo3']."','".$_POST['c2']."','".$_POST['t5']."', '".$_POST['t6']."', '".$_POST['t7']."', '$ruta$rut$ext', '".$_POST['estado']."', '".$_POST['fe_nulo']."')";
			if(dbExecute($sqli))
			{
				echo"<input type='hidden' name='procesa' id='procesa' value='".$_POST['t1']."' />";		
				echo "<script language='Javascript'>
					alert('El Trabajador Fue Ingresado Correctamente');
					document.formp.action='trabajadores.php';
					document.formp.submit();
				 </script>";
			}else{
				echo"<input type='hidden' name='procesa' id='procesa' value='".$_POST['t1']."' />";		
				echo "<script language='Javascript'>
					alert('El Ingreso a Fallado');
					document.formp.action='trabajadores.php';
					document.formp.submit();
				 </script>";
			} 
	}else{		
				echo "<script language='Javascript'>
					alert('El trabajador ya esta ingresado');
					document.formp.action='trabajadores.php';
					document.formp.submit();
				 </script>";
			} 
}
/**********************************************************************************************************************************	
					MODIFICAR REGISTROS DE TRABAJADORES
**********************************************************************************************************************************/		
if($_POST['modificaTrab'] == "Modificar")
{
	if($_POST['fe_nulo'] == ""){$_POST['fe_nulo'] = "0000-00-00";}
	$sql="UPDATE trabajadores SET nom_t='".$_POST['t2']."', app_t='".$_POST['t3']."', apm_t='".$_POST['t4']."', area_t='".$_POST['combo3']."', cargo_t='".$_POST['c2']."', fonom_t='".$_POST['t5']."', fonoc_t='".$_POST['t6']."', correo_t='".$_POST['t7']."', ruta_foto = '$ruta$rut$ext', estado = '".$_POST['estado']."', fe_nulo = '".$_POST['fe_nulo']."' WHERE rut_t ='".$_POST['t1']."' ";
	if(dbExecute($sql))
	{
		if($_FILES['archivo_usuario'] != "")
		{
			move_uploaded_file($_FILES['archivo_usuario']['tmp_name'], $ruta.$rut.$ext);
		}
		echo"<input type='hidden' name='procesa' id='procesa' value='".$_POST['t1']."' />";		
		echo "<script language='Javascript'>
			alert('El Trabajador Fue Modificado Correctamente');
			document.formp.action='trabajadores.php';
			document.formp.submit();
		</script>";
	}else{
		echo"<input type='hidden' name='procesa' id='procesa' value='".$_POST['t1']."' />";		
		echo "<script language='Javascript'>
			alert('La Modificacion a Fallado');
			document.formp.action='trabajadores.php';
			document.formp.submit();
		</script>";
	}
}	
/**********************************************************************************************************************************	
				ELIMINAR TRABAJADORES
**********************************************************************************************************************************/
/*if($_POST['EliminaTrab']=="Eliminar")
{
	$sqld1="DELETE FROM trabajadores WHERE rut_t='".$_POST['t1']."'";
	if(dbExecute($sqld1))
	{
		echo"<input type='hidden' name='procesa' id='procesa' value='".$_POST['t1']."' />";		
		echo "<script language='Javascript'>
			alert('El Trabajador Fue Eliminado Correctamente');
			document.formp.action='trabajadores.php';
			document.formp.submit();
		</script>";
	}else{
		echo"<input type='hidden' name='procesa' id='procesa' value='".$_POST['t1']."' />";		
		echo "<script language='Javascript'>
			alert('La Operacion a Fallado');
			document.formp.action='trabajadores.php';
			document.formp.submit();
		</script>";
	}
}	*/	
?>
</form>
<body>
</body>
</html>
