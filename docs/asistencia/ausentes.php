<?php
	include ('inc/config_db.php');
	require('inc/lib.db.php');
	
	$nom_p		= $_GET['nom_p'];
	$cod_p		= $_GET['cod_p'];
	$cod_eq 	= "Automatico";
	$cont_eq 	= "--- Seleccione Area ---";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Detalle de Ausentes</title>

<link href="inc/bibliocss.css" rel="stylesheet" type="text/css">

<script type="text/javascript" language="JavaScript1.2" src="stmenu.js"></script>

<script LANGUAGE="JavaScript">

function CambiaColor(esto,fondo,texto)
 {
    esto.style.background=fondo;
    esto.style.color=texto;
 }
 
 function mod()
{
var agree=confirm("Esta Seguro de Querer Modificar Este Registro ?");
if (agree)
	return true ;
else
	return false ;
}

function eli()
{
var agree=confirm("Esta Seguro de Querer Eliminar Este Registro ?");
if (agree)
	return true ;
else
	return false ;
}

function ing()
{
	var c1	= document.fitem.c1.value;

	if(c1 != "" && c1 != "--- Seleccione Area ---")
	{
		var agree=confirm("Esta Seguro de Querer ingresar Este Registro ?");
		if (agree)
			return true ;
		else
			return false ;
	}else{
		alert("Selecione Area");
		return false ;
	}
}

</SCRIPT>

<style type="text/css">
<!--
body {
	background-color: #999999;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo11 {font-family: Arial, Helvetica, sans-serif}
.Estilo12 {color: #FF0000}
-->
</style>
</head>
<body> 

<table width="744" height="292" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="744" height="40" align="center" valign="top"><table width="742" height="36" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="73" height="32" align="center"><img src="imagenes/logo_mgyt_c.jpg" width="70" height="30" border="0" /></td>
          <td width="601" align="center"><table width="433" border="0" cellpadding="0" cellspacing="0" class="txt01">
            <tr>
              <td width="433" height="16" align="center"><span class="Estilo11">DETALLE DE <?php echo strtoupper($_GET['tipo']); ?></span></td>
            </tr>
          </table></td>
          <td width="68" align="center"><img src="imagenes/logo_iso_c.jpg" width="68" height="27" /></td>
        </tr>
      </table>      
    </td>
  </tr>
  
  <tr>
    <td height="252" align="center" valign="top">
    
    <table width="732" height="235" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
      <tr>
        <td width="732" height="235" align="center" valign="top">
        
            <form name="fitem" action="" method="POST">
              <table width="737" border="1" bordercolor="#FFFFFF" bgcolor="#999999" class="txtnormal2">
              <tr>
                <td width="5%" bgcolor="#527eab" class="txtnormaln">ITEM</td>
                <td width="27%" bgcolor="#527eab" class="txtnormaln">NOMBRE</td>
                <td width="24%" bgcolor="#527eab" class="txtnormaln">AREA</td>
                <td width="44%" bgcolor="#527eab" class="txtnormaln">NOTA</td>
<? 
$_POST['t2'] = ucwords($_POST['t2']);
/***********************************************************************************************************************

***********************************************************************************************************************/	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sql="SELECT * FROM asistencia, detalle_as WHERE detalle_as.motivo_det_as = '".$_GET['tipo']."' and asistencia.fecha_as = '".$_GET['fecha']."' and asistencia.cod_as = detalle_as.cod_as ";
	
	$respuesta=mysql_query($sql,$co);
	$color="#FFFFFF";
	$i=1;
	while($vrows=mysql_fetch_array($respuesta))
	{
		$rut_t			= "".$vrows['rut_det_as']."";
		$observ_det_as	= "".$vrows['observ_det_as']."";
		
		$sqlt	= "SELECT * FROM trabajadores_a, tb_areas WHERE trabajadores_a.area_t = tb_areas.cod_ar and trabajadores_a.rut_t = '$rut_t' ";
		$resp	= mysql_query($sqlt,$co);
		
		while($vrowst=mysql_fetch_array($resp))
		{	
			$nom_t			= "".$vrowst['nom_t']."";
			$app_t			= "".$vrowst['app_t']."";
			$apm_t			= "".$vrowst['apm_t']."";
			$desc_ar		= "".$vrowst['desc_ar']."";
		}
		
		echo("<tr bgcolor=$color   onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'#ffffff','#000000')>	
									<td bgcolor='#cedee1'><b>&nbsp;$i<b></td>
									<td>&nbsp;".$nom_t." ".$app_t." ".$apm_t."</td>	
									<td>&nbsp;$desc_ar</td>
									<td>&nbsp;$observ_det_as</td>	
									</tr> ");
		$i++;
		}	

?>
              </tr>
            </table>
            </form>
        
        </td>
      </tr>
    </table>    </td>
  </tr>
</table>
</body>
</html>