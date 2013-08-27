<?php 	
	$SERVER		= "192.168.2.7";
	$USR		= "sa";
	$PASS		= "SuperMoto";
	$BDATOS		= "MGYT3";
	
	include('../inc/lib.db.php');
	
	$cod_cc 		= "Todos";
	$area	 		= "Todos";
	$desc_cc	 	= "Todos";
	$estado	 	    = "Todos";
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
	$worksheet->write(2,2,"CENTROS DE COSTO",$for_titulo);
	$worksheet->write(3,5,"",$for_titulo);
	$worksheet2->write(3,4,"HOJA 2",$for_titulo);
	$worksheet3->write(3,4,"HOJA 3",$for_titulo);
	
	// ENCABEZADOS
	
	$worksheet->write(7,0,utf8_decode("Nº"),$encabezado);
	$worksheet->write(7,1,"CODIGO",$encabezado);
	$worksheet->write(7,2,"DESCRIPCION",$encabezado);
	$worksheet->write(7,3,"NIVEL",$encabezado);

	$worksheet->insert_bitmap('A1', '../imagenes/logo.bmp', 1, 1);	
/**************************************************************************
	FIN REPORTE EXCEL
**************************************************************************/	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Centros de costo</title>

<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">
<link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxgrid.css"><!-- llama hoja de estilo -->
<script type="text/javascript" language="JavaScript" src="inc/funciones.js"></script>

