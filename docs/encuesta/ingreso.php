<?php session_start(); ?>
<?php
error_reporting(0);
include("inc/funcion.php");
$link = conectarse();

$pregun1 = $_POST['op'];
$pregun2 = $_POST['op1'];
$pregun3 = $_POST['op2'];
$pregun4 = $_POST['op3'];
$pregun5 = $_POST['op4'];
$pregun6 = $_POST['op5'];
$pregun7 = $_POST['op6'];
$local   = $_POST['Slist'];


if ($_SESSION['tipo'] == 1) {
	$sql ="INSERT INTO respuestas values('','1','1','$local','$pregun1'),
									    ('','1','2','$local','$pregun2'),
									    ('','1','3','$local','$pregun3'),
									    ('','1','4','$local','$pregun4'),
									    ('','1','5','$local','$pregun5'),
									    ('','1','6','$local','$pregun6'),
									    ('','1','7','$local','$pregun7')";
	mysql_query($sql,$link);

	echo "<script>alert('Datos guardados');</script>";
	echo "<script>location.href='encuesta.php';</script>";
}else{
	echo "<script>alert('Usted no dispone de este privilegio');</script>";
	echo "<script>location.href='encuesta.php';</script>";
}



?>