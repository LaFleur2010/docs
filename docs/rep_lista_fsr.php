<?php
require('fpdf.php');
$pdf=new FPDF();
$pdf->AddPage();

include('inc/config_db.php');

$fe	=	date("d/m/Y");

class PDF extends FPDF
{
	// Cabecera de pagina
	function Header()
	{
		global $title;
		$this->Ln(10);
		//Arial bold 15
		$this->SetFont('Arial','B',8);
		
		//Colores de los bordes, fondo y texto
		$this->SetDrawColor(150,150,150);
		$this->SetFillColor(120,120,120);
		$this->SetTextColor(255,255,255);
		
		$this->Cell(30,6,"AREA",1,0,'L',true);						
		$this->Cell(13,6,"Nº SOL",1,0,'L',true);				
		$this->Cell(15,6,"ODS",1,0,'L',true);	
		$this->Cell(15,6,"CC",1,0,'L',true);
		$this->Cell(129,6,"DESCRIPCION",1,0,'L',true);
		$this->Cell(10,6,"CANT",1,0,'L',true);
		$this->Cell(17,6,"FE APROB",1,0,'L',true);
		$this->Cell(17,6,"FE OBRA",1,0,'L',true);
		$this->Cell(20,6,"RECEPCION",1,0,'L',true);
		$this->Cell(10,6,"CANT",1,1,'L',true);
		
		$this->Cell(276,1,"",1,1,'L');
	}
	
	//Pie de página
	function Footer()
	{
		//Posición: a 1,5 cm del final
		$this->SetY(-20);
		//Arial Black de 10
		$this->SetFont('Arial','',10);
		//Número de página
		$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
	}
}
/*********************************************************************************************************
//Función Para Cambiar el Formato de la Fecha
**********************************************************************************************************/
function cambiarFecha( $sFecha, $sSimboloInicial, $sSimboloFinal )
{
return implode( $sSimboloFinal, array_reverse( explode( $sSimboloInicial, $sFecha ) ) ) ; 
} 

/*********************************************************************************************************
//Función para cortar cadena
**********************************************************************************************************/
function cortarTexto($texto,$tam) { 

    $tamano = $tam; // tamaño máximo 
    $textoFinal = ''; // Resultado 

    // Si el numero de carateres del texto es menor que el tamaño maximo, 
    // el tamaño maximo pasa a ser el del texto 
    if (strlen($texto) > $tamano) 
	{ 
		for ($i=0; $i <= $tamano - 1; $i++) { 
			// Añadimos uno por uno cada caracter del texto 
			// original al texto final, habiendo puesto 
			// como limite la variable $tamano 
			$textoFinal .= $texto[$i]; 
		} 
		 // devolvemos el texto final 
    	return $textoFinal."..."; 
	}else{
    	return $texto; 
	}
   
} 

$pdf=new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

function array_recibe($url_array) { 
    $tmp = stripslashes($url_array); 
    $tmp = urldecode($tmp); 
    $tmp = unserialize($tmp); 
   return $tmp; 
}
//********************************************************************************************************

$pdf->SetY(100);
$pdf->SetFont('Arial','',12);
/***********************************************************************************************************************
		CONSULTAMOS LAS ODS SELECCIONADAS (ENVIADAS)
***********************************************************************************************************************/	
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS", $co);
		
  		$aLista	=	array_keys($_POST['campos']); 

		$sQuery	=	"SELECT * FROM tb_sol_rec, tb_det_sol WHERE tb_sol_rec.cod_sol = tb_det_sol.cod_sol and tb_det_sol.id_det IN (".implode(',',$aLista).") ORDER BY tb_det_sol.id_det"; 
		$respQ 	= mysql_query($sQuery, $co);
		
		while ($vrows = mysql_fetch_array($respQ)) 
		{
			$lista_fsr[] = $vrows;
		}
		
$pdf->SetDrawColor(150,150,150);
//*************************** LOGO MGYT ****************************************
$pdf->Image('imagenes/logo2.jpg',13,4,23);
$pdf->SetY(4);

