<?
	include('../inc/config_db.php'); 	// Incluimos archivo de configuracion de la conexion

 function conexion($serv, $usuario, $pass, $bd){
	if (!($link=mysql_connect("$serv","$usuario","$pass"))){
		die("Error conectando a la base de datos.");
	}
	if (!$link=mysql_select_db("$bd",$link)){ 
		die("Error seleccionando la base de datos.");
	}
	    return($link);
	
  }
$conecta 	= conexion($DNS,$USR,$PASS,$BDATOS);
$idcombo 	= $_POST["id"];
$action 	= $_POST["combo"];

switch($action){
	case "c4":{
		$res = mysql_query("SELECT * FROM tb_vehiculos WHERE tipo_veh = '$idcombo' ORDER BY pat_veh");
		
		echo"<option selected='---------------- Todos ----------------'>---------------- Todos ----------------</option>";
		
		while($rs = mysql_fetch_array($res))
			
			echo '<option value="'.$rs["pat_veh"].'">'.$rs["pat_veh"].'</option>';	
	break;
	}
}
?>