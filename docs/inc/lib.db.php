<?php
/************************************************************************************
 Librería de Acceso a Base de Datos
 Proyecto            : SGI 1.0
 Actualización   : Agosto 2008                                                                                                    
//**********************************************************************************/


/************************************************************************************
 Función para Conectarse al motor de Base de Datos
************************************************************************************/
function Conectarse()
{
	include("config_db.php");	
	
	if (!($co=mysql_connect("$DNS","$USR","$PASS")))
	{  
		echo "Error conectanddo a la base de datos...";
		exit(); 
	}
	if (!mysql_select_db("$BDATOS",$co))
	{   
		echo "Error seleccionando la base de datos...";
		exit(); 
	}
		 return $co;
}
/************************************************************************************
 Función para Consultar
************************************************************************************/
function dbConsulta($sql){
    /*Nos conectamos*/
    $db_conexion = Conectarse();
	
    $res = array();
    $consulta  = mysql_query($sql);// or die(header ("Location:  $redir?error_login=1"));
	if ($consulta) {
		if (mysql_num_rows($consulta) != 0) {
	     	// almacenamos datos del Usuario en un array para empezar a chequear.
			while ($row = mysql_fetch_assoc($consulta)) {
	            $res[] = $row;  // $var=[2][nombrecampo];
			}
	    }else{
			 $res = Null;
		}
		 // liberamos la memoria usada por la consulta, ya que tenemos estos datos en el Array.
		mysql_free_result($consulta);	
	}else{
		echo "ERROR: Conexion o Consulta a Base de Datos";
	}
	unset($consulta);
	// cerramos la Base de dtos.
    mysql_close($db_conexion);
	
	return($res);
}
/************************************************************************************
 Función para llenar combo actualizado con ajax
************************************************************************************/
function dbConsulta_combo($sql){
	
    $db_conexion = Conectarse();
	
    $res = array();
    $consulta  = mysql_query($sql);// or die(header ("Location:  $redir?error_login=1"));
	if ($consulta) {
		if (mysql_num_rows($consulta) != 0) {
	     	// almacenamos datos del Usuario en un array para empezar a chequear.
			while ($row = mysql_fetch_assoc($consulta)) {
	            $res[] = $row;  // $var=[2][nombrecampo];
			}
	    }else{
			 $res = Null;
		}
		 // liberamos la memoria usada por la consulta, ya que tenemos estos datos en el Array.
		mysql_free_result($consulta);	
	}else{
		echo "ERROR: Conexion o Consulta a Base de Datos";
	}
	unset($consulta);
	// cerramos la Base de dtos.
    mysql_close($db_conexion);
	
	return($res);
}

/************************************************************************************
 Función para Insertar, Actualizar y Eliminar
************************************************************************************/
function dbExecute($sql){
    //No conectamos	
	
    //$db_conexion = Conectarse();

    $consulta  = mysql_query($sql);// or die(header ("Location:  $redir?error_login=1"));
	// cerramos la Base de dtos.
    //mysql_close($db_conexion);
	return($consulta);
}

/************************************************************************************
 Función para obtener el Total de Registros de una tabla
************************************************************************************/
function dbCount($sql){
    //Nos conectamos
    $db_conexion = Conectarse();

    $total  = mysql_query($sql);// or die(header ("Location:  $redir?error_login=1"));
	$total  = mysql_result($total, 0, 0);
	// cerramos la Base de dtos.
    mysql_close($db_conexion);
	return($total);
}

/*********************************************************************************************************
//Función Para Llenar un combo a partir de una consulta.
**********************************************************************************************************/
function LlenarCombo($nombre,$DNS,$USR,$PASS,$dbname,$sql,$caTexto,$caValor,$selecT,$selecV,$size,$reload){
	$co=mysql_connect($DNS,$USR,$PASS);
	mysql_select_db($dbname, $co);
	$respuesta = mysql_query($sql);
	while ($row = mysql_fetch_assoc($respuesta)) {
            $consulta[] = $row; 
	}
	mysql_close($co);
	
    $out = "<select id=$nombre name=$nombre size=$size ";
	if ($reload) $out .= "onchange='f.submit();'";
	$out .= ">\n<option selected VALUE=0>--  Seleccione Opcion  --</option>\n";
	$i     = 0;
	$total =  count($consulta);
	while($i < $total)
	{   
		$texto = $consulta[$i][$caTexto];
		$valor = $consulta[$i][$caValor];
		if ($texto == $selecT){
			$se = "selected";
		}else{
			$se = "";
		}
		if ($valor == $selecV){
			$se = "selected";
		}else{
			$se = "";
		}
		$out .= "<option $se VALUE=$valor>$texto</option>\n";
		$i++;
	}
	$out .= "</select>\n";
	return($out);
}

