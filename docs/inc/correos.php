<?php
/**********************************************************************************************************************************
				FUNCION PARA ENVIAR CORREO
**********************************************************************************************************************************/	
function EnviaMsjUsuario($nombre, $usuario, $rep_nueva_pass, $mail_usu)
{
	require("../PHPMailer/class.phpmailer.php");
					
	$mail = new PHPMailer();   // Iniciamos la validación por SMTP: 
	$mail->IsSMTP(); 
	$mail->SMTPAuth = false; // True para que verifique autentificación de la cuenta o de lo contrario False 
	$mail->Password = "PMnt2011"; 
	$mail->Username = "Produccion.mgyt@mgytsa.com";  
	$mail->Port 	= "25"; 
	$mail->Host 	= "ktm.mgytsa.cl;192.168.2.8"; 
	$mail->From 	= "intranet@mgyt.cl"; 
	$mail->FromName = "Intranet Rockmine"; 
	$mail->Subject 	= "Cambio de datos de usuario";  
	
	// DESTINATARIOS
	$mail->AddAddress($mail_usu); 	
	
	//$mail->WordWrap = 500;  
	$titulo = "Se han cambiado sus datos de usuario en la intranet Rockmine.<br><br>";
	
	$body = "<html>\n"; 
	$body.= "<body>\n";
	$body.= "<table width='800' bordercolor='#0000FF' border='0' cellpadding='2' cellspacing='2'>";
        
	$body.= "<tr><td align='center' colspan='2' bgcolor='#bad868'><b>$titulo<b></td></tr>";
		
	$body.= "<tr><td align='left' width='30%' colspan='2'>&nbsp;Sus nuevos datos de usuario son los siguientes:</td></tr>";
		
	$body.= "<tr><td align='left'>&nbsp;Nombre:</td>";
	$body.= "<td align='left'>&nbsp;$nombre</td></tr>";
		
	$body.= "<tr><td align='left'>&nbsp;Usuario:</td>";
	$body.= "<td align='left'>&nbsp;$usuario</td></tr>";
		
	$body.= "<tr><td align='left'>&nbsp;Password:</td>";
	$body.= "<td align='left'>&nbsp;$rep_nueva_pass</td></tr>";

	$body.= "<tr><td align='left'>&nbsp;Correo:</td>";
	$body.= "<td align='left'>&nbsp;$mail_usu</td></tr>";
		
	$body.= "<tr><td align='center' colspan='2' bgcolor='#FF0000'>&nbsp;Intranet Rockmine</td></tr>";
		
	$body.= "</tr>";
	$body.= "</table>";
	$body.= "</body>"; 
	$body.= "<html><br>";
	
	$body .= "Este mensaje fue generado automaticamente, favor no responder<br>";
	$body .= "<br>Atte.<br>Intranet Rockmine";
	
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
			FIN CODIGO ENVIO DE CORREO
*******************************************************************************************************************************/
}
/**********************************************************************************************************************************
				FUNCION PARA ENVIAR CORREO CON SOLICITUD ADJUNTA
**********************************************************************************************************************************/	
function envia_adjunto($cod_sol, $ruta_c, $nombre, $aux_modal)
{
	require("../PHPMailer/class.phpmailer.php");
					
	$mail = new PHPMailer();   // Iniciamos la validación por SMTP: 
	$mail->IsSMTP(); 
	$mail->SMTPAuth = false; // True para que verifique autentificación de la cuenta o de lo contrario False 
	$mail->Password = "PMnt2011"; 
	$mail->Username = "Produccion.mgyt@mgytsa.com";  
	$mail->Port 	= "25"; 
	$mail->Host 	= "ktm.mgytsa.cl;192.168.2.8"; 
	$mail->From 	= "intranet@mgyt.cl"; 
	$mail->FromName = "Intranet Rockmine"; 
	$mail->Subject 	= "Solicitud de recursos (".$cod_sol.")";  
	
	// BODEGA
	//$mail->AddAddress("ronaldo.mandujano@rockminesa.com","Bodega");
	
	// Operaciones
	//$mail->AddAddress("miguel.rubio@rockminesa","Operaciones");

	//Informatica
	$mail->AddAddress("diego.fuentes@softtimesa.com","Adquisiciones");
	
	// Departamento
	//$mail->AddAddress("victor.ortiz@rockminesa.com","Departamento");
	
	//$mail->WordWrap = 500;  
	$body  = "Estimados; <br>"; 
	$body .= "Se ha aprobado una nueva solicitud de recursos, para revision.<br><br>Atte.<br>Intranet Rockmine<br><br>";
	$body .= "Este mensaje fue generado automaticamente, favor no responder";
	$mail->Body = $body;
	$mail->MsgHTML($body);
	$mail->IsHTML(true); // Enviar como HTML  
	//$mail->AddReplyTo("pedrotroncos@gmail.com", "Information");
	//$mail->AddStringAttachment('Carpetas ODS/1660/FSR-1000.pdf', 'FSR-1000.pdf');
	$mail->AddAttachment($ruta_c, $nombre);			
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
		echo "Problemas enviando correo electrónico a ".$valor;
		echo "<br/>".$mail->ErrorInfo;	
		echo"<input type='hidden' name='aprueba' id='aprueba' value='$cod_sol' />";
		echo "<script language='Javascript'>
		alert('Error!!!! al validar la solicitud de recursos --- Mensaje no enviado');
			document.f7.submit();
		</script>";
		$resultado = "No_enviado";
	}else{
		echo "Mensaje enviado correctamente";
		echo"<input type='hidden' name='aprueba' id='aprueba' value='$cod_sol' />";
		echo"<input type='hidden' name='detecta_modal_p' id='detecta_modal_p' value='$aux_modal'/>";
		echo "<script language='Javascript'>
			alert('La solicitud de recursos Nº $cod_sol Fue validada correctamente y enviada a Bodega');
			document.f7.submit();
		</script>";
		$resultado = "Enviado";
	}
		
