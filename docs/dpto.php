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
<link href="inc/bibliocss.css" rel="stylesheet" type="text/css"><script type="text/javascript" language="JavaScript1.2" src="stmenu.js"></script>

<LINK href="epoch_styles.css" type=text/css rel=stylesheet>
<SCRIPT src="epoch_classes.js" type=text/javascript></SCRIPT>

<script LANGUAGE="JavaScript">

function carga(cod, nom, ger)
{
    document.fu.cod_dep.value 	= cod;
	document.fu.nom_dep.value 	= nom;
	document.fu.c_ger.value 	= ger;
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
	var nom_dep	= document.fu.nom_dep.value;
	var cod_dep	= document.fu.cod_dep.value;
	
	if(c_ger != "")
	{
		if(nom_dep != "")
		{
			var agree=confirm("Esta Seguro de Querer Ingresar Este Registro ?");
			if (agree)
				return true ;
			else
				return false ;	
		}else{
				alert("Debe Ingresar descripcion");
				document.fu.nom_dep.focus();
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
 } 

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
    </style>
</head>
<body>

<table width="443" height="193" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F1F1F1" class="txtnormal2">

  <tr>
    <td height="160" align="center" valign="top"><table width="420" height="160" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
      <tr>
        <td width="420" height="160" align="center" valign="top"><form name="fu" action="" method="POST">
            <table width="434" height="105" border="0">
              <tr>
                <td width="428" height="101" align="center" valign="top"><table width="410" border="0" cellpadding="1" cellspacing="0" class="txtnormal">
                    <tr>
                      <td width="76" align="left">&nbsp;</td>
                      <td width="330" align="left"><input name="cod_dep" type="hidden" id="cod_dep" size="10" value="<?php echo $cod_dep ?>" /></td>
                    </tr>
                    <tr>
                      <td width="76" align="left">Gerencia</td>
                      <td align="left"><select name="c_ger" id="c_ger" style="width: 210px;" onchange="CargarDatos2(this.value)">
                        <?php
                              //*******************************************************************************************************
								$sql  = "SELECT * FROM tb_gerencia ORDER BY desc_ger ";
	
								$rs 	= dbConsulta($sql);
								$total  = count($rs);
								echo"<option selected='selected' value='$usuario'>$usuario</option>";
										
								for ($i = 0; $i < $total; $i++)
								{
									$desc_ger = $rs[$i]['desc_ger'];
									if($usuario != $desc_ger){
										echo "<option value='".$rs[$i]['cod_ger']."'>".$rs[$i]['desc_ger']."</option>";
									}
								}
							?>
                                                                  </select></td>
                    </tr>

                    <tr>
                      <td width="76" height="10" align="left">Descripcion</td>
                      <td align="left"><input name="nom_dep" type="text" id="nom_dep" size="53" value="<?php echo $nom_dep ?>" /></td>
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
          <table width="402" border="1" cellspacing="0" bordercolor="#CCCCCC" bgcolor="#5a88b7">
              <tr>
                <td width="7%" class="txtnormaln">EDIT</td>
                <td width="10%" class="txtnormaln">COD</td>
                <td width="83%" align="left" class="txtnormaln">&nbsp;NOMBRE</td>
                <?

$_POST['t2'] = ucwords($_POST['t2']);
/*********************************************************************************************************************
                               INGRESO DE REGISTROS  											    
**********************************************************************************************************************/
if($_POST['ingresa'] == "Ingresar")
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS",$co);
						
	$sql  = "SELECT desc_dep FROM tb_dptos WHERE desc_dep = '".$_POST['nom_dep']."' ";
	$resp = mysql_query($sql, $co);
	$cant = mysql_num_rows($resp);
	if($cant < 1)
	{
		$sql  = "INSERT INTO tb_dptos (cod_ger, desc_dep) VALUES ('".$_POST['c_ger']."', '".$_POST['nom_dep']."')";
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
			alert("El Repuesto ya se encuentra ingresado");
		 }
}    
/********************************************************************************************************************                                
				MODIFICAR REGISTROS  											    
*********************************************************************************************************************/	

if($_POST['modifica'] == "Modificar")
{
	$sql="UPDATE tb_dptos SET desc_dep = '".$_POST['nom_dep']."' WHERE cod_dep = '".$_POST['cod_dep']."' ";
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
	
	$sqlCons="SELECT cod_dep FROM tb_areas  WHERE cod_dep = '".$_POST['cod_dep']."' ";
	$res=mysql_query($sqlCons, $co);
	$cant=mysql_num_rows($res);
	if($cant < 1)
	{
		$sqld="DELETE FROM tb_dptos WHERE cod_dep = '".$_POST['cod_dep']."' ";
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
		alert("¡No se puede eliminar el Departamento!   Tiene Areas asociadas a el");
	}
}

/***********************************************************************************************************************

***********************************************************************************************************************/	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sql="SELECT * FROM tb_dptos ORDER BY desc_dep";
	$respuesta=mysql_query($sql,$co);
	$color="#FFFFFF";
	$i=1;
	while($vrows=mysql_fetch_array($respuesta))
	{
		$cod_dep	= "".$vrows['cod_dep']."";
		$desc_dep	= "".$vrows['desc_dep']."";
		$cod_ger	= "".$vrows['cod_ger']."";
		
		echo("<tr bgcolor=$color  bordercolor='#CCCCCC'   onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'#ffffff','#000000')>	
									<td bgcolor='#cedee1' align='left'><a href='#' onclick='carga(\"$cod_dep\", \"$desc_dep\", \"$cod_ger\")'><img src='imagenes/edit.png' border='0' valign='top' alt='Editar'/></a></td>
									<td>&nbsp;".$vrows['cod_dep']."</td>
									<td align='left'>&nbsp;".$vrows['desc_dep']."</td>
									</tr> ");
		$i++;
		}	
/*recargar(<?php echo $ods; ?>);*/
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