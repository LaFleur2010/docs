<?
// Necesario para ver si la session esta activa  o si se tiene permiso de accseso
require("lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php
//
//Definimos el nivel de acceso  (esto es un bonus track para definir que ciertos usuarios puedan entrar a algunas paginas y a otras no)
// Si los usuarios normales tienen acceso=10, para que  accedan todos los usuarios le damos acceso mayor a 10.
$nivel_acceso =12;
if ($nivel_acceso < $_SESSION['usuario_nivel']){
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}
/*********************************************************************************************************************************************************
//Hasta aquí lo comun para todas las paginas restringidas
*********************************************************************************************************************************************************/
	include('inc/config_db.php');
	include('inc/lib.db.php');
	include('inc/correos.php');
//********************************************************************************************************************************
	$trab 		= "--------- Seleccione ---------";
	$mot  		= "--------- Seleccione ---------";
	$est_dia  	= "Presente";
	$area 		= "-- Seleccione Area --";
	$fe   		= date("d/m/Y");
	$num		= 2;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cambio de clave</title>

<link href="inc/bibliocss.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="JavaScript" src="inc/funciones.js"></script>

<LINK href="inc/epoch_styles.css" type=text/css rel=stylesheet>
<SCRIPT src="inc/epoch_classes.js" type=text/javascript></SCRIPT>

<script language="javascript" src="js/jquery-1.2.6.min.js"></script>

<script language="JavaScript" type="text/javascript">

function enviar(url)
{
	document.formus.action = url;
}

function mod()
{
	var pass_ant		= document.formus.pass_ant.value;
	var nueva_pass		= document.formus.nueva_pass.value;
	var rep_nueva_pass	= document.formus.rep_nueva_pass.value;
	var usuario			= document.formus.usuario.value;
	var mail_usu		= document.formus.mail_usu.value;
	
	if(usuario != "" )
	{
		if(pass_ant != "" )
		{
			if(nueva_pass != "" )
			{
				if(rep_nueva_pass != "" )
				{
					if(rep_nueva_pass == nueva_pass )
					{
						if(mail_usu != "" )
						{
							var agree=confirm("Esta Seguro de Querer Modificar Este Registro ?");
							if (agree){
								return true ;
							}else{
								return false ;
							}
						}else{
							alert("Debe Ingresar Su Correo Electronico");
							document.formus.mail_usu.focus();
							return false ;
						}
					}else{
						alert("Debe repetir el mismo password");
						document.formus.rep_nueva_pass.value= "";
						document.formus.rep_nueva_pass.focus();
						return false ;
					}
				}else{
					alert("Debe repetir el mismo password");
					document.formus.rep_nueva_pass.focus();
					return false ;
				}
			}else{
				alert("Debe Ingresar Su Nueva Password");
				document.formus.nueva_pass.focus();
				return false ;
			}
		}else{
			alert("Debe Ingresar Su Password Actual");
			document.formus.pass_ant.focus();
			return false ;
		}
	}else{
		alert("Debe Ingresar Nombre De Usuario");
		document.formus.usuario.focus();
		return false ;
	}
}
</SCRIPT>

    <style type="text/css" media="all">

    .hide {
		font: bold 6px Verdana, Arial, Helvetica, serif;
        visibility: hidden;
        display: none;
    }

    div.row {
        display: table-row;
        clear: both;
        padding: 2px;
        vertical-align: top;
    }

    div.row div {
        display: table-cell;
        padding: 2px;
        vertical-align: middle;
        float:left;
        display: inline;
    }

    div.row div.title {
        display: table-cell;
        padding: 2px;
        margin: 2px;
        background-color: #527eab;
        font: bold 12px Verdana, Arial, Helvetica, serif;
        color: #153244;
        vertical-align: middle;
    }

    div.row div img{
        vertical-align: bottom;
        border:0px solid;
        padding-left: 1px;
    }

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
        background-color: #cedee1;
    }

