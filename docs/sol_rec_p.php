<?
// Necesario para ver si la session esta activa  o si se tiene permiso de accseso
require("lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php

if($_SESSION['usd_sol_lee'] != "1")
{
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}//Hasta aquí lo comun para todas las paginas restringidas
//********************************************************************************************************************************
//********************************************************************************************************************************
	include ('inc/config_db.php');
	require('inc/lib.db.php');
	include('inc/correos.php');
	
	$trab = "--------- Seleccione ---------";
	$area =	"-- Seleccione Area --";
	$mot  =	"---- Seleccione ----";
	$est  = "Presente";
	$fe   = date("Y-m-d");

	$num  = 2;	
//********************************************************************************************************************************
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Solicitud de recursos</title>

<link href="inc/bibliocss.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="JavaScript" src="inc/funciones.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="stmenu.js"></script>

</head>
<body>
<form id="f7" name="f7" method="post" action="sol_rec.php">
<?php
 $_POST['f3']	= cambiarFecha($_POST['f3'], '/', '-' ); 
 $_POST['f1']	= cambiarFecha($_POST['f1'], '/', '-' ); 
 $cont			= count($_POST['desc_sol']);
 $contador_f 	= ($cont-1);
 $cod_sol		= $_POST['cod_sol'];
 $prof_sol		= $_SESSION['usuario_nombre'];

/*********************************************************************************************************************************
				INGRESAMOS LA SOLICITUD
*********************************************************************************************************************************/			
if($_POST['ingresa'] == "Ingresar")
{	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS",$co);
	
	$query  = "SELECT * FROM tb_sol_rec WHERE cod_sol = '".$_POST['cod_sol']."' ";
	$result = mysql_query($query,$co);
	$cant   = mysql_num_rows($result);
		
	if($cant == 0)// SI NO ENCONTRO NINGUN REGISTRO ENTONCES LO INGRESAMOS
	{
//*************************************** INSERTAR INF_DIARIO ********************************************************************
			$app = "";
			$apg = "";
			$apb = "";
		
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS",$co);
	
		$sqli="INSERT INTO tb_sol_rec (area_sol, fe_sol, ods_sol, cc_sol, prof_sol, aprob_dpto, aprob_ger, aprob_bod, fe_aprob_d, fe_aprob_g, fe_aprob_b, hr_ing_sol, fe_en_obra,orden,regularizasion  ) values('".$_POST['combo3']."', '$fe', '".$_POST['ods_sol']."', '".$_POST['cc_sol']."', '".$_SESSION['usuario_nombre']."', '$app', '$apg', '$apb', '0000-00-00' , '0000-00-00', '0000-00-00', '$hora', '".$_POST['f3']."','".$_POST['Rorden']."','".$_POST['regu']."')";
		
		$resp_query_in = mysql_query($sqli, $co);
		
		if($resp_query_in)
		{
			$cod_sol_ing = mysql_insert_id($co); //para saber el codigo de la solicitud ingresada en la tabla sol_rec
//********************************************************************************************************************************		
			$x=0;								// VARIABLE PARA INICIALIZAR EL CONTADOR	
			while($x < $contador_f)
			{
				if($_POST['desc_sol'][$x] != "" )
				{
/*********************************************************************************************************************************/			
					if($_POST['tip_rec'][$x] == "---- Seleccione ----"){ $_POST['tip_rec'][$x] = ""; }
					if($_POST['cant_det'][$x] == ""){ $_POST['cant_det'][$x] = "0"; }
					if($_POST['aux_ap_d'][$x] == ""){ $_POST['aux_ap_d'][$x] = "0"; }
					if($_POST['aux_ap_g'][$x] == ""){ $_POST['aux_ap_g'][$x] = "0"; }
					if($_POST['valor_aprox'][$x] == ""){ $_POST['valor_aprox'][$x] = 0; }
					
					$co=mysql_connect("$DNS","$USR","$PASS");
					mysql_select_db("$BDATOS",$co);
					
					$SqlDet = "INSERT INTO tb_det_sol (cod_sol, desc_sol, cant_det,valor_aprox, und_med, rec_det) VALUES('$cod_sol_ing', '".ucfirst($_POST['desc_sol'][$x])."', '".$_POST['cant_det'][$x]."','".$_POST['valor_aprox'][$x]."',  '".$_POST['und_med'][$x]."', 'Pendiente')";
					
					if(dbExecute($SqlDet))
					{	
/**********************************************************************************************************************************
						CREAMOS LA CARPETA SI ESTA NO EXISTE
**********************************************************************************************************************************/
						if($_POST['ods_sol'] != "")
						{
							$name_carpeta = $_POST['ods_sol'];
						}else{
							$name_carpeta = $_POST['cc_sol'];
						}
						
						$dir		= "Carpetas ODS";
						$ruta_sol	= $dir."/".$name_carpeta;
					
						if(!is_dir($ruta_sol))  		// Preguntamos si la carpeta No Existe
						{
							@mkdir($ruta_sol, 0777);  	// si no existe la creamos
						}
/**********************************************************************************************************************************
						FIN DE CREACION CARPETA
**********************************************************************************************************************************/			
	 
						echo"<input type='hidden' name='ingresa' id='ingresa' value='$cod_sol_ing' />";
						echo"<script language='Javascript'>
							alert('La solicitud fue ingresada Correctamente');
							document.f7.action='sol_rec.php';
							document.f7.submit();
						</script>";
					}else{
						$sqld="DELETE FROM inf_diario2 WHERE cod_inf='$cod_sol_ing' ";
						dbExecute($sqld);
						echo"<input type='hidden' name='ingresa' id='ingresa' value='$cod_sol_ing' />";
						echo "<script language='Javascript'>
							alert('¡¡ERROR!! El Ingreso de la solicitud a fallado');
							document.f7.submit();
						</script>";
					}
				}// trabajadores
			$x++;
			} // while
		}else{
				echo"<input type='hidden' name='ingresa' id='ingresa' value='$cod_sol_ing' />";
				echo "<script language='Javascript'>
					
					alert('¡¡ERROR!! El Ingresooo de la solicitud a fallado');
					document.f7.submit();
				</script>";
		}// if ingreso
	}else{						// fin if si no existe
		
		echo"<input type='hidden' name='ingresa' id='ingresa' value='$cod_sol_ing' />";
		echo "<script language='Javascript'>
			
			alert('¡ La solicitud ya existe !');
			document.f7.submit();
		</script>";
	}
		
}     //if   
   
   
/*********************************************************************************************************************************
				MODIFICAMOS LA SOLICITUD
*********************************************************************************************************************************/	
if($_POST['modifica'] == "Modificar")
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS",$co);
	
	$SqlUpds = "UPDATE tb_sol_rec SET ods_sol		= '".$_POST['ods_sol']."',
									cc_sol			= '".$_POST['cc_sol']."',
									fe_en_obra		= '".$_POST['f3']."'
									WHERE cod_sol	= '".$_POST['cod_sol']."' ";
		if(dbExecute($SqlUpds))
		{									
			$co=mysql_connect("$DNS","$USR","$PASS");
			mysql_select_db("$BDATOS",$co);
													
		$x=0;						// VARIABLE PARA INICIALIZAR EL CONTADOR	
		while($x < $contador_f)
		{
			if($_POST['cant_det'][$x] == ""){ $_POST['cant_det'][$x] = 0; }
			if($_POST['aux_ap_d'][$x] != "2"){ $_POST['aux_ap_d'][$x] = "1"; }
			if($_POST['aux_ap_g'][$x] != "2"){ $_POST['aux_ap_g'][$x] = "1"; }
			if($_POST['valor_aprox'][$x] == ""){ $_POST['valor_aprox'][$x] = 0; }
			
			$SqlUpd = "UPDATE tb_det_sol SET desc_sol		= '".$_POST['desc_sol'][$x]."',
											 cant_det		= '".$_POST['cant_det'][$x]."',
											 valor_aprox	= '".$_POST['valor_aprox'][$x]."',
											 valor_bodega   = '".$_POST['valor_bodega'][$x]."',
											 und_med		= '".$_POST['und_med'][$x]."' 
											 WHERE id_det	= '".$_POST['id'][$x]."' ";
			if(dbExecute($SqlUpd))
			{
			//***************************************************************************************************
				$co=mysql_connect("$DNS","$USR","$PASS");
				mysql_select_db("$BDATOS",$co);
			
				$sql_det = "SELECT * FROM tb_det_sol WHERE cod_sol = '".$_POST['cod_sol']."' ";
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
							if($_POST['desc_sol'][$z] != "" )
							{
								$co=mysql_connect("$DNS","$USR","$PASS");
								mysql_select_db("$BDATOS",$co);
								
								$Sql_det_i = "INSERT INTO tb_det_sol (cod_sol, desc_sol, cant_det, und_med, det_ap_d, det_ap_g, rec_det) VALUES('".$_POST['cod_sol']."', '".$_POST['desc_sol'][$z]."', '".$_POST['cant_det'][$z]."', '".$_POST['und_med'][$z]."', '".$_POST['aux_ap_d'][$z]."', '".$_POST['aux_ap_g'][$z]."', 'Pendiente')";
								if(dbExecute($Sql_det_i)){}
							}
							$z++;
						}
					}
			//***************************************************************************************************
				echo"<input type='hidden' name='modifica' id='modifica' value='".$_POST['cod_sol']."' />";
				echo"<input type='hidden' name='area' id='area' value='".$_POST['combo3']."' />";
				echo"<input type='hidden' name='fecha' id='fecha' value='".$_POST['f1']."' />";
				echo "<script language='Javascript'>
				
					alert('La Modificacion se Realizo Correctamente');
					document.f7.submit();
				</script>";
			}else{
				echo"<input type='hidden' name='modifica' id='modifica' value='".$_POST['cod_sol']."' />";
				echo"<input type='hidden' name='area' id='area' value='".$_POST['combo3']."' />";
				echo"<input type='hidden' name='fecha' id='fecha' value='".$_POST['f1']."' />";
				echo "<script language='Javascript'>
				
					alert('Error Al Modificar El Informe');
					document.f7.submit();
				</script>";
			}
		$x++;
		}
	}else{
		echo"<input type='hidden' name='modifica' id='modifica' value='".$_POST['cod_sol']."' />";
		echo"<input type='hidden' name='area' id='area' value='".$_POST['combo3']."' />";
		echo"<input type='hidden' name='fecha' id='fecha' value='".$_POST['f1']."' />";
		echo "<script language='Javascript'>
				
		alert('Error Al Modificar El Informe');
		document.f7.submit();
		</script>";
	}
}



