<?
/**********************************************************************************************************************************
			NECESARIO PARA VER SI LA SESION ESTA ACTIVA O SI TIENE PERMISOS DE ACCESO
**********************************************************************************************************************************/
require("../lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php
//
//Definimos el nivel de acceso  (esto es un bonus track para definir que ciertos usuarios puedan entrar a algunas paginas y a otras no)
// Si los usuarios normales tienen acceso=10, para que  accedan todos los usuarios le damos acceso mayor a 10.
if($_SESSION['us_tipo'] != "Administrador")
{
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}//Hasta aquí lo comun para todas las paginas restringidas
//Hasta aquí lo comun para todas las paginas restringidas
//*********************************************************************************************************************************

//*********************************************************************************************************************************
	include('../inc/config_db.php');	// CONECCION A LA BASE DE DATOS
	require('../inc/lib.db.php');
	
	$fe			= date("Y-m-d");
	$ger 		= "Todos";
	$area 		= "Todos";
	$dpto 		= "Todos";
	$ing_por 	= "Todos";
	
//comparo la fecha de hoy con la fecha limite
/*function comparar_fechas($fecha_hoy, $fecha_baja)
{
	list ($dia_hoy, $mes_hoy, $anio_hoy) = explode("/", $fecha_hoy); //separo laos dias, los meses y los años
	list ($dia_limite, $mes_limite, $anio_limite) = explode("/", $fecha_baja);
	
	//comparo primero los años para saber si es mayor igual o menor
	if($anio_hoy > $anio_limite) $resp="Mayor";
		elseif ($anio_hoy < $anio_limite) $resp="Menor";
			elseif($mes_hoy > $mes_limite) $resp="Mayor";
				elseif ($mes_hoy < $mes_limite) $resp="Menor";  
					elseif($dia_hoy > $dia_limite) $resp="Mayor";
						elseif ($dia_hoy < $dia_limite) $resp="Menor"; 
							else $resp="Igual";
							
							return $resp;
} */
/*********************************************************************************************************************										
										FUNCION PARA CREAR ENCABEZADO									
*********************************************************************************************************************/	
function encab()
{
	echo"<table width='883' border='1' cellpadding='0' cellspacing='0' bordercolor='#FFFFFF'>
                              <tr class='txtnormaln' bgcolor='#cedee1'>
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
	echo"</table><br>";
}
/*********************************************************************************************************************										
										FUNCION PARA CREAR FILA										
*********************************************************************************************************************/	
function filanm($num, $cod_det_as, $nom_tf, $app_tf, $apm_tf, $rut_det_as, $estado_det_as, $motivo_det_as, $observ_det_as, $check1, $check2	)
{
	 						echo"<tr>
								<td height='12' align='center'>$num</td>
                                <td height='12' align='left'>&nbsp;&nbsp;".$nom_tf." ".$app_tf." ".$apm_tf."</td>
                                <td width='50' align='center'><input name='presente[]' type='checkbox' class='cajas' id='checkbox[]' onclick='cambiar(this)' $check1 /></td>
                                <td width='62' align='center'><input name='ausente[]' type='checkbox' class='cajas' id='checkbox[]' onclick='cambiar(this)' $check2 /></td>
                                <td width='149' align='center'>
								
								<select name='motivo[]' class='combos' id='motivo' style='width: 140px' >
                                  <option selected='selected' value='$motivo_det_asv'>$motivo_det_asv</option>
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
								</td>
								 </tr>"; 
}
/**************************************************************************
	COMIENZA REPORTE EXCEL
**************************************************************************/	
	require_once("excelclass/class.writeexcel_workbookbig.inc.php");
	require_once("excelclass/class.writeexcel_worksheet.inc.php");
	require_once("excelclass/functions.writeexcel_utility.inc.php");
	
	$fname="tmp/reporte.xls";
	
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
	$worksheet->write(2,3,"REPORTE ASISTENCIA",$for_titulo);
	$worksheet->write(0,0,"",$for_titulo);
	$worksheet->write(0,1,"",$for_titulo);
	$worksheet->write(0,2,"",$for_titulo);
	$worksheet->write(0,3,"",$for_titulo);
	$worksheet->write(0,4,"",$for_titulo);
	$worksheet->write(0,5,"",$for_titulo);
	$worksheet->write(0,6,"",$for_titulo);
	$worksheet->write(0,7,"",$for_titulo);
	
	$worksheet2->write(3,4,"HOJA 2",$for_titulo);
	$worksheet3->write(3,4,"HOJA 3",$for_titulo);
	
	// ENCABEZADOS
	
	$worksheet->write(5,0,"GERENCIA",$encabezado);
	$worksheet->write(5,1,"DEPARTAMENTO",$encabezado);
	$worksheet->write(5,2,"AREA",$encabezado);
	$worksheet->write(5,3,"ESTADO INFORME",$encabezado);
	$worksheet->write(5,4,"NOMBRE TRABAJADOR",$encabezado);
	$worksheet->write(5,5,"RUT TRABAJADOR",$encabezado);
	$worksheet->write(5,6,"ESTADO TRABAJADOR",$encabezado);
	$worksheet->write(5,7,"MOTIVO",$encabezado);
	$worksheet->insert_bitmap('A1', '../imagenes/logo.bmp', 1, 1);	
	
/**************************************************************************
	
**************************************************************************/	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Asistencia MGYT</title>

<script type="text/javascript" language="JavaScript" src="inc/funciones.js"></script>

<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">
<LINK href="../inc/epoch_styles.css" type=text/css rel=stylesheet>
<SCRIPT src="../inc/epoch_classes.js" type=text/javascript></SCRIPT>
<script type="text/JavaScript" src="curvycorners.src.js"></script>
<link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxgrid.css"><!-- llama hoja de estilo -->

<script language="javascript" src="js/jquery-1.2.6.min.js"></script>

<script language="javascript">
var dp_cal;
window.onload = function () {
	stime = new Date();
	dp_cal 	  = new Epoch('dp_cal','popup',document.getElementById('date_field'));
}; 

function CambiaColor(esto,fondo,texto)
{
    esto.style.background=fondo;
    esto.style.color=texto;
	esto.style.bordercolor=fondo;
}

function ir(url)
{
	document.f.action=url;
}
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
		document.f.action='procesa_a.php'; 
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
  
function evento()
{
	document.f.submit();
} 

function abrir_v()
{
	abrirVentanac('ausentes.php?tipo='+valor, '650','300','no','yes');
}
</script>

<style type="text/css">

#myBox {
    color: #fff;
    width: 99%;
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
    width: 99%;
    padding: 4px;
    text-align: justify;
    background-color: #cedee1;
    border: 3px solid #fff;
}
#myBox3 {
    color: #fff;
    width: 99%;
    padding: 1px;
    text-align: justify;
    background-color: #F2F2F2;
    border: 3px solid #fff;
}
body {
	background-color: #5a88b7;
}
.Estilo5 {color: #000000}
</style>
</head>

<body>
<?php 	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);	
	
	if($_POST['busca'] == "Buscar")
	{
		$fe = $_POST['fe_b'];
		$fe	=	cambiarFecha($fe, '/', '-' ); 
	}
