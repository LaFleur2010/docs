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


 $resp_pno	= "------------------------------ Seleccione ------------------------------";
//*******************************************************************************************************
if ($_GET["accion"] == "carga_nombres2") {
  echo"<select name='cbo_asig_area' id='cbo_asig_area' style='width:350px;'>";
  
  	$sql  = "SELECT * FROM tb_RespVehArea ORDER BY nom_rva";
	
	$rs 	= dbConsulta($sql);
	$total  = count($rs);
	echo"<option value='$resp_rva'>$resp_rva</option>";
			
	for ($i = 0; $i < $total; $i++)
	{
		echo "<option value='".$rs[$i]['cod_rva']."'>".htmlentities($rs[$i]['nom_rva'])."</option>";
	}
  echo"</select>";
 exit();
}

?>

   </body>
</html>

