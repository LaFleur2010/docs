<?
// Necesario para ver si la session esta activa  o si se tiene permiso de accseso
require("lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php

if($_SESSION['usd_sol_lee'] == "0")
{
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}//Hasta aquí lo comun para todas las paginas restringidas
//********************************************************************************************************************************
	include('inc/config_db.php');
	include('inc/lib.db.php');
	
	$empr_sol 	= "Todos";
	$area 		= "Todos";
	$cod_sol 	= "Todos";
	$ods	 	= "Todos";
	$cc			= "Todos";
	$det 		= "Todos";
	$und_m	 	= "Todos";
	$cant_d 	= "Todos";
	$f_sol	 	= "Todos";
	$p_sol 		= "Todos";
	$est 		= "Todos";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Produccion</title>
<link href="inc/bibliocss.css" rel="stylesheet" type="text/css">
<link rel="STYLESHEET" type="text/css" href="codebase/dhtmlxgrid.css"><!-- llama hoja de estilo -->

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
function evento()
{
	document.form1.submit();
}
function enviar(url)
{
	document.form1.action=url;
}
function muestra(elemento)
{
	document.form1.action='sol_rec.php?cod='+elemento;
	document.form1.submit();
}
function cerrar_ventana_modal()
{
	document.form1.submit();
	VentanaModal.cerrar();
}
</script>

<style type="text/css">
<!--
body {
	background-color: <? echo $ColorFondo; ?>;
	margin-top: 15px;
}
.Estilo5 {color: #000000}
-->
</style></head>

<body>
<form id="form1" name="form1" method="post" action="" >

<table width="1054" height="452" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="100" height="55" align="center" valign="top"><img src="imagenes/logo2.jpg" width="127" height="60" /></td>
    <td width="80" height="55" align="right" valign="middle"><label>
      <input name="Volver2" type="submit" class="boton_volver" id="Volver2" value="Volver" onclick="enviar('sol_rec.php');" />
    </label></td>
    <td width="80" align="center" valign="middle" class="txt01"><input name="Volver4" type="submit" class="boton_actualizar" id="Volver4" value="Actualizar" /></td>
    <td width="514" align="center" valign="middle" class="txt01"><img src="imagenes/Titulos/Sol_Sin_Ap.png" width="500" height="47" /></td>
    <td width="89" align="center" valign="middle">&nbsp;</td>
    <td width="91" align="center" valign="middle">&nbsp;</td>
    <td width="100" align="center" valign="top"><img src="imagenes/logo_iso_c.jpg" width="108" height="58" /></td>
  </tr>
  
  <tr>
    <td height="260" colspan="7" align="center" valign="top">
    
      <table width="1050" height="325" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
        
        <tr>
          <td width="1050" height="280" align="center" valign="top">
          
          <table width="1046" border="1" bordercolor="#F2F2F2" bgcolor="#cedee1" class="txtnormal2" cellspacing="0" cellpadding="0">
        <tr style="background:#cedee1;" class="txtnormal8">
        <td height="16" align="center">&nbsp;VER</td>
        <td align="center">AREA</td>
        <td align="center">Nº SOL.</td>
        <td align="center">ODS</td>
        <td align="center">CENTRO COSTO</td>
        <td align="center">FECHA SOL.</td>
        <td align="center">HORA SOLICITUD</td>
        <td align="center">APROB. JEFE DEPTO.</td>
        <td align="center">APROBADO GERENCIA</td>
        <td align="center">SOLICITADA POR</td>
        </tr>
            <tr class="txtnormal8" >
              <td width="3%" style="background:#cedee1;">&nbsp;</td>
              <td width="17%"><span class="Estilo5">
                <? 
              if($area != "" ){$area = $_POST['c_areas'];}
			  if($area == "" ){$area = "Todos";}
			  ?>
                <select name="c_areas" id="c_areas" style="font-size:9px;" onchange="evento();" >
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
              <td width="9%">
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
              <td width="7%">
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
              <td width="8%">
			  
			  <?
              if($cc != "" ){$cc = $_POST['c_cc'];}
			  if($cc == "" ){$cc = "Todos";}
			  ?>
                <select name="c_cc" id="c_cc" style="font-size:8px;" onchange="evento();" >
                  <?php
                              //*******************************************************************************************************
								$sql_cc  = "SELECT DISTINCT cc_sol FROM tb_sol_rec ORDER BY cc_sol";
								
								$rs_cc 	= dbConsulta($sql_cc);
								$total_cc  = count($rs_cc);
								
								echo"<option selected='selected' value='$ods'>$ods</option>";
								
								if($cc != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}	
									
								for ($i = 0; $i < $total_cc; $i++)
								{
									echo "<option value='".$rs_cc[$i]['cc_sol']."'>".$rs_cc[$i]['cc_sol']."</option>";	
								}							
								?>
                </select></td>
              <td width="8%"><?
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
              <td width="8%"><?
              if($und_m != "" ){$und_m = $_POST['c_und_m'];}
			  if($und_m == "" ){$und_m = "Todos";}
			  ?>
                <span class="Estilo5">
                <select name="c_und_m" id="c_und_m" style="font-size:9px;" onchange="evento();" >
                  <?php
                              //*******************************************************************************************************
								$sql_um  = "SELECT DISTINCT * FROM tb_sol_rec ORDER BY hr_ing_sol";
								
								$rs_um 	= dbConsulta($sql_um);
								$total_um  = count($rs_um);
								
								echo"<option selected='selected' value='$und_m'>$und_m</option>";
								
								if($und_m != "Todos"){
               						echo"<option value='Todos'>Todos</option>";
                				}	
									
								for ($i = 0; $i < $total_um; $i++)
								{
									echo "<option value='".$rs_um[$i]['hr_ing_sol']."'>".$rs_um[$i]['hr_ing_sol']."</option>";	
								}							
								?>
                </select>
                </span></td>
              <td width="9%"><?
              if($fe_in_ret != "" ){$fe_in_ret = $_POST['c_fe_in_ret'];}
			  if($fe_in_ret == "" ){$fe_in_ret = "Todos";}
			  ?>
                <select name="c_fe_in_ret3" id="c_fe_in_ret3"  style="font-size:8px;" onchange="evento();" >
                  <?php
//*******************************************************************************************************
								$sql_fs = "SELECT DISTINCT fe_aprob_d FROM tb_sol_rec WHERE fe_aprob_g = '0000-00-00' and fe_aprob_d != '0000-00-00' ORDER BY fe_aprob_d  ";
								
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
                </select></td>

              <td width="9%"><?
              if($fe_aprob_g != "" ){$fe_aprob_g = $_POST['c_fe_aprob_g'];}
			  if($fe_aprob_g == "" ){$fe_aprob_g = "Todos";}
			  ?>
                <select name="c_f_sol2" id="c_f_sol2"  style="font-size:8px;" onchange="evento();" >
                  <?php
//*******************************************************************************************************
								$sql_fs = "SELECT DISTINCT fe_aprob_g FROM tb_sol_rec WHERE fe_aprob_d = '0000-00-00' ORDER BY fe_aprob_g  ";
								
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
              <td width="22%"align="left" >
			  <?
              if($p_sol != ""){$p_sol = $_POST['c_p_sol'];}
			  if($p_sol == ""){$p_sol = "Todos";}
			  ?>
                <select name="c_p_sol" id="c_p_sol"  style="font-size:9px;" onchange="evento();">
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
                </select></td>
                </tr>
                <tr> 
                	<td colspan="10" align="center" class="txtnormal5"><label></label></td>
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
if($_POST['c_cc'] != "Todos" and $_POST['c_cc'] != "")
{
	$query8 = "and tb_sol_rec.cc_sol = '".$_POST['c_cc']."'";
}
if($_POST['c_empr_sol'] != "Todos" and $_POST['c_empr_sol'] != "")
{
	$query9 = "and empr_sol = '".$_POST['c_empr_sol']."'";
}

/***********************************************************************************************************************
MOSTRAMOS LOS ITEM DE LA SOLICITUD QUE ESTAMOS MOSTRANDO
***********************************************************************************************************************/	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sql = "SELECT * FROM tb_sol_rec WHERE cod_sol != '' $query $query1 $query2 $query3 $query4 $query5 $query6 $query7 $query8 $query9 and (fe_aprob_g = '0000-00-00') ";
	$respuesta=mysql_query($sql,$co);
	
	$cant_sol 	= count($respuesta);
	$color 		= "#ffffff";
	$i			= 1;
	$filaexcel 	= 8;
	
	while($vrows=mysql_fetch_array($respuesta))
	{
		$cod_sol		= "".$vrows['cod_sol']."";
		$ods_sol		= "".$vrows['ods_sol']."";
		$cc_sol			= "".$vrows['cc_sol']."";
		$area_sol		= "".$vrows['area_sol']."";
		$prof_sol		= "".$vrows['prof_sol']."";
		$desc_sol		= "".$vrows['desc_sol']."";
		$cant_det		= "".$vrows['cant_det']."";
		$und_med		= "".$vrows['und_med']."";
		$rec_det		= "".$vrows['rec_det']."";
		$fe_sol			= "".$vrows['fe_sol']."";
		$fe_aprob_d		= "".$vrows['fe_aprob_d']."";
		$fe_aprob_g		= "".$vrows['fe_aprob_g']."";
		$hr_ing_sol		= "".$vrows['hr_ing_sol']."";
		$empr_sol		= "".$vrows['empr_sol']."";
		
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
		
		$fe_sol			=	cambiarFecha($fe_sol, '-', '/' );
		$fe_aprob_d		=	cambiarFecha($fe_aprob_d, '-', '/' );
		$fe_aprob_g		=	cambiarFecha($fe_aprob_g, '-', '/' );
		if($fe_aprob_d == "00/00/0000"){$fe_aprob_d = "";}
		if($fe_aprob_g == "00/00/0000"){$fe_aprob_g = "";}
		
		echo("<tr bgcolor=$color class='txtnormal8' onDblClick='javascript:muestra($cod_sol)'; onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000')>");	
		
		echo"<td bgcolor='#ffc561'>&nbsp;<a href='#' onClick=\"abrirVentanaVariable('sol_rec.php?cod=$cod_sol', 'ventana', 'Solicitud de recursos')\"><img src='imagenes/edit.png' border='0' valign='top' alt='Modificar'/>&nbsp;</td>
									
									<td>&nbsp;$area_d</td>
									<td>&nbsp;<input name='campos[$cod_sol]' type='hidden' />$cod_sol</td>
									<td>&nbsp;$ods_sol</td>	
									<td>&nbsp;$cc_sol</td>
									<td>&nbsp;$fe_sol</td>
									<td>&nbsp;$hr_ing_sol</td>
									<td>&nbsp;$fe_aprob_d</td>
									<td>&nbsp;$fe_aprob_g</td>
									<td>&nbsp;&nbsp;$prof_sol</td>
									</tr>";
									
									if($color == "#ffffff"){ $color = "#ddeeee"; }
									else{ $color = "#ffffff"; }
		$i++;			
	}			
?>         
            <tr>
              <td colspan="10" align="center" class="txtnormaln"><label>
                <input name="Volver" type="submit" class="boton_volver" id="Volver" value="Volver" onclick="enviar('sol_rec.php');" />
                <input name="Volver3" type="submit" class="boton_actualizar" id="Volver3" value="Actualizar" /></label>              </td>
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
</form> 
</body>
</html>