//************************* PRIMERA FILA****************************************
$pdf->Cell(30,14," ",1,0,'C'); 
$pdf->Cell(209,14,"LISTADO SOLICITUDES DE RECURSOS",1,0,'C',$fill); 
$pdf->SetFont('Arial','',8);

$pdf->Cell(37,5,"SGI-MAE-R-XXX",1,1,'L'); 

$pdf->Cell(239,5," ",0,0,'C'); 
$pdf->Cell(37,5,"FECHA: 09/10/2010",1,1,'L'); 

$pdf->Cell(239,4," ",0,0,'C'); 
$pdf->Cell(37,4,"VERSION: 00",1,1,'L'); 

/*************************************************************************************************************************
			
**************************************************************************************************************************/

	$ani   = 10; // ancho Item	
	$total =  count($lista_fsr);
	$i     = 0;
	$pdf->Cell(276,2,"",1,1,'L');
	
	$pdf->SetY(27);
	$pdf->SetFillColor(240,240,240);
	$fondo = true;
	
	while($i < $total)
	{
		
		$cod_sol 		= $lista_fsr[$i]['cod_sol'];
		$area_sol 		= $lista_fsr[$i]['area_sol'];
		$ods_sol 		= $lista_fsr[$i]['ods_sol'];	
		$cc_sol 		= $lista_fsr[$i]['cc_sol'];	
		$desc_sol 		= $lista_fsr[$i]['desc_sol'];
		$und_med 		= $lista_fsr[$i]['und_med'];
		$cant_det 		= $lista_fsr[$i]['cant_det'];
		$fe_aprob_g 	= $lista_fsr[$i]['fe_aprob_g'];
		$fe_en_obra 	= $lista_fsr[$i]['fe_en_obra'];
		$rec_det 		= $lista_fsr[$i]['rec_det'];
		$cant_rec 		= $lista_fsr[$i]['cant_rec'];
		$prof_sol 		= $lista_fsr[$i]['prof_sol'];
		
		$sql_a	= "SELECT * FROM tb_areas WHERE cod_ar='$area_sol' ";
		$res	= mysql_query($sql_a,$co);
		while($vrows=mysql_fetch_array($res))
		{
			$desc_ar	= "".$vrows['desc_ar']."";
		}
		
		$sql_um	= "SELECT * FROM tb_und_med WHERE cod_um='$und_med' ";
		$res_um	= mysql_query($sql_um,$co);
		while($vrows=mysql_fetch_array($res_um))
		{
			$nom_um	= "".$vrows['nom_um']."";
		}

			$fe_aprob_g		=	cambiarFecha($fe_aprob_g, '-', '/' );
			$fe_en_obra		=	cambiarFecha($fe_en_obra, '-', '/' );
			
			if($fe_aprob_g == "00/00/0000"){ $fe_aprob_g = "";}
			if($fe_en_obra == "00/00/0000"){ $fe_en_obra = "";}
			
			if($cant_rec == 0){ $cant_rec = "";}
			$prof_sol = substr(utf8_decode($prof_sol), 0, 30);

			$pdf->Cell(30,6,utf8_decode($desc_ar),1,0,'L',$fondo);						
			$pdf->Cell(13,6,"$cod_sol",1,0,'L',$fondo);				
			$pdf->Cell(15,6,"$ods_sol",1,0,'L',$fondo);	
			$pdf->Cell(15,6,"$cc_sol",1,0,'L',$fondo);
			$pdf->Cell(129,6,cortarTexto(utf8_decode($desc_sol), 85),1,0,'L',$fondo);
			$pdf->Cell(10,6,"$cant_det",1,0,'L',$fondo);
			$pdf->Cell(17,6,"$fe_aprob_g",1,0,'L',$fondo);
			$pdf->Cell(17,6,"$fe_en_obra",1,0,'L',$fondo);
			$pdf->Cell(20,6,"$rec_det",1,0,'L',$fondo);
			$pdf->Cell(10,6,"$cant_rec",1,1,'L',$fondo);
			if($fondo == true){ $fondo = false; }else{ $fondo = true; }
			
			$i++;
	}

	$pdf->Output();
?>