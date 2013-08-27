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

    $consulta  = mysql_query($sql); 	// or die(header ("Location:  $redir?error_login=1"));
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
	list ($dia_hoy, $mes_hoy, $anio_hoy) = split("/", $fecha_hoy); //separo laos dias, los meses y los años
	list ($dia_limite, $mes_limite, $anio_limite) = split("/", $fecha_baja);
	
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
?>    