/*********************************************************************************************************
//Función Para Cambiar el Formato de la Fecha
**********************************************************************************************************/
function cambiarFecha( $sFecha, $sSimboloInicial, $sSimboloFinal )
{
return implode( $sSimboloFinal, array_reverse( explode( $sSimboloInicial, $sFecha ) ) ) ; 
} 

/*********************************************************************************************************
//Función Para generar Alertas
**********************************************************************************************************/
function alert($msg) 
{ 
    $msg = addslashes($msg); 
    $msg = str_replace("\n", "\\n", $msg); 
    echo "<script type='text/javascript' language='Javascript'><!--\n"; 
    echo 'alert("' . $msg . '")'; 
    echo "//--></script>\n\n"; 
} 

function corta($tamano,$texto){
	// Inicializamos las variables
	$contador = 0;
	 
	// Cortamos la cadena por los espacios
	$arrayTexto = split(' ',$texto);
	$texto = '';
	 
	// Reconstruimos la cadena
	while($tamano >= strlen($texto) + strlen($arrayTexto[$contador])){
		$texto .= ' '.$arrayTexto[$contador];
		$contador++;
	}
	return $texto;
}

function envia_msg($ods, $area, $priori, $estado, $est_inf, $planta, $usuario, $fe_in_ret, $fe_env_inf, $fe_aprov, $fe_ent_rep, $fe_ent_rep2, $fe_ent_rep3, $dias_rep, $fe_ent_aprox, $guia_desp_det, $cant, $fam_eq, $desc_eq_sguia, $desc_eq_scont, $V_desc_eq_scont, $desc_falla, $observ, $fe_ter_prod, $guia_mgyt_ent, $ent_par1, $ent_par2, $ent_par3, $ent_par4, $ent_par5, $fe_cierre_ods_fact, $fe_fact, $precio, $botar_rises, $ent1_cant, $ent1_guia, $ent2_cant, $ent2_guia, $ent3_cant, $ent3_guia, $ent4_cant, $ent4_guia, $ent5_cant, $ent5_guia, $req_cal, $ing_por, $fe_ing_sist)
{
		// ORIGEN
		$headers = 'MIME-Version: 1.0' ."web". "\r\n";  
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Produccion MGYT <produccion.mgyt@mgyt.com>';
		  
		// ASUNTO
		$sub 	= "Nueva ODS de $area Aprobada ( $ods ) ";
		$color 	= "#efefef";
		$color2 = "#e5e5e5";
		  
		 // CONTENIDO
		$mensaje = "<html>\n"; 
		$mensaje.= "<body>\n";
		$mensaje = "<table width='850' bordercolor='#ffffff' border='0' cellpadding='2' cellspacing='2' class='textnormal'>";
		 
		$mensaje.= "<tr><td colspan='6' bgcolor='#d0dce0' align='center' width='100'>&nbsp;<br>ORDEN DE SERVICIO <br><br></td></tr>";
		 
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Area</td>"; 
		$mensaje.= "<td align='left' colspan='2' bgcolor='#e5e5e5'>&nbsp;$area</td>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Nº ODS:</td>";
		$mensaje.= "<td align='left' colspan='2' bgcolor='#e5e5e5'>&nbsp;$ods</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Prioridad</td>"; 
		$mensaje.= "<td align='left' colspan='2' bgcolor='$color2'>&nbsp;$priori</td>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Estado:</td>";
		$mensaje.= "<td align='left' colspan='2' bgcolor='$color2'>&nbsp;$estado</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Planta</td>"; 
		$mensaje.= "<td align='left' colspan='2' bgcolor='$color2'>&nbsp;$planta</td>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Usuario</td>";
		$mensaje.= "<td align='left' colspan='2' bgcolor='$color2'>&nbsp;$usuario</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Fecha Ing. Retiro</td>"; 
		$mensaje.= "<td align='left' colspan='2' bgcolor='$color2'>&nbsp;$fe_in_ret</td>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Guia Desp. Det :</td>";
		$mensaje.= "<td align='left' colspan='2' bgcolor='$color2'>&nbsp;$guia_desp_det</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Cantidad</td>"; 
		$mensaje.= "<td align='left' colspan='2' bgcolor='$color2'>&nbsp;$cant</td>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Familia de equipo:</td>";
		$mensaje.= "<td align='left' colspan='2' bgcolor='$color2'>&nbsp;$fam_eq</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Desc. de eq. segun cto.</td>"; 
		$mensaje.= "<td align='left' colspan='5' bgcolor='$color2'>&nbsp;$desc_eq_scont</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Desc. equipo segun guia</td>"; 
		$mensaje.= "<td align='left' colspan='5' bgcolor='$color2'>&nbsp;$desc_eq_sguia</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Desc. de falla</td>"; 
		$mensaje.= "<td align='left' colspan='5' bgcolor='$color2'>&nbsp;$desc_falla</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Requerimientos de calidad:</td>"; 
		$mensaje.= "<td align='left' colspan='5' bgcolor='$color2'>&nbsp;$req_cal</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Observaciones</td>"; 
		$mensaje.= "<td align='left' colspan='5' bgcolor='$color2'>&nbsp;$observ</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Estado ITR</td> <td align='left' width='16%' bgcolor='$color2'>&nbsp;$est_inf</td>"; 
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Fecha envio Inf.</td> <td align='left' width='16%' bgcolor='$color2'>&nbsp;$fe_env_inf</td>";
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Fecha Aprob.</td> <td align='left' width='16%' bgcolor='$color2'>&nbsp;$fe_aprov</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Fecha Ent. repuestos 1</td> <td align='left' width='16%' bgcolor='$color2'>&nbsp;$fe_ent_rep</td>"; 
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Fecha Ent. repuestos 2</td> <td align='left' width='16%' bgcolor='$color2'>&nbsp;$fe_ent_rep2</td>";
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Fecha Ent. repuestos 3</td> <td align='left' width='16%' bgcolor='$color2'>&nbsp;$fe_ent_rep3</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Fecha Ent. Aprox.</td> <td align='left' width='16%' bgcolor='$color2'>&nbsp;$fe_ent_aprox</td>"; 
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Dias Reparacion</td> <td align='left' width='16%' bgcolor='$color2'>&nbsp;$dias_rep</td>";
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Fecha Termino Prod.</td> <td align='left' width='16%' bgcolor='$color2'>&nbsp;$fe_ter_prod</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Entrega Parcial 1</td> <td align='left' width='16%' bgcolor='$color2'>&nbsp;$ent_par1</td>"; 
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Cantidad</td> <td align='left' width='16%' bgcolor='$color2'>&nbsp;$ent1_cant</td>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Nº Guia de despacho</td> <td align='left' width='12%' bgcolor='$color2'>&nbsp;$ent1_guia</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Entrega Parcial 1</td> <td align='left' width='16%' bgcolor='$color2'>&nbsp;$ent_par2</td>"; 
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Cantidad</td> <td align='left' width='16%' bgcolor='$color2'>&nbsp;$ent2_cant</td>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Nº Guia de despacho</td> <td align='left' width='12%' bgcolor='$color2'>&nbsp;$ent2_guia</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Entrega Parcial 1</td> <td align='left' width='16%' bgcolor='$color2'>&nbsp;$ent_par3</td>"; 
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Cantidad</td> <td align='left' width='16%' bgcolor='$color2'>&nbsp;$ent3_cant</td>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Nº Guia de despacho</td> <td align='left' width='12%' bgcolor='$color2'>&nbsp;$ent3_guia</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Entrega Parcial 1</td> <td align='left' width='16%' bgcolor='$color2'>&nbsp;$ent_par4</td>"; 
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Cantidad</td> <td align='left' width='16%' bgcolor='$color2'>&nbsp;$ent4_cant</td>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Nº Guia de despacho</td> <td align='left' width='12%' bgcolor='$color2'>&nbsp;$ent4_guia</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Entrega Parcial 1</td> <td align='left' width='16%' bgcolor='$color2'>&nbsp;$ent_par5</td>"; 
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Cantidad</td> <td align='left' width='16%' bgcolor='$color2'>&nbsp;$ent5_cant</td>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Nº Guia de despacho</td> <td align='left' width='12%' bgcolor='$color2'>&nbsp;$ent5_guia</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Cierre ODS Fact.</td> <td align='left' width='16%' bgcolor='$color2'>&nbsp;$fe_cierre_ods_fact</td>"; 
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;</td> <td align='left' width='16%' bgcolor='$color2'>&nbsp;</td>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Facturacion</td> <td align='left' width='12%' bgcolor='$color2'>&nbsp;$fe_fact</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Precio</td> <td align='left' width='16%' bgcolor='$color2'>&nbsp;$precio</td>"; 
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;</td> <td align='left' width='16%' bgcolor='$color2'>&nbsp;</td>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Botar Rises</td> <td align='left' width='12%' bgcolor='$color2'>&nbsp;$botar_rises</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Guias de Despacho MGYT</td> <td align='left' width='16%' colspan='5' bgcolor='$color2'>&nbsp;</td>"; 
		$mensaje.= "</tr>";

		$mensaje.= "<tr><td colspan='6' bgcolor='#d0dce0' align='center'>&nbsp;ODS INGRESADA POR:&nbsp;&nbsp;&nbsp;$ing_por"."&nbsp;&nbsp;&nbsp;EL DIA:&nbsp;&nbsp;&nbsp;$fe_ing_sist;</td></tr>";
		$mensaje.= "<tr><td colspan='6' bgcolor='#d0dce0'>&nbsp;</td></tr>";
		
		$mensaje.= "</table>";
		$mensaje.= "</body>"; 
		$mensaje.= "<html>";
		  
		 // DESTINATARIOS
		 mail("pedro.troncoso@mgytsa.com", $sub, $mensaje, $headers);
		 mail("pedro.troncoso@mgyt.cl", $sub, $mensaje, $headers);
		 mail("pedro.troncoso@mgytsa.cl", $sub, $mensaje, $headers);
		/* mail("victor.castaneda@mgytsa.com", $sub, $mensaje, $headers);
		 mail("mario.munoz@mgytsa.com", $sub, $mensaje, $headers);
		 mail("jorge.vilches@mgytsa.cl", $sub, $mensaje, $headers);*/
}

