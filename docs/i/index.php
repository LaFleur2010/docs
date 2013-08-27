<?
  // No almacenar en el cache del navegador esta página.
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");             		// Expira en fecha pasada
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");		// Siempre página modificada
		header("Cache-Control: no-cache, must-revalidate");           		// HTTP/1.1
		header("Pragma: no-cache");  
		 
		include('../inc/lib.db.php');                                		// HTTP/1.0


?>
<html>
<head>

<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="css/style.css" />

<? if (isset($_GET['estado'])){
		$url  = explode("?",$_SERVER['URL']);
		$host = $_SERVER['SERVER_NAME'];
		$pag  = $url[0];
	    print "<META http-equiv=REFRESH content=\"5; URL=http://$host$pag;\">";
} ?>

<title>Intranet Rockmine</title>
<base target="_self">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" language="JavaScript" src="../inc/funciones.js"></script>

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

  <!-- PNG Fix Script Starts Here -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.pngFix.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).pngFix();
    });
</script>
<!-- PNG Fix Script Ends Here -->

  
  <!--[if lt IE 8.]>
<link rel="stylesheet" type="text/css" href="css/style-ie.css" />
<![endif]-->
 <!--[if lt IE 7.]>
<link rel="stylesheet" type="text/css" href="css/style-ie6.css" />
<![endif]-->


<!-- Content Slider -->
<script type="text/javascript" src="js/swfobject/swfobject.js"></script>
<script type="text/javascript">
		var flashvars = {};
		flashvars.xml = "config.xml";
		flashvars.font = "font.swf";
		var attributes = {};
		attributes.wmode = "transparent";
		attributes.id = "slider";
		swfobject.embedSWF("animacion5.swf", "content_slider", "575", "265", "9", "expressInstall.swf", flashvars, attributes);
		
function enviar(url)
{
	document.f2.action=url;
	//document.f2.target='_blank';
	document.f2.submit();
}

function enviar3()
{
  document.location.href='../../../encuesta';
}
function soport(){
  document.location.href='http://intranet.softtime.cl/soporte/upload/index.php';
}
function enviar2()
{
	document.location.href='http://www.google.cl';
}
function foco()
{
	document.f.user.focus();
}
function Abrir_nueva_vantana(URL)
{
	abrirVentanaM(URL,"yes");
}

$(document).ready(function(){

	$(".menux a").hover(function() {
		$(this).next("em").animate({opacity: "show", top: "-70"}, "slow");
	}, function() {
		$(this).next("em").animate({opacity: "hide", top: "-115"}, "fast");
	});


});

</script>

<!-- Content Slider -->
<style type="text/css">
<!--
body {
	background-color: ;
}
.textbox {
	BORDER: #000000 1px solid; 
	height:15px;
	width:120px;
	font-size:10px;
}

.menux {
	PADDING-BOTTOM: 0px; LIST-STYLE-TYPE: none; MARGIN: 05px 0px 0px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; LIST-STYLE-IMAGE: none; PADDING-TOP: 0px
}
.menux LI {
	POSITION: relative; TEXT-ALIGN: center; PADDING-BOTTOM: 0px; MARGIN: 0px 2px; PADDING-LEFT: 0px; PADDING-RIGHT: 0px; FLOAT: left; PADDING-TOP: 0px
}
.menux A {
	PADDING-BOTTOM: 14px; PADDING-LEFT: 10px; WIDTH: 144px; PADDING-RIGHT: 10px; DISPLAY: block; COLOR: #FFFFFF; FONT-WEIGHT: bold; TEXT-DECORATION: none; PADDING-TOP: 14px
}
.menux LI EM {
	Z-INDEX: 2; POSITION: absolute; TEXT-ALIGN: center; PADDING-BOTTOM: 26px; FONT-STYLE: normal; PADDING-LEFT: 10px; WIDTH: 180px; PADDING-RIGHT: 12px; DISPLAY: none; BACKGROUND: url(images/fdo_tex.png) no-repeat; HEIGHT: 45px; TOP: -85px; PADDING-TOP: 20px; LEFT: -15px;font-size:11px;color:#000000; border:0px;
}
-->
</style>

</head>

<body onLoad="foco()">

<!-- Main Body Starts Here -->
<div class="txtnormal2" id="main_body">

<!-- Header Starts Here -->
<div id="header">

<!-- Header Top -->
<div id="header_top">
</div>
<!-- Header Top -->

