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

//********************************************************************************************************************************
	include ('inc/config_db.php');
	require('inc/lib.db.php');
	
	$trab = "--------- Seleccione ---------";
	$area =	"-- Seleccione Area --";
	$mot  =	"---- Seleccione ----";
	$est  = "Presente";
	$fe   = date("d/m/Y");
	$num  = 2;	
//********************************************************************************************************************************
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Informe Diario de Personal</title>

<link href="inc/bibliocss.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="JavaScript" src="inc/funciones.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="stmenu.js"></script>
<LINK href="inc/epoch_styles.css" type=text/css rel=stylesheet>
<SCRIPT src="inc/epoch_classes.js" type=text/javascript></SCRIPT>

</head>
<body>
<form id="f7" name="f7" method="post" action="inf_diario.php">

 <?php
 
 $_POST['f1']	= cambiarFecha($_POST['f1'], '/', '-' ); 
 $cont			= count($_POST['trabajadores']);
 $contador_f 	= ($cont-1);

/*********************************************************************************************************************************
								INGRESAMOS EL INFORME 
*********************************************************************************************************************************/			
if($_POST['ingresa'] == "Ingresar")
{	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS",$co);
	
	$query  = "SELECT * FROM inf_diario2 WHERE fecha_inf = '".$_POST['f1']."' and area_inf = '".$_POST['combo3']."' ";
	$result = mysql_query($query,$co);
	$cant   = mysql_num_rows($result);
		
	if($cant == 0)// SI NO ENCONTRO NINGUN REGISTRO ENTONCES LO INGRESAMOS
	{
//*************************************** INSERTAR INF_DIARIO ********************************************************************
		$sqli = "INSERT INTO inf_diario2 (fecha_inf, area_inf, env_por) values('".$_POST['f1']."', '".$_POST['combo3']."', '".$_SESSION['usuario_nombre']."' )";
		$resp_query = mysql_query($sqli, $co);
		if($resp_query)// SI SE INGRESO CORRECTAMENTE ---- INGRESAMOS LOS ITEMS
		{ 
			$cod_inf_ing = mysql_insert_id($co); //para saber el codigo del informe ingresado en la tabla inf_diario2
//********************************************************************************************************************************		
			$x=0;						// VARIABLE PARA INICIALIZAR EL CONTADOR	
			while($x < $contador_f)
			{
				if($_POST['trabajadores'][$x] != "--------- Seleccione ---------" )
				{				
					$co=mysql_connect("$DNS","$USR","$PASS");
					mysql_select_db("$BDATOS",$co);
					
					if($_POST['motivo'][$x] == "---- Seleccione ----"){ $_POST['motivo'][$x] = ""; }
					
					if($_POST['ods'][$x] 	== ""){ $_POST['ods'][$x]	=0; }
					if($_POST['hhn'][$x] 	== ""){ $_POST['hhn'][$x]	=0; }    										// SI HRS SON = "VACIO" LE ASIGNAMOS VALOR 0
					if($_POST['hh50'][$x] 	== ""){ $_POST['hh50'][$x]	=0; }
					if($_POST['hh100'][$x] 	== ""){ $_POST['hh100'][$x]	=0; }
					$totalFila = ($_POST['hhn'][$x] + $_POST['hh50'][$x] + $_POST['hh100'][$x]); 	// SUMA TOTAL DE LAS HORAS
					
					$SqlDet = "INSERT INTO detalle_inf2 (cod_inf, rut_t, estado_as, motivo, ods, cc, hrs, hh50, hh100, total) VALUES('$cod_inf_ing', '".$_POST['trabajadores'][$x]."', '".$_POST['estado'][$x]."', '".$_POST['aux'][$x]."', '".$_POST['ods'][$x]."', '".$_POST['cc'][$x]."', '".$_POST['hhn'][$x]."', '".$_POST['hh50'][$x]."', '".$_POST['hh100'][$x]."', '$totalFila')";
					
					if(dbExecute($SqlDet))
					{	
						echo"<input type='hidden' name='ingresa' id='ingresa' value='$cod_inf_ing' />";
						echo"<input type='hidden' name='area' id='area' value='".$_POST['combo3']."' />";
						echo"<input type='hidden' name='fecha' id='fecha' value='".$_POST['f1']."' />";
						echo"<script language='Javascript'>
							alert('El Informe Fue Creado Correctamente');
							document.f7.action='inf_diario.php';
							document.f7.submit();
						</script>";
					}else{
						$sqld="DELETE FROM inf_diario2 WHERE cod_inf='$cod_inf_ing' ";
						dbExecute($sqld);
						echo"<input type='hidden' name='ingresa' id='ingresa' value='$cod_inf_ing' />";
						echo "<script language='Javascript'>
			
							alert('¡¡ERROR!! El Ingreso del Informe a Fallado');
							document.f7.submit();
						</script>";
					}
				}// trabajadores
			$x++;
			} // while
		}else{
				echo"<input type='hidden' name='ingresa' id='ingresa' value='$cod_inf_ing' />";
				echo "<script language='Javascript'>
			
					alert('¡¡ERROR!! El Ingreso del Informe a Fallado');
					document.f7.submit();
				</script>";
		}// if ingreso
	}else{						// fin if si no existe
		
		echo"<input type='hidden' name='ingresa' id='ingresa' value='$cod_inf_ing' />";
		echo "<script language='Javascript'>
			
			alert('¡ EL INFORME DEL DIA Y AREA INGRESADO YA EXISTE !');
			document.f7.submit();
		</script>";
	}	
}     //if   
/*********************************************************************************************************************************
												MODIFICAMOS LA ODS
*********************************************************************************************************************************/	
$ContFilas = count($_POST['ods']);

