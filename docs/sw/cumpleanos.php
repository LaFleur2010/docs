<?php 	
	$SERVER		= "192.168.2.7";
	$USR		= "consulta";
	$PASS		= "Con5ulta";
	$BDATOS		= "MGYT3";
	$mesact		= date("m");
	$hoy		= date("d-m-Y ");

	include('../inc/lib.db.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cumpleaños del mes</title>
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
<table width="816" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#F2F2F2" bgcolor="#cedee1" class="txtnormal2">
          <tr>
		    <td height="43" colspan="4" align="center" valign="middle" style="background:#cedee1;" >
            
            <table width="810" border="0" cellpadding="0" cellspacing="0">
<tr>
                  <td width="96"><img src="../imagenes/logo_96x52.png" width="96" height="52" /></td>
                  <td width="636" align="center" class="txtnormal3n">CUMPLEAÑOS DEL MES <?php echo " Fecha de hoy: ".$hoy ?></td>
                  <td width="78" align="right">&nbsp;</td>
              </tr>
              </table>	        </td>
    <tr>
	  <td width="4%" height="12" class="txtnormal">ITEM</td>
	  <td width="60%" class="txtnormal">NOMBRE</td>
      <td width="17%" class="txtnormal"><span class="Estilo5">FECHA NACIMIENTO</span></td>
      <td width="19%" class="txtnormal">TERMINO CONTRATO</td>
    <tr>
      <td colspan="4" class="txtnormaln">&nbsp;</td>
      <?php
	  
/***********************************************************************************************************************
										MOSTRAMOS LOS PRODUCTOS CONSULTADOS
***********************************************************************************************************************/	
	$co=mssql_connect("$SERVER","$USR","$PASS") or die("NO SE PUEDE CONECTAR A LA BASE DE DATOS"); 
	mssql_select_db("$BDATOS", $co);
	alert($hoy);
	//$sql 	= "SELECT TOP 10 iw_tprod.DesProd FROM softland.iw_tprod WHERE iw_tprod.DesProd LIKE 'TERMINAL%' ";
	$sql 	= "SELECT * FROM softland.sw_personal WHERE sw_personal.FecTermContrato >= $hoy ORDER BY sw_personal.fechaNacimient";
	
	$respuesta	= mssql_query($sql,$co);
	$color 		= "#ffffff";
	$i=1;
	while($vrows=mssql_fetch_assoc($respuesta))
	{		
		$nac	= "".$vrows['fechaNacimient']."";
		$term	= "".$vrows['FecTermContrato']."";
		
		$fecha	= explode("-", $nac);

		$mes 	= $fecha[1]; // trozo2
		
		if($mesact == $mes)
		{
			echo "<tr bgcolor=$color onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000')>	
					<td bgcolor='#cedee1'>&nbsp;$i</td>
					<td>&nbsp;".utf8_encode($vrows['nombres'])."</td>
					<td>&nbsp;$nac</td>	
					<td>&nbsp;$term</td>	
			  </tr>";
		}
									
		if($color == "#ffffff"){ $color = "#ddeeee"; }
		else{ $color = "#ffffff"; }
		
		$i++;			
	}				
?>
    </tr>
	<tr>
	  <td height="46" colspan="4" align="center" class="txtnormaln">&nbsp;</td>
    </tr>
        </table>

</form>
</body>
</html>