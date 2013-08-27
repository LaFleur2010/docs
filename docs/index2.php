<?
// Necesario para ver si la session esta activa  o si se tiene permiso de accseso
require("lg/lg_controlar.php");
include("ip_isp.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php
//
//Definimos el nivel de acceso  (esto es un bonus track para definir que ciertos usuarios puedan entrar a algunas paginas y a otras no)
// Si los usuarios normales tienen acceso=10, para que  accedan todos los usuarios le damos acceso mayor a 10.
$estado = detecta_usuario();

if($estado != "Aceptado" and $_SESSION['us_ing_internet'] == "No")
{
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}else{
	if ($_SESSION['us_ing_internet'] == "No" )
	{
		header ("Location: $redir?error_login=5");
		exit; //Como no podemos entrar nos vamos de esta página.
	}
}
include('inc/config_db.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<!-- <meta http-equiv="X-UA-Compatible" content="IE=9" />-->
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Produccion Rockmine</title>

<link href="inc/bibliocss.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	background-color: <? echo $ColorFondo; ?>;
}
.Estilo1 {font-size: 9px}

.slideshow { height: 350px; width: 560px; }
.slideshow img { padding: 10px; border: 1px solid #ccc; background-color: #eee; }
-->
</style>

<script type="text/javascript" language="JavaScript" src="inc/funciones.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="inc/stmenu.js"></script>

<script type="text/javascript" language="JavaScript">

function Abrir_nueva_vantana(URL)
{
	abrirVentanaM(URL,"yes");
}

function salir()
{
	var agree=confirm("Esta Seguro de Querer Salir de la aplicacion ?");
	if (agree)
		document.form1.action="lg/lg_logout.php";
	else
		return false ;
	
}

function enviar(url)
{
	document.form1.action=url;
}
</script>


</head>

<body <?
// Esto es un bonus track para mostrar un mensaje de error si la pagina siguiente nos devolvio por no tener nivel de acceso
include ("lg/lg_errores.php");  //Contiene los mensajes de error
if($_GET['error_login']==5) {
	$error=$_GET['error_login'];
	echo "onload='alert(\"$error_login_ms[$error]\");'";
	unset($_GET["error_login"]);
	unset($_GET['error_login']);
	unset($error);
	$_GET['error_login']="" ;
}
?> >

<table width="944" height="645" border="0" align="center" cellpadding="0" cellspacing="0" background="imagenes/f.png">
  <tr>
    <td height="29" align="center" valign="top"><img src="imagenes/barra_sup.png" width="100%" height="24" /></td>
  </tr>
  <tr>
    <td height="108" align="center" valign="top"><img src="imagenes/banner.jpg" width="944" height="80" /></td>
  </tr>
 <tr>
   <td height="12" align="center" valign="top">
          <ul id="menu">
            <li><a href="index2.php">Inicio</a></li>
            <li><a href="#">Ingenieria</a>
              <ul>
                <li><a href="sol_rec.php">Solicitud de Recursos</a>
                <ul>
                  <li><a href="lista_fsr_sap.php">Listado sin Aprobar</a></li>
                  <li><a href="lista_fsr.php">Historial de FSR</a></li>
                </li>
                </ul>
                <!--<li><a href="#">Disponible</a></li>
                <li><a href="#">Disponible</a></li>-->
              </ul>
            </li>
            <li><a href="#">Estudio</a>
              <ul>
                <li><a href="Licitaciones/cotizaciones.php">Cotizaciones/Licitaciones</a>
                  <ul>
                <li><a href="Licitaciones/listado.php">Listado</a></li>
                <li><a href="Licitaciones/lista_ter.php">Historial Cot/Lic</a></li>
              </li>
            </ul>
              </ul>
            </li>
            <li><a href="#">Supervisi&oacute;n</a>
              <ul>
                  <li><a href="inf_diario.php">Informe Diario</a></li>
                  <li><a href="asistencia/asistencia.php">Informe de Asistencia</a></li>
              </ul>
            </li>
            <li><a href="#" onclick="alert('En Proceso...');">RR.HH</a></li>
            <li><a href="#">Informatica</a>
              <ul>
                <li><a href="encuesta/index.php">Encuesta Online</a></li>
                <li><a href="http://informatica.softtime.cl">App. Web</a></li>
                <li><a href="http://intranet.softtime.cl/soporte/upload/index.php">Soporte Online</a></li>
              </li>
              </ul>
            </li>
            <li><a href="#">Transporte</a>
              <ul>
                <li><a href="transp/ords.php">Orden de Servicio</a></li>
              </li>
              </ul>
             <li><a href="lg/lg_logout.php" id="button5" onclick="return salir();" >Salir</a></li>
          </ul>
   </td>
 </tr> 

  <tr>
    <td height="501" align="center" valign="top"><form id="form1" name="form1" method="post" action="">
      <table width="927" height="472" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="180" rowspan="2" align="center"><table width="198" height="482" border="0" cellpadding="0" cellspacing="0" class="txtnormaln">
            <tr>
              
              <td width="198" height="87" align="center"><input name="button10" type="submit" class="boton_solicitudes" id="button10" value="Solicitudes de recursos" onclick="enviar('sol_rec.php')" /></td>
            </tr>
            <tr>
              <td height="97" align="center"><input name="button" type="submit" class="boton_tratos" id="button" value="Cotizacione/Licitaciones" onclick="enviar('Licitaciones/cotizaciones.php')" /></td>
            </tr>
            <tr>
              <td height="98" align="center"><label></label>
                <label></label>
                <input name="button2" type="submit" class="boton_areas" id="button2" value="Mantenedor de Areas" onclick="enviar('mant_areas.php')" />
                <br />              </td>
            </tr>
            <tr>
              <td height="98" align="center"><label>
                <input name="button3" type="submit" class="boton_inf" id="button3" value="Mantenedor de Usuarios" onclick="enviar('usuarios.php')" />
              </label></td>
            </tr>
          </table>
            <br></td>
          <td width="586" height="50" align="center"><span class="txtnormal">
            <?
				echo "Bienvenido <b>".$_SESSION['usuario_nombre']."</b><br>"."Ud. ha iniciado sesion en la intranet Rockmine";
			?>
          </span></td>
          <td width="161" rowspan="2" align="center"><table width="130" height="482" border="0" cellpadding="0" cellspacing="0" class="txtnormaln">
            <tr>
              <td height="87" align="center">
                <input name="button8" type="button" onclick="alert('En Proceso...');" class="boton_pdf" id="button9" value="Manual Usuario"  /></td>
            </tr>
            <tr>
              <td height="97" align="center"><label></label>
                <input name="button4" type="submit" class="boton_llave" id="button12" value="Cambiar clave de usuario" onclick="enviar('camb_cv.php')"/></td>
            </tr>
            <tr>
              <td height="98" align="center"><span class="txtnormaln">
                <label></label>
                <input name="button6" type="submit" class="boton_disponible" id="button4" value="Disponible" />
                <br />
              </span></td>
            </tr>
            <tr>
              <td height="105" align="center"><input name="button5" type="submit" class="boton_salir" id="button5" value="Cerrar sesion y salir" onclick="return salir()" /></td>
            </tr>
          </table>            
            <label></label></td>
        </tr>
        <tr>
          <td height="422" align="center" valign="top">
          
          
          <table width="554" height="403" border="0" align="center" cellpadding="0" cellspacing="0" class="txtnormal">
              <tr>
                <td width="442" height="391" align="center"><img src="imagenes/ff.png" width="527" height="346" /></td>
              </tr>
              <tr>
                <td height="9" align="center" valign="bottom" ><span style="color:#cdcdcd;font-size:10px;">Sistema Creado por Pedro Troncoso<br>y adaptado por Diego Fuentes</span></td>
              </tr>
            </table>
            <span style="color:#cdcdcd;font-size:10px;">
<?php
if($_SESSION['usuario_nivel'] == 0)
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
	
  //ESTO ESTA DEMAS....
	//echo 'Tu IP es:<b style="color:#cdcdcd"> '.$ip.'</b> Tu ISP es: <b style="color:cdcdcd">'.$isp.' </b>';
}
?>
        </span>			
            </td>
        </tr>
      </table>
	  
<script languaje="JavaScript">

/*var mydate=new Date()
var year=mydate.getYear()
if (year < 1000)
year+=1900
var day=mydate.getDay()
var month=mydate.getMonth()
var daym=mydate.getDate()
if (daym<10)
daym="0"+daym
var dayarray=new Array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado")
var montharray=new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre")
document.write("<small><font color='000000' face='Arial'>"+dayarray[day]+" "+daym+" de "+montharray[month]+" de "+year+"</font></small>")
*/
</script>
    </form>    </td>
  </tr>
  <tr>
    <td height="2" align="center" valign="top"><img src="imagenes/barra.gif" width="934" height="1" /></td>
  </tr>
</table>

</body>

</html>