$co=mysql_connect("$DNS","$USR","$PASS");
mysql_select_db("$BDATOS",$co);
		
if($_POST['modifica'] == "Modificar")
{
	$x=0;						// VARIABLE PARA INICIALIZAR EL CONTADOR	
	while($x < $ContFilas)
	{
		if($_POST['hhn'][$x] == ""){ $_POST['hhn'][$x]=0; }
		if($_POST['hh50'][$x] == ""){ $_POST['hh50'][$x]=0; }
		if($_POST['hh100'][$x] == ""){ $_POST['hh100'][$x]=0; }
		$totalFila = ($_POST['hhn'][$x] + $_POST['hh50'][$x] + $_POST['hh100'][$x]);
		
		$SqlUpd = "UPDATE detalle_inf2 SET rut_t		= '".$_POST['trabajadores'][$x]."',
										estado_as		= '".$_POST['estado'][$x]."',
										motivo			= '".$_POST['aux'][$x]."',
										ods				= '".$_POST['ods'][$x]."',
										cc				= '".$_POST['cc'][$x]."',
										hrs				= '".$_POST['hhn'][$x]."',
										hh50			= '".$_POST['hh50'][$x]."',
										hh100			= '".$_POST['hh100'][$x]."',
										total			= '$totalFila'  
										WHERE id_det	= '".$_POST['id'][$x]."' ";
		if(dbExecute($SqlUpd))
		{
		//***************************************************************************************************
			$co=mysql_connect("$DNS","$USR","$PASS");
			mysql_select_db("$BDATOS",$co);
		
			$sql_det = "SELECT * FROM detalle_inf2 WHERE cod_inf = '".$_POST['cod_inf']."' ";
			$res_det = dbExecute($sql_det);
			while ($vrows_rep = mysql_fetch_array($res_det)) 
			{
				$detalle[] = $vrows_det;
			}
			$tot_det_org = count($detalle);
			
			if($contador_f > $tot_det_org)
				{
					$z= $tot_det_org;					// VARIABLE PARA INICIALIZAR EL CONTADOR	
					while($z < $contador_f)
					{
						if($_POST['trabajadores'][$z] != "Seleccione..." )
						{
							$co=mysql_connect("$DNS","$USR","$PASS");
							mysql_select_db("$BDATOS",$co);
							
							if($_POST['hh50'][$z] == ""){ $_POST['hh50'][$z]=0; }
							if($_POST['hh100'][$z] == ""){ $_POST['hh100'][$z]=0; }
							
							$totalFila = ($_POST['hhn'][$z] + $_POST['hh50'][$z] + $_POST['hh100'][$z]); 	// SUMA TOTAL DE LAS HORAS
							
							$Sql_det_i = "INSERT INTO detalle_inf2 (cod_inf, rut_t, estado_as, motivo, ods, cc, hrs, hh50, hh100, total) VALUES('".$_POST['cod_inf']."', '".$_POST['trabajadores'][$z]."', '".$_POST['estado'][$z]."', '".$_POST['aux'][$z]."', '".$_POST['ods'][$z]."', '".$_POST['cc'][$z]."', '".$_POST['hhn'][$z]."', '".$_POST['hh50'][$z]."', '".$_POST['hh100'][$z]."', '$totalFila')";
							dbExecute($Sql_det_i);
						}
						$z++;
					}
				}
		//***************************************************************************************************
			echo"<input type='hidden' name='modifica' id='modifica' value='".$_POST['cod_inf']."' />";
			echo"<input type='hidden' name='area' id='area' value='".$_POST['combo3']."' />";
			echo"<input type='hidden' name='fecha' id='fecha' value='".$_POST['f1']."' />";
			echo "<script language='Javascript'>
			
				alert('La Modificacion se Realizo Correctamente');
				document.f7.submit();
			</script>";
		}else{		
			echo"<input type='hidden' name='modifica' id='modifica' value='".$_POST['cod_inf']."' />";
			echo"<input type='hidden' name='area' id='area' value='".$_POST['combo3']."' />";
			echo"<input type='hidden' name='fecha' id='fecha' value='".$_POST['f1']."' />";
			echo "<script language='Javascript'>
				
				alert('Error Al Modificar El Informe !!!!!!!!!!!!!!!!!!');
				document.f7.submit();
			</script>";
		}
	$x++;
	}
}
?>
</form>
</body>
</html>