function envia_msg_ods($ods, $area, $priori, $estado, $est_inf, $planta, $usuario, $fe_in_ret, $fe_env_inf, $fe_aprov, $fe_ent_rep, $fe_ent_rep2, $fe_ent_rep3, $dias_rep, $fe_ent_aprox, $guia_desp_det, $cant, $fam_eq, $desc_eq_sguia, $desc_eq_scont, $V_desc_eq_scont, $desc_falla, $observ, $fe_ter_prod, $guia_mgyt_ent, $ent_par1, $ent_par2, $ent_par3, $ent_par4, $ent_par5, $fe_cierre_ods_fact, $fe_fact, $precio, $botar_rises, $ent1_cant, $ent1_guia, $ent2_cant, $ent2_guia, $ent3_cant, $ent3_guia, $ent4_cant, $ent4_guia, $ent5_cant, $ent5_guia, $req_cal, $ing_por, $fe_ing_sist)
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
	$mail->FromName = "Produccion MGYT"; 
	$mail->Subject 	= "Nueva ODS de $area Aprobada ( $ods ) ";
	$color 			= "#e0e2e4";
	$color2 		= "#efefef";
	
	// DESTINATARIOS
	$mail->AddAddress("pedro.troncoso@mgyt.cl","Programacion");
	$mail->AddBCC("robinson.gonzalez@mgyt.cl","Programacion");
	$mail->AddBCC("pablo.lopez@mgyt.cl","Programacion");
	
	$mail->AddAddress("victor.castaneda@mgyt.cl","Produccion");
	
	//$mail->AddAddress("mario.munoz@mgyt.cl","Calidad");
	$mail->AddAddress("jorge.vilches@mgyt.cl","Calidad");
	$mail->AddAddress("juan.toncio@mgyt.cl","Calidad");
	

	//$mail->WordWrap = 500;  
	 // CONTENIDO
		$body = "<html>\n"; 
		$body.= "<body>\n";
		$body = "<table width='850' bordercolor='#ffffff' border='0' cellpadding='2' cellspacing='2' class='textnormal'>";
		 
		$body.= "<tr><td colspan='6' bgcolor='#d0dce0' align='center' width='100'>&nbsp;<br>ORDEN DE SERVICIO <br><br></td></tr>";
		 
		$body.= "<tr>";
		$body.= "<td align='left' bgcolor='$color'>&nbsp;Area</td>"; 
		$body.= "<td align='left' colspan='2' bgcolor='#e5e5e5'>&nbsp;$area</td>";
		$body.= "<td align='left' bgcolor='$color'>&nbsp;Nº ODS:</td>";
		$body.= "<td align='left' colspan='2' bgcolor='#e5e5e5'>&nbsp;$ods</td>";
		$body.= "</tr>";
		
		$body.= "<tr>";
		$body.= "<td align='left' bgcolor='$color'>&nbsp;Prioridad</td>"; 
		$body.= "<td align='left' colspan='2' bgcolor='#e5e5e5'>&nbsp;$priori</td>";
		$body.= "<td align='left' bgcolor='$color'>&nbsp;Estado:</td>";
		$body.= "<td align='left' colspan='2' bgcolor='#e5e5e5'>&nbsp;$estado</td>";
		$body.= "</tr>";
		
		$body.= "<tr>";
		$body.= "<td align='left' bgcolor='$color'>&nbsp;Planta</td>"; 
		$body.= "<td align='left' colspan='2' bgcolor='#e5e5e5'>&nbsp;$planta</td>";
		$body.= "<td align='left' bgcolor='$color'>&nbsp;Usuario</td>";
		$body.= "<td align='left' colspan='2' bgcolor='#e5e5e5'>&nbsp;$usuario</td>";
		$body.= "</tr>";
		
		$body.= "<tr>";
		$body.= "<td align='left' bgcolor='$color'>&nbsp;Fecha Ing. Retiro</td>"; 
		$body.= "<td align='left' colspan='2' bgcolor='#e5e5e5'>&nbsp;$fe_in_ret</td>";
		$body.= "<td align='left' bgcolor='$color'>&nbsp;Guia Desp. Det :</td>";
		$body.= "<td align='left' colspan='2' bgcolor='#e5e5e5'>&nbsp;$guia_desp_det</td>";
		$body.= "</tr>";
		
		$body.= "<tr>";
		$body.= "<td align='left' bgcolor='$color'>&nbsp;Cantidad</td>"; 
		$body.= "<td align='left' colspan='2' bgcolor='#e5e5e5'>&nbsp;$cant</td>";
		$body.= "<td align='left' bgcolor='$color'>&nbsp;Familia de equipo:</td>";
		$body.= "<td align='left' colspan='2' bgcolor='#e5e5e5'>&nbsp;$fam_eq</td>";
		$body.= "</tr>";
		
		$body.= "<tr>";
		$body.= "<td align='left' bgcolor='$color'>&nbsp;Desc. de eq. segun cto.</td>"; 
		$body.= "<td align='left' colspan='5' bgcolor='#e5e5e5'>&nbsp;$desc_eq_scont</td>";
		$body.= "</tr>";
		
		$body.= "<tr>";
		$body.= "<td align='left' bgcolor='$color'>&nbsp;Desc. equipo segun guia</td>"; 
		$body.= "<td align='left' colspan='5' bgcolor='#e5e5e5'>&nbsp;$desc_eq_sguia</td>";
		$body.= "</tr>";
		
		$body.= "<tr>";
		$body.= "<td align='left' bgcolor='$color'>&nbsp;Desc. de falla</td>"; 
		$body.= "<td align='left' colspan='5' bgcolor='#e5e5e5'>&nbsp;$desc_falla</td>";
		$body.= "</tr>";
		
		$body.= "<tr>";
		$body.= "<td align='left' bgcolor='$color'>&nbsp;Requerimientos de calidad:</td>"; 
		$body.= "<td align='left' colspan='5' bgcolor='#e5e5e5'>&nbsp;$req_cal</td>";
		$body.= "</tr>";
		
		$body.= "<tr>";
		$body.= "<td align='left' bgcolor='$color'>&nbsp;Observaciones</td>"; 
		$body.= "<td align='left' colspan='5' bgcolor='#e5e5e5'>&nbsp;$observ</td>";
		$body.= "</tr>";
		
		$body.= "<tr>";
		$body.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Estado ITR</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$est_inf</td>"; 
		$body.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Fecha envio Inf.</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$fe_env_inf</td>";
		$body.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Fecha Aprob.</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$fe_aprov</td>";
		$body.= "</tr>";
		
		$body.= "<tr>";
		$body.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Fecha Ent. repuestos 1</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$fe_ent_rep</td>"; 
		$body.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Fecha Ent. repuestos 2</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$fe_ent_rep2</td>";
		$body.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Fecha Ent. repuestos 3</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$fe_ent_rep3</td>";
		$body.= "</tr>";
		
		$body.= "<tr>";
		$body.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Fecha Ent. Aprox.</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$fe_ent_aprox</td>"; 
		$body.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Dias Reparacion</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$dias_rep</td>";
		$body.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Fecha Termino Prod.</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$fe_ter_prod</td>";
		$body.= "</tr>";
		
		$body.= "<tr>";
		$body.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Entrega Parcial 1</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$ent_par1</td>"; 
		$body.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Cantidad</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$ent1_cant</td>";
		$body.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Nº Guia de despacho</td> <td align='left' width='12%' bgcolor='#e5e5e5'>&nbsp;$ent1_guia</td>";
		$body.= "</tr>";
		
		$body.= "<tr>";
		$body.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Entrega Parcial 1</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$ent_par2</td>"; 
		$body.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Cantidad</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$ent2_cant</td>";
		$body.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Nº Guia de despacho</td> <td align='left' width='12%' bgcolor='#e5e5e5'>&nbsp;$ent2_guia</td>";
		$body.= "</tr>";
		
		$body.= "<tr>";
		$body.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Entrega Parcial 1</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$ent_par3</td>"; 
		$body.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Cantidad</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$ent3_cant</td>";
		$body.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Nº Guia de despacho</td> <td align='left' width='12%' bgcolor='#e5e5e5'>&nbsp;$ent3_guia</td>";
		$body.= "</tr>";
		
		$body.= "<tr>";
		$body.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Entrega Parcial 1</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$ent_par4</td>"; 
		$body.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Cantidad</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$ent4_cant</td>";
		$body.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Nº Guia de despacho</td> <td align='left' width='12%' bgcolor='#e5e5e5'>&nbsp;$ent4_guia</td>";
		$body.= "</tr>";
		
		$body.= "<tr>";
		$body.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Entrega Parcial 1</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$ent_par5</td>"; 
		$body.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Cantidad</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$ent5_cant</td>";
		$body.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Nº Guia de despacho</td> <td align='left' width='12%' bgcolor='#e5e5e5'>&nbsp;$ent5_guia</td>";
		$body.= "</tr>";
		
		$body.= "<tr>";
		$body.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Cierre ODS Fact.</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$fe_cierre_ods_fact</td>"; 
		$body.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;</td>";
		$body.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Facturacion</td> <td align='left' width='12%' bgcolor='#e5e5e5'>&nbsp;$fe_fact</td>";
		$body.= "</tr>";
		
		$body.= "<tr>";
		$body.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Precio</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$precio</td>"; 
		$body.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;</td>";
		$body.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Botar Rises</td> <td align='left' width='12%' bgcolor='#e5e5e5'>&nbsp;$botar_rises</td>";
		$body.= "</tr>";
		
		$body.= "<tr>";
		$body.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Guias de Despacho MGYT</td> <td align='left' width='16%' colspan='5' bgcolor='#e5e5e5'>&nbsp;</td>"; 
		$body.= "</tr>";

		$body.= "<tr><td colspan='6' bgcolor='#d0dce0' align='center'>&nbsp;ODS INGRESADA POR:&nbsp;&nbsp;&nbsp;$ing_por"."&nbsp;&nbsp;&nbsp;EL DIA:&nbsp;&nbsp;&nbsp;$fe_ing_sist;</td></tr>";
		$body.= "<tr><td colspan='6' bgcolor='#d0dce0'>&nbsp;</td></tr>";
		
		$body.= "</table>";
		$body.= "</body>"; 
		$body.= "<html>";
	
	$mail->Body = $body; 
	$mail->MsgHTML($body);  
	$mail->IsHTML(true); // Enviar como HTML  

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
		$resultado = "No_enviado";
	}else{

		$resultado = "Enviado";
	}
		
