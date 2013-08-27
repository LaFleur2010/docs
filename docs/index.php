<? 
//Ejemplo si queremos que la página principal llame el formulario de validación
if (isset($_GET['estado'])){
	$est = $_GET['estado'];
	Header ("Location: i/index.php?estado=$est"); 
	exit;
}else{
	Header ("Location: i/index.php"); 
	exit;
}
?>