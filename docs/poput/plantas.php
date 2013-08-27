<?php
	include ('../inc/config_db.php');
	require('../inc/lib.db.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Responsables del Estudio</title>
<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">

<script type="text/javascript" language="JavaScript1.2" src="stmenu.js"></script>
<script type="text/javascript" language="JavaScript" src="../inc/funciones.js"></script>

<script LANGUAGE="JavaScript">

function CambiaColor(esto,fondo,texto)
{
    esto.style.background=fondo;
    esto.style.color=texto;
	esto.style.cursor='hand'
}

function carga(cod, id, nom)
{
    document.f.cod_pta.value 	= cod;
	document.f.c1.value 		= id;
	document.f.nom_pta.value 	= nom;
}

function mod()
{
var agree=confirm("Esta Seguro de Querer Modificar Este Registro ?");
if (agree)
	return true ;
else
	return false ;
}

function eliminar()
{
	cod_pta = document.f.cod_pta.value;
	
	if(cod_pta != "")
	{
		alert("No Se Puede Eliminar La Planta Debido A Que Esta Tiene Registros Asociados");
		/*var agree=confirm("Esta Seguro de Querer Eliminar Este Registro ?");
		if (agree)
		{
			return true ;
		}else{
			return false ;
		}*/
	}else{
		alert("Debe Ingresar Rut de la Empresa a Eliminar");
		document.f.cod_pta.focus();
		return false ;
	}
}

function gen()
{
	var agree=confirm("Esta Seguro Que desea Ingresar La Planta ?");
	if (agree){
		document.f.submit();
		return true ;
	}else{
		return false ;
	}
}

function ingresar()
{
	var c1			= document.f.c1.value;
	var nom_pta		= document.f.nom_pta.value;

	if(c1 != "")
	{
		if(nom_pta != "")
		{
			return gen();
		}else{
			alert("Debe Ingresar Nombre de la Planta a Ingresar");
			document.f.nom_pta.focus();
			return false ;
		}
	}else{
		alert("Debe Seleccionar Cliente al cual Pertenece la Planta");
		document.f.c1.focus();
		return false ;
	}
}
</SCRIPT>

<style type="text/css">
<!--
body {
	background-color: #999999;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo9 {color: #FF0000}
-->
</style>
</head>
<body> 

<table width="650" height="238" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="650" height="30" align="center" valign="top"><table width="641" height="38" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="75" height="38" align="center"><img src="../imagenes/logo_mgyt_c.jpg" width="70" height="37" border="0" /></td>
          <td width="498" align="center"><table width="407" height="21" border="0" cellpadding="0" cellspacing="0" class="txt01">
            <tr>
              <td width="407" align="center">Plantas</td>
            </tr>
          </table></td>
          <td width="68" align="center"><img src="../imagenes/l_iso_c.jpg" width="68" height="34" /></td>
        </tr>
      </table>      
    </td>
  </tr>
  <tr>
    <td height="140" align="center" valign="top"> 
    <table width="462" height="179" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
      <tr>
        <td width="456" height="153" align="center" valign="middle">
            <form name="f" action="" method="POST">
          <table width="637" height="138" border="1" bordercolor="#FFFFFF" bgcolor="#cedee1">
            <tr>
              <td width="627" height="132" align="center" valign="top"><table width="625" height="124" border="0" cellpadding="0" cellspacing="0" class="txtnormal">      
                  <tr>
                    <td height="18" align="left" class="txtnormaln"><input name="cod_pta" type="hidden" id="cod_pta" size="15" onchange="Valida_Rut(this)" value="<?php echo $cod_pta; ?>"/></td>
                    <td width="199" height="18" align="left" class="txtnormal8 Estilo9">&nbsp;</td>
                    <td width="314" height="18" align="left" class="txtnormaln"></td>
                  </tr>
                  <tr>
                    <td width="112" height="24" align="left">Cliente:</td>
                    <td colspan="2" align="left"><select name="c1" id="c1" style="width:420px;" onchange="CargarDatos(this.value)">
                      <?php
									$co=mysql_connect("$DNS","$USR","$PASS");
								
									$sql_c  	= "SELECT * FROM tb_clientes ORDER BY razon_s";
									$rs_c 		= dbConsulta($sql_c);
									$total_c  	= count($rs_c);
									echo"<option selected='selected' value='$cliente_pno'>$cliente_pno</option>";
											
									for ($i = 0; $i < $total_c; $i++)
									{
										$razon_s = $rs_c[$i]['razon_s'];
										if($razon_s != $nom){
											echo "<option value='".$rs_c[$i]['id_cli']."'>".$rs_c[$i]['razon_s']."</option>";
										}
									}
							?>
                    </select></td>
                  </tr>
                  <tr>
                    <td height="1" align="left">Nombre Planta:</td>
                    <td colspan="2" align="left"><input name="nom_pta" type="text" id="nom_pta" size="50" value="<?php echo $nom_pta ?>" /></td>
                  </tr>
                  <tr>
                    <td height="12" colspan="3" align="center" class="txtnormaln">&nbsp;</td>
                    </tr>
                  <tr>
                    <td height="25" colspan="3" align="center" class="txtnormaln">
                    <input name="ingresa" type="submit" class="boton_ing" id="button3" value="Ingresar" onclick="return ingresar()" <?php echo $estado_b; ?>/>&nbsp;
                    <input name="modifica" type="submit" class="boton_mod" id="button4" value="Modificar" onclick="return valida2()" />&nbsp;
                    <input name="elimina" type="button" class="boton_eli" id="button5" value="Eliminar" onclick="eliminar()" />&nbsp;
                    
                    </td>
                  </tr>
              </table></td>
            </tr>
          </table><BR>
          </form></td>
      </tr>
      <tr>
        <td height="25" align="center" valign="top"><table width="637" border="1" bordercolor="#FFFFFF" bgcolor="#cedee1" class="txtnormal2">
          <tr>
            <td width="9%" class="txtnormaln">CLIENTE</td>
            <td width="11%" class="txtnormaln">CODIGO</td>
            <td width="80%" class="txtnormaln">PLANTA</td>
            <? 
			$_POST['nom_pta'] = ucwords($_POST['nom_pta']);

//***********************************************************************************************************************
//                                INGRESO DE REGISTROS  											    
//***********************************************************************************************************************	

if($_POST['ingresa'] == "Ingresar")
{
	$sql = "INSERT INTO tb_plantas (id_cli, nom_pta) VALUES ('".$_POST['id_cli']."', '".$_POST['nom_pta']."')";
	if(dbExecute($sql))
	{	
		alert("Los datos se ingresaron correctamente");
		echo"<script language='Javascript'>
			window.opener.CargarNombres3();
			window.close();
        </script>";
	}else{
		alert("El Ingreso A Fallado");
	}
}
//**********************************************************************************************************************
//                 Modificar Registro   					
//**********************************************************************************************************************
if($_POST['modifica'] == "Modificar")
{ 
	$sqlu = "UPDATE tb_plantas SET nom_pta = '".$_POST['nom_pta']."', id_cli = '".$_POST['c1']."'  WHERE cod_pta = '".$_POST['cod_pta']."' ";
	if(dbExecute($sqlu))
	{
		alert("Los datos fueron modificados correctamente");
		echo"<script language='Javascript'>
			window.opener.CargarNombres3();
			window.close();
        </script>";
	}else{
		alert("La Modificacion A Fallado");
	}
}

//**********************************************************************************************************************
//                 Eliminar Archivo    					
//**********************************************************************************************************************
if($_POST['elimina'] == "Eliminar")
{ 
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sqld = "DELETE FROM tb_plantas WHERE cod_pta = '".$_POST['cod_pta']."' ";
	if(dbExecute($sqld))
	{
		alert("El responsable se elimino correctamente");
		echo"<script language='Javascript'>
			window.opener.CargarNombres3();
			window.close();
		</script>";
	}else{
		alert("La Operacion A Fallado");
	}
}

/***********************************************************************************************************************
					Cargar Datos
***********************************************************************************************************************/	
$co=mysql_connect("$DNS","$USR","$PASS");
mysql_select_db("$BDATOS", $co);
	
$sql		=	"SELECT * FROM tb_plantas ORDER BY nom_pta";
$respuesta	=	mysql_query($sql,$co);
$color		=	"#FFFFFF";
$i			=	1;

while($vrows=mysql_fetch_array($respuesta))
{
	$cod_pta		= "".$vrows['cod_pta']."";
	$id_cli			= "".$vrows['id_cli']."";
	$nom_pta		= "".$vrows['nom_pta']."";
		
	echo("<tr bgcolor=$color onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'#ffffff','#000000') onclick='javascript:carga(\"$cod_pta\",\"$id_cli\",\"$nom_pta\")';>	
									
		<td>&nbsp;".$vrows['id_cli']."</td>
		<td>&nbsp;".$vrows['cod_pta']."</td>
		<td>&nbsp;".$vrows['nom_pta']."</td>	
	</tr> ");
	$i++;
}	
?>
          </tr>
        </table></td>
      </tr>
    </table>    </td>
  </tr>
</table>
</body>
</html>