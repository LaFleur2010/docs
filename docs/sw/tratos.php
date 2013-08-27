<?php 	
	/*$SERVER		= "192.168.2.7";
	$USR		= "sa";
	$PASS		= "SuperMoto";
	$BDATOS		= "MGYT3";*/
	$SERVER		= "localhost";
	$USR		= "sa";
	$PASS		= "sqlserverpass";
	$BDATOS		= "MGYT3";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Trabajadores</title>
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
		    <td height="24" colspan="7" align="center" valign="middle" style="background:#cedee1;" >
            
            <table width="819" border="0" cellpadding="0" cellspacing="0">
<tr>
                  <td width="139">&nbsp;</td>
                  <td width="624" align="center" class="txtnormal3n">TRABAJADORES</td>
                  <td width="138" align="right">&nbsp;</td>
              </tr>
              </table>	        </td>
    <tr>
			    <td width="3%" height="24" class="txtnormaln">ITEM</td>
	            <td width="8%" class="txtnormaln">CODIGO</td>
                <td width="11%" class="txtnormaln">RUT</td>
      <td width="29%" class="txtnormaln">NOMBRE</td>
      <td width="17%" class="txtnormaln"><span class="Estilo5">FECHA INGRESO</span></td>
      <td width="17%" class="txtnormaln">VENCIMIENTO</td>
      <td width="15%" class="txtnormaln">FECHA NAC.</td>
      <?php
/***********************************************************************************************************************
										MOSTRAMOS LOS PRODUCTOS CONSULTADOS
***********************************************************************************************************************/	
	$co=mssql_connect("$SERVER","$USR","$PASS") or die("NO SE PUEDE CONECTAR A LA BASE DE DATOS"); 
	mssql_select_db("$BDATOS", $co);

	//$sql 	= "SELECT TOP 10 iw_tprod.DesProd FROM softland.iw_tprod WHERE iw_tprod.DesProd LIKE 'TERMINAL%' ";
	$sql 	= "SELECT * FROM softland.sw_tratosper ";
	
	$respuesta	= mssql_query($sql,$co);
	$color 		= "#ffffff";
	$i=1;
	while($vrows=mssql_fetch_assoc($respuesta))
	{
		echo "<tr bgcolor=$color   onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000')>	
									<td bgcolor='#cedee1'>&nbsp;$i</td>
									<td>&nbsp;".$vrows['Ficha']."</td>
									<td>&nbsp;".$vrows['fecha']."</td>
									<td>&nbsp;".utf8_encode($vrows['Supervisor'])."</td>
									<td>&nbsp;".$vrows['Cantidad']."</td>	
									<td>&nbsp;".$vrows['Valor']."</td>	
									<td>&nbsp;".$vrows['MesLiq']."</td>
									</tr>";
									
									if($color == "#ffffff"){ $color = "#ededed"; }
									else{ $color = "#ffffff"; }
		$i++;			
	}				
?>
	<tr>
      <td colspan="7" class="txtnormaln">&nbsp;</td>
    </tr>
	<tr>
	  <td height="46" colspan="7" align="center" class="txtnormaln">&nbsp;</td>
    </tr>
        </table>

</form>
</body>
</html>