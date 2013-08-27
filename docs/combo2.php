<?php
include_once("inc/lib.db.php");

$co = Conectarse();

$rpta="";

	$sqlg  	= "SELECT * FROM tb_dptos ORDER BY desc_dep ";
	$result = mysql_query($sqlg,$co);
	
	while($vrowsg = mysql_fetch_array($result))
	{
		$cod_dep	= "".$vrowsg['cod_dep']."";
		
		if ($_POST["elegido"]=="$cod_dep") {
			
			$sql  = "SELECT * FROM tb_areas WHERE cod_dep = '".$_POST["elegido"]."' ORDER BY desc_ar";
										
			$rs 	= dbConsulta_combo($sql);
			$total  = count($rs);
			
			$rpta= '
			<option selected="selected" value="Seleccione...">Seleccione...</option>';
												
			for ($i = 0; $i < $total; $i++)
			{
				$rpta.= '<option value='.$rs[$i]['cod_ar'].'>'.$rs[$i]['desc_ar'].'</option>';
			}
		}
	}
echo $rpta;	
?>