return $resultado;
/*******************************************************************************************************************************
			FIN CODIGO ENVIO DE CORREO CON FSR ADJUNTO BODEGA
*******************************************************************************************************************************/
}

function cortarTexto($texto,$tam) { 

    $tamano = $tam; // tamaño máximo 
    $textoFinal = ''; // Resultado 

    // Si el numero de carateres del texto es menor que el tamaño maximo, 
    // el tamaño maximo pasa a ser el del texto 
    if (strlen($texto) < $tamano) $tamano = strlen($texto); 

    for ($i=0; $i <= $tamano - 1; $i++) { 
        // Añadimos uno por uno cada caracter del texto 
        // original al texto final, habiendo puesto 
        // como limite la variable $tamano 
        $textoFinal .= $texto[$i]; 
    } 

    // devolvemos el texto final 
    return $textoFinal; 
} 

/********************************************************************************************************************************************************************************************
		FUNCION QUE SUMA DIAS A UNA FECHA Y LA MUESTRA CON FORMATO DE FECHA
********************************************************************************************************************************************************************************************/
function suma_fechas($fecha,$ndias)
{
     if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
	 
         list($dia,$mes,$año)=split("/", $fecha);
            
 
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
            
 
        list($dia,$mes,$año)=split("-",$fecha);
        $nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
        $nuevafecha=date("d/m/Y",$nueva);
            
      	return ($nuevafecha);  
}

