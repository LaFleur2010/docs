<?
/**********************************************************************************************************************************
			NECESARIO PARA VER SI LA SESION ESTA ACTIVA O SI TIENE PERMISOS DE ACCESO
**********************************************************************************************************************************/
require("lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php
//
//Definimos el nivel de acceso  (esto es un bonus track para definir que ciertos usuarios puedan entrar a algunas paginas y a otras no)
// Si los usuarios normales tienen acceso=10, para que  accedan todos los usuarios le damos acceso mayor a 10.
$nivel_acceso ="Estandart";
if ($nivel_acceso == $_SESSION['us_tipo']){
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}
//Hasta aquí lo comun para todas las paginas restringidas
//*********************************************************************************************************************************
// INCLUIMOS LIBRERIAS
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
$ruta	= "imagenes/fotos/";
$ext	= ".jpg";
$rut	= $_POST['t1'];
$_POST['fe_nulo']	= cambiarFecha($_POST['fe_nulo'], '/', '-' );
if($_POST['fe_nulo'] == ""){$_POST['fe_nulo'] = "0000-00-00";}

/**********************************************************************************************************************************	
					INGRESO DE TRABAJADORES
**********************************************************************************************************************************/
if($_POST['IngresaTrab']=="Ingresar")
{ 	
	$_POST['t2'] = ucwords($_POST['t2']);
		
	$_POST['t3'] = ucwords($_POST['t3']);
		
	$_POST['t4'] = ucwords($_POST['t4']);
	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
		
	/*$query	= "SELECT rut_t FROM trabajadores WHERE rut_t='".$_POST['t1']."' ";
	$result	= mysql_query($query,$co);
	$cant	= mysql_num_rows($result);
	if($cant == 0)
	{*/
			if($_FILES['archivo_usuario'] != "")
			{
				move_uploaded_file($_FILES['archivo_usuario']['tmp_name'], $ruta.$rut.$ext );
			}
				
			$sqli = "INSERT INTO trabajadores (rut_t, nom_t, app_t, apm_t,area_t, cargo_t, fonom_t, fonoc_t, correo_t, ruta_foto, est_alta, fe_nulo) VALUES('".$_POST['t1']."','".$_POST['t2']."','".$_POST['t3']."','".$_POST['t4']."','".$_POST['combo3']."','".$_POST['c1']."','".$_POST['t5']."', '".$_POST['t6']."', '".$_POST['t7']."', '$ruta$rut$ext', 'Vigente', '0000-00-00')";
			alert($sqli);
			$resp_query_in = mysql_query($sqli, $co);
			
			if(resp_query_in)
			{
				$cod_trab_ing = mysql_insert_id($co); //para saber el codigo de el trabajador ingresado
				
				echo"<input type='hidden' name='ingresa' id='ingresa' value = '$cod_trab_ing' />";		
				echo "<script language='Javascript'>
					alert('El Trabajador Fue Ingresado Correctamente');
					document.formp.action='trabajadores.php';
					document.formp.submit();
				 </script>";
			}else{
				echo"<input type='hidden' name='ingresa' id='ingresa' value = '$cod_trab_ing' />";		
				echo "<script language='Javascript'>
					alert('El Ingreso a Fallado');
					document.formp.action='trabajadores.php';
					document.formp.submit();
				 </script>";
			} 
	/*}else{
		echo"<input type='hidden' name='procesa' id='procesa' value='".$_POST['t1']."' />";		
		echo "<script language='Javascript'>
			alert('El Rut ya esta ingresado');
			document.formp.action='trabajadores.php';
			document.formp.submit();
		 </script>";
			} */
}
/**********************************************************************************************************************************	
					MODIFICAR REGISTROS DE TRABAJADORES
**********************************************************************************************************************************/		
if($_POST['modificaTrab'] == "Modificar")
{
	$_POST['t2'] = ucwords($_POST['t2']);
	$_POST['t3'] = ucwords($_POST['t3']);
	$_POST['t4'] = ucwords($_POST['t4']);
	
	$sql	= "UPDATE trabajadores SET 	nom_t			= '".$_POST['t2']."', 
										app_t			= '".$_POST['t3']."', 
										apm_t			= '".$_POST['t4']."', 
										area_t			= '".$_POST['combo3']."', 
										cargo_t			= '".$_POST['c1']."', 
										fonom_t			= '".$_POST['t5']."', 
										fonoc_t			= '".$_POST['t6']."', 
										correo_t		= '".$_POST['t7']."',
										est_alta		= '".$_POST['estado']."', 
										fe_nulo	    	= '".$_POST['fe_nulo']."',
										ruta_foto 		= '$ruta$rut$ext' 
										WHERE cod_trab 	= '".$_POST['cod_t']."' ";
										alert($sql);
	if(dbExecute($sql))
	{
		if($_FILES['archivo_usuario'] != "")
		{
			move_uploaded_file($_FILES['archivo_usuario']['tmp_name'], $ruta.$rut.$ext);
		}
		echo"<input type='hidden' name='modifica' id='modifica' value='".$_POST['cod_t']."' />";		
		echo "<script language='Javascript'>
			alert('El Trabajador Fue Modificado Correctamente');
			document.formp.action='trabajadores.php';
			document.formp.submit();
		</script>";
	}else{
		echo"<input type='hidden' name='modifica' id='modifica' value='".$_POST['cod_t']."' />";		
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
if($_POST['EliminaTrab'] == "Eliminar")
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
}	
?>
<?php

if($_POST['sol_lee'] 	== "on"){ $sol_lee 		= "1"; }else{$sol_lee 		= 0; }
if($_POST['sol_ing'] 	== "on"){ $sol_ing 		= "1"; }else{$sol_ing 		= 0; }

if($_POST['sol_ap_dep'] == "on"){ $sol_ap_dep 	= "1"; }else{$sol_ap_dep 	= 0; }
if($_POST['sol_ap_ger'] == "on"){ $sol_ap_ger 	= "1"; }else{$sol_ap_ger 	= 0; }
if($_POST['sol_ap_bod'] == "on"){ $sol_ap_bod 	= "1"; }else{$sol_ap_bod 	= 0; }

if($_POST['sol_us_bod'] == "on"){ $sol_us_bod 	= "1"; }else{$sol_us_bod 	= 0; }
if($_POST['sol_us_adq'] == "on"){ $sol_us_adq 	= "1"; }else{$sol_us_adq 	= 0; }

if($_POST['cot_lee'] 	== "on"){ $cot_lee 	= "1"; }else{$cot_lee 	= 0; }
if($_POST['cot_ing'] 	== "on"){ $cot_ing 	= "1"; }else{$cot_ing 	= 0; }
if($_POST['cot_mod'] 	== "on"){ $cot_mod 	= "1"; }else{$cot_mod 	= 0; }
if($_POST['cot_eli'] 	== "on"){ $cot_eli 	= "1"; }else{$cot_eli 	= 0; }
/***********************************************************************************************************************
							INGRESAMOS UN USUARIO 
***********************************************************************************************************************/	
if($_POST['ingresaUs'] == "Ingresar")
{
	$co = mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);

	$_POST['us_pass'] = md5($_POST['us_pass']);
	
		$sql = "INSERT INTO tb_usuarios 
				(us_usuario, 
				us_pass, 
				us_rut, 
				us_nombre, 
				us_cargo, 
				us_correo, 
				us_ing_internet, 
				us_tipo, 
				usd_sol_lee, 
				usd_sol_ing, 
				usd_sol_ap_dep, 
				usd_sol_ap_ger, 
				usd_sol_ap_bod, 
				usd_sol_us_bod, 
				usd_sol_us_adq, 
				usd_cot_lee,
				usd_cot_ing, 
				usd_cot_mod, 
				usd_cot_eli
				) 
		
		VALUES( '".$_POST['us_usuario']."', 
				'".$_POST['us_pass']."', 
				'".$_POST['us_rut']."', 
				'".$_POST['us_nombre']."', 
				'".$_POST['us_cargo']."',
				'".$_POST['us_correo']."', 
				'".$_POST['us_ing_internet']."', 
				'".$_POST['us_tipo']."', 
				'$sol_lee',
				'$sol_ing',
				'$sol_ap_dep',
				'$sol_ap_ger',
				'$sol_ap_bod',
				'$sol_us_bod',
				'$sol_us_adq',
				'$cot_lee',
				'$cot_ing',
				'$cot_mod',
				'$cot_eli'
				)";
		
				$resp_sql_in = mysql_query($sql, $co);
		
				if($resp_sql_in)
				{
					$id_us_ing = mysql_insert_id($co); //para saber el codigo de la solicitud ingresada en la tabla sol_rec
					//*******************************************************************************************************		
					echo"<input type='hidden' name='ingresa' id='ingresa' value='$id_us_ing' />";		
					echo "<script language='Javascript'>
						alert('El Usuario Fue Ingresado Correctamente');
						document.formp.action='usuarios.php';
						document.formp.submit();
					</script>";
				}else{
					echo"<input type='hidden' name='ingresa' id='ingresa' value='$id_us_ing' />";		
					echo "<script language='Javascript'>
						alert('El Ingreso a Fallado');
						document.formp.action='usuarios.php';
						document.formp.submit();
					</script>";
				}

}

/***********************************************************************************************************************
							MODIFICAMOS EL USUARIO
***********************************************************************************************************************/		
if($_POST['modificaUs'] == "Modificar")
{	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sqlc 		= "SELECT * FROM tb_usuarios WHERE us_id = '".$_POST['us_id']."'";
	$respuesta	= mysql_query($sqlc,$co);
	while($vrows=mysql_fetch_array($respuesta))
	{
		$clave = "".$vrows['us_pass'].""; 							
	}
	
	if($clave != $_POST['us_pass']){
		$npass=md5($_POST['us_pass']);
	}else{ $npass=$_POST['us_pass'];}
	
	$sql	= "UPDATE tb_usuarios SET 	us_usuario		= '".$_POST['us_usuario']."',
										us_pass			= '$npass',
										us_rut			= '".$_POST['us_rut']."',
										us_nombre		= '".$_POST['us_nombre']."',
										us_cargo		= '".$_POST['us_cargo']."', 
										us_correo		= '".$_POST['us_correo']."', 
										us_ing_internet	= '".$_POST['us_ing_internet']."', 
										us_tipo			= '".$_POST['us_tipo']."', 
										usd_sol_lee		= '$sol_lee', 
										usd_sol_ing		= '$sol_ing', 
										usd_sol_ap_dep	= '$sol_ap_dep', 
										usd_sol_ap_ger	= '$sol_ap_ger', 
										usd_sol_ap_bod	= '$sol_ap_bod', 
										usd_sol_us_bod	= '$sol_us_bod', 
										usd_sol_us_adq	= '$sol_us_adq', 
										usd_cot_lee		= '$cot_lee',
										usd_cot_ing		= '$cot_ing', 
										usd_cot_mod		= '$cot_mod', 
										usd_cot_eli		= '$cot_eli'	
									
										WHERE us_id 	= '".$_POST['us_id']."' ";
	if(dbExecute($sql))
	{
		echo"<input type='hidden' name='modifica' id='modifica' value='".$_POST['us_id']."' />";		
		echo "<script language='Javascript'>
			alert('El Usuario Fue Modificado Correctamente');
			document.formp.action='usuarios.php';
			document.formp.submit();
		</script>";
	}else{
		echo"<input type='hidden' name='modifica' id='modifica' value='".$_POST['us_id']."' />";		
		echo "<script language='Javascript'>
			alert('La Modificacion de el usuario Ha Fallado');
			document.formp.action='usuarios.php';
			document.formp.submit();
		</script>";
	}

}	

?>

</form>
<body>
</body>
</html>
