<?
// Necesario para ver si la session esta activa  o si se tiene permiso de accseso
require("../lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php
//
//Definimos el nivel de acceso  (esto es un bonus track para definir que ciertos usuarios puedan entrar a algunas paginas y a otras no)
// Si los usuarios normales tienen acceso=10, para que  accedan todos los usuarios le damos acceso mayor a 10.
/*$nivel_acceso =10;
if ($nivel_acceso < $_SESSION['usuario_nivel']){
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}*/

//Hasta aquí lo comun para todas las paginas restringidas
//********************************************************************************************************************************
	include('../inc/config_db.php'); 	// Incluimos archivo de configuracion de la conexion
	include('../inc/lib.db.php');		// Incluimos archivo de libreria de funciones PHP
//********************************************************************************************************************************
/**********************************************************************************************************************************
				FUNCION PARA ENVIAR CORREO
**********************************************************************************************************************************/	
function EnviaMsjTranspmgyt($ods, $ing_por)
{
	include ('../inc/config_db.php');
	
	/*********************************************************************************************************
	//Función Para Cambiar el Formato de la Fecha
	**********************************************************************************************************/
	function cambiarFecha2( $sFecha, $sSimboloInicial, $sSimboloFinal )
	{
		return implode( $sSimboloFinal, array_reverse( explode( $sSimboloInicial, $sFecha ) ) ) ; 
	} 
	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sqlc	= "SELECT * FROM tb_tranods WHERE cod_tods = '$ods' ";
	
	$res	= mysql_query($sqlc,$co);
	$cont 	= mysql_num_rows($res);
	
	if($cont != 0)
	{
		while($vrows=mysql_fetch_array($res))
		{
			$cod_tods 		= "".$vrows['cod_tods']."";
			$empr_sol 		= "".$vrows['empr_sol']."";
			$fe_tods 		= "".$vrows['fe_tods']."";
			$estado 		= "".$vrows['estado']."";
			$cond_tods 		= "".$vrows['cond_tods']."";
			$coord_tods 	= "".$vrows['coord_tods']."";
			$cc_tods 		= "".$vrows['cc_tods']."";
			$dest_tods 		= "".$vrows['dest_tods']."";
			$tipo_veh_tods 	= "".$vrows['tipo_veh_tods']."";
			$pat_veh_tods 	= "".$vrows['pat_veh_tods']."";
			$kmini_tods 	= "".$vrows['kmini_tods']."";
			$kmlleg_tods 	= "".$vrows['kmlleg_tods']."";
			$carg_tods 		= "".$vrows['carg_tods']."";
			$hrsal_tods 	= "".$vrows['hrsal_tods']."";
			$hrlleg_tods 	= "".$vrows['hrlleg_tods']."";
			$doc_tods 		= "".$vrows['doc_tods']."";
			$obs_tods 		= "".$vrows['obs_tods']."";
			$ing_por 		= "".$vrows['ing_por']."";
		}	
		
		$fe_tods		=	cambiarFecha2($fe_tods, '-', '/' ); 
		
		$SqlGas = "SELECT * FROM tb_gasxodst, tb_gastos WHERE tb_gasxodst.cod_tods = '$cod_tods' and tb_gasxodst.cod_gas = tb_gastos.cod_gasto ORDER BY tb_gastos.nom_gasto";
		$ResGas = dbExecute($SqlGas);
		while ($VrsGas = mysql_fetch_array($ResGas)) 
		{
			$GastosxOds[] = $VrsGas;
		}
			
		//$tothrs_tods = ($hrlleg_tods - $hrsal_tods);
		function resta($inicio, $fin)
		{
		  	$dif=date("H:i:s", strtotime("00:00:00") + strtotime($fin) - strtotime($inicio) );
		  	return $dif;
		 }
			
		if($hrlleg_tods != "00:00:00"){
			$tothrs_tods = resta($hrsal_tods, $hrlleg_tods);
		}
		$kmrec_tods  = ($kmlleg_tods - $kmini_tods);
			
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS", $co);
	
		$sql_coord = "SELECT * FROM tb_coordinador WHERE cod_coord = '$coord_tods' ";
		$res_coord = mysql_query($sql_coord,$co);
		while($vrowscoord=mysql_fetch_array($res_coord))
		{
			$nom_coord = "".$vrowscoord['nom_coord']."";
			$cod_coord = "".$vrowscoord['cod_coord']."";
		}
		
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS", $co);
		
		$sql_dest = "SELECT * FROM tb_destino WHERE cod_dest = '$dest_tods' ";
		$res_dest = mysql_query($sql_dest ,$co);
		while($vrowsdest = mysql_fetch_array($res_dest))
		{
			$nom_dest  = "".$vrowsdest['nom_dest']."";
			$cod_dest  = "".$vrowsdest['cod_dest']."";
		}
		
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS", $co);
		
		$sql_veh = "SELECT * FROM tb_vehiculos WHERE cod_veh  = '$veh_tods' ";
		$res_veh = mysql_query($sql_veh ,$co);
		while($vrowsveh = mysql_fetch_array($res_veh))
		{
			$nom_veh  = "".$vrowsveh['nom_veh']."";
			$cod_veh  = "".$vrowsveh['cod_veh']."";
		}
	}
	
	//$fe_tods = cambiarFecha($fe_tods, '-', '/' ); 
	
	require("../../PHPMailer/class.phpmailer.php");
					
	$mail = new PHPMailer();   // Iniciamos la validación por SMTP: 
	$mail->IsSMTP(); 
	$mail->SMTPAuth = false; // True para que verifique autentificación de la cuenta o de lo contrario False 
	$mail->Password = "PMnt2011"; 
	$mail->Username = "Produccion.mgyt@mgytsa.com";  
	$mail->Port 	= "25"; 
	$mail->Host 	= "ktm.mgytsa.cl;192.168.2.7"; 
	$mail->From 	= "intranet@mgyt.cl"; 
	$mail->FromName = "Intranet Rockmine"; 
	$mail->Subject 	= "Ingreso de nueva ODS de Transportes(".$ods.")";  
	
	// TRANSPORTES
	$mail->AddAddress("diego.fuentes@softtimesa.com","Transportes"); 
	//$mail->AddAddress("nicolas.sotomayor@softtimesa.com","Transportes"); 
	//$mail->AddAddress("luciano.peraldi@mgyt.cl","Transportes"); 
	//$mail->AddBCC("pedro.troncoso@mgyt.cl","Administrador");	
	
	$cuerpo = "<html>\n"; 
	$cuerpo.= "<body>\n";
	$cuerpo.= "<table width='800' bordercolor='#ffffff' border='1' cellpadding='3' cellspacing='1' class='txtnormaln'>";
	
	$cuerpo.= "<tr bgcolor='#cedee1'><td align='center' colspan='4'>ORDEN DE SERVICIO</td></tr>";
			
	$cuerpo.= "<tr bgcolor='#d6e7ff'><td align='left' width='15%'>&nbsp;".utf8_decode('Nº de Orden:')."</td>";
	$cuerpo.= "<td align='left' width='50%'>&nbsp;$ods</td>";
	$cuerpo.= "<td align='left' width='16%'>&nbsp;Fecha:</td>";
	$cuerpo.= "<td align='left' width='20%'>&nbsp;$fe_tods</td></tr>";

	$cuerpo.= "<tr bgcolor='#d6e7ff'><td align='left'>&nbsp;Conductor:</td>";
	$cuerpo.= "<td align='left'>&nbsp;".utf8_decode($cond_tods)."</td>";
	$cuerpo.= "<td align='left'>&nbsp;Hora de Salida:</td>";
	$cuerpo.= "<td align='left'>&nbsp;$hrsal_tods</td></tr>";
	
	$cuerpo.= "<tr bgcolor='#d6e7ff'><td align='left'>&nbsp;Coordinador:</td>";
	$cuerpo.= "<td align='left'>&nbsp;".utf8_decode($nom_coord)."</td>";
	$cuerpo.= "<td align='left'>&nbsp;Hora de Llegada:</td>";
	$cuerpo.= "<td align='left'>&nbsp;$hrlleg_tods</td></tr>";
	
	$cuerpo.= "<tr bgcolor='#d6e7ff'><td align='left'>&nbsp;Centro costo:</td>";
	$cuerpo.= "<td align='left'>&nbsp;$cc_tods</td>";
	$cuerpo.= "<td align='left'>&nbsp;Total horas:</td>";
	$cuerpo.= "<td align='left'>&nbsp;</td></tr>";
	
	$cuerpo.= "<tr bgcolor='#d6e7ff'><td align='left'>&nbsp;Tipo Vehiculo:</td>";
	$cuerpo.= "<td align='left'>&nbsp;$nom_veh</td>";
	$cuerpo.= "<td align='left'>&nbsp;Patente:</td>";
	$cuerpo.= "<td align='left'>&nbsp;$pat_veh_tods</td></tr>";
	
	$cuerpo.= "<tr bgcolor='#d6e7ff'><td align='left'>&nbsp;Destino:</td>";
	$cuerpo.= "<td align='left' colspan='3'>&nbsp;".utf8_decode($nom_dest)."</td></tr>";
	
	$cuerpo.= "<tr bgcolor='#d6e7ff'><td align='left'>&nbsp;Km Inicio:</td>";
	$cuerpo.= "<td align='left'>&nbsp;$kmini_tods</td>";
	$cuerpo.= "<td align='left'>&nbsp;Km Termino:</td>";
	$cuerpo.= "<td align='left'>&nbsp;$kmlleg_tods</td></tr>";
	
	$cuerpo.= "<tr bgcolor='#d6e7ff'><td align='left'>&nbsp;Carga o Materiales:</td>";
	$cuerpo.= "<td align='left' colspan='3'>&nbsp;".utf8_decode($carg_tods)."</td></tr>";
	
	$cuerpo.= "<tr bgcolor='#d6e7ff'><td align='left'>&nbsp;Observaciones:</td>";
	$cuerpo.= "<td align='left' colspan='3'>&nbsp;".utf8_decode($obs_tods)."</td></tr>";
	
	$cuerpo.= "<tr bgcolor='#d6e7ff'><td align='left'>&nbsp;Ingresada por:</td>";
	$cuerpo.= "<td align='left' colspan='3'>&nbsp;".utf8_decode($ing_por)."</td></tr>";
			
	$cuerpo.= "</tr>";
	$cuerpo.= "</table>";
	$cuerpo.= "</body>"; 
	$cuerpo.= "<html><br>";
	
	//$mail->WordWrap = 500;  
	$body  = "Estimados, <br><br>"; 
	$body .= "Se ha ingresado una nueva ODS (".$ods.") en el sistema de Produccion.<br><br>";
	$body .= $cuerpo;
	$body .= "Atte.<br>Intranet MGYT<br><br>";
	$body .= "Este mensaje fue generado automaticamente, favor no responder";
	$mail->Body = $body; 
	$mail->MsgHTML($body);  
	$mail->IsHTML(true); // Enviar como HTML  
	//$mail->AddReplyTo("pedrotroncos@gmail.com", "Information");
	//$mail->AddStringAttachment('Carpetas ODS/1660/FSR-1000.pdf', 'FSR-1000.pdf');
	//$mail->AddAttachment($ruta_c, $nombre);			ENVIA CORREO ADJUNTO					
	//se envia el mensaje, si no ha habido problemas 
	//la variable $exito tendra el valor true
	$exito = $mail->Send();
						
	//Si el mensaje no ha podido ser enviado se realizaran 4 intentos mas como mucho 
 	//para intentar enviar el mensaje, cada intento se hara 5 segundos despues 
	//del anterior, para ello se usa la funcion sleep	
	$intentos=1; 
	while ((!$exito) && ($intentos < 3)) {
	sleep(5);
		//echo $mail->ErrorInfo;
		$exito 		= $mail->Send();
		$intentos	= $intentos+1;
	}					
	if(!$exito)
	{
		$resultado = "No-Enviado";
	}else{
		$resultado = "Enviado";
	}
		
return $resultado;
/*******************************************************************************************************************************
			FIN CODIGO ENVIO DE CORREO CON FSR ADJUNTO
*******************************************************************************************************************************/
}
/**********************************************************************************************************************************
				FUNCION PARA ENVIAR CORREO
**********************************************************************************************************************************/	
function EnviaMsjTransp($ods, $ing_por)
{
	require("../../PHPMailer/class.phpmailer.php");
					
	$mail = new PHPMailer();   // Iniciamos la validación por SMTP: 
	$mail->IsSMTP(); 
	$mail->SMTPAuth = false; // True para que verifique autentificación de la cuenta o de lo contrario False 
	$mail->Password = "PMnt2011"; 
	$mail->Username = "Produccion.mgyt@mgytsa.com";  
	$mail->Port 	= "25"; 
	$mail->Host 	= "ktm.mgytsa.cl;192.168.2.7"; 
	$mail->From 	= "intranet@mgyt.cl"; 
	$mail->FromName = "Intranet Rockmine"; 
	$mail->Subject 	= "Ingreso de nueva ODS de Transportes(".$ods.")";  
	
	// TRANSPORTES
	$mail->AddAddress("nicolas.sotomayor@softtimesa.com","Transportes"); 
	//$mail->AddAddress("oscar.barril@mgyt.cl","Transportes"); 
	//$mail->AddAddress("luciano.peraldi@mgyt.cl","Transportes"); 
	//$mail->AddBCC("pedro.troncoso@mgyt.cl","Administrador");	
	
	//$mail->WordWrap = 500;  
	$body  = "Estimados, <br><br>"; 
	$body .= "Se ha ingresado una nueva ODS (".$ods.") en la intranet Rockmine.<br><br>Atte.<br>Intranet Rockmine<br><br>";
	$body .= "Este mensaje fue generado automaticamente, favor no responder";
	$mail->Body = $body; 
	$mail->MsgHTML($body);  
	$mail->IsHTML(true); // Enviar como HTML  
	//$mail->AddReplyTo("pedrotroncos@gmail.com", "Information");
	//$mail->AddStringAttachment('Carpetas ODS/1660/FSR-1000.pdf', 'FSR-1000.pdf');
	//$mail->AddAttachment($ruta_c, $nombre);			ENVIA CORREO ADJUNTO					
	//se envia el mensaje, si no ha habido problemas 
	//la variable $exito tendra el valor true
	$exito = $mail->Send();
						
	//Si el mensaje no ha podido ser enviado se realizaran 4 intentos mas como mucho 
 	//para intentar enviar el mensaje, cada intento se hara 5 segundos despues 
	//del anterior, para ello se usa la funcion sleep	
	$intentos=1; 
	while ((!$exito) && ($intentos < 3)) {
	sleep(5);
		//echo $mail->ErrorInfo;
		$exito 		= $mail->Send();
		$intentos	= $intentos+1;
	}					
	if(!$exito)
	{
		$resultado = "No-Enviado";
	}else{
		$resultado = "Enviado";
	}
		
return $resultado;
/*******************************************************************************************************************************
			FIN CODIGO ENVIO DE CORREO CON FSR ADJUNTO
*******************************************************************************************************************************/
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Solicitud de recursos</title>

<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="JavaScript" src="../inc/funciones.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="../stmenu.js"></script>

</head>
<body>
<form id="f7" name="f7" method="post" action="ords.php">
<?php

 $_POST['f1']	= cambiarFecha($_POST['f1'], '/', '-' ); 
 $cod_tods		= $_POST['cod_tods'];
 $nom_usu		= $_SESSION['usuario_nombre'];
 
 $cont_g	 = count($_POST['tipo_gasto']);	
 $cont_gasto = ($cont_g - 1);
 
 if($_POST['kmini_tods']  == ""){	$_POST['kmini_tods']  = "0";}
 if($_POST['kmlleg_tods'] == ""){	$_POST['kmlleg_tods'] = "0";} 
 if($_POST['hrsal_tods']  == ""){	$_POST['hrsal_tods']  = "00:00:00";}
 if($_POST['hrlleg_tods'] == ""){	$_POST['hrlleg_tods'] = "00:00:00";} 
 
 $co=mysql_connect("$DNS","$USR","$PASS");
 mysql_select_db("$BDATOS",$co);
 /****************************************************************************************

*****************************************************************************************/
	if(!is_numeric($_POST['c1']))
	{
		$sql_p = "SELECT * FROM tb_coordinador WHERE nom_coord = '".$_POST['c1']."' ";
		$res_p   = mysql_query($sql_p,$co);
		while($vrows=mysql_fetch_array($res_p))
		{
			$coord_tods = "".$vrows['cod_coord']."";
		}
	}else{
		$coord_tods   = $_POST['c1'];
	}
/****************************************************************************************

*****************************************************************************************/
	if(!is_numeric($_POST['c3']))
	{
		$sql_p = "SELECT * FROM tb_destino WHERE nom_dest = '".$_POST['c3']."' ";
		$res   = mysql_query($sql_p,$co);
		while($vrows_p=mysql_fetch_array($res))
		{
			$dest_tods = "".$vrows_p['cod_dest']."";
		}
	}else{
		$dest_tods   = $_POST['c3'];
	}
/*********************************************************************************************************************************
				INGRESAMOS LA SOLICITUD
*********************************************************************************************************************************/			
if($_POST['ingresa'] == "Ingresar")
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS",$co);
	
	$sqli = "INSERT INTO tb_tranods (empr_sol, fe_tods, estado, cond_tods, coord_tods, cc_tods, dest_tods, tipo_veh_tods, pat_veh_tods, kmini_tods, kmlleg_tods, carg_tods, hrsal_tods, hrlleg_tods, doc_tods, obs_tods, ing_por) values('".$_POST['empr_sol']."', '".$_POST['f1']."', '".$_POST['estado']."', '".$_POST['cond_tods']."', '".$_POST['c1']."', '".$_POST['cc_tods']."', '".$_POST['c3']."', '".$_POST['c4']."', '".$_POST['c5']."', '".$_POST['kmini_tods']."', '".$_POST['kmlleg_tods']."', '".$_POST['carg_tods']."', '".$_POST['hrsal_tods']."', '".$_POST['hrlleg_tods']."', '".$_POST['doc_tods']."', '".$_POST['obs_tods']."', '".$_SESSION['usuario_nombre']."')";
		
		if(mysql_query($sqli, $co))
		{
			$cod_todsI = mysql_insert_id($co); //para saber el codigo de la ODS ingresada
			
			$ResCorreo = EnviaMsjTransp($cod_todsI, $_SESSION['usuario_nombre']); // ENVIAMOS UN CORREO DE ALERTA A TRANSPORTES
			
			if($ResCorreo == "Enviado")
			{
				echo "Mensaje Enviado Correctamente";
			}else{
				echo "Error al enviar mensaje";
			} 

/********************************************************************************************************************************	

********************************************************************************************************************************/		
			$x=0;				// VARIABLE PARA INICIALIZAR EL CONTADOR	
			while($x < $cont_gasto)
			{
				if($_POST['tipo_gasto'][$x] != "" )
				{
					$co=mysql_connect("$DNS","$USR","$PASS");
					mysql_select_db("$BDATOS",$co);
						
					$_POST['fe_gas'][$x] = cambiarFecha($_POST['fe_gas'][$x], '/', '-' );
						
					$Sql_det = "INSERT INTO tb_gasxodst (cod_tods, cod_gas, monto_gas, fe_gas) VALUES('$cod_todsI', '".$_POST['tipo_gasto'][$x]."','".$_POST['monto_gas'][$x]."','".$_POST['fe_gas'][$x]."')";
					dbExecute($Sql_det);
				}
				$x++;
			}
/**********************************************************************************************************************************
						CREAMOS LA CARPETA SI ESTA NO EXISTE
**********************************************************************************************************************************/						
			$dir		= "Carpetas ODST";
			$ruta_carp	= $dir."/".$cod_todsI;
					
			if(!is_dir($ruta_sol))  		// Preguntamos si la carpeta No Existe
			{
				@mkdir($ruta_carp, 0777);  	// si no existe la creamos
			}
/**********************************************************************************************************************************
						FIN DE CREACION CARPETA
**********************************************************************************************************************************/			
	 
			echo"<input type='hidden' name='ingresa' id='ingresa' value='$cod_todsI' />";
			echo"<script language='Javascript'>
				alert('La Orden De Servicio Fue Ingresada Correctamente y Fue Enviado Un Mensaje De Alerta a Transportes');
				document.f7.action='ords.php';
				document.f7.submit();
			</script>";
		}else{
				echo"<input type='hidden' name='ingresa' id='ingresa' value='$cod_todsI' />";
				echo "<script language='Javascript'>";
				echo "alert('¡¡ERROR!! El Ingreso de la ODS a fallado');
					document.f7.action='ords.php';
					document.f7.submit();
				</script>";
		}// if ingreso
		
}     //if   
   
   
/*********************************************************************************************************************************
				MODIFICAMOS LA SOLICITUD
*********************************************************************************************************************************/	
if($_POST['modifica'] == "Modificar")
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS",$co);
	
	$SqlGasto = "SELECT * FROM tb_gasxodst WHERE cod_tods = '".$_POST['cod_tods']."' ";
	$ResGasto = dbExecute($SqlGasto);
	while ($vrows_Gasto = mysql_fetch_array($ResGasto)) 
	{
    	$DetalleGasto[] = $vrows_Gasto;
	}
	$TotalDG = count($DetalleGasto);
			
	$SqlUpd = "UPDATE tb_tranods SET empr_sol		= '".$_POST['empr_sol']."',
									 fe_tods		= '".$_POST['f1']."',
									 estado			= '".$_POST['estado']."',
									 cond_tods		= '".$_POST['cond_tods']."',
									 coord_tods		= '$coord_tods',
									 cc_tods		= '".$_POST['cc_tods']."',
									 dest_tods		= '$dest_tods',
									 tipo_veh_tods	= '".$_POST['c4']."',
									 pat_veh_tods	= '".$_POST['c5']."',
									 kmini_tods		= '".$_POST['kmini_tods']."',
									 kmlleg_tods	= '".$_POST['kmlleg_tods']."',
									 carg_tods		= '".$_POST['carg_tods']."',
									 hrsal_tods		= '".$_POST['hrsal_tods']."',
									 hrlleg_tods	= '".$_POST['hrlleg_tods']."',
									 doc_tods		= '".$_POST['doc_tods']."',
									 obs_tods		= '".$_POST['obs_tods']."'
									 
									 WHERE cod_tods	= '".$_POST['cod_tods']."' ";
	if(dbExecute($SqlUpd))
	{
		$x=0;	// VARIABLE PARA INICIALIZAR EL CONTADOR	
		while($x < $cont_gasto)
		{
			$co=mysql_connect("$DNS","$USR","$PASS");
			mysql_select_db("$BDATOS",$co);
			
			$_POST['fe_gas'][$x] = cambiarFecha($_POST['fe_gas'][$x], '/', '-' );
			if($_POST['fe_gas'][$x]	== ""){$_POST['fe_gas'][$x]	= "0000-00-00";}
				
			$Sql_pno = "UPDATE tb_gasxodst SET  cod_gas		 = '".$_POST['tipo_gasto'][$x]."',
												monto_gas 	 = '".$_POST['monto_gas'][$x]."',
												fe_gas 		 = '".$_POST['fe_gas'][$x]."'
												WHERE id_det = '".$_POST['id_det'][$x]."' ";
														
			mysql_query($Sql_pno, $co);
			$x++;
		}
				
		if($cont_gasto > $TotalDG)
		{
			$z = $TotalDG;					// VARIABLE PARA INICIALIZAR EL CONTADOR	
			while($z < $cont_gasto)
			{
				if($_POST['tipo_gasto'][$z] != "" )
				{
					$co=mysql_connect("$DNS","$USR","$PASS");
					mysql_select_db("$BDATOS",$co);
					
					$_POST['fe_gas'][$z] = cambiarFecha($_POST['fe_gas'][$z], '/', '-' );
					if($_POST['fe_gas'][$z]	== ""){$_POST['fe_gas'][$z]	= "0000-00-00";}
							
					$Sql_UCop = "INSERT INTO tb_gasxodst (cod_tods, cod_gas, monto_gas, fe_gas) VALUES('".$_POST['cod_tods']."', '".$_POST['tipo_gasto'][$z]."','".$_POST['monto_gas'][$z]."','".$_POST['fe_gas'][$z]."')";
					
					dbExecute($Sql_UCop);		
				}
				$z++;
			}
		}
		
		echo"<input type='hidden' name='modifica' id='modifica' value='".$_POST['cod_tods']."' />";
		echo "<script language='Javascript'>	
		alert('La Modificacion se Realizo Correctamente');
			document.f7.submit();
		</script>";
	}else{
		echo"<input type='hidden' name='modifica' id='modifica' value='".$_POST['cod_tods']."' />";
		
		echo "<script language='Javascript'>	
			alert('Error Al Modificar El Informe');
			document.f7.submit();
		</script>";
	}
}

if ($_POST['Elimina'] == "Eliminar") {
	
	echo "<script>alert('Falta este boton');document.f7.submit();</script>";
}
?>
</form>
</body>
</html>
