<?
  // No almacenar en el cache del navegador esta página.
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");             		// Expira en fecha pasada
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");		// Siempre página modificada
		header("Cache-Control: no-cache, must-revalidate");           		// HTTP/1.1
		header("Pragma: no-cache");                                   		// HTTP/1.0
?>
<html>
<head>
<? if (isset($_GET['estado'])){
		$url  = explode("?",$_SERVER['URL']);
		$host = $_SERVER['SERVER_NAME'];
		$pag  = $url[0];
	    print "<META http-equiv=REFRESH content=\"5; URL=http://$host$pag;\">";
} ?>
<title>Login de Usuarios</title>
<base target="_self">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	margin-top: 100px;
	background-image: url();
	background-color: #5a88b7;
}
-->
</style>

<script> 
function cerrarse(){ 
window.close() 
} 
</script>
 
</head>

<body onLoad="document.forms[0].user.focus()" leftmargin="0" rightmargin="0" bottommargin="0">
<table width="200" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#cedee1">
  <tr>
    <td align="center"><table width="439" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td width="129"><div align="left"><span class="botones"></span><span class="imputbox"></span><img src="../imagenes/logo_mgyt_c.jpg" width="100" height="52"><br>
          </div>
        <td width="203" align="center" valign="middle"><? if (!isset($_GET['estado'])){ //Entramos ?>
          <img src="../imagenes/Titulos/LOGIN.gif" width="200" height="37">
        
        <td width="107" valign="top"><div align="right"><img src="../imagenes/logo_iso_c.jpg" width="100" height="52"></div>
        </tr>
      <tr>
        <td height="196" colspan="3"><div align="center">
            <table width="400" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#C6D7FF">
              <tr>
                <td><table width=100% border=0 align="center" cellpadding="0" cellspacing="0" bordercolor="#C6D7FF">
                    <? //cargamos configuracion
		   include("lg_config.php");
		?>
                    <form action="../<?=$pag_inicial;?>" target="_top" method="post">
                      <tr>
                        <td colspan="3"><div align="center">
                            <table width="100%" border="0" cellspacing="0" cellpadding="5">
                              <tr valign="middle">
                                <td colspan="2" height="30"><div align="center">
                                  <?
                          // Mostrar error de Autentificaci&oacute;n.
                          include ("lg_errores.php");  //Contiene los mensajes de error
                          if (isset($_GET['error_login'])){
                              $error=$_GET['error_login'];
                          echo "<font color='#FF0000'>Error: $error_login_ms[$error]</font>";
                          }
                         ?>
                                </div></td>
                              </tr>
                              <tr>
                                <td width="39%"><div align="right"><font color="#0000f0">Usuario: </font></div></td>
                                <td width="61%"><div align="left">
                                    <input type="text" name="user" size="15">
                                </div></td>
                              </tr>
                              <tr>
                                <td width="39%"><div align="right"><font color="#0000f0">Password: </font></div></td>
                                <td width="61%"><div align="left">
                                    <input type="password" name="pass" size="15">
                                </div></td>
                              </tr>
                            </table>
                        </div></td>
                      </tr>
                      <tr valign="middle">
                        <td width="48%" height="48" align="right"><div align="right"><font face="Arial" color=black size=2>
                            <input name=submit type=submit value="  Ingresar  " bgcolor="#0099FF">
                          </font></div>
                            <div align="center">
                              <label></label>
                          </div></td>
                        <td width="5%">&nbsp;</td>
                        <td width="47%"><div align="left"><font face="Arial" color=black size=2>
                            <input type=button value="Cerrar" bgcolor="#0099FF" onClick="cerrarse()">
                        </font></div></td>
                      </tr>
                      <tr valign="middle">
                        <td height="25" colspan="3"><div align="center"></div></td>
                      </tr>
                    </form>
                </table></td>
              </tr>
            </table>
        </div>
        </tr>
      <tr>
        <td colspan="3"><? }else{  //Nos vamos
	print "<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sesi&oacute;n cerrada";
}?>
            <div align="left"></div>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