/**********************************************************************************************************************************
				APROBAR FSR (BODEGA)
**********************************************************************************************************************************/			
if($_POST['aprueba'] == "Aprobar" and $_POST['aux_ap_b'] != "0" and $_SESSION['usd_sol_ap_bod'] == "1" )
{
	$x=0; 	// VARIABLE PARA INICIALIZAR EL CONTADOR	
	while($x < $contador_f)
	{			
		//if($_POST['aux_ap_b'][$x] 	!= "2"){ $_POST['aux_ap_b'][$x] = "1"; }
		if($_POST['cant_b'][$x] 	== ""){ $_POST['cant_b'][$x] = 0; }
		if($_POST['cant_b'][$x] 	== $_POST['cant_det'][$x]){ $recepcion = "Completa"; }
		if($_POST['cant_b'][$x] > 0 and $_POST['cant_b'][$x] != $_POST['cant_det'][$x]){ $recepcion = "Parcial"; }
		if($_POST['cant_b'][$x] 	== 0){ $recepcion = "Pendiente"; }
			
		$SqlAp = "UPDATE tb_det_sol SET cant_b	    	= '".$_POST['cant_b'][$x]."',
										rec_det	    	= '$recepcion',
										det_ap_b		= '".$_POST['aux_ap_b'][$x]."',
										valor_bodega    = '".$_POST['valor_bodega'][$x]."'
										WHERE id_det	= '".$_POST['id'][$x]."' ";		
			
		if(dbExecute($SqlAp))
		{
			if($x == ($contador_f - 1))
			{	
			/**********************************************************************************************************************************
									CONSULTA SI LA SOLICITUD ESTA APROBADA
			**********************************************************************************************************************************/	
				$co=mysql_connect("$DNS","$USR","$PASS");
				mysql_select_db("$BDATOS", $co);
				
				$sqlc	= "SELECT * FROM tb_det_sol WHERE cod_sol = '".$_POST["cod_sol"]."' and det_ap_g = '2' ";
				$res	= mysql_query($sqlc,$co);
				$cont 	= mysql_num_rows($res);
					
				if($cont != 0)
				{
					$Sqlupd = "UPDATE tb_sol_rec SET aprob_bod  = '".$_POST["usuario_nombre"]."', fe_aprob_b = '$fe', hr_apbb_sol = '$hora' WHERE cod_sol = '".$_POST["cod_sol"]."' ";
					if(dbExecute($Sqlupd))
					{
						$co=mysql_connect("$DNS","$USR","$PASS");
						mysql_select_db("$BDATOS", $co);
					
						if($_POST['ods_sol'] != ""){$name_carpeta = $_POST['ods_sol'];}
						else{$name_carpeta = $_POST['cc_sol'];}
												
						//ENVIAMOS LA SOLICITUDS POR CORREO
						$ruta_c 	= $carpeta_solicitudes.$name_carpeta."/FSR-".$_POST["cod_sol"].".pdf";
						$nombre 	= "FSR-".$_POST["cod_sol"].".pdf";
						genera_pdf_ad($_POST['cod_sol']); // GENERAMOS Y GUARDAMOS EL ARCHIVO PDF LLAMANDO A LA FUNCION
						$result 	= envia_adjunto_bodega($_POST["cod_sol"], $ruta_c, $nombre, $_POST['detecta_modal']);
						
					}else{
						echo"<input type='hidden' name='aprueba' id='aprueba' value='".$_POST['cod_sol']."' />";
						echo"<input type='hidden' name='detecta_modal_p' id='detecta_modal_p' value='".$_POST['detecta_modal']."'/>";
						echo "<script language='Javascript'>
							alert('Error!!!! al validar la solicitud de recursos, verifique los datos solicitados');
							document.f7.submit();
						</script>";
					}	
				}else{
					echo"<input type='hidden' name='aprueba' id='aprueba' value='".$_POST['cod_sol']."' />";
					echo"<input type='hidden' name='detecta_modal_p' id='detecta_modal_p' value='".$_POST['detecta_modal']."'/>";
					echo "<script language='Javascript'>
						alert('No existe ningun item aprobado');
						document.f7.submit();
					</script>";
				}
			}		
		}else{
			echo"<input type='hidden' name='aprueba' id='aprueba' value='".$_POST['cod_sol']."' />";
			echo"<input type='hidden' name='detecta_modal_p' id='detecta_modal_p' value='".$_POST['detecta_modal']."'/>";
			echo "<script language='Javascript'>
				alert('Error!!!! al validar la solicitud de recursos');
				document.f7.submit();
			</script>";
		}
		$x++;
	}	// Fin de while
}
if($_POST['des_aprueba'] == "Desaprobar")
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$Sqlupd = "UPDATE tb_sol_rec SET aprob_ger  = '', aprob_dpto  = '', aprob_bod  = '', fe_aprob_g = '0000-00-00', fe_aprob_d = '0000-00-00', fe_aprob_b = '0000-00-00', hr_apb_sol = '00:00:00' WHERE cod_sol = '".$_POST["cod_sol"]."'";
	dbExecute($Sqlupd);
	
	$x=0;
	while($x < $contador_f)
	{
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS", $co);
			
		// MODIFICAREMOS EL DETALLE DE LA SOLICITUD
		$SqlAp = "UPDATE tb_det_sol SET det_ap_g	= '0',
										det_ap_d	= '0',
										det_ap_b	= '0',
										rec_det 	= 'Pendiente'
										
										WHERE id_det= '".$_POST['id'][$x]."' ";	
					dbExecute($SqlAp);
		$x++;
	}
	echo"<input type='hidden' name='aprueba' id='aprueba' value='".$_POST['cod_sol']."'/>";
	echo "<script language='Javascript'>
		alert('La solicitud de recursos Nº $cod_sol Fue Desaprobada correctamente');
		document.f7.submit();
	</script>";
}
/**********************************************************************************************************************************
				APROBAR FSR Y ENVIAR A ADQUISICIONES (OPERACIONES)
**********************************************************************************************************************************/			
if($_POST['aprueba'] == "Aprobar")
{
	if($_SESSION['usd_sol_ap_ger'] == "1" and $_POST['tipo_ap'] == "Gerencia") // Preguntamos el tipo de permisos para aprobar
	{
		$aux_ap_x			= "aux_ap_g";  	// Campo que trae la aprobacion (si los checbox estan marcados)
		$det_ap_x 			= "det_ap_g";	// Campo que guarda la aprobacion del detalle en la BD
		$aprob_x 			= "aprob_ger";	// Campo que guarda el nombre de quien aprueba
		$fe_aprob_x 		= "fe_aprob_g";	// Campo que guarda la fecha de aprobacion
		$tipo_aprobacion 	= "Gerencia";
		//$sql_hora_apb		= ", hr_apb_sol = $hora";
	}
	if($_SESSION['usd_sol_ap_dep'] == "1" and $_POST['tipo_ap'] == "Departamento") // Preguntamos el tipo de permisos para aprobar
	{
		$aux_ap_x			= "aux_ap_d";  	// Campo que trae la aprobacion (si los checbox estan marcados)
		$det_ap_x 			= "det_ap_d";	// Campo que guarda la aprobacion del detalle en la BD
		$aprob_x 			= "aprob_dpto";	// Campo que guarda el nombre de quien aprueba
		$fe_aprob_x 		= "fe_aprob_d";	// Campo que guarda la fecha de aprobacion
		$tipo_aprobacion 	= "Departamento";
	}
	
	$x=0; 	// VARIABLE PARA INICIALIZAR EL CONTADOR	
	while($x < $contador_f)
	{	
			
		// MODIFICAREMOS EL DETALLE DE LA SOLICITUD	
		if($_POST['cant_det'][$x] == ""){ $_POST['cant_det'][$x] = 0; }
		if($_POST['$aux_ap_x'][$x] == "1"){ $Recepcion = "Rechazada"; }else{$Recepcion = "Pendiente";}// SOLO PARA GERENCIA
		
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS", $co);
		
		$SqlAp = "UPDATE tb_det_sol SET $det_ap_x	= '".$_POST[$aux_ap_x][$x]."',
										rec_det 	= '$Recepcion'
										
										WHERE id_det= '".$_POST['id'][$x]."' ";
		if(dbExecute($SqlAp))
		{	// // SI LA MIDIFICACION DEL DETALLE SE EJECUTO CORRECTAMENTE LA MARCAREMOS COMO APROBADA
			if($x == ($contador_f - 1))
			{
				$co=mysql_connect("$DNS","$USR","$PASS");
				mysql_select_db("$BDATOS", $co);
				
				// CONSULTAMOS SI LA SOLICITUD YA ESTA APROBADA
				$sqlc	= "SELECT * FROM tb_det_sol WHERE cod_sol = '".$_POST["cod_sol"]."' and ($det_ap_x = 2 or $det_ap_x = 1)";
				$respc	= mysql_query($sqlc,$co);
				$contg 	= mysql_num_rows($respc);
				
				// SI NO ESTA APROBADA (NO SE ENCUENTRAN REGISTROS) ENTONCES LA APROBAMOS Y MARCAMOS COMO APROBADA
				if($contg != 0)
				{
					$co=mysql_connect("$DNS","$USR","$PASS");
					mysql_select_db("$BDATOS", $co);
				
					$Sqlupd = "UPDATE tb_sol_rec SET $aprob_x  = '".$_POST["usuario_nombre"]."', $fe_aprob_x = '$fe' WHERE cod_sol = '".$_POST["cod_sol"]."'";
					if(dbExecute($Sqlupd))
					{
						// SI EL TIPO DE APROBACION ES IGUAL A GERENCIA
						if($tipo_aprobacion == "Departamento")
						{
							genera_pdf($_POST['cod_sol']); // GENERAMOS Y GUARDAMOS EL ARCHIVO PDF LLAMANDO A LA FUNCION
						
							echo"<input type='hidden' name='aprueba' id='aprueba' value='".$_POST['cod_sol']."'/>";
							echo"<input type='hidden' name='detecta_modal_p' id='detecta_modal_p' value='".$_POST['detecta_modal']."'/>";
							echo "<script language='Javascript'>
								alert('La solicitud de recursos Nº $cod_sol Fue validada correctamente $msj_envio');
								document.f7.submit();
							</script>";
						
						}
						
						
						// SI EL TIPO DE APROBACION ES IGUAL A GERENCIA
						if($tipo_aprobacion == "Gerencia")
						{
							$co=mysql_connect("$DNS","$USR","$PASS");
							mysql_select_db("$BDATOS", $co);
	
							if($_POST['ods_sol'] != ""){ $name_carpeta = $_POST['ods_sol']; }else{ $name_carpeta = $_POST['cc_sol']; }
							
							// PREGUNTAMOS SI EL DOCUMENTO YA ESTA INGRESADO EN LA CARPETA Y EN LA BD
							$query	= "SELECT * FROM documentos WHERE nom_doc='$nombre' AND ruta_doc='$ruta'";
							$result	= mysql_query($query,$co);
							$cant	= mysql_num_rows($result);
								
							if($cant == 0)
							{	// SI EL DOCUMENTO NO ESTA INGRESADO LO INGRESAMOS
								$ing = "INSERT INTO documentos (ruta_doc, rutac_doc, carp_doc, nom_doc, nivel_doc, sub_por, fecha_sub) values('$ruta', '$ruta_c', '$name_carpeta', '$nombre', 5, 'Intranet','$fesol')";
								if(mysql_query($ing, $co))
								{
									// SI EL INGRESO FUE CORRECTO GUARDAMOS LA SOLICITUD Y LA ENVIAMOS POR CORREO
									$ruta_c = $carpeta_solicitudes.$name_carpeta."/FSR-".$_POST["cod_sol"].".pdf";
									$nombre = "FSR-".$_POST["cod_sol"].".pdf";
									genera_pdf($_POST['cod_sol']); // GENERAMOS Y GUARDAMOS EL ARCHIVO PDF LLAMANDO A LA FUNCION
									$result = envia_adjunto($_POST["cod_sol"], $ruta_c, $nombre, $_POST['detecta_modal']);
								}
							}else{
								// SI EL DOCUMENTO ESTA INGRESADO GUARDAMOS LA SOLICITUD Y LA ENVIAMOS POR CORREO
								$ruta_c 	= $carpeta_solicitudes.$name_carpeta."/FSR-".$_POST["cod_sol"].".pdf";
								$nombre 	= "FSR-".$_POST["cod_sol"].".pdf";
								genera_pdf($_POST['cod_sol']); // GENERAMOS Y GUARDAMOS EL ARCHIVO PDF LLAMANDO A LA FUNCION
								$result 	= envia_adjunto($_POST["cod_sol"], $ruta_c, $nombre, $_POST['detecta_modal']);
							}	// if($cant == 0)	
						} // Fin si es aprobacion de gerencia
			
					}	// if(dbExecute($Sqlupd))	
				}	// if($contg != 0)
				else{
				echo"<input type='hidden' name='aprueba' id='aprueba' value='".$_POST['cod_sol']."' />";
				echo "<script language='Javascript'>
					alert('Error!!!! La solicitud ya esta aprobada');
					document.f7.submit();
				</script>";
				}
				
			}	// if($x == ($contador_f - 1))
		}else{
			echo"<input type='hidden' name='aprueba' id='aprueba' value='".$_POST['cod_sol']."' />";
			echo "<script language='Javascript'>
				alert('Error!!!! al validar la solicitud de recursos');
				document.f7.submit();
			</script>";
		} //if(dbExecute($SqlAp))
		
		$x++;
	} // while($x < $contador_f)
}

