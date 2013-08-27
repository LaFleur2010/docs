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

function carga(cod, rut, nom)
{
    document.f.cod_Rpno.value = cod;
	document.f.rut_Rpno.value = rut;
	document.f.nom_Rpno.value = nom;
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
	rut_Rpno = document.f.rut_Rpno.value;
	
	if(rut_Rpno != "")
	{
		alert("No Se Puede Eliminar La Empresa Debido A Que Esta Asociada A Una Cotizacion");
		/*var agree=confirm("Esta Seguro de Querer Eliminar Este Registro ?");
		if (agree)
		{
			return true ;
		}else{
			return false ;
		}*/
	}else{
		alert("Debe Ingresar Rut de la Empresa a Eliminar");
		document.f.rut_Rpno.focus();
		return false ;
	}
}

function gen()
{
	var agree=confirm("Esta Seguro Que desea Ingresar La Empresa ?");
	if (agree){
		document.f.submit();
		return true ;
	}else{
		return false ;
	}
}

function ingresar()
{
	var rut_Rpno		= document.f.rut_Rpno.value;
	var nom_Rpno		= document.f.nom_Rpno.value;

	if(rut_Rpno != "")
	{
		if(nom_Rpno != "")
		{
			return gen();
		}else{
			alert("Debe Ingresar Nombre");
			document.f.nom_Rpno.focus();
			return false ;
		}
	}else{
		alert("Debe Ingresar Rut");
		document.f.rut_Rpno.focus();
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

<table width="469" height="238" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="463" height="30" align="center" valign="top"><table width="458" height="30" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="70" height="30" align="center"><img src="../imagenes/logo_mgyt_c.jpg" width="70" height="30" border="0" /></td>
          <td width="306" align="center"><table width="302" border="0" cellpadding="0" cellspacing="0" class="txt01">
            <tr>
              <td width="308" align="center">Responsable Plano</td>
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
                    <td height="18" align="left" class="txtnormaln"><input name="cod_Rpno" type="hidden" id="cod_Rpno" size="15" onchange="Valida_Rut(this)" value="<?php echo $cod_Rpno; ?>"/></td>
                    <td width="211" height="18" align="left" class="txtnormal8 Estilo9">Ejemplo: 77081930-K (sin puntos)</td>
                    <td width="120" height="18" align="left" class="txtnormaln"></td>
                  </tr>
                  <tr>
                    <td width="100" height="24" align="left">Rut:</td>
                    <td colspan="2" align="left">
                    	<input name="rut_Rpno" type="text" id="rut_Rpno" size="15" onchange="Valida_Rut(this)" value="<?php echo $rut_Rpno; ?>"/></td>
                  </tr>
                  <tr>
                    <td height="1" align="left">Nombre :</td>
                    <td colspan="2" align="left"><input name="nom_Rpno" type="text" id="nom_Rpno" size="40" value="<?php echo $nom_Rpno ?>" /></td>
                  </tr>
                  <tr>
                    <td height="12" colspan="3" align="center" class="txtnormaln">&nbsp;</td>
                    </tr>
                  <tr>
                    <td height="25" colspan="3" align="center" class="txtnormaln"><input name="ingresa" type="submit" class="boton_ing" id="button3" value="Ingresar" onclick="return ingresar()" <?php echo $estado_b; ?>/>
                      <input name="modifica" type="submit" class="boton_mod" id="button4" value="Modificar" onclick="return valida2()" />
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
            <td width="23%" class="txtnormaln">RUT</td>
            <td width="71%" class="txtnormaln">NOMBRE</td>
            <td width="6%" class="txtnormaln">&nbsp;</td>
            <? 
			$_POST['nom_Rpno'] = ucwords($_POST['nom_Rpno']);

//***********************************************************************************************************************
//                                INGRESO DE REGISTROS  											    
//***********************************************************************************************************************	

if($_POST['ingresa'] == "Ingresar")
{
	$sql = "INSERT INTO tb_responsable_pno (rut_Rpno, nom_Rpno) VALUES ('".$_POST['rut_Rpno']."', '".$_POST['nom_Rpno']."')";
	if(dbExecute($sql))
	{	
		alert("Los datos se ingresaron correctamente");
		echo"<script language='Javascript'>
			window.opener.CargarNombres4();
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
	$sqlu = "UPDATE tb_responsable_pno SET nom_Rpno = '".$_POST['nom_Rpno']."', rut_Rpno = '".$_POST['rut_Rpno']."'  WHERE cod_Rpno = '".$_POST['cod_Rpno']."' ";
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
	
	$sqld = "DELETE FROM tb_responsable_pno WHERE cod_Rpno = '".$_POST['cod_Rpno']."' ";
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
	
$sql		=	"SELECT * FROM tb_responsable_pno ORDER BY nom_Rpno";
$respuesta	=	mysql_query($sql,$co);
$color		=	"#FFFFFF";
$i			=	1;

while($vrows=mysql_fetch_array($respuesta))
{
	$cod_Rpno		= "".$vrows['cod_Rpno']."";
	$rut_Rpno		= "".$vrows['rut_Rpno']."";
	$nom_Rpno		= "".$vrows['nom_Rpno']."";
		
	echo("<tr bgcolor=$color onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'#ffffff','#000000') onclick='javascript:carga(\"$cod_Rpno\",\"$rut_Rpno\",\"$nom_Rpno\")';>	
									
		<td>&nbsp;".$vrows['rut_Rpno']."</td>
		<td>&nbsp;".$vrows['nom_Rpno']."</td>
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