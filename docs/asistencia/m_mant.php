<?
/**********************************************************************************************************************************
			NECESARIO PARA VER SI LA SESION ESTA ACTIVA O SI TIENE PERMISOS DE ACCESO
**********************************************************************************************************************************/
require("lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php
//
//Definimos el nivel de acceso  (esto es un bonus track para definir que ciertos usuarios puedan entrar a algunas paginas y a otras no)
// Si los usuarios normales tienen acceso=10, para que  accedan todos los usuarios le damos acceso mayor a 10.
$nivel_acceso =12;
if ($_SESSION['usuario_nivel'] != 0 and $_SESSION['usuario_nivel'] != 11){
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}
//Hasta aquí lo comun para todas las paginas restringidas
//*********************************************************************************************************************************

//*********************************************************************************************************************************
	include('inc/config_db.php');	// CONECCION A LA BASE DE DATOS
	require('inc/lib.db.php');
	$fe		= date("d/m/Y");
	$sel 	= "Seleccione...";
//********************************************************************************************************************************
function encab()
{
	echo"<table width='883' border='1' cellpadding='0' cellspacing='0' bordercolor='#FFFFFF'>
                              <tr class='txtnormaln' bgcolor='#5a88b7'>
                                <td width='26' rowspan='2' align='center'>Nº</td>
                                <td width='219' rowspan='2' align='center'>NOMBRE TRABAJADOR</td>
                                <td colspan='2' align='center'>ESTADO</td>
                                <td width='149' rowspan='2' align='center'>MOTIVO</td>
                                <td width='365' rowspan='2' align='center'>OBSERVACION</td>
                                </tr>
                              <tr class='txtnormalb'>
                                <td width='57' align='center' bgcolor='#003366'>Presente</td>
                                <td width='53' align='center' bgcolor='#003366'>Ausente</td>
                              </tr>";
}
	
function fin()
{
	echo"<tr bgcolor='#5a88b7' bordercolor='#5a88b7'>
<td height='12' align='center'>&nbsp;</td>
<td height='12' align='left'>&nbsp;</td>
<td width='50' align='center'><a href='javascript:seleccionar_todo_p()'>Todos</a></td>
<td width='62' align='center'><a href='javascript:seleccionar_todo_a()'>Todos</a></td>
<td width='149' align='center'>&nbsp;</td>
<td width='365' align='center'>&nbsp;</td>
</tr>

<tr bgcolor='#5a88b7' bordercolor='#5a88b7'>
<td height='12' align='center'>&nbsp;</td>
<td height='12' align='left'>&nbsp;</td>
<td width='50' align='center'><a href='javascript:deseleccionar_todo_p()'>Ninguno</a></td>
<td width='62' align='center'><a href='javascript:deseleccionar_todo_a()'>Ninguno</a></td>
<td width='149' align='center'>&nbsp;</td>
<td width='365' align='center'>&nbsp;</td>
</tr>
</table><br>";
}
function filanm($num, $cod_det_as, $nom_tf, $app_tf, $apm_tf, $rut_det_as, $estado_det_as, $motivo_det_as, $observ_det_as, $check1, $check2, $color, $cod_as)
{
	 						echo"<tr bgcolor=$color bordercolor=$color onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000')>
								<td height='12' align='center'>$num</td>
                                <td height='12' align='left'>&nbsp;&nbsp;".$nom_tf." ".$app_tf." ".$apm_tf."</td>
                                <td width='50' align='center'><input name='presente[]' type='checkbox' class='cajas' id='checkbox[]' onclick='cambiar(this)' $check1 /></td>
                                <td width='62' align='center'><input name='ausente[]' type='checkbox' class='cajas' id='checkbox[]' onclick='cambiar(this)' $check2 /></td>
                                <td width='149' align='center'>
								
								<select name='motivo[]' class='combos' id='motivo' style='width: 140px' >
                                  <option selected='selected' value='$motivo_det_as'>$motivo_det_as</option>
                                  <option value='Falla'>Falla</option>
                                  <option value='Licencia'>Licencia</option>
                                  <option value='Permiso a descuento'>Permiso a descuento</option>
                                  <option value='Permiso Legal'>Permiso Legal</option>
                                  <option value='Terreno'>Terreno</option>
                                  <option value='Vacaciones'>Vacaciones</option>
                                </select>
								
								</td>
									<td width='365' align='center'>
										<input name='obs[]' type='text' class='cajas' id='textfield' size='55' value='$observ_det_as' />
										<input type='hidden' name='id[]' value='$cod_det_as' />
										<input name='aux[]' type='hidden' id='aux[]' />
									<input name='cod' type='hidden' class='cajas' id='textfield' size='5' value='$cod_as' />
									</td>
								</td>
								 </tr>"; 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Asistencia MGYT</title>

<script type="text/javascript" language="JavaScript" src="inc/funciones.js"></script>

<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">

<script type="text/JavaScript" src="../curvycorners.src.js"></script>

<script language="javascript" src="../js/jquery-1.2.6.min.js"></script>

<script language="javascript">
 
function ir(url)
{
	document.f.action=url;
}

$(document).ready(function(){
	// Parametros para e combo1
   $("#combo1").change(function () {
   		$("#combo1 option:selected").each(function () {
			//alert($(this).val());
				elegido=$(this).val();
				$.post("combo1.php", { elegido: elegido }, function(data){
				$("#combo2").html(data);
				$("#combo3").html("");
			});			
        });
   })
	// Parametros para el combo2
	$("#combo2").change(function () {
   		$("#combo2 option:selected").each(function () {
			//alert($(this).val());
				elegido=$(this).val();
				$.post("combo2.php", { elegido: elegido }, function(data){
				$("#combo3").html(data);
			});			
        });
   })
});

function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

  addEvent(window, 'load', initCorners);

  function initCorners() {
    var settings = {
      tl: { radius: 25 },
      tr: { radius: 25 },
      bl: { radius: 0 },
      br: { radius: 0 },
      antiAlias: true
    }
    //curvyCorners(settings, "#myBox");
	curvyCorners(settings, "#myBox2");
	//curvyCorners(settings, "#myBox3");
  }
  
function AbrirVentana(nombre, ancho, alto)
{
	abrirVentanac(nombre, ancho, alto,'no','yes');
}
</script>

<style type="text/css" media="all">

#myBox2 {
    color: #fff;
    width: 98%;
    padding: 4px;
    text-align: justify;
    background-color: #cedee1;
    border: 3px solid #fff;
}

body {
	background-color: #5a88b7;
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
   -->
  </style> 
  
</head>

<body onload="cambiar2()">

<table width="1075" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#f2f2f2">
<tr>
      <td width="1071" align="center">
        <table width="1069" height="362" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F2F2F2">
          <tr>
            <td width="100" height="54" align="left" valign="top"><img src="../imagenes/logo2.jpg" width="100" height="60" /></td>
            <td width="869" align="center" valign="middle">MANTENEDOR DE AREAS</td>
            <td width="100" align="left" valign="top"><img src="../imagenes/logo_iso_c.jpg" width="100" height="52" /></td>
          </tr>
          <tr>
            <td height="3" colspan="3" align="center" valign="top"><img src="imagenes/barra.gif" alt="" width="900" height="3" /></td>
          </tr>
          <tr>
            <td height="297" colspan="3" align="center" valign="top"><table width="939" height="297" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
                <tr>
                  <td width="933" height="274" align="center" valign="top"><form id="f" name="f" method="post" action="">
                    <table width="1059" height="342" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
                      <tr>
                        <td width="1059" height="51" align="center"><label></label>
                            <div  id="myBox2" class="txtnormal">
                              <table width="1050" height="66" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td width="100" height="62" align="right"><label>
                                    <input name="in" type="submit" class="boton_inicio" id="in" value="Inicio" onclick="ir('asistencia.php')" />
                                  </label></td>
                                  <td width="181" align="right">&nbsp;</td>
                                  <td width="100" align="center">&nbsp;</td>
                                  <td width="100" align="center">&nbsp;</td>
                                  <td width="100" align="center">&nbsp;</td>
                                <td width="100" align="center"><label></label></td>
                                  <td width="100" align="center"><input name="button" type="submit" class="boton_excel" id="button" value="Reporte" disabled="disabled" /></td>
                                  <td width="100" align="center"><input name="button4" type="button" class="boton_print" id="button2" value="Imprimir" onclick="rep()" disabled="disabled" /></td>
                                  <td width="17" align="right"><input type="hidden" name="usuario_nombre" id="usuario_nombre" value="<?php echo $_SESSION['usuario_nombre']; ?> " /></td>
                                </tr>
                              </table>
                          </div></td>
                      </tr>
                      <tr>
                        <td height="225" align="center" valign="top"><table width="1047" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#cedee1">
                          <tr>
                            <td width="1043" align="center"><table width="1050" height="383" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="3" rowspan="2">&nbsp;</td>
                                <td width="16" align="left" class="txtnormal"><label></label>                                  <label></label></td>
                                <td align="left" class="txtnormal">&nbsp;</td>
                                <td width="256" align="left" class="txtnormal"><label></label></td>
                                <td width="567" align="left" class="txtnormal"><label></label></td>
                              </tr>
                              <tr>
                                <td align="left" class="txtnormal">&nbsp;</td>
                                <td align="left" class="txtnormal">GERENCIA</td>
                                <td width="256" align="left" class="txtnormal">DEPARTAMENTO</td>
                                <td width="567" align="left" class="txtnormal">AREA</td>
                              </tr>
                              
                              <tr>
                                <td width="3">&nbsp;</td>
                                <td height="262" align="left" class="txtnormal">&nbsp;</td>
                                <td width="206" align="left" class="txtnormal"><select name="combo1" size="16" id="combo1" style="width: 200px;" >
                                  <?php
                              //*******************************************************************************************************
								$sql  = "SELECT cod_ger, desc_ger FROM tb_gerencia ORDER BY desc_ger ";
	
								$rs 	= dbConsulta($sql);
								$total  = count($rs);
								echo"<option selected='selected' value='$sel'>$sel</option>";
										
								for ($i = 0; $i < $total; $i++)
								{
									$desc_ger = $rs[$i]['desc_ger'];
									if($sel != $desc_ger){
										echo "<option value='".$rs[$i]['cod_ger']."'>".$rs[$i]['desc_ger']."</option>";
									}
								}
							?>
                                  </select></td>
                                <td width="256" align="left" class="txtnormal"><select name="combo2" size="16" id="combo2" style="width: 250px;" >
                                  <!-- onchange="enviar()"-->
                                  </select>                                </td>
                                <td width="567" align="left" class="txtnormal">
                                  
                                  <select name="combo3" size="16" id="combo3" style="width: 560px;" >
                                    </select>
                                  
                                  </td>
                              </tr>
                              <tr>
                                <td width="3">&nbsp;</td>
                                <td height="24" align="left" class="txtnormal">&nbsp;</td>
                                <td align="left" class="txtnormal"><span class="txtnormal3n">
                                  <input type="button" class="boton_nue2" value="Mantenedor" onclick="AbrirVentana('gerencia.php', '440', '300')" />
                                  </span></td>
                                <td width="256" align="left" class="txtnormal"><span class="txtnormal3n">
                                  <input type="button" class="boton_nue2" value="Mantenedor" onclick="AbrirVentana('dpto.php', '440', '300')" />
                                  </span></td>
                                <td width="567" align="left" class="txtnormal"><span class="txtnormal3n">
                                  <input type="button" class="boton_nue2" value="Mantenedor" onclick="AbrirVentana('area.php', '440', '300')" />
                                  </span></td>
                              </tr>
                              <tr>
                                <td width="3" height="22">&nbsp;</td>
                                <td colspan="4" rowspan="3" align="center" valign="top" class="txtnormal">
								
                                    <div id="resultado"></div><br></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td height="15">&nbsp;</td>
                              </tr>
                            </table></td>
                          </tr>
                        </table>
                        <!-- <div id="myBox" class="txtnormal">-->                          <!-- </div>--></td>
                      </tr>
                      <tr>
                        <td height="37" align="center" valign="bottom"><label></label>&nbsp;
                          <input name="limpia" type="submit" class="boton_lim" id="button6" value="Limpiar" />
                          &nbsp;
                          <!-- <input name="report2" type="button" class="boton_imp" onclick="document.f.action='rep_fsr.php'; document.f.submit()" value="Solicitud R"; /> -->
                          &nbsp;
                          <label></label></td>
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
      </td>
    </tr>
  </table>
</body>
</html>
