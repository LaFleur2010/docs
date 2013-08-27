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
	if (!($link=mysql_connect("$DNS","$USR","$PASS")))
	{  
		echo "Error conectanddo a la base de datos...";
		exit(); 
	}
	if (!mysql_select_db("$BDATOS",$link))
	{   
		echo "Error seleccionando la base de datos...";
		exit(); 
	}
		 return $link;
}
/************************************************************************************
 Función para Consultar
************************************************************************************/
function dbConsulta($sql){
    //Nos conectamos
    require ("inc/config_db.php");	
    $db_conexion = mysql_connect("$DNS", "$USR", "$PASS"); //or die(header ("Location:  $redir?error_login=0"));
    mysql_select_db("$BDATOS");
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
    require ("inc/config_db.php");		
    $db_conexion = mysql_connect("$DNS", "$USR", "$PASS"); //or die(header ("Location:  $redir?error_login=0"));
    mysql_select_db("$BDATOS");

    $consulta  = mysql_query($sql);// or die(header ("Location:  $redir?error_login=1"));
	// cerramos la Base de dtos.
    mysql_close($db_conexion);
	return($consulta);
}

/************************************************************************************
 Función para obtener el Total de Registros de una tabla
************************************************************************************/
function dbCount($sql){
    //Nos conectamos
    require ("inc/config_db.php");		
    $db_conexion = mysql_connect("$DNS", "$USR", "$PASS"); //or die(header ("Location:  $redir?error_login=0"));
    mysql_select_db("$BDATOS");

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
    echo "<script language='javascript'><!--\n"; 
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

function envia_msg($ods, $area, $priori, $estado, $est_inf, $planta, $usuario, $fe_in_ret, $fe_env_inf, $fe_aprov, $fe_ent_rep, $fe_ent_rep2, $fe_ent_rep3, $dias_rep, $fe_ent_aprox, $guia_desp_det, $cant, $fam_eq, $desc_eq_sguia, $desc_eq_scont, $V_desc_eq_scont, $desc_falla, $observ, $fe_ter_prod, $guia_mgyt_ent, $ent_par1, $ent_par2, $ent_par3, $ent_par4, $ent_par5, $fe_cierre_ods_fact, $fe_fact, $precio, $botar_rises, $ent1_cant, $ent1_guia, $ent2_cant, $ent2_guia, $ent3_cant, $ent3_guia, $ent4_cant, $ent4_guia, $ent5_cant, $ent5_guia)
{
		// ORIGEN
		$headers = 'MIME-Version: 1.0' ."web". "\r\n";  
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Produccion MGYT <intranet@mgyt.cl>';
		  
		// ASUNTO
		$sub 	= "Nueva ODS de $area Aprobada ( $ods ) ";
		$color 	= "#d5d5d5";
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
		$mensaje.= "<td align='left' colspan='2' bgcolor='#e5e5e5'>&nbsp;$priori</td>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Estado:</td>";
		$mensaje.= "<td align='left' colspan='2' bgcolor='#e5e5e5'>&nbsp;$estado</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Planta</td>"; 
		$mensaje.= "<td align='left' colspan='2' bgcolor='#e5e5e5'>&nbsp;$planta</td>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Usuario</td>";
		$mensaje.= "<td align='left' colspan='2' bgcolor='#e5e5e5'>&nbsp;$usuario</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Fecha Ing. Retiro</td>"; 
		$mensaje.= "<td align='left' colspan='2' bgcolor='#e5e5e5'>&nbsp;$fe_in_ret</td>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Guia Desp. Det :</td>";
		$mensaje.= "<td align='left' colspan='2' bgcolor='#e5e5e5'>&nbsp;$guia_desp_det</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Cantidad</td>"; 
		$mensaje.= "<td align='left' colspan='2' bgcolor='#e5e5e5'>&nbsp;$cant</td>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Familia de equipo:</td>";
		$mensaje.= "<td align='left' colspan='2' bgcolor='#e5e5e5'>&nbsp;$fam_eq</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Desc. de eq. segun cto.</td>"; 
		$mensaje.= "<td align='left' colspan='5' bgcolor='#e5e5e5'>&nbsp;$desc_eq_scont</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Desc. equipo segun guia</td>"; 
		$mensaje.= "<td align='left' colspan='5' bgcolor='#e5e5e5'>&nbsp;$desc_eq_sguia</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Desc. de falla</td>"; 
		$mensaje.= "<td align='left' colspan='5' bgcolor='#e5e5e5'>&nbsp;$desc_falla</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' bgcolor='$color'>&nbsp;Observaciones</td>"; 
		$mensaje.= "<td align='left' colspan='5' bgcolor='#e5e5e5'>&nbsp;$observ</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Estado ITR</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$est_inf</td>"; 
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Fecha envio Inf.</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$fe_env_inf</td>";
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Fecha Aprob.</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$fe_aprov</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Fecha Ent. repuestos 1</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$fe_ent_rep</td>"; 
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Fecha Ent. repuestos 2</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$fe_ent_rep2</td>";
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Fecha Ent. repuestos 3</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$fe_ent_rep3</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Fecha Ent. Aprox.</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$fe_ent_aprox</td>"; 
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Dias Reparacion</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$dias_rep</td>";
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Fecha Termino Prod.</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$fe_ter_prod</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Entrega Parcial 1</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$ent_par1</td>"; 
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Cantidad</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$ent1_cant</td>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Nº Guia de despacho</td> <td align='left' width='12%' bgcolor='#e5e5e5'>&nbsp;$ent1_guia</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Entrega Parcial 1</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$ent_par2</td>"; 
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Cantidad</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$ent2_cant</td>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Nº Guia de despacho</td> <td align='left' width='12%' bgcolor='#e5e5e5'>&nbsp;$ent2_guia</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Entrega Parcial 1</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$ent_par3</td>"; 
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Cantidad</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$ent3_cant</td>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Nº Guia de despacho</td> <td align='left' width='12%' bgcolor='#e5e5e5'>&nbsp;$ent3_guia</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Entrega Parcial 1</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$ent_par4</td>"; 
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Cantidad</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$ent4_cant</td>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Nº Guia de despacho</td> <td align='left' width='12%' bgcolor='#e5e5e5'>&nbsp;$ent4_guia</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Entrega Parcial 1</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$ent_par5</td>"; 
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;Cantidad</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$ent5_cant</td>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Nº Guia de despacho</td> <td align='left' width='12%' bgcolor='#e5e5e5'>&nbsp;$ent5_guia</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Cierre ODS Fact.</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$fe_cierre_ods_fact</td>"; 
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;</td>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Facturacion</td> <td align='left' width='12%' bgcolor='#e5e5e5'>&nbsp;$fe_fact</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Precio</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;$precio</td>"; 
		$mensaje.= "<td align='left' width='16%' bgcolor='$color'>&nbsp;</td> <td align='left' width='16%' bgcolor='#e5e5e5'>&nbsp;</td>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Botar Rises</td> <td align='left' width='12%' bgcolor='#e5e5e5'>&nbsp;$botar_rises</td>";
		$mensaje.= "</tr>";
		
		$mensaje.= "<tr>";
		$mensaje.= "<td align='left' width='20%' bgcolor='$color'>&nbsp;Guias de Despacho MGYT</td> <td align='left' width='16%' colspan='5' bgcolor='#e5e5e5'>&nbsp;</td>"; 
		$mensaje.= "</tr>";

		$mensaje.= "<tr><td colspan='6' bgcolor='#d0dce0'>&nbsp;</td></tr>";
		
		$mensaje.= "</table>";
		$mensaje.= "</body>"; 
		$mensaje.= "<html>";
		  
		 // DESTINATARIOS
		 mail("pedro.troncoso@mgyt.cl", $sub, $mensaje, $headers);
		 mail("cristian.saldana@mgyt.cl", $sub, $mensaje, $headers);
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
	
	echo "Los dias de diferencia son: ".$dias_diferencia; 
}


?>    