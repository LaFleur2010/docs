<?
/**********************************************************************************************************************************
			NECESARIO PARA VER SI LA SESION ESTA ACTIVA O SI TIENE PERMISOS DE ACCESO
**********************************************************************************************************************************/
/*require("lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php
//
//Definimos el nivel de acceso  (esto es un bonus track para definir que ciertos usuarios puedan entrar a algunas paginas y a otras no)
// Si los usuarios normales tienen acceso=10, para que  accedan todos los usuarios le damos acceso mayor a 10.
$nivel_acceso =8;
if ($nivel_acceso < $_SESSION['usuario_nivel']){
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}
//Hasta aquí lo comun para todas las paginas restringidas
//*********************************************************************************************************************************
*/
//*********************************************************************************************************************************
	include('inc/config_db.php');	// CONECCION A LA BASE DE DATOS
	require('inc/lib.db.php');
/**********************************************************************************************************************************
Inicializamos las variables de los combos
**********************************************************************************************************************************/	
		$planta 		=	"--------------  Seleccione Planta --------------";
		$desc_eq_scont 	=	"--------------------------------------------------------------------  Seleccione Equipo --------------------------------------------------------------------";
		$V_desc_eq_scont 	=	"*";
		$cli_cot 		=	"---------  Seleccione  ---------";
		$estado_cot 	=	"---------  Seleccione  ---------";
		$usuario 		=	"---------  Seleccione  ---------";
		$rises	 		=	"---------  Seleccione  ---------";
		$area 			=	"---------  Seleccione  ---------";
		$estado 		=	"---------  Seleccione  ---------";
		$priori 		=	"---------  Seleccione  ---------";
		$est_inf 		=	"---  Seleccione  ---";
		$fe				=	date("d/m/Y");
//********************************************************************************************************************************
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Asistencia MGYT</title>

<script type="text/javascript" language="JavaScript" src="inc/funciones.js"></script>

<script type="text/JavaScript" src="curvycorners.src.js"></script>

<link href="inc/bibliocss.css" rel="stylesheet" type="text/css">
<LINK href="inc/epoch_styles.css" type=text/css rel=stylesheet>
<SCRIPT src="inc/epoch_classes.js" type=text/javascript></SCRIPT>

<script language="javascript" src="js/jquery-1.2.6.min.js"></script>

<script language="javascript">

function ir(url)
{
	document.f.action=url;
}

var dp_cal;
window.onload = function () {
	stime = new Date();
	dp_cal 	  = new Epoch('dp_cal','popup',document.getElementById('date_field'));
}; 

function mod()
{
	var agree=confirm("Esta Seguro de Querer Modificar Este Registro ?");
	if (agree){
		document.f.action='contratos_p.php'; 
		document.f.submit();
		return true ;
	}else{
		return false ;
	}
}

function eli()
{
	var agree=confirm("Esta Seguro de Querer Eliminar Este Registro ?");
	if (agree){
		document.f.action='contratos_p.php'; 
		document.f.submit();
		return true ;
	}else{
		return false ;
	}
}

function gen()
{
	var agree=confirm("Esta Seguro Que desea Ingresar la ODS ?");
	if (agree){
		document.f.action='contratos_p.php'; 
		document.f.submit();
		return true ;
	}else{
		return false ;
	}
}

  addEvent(window, 'load', initCorners);

  function initCorners() {
    var settings = {
      tl: { radius: 15 },
      tr: { radius: 15 },
      bl: { radius: 15 },
      br: { radius: 15 },
      antiAlias: true
    }
    curvyCorners(settings, "#myBox");
	curvyCorners(settings, "#myBox2");
	curvyCorners(settings, "#myBox3");
  }
</script>

<style type="text/css" media="all">
#myBox {
    color: #fff;
    width: 98%;
    padding: 4px;
    text-align: justify;
    background-color: #a2b5c0;
    border: 3px solid #fff;
}
#myBox p {
  padding:0;
  margin:1ex 0;
}
#myBox2 {
    color: #fff;
    width: 98%;
    padding: 4px;
    text-align: justify;
    background-color: #cedee1;
    border: 3px solid #fff;
}
#myBox3 {
    color: #fff;
    width: 98%;
    padding: 1px;
    text-align: justify;
    background-color: #F2F2F2;
    border: 3px solid #fff;
}
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


    </style>

