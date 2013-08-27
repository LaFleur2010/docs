<?
/**********************************************************************************************************************************
			NECESARIO PARA VER SI LA SESION ESTA ACTIVA O SI TIENE PERMISOS DE ACCESO
**********************************************************************************************************************************/
require("lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php
//
//Definimos el nivel de acceso  (esto es un bonus track para definir que ciertos usuarios puedan entrar a algunas paginas y a otras no)
// Si los usuarios normales tienen acceso=10, para que  accedan todos los usuarios le damos acceso mayor a 10.
$nivel_acceso =1;
if ($nivel_acceso < $_SESSION['usuario_nivel']){
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}
//Hasta aquí lo comun para todas las paginas restringidas
//*********************************************************************************************************************************
?>
<?php
//*********************************************************************************************************************************
	include ('inc/config_db.php');
	require ("inc/lib.db.php");
//*********************************************************************************************************************************
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mantenedor Trabajadores</title>
<link href="inc/bibliocss.css" rel="stylesheet" type="text/css">

<LINK href="inc/epoch_styles.css" type=text/css rel=stylesheet>
<SCRIPT src="inc/epoch_classes.js" type=text/javascript></SCRIPT>

<script type="text/javascript" language="JavaScript1.2" src="inc/stmenu.js"></script>
<script type="text/javascript" language="JavaScript" src="inc/funciones.js"></script>

<script LANGUAGE="JavaScript">

var dp_cal;
window.onload = function () {
	stime = new Date();
	dp_cal 	  = new Epoch('dp_cal','popup',document.getElementById('date_field'));
}; 

function enviar(url)
{
	document.formtrab.action=url;
}

function ing()
{
	var agree=confirm("Esta Seguro Que desea Ingresar El Registro ?");
	if (agree){
		document.formtrab.action='procesa.php'; 
		document.formtrab.submit();
		return true ;
	}else{
		return false ;
	}
}

function mod()
{
	var agree=confirm("Esta Seguro Que desea Modificar El Registro ?");
	if (agree){
		document.formtrab.action='procesa.php'; 
		document.formtrab.submit();
		return true ;
	}else{
		return false ;
	}
}

function eli()
{
	var agree=confirm("Esta Seguro Que desea Eliminar El Registro ?");
	if (agree){
		document.formtrab.action='procesa.php'; 
		document.formtrab.submit();
		return true ;
	}else{
		return false ;
	}
}

function carga(rut)
{
    document.formtrab.rut_trab.value = rut;
	document.formtrab.submit();
}

</SCRIPT>

<style type="text/css">
<!--
body {
	background-color: #527eab;
}
.Estilo5 {color: #000000}
.Estilo6 {color: #FFFFFF}
-->
</style>

    <style type="text/css" media="all">

    .hide {
		font: bold 6px Verdana, Arial, Helvetica, serif;
        visibility: hidden;
        display: none;
    }

    div.row {
        display: table-row;
        clear: both;
        padding: 2px;
        vertical-align: top;
    }

    div.row div {
        display: table-cell;
        padding: 2px;
        vertical-align: middle;
        float:left;
        display: inline;
    }

    div.row div.title {
        display: table-cell;
        padding: 2px;
        margin: 2px;
        background-color: #527eab;
        font: bold 12px Verdana, Arial, Helvetica, serif;
        color: #153244;
        vertical-align: middle;
    }

    div.row div img{
        vertical-align: bottom;
        border:0px solid;
        padding-left: 1px;
    }

    input, textarea {
        font: 12px Verdana, Arial, Helvetica, serif;
        border: #153244 1px solid;
        color: #000000;
        background-color: #FFFFFF;
        padding: 1px 3px 1px 3px;
    }

    select {
        font: 11px Verdana, Arial, Helvetica, serif;
        border: #153244 1px solid;
        color: #000000;
        background-color: #EFEBE7;
    }

    </style>
</head>

<body>
<?php
/**********************************************************************************************************************************	
						BUSCAR REGISTROS
**********************************************************************************************************************************/	
$co=mysql_connect("$DNS","$USR","$PASS");
mysql_select_db("$BDATOS", $co);

if($_POST['rut_trab'] != "")
{
	$rut_trab = $_POST['rut_trab'];
}
if($_POST['procesa'] != "")
{
	$rut_trab = $_POST['procesa'];
}
	
	$sqlc 			= "SELECT * FROM trabajadores WHERE rut_t = '$rut_trab' ";
	$respuesta		= mysql_query($sqlc,$co);
	while($vrowsM	= mysql_fetch_array($respuesta))
	{
		$rut_t		="".$vrowsM['rut_t']."";
		$nom_t		="".$vrowsM['nom_t'].""; 
		$app_t		="".$vrowsM['app_t']."";
		$apm_t		="".$vrowsM['apm_t']."";
		$area_t		="".$vrowsM['area_t'].""; 
		$cargo_t	="".$vrowsM['cargo_t'].""; 
		$fonom_t	="".$vrowsM['fonom_t'].""; 
		$fonoc_t	="".$vrowsM['fonoc_t']."";
		$correo_t	="".$vrowsM['correo_t'].""; 
		$ruta_foto	="".$vrowsM['ruta_foto']."";  	
		$estado		="".$vrowsM['est_alta'].""; 
		$fe_nulo	="".$vrowsM['fe_nulo']."";						
	}
?>
<table width="807" height="486" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F2F2F2">
  <tr>
    <td width="100" height="54" align="center" valign="top"><a href="index2.php"><img src="images/logo_c.jpg" width="100" height="60" border="0" /></a></td>
    <td width="607" align="center" valign="middle" bgcolor="#FFFFFF"><img src="imagenes/Titulos/TRABAJADORES.png" width="233" height="10" /></td>
    <td width="100" align="center" valign="top"><img src="imagenes/logo_iso_c.jpg" width="100" height="52" /></td>
  </tr>
  <tr>
    <td height="5" colspan="3" align="center" valign="top"><img src="imagenes/barra.gif" width="100%" height="3" /></td>
  </tr>
  <tr>
    <td height="412" colspan="3" align="center" valign="top">
    
    <table width="790" height="258" border="0" class="txtnormal">
      <tr>
        <td width="784" height="225" align="center" valign="top">
        
        <form name="formtrab" enctype="multipart/form-data" action="" method="post">
          <table width="770" height="45" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CEDEE1">
            <tr>
              <td width="970" align="right"><table width="766" height="67" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="80" height="67" align="right"><input name="button8" type="submit" class="boton_inicio" id="button8" value="Inicio" onclick="enviar('index2.php')" /></td>
                    <td width="154" align="right"><label>
                      <input type="hidden" name="rut_trab" id="hiddenField" />
                    </label></td>
                    <td width="130" align="right">&nbsp;</td>
                    <td width="164" align="center">&nbsp;</td>
                    <td width="105" align="center"><input name="Volver4" type="submit" class="boton_actualizar" id="Volver4" value="Actualizar" /></td>
                    <td width="100" align="right"><input name="button" type="submit" class="boton_lista2" id="button7" value="Listado Trabaj." onclick="enviar('lista_trab.php')" /></td>
                    <td width="33" align="right">&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
          </table>
          <table width="770" height="345" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#cedee1">
            <tr>
              <td height="339" align="center"><table width="718" height="327" border="0" cellpadding="0" cellspacing="0" class="txtnormaln">
                <tr>
                  <td width="111" height="18" align="left" valign="bottom">&nbsp;</td>
                  <td colspan="3" align="left" valign="bottom"><label>
<?	
/**********************************************************************************************************************************	
						BUSCAR REGISTROS
**********************************************************************************************************************************/
if($_POST['busca'] =="Buscar")
{	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sqlc			= "SELECT * FROM trabajadores WHERE rut_t='".$_POST['t1']."' ";
	$respuesta		= mysql_query($sqlc,$co);
	while($vrowsB	= mysql_fetch_array($respuesta))
	{
		$rut_t		="".$vrowsB['rut_t']."";
		$nom_t		="".$vrowsB['nom_t'].""; 
		$app_t		="".$vrowsB['app_t']."";
		$apm_t		="".$vrowsB['apm_t']."";
		$area_t		="".$vrowsB['area_t'].""; 
		$cargo_t	="".$vrowsB['cargo_t'].""; 
		$fonom_t	="".$vrowsB['fonom_t'].""; 
		$fonoc_t	="".$vrowsB['fonoc_t']."";
		$correo_t	="".$vrowsB['correo_t'].""; 
		$ruta_foto	="".$vrowsB['ruta_foto']."";  
		$estado		="".$vrowsB['est_alta'].""; 
		$fe_nulo	="".$vrowsB['fe_nulo']."";							
	}
}
?>
                  </label></td>
                  <td width="284" align="center" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                  <td width="111" height="20" align="left" valign="bottom">Rut                    </td>
                  <td colspan="3" align="left" valign="bottom">
                  <input name="t1" type="text" id="textfield6" style="width:105px;" value="<? echo $rut_t; ?>" onchange="Valida_Rut(this);" />
                    <label>
                    <input name="busca" type="submit" class="boton_bus" id="busca" value="Buscar" />
                    </label></td>
                  <td width="284" rowspan="12" align="center" valign="middle"><table width="154" height="225" border="1" bordercolor="#FFFFFF">
                    <tr>
                      <td align="center"><? echo"<img src='$ruta_foto' width='154' height='225' />";?></td>
                    </tr>
                  </table>
                    Fotografia</td>
                </tr>
                <tr>
                  <td height="25" align="left">Nombre</td>
                  <td colspan="3" align="left"><input name="t2" type="text" id="textfield" value="<? echo $nom_t; ?>" size="30" />
                    <label>
                    <input name="busNom" type="submit" class="boton_bus_ch" id="button" value="Buscar" />
                    </label></td>
                  </tr>
                <tr>
                  <td height="25" align="left">Apellido Paterno</td>
                  <td colspan="3" align="left"><input name="t3" type="text" id="textfield2" value="<? echo $app_t; ?>" size="30" />
                    <input name="busApp" type="submit" class="boton_bus_ch" id="button2" value="Buscar" /></td>
                  </tr>
                <tr>
                  <td height="25" align="left">Apellido Materno</td>
                  <td colspan="3" align="left"><input name="t4" type="text" id="textfield3" value="<? echo $apm_t; ?>" size="30" /></td>
                  </tr>
                <tr>
                  <td height="21" align="left">Area</td>
                  <td colspan="3" align="left">
                  <select name="c1" id="select7" style="width:205px;">
                    <? echo"<option selected='$area_t'>$area_t</option>";?>
                    <option value="Apoyo">Apoyo</option>
                    <option value="Bodega">Bodega</option>
                    <option value="Calidad">Calidad</option>
                    <option value="Cilindros">Cilindros</option>
                    <option value="Electromecanica">Electromecanica</option>
                    <option value="Estructuras">Estructuras</option>
                    <option value="Ingenieria">Ingenieria</option>
                    <option value="Mecanizado">Mecanizado</option>
                    <option value="Mantencion Mecanica">Mantencion Mecanica</option>
                    <option value="Seguridad">Seguridad</option>
                    <option value="Sellos">Sellos</option>
                    <option value="Transportes">Transportes</option>
                    <option value="Nulo">Nulo</option>
                    </select></td>
                  </tr>
                <tr>
                  <td height="21" align="left">Cargo</td>
                  <td colspan="3" align="left">
                  <select name="c2" id="c" style="width:205px;">
                  	<option value="Supervisor de area">Supervisor de area</option>
                    <option value="Maestro mayor">Maestro mayor</option>
                    <option value="Maestro primera">Maestro Primera</option>
                    <option value="Maestro segunda">Maestro segunda</option>
                    <option value="Maestro tercera">Maestro tercera</option>
                    <option value="ayudante">Ayudante</option>
                    <option value="Asistente">Asistente</option>
                    <? echo"<option selected='$cargo_t'>$cargo_t</option>";?>
                  </select></td>
                  </tr>
                <tr>
                  <td height="25" align="left">Fono Movil</td>
                  <td colspan="3" align="left"><input name="t5" type="text" id="textfield7" value="<? echo $fonom_t; ?>" size="30" /></td>
                  </tr>
                <tr>
                  <td height="25" align="left">Fono Casa</td>
                  <td colspan="3" align="left"><input name="t6" type="text" id="textfield8" value="<? echo $fonoc_t; ?>" size="30" /></td>
                  </tr>
                <tr>
                  <td height="25" align="left">Correo</td>
                  <td colspan="3" align="left"><input name="t7" type="text" id="textfield9" value="<? echo $correo_t; ?>" size="30" /></td>
                  </tr>
                <tr>
                  <td align="left">Fotografia</td>
                  <td colspan="3" align="left"><input name="archivo_usuario" type="file" id="archivo_usuario" value="" size="30" /></td>
                  </tr>
                <tr>
                  <td height="37" align="left">Estado</td>
                  <td align="left">
                  
                  <select name="estado" id="estado">
                    <?php 
					if($rut_t == ""){$estado = "alta";}
						echo"<option selected='selected' value='$estado'>$estado</option>"; ?>
                    <option value="alta">alta</option>
                    <option value="Baja">Baja</option>
                  </select></td>
                  <td align="left">Fecha de baja</td>
                  <td align="left"><span class="content">
                    <? 
					if($fe_nulo != "")
					{
						$fe_nulo	=	cambiarFecha($fe_nulo, '-', '/' ); 
					}
					if($rut_t == ""){$fe_nulo = "";}
					if($fe_nulo == "00/00/0000"){$fe_nulo = "";}
					?>
                    <input name="fe_nulo" class="cajas" id="date_field" style="WIDTH: 7em" value="<? echo $fe_nulo; ?>" />
                    <input type="button" class="botoncal" onclick="dp_cal.toggle();"  onmouseup="oculta('aux')" />
                  </span></td>
                </tr>
                <tr>
                  <td height="22" align="left">&nbsp;</td>
                  <td width="87" align="left">&nbsp;</td>
                  <td width="88" align="left">&nbsp;</td>
                  <td width="148" align="left">&nbsp;</td>
                </tr>
              </table>
                </td>
            </tr>
          </table>
          <table width="770" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#cedee1">
            <tr>
              <td width="772" height="40" align="center"><label>
                  <input name="IngresaTrab" type="submit" class="boton_ing" id="button3" value="Ingresar" onclick="return ing();" />
                  &nbsp;
              </label>
                <input name="modificaTrab" type="submit" class="boton_mod" id="button4" value="Modificar" onclick="return mod();" />
                &nbsp;
                <input name="EliminaTrab" type="submit" class="boton_eli" id="button5" value="Eliminar" onclick="return eli();" />
                &nbsp;
                <input name="limpia" type="submit" class="boton_lim" id="button6" value="Limpiar" />
                &nbsp;&nbsp;</td>
            </tr>
          </table>
          <label></label>
        </form>
        </td>
      </tr>
      <tr>
        <td height="2" align="center" valign="top">
        
        <table width="768" border="0" bordercolor="#FFFFFF" bgcolor="#cedee1" class="txtnormal" cellspacing="1" cellpadding="0">
          <tr>
            <td width="5%">...</td>
            <td width="17%">RUT</td>
            <td width="20%">NOMBRE</td>
            <td width="23%">APELLIDO PATERNO</td>
            <td width="23%"><span class="Estilo5">&nbsp;APELLIDO MATERNO</span></td>
            <td width="12%">FONO MOVIL</td>
<? 
if($_POST['busNom'] == "Buscar")
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$criterio   	= $_POST['t2'];
	$sql			= "SELECT * FROM trabajadores WHERE nom_t LIKE '%$criterio%' ";
	$respuesta		= mysql_query($sql,$co);
	$color			= "#FFFFFF";
	while($vrows	= mysql_fetch_array($respuesta))
	{	
		$rut = $vrows['rut_t'];
		echo("<tr bgcolor=$color align='left'>	
									<td bgcolor='#ffc561'>&nbsp;<a href='#' onclick=carga('$rut');><img src='imagenes/edit.png' border='0' valign='top' alt='Modificar'/></a></td>
									<td align='left'>&nbsp;&nbsp;&nbsp;".$vrows['rut_t']."</td>
									<td>&nbsp;".$vrows['nom_t']."</td>
									<td>&nbsp;".$vrows['app_t']."</td>
									<td>&nbsp;".$vrows['apm_t']."</td>
									<td>&nbsp;".$vrows['fonom_t']."</td>
									</tr> ");			
	}	
}	
//*********************************************************************************************************************************
if($_POST['busApp'] == "Buscar")
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$criterio   = $_POST['t3'];
	$sql		= "SELECT * FROM trabajadores WHERE app_t LIKE '%$criterio%' ";

	$respuesta	= mysql_query($sql,$co);
	$color		= "#FFFFFF";
	while($rows=mysql_fetch_array($respuesta))
	{
		$rut = $rows['rut_t'];
		echo("<tr bgcolor=$color>	<td bgcolor='#ffc561'>&nbsp;<a href='#' onclick=carga('$rut');><img src='imagenes/edit.png' border='0' valign='top' alt='Modificar'/></a></td>
									<td>&nbsp;".$rows['rut_t']."</td>
									<td>&nbsp;".$rows['nom_t']."</td>
									<td>&nbsp;".$rows['app_t']."</td>
									<td>&nbsp;".$rows['apm_t']."</td>
									<td>&nbsp;".$rows['fonom_t']."</td>
									</tr> ");			
	}	
}			
?>
          </tr>
        </table></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td height="5" colspan="3" align="center" valign="top"><img src="imagenes/barra.gif" alt="" width="792" height="3" /></td>
  </tr>
</table>
</body>
</html>
