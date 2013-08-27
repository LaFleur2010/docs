<?
// Necesario para ver si la session esta activa  o si se tiene permiso de accseso
require("../lg/lg_controlar.php");
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
?>
<?php
	include('../inc/config_db.php');
	include('../inc/lib.db.php');
	
	$ods 			= "Todos";
	$area 			= "Todos";
	$priori 		= "Todos";
	$estado 		= "Todos";
	$est_inf 		= "Todos";
	$fe_ent_aprox 	= "Todos";
	$fe_in_ret 		= "Todos";
	$cant	 		= "Todos";
	$desc_eq_scont 	= "Todos";
	$planta 		= "Todos";
	$usuario		= "Todos";
	
/**************************************************************************
	COMIENZA REPORTE EXCEL
**************************************************************************/	
	require_once("../excelclass/class.writeexcel_workbookbig.inc.php");
	require_once("../excelclass/class.writeexcel_worksheet.inc.php");
	require_once("../excelclass/functions.writeexcel_utility.inc.php");
	
	$fname="../tmp/reporte.xls";
	
	$workbook  = & new writeexcel_workbookbig($fname);
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
	$worksheet->write(3,4,"REPORTE ODS",$for_titulo);
	$worksheet->write(3,5,"",$for_titulo);
	$worksheet2->write(3,4,"HOJA 2",$for_titulo);
	$worksheet3->write(3,4,"HOJA 3",$for_titulo);
	
	// ENCABEZADOS
	
	$worksheet->write(7,0,"ODS",$encabezado);
	$worksheet->write(7,1,"AREA",$encabezado);
	$worksheet->write(7,2,"FECHA ING",$encabezado);
	$worksheet->write(7,3,"ESTADO",$encabezado);
	$worksheet->write(7,4,"CANT",$encabezado);
	$worksheet->write(7,5,"GUIA DESP. DET.",$encabezado);
	$worksheet->write(7,6,"DESC SEGUN CONT",$encabezado);
	$worksheet->write(7,7,"DESC SEGUN GUIA",$encabezado);
	$worksheet->write(7,8,"OBSERVACION",$encabezado);
	$worksheet->write(7,9,"FECHA APROB",$encabezado);
	$worksheet->write(7,10,"FECHA ENT 1",$encabezado);
	$worksheet->write(7,11,"GUIA ENT 1",$encabezado);
	$worksheet->write(7,12,"FECHA ENT 2",$encabezado);
	$worksheet->write(7,13,"GUIA ENT 2",$encabezado);
	$worksheet->write(7,14,"FECHA ENT 3",$encabezado);
	$worksheet->write(7,15,"GUIA ENT 3",$encabezado);
	$worksheet->write(7,16,"FECHA ENT 4",$encabezado);
	$worksheet->write(7,17,"GUIA ENT 4",$encabezado);
	$worksheet->write(7,18,"FECHA ENT 5",$encabezado);
	$worksheet->write(7,19,"GUIA ENT 5",$encabezado);
	$worksheet->write(7,20,"FECHA CIERRE",$encabezado);
	$worksheet->write(7,21,"PLANTA",$encabezado);
	$worksheet->write(7,22,"USUARIO",$encabezado);
	$worksheet->write(7,23,"PRECIO",$encabezado);
	$worksheet->write(7,24,"% AVANCE",$encabezado);
	$worksheet->insert_bitmap('A1', '../imagenes/logo.bmp', 1, 1);	
/**************************************************************************
	FIN REPORTE EXCEL
**************************************************************************/	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Programación Maestranza</title>

<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">
<link rel="STYLESHEET" type="text/css" href="../codebase/dhtmlxgrid.css"><!-- llama hoja de estilo -->
<script type="text/javascript" language="JavaScript" src="inc/funciones.js"></script>

<!-- BARRA DE PROGRESO-->
<link href="../progressBar/lib/style.css" rel="stylesheet" type="text/css" media="screen" />
<script language="javascript" type="text/javascript" src="../progressBar/lib/prototype.js"></script>
<script language="javascript" type="text/javascript" src="../progressBar/lib/progress.js"></script>

<!-- VENTANA MODAL -->
<script type="text/javascript" src="../modal/js/ventana-modal-1.3.js"></script>
<script type="text/javascript" src="../modal/js/abrir-ventana-variable.js"></script>
<script type="text/javascript" src="../modal/js/abrir-ventana-fija.js"></script>
<script type="text/javascript" src="../modal/js/abrir-ventana-fotos.js"></script>
<script type="text/javascript" src="../modal/js/abrir-ventana-alertas.js"></script>
<script type="text/javascript" src="../modal/js/abrir-ventana-cargando.js"></script>
<link href="../modal/css/ventana-modal.css" rel="stylesheet" type="text/css">
<link href="../modal/css/style.css" rel="stylesheet" type="text/css">
<!-- FIN VENTANA MODAL -->