<style type="text/css">
<!--
body {
	background-color: #0099FF;
}
-->
</style>

  <style type="text/css">
  <!--
     body {
	scrollbar-3dlight-color:#0099FF;
	scrollbar-arrow-color:white;
	scrollbar-track-color:silver;
	scrollbar-darkshadow-color:black;
	scrollbar-face-color:#0099FF;
    scrollbar-highlight-color:;
    scrollbar-shadow-color:;
	background-image: url();
	background-color: #5a88b7;
}
.Estilo8 {color: #000000}
.Estilo9 {color: #FFFFFF}
#myBox2 {    color: #fff;
    width: 98%;
    padding: 4px;
    text-align: justify;
    background-color: #cedee1;
    border: 3px solid #fff;
}
#myBox {    color: #fff;
    width: 98%;
    padding: 4px;
    text-align: justify;
    background-color: #a2b5c0;
    border: 3px solid #fff;
}
   -->
  </style> 
</head>

<body>
<?php 		
/**********************************************************************************************************************************
	
**********************************************************************************************************************************/
if($_POST['limpia'] != "Limpiar" and $_POST['elimina'] != "Eliminar")
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
/**********************************************************************************************************************************
			CARGAMOS LOS DATOS DEL CODIGO QUE NOS ENVIO LA GRILLA
**********************************************************************************************************************************/	
	if($_POST['cod'] != "")
	{
		$llave = $_POST['cod'];
	}
	if($_GET['cod'] != "")
	{
		$llave = $_GET['cod'];
	}
	if($_GET['ods_v'] != "")
	{
		$llave = $_GET['ods_v'];
	}
	if($_POST['modifica'] != "")
	{
		$llave = $_POST['modifica'];
	}
	if($_POST['ingresa'] != "")
	{
		$llave = $_POST['ingresa'];
	}
	if($_POST['elimina'] != "")
	{
		$llave = $_POST['elimina'];
	}
	if($_POST['busca'] != "")
	{
		$llave = $_POST['busca'];
	}
	if($_POST['aprueba'] != "")
	{
		$llave = $_POST['aprueba'];
	}
	
	$sqlc="SELECT * FROM contratos WHERE ods = '$llave' ";
	$respuesta=mysql_query($sqlc,$co);
	while($vrows=mysql_fetch_array($respuesta))
	{
		$ods				= "".$vrows['ods']."";
		$area				= "".$vrows['area']."";
		$priori				= "".$vrows['priori']."";
		$estado				= "".$vrows['estado']."";
		$est_inf			="".$vrows['est_inf'].""; 
		$planta				= "".$vrows['planta'].""; 
		$usuario			= "".$vrows['usuario'].""; 
		$fe_in_ret			= "".$vrows['fe_in_ret']."";
		$fe_env_inf			= "".$vrows['fe_env_inf'].""; 
		$fe_aprov			= "".$vrows['fe_aprov']."";
		$fe_ent_rep			= "".$vrows['fe_ent_rep']."";  
		$fe_ent_rep2		= "".$vrows['fe_ent_rep2'].""; 
		$fe_ent_rep3		= "".$vrows['fe_ent_rep3'].""; 
		$dias_rep			= "".$vrows['dias_rep'].""; 
		$fe_ent_aprox		= "".$vrows['fe_ent_aprox']."";
		$guia_desp_det		= "".$vrows['guia_desp_det']."";
		$cant				= "".$vrows['cant']."";
		$fam_eq				= "".$vrows['fam_eq']."";
		$desc_eq_sguia		= "".$vrows['desc_eq_sguia']."";
		$desc_eq_scont		= "".$vrows['desc_eq_scont']."";
		$V_desc_eq_scont	= "".$vrows['cod_eq']."";
		$desc_falla			= "".$vrows['desc_falla'].""; 
		$observ				= "".$vrows['observ'].""; 
		$fe_ter_prod		= "".$vrows['fe_ter_prod']."";
		$guia_mgyt_ent		= "".$vrows['guia_mgyt_ent'].""; 
		$ent_par1			= "".$vrows['ent_par1']."";
		$ent_par2			= "".$vrows['ent_par2']."";  
		$ent_par3			= "".$vrows['ent_par3'].""; 
		$ent_par4			= "".$vrows['ent_par4']."";
		$ent_par5			= "".$vrows['ent_par5']."";
		$fe_cierre_ods_fact	= "".$vrows['fe_cierre_ods_fact']."";    
		$fe_fact			= "".$vrows['fe_fact']."";
		$precio				= "".$vrows['precio']."";
		$botar_rises		= "".$vrows['botar_rises'].""; 
		
		$ent1_cant			= "".$vrows['ent1_cant']."";  
		$ent1_guia			= "".$vrows['ent1_guia'].""; 
		$ent2_cant			= "".$vrows['ent2_cant']."";   
		$ent2_guia			= "".$vrows['ent2_guia']."";  
		$ent3_cant			= "".$vrows['ent3_cant'].""; 
		$ent3_guia			= "".$vrows['ent3_guia'].""; 
		$ent4_cant			= "".$vrows['ent4_cant']."";    
		$ent4_guia			= "".$vrows['ent4_guia'].""; 
		$ent5_cant			= "".$vrows['ent5_cant'].""; 
		$ent5_guia			= "".$vrows['ent5_guia']."";   	  							
	}
		$sql_u = "SELECT * FROM usuario_e WHERE cod_ue='$usuario' ";
		$res=mysql_query($sql_u,$co);
		while($vrows=mysql_fetch_array($res))
		{
			$usuario	= "".$vrows['nom_ue']."";
			$codigo_ue	= "".$vrows['cod_ue']."";
		}
		
		$sql_p = "SELECT * FROM plantas WHERE cod_p='$planta' ";
		$res=mysql_query($sql_p,$co);
		while($fila=mysql_fetch_array($res))
		{
			$cod_planta	= "".$fila['cod_p']."";
			$planta		= "".$fila['nom_p']."";
		}	
		$sql3 = "SELECT * FROM equipos WHERE cod_eq = '$desc_eq_scont' ";
		$resp3 	= dbExecute($sql3);
		while ($vrows3 = mysql_fetch_array($resp3)) 
		{
    		$desc_eq_scont = "".$vrows3['nom_eq']."";
		}
		
		$sqlrep = "SELECT * FROM rep_x_ods, repuestos WHERE rep_x_ods.ods = '$ods' and rep_x_ods.id_rep = repuestos.cod_rep ORDER BY id ";
		$resrep = dbExecute($sqlrep);
		while ($vrows_rep = mysql_fetch_array($resrep)) 
		{
    		$repxods[] = $vrows_rep;
		}
		
		if($fe_in_ret  			== "0000-00-00"){$fe_in_ret  		="";}
		if($fe_env_inf  		== "0000-00-00"){$fe_env_inf   		="";}
		if($fe_aprov	  		== "0000-00-00"){$fe_aprov  		="";}
		if($fe_ent_rep  		== "0000-00-00"){$fe_ent_rep   		="";}
		if($fe_ent_rep2  		== "0000-00-00"){$fe_ent_rep2   	="";}
		if($fe_ent_rep3  		== "0000-00-00"){$fe_ent_rep3   	="";}
		if($fe_ent_aprox  		== "0000-00-00"){$fe_ent_aprox   	="";}
		if($fe_ter_prod  		== "0000-00-00"){$fe_ter_prod 		="";}
		if($ent_par1  			== "0000-00-00"){$ent_par1  		="";}
		if($ent_par2  			== "0000-00-00"){$ent_par2    		="";}
		if($ent_par3  			== "0000-00-00"){$ent_par3    		="";}
		if($ent_par4 			== "0000-00-00"){$ent_par4 			="";}
		if($ent_par5 			== "0000-00-00"){$ent_par5  		="";}
		if($fe_cierre_ods_fact 	== "0000-00-00"){$fe_cierre_ods_fact="";}
		if($fe_fact				== "0000-00-00"){$fe_fact 			="";}
}
//********************************************************************************************************************************


