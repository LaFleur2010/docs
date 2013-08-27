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
//********************************************************************************************************************************
	include ('inc/config_db.php');
	require('inc/lib.db.php');

	$fe   = date("d/m/Y");
	$num  = 2;	
//********************************************************************************************************************************
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Informe Diario Personal</title>

<link href="inc/bibliocss.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="JavaScript" src="inc/funciones.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="stmenu.js"></script>
<LINK href="inc/epoch_styles.css" type=text/css rel=stylesheet>
<SCRIPT src="inc/epoch_classes.js" type=text/javascript></SCRIPT>

</head>
<body>
<form id="f7" name="f7" method="post" action="asistencia.php">

 <?php
 
 $_POST['f1']	= cambiarFecha($_POST['f1'], '/', '-' ); 
 $cont_w		= count($_POST['rut']);
/*********************************************************************************************************************************
								INGRESAMOS EL INFORME 
*********************************************************************************************************************************/			
if($_POST['ingresa'] == "Ingresar" and $_POST['c3'] != "")
{	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS",$co);
	
	$query  = "SELECT * FROM asistencia WHERE fecha_as = '".$_POST['f1']."' and area_as = '".$_POST['c3']."' ";
	$result = mysql_query($query,$co);
	$cant = mysql_num_rows($result);
		
	if($cant == 0)// SI NO ENCONTRO NINGUN REGISTRO ENTONCES LO INGRESAMOS
	{	
		$consulta	= mysql_query("SELECT max(cod_as) FROM asistencia"); 
		$M_cod_inf 	= mysql_result($consulta,0);
		$N_cod_as	= ($M_cod_inf + 1);
//*************************************** INSERTAR INF_DIARIO ********************************************************************
		$sqli = "INSERT INTO asistencia (cod_as, area_as, fecha_as, ing_as) values('$N_cod_as', '".$_POST['c3']."', '".$_POST['f1']."', '".$_SESSION['usuario_nombre']."' )";
		if(dbExecute($sqli))// SI SE INGRESO CORRECTAMENTE ---- INGRESAMOS LOS ITEMS
		{
//********************************************************************************************************************************		
			$x=0;						// VARIABLE PARA INICIALIZAR EL CONTADOR	
			while($x < $cont_w)
			{			
					$co=mysql_connect("$DNS","$USR","$PASS");
					mysql_select_db("$BDATOS",$co);
					
					if($_POST['aux'][$x] == 'Presente') 
					{
						$est	= "Presente";
					}else
					{
						$est= "Ausente";
					}
					
					$SqlDet="INSERT INTO detalle_as (cod_as, rut_det_as, estado_det_as, motivo_det_as, observ_det_as) VALUES('$N_cod_as', '".$_POST['rut'][$x]."', '$est', '".$_POST['aux_mot'][$x]."', '".$_POST['obs'][$x]."' )";
					if(dbExecute($SqlDet))
					{	
						echo"<input type='hidden' name='Ing_a' id='Ing_a' value='$N_cod_as' />";	
						echo"<script language='Javascript'>
						
							
							document.f7.submit();
						</script>";
					}else{
						$sqld="DELETE FROM asistencia WHERE cod_as = '$N_cod_as' ";
						echo"<input type='hidden' name='ingresa' id='ingresa' value='$N_cod_as' />";
						echo "<script language='Javascript'>
							alert('¡¡ERROR!! El Ingreso del Informe a Fallado');
							document.f7.submit();
						</script>";
					}
				//}// trabajadores
			$x++;
			} // while
		}else{
				echo"<input type='hidden' name='ingresa' id='ingresa' value='$N_cod_as' />";
				echo "<script language='Javascript'>
					alert('¡¡ERROR!! El Ingreso del Informe a Fallado');
					document.f7.submit();
				</script>";
		}// if ingreso
	}else{						// fin if si no existe
		$fecha 	= $_POST['f1'];
		
		$fecha	= cambiarFecha($fecha, '-', '/' );
		
		$sql_a	= "SELECT * FROM tb_areas WHERE cod_ar = '".$_POST['c3']."' ";
		$res_a	= mysql_query($sql_a,$co);
		while($vrowsa=mysql_fetch_array($res_a))
		{
			$area	= "".$vrowsa['desc_ar']."";
		}
		
		echo"<input type='hidden' name='ingresa' id='ingresa' value='$N_cod_as' />";
		echo "<script language='Javascript'>
			alert(' ¡ EL INFORME DEL DIA $fecha Y AREA $area <<< YA EXISTE >>> ! ');
			document.f7.submit();
		</script>";
	}
		
}     //if  

