<?
/**********************************************************************************************************************************
			NECESARIO PARA VER SI LA SESION ESTA ACTIVA O SI TIENE PERMISOS DE ACCESO
**********************************************************************************************************************************/
require("lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php
//
//Definimos el nivel de acceso  (esto es un bonus track para definir que ciertos usuarios puedan entrar a algunas paginas y a otras no)
// Si los usuarios normales tienen acceso=10, para que  accedan todos los usuarios le damos acceso mayor a 10.
if($_SESSION['us_tipo'] != "Administrador" AND $_SESSION['us_tipo'] != "Supervisor")
{
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}//Hasta aquí lo comun para todas las paginas restringidas
//Hasta aquí lo comun para todas las paginas restringidas
//*********************************************************************************************************************************
//*********************************************************************************************************************************
	include ('inc/config_db.php');
	require ("inc/lib.db.php");

		$est_alta			= 	" ";
		$cliente_cot		= "-------------------- Seleccione -------------------";
//*********************************************************************************************************************************
/**************************************************************************
	COMIENZA REPORTE EXCEL
**************************************************************************/	
	require_once("excelclass/class.writeexcel_workbookbig.inc.php");
	require_once("excelclass/class.writeexcel_worksheet.inc.php");
	require_once("excelclass/functions.writeexcel_utility.inc.php");
	
	$fname="tmp/reporte2.xls";
	
	$workbook   = & new writeexcel_workbookbig($fname);
	$worksheet  = & $workbook->addworksheet('hoja1');
	$worksheet2 = & $workbook->addworksheet('hoja2');
	$worksheet3 = & $workbook->addworksheet('hoja3');
	
	////formato////
	$encabezado=& $workbook->addformat();
	$encabezado->set_size(8);
	$encabezado->set_border_color('black');
	$encabezado->set_top(1);
	$encabezado->set_bottom(1);
	$encabezado->set_left(1);
	$encabezado->set_right(1);
	$encabezado->set_pattern();         # Set pattern to 1, i.e. solid fill
    $encabezado->set_fg_color('silver'); # Note foreground and not background
    //$encabezado->write(0, 0, "Ray", $encabezado);
	$formato=& $workbook->addformat();
	$formato->set_size(8);
	$formato->set_border_color('black');
	$formato->set_top(1);
	$formato->set_bottom(1);
	$formato->set_left(1);
	$formato->set_right(1);
	$formato->set_text_justlast(0);
	
	$for_titulo=& $workbook->addformat();
	$for_titulo->set_bold();
	$for_titulo->set_align('center');
	$for_titulo->set_align('vcenter');
	$for_titulo->set_fg_color('white');
	$for_titulo->set_border_color('yellow');
	$for_titulo->set_pattern(0x1);
	$for_titulo->set_merge(); # This is the key feature
	$formato2=& $workbook->addformat();
	$formato2->set_size(10);
	$worksheet->set_column(0,30,15);
	$worksheet->set_row(0,15);
	/*for($a=1;$a<100;$a++)
	{
		$worksheet->set_row($a,12);
	}*/
	$tit_subt=& $workbook->addformat();
	$tit_subt->set_bold();
	$tit_subt->set_size(8);
	$tit_subt->set_border_color('black');
	
	
	// titulo
	$worksheet->write(2,3,"REPORTE TRABAJADORES INGRESADOS",$for_titulo);
	$worksheet->write(0,0,"",$for_titulo);
	$worksheet->write(0,1,"",$for_titulo);
	$worksheet->write(0,2,"",$for_titulo);
	$worksheet->write(0,3,"",$for_titulo);
	$worksheet->write(0,4,"",$for_titulo);
	$worksheet->write(0,5,"",$for_titulo);
	$worksheet->write(0,6,"",$for_titulo);
	
	$worksheet2->write(3,4,"HOJA 2",$for_titulo);
	$worksheet3->write(3,4,"HOJA 3",$for_titulo);
	
	// ENCABEZADOS
	
	$worksheet->write(5,0,"RUT",$encabezado);
	$worksheet->write(5,1,"NOMBRE",$encabezado);
	$worksheet->write(5,2,"GERENCIA",$encabezado);
	$worksheet->write(5,3,"DEPARTAMENTO",$encabezado);
	$worksheet->write(5,4,"AREA",$encabezado);
	$worksheet->write(5,5,"CARGO",$encabezado);
	$worksheet->write(5,6,"ESTADO",$encabezado);
	$worksheet->insert_bitmap('A1', 'imagenes/logo.bmp', 1, 1);	
	
/**************************************************************************
	
**************************************************************************/	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mantenedor Trabajadores</title>

<link href="inc/bibliocss.css" rel="stylesheet" type="text/css">
<LINK href="inc/epoch_styles.css" type=text/css rel=stylesheet>
<SCRIPT src="inc/epoch_classes.js" type=text/javascript></SCRIPT>

<script type="text/javascript" language="JavaScript" src="inc/funciones.js"></script>

<script language="javascript" src="js/jquery-1.2.6.min.js"></script>

<script LANGUAGE="JavaScript">

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
	alert("Los trabajadores no se pueden eliminar... solo dar de Baja (cambiar estado a NULO)");
	return false ;
}

