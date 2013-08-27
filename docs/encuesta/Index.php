<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
if($_SESSION['Ingreso']=="si" && $_SESSION['tipo']== 1){
	echo "<script>location.href='encuesta.php';</script>";
}
?>
<html>
<head>

<title>
Encuesta Online
</title>

<link rel="stylesheet" type="text/css" href="estilo.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />

</head>
<body>
<center>
<div id="logo">
<img src="img/logo1.png" width="150">
</div>
</center>

<div id="login">	

<form name="login" action="login.php" method="post">	
<center>

<div style="border:0px solid #000; width:180px; margin-top:0px;">
<br>
<p>Inicio de Sesi&oacute;n</p>
<br>
<img src="img/users.png" width="40"></img>
<br>
<center>
Usuario
<br>
<input type="text" name="nick" value="">
<br>
Clave&nbsp;&nbsp;
<br>
<input type="password" name="pwd" value="">
</center>
<br>
<br>
<input type="submit" class="boton" name="ingresar" value="Ingresar">
<input type="reset"  class="boton" name="Cancelar" value="Cancelar">
</div>
<br style="clear:both;" />
</center>
</form>
<!-- este div me permite dejar el fondo blanco-->
<div id="fondo">	
</div>
<br style="clear:both;" />
</div>
<br style="clear:both;" />
<br>
<br><br>
<center><a href="http://intranet.softtime.cl">Intranet Softtime |</a></center>
<hr width="600">
<p class="copy">&copy; Desarrollado por Diego Fuentes Aceituno</p>
</body>
</html>