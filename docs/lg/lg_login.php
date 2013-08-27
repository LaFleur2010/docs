<?
  // No almacenar en el cache del navegador esta página.
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");             		// Expira en fecha pasada
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");		// Siempre página modificada
		header("Cache-Control: no-cache, must-revalidate");           		// HTTP/1.1
		header("Pragma: no-cache");                                   		// HTTP/1.0
?>
<html>
<head>
<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">
<? if (isset($_GET['estado'])){
		$url  = explode("?",$_SERVER['URL']);
		$host = $_SERVER['SERVER_NAME'];
		$pag  = $url[0];
	    print "<META http-equiv=REFRESH content=\"5; URL=http://$host$pag;\">";
} ?>
<title>Login de Usuarios</title>
<base target="_self">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<style type="text/css">
<!--
body {
	margin-top: 100px;
	background-image: url(../imagenes/fondo.jpg);
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
<table width="200" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#cedee1" background="../imagenes/login.jpg">
  <tr>
    <td align="center"><table width="430" height="247" border="0" align="center" cellpadding="0" cellspacing="0" class="txtnormaln">
      <tr>
        <td height="76" align="center" class="txtnormaln">
          <? if (!isset($_GET['estado'])){ //Entramos ?>        
      </tr>
      <tr>
        <td height="168"><div align="center">
        
        <fieldset>
        <legend class="txtnormaln">Validacion de usuario</legend>
        
           <table width=78% border=0 align="center" cellpadding="0" cellspacing="0" bordercolor="#C6D7FF" class="txtnormaln">
                    <? //cargamos configuracion
		   include ("lg_config.php");
		?>
                    <form action="../<?=$pag_inicial;?>" target="_top" method="post">
                      <tr>
                        <td height="102" valign="middle"><div align="center">
                          <table width="100%" height="92" border="0" cellpadding="5" cellspacing="0">
                      <tr valign="middle">
                                <td colspan="3" height="28" class="txtnormaln"><div align="center">
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
                                <td width="39%" align="right" class="txtnormaln">Usuario:</td>
                      <td width="30%"><div align="left">
                                    <input type="text" name="user" size="15">
                                </div></td>
                                <td width="31%" rowspan="2" align="center">&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="39%" align="right" class="txtnormaln">Pass:</td>
                      <td width="30%"><div align="left">
                                    <input type="password" name="pass" size="15">
                                </div></td>
                                </tr>
                            </table>
                        </div></td>
                      </tr>
                      <tr valign="middle">
                        <td height="24" align="center"><div>
                            <input name=submit type=submit value="  Ingresar  " bgcolor="#0099FF">
                          </div>
                            <div align="center">
                              <label></label>
                          </div></td>
                      </tr>
                      <tr valign="middle">
                        <td height="25" align="center"><span class="txtnormal3n">
                          <? }else{  //Nos vamos
	print "<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sesi&oacute;n cerrada";
}?>
                        </span></td>
                      </tr>
                    </form>
                </table>
              </fieldset>
        </div>        </tr>
      
    </table></td>
  </tr>
</table>
</body>
</html>