return $resultado;
/*******************************************************************************************************************************
			FIN CODIGO ENVIO DE CORREO CON FSR ADJUNTO
*******************************************************************************************************************************/
}

function envia_adjuntoo($cod_sol, $ruta_c, $nombre, $aux_modal)
{
	require("../PHPMailer/class.phpmailer.php");
					
	$mail = new PHPMailer();   // Iniciamos la validación por SMTP: 
	$mail->IsSMTP(); 
	$mail->SMTPAuth = false; // True para que verifique autentificación de la cuenta o de lo contrario False 
	$mail->Password = "PMnt2011"; 
	$mail->Username = "Produccion.mgyt@mgytsa.com";  
	$mail->Port 	= "25"; 
	$mail->Host 	= "ktm.mgytsa.cl;192.168.2.8"; 
	$mail->From 	= "intranet@mgyt.cl"; 
	$mail->FromName = "Bodega Rockmine"; 
	$mail->Subject 	= "Solicitud de recursos desde Bodega (".$cod_sol.")"; 
	
	// BODEGA
	//$mail->AddAddress("ronaldo.mandujano@rockminesa.com","Bodega");
	
	// Operaciones
	//$mail->AddAddress("miguel.rubio@rockminesa","Operaciones");

	//Informatica
	$mail->AddAddress("diego.fuentes@softtimesa.com","Adquisiciones");
	
	// Departamento
	//$mail->AddAddress("victor.ortiz@rockminesa.com","Departamento");
	
	//$mail->WordWrap = 500;  
	$body  = "Estimados; <br>"; 
	$body .= "Se ha aprobado una nueva solicitud de recursos, para revision.<br><br>Atte.<br>Intranet Rockmine<br><br>";
	$body .= "Este mensaje fue generado automaticamente, favor no responder";
	$mail->Body = $body;
	$mail->MsgHTML($body);
	$mail->IsHTML(true); // Enviar como HTML  
	//$mail->AddReplyTo("pedrotroncos@gmail.com", "Information");
	//$mail->AddStringAttachment('Carpetas ODS/1660/FSR-1000.pdf', 'FSR-1000.pdf');
	$mail->AddAttachment($ruta_c, $nombre);			
	//se envia el mensaje, si no ha habido problemas 
	//la variable $exito tendra el valor true
	$exito = $mail->Send();
						
	//Si el mensaje no ha podido ser enviado se realizaran 4 intentos mas como mucho 
 	//para intentar enviar el mensaje, cada intento se hara 5 segundos despues 
	//del anterior, para ello se usa la funcion sleep	
	$intentos=1; 
	while ((!$exito) && ($intentos < 3)) {
	sleep(3);
		//echo $mail->ErrorInfo;
		$exito 		= $mail->Send();
		$intentos	= $intentos+1;
	}					
	if(!$exito)
	{
		echo "Problemas enviando correo electrónico awwwww ".$mail;
		echo "<br/>".$mail->ErrorInfo;	
		echo"<input type='hidden' name='aprueba' id='aprueba' value='$cod_sol' />";
		echo "<script language='Javascript'>
		alert('Error!!!! al validar la solicitud de recursos --- Mensaje no enviado');
			document.f7.submit();
		</script>";
		$resultado = "No_enviado";
	}else{
		echo "Mensaje enviado correctamente";
		echo"<input type='hidden' name='aprueba' id='aprueba' value='$cod_sol' />";
		echo"<input type='hidden' name='detecta_modal_p' id='detecta_modal_p' value='$aux_modal'/>";
		echo "<script language='Javascript'>
			alert('La solicitud de recursos Nº $cod_sol Fue validada correctamente y enviada a Bodega');
			document.f7.submit();
		</script>";
		$resultado = "Enviado";
	}
		
return $resultado;
/*******************************************************************************************************************************
			FIN CODIGO ENVIO DE CORREO CON FSR ADJUNTO
*******************************************************************************************************************************/
}