/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
if($_POST['ingresa'] == "Ingresar" and $_POST['c3'] == "")
{	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS",$co);
	
	$sqla 	= "SELECT * FROM tb_areas WHERE cod_dep = '".$_POST["c2"]."' ORDER BY desc_ar";
	$result = mysql_query($sqla,$co);
	
	while($vrowsa = mysql_fetch_array($result))
	{
		$areas[]	= $vrowsa;
	}
	
	$z			= 0;
	$cont_ar	= count($areas);

		while($z < $cont_ar)
		{
			$desc_ar	= $areas[$z]['desc_ar'];
			$cod_ar		= $areas[$z]['cod_ar'];    
			
			$co=mysql_connect("$DNS","$USR","$PASS");
			mysql_select_db("$BDATOS",$co);
			
			$query  = "SELECT * FROM asistencia WHERE fecha_as = '".$_POST['f1']."' and area_as = '$cod_ar' ";
			$result = mysql_query($query,$co);
			$cant = mysql_num_rows($result);
				
			if($cant == 0)// SI NO ENCONTRO NINGUN REGISTRO ENTONCES LO INGRESAMOS
			{	
				$consulta	= mysql_query("SELECT max(cod_as) FROM asistencia"); 
				$M_cod_inf 	= mysql_result($consulta,0);
				$N_cod_as	= ($M_cod_inf + 1);
//*************************************** INSERTAR INF_DIARIO ********************************************************************
				$sqli = "INSERT INTO asistencia (cod_as, area_as, fecha_as, ing_as) values('$N_cod_as', '$cod_ar', '".$_POST['f1']."', '".$_SESSION['usuario_nombre']."' )";
				if(dbExecute($sqli))// SI SE INGRESO CORRECTAMENTE ---- INGRESAMOS LOS ITEMS
				{
//********************************************************************************************************************************		
					$x=0;						// VARIABLE PARA INICIALIZAR EL CONTADOR	
					while($x < $cont_w)
					{	
						if($_POST['area'][$x] == $areas[$z]['cod_ar'])
						{
							$co=mysql_connect("$DNS","$USR","$PASS");
							mysql_select_db("$BDATOS",$co);
							
							if($_POST['aux'][$x] == 'Presente') 
							{
								$est	= "Presente";
							}else
							{
								$est= "Ausente";
							}
							
							$SqlDet="INSERT INTO detalle_as (cod_as, rut_det_as, estado_det_as, motivo_det_as, observ_det_as) VALUES('$N_cod_as', '".$_POST['rut'][$x]."', '$est', '".$_POST['aux_mot'][$x]."', '".$_POST['obs'][$x]."' )";
							if(dbExecute($SqlDet))
							{	
								echo"<input type='hidden' name='Ing_a' id='Ing_a' value='$N_cod_as' />";	
								echo"<script language='Javascript'>
									alert('El Informe fue ingresado correctamente');
									document.f7.action='lista.php';
									document.f7.submit();
								</script>";
							}else{
								$sqld="DELETE FROM asistencia WHERE cod_as = '$N_cod_as' ";
								echo"<input type='hidden' name='ingresa' id='ingresa' value='$N_cod_as' />";
								echo "<script language='Javascript'>
									alert('¡¡ERROR!! El Ingreso del Informe a Fallado');
									document.f7.submit();
								</script>";
							}
						}// if
					$x++;
					} // while
				}else{
						echo"<input type='hidden' name='ingresa' id='ingresa' value='$N_cod_as' />";
						echo "<script language='Javascript'>
							alert('¡¡ERROR!! El Ingreso del Informe a Fallado');
							document.f7.submit();
						</script>";
				}// if ingreso
			}else{						// fin if si no existe
				echo"<input type='hidden' name='ingresa' id='ingresa' value='$N_cod_as' />";
				echo "<script language='Javascript'>
					alert('¡ EL INFORME DEL DIA Y AREA'.'".$_POST['c3']."'.' INGRESADO YA EXISTE !');
					document.f7.submit();
				</script>";
			}
			$z++;
		}
		
}     //if  
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/












/***********************************************************************************************************
								MODIFICAMOS EL INFORME
************************************************************************************************************/
if($_POST['modifica'] == "Modificar")
{
	$id		= count($_POST['id']);

	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS",$co);
	$x=0;						// VARIABLE PARA INICIALIZAR EL CONTADOR
		
	while($x < $id)
	{
		if($_POST['aux'][$x] == 'Ausente') 
		{
			$est	= "Ausente";
		}else
		{
			$est= "Presente";
		}
		
		$SqlUpd = "UPDATE detalle_as SET 	estado_det_as		= '$est',
											motivo_det_as		= '".$_POST['aux_mot'][$x]."', 
											observ_det_as		= '".$_POST['obs'][$x]."'
											WHERE cod_det_as	= '".$_POST['id'][$x]."' ";
		if(dbExecute($SqlUpd))
		{
			echo"<input type='hidden' name='Mod_a' id='Mod_a' value='".$_POST['cod']."' />";
			echo"<input type='hidden' name='Mod_f' id='fecha' value='".$_POST['f1']."' />";
			echo "<script language='Javascript'>
			
				alert('La Modificacion se Realizo Correctamente');
				document.f7.submit();
			</script>";
		}else{
			echo"<input type='hidden' name='Mod_a' id='Mod_a' value='".$_POST['cod']."' />";
			echo"<input type='hidden' name='area' id='area' value='".$_POST['combo3']."' />";
			echo"<input type='hidden' name='fecha' id='fecha' value='".$_POST['f1']."' />";
			echo "<script language='Javascript'>
				alert('Error Al Modificar El Informe');
				document.f7.submit();
			</script>";
		}
	$x++;
	}
}

if($_POST['elimina'] == "Eliminar")
{	
	$cod_inf = $_POST['cod'];
	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sqldet = "DELETE FROM detalle_as WHERE cod_as = '".$_POST['cod']."' ";
	if(dbExecute($sqldet))
	{
		$sqld1="DELETE FROM asistencia WHERE cod_as = '".$_POST['cod']."' ";
		
		if(dbExecute($sqld1))
		{
			echo"<input type='hidden' name='elimina' id='elimina' value='$cod_inf' />";
			echo "<script language='Javascript'>
		
           		alert('El Informe Fue Eliminado Correctamente');
				document.f7.submit();
        	</script>";
			
		}else{
			echo"<input type='hidden' name='elimina' id='elimina' value='$cod_inf' />";
			echo "<script language='Javascript'>
		
           		alert('Error al Eliminar el informe');
				document.f7.submit();
        	</script>";
		}
	}else{
		echo"<input type='hidden' name='Ing_a' id='Ing_a' value='$cod_inf' />";
		echo "<script language='Javascript'>
		
           	alert('¡ERROR!  no se puede eliminar el informe');
			document.f7.submit();
        </script>";
	}
}


?>
</form>
</body>
</html>