?>

  <table width="944" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center"><div id="myBox3" class="txtnormal">
        <table width="944" height="354" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="100" height="54" align="left" valign="top"><img src="../imagenes/logo2.jpg" width="100" height="60" /></td>
            <td width="740" align="center" valign="middle"><img src="../imagenes/Titulos/ASISTENCIA.png" width="400" height="40" /></td>
            <td width="100" align="left" valign="top"><img src="../imagenes/logo_iso_c.jpg" width="100" height="52" /></td>
          </tr>
          <tr>
            <td height="3" colspan="3" align="center" valign="top"><img src="imagenes/barra.gif" alt="" width="900" height="3" /></td>
          </tr>
          <tr>
            <td height="289" colspan="3" align="center" valign="top"><table width="939" height="288" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
                <tr>
                  <td width="933" height="273" align="center" valign="top"><form id="f" name="f" method="post" action="">
                      <table width="926" height="266" border="0" cellpadding="0" cellspacing="0" class="tablas">
                        <tr>
                          <td width="920" height="266" align="center" valign="top"><table width="918" height="266" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
                              <tr>
                                <td height="51" align="center"><div  id="myBox2" class="txtnormal">
                                    <table width="892" height="66" border="0" cellpadding="0" cellspacing="0">
                                      <tr>
                                        <td width="100" height="62" align="right"><label>
                                          <input name="button8" type="submit" class="boton_inicio" id="button8" value="Inicio" onclick="ir('asistencia.php')" />
                                        </label></td>
                                        <td width="181" align="right">&nbsp;</td>
                                        <td width="100" align="center">&nbsp;</td>
                                        <td width="100" align="center">&nbsp;</td>
                                        <td width="100" align="center">&nbsp;</td>
                                        <td width="100" align="center"><label></label></td>
                                        <td width="100" align="center"><a href='bajar_excel.php?filename=<? echo $fname ?>'><img src="../imagenes/botones/rep_excel.jpg" border="0" /></a></td>
                                        <td width="100" align="center"><input name="button4" type="button" class="boton_print" id="button2" value="Imprimir" onclick="rep()" disabled="disabled" /></td>
                                        <td width="25" align="right"><input type="hidden" name="usuario_nombre" id="usuario_nombre" value="<?php echo $_SESSION['usuario_nombre']; ?> " /></td>
                                      </tr>
                                    </table>
                                </div></td>
                              </tr>
                              <tr>
                                <td height="19" align="center" valign="bottom">
                                    <div id="myBox" class="txtnormal">
                                    <br>
                                    <fieldset class="txtnormalB">
                                      <legend class="txtnormaln">Buscar informes por fecha</legend><br>
                                      <table width="348" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="69">Fecha</td>
                                          <td width="150"><span class="content">
                                            <? $fe	=	cambiarFecha($fe, '-', '/' ); ?>
                                          <input name="fe_b" class="cajas" id="date_field" style="WIDTH: 7em" value="<? echo $fe; ?>" />
                                            <input type="button" class="botoncal" onclick="dp_cal.toggle();"  onmouseup="oculta('aux')" />
                                          </span>
                                            <label></label></td>
                                          <td width="129"><input name="busca" type="submit" class="boton_bus" id="busca" value="Buscar" /></td>
                                        </tr>
                                      </table>
                                    </fieldset>
                                      <br>
                                      
                                      <fieldset class="txtnormalB">
                                      <?php $fe	=	cambiarFecha($fe, '-', '/' ); ?>
                                      <legend class="txtnormaln">Informes ingresados <?php echo $fe ?></legend>
                                        <?php $fe	=	cambiarFecha($fe, '/', '-' ); ?>
                                      <br>
                                      <table width="891" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" bgcolor="#cedee1" class="txtnormal">
                                        <tr height="25" bgcolor="#cedee1" bordercolor="#cedee1">
                                          <td width="2%" align="center" class="txtnormaln">Nº</td>
                                          <td width="27%" align="center" class="txtnormaln">GERENCIA</td>
                                          <td width="19%" align="center" class="txtnormaln">DEPARTAMENTO</td>
                                          <td width="20%" align="center" class="txtnormaln">AREA</td>
                                          <td width="5%" align="center" class="txtnormaln">TOTAL</td>
                                          <td width="3%" align="center" class="txtnormaln">PRE</td>
                                          <td width="3%" align="center" class="txtnormaln">AUS</td>
                                          <td width="18%" align="center" class="txtnormaln">INGRESADO POR</td>
                                          <td width="3%" align="center" class="txtnormaln">EDIT</td>
                                        </tr>
                                        <tr height="25" bordercolor="#cedee1">
                                          <td width="2%" align="center" class="txtnormaln">&nbsp;</td>
                                          <td width="27%" align="center">
							<?
								  if($ger != "" ){$ger = $_POST['c_ger'];}
								  if($ger == ""){$ger = "Todos";} 
			  				?>
                                <select name="c_ger" id="c_ger"  style="font-size:10px;" onchange="evento();">
                                <?php
								$co=mysql_connect("$DNS","$USR","$PASS");
								mysql_select_db("$BDATOS", $co);
					
                              	$sql_g	= "SELECT * FROM tb_gerencia WHERE cod_ger = '$ger' ";
								$res_g	= mysql_query($sql_g,$co);
								while($vrowsg=mysql_fetch_array($res_g))
								{
									$ger	= "".$vrowsg['desc_ger']."";
									$cod_ger= "".$vrowsg['cod_ger']."";
								}
								$sqlg    = "SELECT * FROM tb_gerencia ORDER BY desc_ger ";
	
								$rsg 	 = dbConsulta($sqlg);
								$totalg  = count($rsg);
								echo"<option selected='selected' value='$cod_ger'>$ger</option>";
								if($ger != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}
										
								for ($i = 0; $i < $totalg; $i++)
								{
									echo "<option value='".$rsg[$i]['cod_ger']."'>".$rsg[$i]['desc_ger']."</option>";
								}
							?>
                               </select></td>
                                        <td width="19%" align="center" class="txtnormaln"><span class="Estilo5">
                                <?
									if($dpto != "" ){$dpto = $_POST['c_dpto'];}
									if($dpto == "" ){$dpto = "Todos";}
								?>
                               <select name="c_dpto" id="c_dpto"  style="font-size:10px;" onchange="evento();">
                            <?php
								$co=mysql_connect("$DNS","$USR","$PASS");
								mysql_select_db("$BDATOS", $co);
								
                              	$sql_g	= "SELECT * FROM tb_dptos WHERE cod_dep = '$dpto' ";
								$res_g	= mysql_query($sql_g,$co);
								while($vrowsg=mysql_fetch_array($res_g))
								{
									$dpto	= "".$vrowsg['desc_dep']."";
									$cod_dep= "".$vrowsg['cod_dep']."";
								}
								
								$sqlg    = "SELECT * FROM tb_dptos WHERE cod_ger = '".$_POST['c_ger']."' ORDER BY desc_dep ";
								
								$rsg 	 = dbConsulta($sqlg);
								$totalg  = count($rsg);
								echo"<option selected='selected' value='$cod_dep'>$dpto</option>";
								
								if($dpto != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}
									
								for ($i = 0; $i < $totalg; $i++)
								{
									echo "<option value='".$rsg[$i]['cod_dep']."'>".$rsg[$i]['desc_dep']."</option>";
								}
							?>
                                          </select>
                                        </span></td>
                                          <td width="20%" align="center" class="txtnormaln"><span class="Estilo5">
              <?
              if($area != "" ){$area = $_POST['c_area'];}
			  if($area == "" ){$area = "Todos";}
			  ?>
              <select name="c_area" id="c_area"  style="font-size:10px;" onchange="evento();">
                <?php
								$co=mysql_connect("$DNS","$USR","$PASS");
								mysql_select_db("$BDATOS", $co);
					
                              	$sql_g	= "SELECT * FROM tb_areas WHERE cod_ar = '$area' ";
								$res_g	= mysql_query($sql_g,$co);
								while($vrowsg=mysql_fetch_array($res_g))
								{
									$area	= "".$vrowsg['desc_ar']."";
									$cod_ar = "".$vrowsg['cod_ar']."";
								}
								$sqlg    = "SELECT * FROM tb_areas WHERE cod_dep = '".$_POST['c_dpto']."' ORDER BY desc_ar ";
	
								$rsg 	 = dbConsulta($sqlg);
								$totalg  = count($rsg);
								echo"<option selected='selected' value='$cod_ar'>$area</option>";
								if($area != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}
										
								for ($i = 0; $i < $totalg; $i++)
								{
									echo "<option value='".$rsg[$i]['cod_ar']."'>".$rsg[$i]['desc_ar']."</option>";
								}
							?>
              </select>
                                          </span></td>
                                          <td width="5%" align="center" class="txtnormaln">&nbsp;</td>
                                          <td width="3%" align="center" class="txtnormaln">&nbsp;</td>
                                          <td width="3%" align="center" class="txtnormaln">&nbsp;</td>
                                        <td width="18%" align="center" class="txtnormaln">&nbsp;</td>
                                          <td width="3%" align="center" class="txtnormaln">&nbsp;</td>
