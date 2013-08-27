<?
// Necesario para ver si la session esta activa  o si se tiene permiso de accseso
require("../lg/lg_controlar.php");
error_reporting(0);
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php

if($_SESSION['usd_cot_lee'] != "1")
{
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}//Hasta aquí lo comun para todas las paginas restringidas
/*********************************************************/
include ('../inc/config_db.php'); 	// Incluimos archivo de configuracion de la conexion
include ('../inc/lib.db.php');		// Incluimos archivo de libreria de funsiones PHP
	
	$num_cot 			= "Todos";
	$tipo_ing	 		= "Todos";
	$desc_cot	 		= "Todos";
	$fe_ing_cot 		= "Todos";
	$fe_sal_cot 		= "Todos";
	$fe_ent_cot 		= "Todos";
	$emp_cot		 	= "Todos";
	$estado_cot 		= "Todos";
	$cliente_cot	 	= "Todos";
	$contacto_cot 		= "Todos";
	$resp_cot			= "Todos";
	
/**************************************************************************
	COMIENZA REPORTE EXCEL
**************************************************************************/	
	require_once("excelclass/class.writeexcel_workbookbig.inc.php");
	require_once("excelclass/class.writeexcel_worksheet.inc.php");
	require_once("excelclass/functions.writeexcel_utility.inc.php");
	
	$fname="tmp/reporte.xls";
	
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
	$worksheet->write(3,4,"COTIZACIONES/LICITACIONES",$for_titulo);
	$worksheet->write(3,5,"",$for_titulo);
	$worksheet2->write(3,4,"HOJA 2",$for_titulo);
	$worksheet3->write(3,4,"HOJA 3",$for_titulo);
	
	// ENCABEZADOS
	
	$worksheet->write(5,0,"NUMERO",$encabezado);
	$worksheet->write(5,1,"TIPO",$encabezado);
	$worksheet->write(5,2,"DESCRIPCION TRABAJO",$encabezado);
	$worksheet->write(5,3,"FECHA INGRESO",$encabezado);
	$worksheet->write(5,4,"FECHA VISITA",$encabezado);
	$worksheet->write(5,5,"FECHA CONSULTA",$encabezado);
	$worksheet->write(5,6,"FECHA RESPUESTA",$encabezado);
	$worksheet->write(5,7,"FECHA ENTREGA",$encabezado);
	$worksheet->write(5,8,"CLIENTE",$encabezado);
	$worksheet->write(5,9,"CONTACTO",$encabezado);
	$worksheet->write(5,10,"EMPRESA",$encabezado);
	$worksheet->write(5,11,"RESPONSABLE",$encabezado);
	$worksheet->write(5,12,"ESTADO",$encabezado);
	$worksheet->write(5,13,"OBSERVACION",$encabezado);
	$worksheet->write(5,14,"ING POR",$encabezado);

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
	document.form1.action = 'cotizaciones.php?cod='+elemento;
	document.form1.submit();
}

function CambiaColor(esto,fondo,texto)
{
    esto.style.background=fondo;
    esto.style.color=texto;
	esto.style.cursor='hand'
}

function evento(valor)
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

function rep()
{
	//poput = abrirVentanaM("rep_filtro_ods.php","yes");
	document.form1.target='poput';
	document.form1.action='rep_lista_cot.php';
	document.form1.submit();
}
function resetear(){
	document.form1.target='';
	document.form1.action='';
}
function ingreso()
{
	document.form1.action = 'ingreso.php';
	document.form1.submit();
}
</script>

