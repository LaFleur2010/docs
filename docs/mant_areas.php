<?
// Necesario para ver si la session esta activa  o si se tiene permiso de accseso
require("lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php

if($_SESSION['usd_sol_lee'] != "1")
{
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}//Hasta aquí lo comun para todas las paginas restringidas
//**********************************************************************************************************************************************************
	include('inc/config_db.php');
	include('inc/lib.db.php');
/**********************************************************************************************************************************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mantenedor de areas</title>

<link href="inc/bibliocss.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="JavaScript" src="inc/funciones.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>


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

<script language="JavaScript" type="text/javascript">

/* COMIENZAN FUNCIONES PARA COMBOS ANIDADOS */
/********************************************/
$(document).ready(function(){
	
	// Parametros para e combo1
   $("#combo1").change(function () {
   		$("#combo1 option:selected").each(function () {
			//alert($(this).val());
				elegido=$(this).val();
				$.post("combo1.php", { elegido: elegido }, function(data){
				$("#combo2").html(data);
				$("#combo3").html("");
			});			
        });
   })
	// Parametros para el combo2
	$("#combo2").change(function () {
   		$("#combo2 option:selected").each(function () {
			//alert($(this).val());
				elegido=$(this).val();
				$.post("combo2.php", { elegido: elegido }, function(data){
				$("#combo3").html(data);
			});			
        });
   })
});
/* TERMINAN FUNCIONES PARA COMBOS ANIDADOS */
/********************************************/

function enviar(url)
{
	document.f.action=url;
}

function repuestos(nombre, ancho, alto)
{
	abrirVentanac(nombre, ancho, alto,'no','yes');
}
</script>

<style type="text/css">
body {
	font-family: Helvetica;
	background-image: url();
	font-size: 11px;
	color: #000;
	background-color: <? echo $ColorFondo; ?>;
}

.Estilo8 {color: #FF0000}
.Estilo9 {color: #000000}

</style>

</head>
<body>
<table width="1010" height="367" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
  <tr bgcolor="#FFFFFF">
    <td width="100" height="54" align="center" valign="top"><img src="imagenes/logo2.jpg" width="127" height="60" /></td>
    <td width="810" align="center" valign="middle" class="txt01"><img src="imagenes/Titulos/Mant_areas.png" width="500" height="47" /></td>
    <td width="100" align="right" valign="top"><img src="imagenes/logo_iso_c.jpg" width="100" height="52" /></td>
  </tr>
  
  <tr>
    <td height="309" colspan="3" align="center" valign="top">
    <form action="" method="post" name="f" id="f">
    <table width="1008" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1003" align="center">
        
        <table width="1006" height="45" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor=<?php echo $ColorMotivo; ?> >
          <tr>
            <td width="970" align="right">
            
            <table width="990" height="67" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="92" height="67" align="right"><input name="Volver2" type="submit" class="boton_volver" id="Volver2" value="Volver" onclick="enviar('index2.php');" /></td>
                  <td width="99" align="center"><input name="Volver4" type="submit" class="boton_actualizar" id="Volver4" value="Actualizar" /></td>
                  <td width="222" align="center">&nbsp;</td>
                  <td width="83" align="right"></td>
                  <td width="88" align="right">&nbsp;</td>
                  <td width="100" align="right">&nbsp;</td>
                  <td width="84" align="center">&nbsp;</td>
                  <td width="100" align="center">&nbsp;</td>
                  <td width="94" align="right"><input name="button4" type="button" class="boton_print" id="button2" value="Vista impresion" onclick="Vista_Impresion_FSR()" /></td>
                  <td width="21" align="right">
                  <input type="hidden" name="usuario_nombre" id="usuario_nombre" value="<?php echo $_SESSION['usuario_nombre']; ?>" /></td>
                </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center">
        
        <table width="1006" height="45" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#cedee1">
          <tr>
            <td width="1004" height="224" align="center" valign="top">
            
            <table width="981" height="259" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="3" rowspan="2">&nbsp;</td>
                    <td width="11" align="left" class="txtnormal">&nbsp;</td>
                    <td align="left" class="txtnormal">&nbsp;</td>
                    <td width="44" rowspan="2" align="left" class="txtnormal"><span class="content"> </span></td>
                    <td width="306" align="left" class="txtnormal"><label></label></td>
                    <td width="21" align="left" class="txtnormal">&nbsp;</td>
                    <td width="332" align="left" class="txtnormal"><label></label></td>
                  </tr>
                  <tr>
                    <td align="left" class="txtnormal">&nbsp;</td>
                    <td align="left" class="txtnormal">GERENCIA</td>
                    <td width="306" align="left" class="txtnormal">DEPARTAMENTO</td>
                    <td colspan="2" align="left" class="txtnormal">AREA</td>
                    </tr>
                  <tr>
                    <td width="3">&nbsp;</td>
                    <td height="58" align="left" class="txtnormal">&nbsp;</td>
                    <td colspan="2" align="left" valign="middle" class="txtnormal7">
                    
                    <select name="combo1" size="14" id="combo1" style="width: 300px;" >
                      <?php
                              //*******************************************************************************************************
								$sql  = "SELECT cod_ger, desc_ger FROM tb_gerencia ORDER BY desc_ger ";
	
								$rs 	= dbConsulta($sql);
								$total  = count($rs);
								echo"<option selected='selected' value='$cod_ger'>$desc_ger</option>";
										
								for ($i = 0; $i < $total; $i++)
								{
									$desc_ger = $rs[$i]['desc_ger'];
									if($sel != $desc_ger){
										echo "<option value='".$rs[$i]['cod_ger']."'>".$rs[$i]['desc_ger']."</option>";
									}
								}
							?>
                    </select>
                    </td>
                    
                    <td align="left" valign="middle" class="txtnormal7">
                    
                    <select name="combo2" size="14" id="combo2" style="width: 300px;" >
                      <?php echo"<option selected='selected' value='$cod_dep'>$desc_dep</option>"; ?>
                    </select>
                    
                    </td>
                    
                    <td colspan="2" align="left" valign="middle" class="txtnormal7">
                      <select name="combo3" size="14" id="combo3" style="width: 350px;">
                        <?php echo"<option selected='selected' value='$cod_ar'>$area_t</option>"; ?>
                        </select>
                    </td>
                    </tr>
                  <tr>
                    <td width="3" rowspan="2">&nbsp;</td>
                    <td height="24" rowspan="2" align="left" class="txtnormal">&nbsp;</td>
                    <td width="262" align="left" class="txtnormal"><label></label></td>
                    <td rowspan="2" align="left" class="txtnormal">&nbsp;</td>
                    <td width="306" align="left" class="txtnormal"><label></label></td>
                    <td width="21" rowspan="2" align="left" class="txtnormal">&nbsp;</td>
                    <td width="332" align="left" class="txtnormal">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" class="txtnormal"><span class="txtnormal3n">
                      <input type="button" class="boton_nue2" value="Mantenedor" onclick="abrirVentanaFija('gerencia.php', 450, 500, 'ventana', 'Mantenedor De Gerencias')" />
                    </span></td>
                    <td width="306" align="left" class="txtnormal"><span class="txtnormal3n">
                      <input type="button" class="boton_nue2" value="Mantenedor"  onclick="abrirVentanaFija('dpto.php', 500, 500, 'ventana', 'Mantenedor De Departamentos')" />
                    </span></td>
                    <td width="332" align="left" class="txtnormal"><span class="txtnormal3n">
                      <input type="button" class="boton_nue2" value="Mantenedor"  onclick="abrirVentanaFija('area.php', 540, 500, 'ventana', 'Mantenedor De Areas')" />
                    </span></td>
                  </tr>
                  <tr>
                    <td width="3" height="22">&nbsp;</td>
                    <td colspan="6" rowspan="3" align="center" valign="top" class="txtnormal"><?php


if($_POST['limpia'] != "Limpiar" and $_POST['ingresa'] != "Ingresar" )
{
	$i				= 0;
	$cont_det	 	= count($det_as);
/*************************************************************************************
			COMENZAMOS EL WHILE DE TRABAJADORES POR SECCION
********************************************************************************************************************************/
//encab();
$color = "#ffffff";	
	while($i < $cont_det)
	{
		$cod_det_as			= $det_as[$i]['cod_det_as'];
		$rut_det_as			= $det_as[$i]['rut_det_as'];
		$estado_det_as 		= $det_as[$i]['estado_det_as'];
		$motivo_det_asv 	= $det_as[$i]['motivo_det_as'];
		$observ_det_as 		= $det_as[$i]['observ_det_as'];
		$num                = ($i + 1);
		
		if($estado_det_as == "Presente" )
		{
			$check1	= "checked";
		}else{
			$check1	= "";
		}
		if($estado_det_as == "Ausente" )
		{
			$check2	= "checked";
		}else{
			$check2	= "";
		}
		
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS", $co);
		
		$sql_u = "SELECT * FROM trabajadores WHERE rut_t = '$rut_det_as' ";
		$rest=mysql_query($sql_u,$co);
		
		while($vrowst=mysql_fetch_array($rest))
		{
			$nom_trab	= $vrowst['nom_t'];
			$app_trab	= $vrowst['app_t'];
			$apm_trab 	= $vrowst['apm_t'];
			
			filanm($num, $cod_det_as, $nom_trab, $app_trab, $apm_trab, $rut_det_as, $estado_det_as, $motivo_det_asv, $observ_det_as, $check1, $check2, $color, $cod_as);
			
			if($color == "#ffffff"){ $color = "#ededed"; }
			else{ $color = "#ffffff"; }
		}
		$i++;
	}
//fin();
}
?>
                      <div id="resultado"></div>
                      <br /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="15">&nbsp;</td>
                  </tr>
                </table>             
            
            <br/></td>
          </tr>
        </table></td>
      </tr>
    </table>
     </form>
    </td>
  </tr>
  <tr>
    <td height="3" colspan="3" align="center" valign="top"><img src="imagenes/barra.gif" width="990" height="3" /></td>
  </tr>
</table>
</body>
</html>
