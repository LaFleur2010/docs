<?php
	include ('../inc/config_db.php');
	require('../inc/lib.db.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Responsables del Estudio</title>
<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">

<script type="text/javascript" language="JavaScript1.2" src="stmenu.js"></script>

<script LANGUAGE="JavaScript">

function CambiaColor(esto,fondo,texto)
{
    esto.style.background=fondo;
    esto.style.color=texto;
	esto.style.cursor='hand'
}

function carga(rut, nom)
{
    document.f.rut_resp.value = rut;
	document.f.nom_resp.value = nom;
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
	var agree=confirm("Esta Seguro de Querer ingresar Este Registro ?");
	if (agree)
		return true ;
	else
		return false ;
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
.Estilo8 {color: #000000}
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
              <td width="308" align="center">Empresa del Servicio</td>
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
              <td width="462" height="132" align="center" valign="top"><table width="431" height="124" border="0" cellpadding="0" cellspacing="0" class="txtnormal">      
                  <tr>
                    <td height="18" colspan="3" align="center" class="txtnormaln"></td>
                  </tr>
                  <tr>
                    <td width="71" height="24" align="left">Rut:</td>
                    <td width="742" colspan="2" align="left">
                    	<input name="rut_emps" type="text" id="rut_resp" size="15" value="<?php echo $rut_emps; ?>"/></td>
                  </tr>
                  <tr>
                    <td height="1" align="left">Nombre :</td>
                    <td colspan="2" align="left"><input name="nom_emps" type="text" id="textfield" size="40" value="<?php echo $nom_emps ?>" /></td>
                  </tr>
                  <tr>
                    <td height="12" colspan="3" align="center" class="txtnormaln">&nbsp;</td>
                    </tr>
                  <tr>
                    <td height="25" colspan="3" align="center" class="txtnormaln">
                    <input name="ingresa" type="submit" class="boton_ing" id="button3" value="Ingresar" onclick="return valida()"<?php echo $estado_b; ?>/>
                    <input name="modifica" type="submit" class="boton_mod" id="button4" value="Modificar" onclick="return valida2()" />
                    <input name="elimina" type="submit" class="boton_eli" id="button5" value="Eliminar" onclick="return eli()" /></td>
                  </tr>
              </table></td>
            </tr>
          </table><BR>
          </form></td>
      </tr>
      <tr>
        <td height="25" align="center" valign="top"><table width="450" border="1" bordercolor="#FFFFFF" bgcolor="#cedee1" class="txtnormal2">
          <tr>
            <td width="23%" class="txtnormaln">RUT</td>
            <td width="71%" class="txtnormaln">NOMBRE</td>
            <td width="6%" class="txtnormaln">&nbsp;</td>
            <? 
			$_POST['nom_emps'] = ucwords($_POST['nom_emps']);

//***********************************************************************************************************************
//                                INGRESO DE REGISTROS  											    
//***********************************************************************************************************************	

if($_POST['ingresa'] == "Ingresar")
{
	$sql = "INSERT INTO tb_empresaserv VALUES ('".$_POST['rut_emps']."', '".$_POST['nom_emps']."')";
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
	$sqlu = "UPDATE tb_empresaserv SET nom_emps = '".$_POST['nom_emps']."' WHERE rut_emps = '".$_POST['rut_emps']."' ";
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
	
	$sqld = "DELETE FROM tb_empresaserv WHERE rut_emps = '".$_POST['rut_emps']."' ";
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
	
$sql		=	"SELECT * FROM tb_empresaserv ORDER BY nom_emps";
$respuesta	=	mysql_query($sql,$co);
$color		=	"#FFFFFF";
$i			=	1;

while($vrows=mysql_fetch_array($respuesta))
{
	$rut_emps		= "".$vrows['rut_emps']."";
	$nom_emps		= "".$vrows['nom_emps']."";
		
	echo("<tr bgcolor=$color onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'#ffffff','#000000') onclick='javascript:carga(\"$rut_emps\",\"$nom_emps\")';>	
									
		<td>&nbsp;".$vrows['rut_emps']."</td>
		<td>&nbsp;".$vrows['nom_emps']."</td>
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