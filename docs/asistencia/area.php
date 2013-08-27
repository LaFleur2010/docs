<?php
	include ('../inc/config_db.php');
	require('../inc/lib.db.php');
	$cod_ue = "Automatico"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mantenedor de areas</title>
<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">

<script LANGUAGE="JavaScript">

function carga(cod, area, dpto, c_d)
{
    document.fu.cod_ar.value 	= cod;
	document.fu.nom_rep.value 	= area;
	document.fu.c1.text 	= c_d;
	//document.fu.c_dpto.options[indice].text = dpto;
	document.fu.c1.value 	= area;
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
	var c_ger	= document.fu.c_ger.value;
	var c_dpto	= document.fu.c_dpto.value;
	var nom_rep	= document.fu.nom_rep.value;
	var cod_rep	= document.fu.cod_rep.value;
	
	if(c_ger != "" && c_ger != "Seleccione...")
	{
		if(c_dpto != "" && c_dpto != "Seleccione...")
		{
			if(nom_rep != "")
			{
				var agree=confirm("Esta Seguro de Querer Ingresar Este Registro ?");
				if (agree)
					return true ;
				else
					return false ;	
			}else{
					alert("Debe Ingresar descripcion");
					document.fu.nom_rep.focus();
					return false ;
			}
		}else{
					alert("Debe seleccionar Departamento");
					document.fu.c_dpto.focus();
					return false ;
			}
	}else{
			alert("Debe seleccionar Gerencia");
			document.fu.c_ger.focus();
			return false ;
		}
}

function CambiaColor(esto,fondo,texto)
 {
    esto.style.background=fondo;
    esto.style.color=texto;
	esto.style.cursor='hand';
 } 

</SCRIPT>

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #cedee1;
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

<table width="420" height="193" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F1F1F1" class="txtnormal2">
  <tr>
    <td width="420" height="27" align="center" valign="bottom">AREAS</td>
  </tr>
  
  <tr>
    <td height="160" align="center" valign="top"><table width="420" height="160" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
      <tr>
        <td width="420" height="160" align="center" valign="top"><form name="fu" action="" method="POST">
            <table width="420" height="105" border="0">
              <tr>
                <td width="410" height="101" align="center" valign="top"><table width="410" border="0" cellpadding="1" cellspacing="0" class="txtnormal">
                    <tr>
                      <td width="76" align="left">&nbsp;</td>
                      <td width="330" align="left"><input name="cod_ar" type="hidden" id="cod_ar" size="10" value="<?php echo $cod_rep ?>" />
                        <label></label></td>
                    </tr>
                    <tr>
                      <td width="76" align="left">Gerencia</td>
                      <td align="left">
                        <? 
              if($_POST['c_ger'] != "" ){$d_g = $_POST['c_ger'];}
			  if($_POST['c_ger'] == "" ){$d_g = "Seleccione..."; $c_g = "Seleccione...";}
			  ?>
                        
                        <select name="c_ger" id="c_ger" style="width: 210px;"  onchange="javascript:document.fu.submit()">
                        <?php
								$co=mysql_connect("$DNS","$USR","$PASS");
								mysql_select_db("$BDATOS", $co);
								
                              	$sql_g	= "SELECT * FROM tb_gerencia WHERE cod_ger = '$d_g' ";
								$res_g	= mysql_query($sql_g,$co);
								while($vrowsg=mysql_fetch_array($res_g))
								{
									$d_g	= "".$vrowsg['desc_ger']."";
									$c_g	= "".$vrowsg['cod_ger']."";
								}
								
								$sql  = "SELECT * FROM tb_gerencia ORDER BY desc_ger ";
	
								$rs 	= dbConsulta($sql);
								$total  = count($rs);
								
								echo"<option selected='selected' value='$c_g'>$d_g</option>";
										
								for ($i = 0; $i < $total; $i++)
								{
									$desc_ger = $rs[$i]['desc_ger'];
									if($d_g != $desc_ger){
										echo "<option value='".$rs[$i]['cod_ger']."'>".$rs[$i]['desc_ger']."</option>";
									}
								}
							?>
                      </select></td>
                    </tr>
                    <tr>
                      <td width="76" align="left">Departamento</td>
                      <td align="left"><select name="c_dpto" id="c_dpto" style="width: 210px;">
                        <?php
                              //*******************************************************************************************************
								$sql  = "SELECT * FROM tb_dptos WHERE cod_ger = '".$_POST['c_ger']."' ORDER BY desc_dep ";
	
								$rs 	= dbConsulta($sql);
								$total  = count($rs);
								echo"<option selected='selected' value='Seleccione...'>Seleccione...</option>";
										
								for ($i = 0; $i < $total; $i++)
								{
									$desc_dep = $rs[$i]['desc_dep'];
									if($usuario != $desc_dep){
										echo "<option value='".$rs[$i]['cod_dep']."'>".$rs[$i]['desc_dep']."</option>";
									}
								}
							?>
                      </select></td>
                    </tr>

                    <tr>
                      <td width="76" height="10" align="left">Descripcion</td>
                      <td align="left"><input name="nom_rep" type="text" id="nom_rep" size="53" value="<?php echo $nom_rep ?>" /></td>
                    </tr>
                    <tr>
                      <td width="76" height="9" align="left">&nbsp;</td>
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
          <table width="411" border="1" cellspacing="0" bordercolor="#CCCCCC" bgcolor="#5a88b7">
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
						
	$sql  = "SELECT desc_ar FROM tb_areas WHERE desc_ar = '".$_POST['nom_rep']."' ";
	$resp = mysql_query($sql, $co);
	$cant = mysql_num_rows($resp);
	if($cant < 1)
	{
		$sql  = "INSERT INTO tb_areas (cod_dep, desc_ar) VALUES ('".$_POST['c_dpto']."', '".$_POST['nom_rep']."')";
		if(dbExecute($sql))
		{	
			echo"<script language='Javascript'>
				window.opener.f.submit();
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
	$sql="UPDATE tb_areas SET desc_ar='".$_POST['nom_rep']."' WHERE cod_ar = '".$_POST['cod_ar']."' ";
	if(dbExecute($sql))
	{
		alert("La Modificacion se Realizo Correctamente");
		echo"<script language='Javascript'>
			window.opener.f.submit();
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
	
	$sqlCons="SELECT cod_as FROM asistencia WHERE area_as = '".$_POST['cod_ar']."' ";
	$res=mysql_query($sqlCons, $co);
	$cant=mysql_num_rows($res);
	if($cant < 1)
	{
		$sqld="DELETE FROM tb_areas WHERE cod_ar= '".$_POST['cod_ar']."' ";
		if(dbExecute($sqld))
		{
			echo"<script language='Javascript'>
				window.opener.f.submit();
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
		$desc_dep	= "".$vrows['desc_dep']."";
		$cod_dep	= "".$vrows['cod_dep']."";
		
		echo("<tr bgcolor=$color  bordercolor='#CCCCCC'   onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'#ffffff','#000000')>	
				<td bgcolor='#cedee1' align='left'>
				<a href='#' onclick='carga(\"$cod_ar\", \"$desc_ar\", \"$desc_dep\", \"$c_d\")'><img src='../imagenes/edit.png' border='0' valign='top' alt='Editar'/></a></td>
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