<!-- Header Body Starts Here -->
<div id="header_body">

<!-- Header Left Part Starts Here -->
<div id="header_left">
<!-- Logo Starts Here-->
<div id="logo"><img src="images/Titulo.png" width="300" height="65"></div>
<!-- Logo Ends Here -->

<!-- Divider Starts Here -->
<div id="logo_divider">
<img src="images/logo_divider.png"/>
</div>
<!-- Divider Ends Here -->

<!-- Menu Links Starts Here -->
<div id="menum">
  <table width="300" border="0">
    <tr>
      <td align="center"><p>&nbsp;</p>
        <p><img src="../imagenes/rockmine.png" ></p></td>
    </tr>
  </table>


</div>
<!-- Menu Links Ends Here -->

</div>
<!-- Header Left Part Ends Here -->

<!-- Header Right Part Starts Here-->
<div id="header_right">

<!-- Content Slider Starts Here -->
<div id="slider_shadow">
<div id="content_slider">
<!-- <a href="http://www.adobe.com/go/getflashplayer">
        <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
    </a>-->
 </div>    
</div>
<!-- Content Slider Ends Here -->

</div>
<!-- Header Right Part Ends Here -->

</div>
<!-- Header Body Ends Here -->

<!-- Header Bottom-->
<div id="header_bottom">
</div>
<!-- Header Bottom -->

</div>
<!-- Header Ends here -->

<!-- Content Body Starts here -->
<div id="content_body">

<!-- Left Content Starts Here -->
<div id="left_content">
<!-- Heading -->
<p class="headings">
  MENU DE APLICACIONES</p>
<!-- Heading -->
<form name="f2" method="post" action="">
<UL class=menux>

  <table width="566" border="0">
    <tr>
      <td width="184" height="100" align="center">
      
      
      <LI><A href="">
        <input name="button" type="button" class="boton_google" id="button" value="Ir a Google" onClick="enviar2('http://www.google.cl')"/>
        </A> 
      <EM>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ir a la página principal de Google&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</EM> 
      </LI>
      
      
      </td>
      <td width="184" align="center">
      
      
      
      <LI><A href="#">
        <input name="button4" type="button" class="boton_cc" id="button4" value="Centros de costo" onClick="abrirVentanaFijaSr('../lista_cc.php', 850, 500, 'ventana', 'Centros de costo Softtime')" /></A> 
      <EM>Listado de centros de costos actualizados desde Softland</EM> 
      </LI>
      
      
      </td>
      <td width="184" align="center">
      
      <LI><A href="#">
        <input name="button5" type="button" class="boton_biblio" id="button5" value="Biblioteca Digital" onClick="enviar('http://biblioteca.mgyt.cl')"/>
        </A> 
      <EM>Acceso a biblioteca digital y registros del sistema de gestion integrado</EM> 
      </LI>
      
      </td>
    </tr>
    <tr>
      <td height="122" align="center">
      
      
      <LI><A href="#">
        <input name="button2" type="button" class="boton_politica" id="button2" value="Politica Integral 2012" onClick="Abrir_nueva_vantana('../politica_2012.pdf')"/>
        </A> 
      <EM>Ver política integral de Industrial y Comercial MGYT</EM> 
      </LI>
      
      </td>
      <td align="center">
      
      
       
       <LI>
        <a href="#">
        <!-- <input name="button6" type="button" class="boton_encuesta" id="button6" value="Encuesta" onclick="enviar3();" />-->
       <input name="button3" type="button" class="boton_sop" id="button3" onclick="soport();" value="Soporte"/>
       </a>
      <EM><br>Soporte<br></EM> 
      </LI>
      
      
           
      </td>
      <td align="center">
      
      
      <LI><A href="#">
        <input name="button3" type="button" class="boton_disponible" id="button3" value="Disponible"  onclick="javascript: alert('En Proceso...')"/></A> 
      <EM>&nbsp;<br>Boton disponible<br></EM> 
      </LI>
      
      
      </td>
    </tr>
    <tr>
      <td colspan="3" align="center">&nbsp;</td>
    </tr>
  </table>
  </UL>
</form>
</div>
<!-- Left Content Ends Here -->

<!-- Right Content Starts Here -->
<div id="right_content">

