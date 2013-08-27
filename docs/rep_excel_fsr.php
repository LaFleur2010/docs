<?php
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Solicitudes.xls");
header("Pragma: no-cache");
header("Expires: 0");

$consulta = str_replace("\'","'",$_GET['consulta']); 
//*********************************************************************************************************************************
	include('inc/config_db.php');	// CONECCION A LA BASE DE DATOS
	require('inc/lib.db.php');
/*********************************************************************************************************************************/
	echo "<table aling='center' border='1'>
			<tr aling='center'>
				<td align='center' colspan='16' height='80'><b>LISTADO DE SOLICITUDES DE RECURSOS</td><tr>
				<td width='200'><b>GERENCIA</td>
				<td width='200'><b>DEPARTAMENTO</td>
				<td width='200'><b>AREA</td>
				<td><b>CODIGO</td>
				<td><b>ODS</td>
				<td width='680'><b>DESCRIPCION</td>
				<td><b>UND DE MED.</td>
				<td><b>CANT.</td>
				<td><b>FECHA SOL.</td>
				<td><b>HORA SOL.</td>
				<td><b>FECHA APROB. GCIA</td>
				<td><b>HORA APROB. GCIA</td>
				<td><b>RECEPCION</td>
				<td><b>CANT. RECEPCION</td>
				<td><b>NUM. OC</td>
				<td><b>PROFESIONAL SOLICITANTE</td>
			</tr>";
	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	//$sql_rep = "SELECT * FROM tb_sol_rec, tb_det_sol WHERE tb_sol_rec.cod_sol = tb_det_sol.cod_sol $query1 $query2 $query3 $query4 $query5 $query6 ORDER BY tb_sol_rec.cod_sol DESC";
	$sql_rep = $consulta;
	$resp_rep	= mysql_query($sql_rep, $co)or die(mysql_error());
	$color 		= "#ffffff";
	$i			= 1;
	
	while($vrows_rep = mysql_fetch_array($resp_rep))
	{
		$cod_sol		= "".$vrows_rep['cod_sol']."";
		$id_det			= "".$vrows_rep['id_det']."";
		$ods_sol		= "".$vrows_rep['ods_sol']."";
		$cc_sol			= "".$vrows_rep['cc_sol']."";
		$area_sol		= "".$vrows_rep['area_sol']."";
		$prof_sol		= "".$vrows_rep['prof_sol']."";
		$desc_sol		= "".$vrows_rep['desc_sol']."";
		$cant_det		= "".$vrows_rep['cant_det']."";
		$und_med		= "".$vrows_rep['und_med']."";
		$rec_det		= "".$vrows_rep['rec_det']."";
		$cant_rec		= "".$vrows_rep['cant_rec']."";
		$fe_sol			= "".$vrows_rep['fe_sol']."";
		$hr_ing_sol		= "".$vrows_rep['hr_ing_sol']."";
		$fe_aprob_g 	= "".$vrows_rep['fe_aprob_g']."";
		$hr_apb_sol 	= "".$vrows_rep['hr_apb_sol']."";
		$det_ap_g 		= "".$vrows_rep['det_ap_g']."";
		$num_oc			= "".$vrows_rep['num_oc']."";
		
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS", $co);
						
		$sql_a 		= "SELECT * FROM tb_areas WHERE cod_ar = '$area_sol' ";
		$resp_a		= mysql_query($sql_a,$co);
		$total_a 	= mysql_num_rows($resp_a);
	
		while($vrows_a = mysql_fetch_array($resp_a))
		{
			$desc_ar 	= "".$vrows_a['desc_ar']."";
			$cod_ar 	= "".$vrows_a['cod_ar']."";
			$cod_dep 	= "".$vrows_a['cod_dep']."";
		
			$sql_dpto 	= "SELECT * FROM tb_dptos WHERE cod_dep ='$cod_dep' ";
			$resp_dpto	= mysql_query($sql_dpto,$co);
			while($vrowsd=mysql_fetch_array($resp_dpto))
			{
				$desc_dep 	= "".$vrowsd['desc_dep']."";
				$cod_dep 	= "".$vrowsd['cod_dep']."";
				$cod_ger 	= "".$vrowsd['cod_ger']."";
					
				$sql_ger 	= "SELECT * FROM tb_gerencia WHERE cod_ger ='$cod_ger' ";
				$resp_ger	= mysql_query($sql_ger,$co);
				while($vrowsd=mysql_fetch_array($resp_ger))
				{
					$desc_ger 	= "".$vrowsd['desc_ger']."";
					$cod_ger 	= "".$vrowsd['cod_ger']."";
				}
					
			}	
		}
		
		$sql_um	= "SELECT * FROM tb_und_med WHERE cod_um = '$und_med' ";
		$res_um	= mysql_query($sql_um,$co);
		while($vrows_um = mysql_fetch_array($res_um))
		{
			$nom_um 	= $vrows_um['nom_um'];
		}
		
		$fe_sol		=	cambiarFecha($fe_sol, '-', '/' );
		$fe_aprob_g	=	cambiarFecha($fe_aprob_g, '-', '/' );
		
		if($fe_aprob_g == "00/00/0000"){$fe_aprob_g = "";}
									
		echo"</tr>
			<td>".utf8_decode($desc_ger)."</td>
			<td>".utf8_decode($desc_dep)."</td>
			<td>".utf8_decode($desc_ar)."</td>
			<td>$cod_sol</td>
			<td>$ods_sol</td>
			<td>".utf8_decode($desc_sol)."</td>
			<td>".utf8_decode($nom_um)."</td>
			<td>$cant_det</td>
			<td>$fe_sol</td>
			<td>$hr_ing_sol</td>
			<td>$fe_aprob_g</td>
			<td>$hr_apb_sol</td>
			<td>".utf8_decode($rec_det)."</td>
			<td>$cant_recep</td>
			<td>$num_oc</td>
			<td>".utf8_decode($prof_sol)."</td>
		</tr>";
		
		$i++;			
	}	
	mysql_free_result($resp_rep);

	echo "</table>";
?>
	
	

