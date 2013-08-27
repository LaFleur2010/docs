<?php
	include ('../inc/config_db.php');
	require('../inc/lib.db.php');
	require('../inc/correos.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ingreso de repuestos</title>
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

function carga(rut, nom, mail, cargo)
{
    document.f.rut_resp.value 	= rut;
	document.f.nom_resp.value 	= nom;
	document.f.mail_resp.value	= mail;
	document.f.cargo_resp.value	= cargo;
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
	var cant_rep	= document.f.cant_rep.value;
	var fe_rep		= document.f.fe_rep.value;
	var guia_rep	= document.f.guia_rep.value;

	
	if(cant_rep != "")
	{
		if(fe_rep != "")
		{
			if(guia_rep != "")
			{
				return gen();

			}else{
				alert("Debe Ingresar Nº de guia de despacho cliente");
				document.f.guia_rep.focus();
				return false ;
			}
		}else{
			alert("Debe ingresar fecha de egreso");
			document.f.fe_rep.focus();
			return false ;
		}
	}else{
		alert("Debe Ingresar Cantidad");
		document.f.cant_rep.focus();
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

<table width="800" height="148" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="809" height="30" align="center" valign="top"><table width="798" height="30" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="70" height="30" align="center"><img src="../imagenes/logo_mgyt_c.jpg" width="70" height="30" border="0" /></td>
          <td width="660" align="center"><table width="302" border="0" cellpadding="0" cellspacing="0" class="txt01">
            <tr>
              <td width="308" align="center"><span class="Estilo3">INGRESO DE REPUESTO</span></td>
            </tr>
          </table></td>
          <td width="68" align="center"><img src="../imagenes/l_iso_c.jpg" width="68" height="27" /></td>
        </tr>
      </table>      
    </td>
  </tr>
  <tr>
    <td height="117" align="center" valign="top"> 
    <table width="462" height="117" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
      <tr>
        <td width="456" height="117" align="center" valign="middle">
            <form name="f" action="" method="POST">
          <table width="800" height="102" border="1" bordercolor="#FFFFFF" bgcolor="#cedee1">
            <tr>
              <td width="686" height="96" align="center" valign="top">
              
              <table width="798" height="97" border="0" cellpadding="1" cellspacing="1" class="txtnormal">      
                  <tr>
                    <td height="20" align="left" class="txtnormaln">Cant</td>
                    <td height="20" align="left" class="txtnormaln">Fecha</td>
                    <td height="20" align="left" class="txtnormaln">NOTA/OBSERVACION</td>
                    <td width="103" height="20" align="left" class="txtnormaln">Nº guia</td>
                    </tr>
                  <tr>
                    <td width="37" height="24" align="left">
                    <input name="cant_rep" type="text" id="cant_rep" size="5" />                    </td>
                    <td width="67" align="left">
                    <input name="fe_rep" type="text" id="fe_rep" size="10" onkeyup="this.value=formateafecha(this.value)"  />                    </td>
                    <td width="578" align="left">
                    <input name="nota_rep" type="text" id="nota_rep" size="80" />                    </td>
                    <td align="left">
                    <input name="guia_rep" type="text" id="guia_rep" size="12" />                    </td>
                    </tr>
                  <tr>
                    <td height="1" colspan="4" align="left"><label>
                      <input type="checkbox" name="EnvCorreo" id="EnvCorreo" />
                    Enviar correo de alerta a produccion</label></td>
<? 
$_POST['nom_resp'] = ucwords($_POST['nom_resp']);

	$_POST['fe_rep']	= cambiarFecha($_POST['fe_rep'], '/', '-' );
 if($_POST['fe_rep']	== ""){$_POST['fe_rep']  = "0000-00-00";}
 
 $cod_rep = $_GET['cod'];
//***********************************************************************************************************************
//                                INGRESO DE REGISTROS  											    
//***********************************************************************************************************************	
if($_POST['ingresa'] == "Ingresar")
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sqlc 	= "SELECT * FROM tb_repuestos WHERE cod_rep = '$cod_rep' ";
	$res 	= mysql_query($sqlc, $co);

	while($fila=mysql_fetch_array($res))
	{
		$cod_rep	= "".$fila['cod_rep']."";
		$nom_rep	= "".$fila['nom_rep']."";
		$cont_rep	= "".$fila['cont_rep']."";
		$stock_rep	= "".$fila['stock_rep']."";
	}	

	$sql = "INSERT INTO tb_detrep    (  cod_rep, 
										tipo_op, 
										cant_rep, 
										ods,
										fe_rep,
										nota_rep,
										guia_rep,
										ing_rep
										) 
								VALUES ('$cod_rep', 
										'Ingreso', 
										'".$_POST['cant_rep']."', 
										'".$_POST['ods_rep']."',
										'".$_POST['fe_rep']."',
										'".$_POST['nota_rep']."',
										'".$_POST['guia_rep']."',
										'".$_GET['usn']."'
										)";
	if(dbExecute($sql))
	{	 
		$nuevaCant = $stock_rep + $_POST['cant_rep'];
		
		$sqlUpd = "UPDATE tb_repuestos SET stock_rep = '$nuevaCant' WHERE cod_rep = '$cod_rep' ";
		dbExecute($sqlUpd);
		
		if($_POST['EnvCorreo'] == "on"){
			EnviaMsjRepuestos($cod_rep, $nom_rep, $cont_rep, $_POST['cant_rep'], $_POST['nota_rep'], $_POST['guia_rep'], $_GET['usn'], $fecha, $hora);
		}
		
		echo"<script language='Javascript'>
			window.opener.f.submit();
			window.close();
        </script>";
	}else{
		alert("El Ingreso A Fallado, favor vuelva a intentarlo");
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
?>
                  </tr>
                  <tr>
                    <td height="25" colspan="4" align="center" class="txtnormaln">
                    <input name="ingresa" type="submit" class="boton_ing" id="button3" value="Ingresar" onclick="return ingresar()" <?php echo $estado_b; ?>/>&nbsp; 
                    <input name="modifica" type="submit" class="boton_mod" id="button4" value="Modificar" onclick="return modifica()" /></td>
                  </tr>
              </table></td>
            </tr>
          </table><BR>
          </form></td>
      </tr>
    </table>    </td>
  </tr>
</table>
</body>
</html>