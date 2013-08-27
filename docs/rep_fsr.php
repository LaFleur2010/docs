<?php
require('fpdf.php');

$pdf=new FPDF();
$pdf->AddPage();
include ('inc/config_db.php');
$fe=date("Y-m-d");

class PDF extends FPDF
{
	// Cabecera de pagina
	function Header()
	{
	
	}
	//Pie de página
	function Footer()
	{
		//Posición: a 1,5 cm del final
		$this->SetY(-15);
		//Arial Black de 10
		$this->SetFont('Arial','',10);
		//Número de página
		$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

$pdf=new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial','',12);
/*********************************************************************************************************
	Función Para Cambiar el Formato de la Fecha
**********************************************************************************************************/
function cambiarFecha( $sFecha, $sSimboloInicial, $sSimboloFinal )
{
return implode( $sSimboloFinal, array_reverse( explode( $sSimboloInicial, $sFecha ) ) ) ; 
} 
//********************************************************************************************************

$cod_sol	= $_GET['cs'];

	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS",$co);
	
	$sqlf 		= "SELECT * FROM tb_sol_rec, tb_det_sol WHERE tb_sol_rec.cod_sol='$cod_sol' and tb_sol_rec.cod_sol = tb_det_sol.cod_sol";
	$respuesta	= mysql_query($sqlf,$co);
	while ($row = mysql_fetch_array($respuesta)) {
    	$consulta[] = $row; 
	}
	
	$fe_sol 	= $consulta[0]['fe_sol'];
	$fe_aprob_g = $consulta[0]['fe_aprob_g'];
	$fe_aprob_b = $consulta[0]['fe_aprob_b'];
	$ods_sol 	= $consulta[0]['ods_sol'];
	$cc_sol 	= $consulta[0]['cc_sol'];
	$area_sol 	= $consulta[0]['area_sol'];
	$aprob_ger 	= $consulta[0]['aprob_ger'];
	$aprob_adm  = $consulta[0]['aprob_dpto'];
	$aprob_bod  = $consulta[0]['aprob_bod'];
	$prof_sol   = $consulta[0]['prof_sol'];
	$fe_en_obra = $consulta[0]['fe_en_obra'];
	$empr_sol   = $consulta[0]['empr_sol'];
	$hr_apb_sol = $consulta[0]['hr_apb_sol'];
	$hr_ing_sol = $consulta[0]['hr_ing_sol'];
	$hr_apbb_sol= $consulta[0]['hr_apbb_sol'];
	$valor_aprox = $consulta[0]['valor_aprox'];
	$valor_bodega = $consulta[0]['valor_bodega'];
	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
		
	/****************************************************************/
	/****************************************************************/
	$sql_a 		= "SELECT * FROM tb_areas WHERE cod_ar = '$area_sol' ";
	$resp_a		= mysql_query($sql_a,$co);
	$total_a 	= mysql_num_rows($resp_a);
		
	while($vrows_a = mysql_fetch_array($resp_a))
	{
		$area_t 	= "".$vrows_a['desc_ar']."";
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

$fe_sol		= cambiarFecha($fe_sol, '-', '/' );
$fe_aprob_g	= cambiarFecha($fe_aprob_g, '-', '/' ); 
$fe_aprob_b	= cambiarFecha($fe_aprob_b, '-', '/' ); 
$fe_en_obra	= cambiarFecha($fe_en_obra, '-', '/' ); 

if($fe_aprob_b == "00/00/0000"){$fe_aprob_b = "";}
if($fe_aprob_g == "00/00/0000"){$fe_aprob_g = "";}

if($hr_apbb_sol == "00:00:00"){$hr_apbb_sol = "";}
if($hr_apb_sol  == "00:00:00"){$hr_apb_sol  = "";}
//*************** LOGO MGYT *****************************

$pdf->Image('imagenes/logo2.jpg',13,11,23);

//************** PRIMERA FILA ***************************
$pdf->Cell(28,15," ",1,0,'C'); 
$pdf->Cell(216,15,"FORMULARIO DE SOLICITUD DE RECURSOS Y COTIZACION",1,0,'C'); 
$pdf->SetFont('Arial','',8);

$pdf->Cell(12,5,"COD.",1,0,'C'); 
$pdf->Cell(25,5,"SGI-GER-R-087",1,1,'L'); 

$pdf->Cell(244,5," ",0,0,'C'); 
$pdf->Cell(12,5,"REV.",1,0,'C'); 
$pdf->MultiCell(25,5,"02",1,1,'L'); 

$pdf->Cell(244,5," ",0,0,'C'); 
$pdf->Cell(12,5,"Fecha",1,0,'C'); 
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(25,5,"15/05/2012",1,1,'L'); 
//************** SEGUNDA FILA ***************************
$pdf->SetFont('Arial','',8);
$pdf->Cell(50,6,"Nº DE SOLICITUD",1,0,'L'); 
$pdf->SetFont('Arial','',9);
$pdf->Cell(140,6,"$cod_sol",1,0,'L'); 
$pdf->SetFont('Arial','',8);
$pdf->Cell(1,6,"",0,0,'C'); 
$pdf->Cell(40,6,"Profesional/Solicitante",1,0,'L');
$pdf->Cell(50,6,utf8_decode($prof_sol),1,1,'C'); 

//************* TERCERA FILA ****************************
$pdf->SetFont('Arial','',8);
$pdf->Cell(50,6,"Empresa  -  Area o contrato",1,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(140,6,$desc_ger." - ".$desc_dep." - ".$area_t,1,0,'L');

$pdf->Cell(1,6,"",0,0,'C'); 

$pdf->SetFont('Arial','',8);
$pdf->Cell(40,6,"Fecha en Obra",1,0,'L'); 
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,6,"$fe_en_obra",1,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(50,6,"Centro de Costo",1,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(140,6,"$cc_sol",1,0,'L');

$pdf->Cell(1,6,"",0,0,'C'); 

$pdf->SetFont('Arial','',8);
$pdf->Cell(40,6,"Fecha elab. solicitud",1,0,'L'); 
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,6,"$fe_sol  - ".$hr_ing_sol,1,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(50,6,"Nº informe/ODS",1,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(140,6,"$ods_sol",1,0,'L');
$pdf->Cell(1,6,"",0,0,'C'); 
$pdf->SetFont('Arial','',8);

$pdf->Cell(40,6,"Fecha aprob. solicitud",1,0,'L'); 
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,6,"$fe_aprob_g  - ".$hr_apb_sol,1,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(190,5,"",1,0,'L');
$pdf->Cell(1,5,"",0,0,'C'); 
$pdf->Cell(30,5,"APROBACION",1,0,'C'); 
$pdf->Cell(30,5,"EXISTE EN BOD.",1,0,'C'); 
$pdf->Cell(30,5,"RECEPCION",1,1,'C');

$pdf->Cell(6,5,"Nº",1,0,'L');
$pdf->Cell(116,5,"Descripcion clara y detallada del Requerimiento",1,0,'L');
$pdf->Cell(20,5,"Unidad Med.",1,0,'L');
$pdf->Cell(8,5,"Cant.",1,0,'L');
$pdf->Cell(20,5,"Valor Aprox",1,0,'L');
$pdf->Cell(20,5,"Valor Bodeg",1,0,'L');

$pdf->Cell(1,5,"",0,0,'C'); 
$pdf->Cell(15,5,"Jefe Dpto.",1,0,'C');
$pdf->Cell(15,5,"Gte. Op",1,0,'C');
$pdf->Cell(18,5,"Si / No",1,0,'C');
$pdf->Cell(12,5,"Cant.",1,0,'C');
$pdf->Cell(30,5,"",1,1,'C');
			
	//$this->Cell(80);
	$ani=13; // ancho Item	
	$i=0;
	//$total =  count($consulta);
	$total =  12;
	$xx=53;
	
	while($i < $total)
	{
		//$pdf->Cell(4,5,'');
		$valor0 		= $i+1;
		$desc_sol 		= $consulta[$i]['desc_sol'];
		$und_med 		= $consulta[$i]['und_med'];
		$cant_det 		= $consulta[$i]['cant_det'];
		$fecha_sol 		= $consulta[$i]['fecha_sol'];	
		$det_ap_a 		= $consulta[$i]['det_ap_d'];
		$det_ap_g		= $consulta[$i]['det_ap_g'];
		$det_ap_b		= $consulta[$i]['det_ap_b'];
		$rec_det		= $consulta[$i]['rec_det'];	
		$ex_bod_det		= $consulta[$i]['ex_bod_det'];
		$cant_b			= $consulta[$i]['cant_b'];
		$valor_aprox	= $consulta[$i]['valor_aprox'];
		$valor_bodega   = $consulta[$i]['valor_bodega'];	
		
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS", $co);
			
		$sql_um	= "SELECT * FROM tb_und_med WHERE cod_um = '$und_med' ";
		$res_um	= mysql_query($sql_um,$co);
		while($vrows_um = mysql_fetch_array($res_um))
		{
			$nom_um 	= $vrows_um['nom_um'];
		}	
		
		$pdf->Cell(6,7,"$valor0",1,0,'L');
		$pdf->Cell(116,7,utf8_decode($desc_sol),1,0,'L');
		$pdf->Cell(20,7,"$nom_um",1,0,'L');
		$pdf->Cell(8,7,"$cant_det",1,0,'L');
		$pdf->Cell(20,7,"$valor_aprox",1,0,'L');
		$pdf->Cell(20,7,"$valor_bodega",1,0,'L');
		
		if($det_ap_a  == "2"){$tipo_p = "imagenes/ok.jpg"; }else{ $tipo_p = "imagenes/no.jpg";}
		if($det_ap_g  == "2"){$tipo_g = "imagenes/ok.jpg"; }else{ $tipo_g = "imagenes/no.jpg";}
		if($det_ap_b  == 1 and $cant_b == $cant_det){$tipo_b = "imagenes/ok.jpg"; }
		if($det_ap_b  == 1 and $cant_b >= 0 and $cant_b != $cant_det){$tipo_b = "imagenes/ok.jpg"; }
		if($det_ap_b  == 2){$tipo_b = "imagenes/no.jpg"; }
		
		if($det_ap_a  == 0){$tipo_p = "imagenes/blanco.jpg"; }
		if($det_ap_g  == 0){$tipo_g = "imagenes/blanco.jpg"; }
		if($det_ap_b  == 0){$tipo_b = "imagenes/blanco.jpg"; }
		
		//if($ex_bod_det == "1"){$ex_b = "imagenes/ok.jpg"; $xy="234"; }else{ $ex_b = "imagenes/no.jpg"; $xy="243"; }
		
		$xx = $xx + 7;
		if($desc_sol != ""){$vara = $pdf->Image($tipo_p,206,$xx,4);}else{$desc_sol == "";}
		if($desc_sol != ""){$varg = $pdf->Image($tipo_g,220,$xx,4);}else{$desc_sol == "";}
		if($desc_sol != ""){$varb = $pdf->Image($tipo_b,238,$xx,4);}else{$desc_sol == "";}
		
		if($aprob_bod == ""){$cant_b = "";}
		
		$pdf->Cell(1,7,$vara,0,0,'C'); 
		$pdf->Cell(15,7,$varg,1,0,'C');
		$pdf->Cell(15,7,$varb,1,0,'C');
		$pdf->Cell(18,7,"$ex_bod_det",1,0,'C');
		$pdf->Cell(12,7,"$cant_b",1,0,'C');
		$pdf->Cell(30,7,"$rec_det",1,1,'C');
		$nom_um="";
		$i++;
	}
/*******************************************************************************************************
CONSULTAMOS SI LA SOLICITUD ESTA APROBADA PARA IMPRIMIR LA FIRMA DIGITAL
*******************************************************************************************************/
	$aprob_adm = utf8_decode($aprob_adm);
	$aprob_ger 	= utf8_decode($aprob_ger);
	
	//if($aprob_adm == "Juan Rosales Pino")		{ $a_p = $pdf->Image('imagenes/firma4.jpg',130,140,45);}
	if($aprob_adm == "Victor Hugo Ortiz Tovar")		{ $a_p = $pdf->Image('imagenes/firma4_4.jpg',140,145,45);}
	//if($aprob_adm == "Patrico Riquelme S.")		{ $a_p = $pdf->Image('imagenes/firma2.jpg',130,140,45);}

	if($aprob_ger  == "Miguel Rubio")			{ $a_g = $pdf->Image('imagenes/firma8_8.jpg',130,153,20);}
	//if($aprob_ger  == "Jose Acevedo")		{ $a_g = $pdf->Image('imagenes/firma4_4.jpg',130,155,40);}
	
	if($aprob_bod  == "Ronaldo Mandujano")		{ $a_b = $pdf->Image('imagenes/ronaldo.jpg',245,162,45);}
	
/******************************************************************************************************/

$pdf->Cell(158,4,"AUTORIZADA POR:",1,1,'C');

$pdf->Cell(38,4,"Area",1,0,'C');
$pdf->Cell(80,4,"Nombre",1,0,'C');
$pdf->Cell(40,4,"Firma",1,1,'C');

$pdf->Cell(38,10,"ADMINISTRACION",1,0,'L');
$pdf->Cell(80,10,"$aprob_adm",1,0,'C');
$pdf->Cell(40,10,$a_p,1,0,'L');

$pdf->Cell(33,10,"",0,0,'L');
$pdf->Cell(49,10,"FECHA APROBACION BODEGA",1,0,'C');
$pdf->Cell(41,10,"$fe_aprob_b - ".$hr_apbb_sol,1,1,'C');

$pdf->Cell(38,10,"OPERACIONES",1,0,'L');
$pdf->Cell(80,10,"$aprob_ger",1,0,'C');
$pdf->Cell(40,10,$a_g,1,0,'L');

$pdf->Cell(33,10,"",0,0,'L');
$pdf->Cell(49,10,"NOMBRE ENCARGADO BODEGA",1,0,'C');
$pdf->Cell(41,10,"$aprob_bod",1,1,'C');

$pdf->Cell(38,10,"ABASTECIMIENTO",1,0,'L');
$pdf->Cell(80,10," ",1,0,'C');
$pdf->Cell(40,10,"",1,0,'L');

$pdf->Cell(33,10,"",0,0,'L');
$pdf->Cell(49,10,"FIRMA ENCARGADO BODEGA",1,0,'C');
$pdf->Cell(41,10,"",1,1,'L');

	
	$ruta 	= "Carpetas ODS/".$ods_sol."/";
	$ruta_c = "Carpetas ODS/".$ods_sol."/FSR-".$cod_sol.".pdf";
	$nombre = "FSR-".$cod_sol.".pdf";
	
	$query	= "SELECT * FROM documentos WHERE nom_doc='$nombre' AND ruta_doc='$ruta'";
	$result	= mysql_query($query,$co);
	$cant	= mysql_num_rows($result);
	if($cant==0)
	{
		$ing = "INSERT INTO documentos (ruta_doc, rutac_doc, carp_doc, nom_doc, nivel_doc, sub_por, fecha_sub) values('$ruta', '$ruta_c', '$ods_sol', '$nombre', 5, 'Administracion','$fe')";
		mysql_query($ing, $co);
	}
	//$pdf->Output($ruta_c);
	$pdf->Output();
?>