/********************************************************************************************************************************************************************************************
		FUNCION QUE CALCULA LOS DIAS ENTRE DOS FECHAS
********************************************************************************************************************************************************************************************/
function calcula_fecha($fe1,$fe2)
{
	$fecha1 = explode("-", $fe1);
	$fecha2 = explode("-", $fe2);
	
	$ano1 = $fecha1[0]; // trozo1
	$mes1 = $fecha1[1]; // trozo2
	$dia1 = $fecha1[2]; // trozo2
	
	//defino fecha 2 
	$ano2 = $fecha2[0]; // trozo1
	$mes2 = $fecha2[1]; // trozo2
	$dia2 = $fecha2[2]; // trozo2
	
	//calculo timestam de las dos fechas 
	$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1); 
	$timestamp2 = mktime(4,12,0,$mes2,$dia2,$ano2); 
	
	//resto a una fecha la otra 
	$segundos_diferencia = $timestamp1 - $timestamp2; 
	//echo $segundos_diferencia; 
	
	//convierto segundos en días 
	$dias_diferencia = $segundos_diferencia / (60 * 60 * 24); 
	
	//obtengo el valor absoulto de los días (quito el posible signo negativo) 
	$dias_diferencia = abs($dias_diferencia); 
	
	//quito los decimales a los días de diferencia 
	$dias_diferencia = floor($dias_diferencia); 
	
	return $dias_diferencia; 
}

