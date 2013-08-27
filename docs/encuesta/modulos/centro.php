
<form name="encuesta" id="encuesta" action="ingreso.php" method="POST">
<center>

<table class="tablas" >
<tr>
<td colspan="6" class="titulo2">
	<center><h2>Encuesta de Casino &nbsp;&nbsp;
	<select name="Slist">
	<option value="1">Kokodrilo</option>
	<option value="2">Donde Silvana</option>
	</select>
	</h2>	
	</center>
</td>	
</tr>
<tr>
<td class="titulo2">
<h3>Encuesta Numero : <?php echo fn_ultimo_numero(1); ?></h3> 
</td>
<td class="titulo2">
Muy Bueno
</td>
<td class="titulo2">
Bueno
</td>
<td class="titulo2">
Regular
</td>
<td class="titulo2">
Malo
</td>
<td class="titulo2">
Muy Malo
</td>
</tr>
<tr>
<td class="fondo">
<p class="p">Cual es el Grado de sastifaccion general ocn el servicio entregado por el casino</p>
</td>
<td class="por">
<input type="radio" name="op" value="1">
</td>
<td class="por">
<input type="radio" name="op" value="2">
</td>
<td class="por">
<input type="radio" name="op" value="3">
</td>
<td class="por">
<input type="radio" name="op" value="4">
</td>
<td class="por">
<input type="radio" name="op" value="5">
</td>
</tr>
<tr>
<td class="fondo">
<p class="p">Que opina de la calidad de los productos (alimentos) ofrecidos por el casino</p>
</td>
<td class="por">
<input type="radio" name="op1" value="1">
</td>
<td class="por">
<input type="radio" name="op1" value="2">
</td>
<td class="por">
<input type="radio" name="op1" value="3">
</td>
<td class="por">
<input type="radio" name="op1" value="4">
</td>
<td class="por">
<input type="radio" name="op1" value="5">
</td>
</tr>
<tr>
<td class="fondo">
<p class="p">Que opina e la cantidad o porciones e los productos incluidos en los platos ofrecidos</p>
</td>
<td class="por">
<input type="radio" name="op2" value="1">
</td>
<td class="por">
<input type="radio" name="op2" value="2">
</td>
<td class="por">
<input type="radio" name="op2" value="3">
</td>
<td class="por">
<input type="radio" name="op2" value="4">
</td>
<td class="por">
<input type="radio" name="op2" value="5">
</td>
</tr>
<tr>
<td class="fondo">
<p class="p">Como considera el tiempo de espera en la atencion en el casino</p>
</td>
<td class="por">
<input type="radio" name="op3" value="1">
</td>
<td class="por">
<input type="radio" name="op3" value="2">
</td>
<td class="por">
<input type="radio" name="op3" value="3">
</td>
<td class="por">
<input type="radio" name="op3" value="4">
</td>
<td class="por">
<input type="radio" name="op3" value="5">
</td>
</tr>
<tr>
<td class="fondo">
<p class="p">Como considera la calidad nutritiva de los alimentos que se preparan en el casino</p>
</td>
<td class="por">
<input type="radio" name="op4" value="1">
</td>
<td class="por">
<input type="radio" name="op4" value="2">
</td>
<td class="por">
<input type="radio" name="op4" value="3">
</td>
<td class="por">
<input type="radio" name="op4" value="4">
</td>
<td class="por">
<input type="radio" name="op4" value="5">
</td>
</tr>
<tr>
<td class="fondo">
<p class="p">Como considera el trato por parte del personal de casino</p>
</td>
<td class="por">
<input type="radio" name="op5" value="1">
</td>
<td class="por">
<input type="radio" name="op5" value="2">
</td>
<td class="por">
<input type="radio" name="op5" value="3">
</td>
<td class="por">
<input type="radio" name="op5" value="4">
</td>
<td class="por">
<input type="radio" name="op5" value="5">
</td>
</tr>
<tr>
<td class="fondo">
<p class="p">Que opina sobre la mantencion el aseo, higene y orden del local</p>
</td>
<td class="por">
<input type="radio" name="op6" value="1">
</td>
<td class="por">
<input type="radio" name="op6" value="2">
</td>
<td class="por">
<input type="radio" name="op6" value="3">
</td>
<td class="por">
<input type="radio" name="op6" value="4">
</td>
<td class="por">
<input type="radio" name="op6" value="5">
</td>
</tr>
<tr>
<td colspan="6">
	
<center>
	<input type="submit"name="Ingresar" onclick="return ingreso();" class="boton" value="Ingresar">&nbsp;
	<input type="reset" name="Limpiar" class="boton" value="Limpiar">
</center>	
</td>
</tr>	
</center>
</table>

</center>	
</form>
<br>
<center>Bienvenio <u><?php echo $_SESSION['nombre']; ?></u> | &nbsp;<a href="cerrar.php"><u>Cerrar Sesion</u>&nbsp;<img src="img/delete.png"></a></center>