<!-- Testimonial Starts Here -->
<!-- Heading -->
<p class="headings">VALIDACION DE USUARIO</p>
<div id="follow_us2">
        <? 
		if (!isset($_GET['estado'])){ //Entramos
        
        	//cargamos configuracion
		   include ("..//lg/lg_config.php");
		?>
    <form action="<?=$pag_inicial;?>" target="_top" method="post" name="f">
    
      <table width="283" border="0" cellspacing="0" class="txtnormal2">
        <tr>
          <td><span class="headings"><img src="images/usu.png" alt="" width="37" height="44" /></span></td>
          <td><label for="textfield2"><span class="headings">Login de usuario </span></label></td>
        </tr>
        <tr>
          <td colspan="2" align="center"><?
			 // Mostrar error de Autentificaci&oacute;n.
			include ("../lg/lg_errores.php");  //Contiene los mensajes de error
			if (isset($_GET['error_login']))
			{
				 $error=$_GET['error_login'];
				 echo "<font color='#FF0000'>Error: $error_login_ms[$error]</font>";
         	}
        ?></td>
          </tr>
        <tr>
          <td>Usuario:</td>
          <td><input name="user" type="text" class="cajas" size="20" /></td>
        </tr>
        <tr>
          <td>Password:</td>
          <td><label for="textfield3"></label>
            <input name="pass" type="password" class="cajas" size="20" /></td>
        </tr>
        <tr>
          <td colspan="2" align="center"><span class="txtnormal3n">
         <? }else{  //Nos vamos
				echo "<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sesi&oacute;n cerrada";
			}?>
          </span></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input name="submit" type="submit" value="  Ingresar  " bgcolor="#0099FF" /></td>
        </tr>
        <tr>
          <td height="25"><span>
            <?php
  $fecha1 = "2013-03-09";
  $fecha2 = date("Y-m-d");
  $CantDias = calcula_fecha($fecha1,$fecha2);
  
  ?>
          </span></td>
          <td>&nbsp;</td>
        </tr>
      </table>
    </form>

  </div>
<!-- Heading --><!-- Testimonial Ends Here -->

<!-- Follow Us Starts Here -->
<div id="follow_us">

<!-- Heading -->
<p class="headings">INDICADORES DE SEGURIDAD</p>
<table width="288" height="61" border="0" cellpadding="0" cellspacing="0" class="txtnormal2" >
  <tr>
    <td height="20" align="left">LLEVAMOS:</td>
    <td height="20" align="left"><strong><?php echo $CantDias; ?></strong></td>
    <td height="20" align="left">Dias sin accidentes</td>
  </tr>
  <tr>
    <td width="133" height="19" align="left">META:</td>
    <td width="34" align="left"><strong>000</strong></td>
    <td width="121" align="left">Dias</td>
  </tr>
  <tr>
    <td height="22" align="left">RECORD ANTERIOR: </td>
    <td height="22" align="left"><strong>319</strong></td>
    <td height="22" align="left">Dias</td>
  </tr>
</table>
<p>&nbsp;</p>
</div>
<!-- Follow Us Ends Here -->

<!-- Download Brochure Button Starts Here --></div>
<!-- Right Content Ends Here -->

<!-- Clear -->
<div class="clear">
</div>
<!-- Clear -->

</div>
<!-- Content Body Ends Here -->

<!-- Footer Starts Here -->

<!-- Top --><!-- Content -->
<div id="footer_content">
<div class="left">
<a href="http://www.google.cl" target="_blank">www.google.cl</a> <span>|</span> 
<a href="http://www.softtime.cl" target="_blank">www.softtime.cl</a> <span>|</span> 
<a href="http://www.rockminesa.cl" target="_blank">www.rockminesa.cl</a> <span>|</span> 
<a href="http://www.bci.cl" target="_blank">www.bci.cl</a> <span>|</span>
<a href="http://www.qmarket.cl">www.qmarket.cl</a> <span>|</span> 
<a href="http://www.portalminero.com/" target="_blank">Portal Minero</a> <span>|</span> 
<a href="../politica_2011.pdf" target="_blank">Politica integral 2012</a> <span>|</span> 
</div>

<div  class="right"> &copy; Copyright 2012. Rockmine S.A.</div>

<!-- Clear -->
<div class="clear">
</div>
<!-- Clear -->


</div>
<!-- Content -->

<!-- Bottom -->
<div id="footer_bottom_bg">
</div>


<!-- Footer Ends Here -->

</div>
<!-- Main Body Ends Here -->

 </body>
</html>