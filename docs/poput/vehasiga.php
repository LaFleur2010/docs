<?php
	include ('../inc/config_db.php');
	require('../inc/lib.db.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Responsables de Vehiculo</title>
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

function carga(cod, nom, cargo, correo)
{
    document.f.cod_rveh.value 		= cod;
	document.f.nom_rveh.value 		= nom;
	document.f.cargo_rveh.value		= cargo;
	document.f.correo_rveh.value	= correo;
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
	rut_resp = document.f.rut_resp.value;
	
	if(rut_resp != "")
	{
		alert("No Se Puede Eliminar El Responsable Debido A Que Esta Asociado A Una Cotizacion");
		/*var agree=confirm("Esta Seguro de Querer Eliminar Este Registro ?");
		if (agree)
		{
			return true ;
		}else{
			return false ;
		}*/
	}else{
		alert("Debe Ingresar Rut de el Responsable a Eliminar");
		document.f.rut_resp.focus();
		return false ;
	}
}


function gen()
{
	var agree=confirm("Esta Seguro Que desea Ingresar el Responsable ?");
	if (agree){
		document.f.submit();
		return true ;
	}else{
		return false ;
	}
}

function ingresar()
{
	var rut_resp		= document.f.rut_resp.value;
	var nom_resp		= document.f.nom_resp.value;
	var cargo_resp		= document.f.cargo_resp.value;
	var mail_resp		= document.f.mail_resp.value;

	
	if(rut_resp != "")
	{
		if(nom_resp != "")
		{
			if(cargo_resp != "")
			{
				if(mail_resp != "")
				{
					return gen();

				}else{
					alert("Debe Ingresar Correo");
					document.form1.mail_resp.focus();
					return false ;
				return false ;
				}
			}else{
				alert("Debe Ingresar Cargo");
				document.f.cargo_resp.focus();
				return false ;
			}
		}else{
			alert("Debe Ingresar Nombre");
			document.f.nom_resp.focus();
			return false ;
		}
	}else{
		alert("Debe Ingresar Rut del Responsable");
		document.f.rut_resp.focus();
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
.Estilo3 {font-family: arial}
.Estilo9 {color: #FF0000}
-->
</style>
</head>
<body> 

<table width="469" height="238" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="463" height="30" align="center" valign="top"><table width="458" height="30" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="70" height="30" align="center"><img src="../imagenes/logo_mgyt_c.jpg" width="70" height="30" border="0" /></td>
          <td width="306" align="center"><table width="302" border="0" cellpadding="0" cellspacing="0" class="txt01">
            <tr>
              <td width="308" align="center"><span class="Estilo3">Responsables de Vehiculo</span></td>
            </tr>
          </table></td>
          <td width="68" align="center"><img src="../imagenes/l_iso_c.jpg" width="68" height="27" /></td>
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
          <table width="455" height="138" border="1" bordercolor="#FFFFFF" bgcolor="#cedee1">
            <tr>
              <td width="462" height="132" align="center" valign="top">
              
              <table width="431" height="123" border="0" cellpadding="0" cellspacing="0" class="txtnormal">      
                  <tr>
                    <td width="109" height="18" align="center" class="txtnormaln">
                    <input name="cod_rveh" type="hidden" id="cod_rveh" size="15" value="<?php echo $cod_rveh; ?>"/></td>
                    <td width="322" height="18" align="left" class="txtnormaln">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="1" align="left">Nombre :</td>
                    <td align="left"><input name="nom_rveh" type="text" id="nom_rveh" size="40" value="<?php echo $nom_rveh ?>" /></td>
                  </tr>
                  <tr>
                    <td height="6" align="left">Fono:</td>
                    <td height="6" align="left"><input name="cargo_rveh" type="text" id="cargo_rveh" size="40" value="<?php echo $cargo_rveh ?>" /></td>
                    </tr>
                  <tr>
                    <td height="6" align="left">Correo:</td>
                    <td height="6" align="left"><input name="mail_rveh" type="text" id="mail_rveh" size="40" value="<?php echo $mail_rveh ?>" /></td>
                  </tr>
                  <tr>
                    <td height="38" colspan="2" align="center" class="txtnormaln">
                    <input name="ingresa" type="submit" class="boton_ing" id="button3" value="Ingresar" onclick="return ingresar()" <?php echo $estado_b; ?>/> 
                    <input name="modifica" type="submit" class="boton_mod" id="button4" value="Modificar" onclick="return modifica()" />
                    <input name="elimina" type="button" class="boton_eli" id="button5" value="Eliminar" onclick="eliminar()" /></td>
                  </tr>
              </table></td>
            </tr>
          </table><BR>
          </form></td>
      </tr>
      <tr>
        <td height="25" align="center" valign="top"><table width="450" border="1" bordercolor="#FFFFFF" bgcolor="#cedee1" class="txtnormal2">
          <tr>
            <td width="23%" class="txtnormaln">CODIGO</td>
            <td width="71%" class="txtnormaln">NOMBRE</td>
            <td width="6%" class="txtnormaln">&nbsp;</td>
            <? 
			$_POST['nom_rveh'] = ucwords($_POST['nom_rveh']);

//***********************************************************************************************************************
//                                INGRESO DE REGISTROS  											    
//***********************************************************************************************************************	

if($_POST['ingresa'] == "Ingresar")
{
	$sql = "INSERT INTO tb_respVeh (cod_rveh, nom_rveh, cargo_rveh, correo_rveh) VALUES ('".$_POST['cod_rveh']."', '".$_POST['nom_rveh']."', '".$_POST['cargo_rveh']."', '".$_POST['correo_rveh']."')";
	if(dbExecute($sql))
	{	
		alert("Los datos se ingresaron correctamente");
		echo"<script language='Javascript' type='text/javascript'>
			window.opener.CargarNombres();
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
	$sqlu = "UPDATE tb_responsable SET nom_resp = '".$_POST['nom_resp']."', mail_resp = '".$_POST['mail_resp']."', cargo_resp = '".$_POST['cargo_resp']."' WHERE rut_resp = '".$_POST['rut_resp']."' ";
	if(dbExecute($sqlu))
	{
		alert("Los datos fueron modificados correctamente");
		echo"<script language='Javascript'>
			window.opener.CargarNombres();
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
	
	$sqld = "DELETE FROM tb_responsable WHERE rut_resp = '".$_POST['rut_resp']."' ";
	if(dbExecute($sqld))
	{
		alert("El responsable se elimino correctamente");
		echo"<script language='Javascript'>
			window.opener.CargarNombres();
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
	
$sql		=	"SELECT * FROM tb_respVeh ORDER BY nom_rveh";
$respuesta	=	mysql_query($sql,$co);
$color		=	"#FFFFFF";
$i			=	1;

while($vrows=mysql_fetch_array($respuesta))
{
	$cod_rveh		= "".$vrows['rut_resp']."";
	$nom_rveh		= "".$vrows['nom_resp']."";
	$cargo_resp		= "".$vrows['cargo_resp']."";
	$correo_rveh	= "".$vrows['correo_rveh']."";
		
	echo("<tr bgcolor=$color onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'#ffffff','#000000') onclick='javascript:carga(\"$cod_rveh\",\"$nom_rveh\",\"$cargo_rveh\",\"$correo_rveh\")';>	
									
		<td>&nbsp;".$vrows['cod_rveh']."</td>
		<td>&nbsp;".$vrows['nom_rveh']."</td>
		<td bgcolor='#cedee1'>&nbsp</td>	
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