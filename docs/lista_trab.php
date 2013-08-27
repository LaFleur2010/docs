<?
/**********************************************************************************************************************************
			NECESARIO PARA VER SI LA SESION ESTA ACTIVA O SI TIENE PERMISOS DE ACCESO
**********************************************************************************************************************************/
require("lg/lg_controlar.php");
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
//********************************************************************************************************************************
	include('inc/config_db.php');
	include('inc/lib.db.php');
	
	$rut_t 			= "Todos";
	$nom_t 			= "Todos";
	$app_t 			= "Todos";
	$apm_t 			= "Todos";
	$desc_ger 		= "Todos";
	$desc_dep 		= "Todos";
	$desc_ar 		= "Todos";
	$cargo_t 		= "Todos";
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
	$worksheet->write(7,2,"ODS",$encabezado);
	$worksheet->write(7,3,"DETALLE",$encabezado);
	$worksheet->write(7,4,"UND MED",$encabezado);
	$worksheet->write(7,5,"CANT.",$encabezado);
	$worksheet->write(7,6,"FECHA SOL",$encabezado);
	$worksheet->write(7,7,"FECHA APROB",$encabezado);
	$worksheet->write(7,8,"RECEPCION",$encabezado);
	$worksheet->write(7,9,"CANT RECEP",$encabezado);
	$worksheet->write(7,10,"O/C",$encabezado);
	$worksheet->write(7,11,"SOLICITANTE",$encabezado);
	$worksheet->insert_bitmap('A1', 'imagenes/logo.bmp', 1, 1);	
	
/**************************************************************************
	
**************************************************************************/	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Listado Trabajadores</title>
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

function CambiaColor(esto,fondo,texto)
{
    esto.style.background=fondo;
    esto.style.color=texto;
	esto.style.cursor='hand'
}

function muestra(elemento)
{
	document.form1.action='trabajadores.php?cod='+elemento;
	document.form1.submit();
}