/********************************************************************************************************************************************************************************************
		FUNCION QUE CALCULA LOS DIAS QUE FALTAN PARA UNA FECHA
********************************************************************************************************************************************************************************************/
function calcula_dias_de_diferencia($fe1,$fe2)
{
	$fecha1 = explode("-", $fe1);
	$fecha2 = explode("-", $fe2);
	
	$ano1 = $fecha1[0]; // trozo1
	$mes1 = $fecha1[1]; // trozo2
	$dia1 = $fecha1[2]; // trozo2
	
	//defino fecha 2 
	$ano2 = $fecha2[0]; // trozo1
	$mes2 = $fecha2[1]; // trozo2
	$dia2 = $fecha2[2]; // trozo2
	
	//calculo timestam de las dos fechas 
	$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1); 
	$timestamp2 = mktime(4,12,0,$mes2,$dia2,$ano2); 
	
	//resto a una fecha la otra 
	$segundos_diferencia = $timestamp1 - $timestamp2; 
	//echo $segundos_diferencia; 
	
	//convierto segundos en días 
	$dias_diferencia = $segundos_diferencia / (60 * 60 * 24); 
	
	//obtengo el valor absoulto de los días (quito el posible signo negativo) 
	//$dias_diferencia = abs($dias_diferencia); 
	
	//quito los decimales a los días de diferencia 
	$dias_diferencia = floor($dias_diferencia); 
	
	return $dias_diferencia; 
}