<?php	
/***********************************************************************************************************************
				FILTRAMOS
***********************************************************************************************************************/	
if($_POST['c_ger'] != "Todos" and $_POST['c_ger'] != "")
{
	$query_g = "and cod_ger = '".$_POST['c_ger']."'";
}

if($_POST['c_dpto'] != "Todos" and $_POST['c_dpto'] != "")
{
	$query_d = "and cod_dep = '".$_POST['c_dpto']."'";
}

if($_POST['c_area'] != "Todos" and $_POST['c_area'] != "")
{
	$query_a = "and cod_ar = '".$_POST['c_area']."'";
}	
$filaexcel = 6;
$total_mgyt = 0;
/***********************************************************************************************************************
					CONSULTAMOS LOS REGISTROS (DIA DE HOY O DIA SELECIONADO)
***********************************************************************************************************************/	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sql1	= "SELECT * FROM trabajadores";
	$resp1	= mysql_query($sql1,$co);
	$total1 = mysql_num_rows($resp1);

	$sql_ger 	= "SELECT * FROM tb_gerencia WHERE cod_ger != 'pedro' $query_g ";
	$resp_ger	= mysql_query($sql_ger,$co);
	
	unset($gerencia);
	while($vrowsg=mysql_fetch_array($resp_ger))
	{
		$gerencia[] = $vrowsg;
	}
	$n 			= 1;
	$g			= 0;
	
	$total_g 	= count($gerencia);

	
	while($g < $total_g)
	{
		$desc_ger = $gerencia[$g]['desc_ger'];
		$cod_ger  = $gerencia[$g]['cod_ger'];
		
		$sql_dpto 	= "SELECT * FROM tb_dptos WHERE cod_ger ='$cod_ger' $query_d ";
		$resp_dpto	= mysql_query($sql_dpto,$co);
		
		unset($departamento);
		while($vrowsd=mysql_fetch_array($resp_dpto))
		{
			$departamento[] = $vrowsd;
		}
		
		$dep			= 0;
		$total_d 	= count($departamento);
		
		while($dep < $total_d)
		{
			$desc_dep = $departamento[$dep]['desc_dep'];
			$cod_dep  = $departamento[$dep]['cod_dep'];
			
			$sql_a 		= "SELECT * FROM tb_areas WHERE cod_dep = '$cod_dep' '$query_a' ";
			$resp_a		= mysql_query($sql_a,$co);
			
			unset($areas);
			while($vrowsa = mysql_fetch_array($resp_a))
			{ 
				$areas[] = $vrowsa;
			}
			
			$fe			= cambiarFecha($fe, '/', '-');
			$color = "#ffffff";
			
			$a = 0;
			$total_a 	= count($areas);
			
			while($a < $total_a)
			{	
				$fe			= cambiarFecha($fe, '/', '-' ); 
				$fe_b		= cambiarFecha($_POST['fe_b'], '/', '-' ); 
				$desc_ar 	= $areas[$a]['desc_ar'];
				$cod_ar  	= $areas[$a]['cod_ar'];
				
				$sql2	= "SELECT * FROM trabajadores WHERE area_t = '$cod_ar' ";
				$resp2	= mysql_query($sql2,$co);
				//$total2 = mysql_num_rows($resp2);
				unset($ttpa);
				while($vrowstt = mysql_fetch_array($resp2))
				{ 
					$ttpa[] = $vrowstt;
				}
				
				$t = 0;
				$total_tt 	= count($ttpa);
				$total2=0;
				
				while($t < $total_tt)
				{
					$fe_nulo	= $ttpa[$t]['fe_nulo'];
					$rut_t		= $ttpa[$t]['rut_t'];
					
					if($_POST['fe_b'] == ""){$_POST['fe_b'] = $fe;}else{$_POST['fe_b']	=	cambiarFecha($_POST['fe_b'], '/', '-' );}
					$resul = comparar_fechas($_POST['fe_b'], $fe_nulo);
					
					/*if($rut_t == "13808479-5"){alert("  Area  ".$cod_ar." Res   ".$resul);alert("fecha sol:  ".$_POST['fe_b']."Fecha Nulo: ".$fe_nulo);}*/
					
					if($resul == "Menor" or $fe_nulo == "0000-00-00")
					{
						$total2 = $total2 + 1;
					}
					
				$t++;
				}
				$total_mgyt = $total_mgyt + $total2;
									
				$sql3	= "SELECT * FROM asistencia, detalle_as WHERE asistencia.area_as = '$cod_ar' and asistencia.fecha_as = '$fe' and detalle_as.estado_det_as ='Presente' and asistencia.cod_as = detalle_as.cod_as ";
				$resp3	= mysql_query($sql3,$co);          
				$total3 = mysql_num_rows($resp3);
				
				$sql4	= "SELECT * FROM asistencia, detalle_as WHERE asistencia.area_as = '$cod_ar' and asistencia.fecha_as = '$fe' and asistencia.cod_as = detalle_as.cod_as and detalle_as.estado_det_as ='Ausente'"; 
				$resp4	= mysql_query($sql4,$co);
				$total4 = mysql_num_rows($resp4);
				
				$total_r = 0;
				$fe	=	cambiarFecha($fe, '/', '-' ); 
				
				$sql = "SELECT * FROM asistencia WHERE fecha_as ='$fe' and area_as = '$cod_ar' ";
				$total_p_dia	= 0;
				$respuesta		= mysql_query($sql,$co);
				$total_r 		= mysql_num_rows($respuesta);
				
				if($total_r != 0)
				{
					while($vrows=mysql_fetch_array($respuesta))
					{
						$cod_as		= "".$vrows['cod_as']."";
						$ing_as		= "".$vrows['ing_as']."";
						
						echo("<tr bgcolor=$color bordercolor=$color onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000')>	
							<td bgcolor='#cedee1'>&nbsp;$n</td>
							<td align='left'>&nbsp;$desc_ger</td>
							<td align='left'>&nbsp;$desc_dep</td>
							<td align='left'>&nbsp;$desc_ar</td>
							<td align='center'>&nbsp;$total2</td>
							<td align='center'>&nbsp;$total3</td>
							<td align='center'>&nbsp;$total4</td>
							<td align='left'>&nbsp;$ing_as</td>
							<td align='left' bgcolor='#cedee1'>&nbsp;<a href='asistencia.php?cod=$cod_as'><img src='imagenes/edit.png' border='0' valign='top' alt='Modificar'/>&nbsp;</a></td>
							</tr> ");
							
							$tp = $tp + $total3;
							$ta = $ta + $total4;
							$tt = $tp + $ta;
						
						$sql_da 	= "SELECT * FROM detalle_as WHERE cod_as ='$cod_as' ";
						$resp_da	= mysql_query($sql_da,$co);
						
						unset($totalr_da);
						while($vrows_da = mysql_fetch_array($resp_da))
						{ 
							$totalr_da[] = $vrows_da;
						}
						
						$d = 0;
						$total_da 	= count($totalr_da);
						
						while($d < $total_da)
						{
							$rut_det_as		= $totalr_da[$d]['rut_det_as'];
							$estado_det_as	= $totalr_da[$d]['estado_det_as'];
							$motivo_det_as	= $totalr_da[$d]['motivo_det_as'];
							$observ_det_as	= $totalr_da[$d]['observ_det_as'];
							
							$sql_nt 	= "SELECT * FROM trabajadores WHERE rut_t = '$rut_det_as' ";
							$resp_nt	= mysql_query($sql_nt,$co);
							while($vrows_nt = mysql_fetch_array($resp_nt))
							{
								$nom_t		= "".$vrows_nt['nom_t']."";
								$app_t		= "".$vrows_nt['app_t']."";
								$apm_t		= "".$vrows_nt['apm_t']."";
							}
							
							$worksheet->write($filaexcel,0,$desc_ger,$formato);
							$worksheet->write($filaexcel,1,$desc_dep,$formato);
							$worksheet->write($filaexcel,2,$desc_ar,$formato);
							$worksheet->write($filaexcel,3,"Ingresado",$formato);
							$worksheet->write($filaexcel,4,utf8_decode($nom_t." ".$app_t." ".$apm_t),$formato);
							$worksheet->write($filaexcel,5,$rut_det_as,$formato);
							$worksheet->write($filaexcel,6,$estado_det_as,$formato);
							$worksheet->write($filaexcel,7,utf8_decode($motivo_det_as),$formato);
													
							if($color == "#ffffff"){ $color = "#eeeeee"; }
							else{ $color = "#ffffff"; }
							$ing_as = "";
							$filaexcel++;
						
						$d++;
						}
					}
					
				}else{
					$fe	=	cambiarFecha($fe, '-', '/' ); 
					$color='#ffebaf';
					echo("<tr bgcolor=$color bordercolor=$color onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000')>	
					<td bgcolor='$color'>&nbsp;$n</td>
					<td align='left'>&nbsp;$desc_ger</td>
					<td align='left'>&nbsp;$desc_dep</td>
					<td align='left'>&nbsp;$desc_ar</td>
					<td align='center'>&nbsp;$total2</td>
					<td align='center'>&nbsp;0</td>
					<td align='center'>&nbsp;0</td>
					<td align='left'>&nbsp;</td>
					<td align='left'>&nbsp;</td>
					</tr> ");
					
					$worksheet->write($filaexcel,0,$desc_ger,$formato);
					$worksheet->write($filaexcel,1,$desc_dep,$formato);
					$worksheet->write($filaexcel,2,$desc_ar,$formato);
					$worksheet->write($filaexcel,3,"No Ingresado",$formato);
					$worksheet->write($filaexcel,4,"",$formato);
					$worksheet->write($filaexcel,5,"",$formato);
					$worksheet->write($filaexcel,6,"",$formato);
					$worksheet->write($filaexcel,7,"",$formato);
					$filaexcel++;
					
					if($color == "#ffffff"){ $color = "#eeeeee"; }
					else{ $color = "#ffffff"; }
				}
				$cod_ar = "";
				$a++;
				$n++;
			}
			$dep++;
		}	
		$g++;
	}
$tat = ($total1 - $tp);	
?>
                                        </tr>
                                        <tr height="25" bordercolor='#cedee1'>
                                          <td colspan="4" align="center" bordercolor="#cedee1" class="txtnormaln">&nbsp;RESUMEN DE INFORMES INGRESADOS</td>
                                          <td width="5%" align="center" class="txtnormaln">&nbsp;<?php echo $tt ?></td>
                                          <td width="3%" align="center" class="txtnormaln">&nbsp;<?php echo $tp ?></td>
                                          <td width="3%" align="center" class="txtnormaln">&nbsp;<?php echo $ta ?></td>
                                          <td align="center" class="txtnormaln" colspan="2">&nbsp;</td>
                                        </tr>
                                        <tr height="25" bordercolor='#cedee1'>
                                          <td align="center" class="txtnormaln" colspan="4">&nbsp;RESUMEN TOTAL MGYT</td>
                                          <td width="5%" align="center" class="txtnormaln">&nbsp;<?php echo $total_mgyt ?></td>
                                          <td width="3%" align="center" class="txtnormaln">&nbsp;<?php echo $tp ?></td>
                                          <td width="3%" align="center" class="txtnormaln">&nbsp;<?php echo ($total_mgyt - $tp) ?></td>
                                          <td align="center" class="txtnormaln" colspan="2">&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <td colspan="12" class="txtnormal"></td>
                                        </tr>
                                      </table>
                                      <br />
                                      </fieldset>
                                      
                                      <br />
                                      
                                    <fieldset class="txtnormalB">
                                      <legend class="txtnormaln">Detalle Ausentes</legend><br>
                                      
                                      <table width="348" border="0" cellspacing="0" cellpadding="0">
                                      <?php
/*********************************************************************************************************************										
										FUNCION PARA IMPRIMIR MOTIVOS									
*********************************************************************************************************************/										  
									  function motivos($desc_mot, $totalcm, $fe)
									  {
									  	echo"<tr>
                                          <td width='300'>$desc_mot</td>
										  <td width='10'>&nbsp;= </td>
                                          <td width='100'>&nbsp;</td>
                                          <td width='100'>$totalcm</td>
										  <input name='tipo[]' id='tipo[]' type='hidden' value='$desc_mot' />
										  <td width='200'><a href=\"javascript:abrirVentanac('ausentes.php?tipo=$desc_mot&fecha=$fe', '745', '290', 'yes', 'yes')\">&nbsp;Detalles</a></td>
                                        </tr>";
									  }
									  
									  	$sql_mot 	= "SELECT * FROM tb_motivos ";
										$resp_mot 	= mysql_query($sql_mot,$co);
										
										unset($motivo);
										while($vrowsm=mysql_fetch_array($resp_mot))
										{
											$motivo[] = $vrowsm;
										}
										
										$total_m	= count($motivo);
										
/*********************************************************************************************************************										
										SI SE HA SELECCIONADO UNA GERENCIA									
*********************************************************************************************************************/								
										if($_POST['c_ger'] != "Todos" and $_POST['c_ger'] != "" and ($_POST['c_dpto'] == "Todos" or $_POST['c_dpto'] == "") and ($_POST['c_area'] == "Todos" or $_POST['c_area'] == ""))
										{
											$co = mysql_connect("$DNS","$USR","$PASS");
											mysql_select_db("$BDATOS", $co);
											
											$m		= 0;
											while($m < $total_m)
											{
												$desc_mot = $motivo[$m]['desc_mot'];
												$cod_mot  = $motivo[$m]['cod_mot'];
												
												$sql_ger 	= "SELECT * FROM tb_areas, tb_dptos WHERE tb_dptos.cod_ger = '".$_POST['c_ger']."' and tb_areas.cod_dep = tb_dptos.cod_dep ";
												$resp_ger	= mysql_query($sql_ger,$co);
												$total_q 	= mysql_num_rows($resp_ger);
												
												$tot_au = 0;
												unset($gerencia);
												while($vrowsg=mysql_fetch_array($resp_ger))
												{
													$cod_ar		= "".$vrowsg['cod_ar']."";
													$desc_ar	= "".$vrowsg['desc_ar']."";
													
													$fe	=	cambiarFecha($fe, '/', '-' );
													$sqlcm	= "SELECT * FROM asistencia, detalle_as WHERE asistencia.fecha_as = '$fe' and detalle_as.estado_det_as ='Ausente' and asistencia.cod_as = detalle_as.cod_as and detalle_as.motivo_det_as = '$desc_mot' and asistencia.area_as = $cod_ar ";
													
													$respcm	= mysql_query($sqlcm,$co);  
													$totalcm = 0;        
													$totalcm = mysql_num_rows($respcm);
													$tot_au = $tot_au + $totalcm;
												}
													motivos($desc_mot, $tot_au, $fe);
													$m++;
											}
										}
										
/*********************************************************************************************************************										
										SI NO SE HA SELECCIONADO UN DEPARTAMENTO									
*********************************************************************************************************************/	
										
										if($_POST['c_ger'] != "Todos" and $_POST['c_ger'] != "" and $_POST['c_dpto'] != "Todos" and $_POST['c_dpto'] != "" and ($_POST['c_area'] == "Todos" or $_POST['c_area'] == ""))
										{
											$co = mysql_connect("$DNS","$USR","$PASS");
											mysql_select_db("$BDATOS", $co);
											
											$m		= 0;
											while($m < $total_m)
											{
												$desc_mot = $motivo[$m]['desc_mot'];
												$cod_mot  = $motivo[$m]['cod_mot'];
													
												$sql_ger 	= "SELECT * FROM tb_areas, tb_dptos WHERE tb_dptos.cod_ger = '".$_POST['c_ger']."' and tb_dptos.cod_dep = '".$_POST['c_dpto']."' and tb_areas.cod_dep = tb_dptos.cod_dep ";
												$resp_ger	= mysql_query($sql_ger,$co);
												$total_q 	= mysql_num_rows($resp_ger);
												
												$tot_au = 0;
												unset($gerencia);
												while($vrowsg=mysql_fetch_array($resp_ger))
												{
													$cod_ar		= "".$vrowsg['cod_ar']."";
													$desc_ar	= "".$vrowsg['desc_ar']."";
													
													$fe	=	cambiarFecha($fe, '/', '-' );
													$sqlcm	= "SELECT * FROM asistencia, detalle_as WHERE asistencia.fecha_as = '$fe' and detalle_as.estado_det_as ='Ausente' and asistencia.cod_as = detalle_as.cod_as and detalle_as.motivo_det_as = '$desc_mot' and asistencia.area_as = $cod_ar ";
													
													$respcm	= mysql_query($sqlcm,$co);  
													$totalcm = 0;        
													$totalcm = mysql_num_rows($respcm);
													$tot_au = $tot_au + $totalcm;
												}
													motivos($desc_mot, $tot_au, $fe);
													$m++;
											}
										}
/*********************************************************************************************************************										
										SI SE HA SELECCIONADO UN AREA ESPECIFICA									
*********************************************************************************************************************/										
										if($_POST['c_ger'] != "Todos" and $_POST['c_ger'] != "" and $_POST['c_dpto'] != "Todos" and $_POST['c_dpto'] != "" and $_POST['c_area'] != "Todos" and $_POST['c_area'] != "")
										{
											$co = mysql_connect("$DNS","$USR","$PASS");
											mysql_select_db("$BDATOS", $co);
											
											$m		= 0;
											while($m < $total_m)
											{
												$desc_mot = $motivo[$m]['desc_mot'];
												$cod_mot  = $motivo[$m]['cod_mot'];
													
												$sql_ger 	= "SELECT * FROM tb_areas, tb_dptos WHERE tb_dptos.cod_dep = '".$_POST['c_dpto']."' and tb_areas.cod_ar = '".$_POST['c_area']."' and tb_areas.cod_dep = tb_dptos.cod_dep ";
												$resp_ger	= mysql_query($sql_ger,$co);
												$total_q 	= mysql_num_rows($resp_ger);
												
												$tot_au = 0;
												unset($gerencia);
												while($vrowsg=mysql_fetch_array($resp_ger))
												{
													$cod_ar		= "".$vrowsg['cod_ar']."";
													$desc_ar	= "".$vrowsg['desc_ar']."";
													
													$fe	=	cambiarFecha($fe, '/', '-' );
													$sqlcm	= "SELECT * FROM asistencia, detalle_as WHERE asistencia.fecha_as = '$fe' and detalle_as.estado_det_as ='Ausente' and asistencia.cod_as = detalle_as.cod_as and detalle_as.motivo_det_as = '$desc_mot' and asistencia.area_as = $cod_ar ";
													
													$respcm	= mysql_query($sqlcm,$co);  
													$totalcm = 0;        
													$totalcm = mysql_num_rows($respcm);
													$tot_au = $tot_au + $totalcm;
												}
													motivos($desc_mot, $tot_au, $fe);
													$m++;
											}
										}
/*********************************************************************************************************************										
										SI NO SE HA REALIZADO NINGUN FILTRO										
*********************************************************************************************************************/										
										if($_POST['c_ger'] == "Todos" or $_POST['c_ger'] == "")
										{
											$m=0;
											while($m < $total_m)
											{
												$desc_mot = $motivo[$m]['desc_mot'];
												$cod_mot  = $motivo[$m]['cod_mot'];
												//alert($desc_mot);
												$fe	=	cambiarFecha($fe, '/', '-' );
												$sqlcm	= "SELECT * FROM asistencia, detalle_as WHERE asistencia.fecha_as = '$fe' and detalle_as.estado_det_as ='Ausente' and asistencia.cod_as = detalle_as.cod_as and detalle_as.motivo_det_as = '$desc_mot' ";
												$respcm	= mysql_query($sqlcm,$co);          
												$totalcm = mysql_num_rows($respcm);
												
												motivos($desc_mot, $totalcm, $fe);
												
												$m++;
											}
										}
										echo "<input name='sql' type='hidden' id='sql' value='$rut_det_as'/>";
									  ?>
                                        
                                      </table>
                                    </fieldset>
                                      <br>
                                    </div>
                                  <label></label></td>
                              </tr>
                              <tr>
                                <td height="15" align="center" valign="bottom"><label></label>
                                <label></label></td>
                              </tr>
                          </table></td>
                        </tr>
                      </table>
                  </form></td>
                </tr>
                <tr>
                  <td height="15" align="center" valign="top">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="5" colspan="3" align="center" valign="top"><img src="imagenes/barra.gif" alt="" width="885" height="3" /></td>
          </tr>
        </table>
      </div></td>
    </tr>
  </table>
  
  <?php
  $workbook->close();		
  ?>
</body>
</html>
