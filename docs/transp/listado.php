<?
error_reporting(0);
// Necesario para ver si la session esta activa  o si se tiene permiso de accseso
require("../lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php
//
//Definimos el nivel de acceso  (esto es un bonus track para definir que ciertos usuarios puedan entrar a algunas paginas y a otras no)
// Si los usuarios normales tienen acceso=10, para que  accedan todos los usuarios le damos acceso mayor a 10.
/*$nivel_acceso =10;
if ($nivel_acceso < $_SESSION['usuario_nivel']){
	header ("Location: ../index2.php?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}*/
//Hasta aquí lo comun para todas las paginas restringidas
	include('../inc/config_db.php'); 	// Incluimos archivo de configuracion de la conexion
	include('../inc/lib.db.php');		// Incluimos archivo de libreria de funciones PHP
	
	$cod_tods	 	= "Todos";
	$fe_tods 		= "Todos";
	$cond_tods	    = "Todos";
	$nom_coord	 	= "Todos";
	$cc_tods 		= "Todos";
	$nom_dest 		= "Todos";
	$nom_veh		= "Todos";
	$kmini_tods 	= "Todos";
	$kmlleg_tods 	= "Todos";
	$carg_tods 		= "Todos";
	$hrsal_tods 	= "Todos";
	$ing_por	 	= "Todos";
/**************************************************************************
	COMIENZA REPORTE EXCEL
**************************************************************************/	
	require_once("excelclass/class.writeexcel_workbookbig.inc.php");
	require_once("excelclass/class.writeexcel_worksheet.inc.php");
	require_once("excelclass/functions.writeexcel_utility.inc.php");

	$fname="tmp/reporte.xls";
	
	$workbook  =  new writeexcel_workbookbig($fname);
	$worksheet = & $workbook->addworksheet('hoja1');
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
	$worksheet->write(3,4,"ORDENES DE SERVICIO",$for_titulo);
	$worksheet->write(3,5,"",$for_titulo);
	$worksheet2->write(3,4,"HOJA 2",$for_titulo);
	$worksheet3->write(3,4,"HOJA 3",$for_titulo);
	
	// ENCABEZADOS
	
	$worksheet->write(5,0,"COD.",$encabezado);
	$worksheet->write(5,1,"FECHA",$encabezado);
	$worksheet->write(5,2,"CONDUCTOR",$encabezado);
	$worksheet->write(5,3,"COORDINADOR",$encabezado);
	$worksheet->write(5,4,"CENTRO COSTO",$encabezado);
	$worksheet->write(5,5,"DESTINO",$encabezado);
	$worksheet->write(5,6,"VEHICULO",$encabezado);
	$worksheet->write(5,7,"KM INICIO",$encabezado);
	$worksheet->write(5,8,"KM LLEGADA",$encabezado);
	$worksheet->write(5,9,"CARGA O MATERIALES",$encabezado);
	$worksheet->write(5,10,"HR SALIDA",$encabezado);
	$worksheet->write(5,11,"HR LLEGADA",$encabezado);
	$worksheet->write(5,12,"TOTAL HRS",$encabezado);
	$worksheet->write(5,13,"DOCUMENTOS",$encabezado);
	$worksheet->write(5,14,"OBSERVACION",$encabezado);
	$worksheet->write(5,15,"INGRESADA POR",$encabezado);

	$worksheet->insert_bitmap('A1', 'imagenes/logo.bmp', 1, 1);	
	
/**************************************************************************

**************************************************************************/	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Listado de Ingresos</title>
<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">
<link rel="STYLESHEET" type="text/css" href="../codebase/dhtmlxgrid.css"><!-- llama hoja de estilo -->
<script type="text/javascript" language="JavaScript" src="../inc/funciones.js"></script>

<script LANGUAGE="JavaScript">
function muestra(elemento)
{
	document.form1.action = 'ords.php?cod='+elemento;
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
	document.form1.action='listado.php?pagina='+1;
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
	document.form1.action	="rep_lista_tods.php";
	document.form1.submit();
	document.form1.target	='';
	document.form1.action	='';
}
function ingreso()
{
	document.form1.action = 'ingreso.php';
	document.form1.submit();
}
</script>

<style type="text/css">

body {
	background-color: #527eab;
	margin-top: 15px;
}
.Estilo5 {color: #000000}

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

<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>

<body>
<form id="form1" name="form1" method="post" action="" > 
  <table width="1100" height="199" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="101" height="55" align="center" valign="top"><a href="../index2.php"><img src="../imagenes/logo2.jpg" alt="" width="100" height="60" border="0" /></a></td>
    <td width="84" height="55" align="center" valign="middle"><input name="Volver2" type="submit" class="boton_inicio" id="Volver2" value="Inicio" onclick="enviar('../index2.php');" /></td>
    <td width="82" align="center" valign="middle"><input name="Volver3" type="submit" class="boton_volver" id="Volver3" value="Volver" onclick="enviar('ords.php');" /></td>
    <td width="692" align="center" valign="middle" class="txtnormal3n">LISTADO ORDENES DE SERVICIO TRANSPORTES</td>
    <td width="80" align="center" valign="middle"><input name="Volver4" type="submit" class="boton_actualizar" id="Volver4" value="Actualizar" /></td>
    <td width="65" align="center" valign="middle">&nbsp;</td>
    <td width="93" align="center" valign="top"><img src="../imagenes/logo_iso_c.jpg" width="93" height="50" /></td>
  </tr>
  <tr>
    <td height="114" colspan="7" align="center" valign="top">
      <table width="1043" height="114" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
        <tr>
          <td width="1043" height="114" align="center" valign="top">
          <table width="1089" border="1" bordercolor="#F2F2F2" bgcolor="#cedee1" class="txtnormal2" cellspacing="0" cellpadding="0">
        	<tr style="background:#cedee1;" class="txtnormal8">
        		<td align="center">&nbsp;EDIT.</td>
				<td align="center">NUM</td>
				<td align="center">FECHA</td>
				<td align="center">				  CONDUCTOR</td>
				<td align="center">				  COORDINADOR</td>
				<td align="center">CENTRO COSTO</td>
				<td align="center">DESTINO</td>
				<td align="center">VEHICULO</td>
				<td align="center">KM INICIO</td>
				<td align="center">KM LLEGADA</td>
				<td align="center">HR SALIDA</td>
				<td align="center">INGRESADA POR</td>
        	</tr>
            <tr class="txtnormal8" align="center">
              <td width="3%" style="background:#cedee1;">&nbsp;</td>
			  <td width="3%">
			    <?
              if($cod_tods != "" ){$cod_tods = $_POST['c_cod_tods'];}
			  if($cod_tods == "" ){$cod_tods = "Todos";}
			  ?>
			    <select name="c_cod_tods" id="c_cod_tods" style="font-size:8px;" onchange="evento();">
			      <?php
                //*******************************************************************************************************
					$sqlods  	= "SELECT DISTINCT cod_tods FROM tb_tranods WHERE cod_tods != 'No Estudio' ORDER BY cod_tods";
								
					$rsnume 	= dbConsulta($sqlods);
					$totaln  	= count($rsnume);
					echo"<option selected='selected' value='$cod_tods'>$cod_tods</option>";
					
					if($cod_tods != "Todos")
					{
               			echo"<option value='Todos'>Todos</option>";
                	}					
					for ($i = 0; $i < $totaln; $i++)
					{
						echo "<option value='".$rsnume[$i]['cod_tods']."'>".$rsnume[$i]['cod_tods']."</option>";	
					}							
				?>
			      </select>			    </td>
              <td width="3%"><span class="Estilo5">
                <?
              		if($fe_tods != "" ){$fe_tods = $_POST['c_fe_tods'];}
					if($fe_tods == "" ){$fe_tods = "Todos";}
			  	?>
                <select name="c_fe_tods" id="c_fe_tods" style="font-size:8px;" onchange="evento();" >
                  <?php
                //*******************************************************************************************************
					$SqlFi = "SELECT DISTINCT fe_tods FROM tb_tranods WHERE fe_tods != '' ORDER BY fe_tods ";
								
					$RsFi 		= dbConsulta($SqlFi);
					$totalFi  	= count($RsFi);
					
					echo"<option selected='selected' value='$fe_tods'>$fe_tods</option>";
					
					if($fe_tods != "Todos")
					{
               			echo"<option value='Todos'>Todos</option>";
                	}	
									
					for ($i = 0; $i < $totalFi; $i++)
					{
						$RsFi[$i]['fe_tods']	= cambiarFecha($RsFi[$i]['fe_tods'], '-', '/' ); 
						echo "<option value='".$RsFi[$i]['fe_tods']."'>".$RsFi[$i]['fe_tods']."</option>";	
					}							
				?>
                </select></td>
              <td width="8%"><?
              if($cond_tods != "" ){$cond_tods = $_POST['c_cond_tods'];}
			  if($cond_tods == "" ){$cond_tods = "Todos";}
			  ?>
                <select name="c_cond_tods" id="c_cond_tods" style="font-size:8px;" onchange="evento();" >
                  <?php
                //*******************************************************************************************************
					$Sqlcarg  = "SELECT DISTINCT cond_tods FROM tb_tranods WHERE cond_tods != '' ORDER BY cond_tods ";
								
					$Rscarg 	= dbConsulta($Sqlcarg);
					$totalcarg  = count($Rscarg);
					
					echo"<option selected='selected' value='$cond_tods'>$cond_tods</option>";
					
					if($cond_tods != "Todos")
					{
               			echo"<option value='Todos'>Todos</option>";
                	}	
									
					for ($i = 0; $i < $totalcarg; $i++)
					{
						echo "<option value='".$Rscarg[$i]['cond_tods']."'>".$Rscarg[$i]['cond_tods']."</option>";	
					}							
				?>
                </select></td>
              <td width="9%"><?
              if($nom_coord != "" ){$nom_coord = $_POST['c_nom_coord'];}
			  if($nom_coord == "" ){$nom_coord = "Todos";}
			  ?>
                <select name="c_nom_coord" style="font-size:8px;" onchange="evento();" >
                  <?php
/*******************************************************************************************************************************************   
						PREGUNTAMOS SI EL SELECT ENVIO UN VALOR NUMERICO(CODIGO DE EQUIPO)
********************************************************************************************************************************************/                           
								if(is_numeric($_POST['c_nom_coord']))
								{
									$sql3 = "SELECT * FROM tb_coordinador WHERE cod_coord = '".$_POST['c_nom_coord']."' ";
									$resp3 	= dbExecute($sql3);
									while ($vrows3 = mysql_fetch_array($resp3)) 
									{
										$nom_coord 	= "".$vrows3['nom_coord']."";
										$cod_coorM	= "".$vrows3['cod_coord']."";
									}
								}
									$sqle   = "SELECT nom_coord, cod_coord FROM tb_coordinador ORDER BY nom_coord ";
									$rse 	 = dbConsulta($sqle);
									$totale  = count($rse);
									
									echo"<option selected='selected' value='$cod_coorM'>$nom_coord</option>";
										if($cod_coorM != "Todos"){
               								echo"<option value='Todos'>Todos</option>";
                						}
												
									for ($i = 0; $i < $totale; $i++)
									{
										$nombre_coord = $rse[$i]['nom_coord'];
										if($nom_coord != $nombre_coord){
											echo "<option value='".$rse[$i]['cod_coord']."'>".$rse[$i]['nom_coord']."</option>";
										}
									}
								
							?>
                </select></td>
              <td width="5%"><span class="Estilo5">
                <?
              		if($cc_tods != "" ){$cc_tods = $_POST['c_cc_tods'];}
					if($cc_tods == "" ){$cc_tods = "Todos";}
			  	?>
                <select name="c_cc_tods" id="c_cc_tods" style="font-size:8px;" onchange="evento();" >
               <?php
                //*******************************************************************************************************
					$SqlFv = "SELECT DISTINCT cc_tods FROM tb_tranods WHERE cc_tods != '' ORDER BY cc_tods ";
								
					$RsFv 	 = dbConsulta($SqlFv);
					$totalRv = count($RsFv);
					echo"<option selected='selected' value='$cc_tods'>$cc_tods</option>";
					
					if($cc_tods != "Todos")
					{
               			echo"<option value='Todos'>Todos</option>";
                	}	
									
					for ($i = 0; $i < $totalRv; $i++)
					{
						echo "<option value='".$RsFv[$i]['cc_tods']."'>".$RsFv[$i]['cc_tods']."</option>";	
					}							
				?>
              </select>
              </span></td>
              <td width="23%"><?
              if($nom_dest != "" ){$nom_dest = $_POST['c_nom_dest'];}
			  if($nom_dest == "" ){$nom_dest = "Todos";}
			  ?>
                <select name="c_nom_dest" style="font-size:8px;" onchange="evento();" >
                  <?php
/*******************************************************************************************************************************************   
						PREGUNTAMOS SI EL SELECT ENVIO UN VALOR NUMERICO(CODIGO DE EQUIPO)
********************************************************************************************************************************************/                           
								if(is_numeric($_POST['c_nom_dest']))
								{
									$sql3 = "SELECT * FROM tb_destino WHERE cod_dest = '".$_POST['c_nom_dest']."' ";
									$resp3 	= dbExecute($sql3);
									while ($vrows3 = mysql_fetch_array($resp3)) 
									{
										$nom_dest 	= "".$vrows3['nom_dest']."";
										$cod_destM	= "".$vrows3['cod_dest']."";
									}
								}
									$sqle   = "SELECT nom_dest, cod_dest FROM tb_destino ORDER BY nom_dest ";
									$rse 	 = dbConsulta($sqle);
									$totale  = count($rse);
									
									echo"<option selected='selected' value='$cod_destM'>$nom_dest</option>";
										if($nom_dest != "Todos"){
               								echo"<option value='Todos'>Todos</option>";
                						}
												
									for ($i = 0; $i < $totale; $i++)
									{
										$nombre_dest = $rse[$i]['nom_dest'];
										if($nom_dest != $nombre_dest){
											echo "<option value='".$rse[$i]['cod_dest']."'>".$rse[$i]['nom_dest']."</option>";
										}
									}
								
							?>
                </select></td>
			  <td width="18%"><?
              if($nom_veh != "" ){$nom_veh = $_POST['c_nom_veh'];}
			  if($nom_veh == "" ){$nom_veh = "Todos";}
			  ?>
                <select name="c_nom_veh" style="font-size:8px;" onchange="evento();" >
                  <?php
/*******************************************************************************************************************************************   
						PREGUNTAMOS SI EL SELECT ENVIO UN VALOR NUMERICO(CODIGO DE EQUIPO)
********************************************************************************************************************************************/                           
								if(is_numeric($_POST['c_nom_veh']))
								{
									$sql3 = "SELECT * FROM tb_vehiculos WHERE cod_veh = '".$_POST['c_nom_veh']."' ";
									$resp3 	= dbExecute($sql3);
									while ($vrows3 = mysql_fetch_array($resp3)) 
									{
										$nom_veh 	= "".$vrows3['nom_veh']."";
										$cod_vehM	= "".$vrows3['cod_veh']."";
									}
								}
									$sqle   = "SELECT nom_veh, cod_veh FROM tb_vehiculos ORDER BY nom_veh";
									$rsveh 	= dbConsulta($sqle);
									$total_veh  = count($rsveh);
									
									echo"<option selected='selected' value='$cod_vehM'>$nom_veh</option>";
										if($nom_veh != "Todos"){
               								echo"<option value='Todos'>Todos</option>";
                						}
												
									for ($i = 0; $i < $total_veh; $i++)
									{
										$nombre_veh = $rsveh[$i]['nom_veh'];
										if($nom_veh != $nombre_veh){
											echo "<option value='".$rsveh[$i]['cod_veh']."'>".$rsveh[$i]['nom_veh']."</option>";
										}
									}
								
							?>
                </select></td>
              <td width="4%">
			  <?
              if($kmini_tods != "" ){$kmini_tods = $_POST['c_kmini_tods'];}
			  if($kmini_tods == "" ){$kmini_tods = "Todos";}
			  ?>
			  <select name="c_kmini_tods" id="c_kmini_tods" style="font-size:8px;" onchange="evento();" >
			    <?php
                //*******************************************************************************************************
					$Sqlkmini  = "SELECT DISTINCT kmini_tods FROM tb_tranods WHERE kmini_tods != '' ORDER BY kmini_tods";
								
					$Rskmini 	 	= dbConsulta($Sqlkmini);
					$totalkmini  	= count($Rskmini);
					echo"<option selected='selected' value='$kmini_tods'>$kmini_tods</option>";
					if($kmini_tods != "Todos")
					{
               			echo"<option value='Todos'>Todos</option>";
                	}				
					for ($i = 0; $i < $totalkmini; $i++)
					{
						echo "<option value='".$Rskmini[$i]['kmini_tods']."'>".$Rskmini[$i]['kmini_tods']."</option>";	
					}							
				?>
			    </select></td>
              <td width="5%"><?
              if($kmlleg_tods != "" ){$kmlleg_tods = $_POST['c_kmlleg_tods'];}
			  if($kmlleg_tods == "" ){$kmlleg_tods = "Todos";}
			  ?>
                <select name="c_kmlleg_tods" id="c_kmlleg_tods" style="font-size:8px;" onchange="evento();" >
                  <?php
                //*******************************************************************************************************
					$Sqlkmlleg  = "SELECT DISTINCT kmlleg_tods FROM tb_tranods WHERE kmlleg_tods != '' ORDER BY kmlleg_tods";
								
					$Rskmlleg 	 	= dbConsulta($Sqlkmlleg);
					$totalkmlleg  	= count($Rskmlleg);
					echo"<option selected='selected' value='$kmlleg_tods'>$kmlleg_tods</option>";
					if($kmlleg_tods != "Todos")
					{
               			echo"<option value='Todos'>Todos</option>";
                	}				
					for ($i = 0; $i < $totalkmlleg; $i++)
					{
						echo "<option value='".$Rskmlleg[$i]['kmlleg_tods']."'>".$Rskmlleg[$i]['kmlleg_tods']."</option>";	
					}							
				?>
                </select></td>
              <?
			/******************************************************************************************************************************   
						PREGUNTAMOS SI EL SELECT ENVIO UN VALOR NUMERICO(CODIGO DE EQUIPO)
			*******************************************************************************************************************************/  
			  if($contacto_cot != ""){$contacto_cot = $_POST['c_contacto'];}
			  if($contacto_cot == ""){$contacto_cot = "Todos";}
			  ?>            
              <td width="4%"align="center">
                <?
              if($hrsal_tods != ""){$hrsal_tods = $_POST['c_hrsal_tods'];}
			  if($hrsal_tods == ""){$hrsal_tods = "Todos";}
			  ?>
                <select name="c_hrsal_tods" id="c_hrsal_tods" style="font-size:8px;" onchange="evento();" >
                  <?php
                //*******************************************************************************************************
					$SqlHrsal  = "SELECT DISTINCT hrsal_tods FROM tb_tranods WHERE hrsal_tods != '' ORDER BY hrsal_tods ";
								
					$RsHrsal 		= dbConsulta($SqlHrsal);
					$totalHrsal  	= count($RsHrsal);
					
					echo"<option selected='selected' value='$hrsal_tods'>$hrsal_tods</option>";
					
					if($hrsal_tods != "Todos")
					{
               			echo"<option value='Todos'>Todos</option>";
                	}	
									
					for ($i = 0; $i < $totalHrsal; $i++)
					{
						echo "<option value='".$RsHrsal[$i]['hrsal_tods']."'>".$RsHrsal[$i]['hrsal_tods']."</option>";	
					}							
				?>
                </select></td>
              <td width="15%"align="center"><?
              if($ing_por != ""){$ing_por = $_POST['c_ing_por'];}
			  if($ing_por == ""){$ing_por = "Todos";}
			  ?>
                <select name="c_ing_por" id="c_ing_por" style="font-size:8px;" onchange="evento();" >
                  <?php
                //*******************************************************************************************************
					$SqlIngP  = "SELECT DISTINCT ing_por FROM tb_tranods WHERE ing_por != '' ORDER BY ing_por ";
								
					$RsIngP 		= dbConsulta($SqlIngP);
					$totalIngP  	= count($RsIngP);
					
					echo"<option selected='selected' value='$ing_por'>$ing_por</option>";
					
					if($ing_por != "Todos")
					{
               			echo"<option value='Todos'>Todos</option>";
                	}	
									
					for ($i = 0; $i < $totalIngP; $i++)
					{
						echo "<option value='".$RsIngP[$i]['ing_por']."'>".$RsIngP[$i]['ing_por']."</option>";	
					}							
				?>
                </select></td>
			  </tr>
		<?php
		/***********************************************************************************************************************
				FILTRAMOS
		***********************************************************************************************************************/	
	if($_POST['c_cod_tods'] != "Todos" and $_POST['c_cod_tods'] != "")
	{
		$query = "and cod_tods = '".$_POST['c_cod_tods']."'";
	}
	if($_POST['c_fe_tods'] != "Todos" and $_POST['c_fe_tods'] != "")
	{
		$_POST['c_fe_tods']	= cambiarFecha($_POST['c_fe_tods'], '/', '-' );
		$query12 = "and fe_tods = '".$_POST['c_fe_tods']."'";
	}		
	if($_POST['c_cond_tods'] != "Todos" and $_POST['c_cond_tods'] != "")
	{
		$query2 = "and cond_tods = '".$_POST['c_cond_tods']."'";
	}	
	if($_POST['c_nom_coord'] != "Todos" and $_POST['c_nom_coord'] != "")
	{
		$query3 = "and coord_tods = '".$_POST['c_nom_coord']."'";
	}
	if($_POST['c_cc_tods'] != "Todos" and $_POST['c_cc_tods'] != "")
	{
		$query4 = "and cc_tods = '".$_POST['c_cc_tods']."'";
	}
	if($_POST['c_nom_dest'] != "Todos" and $_POST['c_nom_dest'] != "")
	{
		$query5 = "and dest_tods = '".$_POST['c_nom_dest']."'";
	}
	if($_POST['c_nom_veh'] != "Todos" and $_POST['c_nom_veh'] != "")
	{
		$query6 = "and veh_tods = '".$_POST['c_nom_veh']."'";
	}
	if($_POST['c_kmini_tods'] != "Todos" and $_POST['c_kmini_tods'] != "")
	{
		$query7 = "and kmini_tods = '".$_POST['c_kmini_tods']."'";
	}
	if($_POST['c_kmlleg_tods'] != "Todos" and $_POST['c_kmlleg_tods'] != "")
	{
		$query8 = "and kmlleg_tods = '".$_POST['c_kmlleg_tods']."'";
	}
	if($_POST['c_carg_tods'] != "Todos" and $_POST['c_carg_tods'] != "")
	{
		$query9 = "and carg_tods = '".$_POST['c_carg_tods']."'";
	}
	if($_POST['c_hrsal_tods'] != "Todos" and $_POST['c_hrsal_tods'] != "")
	{
		$query10 = "and hrsal_tods = '".$_POST['c_hrsal_tods']."'";
	}
	if($_POST['c_ing_por'] != "Todos" and $_POST['c_ing_por'] != "")
	{
		$query11 = "and ing_por = '".$_POST['c_ing_por']."'";
	}

/***************************************************************************************************************************/
$co=mysql_connect("$DNS","$USR","$PASS");
mysql_select_db("$BDATOS", $co);
		
$sql1	= "SELECT * FROM tb_tranods WHERE cod_tods != '' and empr_sol = 'Rockmine' $query $query1 $query2 $query3 $query4 $query5 $query6 $query7 $query8 $query9 $query10 $query11 $query12 ORDER BY cod_tods ";
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
									MOSTRAMOS LOS INGRESOS
***********************************************************************************************************************/	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sql = "SELECT * FROM tb_tranods WHERE cod_tods != '' and empr_sol != '' $query $query1 $query2 $query3 $query4 $query5 $query6 $query7 $query8 $query9 $query10 $query11 $query12 ORDER BY cod_tods DESC LIMIT ".$limitInf.",".$tamPag;
	$respuesta = mysql_query($sql,$co);
	
	$color = "#ffffff";
	$i=1;
	while($vrows=mysql_fetch_array($respuesta))
	{
		$cod_tods 		= "".$vrows['cod_tods']."";
		$fe_tods 		= "".$vrows['fe_tods']."";
		$cond_tods 		= "".$vrows['cond_tods']."";
		$coord_tods 	= "".$vrows['coord_tods']."";
		$cc_tods 		= "".$vrows['cc_tods']."";
		$dest_tods 		= "".$vrows['dest_tods']."";
		$veh_tods 		= "".$vrows['veh_tods']."";
		$kmini_tods 	= "".$vrows['kmini_tods']."";
		$kmlleg_tods 	= "".$vrows['kmlleg_tods']."";
		$carg_tods 		= "".$vrows['carg_tods']."";
		$hrsal_tods 	= "".$vrows['hrsal_tods']."";
		$hrlleg_tods 	= "".$vrows['hrlleg_tods']."";
		$tothrs_tods 	= "".$vrows['tothrs_tods']."";
		$doc_tods 		= "".$vrows['doc_tods']."";
		$obs_tods 		= "".$vrows['obs_tods']."";
		$ing_por 		= "".$vrows['ing_por']."";
		
		$sql_coord = "SELECT nom_coord FROM tb_coordinador WHERE cod_coord = '$coord_tods' ";
		$res = mysql_query($sql_coord,$co);
		while($vrowscoord=mysql_fetch_array($res))
		{
			$nom_coord = "".$vrowscoord['nom_coord']."";
		}
		$sql_dest = "SELECT nom_dest FROM tb_destino WHERE cod_dest  = '$dest_tods' ";
		$res = mysql_query($sql_dest ,$co);
		while($vrowsdest = mysql_fetch_array($res))
		{
			$nom_dest  = "".$vrowsdest ['nom_dest']."";
		}
		
		$sql_veh = "SELECT * FROM tb_vehiculos WHERE cod_veh  = '$veh_tods' ";
		$res_veh = mysql_query($sql_veh ,$co);
		while($vrowsveh = mysql_fetch_array($res_veh))
		{
			$nom_veh  = "".$vrowsveh ['nom_veh']."";
		}
		
		
		$fe_tods	= cambiarFecha($fe_tods, '-', '/' );
		
		echo("<tr bgcolor=$color class='txtnormal8' onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000') align=left onClick=\"javascript:muestra('$cod_tods')\";>	
									
		<td bgcolor='#ffc561'>&nbsp;<a href=\"ords.php?cod=$cod_tods\"><img src='../imagenes/edit.png' border='0' valign='top' alt='Modificar'/>&nbsp;</td>
		<td bgcolor='#cedee1'>&nbsp;$cod_tods</td>
		<td>&nbsp;$fe_tods</td>
		<td>&nbsp;$cond_tods</td>	
		<td>&nbsp;$nom_coord</td>
		<td>&nbsp;$cc_tods</td>	
		<td>&nbsp;$nom_dest</td>
		<td>&nbsp;$nom_veh</td>
		<td>&nbsp;$kmini_tods</td>	
		<td>&nbsp;$kmlleg_tods</td>	
		<td>&nbsp;$hrsal_tods</td>	
		<td>&nbsp;$ing_por</td>	
		</tr> ");
		if($color == "#ffffff"){ $color = "#ddeeee"; }
		else{ $color = "#ffffff"; }
		$i++;			
	}	
}			
?>  
			  <tr>
			  <td height="29" colspan="12" align="center" class="txtnormal5"><?php echo "Encontrados ".$numeroRegistros." resultados"; ?></td>
              </tr>
			  <tr>
			    <td colspan="12" align="center" class="txtnormal5"><table width="1091" border="0" cellspacing="0" cellpadding="0">
			      <tr>
			        <td width="106">&nbsp;</td>
			        <td width="985" align="center"><?
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
              <td colspan="12" align="center" class="txtnormaln">
              
              <a href='bajar_excel.php?filename=<?php echo $fname ?>'>
              <img src="../imagenes/botones/rep_excel.jpg" alt="" border="0" /></a>
              <input name="Volver" type="submit" class="boton_volver" id="Volver" value="Volver" onclick="enviar('../index2.php');" /></td>
            </tr>
          </table>		  </td>
        </tr>
      </table>	  </td>
  </tr>
  <tr>
    <td height="5" colspan="7" align="center" valign="top"><img src="imagenes/barra.gif" alt="" width="100%" height="2" /></td>
  </tr>
</table>
<?php
/***********************************************************************************************************************
REALIZAMOS LA CONSULTA PARA GENERAR REPORTE EN EXCEL
***********************************************************************************************************************/		
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sql_rep  = "SELECT * FROM tb_tranods WHERE cod_tods != '' and empr_sol != '' $query $query1 $query2 $query3 $query4 $query5 $query6 $query7 $query8 $query9 $query10 $query11 $query12 ORDER BY cod_tods ";
	$resp_rep = mysql_query($sql_rep, $co);

	$filaexcel = 6;
	while($vrows_rep=mysql_fetch_array($resp_rep))
	{
		$cod_tods 		= "".$vrows_rep['cod_tods']."";
		$fe_tods 		= "".$vrows_rep['fe_tods']."";
		$cond_tods 		= "".$vrows_rep['cond_tods']."";
		$coord_tods 	= "".$vrows_rep['coord_tods']."";
		$cc_tods 		= "".$vrows_rep['cc_tods']."";
		$dest_tods 		= "".$vrows_rep['dest_tods']."";
		$veh_tods 		= "".$vrows_rep['veh_tods']."";
		$kmini_tods 	= "".$vrows_rep['kmini_tods']."";
		$kmlleg_tods 	= "".$vrows_rep['kmlleg_tods']."";
		$carg_tods 		= "".$vrows_rep['carg_tods']."";
		$hrsal_tods 	= "".$vrows_rep['hrsal_tods']."";
		$hrlleg_tods 	= "".$vrows_rep['hrlleg_tods']."";
		$tothrs_tods 	= "".$vrows_rep['tothrs_tods']."";
		$doc_tods 		= "".$vrows_rep['doc_tods']."";
		$obs_tods 		= "".$vrows_rep['obs_tods']."";
		$ing_por 		= "".$vrows_rep['ing_por']."";
		
		$sql_coord = "SELECT nom_coord FROM tb_coordinador WHERE cod_coord = '$coord_tods' ";
		$res = mysql_query($sql_coord,$co);
		while($vrowscoord=mysql_fetch_array($res))
		{
			$nom_coord = "".$vrowscoord['nom_coord']."";
		}
		$sql_dest = "SELECT nom_dest FROM tb_destino WHERE cod_dest  = '$dest_tods' ";
		$res = mysql_query($sql_dest ,$co);
		while($vrowsdest = mysql_fetch_array($res))
		{
			$nom_dest  = "".$vrowsdest ['nom_dest']."";
		}
		
		$sql_veh = "SELECT * FROM tb_vehiculos WHERE cod_veh  = '$veh_tods' ";
		$res_veh = mysql_query($sql_veh ,$co);
		while($vrowsveh = mysql_fetch_array($res_veh))
		{
			$nom_veh  = "".$vrowsveh ['nom_veh']."";
		}
		
		$fe_tods	= cambiarFecha($fe_tods, '-', '/' );
									
		$worksheet->write($filaexcel,0,$vrows_rep['cod_tods'],$formato);
        $worksheet->write($filaexcel,1,$fe_tods,$formato);
        $worksheet->write($filaexcel,2,$vrows_rep['cond_tods'],$formato);
        $worksheet->write($filaexcel,3,$nom_coord,$formato);
        $worksheet->write($filaexcel,4,$vrows_rep['cc_tods'],$formato);
		$worksheet->write($filaexcel,5,$nom_dest,$formato);
        $worksheet->write($filaexcel,6,$nom_veh,$formato);
		$worksheet->write($filaexcel,7,$vrows_rep['kmini_tods'],$formato);
		$worksheet->write($filaexcel,8,utf8_decode($vrows_rep['kmlleg_tods']),$formato);
		$worksheet->write($filaexcel,9,utf8_decode($vrows_rep['carg_tods']),$formato);
		$worksheet->write($filaexcel,10,utf8_decode($vrows_rep['hrsal_tods']),$formato);
		$worksheet->write($filaexcel,11,utf8_decode($vrows_rep['hrlleg_tods']),$formato);
		$worksheet->write($filaexcel,12,utf8_decode($vrows_rep['tothrs_tods']),$formato);
		$worksheet->write($filaexcel,13,utf8_decode($vrows_rep['doc_tods']),$formato);
		$worksheet->write($filaexcel,14,utf8_decode($vrows_rep['obs_tods']),$formato);
		$worksheet->write($filaexcel,15,utf8_decode($ing_por),$formato);

		$filaexcel++;				
	}

	$workbook->close();	
?>
</form> 
</body>
</html>