<!-- PARA EJECUTAR LOS TOOLTIP -->
<link rel="stylesheet" href="../tooltip/jquery.tooltip.css" />
<link rel="stylesheet" href="../tooltip/demo/screen.css" />
<script src="../tooltip/lib/jquery.js" type="text/javascript"></script>
<script src="../tooltip/lib/jquery.dimensions.js" type="text/javascript"></script>
<script src="../tooltip/jquery.tooltip.js" type="text/javascript"></script>

<script type="text/javascript">
$(function() {

$("#fancy, #fancy2").tooltip({
	track: true,
	delay: 0,
	showURL: false,
	fixPNG: true,
	showBody: " - ",
	extraClass: "pretty fancy",
	top: -15,
	left: 5
});
});
</script>
<!-- FIN DE TOOLTIP -->


<script LANGUAGE="JavaScript">
function CambiaColor(esto,fondo,texto)
{
    esto.style.background=fondo;
    esto.style.color=texto;
}

function evento()
{
	document.form1.submit();
}

function enviar(url)
{
	document.form1.action=url;
}

function rep()
{
	//poput = abrirVentanaM("rep_filtro_ods.php","yes");
	document.form1.target='poput';
	document.form1.action='rep_filtro_ods.php';
	document.form1.submit();
}
function resetear(){
	document.form1.target='';
	document.form1.action='';
}

function historia()
{
	abrirVentanaM("historia.php?ods="+ods,"yes");
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
</style>

<style type = "text/css">
img { padding: 0px; margin: 0px; border: none;}
#demo_barra {
margin : 0 auto;
width:98%;
margin:1px;

}
#demo_barra .extra {
padding-left:1px;
}
#demo_barra .options {
padding-left:1px;
}
#demo_barra .getOption {
padding-left:1px;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>


</head>

<body>
<?php
function Genera_Grafico($cumple, $no_cumple)
{
	 // Standard inclusions   
	 include("pChart/pData.class");
	 include("pChart/pChart.class");
	
	 // Dataset definition 
	 $DataSet = new pData;
	 $DataSet->AddPoint(array($cumple,$no_cumple),"Serie1");
	 $DataSet->AddPoint(array("Cumple","No Cumple"),"Serie2");
	 $DataSet->AddAllSeries();
	 $DataSet->SetAbsciseLabelSerie("Serie2");
	
	 // Initialise the graph
	 $Test = new pChart(420,250);
	 $Test->drawFilledRoundedRectangle(7,7,413,243,5,240,240,240);
	 $Test->drawRoundedRectangle(5,5,415,245,5,230,230,230);
	 $Test->createColorGradientPalette(195,204,56,223,1,1,1);
	
	 // Draw the pie chart
	 $Test->setFontProperties("Fonts/tahoma.ttf",8);
	 $Test->AntialiasQuality = 0;
	 $Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),180,130,110,PIE_PERCENTAGE_LABEL,FALSE,50,20,5);
	 $Test->drawPieLegend(330,15,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);
	
	 // Write the title
	 $Test->setFontProperties("Fonts/MankSans.ttf",10);
	 $Test->drawTitle(10,20,"Porcentaje de Cumplimiento",100,100,100);
	
	 $Test->Render("Cumplimiento.png");
}
Genera_Grafico(90, 10)
?>
<form id="form1" name="form1" method="post" action="" >

