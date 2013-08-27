<?php 	
	$SERVER		= "localhost";
	$USR		= "sa";
	$PASS		= "sqlserverpass";
	$BDATOS		= "MGYT3";
	
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

function convertir_fecha($fecha_datetime)
{ 
	//Esta función convierte la fecha del formato DATETIME de SQL 
	//a formato DD-MM-YYYY HH:mm:ss 
	$fecha = split("-",$row["fecha_datetime"]); 
	$hora = split(":",$fecha[2]); 
	$fecha_hora=split("",$hora[0]); 
	$fecha_convertida=$fecha_hora[0].'-'.$fecha[1].'-'.$fecha[0].' 
	'.$fecha_hora[1].':'.$hora[1].':'.$hora[2]; 
	return $fecha_convertida; 
}  

/********************************************************************************************************************************************************************************************
		FUNCION QUE CALCULA LOS DIAS QUE FALTAN PARA UNA FECHA DATETIME
********************************************************************************************************************************************************************************************/
function dias_de_diferencia_datetime($fe1,$fe2)
{
	$fecha1 = explode("-", $fe1);
	$fecha2 = explode("-", $fe2);
	
	$dia1 	= $fecha1[0]; // trozo1
	$mes1  	= $fecha1[1]; // trozo2
	$ano1a  = $fecha1[2]; // trozo2
	
	$anoa 	= explode(" ", $ano1a);
	$ano1  	= $anoa[0]; // trozo1
	
	//defino fecha 2 
	$dia2 	= $fecha2[0]; // trozo1
	$mes2 	= $fecha2[1]; // trozo2
	$ano2b 	= $fecha2[2]; // trozo2
	
	$anob = explode(" ", $ano2b);
	$ano2  = $anob[0]; // trozo1
	
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vacaciones</title>
<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">

<script language="javascript">

</script>
<style type="text/css">
<!--
body {
	background-color: #5a88b7;
}
-->
</style></head>

<body>
<form id="f" name="f" method="post" action="">
<table width="1102" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#F2F2F2" bgcolor="#cedee1" class="txtnormal2">
          <tr>
		    <td height="24" colspan="8" align="center" valign="middle" style="background:#cedee1;" >
            
            <table width="819" border="0" cellpadding="0" cellspacing="0">
<tr>
                  <td width="250"><span class="txtnormal3n">
                    <input type="text" name="ficha" id="ficha" />
                  <input name="busca" type="submit" class="boton_bus" id="busca" value="Buscar"/>
                  </span></td>
                  <td width="448" align="center" class="txtnormal3n">                  VACACIONES</td>
                  <td width="121" align="right">&nbsp;</td>
              </tr>
              </table>	        </td>
    <tr>
          <td width="4%" height="24" class="txtnormaln">ITEM</td>
          <td width="7%" class="txtnormaln">FICHA</td>
          <td width="25%" class="txtnormaln">NOMBRE</td>
          <td width="14%" class="txtnormaln">INGRESO</td>      
          <td width="17%" class="txtnormaln">DESDE</td>
          <td width="14%" class="txtnormaln">HASTA</td>
          <td width="6%" class="txtnormaln">ESTADO</td>
          <td width="7%" class="txtnormaln">DIAS SOL</td>
          <td width="6%" class="txtnormaln">DIAS AP</td>
      <?php
/***********************************************************************************************************************
										MOSTRAMOS LOS PRODUCTOS CONSULTADOS
***********************************************************************************************************************/	
	$co=mssql_connect("$SERVER","$USR","$PASS") or die("NO SE PUEDE CONECTAR A LA BASE DE DATOS"); 
	mssql_select_db("$BDATOS", $co);

	//$sql 	= "SELECT TOP 10 iw_tprod.DesProd FROM softland.iw_tprod WHERE iw_tprod.DesProd LIKE 'TERMINAL%' ";
	//$sql 	= "SELECT * FROM softland.sw_personal, softland.sw_vacsolic WHERE sw_vacsolic.Ficha = sw_personal.ficha and sw_personal.ficha = '138084795'";
	$sql 	= "SELECT * FROM softland.sw_personal, softland.sw_vacsolic WHERE sw_vacsolic.Ficha = sw_personal.ficha and sw_vacsolic.NDiasAp = '14'";
	$respuesta	= mssql_query($sql,$co);
	$color 		= "#ffffff";
	$i=1;
	$dias_utilizados = 0;
	
	while($vrows=mssql_fetch_assoc($respuesta))
	{
		$fecha = date_format($vrows['fechaIngreso'], 'Y-m-d');
				
		echo "<tr bgcolor=$color   onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000')>	
									<td bgcolor='#cedee1'>&nbsp;$i</td>
									<td>&nbsp;".$vrows['ficha']."</td>
									<td>&nbsp;".utf8_encode($vrows['nombres'])."</td>
									<td>&nbsp;".$vrows['fechaIngreso']."</td>
									<td>&nbsp;".$vrows['FsDesde']."</td>
									<td>&nbsp;".$vrows['FsHasta']."</td>
									<td>&nbsp;".$vrows['Estado']."</td>	
									<td>&nbsp;".$vrows['NDias']."</td>	
									<td>&nbsp;".$vrows['NDiasAp']."</td>
									</tr>";
									
									$diasdif = dias_de_diferencia_datetime(date("Y-m-d"), $vrows['fechaIngreso']);
									
									/*$fecha1 = explode("-", $vrows['fechaIngreso']);
									$dia 		= $fecha1[0]; // trozo1
									$mes 		= $fecha1[1]; // trozo2
									$anolargo 	= $fecha1[2]; // trozo2
									
									$anoa = explode(" ", $anolargo);
									$ano 		= $anoa[0]; // trozo1*/
									alert($diasdif);
									//alert("DIA: ".$dia." MES: ".$mes." AÑO: ".$ano);
									
									if($color == "#ffffff"){ $color = "#ededed"; }
									else{ $color = "#ffffff"; }
									//alert($vrows['fechaIngreso']);	
									$dias_utilizados = $dias_utilizados + $vrows['NDias'];
		$i++;			
	}	
			
?>
	<tr>
      <td height="30" colspan="9" class="txtnormaln" align="center"><?php echo "Total Dias: ".$dias_utilizados; ?>&nbsp;</td>
    </tr>
	<tr>
	  <td height="30" colspan="9" align="center" class="txtnormaln"><?php echo "Dias Utilizados: ".$dias_utilizados; ?>&nbsp;</td>
    </tr>
    <tr>
	  <td height="30" colspan="9" align="center" class="txtnormaln"><?php echo "Dias Disponibles: ".$dias_utilizados; ?>&nbsp;</td>
    </tr>
        </table>

</form>
</body>
</html>