<?php
	include ('../inc/config_db.php');
	require('../inc/lib.db.php');
	
	$cod_cargo = "...... Automatico ......";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cargos</title>
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


function limpiaCaja(esto)
{
	if(esto.value == "...... Automatico ......")
	{
		esto.value = "";
	}
}

function carga(rut, nom)
{
    document.f.cod_cargo.value = rut;
	document.f.nom_cargo.value = nom;
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
	cod_cargo = document.f.cod_cargo.value;
	
	if(cod_cargo != "")
	{
		var agree=confirm("Esta Seguro de Querer Eliminar Este Registro ?");
		if (agree)
		{
			return true ;
		}else{
			return false ;
		}
	}else{
		alert("Debe Ingresar codigo del cargo a Eliminar");
		document.f.cod_cargo.focus();
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
	var nom_cargo = document.f.nom_cargo.value;

	if(nom_cargo != "")
	{
		return gen();
	}else{
		alert("Debe Ingresar Descripcion del Cargo");
		document.f.nom_cargo.focus();
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
          <td width="70" height="30" align="center"><img src="../imagenes/logo_mgyt_c.jpg" alt="" width="70" height="30" border="0" /></td>
          <td width="306" align="center"><table width="302" border="0" cellpadding="0" cellspacing="0" class="txt01">
            <tr>
              <td width="308" align="center">Mantenedor de Cargos</td>
            </tr>
          </table></td>
          <td width="68" align="center"><img src="../imagenes/l_iso_c.jpg" width="68" height="27" /></td>
        </tr>
      </table>      
    </td>
  </tr>
  <tr>
    <td height="140" align="center" valign="top"> 
        
    <form name="f" action="" method="POST">

    <table width="462" height="179" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
      <tr>
        <td width="456" height="153" align="center" valign="middle">
            
          <table width="455" height="115" border="1" bordercolor="#FFFFFF" bgcolor="#cedee1">
            <tr>
              <td width="462" height="109" align="center" valign="top"><table width="431" height="102" border="0" cellpadding="0" cellspacing="0" class="txtnormal">      
                  <tr>
                    <td height="15" align="left" class="txtnormaln"></td>
                    <td width="211" height="15" align="left" class="txtnormal8 Estilo9">&nbsp;</td>
                    <td width="120" height="15" align="left" class="txtnormaln"></td>
                  </tr>
                  <tr>
                    <td width="100" height="22" align="left">Codigo:</td>
                    <td colspan="2" align="left">
                    	<input name="cod_cargo" type="text" id="cod_cargo" size="15" onfocus="limpiaCaja(this);" value="<?php echo $cod_cargo; ?>"/></td>
                  </tr>
                  <tr>
                    <td height="22" align="left">Nombre :</td>
                    <td colspan="2" align="left"><input name="nom_cargo" type="text" id="nom_cargo" size="40" value="<?php echo $nom_cargo ?>" /></td>
                  </tr>
                  <tr>
                    <td height="12" colspan="3" align="center" class="txtnormaln">&nbsp;</td>
                    </tr>
                  <tr>
                    <td height="22" colspan="3" align="center" class="txtnormaln"><input name="ingresa" type="submit" class="boton_ing" id="button3" value="Ingresar" onclick="return ingresar()" <?php echo $estado_b; ?>/>
                      <input name="modifica" type="submit" class="boton_mod" id="button4" value="Modificar" onclick="return valida2()" />
                      <input name="elimina" type="button" class="boton_eli" id="button5" value="Eliminar" onclick="eliminar()" /></td>
                  </tr>
              </table></td>
            </tr>
          </table><BR>
          </td>
      </tr>
      <tr>
        <td height="25" align="center" valign="top"><table width="450" border="1" bordercolor="#FFFFFF" bgcolor="#cedee1" class="txtnormal2">
          <tr>
            <td width="23%" class="txtnormaln">RUT</td>
            <td width="71%" class="txtnormaln">NOMBRE</td>
            <td width="6%" class="txtnormaln">&nbsp;</td>
            <? 
			$_POST['nom_cargo'] = ucwords($_POST['nom_cargo']);

//***********************************************************************************************************************
//                                INGRESO DE REGISTROS  											    
//***********************************************************************************************************************	

if($_POST['ingresa'] == "Ingresar")
{
	$sql = "INSERT INTO tb_cargos (nom_cargo) VALUES ('".$_POST['nom_cargo']."')";
	if(dbExecute($sql))
	{	
		alert("Los datos se ingresaron correctamente");
		echo"<script language='Javascript'>
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
	$sqlu = "UPDATE tb_cargos SET nom_cargo = '".$_POST['nom_cargo']."' WHERE cod_cargo = '".$_POST['cod_cargo']."' ";
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
		
	$query	= "SELECT cargo_t FROM trabajadores WHERE cargo_t = '".$_POST['cod_cargo']."' ";
	$result	= mysql_query($query,$co);
	$cant	= mysql_num_rows($result);
	if($cant==0)
	{
		$sqld = "DELETE FROM tb_cargos WHERE cod_cargo = '".$_POST['cod_cargo']."' ";
		if(dbExecute($sqld))
		{
			alert("El Cargo se elimino correctamente");
			echo"<script language='Javascript'>
				window.opener.CargarNombres();
				window.close();
			</script>";
		}else{
			alert("La eliminacion A Fallado");
		}
	}else{
		alert("La eliminacion A Fallado: El cargo esta asociado a un trabajador");
	}
}

/***********************************************************************************************************************
					Cargar Datos
***********************************************************************************************************************/	
$co=mysql_connect("$DNS","$USR","$PASS");
mysql_select_db("$BDATOS", $co);
	
$sql		=	"SELECT * FROM tb_cargos ORDER BY nom_cargo";
$respuesta	=	mysql_query($sql,$co);
$color		=	"#FFFFFF";
$i			=	1;

while($vrows=mysql_fetch_array($respuesta))
{
	$nom_cargo		= "".$vrows['nom_cargo']."";
	$cod_cargo		= "".$vrows['cod_cargo']."";
		
	echo("<tr bgcolor=$color onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'#ffffff','#000000') onclick='javascript:carga(\"$cod_cargo\",\"$nom_cargo\")';>	
									
		<td>&nbsp;".$vrows['cod_cargo']."</td>
		<td>&nbsp;".$vrows['nom_cargo']."</td>
		<td bgcolor='#cedee1'>&nbsp</td>	
	</tr> ");
	$i++;
}	
?>
          </tr>
        </table></td>
      </tr>
    </table>
    </form>
        
    </td>
  </tr>
</table>
</body>
</html>