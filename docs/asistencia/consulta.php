<?php
	require("inc/config_db.php");

function filan($num, $rut_t, $nom_t, $app_t, $apm_t, $color)
{
	echo"<tr bgcolor=$color  bordercolor=$color onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000')>
	<td height='12' align='center'>$num</td>
    <td height='12' align='left'>&nbsp;&nbsp;".$nom_t." ".$app_t." ".stripslashes(utf8_encode($apm_t))."</td>
    <td width='50' align='center'><input name='presente[]' type='checkbox' class='cajas' id='checkbox[]' onclick='cambiar(this)' /></td>
    <td width='62' align='center'><input name='ausente[]' type='checkbox' class='cajas' id='checkbox[]' onclick='cambiar(this)' /></td>
    <td width='149' align='center'>
								
	<select name='motivo[]' class='combos' id='motivo' style='width: 140px' onchange='fmot(this);' >
    <option selected='selected' value='SELECCIONE...'>Seleccione...</option>
	<option value='Dia compensado'>Dia compensado</option>
    <option value='Falla'>Falla</option>
    <option value='Licencia'>Licencia</option>
    <option value='Permiso a descuento'>Permiso a descuento</option>
    <option value='Permiso Legal'>Permiso Legal</option>
    <option value='Terreno'>Terreno</option>
	<option value='Turno'>Turno</option>
    <option value='Vacaciones'>Vacaciones</option>
    </select>
								
	</td>
		<td width='365' align='center'>
			<input name='obs[]' type='text' class='cajas' id='textfield' size='55' />
			<input name='rut[]' type='hidden' id='rut[]' value='$rut_t'/>
			<input name='aux[]' type='hidden' id='aux[]' />
			<input name='aux_mot[]' type='hidden' id='aux_mot[]' />
		</td>
	</tr>"; 
}
	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$valor = $_GET['valor'];
	
	/*$sqla 	= "SELECT desc_ar FROM tb_areas WHERE cod_ar = '".$_GET["valor"]."' ORDER BY desc_ar";
	$result = mysql_query($sqla,$co);
	
	while($vrowsa = mysql_fetch_array($result))
	{
		$cod_ar	= "".$vrowsa['cod_ar']."";
	}*/
	unset($sqlc);
	$sqlc		= "SELECT * FROM trabajadores_a WHERE area_t = '".$_GET["valor"]."' and estado = 'Vigente' ";
	$respuesta	= mysql_query($sqlc,$co);
	$cant   	= mysql_num_rows($respuesta);
	
	if($cant == 0)	// SI NO ENCONTRO NINGUN REGISTRO ENVIAMOS UN MENSAJE
	{
		//alert("No Se Encontraron Registros");
	}else{			// DE LO CONTRARIO MOSTRAMOS LOS REGISTROS
		unset($trabajadores);
		while($vrowst=mysql_fetch_array($respuesta))
		{
			$trabajadores[]	= $vrowst;							
		}

echo"<table width='883' border='1' cellpadding='0' cellspacing='0' bordercolor='#cccccc' bgcolor='#a2b5c0'>
                              <tr class='txtnormaln' bgcolor='#5a88b7'>
                                <td width='26' rowspan='2' align='center'>Nº</td>
                                <td width='219' rowspan='2' align='center'>NOMBRE TRABAJADOR</td>
                                <td colspan='2' align='center'>ESTADO</td>
                                <td width='149' rowspan='2' align='center'>MOTIVO</td>
                                <td width='365' rowspan='2' align='center'>OBSERVACION</td>
                                </tr>
                              <tr class='txtnormalb' bgcolor='#5a88b7'>
                                <td width='57' align='center'>Presente</td>
                                <td width='53' align='center'>Ausente</td>
                              </tr>";

$i = 0;
$total_t = count($trabajadores);
$color = "#ffffff";	
while($i < $total_t)
{
	$rut_t	 	= $trabajadores[$i]['rut_t'];
	$nom_t		= $trabajadores[$i]['nom_t'];
	$app_t	 	= $trabajadores[$i]['app_t'];
	$apm_t		= $trabajadores[$i]['apm_t'];
	$num		= ($i + 1);
	
							
	filan($num, $rut_t, $nom_t, $app_t, utf8_decode($apm_t), $color);
	
	if($color == "#ffffff"){ $color = "#ededed"; }
	else{ $color = "#ffffff"; }
	$i++;
}
echo"<tr bgcolor='#5a88b7' bordercolor='#5a88b7'>
<td height='12' align='center'>&nbsp;</td>
<td height='12' align='left'>&nbsp;</td>
<td width='50' align='center'><a href='javascript:seleccionar_todo_p()'>Todos</a></td>
<td width='62' align='center'><a href='javascript:seleccionar_todo_a()()'>Todos</a></td>
<td width='149' align='center'>&nbsp;</td>
<td width='365' align='center'>&nbsp;</td>
</tr>

<tr bgcolor='#5a88b7' bordercolor='#5a88b7'>
<td height='12' align='center'>&nbsp;</td>
<td height='12' align='left'>&nbsp;</td>
<td width='50' align='center'><a href='javascript:deseleccionar_todo_p()'>Ninguno</a></td>
<td width='62' align='center'><a href='javascript:deseleccionar_todo_a()()'>Ninguno</a></td>
<td width='149' align='center'>&nbsp;</td>
<td width='365' align='center'>&nbsp;</td>
</tr>
</table>";
}
?>