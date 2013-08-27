<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
 <head>
   <title>titulo</title>
 </head>
 <body>
 <?php 
/************************************************************************************
 Función para Consultar
************************************************************************************/
function dbConsulta($sql){

    $db_conexion = mysql_connect("localhost", "intrauser", "intranetmgyt"); 
    mysql_select_db("produccion");
    $res = array();
    $consulta  = mysql_query($sql);// or die(header ("Location:  $redir?error_login=1"));
	if ($consulta) {
		if (mysql_num_rows($consulta) != 0) {
	     	// almacenamos datos del Usuario en un array para empezar a chequear.
			while ($row = mysql_fetch_assoc($consulta)) {
	            $res[] = $row;  // $var=[2][nombrecampo];
			}
	    }else{
			 $res = Null;
		}
		 // liberamos la memoria usada por la consulta, ya que tenemos estos datos en el Array.
		mysql_free_result($consulta);	
	}else{
		echo "ERROR: Conexion o Consulta a Base de Datos";
	}
	unset($consulta);
	// cerramos la Base de dtos.
    mysql_close($db_conexion);
	
	return($res);
}


 $razon_s	= "------------------------------ Seleccione ------------------------------";
//*******************************************************************************************************
if ($_GET["accion"] == "carga_nombres") {
  echo"<select name='c1' id='c1' style='width:350px;'>";
  
  	$sql  = "SELECT * FROM tb_clientes ORDER BY razon_s";
	
	$rs 	= dbConsulta($sql);
	$total  = count($rs);
	echo"<option value='$razon_s'>$razon_s</option>";
			
	for ($i = 0; $i < $total; $i++)
	{
		echo "<option value='".$rs[$i]['rut_cli']."'>".htmlentities($rs[$i]['razon_s'])."</option>";
	}
  echo"</select>";
 exit();
}

?>

   </body>
</html>

