<? 
//Ejemplo si queremos que la p�gina principal llame el formulario de validaci�n
if (isset($_GET['estado'])){
	$est = $_GET['estado'];
	Header ("Location: i/index.php?estado=$est"); 
	exit;
}else{
	Header ("Location: i/index.php"); 
	exit;
}
?>