/**********************************************************************************************************************************
				APROBAR FSR (DEPARTAMENTO)
**********************************************************************************************************************************/			
/*if($_POST['aprueba'] == "Aprobar" and $_SESSION['usd_sol_ap_dep'] == "1" )
{
	$x=0; 	// VARIABLE PARA INICIALIZAR EL CONTADOR	
	while($x < $contador_f)
	{	
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS", $co);
	
		if($_POST['cant_det'][$x] == ""){ $_POST['cant_det'][$x] = 0; }
		
		$SqlAp = "UPDATE tb_det_sol SET det_ap_d	= '".$_POST['aux_ap_d'][$x]."',
										rec_det 	= 'Pendiente'
										WHERE id_det= '".$_POST['id'][$x]."' ";		
		
		if(dbExecute($SqlAp))
		{
			if($x == ($contador_f - 1))
			{	
				/**********************************************************************************************************************************
								CONSULTA SI LA SOLICITUD ESTA APROBADA
				**********************************************************************************************************************************/	
				/*$co=mysql_connect("$DNS","$USR","$PASS");
				mysql_select_db("$BDATOS", $co);
			
				$sqlc	= "SELECT * FROM tb_det_sol WHERE cod_sol = '".$_POST["cod_sol"]."' and (det_ap_d = '2' or det_ap_d = '1')";
				$res	= mysql_query($sqlc,$co);
				$cont 	= mysql_num_rows($res);
				
				if($cont != 0)
				{
					$Sqlupd = "UPDATE tb_sol_rec SET aprob_dpto  = '".$_POST["usuario_nombre"]."', fe_aprob_d = '$fe' WHERE cod_sol = '".$_POST["cod_sol"]."' ";
					if(dbExecute($Sqlupd))
					{
						genera_pdf($_POST['cod_sol']); // GENERAMOS Y GUARDAMOS EL ARCHIVO PDF LLAMANDO A LA FUNCION
						
						echo"<input type='hidden' name='aprueba' id='aprueba' value='".$_POST['cod_sol']."'/>";
						echo"<input type='hidden' name='detecta_modal_p' id='detecta_modal_p' value='".$_POST['detecta_modal']."'/>";
						echo "<script language='Javascript'>
							alert('La solicitud de recursos Nº $cod_sol Fue validada correctamente $msj_envio');
							document.f7.submit();
						</script>";
					}else{
						echo"<input type='hidden' name='aprueba' id='aprueba' value='".$_POST['cod_sol']."' />";
						echo"<input type='hidden' name='detecta_modal_p' id='detecta_modal_p' value='".$_POST['detecta_modal']."'/>";
						echo "<script language='Javascript'>
							alert('Error!!!! al validar la solicitud de recursos');
							document.f7.submit();
						</script>";
					}	
				}else{
					echo"<input type='hidden' name='aprueba' id='aprueba' value='".$_POST['cod_sol']."' />";
					echo"<input type='hidden' name='detecta_modal_p' id='detecta_modal_p' value='".$_POST['detecta_modal']."'/>";
					echo "<script language='Javascript'>
						alert('Error!!!! al validar la solicitud de recursos');
						document.f7.submit();
					</script>";
				}
			}		
		}else{
			echo"<input type='hidden' name='aprueba' id='aprueba' value='".$_POST['cod_sol']."' />";
			echo"<input type='hidden' name='detecta_modal_p' id='detecta_modal_p' value='".$_POST['detecta_modal']."'/>";
			echo "<script language='Javascript'>
				alert('Error!!!! al validar la solicitud de recursos');
				document.f7.submit();
			</script>";
		}
		$x++;
	}

}*/


