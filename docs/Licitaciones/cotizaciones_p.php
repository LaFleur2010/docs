<?
// Necesario para ver si la session esta activa  o si se tiene permiso de accseso
require("../lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php

if($_SESSION['usd_cot_lee'] != "1")
{
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}//Hasta aquí lo comun para todas las paginas restringidas
//*********************************************************************************************************************************
//*********************************************************************************************************************************
	include('../inc/config_db.php');	// CONECCION A LA BASE DE DATOS
	require('../inc/lib.db.php');
	$fecha	= date("Y-m-d");		// FECHA DE HOY

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Procesando.....</title>
<script language="javascript">
function Enviar()
{
	document.formu.submit();
}
</script>
</head>

<body>
<form id="formu" name="formu" method="post" action="cotizaciones.php">

<?php
//********************************************************************************************************************************
 $cont_d	 = count($_POST['desc_detc']);
 $cont_det	 = $cont_d - 1;
 
 $cont_a	 = count($_POST['desc_alcc']);	
 $cont_alc	 = $cont_a - 1;
/*********************************************************************************************************************************
				LE CAMBIAMOS EL FORMATO A LA FECHA
**********************************************************************************************************************************/					
	$_POST['fe_ing_cot']	= cambiarFecha($_POST['fe_ing_cot'], '/', '-' );
	$_POST['fe_sal_cot']	= cambiarFecha($_POST['fe_sal_cot'], '/', '-' );
	$_POST['fe_cons_cot']	= cambiarFecha($_POST['fe_cons_cot'], '/', '-' );
	$_POST['fe_resp_cot']	= cambiarFecha($_POST['fe_resp_cot'], '/', '-' );
	$_POST['fe_ent_cot']	= cambiarFecha($_POST['fe_ent_cot'], '/', '-' );
	$_POST['fe_ingr_cot']	= cambiarFecha($_POST['fe_ingr_cot'], '/', '-' );
		
	if($_POST['fe_ing_cot']		== ""){$_POST['fe_ing_cot']		= "0000-00-00";}
	if($_POST['fe_sal_cot']		== ""){$_POST['fe_sal_cot']		= "0000-00-00";}
	if($_POST['fe_cons_cot']	== ""){$_POST['fe_cons_cot']	= "0000-00-00";}
	if($_POST['fe_resp_cot']	== ""){$_POST['fe_resp_cot']	= "0000-00-00";}
	if($_POST['fe_ent_cot']		== ""){$_POST['fe_ent_cot']		= "0000-00-00";}
	if($_POST['fe_ingr_cot']	== ""){$_POST['fe_ingr_cot']	= "0000-00-00";}

	$_POST['desc_cot'] = ucwords($_POST['desc_cot']);
	
	if($_POST['valor_cot'] == ""){$_POST['valor_cot'] = 0;}
/**********************************************************************************************************************************
								INGRESAMOS LA NUEVA COTIZACION
**********************************************************************************************************************************/			
if($_POST['ingresa'] == "Ingresar")
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS",$co);

/**********************************************************************************************************************************
								SI SE MARCO EL RADIO DE CODIGO AUTOMATICO
**********************************************************************************************************************************/	
if($_POST['radio'] == "auto")
{
	if($_POST['tipo_ing'] == "Cotizacion")
	{	
		$mayor =0;					
		$consulta		= "SELECT aux_cot FROM tb_cotizaciones WHERE tipo_ing = 'Cotizacion' "; 
		$resp			= mysql_query($consulta, $co);
		while($vrows 	= mysql_fetch_array($resp))
		{	
		
			$cadena = $vrows['aux_cot'];
			$numero = "";
		
			for( $index = 0; $index < strlen($cadena); $index++ )
			{
				if( is_numeric($cadena[$index]) )
				{
					$numero .= $cadena[$index];
				}
			}
		
			if($numero > $mayor )
			{
				$mayor = $numero;
			}
		}
		$n			=	$mayor + 1;
		$num_cot	=	"1500-".$n;
		
	}
					
	if($_POST['tipo_ing'] == "Licitacion")
	{						
		$mayor =0;					
		$consulta		= "SELECT num_cot FROM tb_cotizaciones WHERE tipo_ing = 'Licitacion' "; 
		$resp			= mysql_query($consulta, $co);
		while($vrows 	= mysql_fetch_array($resp))
		{	
		
			$cadena = $vrows['num_cot'];
			$numero = "";
		
			for( $index = 0; $index < strlen($cadena); $index++ )
			{
				if( is_numeric($cadena[$index]) )
				{
					$numero .= $cadena[$index];
				}
			}
		
			if($numero > $mayor )
			{
				$mayor = $numero;
			}
		}
		$n			=	$mayor + 1;
		$num_cot	=	$n;

	}
}
/**********************************************************************************************************************************
								SI SE MARCO EL RADIO DE INGRESAR CODIGO
**********************************************************************************************************************************/
if($_POST['radio'] == "ing")
{
	$num_cot	=	$_POST['num_cot'];
	
	if($_POST['tipo_ing'] == "Cotizacion"){ $n = substr ("$num_cot", 5);    /* devuelve "codigo incremental" */}
	if($_POST['tipo_ing'] == "Licitacion"){ $n = $num_cot;}					// Si es Licitacion devolvemos el mismo Nº de la licitacion
}
/**********************************************************************************************************************************
								PREGUNTAMOS SI EL REGISTRO DEL CODIGO YA EXISTE
**********************************************************************************************************************************/
	$query  = "SELECT * FROM tb_cotizaciones WHERE num_cot = '$num_cot' ";
	$result = mysql_query($query,$co);
	$cant   = mysql_num_rows($result);
		
	$_POST['c5'] = utf8_decode($_POST['c5']);



	if ($_POST['otro'] == "" ) {
		$ven_f = $_POST['otro2'];
	}else{
		$ven_f = $_POST['otro'];
	}
	
		
	if($cant == 0)// SI NO ENCONTRO NINGUN REGISTRO ENTONCES LO INGRESAMOS
	{
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS",$co);
		
		$sqli = "INSERT INTO tb_cotizaciones (
								num_cot,
								aux_cot,
								tipo_ing,
								desc_cot,
								fe_ing_cot,
								fe_sal_cot,
								fe_cons_cot,
								fe_resp_cot,
								fe_ent_cot,
								cliente_cot,
								contacto_cot,
								emp_cot,
								resp_cot,
								estado_cot,
								obs_cot,
								ing_por_cot,
								fe_ingr_cot,
								transp_cot,
								moneda_cot,
								conpag_cot,
								plazoent_cot,
								garantia_cot,
								valof_cot,
								valor_cot,
								por_modificaciones,
								por_multas,
								ref_venta,
								op_venta,
								resp_general
								) 
					
			VALUES(	'$num_cot', 
					'$n',
					'".$_POST['tipo_ing']."', 
					'".$_POST['desc_cot']."', 
					'".$_POST['fe_ing_cot']."',
					'".$_POST['fe_sal_cot']."', 
					'".$_POST['fe_cons_cot']."', 
					'".$_POST['fe_resp_cot']."', 
					'".$_POST['fe_ent_cot']."', 
					'".$_POST['c1']."', 
					'".$_POST['c2']."', 
					'".$_POST['c3']."', 
					'".$_POST['c4']."', 
					'".$_POST['c5']."', 
					'".$_POST['obs_cot']."',
					'".$_SESSION['usuario_nombre']."',
					'$fecha',
					'".$_POST['transp_cot']."',
					'".$_POST['moneda_cot']."',
					'".$_POST['conpag_cot']."',
					'".$_POST['plazoent_cot']."',
					'".$_POST['garantia_cot']."',		
					'".$_POST['valof_cot']."',
					'".$_POST['valor_cot']."',
					'".$_POST['por_modificaciones']."',
					'".$_POST['por_multas']."',
					'".$_POST['otro']."',
					'".$_POST['otro2']."',
					'".$_POST['c8']."'
					)";
		
			$sql_presu = "SELECT * FROM tb_presupuesto where num = '$num_cot'";
			$rs 	   = mysql_query($sql_presu,$co);
			$co_presu  = mysql_num_rows($rs);
			
			if ($co_presu == 0) {
			
				$sql = "INSERT INTO tb_presupuesto (venta, estudio,tipo,num) VALUES('".$_POST['valor_cot']."','".$_POST['Pestudio']."','".$_POST['tipo_ing']."','$num_cot')";
				mysql_query($sql,$co);

				
			}else{
				echo "mal";
			}
			
			//Esto es para Ingresar la opcion de Responsabilidad de diseño
			$sql_obserbacion = "SELECT * FROM tb_obserbacion where numero = '$num_cot'";
			$rs_obserbacion  = mysql_query($sql_obserbacion,$co);
			$co_obserbacion   = mysql_num_rows($rs_obserbacion);

			if ($co_obserbacion == 0) {
						
				$sql = "INSERT INTO tb_obserbacion VALUES('','".$_POST['Copcion']."','$num_cot')";
				mysql_query($sql,$co);
			}	
			
		
			if(mysql_query($sqli, $co))
			{		
				/*****************************************************************************
				INSERTAMOS DETALLE DE COTIZACION
				******************************************************************************/		
				//$num_cotI = mysql_insert_id($co); //para saber el codigo de la ODS ingresada
				/*****************************************************************************/
				$x=0;				// VARIABLE PARA INICIALIZAR EL CONTADOR	
				while($x < $cont_det)
				{
					if($_POST['desc_detc'][$x] != "" )
					{
						$co=mysql_connect("$DNS","$USR","$PASS");
						mysql_select_db("$BDATOS",$co);
							
						$Sql_det = "INSERT INTO tb_cot_det (num_cot, desc_detc, cant_detc, und_detc, unit_detc) VALUES('$num_cot', '".$_POST['desc_detc'][$x]."', '".$_POST['cant_detc'][$x]."', '".$_POST['und_med'][$x]."','".$_POST['unit_detc'][$x]."')";
						dbExecute($Sql_det);
					}
					$x++;
				}
				/*****************************************************************************
				INSERTAMOS DETALLE DE ALCANCE
				******************************************************************************/
				$y=0;				// VARIABLE PARA INICIALIZAR EL CONTADOR	
				while($y < $cont_alc)
				{
					if($_POST['desc_alcc'][$y] != "" )
					{
						$co=mysql_connect("$DNS","$USR","$PASS");
						mysql_select_db("$BDATOS",$co);
						
						if($_POST['auxcheck'][$y] == 1){$tipo_alcc = 1;}else{$tipo_alcc = 0; }
							
						
						$Sql_det = "INSERT INTO tb_cot_alc (num_cot, desc_alcc, tipo_alcc) VALUES('$num_cot', '".$_POST['desc_alcc'][$y]."', '$tipo_alcc' )";
						mysql_query($Sql_det, $co);
						
					}
					$y++;	
				}
/**********************************************************************************************************************************
		CREAMOS LA CARPETA CON EL CODIGO DE LA COTIZACION O LICITACION
**********************************************************************************************************************************/
				$dir	= "Carpetas";
				$carp	= $dir."/".$num_cot;
			
				if(!is_dir($carp))  		// Preguntamos si la carpeta No Existe
				{
					@mkdir($carp, 0777);  	// si no existe la creamos
				}else{ 
					//alert("La Carpeta Ya Existe"); 
				} 
/**********************************************************************************************************************************
			SI EL REGISTRO SE INGRESO CORRECTAMENTE ENVIAMOS UN MENSAJE Y REGRESAMOS
**********************************************************************************************************************************/
				echo"<input type='hidden' name='ingresa' id='ingresa' value='$num_cot' />";		
				echo "<script language='Javascript'>
					alert('El ingreso se realizo correctamente');
					
					
					document.formu.submit();
				 </script>";
//********************************************************************************************************************************
			}else{
				echo"<input type='hidden' name='ingresa' id='ingresa' value='$num_cot' />";	
				echo "<script language='Javascript'>
					alert('¡ERROR! los datos no pudieron ser ingresados');
					document.formu.submit();
				 </script>";
			} 
		
		}else{
			echo"<input type='hidden' name='ingresa' id='ingresa' value='$num_cot' />";		
			echo "<script language='Javascript'>
				alert('Error: El Nº de Cot/Lic ya existe');
				document.formu.submit();
			</script>";
		}
}
/*********************************************************************************************************************************
/*********************************************************************************************************************************
***								MODIFICAMOS LA ODS                                                                             ***
**********************************************************************************************************************************	
*********************************************************************************************************************************/	
if($_POST['modifica'] == "Modificar")
{
	$num_cot = $_POST['num_cot'];
	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS",$co);


	//MODIFICAMOS LA TABLA PRESUPUESTO POR LOS NUEVOS VALORES PUESTOS EN LOS INPUTS
	$sql_presupuesto = "UPDATE tb_presupuesto SET venta = '".$_POST['Pventa']."', estudio = '".$_POST['Pestudio']."', objetivo = '".$_POST['Pobjetivo']."' where num = '$num_cot'";
	mysql_query($sql_presupuesto,$co);
	//MODIFICAMOS LA OBSERBACION A 0
	$sql_obserbacion = "UPDATE tb_obserbacion SET comentario = '".$_POST['Copcion']."' where numero = '$num_cot'";
	mysql_query($sql_obserbacion,$co);


	$SqlDetalle = "SELECT * FROM tb_cot_det WHERE num_cot = '".$_POST['num_cot']."' ";
	$ResDetalle = dbExecute($SqlDetalle);
	while ($vrows_Detalle = mysql_fetch_array($ResDetalle)) 
	{
    	$DetCot[] = $vrows_Detalle;
	}
	$TotalDC = count($DetCot);
	
	$SqlAlcance = "SELECT * FROM tb_cot_alc WHERE num_cot = '".$_POST['num_cot']."' ";
	$ResAlcance = dbExecute($SqlAlcance);
	while ($vrows_Alcance = mysql_fetch_array($ResAlcance)) 
	{
    	$AlcCot[] = $vrows_Alcance;
	}
	$TotalAC = count($AlcCot);

/************************************************************************************************
					RUT CLIENTE
************************************************************************************************/	
	$rut = explode("-", $_POST['c1']);
	$rut[0]; // Devuelve rut sin digigo verificador ni guion
	
	if(!is_numeric($rut[0]))
	{
		$sql_c = "SELECT id_cli FROM tb_clientes WHERE razon_s = '".$_POST['c1']."' ";
		$res=mysql_query($sql_c,$co);
		while($vrows=mysql_fetch_array($res))
		{
			$id_cli = 	"".$vrows['id_cli']."";
		}
	}else{
		$id_cli	= $_POST['c1'];
	}
/************************************************************************************************
					RUT RESPONSABLE
************************************************************************************************/
	$rut_r = explode("-", $_POST['c4']);
	$rut_r[0]; // Devuelve rut sin digigo verificador ni guion

	if(!is_numeric($rut_r[0]))
	{
		$sql_r = "SELECT rut_resp FROM tb_responsable WHERE nom_resp = '".$_POST['c4']."' ";
		$res=mysql_query($sql_r,$co);
		while($vrowsr=mysql_fetch_array($res))
		{
			$rut_resp = 	"".$vrowsr['rut_resp']."";
		}
	}else{
		$rut_resp	= $_POST['c4'];
	}
/************************************************************************************************
					RUT EMPRESA SERVICIO
************************************************************************************************/
	$rut_es = explode("-", $_POST['c3']);
	$rut_es[0]; // Devuelve rut sin digigo verificador ni guion

	if(!is_numeric($rut_es[0]))
	{
		$sql_r = "SELECT rut_emps FROM tb_empresaserv WHERE nom_emps = '".$_POST['c3']."' ";
		$res=mysql_query($sql_r,$co);
		while($vrowsr=mysql_fetch_array($res))
		{
			$rut_emps = 	"".$vrowsr['rut_emps']."";
		}
	}else{
		$rut_emps	= $_POST['c3'];
	}
	

	$sql = "UPDATE tb_cotizaciones SET 	tipo_ing			= '".$_POST['tipo_ing']."',
										desc_cot			= '".$_POST['desc_cot']."',
										fe_ing_cot			= '".$_POST['fe_ing_cot']."',
										fe_sal_cot			= '".$_POST['fe_sal_cot']."',
										fe_cons_cot			= '".$_POST['fe_cons_cot']."',
										fe_resp_cot			= '".$_POST['fe_resp_cot']."',
										fe_ent_cot			= '".$_POST['fe_ent_cot']."',
										cliente_cot			= '$id_cli',
										contacto_cot		= '".$_POST['c2']."',
										emp_cot				= '$rut_emps',
										resp_cot			= '$rut_resp',
										estado_cot			= '".$_POST['c5']."',
										obs_cot				= '".$_POST['obs_cot']."',
										transp_cot			= '".$_POST['transp_cot']."',
										moneda_cot			= '".$_POST['moneda_cot']."',
										conpag_cot			= '".$_POST['conpag_cot']."',
										plazoent_cot		= '".$_POST['plazoent_cot']."',
										garantia_cot		= '".$_POST['garantia_cot']."',		
										valof_cot			= '".$_POST['valof_cot']."',
										valor_cot			= '".$_POST['valor_cot']."',
										por_modificaciones  = '".$_POST['por_modificaciones']."',
										por_multas 			= '".$_POST['por_multas']."',
										op_venta			= '".$_POST['otro2']."',
										ref_venta 			= '".$_POST['otro']."',
										resp_general        = '".$_POST['c8']."'
										WHERE num_cot		= '$num_cot' ";
								
	if(dbExecute($sql))
	{		
		$x=0;	// VARIABLE PARA INICIALIZAR EL CONTADOR	
		while($x < $cont_det)
		{
			$co=mysql_connect("$DNS","$USR","$PASS");
			mysql_select_db("$BDATOS",$co);
				
			$Sql_D = "UPDATE tb_cot_det SET desc_detc	 = '".$_POST['desc_detc'][$x]."',
											cant_detc 	 = '".$_POST['cant_detc'][$x]."',
											und_detc 	 = '".$_POST['und_med'][$x]."',
											unit_detc 	 = '".$_POST['unit_detc'][$x]."'
											WHERE id_det = '".$_POST['id_det'][$x]."' ";
														
			mysql_query($Sql_D, $co);
			$x++;
		}
			


		$y=0;	// VARIABLE PARA INICIALIZAR EL CONTADOR	
		
		while($y < $cont_alc)
		{
			$co=mysql_connect("$DNS","$USR","$PASS");
			mysql_select_db("$BDATOS",$co);
			
			if($_POST['auxcheck'][$y] == 1){$tipo_alcc = 1;}else{$tipo_alcc = 0; }
			
			$Sql_A = "UPDATE tb_cot_alc SET desc_alcc	 = '".$_POST['desc_alcc'][$y]."',
											tipo_alcc 	 = '$tipo_alcc'
											
											WHERE id_alc = '".$_POST['id_alc'][$y]."' ";										
			mysql_query($Sql_A, $co);
			$y++;
		}
				
		if($cont_det > $TotalDC)
		{
			$z = $TotalDC;					// VARIABLE PARA INICIALIZAR EL CONTADOR	
			while($z < $cont_det)
			{
				if($_POST['desc_detc'][$z] != "" )
				{
					$co=mysql_connect("$DNS","$USR","$PASS");
					mysql_select_db("$BDATOS",$co);
							
					$Sql_UCop = "INSERT INTO tb_cot_det (num_cot, desc_detc, cant_detc, und_detc, unit_detc) VALUES('$num_cot', '".$_POST['desc_detc'][$z]."', '".$_POST['cant_detc'][$z]."', '".$_POST['und_med'][$z]."','".$_POST['unit_detc'][$z]."')";
					
					dbExecute($Sql_UCop);		
				}
				$z++;
			}
		}
		
		if($cont_alc > $TotalAC)
		{
			$w = $TotalAC;					// VARIABLE PARA INICIALIZAR EL CONTADOR	
			while($w < $cont_alc)
			{
				if($_POST['desc_alcc'][$w] != "" )
				{
					$co=mysql_connect("$DNS","$USR","$PASS");
					mysql_select_db("$BDATOS",$co);
					
					if($_POST['auxcheck'][$w] == 1){$tipo_alc = "1";}else{$tipo_alc = "0"; }
							
					$Sql_Alcot = "INSERT INTO tb_cot_alc (num_cot, desc_alcc, tipo_alcc) VALUES('$num_cot', '".$_POST['desc_alcc'][$w]."', '$tipo_alc' )";					
					dbExecute($Sql_Alcot);		
				}
				$w++;
			}
		}
			
		echo"<input type='hidden' name='modifica' id='modifica' value='$num_cot' />";
		echo "<script language='Javascript'>
           	alert('La Modificacion se Realizo Correctamente');
			document.formu.submit();
        </script>";
	}else{
		echo"<input type='hidden' name='modifica' id='modifica' value='$num_cot' />";
		echo "<script language='Javascript'>
           	alert('Error Al Modificar El Registro');
			document.formu.submit();
        </script>";
	}
}	

