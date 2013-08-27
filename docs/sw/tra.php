<?php 	
	$SERVER		= "190.151.75.146";
	$USR		= "consulta";
	$PASS		= "Con5ulta";
	$BDATOS		= "MGYT3";
	/*$SERVER		= "localhost";
	$USR		= "sa";
	$PASS		= "sqlserverpass";
	$BDATOS		= "MGYT3";*/
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
<table width="1393" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#F2F2F2" bgcolor="#cedee1" class="txtnormal2">
          <tr>
		    <td height="43" colspan="8" align="center" valign="middle" style="background:#cedee1;" >
            
            <table width="1383" border="0" cellpadding="0" cellspacing="0">
<tr>
                  <td width="96"><img src="../imagenes/logo_96x52.png" width="96" height="52" /></td>
                  <td width="1204" align="center" class="txtnormal3n">TRABAJADORES MGYT</td>
                  <td width="83" align="right">&nbsp;</td>
              </tr>
              </table>	        </td>
    <tr>
	  <td width="3%" height="12" class="txtnormal">ITEM</td>
	  <td width="6%" class="txtnormal">TELEFONO</td>
      <td width="8%" class="txtnormal">RUT</td>
      <td width="24%" class="txtnormal">NOMBRE</td>
      <td width="8%" class="txtnormal"><span class="Estilo5">FECHA INGRESO</span></td>
      <td width="8%" class="txtnormal">VENCIMIENTO</td>
      <td width="33%" class="txtnormal">DIRECCION</td>
      <td width="10%" class="txtnormal">COMUNA</td>

	<tr>
	  <td width="3%" height="12" class="txtnormaln">&nbsp;</td>
	  <td width="6%" class="txtnormaln">&nbsp;</td>
	  <td width="8%" class="txtnormaln">&nbsp;</td>
	  <td width="24%" class="txtnormaln">
<?
	$co=mssql_connect("$SERVER","$USR","$PASS");
	mssql_select_db("$BDATOS", $co);
	
	if($cod_cc != "" ){$cod_cc = $_POST['c_cod_cc'];}
	if($cod_cc == "" ){$cod_cc = "Todos";}
?>
    <select name="c_cod_cc" id="c_cod_cc" style="font-size:10px;" onchange="evento();" >
<?php
//*******************************************************************************************************
		$sql_sol  = "SELECT sw_personal.nombres FROM softland.sw_personal ORDER BY sw_personal.nombres ";
								
		$respuesta = mssql_query($sql_sol,$co);
								
		while ($rows = mssql_fetch_assoc($respuesta)) 
		{
	    	$rs_cod[] = $rows;
		}
		$total_sol  = count($rs_cod);
								
		echo"<option selected='selected' value='$cod_cc'>$cod_cc</option>";
								
		if($cod_cc != "Todos"){
        	echo"<option value='Todos'>Todos</option>";
        }	
									
		for ($i = 0; $i < $total_sol; $i++)
		{
			echo "<option value='".$rs_cod[$i]['nombres']."'>".$rs_cod[$i]['nombres']."</option>";	
		}							
		?>
	</select>
        
        </td>
	  <td width="8%" class="txtnormaln">&nbsp;</td>
	  <td width="8%" class="txtnormaln">&nbsp;</td>
	  <td colspan="2" class="txtnormaln">&nbsp;</td>
    <tr>
      <td colspan="8" class="txtnormaln">&nbsp;</td>
      <?php
/***********************************************************************************************************************
										MOSTRAMOS LOS PRODUCTOS CONSULTADOS
***********************************************************************************************************************/	
	$co=mssql_connect("$SERVER","$USR","$PASS") or die("NO SE PUEDE CONECTAR A LA BASE DE DATOS"); 
	mssql_select_db("$BDATOS", $co);

	//$sql 	= "SELECT TOP 10 iw_tprod.DesProd FROM softland.iw_tprod WHERE iw_tprod.DesProd LIKE 'TERMINAL%' ";
	$sql 	= "SELECT * FROM softland.sw_personal ORDER BY sw_personal.nombres";
	
	$respuesta	= mssql_query($sql,$co);
	$color 		= "#ffffff";
	$i=1;
	while($vrows=mssql_fetch_assoc($respuesta))
	{
		$sql_p 	= "SELECT * FROM softland.socomunas WHERE socomunas.CodComuna = '".$vrows['codComuna']."' ";
		$res	= mssql_query($sql_p,$co);
		while($fila = mssql_fetch_assoc($res))
		{
			$NomComuna	= "".$fila['NomComuna']."";
		}
		
		echo "<tr bgcolor=$color   onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000')>	
									<td bgcolor='#cedee1'>&nbsp;$i</td>
									<td>&nbsp;".$vrows['telefono1']."</td>
									<td>&nbsp;".$vrows['rut']."</td>
									<td>&nbsp;".utf8_encode($vrows['nombres'])."</td>
									<td>&nbsp;".$vrows['fechaIngreso']."</td>	
									<td>&nbsp;".$vrows['fechaContratoV']."</td>	
									<td>&nbsp;".htmlentities($vrows['direccion'])."</td>	
									<td>&nbsp;".htmlentities($NomComuna)."</td>
									</tr>";
									
									if($color == "#ffffff"){ $color = "#ddeeee"; }
									else{ $color = "#ffffff"; }
		$i++;			
	}				
?>
    </tr>
	<tr>
	  <td height="46" colspan="8" align="center" class="txtnormaln">&nbsp;
      	<a href='trab_rep.php'><img src="../imagenes/botones/rep_excel.jpg" border="0" /></a>
      </td>
    </tr>
        </table>

</form>
</body>
</html>