/**********************************************************************************************************************************
				FUNCION PARA ENVIAR CORREO CON SOLICITUD ADJUNTA - BODEGA
**********************************************************************************************************************************/	
function envia_adjunto_bodega($cod_sol, $ruta_c, $nombre, $aux_modal)
{
	require("../PHPMailer/class.phpmailer.php");
					
	$mail = new PHPMailer();   // Iniciamos la validación por SMTP: 
	$mail->IsSMTP(); 
	$mail->SMTPAuth = false; // True para que verifique autentificación de la cuenta o de lo contrario False 
	$mail->Password = "PMnt2011"; 
	$mail->Username = "Produccion.mgyt@mgytsa.com";  
	$mail->Port 	= "25"; 
	$mail->Host 	= "ktm.mgytsa.cl;192.168.2.8"; 
	$mail->From 	= "intranet@mgyt.cl"; 
	$mail->FromName = "Bodega Rockmine"; 
	$mail->Subject 	= "Solicitud de recursos desde Bodega (".$cod_sol.")"; 
	
	// ADQUISICIONES
	//$mail->AddAddress("pablo.centonzio@mgyt.cl","Adquisiciones");
	//$mail->AddAddress("bianca.cordova@rockminesa.com","Adquisiciones");
	$mail->AddAddress("diego.fuentes@softtimesa.com","Adquisiciones");
	

	//$mail->WordWrap = 500;  
	$body  = "Estimado; <br>"; 
	$body .= "Se ha aprobado una nueva solicitud de recursos, la cual fue revisada por bodega.<br><br>Atte.<br>Intranet Rockmine <br><br>";
	$body .= "Este mensaje fue generado automaticamente, favor no responder";
	$mail->Body = $body; 
	$mail->MsgHTML($body);  
	$mail->IsHTML(true); // Enviar como HTML  
	//$mail->AddReplyTo("pedrotroncos@gmail.com", "Information");
	//$mail->AddStringAttachment('Carpetas ODS/1660/FSR-1000.pdf', 'FSR-1000.pdf');
	$mail->AddAttachment($ruta_c, $nombre);								
	//se envia el mensaje, si no ha habido problemas 
	//la variable $exito tendra el valor true
	$exito = $mail->Send();
						
	//Si el mensaje no ha podido ser enviado se realizaran 4 intentos mas como mucho 
 	//para intentar enviar el mensaje, cada intento se hara 5 segundos despues 
	//del anterior, para ello se usa la funcion sleep	
	$intentos=1; 
	while ((!$exito) && ($intentos < 3)) {
	sleep(3);
		//echo $mail->ErrorInfo;
		$exito 		= $mail->Send();
		$intentos	= $intentos+1;
	}					
	if(!$exito)
	{
		echo "Problemas enviando correo electrónico a ".$valor;
		echo "<br/>".$mail->ErrorInfo;	
		echo"<input type='hidden' name='aprueba' id='aprueba' value='$cod_sol' />";
		echo "<script language='Javascript'>
		alert('Error!!!! al validar la solicitud de recursos --- Mensaje no enviado');
			document.f7.submit();
		</script>";
		$resultado = "No_enviado";
	}else
		{
			echo "Mensaje enviado correctamente";
			echo"<input type='hidden' name='aprueba' id='aprueba' value='$cod_sol' />";
			echo"<input type='hidden' name='detecta_modal_p' id='detecta_modal_p' value='$aux_modal'/>";
			echo "<script language='Javascript'>
				alert('La solicitud de recursos Nº $cod_sol Fue validada correctamente y enviada a Adquisiciones');
				document.f7.submit();
			</script>";
			$resultado = "Enviado";
	}
		
return $resultado;
/*******************************************************************************************************************************
			FIN CODIGO ENVIO DE CORREO CON FSR ADJUNTO BODEGA
*******************************************************************************************************************************/
}