/**********************************************************************************************************************************
				FUNCION PARA GENERAR PDF PARA ADQUISICIONES
**********************************************************************************************************************************/	

function genera_pdf_ad($cod_sol)
{
	require('fpdf.php');
					
	$pdf=new FPDF();
	$pdf->AddPage();
					
	$fesol=date("Y-m-d");
					
	class PDF extends FPDF
	{
		// Cabecera de pagina
		function Header()
		{
						
		}
		//Pie de página
		function Footer()
		{
			//Posición: a 1,5 cm del final
			$this->SetY(-15);
			//Arial Black de 10
			$this->SetFont('Arial','',10);
			//Número de página
			$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
		}
	}
	
	$pdf=new PDF('L','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage(); 
					
	$pdf->SetFont('Arial','',12);
	
	$carpeta_solicitudes = $GLOBALS["carpeta_solicitudes"];
	
	$co=mysql_connect($GLOBALS["DNS"], $GLOBALS["USR"], $GLOBALS["PASS"]);
	mysql_select_db($GLOBALS["BDATOS"], $co);
					
	$sqlfsr		= "SELECT * FROM tb_sol_rec, tb_det_sol WHERE tb_sol_rec.cod_sol = '$cod_sol' and tb_sol_rec.cod_sol = tb_det_sol.cod_sol ";
	$resp_fsr	= mysql_query($sqlfsr,$co);
	
	unset($consulta);
	while ($row_fsr = mysql_fetch_array($resp_fsr)) {
		$consulta[] = $row_fsr; 
	}
					
	$fe_sol 	= $consulta[0]['fe_sol'];
	$fe_aprob_g = $consulta[0]['fe_aprob_g'];
	$fe_aprob_b = $consulta[0]['fe_aprob_b'];
	$ods_sol 	= $consulta[0]['ods_sol'];
	$cc_sol 	= $consulta[0]['cc_sol'];
	$area_sol 	= $consulta[0]['area_sol'];
	$aprob_ger 	= $consulta[0]['aprob_ger'];
	$aprob_dpto = $consulta[0]['aprob_dpto'];
	$aprob_bod  = $consulta[0]['aprob_bod'];
	$prof_sol   = $consulta[0]['prof_sol'];
	$fe_en_obra = $consulta[0]['fe_en_obra'];
	$empr_sol   = $consulta[0]['empr_sol'];
	$hr_apb_sol = $consulta[0]['hr_apb_sol'];
	$hr_ing_sol = $consulta[0]['hr_ing_sol'];
	$hr_apbb_sol= $consulta[0]['hr_apbb_sol'];
	$valor_aprox = $consulta[0]['valor_aprox'];
	$valor_bodega = $consulta[0]['valor_bodega'];
	
	$co=mysql_connect($GLOBALS["DNS"], $GLOBALS["USR"], $GLOBALS["PASS"]);
	mysql_select_db($GLOBALS["BDATOS"], $co);
	
	$sql_a 		= "SELECT * FROM tb_areas WHERE cod_ar = '$area_sol' ";
	$resp_a		= mysql_query($sql_a,$co);
	$total_a 	= mysql_num_rows($resp_a);
		
	while($vrows_a = mysql_fetch_array($resp_a))
	{
		$nom_area 	= "".$vrows_a['desc_ar']."";
		$cod_ar 	= "".$vrows_a['cod_ar']."";
		$cod_dep 	= "".$vrows_a['cod_dep']."";
			
		$sql_dpto 	= "SELECT * FROM tb_dptos WHERE cod_dep ='$cod_dep' ";
		$resp_dpto	= mysql_query($sql_dpto,$co);
		while($vrowsd=mysql_fetch_array($resp_dpto))
		{
			$desc_dep 	= "".$vrowsd['desc_dep']."";
			$cod_dep 	= "".$vrowsd['cod_dep']."";
			$cod_ger 	= "".$vrowsd['cod_ger']."";
						
			$sql_ger 	= "SELECT * FROM tb_gerencia WHERE cod_ger ='$cod_ger' ";
			$resp_ger	= mysql_query($sql_ger,$co);
			while($vrowsd=mysql_fetch_array($resp_ger))
			{
				$desc_ger 	= "".$vrowsd['desc_ger']."";
				$cod_ger 	= "".$vrowsd['cod_ger']."";
			}
						
		}	
	}


$fe_sol		= cambiarFecha($fe_sol, '-', '/' );
$fe_aprob_g	= cambiarFecha($fe_aprob_g, '-', '/' ); 
$fe_aprob_b	= cambiarFecha($fe_aprob_b, '-', '/' ); 
$fe_en_obra	= cambiarFecha($fe_en_obra, '-', '/' ); 

if($fe_aprob_b == "00/00/0000"){$fe_aprob_b = "";}
if($fe_aprob_g == "00/00/0000"){$fe_aprob_g = "";}

if($hr_apbb_sol == "00:00:00"){$hr_apbb_sol = "";}
if($hr_apb_sol  == "00:00:00"){$hr_apb_sol  = "";}
//*************** LOGO ROCKMINE *****************************

$pdf->Image('imagenes/logo2.jpg',13,12,23);

//************** PRIMERA FILA ***************************
$pdf->Cell(28,15," ",1,0,'C'); 
$pdf->Cell(216,15,"FORMULARIO DE SOLICITUD DE RECURSOS Y COTIZACION",1,0,'C'); 
$pdf->SetFont('Arial','',8);

$pdf->Cell(12,5,"COD.",1,0,'C'); 
$pdf->Cell(25,5,"SGI-GER-R-087",1,1,'L'); 

$pdf->Cell(244,5," ",0,0,'C'); 
$pdf->Cell(12,5,"REV.",1,0,'C'); 
$pdf->MultiCell(25,5,"02",1,1,'L'); 

$pdf->Cell(244,5," ",0,0,'C'); 
$pdf->Cell(12,5,"Fecha",1,0,'C'); 
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(25,5,"15/05/2012",1,1,'L'); 
//************** SEGUNDA FILA ***************************
$pdf->SetFont('Arial','',8);
$pdf->Cell(50,6,utf8_decode("Nº DE SOLICITUD"),1,0,'L'); 
$pdf->SetFont('Arial','',9);
$pdf->Cell(140,6,"$cod_sol",1,0,'L'); 
$pdf->SetFont('Arial','',8);
$pdf->Cell(1,6,"",0,0,'C'); 
$pdf->Cell(40,6,"Profesional/Solicitante",1,0,'L');
$pdf->Cell(50,6,utf8_decode($prof_sol),1,1,'C'); 

//************* TERCERA FILA ****************************
$pdf->SetFont('Arial','',8);
$pdf->Cell(50,6,"Empresa  -  Area o contrato",1,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(140,6,$desc_ger." - ".$desc_dep." - ".utf8_decode($nom_area),1,0,'L');

$pdf->Cell(1,6,"",0,0,'C'); 

$pdf->SetFont('Arial','',8);
$pdf->Cell(40,6,"Fecha en Obra",1,0,'L'); 
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,6,"$fe_en_obra",1,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(50,6,"Centro de Costo",1,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(140,6,"$cc_sol",1,0,'L');

$pdf->Cell(1,6,"",0,0,'C'); 

$pdf->SetFont('Arial','',8);
$pdf->Cell(40,6,"Fecha elab. solicitud",1,0,'L'); 
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,6,"$fe_sol  - ".$hr_ing_sol,1,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(50,6,utf8_decode("Nº informe/ODS"),1,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(140,6,"$ods_sol",1,0,'L');
$pdf->Cell(1,6,"",0,0,'C'); 
$pdf->SetFont('Arial','',8);

$pdf->Cell(40,6,"Fecha aprob. solicitud",1,0,'L'); 
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,6,"$fe_aprob_g  - ".$hr_apb_sol,1,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(190,5,"",1,0,'L');
$pdf->Cell(1,5,"",0,0,'C'); 
$pdf->Cell(30,5,"APROBACION",1,0,'C'); 
$pdf->Cell(30,5,"EXISTE EN BOD.",1,0,'C'); 
$pdf->Cell(30,5,"RECEPCION",1,1,'C');

$pdf->Cell(6,5,"Nº",1,0,'L');
$pdf->Cell(116,5,"Descripcion clara y detallada del Requerimiento",1,0,'L');
$pdf->Cell(20,5,"Unidad Med.",1,0,'L');
$pdf->Cell(8,5,"Cant.",1,0,'L');
$pdf->Cell(20,5,"Valor Aprox",1,0,'L');
$pdf->Cell(20,5,"Valor Bodeg",1,0,'L');

$pdf->Cell(1,5,"",0,0,'C'); 
$pdf->Cell(15,5,"Jefe Dpto.",1,0,'C');
$pdf->Cell(15,5,"Gte. Op",1,0,'C');
$pdf->Cell(18,5,"Si / No",1,0,'C');
$pdf->Cell(12,5,"Cant.",1,0,'C');
$pdf->Cell(30,5,"",1,1,'C');
			
	//$this->Cell(80);
	$ani=13; // ancho Item	
	$i=0;
	//$total =  count($consulta);
	$total =  12;
	$xx=53;
	
	while($i < $total)
	{
		//$pdf->Cell(4,5,'');
		$valor0 		= $i+1;
		$desc_sol 		= $consulta[$i]['desc_sol'];
		$und_med 		= $consulta[$i]['und_med'];
		$cant_det 		= $consulta[$i]['cant_det'];
		$fecha_sol 		= $consulta[$i]['fecha_sol'];	
		$det_ap_d 		= $consulta[$i]['det_ap_d'];
		$det_ap_g		= $consulta[$i]['det_ap_g'];
		$det_ap_b		= $consulta[$i]['det_ap_b'];
		$rec_det		= $consulta[$i]['rec_det'];	
		$ex_bod_det		= $consulta[$i]['ex_bod_det'];
		$cant_b			= $consulta[$i]['cant_b'];
		$valor_aprox	= $consulta[$i]['valor_aprox'];
		$valor_bodega   = $consulta[$i]['valor_bodega'];		
		
		$co=mysql_connect($GLOBALS["DNS"], $GLOBALS["USR"], $GLOBALS["PASS"]);
		mysql_select_db($GLOBALS["BDATOS"], $co);
			
		$sql_um	= "SELECT * FROM tb_und_med WHERE cod_um = '$und_med' ";
		$res_um	= mysql_query($sql_um,$co);
		while($vrows_um = mysql_fetch_array($res_um))
		{
			$nom_um 	= $vrows_um['nom_um'];
		}	
		
		$pdf->Cell(6,7,"$valor0",1,0,'L');
		$pdf->Cell(116,7,utf8_decode($desc_sol),1,0,'L');
		$pdf->Cell(20,7,"$nom_um",1,0,'L');
		$pdf->Cell(8,7,"$cant_det",1,0,'L');
		$pdf->Cell(20,7,"$valor_aprox",1,0,'L');
		$pdf->Cell(20,7,"$valor_bodega",1,0,'L');
		
		if($det_ap_d  == "2"){$tipo_p = "imagenes/ok.jpg"; }else{ $tipo_p = "imagenes/no.jpg";}
		if($det_ap_g  == "2"){$tipo_g = "imagenes/ok.jpg"; }else{ $tipo_g = "imagenes/no.jpg";}
		if($det_ap_b  == 1 and $cant_b == $cant_det){$tipo_b = "imagenes/ok.jpg"; }
		if($det_ap_b  == 1 and $cant_b > 0 and $cant_b != $cant_det){$tipo_b = "imagenes/ok.jpg"; }
		if($det_ap_b  == 2){$tipo_b = "imagenes/no.jpg"; }
		
		if($det_ap_d  == 0){$tipo_p = "imagenes/blanco.jpg"; }
		if($det_ap_g  == 0){$tipo_g = "imagenes/blanco.jpg"; }
		if($det_ap_b  == 0){$tipo_b = "imagenes/blanco.jpg"; }
		
		//if($ex_bod_det == "1"){$ex_b = "imagenes/ok.jpg"; $xy="234"; }else{ $ex_b = "imagenes/no.jpg"; $xy="243"; }
		
		$xx = $xx + 7;
		if($desc_sol != ""){$varp = $pdf->Image($tipo_p,206,$xx,4);}else{$desc_sol == "";}
		if($desc_sol != ""){$varg = $pdf->Image($tipo_g,220,$xx,4);}else{$desc_sol == "";}
		if($desc_sol != ""){$varb = $pdf->Image($tipo_b,238,$xx,4);}else{$desc_sol == "";}
		
		if($aprob_bod == ""){$cant_b = "";}
		
		$pdf->Cell(1,7,$varp,0,0,'C'); 
		$pdf->Cell(15,7,$varg,1,0,'C');
		$pdf->Cell(15,7,$varb,1,0,'C');
		$pdf->Cell(18,7,"$ex_bod_det",1,0,'C');
		$pdf->Cell(12,7,"$cant_b",1,0,'C');
		$pdf->Cell(30,7,"$rec_det",1,1,'C');
		$nom_um="";
		$i++;
	}
/******************************************************************************
CONSULTAMOS SI LA SOLICITUD ESTA APROBADA PARA IMPRIMIR LA FIRMA DIGITAL
******************************************************************************/
	$aprob_dpto = htmlspecialchars($aprob_dpto);
	$aprob_ger 	= htmlspecialchars($aprob_ger);
	
	//if($aprob_adm == "Juan Rosales Pino")		{ $a_p = $pdf->Image('imagenes/firma4.jpg',130,140,45);}
	if($aprob_dpto == "Victor Hugo Ortiz Tovar")		{ $a_p = $pdf->Image('imagenes/firma4_4.jpg',140,145,45);}
	//if($aprob_adm == "Patrico Riquelme S.")		{ $a_p = $pdf->Image('imagenes/firma2.jpg',130,140,45);}

	if($aprob_ger  == "Miguel Rubio")			{ $a_g = $pdf->Image('imagenes/firma8_8.jpg',130,153,20);}
	//if($aprob_ger  == "Jose Acevedo")		{ $a_g = $pdf->Image('imagenes/firma4_4.jpg',130,155,40);}
	
	if($aprob_bod  == "Ronaldo Mandujano")		{ $a_b = $pdf->Image('imagenes/ronaldo.jpg',245,162,45);}
		
	if($ods_sol != "")
	{
		$name_carpeta = $ods_sol;
	}else{
		$name_carpeta = $cc_sol;
	}
	
/******************************************************************************/

//Firma cuando bodeha acepta
$adqui = $pdf->Image('imagenes/centonzio_1.jpg',130,170,20);

$pdf->Cell(158,4,"AUTORIZADA POR:",1,1,'C');

$pdf->Cell(38,4,"Area",1,0,'C');
$pdf->Cell(80,4,"Nombre",1,0,'C');
$pdf->Cell(40,4,"Firma",1,1,'C');

$pdf->Cell(38,10,"DEPARTAMENTO",1,0,'L');
$pdf->Cell(80,10,utf8_decode("$aprob_dpto"),1,0,'C');
$pdf->Cell(40,10,$a_p,1,0,'L');

$pdf->Cell(33,10,"",0,0,'L');
$pdf->Cell(49,10,"FECHA APROBACION BODEGA",1,0,'C');
$pdf->Cell(41,10,"$fe_aprob_b - ".$hr_apbb_sol,1,1,'C');

$pdf->Cell(38,10,"OPERACIONES",1,0,'L');
$pdf->Cell(80,10,utf8_decode("$aprob_ger"),1,0,'C');
$pdf->Cell(40,10,$a_g,1,0,'L');

$pdf->Cell(33,10,"",0,0,'L');
$pdf->Cell(49,10,"NOMBRE ENCARGADO BODEGA",1,0,'C');
$pdf->Cell(41,10,utf8_decode("$aprob_bod"),1,1,'C');


$pdf->Cell(38,10,"ABASTECIMIENTO",1,0,'L');
$pdf->Cell(80,10,"Pablo Centonzio",1,0,'C');
$pdf->Cell(40,10,$adqui,1,0,'L');

$pdf->Cell(33,10,"",0,0,'L');
$pdf->Cell(49,10,"FIRMA ENCARGADO BODEGA",1,0,'C');
$pdf->Cell(41,10,"",1,1,'L');
	
	$ruta 	= $carpeta_solicitudes.$name_carpeta."/";
	$ruta_c = $carpeta_solicitudes.$name_carpeta."/FSR-".$cod_sol.".pdf";
	$nombre = "FSR-".$cod_sol.".pdf";
	
	if(!is_dir($ruta))  		// Preguntamos si la carpeta No Existe
	{
		@mkdir($ruta, 0777);  	// si no existe la creamos
	}

	$query	= "SELECT * FROM documentos WHERE nom_doc='$nombre' AND ruta_doc='$ruta'";
	$result	= mysql_query($query,$co);
	$cant	= mysql_num_rows($result);
					
	if($cant == 0)
	{
		$ing = "INSERT INTO documentos (ruta_doc, rutac_doc, carp_doc, nom_doc, nivel_doc, sub_por, fecha_sub) values('$ruta', '$ruta_c', '$name_carpeta', '$nombre', 5, 'Intranet','$fesol')";
		mysql_query($ing, $co);
	}
	$pdf->Output($ruta_c);
}

/**********************************************************************************************************************************
				FUNCION PARA GENERAR PDF PARA BODEGA
**********************************************************************************************************************************/	
function genera_pdf($cod_sol)
{
	require('fpdf.php');
					
	$pdf=new FPDF();
	$pdf->AddPage();
					
	$fesol=date("Y-m-d");
					
	class PDF extends FPDF
	{
		// Cabecera de pagina
		function Header()
		{
						
		}
		//Pie de página
		function Footer()
		{
			//Posición: a 1,5 cm del final
			$this->SetY(-15);
			//Arial Black de 10
			$this->SetFont('Arial','',10);
			//Número de página
			$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
		}
	}
	
	$pdf=new PDF('L','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage(); 
					
	$pdf->SetFont('Arial','',12);
	
	$carpeta_solicitudes = $GLOBALS["carpeta_solicitudes"];
	
	$co=mysql_connect($GLOBALS["DNS"], $GLOBALS["USR"], $GLOBALS["PASS"]);
	mysql_select_db($GLOBALS["BDATOS"], $co);
					
	$sqlfsr		= "SELECT * FROM tb_sol_rec, tb_det_sol WHERE tb_sol_rec.cod_sol = '$cod_sol' and tb_sol_rec.cod_sol = tb_det_sol.cod_sol ";
	$resp_fsr	= mysql_query($sqlfsr,$co);
	
	unset($consulta);
	while ($row_fsr = mysql_fetch_array($resp_fsr)) {
		$consulta[] = $row_fsr; 
	}
					
	$fe_sol 	= $consulta[0]['fe_sol'];
	$fe_aprob_g = $consulta[0]['fe_aprob_g'];
	$fe_aprob_b = $consulta[0]['fe_aprob_b'];
	$ods_sol 	= $consulta[0]['ods_sol'];
	$cc_sol 	= $consulta[0]['cc_sol'];
	$area_sol 	= $consulta[0]['area_sol'];
	$aprob_ger 	= $consulta[0]['aprob_ger'];
	$aprob_dpto = $consulta[0]['aprob_dpto'];
	$aprob_bod  = $consulta[0]['aprob_bod'];
	$prof_sol   = $consulta[0]['prof_sol'];
	$fe_en_obra = $consulta[0]['fe_en_obra'];
	$empr_sol   = $consulta[0]['empr_sol'];
	$hr_apb_sol = $consulta[0]['hr_apb_sol'];
	$hr_ing_sol = $consulta[0]['hr_ing_sol'];
	$hr_apbb_sol= $consulta[0]['hr_apbb_sol'];
	$valor_aprox = $consulta[0]['valor_aprox'];
	$valor_bodega = $consulta[0]['valor_bodega'];
	
	$co=mysql_connect($GLOBALS["DNS"], $GLOBALS["USR"], $GLOBALS["PASS"]);
	mysql_select_db($GLOBALS["BDATOS"], $co);
	
	$sql_a 		= "SELECT * FROM tb_areas WHERE cod_ar = '$area_sol' ";
	$resp_a		= mysql_query($sql_a,$co);
	$total_a 	= mysql_num_rows($resp_a);
		
	while($vrows_a = mysql_fetch_array($resp_a))
	{
		$nom_area 	= "".$vrows_a['desc_ar']."";
		$cod_ar 	= "".$vrows_a['cod_ar']."";
		$cod_dep 	= "".$vrows_a['cod_dep']."";
			
		$sql_dpto 	= "SELECT * FROM tb_dptos WHERE cod_dep ='$cod_dep' ";
		$resp_dpto	= mysql_query($sql_dpto,$co);
		while($vrowsd=mysql_fetch_array($resp_dpto))
		{
			$desc_dep 	= "".$vrowsd['desc_dep']."";
			$cod_dep 	= "".$vrowsd['cod_dep']."";
			$cod_ger 	= "".$vrowsd['cod_ger']."";
						
			$sql_ger 	= "SELECT * FROM tb_gerencia WHERE cod_ger ='$cod_ger' ";
			$resp_ger	= mysql_query($sql_ger,$co);
			while($vrowsd=mysql_fetch_array($resp_ger))
			{
				$desc_ger 	= "".$vrowsd['desc_ger']."";
				$cod_ger 	= "".$vrowsd['cod_ger']."";
			}
						
		}	
	}


$fe_sol		= cambiarFecha($fe_sol, '-', '/' );
$fe_aprob_g	= cambiarFecha($fe_aprob_g, '-', '/' ); 
$fe_aprob_b	= cambiarFecha($fe_aprob_b, '-', '/' ); 
$fe_en_obra	= cambiarFecha($fe_en_obra, '-', '/' ); 

if($fe_aprob_b == "00/00/0000"){$fe_aprob_b = "";}
if($fe_aprob_g == "00/00/0000"){$fe_aprob_g = "";}

if($hr_apbb_sol == "00:00:00"){$hr_apbb_sol = "";}
if($hr_apb_sol  == "00:00:00"){$hr_apb_sol  = "";}
//*************** LOGO ROCKMINE *****************************

$pdf->Image('imagenes/logo2.jpg',13,12,23);

//************** PRIMERA FILA ***************************
$pdf->Cell(28,15," ",1,0,'C'); 
$pdf->Cell(216,15,"FORMULARIO DE SOLICITUD DE RECURSOS Y COTIZACION",1,0,'C'); 
$pdf->SetFont('Arial','',8);

$pdf->Cell(12,5,"COD.",1,0,'C'); 
$pdf->Cell(25,5,"SGI-GER-R-087",1,1,'L'); 

$pdf->Cell(244,5," ",0,0,'C'); 
$pdf->Cell(12,5,"REV.",1,0,'C'); 
$pdf->MultiCell(25,5,"02",1,1,'L'); 

$pdf->Cell(244,5," ",0,0,'C'); 
$pdf->Cell(12,5,"Fecha",1,0,'C'); 
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(25,5,"15/05/2012",1,1,'L'); 
//************** SEGUNDA FILA ***************************
$pdf->SetFont('Arial','',8);
$pdf->Cell(50,6,utf8_decode("Nº DE SOLICITUD"),1,0,'L'); 
$pdf->SetFont('Arial','',9);
$pdf->Cell(140,6,"$cod_sol",1,0,'L'); 
$pdf->SetFont('Arial','',8);
$pdf->Cell(1,6,"",0,0,'C'); 
$pdf->Cell(40,6,"Profesional/Solicitante",1,0,'L');
$pdf->Cell(50,6,utf8_decode($prof_sol),1,1,'C'); 

//************* TERCERA FILA ****************************
$pdf->SetFont('Arial','',8);
$pdf->Cell(50,6,"Empresa  -  Area o contrato",1,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(140,6,$desc_ger." - ".$desc_dep." - ".utf8_decode($nom_area),1,0,'L');

$pdf->Cell(1,6,"",0,0,'C'); 

$pdf->SetFont('Arial','',8);
$pdf->Cell(40,6,"Fecha en Obra",1,0,'L'); 
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,6,"$fe_en_obra",1,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(50,6,"Centro de Costo",1,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(140,6,"$cc_sol",1,0,'L');

$pdf->Cell(1,6,"",0,0,'C'); 

$pdf->SetFont('Arial','',8);
$pdf->Cell(40,6,"Fecha elab. solicitud",1,0,'L'); 
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,6,"$fe_sol  - ".$hr_ing_sol,1,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(50,6,utf8_decode("Nº informe/ODS"),1,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(140,6,"$ods_sol",1,0,'L');
$pdf->Cell(1,6,"",0,0,'C'); 
$pdf->SetFont('Arial','',8);

$pdf->Cell(40,6,"Fecha aprob. solicitud",1,0,'L'); 
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,6,"$fe_aprob_g  - ".$hr_apb_sol,1,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(190,5,"",1,0,'L');
$pdf->Cell(1,5,"",0,0,'C'); 
$pdf->Cell(30,5,"APROBACION",1,0,'C'); 
$pdf->Cell(30,5,"EXISTE EN BOD.",1,0,'C'); 
$pdf->Cell(30,5,"RECEPCION",1,1,'C');

$pdf->Cell(6,5,"Nº",1,0,'L');
$pdf->Cell(116,5,"Descripcion clara y detallada del Requerimiento",1,0,'L');
$pdf->Cell(20,5,"Unidad Med.",1,0,'L');
$pdf->Cell(8,5,"Cant.",1,0,'L');
$pdf->Cell(20,5,"Valor Aprox",1,0,'L');
$pdf->Cell(20,5,"Valor Bodeg",1,0,'L');

$pdf->Cell(1,5,"",0,0,'C'); 
$pdf->Cell(15,5,"Jefe Dpto.",1,0,'C');
$pdf->Cell(15,5,"Gte. Op",1,0,'C');
$pdf->Cell(18,5,"Si / No",1,0,'C');
$pdf->Cell(12,5,"Cant.",1,0,'C');
$pdf->Cell(30,5,"",1,1,'C');
			
	//$this->Cell(80);
	$ani=13; // ancho Item	
	$i=0;
	//$total =  count($consulta);
	$total =  12;
	$xx=53;
	
	while($i < $total)
	{
		//$pdf->Cell(4,5,'');
		$valor0 		= $i+1;
		$desc_sol 		= $consulta[$i]['desc_sol'];
		$und_med 		= $consulta[$i]['und_med'];
		$cant_det 		= $consulta[$i]['cant_det'];
		$fecha_sol 		= $consulta[$i]['fecha_sol'];	
		$det_ap_d 		= $consulta[$i]['det_ap_d'];
		$det_ap_g		= $consulta[$i]['det_ap_g'];
		$det_ap_b		= $consulta[$i]['det_ap_b'];
		$rec_det		= $consulta[$i]['rec_det'];	
		$ex_bod_det		= $consulta[$i]['ex_bod_det'];
		$cant_b			= $consulta[$i]['cant_b'];
		$valor_aprox	= $consulta[$i]['valor_aprox'];
		$valor_bodega   = $consulta[$i]['valor_bodega'];		
		
		$co=mysql_connect($GLOBALS["DNS"], $GLOBALS["USR"], $GLOBALS["PASS"]);
		mysql_select_db($GLOBALS["BDATOS"], $co);
			
		$sql_um	= "SELECT * FROM tb_und_med WHERE cod_um = '$und_med' ";
		$res_um	= mysql_query($sql_um,$co);
		while($vrows_um = mysql_fetch_array($res_um))
		{
			$nom_um 	= $vrows_um['nom_um'];
		}	
		
		$pdf->Cell(6,7,"$valor0",1,0,'L');
		$pdf->Cell(116,7,utf8_decode($desc_sol),1,0,'L');
		$pdf->Cell(20,7,"$nom_um",1,0,'L');
		$pdf->Cell(8,7,"$cant_det",1,0,'L');
		$pdf->Cell(20,7,"$valor_aprox",1,0,'L');
		$pdf->Cell(20,7,"$valor_bodega",1,0,'L');
		
		if($det_ap_d  == "2"){$tipo_p = "imagenes/ok.jpg"; }else{ $tipo_p = "imagenes/no.jpg";}
		if($det_ap_g  == "2"){$tipo_g = "imagenes/ok.jpg"; }else{ $tipo_g = "imagenes/no.jpg";}
		if($det_ap_b  == 1 and $cant_b == $cant_det){$tipo_b = "imagenes/ok.jpg"; }
		if($det_ap_b  == 1 and $cant_b > 0 and $cant_b != $cant_det){$tipo_b = "imagenes/ok.jpg"; }
		if($det_ap_b  == 2){$tipo_b = "imagenes/no.jpg"; }
		
		if($det_ap_d  == 0){$tipo_p = "imagenes/blanco.jpg"; }
		if($det_ap_g  == 0){$tipo_g = "imagenes/blanco.jpg"; }
		if($det_ap_b  == 0){$tipo_b = "imagenes/blanco.jpg"; }
		
		//if($ex_bod_det == "1"){$ex_b = "imagenes/ok.jpg"; $xy="234"; }else{ $ex_b = "imagenes/no.jpg"; $xy="243"; }
		
		$xx = $xx + 7;
		if($desc_sol != ""){$varp = $pdf->Image($tipo_p,206,$xx,4);}else{$desc_sol == "";}
		if($desc_sol != ""){$varg = $pdf->Image($tipo_g,220,$xx,4);}else{$desc_sol == "";}
		if($desc_sol != ""){$varb = $pdf->Image($tipo_b,238,$xx,4);}else{$desc_sol == "";}
		
		if($aprob_bod == ""){$cant_b = "";}
		
		$pdf->Cell(1,7,$varp,0,0,'C'); 
		$pdf->Cell(15,7,$varg,1,0,'C');
		$pdf->Cell(15,7,$varb,1,0,'C');
		$pdf->Cell(18,7,"$ex_bod_det",1,0,'C');
		$pdf->Cell(12,7,"$cant_b",1,0,'C');
		$pdf->Cell(30,7,"$rec_det",1,1,'C');
		$nom_um="";
		$i++;
	}
/******************************************************************************
CONSULTAMOS SI LA SOLICITUD ESTA APROBADA PARA IMPRIMIR LA FIRMA DIGITAL
******************************************************************************/
	$aprob_dpto = htmlspecialchars($aprob_dpto);
	$aprob_ger 	= htmlspecialchars($aprob_ger);
	
	//if($aprob_adm == "Juan Rosales Pino")		{ $a_p = $pdf->Image('imagenes/firma4.jpg',130,140,45);}
	if($aprob_dpto == "Victor Hugo Ortiz Tovar")		{ $a_p = $pdf->Image('imagenes/firma4_4.jpg',140,145,45);}
	//if($aprob_adm == "Patrico Riquelme S.")		{ $a_p = $pdf->Image('imagenes/firma2.jpg',130,140,45);}

	if($aprob_ger  == "Miguel Rubio")			{ $a_g = $pdf->Image('imagenes/firma8_8.jpg',130,153,20);}
	//if($aprob_ger  == "Jose Acevedo")		{ $a_g = $pdf->Image('imagenes/firma4_4.jpg',130,155,40);}
	
	if($aprob_bod  == "Ronaldo Mandujano")		{ $a_b = $pdf->Image('imagenes/ronaldo.jpg',245,162,45);}
		
	if($ods_sol != "")
	{
		$name_carpeta = $ods_sol;
	}else{
		$name_carpeta = $cc_sol;
	}
	
/******************************************************************************/

//Firma cuando bodeha acepta
//$adqui = $pdf->Image('imagenes/centonzio_1.jpg',130,170,20);

$pdf->Cell(158,4,"AUTORIZADA POR:",1,1,'C');

$pdf->Cell(38,4,"Area",1,0,'C');
$pdf->Cell(80,4,"Nombre",1,0,'C');
$pdf->Cell(40,4,"Firma",1,1,'C');

$pdf->Cell(38,10,"DEPARTAMENTO",1,0,'L');
$pdf->Cell(80,10,utf8_decode("$aprob_dpto"),1,0,'C');
$pdf->Cell(40,10,$a_p,1,0,'L');

$pdf->Cell(33,10,"",0,0,'L');
$pdf->Cell(49,10,"FECHA APROBACION BODEGA",1,0,'C');
$pdf->Cell(41,10,"$fe_aprob_b - ".$hr_apbb_sol,1,1,'C');

$pdf->Cell(38,10,"OPERACIONES",1,0,'L');
$pdf->Cell(80,10,utf8_decode("$aprob_ger"),1,0,'C');
$pdf->Cell(40,10,$a_g,1,0,'L');

$pdf->Cell(33,10,"",0,0,'L');
$pdf->Cell(49,10,"NOMBRE ENCARGADO BODEGA",1,0,'C');
$pdf->Cell(41,10,utf8_decode("$aprob_bod"),1,1,'C');


$pdf->Cell(38,10,"ABASTECIMIENTO",1,0,'L');
$pdf->Cell(80,10,"Pablo Centonzio",1,0,'C');
$pdf->Cell(40,10,"",1,0,'L');

$pdf->Cell(33,10,"",0,0,'L');
$pdf->Cell(49,10,"FIRMA ENCARGADO BODEGA",1,0,'C');
$pdf->Cell(41,10,"",1,1,'L');
	
	$ruta 	= $carpeta_solicitudes.$name_carpeta."/";
	$ruta_c = $carpeta_solicitudes.$name_carpeta."/FSR-".$cod_sol.".pdf";
	$nombre = "FSR-".$cod_sol.".pdf";
	
	if(!is_dir($ruta))  		// Preguntamos si la carpeta No Existe
	{
		@mkdir($ruta, 0777);  	// si no existe la creamos
	}

	$query	= "SELECT * FROM documentos WHERE nom_doc='$nombre' AND ruta_doc='$ruta'";
	$result	= mysql_query($query,$co);
	$cant	= mysql_num_rows($result);
					
	if($cant == 0)
	{
		$ing = "INSERT INTO documentos (ruta_doc, rutac_doc, carp_doc, nom_doc, nivel_doc, sub_por, fecha_sub) values('$ruta', '$ruta_c', '$name_carpeta', '$nombre', 5, 'Intranet','$fesol')";
		mysql_query($ing, $co);
	}
	$pdf->Output($ruta_c);
}
?>
</form>
</body>
</html>
