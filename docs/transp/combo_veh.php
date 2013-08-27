<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
 <head>
   <title>Destino</title>
 </head>
 <body>
 
 <?php   
	include('../inc/config_db.php'); 	// Incluimos archivo de configuracion de la conexion
	include('../inc/lib.db.php');		// Incluimos archivo de libreria de funciones PHP
  
 $vehiculo	= "------------------------------ Seleccione ------------------------------";
//*******************************************************************************************************
if ($_GET["accion"] == "carga_nombres4") {
  echo"<select name='c4' id='c4' style='width:350px;' onchange='CargarDatos(this.value)'>";
  
  	$sql_v  	= "SELECT DISTINCT tipo_veh FROM tb_vehiculos ORDER BY tipo_veh";
	
	$rsv 		= dbConsulta_combo($sql_v);
	$total_v  	= count($rsv);
	echo"<option value='$vehiculo'>$vehiculo</option>";
			
	for ($i = 0; $i < $total_v; $i++)
	{
		echo "<option value='".$rsv[$i]['tipo_veh']."'>".$rsv[$i]['tipo_veh']."</option>";
	}
  echo"</select>";
 exit();
}

?>

   </body>
</html>

