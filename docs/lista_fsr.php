<?
// Necesario para ver si la session esta activa  o si se tiene permiso de accseso
require("lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php

if($_SESSION['usd_sol_lee'] != "1")
{
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}//Hasta aquí lo comun para todas las paginas restringidas
//********************************************************************************************************************************
	include('inc/config_db.php');
	include('inc/lib.db.php');
	
	$area 			= "Todos";
	$cod_sol 		= "Todos";
	$ods	 		= "Todos";
	$cc 	 		= "Todos";
	$det 			= "Todos";
	$und_m	 		= "Todos";
	$cant_d 		= "Todos";
	$f_sol	 		= "Todos";
	$p_sol 			= "Todos";
	$est 			= "Todos";
	$empr_sol 		= "Todos";
	$oc				= "Todos";
	
	$usuario		= "Todos";
/**************************************************************************
	COMIENZA REPORTE EXCEL
**************************************************************************/	
	require_once("excelclass/class.writeexcel_workbookbig.inc.php");
	require_once("excelclass/class.writeexcel_worksheet.inc.php");
	require_once("excelclass/functions.writeexcel_utility.inc.php");
	
	$fname = "tmp/ReporteFSR.xls";
	
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
	$worksheet->set_column(0,30,20);
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
	$worksheet->write(3,4,"REPORTE SOLICITUDES DE RECURSOS",$for_titulo);
	$worksheet->write(3,5,"",$for_titulo);
	$worksheet2->write(3,4,"HOJA 2",$for_titulo);
	$worksheet3->write(3,4,"HOJA 3",$for_titulo);
	
	// ENCABEZADOS
	
	$worksheet->write(7,0,"AREA",$encabezado);
	$worksheet->write(7,1,utf8_decode("Nº SOL."),$encabezado);
	$worksheet->write(7,2,"C.C",$encabezado);
	$worksheet->write(7,3,"DETALLE",$encabezado);
	$worksheet->write(7,4,"UND MED",$encabezado);
	$worksheet->write(7,5,"CANT.",$encabezado);
	$worksheet->write(7,6,"FECHA SOL",$encabezado);
	$worksheet->write(7,7,"HORA SOL",$encabezado);
	$worksheet->write(7,8,"FECHA APROB",$encabezado);
	$worksheet->write(7,9,"HORA APROB",$encabezado);
	$worksheet->write(7,10,"RECEPCION",$encabezado);
	$worksheet->write(7,11,"CANT RECEP",$encabezado);
	$worksheet->write(7,12,"O/C",$encabezado);
	$worksheet->write(7,13,"SOLICITANTE",$encabezado);
	$worksheet->insert_bitmap('A1', 'imagenes/logo.bmp', 1, 1);	
	
/**************************************************************************
	
**************************************************************************/	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Listado FSR</title>
<link href="inc/bibliocss.css" rel="stylesheet" type="text/css">
<link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxgrid.css"><!-- llama hoja de estilo -->
<script type="text/javascript" language="JavaScript" src="inc/funciones.js"></script>

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

<script LANGUAGE="JavaScript">
function muestra(elemento)
{
	document.form1.action='sol_rec.php?cod='+elemento;
	document.form1.submit();
}

function CambiaColor(esto,fondo,texto)
{
    esto.style.background=fondo;
    esto.style.color=texto;
	esto.style.cursor='hand'
}

function evento()
{
	document.form1.action='lista_fsr.php?pagina='+1;
	document.form1.submit();	
}

function enviar_otra_pagina(url)
{
	document.form1.action=url;
	document.form1.submit();
}

function enviar(url)
{
	document.form1.action=url;
}

function reporte_pdf()
{
	document.form1.target	='_blank';
	document.form1.action	="rep_lista_fsr.php";
	document.form1.submit();
	document.form1.target	='';
	document.form1.action	='';
}
function Abrir_nueva_vantana()
{
	abrirVentanaM("rep_lista_fsr.php", "yes");
}
</script>

<style type="text/css">
<!--
body {
	background-color: rgb(90, 136, 183);
	margin-top: 15px;
}
.Estilo5 {color: #000000}
-->
ul    { border:0; margin:0; padding:0; }
#pagination-digg li          { border:0; margin:0; padding:0; font-size:11px; list-style:none; /* savers */ float:left; }
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
<form id="form1" name="form1" method="post" action="" >
<table width="1159" height="452" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="104" height="55" align="center" valign="top"><img src="imagenes/logo2.jpg" width="127" height="60" /></td>
    <td width="83" height="55" align="left" valign="middle"><label>
      <input name="Volver2" type="submit" class="boton_volver" id="Volver2" value="Volver" onclick="enviar('sol_rec.php');" />
    </label></td>
    <td width="83" align="left" valign="middle"><input name="Volver4" type="submit" class="boton_actualizar" id="Volver4" value="Actualizar" /></td>
    <td width="675" align="center" valign="middle" class="txt01">LISTADO SOLICITUDES DE RECURSOS</td>
    <td width="79" align="center" valign="middle">&nbsp;</td>
    <td width="54" align="center" valign="middle">&nbsp;</td>
    <td width="116" align="right" valign="top"><img src="imagenes/logo_iso_c.jpg" width="116" height="60"/></td>
  </tr>
  
  <tr>
    <td height="260" colspan="7" align="center" valign="top">
    
      <table width="1168" height="325" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
        
        <tr>
          <td width="1176" height="280" align="center" valign="top">
          
          <table width="1153" border="1" bordercolor="#F2F2F2" bgcolor="#cedee1" class="txtnormal2" cellspacing="0" cellpadding="0">
        <tr style="background:#cedee1;" class="txtnormal8">
        <td align="center">&nbsp;VER</td>
        <td align="center">AREA</td>
        <td align="center">Nº SOL.</td>
        <td align="center">ODS</td>
        <td align="center">CENTRO COSTO</td>
        <td align="center">DETALLE DE SOLICITUD</td>
        <td align="center">UND MEDIDA</td>
        <td align="center">CANT</td>
        <td align="center">FECHA SOL.</td>
        <td align="center">FECHA APROB</td>
        <td align="center">RECEPCION</td>
        <td align="center">OC</td>
        <td align="center">FACTURA</td>
        <td align="center">SOLICITADA POR</td>
        </tr>
            <tr class="txtnormal8" >
              <td width="2%" style="background:#cedee1;">&nbsp;</td>
              <td width="5%"><span class="Estilo5">
                <?
              if($area != "" ){$area = $_POST['c_areas'];}
			  if($area == "" ){$area = "Todos";}
			  ?>
                <select name="c_areas" id="c_areas" style="font-size:9px; width:130px;" onchange="evento();" >
                  <?php
//*******************************************************************************************************
								$sql_c = "SELECT * FROM tb_areas ORDER BY desc_ar ";
								
								$rows_area= dbConsulta($sql_c);
								$total_c = count($rows_area);
								echo"<option selected='selected' value='$area'>$area</option>";
								if($area != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}
										
								for ($i = 0; $i < $total_c; $i++)
								{
									echo "<option value='".$rows_area[$i]['cod_ar']."'>".$rows_area[$i]['desc_ar']."</option>";	
								}
							?>
                </select>
              </span></td>
              <td width="5%">
			  <?
              if($cod_sol != "" ){$cod_sol = $_POST['c_cod_sol'];}
			  if($cod_sol == "" ){$cod_sol = "Todos";}
			  ?>
                <select name="c_cod_sol" id="c_cod_sol" style="font-size:8px;" onchange="evento();" >
                  <?php
                              //*******************************************************************************************************
								$sql_sol  = "SELECT DISTINCT cod_sol FROM tb_sol_rec ORDER BY cod_sol ";
								
								$rs_cod 	= dbConsulta($sql_sol);
								$total_sol  = count($rs_cod);
								
								echo"<option selected='selected' value='$cod_sol'>$cod_sol</option>";
								
								if($cod_sol != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}	
									
								for ($i = 0; $i < $total_sol; $i++)
								{
									echo "<option value='".$rs_cod[$i]['cod_sol']."'>".$rs_cod[$i]['cod_sol']."</option>";	
								}							
								?>
                </select>                </td>
              <td width="5%">
			  <?
              if($ods != "" ){$ods = $_POST['c_ods'];}
			  if($ods == "" ){$ods = "Todos";}
			  ?>
			  <select name="c_ods" id="c_ods" style="font-size:8px;" onchange="evento();" >
                <?php
                              //*******************************************************************************************************
								$sql_ods  = "SELECT DISTINCT ods_sol FROM tb_sol_rec ORDER BY ods_sol ";
								
								$rs_ods 	= dbConsulta($sql_ods);
								$total_ods  = count($rs_ods);
								
								echo"<option selected='selected' value='$ods'>$ods</option>";
								
								if($ods != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}	
									
								for ($i = 0; $i < $total_ods; $i++)
								{
									echo "<option value='".$rs_ods[$i]['ods_sol']."'>".$rs_ods[$i]['ods_sol']."</option>";	
								}							
								?>
              </select></td>
              <td width="5%"><?
              if($cc != "" ){$cc = $_POST['c_cc'];}
			  if($cc == "" ){$cc = "Todos";}
			  ?>
                <select name="c_cc" id="c_cc" style="font-size:8px;" onchange="evento();" >
                  <?php
                              //*******************************************************************************************************
								$sql_cc  = "SELECT DISTINCT cc_sol FROM tb_sol_rec ORDER BY cc_sol";
								
								$rs_cc 	= dbConsulta($sql_cc);
								$total_cc  = count($rs_cc);
								
								echo"<option selected='selected' value='$cc'>$cc</option>";
								
								if($cc != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}	
									
								for ($i = 0; $i < $total_cc; $i++)
								{
									echo "<option value='".$rs_cc[$i]['cc_sol']."'>".$rs_cc[$i]['cc_sol']."</option>";	
								}							
								?>
                </select></td>
              <td width="30%"><span class="Estilo5">
                <?
              if($det != "" ){$det = $_POST['c_det'];}
			  if($det == "" ){$det = "Todos";}
			  ?>
                <select name="c_det" id="c_det" style="font-size:9px; width:290px;" onchange="evento();" >
                  <?php
                              //*******************************************************************************************************
								$sql_det  = "SELECT DISTINCT desc_sol FROM tb_det_sol ORDER BY desc_sol ";
								
								$rs_det 	= dbConsulta($sql_det);
								$total_det  = count($rs_det);
								
								echo"<option selected='selected' value='$det'>".cortarTexto($det, 80)."</option>";
								
								if($det != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}	
									
								for ($i = 0; $i < $total_det; $i++)
								{
									echo "<option value='".$rs_det[$i]['desc_sol']."'>".cortarTexto($rs_det[$i]['desc_sol'], 80)."</option>";	
								}
															
								?>
                </select>
              </span></td>
              <td width="8%"><?
              if($und_m != "" ){$und_m = $_POST['c_und_m'];}
			  if($und_m == "" ){$und_m = "Todos";}
			  ?>
                <span class="Estilo5">
                <select name="c_und_m" id="c_und_m" style="font-size:9px;" onchange="evento();" >
                  <?php
                              //*******************************************************************************************************
								$sql_um  = "SELECT * FROM tb_und_med ORDER BY nom_um";
								
								$rs_um 	= dbConsulta($sql_um);
								$total_um  = count($rs_um);
								
								echo"<option selected='selected' value='$und_m'>$und_m</option>";
								
								if($und_m != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}	
									
								for ($i = 0; $i < $total_um; $i++)
								{
									echo "<option value='".$rs_um[$i]['cod_um']."'>".$rs_um[$i]['nom_um']."</option>";	
								}							
								?>
                </select>
                </span></td>
              <td width="3%">
              
              <?
              if($cant_d != "" ){$cant_d = $_POST['c_cant_d'];}
			  if($cant_d == "" ){$cant_d = "Todos";}
			  ?>
              <select name="c_cant_d" id="c_cant_d" style="font-size:8px;" onchange="evento();" >
                <?php
                              //*******************************************************************************************************
								$sql_cant  = "SELECT DISTINCT cant_det FROM tb_det_sol ORDER BY cant_det";
								
								$rs_cant 	= dbConsulta($sql_cant);
								$total_cant  = count($rs_cant);
								echo"<option selected='selected' value='$cant_d'>$cant_d</option>";
								if($cant_d != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}	
									
								for ($i = 0; $i < $total_cant; $i++)
								{
									echo "<option value='".$rs_cant[$i]['cant_det']."'>".$rs_cant[$i]['cant_det']."</option>";	
								}							
								?>
              </select></td>
              <td width="5%">
			  <?
              if($f_sol != "" ){$f_sol = $_POST['c_f_sol'];}
			  if($f_sol == "" ){$f_sol = "Todos";}
			  ?>
                <select name="c_f_sol" id="c_f_sol"  style="font-size:8px;" onchange="evento();" >
                  <?php
//*******************************************************************************************************
								$sql_fs = "SELECT DISTINCT fe_sol FROM tb_sol_rec ORDER BY fe_sol ";
								
								$rsfs	= dbConsulta($sql_fs);
								$totalfs = count($rsfs);
								
								echo"<option selected='selected' value='$f_sol'>$f_sol</option>";
								if($f_sol != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}
										
								for ($i = 0; $i < $totalfs; $i++)
								{
									$rsfs[$i]['fe_sol']		=	cambiarFecha($rsfs[$i]['fe_sol'], '-', '/' );
									echo "<option value='".$rsfs[$i]['fe_sol']."'>".$rsfs[$i]['fe_sol']."</option>";	
								}
							?>
                </select></td>
              <td width="6%"><?
              if($fe_aprob_g != "" ){$fe_aprob_g = $_POST['c_fe_aprob_g'];}
			  if($fe_aprob_g == "" ){$fe_aprob_g = "Todos";}
			  ?>
                <select name="c_fe_aprob_g3" id="c_fe_aprob_g3"  style="font-size:8px;" onchange="evento();" >
                  <?php
//*******************************************************************************************************
								$sql_apg = "SELECT DISTINCT fe_aprob_g FROM tb_sol_rec ORDER BY fe_aprob_g ";
								
								$rs_apg		= dbConsulta($sql_apg);
								$total_apg 	= count($rs_apg);
								
								echo"<option selected='selected' value='$fe_aprob_g'>$fe_aprob_g</option>";
								if($fe_aprob_g != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}
										
								for ($i = 0; $i < $total_apg; $i++)
								{
									$fe_aprob_g = $rs_apg[$i]['fe_aprob_g'];
									
									$fe_aprob_g		=	cambiarFecha($fe_aprob_g, '-', '/' );
									echo "<option value='$fe_aprob_g'>$fe_aprob_g</option>";	
								}
							?>
                </select></td>
              
              <?
/*******************************************************************************************************************************************   
						PREGUNTAMOS SI EL SELECT ENVIO UN VALOR NUMERICO(CODIGO DE EQUIPO)
********************************************************************************************************************************************/ 
              
			  if($planta != ""){$planta = $_POST['c_plantas'];}
			  if($planta == ""){$planta = "Todos";}
			  ?>
              
              <td width="7%"><?
              if($est != ""){$est = $_POST['c_est'];}
			  if($est == ""){$est = "Todos";}
			  ?>
                <select name="c_est" id="c_est" style="font-size:8px;" onchange="evento();">
                <? echo"<option selected='selected' value='$est'>$est</option>";
					if($est != "Todos"){
               			echo"<option value='Todos'>Todos</option>";
                	}
				?>
               	<option value="Anulado">Anulado</option>
                <option value="Pendiente">Pendiente</option>
               	<option value="Completa">Completa</option>
              	<option value="Parcial">Parcial</option>
                <option value="Rechazada">Rechazada</option>
              </select></td>
              <td width="2%"><?
              if($oc != "" ){$oc = $_POST['c_oc'];}
			  if($oc == "" ){$oc = "Todos";}
			  ?>
                <select name="c_oc" id="c_oc" style="font-size:8px;" onchange="evento();" >
                  <?php
			  //*******************************************************************************************************
				$sql_cant  = "SELECT DISTINCT num_oc FROM tb_det_sol ORDER BY num_oc";
				
				$rs_cant 	= dbConsulta($sql_cant);
				$total_cant  = count($rs_cant);
				echo"<option selected='selected' value='$oc'>$oc</option>";
				if($oc != "Todos"){
					echo"<option value='Todos'>Todos</option>";
				}	
					
				for ($i = 0; $i < $total_cant; $i++)
				{
					echo "<option value='".$rs_cant[$i]['num_oc']."'>".$rs_cant[$i]['num_oc']."</option>";	
				}							
				?>
                </select></td>
              <td width="1%">&nbsp;</td>
              <td width="10%"align="left" >
                <?
              if($p_sol != ""){$p_sol = $_POST['c_p_sol'];}
			  if($p_sol == ""){$p_sol = "Todos";}
			  ?>
                <select name="c_p_sol" id="c_p_sol"  style="font-size:9px; width:100px;" onchange="evento();">
                  <?php
                  				$sqlu    = "SELECT DISTINCT prof_sol FROM tb_sol_rec ORDER BY prof_sol ";
	
								$rsu 	 = dbConsulta($sqlu);
								$totalu  = count($rsu);
								echo"<option selected='selected' value='$p_sol'>$p_sol</option>";
								if($p_sol != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}
										
								for ($i = 0; $i < $totalu; $i++)
								{
									echo "<option value='".$rsu[$i]['prof_sol']."'>".$rsu[$i]['prof_sol']."</option>";
								}
							?>
                </select>                	</td>
               </tr>
               <tr> 
                	<td colspan="14" align="center" class="txtnormal5"></td>
               </tr>
<?php
/***********************************************************************************************************************
				FILTRAMOS
***********************************************************************************************************************/	
if($_POST['c_areas'] != "Todos" and $_POST['c_areas'] != "")
{
	$query = "and area_sol = '".$_POST['c_areas']."'";
}
if($_POST['c_cod_sol'] != "Todos" and $_POST['c_cod_sol'] != "")
{
	$query1 = "and tb_sol_rec.cod_sol = '".$_POST['c_cod_sol']."'";
}	
if($_POST['c_ods'] != "Todos" and $_POST['c_ods'] != "")
{
	$query2 = "and tb_sol_rec.ods_sol = '".$_POST['c_ods']."'";
}
if($_POST['c_det'] != "Todos" and $_POST['c_det'] != "")
{
	$query3 = "and tb_det_sol.desc_sol = '".$_POST['c_det']."'";
}
if($_POST['c_und_m'] != "Todos" and $_POST['c_und_m'] != "")
{
	$query4 = "and tb_det_sol.und_med = '".$_POST['c_und_m']."'";
}
if($_POST['c_oc'] != "Todos" and $_POST['c_oc'] != "")
{
	$query5 = "and tb_det_sol.num_oc = '".$_POST['c_oc']."'";
}
if($_POST['c_f_sol'] != "Todos" and $_POST['c_f_sol'] != "")
{
	$_POST['c_f_sol']	=	cambiarFecha($_POST['c_f_sol'], '/', '-' );
	$query6 = "and tb_sol_rec.fe_sol = '".$_POST['c_f_sol']."'";
}
if($_POST['c_p_sol'] != "Todos" and $_POST['c_p_sol'] != "")
{
	$query6 = "and tb_sol_rec.prof_sol = '".$_POST['c_p_sol']."'";
}
if($_POST['c_est'] != "Todos" and $_POST['c_est'] != "")
{
	$query7 = "and tb_det_sol.rec_det = '".$_POST['c_est']."' ";
}
if($_GET['consulta'] != "Todos" and $_GET['consulta'] != "")
{
	$query8 = stripslashes($_GET['consulta']);
}
if($_POST['c_empr_sol'] != "Todos" and $_POST['c_empr_sol'] != "")
{
	$query9 = "and empr_sol = '".$_POST['c_empr_sol']."'";
}
if($_POST['c_cc'] != "Todos" and $_POST['c_cc'] != "")
{
	$query10 = "and tb_sol_rec.cc_sol = '".$_POST['c_cc']."'";
}

/***************************************************************************************************************************/
$co=mysql_connect("$DNS","$USR","$PASS");
mysql_select_db("$BDATOS", $co);
		
$sql1	= "SELECT * FROM tb_sol_rec, tb_det_sol WHERE tb_sol_rec.cod_sol = tb_det_sol.cod_sol $query $query1 $query2 $query3 $query4 $query5 $query6 $query7 $query8 $query9 $query10 ORDER BY tb_sol_rec.cod_sol";
$res	= mysql_query($sql1, $co);
	
$numeroRegistros = mysql_num_rows($res);
mysql_free_result($res); // Liberamos memoria

if($numeroRegistros > 0)
{
	//////////calculo de elementos necesarios para paginacion
	//tamaño de la pagina
	$tamPag=23;

	//pagina actual si no esta definida y limites
	if(!isset($_GET["pagina"]))
	{
		$pagina=1;
		$inicio=1;
		$final=$tamPag;
	}else{
		$pagina = $_GET["pagina"];
	}
	//calculo del limite inferior
	$limitInf=($pagina-1)*$tamPag;

	//calculo del numero de paginas
	$numPags=ceil($numeroRegistros/$tamPag);
	if(!isset($pagina))
	{
		$pagina=1;
		$inicio=1;
		$final=$tamPag;
	}else{
		$seccionActual=intval(($pagina-1)/$tamPag);
		$inicio=($seccionActual*$tamPag)+1;

		if($pagina<$numPags)
		{
			$final=$inicio+$tamPag-1;
		}else{
			$final=$numPags;
		}
                
		if ($final>$numPags){
			$final=$numPags;
		}
	}
	//////////fin de dicho calculo	


/***********************************************************************************************************************
MOSTRAMOS LOS ITEM DE LA SOLICITUD QUE ESTAMOS MOSTRANDO
***********************************************************************************************************************/	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sql = "SELECT * FROM tb_sol_rec, tb_det_sol WHERE tb_sol_rec.cod_sol = tb_det_sol.cod_sol $query $query1 $query2 $query3 $query4 $query5 $query6 $query7 $query8 $query9 $query10 ORDER BY tb_sol_rec.cod_sol DESC LIMIT ".$limitInf.",".$tamPag;
	
	$respuesta	= mysql_query($sql,$co);
	$color 		= "#ffffff";
	$i=1;
	while($vrows=mysql_fetch_array($respuesta))
	{
		$cod_sol		= "".$vrows['cod_sol']."";
		$id_det			= "".$vrows['id_det']."";
		$ods_sol		= "".$vrows['ods_sol']."";
		$cc_sol			= "".$vrows['cc_sol']."";
		$empr_sol		= "".$vrows['empr_sol']."";
		$area_sol		= "".$vrows['area_sol']."";
		$prof_sol		= "".$vrows['prof_sol']."";
		$desc_sol		= "".$vrows['desc_sol']."";
		$cant_det		= "".$vrows['cant_det']."";
		$und_med		= "".$vrows['und_med']."";
		$rec_det		= "".$vrows['rec_det']."";
		$cant_rec		= "".$vrows['cant_rec']."";
		$fe_sol			= "".$vrows['fe_sol']."";
		$fe_aprob_g 	= "".$vrows['fe_aprob_g']."";
		$det_ap_g 		= "".$vrows['det_ap_g']."";
		$num_oc			= "".$vrows['num_oc']."";
		$factura		= "".$vrows['factura']."";
		
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS", $co);
						
		$sql_g	= "SELECT * FROM tb_areas WHERE cod_ar = '$area_sol' ";
		$res_g	= mysql_query($sql_g,$co);
		while($vrowsg=mysql_fetch_array($res_g))
		{
			$area_d	= "".$vrowsg['desc_ar']."";
			$area_c = "".$vrowsg['cod_ar']."";
		}
		
		$sql_um	= "SELECT * FROM tb_und_med WHERE cod_um = '$und_med' ";
		$res_um	= mysql_query($sql_um,$co);
		while($vrows_um = mysql_fetch_array($res_um))
		{
			$nom_um 	= $vrows_um['nom_um'];
		}
		
		$fe_sol		=	cambiarFecha($fe_sol, '-', '/' );
		$fe_aprob_g	=	cambiarFecha($fe_aprob_g, '-', '/' );
		
		if($fe_aprob_g == "00/00/0000"){$fe_aprob_g = "";}
		
		if($rec_det == "Completa"){ $color = "#95d79a"; }
		if($rec_det == "Parcial"){ $color = "#fffb96"; }
		if($fe_aprob_g != "" and $det_ap_g == "1"){$color = "red"; $fe_aprob_g = "Rechazada"; }
		if($fe_aprob_g != "" and $det_ap_g == "3"){$color = "#ffdd74"; $fe_aprob_g = "Anulado"; }

		echo"<tr bgcolor=$color class='txtnormal8' onDblClick='javascript:muestra($cod_sol)'; onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000')>";	

		   echo"<td bgcolor='#ffc561'>&nbsp;<a href=\"sol_rec.php?cod=$cod_sol\"><img src='imagenes/edit.png' border='0' valign='top' alt='Modificar'/>&nbsp;</a></td>
				<td>&nbsp;$area_d</td>
				<td>&nbsp;$cod_sol</td>
				<td>&nbsp;$ods_sol</td>
				<td>&nbsp;$cc_sol</td>
				<td>&nbsp;$desc_sol</td>	
				<td>&nbsp;$nom_um</td>
				<td>&nbsp;$cant_det</td>
				<td>&nbsp;$fe_sol</td>
				<td>&nbsp;$fe_aprob_g</td>
				<td>&nbsp;$rec_det</td>
				<td>&nbsp;<a href=\"sw/rep_oc.php?cod=$num_oc&emp=$empr_sol\" target='blank'>$num_oc</a></td>
				<td width='5%'>&nbsp;<a href='$factura' target='blank'>"; if($factura != ""){ echo "Factura"; } echo"</a></td>
				<td>&nbsp;&nbsp;$prof_sol</td>
			</tr>";
									
				if($color == "#ffffff"){ $color = "#ddeeee"; }
				else{ $color = "#ffffff"; }		
	}
		mysql_free_result($respuesta); // Liberamos memoria
}		
?>         
            <tr>
              <td colspan="14" align="center" class="txtnormal" height="30"><?php echo "Encontrados ".$numeroRegistros." resultados"; ?></td>
            </tr>
            <tr>
              <td colspan="14" align="center" class="txtnormaln"><table width="1183" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="106">&nbsp;</td>
                  <td width="1077" align="center">
<?
/*****************************************************************************************************************************************************
				ACA COMIENZA LA PAGINACION
******************************************************************************************************************************************************
				MOSTRAMOS LOS LINK ANTERIOR Y PRIMERA PAGINA
*****************************************************************************************************************************************************/
				echo "<div align='center'><ul id='pagination-digg'><li>&nbsp;</li>";

                if($pagina>1)
                {
                    echo "<li><a onclick=\"enviar_otra_pagina('".$_SERVER["PHP_SELF"]."?pagina=".(1)."')\"; href='#'>";
					echo "<font face='verdana' size='-2'>Primera</font></a></li>";
					
					echo "<li><a onclick=\"enviar_otra_pagina('".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."')\"; href='#'>";
                    echo "<font face='verdana' size='-2'><< anterior</font>";
                    echo "</a><li>";
                }
/*****************************************************************************************************************************************************
				MOSTRAMOS LOS LINK DE CADA PAGINA
*****************************************************************************************************************************************************/            
                for($i=$inicio;$i<=$final;$i++)
                {
                    if($i==$pagina)
                    {
                        echo "<li class='active'><font face='verdana' size='-2'><b>".$i."</b>&nbsp;</font></li>";
                    }else{
                        echo "<li><a onclick=\"enviar_otra_pagina('".$_SERVER["PHP_SELF"]."?pagina=".$i."')\"; href='#'>";
                        echo "<font face='verdana' size='-2'>".$i."</font></a></li>";
                    }
                }
/*****************************************************************************************************************************************************
				MOSTRAMOS LOS LINK SIGUIENTE Y ULTIMA PAGINA
*****************************************************************************************************************************************************/				
                if($pagina<$numPags)
                {
                    echo "<li><a onclick=\"enviar_otra_pagina('".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."')\"; href='#'>";
                    echo "<font face='verdana' size='-2'>siguiente >></font></a></li>";
					
					echo "<li><a onclick=\"enviar_otra_pagina('".$_SERVER["PHP_SELF"]."?pagina=".($numPags)."')\"; href='#'>";
                	echo "<font face='verdana' size='-2'>Ultima</font></a></li>";
                }
				echo "</ul></div>";
                //////////fin de la paginacion           
            ?>            </td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td height="74" colspan="14" align="center" valign="bottom" class="txtnormaln">&nbsp;
               <label>
                <input name="button" type="button" class="boton_pdf" id="button" value="Exportar a PDF" onclick="reporte_pdf()"/>
                
               <a href='bajar_excel.php?filename=<? echo $fname ?>'><img src="imagenes/botones/rep_excel.jpg" border="0" /></a>
                
                <input name="Volver" type="submit" class="boton_volver" id="Volver" value="Volver" onclick="enviar('sol_rec.php');" />
                <input name="Volver3" type="submit" class="boton_actualizar" id="Volver3" value="Actualizar" />
              </label>              </td>
            </tr>
           </table>
                     
         </td>
        </tr>
       </table>   
             
      </td>
     </tr>
     
  <tr>
    <td height="5" colspan="7" align="center" valign="top"><img src="imagenes/barra.gif" alt="" width="100%" height="3" /></td>
  </tr>
</table>

<?php
/***********************************************************************************************************************
MOSTRAMOS LOS ITEM DE LA SOLICITUD QUE ESTAMOS MOSTRANDO
***********************************************************************************************************************/	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sql_rep = "SELECT * FROM tb_sol_rec, tb_det_sol WHERE tb_sol_rec.cod_sol = tb_det_sol.cod_sol $query $query1 $query2 $query3 $query4 $query5 $query6 $query7 $query8 $query9 $query10 ORDER BY tb_sol_rec.cod_sol";
	
	$resp_rep	= mysql_query($sql_rep, $co);
	$color 		= "#ffffff";
	$i			= 1;
	$filaexcel  = 8;
	
	while($vrows_rep = mysql_fetch_array($resp_rep))
	{
		echo "<input name='campos[$id_det]' type='hidden'/>";
		$cod_sol		= "".$vrows_rep['cod_sol']."";
		$id_det			= "".$vrows_rep['id_det']."";
		$ods_sol		= "".$vrows_rep['ods_sol']."";
		$cc_sol			= "".$vrows_rep['cc_sol']."";
		$area_sol		= "".$vrows_rep['area_sol']."";
		$prof_sol		= "".$vrows_rep['prof_sol']."";
		$desc_sol		= "".$vrows_rep['desc_sol']."";
		$cant_det		= "".$vrows_rep['cant_det']."";
		$und_med		= "".$vrows_rep['und_med']."";
		$rec_det		= "".$vrows_rep['rec_det']."";
		$cant_rec		= "".$vrows_rep['cant_rec']."";
		$fe_sol			= "".$vrows_rep['fe_sol']."";
		$hr_ing_sol		= "".$vrows_rep['hr_ing_sol']."";
		$fe_aprob_g 	= "".$vrows_rep['fe_aprob_g']."";
		$hr_apb_sol 	= "".$vrows_rep['hr_apb_sol']."";
		$det_ap_g 		= "".$vrows_rep['det_ap_g']."";
		$num_oc			= "".$vrows_rep['num_oc']."";
		
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS", $co);
						
		$sql_g	= "SELECT * FROM tb_areas WHERE cod_ar = '$area_sol' ";
		$res_g	= mysql_query($sql_g,$co);
		while($vrowsg=mysql_fetch_array($res_g))
		{
			$area_d	= "".$vrowsg['desc_ar']."";
			$area_c = "".$vrowsg['cod_ar']."";
		}
		
		$sql_um	= "SELECT * FROM tb_und_med WHERE cod_um = '$und_med' ";
		$res_um	= mysql_query($sql_um,$co);
		while($vrows_um = mysql_fetch_array($res_um))
		{
			$nom_um 	= $vrows_um['nom_um'];
		}
		
		$fe_sol		=	cambiarFecha($fe_sol, '-', '/' );
		$fe_aprob_g	=	cambiarFecha($fe_aprob_g, '-', '/' );
		
		if($fe_aprob_g == "00/00/0000"){$fe_aprob_g = "";}
									
		$worksheet->write($filaexcel,0,$area_d,$formato);
        $worksheet->write($filaexcel,1,$cod_sol,$formato);
        $worksheet->write($filaexcel,2,$cc_sol,$formato);
        $worksheet->write($filaexcel,3,utf8_decode($desc_sol),$formato);
        $worksheet->write($filaexcel,4,utf8_decode($nom_um),$formato);
		$worksheet->write($filaexcel,5,$cant_det,$formato);
        $worksheet->write($filaexcel,6,$fe_sol,$formato);
		$worksheet->write($filaexcel,7,$hr_ing_sol,$formato);
		$worksheet->write($filaexcel,8,$fe_aprob_g,$formato);
		$worksheet->write($filaexcel,9,$hr_apb_sol,$formato);
		$worksheet->write($filaexcel,10,utf8_decode($rec_det),$formato);
		$worksheet->write($filaexcel,11,$cant_recep,$formato);
		$worksheet->write($filaexcel,12,$num_oc,$formato);
		$worksheet->write($filaexcel,13,utf8_decode($prof_sol),$formato);
									
		if($color == "#ffffff"){ $color = "#ddeeee"; }
		else{ $color = "#ffffff"; }
		
		$i++;
		$filaexcel++;				
	}
	$workbook->close();		
	mysql_free_result($resp_rep);

?>
</form> 
</body>
</html>