<table width="1350" height="516" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="100" height="27" align="center" valign="top">
    <a href="index2.php"><img src="../imagenes/logo_mgyt_c.jpg" width="100" height="52" border="0" /></a>    </td>
    <td width="368" height="27" align="left" valign="middle"><label>
      <input name="Volver2" type="submit" class="boton_volver" id="Volver2" value="Volver" onclick="enviar('../index2.php');" />
    </label></td>
    <td colspan="2" align="center" valign="middle"><img src="../imagenes/Titulos/PROG_MAE.gif" width="500" height="45" /></td>
    <td width="323" align="center" valign="middle">&nbsp;</td>
    <td width="100" align="center" valign="top"><img src="../imagenes/logo_iso_c.jpg" width="100" height="52" /></td>
  </tr>
  <tr>
    <td width="100" height="27" align="center" valign="top">&nbsp;</td>
    <td height="27" colspan="2" align="center" valign="middle"><img src="Cumplimiento.png" width="321" height="202" /></td>
    <td width="499" align="center" valign="middle">&nbsp;</td>
    <td colspan="2" align="center" valign="top"><table width="400" height="156" border="1" bordercolor="#FF0000">
      <tr bgcolor="#FF0000">
        <td align="center" valign="middle"><table width="386" height="148" border="1" cellpadding="0" cellspacing="1" bordercolor="#FFFFFF" class="txtnormal">
          <tr>
            <td width="116" height="19" align="left" valign="middle" bgcolor="#CEDEE1">FECHA:</td>
            <td width="102" align="left" valign="middle" bgcolor="#CEDEE1">&nbsp;<?PHP echo date("d/m/Y");; ?></td>
            <td width="146" align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          <tr>
            <td height="23" align="left" valign="middle" bgcolor="#CEDEE1">CARACTERISTICA</td>
            <td align="left" valign="middle" bgcolor="#CEDEE1">CANTIDAD</td>
            <td align="left" valign="middle" bgcolor="#CEDEE1">PORCENTAJE %</td>
          </tr>
          <tr>
            <td height="23" align="left" valign="middle" bgcolor="#CEDEE1">CUMPLE</td>
            <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
            <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          <tr>
            <td height="23" align="left" valign="middle" bgcolor="#CEDEE1">NO CUMPLE</td>
            <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
            <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          <tr>
            <td height="20" align="left" valign="middle" bgcolor="#CEDEE1">&nbsp;</td>
            <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
            <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="middle" bgcolor="#CEDEE1">TOTAL ODS</td>
            <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
            <td align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
    </tr>
  
  <tr>
    <td height="403" colspan="6" align="center" valign="top">
    
      <table width="1334" height="325" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
        
        <tr>
          <td width="1387" height="280" align="center" valign="top"><table width="1347" border="1" bordercolor="#F2F2F2" bgcolor="#cedee1" class="txtnormal2" cellspacing="0" cellpadding="0">
            <tr><td colspan="13" align="center" class="txtnormaln"><table width="1345" border="1" bordercolor="#F2F2F2" bgcolor="#cedee1" class="txtnormal2" cellspacing="0" cellpadding="0">
            <tr style="background:#cedee1;" class="txtnormal8">
              <td align="center">&nbsp;VER</td>
              <td align="center">ODS</td>
              <td align="center">AREA</td>
              <td align="center">PRIORIDAD</td>
              <td align="center">ESTADO</td>
              <td align="center">ESTADO INF.</td>
              <td align="center">FECHA ING/RET</td>
              <td align="center">CANT.</td>
              <td align="center">DESCRIPCION EQUIPO</td>
              <td align="center">PLANTA </td>
              <td align="center">USUARIO</td>
              <td align="center">FECHA ENT.</td>
              <td align="center">HIST</td>
              <td align="center">% AVANCE</td>
            </tr>
            <tr class="txtnormal8" >
              <td width="3%" style="background:#cedee1;">&nbsp;</td>
              <td width="6%">
			  <?
              if($ods != "" ){$ods = $_POST['c_ods'];}
			  if($ods == "" ){$ods = "Todos";}
			  ?>
                  <select name="c_ods" id="c_ods" style="font-size:8px;" onchange="evento();" >
                    <?php
                              //*******************************************************************************************************
								$sqlods  = "SELECT DISTINCT ods FROM contratos ORDER BY ods ";
								
								$rsods 	= dbConsulta($sqlods);
								$totalO  = count($rsods);
								echo"<option selected='selected' value='$ods'>$ods</option>";
								if($ods != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}	
									
								for ($i = 0; $i < $totalO; $i++)
								{
									echo "<option value='".$rsods[$i]['ods']."'>".$rsods[$i]['ods']."</option>";	
								}							
								?>
                  </select>              </td>
              <td width="9%"><span class="Estilo5">
                <?
              if($area != "" ){$area = $_POST['c_area'];}
			  if($area == "" ){$area = "Todos";}
			  ?>
                <select name="c_area" style="font-size:8px;" onchange="evento();" >
                  <? echo"<option selected='selected' value='$area'>$area</option>";
               		if($area != "Todos"){
               			echo"<option value='Todos'>Todos</option>";
                	}
				?>
                  <option value="Cilindros">Cilindros</option>
                  <option value="Desgaste">Desgaste</option>
                  <option value="GMIN">GMIN</option>
                  <option value="Otros Maestranza">Otros Maestranza</option>
                  <option value="Paradas de ruedas">Paradas de ruedas</option>
                  <option value="Paradas Transap">Paradas Transap</option>
                  <option value="Reparacion de carros">Reparacion de carros</option>
                  <option value="Trabajos MGYT">Trabajos MGYT</option>
                  <option value="Ventiladores">Ventiladores</option>
                  <option value="Ventiladores Gmin">Ventiladores Gmin</option>
                </select>
              </span></td>
              <td width="6%"><span class="Estilo5">
                <?
              if($priori != "" ){$priori = $_POST['c_priori'];}
			  if($priori == "" ){$priori = "Todos";}
			  ?>
                </span>
                  <select name="c_priori" id="c_priori" style="font-size:8px;" onchange="evento();">
                    <? echo"<option selected='selected' value='$priori'>$priori</option>";
					if($priori != "Todos"){
               			echo"<option value='Todos'>Todos</option>";
                	}
				?>
                    <option value="Emergencia">Emergencia</option>
                    <option value="Normal">Normal</option>
                    <option value="Urgencia">Urgencia</option>
                    <option value="Garantia">Garantia</option>
                </select></td>
              <td width="9%"><?
              		if($estado != "" ){$estado = $_POST['c_estado'];}
					if($estado == "" ){$estado = "Todos";}
			  	?>
                  <select name="c_estado" style="font-size:8px;" onchange="evento();" >
                    <? echo"<option selected='selected' value='$estado'>$estado</option>"; 
			  		if($estado != "Todos"){
               			echo"<option value='Todos'>Todos</option>";
                	}
			  ?>
                    <option value="Aprobada">Aprobada</option>
                    <option value="En Proceso Reparacion">En Proceso Reparacion</option>
                    <option value="Falta Aprobacion">Falta Aprobacion</option>
                    <option value="Falta Informacion">Falta Informacion</option>
                    <option value="Falta Repuestos">Falta Repuestos</option>
                    <option value="Nula">Nula </option>
                    <option value="Pendiente x Usuario">Pendiente x Usuario</option>
                    <option value="Terminado sin entregar">Terminado sin entregar</option>
                    <option value="Terminado sin facturar">Terminado sin facturar</option>
                    <option value="Terminado">Terminado</option>
                </select></td>
              <td width="7%"><span class="Estilo5">
                <?
              		if($est_inf != "" ){$est_inf = $_POST['c_est_inf'];}
					if($est_inf == "" ){$est_inf = "Todos";}
			  	?>
                <select name="c_est_inf" id="c_est_inf" style="font-size:8px;" onchange="evento();">
                  <? echo"<option selected='selected' value='$est_inf'>$est_inf</option>";
				  	if($est_inf != "Todos"){
               			echo"<option value='Todos'>Todos</option>";
                	}
				  ?>
                  <option value="Pendiente">Pendiente</option>
                  <option value="Ok">Ok</option>
                  <option value="Falta Numeracion">Falta Numeracion</option>
                  <option value="No Aplica">No Aplica</option>
                </select>
              </span></td>
              <td width="3%"><?
              if($fe_in_ret != "" ){$fe_in_ret = $_POST['c_fe_in_ret'];}
			  if($fe_in_ret == "" ){$fe_in_ret = "Todos";}
			  ?>
                  <select name="c_fe_in_ret" id="c_fe_in_ret"  style="font-size:8px;" onchange="evento();" >
                    <?php
