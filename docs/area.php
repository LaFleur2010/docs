<?php
	include ('inc/config_db.php');
	require('inc/lib.db.php');
	$cod_ue = "Automatico"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mantenedor de Repuestos</title>

<link href="inc/bibliocss.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery.js"></script>

<script type="text/javascript" LANGUAGE="JavaScript">

function carga(cod_area, area, departamento, gerencia)
{
	document.fu.cod_ar.value 	= cod_area;
    document.fu.combo1.value 	= gerencia;
	document.fu.combo2.value 	= departamento;
	document.fu.desc_area.value = area;
}

function mod()
{
var agree=confirm("Esta Seguro de Querer Modificar Este Registro ?");
if (agree)
	return true ;
else
	return false ;
}

function eli()
{
var agree=confirm("Esta Seguro de Querer Eliminar Este Registro ?");
if (agree)
	return true ;
else
	return false ;
}

function ing()
{
	var combo1	= document.fu.combo1.value;
	var combo2	= document.fu.combo2.value;
	var desc_area	= document.fu.desc_area.value;
	var cod_ar	= document.fu.cod_ar.value;
	
	if(combo1 != "" && combo1 != "Seleccione...")
	{
		if(combo2 != "" && combo2 != "Seleccione...")
		{
			if(desc_area != "")
			{
				var agree=confirm("Esta Seguro de Querer Ingresar Este Registro ?");
				if (agree)
					return true ;
				else
					return false ;	
			}else{
					alert("Debe Ingresar descripcion");
					document.fu.desc_area.focus();
					return false ;
			}
		}else{
					alert("Debe seleccionar Departamento");
					document.fu.combo2.focus();
					return false ;
			}
	}else{
			alert("Debe seleccionar Gerencia");
			document.fu.combo1.focus();
			return false ;
		}
}

function CambiaColor(esto,fondo,texto)
 {
    esto.style.background=fondo;
    esto.style.color=texto;
 } 

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
</SCRIPT>

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #F1F1F1;
}
-->
</style>

    <style type="text/css" media="all">

    input, textarea {
        font: 12px Verdana, Arial, Helvetica, serif;
        border: #153244 1px solid;
        color: #000000;
        background-color: #FFFFFF;
        padding: 1px 3px 1px 3px;
    }

    select {
        font: 11px Verdana, Arial, Helvetica, serif;
        border: #153244 1px solid;
        color: #000000;
        background-color: #F2F2F2;
    }
.Estilo5 {color: #000000}
    </style>
</head>
<body>

<table width="475" height="193" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F1F1F1" class="txtnormal2">

  <tr>
    <td height="160" align="center" valign="top"><table width="420" height="173" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
      <tr>
        <td width="420" height="173" align="center" valign="top"><form name="fu" action="" method="POST">
            <table width="466" height="105" border="0">
              <tr>
                <td width="460" height="101" align="center" valign="top"><table width="458" border="0" cellpadding="1" cellspacing="0" class="txtnormal">
                    <tr>
                      <td width="79" align="left">&nbsp;</td>
                      <td width="375" align="left"><input name="cod_ar" type="hidden" id="cod_ar" size="10" value="<?php echo $cod_ar ?>" />
                        <label></label></td>
                    </tr>
                    <tr>
                      <td width="79" align="left">Gerencia
                        <? 
              if($_POST['combo1'] != "" ){$d_g = $_POST['combo1'];}
			  if($_POST['combo1'] == "" ){$d_g = "Seleccione..."; $c_g = "Seleccione...";}
			  ?></td>
                      <td align="left"><select name="combo1" class="combos" id="combo1" style="width: 250px;" >
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
                      </select></td>
                    </tr>
                    <tr>
                      <td width="79" align="left">Departamento</td>
                      <td align="left"><select name="combo2" class="combos" id="combo2" style="width: 250px;" >
                        <?php echo"<option selected='selected' value='$cod_dep'>$desc_dep</option>"; ?>
                      </select></td>
                    </tr>

                    <tr>
                      <td width="79" height="10" align="left">Descripcion</td>
                      <td align="left"><input name="desc_area" type="text" id="desc_area" size="50" value="<?php echo $desc_area ?>" /></td>
                    </tr>
                    <tr>
                      <td width="79" height="9" align="left">&nbsp;</td>
                      <td align="left">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="12" colspan="2" align="center"><input name="ingresa" type="submit" class="boton_ing" id="button3" value="Ingresar" onclick="return ing()" />
                          <input name="modifica" type="submit" class="boton_mod" id="button4" value="Modificar" onclick="return mod()" />
                          <input name="elimina" type="submit" class="boton_eli" id="button5" value="Eliminar" onclick="return eli()" /></td>
                    </tr>
                </table></td>
              </tr>
            </table>
          <table width="458" border="1" cellspacing="0" bordercolor="#CCCCCC" bgcolor="#5a88b7">
              <tr>
                <td width="7%" class="txtnormaln">EDIT</td>
                <td width="10%" class="txtnormaln">COD</td>
                <td width="41%" align="left" class="txtnormaln">&nbsp;DEPARTAMENTO</td>
                <td width="42%" align="left" class="txtnormaln">AREA</td>
                <?

$_POST['t2'] = ucwords($_POST['t2']);
/*********************************************************************************************************************
                               INGRESO DE REGISTROS  											    
**********************************************************************************************************************/
if($_POST['ingresa'] == "Ingresar")
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS",$co);
						
	$sql  = "SELECT desc_ar FROM tb_areas WHERE desc_ar = '".$_POST['desc_area']."' ";
	$resp = mysql_query($sql, $co);
	$cant = mysql_num_rows($resp);
	if($cant < 1)
	{
		$sql  = "INSERT INTO tb_areas (cod_dep, desc_ar) VALUES ('".$_POST['combo2']."', '".$_POST['desc_area']."')";
		if(dbExecute($sql))
		{	
			echo"<script language='Javascript'>
				window.parent.f.submit();
				window.close();
			</script>";
		}else{
			alert("El Ingreso a fallado");
		}
	}else{
			alert("El area ya se encuentraba ingresada");
		 }
}    
/********************************************************************************************************************                                
				MODIFICAR REGISTROS  											    
*********************************************************************************************************************/	