<style type="text/css">
<!--
body {
	background-color: #5A88B7;
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

<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>

<body>
<form id="form1" name="form1" method="post" action="" > 
  <table width="1100" height="199" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="100" height="55" align="center" valign="top"><img src="../imagenes/logo2.jpg" width="127" height="60" /></td>
    <td width="90" height="55" align="center" valign="middle"><label>
      <input name="Volver2" type="submit" class="boton_inicio" id="Volver2" value="Inicio" onclick="enviar('../index2.php');" />
    </label></td>
    <td width="80" align="center" valign="middle"><input name="Volver3" type="submit" class="boton_volver" id="Volver3" value="Volver" onclick="enviar('cotizaciones.php');" /></td>
    <td width="78" align="center" valign="middle">&nbsp;</td>
    <td width="498" align="center" valign="middle">LISTADO DE COTIZACIONES/LICITACIONES</td>
    <td width="79" align="center" valign="middle">&nbsp;</td>
    <td width="91" align="center" valign="middle"><input name="Volver4" type="submit" class="boton_actualizar" id="Volver4" value="Actualizar" /></td>
    <td width="91" align="center" valign="middle">&nbsp;</td>
    <td width="93" align="center" valign="top"><img src="../imagenes/logo_iso_c.jpg" width="108" height="58" /></td>
  </tr>
  <tr>
    <td height="114" colspan="9" align="center" valign="top">
      <table width="1043" height="114" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
        <tr>
          <td width="1043" height="114" align="center" valign="top">
          <table width="1089" border="1" bordercolor="#F2F2F2" bgcolor="#cedee1" class="txtnormal2" cellspacing="0" cellpadding="0">
        	<tr style="background:#cedee1;" class="txtnormal8">
        		<td align="center">&nbsp;EDIT.</td>
				<td align="center">NUM</td>
				<td align="center">TIPO</td>
				<td align="center">NOM/TRABAJO</td>
				<td align="center">FECHA INGRESO</td>
				<td align="center">FECHA ENTREGA</td>
				<td align="center">ESTADO</td>
				<td width="28%" align="center">CLIENTE</td>
				<td align="center">RESPONSABLE</td>
        	</tr>
            <tr class="txtnormal8" align="center">
              <td width="3%" style="background:#cedee1;"><input type="hidden" name="ValorCombo" id="ValorCombo" value="<?php echo $valor_combo; ?>" /></td>
			  <td width="3%">
			    <?
              if($num_cot != "" ){$num_cot = $_POST['c_num_cot'];}
			  if($num_cot == "" ){$num_cot = "Todos";}
			  ?>
			    <select name="c_num_cot" id="c_num_cot" style="font-size:9px;" onchange="evento();">
			      <?php
                //*******************************************************************************************************
					$sqlods  	= "SELECT DISTINCT num_cot FROM tb_cotizaciones WHERE estado_cot != 'No Estudio' and estado_cot != 'Adjudicado' and estado_cot != 'No Adjudicado' ORDER BY num_cot ";
								
					$rsnume 	= dbConsulta($sqlods);
					$totaln  	= count($rsnume);
					echo"<option selected='selected' value='$num_cot'>$num_cot</option>";
					
					if($num_cot != "Todos")
					{
               			echo"<option value='Todos'>Todos</option>";
                	}					
					for ($i = 0; $i < $totaln; $i++)
					{
						echo "<option value='".$rsnume[$i]['num_cot']."'>".$rsnume[$i]['num_cot']."</option>";	
					}							
				?>
			      </select>			    </td>
              <td width="3%"><span class="Estilo5">
			  <?
              if($tipo_ing != "" ){$tipo_ing = $_POST['c_tipo_ing'];}
			  if($tipo_ing == "" ){$tipo_ing = "Todos";}
			  ?>
               <select name="c_tipo_ing" id="c_tipo_ing" style="font-size:9px;" onchange="evento();" >
               <?php
               //*******************************************************************************************************
					$SqlTipo = "SELECT DISTINCT tipo_ing FROM tb_cotizaciones WHERE estado_cot != 'No Estudio' and estado_cot != 'Adjudicado' and estado_cot != 'No Adjudicado' ORDER BY tipo_ing ";
								
					$RsTipo  = dbConsulta($SqlTipo);
					$totalT  = count($RsTipo);
					echo"<option selected='selected' value='$tipo_ing'>$tipo_ing</option>";
					if($tipo_ing != "Todos")
					{
               			echo"<option value='Todos'>Todos</option>";
                	}	
									
					for ($i = 0; $i < $totalT; $i++)
					{
						echo "<option value='".$RsTipo[$i]['tipo_ing']."'>".$RsTipo[$i]['tipo_ing']."</option>";	
					}							
				?>
              </select>           	  </td>
              <td width="38%">  
              	<span class="Estilo5">
              	<?
              		if($desc_cot != "" ){$desc_cot = $_POST['c_desc_cot'];}
			  		if($desc_cot == "" ){$desc_cot = "Todos";}
			  	?>
              	</span>
              <select name="c_desc_cot" id="c_desc_cot" style="font-size:9px;width:350px;" onchange="evento();" >
               <?php
                //*******************************************************************************************************
					$SqlTrab = "SELECT DISTINCT desc_cot FROM tb_cotizaciones WHERE estado_cot != 'No Estudio' and estado_cot != 'Adjudicado' and estado_cot != 'No Adjudicado' ORDER BY desc_cot ";
								
					$RsTrab  	 = dbConsulta($SqlTrab);
					$totalTrab   = count($RsTrab);
					echo"<option selected='selected' value='$desc_cot'>$desc_cot</option>";
					if($desc_cot != "Todos")
					{
               			echo"<option value='Todos'>Todos</option>";
                	}	
									
					for ($i = 0; $i < $totalTrab; $i++)
					{
						echo "<option value='".$RsTrab[$i]['desc_cot']."'>".$RsTrab[$i]['desc_cot']."</option>";	
					}							
				?>
              </select></td>
              <td width="5%">
                <?
              		if($fe_ing_cot != "" ){$fe_ing_cot = $_POST['c_fingreso'];}
					if($fe_ing_cot == "" ){$fe_ing_cot = "Todos";}
			  	?>
                <select name="c_fingreso" id="c_fingreso" style="font-size:9px;" onchange="evento();" >
                  <?php
                //*******************************************************************************************************
					$SqlFi = "SELECT DISTINCT fe_ing_cot FROM tb_cotizaciones WHERE estado_cot != 'No Estudio' and estado_cot != 'Adjudicado' and estado_cot != 'No Adjudicado' ORDER BY fe_ing_cot ";
								
					$RsFi 		= dbConsulta($SqlFi);
					$totalFi  	= count($RsFi);
					
					echo"<option selected='selected' value='$fe_ing_cot'>$fe_ing_cot</option>";
					
					if($fe_ing_cot != "Todos")
					{
               			echo"<option value='Todos'>Todos</option>";
                	}	
									
					for ($i = 0; $i < $totalFi; $i++)
					{
						$RsFi[$i]['fe_ing_cot']		=	cambiarFecha($RsFi[$i]['fe_ing_cot'], '-', '/' );
						echo "<option value='".$RsFi[$i]['fe_ing_cot']."'>".$RsFi[$i]['fe_ing_cot']."</option>";	
					}							
				?>
                </select></td>
              <td width="4%">
                <?
              if($fe_ent_cot != "" ){$fe_ent_cot = $_POST['c_fentrega'];}
			  if($fe_ent_cot == "" ){$fe_ent_cot = "Todos";}
			  ?>
                <select name="c_fentrega" id="c_fentrega" style="font-size:9px;" onchange="evento();" >
                  <?php
                //*******************************************************************************************************
					$SqlFe  = "SELECT DISTINCT fe_ent_cot FROM tb_cotizaciones WHERE estado_cot != 'No Estudio' and estado_cot != 'Adjudicado' and estado_cot != 'No Adjudicado' ORDER BY fe_ent_cot ";
								
					$RsFe 	= dbConsulta($SqlFe);
					$totalFe  = count($RsFe);
					
					echo"<option selected='selected' value='$fe_ent_cot'>$fe_ent_cot</option>";
					
					if($fe_ent_cot != "Todos")
					{
               			echo"<option value='Todos'>Todos</option>";
                	}	
									
					for ($i = 0; $i < $totalFe; $i++)
					{
						$RsFe[$i]['fe_ent_cot']		=	cambiarFecha($RsFe[$i]['fe_ent_cot'], '-', '/' );
						echo "<option value='".$RsFe[$i]['fe_ent_cot']."'>".$RsFe[$i]['fe_ent_cot']."</option>";	
					}							
				?>
                </select></td>
			  <td width="6%">
			  <?
              if($estado_cot != "" ){$estado_cot = $_POST['c_estado'];}
			  if($estado_cot == "" ){$estado_cot = "Todos";}
			  ?>
               <select name="c_estado" id="c_estado" style="font-size:9px;" onchange="evento();" >
               <?php
                //*******************************************************************************************************
					$SqlEst  = "SELECT DISTINCT estado_cot FROM tb_cotizaciones WHERE estado_cot != 'No Estudio' and estado_cot != 'Adjudicado' and estado_cot != 'No Adjudicado' ORDER BY estado_cot ";
								
					$RsEst 	 	= dbConsulta($SqlEst);
					$totalEst  	= count($RsEst);
					echo"<option selected='selected' value='$estado_cot'>$estado_cot</option>";
					if($estado_cot != "Todos")
					{
               			echo"<option value='Todos'>Todos</option>";
                	}	
									
					for ($i = 0; $i < $totalEst; $i++)
					{
						echo "<option value='".$RsEst[$i]['estado_cot']."'>".$RsEst[$i]['estado_cot']."</option>";	
					}							
				?>
              </select>              </td>
              
              
              <td><?
			  /**********************************************************************************************************************************
			  															COMBO CLIENTES
			  **********************************************************************************************************************************/
              if($cliente_cot != "" ){$cliente_cot = $_POST['c_cliente_cot'];}
			  if($cliente_cot == "" ){$cliente_cot = "Todos";}
			  ?>
              <!---------------------------------------------------------------------------------------------------------------------------------
            					COMIENZO DEL SELECT
              ---------------------------------------------------------------------------------------------------------------------------------->
                <select name="c_cliente_cot" style="font-size:9px;" onchange="evento();" >
              <?php                         
				if(is_numeric($_POST['c_cliente_cot']))
				{
					$sql3 	= "SELECT id_cli, razon_s FROM tb_clientes WHERE id_cli = '".$_POST['c_cliente_cot']."' ";			
					$resp3 	= dbExecute($sql3);
					while ($vrows3 = mysql_fetch_array($resp3)) 
					{
						$sid_cli 		= "".$vrows3['id_cli']."";
						$cliente_cot 	= "".$vrows3['razon_s']."";
					}
				}
				$co=mysql_connect("$DNS","$USR","$PASS");
				mysql_select_db("$BDATOS", $co);
				
				$SqlDist = "SELECT DISTINCT cliente_cot FROM tb_cotizaciones WHERE estado_cot != 'No Estudio' and estado_cot != 'Adjudicado' and estado_cot != 'No Adjudicado' ORDER BY cliente_cot ";
				$resDist = mysql_query($SqlDist, $co);
				
				echo"<option selected='selected' value='$sid_cli'>$cliente_cot</option>";
				if($cliente_cot != "Todos")
				{
               		echo"<option value='Todos'>Todos</option>";
                }	
				
				while($vrowsDist = mysql_fetch_array($resDist))
				{
					$cliente = "".$vrowsDist['cliente_cot']."";
					
					$SqlRes  = "SELECT id_cli, razon_s FROM tb_clientes WHERE id_cli = '$cliente' ORDER BY razon_s";	
							
					$rse 	 = dbConsulta($SqlRes);
					$totale  = count($rse);
													
					for ($i = 0; $i < $totale; $i++)
					{
						$nom_cli = $rse[$i]['razon_s'];
						if($cliente_cot != $nom_cli)
						{
							echo "<option value='".$rse[$i]['id_cli']."'>".$rse[$i]['razon_s']."</option>";
						}
					}
				}
			/**********************************************************************************************************************************
			  															FIN COMBO CLIENTES
			 **********************************************************************************************************************************/				
			?>
            </select>
            <!---------------------------------------------------------------------------------------------------------------------------------
            					FIN DEL SELECT
             ---------------------------------------------------------------------------------------------------------------------------------->                </td>
            <? 
			  if($contacto_cot != ""){$contacto_cot = $_POST['c_contacto'];}
			  if($contacto_cot == ""){$contacto_cot = "Todos";}
			  ?>            
              <td width="10%"align="center"><?
			  /**********************************************************************************************************************************
			  															COMBO RESPONSABLE
			  **********************************************************************************************************************************/
              if($resp_cot != "" ){$resp_cot = $_POST['c_resp_cot'];}
			  if($resp_cot == "" ){$resp_cot = "Todos";}
			  ?>
                <!---------------------------------------------------------------------------------------------------------------------------------
            					COMIENZO DEL SELECT
              ---------------------------------------------------------------------------------------------------------------------------------->
                <select name="c_resp_cot" style="font-size:9px;" onchange="evento();" >
                  <?php                         
				if(!is_numeric($_POST['c_resp_cot']))
				{
					$sql3 	= "SELECT rut_resp, nom_resp FROM tb_responsable WHERE rut_resp = '".$_POST['c_resp_cot']."' ";			
					$resp3 	= dbExecute($sql3);
					while ($vrows3 = mysql_fetch_array($resp3)) 
					{
						$srut_resp 	= "".$vrows3['rut_resp']."";
						$resp_cot 	= "".$vrows3['nom_resp']."";
					}
				}
				$co=mysql_connect("$DNS","$USR","$PASS");
				mysql_select_db("$BDATOS", $co);
				
				$SqlDist  	= "SELECT DISTINCT resp_cot FROM tb_cotizaciones WHERE estado_cot != 'No Estudio' and estado_cot != 'Adjudicado' and estado_cot != 'No Adjudicado' ORDER BY resp_cot ";
				$resDist 	= mysql_query($SqlDist, $co);
				
				echo"<option selected='selected' value='$srut_resp'>$resp_cot</option>";
				if($resp_cot != "Todos")
				{
               		echo"<option value='Todos'>Todos</option>";
                }	
				
				while($vrowsDist = mysql_fetch_array($resDist))
				{
					$responsable = "".$vrowsDist['resp_cot']."";
					
					$SqlRes  = "SELECT rut_resp, nom_resp FROM tb_responsable WHERE rut_resp = '$responsable' ORDER BY nom_resp";	
							
					$rse 	 = dbConsulta($SqlRes);
					$totale  = count($rse);
													
					for ($i = 0; $i < $totale; $i++)
					{
						$nom_resp = $rse[$i]['nom_resp'];
						if($resp_cot != $nom_resp)
						{
							echo "<option value='".$rse[$i]['rut_resp']."'>".$rse[$i]['nom_resp']."</option>";
						}
					}
				}
			/**********************************************************************************************************************************
			  															FIN COMBO RESPONSABLE
			 **********************************************************************************************************************************/				
			?>
                </select></td>
			  </tr>
		<?php
		/***********************************************************************************************************************
				FILTRAMOS
		***********************************************************************************************************************/	
	if($_POST['c_num_cot'] != "Todos" and $_POST['c_num_cot'] != "")
	{
		$query = "and num_cot = '".$_POST['c_num_cot']."'";
	}
	if($_POST['c_tipo_ing'] != "Todos" and $_POST['c_tipo_ing'] != "")
	{
		$query1 = "and tipo_ing = '".$_POST['c_tipo_ing']."'";
	}
	if($_POST['c_desc_cot'] != "Todos" and $_POST['c_desc_cot'] != "")
	{
		$query2 = "and desc_cot = '".$_POST['c_desc_cot']."'";
	}	
	if($_POST['c_fingreso'] != "Todos" and $_POST['c_fingreso'] != "")
	{
		$_POST['c_fingreso']	=	cambiarFecha($_POST['c_fingreso'], '/', '-' );
		$query3 = "and fe_ing_cot = '".$_POST['c_fingreso']."'";
	}
	if($_POST['c_fvisita'] != "Todos" and $_POST['c_fvisita'] != "")
	{
		$_POST['c_fvisita']	=	cambiarFecha($_POST['c_fvisita'], '/', '-' );
		$query4 = "and fe_sal_cot = '".$_POST['c_fvisita']."'";
	}
	if($_POST['c_fentrega'] != "Todos" and $_POST['c_fentrega'] != "")
	{
		$_POST['c_fentrega']	=	cambiarFecha($_POST['c_fentrega'], '/', '-' );
		$query5 = "and fe_ent_cot = '".$_POST['c_fentrega']."'";
	}
	if($_POST['c_empresa'] != "Todos" and $_POST['c_empresa'] != "")
	{
		$query6 = "and emp_cot = '".$_POST['c_empresa']."'";
	}
	if($_POST['c_estado'] != "Todos" and $_POST['c_estado'] != "")
	{
		$query7 = "and estado_cot = '".$_POST['c_estado']."'";
	}
	if($_POST['c_cliente_cot'] != "Todos" and $_POST['c_cliente_cot'] != "")
	{
		$query8 = "and cliente_cot = '".$_POST['c_cliente_cot']."'";
	}
	if($_POST['c_contacto'] != "Todos" and $_POST['c_contacto'] != "")
	{
		$query9 = "and contacto_cot = '".$_POST['c_contacto']."'";
	}
	if($_POST['c_resp_cot'] != "Todos" and $_POST['c_resp_cot'] != "")
	{
		$query10 = "and resp_cot = '".$_POST['c_resp_cot']."'";
	}
	

/***************************************************************************************************************************/
$co=mysql_connect("$DNS","$USR","$PASS");
mysql_select_db("$BDATOS", $co);
		
$sql1	= "SELECT * FROM tb_cotizaciones WHERE estado_cot != 'Adjudicado' and estado_cot != 'No Estudio' and estado_cot != 'No Adjudicado' and estado_cot != 'Nula' $query $query1 $query2 $query3 $query4 $query5 $query6 $query7 $query8 $query9 $query10 ORDER BY num_cot ";
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
	
	$sql = "SELECT * FROM tb_cotizaciones WHERE  estado_cot != 'Adjudicado' and estado_cot != 'No Estudio' and estado_cot != 'No Adjudicado' and estado_cot != 'Nula' $query $query1 $query2 $query3 $query4 $query5 $query6 $query7 $query8 $query9 $query10 ORDER BY num_cot DESC LIMIT ".$limitInf.",".$tamPag;
	$respuesta = mysql_query($sql,$co);
	
	$color = "#ffffff";
	$i=1;
	while($vrows=mysql_fetch_array($respuesta))
	{
		$num_cot		= "".$vrows['num_cot']."";
		$tipo_ing		= "".$vrows['tipo_ing']."";
		$desc_cot		= "".$vrows['desc_cot']."";
		$fe_ing_cot		= "".$vrows['fe_ing_cot']."";
		$fe_sal_cot		= "".$vrows['fe_sal_cot']."";
		$fe_ent_cot		= "".$vrows['fe_ent_cot']."";
		$emp_cot		= "".$vrows['emp_cot']."";
		$estado_cot		= "".$vrows['estado_cot']."";
		$cliente_cot	= "".$vrows['cliente_cot']."";
		$contacto_cot	= "".$vrows['contacto_cot']."";
		$resp_cot		= "".$vrows['resp_cot']."";
		
		$sql_cli = "SELECT razon_s FROM tb_clientes WHERE id_cli = '$cliente_cot' ";
		$res=mysql_query($sql_cli,$co);
		
		while($vrowsc=mysql_fetch_array($res))
		{
			$cliente_cot = "".$vrowsc['razon_s']."";
		}
		
		$sql_res = "SELECT nom_resp FROM tb_responsable WHERE rut_resp = '$resp_cot' ";
		$res = mysql_query($sql_res,$co);
		while($vrowsr = mysql_fetch_array($res))
		{
			$resp_cot	= "".$vrowsr['nom_resp']."";
		}
		
		$fe_ing_cot	= cambiarFecha($fe_ing_cot, '-', '/' );
		$fe_sal_cot	= cambiarFecha($fe_sal_cot, '-', '/' );
		$fe_ent_cot	= cambiarFecha($fe_ent_cot, '-', '/' );
		
		echo("<tr bgcolor=$color class='txtnormal8' onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000') align=left onClick=\"javascript:muestra('$num_cot')\";>	
									
		<td bgcolor='#ffc561'>&nbsp;<a href=\"cotizaciones.php?cod=$num_cot\"><img src='../imagenes/edit.png' border='0' valign='top' alt='Modificar'/>&nbsp;</td>
		<td bgcolor='#cedee1'>&nbsp;$num_cot</td>
		<td>&nbsp;$tipo_ing</td>
		<td>&nbsp;$desc_cot</td>	
		<td>&nbsp;$fe_ing_cot</td>
		<td>&nbsp;$fe_ent_cot</td>
		<td>&nbsp;$estado_cot</td>	
		<td>&nbsp;$cliente_cot</td>	
		<td>&nbsp;$resp_cot</td>	
		</tr> ");
		if($color == "#ffffff"){ $color = "#ddeeee"; }
		else{ $color = "#ffffff"; }
		$i++;			
	}	
}			
?>  
			  <tr>
			  <td height="29" colspan="9" align="center" class="txtnormal5"><?php echo "Encontrados ".$numeroRegistros." resultados"; ?></td>
              </tr>
			  <tr>
			    <td colspan="9" align="center" class="txtnormal5"><table width="1183" border="0" cellspacing="0" cellpadding="0">
			      <tr>
			        <td width="106">&nbsp;</td>
			        <td width="1077" align="center"><?
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
              <td colspan="9" align="center" class="txtnormaln">
              
              <a href='bajar_excel.php?filename=<?php echo $fname ?>'>
              <img src="../imagenes/botones/rep_excel.jpg" alt="" border="0" /></a>
              <input name="Volver" type="submit" class="boton_volver" id="Volver" value="Volver" onclick="enviar('cotizaciones.php');" /></td>
            </tr>
          </table>		  </td>
        </tr>
      </table>	  </td>
  </tr>
  <tr>
    <td height="5" colspan="9" align="center" valign="top"><img src="imagenes/barra.gif" alt="" width="100%" height="2" /></td>
  </tr>
</table>
<?php
/***********************************************************************************************************************
REALIZAMOS LA CONSULTA PARA GENERAR REPORTE EN EXCEL
***********************************************************************************************************************/		
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sql_rep  = "SELECT * FROM tb_cotizaciones WHERE estado_cot != 'No Estudio' and estado_cot != 'No Adjudicado' and estado_cot != 'Nula' $query $query1 $query2 $query3 $query4 $query5 $query6 $query7 $query8 $query9 $query10 ORDER BY num_cot ";
	$resp_rep = mysql_query($sql_rep, $co);

	$filaexcel = 6;
	while($vrows_rep=mysql_fetch_array($resp_rep))
	{
		echo "<input name='campos[$id_cot]' type='hidden'/>";
		$num_cot		= "".$vrows_rep['num_cot']."";
		$tipo_ing		= "".$vrows_rep['tipo_ing']."";
		$desc_cot		= "".$vrows_rep['desc_cot']."";
		$fe_ing_cot		= "".$vrows_rep['fe_ing_cot']."";
		$fe_sal_cot		= "".$vrows_rep['fe_sal_cot']."";
		$fe_ent_cot		= "".$vrows_rep['fe_ent_cot']."";
		$emp_cot		= "".$vrows_rep['emp_cot']."";
		$estado_cot		= "".$vrows_rep['estado_cot']."";
		$cliente_cot	= "".$vrows_rep['cliente_cot']."";
		$contacto_cot	= "".$vrows_rep['contacto_cot']."";
		$resp_cot		= "".$vrows_rep['resp_cot']."";
		
		$sql_cli 	= "SELECT razon_s FROM tb_clientes WHERE id_cli = '$cliente_cot' ";
		$resp		= mysql_query($sql_cli,$co);
		while($vrowscp=mysql_fetch_array($resp))
		{
			$cliente_cot = "".$vrowscp['razon_s']."";
		}
		$sql_res = "SELECT nom_resp FROM tb_responsable WHERE rut_resp = '$resp_cot' ";
		$res = mysql_query($sql_res,$co);
		while($vrowsr = mysql_fetch_array($res))
		{
			$resp_cot	= "".$vrowsr['nom_resp']."";
		}
		
		$sql_emp = "SELECT nom_emps FROM tb_empresaserv WHERE rut_emps = '$emp_cot' ";
		$res_emp = mysql_query($sql_emp,$co);
		while($vrow_emp = mysql_fetch_array($res_emp))
		{
			$nom_emps	= "".$vrow_emp['nom_emps']."";
		}
		
		if($fe_ing_cot 	== "0000-00-00"){$fe_ing_cot 	= "";}
		if($fe_sal_cot 	== "0000-00-00"){$fe_sal_cot 	= "";}
		if($fe_cons_cot == "0000-00-00"){$fe_cons_cot 	= "";}
		if($fe_resp_cot == "0000-00-00"){$fe_resp_cot 	= "";}
		if($fe_ent_cot 	== "0000-00-00"){$fe_ent_cot 	= "";}
		
		$fe_ing_cot	= cambiarFecha($fe_ing_cot, '-', '/' );
		$fe_sal_cot	= cambiarFecha($fe_sal_cot, '-', '/' );
		$fe_cons_cot= cambiarFecha($fe_cons_cot, '-', '/' );
		$fe_resp_cot= cambiarFecha($fe_resp_cot, '-', '/' );
		$fe_ent_cot	= cambiarFecha($fe_ent_cot, '-', '/' );
											
		$worksheet->write($filaexcel,0,$vrows_rep['num_cot'],$formato);
        $worksheet->write($filaexcel,1,$vrows_rep['tipo_ing'],$formato);
        $worksheet->write($filaexcel,2,utf8_decode($vrows_rep['desc_cot']),$formato);
        $worksheet->write($filaexcel,3,$fe_ing_cot,$formato);
        $worksheet->write($filaexcel,4,$fe_sal_cot,$formato);
		$worksheet->write($filaexcel,5,$fe_cons_cot,$formato);
        $worksheet->write($filaexcel,6,$fe_resp_cot,$formato);
		$worksheet->write($filaexcel,7,$fe_ent_cot,$formato);
		$worksheet->write($filaexcel,8,utf8_decode($cliente_cot),$formato);
		$worksheet->write($filaexcel,9,utf8_decode($vrows_rep['contacto_cot']),$formato);
		$worksheet->write($filaexcel,10,utf8_decode($nom_emps),$formato);
		$worksheet->write($filaexcel,11,utf8_decode($resp_cot),$formato);
		$worksheet->write($filaexcel,12,utf8_decode($vrows_rep['estado_cot']),$formato);
		$worksheet->write($filaexcel,13,utf8_decode($vrows_rep['obs_cot']),$formato);
		$worksheet->write($filaexcel,14,utf8_decode($vrows_rep['ing_por_cot']),$formato);

		$filaexcel++;				
	}

	$workbook->close();	
?>
</form> 
</body>
</html>