//*******************************************************************************************************
								$sqlods = "SELECT DISTINCT fe_in_ret FROM contratos ORDER BY fe_in_ret ";
								
								$rsf	= dbConsulta($sqlods);
								$totalf = count($rsf);
								echo"<option selected='selected' value='$fe_in_ret'>$fe_in_ret</option>";
								if($fe_in_ret != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}
										
								for ($i = 0; $i < $totalf; $i++)
								{
									$fe_in_ret = $rsf[$i]['fe_in_ret'];
									
									$fe_in_ret		=	cambiarFecha($fe_in_ret, '-', '/' );
									echo "<option value='$fe_in_ret'>$fe_in_ret</option>";	
								}
							?>
                  </select>              </td>
              <td width="3%"><?
              if($cant != "" ){$cant = $_POST['c_cant'];}
			  if($cant == "" ){$cant = "Todos";}
			  ?>
                  <select name="c_cant" id="c_cant" style="font-size:8px;" onchange="evento();" >
                    <?php
//*******************************************************************************************************
								$sql_c = "SELECT DISTINCT cant FROM contratos ORDER BY cant ";
								
								$rowsc= dbConsulta($sql_c);
								$total_c = count($rowsc);
								echo"<option selected='selected' value='$cant'>$cant</option>";
								if($cant != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}
										
								for ($i = 0; $i < $total_c; $i++)
								{
									$cant = $rowsc[$i]['cant'];
									echo "<option value='$cant'>$cant</option>";	
								}
							?>
                </select></td>
              <td width="22%"><?
              if($desc_eq_scont != "" ){$desc_eq_scont = $_POST['c_desc_eq_scont'];}
			  if($desc_eq_scont == "" ){$desc_eq_scont = "Todos";}
			  ?>
                  <select name="c_desc_eq_scont" style="font-size:8px;" onchange="evento();" >
                    <?php