body {
	background-color: #527eab;
	background-image: url();
}
.Estilo5 {color: #000000}
.Estilo6 {color: #FFFFFF}
.Estilo8 {font-size: 10px}
-->
    </style>
</head>


<body>
<?php
$usuario 	= $_SESSION['usuario_nombre'];
$login		= $_SESSION['usuario_login'];
$correo		= $_SESSION['usuario_correo'];

?>
<table width="944" height="367" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
  <tr>
    <td width="100" height="54" align="center" valign="top"><img src="imagenes/logo2.jpg" width="127" height="60" /></td>
    <td width="744" align="center" valign="middle" bgcolor="#FFFFFF" class="txt01">CAMBIO DE DATOS DE USUARIO</td>
    <td width="100" align="center" valign="top"><img src="imagenes/logo_iso_c.jpg" width="100" height="52" /></td>
  </tr>
  
  <tr>
    <td height="309" colspan="3" align="center" valign="top">
    <form action="" method="post" name="formus" id="formus">
    <table width="932" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="932" align="center"><table width="921" height="45" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor=<?php echo $ColorMotivo; ?> >
          <tr>
            <td align="right"><table width="905" height="60" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="95" height="60" align="right">
                  <input name="button8" type="submit" class="boton_volver" id="button8" value="Inicio" onclick="enviar('index2.php')" /></td>
                  <td width="193" align="right"></td>
                  <td width="99" align="right"></td>
                  <td width="99" align="right"></td>
                  <td width="99" align="right">&nbsp;</td>
                  <td width="99" align="center">&nbsp;</td>
                  <td width="102" align="center">&nbsp;</td>
                  <td width="102" align="center">&nbsp;</td>
                  <td width="17" align="right">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center"><table width="921" height="230" border="0">
          <tr>
            <td width="911" height="224" align="center" valign="top"><table width="551" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
              <tr>
                <td colspan="3" align="center" class="txtnormaln"><label></label>
                  <label></label>
                  <label><img src="i/images/usu.png" alt="" width="128" height="128" /></label></td>
              </tr>
              <tr>
                <td colspan="3" align="center" class="txtnormaln">Desde aqui puede modificar sus datos</td>
              </tr>
              <tr>
                <td colspan="3" align="center" class="txtnormaln">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="3" align="center" class="txt_rojo">los campos con <span class="txtrojo">(*)</span> son los que puede modificar</td>
              </tr>
              <tr>
                <td colspan="3" align="center" class="txtnormaln"><!--<input type="submit" name="consulta" value="Listar Todos los Usuarios" /> --></td>
              </tr>
              <tr>
                <td colspan="2" align="left" class="txtnormaln">&nbsp;</td>
                <td width="337" align="left">&nbsp;</td>
              </tr>
              <tr>
                <td width="41" align="left" class="txtnormaln">&nbsp;</td>
                <td width="173" align="left" class="txtnormaln">&nbsp;&nbsp;Nombre completo&nbsp;&nbsp;&nbsp;&nbsp;<span class="Estilo8">&nbsp;</span></td>
                <td align="left"><label>
                  <input name="nombre" type="text" class="txtnormal" id="nombre" size="40" value="<? echo $usuario ?>" onchange="Valida_Rut(this)" disabled="disabled" />
                </label>
                  <label>
                  <input name="nombre2" type="hidden" class="txtnormal" id="nombre2" size="40" value="<? echo $usuario ?>" />
                  </label></td>
              </tr>
              <tr>
                <td align="left" class="txtnormaln">&nbsp;</td>
                <td align="left" class="txtnormaln">&nbsp;&nbsp;Nombre de usuario <span class="txtrojo">(*)</span></td>
                <td align="left" style="color:#FF0000"><label>
                  <input name="usuario" type="text" class="txtnormal" id="textfield3" size="40" value="<? echo $login ?>" />
                </label></td>
              </tr>
              <tr>
                <td align="left" class="txtnormaln">&nbsp;</td>
                <td align="left" class="txtnormaln">&nbsp;&nbsp;Password actual <span class="txtrojo">(*)</span></td>
                <td align="left"><input name="pass_ant" type="password" class="txtnormal" id="textfield4" size="40" value="<? echo $pass_usua; ?>" /></td>
              </tr>
              <tr>
                <td rowspan="2" align="left" class="txtnormaln">&nbsp;</td>
                <td align="left" class="txtnormaln">&nbsp;&nbsp;Nuevo password <span class="txtrojo">(*)</span></td>
                <td align="left"><input name="nueva_pass" type="password" class="txtnormal" id="textfield3" size="40" />
                  <label></label></td>
              </tr>
              <tr>
                <td align="left" class="txtnormaln">&nbsp;&nbsp;Repita Nuevo password <span class="txtrojo">(*)</span></td>
                <td align="left"><input name="rep_nueva_pass" type="password" class="txtnormal" id="rep_nueva_pass" size="40" /></td>
              </tr>
              <tr>
                <td align="left" class="txtnormaln">&nbsp;</td>
                <td align="left" class="txtnormaln">&nbsp;&nbsp;Correo <span class="txtrojo">(*)</span></td>
                <td align="left"><label>
                  <input name="mail_usu" type="text" class="txtnormal" id="textfield4" size="40" onblur="isEmailAddress(this.value, this.name)" value="<? echo $correo; ?>" />
                </label></td>
              </tr>
              <tr>
                <td height="35" colspan="3" align="center" class="txtrojo">Al modificar sus datos, le llegara un correo de confirmacion con sus datos modificados</td>
                </tr>
              <tr>
                <td colspan="2" align="left" class="txtnormaln">&nbsp;</td>
                <td height="36" align="left"><input name="modifica" type="submit" class="boton_mod" id="button3" value="Modificar" onclick="return mod()" />
&nbsp;
<input name="limpia" type="submit" class="boton_lim" id="button6" value="Limpiar" onclick="limpia();" />
&nbsp;
<?php
/***********************************************************************************************************************
							MODIFICAMOS EL USUARIO
***********************************************************************************************************************/		
if($_POST['modifica'] == "Modificar")
{	
	$n_pass = md5($_POST['rep_nueva_pass']);
	
	$sql = "UPDATE tb_usuarios SET us_usuario = '".$_POST['usuario']."', us_pass = '$n_pass', us_correo = '".$_POST['mail_usu']."' WHERE us_id = '".$_SESSION['usuario_id']."' ";
	if(dbExecute($sql))
	{
/*******************************************************************************************
		SI EL REGISTRO SE MODIFICO CORRECTAMENTE ENVIAMOS CORREO CON LOS NUEVOS DATOS
*******************************************************************************************/
		EnviaMsjUsuario(utf8_decode($_POST['nombre2']), utf8_decode($_POST['usuario']), $_POST['rep_nueva_pass'], $_POST['mail_usu'], $sub, $tit);
/*******************************************************************************************
			SI EL REGISTRO SE MODIFICO CORRECTAMENTE ENVIAMOS MENSAJE
*******************************************************************************************/	
		echo "<script language='Javascript'>
		alert('Los datos fueron modificados correctamente');
		document.formus.action='lg/lg_logout.php';
		document.formus.submit();
		</script>";
//******************************************************************************************
	}else{
		echo "<script language='Javascript'>
		alert('¡ERROR! Al Modificar los datos de usuario');
		document.formus.submit();
		</script>";
	} 
}	
?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table>
     </form>
    </td>
  </tr>
  <tr>
    <td height="3" colspan="3" align="center" valign="top"><img src="imagenes/barra.gif" width="942" height="3" /></td>
  </tr>
</table>
</body>
</html>
