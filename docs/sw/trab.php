<?php
//********************************************************************************************************************************
	$SERVER		= "localhost";
	$USR		= "sa";
	$PASS		= "SuperMoto";
	$BDATOS		= "MGYT3";

	include('../inc/lib.db.php');
	
	$area 			= "Todos";
	$cod_sol 		= "Todos";
	$ods	 		= "Todos";
	$det 			= "Todos";
	$und_m	 		= "Todos";
	$cant_d 		= "Todos";
	$f_sol	 		= "Todos";
	$p_sol 			= "Todos";
	$est 			= "Todos";
	
	$usuario		= "Todos";
/**************************************************************************
	COMIENZA REPORTE EXCEL
**************************************************************************/	
	require_once("../excelclass/class.writeexcel_workbookbig.inc.php");
	require_once("../excelclass/class.writeexcel_worksheet.inc.php");
	require_once("../excelclass/functions.writeexcel_utility.inc.php");
	
	$fname = "tmp/sw_reporte.xls";
	
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
	
	$worksheet->write(7,0,"FICHA",$encabezado);
	$worksheet->write(7,1,"RUT",$encabezado);
	$worksheet->write(7,2,"NOMBRE",$encabezado);
	$worksheet->write(7,3,"FECHA NAC",$encabezado);
	$worksheet->write(7,4,"FECHA ING",$encabezado);
	$worksheet->write(7,5,"FECHA TERM CONT",$encabezado);
	$worksheet->write(7,6,"FECHA SOL",$encabezado);
	$worksheet->write(7,7,"FECHA APROB",$encabezado);
	$worksheet->write(7,8,"RECEPCION",$encabezado);
	$worksheet->write(7,9,"CANT RECEP",$encabezado);
	$worksheet->write(7,10,"SOLICITANTE",$encabezado);
	$worksheet->insert_bitmap('A1', '../imagenes/logo.bmp', 1, 1);	
/**************************************************************************
**************************************************************************/	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Trabajadores</title>
<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">
<link rel="STYLESHEET" type="../text/css" href="codebase/dhtmlxgrid.css"><!-- llama hoja de estilo -->
<script type="text/javascript" language="JavaScript" src="inc/funciones.js"></script>

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
<table width="1175" height="286" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="100" height="54" align="center" valign="top"><a href="../index2.php"><img src="../imagenes/logo_mgyt_c.jpg" width="100" height="52" border="0" /></a></td>
    <td width="80" height="54" align="left" valign="middle"><label>
      <input name="Volver2" type="submit" class="boton_volver" id="Volver2" value="Volver" onclick="enviar('sol_rec.php');" />
    </label></td>
    <td width="80" align="left" valign="middle"><input name="Volver4" type="submit" class="boton_actualizar" id="Volver4" value="Actualizar" /></td>
    <td width="676" align="center" valign="middle" class="txt01">LISTADO SOLICITUDES DE RECURSOS</td>
    <td width="101" align="center" valign="middle">&nbsp;</td>
    <td width="56" align="center" valign="middle">&nbsp;</td>
    <td width="100" align="right" valign="top"><img src="../imagenes/logo_iso_c.jpg" width="100" height="52"/></td>
  </tr>
  
  <tr>
    <td height="223" colspan="7" align="center" valign="top">
    
      <table width="1168" height="173" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
        
        <tr>
          <td width="1176" height="173" align="center" valign="top">
          
          <table width="1168" border="1" bordercolor="#F2F2F2" bgcolor="#cedee1" class="txtnormal2" cellspacing="0" cellpadding="0">
        <tr style="background:#cedee1;" class="txtnormal8">
        <td align="center">&nbsp;VER</td>
        <td align="center">FICHA</td>
        <td align="center">RUT</td>
        <td align="center">NOMBRE</td>
        <td align="center">FECHA NAC</td>
        <td align="center">FECHA ING</td>
        <td align="center">FECHA TERM CONT</td>
        <td align="center">&nbsp;</td>
        </tr>
            <tr class="txtnormal8" >
              <td width="2%" style="background:#cedee1;">&nbsp;</td>
              <td width="11%">&nbsp;</td>
              <td width="9%">&nbsp;</td>
              <td width="29%"><?
              if($p_sol != ""){$p_sol = $_POST['c_p_sol'];}
			  if($p_sol == ""){$p_sol = "Todos";}
			  ?>
                <select name="c_p_sol" id="c_p_sol"  style="font-size:9px;" onchange="evento();">
                  <?php
                  				$sqlu    = "SELECT DISTINCT prof_sol FROM tb_sol_rec ORDER BY prof_sol ";
	
								$rsu 	 = mssql_query($sqlu, $co);
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
                </select></td>
              <td width="13%">&nbsp;</td>
              <td width="12%">&nbsp;</td>
              <td width="11%">&nbsp;</td>
              <td width="13%">&nbsp;</td>
              <?
