<?php
include ('inc/config_db.php');
require('inc/lib.db.php');


$fe			= date("Y-m-d");
$id			= $_GET['ods'];
$usuario	= $_GET['usuario'];
$origen		= $_GET['origen'];
	
if($size>5242880)
{
	echo "error en tamaño de archivo > 5 MB";
	unlink($_FILES['uploadfile']['tmp_name']);
	exit;
}

/******************************************************************************************************************************
CONSULTAMOS SI LA PAGINA QUE NOS ENVIO ES LA DE ODS
******************************************************************************************************************************/
if($origen == "ODS"){

	$directorio	= "Carpetas ODS/";
	$uploaddir 	= './Carpetas ODS/'.$_GET['ods']."/"; 
	$file 		= $uploaddir . basename($_FILES['uploadfile']['name']); 
	$size 		= $_FILES['uploadfile']['size'];

	if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) 
	{ 
	
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS", $co);
		
		$query	= "SELECT * FROM documentos WHERE nom_doc='".$_FILES['uploadfile']['name']."' AND ruta_doc = '$directorio'";
		$result	= mysql_query($query,$co);
		$cant	= mysql_num_rows($result);
		if($cant==0)
		{
			$ejemplo	= substr($directorio,11,50); 	// cortamos la cadena original(quitamos el dir raiz)
			$tal		= explode("/",$ejemplo);		// cortamos la cadena hasta donde encuentre un slach
			$carp		= $tal[1];						// nos devuelve la carpeta base de la ruta
			$carpet 	= trim($carp); 					// eliminamos espacios en blanco al principio y final
				
			$dirc		= $directorio.$id."/".$_FILES['uploadfile']['name'];
			$direc		= $directorio.$id."/";
				
			if ( $_POST['ingenieria'] 	== "on" )	{ $nivel	= "1"; }
			if ( $_POST['produccion'] 	== "on" )	{ $nivel	= "5"; }
			if ( $_POST['supervidores'] == "on" )	{ $nivel	= "8"; }
			if ( $_POST['todos'] 		== "on" )	{ $nivel	= "10";}
				
			$sqli = "INSERT INTO documentos (ruta_doc, rutac_doc, carp_doc, nom_doc, nivel_doc, sub_por, fecha_sub) values('$direc', '$dirc', '".$_GET['ods']."', '".$_FILES['uploadfile']['name']."', '10', '".utf8_encode($_GET['usuario'])."', '$fe')";
	
			if(mysql_query($sqli,$co))
			{ 
				/*echo "<script language='Javascript'>
					actualiza();
					alert('mmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm');
				</script>";*/
					 
			}else{
				alert("Error al Subir Documento");
			} 
		} 
	
	  
	}else{
		echo "Error ".$_FILES['uploadfile']['error']." --- ".$_FILES['uploadfile']['tmp_name']." %%% ".$file."($size)";
	}
}
/******************************************************************************************************************************
CONSULTAMOS SI LA PAGINA QUE NOS ENVIO ES LA DE PLANOS
******************************************************************************************************************************/
if($origen == "PLANOS"){ 

	$directorio	= "IngresoPlanos/";
	$uploaddir 	= './Planos/IngresoPlanos/'.$_GET['ods']."/"; 
	$file 		= $uploaddir . basename($_FILES['uploadfile']['name']); 
	$size 		= $_FILES['uploadfile']['size'];

	if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) 
	{ 
	
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS", $co);
		
		$query	= "SELECT * FROM tb_docpno WHERE nom_docpno='".$_FILES['uploadfile']['name']."' AND ruta_docpno = '$directorio'";
		$result	= mysql_query($query,$co);
		$cant	= mysql_num_rows($result);
		if($cant==0)
		{
			$ejemplo	= substr($directorio,11,50); 	// cortamos la cadena original(quitamos el dir raiz)
			$tal		= explode("/",$ejemplo);		// cortamos la cadena hasta donde encuentre un slach
			$carp		= $tal[1];						// nos devuelve la carpeta base de la ruta
			$carpet 	= trim($carp); 					// eliminamos espacios en blanco al principio y final
				
			$dirc		= $directorio.$id."/".$_FILES['uploadfile']['name'];
			$direc		= $directorio.$id."/";
				
			if ( $_POST['ingenieria'] 	== "on" )	{ $nivel	= "1"; }
			if ( $_POST['produccion'] 	== "on" )	{ $nivel	= "5"; }
			if ( $_POST['supervidores'] == "on" )	{ $nivel	= "8"; }
			if ( $_POST['todos'] 		== "on" )	{ $nivel	= "10";}
				
			$sqli = "INSERT INTO tb_docpno (ruta_docpno, rutac_docpno, carp_docpno, nom_docpno, nivel_docpno, sub_por_docpno, fecha_sub_docpno) values('$direc', '$dirc', '".$_GET['ods']."', '".$_FILES['uploadfile']['name']."', '10', '".utf8_encode($_GET['usuario'])."', '$fe')";
	
			if(mysql_query($sqli,$co))
			{ 
				/*echo "<script language='Javascript'>
					actualiza();
					alert('mmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm');
				</script>";*/
					 
			}else{
				alert("Error al Subir Documento");
			} 
		} 
	
	  
	}else{
		echo "Error ".$_FILES['uploadfile']['error']." --- ".$_FILES['uploadfile']['tmp_name']." %%% ".$file."($size)";
	}
}