// Calcula el numero de dias entre dos fechas. 
// Da igual el formato de las fechas (dd-mm-aaaa o aaaa-mm-dd), 
// pero el caracter separador debe ser un guión. 
function diasEntreFechas($fechainicio, $fechafin)
{     
	return (floor((strtotime($fechafin)-strtotime($fechainicio))/86400)); 
}

function detecta_ip_isp()
{
	if (getenv("HTTP_X_FORWARDED_FOR"))
	{
		$ip = getenv("HTTP_X_FORWARDED_FOR");
		$client = gethostbyaddr($_SERVER['HTTP_X_FORWARDED_FOR']);
	}else{
		$ip = getenv("REMOTE_ADDR");
		$client = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	}
	$str = preg_split("/\./", $client);
	$i = count($str);
	$x = $i - 1;
	$n = $i - 2;
	$isp = $str[$n] . "." . $str[$x];
	
	//return $ip;
	return $isp;
}
/********************************************************************************************************************************************************************************************
		FUNCION QUE COMPARA FECHAS Y DEVUELVE MAYOR, MENOR O IGUAL
********************************************************************************************************************************************************************************************/
function comparar_fechas($fecha_hoy, $fecha_baja)
{
	list ($dia_hoy, $mes_hoy, $anio_hoy) = explode("/", $fecha_hoy); //separo laos dias, los meses y los años
	list ($dia_limite, $mes_limite, $anio_limite) = explode("/", $fecha_baja);
	
	//comparo primero los años para saber si es mayor igual o menor
	if($anio_hoy > $anio_limite) $resp="Mayor";
		elseif ($anio_hoy < $anio_limite) $resp="Menor";
			elseif($mes_hoy > $mes_limite) $resp="Mayor";
				elseif ($mes_hoy < $mes_limite) $resp="Menor";  
					elseif($dia_hoy > $dia_limite) $resp="Mayor";
						elseif ($dia_hoy < $dia_limite) $resp="Menor"; 
							else $resp="Igual";
							
							return $resp;
} 


