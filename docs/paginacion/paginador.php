<?php
include('../inc/config_db.php');
include('../inc/lib.db.php');

if($_POST['c_p_sol'] != "Todos" and $_POST['c_p_sol'] != "")
{
	$query2 = "and tb_sol_rec.prof_sol = '".$_POST['c_p_sol']."'";
	$p_sol = $_POST['c_p_sol'];
}

if($_POST['c_est'] != "Todos" and $_POST['c_est'] != "")
{
	$query1 = "and tb_det_sol.rec_det = '".$_POST['c_est']."' ";
	$est 	= $_POST['c_est'];
}

if($_POST['c_ods'] != "Todos" and $_POST['c_ods'] != "")
{
	$query3 = "and tb_sol_rec.ods_sol = '".$_POST['c_ods']."'";
	$ods 	= $_POST['c_ods'];
}

if($_POST['c_cc'] != "Todos" and $_POST['c_cc'] != "")
{
	$query4 = "and tb_sol_rec.cc_sol = '".$_POST['c_cc']."'";
	$cc 	= $_POST['c_cc'];
}

if($_POST['c_areas'] != "Todos" and $_POST['c_areas'] != "")
{
	$query5 = "and area_sol = '".$_POST['c_areas']."'";
	$area 	= $_POST['c_areas'];
}
if($_POST['c_f_sol'] != "Todos" and $_POST['c_f_sol'] != "")
{
	$_fecha_sol	=	cambiarFecha($_POST['c_f_sol'], '/', '-' );
	$query6 = "and tb_sol_rec.fe_sol = '$_fecha_sol'";
	$f_sol 	= $_POST['c_f_sol'];
}

// Total de registros	
$consulta = "SELECT * FROM tb_sol_rec, tb_det_sol WHERE tb_sol_rec.cod_sol = tb_det_sol.cod_sol $query1 $query2 $query3 $query4 $query5 $query6 ORDER BY tb_sol_rec.cod_sol DESC";

$NroRegistros = mysql_num_rows(mysql_query($consulta, $co));

if($NroRegistros > 0)
{
	//////////calculo de elementos necesarios para paginacion
	//tamaño de la pagina (registros a mostrar por pagina)
	$RegistrosAMostrar = 35;

	//pagina actual si no esta definida y limites
	if(!isset($_POST["pag"]))
	{
		$paginaActual	= 1;
		$inicio	= 1;
		$final	= $RegistrosAMostrar;
	}else{
		$paginaActual = $_POST["pag"];
	}
	//calculo del limite inferior
	$RegistrosAEmpezar = ($paginaActual-1)*$RegistrosAMostrar;
	if($RegistrosAEmpezar < 0){$RegistrosAEmpezar = 0;}
	//calculo del numero de paginas
	$numPags=ceil($NroRegistros/$RegistrosAMostrar);
	if(!isset($paginaActual))
	{
		$paginaActual=1;
		$inicio=1;
		$final=$RegistrosAMostrar;
	}else{
		$seccionActual=intval(($paginaActual-1)/$RegistrosAMostrar);
		$inicio=($seccionActual*$RegistrosAMostrar)+1;

		if($paginaActual<$numPags)
		{
			$final=$inicio+$RegistrosAMostrar-1;
		}else{
			$final=$numPags;
		}
                
		if ($final>$numPags){
			$final=$numPags;
		}
	}
	//////////fin de dicho calculo	


	$consulta2 = "SELECT * FROM tb_sol_rec, tb_det_sol WHERE tb_sol_rec.cod_sol = tb_det_sol.cod_sol $query1 $query2 $query3 $query4 $query5 $query6 ORDER BY tb_sol_rec.cod_sol DESC LIMIT $RegistrosAEmpezar, $RegistrosAMostrar";
	$Resultado = mysql_query($consulta2, $co);
} // fin de if

