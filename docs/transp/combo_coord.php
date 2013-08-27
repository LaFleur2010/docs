<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
 <head>
   <title>Destino</title>
 </head>
 <body>
 <?php 
	include('../inc/config_db.php'); 	// Incluimos archivo de configuracion de la conexion
	include('../inc/lib.db.php');		// Incluimos archivo de libreria de funciones PHP

 $destino	= "------------------------------ Seleccione ------------------------------";
//*******************************************************************************************************
if ($_GET["accion"] == "carga_nombres") {
  echo"<select name='c1' id='c1' style='width:350px;'>";
  
  	$sql  = "SELECT * FROM tb_coordinador ORDER BY nom_coord";
	
	$rs 	= dbConsulta_combo($sql);
	$total  = count($rs);
	echo"<option value='$destino'>$destino</option>";
			
	for ($i = 0; $i < $total; $i++)
	{
		echo "<option value='".$rs[$i]['cod_coord']."'>".$rs[$i]['nom_coord']."</option>";
	}
  echo"</select>";
 exit();
}

?>
</body>
</html>