/*******************************************************************************************************************************************   
						PREGUNTAMOS SI EL SELECT ENVIO UN VALOR NUMERICO(CODIGO DE EQUIPO)
********************************************************************************************************************************************/                           
								if(is_numeric($_POST['c_desc_eq_scont']))
								{
									$sql3 = "SELECT * FROM equipos WHERE cod_eq = '".$_POST['c_desc_eq_scont']."' ";
									$resp3 	= dbExecute($sql3);
									while ($vrows3 = mysql_fetch_array($resp3)) 
									{
										$desc_eq_scont 	= "".$vrows3['nom_eq']."";
										$cod_d_s_c 		= "".$vrows3['cod_eq']."";
									}
								}
									$sqle    = "SELECT nom_eq, cod_eq FROM equipos ORDER BY nom_eq ";
									
									$rse 	 = dbConsulta($sqle);
									$totale  = count($rse);
									
									echo"<option selected='selected' value='$cod_d_s_c'>$desc_eq_scont</option>";
										if($desc_eq_scont != "Todos"){
               								echo"<option value='Todos'>Todos</option>";
                						}
												
									for ($i = 0; $i < $totale; $i++)
									{
										$nom_e = $rse[$i]['nom_eq'];
										if($desc_eq_scont != $nom_e){
											echo "<option value='".$rse[$i]['cod_eq']."'>".$rse[$i]['nom_eq']."</option>";
										}
									}
								
							?>
                  </select>              </td>
              <?
/*******************************************************************************************************************************************   
						PREGUNTAMOS SI EL SELECT ENVIO UN VALOR NUMERICO(CODIGO DE EQUIPO)
********************************************************************************************************************************************/ 
              
			  if($planta != ""){$planta = $_POST['c_plantas'];}
			  if($planta == ""){$planta = "Todos";}
			  ?>
              <td width="9%"><select name="c_plantas" id="c_plantas" style="font-size:8px;" onchange="evento();">
                  <?php
			  		$co=mysql_connect("$DNS","$USR","$PASS");
					mysql_select_db("$BDATOS", $co);
				
					$sql_p	= "SELECT * FROM plantas WHERE cod_p = '".$_POST['c_plantas']."' ";
					$resp	= mysql_query($sql_p,$co);
					while($filap=mysql_fetch_array($resp))
					{
						$planta		= "".$filap['nom_p']."";
						$cod_pl		= "".$filap['cod_p']."";
					}
                           
								$sql  = "SELECT cod_p, nom_p FROM plantas ORDER BY nom_p ";
								
								$rsp 	= dbConsulta($sql);
								$total  = count($rsp);
								
								echo"<option selected='selected' value='$cod_pl'>$planta</option>";
								if($planta != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}
										
								for ($i = 0; $i < $total; $i++)
								{
									echo "<option value='".$rsp[$i]['cod_p']."'>".$rsp[$i]['nom_p']."</option>";
								}
							?>
              </select></td>
              <td width="8%"align="center" ><?
              if($usuario != "" ){$usuario = $_POST['c_usuario_e'];}
			  if($usuario == ""){$usuario = "Todos";}
			  ?>
                  <select name="c_usuario_e" id="c_usuario_e"  style="font-size:8px;" onchange="evento();">
                    <?php
								$co=mysql_connect("$DNS","$USR","$PASS");
								mysql_select_db("$BDATOS", $co);
					
                              	$sql_u	= "SELECT * FROM usuario_e WHERE cod_ue='$usuario' ";
								$res	= mysql_query($sql_u,$co);
								while($vrows=mysql_fetch_array($res))
								{
									$usuario	= "".$vrows['nom_ue']."";
									$cod_usu	= "".$vrows['cod_ue']."";
								}
								$sqlu    = "SELECT cod_ue, nom_ue FROM usuario_e ORDER BY nom_ue ";
	
								$rsu 	 = dbConsulta($sqlu);
								$totalu  = count($rsu);
								echo"<option selected='selected' value='$cod_usu'>$usuario</option>";
								if($usuario != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}
										
								for ($i = 0; $i < $totalu; $i++)
								{
									echo "<option value='".$rsu[$i]['cod_ue']."'>".$rsu[$i]['nom_ue']."</option>";
								}
							?>
                  </select>              </td>
              <td width="6%"align="center" ><?
              if($fe_ent_aprox != "" ){$fe_ent_aprox = $_POST['c_fe_ent_aprox'];}
			  if($fe_ent_aprox == "" ){$fe_ent_aprox = "Todos";}
			  ?>
                  <select name="c_fe_ent_aprox" id="c_fe_ent_aprox"  style="font-size:8px;" onchange="evento();" >
                    <?php