echo "<form action='' method='post' name='formu' id='formu' onSubmit='return false'><table width='1450' border='1' bordercolor='#F2F2F2' bgcolor='#cedee1' class='txtnormal2' cellspacing='0' cellpadding='0'>
<tr>
    <td align='center'>&nbsp;VER</td>
    <td align='center'>AREA</td>
    <td align='center'>".utf8_encode("Nº SOL")."</td>
    <td align='center'>ODS</td>
    <td align='center'>CENTRO COSTO</td>
    <td align='center' width='50%' >DETALLE DE SOLICITUD</td>
    <td align='center'>UND MEDIDA</td>
    <td align='center'>CANT</td>
    <td align='center'>FECHA SOL.</td>
    <td align='center'>FECHA APROB</td>
    <td align='center'>RECEPCION</td>
    <td align='center'>OC</td>
	<td align='center'>FACTURA</td>
    <td align='center'>SOLICITADA POR</td>
</tr>
<tr>
    <td align='center'>&nbsp;</td>
	
    <td align='center'>";
	
     	if($area != "" ){$area = $_POST['c_areas'];}
		if($area == "" ){$area = "Todos";}
		
		echo"<select name='c_areas' id='c_areas' style='font-size:9px; width: 170px' onchange='Pagina($paginaActual)' >";

		$sql_c = "SELECT * FROM tb_areas ORDER BY desc_ar ";
		
		$rows_area= dbConsulta($sql_c);
		$total_c = count($rows_area);
		
		echo"<option selected='selected' value='$area'>$area</option>";
		if($area != "Todos"){
			echo"<option value='Todos'>Todos</option>";
		}
				
		for ($i = 0; $i < $total_c; $i++)
		{
			echo "<option value='".$rows_area[$i]['cod_ar']."'>".$rows_area[$i]['desc_ar']."</option>";	
		}
		echo"</select>
	</td>
	
    <td align='center'>&nbsp;</td>
	
    <td align='center'>";
	
  		if($ods != "" ){$ods = $_POST['c_ods'];}
  		if($ods == "" ){$ods = "Todos";}
		
  		echo"<select name='c_ods' id='c_ods' style='font-size:9px;' onchange='Pagina($paginaActual)' >";
		
		$sql_ods  = "SELECT DISTINCT ods_sol FROM tb_sol_rec ORDER BY ods_sol ";
	
		$rs_ods 	= dbConsulta($sql_ods);
		$total_ods  = count($rs_ods);
	
		echo"<option selected='selected' value='$ods'>$ods</option>";
	
		if($ods != "Todos"){
			echo"<option value='Todos'>Todos</option>";
		}	
		
		for ($i = 0; $i < $total_ods; $i++)
		{
			echo "<option value='".$rs_ods[$i]['ods_sol']."'>".$rs_ods[$i]['ods_sol']."</option>";	
		}							
  		echo"</select>
	</td>
	
    <td align='center'>";

	 	if($cc != "" ){$cc = $_POST['c_cc'];}
	  	if($cc == "" ){$cc = "Todos";}

		echo"<select name='c_cc' id='c_cc' style='font-size:9px;' onchange='Pagina($paginaActual)' >";

		$sql_cc  = "SELECT DISTINCT cc_sol FROM tb_sol_rec ORDER BY cc_sol";
		
		$rs_cc 	= dbConsulta($sql_cc);
		$total_cc  = count($rs_cc);
		
		echo"<option selected='selected' value='$cc'>$cc</option>";
		
		if($cc != "Todos"){
			echo"<option value='Todos'>Todos</option>";
		}	
			
		for ($i = 0; $i < $total_cc; $i++)
		{
			echo "<option value='".$rs_cc[$i]['cc_sol']."'>".$rs_cc[$i]['cc_sol']."</option>";	
		}							

	echo"</select>
	</td>
	
    <td align='center'><select name='c_det' id='c_det' style='font-size:9px; width:550px' onchange='evento()' ></select></td>
    <td align='center'></td>
    <td align='center'></td>
	
    <td align='center'>";
	
		if($f_sol != "" ){$f_sol = $_POST['c_f_sol'];}
	 	if($f_sol == "" ){$f_sol = "Todos";}

		echo"<select name='c_f_sol' id='c_f_sol'  style='font-size:9px;' onchange='Pagina($paginaActual)' >";

		$sql_fs = "SELECT DISTINCT fe_sol FROM tb_sol_rec ORDER BY fe_sol DESC";
		
		$rsfs	= dbConsulta($sql_fs);
		$totalfs = count($rsfs);
		
		$f_sol = cambiarFecha($f_sol, '-', '/' );
		echo"<option selected='selected' value='$f_sol'>$f_sol</option>";
		
		if($f_sol != "Todos"){
			echo"<option value='Todos'>Todos</option>";
		}
				
		for ($i = 0; $i < $totalfs; $i++)
		{
			$rsfs[$i]['fe_sol']		=	cambiarFecha($rsfs[$i]['fe_sol'], '-', '/' );
			echo "<option value='".$rsfs[$i]['fe_sol']."'>".$rsfs[$i]['fe_sol']."</option>";	
		}

   		echo"</select>
	</td>
	
    <td align='center'></td>
	
    <td align='center'>";
	  if($est != ""){$est = $_POST['c_est'];}
	  if($est == ""){$est = "Todos";}
	  
		echo"<select name='c_est' id='c_est' style='font-size:9px;' onchange='Pagina($paginaActual)' >
		<option selected='selected' value='$est'>$est</option>";
			if($est != "Todos"){
				echo"<option value='Todos'>Todos</option>";
			}
	
		echo"<option value='Anulado'>Anulado</option>
		<option value='Pendiente'>Pendiente</option>
		<option value='Completa'>Completa</option>
		<option value='Parcial'>Parcial</option>
		<option value='Rechazada'>Rechazada</option>
	  </select>
	</td>
	
    <td align='center'></td>
	<td align='center'></td>
	
    <td align='center'>";
	
	  if($p_sol != ""){$p_sol = $_POST['c_p_sol'];}
	  if($p_sol == ""){$p_sol = "Todos";}

		echo"<select name='c_p_sol' id='c_p_sol'  style='font-size:9px;' onchange='Pagina($paginaActual)'>";

		$sqlu    = "SELECT DISTINCT prof_sol FROM tb_sol_rec ORDER BY prof_sol ";

		$rsu 	 = dbConsulta($sqlu);
		$totalu  = count($rsu);
		
		echo"<option selected='selected' value='$p_sol'>$p_sol</option>";
		
		if($p_sol != "Todos"){
			echo"<option value='Todos'>Todos</option>";
		}
				
		for ($i = 0; $i < $totalu; $i++)
		{
			echo "<option value='".$rsu[$i]['prof_sol']."'>".$rsu[$i]['prof_sol']."</option>";
		}

		echo"</select>
	</td>
	