/*******************************************************************************************************************************************   
						PREGUNTAMOS SI EL SELECT ENVIO UN VALOR NUMERICO(CODIGO DE EQUIPO)
********************************************************************************************************************************************/ 
              
			  if($planta != ""){$planta = $_POST['c_plantas'];}
			  if($planta == ""){$planta = "Todos";}
			  ?>
              </tr>
               <tr> 
                	<td colspan="8" align="center" class="txtnormal5"><label></label></td>
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
if($_POST['c_cant_d'] != "Todos" and $_POST['c_cant_d'] != "")
{
	$query5 = "and tb_det_sol.cant_det = '".$_POST['c_cant_d']."'";
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


$co=mssql_connect("$SERVER","$USR","$PASS");
mssql_select_db("$BDATOS", $co);
		
$sql1	= "SELECT * FROM softland.sw_personal WHERE sw_personal.appaterno != '' $query $query1 $query2 $query3 $query4 $query5 $query6 $query7 $query8 ORDER BY sw_personal.appaterno";
$res	= mssql_query($sql1, $co);
	
$numeroRegistros=mssql_num_rows($res);

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
	$co=mssql_connect("$SERVER","$USR","$PASS");
	mssql_select_db("$BDATOS", $co);
	
	/*$sql = 	"SELECT * FROM softland.sw_personal WHERE sw_personal.appaterno != '' $query $query1 $query2 $query3 $query4 $query5 $query6 $query7 $query8 ORDER BY sw_personal.appaterno LIMIT ".$limitInf.",".$tamPag;*/
	/*$sql = "SELECT * FROM ( SELECT *, ROW_NUMBER() OVER (ORDER BY sw_personal.ficha) as row FROM softland.sw_personal) a WHERE row > ".$limitInf." and row <= ".$tamPag;*/
	$sql = "SELECT * FROM ( SELECT *, ROW_NUMBER() OVER (ORDER BY sw_personal.appaterno) as row FROM softland.sw_personal) a WHERE row > ".$limitInf." and row <= ".$tamPag;

	$respuesta 	= mssql_query($sql,$co);
	$color 		= "#ffffff";
	$i=1;
	while($vrows=mssql_fetch_assoc($respuesta))
	{
		$ficha				= "".$vrows['ficha']."";
		$ficha				= "".$vrows['rut']."";
		$nombres			= "".utf8_encode($vrows['nombres'])."";
		$fechaIngreso		= "".$vrows['fechaIngreso']."";
		$FecTermContrato	= "".$vrows['FecTermContrato']."";
		$fechaNacimient		= "".$vrows['fechaNacimient']."";
		
		$co=mssql_connect("$SERVER","$USR","$PASS");
		mssql_select_db("$BDATOS", $co);

		echo"<tr bgcolor=$color class='txtnormal8' onDblClick='javascript:muestra($cod_sol)'; onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000')>";	

		   echo"<td bgcolor='#ffc561'>&nbsp;<a href=\"sol_rec.php?cod=$cod_sol\"><img src='../imagenes/edit.png' border='0' valign='top' alt='Modificar'/>&nbsp;</a></td>
				<td>&nbsp;$ficha</td>
				<td>&nbsp;$ficha</td>
				<td>&nbsp;$nombres</td>
				<td>&nbsp;$fechaNacimient</td>	
				<td>&nbsp;$fechaIngreso</td>
				<td>&nbsp;$FecTermContrato</td>
				<td>&nbsp;$fe_sol</td>
			</tr>";
									
				if($color == "#ffffff"){ $color = "#ddeeee"; }
				else{ $color = "#ffffff"; }		
	}

}		
?>         
            <tr>
              <td colspan="8" align="center" class="txtnormal" height="30"><?php echo "Encontrados ".$numeroRegistros." resultados"; ?></td>
            </tr>
            <tr>
              <td colspan="8" align="center" class="txtnormaln"><table width="1183" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="163">&nbsp;</td>
                  <td width="1020" align="center"><?
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
              <td height="74" colspan="8" align="center" valign="bottom" class="txtnormaln">&nbsp;
               <label>
                <input name="button" type="button" class="boton_pdf" id="button" value="Exportar a PDF" onclick="reporte_pdf()"/>
                <a href='bajar_excel.php?filename=<? echo $fname ?>'><img src="../imagenes/botones/rep_excel.jpg" border="0" /></a>
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
	$co=mssql_connect("$SERVER","$USR","$PASS");
	mssql_select_db("$BDATOS", $co);
	
	$sql_rep = "SELECT * FROM softland.sw_personal WHERE sw_personal.appaterno != '32' $query $query1 $query2 $query3 $query4 $query5 $query6 $query7 $query8 ORDER BY sw_personal.appaterno";
	
	$resp_rep	= mssql_query($sql_rep, $co);
	$color 		= "#ffffff";
	$i			= 1;
	$filaexcel  = 8;
	
	while($vrows_rep = mssql_fetch_assoc($resp_rep))
	{
		echo "<input name='campos[$id_det]' type='hidden'/>";
		$ficha				= "".$vrows['ficha']."";
		$rut				= "".$vrows['rut']."";
		$nombres			= "".$vrows['nombres']."";
		$fechaIngreso		= "".$vrows['fechaIngreso']."";
		$FecTermContrato	= "".$vrows['FecTermContrato']."";
		$fechaNacimient		= "".$vrows['fechaNacimient']."";
		
		$co=mssql_connect("$SERVER","$USR","$PASS");
		mssql_select_db("$BDATOS", $co);
									
		$worksheet->write($filaexcel,0,$ficha,$formato);
        $worksheet->write($filaexcel,1,$rut,$formato);
        $worksheet->write($filaexcel,2,$nombres,$formato);
        $worksheet->write($filaexcel,3,$fechaIngreso,$formato);
        $worksheet->write($filaexcel,4,$FecTermContrato,$formato);
		$worksheet->write($filaexcel,5,$fechaNacimient,$formato);
        $worksheet->write($filaexcel,6,$fe_sol,$formato);
		$worksheet->write($filaexcel,7,$fe_aprob_g,$formato);
		$worksheet->write($filaexcel,8,utf8_decode($rec_det),$formato);
		$worksheet->write($filaexcel,9,$cant_recep,$formato);
		$worksheet->write($filaexcel,10,utf8_decode($prof_sol),$formato);
									
		if($color == "#ffffff"){ $color = "#ddeeee"; }
		else{ $color = "#ffffff"; }
		
		$i++;
		$filaexcel++;				
	}
	$workbook->close();		
	//mysql_free_result($resp_rep);

?>
</form> 
</body>
</html>