if($_POST['modifica'] == "Modificar")
{
	$sql="UPDATE tb_areas SET desc_ar='".$_POST['desc_area']."' WHERE cod_ar = '".$_POST['cod_ar']."' ";
	if(dbExecute($sql))
	{
		alert("La Modificacion se Realizo Correctamente");
		echo"<script language='Javascript'>
			window.parent.f.submit();
			window.close();
        </script>";
	}else{
		alert("La Modificacion a Fallado");
	}
	
}
//*******************************************************
//                 Eliminar Archivo    					*
//*******************************************************
if($_POST['elimina']=="Eliminar")
{ 	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sqlCons	= "SELECT cod_as FROM asistencia WHERE area_as = '".$_POST['cod_ar']."' ";
	$res		= mysql_query($sqlCons, $co);
	$cant		= mysql_num_rows($res);
	if($cant < 1)
	{
		$sqld="DELETE FROM tb_areas WHERE cod_ar= '".$_POST['cod_ar']."' ";
		if(dbExecute($sqld))
		{
			echo"<script language='Javascript'>
				window.parent.f.submit();
				window.close();
			</script>";
		}else{
			alert("La Eliminacion a Fallado");
		}
	}else{
		alert("¡No se puede eliminar el Area!   Tiene registros asociados a ella");
	}
}

/***********************************************************************************************************************

***********************************************************************************************************************/	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sql="SELECT * FROM tb_areas, tb_dptos WHERE tb_areas.cod_dep = tb_dptos.cod_dep ORDER BY desc_ar";
	$respuesta=mysql_query($sql,$co);
	$color="#FFFFFF";
	$i=1;
	while($vrows=mysql_fetch_array($respuesta))
	{
		$cod_ar		= "".$vrows['cod_ar']."";
		$desc_ar	= "".$vrows['desc_ar']."";
		$cod_dep	= "".$vrows['cod_dep']."";
		$cod_ger	= "".$vrows['cod_ger']."";
		
		echo("<tr bgcolor=$color  bordercolor='#CCCCCC'   onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'#ffffff','#000000')>	
				<td bgcolor='#cedee1' align='left'>
				<a href='#' onclick='carga(\"$cod_ar\", \"$desc_ar\", \"$cod_dep\", \"$cod_ger\")'><img src='imagenes/edit.png' border='0' valign='top' alt='Editar'/></a></td>
				<td>&nbsp;".$vrows['cod_ar']."</td>
				<td align='left'>&nbsp;".$vrows['desc_dep']."</td>
				<td align='left'>&nbsp;".$vrows['desc_ar']."</td>
				</tr> ");
		$i++;
		}	
?>
              </tr>
            </table>
          <br />
        </form></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>