<?php
include('inc/config_db.php');	// CONECCION A LA BASE DE DATOS
require('inc/lib.db.php');
	
$co=mysql_connect("$DNS","$USR","$PASS");
mysql_select_db("$BDATOS", $co);

$rpta="";	

	$sqlg  	= "SELECT * FROM tb_gerencia ORDER BY desc_ger ";
	$result = mysql_query($sqlg,$co);
	
	while($vrowsg = mysql_fetch_array($result))
	{
		$cod_ger	= "".$vrowsg['cod_ger']."";
		
		if ($_POST["elegido"]=="$cod_ger") {
			
			$sql  = "SELECT * FROM tb_dptos WHERE cod_ger = '".$_POST["elegido"]."' ORDER BY desc_dep ";
										
			$rs 	= dbConsulta($sql);
			$total  = count($rs);
			
			$rpta= '
			<option selected="selected" value="Seleccione...">Seleccione...</option>';
												
			for ($i = 0; $i < $total; $i++)
			{
				$rpta.= '<option value='.$rs[$i]['cod_dep'].'>'.$rs[$i]['desc_dep'].'</option>';
			}
		}
	}
		echo $rpta;	
?>