//*******************************************************************************************************
								$sqlods = "SELECT DISTINCT fe_ent_aprox FROM contratos ORDER BY fe_ent_aprox ";
								
								$rsf	= dbConsulta($sqlods);
								$totalf = count($rsf);
								echo"<option selected='selected' value='$fe_ent_aprox'>$fe_ent_aprox</option>";
								if($fe_ent_aprox != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}
										
								for ($i = 0; $i < $totalf; $i++)
								{
									$fe_ent_aprox = $rsf[$i]['fe_ent_aprox'];
									
									$fe_ent_aprox		=	cambiarFecha($fe_ent_aprox, '-', '/' );
									echo "<option value='$fe_ent_aprox'>$fe_ent_aprox</option>";	
								}
							?>
                </select></td>
              <td width="1%"align="center" >&nbsp;</td>
              <td width="8%"align="center" >&nbsp;</td>
            </tr>
            <tr>
              <td colspan="14" align="center" class="txtnormal5">&nbsp;</td>
            </tr>
            <?php
/***********************************************************************************************************************
				FILTRAMOS
***********************************************************************************************************************/	
if($_POST['c_ods'] != "Todos" and $_POST['c_ods'] != "")
{
	$query = "and ods = '".$_POST['c_ods']."'";
}
if($_POST['c_area'] != "Todos" and $_POST['c_area'] != "")
{
	$query1 = "and area = '".$_POST['c_area']."'";
}	
if($_POST['c_priori'] != "Todos" and $_POST['c_priori'] != "")
{
	$query2 = "and priori = '".$_POST['c_priori']."'";
}
if($_POST['c_estado'] != "Todos" and $_POST['c_estado'] != "")
{
	$query3 = "and estado = '".$_POST['c_estado']."'";
}
if($_POST['c_est_inf'] != "Todos" and $_POST['c_est_inf'] != "")
{
	$query4 = "and est_inf = '".$_POST['c_est_inf']."'";
}
if($_POST['c_fe_in_ret'] != "Todos" and $_POST['c_fe_in_ret'] != "")
{
	$_POST['c_fe_in_ret']	=	cambiarFecha($_POST['c_fe_in_ret'], '/', '-' );
	$query5 = "and fe_in_ret = '".$_POST['c_fe_in_ret']."'";
}

if($_POST['c_cant'] != "Todos" and $_POST['c_cant'] != "")
{
	$query_cant = "and cant = '".$_POST['c_cant']."'";
}

if($_POST['c_desc_eq_scont'] != "Todos" and $_POST['c_desc_eq_scont'] != "")
{
	$query6 = "and desc_eq_scont = '".$_POST['c_desc_eq_scont']."'";
}
if($_POST['c_plantas'] != "Todos" and $_POST['c_plantas'] != "")
{
	$query7 = "and planta = '".$_POST['c_plantas']."'";
}
if($_POST['c_usuario_e'] != "Todos" and $_POST['c_usuario_e'] != "")
{
	$query8 = "and usuario = '".$_POST['c_usuario_e']."'";
}
if($_POST['c_fe_ent_aprox'] != "Todos" and $_POST['c_fe_ent_aprox'] != "")
{
	$_POST['c_fe_ent_aprox']	=	cambiarFecha($_POST['c_fe_ent_aprox'], '/', '-' );
	$query9 = "and fe_ent_aprox = '".$_POST['c_fe_ent_aprox']."'";
}

