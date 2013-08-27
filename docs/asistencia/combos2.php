<?
include ('inc/config_db.php');

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
	case "c1":{
		$res = mysql_query("SELECT * FROM trabajadores WHERE area_t = '$idcombo' ORDER BY nom_t");
		
		echo"<option selected='---------------- Todos ----------------'>---------------- Todos ----------------</option>";
		
		while($rs = mysql_fetch_array($res))
			
			echo '<option value="'.$rs["rut_t"].'">'.$rs["nom_t"]." ".$rs["app_t"].'</option>';	
	break;
	}
}
?>