<script LANGUAGE="JavaScript">
function CambiaColor(esto,fondo,texto)
{
    esto.style.background=fondo;
    esto.style.color=texto;
	esto.style.cursor='hand'
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
	document.form1.action='../rep_filtro_cc.php';
	document.form1.submit();
}
function resetear(){
	document.form1.target='';
	document.form1.action='';
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
<form id="form1" name="form1" method="post" action="" >
<table width="1000" height="385" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="100" height="54" align="center" valign="top">
    <a href="index2.php"><img src="../imagenes/logo_mgyt_c.jpg" width="100" height="52" border="0" /></a>    </td>
    <td width="800" height="54" align="center" valign="middle" class="txt01"><label></label>LISTADO CENTROS DE COSTO</td>
    <td width="100" align="center" valign="top"><img src="../imagenes/logo_iso_c.jpg" width="100" height="52" /></td>
  </tr>
  
  <tr>
    <td height="325" colspan="3" align="center" valign="top">
    
      <table width="996" height="325" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
        
        <tr>
          <td width="829" height="280" align="center" valign="top"><table width="992" border="1" bordercolor="#F2F2F2" bgcolor="#cedee1" class="txtnormal2" cellspacing="0" cellpadding="0">
            <tr><td width="850" colspan="13" align="center" class="txtnormaln"><table width="990" border="0" bordercolor="#FFFFFF" bgcolor="#cedee1" class="txtnormal" cellspacing="1" cellpadding="1">
            <tr style="background:#cedee1;" class="txtnormal8">
              <td align="center">&nbsp;Nº</td>
              <td align="center">CODIGO</td>
              <td align="left">DESCRIPCION</td>
              <td align="left">ESTADO</td>
              <td align="left">AREA/TIPO</td>
              </tr>
            <tr class="txtnormal8" >
              <td width="3%" rowspan="2" style="background:#cedee1;">&nbsp;</td>
              <td width="11%">
			  
			  <?
			  	$co=mssql_connect("$SERVER","$USR","$PASS");
				mssql_select_db("$BDATOS", $co);
	
              if($cod_cc != "" ){$cod_cc = $_POST['c_cod_cc'];}
			  if($cod_cc == "" ){$cod_cc = "Todos";}
			  ?>
                <select name="c_cod_cc" id="c_cod_cc" style="font-size:10px;" onchange="evento();" >
                  <?php
                              //*******************************************************************************************************
								$sql_sol  = "SELECT cwtccos.CodiCC FROM softland.cwtccos ORDER BY cwtccos.CodiCC ";
								
								$respuesta = mssql_query($sql_sol,$co);
								
								while ($rows = mssql_fetch_assoc($respuesta)) 
								{
	            					$rs_cod[] = $rows;
								}
								$total_sol  = count($rs_cod);
								
								echo"<option selected='selected' value='$cod_cc'>$cod_cc</option>";
								
								if($cod_cc != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}	
									
								for ($i = 0; $i < $total_sol; $i++)
								{
									echo "<option value='".$rs_cod[$i]['CodiCC']."'>".$rs_cod[$i]['CodiCC']."</option>";	
								}							
								?>
                </select></td>
              <td width="48%" align="left">
			  
			  <?
			  	$co=mssql_connect("$SERVER","$USR","$PASS");
				mssql_select_db("$BDATOS", $co);
	
              if($desc_cc != "" ){$desc_cc = $_POST['c_desc_cc'];}
			  if($desc_cc == "" ){$desc_cc = "Todos";}
			  ?>
                <select name="c_desc_cc" id="c_desc_cc" style="font-size:10px;" onchange="evento();" >
                  <?php
                              //*******************************************************************************************************
								$sql_desc_cc  = "SELECT cwtccos.DescCC FROM softland.cwtccos ORDER BY cwtccos.DescCC ";
								
								$resp_desc_cc = mssql_query($sql_desc_cc,$co);
								
								while ($rows = mssql_fetch_assoc($resp_desc_cc)) 
								{
	            					$rs_desc_cc[] = $rows;
								}
								$total_desc_cc  = count($rs_desc_cc);
								
								echo"<option selected='selected' value='$desc_cc'>$desc_cc</option>";
								
								if($desc_cc != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}	
									
								for ($i = 0; $i < $total_desc_cc; $i++)
								{
									echo "<option value='".htmlentities($rs_desc_cc[$i]['DescCC'])."'>".htmlentities($rs_desc_cc[$i]['DescCC'])."</option>";	
								}							
								?>
                </select></td>
              <td width="12%" align="left"><span class="Estilo5">
                <?
              if($estado != "" ){$estado = $_POST['c_estado'];}
			  if($estado == "" ){$estado = "Todos";}
			  ?>
                <select name="c_estado" style="font-size:10px;" onchange="evento();" >
                  <? echo"<option selected='selected' value='$estado'>$estado</option>";
               		if($estado != "Todos"){
               			echo"<option value='Todos'>Todos</option>";
                	}
				  ?>
                  <option value="Activo">Activo</option>
                  <option value="Cerrado">Cerrado</option>
                </select>
              </span></td>
              <td width="26%" align="left"><span class="Estilo5">
                <?
              if($area != "" ){$area = $_POST['c_area'];}
			  if($area == "" ){$area = "Todos";}
			  ?>
                <select name="c_area" style="font-size:10px;" onchange="evento();" >
                  <? echo"<option selected='selected' value='$area'>$area</option>";
               		if($area != "Todos"){
               			echo"<option value='Todos'>Todos</option>";
                	}
				  ?>
                  <option value="Estructura">Estructuras</option>
                  <option value="Mant. Electrica">Mant. Electrica</option>
                  <option value="Mant. Mecanica">Mant. Mecanica</option>
                  <option value="Mecanizado">Mecanizado</option>
                  <option value="Sellos">Sellos</option>
                  <option value="Transporte">Transportes</option>
                  <option value="Administracion">Administracion</option>
                  <option value="Apoyo">Apoyo</option>
                  <option value="Trabajos externos">Trabajos externos</option>
                  <option value="CERRADO">CC Cerrados</option>
                  <option value="General">General</option>
                </select>
              </span></td>
              <?
/*******************************************************************************************************************************************   
						PREGUNTAMOS SI EL SELECT ENVIO UN VALOR NUMERICO(CODIGO DE EQUIPO)
********************************************************************************************************************************************/ 
              
			  if($planta != ""){$planta = $_POST['c_plantas'];}
			  if($planta == ""){$planta = "Todos";}
			  ?>
              </tr>
            <tr class="txtnormal8" >
              <td width="11%">&nbsp;</td>
              <td width="48%" align="left">&nbsp;</td>
              <td width="12%">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            
            <?php
/***********************************************************************************************************************
				FILTRAMOS
***********************************************************************************************************************/	
if($_POST['c_cod_cc'] != "Todos" and $_POST['c_cod_cc'] != "")
{
	$query = "and cwtccos.CodiCC = '".$_POST['c_cod_cc']."'";
}

if($_POST['c_desc_cc'] != "Todos" and $_POST['c_desc_cc'] != "")
{
	$query1 = "and cwtccos.DescCC = '".$_POST['c_desc_cc']."'";
}

if($_POST['c_estado'] != "Todos" and $_POST['c_estado'] != "")
{
	if($_POST['c_estado'] == "Cerrado"){$query2 = "and cwtccos.DescCC LIKE '%CERRADO%' ";}
	if($_POST['c_estado'] == "Activo"){$query2 = "and cwtccos.DescCC NOT LIKE '%CERRADO%' ";}
}

if($_POST['c_area'] != "Todos" and $_POST['c_area'] != "")
{
	if($_POST['c_area'] == ""){}
	$query3 = "and cwtccos.DescCC LIKE '%".$_POST['c_area']."%' ";
}
/***********************************************************************************************************************

***********************************************************************************************************************/	
	$co=mssql_connect("$SERVER","$USR","$PASS");
	mssql_select_db("$BDATOS", $co);
	
	$sql = "SELECT * FROM softland.cwtccos WHERE cwtccos.DescCC != '' $query $query1 $query2 $query3 ";
	
	$respuesta = mssql_query($sql,$co);

	$color = "#ffffff";
	$i=1;
	$filaexcel = 8;
	while($vrows=mssql_fetch_assoc($respuesta))
	{
		$CodiCC		= "".$vrows['CodiCC']."";
		$DescCC		= "".utf8_encode($vrows['DescCC'])."";
		$NivelCC	= "".$vrows['NivelCC']."";

		$texto = explode("-",$DescCC);
		$cc    = explode("-",$CodiCC);
		
		$texto[0] = trim($texto[0]);
		$texto[1] = trim($texto[1]);
		$texto[2] = trim($texto[2]);
		
		$cc[0] = trim($cc[0]);
		
		if($texto[0] 	== "CERRADO"){$area_ccosto = $texto[1]; }else{$area_ccosto = $texto[0]; }
		if($area_ccosto == "CERRADO"){}
		if($texto[0] 	== "CERRADO"){$est_ccosto = "Cerrado"; }else{$est_ccosto = "Activo"; }
		
		$largo_area  = strlen($area_ccosto);
		$largo_area2 = strlen($DescCC);
		
		if($NivelCC == 1 or $NivelCC == 2 or $cc[0] == "01" or $largo_area > 20){$area_ccosto = "General Imputable"; }
		if($cc[2] == "00"){$area_ccosto = "No Imputable"; }
		
		if($NivelCC == 1 or $NivelCC == 2){ $color = "#527eab"; }
		
		echo "<input name='campos[$CodiCC]' type='hidden'/>";
		echo"<tr bgcolor=$color class='txtnormal' onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000')>
									
				<td bgcolor='#cedee1'>&nbsp;$NivelCC</td>
				<td>&nbsp;$CodiCC</td>
				<td align='left'>&nbsp;$DescCC</td>
				<td align='left'>&nbsp;$est_ccosto</td>
				<td align='left'>&nbsp;$area_ccosto</td>
				
			 </tr>";
				$worksheet->write($filaexcel,0,$i,$formato);
                $worksheet->write($filaexcel,1,$CodiCC,$formato);
                $worksheet->write($filaexcel,2,utf8_encode($DescCC),$formato);
                $worksheet->write($filaexcel,3,$NivelCC,$formato);
									
				if($color == "#ffffff"){ $color = "#ddeeee"; }
				else{ $color = "#ffffff"; }
		$i++;
		$filaexcel++;				
	}
	$workbook->close();				
?>
            <tr>
              <td colspan="5" align="center" class="txtnormaln">
              <label>Exportar a:</label></td>
            </tr>
            <tr>
              <td colspan="5" align="center" class="txtnormaln"><a href='bajar_excel.php?filename=<? echo $fname ?>'><img src="../imagenes/botones/rep_excel.jpg" border="0" /></a>
                <input name="button" type="button" class="boton_pdf" id="button" onclick="rep();resetear()" value="Pdf" /></td>
            </tr>
          </table>            
          <label><a href='../bajar_excel.php?filename=<? echo $fname ?>'></a></label></td>
            </tr>
          </table>          </td>
        </tr>
      </table>         </td>
  </tr>
  <tr>
    <td height="5" colspan="3" align="center" valign="top"><img src="../imagenes/barra.gif" alt="" width="99%" height="3" /></td>
  </tr>
</table>
</form> 
</body>
</html>
