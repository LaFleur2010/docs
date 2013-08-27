<?php
include("funcion.php");
?>
<!--
**************************************************
 primera parte de estadisticas 
**************************************************
-->

<h2>Resultados de Encuesta Local Kokodrilo</h2>
<br />

<table width="100%" border="1">
	<tr>
		<td class="titulo">Preguntas</td>
		<td class="titulo">Muy Bueno</td>
		<td class="titulo">Bueno</td>
		<td class="titulo">Regular</td>
		<td class="titulo">Malo</td>
		<td class="titulo">Muy Malo</td>
	</tr>
<?php

$total_preguntas = fn_total_preguntas(1);

for($i=1;$i<=$total_preguntas;$i++)
{
	//cantidad de votos por cada opcion de la pregunta $i
	$cantidades[$i] 	= fn_cantidades($i);

	//cantidad de votos totales de la pregunta $i
	$suma_pregunta[$i] = array_sum($cantidades[$i]);
}


$sqlw 	= "SELECT * from preguntas order by posicion asc";
$rsw 	= mysql_query($sqlw,$link);

while ($w = mysql_fetch_array($rsw))
{
	$id_preg = $w['id'];

	echo "<tr>";
	echo "<td class='fondo' width='500'>".$w['pregunta']."</td>";
	echo "<td class='por'>".fn_porc_opcion($suma_pregunta[$id_preg],$cantidades[$id_preg][1])." %</td>";
	echo "<td class='por'>".fn_porc_opcion($suma_pregunta[$id_preg],$cantidades[$id_preg][2])." %</td>";
	echo "<td class='por'>".fn_porc_opcion($suma_pregunta[$id_preg],$cantidades[$id_preg][3])." %</td>";
	echo "<td class='por'>".fn_porc_opcion($suma_pregunta[$id_preg],$cantidades[$id_preg][4])." %</td>";
	echo "<td class='por'>".fn_porc_opcion($suma_pregunta[$id_preg],$cantidades[$id_preg][5])." %</td>";
	echo "</tr>";
}
?>
</table>

<br />

<h3>Cantidad de Encuestados: <?php echo fn_total_encuestados(1); ?></h3>

<br />
<br />

<!--
**************************************************
 segunda parte de estadisticas 
**************************************************
-->


<h2>Resultados de Encuesta Local Donde Silvana</h2>
<br />

<table width="100%" border="1">
	<tr>
		<td class="titulo">Preguntas</td>
		<td class="titulo">Muy Bueno</td>
		<td class="titulo">Bueno</td>
		<td class="titulo">Regular</td>
		<td class="titulo">Malo</td>
		<td class="titulo">Muy Malo</td>
	</tr>
<?php

$total_preguntas = fn_total_preguntas(1);

for($i=1;$i<=$total_preguntas;$i++)
{
	//cantidad de votos por cada opcion de la pregunta $i
	$cantidades[$i] 	= fn_cantidades2($i);

	//cantidad de votos totales de la pregunta $i
	$suma_pregunta[$i] = array_sum($cantidades[$i]);
}


$sqlw 	= "SELECT * from preguntas order by posicion asc";
$rsw 	= mysql_query($sqlw,$link);

while ($w = mysql_fetch_array($rsw))
{
	$id_preg = $w['id'];

	echo "<tr>";
	echo "<td class='fondo' width='500'>".$w['pregunta']."</td>";
	echo "<td class='por'>".fn_porc_opcion($suma_pregunta[$id_preg],$cantidades[$id_preg][1])." %</td>";
	echo "<td class='por'>".fn_porc_opcion($suma_pregunta[$id_preg],$cantidades[$id_preg][2])." %</td>";
	echo "<td class='por'>".fn_porc_opcion($suma_pregunta[$id_preg],$cantidades[$id_preg][3])." %</td>";
	echo "<td class='por'>".fn_porc_opcion($suma_pregunta[$id_preg],$cantidades[$id_preg][4])." %</td>";
	echo "<td class='por'>".fn_porc_opcion($suma_pregunta[$id_preg],$cantidades[$id_preg][5])." %</td>";
	echo "</tr>";
}
?>
</table>

<br />

<h3>Cantidad de Encuestados: <?php echo fn_total_encuestados2(1); ?></h3>
