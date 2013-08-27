<?php session_start(); ?>
<?php
include("inc/funcion.php");
$link = conectarse();

$nick = $_POST['nick'];
$pwd  = md5($_POST['pwd']);

$sql = "SELECT * FROM usuarios where nick = '$nick' and password = '$pwd'";
$rs  = mysql_query($sql,$link);


if($row = mysql_fetch_array($rs)){
	$tipo = $row["tipo"];
}
if(mysql_num_rows($rs)!= 0){
	
	if($row[2]==$pwd && $row[1]==$nick){
	
		$_SESSION['nick']=$row[1];
		$_SESSION['password']=$row[2];
		$_SESSION['tipo']=$row[4];
		$_SESSION['nombre']=$row[3];
		$_SESSION['Ingreso']="si";
	}

	if($tipo == 1 || $tipo == 2){
		echo "<script>location.href='encuesta.php';</script>";
	
	}
	}else{
		echo "<script language='javascript'>alert('Error  Usuario o Contrasena')</script>";
		echo "<script>location.href='Index.php';</script>";
	}
	

?>