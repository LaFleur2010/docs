<?php
include_once("inc/lib.db.php");

$co = Conectarse();

$rpta="";	

	$sqlg  	= "SELECT * FROM tb_gerencia ORDER BY desc_ger ";
	$result = mysql_query($sqlg,$co);
	
	while($vrowsg = mysql_fetch_array($result))
	{
		$cod_ger = "".$vrowsg['cod_ger']."";
		
		if ($_POST["elegido"]=="$cod_ger") {
			
			$sql  = "SELECT * FROM tb_dptos WHERE cod_ger = '".$_POST["elegido"]."' ORDER BY desc_dep ";
										
			$rs 	= dbConsulta_combo($sql);
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