<?php
function conectarse(){
	if(!($link = mysql_connect("localhost","intrauser","intranetmgyt"))){
		echo "error al conectarse al servidor";
		exit();
	}
	if(! mysql_select_db("encuesta",$link)){
		echo "error en la base datos";
		exit();
	}
	return $link;
}

$link = Conectarse();
?>

<?php
	
/*
***************************************
funciones para estadisticas kokodrilo
***************************************
*/

function fn_total_encuestados($cuestionario)
{
	$con = mysql_connect("localhost","intrauser","intranetmgyt");
	mysql_select_db("encuesta",$con);

	$sql = "SELECT COUNT(id) as numero FROM respuestas WHERE cuestionario_id='".$cuestionario."' and local_id = '1'";
	$rs = mysql_query($sql,$con);
	$id = mysql_fetch_array($rs);

	$numero = $id['numero'] /7;
	return $numero;
}

function fn_ultimo_numero($cuestionario)
{
	$con = mysql_connect("localhost","intrauser","intranetmgyt");
	mysql_select_db("encuesta",$con);

	$sql = "SELECT COUNT(id) as numero FROM respuestas WHERE cuestionario_id='".$cuestionario."'";
	$rs = mysql_query($sql,$con);
	$id = mysql_fetch_array($rs);

	$numero = $id['numero'] /7;
	$numero++;

	return $numero;
}

function fn_cantidades($pregunta_id)
{
	$con = mysql_connect("localhost","intrauser","intranetmgyt");
	mysql_select_db("encuesta",$con);

	for($x=1;$x<=5;$x++)
	{
		$q = "SELECT count(id) as cantidad from respuestas where opcion='".$x."' and pregunta_id='".$pregunta_id."' and local_id ='1'";
		$r = mysql_query($q,$con);

		while ($row = mysql_fetch_array($r)) {
			$cantidad[$x] = $row['cantidad'];

			//suponiendo que pregunta_id=1
			//retorna cantidad de respuesta de la cada opcion, de la pregunta 1
			//$cantidad[1] = 4
			//$cantidad[2] = 2
			//$cantidad[3] = 8
			//$cantidad[4] = 0
			//$cantidad[5] = 1

		}
	}

	return $cantidad;
}

function fn_porc_opcion($total, $cantidad_opcion)
{
	$porcentaje = $cantidad_opcion *  100 / $total;
	return round($porcentaje,1);
}

function fn_total_preguntas($cuestionario)
{
	$con = mysql_connect("localhost","intrauser","intranetmgyt");
	mysql_select_db("encuesta",$con);

	$q = "SELECT count(id) as cantidad from preguntas where cuestionario_id='".$cuestionario."'";
	$r = mysql_query($q,$con);

	while ($row = mysql_fetch_array($r)) {
		$total = $row['cantidad'];
	}

	return $total;
}

?>

<?php

/*
***************************************
funciones para estadisticas silvana
***************************************
*/

function fn_total_encuestados2($cuestionario)
{
	$con = mysql_connect("localhost","intrauser","intranetmgyt");
	mysql_select_db("encuesta",$con);

	$sql = "SELECT COUNT(id) as numero FROM respuestas WHERE cuestionario_id='".$cuestionario."' and local_id = '2'";
	$rs = mysql_query($sql,$con);
	$id = mysql_fetch_array($rs);

	$numero = $id['numero'] /7;
	return $numero;
}


function fn_cantidades2($pregunta_id)
{
	$con = mysql_connect("localhost","intrauser","intranetmgyt");
	mysql_select_db("encuesta",$con);

	for($x=1;$x<=5;$x++)
	{
		$q = "SELECT count(id) as cantidad from respuestas where opcion='".$x."' and pregunta_id='".$pregunta_id."' and local_id ='2'";
		$r = mysql_query($q,$con);

		while ($row = mysql_fetch_array($r)) {
			
			$cantidad[$x] = $row['cantidad'];

		}
	}

	return $cantidad;
}


?>