</tr>";

if($NroRegistros > 0)
{
	$color 		= "#ffffff";
	$i=1;
	while($vrows = mysql_fetch_array($Resultado))
	{
		$cod_sol		= "".$vrows['cod_sol']."";
		$id_det			= "".$vrows['id_det']."";
		$ods_sol		= "".$vrows['ods_sol']."";
		$cc_sol			= "".$vrows['cc_sol']."";
		$empr_sol		= "".$vrows['empr_sol']."";
		$area_sol		= "".$vrows['area_sol']."";
		$prof_sol		= "".$vrows['prof_sol']."";
		$desc_sol		= "".$vrows['desc_sol']."";
		$cant_det		= "".$vrows['cant_det']."";
		$und_med		= "".$vrows['und_med']."";
		$rec_det		= "".$vrows['rec_det']."";
		$cant_rec		= "".$vrows['cant_rec']."";
		$fe_sol			= "".$vrows['fe_sol']."";
		$fe_aprob_g 	= "".$vrows['fe_aprob_g']."";
		$det_ap_g 		= "".$vrows['det_ap_g']."";
		$num_oc			= "".$vrows['num_oc']."";
		$factura		= "".$vrows['factura']."";
		
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS", $co);

		$sql_g	= "SELECT * FROM tb_areas WHERE cod_ar = '$area_sol' ";
		$res_g	= mysql_query($sql_g, $co);
		while($vrowsg=mysql_fetch_array($res_g))
		{
			$area_d	= "".$vrowsg['desc_ar']."";
			$area_c = "".$vrowsg['cod_ar']."";
		}

		$res_um	= mysql_query("SELECT * FROM tb_und_med WHERE cod_um = '$und_med' ", $co);
		while($vrows_um = mysql_fetch_array($res_um))
		{
			$nom_um 	= $vrows_um['nom_um'];
		}
		
		$fe_sol		=	cambiarFecha($fe_sol, '-', '/' );
		$fe_aprob_g	=	cambiarFecha($fe_aprob_g, '-', '/' );
		
		if($fe_aprob_g == "00/00/0000"){$fe_aprob_g = "";}
		
		if($rec_det == "Completa"){ $color = "#95d79a"; }
		if($rec_det == "Parcial"){ $color = "#fffb96"; }
		if($fe_aprob_g != "" and $det_ap_g == "1"){$color = "red"; $fe_aprob_g = "Rechazada"; }
		if($fe_aprob_g != "" and $det_ap_g == "3"){$color = "#ffdd74"; $fe_aprob_g = "Anulado"; }

		echo"<tr bgcolor=$color class='txtnormal8' onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000')>";	

		   echo"<td bgcolor='#ffc561'>&nbsp;<a href=\"../sol_rec.php?cod=$cod_sol\" width='2%'><img src='../imagenes/edit.png' border='0' valign='top' alt='Modificar'/>&nbsp;</a></td>
				<td width='8%'>&nbsp;$area_d</td>
				<td width='5%'>&nbsp;$cod_sol</td>
				<td width='6%'>&nbsp;$ods_sol</td>
				<td width='6%'>&nbsp;$cc_sol</td>
				<td width='22%'>&nbsp;$desc_sol</td>	
				<td width='8%'>&nbsp;$nom_um</td>
				<td width='3%'>&nbsp;$cant_det</td>
				<td width='4%'>&nbsp;$fe_sol</td>
				<td width='4%'>&nbsp;$fe_aprob_g</td>
				<td width='5%'>&nbsp;$rec_det</td>
				<td width='4%'>&nbsp;<a href=\"../sw/rep_oc.php?cod=$num_oc&emp=$empr_sol\" target='blank'>$num_oc</a></td>
				<td width='5%'>&nbsp;<a href='../$factura' target='blank'>"; if($factura != ""){ echo "Factura"; } echo"</a></td>
				<td width='20%'>&nbsp;&nbsp;$prof_sol</td>
			</tr>";
									
				if($color == "#ffffff"){ $color = "#ddeeee"; }
				else{ $color = "#ffffff"; }		
	}
	
}

