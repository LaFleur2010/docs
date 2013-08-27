<?php
	$p_sol 	= "Todos";
	$est    = "Todos";
	$ods    = "Todos";
	$cc     = "Todos";
	$area   = "Todos";
	$f_sol  = "Todos";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8"/>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Listado de Solicitudes</title>

<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="ajax.paginacion.js"></script>

<script type="text/javascript">

function CambiaColor(esto,fondo,texto)
{
    esto.style.background=fondo;
    esto.style.color=texto;
	esto.style.cursor='hand'
}

function enviar(url)
{
	document.f.action=url;
}

</script>

<style type="text/css">
<!--
body {
	background-color: #527eab;
	margin-top: 15px;
}
.Estilo5 {color: #000000}
-->
ul    						{ border:0; margin:0; padding:0; }
#pagination-digg li          { border:1; margin:0; padding:0; font-size:11px; list-style:none; /* savers */ float:left; }
#pagination-digg a           { border:solid 1px #9aafe5; margin-right:2px; }
#pagination-digg .previous-off,
#pagination-digg .next-off   { border:solid 1px #DEDEDE; color:#888888; display:block; float:left; font-weight:bold; margin-right:2px; padding:3px 4px; }
#pagination-digg .next a,
#pagination-digg .previous a { font-weight:bold; }
#pagination-digg .active     { background:#2e6ab1; color:#FFFFFF; font-weight:bold; display:block; float:left; padding:4px 6px; /* savers */ margin-right:2px; }
#pagination-digg a:link,
#pagination-digg a:visited   { color:#0e509e; display:block; float:left; padding:3px 6px; text-decoration:none; }
#pagination-digg a:hover     { border:solid 1px #0e509e; }
</style>

</head>

<body>
<table width="1447" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="1447" align="center">
    
    <div style="width:1496;text-align:center;">
    
      <table width="1496" border="1" bordercolor="#F2F2F2" bgcolor="#FFFFFF" class="txtnormal" cellspacing="0" cellpadding="0">
        <tr>
          <td width="1496" height="65" align="center">
          
          <form name="f" method="post">
          
          <table width="1493" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100"><a href="index2.php"><img src="../images/logo_c.jpg" alt="" width="100" height="60" border="0" /></a></td>
              <td width="90"><input name="Volver2" type="submit" class="boton_volver" id="Volver2" value="Volver" onclick="enviar('../sol_rec.php')" /></td>
              <td width="84"><input name="Volver4" type="submit" class="boton_actualizar" id="Volver4" value="Actualizar" /></td>
              <td width="850" align="center"><img src="../imagenes/Titulos/Lista_FSR.png" width="500" height="47" /></td>
              <td width="108"><!-- <input name="Volver" type="submit" class="boton_excel" id="Volver" value="Exportar a Excel" onclick="enviar('../rep_excel_fsr.php')" />--></td>
              <td width="114">&nbsp;</td>
              <td width="100"><img src="../imagenes/logo_iso_c.jpg" alt="" width="100" height="52"/></td>
            </tr>
          </table>
          </form>
          </td>
        </tr>
      </table>
      
      <div id="contenido">
      
        <?php include('paginador.php')?>
     
      </div>
      
    </div></td>
  </tr>
</table>
</body>
</html>
