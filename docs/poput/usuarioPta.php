<?php
	include('../inc/config_db.php');
	require('../inc/lib.db.php');
	$cod_ue = "Automatico"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mantenedor de Usuarios</title>

<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">

<script LANGUAGE="JavaScript">
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
var agree=confirm("Esta Seguro de Querer Ingresar Este Registro ?");
if (agree)
	return true ;
else
	return false ;
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
	background-color: #999999;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>

  <style type="text/css"><!--
     body {scrollbar-3dlight-color:blue;
                scrollbar-arrow-color:#cedee1;
                scrollbar-track-color:silver;
                scrollbar-darkshadow-color:black;
                scrollbar-face-color:blue;
                scrollbar-highlight-color:;
                scrollbar-shadow-color:}
   --></style> 
</head>
<body> <!--Recarga la ventana madre al cerrar el pop-up (envia el Formulario)-->

<table width="469" height="186" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td width="463" height="40" align="center" valign="top"><table width="458" height="36" border="0">
        <tr>
          <td width="70" height="32" align="center"><a href="produccion.php"><img src="../imagenes/logo_mgyt_c.jpg" width="70" height="30" border="0" /></a></td>
          <td width="306" align="center"><table width="302" border="0" class="txt01">
            <tr>
              <td width="308" align="center">Usuarios</td>
            </tr>
          </table></td>
          <td width="68" align="center"><img src="../imagenes/logo_iso_c.jpg" width="68" height="27" /></td>
        </tr>
      </table>      
    </td>
  </tr>
  
  <tr>
    <td height="140" align="center" valign="top">
    
    <table width="462" height="138" border="0" class="txtnormal">
      <tr>
        <td width="456" height="134" align="center" valign="top">
        
            <form name="fu" action="" method="POST">
        
          <table width="456" border="1" bordercolor="#FFFFFF" bgcolor="#cedee1">
            <tr>
              <td width="462" height="141" align="center" valign="top"><table width="446" border="0">
                  <tr>
                    <td colspan="3" align="center" class="txtnormaln"><label></label>
                      </td>
                    </tr>
                  <tr>
                    <td colspan="3" align="center" class="txtnormaln">
<?php
 if($_POST['busca']== "Buscar")
 {
 	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sqlc="SELECT * FROM usuario_e WHERE cod_ue='".$_POST['t1']."' ORDER BY nom_ue";
	$respuesta=mysql_query($sqlc,$co);
	while($vrows=mysql_fetch_array($respuesta))
	{
		$nom_ue				="".$vrows['nom_ue']."";
		$cod_ue				="".$vrows['cod_ue']."";  	  							
	}
 }                
                    
                    
 ?></td>
                  </tr>
                  <tr>
                    <td width="74" align="right" class="txtnormaln">Codigo :
                    </td>
                    <td width="345" colspan="2" align="left"><label>
                      <input name="t1" type="text" id="t1" size="10" value="<?php echo $cod_ue ?>" />
                      <input name="busca" type="submit" class="boton_bus" id="busca" value="Buscar" />
                    </label></td>
                  </tr>
                  <tr>
                    <td height="2" align="right" class="txtnormaln">Nombre :</td> 
                    <td colspan="2" align="left"><label>
                    <input name="t2" type="text" id="t2" size="50" value="<?php echo $nom_ue ?>" />
                    </label></td>
                  </tr>
                  <tr>
                    <td height="12" colspan="3" align="center" class="txtnormaln">&nbsp;</td>
                    </tr>
                  <tr>
                    <td height="12" colspan="3" align="center" class="txtnormaln">
                    <input name="ingresa" type="submit" class="boton_ing" id="button3" value="Ingresar" onclick="return ing()" />
                    <input name="modifica" type="submit" class="boton_mod" id="button4" value="Modificar" onclick="return mod()" />
                    <input name="elimina" type="submit" class="boton_eli" id="button5" value="Eliminar" onclick="return eli()" /></td>
                  </tr>
              </table>
</td>
            </tr>
          </table>
          <table width="450" border="1" bordercolor="#FFFFFF" bgcolor="#0099FF" class="txtnormal2">
            <tr>
              <td width="7%" class="txtnormaln">ITEM</td>
              <td width="10%" class="txtnormaln">COD</td>
              <td width="83%" class="txtnormaln">&nbsp;NOMBRE</td>
<?

$_POST['t2'] = ucwords($_POST['t2']);
//***********************************************************************************************************************
//                                INGRESO DE REGISTROS  											    *
//***********************************************************************************************************************	

if($_POST['ingresa'] == "Ingresar")
{
	$sql="INSERT INTO usuario_e (nom_ue) VALUES ('".$_POST['t2']."')";
	if(dbExecute($sql))
	{
		alert("Ingreso Realizado Correctamente");
		echo"<script language='Javascript'>
			window.opener.CargarNombres2();
			window.close();
        </script>";
	}else{
		alert("El Ingreso a Fallado");
	}
	
}                     
	
	
/***********************************************************************************************************************                                
				MODIFICAR REGISTROS  											    
************************************************************************************************************************/	

if($_POST['modifica'] == "Modificar")
{
	$sql="UPDATE usuario_e SET nom_ue='".$_POST['t2']."' WHERE cod_ue = '".$_POST['t1']."' ";
	if(dbExecute($sql))
	{
		alert("La Modificacion se Realizo Correctamente");
		echo"<script language='Javascript'>
			window.opener.CargarNombres2();
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
	
	$sqlCons="SELECT usuario FROM contratos WHERE usuario = '".$_POST['t1']."' ";
	$res=mysql_query($sqlCons, $co);
	$cant=mysql_num_rows($res);
	if($cant < 1)
	{
		$sqld="DELETE FROM usuario_e WHERE cod_ue= '".$_POST['t1']."' ";
		if(dbExecute($sqld))
		{
			alert("El Usuario se Elimino Correctamente");
			echo"<script language='Javascript'>
				window.opener.CargarNombres2();
				window.close();
			</script>";
		}else{
			alert("La Eliminacion a Fallado");
		}
	}else{
		alert("¡No se puede eliminar el usuario!   Porque esta asociado a - ".$cant." - ODS");
	}
}

/***********************************************************************************************************************

***********************************************************************************************************************/	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sql="SELECT * FROM usuario_e ORDER BY cod_ue";
	$respuesta=mysql_query($sql,$co);
	$color="#FFFFFF";
	$i=1;
	while($vrows=mysql_fetch_array($respuesta))
	{
		$cod_ue		= "".$vrows['cod_ue']."";
		$nom_ue		= "".$vrows['nom_ue']."";
		
		echo("<tr bgcolor=$color   onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'#ffffff','#000000')>	
									<td bgcolor='#cedee1'><b>&nbsp;$i<b></td>
									<td>&nbsp;".$vrows['cod_ue']."</td>
									<td>&nbsp;".$vrows['nom_ue']."</td>
									</tr> ");
		$i++;
		}	

?>
            </tr>
          </table>
          <br>
            </form>
        
        </td>
      </tr>
    </table>    </td>
  </tr>
</table>
</body>
</html>