/***********************************************************************************************************************
MOSTRAMOS LOS ITEM DE LA OTI QUE ESTAMOS MOSTRANDO
***********************************************************************************************************************/	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sql = "SELECT * FROM contratos WHERE estado != 'Nula' and estado != 'Terminado' $query $query1 $query2 $query3 $query4 $query5 $query_cant $query6 $query7 $query8 $query9 ORDER BY aux_c ASC";
	$respuesta=mysql_query($sql,$co);
	$color = "#ffffff";
	$i=1;
	$filaexcel = 8;
	while($vrows=mysql_fetch_array($respuesta))
	{
		$ods			= "".$vrows['ods']."";
		$id_ods			= "".$vrows['id_ods']."";
		$aux_c			= "".$vrows['aux_c']."";
		$area			= "".$vrows['area']."";
		$priori			= "".$vrows['priori']."";
		$estado			= "".$vrows['estado']."";
		$est_inf		= "".$vrows['est_inf']."";
		$fe_in_ret		= "".$vrows['fe_in_ret']."";
		$fe_ent_aprox	= "".$vrows['fe_ent_aprox']."";
		$planta			= "".$vrows['planta']."";
		$usuario		= "".$vrows['usuario']."";
		$cant			= "".$vrows['cant']."";
		$guia_desp_det	= "".$vrows['guia_desp_det']."";
		$desc_eq_scont	= "".$vrows['desc_eq_scont']."";
		$desc_eq_sguia	= "".$vrows['desc_eq_sguia']."";
		$desc_falla		= "".$vrows['desc_falla']."";
		$observ			= "".$vrows['observ']."";
		$fe_aprov		= "".$vrows['fe_aprov']."";
		$ent_par1		= "".$vrows['ent_par1']."";
		$ent_par2		= "".$vrows['ent_par2']."";
		$ent_par3		= "".$vrows['ent_par3']."";
		$ent_par4		= "".$vrows['ent_par4']."";
		$ent_par5		= "".$vrows['ent_par5']."";
		$ent1_guia		= "".$vrows['ent1_guia']."";
		$ent2_guia		= "".$vrows['ent2_guia']."";
		$ent3_guia		= "".$vrows['ent3_guia']."";
		$ent4_guia		= "".$vrows['ent4_guia']."";
		$ent5_guia		= "".$vrows['ent5_guia']."";
		$porc_avance	= "".$vrows['porc_avance']."";
		
		$fe_cierre_ods_fact	= "".$vrows['fe_cierre_ods_fact']."";
		$precio			= "".$vrows['precio']."";
		
		
		$fe_in_ret				=	cambiarFecha($fe_in_ret, '-', '/' );
		$fe_ent_aprox			=	cambiarFecha($fe_ent_aprox, '-', '/' );
		$fe_aprov				=	cambiarFecha($fe_aprov, '-', '/' );
		$fe_cierre_ods_fact		=	cambiarFecha($fe_cierre_ods_fact, '-', '/' );
		$ent_par1				=	cambiarFecha($ent_par1, '-', '/' );
		$ent_par2				=	cambiarFecha($ent_par2, '-', '/' );
		$ent_par3				=	cambiarFecha($ent_par3, '-', '/' );
		$ent_par4				=	cambiarFecha($ent_par4, '-', '/' );
		$ent_par5				=	cambiarFecha($ent_par5, '-', '/' );
		
		$sql3 = "SELECT * FROM equipos WHERE cod_eq = '$desc_eq_scont' ";
		$resp3 	= dbExecute($sql3);
		while ($vrows3 = mysql_fetch_array($resp3)) 
		{
    		$desc_eq_scont = "".$vrows3['nom_eq']."";
		}
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS", $co);
		
		$sql_u	= "SELECT * FROM usuario_e WHERE cod_ue='$usuario' ";
		$res	= mysql_query($sql_u,$co);
		while($vrows=mysql_fetch_array($res))
		{
			$usuario	= "".$vrows['nom_ue']."";
		}
			
		$sql_p="SELECT * FROM plantas WHERE cod_p='$planta' ";
		$res=mysql_query($sql_p,$co);
		while($fila=mysql_fetch_array($res))
		{
			$planta		= "".$fila['nom_p']."";
		}
		if($estado 			== "En Proceso Reparacion"){$estado = "En Proceso Repar...";}
		if($estado 			== "Terminado sin entregar"){$estado = "Terminado sin ent.";}
		if($est_inf 		== "Falta Numeracion"){$est_inf = "Falta Numerac.";}
		if($fe_ent_aprox 	== "00/00/0000"){$fe_ent_aprox = "";}
		if($fe_in_ret 		== "00/00/0000"){$fe_in_ret = "";}
									
									/*<td bgcolor='#ffc561'>&nbsp;<a href='#' onClick=\"abrirVentanaVariable('contratos.php?cod=$ods', 'ventana', 'ODS aprobadas')\"><img src='imagenes/edit.png' border='0' valign='top' alt='Modificar'/>&nbsp;</td>*/
		echo"<tr bgcolor=$color class='txtnormal8' onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000')>							
									<td bgcolor='#ffc561'>&nbsp;<a href=\"contratos.php?cod=$ods\"><img src='imagenes/edit.png' border='0' valign='top' alt='Modificar'/>&nbsp;</a></td>
									<td bgcolor='#cedee1'><input name='campos[$id_ods]' type='hidden' />$ods</td>
									<td>&nbsp;$area</td>
									<td>&nbsp;$priori	</td>	
									<td>&nbsp;$estado</td>
									<td>&nbsp;$est_inf</td>	
									<td>&nbsp;$fe_in_ret</td>
									<td>&nbsp;$cant</td>	
									<td>&nbsp;$desc_eq_scont</td>	
									<td>&nbsp;$planta</td>	
									<td>&nbsp;$usuario</td>
									<td>&nbsp;$fe_ent_aprox</td>
									<td>&nbsp;<span id='fancy2' title='Muestra el historial de la ODS'><a href=\"historia.php?ods=$ods\" target='_blank'><img alt='Historial de la ODS' src='imagenes/Botones/historia.png'/>&nbsp;</a></td></span>
									
									<td>
									<div style='width:154px;margin: 0 auto; text-align:left;>
									<div id='demo_barra'>";
									echo "<script>display ('element1',$porc_avance,1);</script>"; 
									echo"</div></div>
									</td>

		</tr> ";
									
									if($ent_par1 == "00/00/0000"){$ent_par1 = "";}
									if($ent_par2 == "00/00/0000"){$ent_par2 = "";}
									if($ent_par3 == "00/00/0000"){$ent_par3 = "";}
									if($ent_par4 == "00/00/0000"){$ent_par4 = "";}
									if($ent_par5 == "00/00/0000"){$ent_par5 = "";}
									if($fe_cierre_ods_fact == "00/00/0000"){$fe_cierre_ods_fact = "";}
									if($fe_ent_aprox == "00/00/0000"){$fe_ent_aprox = "";}
									if($fe_in_ret == "00/00/0000"){$fe_in_ret = "";}
									
									$worksheet->write($filaexcel,0,$ods,$formato);
                                    $worksheet->write($filaexcel,1,$area,$formato);
                                    $worksheet->write($filaexcel,2,$fe_in_ret,$formato);
                                    $worksheet->write($filaexcel,3,$estado,$formato);
                                    $worksheet->write($filaexcel,4,$cant,$formato);
									$worksheet->write($filaexcel,5,$guia_desp_det,$formato);
                                    $worksheet->write($filaexcel,6,utf8_decode($desc_eq_scont),$formato);
									$worksheet->write($filaexcel,7,utf8_decode($desc_eq_sguia),$formato);
									$worksheet->write($filaexcel,8,utf8_decode($observ),$formato);
									$worksheet->write($filaexcel,9,$fe_aprov,$formato);
									$worksheet->write($filaexcel,10,$ent_par1,$formato);
									$worksheet->write($filaexcel,11,$ent1_guia,$formato);
									$worksheet->write($filaexcel,12,$ent_par2,$formato);
									$worksheet->write($filaexcel,13,$ent2_guia,$formato);
									$worksheet->write($filaexcel,14,$ent_par5,$formato);
									$worksheet->write($filaexcel,15,$ent3_guia,$formato);
									$worksheet->write($filaexcel,16,$ent_par3,$formato);
									$worksheet->write($filaexcel,17,$ent4_guia,$formato);
									$worksheet->write($filaexcel,18,$ent_par5,$formato);
									$worksheet->write($filaexcel,19,$ent5_guia,$formato);
									$worksheet->write($filaexcel,20,$fe_cierre_ods_fact,$formato);
                                    $worksheet->write($filaexcel,21,utf8_decode($planta),$formato);
                                    $worksheet->write($filaexcel,22,utf8_decode($usuario),$formato);
									$worksheet->write($filaexcel,23,$precio,$formato);
									$worksheet->write($filaexcel,24,$porc_avance." "."%",$formato);
									
									if($color == "#ffffff"){ $color = "#ddeeee"; }
									else{ $color = "#ffffff"; }
		$i++;
		$filaexcel++;				
	}
	$workbook->close();				
?>
            <tr>
              <td colspan="14" align="center" class="txtnormaln">
              <label>Exportar a:</label></td>
            </tr>
            <tr>
              <td colspan="14" align="center" class="txtnormaln"><a href='bajar_excel.php?filename=<? echo $fname ?>'><img src="imagenes/botones/rep_excel.jpg" border="0" /></a>
                <input name="button" type="button" class="boton_pdf" id="button" onclick="rep();resetear()" value="Pdf" />
                <input name="Volver" type="submit" class="boton_volver" id="Volver" value="Volver" onclick="enviar('index2.php');" /></td>
            </tr>
          </table>            
          <label><a href='bajar_excel.php?filename=<? echo $fname ?>'></a></label></td>
            </tr>
          </table>          </td>
        </tr>
      </table>         </td>
  </tr>
  <tr>
    <td height="5" colspan="6" align="center" valign="top"><img src="imagenes/barra.gif" alt="" width="99%" height="3" /></td>
  </tr>
</table>
</form> 
</body>
</html>
