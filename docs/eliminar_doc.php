<?
/**********************************************************************************************************************************
			NECESARIO PARA VER SI LA SESION ESTA ACTIVA O SI TIENE PERMISOS DE ACCESO
**********************************************************************************************************************************/
require("lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php
//
//Definimos el nivel de acceso  (esto es un bonus track para definir que ciertos usuarios puedan entrar a algunas paginas y a otras no)
// Si los usuarios normales tienen acceso=10, para que  accedan todos los usuarios le damos acceso mayor a 10.
$nivel_acceso =10;
if ($nivel_acceso < $_SESSION['usuario_nivel']){
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}
//Hasta aquí lo comun para todas las paginas restringidas
//*********************************************************************************************************************************
?>
<?php
//*********************************************************************************************************************************
	include('inc/config_db.php');	// CONECCION A LA BASE DE DATOS
	require('inc/lib.db.php');
	$fecha	= date("Y-m-d");		// FECHA DE HOY
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Procesa2</title>

<script language="javascript">
function Enviar()
{
	document.f2.submit();
}
</script>
</head>

<body>

<form id="feli" name="feli" method="post" action="<?php echo $_GET['dest']; ?>">

<?php
if($_GET['tipo'] == "plano"){
	$tabla = "tb_docpno";
	$campo = "id_docpno";
}else{
	 $tabla = "documentos";
	 $campo = "id_doc";
}

/***********************************************************************************************************************
		ELIMINAMOS EL DOCUMENTO
***********************************************************************************************************************/	 			
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);

		$sqld = "DELETE FROM $tabla WHERE $campo ='".$_GET['id']."' ";
		mysql_query($sqld,$co);
		
		if(dbExecute($sqld))
		{
			unlink($_GET['ruta']);
			echo"<input type='hidden' name='elimina' id='elimina' value='".$_GET['ods']."' />";
			echo "<script language='Javascript'>
		
           		alert('EL DOCUMENTO FUE ELIMINADO CORRECTAMENTE');
				document.feli.submit();
        	</script>";
		}else
			{ 
				echo"<input type='hidden' name='elimina' id='elimina' value='".$_GET['ods']."' />";
				echo "<script language='Javascript'>
		
           			alert('¡ERROR! Al Eliminar Archivo');
					document.feli.submit();
        		</script>";
			}
?>
  
</form>
</body>
</html>
