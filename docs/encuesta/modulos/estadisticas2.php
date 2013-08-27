<?php
session_start();
?>
<form action="" method="POST">
<input type="submit" onclick="" class="boton1" name="btn" value="Esdsdsdstadisticas Kokodrilo">

<?php

if ($_POST['btn']) {

$total = "SELECT count(numero) as porciento from encuestas where local=1 ";
$rs1 = mysql_query($total,$link);

while ($row = mysql_fetch_array($rs1)) {
	$Porciento = $row['porciento'];
}

//PREGUNTA 1	
$sql = "SELECT count(preg1) as pregunta1
		FROM encuestas 
		WHERE (local = 1) and (preg1 = 1)";
$rs = mysql_query($sql,$link);

while ($row = mysql_fetch_array($rs)) {
	$pregunta1 = $row['pregunta1'];

}

$pre = $pregunta1 *  100 / $Porciento;


echo "<br>";
echo "<br>";
echo "<table class='Estadisticas'>";
echo "<tr>";
echo "<td><h3>Estadisticas</h3></td>";
echo "<td width='70'>Muy Bueno</td>";
echo "<td width='60'>Bueno</td>";
echo "<td width='70'>Regular</td>";
echo "<td width='60'>Malo</td>";
echo "<td width='70'>Muy Malo</td>";
echo "</tr>";
echo "<tr>";
echo "<td><p class='es'>Cual es el Grado de sastifaccion general ocn el servicio entregado por el casino</p></td>";
echo "<td>".$pre."&#37;</td>";
echo "<td>".$p2_1."</td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "</tr>";
echo "<tr>";
echo "<td><p class='es'>Que opina de la calidad de los productos (alimentos) ofrecidos por el casino</p></td>";
echo "<td>".$pregunta2."</td>";
echo "<td>".$p2_2."</td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "</tr>";
echo "<tr>";
echo "<td><p class='es'>Que opina e la cantidad o porciones e los productos incluidos en los platos ofrecidos</p></td>";
echo "<td>".$pregunta3."</td>";
echo "<td>".$p2_3."</td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "</tr>";
echo "<tr>";
echo "<td><p class='es'>Como considera el tiempo de espera en la atencion en el casino</p></td>";
echo "<td>".$pregunta4."</td>";
echo "<td>".$p2_4."</td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "</tr>";
echo "<tr>";
echo "<td><p class='es'>Como considera la calidad nutritiva de los alimentos que se preparan en el casino</p></td>";
echo "<td>".$pregunta5."</td>";
echo "<td>".$p2_5."</td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "</tr>";
echo "<tr>";
echo "<td><p class='es'>Como considera el trato por parte del personal de casino</p></td>";
echo "<td>".$pregunta6."</td>";
echo "<td>".$p2_6."</td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "</tr>";
echo "<tr>";
echo "<td><p class='es'>Que opina sobre la mantencion el aseo, higene y orden del local</p></td>";
echo "<td>".$pregunta7."</td>";
echo "<td>".$p2_7."</td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "</tr>";
echo "<td><p style='text-align:right;'>Total</p></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "<td></td>";
echo "</tr>";
echo "</table>";

}

?>

</form>	