/******************************************************************************************************************************
CONSULTAMOS SI LA PAGINA QUE NOS ENVIO ES LA DE COTIZACIONES
******************************************************************************************************************************/
if($origen == "COT"){

	$directorio	= "Carpetas/";
	$uploaddir 	= './Licitaciones/Carpetas/'.$_GET['ods']."/"; 
	$file 		= $uploaddir . basename($_FILES['uploadfile']['name']); 
	$size 		= $_FILES['uploadfile']['size'];

	if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) 
	{ 
	
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS", $co);
		
		$query	= "SELECT * FROM documentos WHERE nom_doc='".$_FILES['uploadfile']['name']."' AND ruta_doc = '$directorio'";
		$result	= mysql_query($query,$co);
		$cant	= mysql_num_rows($result);
		if($cant==0)
		{
			$ejemplo	= substr($directorio,11,50); 	// cortamos la cadena original(quitamos el dir raiz)
			$tal		= explode("/",$ejemplo);		// cortamos la cadena hasta donde encuentre un slach
			$carp		= $tal[1];						// nos devuelve la carpeta base de la ruta
			$carpet 	= trim($carp); 					// eliminamos espacios en blanco al principio y final
				
			$dirc		= $directorio.$id."/".$_FILES['uploadfile']['name'];
			$direc		= $directorio.$id."/";
				
			if ( $_POST['ingenieria'] 	== "on" )	{ $nivel	= "1"; }
			if ( $_POST['produccion'] 	== "on" )	{ $nivel	= "5"; }
			if ( $_POST['supervidores'] == "on" )	{ $nivel	= "8"; }
			if ( $_POST['todos'] 		== "on" )	{ $nivel	= "10";}
				
			$sqli = "INSERT INTO documentos (ruta_doc, rutac_doc, carp_doc, nom_doc, nivel_doc, sub_por, fecha_sub) values('$direc', '$dirc', '".$_GET['ods']."', '".$_FILES['uploadfile']['name']."', '10', '".utf8_encode($_GET['usuario'])."', '$fe')";
	
			if(mysql_query($sqli,$co))
			{ 
				echo "<script language='Javascript'>
					actualiza();
					alert('mmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm');
				</script>";
					 
			}else{
				alert("Error al Subir Documento");
			} 
		} 
	
	  
	}else{
		echo "Error ".$_FILES['uploadfile']['error']." --- ".$_FILES['uploadfile']['tmp_name']." %%% ".$file."($size)";
	}
}


?>