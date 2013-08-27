<?
	$DNS		= "localhost";
	/*$USR		= "root";
	$PASS		= "mysqlpass";*/
	$USR		= "intrauser";
	$PASS		= "intranetmgyt";
	$BDATOS		= "rockmine";	

	$hora   	= date("H:i:s",strtotime("-1 hour"));
	//$hora   	= date("H:i:s");
	$fecha		= date("Y-m-d"); // FECHA DE HOY
	
	/*$ColorMotivo = "#bad868";
	$ColorFondo  = "#bad868";*/
	$ColorMotivo = "#5a88b7";
	$ColorFondo  = "#5a88b7";
	
	//$ColorMotivo = "#6396b9";
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS",$co);
	
	$op_nombre 	= "Juan Carlos Cruz Connell";
	$fono_emp 	= "(72) 481038 - 625311";
	$op_celular	= "77574732";
	$op_email	= "juan.cruz@softtimesa.com";
	
	// Carpeta en la cual se guardaran las solicitudes
	$carpeta_solicitudes = "Carpetas ODS/";
?>