/**********************************************************************************************************************************
				FUNCION PARA ENVIAR CORREO DE RECEPCION
**********************************************************************************************************************************/	
function EnviaMsjRec($id_det, $recepcion)
{	
	require("inc/config_db.php");
	
	$sqlf 	= "SELECT * FROM tb_sol_rec, tb_det_sol WHERE tb_det_sol.id_det = '$id_det' and tb_sol_rec.cod_sol = tb_det_sol.cod_sol";
	$resp	= mysql_query($sqlf,$co);
		
	while ($row = mysql_fetch_array($resp)) {
		$consulta[] = $row; 
	}
			
	$id_det 	= $consulta[0]['id_det'];
	$cod_sol 	= $consulta[0]['cod_sol'];
	$desc_sol 	= $consulta[0]['desc_sol'];
	$cant_det 	= $consulta[0]['cant_det'];
	$cant_rec 	= $consulta[0]['cant_rec'];
	$und_med 	= $consulta[0]['und_med'];
	$motivo 	= $consulta[0]['motivo'];
	$prof_sol 	= $consulta[0]['prof_sol'];	
	
	$sql_um	= "SELECT * FROM tb_und_med WHERE cod_um = '$und_med' ";
	$res_um	= mysql_query($sql_um,$co);
	while($vrows_um = mysql_fetch_array($res_um))
	{
		$cod_um 	= $vrows_um['cod_um'];
		$nom_um 	= $vrows_um['nom_um'];
	}
	
	$sql_us	= "SELECT * FROM tb_usuarios WHERE us_nombre = '$prof_sol' ";
	$res_us	= mysql_query($sql_us, $co);
	while($vrows_us = mysql_fetch_array($res_us))
	{
		$us_correo  = $vrows_us['us_correo'];
	}
	
	if($recepcion != "Rechazado" and $recepcion != "Anulado"){ 
		$asunto = "Recepcion Solicitud (".$cod_sol.")"; 
		$encabezado = utf8_decode("Se ha recepcionado por bodega el siguiente item de solicitud de recursos Nº (".$cod_sol.")");
		$cuerpo .= utf8_decode("<b>$desc_sol<br><br>");
		$cuerpo .= "Solicitado: $cant_det "." $nom_um<br>";
		$cuerpo .= "Recepcionado: $cant_rec "."$nom_um<br><br></b>";
	}
	if($recepcion == "Rechazado" or $recepcion == "Anulado"){ 
		$asunto = "Item de Solicitud (".$cod_sol.") Rechazado"; 
		$encabezado = utf8_decode("Se ha <b>$recepcion</b> el siguiente item de solicitud de recursos Nº (".$cod_sol.")");
		
		$cuerpo = "<html>\n"; 
		$cuerpo.= "<body>\n";
		$cuerpo.= "<table width='800' bordercolor='#cedee1' border='0' cellpadding='3' cellspacing='1'>";
			
		$cuerpo.= "<tr bgcolor='#d6e7ff'><td align='left'>&nbsp;Descripcion:</td>";
		$cuerpo.= "<td align='left'>&nbsp;".utf8_decode($desc_sol)."</td></tr>";
		
		$cuerpo.= "<tr bgcolor='#d6e7ff'><td align='left' width='22%'>&nbsp;Cantidad:</td>";
		$cuerpo.= "<td align='left'>&nbsp;$cant_det</td></tr>";
		
		$cuerpo.= "<tr bgcolor='#d6e7ff'><td align='left'>&nbsp;Unidad de medida:</td>";
		$cuerpo.= "<td align='left'>&nbsp;$nom_um</td></tr>";
		
		$cuerpo.= "<tr bgcolor='#d6e7ff'><td align='left'>&nbsp;Motivo / Nota</td>";
		$cuerpo.= "<td align='left'>&nbsp;".utf8_decode($motivo)."</td></tr>";
			
		$cuerpo.= "</tr>";
		$cuerpo.= "</table>";
		$cuerpo.= "</body>"; 
		$cuerpo.= "<html><br>";
	}
	
			
	require("../PHPMailer/class.phpmailer.php");
	$fecha	=	cambiarFecha($fecha, '-', '/' );
					
	$mail = new PHPMailer();   // Iniciamos la validación por SMTP: 
	$mail->IsSMTP(); 
	$mail->SMTPAuth = false; // True para que verifique autentificación de la cuenta o de lo contrario False 
	$mail->Password = "PMnt2011"; 
	$mail->Username = "Produccion.mgyt@mgytsa.com";  
	$mail->Port 	= "25"; 
	$mail->Host 	= "ktm.mgytsa.cl;192.168.2.7"; 
	$mail->From 	= "intranet@mgyt.cl"; 
	$mail->FromName = "Intranet Rockmine"; 
	$mail->Subject 	= $asunto;  
	
	// DESTINATARIOS DE PRODUCCION
    $mail->AddAddress($us_correo, "Solicitante");
	
	//$mail->WordWrap = 500;  
	$titulo = "Recepcion de Solicitud $cod_sol.<br><br>";
	
	$body  = "Estimado, <br>"; 
	$body .= "$encabezado<br><br>";
	$body .= $cuerpo;
	$body .= "Atte.<br>Intranet Rockmine <br><br>";
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
	sleep(2);
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
			FIN CODIGO ENVIO DE CORREO
*******************************************************************************************************************************/
}
?>    