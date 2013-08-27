<?php
require('fpdf.php');
include ('inc/config_db.php');
$fe=date("d/m/Y");
class PDF extends FPDF
{
	function Header()
	{
	
	}
	//Pie de página
	function Footer()
	{
		//Posición: a 1,5 cm del final
		$this->SetY(-15);
		//Arial Black de 10
		$this->SetFont('Arial','B',10);
		//Número de página
		$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

$pdf=new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetY(2);

$cod=$_GET['c_inf'];

/*********************************************************************************************************
//Función Para Cambiar el Formato de la Fecha
**********************************************************************************************************/
function cambiarFecha( $sFecha, $sSimboloInicial, $sSimboloFinal )
{
	return implode( $sSimboloFinal, array_reverse( explode( $sSimboloInicial, $sFecha ) ) ) ; 
} 
/********************************************************************************************************/

	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS",$co);
	
	$sqlCon="SELECT * FROM inf_diario2, detalle_inf2, trabajadores WHERE inf_diario2.cod_inf = '$cod' and inf_diario2.cod_inf = detalle_inf2.cod_inf and trabajadores.rut_t = detalle_inf2.rut_t ORDER BY detalle_inf2.id_det";
	$respuesta=mysql_query($sqlCon,$co);
	
	while ($row = mysql_fetch_array($respuesta)) {
    	$inf_diario[] = $row; 
	}
	
	$area 		= $inf_diario[0]['area_inf'];
	$fecha_inf  = $inf_diario[0]['fecha_inf'];
	$env_por    = $inf_diario[0]['env_por'];
	/****************************************************************/
	/****************************************************************/
	$sql_a 		= "SELECT * FROM tb_areas WHERE cod_ar = '$area' ";
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
	
	$i=0;
	$total_det 	= count($inf_diario);
//*************** LOGO MGYT ********************************************************
$pdf->Image('imagenes/logo2.jpg',12,3,24);

//************** PRIMERA FILA ******************************************************
$pdf->SetDrawColor(150,150,150);
$pdf->SetFillColor(120,120,120);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',12);

$pdf->Line('10', '15', '10', '50');
$pdf->Line('285', '15', '285', '50');
 
$pdf->Cell(30,15,"",1,0,'C'); 
$pdf->Cell(215,15,"INFORME DIARIO DE ACTIVIDAD DE PERSONAL",1,0,'C'); 

$pdf->SetFont('Arial','',8);
$pdf->Cell(30,5,"SGI-MAE-R- ? ",1,0,'L'); 
$pdf->SetY(7);

$pdf->Cell(245,5," ",0,0,'C');
$pdf->Cell(30,5,"05/01/2009",1,1,'L'); 

$pdf->Cell(245,5," ",0,0,'C');
$pdf->Cell(30,5,"VERSION: 01",1,0,'L'); 

$pdf->SetY(17);
$pdf->SetFont('Arial','',12);
//************** SEGUNDA FILA *****************************************************+
$pdf->Cell(195,6,"",0,1,'C'); 

$pdf->SetFont('Arial','',10);

		$ani=6; // ancho Item	
		$fecha_inf		=	cambiarFecha($fecha_inf, '-', '/' );
		$pdf->Cell(30,$ani," FECHA INF:",0,0,'L'); 
		$pdf->Cell(30,$ani,"$fecha_inf",0,0,'L'); 
		$pdf->Cell(25,$ani," GERENCIA: ",0,0,'L');
		$pdf->Cell(40,$ani,utf8_decode($desc_ger),0,0,'L');
		$pdf->Cell(35,$ani," DEPARTAMENTO: ",0,0,'L');
		$pdf->Cell(40,$ani,utf8_decode($desc_dep),0,0,'L');
		$pdf->Cell(20,$ani," AREA: ",0,0,'L');
		$pdf->Cell(40,$ani,utf8_decode($area_t),0,1,'L');
		
		$pdf->Cell(35,$ani," SUPERVISOR: ",0,0,'L'); 
		$pdf->Cell(60,$ani,$_POST['t1'],0,0,'L'); 
		$pdf->Cell(34,$ani,"",0,0,'L');
		$pdf->Cell(60,$ani,utf8_decode($_POST['t6']),0,1,'L');
		
		$pdf->Ln(3);
		
		$pdf->Cell(55,7,"DETALLE POR TRABAJADOR",1,1,'C');
		
		
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(9,$ani,"Nº",1,0,'C',true); 
		$pdf->Cell(64,$ani,"NOMBRE TRABAJADOR",1,0,'C',true);
		$pdf->Cell(35,$ani,"ESTADO",1,0,'C',true);
		$pdf->Cell(45,$ani,"MOTIVO",1,0,'C',true);
		$pdf->Cell(24,$ani," ODS ",1,0,'C',true);
		$pdf->Cell(24,$ani," CC ",1,0,'C',true);
		$pdf->Cell(18,$ani," HRS ",1,0,'C',true); 
		$pdf->Cell(18,$ani,"HH 50%",1,0,'C',true);
		$pdf->Cell(18,$ani,"HH 100%",1,0,'C',true); 
		$pdf->Cell(20,$ani,"TOTAL",1,1,'C',true); 
		$pdf->SetTextColor(0,0,0);
	
	while($i < $total_det)
	{
		$nom_t 		= $inf_diario[$i]['nom_t'];
		$app_t 		= $inf_diario[$i]['app_t'];
		
		$estado_as 	= $inf_diario[$i]['estado_as'];
		$motivo 	= $inf_diario[$i]['motivo'];
		$ods 		= $inf_diario[$i]['ods'];
		$cc 		= $inf_diario[$i]['cc'];
		$hrs 		= $inf_diario[$i]['hrs'];	
		$hh50 		= $inf_diario[$i]['hh50'];
		$hh100 		= $inf_diario[$i]['hh100'];	
		$total 		= $inf_diario[$i]['total'];		
		
		if($ods == 0){$ods = "";}
		
		$pdf->Cell(9,$ani,($i+1),1,0,'L'); 
		$pdf->Cell(64,$ani,utf8_decode($nom_t." ".$app_t),1,0,'L'); 
		$pdf->Cell(35,$ani,"$estado_as",1,0,'L'); 
		$pdf->Cell(45,$ani,"$motivo",1,0,'L');  
		$pdf->Cell(24,$ani,"$ods",1,0,'L');
		$pdf->Cell(24,$ani,utf8_decode($cc),1,0,'L');
		$pdf->Cell(18,$ani,"    ".utf8_decode($hrs),1,0,'L');
		if($hh50 == 0){ $hh50 ="";}
		$pdf->Cell(18,$ani,"    ".utf8_decode($hh50),1,0,'L');
		if($hh100 == 0){ $hh100 ="";}
		$pdf->Cell(18,$ani,"    ".utf8_decode($hh100),1,0,'L');
		
		$pdf->Cell(20,$ani,"    ".utf8_decode($total),1,1,'L'); 
		$i++;
	}
	
		$pdf->Cell(410,2," ",0,1,'C'); 
	
		$pdf->Cell(69,7," INGRESADO POR:",1,0,'L'); 
		$pdf->Cell(60,7,"FIRMA ",1,1,'L');
		 
		$pdf->Cell(69,10,utf8_decode($env_por),1,0,'L');
		$pdf->Cell(60,10,"",1,1,'L');
	
	$pdf->Output();
?>