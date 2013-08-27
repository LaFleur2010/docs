<?php
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=archivo.xls");
header("Pragma: no-cache");
header("Expires: 0");
	
include('config_db.php'); // Libreria de conexion

$co=mssql_connect("$SERVER","$USR","$PASS");
mssql_select_db("$BDATOS", $co);

	//echo "<br></br>";

		
	echo "<table aling='center' border='1'>
			<tr aling='center'>
				<td align='center' colspan='8' height='20'><b><img src='../imagenes/logo_mgyt_c.jpg'>LISTADO DE TRABAJADORES</td><tr>
				<td><b>RUT</td>
				<td><b>NOMBRE</td>
				<td><b>FECHA ING</td>
				<td><b>VENCIMIENTO</td>
				<td><b>DIRECCION</td>
				<td><b>COMUNA</td>
				<td><b>TELEFONO</td>
				<td><b>CORREO</td>
			</tr>";
	
	//$sql 	= "SELECT TOP 10 iw_tprod.DesProd FROM softland.iw_tprod WHERE iw_tprod.DesProd LIKE 'TERMINAL%' ";
	$sql 	= "SELECT * FROM softland.sw_personal ORDER BY sw_personal.nombres";
	
	$respuesta	= mssql_query($sql,$co);
	$color 		= "#ffffff";
	$i=1;
	while($vrows=mssql_fetch_assoc($respuesta))
	{
		$sql_p 	= "SELECT * FROM softland.socomunas WHERE socomunas.CodComuna = '".$vrows['codComuna']."' ";
		$res	= mssql_query($sql_p,$co);
		while($fila = mssql_fetch_assoc($res))
		{
			$NomComuna	= "".$fila['NomComuna']."";
		}
		
		echo "<tr bgcolor=$color   onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000')>	
				
				<td>&nbsp;".$vrows['rut']."</td>
				<td>&nbsp;".htmlentities($vrows['nombres'])."</td>
				<td>&nbsp;".$vrows['fechaIngreso']."</td>	
				<td>&nbsp;".$vrows['fechaContratoV']."</td>	
				<td>&nbsp;".htmlentities($vrows['direccion'])."</td>	
				<td>&nbsp;".htmlentities($NomComuna)."</td>
				<td>&nbsp;".$vrows['telefono1']."</td>
				<td>&nbsp;".$vrows['Email']."</td>
				</tr>";
	}
	echo "</table>";
?>
	
	

