<?php
include('inc/config_db.php');
include('inc/lib.db.php');

$fecha_sub	= date("Y-m-d");

if($_GET['origen'] == "FACTURAS")
{
	$ext 			= substr($_FILES['uploadfile']['name'], strrpos($_FILES['uploadfile']['name'],'.'));
	$nombre			= $_GET['id'].$ext;
	$tipo 			= $_FILES['uploadfile']['type'];  // almaceno el tipo de archivo
	
	$directorio		= "Facturas/";
	$file 			= $directorio.$nombre; 
	$size 			= $_FILES['uploadfile']['size'];
	
	//aca controlo que el archivo subido sea JPG
	if($ext == ".pdf" or $ext == ".PDF" or $ext == ".Pdf")
	{		
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS", $co);
					
		$sql = "UPDATE tb_det_sol SET factura = '$file' WHERE id_det = ".$_GET['id'];
		echo $sql;	
		mysql_query($sql, $co);
		
		//esto es si la imagen no excedia el ancho
		$archivo = $directorio.$_FILES['uploadfile']['name'];
			
		//guardo el archivo original
		move_uploaded_file($HTTP_POST_FILES['uploadfile']['tmp_name'], $file);
	 
			//$muestra = "<img src=\"".$archivo."\">";
	} else {
		//$muestra = "el archivo no es JPG";
	}
}

?>