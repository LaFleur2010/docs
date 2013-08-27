<?
// Necesario para ver si la session esta activa  o si se tiene permiso de accseso
require("../lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php

if($_SESSION['usd_cot_lee'] != "1")
{
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}//Hasta aquí lo comun para todas las paginas restringidas
//********************************************************************************************************************************
	
//********************************************************************************************************************************

	include ('../inc/config_db.php'); 	// Incluimos archivo de configuracion de la conexion
	include ('../inc/lib.db.php');		// Incluimos archivo de liobreria de funsiones PHP
	
if($_POST['num_cot'] != "")
{
 	$num_cot = $_POST['num_cot'];
}
if($_POST['ods'] != "")
{
 	$num_cot = $_POST['ods'];
}
if($_POST['elimina'] != "")
{
 	$num_cot = $_POST['elimina'];
}

$origen = "COT";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documentos por C/L</title>
<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">

<!-- VENTANA MODAL -->
<script type="text/javascript" src="modal/js/ventana-modal-1.3.js"></script>
<script type="text/javascript" src="modal/js/abrir-ventana-variable.js"></script>
<script type="text/javascript" src="modal/js/abrir-ventana-fija.js"></script>
<script type="text/javascript" src="modal/js/abrir-ventana-fotos.js"></script>
<script type="text/javascript" src="modal/js/abrir-ventana-alertas.js"></script>
<script type="text/javascript" src="modal/js/abrir-ventana-cargando.js"></script>
<link href="modal/css/ventana-modal.css" rel="stylesheet" type="text/css">
<link href="modal/css/style.css" rel="stylesheet" type="text/css">
<!-- FIN VENTANA MODAL -->


<style type="text/css">
<!--
body {
	background-color: #527eab;
}
.Estilo2 {color: #000000}
-->

</style>

<script type="text/javascript" language="JavaScript" src="../inc/funciones.js"></script>

<script language="javascript">

function CambiaColor(esto,fondo,texto)
{
    esto.style.background=fondo;
    esto.style.color=texto;
	esto.style.cursor='hand';
}

function eliminar()
{
	var agree=confirm("Esta Seguro de Querer Eliminar Este Documento ?");
	if (agree){
		document.f.action='ieliminar_doc.php'; 
		document.f.submit();
		return true ;
	}else{
		return false ;
	}
}

function actualizar()
{
	document.form1.submit();
	VentanaModal.cerrar();
}

function enviar(url)
{
	document.form1.action=url;
}

function volver(url)
{
	var ods_v 	=	document.form1.ods.value;
	document.form1.action	=	url+'?cod='+ods_v;
	document.form1.submit();
}
</script>
</head>

<body>
<table width="944" height="565" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F2F2F2">
	<tr>
   		<td width="100" height="54" align="center" valign="top"><img src="../imagenes/logo2.jpg" width="127" height="60" /></a>        </td>
	  <td width="744" align="center" valign="middle" bgcolor="#FFFFFF" class="txt01">DOCUMENTOS POR COTIZACION/LICITACION</td>
   		<td width="100" align="center" valign="top"><img src="../imagenes/logo_iso_c.jpg" width="108" height="58" /></td>
	</tr>
  	<tr>
    	<td height="7" colspan="3" align="center" valign="top"><img src="../imagenes/barra.gif" width="100%" height="3" /></td>
  	</tr>
  	<tr>
    	<td height="485" colspan="3" align="center" valign="top">
        <form id="form1" name="form1" method="post" action="">
    <table width="930" height="316" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
    <tr>
     	<td height="17" align="center" valign="middle">
        
        <table width="917" height="54" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor=<?php echo $ColorMotivo; ?>>
    <tr>
        <td align="center"><table width="892" height="50" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="136"><span class="txt01">
                    <input name="vuelve" type="submit" class="boton_volver" id="vuelve" value="Volver" onclick="volver('cotizaciones.php')" />
                    <input type="hidden" name="ods" id="ods" value="<?php echo $num_cot; ?>" />
                    <input type="hidden" name="usuario_nombre" id="usuario_nombre" value="<?php echo $_SESSION['usuario_nombre']; ?> " />
                  </span></td>
                  <td width="100"><span class="txt01">
                    <input name="Volver4" type="submit" class="boton_actualizar" id="Volver4" value="Actualizar" />
                  </span></td>
                  <td width="432" align="center"><span class="txtrojo">
                    <input type="hidden" name="msj" id="msj" value="" />
                    <?php echo $_POST['msj']; ?><span class="txt01"><?php echo "COTIZACION/LICITACION  ".$num_cot; ?></span></span></td>
                  <td width="125">&nbsp;</td>
                  <td width="99"><span class="txt01">
                    <input type="button" class="boton_subir" name="nitem" value="Subir Documet." 
                    onclick="abrirVentanaFija('../subir.php?ods=<?php echo $num_cot; ?>&usuario=<?php echo $_SESSION['usuario_nombre']; ?>&origen=<?php echo $origen; ?>', 700, 550, 'ventana', 'Subir documentos a la carpeta de la ODS')"/>
                  </span></td>
                </tr>
              </table></td>
            </tr>
          </table>            <label></label></td>
          </tr>
        <tr>
          <td height="238" align="center" valign="top"><table width="917" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CEDEE1" class="txtnormal2">
            <tr>
              <td width="4%" bordercolor="#FFFFFF" bgcolor="#cedee1" class="txtnormal"><span class="Estilo2">&nbsp;Nº</span></td>
              <td width="59%" bordercolor="#FFFFFF" bgcolor="#cedee1" class="txtnormal"><span class="Estilo2">&nbsp;NOMBRE DE ARCHIVO</span></td>
              <td width="18%" bordercolor="#FFFFFF" bgcolor="#cedee1" class="txtnormal"><span class="Estilo2">&nbsp;SUBIDO POR</span></td>
              <td width="10%" bordercolor="#FFFFFF" bgcolor="#cedee1" class="txtnormal">FECHA SUB</td>
              <td width="9%" bordercolor="#FFFFFF" bgcolor="#cedee1" class="txtnormal">ELIMINAR</td>
              <?php
$dir 		= "Carpetas/".$num_cot; 
$directorio	= opendir($dir); 
  
while ($archivo = readdir($directorio)) {  
  if($archivo != '.' and $archivo != '..' and $archivo != "Thumbs.db"){
  if(is_dir("$dir/$archivo")) 
  
    echo "<a href=\"?dir=$dir/$archivo\"><img src='../imagenes/carpeta.gif' border='0'/><b>$archivo</b><br></a>";
  }
}  
closedir($directorio); 
?>
<?php
	$directorio = $dir."/";
	$carpeta 	= basename($dir); 
	$cad_may 	= strtoupper($carpeta);
	$num		= 1;

	$co = mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sql="SELECT * FROM documentos WHERE nivel_doc >= '".$_SESSION['usuario_nivel']."' AND ruta_doc='$directorio' ORDER BY nom_doc";
	$respuesta=mysql_query($sql,$co);
	$color="#ffffff";
	while($vrows=mysql_fetch_array($respuesta))
	{
		$id_doc		= $vrows['id_doc'];
		$rutac_doc	= htmlentities($vrows['rutac_doc']);
		$rutaeli_doc= htmlentities("Licitaciones/".$vrows['rutac_doc']);
		$nom		= $vrows['nom_doc'];
		$rutt		= $vrows['rutac_doc'];
		$rutacom	= pathinfo($rutt); 
		$ext		= $rutacom['extension'];
		$na			= $ext;
		$nombre		= basename("$nom", ".$ext");
		$fe 		= $vrows['fecha_sub'];
		$fe			= cambiarFecha($fe, '-', '/' );
		
		echo("<tr bgcolor=$color   onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000')>	
		<td bgcolor='#cedee1'>&nbsp;$num</td>");
		echo("<td><a href='$rutac_doc' target='blank'><img src='imagenes/na.png' border='0'/>&nbsp;&nbsp;$nombre</a></td>
							<td>&nbsp;&nbsp;".$vrows['sub_por']."</td>
							<td>&nbsp;&nbsp;$fe</td>
							<td bgcolor='#cedee1'><a href='../ieliminar_doc.php?id=$id_doc&ods=$num_cot&ruta=$rutaeli_doc&origen=$origen' onclick='return eliminar()'><img src='imagenes/remove.png' border='0' valign='top'/>Eliminar</a></td>
							</tr> ");
							
							if($color == "#ffffff"){ $color = "#ededed"; }
							else{ $color = "#ffffff"; }
							
							$num++;			
	}
?>
            </tr>
          </table></td>
        </tr>
      </table>
        </form>    </td>
  </tr>
  <tr>
    <td height="7" colspan="3" align="center" valign="top"><img src="../imagenes/barra.gif" width="100%" height="3" /></td>
  </tr>
</table>
</body>
</html>
