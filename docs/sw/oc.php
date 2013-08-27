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
<title>Ordenes de compra</title>

<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">
<link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxgrid.css"><!-- llama hoja de estilo -->
<script type="text/javascript" language="JavaScript" src="../inc/funciones.js"></script>

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
function RepOC()
{
	abrirVentanaM("rep_oc.php","yes");
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
              <td align="center">&nbsp;</td>
              <td align="center">&nbsp;</td>
              <td align="left">&nbsp;</td>
              <td align="left">&nbsp;</td>
              <td width="35%" align="right"><input name="button4" type="button" class="boton_print" id="button2" value="Vista impresion" onclick="RepOC()" /></td>
              </tr>
            <tr class="txtnormal8" >
              <td width="3%" style="background:#cedee1;">&nbsp;Nº</td>
              <td width="7%">CODIGO</td>
              <td width="7%" align="left">FECHA</td>
              <td width="48%">DESCRIPCION</td>
              <td>AREA/TIPO</td>
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
	
	$sql = "SELECT * FROM softland.OW_vsnpTraeEncabezadoOCompra WHERE OW_vsnpTraeEncabezadoOCompra.NumOC = '32310' ORDER BY OW_vsnpTraeEncabezadoOCompra.NumOC";

	$respuesta = mssql_query($sql,$co);

	$color = "#ffffff";
	$i=1;
	$filaexcel = 8;
	while($vrows=mssql_fetch_assoc($respuesta))
	{
		$NumOC		= "".$vrows['NumOC']."";
		$FechaOC	= "".$vrows['FechaOC']."";
		$NomAux		= "".utf8_encode($vrows['NomAux'])."";
		
		$cc[0] = trim($cc[0]);
		
		echo "<input name='campos[$CodiCC]' type='hidden'/>";
		echo"<tr bgcolor=$color class='txtnormal' onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000')>
									
				<td bgcolor='#cedee1'>&nbsp;</td>
				<td>&nbsp;$NumOC</td>
				<td align='left'>&nbsp;$FechaOC</td>
				<td align='left'>&nbsp;$NomAux</td>
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