/*********************************************************************************************************************************
								ELIMINAMOS LA ODS
*********************************************************************************************************************************/
if($_POST['elimina'] == "Eliminar" and $_SESSION['usuario_tipo'] == "Administrador")
{	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sqls 	= "SELECT * FROM tb_cotizaciones WHERE num_cot = '".$_POST['num_cot']."' ";
	$res 	= mysql_query($sqls,$co);
	$reg   	= mysql_num_rows($res);
	
	if($reg != 0)// SI NO ENCONTRO NINGUNA OTI ASOCIADA A LA ODS, LA ELIMINAMOS
	{
		$sqld = "DELETE FROM tb_cotizaciones, tb_cot_det, tb_cot_alc WHERE tb_cotizaciones.num_cot = '".$_POST['num_cot']."' and tb_cotizaciones.num_cot = tb_cot_det.num_cot and tb_cotizaciones.num_cot = tb_cot_alc.num_cot ";
		mysql_query($sqld,$co);
		
		if(dbExecute($sqld))
		{
			echo"<input type='hidden' name='elimina' id='elimina' value='".$_POST['num_cot']."' />";
			echo "<script language='Javascript'>
		
           		alert('Los registros fueron eliminados correctamente');
				document.formu.submit();
        	</script>";
		}else{ 
				echo"<input type='hidden' name='elimina' id='elimina' value='".$_POST['num_cot']."' />";
				echo "<script language='Javascript'>
		
           			alert('¡ERROR! Al eliminar registros');
					document.formu.submit();
        		</script>";
			}
	}else{
		echo"<input type='hidden' name='elimina' id='elimina' value='".$_POST['num_cot']."' />";
		echo "<script language='Javascript'>
		
           	alert('¡LA COTIZACION A ELIMINAR NO EXISTE');
			document.formu.submit();
        </script>";
	}
}	
?>
</form>
</body>
</html>