function remitentest()
{
	$sql  = "SELECT cod_p,nom_p FROM plantas ORDER BY nom_p ";
	
	$rs 	= dbConsulta($sql);
	$total  = count($rs);
	echo"<option value='$planta'>$planta</option>";
			
	for ($i = 0; $i < $total; $i++)
	{
		echo "<option value='".$rs[$i]['cod_p']."'>".$rs[$i]['nom_p']."</option>";
	}
}
?>
<table width="944" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="22" align="center"><div id="myBox3" class="txtnormal">
      <table width="925" height="362" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F2F2F2">
        <tr>
          <td width="106" height="54" align="right" valign="top"><a href="index2.php"><img src="imagenes/logo_mgyt_c.jpg" border="0" width="100" height="52" /></a></td>
          <td width="713" align="center" valign="middle"><img src="imagenes/Titulos/REP_ASIST.png" width="400" height="40" /></td>
          <td width="106" align="left" valign="top"><img src="imagenes/logo_iso_c.jpg" width="100" height="52" /></td>
        </tr>
        <tr>
          <td height="3" colspan="3" align="center" valign="top"><img src="imagenes/barra.gif" alt="" width="910" height="3" /></td>
        </tr>
        <tr>
          <td height="297" colspan="3" align="center" valign="top"><table width="904" height="297" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
              <tr>
                <td width="904" height="274" align="center" valign="top"><form id="f" name="f" method="post" action="">
                    <table width="899" height="272" border="0" cellpadding="0" cellspacing="0" class="tablas">
                      <tr>
                        <td width="899" height="272" align="center" valign="top"><table width="899" height="107" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
                            <tr>
                              <td width="899" height="51" align="center"><div  id="myBox2" class="txtnormal">
                                  <table width="880" height="66" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="880" height="62" align="center"><label></label>
                                          <label>
                                          <input name="button8" type="submit" class="boton_inicio" id="button8" value="Volver" onclick="ir('asistencia.php')" />
                                        </label></td>
                                    </tr>
                                  </table>
                              </div>
                                  <label></label></td>
                            </tr>
                            <tr>
                              <td height="19" align="center" valign="bottom"><label></label>
                                  <div id="myBox" class="txtnormal">
                                    <table width="878" border="0" cellpadding="0" cellspacing="0">
                                      <tr>
                                        <td width="3" height="21">&nbsp;</td>
                                        <td colspan="7" align="left" class="txtnormal"><label></label>
                                            <span class="content"> </span>
                                            <label></label>
                                            <label></label></td>
                                      </tr>
                                      <tr>
                                        <td width="3">&nbsp;</td>
                                        <td width="3" height="193" align="left" class="txtnormal">&nbsp;</td>
                                        <td width="146" align="center" class="txtnormal">&nbsp;</td>
                                        <td width="140" align="center" class="txtnormal"><label>
                                          <input name="button" type="submit" class="boton_inf" id="button" value="Informes Ingresados" onclick="ir('listado_ing.php')"/>
                                        </label></td>
                                        <td width="153" align="center" class="txtnormal"><label>
                                          <input name="button2" type="submit" class="boton_menu" id="button2" value="Enviar" />
                                        </label></td>
                                        <td width="146" align="center" class="txtnormal"><input name="button3" type="submit" class="boton_menu" id="button3" value="Enviar" /></td>
                                        <td width="160" align="center" class="txtnormal"><input name="button4" type="submit" class="boton_menu" id="button4" value="Enviar" /></td>
                                        <td width="127" align="center" class="txtnormal">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td width="3">&nbsp;</td>
                                        <td height="174" align="left" class="txtnormal">&nbsp;</td>
                                        <td width="146" align="center" class="txtnormal">&nbsp;</td>
                                        <td align="center" class="txtnormal"><input name="button5" type="submit" class="boton_menu" id="button5" value="Enviar" /></td>
                                        <td align="center" class="txtnormal"><input name="button6" type="submit" class="boton_menu" id="button6" value="Enviar" /></td>
                                        <td width="146" align="center" class="txtnormal"><label></label>
                                            <input name="button7" type="submit" class="boton_menu" id="button7" value="Enviar" /></td>
                                        <td width="160" align="center" class="txtnormal"><input name="button9" type="submit" class="boton_menu" id="button9" value="Enviar" /></td>
                                        <td width="127" align="center" class="txtnormal">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td width="3" height="22">&nbsp;</td>
                                        <td colspan="7" rowspan="3" align="center" class="txtnormal">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td height="15">&nbsp;</td>
                                      </tr>
                                    </table>
                                    <br />
                                  </div>
                                <label></label></td>
                            </tr>
                            <tr>
                              <td height="37" align="center" valign="bottom"><label></label>
                                  <label></label></td>
                            </tr>
                        </table></td>
                      </tr>
                    </table>
                </form></td>
              </tr>
              <tr>
                <td height="17" align="center" valign="top">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="5" colspan="3" align="center" valign="top"><img src="imagenes/barra.gif" alt="" width="910" height="3" /></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</body>
</html>
