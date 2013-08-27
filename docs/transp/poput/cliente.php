<?php
	include ('../licitaciones/funciones/conexion.php');
	require('../licitaciones/funciones/librerias.php');
	
	$clientecampo		= $_GET['clientecampo'];
	$numerocliente		= $_GET['numerocliente'];
	$numerocliente 		= "Automatico";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Mantenedor de Clientes</title>

<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">

<script type="text/javascript" language="JavaScript1.2" src="funciones/stmenu.js"></script>

<script LANGUAGE="JavaScript">

function CambiaColor(esto,fondo,texto)
 {
    esto.style.background=fondo;
    esto.style.color=texto;
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
function valida()
{
	var t2 = document.fitem.t2.value;
	if(t2 != "" && t2 != " " && t2 != "  " && t2 != "   " && t2 != "_" && t2 != " _")
	{
		return ing();
	}else
	{
		alert("DEBE INGRESAR EL CLIENTE");
		document.fitem.t2.focus();
		return false;
	}
}
function valida2()
{
	var t2 = document.fitem.t2.value;
	if(t2 != "" && t2 != " " && t2 != "  " && t2 != "   " && t2 != "_" && t2 != " _")
	{
		return mod();
	}else
	{
		alert("EL CAMPO DEL CLIENTE NO PUEDE ESTAR VACIO");
		document.fitem.t2.focus();
		return false;
	}
}
function visi()
{
	fitem.t3.style.visibility = "hidden";
}
</SCRIPT>

<style type="text/css">
<!--
body {
	background-color: #527eab;
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
<body onload="return visi()"> 

<table width="800" height="205" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="535" height="30" align="center" valign="top"><table width="798" height="36" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="70" height="36" align="center"><img src="../imagenes/MGYT.jpg" width="70" height="36" /></td>
          <td width="658" align="center"><table width="302" border="0" cellpadding="0" cellspacing="0" class="txt01">
            <tr>
              <td width="308" align="center"><span class="Estilo3">Mantenedor de Clientes</span></td>
            </tr>
          </table></td>
          <td width="70" align="center"><img src="../imagenes/l_iso_c.jpg" width="70" height="30" /></td>
        </tr>
      </table>      
    </td>
  </tr>
  <tr>
    <td height="169" align="center" valign="top">
    
    <table width="462" height="169" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
      <tr>
        <td width="456" height="143" align="center" valign="middle">
            <form name="fitem" action="" method="POST">
          <table width="798" height="203" border="1" bordercolor="#FFFFFF" bgcolor="#cedee1">
            <tr>
              <td width="516" height="197" align="center" valign="top"><table width="740" height="193" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
                  
                  <tr>
                    <td width="71" height="19" align="left">&nbsp;</td>
                    <td colspan="2" align="left"><span class="txtnormaln">
                      <?php
 if($_POST['busca']== "Buscar")
 {
 	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sqlc 		= "SELECT * FROM cliente WHERE numerocliente='".$_POST['t1']."' ORDER BY clientecampo";
	$respuesta	= mysql_query($sqlc,$co);
	while($vrows= mysql_fetch_array($respuesta))
	{
		$clientecampo		= "".$vrows['clientecampo']."";
		$numerocliente		= "".$vrows['numerocliente']."";  	  							
	}
	$estado_b = "disabled";
 }    
 if($_POST['refresh'] == "Refresh")
 {
 	$_POST['t2'] == "";
 }            
 ?>
                      </span></td>
                  </tr>
                  <tr>
                    <td width="71" height="24" align="left">Codigo : </td>
                    <td colspan="2" align="left"><label for="textfield5"></label>
                      <input name="textfield5" type="text" id="textfield5" size="12" />                      <input name="busca" type="submit" class="boton_bus" id="busca" value="Buscar" /></td>
                  </tr>
                  <tr>
                    <td height="22" align="left">Rut:</td>
                    <td colspan="2" align="left"><label for="textfield6"></label>
                      <input type="text" name="textfield6" id="textfield6" /></td>
                  </tr>
                  <tr>
                    <td height="1" align="left">Nombre</td>
                    <td colspan="2" align="left"><input name="t2" type="text" id="textfield" value="<?php echo $clientecampo ?>" size="70" /></td>
                  </tr>
                  <tr>
                    <td height="1" align="left">Direccion:</td>
                    <td colspan="2" align="left"><label for="textfield2"></label>
                      <input name="textfield2" type="text" id="textfield2" size="40" /></td>
                  </tr>
                  <tr>
                    <td height="1" align="left">Fono:</td>
                    <td colspan="2" align="left"><input name="textfield" type="text" id="textfield3" size="40" /></td>
                  </tr>
                  <tr>
                    <td height="12" align="left" class="txtnormaln">Fono 2:</td>
                    <td width="366" height="12" align="left" class="txtnormaln"><input name="textfield3" type="text" id="textfield4" size="40" /></td>
                    <td width="303" height="12" align="center" class="txtnormaln">&nbsp;</td>
                    </tr>
                  <tr>
                    <td height="40" colspan="3" align="center" class="txtnormaln"><input name="ingresa" type="submit" class="boton_ing" id="button3" value="Ingresar" onclick="return valida()"<?php echo $estado_b; ?>/>
                      <input name="modifica" type="submit" class="boton_mod" id="button4" value="Actualizar" onclick="return valida2()" /></td>
                  </tr>
              </table></td>
            </tr>
          </table><BR>
          </form>        </td>
      </tr>
      <tr>
        <td height="25" align="center" valign="top"><table width="798" border="0" cellpadding="1" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CEDEE1" class="txtnormal2">
          <tr>
            <td width="8%" class="txtnormaln">EDIT</td>
            <td width="9%" class="txtnormaln">COD</td>
            <td width="76%" class="txtnormaln">&nbsp;NOMBRE</td>
            <td width="7%" class="txtnormaln">ELIM</td>
            <? 

$_POST['t2'] = ucwords($_POST['t2']);

//***********************************************************************************************************************
//                                INGRESO DE REGISTROS  											    
//***********************************************************************************************************************	

if($_POST['ingresa'] == "Ingresar")
{
	$SqlIng = "INSERT INTO cliente (clientecampo) VALUES ('".$_POST['t2']."')";
	if(dbExecute($SqlIng))
	{
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
	$sqlu = "UPDATE cliente SET clientecampo='".$_POST['t2']."' WHERE numerocliente='".$_POST['t3']."' ";
	if(dbExecute($sqlu))
	{
		echo"<script language='Javascript'>
			window.opener.CargarNombres();
			window.close();
        </script>";
	}else{
		alert("La Modificacion A Fallado");
	}
	echo "<script language = 'javascript'>
		alert('Datos Modificados Correctamente');
		</script>";
}
//**********************************************************************************************************************
//                 Eliminar Archivo    					
//**********************************************************************************************************************
if($_POST['elimina'] == "Eliminar")
{ 
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sqlCons = "SELECT clientecampo FROM ingreso WHERE clientecampo = '".$_POST['t2']."' ";
	$res  = mysql_query($sqlCons, $co);
		$sqld = "DELETE FROM cliente WHERE numerocliente= '".$_POST['t3']."' ";
		if(dbExecute($sqld))
		{
			echo"<script language='Javascript'>
				window.opener.CargarNombres();
				window.close();
			</script>";
		}else{
			alert("La Operacion A Fallado");
		}
		echo "<script language = 'javascript'>
		alert('Datos Eliminados Correctamente');
		</script>";	
}

/***********************************************************************************************************************
								/Cargar Datos
***********************************************************************************************************************/	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sql="SELECT * FROM cliente ORDER BY clientecampo";
	$respuesta=mysql_query($sql,$co);
	$color="#FFFFFF";
	$i=1;
	while($vrows=mysql_fetch_array($respuesta))
	{
		$numerocliente		= "".$vrows['numerocliente']."";
		$clientecampo		= "".$vrows['clientecampo']."";
		
		echo("<tr bgcolor=$color   onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'#ffffff','#000000') align='left'>	
									<td bgcolor='#cedee1'><b>&nbsp;$i<b></td>
									<td>&nbsp;".$vrows['numerocliente']."</td>
									<td>&nbsp;".$vrows['clientecampo']."</td>	
									</tr> ");
		$i++;
		}	

?>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>