echo "
<tr bgcolor='#cedee1'>
	<td colspan='14' align='center' height='30'>Encontrados <b>$NroRegistros</b> resultados ($numPags Paginas)</td>
</tr>
<tr bgcolor='#cedee1'>
	<td colspan='14' align='center' height='50' class='txtnormal8'>";

// AQUI MOSTRAMOS LA PAGINACION
echo "<div align='center'><ul id='pagination-digg'><li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>";

if($paginaActual > 1)
{
	// Primera
	echo "<li><a onclick=\"Pagina(1)\" href='#'><font face='verdana' size='-2'>Primera</font></a></li> ";
	// Anterior
	echo "<a onclick=\"Pagina($paginaActual-1)\" href='#'>&nbsp;<< Anterior&nbsp;</a> ";
}
/*****************************************************************************************************************************************************
				MOSTRAMOS LOS LINK DE CADA PAGINA
*****************************************************************************************************************************************************/            
for($i=$inicio;$i<=$final;$i++)
{
	if($i==$paginaActual)
	{
		echo "<li class='active'><font face='verdana' size='-2'><b>".$i."</b>&nbsp;</font></li>";
	}else{
		echo "<li><a onclick=\"Pagina($i)\" href='#'>";
		echo "<font face='verdana' size='-2'>".$i."</font></a></li>";
	}
}


if($paginaActual < $numPags)
{
	// Siguiente
	echo " <a onclick=\"Pagina($paginaActual+1)\" href='#'>&nbsp;Siguiente >>&nbsp;</a> ";
	// Ultima
	echo "<a onclick=\"Pagina($numPags)\" href='#'>Ultima</a>";
}



echo "</ul></div>";
//  Fin de la paginacion 
$consulta = urlencode($consulta); // Para quitar caracteres extraños

echo"<tr bgcolor='#cedee1'>
	<td colspan='14' align='center' height='50' class='txtnormal8'>
	<a href='../rep_excel_fsr.php?consulta=$consulta'><img src=\"../imagenes/botones/rep_excel.jpg\" border='0' /></a>
	</td>

</td></tr></table></form>";
?>