function Calcula_Mes()
{
	$hoy    = date("Y-m-d");
	$fecha 	= explode("-", $hoy);
	$mes 	= $fecha[1]; // Mes
	
	switch ($mes) {
		case "01":
			$MesActual = "Enero";
			break;
		case "02":
			$MesActual = "Febrero";
			break;
		case "03":
			$MesActual = "Marzo";
			break;
		case "04":
			$MesActual = "Abril";
			break;
		case "05":
			$MesActual = "Mayo";
			break;
		case "06":
			$MesActual ="Junio";
			break;
		case "07":
			$MesActual = "Julio";
			break;
		case "08":
			$MesActual = "Agosto";
			break;
		case "09":
			$MesActual = "Septiembre";
			break;
		case "10":
			$MesActual = "Octubre";
			break;
		case "11":
			$MesActual = "Noviembre";
			break;
		case "12":
			$MesActual = "Diciembre";
			break;
	}
	return $MesActual;
}


function Calcula_Ano()
{
	$hoy    	= date("Y-m-d");
	$fecha 		= explode("-", $hoy);
	$anoDate 	= $fecha[0]; // Mes
	
	switch ($anoDate) {
		case "2011":
			$AnoActual = "2011";
			break;
		case "2012":
			$AnoActual = "2012";
			break;
		case "2013":
			$AnoActual = "2013";
			break;
	}
	return $AnoActual;
}


?>    