function carga(rut,nom,app_t,apm_t,area_t,cargo_t,fonom_t)
{
    document.formtrab.t1.value = rut;
	document.formtrab.t2.value = nom;
	document.formtrab.t3.value = app_t;
	document.formtrab.t4.value = apm_t;
	document.formtrab.t5.value = fonom_t;
	document.formtrab.t6.value = cargo_t;
	document.formtrab.t7.value = fonom_t;
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
				$.post("c2.php", { elegido: elegido }, function(data){
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

function ir(url)
{
	document.formtrab.action=url;
}

var dp_cal;
window.onload = function () {
	stime = new Date();
	dp_cal 	  = new Epoch('dp_cal','popup',document.getElementById('date_field'));
}; 

function CambiaColor(esto,fondo,texto)
{
    esto.style.background=fondo;
    esto.style.color=texto;
	esto.style.cursor='hand';
	esto.style.bordercolor=fondo;
}

function enviar(url)
{
	document.formtrab.action=url;
}

/**********************************************************************************************************************
***********************************************************************************************************************
CARGAR COMBO CLIENTES SIN RECARGAR LA PAGINA
PARAMETROS:
- Div donde esta el combo
- Div para mostrar el resultado
- Comando = campo hidden
- Nombre del combo ya actualizado
/**********************************************************************************************************************
***********************************************************************************************************************/
var comando;
var resultado;

function CargarDatos(valor) 
{
	 if (valor != 0) 
	 {
		comando 	= "accion=carga_datos&id=" + valor;
		resultado 	= "DivDatos";
		Ajax();
	 }
}

function CargarNombres()
{
	 comando 	= "accion=carga_nombres";
	 resultado 	= "DivNombres";
	 Ajax();
}

function Ajax() 
{
 	crearObjeto();
 	if (objeto.readyState != 0) 
	{
   		alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
 	}else {
   		if (!comando) {
 		// si no hay comando.. es porque se esta mandando llamar de la ventana emergente
     	comando = document.getElementById("ComandoRemoto").value;
   }
// indicar la funcion que procesa el resultado
   objeto.onreadystatechange = procesaResultado;
// enviar los datos - el "random" es porque se puede detectar que intentas leer los mismos datos; entonces, alenviarle
// un numero en random es como si pidieras los datos nuevos (no los que estan en memoria)
   objeto.open("GET", "poput/combo_car.php?" + comando + "&random=" + Math.random(), true);
// ni idea para que es esto (pero si no lo pones no funciona) tongue.gif
   objeto.send(null);
 }
}

function procesaResultado() 
{
	if (objeto.readyState == 1) 
	{
   		// cargando..
	}
	if (objeto.readyState == 4) 
	{
		// poner el resultado en "datos"
			datos = objeto.responseText;
		// poner el resultado en el Div que corresponde
		   	document.getElementById(resultado).innerHTML = datos;
		// limpiar las acciones
			comando = "";
			document.getElementById("ComandoRemoto").value = "";
	}
}
// inicio - conexion
var objeto = false;

function crearObjeto() {
 try { objeto = new ActiveXObject("Msxml2.XMLHTTP"); }
 catch (e) {
   try { objeto = new ActiveXObject("Microsoft.XMLHTTP"); }
   catch (E) { objeto = false; }
 }
 if (!objeto && typeof XMLHttpRequest!='undefined') {
   objeto = new XMLHttpRequest();
 }
}
// fin - conexion

<!-- hasta aqui termina el codigo de ajax-->
/**********************************************************************************************************************
**********************************************************************************************************************/

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
/**********************************************************************************************************************************
			CARGAMOS LOS DATOS DEL RUT QUE NOS ENVIO LA LISTA
**********************************************************************************************************************************/	
if($_POST['busca'] == "Buscar")
{	
	$query = "SELECT * FROM trabajadores WHERE rut_t = '".$_POST['t1']."' ";
}
if($_POST['ingresa'] != "")
{
	$query = "SELECT * FROM trabajadores WHERE cod_trab = '".$_POST['ingresa']."' ";
}
if($_POST['modifica'] != "")
{
	$query = "SELECT * FROM trabajadores WHERE cod_trab ='".$_POST['modifica']."' ";
}

if($_GET['cod'] != "")
{
	$query = "SELECT * FROM trabajadores WHERE cod_trab = '".$_GET['cod']."' ";
}

if($_POST['elimina_item'] != "")
{
	$query = "SELECT * FROM trabajadores WHERE cod_sol='".$_POST['elimina_item']."' ";
}


if($_POST['busca'] == "Buscar" or $_POST['ingresa'] != "" or $_POST['modifica'] != "" or $_GET['cod'] != "" )
{	
	$sqlc = $query;
	$respuesta=mysql_query($sqlc,$co);
	while($vrows=mysql_fetch_array($respuesta))
	{
		$cod_t		= "".$vrows['cod_trab']."";
		$rut_t		= "".$vrows['rut_t']."";
		$nom_t		= "".$vrows['nom_t'].""; 
		$app_t		= "".$vrows['app_t']."";
		$apm_t		= "".$vrows['apm_t']."";
		$area_t		= "".$vrows['area_t'].""; 
		$cargo_t	= "".$vrows['cargo_t'].""; 
		$fonom_t	= "".$vrows['fonom_t'].""; 
		$fonoc_t	= "".$vrows['fonoc_t']."";
		$correo_t	= "".$vrows['correo_t'].""; 
		$ruta_foto	= "".$vrows['ruta_foto']."";
		$est_alta	= "".$vrows['est_alta']."";
		$fe_nulo	= "".$vrows['fe_nulo']."";
		
		$sql_cargo = "SELECT * FROM tb_cargos WHERE cod_cargo = '$cargo_t' ";
		$res_cargo = mysql_query($sql_cargo,$co);
		while($vrowres_cargo=mysql_fetch_array($res_cargo))
		{
			$cod_cargo	= "".$vrowres_cargo['cod_cargo']."";
			$nom_cargo	= "".$vrowres_cargo['nom_cargo']."";
		}
		
		$sql_a 		= "SELECT * FROM tb_areas WHERE cod_ar = '$area_t' ";
		$resp_a		= mysql_query($sql_a,$co);
		$total_a 	= mysql_num_rows($resp_a);
		
		while($vrows_a = mysql_fetch_array($resp_a))
		{
			$area_t 	= "".$vrows_a['desc_ar']."";
			$cod_ar 	= "".$vrows_a['cod_ar']."";
			$cod_dep 	= "".$vrows_a['cod_dep']."";
		
				$sql_dpto 	= "SELECT * FROM tb_dptos WHERE cod_dep ='$cod_dep' ";
				$resp_dpto	= mysql_query($sql_dpto,$co);
				while($vrowsd=mysql_fetch_array($resp_dpto))
				{
					$desc_dep 	= "".$vrowsd['desc_dep']."";
					$cod_dep 	= "".$vrowsd['cod_dep']."";
					$cod_ger 	= "".$vrowsd['cod_ger']."";
					
					$sql_ger 	= "SELECT * FROM tb_gerencia WHERE cod_ger ='$cod_ger' ";
					$resp_ger	= mysql_query($sql_ger,$co);
					while($vrowsd=mysql_fetch_array($resp_ger))
					{
						$desc_ger 	= "".$vrowsd['desc_ger']."";
						$cod_ger 	= "".$vrowsd['cod_ger']."";
					}
					
				}	
		}  							
	}
}
?>
<table width="900" height="486" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F2F2F2">
  <tr>
    <td width="100" height="54" align="center" valign="top"><img src="imagenes/logo2.jpg" width="100" height="60" /></td>
    <td width="707" align="center" valign="middle"><img src="imagenes/Titulos/TRABAJADORES.png" width="400" height="40" /></td>
    <td width="93" align="center" valign="top"><img src="imagenes/logo_iso_c.jpg" width="93" height="50" /></td>
  </tr>
  <tr>
    <td height="5" colspan="3" align="center" valign="top"><img src="imagenes/barra.gif" width="100%" height="3" /></td>
  </tr>
  <tr>
    <td height="412" colspan="3" align="center" valign="top">
    
    <table width="890" height="258" border="0" class="txtnormal">
      <tr>
        <td width="882" height="225" align="center" valign="top">
        
        <form name="formtrab" enctype="multipart/form-data" action="" method="post">
          <table width="880" height="59" border="1" bordercolor="#FFFFFF" bgcolor="#cedee1">
            <tr>
              <td height="53" align="center"><table width="864" border="0" cellpadding="0">
                <tr>
                  <td width="40"><a href='bajar_excel.php?filename=<? echo $fname ?>'>
                    <input name="in" type="submit" class="boton_volver" id="in" value="Volver" onclick="ir('index2.php')" />
                  </a></td>
                  <td width="552">&nbsp;</td>
                  <td width="85">&nbsp;</td>
                  <td width="85"><input name="button2" type="submit" class="boton_trab" id="button9" value="Listado Trabajadores" onclick="enviar('lista_trab.php')" /></td>
                  <td width="90">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          </table>
          <table width="880" height="406" border="1" bordercolor="#FFFFFF" bgcolor="#cedee1">
            <tr>
              <td height="400" align="center"><table width="850" height="392" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
                <tr>
                  <td width="186" height="5" align="left" valign="middle">&nbsp;</td>
                  <td colspan="3" align="center" valign="middle">	
                    <span class="txt_rojo"> Campos obligatorios (*)</span></td>
                  <td width="226" rowspan="16" align="center" valign="middle"><table width="154" height="225" border="1" bordercolor="#FFFFFF">
                    <tr>
                      <td align="center"><? echo"<img src='$ruta_foto' width='154' height='225' />";?></td>
                      </tr>
                    </table>
                    Fotografia</td>
                </tr>
                <tr>
                  <td height="25" align="left" valign="middle">Codigo</td>
                  <td colspan="3" align="left" valign="middle">&nbsp;<?php echo $cod_t; ?></td>
                </tr>
                <tr>
                  <td width="186" height="22" align="left" valign="middle">Rut<span class="txt_rojo">
                      <input name="cod_t" type="hidden" id="cod_t" value="<? echo $cod_t; ?>" />
Ej 12859756-5 (Sin puntos)</span></td>
                  <td height="22" colspan="3" align="left" valign="middle"><input name="t1" type="text" id="textfield6" style="width:105px;" value="<? echo $rut_t; ?>" onchange="Valida_Rut(this);" />
                    <label>&nbsp;<span class="txt_rojo">&nbsp;(*)</span></label></td>
                </tr>
                <tr>
                  <td height="25" align="left">Nombre</td>
                  <td colspan="3" align="left"><input name="t2" type="text" id="textfield" value="<? echo $nom_t; ?>" size="30" />
                    <label><span class="txt_rojo"> (*)</span></label></td>
                  </tr>
                <tr>
                  <td height="25" align="left">Apellido Paterno</td>
                  <td colspan="3" align="left"><input name="t3" type="text" id="textfield2" value="<? echo $app_t; ?>" size="30" />
                    <span class="txt_rojo"> (*)</span></td>
                </tr>
                <tr>
                  <td height="25" align="left">Apellido Materno</td>
                  <td colspan="3" align="left"><input name="t4" type="text" id="textfield3" value="<? echo $apm_t; ?>" size="30" />
                    <span class="txt_rojo"> (*)</span></td>
                  </tr>
                <tr>
                  <td height="6" align="left">Gerencia</td>
                  <td colspan="3" align="left">
                  
                  
                  <select name="combo1" class="combos" id="combo1" style="width: 204px;" >
                      <?php
                              //*******************************************************************************************************
								$sql  = "SELECT cod_ger, desc_ger FROM tb_gerencia ORDER BY desc_ger ";
	
								$rs 	= dbConsulta($sql);
								$total  = count($rs);
								echo"<option selected='selected' value='$cod_ger'>$desc_ger</option>";
										
								for ($i = 0; $i < $total; $i++)
								{
									$desc_ger = $rs[$i]['desc_ger'];
									if($sel != $desc_ger){
										echo "<option value='".$rs[$i]['cod_ger']."'>".$rs[$i]['desc_ger']."</option>";
									}
								}
							?>
                    </select>
                  <span class="txt_rojo"> (*)</span></td>
                  </tr>
                <tr>
                  <td height="5" align="left">Departamento</td>
                  <td colspan="3" align="left"><select name="combo2" class="combos" id="combo2" style="width: 204px;" >
                    <?php echo"<option selected='selected' value='$cod_dep'>$desc_dep</option>"; ?>
                  </select>
                    <span class="txt_rojo"> (*)</span> </td>
                </tr>
                <tr>
                  <td height="10" align="left">Area</td>
                  <td colspan="3" align="left"><select name="combo3" class="combos" id="combo3" style="width: 204px;">
                  <?php echo"<option selected='selected' value='$cod_ar'>$area_t</option>"; ?>
                  </select>
                    <span class="txt_rojo"> (*)</span></td>
                </tr>
                <tr>
                  <td height="21" align="left">Cargo</td>
                  <td width="300" align="left">
                  
                  <div id="DivNombres">
                    <select name="c1" class="combos" id="c1" style="width:300px;" onchange="CargarDatos(this.value)">
                      <?php
									$co=mysql_connect("$DNS","$USR","$PASS");
								
									$sql_c  	= "SELECT * FROM tb_cargos ORDER BY nom_cargo";
									$rs_c 		= dbConsulta($sql_c);
									$total_c  	= count($rs_c);
									echo"<option selected='selected' value='$cod_cargo'>$nom_cargo</option>";
											
									for ($i = 0; $i < $total_c; $i++)
									{
										$nom_cargo = $rs_c[$i]['nom_cargo'];
										if($nom_cargo != $cargo){
											echo "<option value='".$rs_c[$i]['cod_cargo']."'>".htmlentities(utf8_decode($rs_c[$i]['nom_cargo']))."</option>";
										}
									}
							?>
                    </select>
                  </div>
                  
                  <div id="resultado"></div>                  </td>
                  <td width="23" align="left"><span class="Estilo5">
                    <input name="clientes" type="button" class="otro" id="agregar" value="  ? " onclick="abrirVentanac('poput/cargos.php','470','400','yes','yes');"/>
                    <input type="hidden" name="ComandoRemoto" id="ComandoRemoto" />
                  </span></td>
                  <td width="115" align="left">&nbsp;</td>
                </tr>
                <tr>
                  <td height="23" align="left">Fono Movil</td>
                  <td colspan="3" align="left"><input name="t5" type="text" id="textfield7" value="<? echo $fonom_t; ?>" size="30" /></td>
                  </tr>
                <tr>
                  <td height="23" align="left">Fono Casa</td>
                  <td colspan="3" align="left"><input name="t6" type="text" id="textfield8" value="<? echo $fonoc_t; ?>" size="30" /></td>
                  </tr>
                <tr>
                  <td height="23" align="left">Correo</td>
                  <td colspan="3" align="left"><input name="t7" type="text" id="textfield9" value="<? echo $correo_t; ?>" size="30" /></td>
                  </tr>
                <tr>
                  <td align="left">Fotografia</td>
                  <td colspan="3" align="left"><input name="archivo_usuario" type="file" id="archivo_usuario" value="" size="30" /></td>
                  </tr>
                <tr>
                  <td align="left">Estado</td>
                  <td colspan="3" align="left"><label>
                    <select name="estado" id="estado">
                      <?php 
					if($rut_t == ""){$est_alta = "Vigente";}
						echo"<option selected='selected' value='$est_alta'>$est_alta</option>"; ?>
                      <option value="Vigente">Vigente</option>
                      <option value="Nulo">Nulo</option>
                      </select>
                    <span class="txt_rojo"> (*)</span></label></td>
                  </tr>
                <tr>
                  <td align="left">Fecha de baja</td>
                  <td colspan="3" align="left"><span class="content">
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
                  </span><span class="txt_rojo">&nbsp;&nbsp;&nbsp;&nbsp;A partir de esta fecha el trabajador no aparecera en el area a la cual esta asociado.</span></td>
                </tr>
              </table>
                </td>
            </tr>
          </table>
          <table width="880" border="1" bordercolor="#FFFFFF" bgcolor="#cedee1">
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
        
        </td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td height="5" colspan="3" align="center" valign="top"><img src="imagenes/barra.gif" alt="" width="100%" height="3" /></td>
  </tr>
</table>
  <?php
  $workbook->close();		
  ?>
</body>
</html>