function evento()
{
	document.form1.action='lista_trab.php?pagina='+1;
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
	background-color: #527eab;
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
<table width="1150" height="247" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="100" height="60" align="left" valign="top"><a href="index2.php"><img src="imagenes/logo2.jpg" width="100" height="60" border="0" /></a></td>
    <td width="174" height="60" align="center" valign="middle"><span class="Estilo5">
      <input name="Volver2" type="submit" class="boton_volver" id="Volver2" value="Volver" onclick="enviar('trabajadores.php');" />
    </span></td>
    <td width="601" align="center" valign="middle">LISTADO TRABAJADORES</td>
    <td width="175" align="center" valign="middle"><span class="Estilo5">
      <input name="Volver4" type="submit" class="boton_actualizar" id="Volver4" value="Actualizar" />
    </span></td>
    <td width="100" align="right" valign="top"><img src="imagenes/logo_iso_c.jpg" width="100" height="52"/></td>
  </tr>
  
  <tr>
    <td height="180" colspan="5" align="center" valign="top">
    
      <table width="1140" height="180" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
        
        <tr>
          <td width="948" height="180" align="center" valign="top">
          
          <table width="1138" border="1" bordercolor="#F2F2F2" bgcolor="#cedee1" class="txtnormal2" cellspacing="0" cellpadding="0">
        <tr style="background:#cedee1;" class="txtnormal8">
        <td align="center">&nbsp;VER</td>
        <td align="center">RUT</td>
        <td align="center">NOMBRE</td>
        <td align="center">APELLIDO PATERNO</td>
        <td align="center">APELLIDO MATERNO</td>
        <td align="center">GERENCIA</td>
        <td align="center">DEPARTAMENTO</td>
        <td align="center">AREA</td>
        <td align="center">CARGO</td>
        </tr>
            <tr class="txtnormal8" >
              <td width="4%" style="background:#cedee1;">&nbsp;</td>
              <td width="10%"><span class="Estilo5">
                <? 
              if($rut_t != "" ){$rut_t = $_POST['c_rut_t'];}
			  if($rut_t == "" ){$rut_t = "Todos";}
			  ?>
                <select name="c_rut_t" id="c_rut_t"  style="font-size:9px;" onchange="evento();">
                  <?php
                  				$sql_emps    = "SELECT DISTINCT rut_t FROM trabajadores ORDER BY rut_t";
	
								$rs_emps 	 = dbConsulta($sql_emps);
								$total_emps  = count($rs_emps );
								echo"<option selected='selected' value='$rut_t'>$rut_t</option>";
								if($rut_t != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}
										
								for ($i = 0; $i < $total_emps; $i++)
								{
									echo "<option value='".$rs_emps[$i]['rut_t']."'>".$rs_emps[$i]['rut_t']."</option>";
								}
							?>
                </select>
              </span></td>
              <td width="11%"><?
              if($nom_t != "" ){$nom_t = $_POST['c_nom_t'];}
			  if($nom_t == "" ){$nom_t = "Todos";}
			  ?>
                <select name="c_nom_t" id="c_nom_t" style="font-size:8px;" onchange="evento();" >
                  <?php
                              //*******************************************************************************************************
								$sql_nt  = "SELECT DISTINCT nom_t FROM trabajadores ORDER BY nom_t ";
								
								$rs_nt 		= dbConsulta($sql_nt);
								$total_nt  	= count($rs_nt);
								
								echo"<option selected='selected' value='$nom_t'>$nom_t</option>";
								
								if($nom_t != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}	
									
								for ($i = 0; $i < $total_nt; $i++)
								{
									echo "<option value='".$rs_nt[$i]['nom_t']."'>".$rs_nt[$i]['nom_t']."</option>";	
								}							
								?>
                </select></td>
              <td width="11%">
			  <?
              if($app_t != "" ){$app_t = $_POST['c_app_t'];}
			  if($app_t == "" ){$app_t = "Todos";}
			  ?>
                <select name="c_app_t" id="c_app_t" style="font-size:8px;" onchange="evento();" >
                  <?php
                              //*******************************************************************************************************
								$sql_app_t  = "SELECT DISTINCT app_t FROM trabajadores ORDER BY app_t ";
								
								$rs_app_t 	= dbConsulta($sql_app_t);
								$total_app_t  = count($rs_app_t);
								
								echo"<option selected='selected' value='$app_t'>$app_t</option>";
								
								if($app_t != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}	
									
								for ($i = 0; $i < $total_app_t; $i++)
								{
									echo "<option value='".$rs_app_t[$i]['app_t']."'>".$rs_app_t[$i]['app_t']."</option>";	
								}							
								?>
                </select>                </td>
              <td width="11%">
			  
			  <?
              if($apm_t != "" ){$apm_t = $_POST['c_apm_t'];}
			  if($apm_t == "" ){$apm_t = "Todos";}
			  ?>
                <select name="c_apm_t" id="c_apm_t" style="font-size:8px;" onchange="evento();" >
                  <?php
                              //*******************************************************************************************************
								$sql_apm_t  = "SELECT DISTINCT apm_t FROM trabajadores ORDER BY apm_t ";
								
								$rs_apm_t 	= dbConsulta($sql_apm_t);
								$total_apm_t  = count($rs_apm_t);
								
								echo"<option selected='selected' value='$apm_t'>$apm_t</option>";
								
								if($apm_t != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}	
									
								for ($i = 0; $i < $total_apm_t; $i++)
								{
									echo "<option value='".$rs_apm_t[$i]['apm_t']."'>".$rs_apm_t[$i]['apm_t']."</option>";	
								}							
								?>
                </select></td>
              <td width="13%"><span class="Estilo5">
                <?
              		if($desc_ger != "" ){$desc_ger = $_POST['c_desc_ger'];}
			  		if($desc_ger == "" ){$desc_ger = "Todos";}
			  	?>
              </span>
                <select name="c_desc_ger" id="c_desc_ger" style="font-size:8px;" onchange="evento();" >
                  <?php
                //*******************************************************************************************************
					$SqlGER = "SELECT DISTINCT desc_ger FROM tb_gerencia ORDER BY desc_ger ";
								
					$RsGER  	 = dbConsulta($SqlGER);
					$totalGER    = count($RsGER);
					echo"<option selected='selected' value='$desc_ger'>$desc_ger</option>";
					if($desc_ger != "Todos")
					{
               			echo"<option value='Todos'>Todos</option>";
                	}	
									
					for ($i = 0; $i < $totalGER; $i++)
					{
						echo "<option value='".$RsGER[$i]['desc_ger']."'>".$RsGER[$i]['desc_ger']."</option>";	
					}							
				?>
                </select></td>
              <td width="13%"><span class="Estilo5">
                <?
              		if($desc_dep != "" ){$desc_dep = $_POST['c_desc_dep'];}
			  		if($desc_dep == "" ){$desc_dep = "Todos";}
			  	?>
              </span>
                <select name="c_desc_dep" id="c_desc_dep" style="font-size:8px;" onchange="evento();" >
                  <?php
                //*******************************************************************************************************
					$Sqldep = "SELECT DISTINCT desc_dep FROM tb_dptos ORDER BY desc_dep ";
								
					$Rsdep  	 = dbConsulta($Sqldep);
					$totaldep    = count($Rsdep);
					echo"<option selected='selected' value='$desc_dep'>$desc_dep</option>";
					if($desc_dep != "Todos")
					{
               			echo"<option value='Todos'>Todos</option>";
                	}	
									
					for ($i = 0; $i < $totaldep; $i++)
					{
						echo "<option value='".$Rsdep[$i]['desc_dep']."'>".$Rsdep[$i]['desc_dep']."</option>";	
					}							
				?>
                </select></td>
              <td width="15%"><span class="Estilo5">
                <?
              		if($desc_ar != "" ){$desc_ar = $_POST['c_desc_ar'];}
			  		if($desc_ar == "" ){$desc_ar = "Todos";}
			  	?>
              </span>
                <select name="c_desc_ar" id="c_desc_ar" style="font-size:8px;" onchange="evento();" >
                  <?php
                //*******************************************************************************************************
					$Sqlar = "SELECT DISTINCT desc_ar FROM tb_areas ORDER BY desc_ar ";
								
					$Rsar  	 = dbConsulta($Sqlar);
					$totalar    = count($Rsar);
					echo"<option selected='selected' value='$desc_ar'>$desc_ar</option>";
					if($desc_ar != "Todos")
					{
               			echo"<option value='Todos'>Todos</option>";
                	}	
									
					for ($i = 0; $i < $totalar; $i++)
					{
						echo "<option value='".$Rsar[$i]['desc_ar']."'>".$Rsar[$i]['desc_ar']."</option>";	
					}							
				?>
                </select></td>
              <td width="12%">
              
              <?
              if($cargo_t != "" ){$cargo_t = $_POST['c_cargo_t'];}
			  if($cargo_t == "" ){$cargo_t = "Todos";}
			  ?>
              <select name="c_cargo_t" id="c_cargo_t" style="font-size:8px;" onchange="evento();" >
                <?php
                              //*******************************************************************************************************
								$sql_cant  = "SELECT DISTINCT cargo_t FROM tb_trabajadores ORDER BY cargo_t";
								
								$rs_cargo_t 	= dbConsulta($sql_cargo_t);
								$total_cargo_t  = count($rs_cargo_t);
								echo"<option selected='selected' value='$cargo_t'>$cargo_t</option>";
								if($cargo_t != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}	
									
								for ($i = 0; $i < $total_cargo_t; $i++)
								{
									echo "<option value='".$rs_cargo_t[$i]['cargo_t']."'>".$rs_cargo_t[$i]['cargo_t']."</option>";	
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
              </tr>
               <tr> 
                	<td colspan="9" align="center" class="txtnormal5"></td>
               </tr>
<?php
/***********************************************************************************************************************
				FILTRAMOS
***********************************************************************************************************************/	
if($_POST['c_rut_t'] != "Todos" and $_POST['c_rut_t'] != "")
{
	$query = "and rut_t = '".$_POST['c_rut_t']."'";
}
if($_POST['c_nom_t'] != "Todos" and $_POST['c_nom_t'] != "")
{
	$query1 = "and nom_t = '".$_POST['c_nom_t']."'";
}
if($_POST['c_app_t'] != "Todos" and $_POST['c_app_t'] != "")
{
	$query2 = "and app_t = '".$_POST['c_app_t']."'";
}
if($_POST['c_apm_t'] != "Todos" and $_POST['c_apm_t'] != "")
{
	$query3 = "and apm_t = '".$_POST['c_apm_t']."'";
}/*	
if($_POST['c_app_m'] != "Todos" and $_POST['c_und_m'] != "")
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
	$query7 = "and tb_det_sol.rec_det = '".$_POST['c_est']."'";
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
}*/

$co=mysql_connect("$DNS","$USR","$PASS");
mysql_select_db("$BDATOS", $co);
		
$sql1	= "SELECT * FROM trabajadores WHERE rut_t != '' $query $query1 $query2 $query3 $query4 $query5 $query6 $query7 $query8 ";
$res	= mysql_query($sql1, $co);
	
$numeroRegistros=mysql_num_rows($res);
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
	
	$sql = "SELECT * FROM trabajadores WHERE rut_t != '' $query $query1 $query2 $query3 $query4 $query5 $query6 $query7 $query8 $query9 $query10 ORDER BY app_t LIMIT ".$limitInf.",".$tamPag;
	
	$respuesta	= mysql_query($sql,$co);
	$color 		= "#ffffff";
	$i=1;
	while($vrows=mysql_fetch_array($respuesta))
	{
		$cod_trab		= "".$vrows['cod_trab']."";
		$rut_t			= "".$vrows['rut_t']."";
		$nom_t			= "".$vrows['nom_t']."";
		$app_t			= "".$vrows['app_t']."";
		$apm_t			= "".$vrows['apm_t']."";
		$area_t			= "".$vrows['area_t']."";
		
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
		
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS", $co);
		
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

		echo"<tr bgcolor=$color class='txtnormal8' onClick='javascript:muestra($cod_trab)'; onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000')>";	

		   echo"<td bgcolor='#ffc561'>&nbsp;<a href=\"trabajadores.php?cod=$cod_trab\"><img src='imagenes/edit.png' border='0' valign='top' alt='Modificar'/>&nbsp;</a></td>
				<td>&nbsp;$rut_t</td>
				<td>&nbsp;$nom_t</td>
				<td>&nbsp;$app_t</td>
				<td>&nbsp;$apm_t</td>
				<td>&nbsp;$desc_ger</td>
				<td>&nbsp;$desc_dep</td>	
				<td>&nbsp;$area_t</td>
				<td>&nbsp;&nbsp;$prof_sol</td>
			</tr>";
									
				if($color == "#ffffff"){ $color = "#ddeeee"; }
				else{ $color = "#ffffff"; }		
	}
	mysql_free_result($respuesta);
}		
?>         
            <tr>
              <td colspan="9" align="center" class="txtnormal" height="30"><?php echo "Encontrados ".$numeroRegistros." resultados"; ?></td>
            </tr>
            <tr>
              <td colspan="9" align="center" class="txtnormaln"><table width="723" border="0" cellspacing="0" cellpadding="0">
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
            ?></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td height="74" colspan="9" align="center" valign="bottom" class="txtnormaln">&nbsp;
               <label><a href='bajar_excel.php?filename=<? echo $fname ?>'><img src="imagenes/botones/rep_excel.jpg" border="0" /></a>
                <input name="Volver" type="submit" class="boton_volver" id="Volver" value="Volver" onclick="enviar('sol_rec.php');" />
                <input name="Volver3" type="submit" class="boton_actualizar" id="Volver3" value="Actualizar" />
              </label>              </td>
            </tr>
           </table>         </td>
        </tr>
       </table>      </td>
     </tr>
     
  <tr>
    <td height="5" colspan="5" align="center" valign="top"><img src="imagenes/barra.gif" alt="" width="100%" height="3" /></td>
  </tr>
</table>
<?php
/***********************************************************************************************************************
MOSTRAMOS LOS ITEM DE LA SOLICITUD QUE ESTAMOS MOSTRANDO
***********************************************************************************************************************/	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sql_rep	= "SELECT * FROM trabajadores WHERE rut_t != '' $query $query1 $query2 $query3 $query4 $query5 $query6 $query7 $query8 $query9 $query10";
	
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
		$fe_aprob_g 	= "".$vrows_rep['fe_aprob_g']."";
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
        $worksheet->write($filaexcel,2,$ods_sol,$formato);
        $worksheet->write($filaexcel,3,utf8_decode($desc_sol),$formato);
        $worksheet->write($filaexcel,4,utf8_decode($nom_um),$formato);
		$worksheet->write($filaexcel,5,$cant_det,$formato);
        $worksheet->write($filaexcel,6,$fe_sol,$formato);
		$worksheet->write($filaexcel,7,$fe_aprob_g,$formato);
		$worksheet->write($filaexcel,8,utf8_decode($rec_det),$formato);
		$worksheet->write($filaexcel,9,$cant_recep,$formato);
		$worksheet->write($filaexcel,10,$num_oc,$formato);
		$worksheet->write($filaexcel,11,utf8_decode($prof_sol),$formato);
									
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
