<?php
require('fpdf.php');
$pdf=new FPDF();
$pdf->AddPage();

include ('funciones/conexion.php');
$fe	=	date("d/m/Y");
$hr	=	date("G : i : s A");
class PDF extends FPDF
{
	// Cabecera de pagina
	function Header()
	{
		global $title;
		$this->Ln(10);
		//Arial bold 15
		$this->SetFont('Arial','B',6);
		
		//Colores de los bordes, fondo y texto
		$this->SetDrawColor(150,150,150);
		$this->SetFillColor(120,120,120);
		$this->SetTextColor(255,255,255);
		
		$this->Cell(17,6,"NUMERO",1,0,'L',true);						
		$this->Cell(16,6,"TIPO",1,0,'L',true);				
		$this->Cell(30,6,"NOMBRE/TRABAJO",1,0,'L',true);	
		$this->Cell(20,6,"FECH/INGRESO",1,0,'L',true);
		$this->Cell(25,6,"FECH/VISIT/TERRENO",1,0,'L',true);
		$this->Cell(20,6,"FECH/ENTREGA",1,0,'L',true);
		$this->Cell(20,6,"E/SERVICIO",1,0,'L',true);
		$this->Cell(20,6,"ESTADO",1,0,'L',true);
		$this->Cell(24,6,"CLIENTE",1,0,'L',true);
		$this->Cell(26,6,"RESPONSABLE",1,0,'L',true);
		$this->Cell(58,6,"OBSERVACIONES",1,1,'L',true);
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
$pdf->SetFont('Arial','',14);

	/*$array=$_GET['array']; 
	 // el método de envio usado. (en el ejemplo un link genera un GET. En el formulario se usa POST podria ser GET tambien ...) 
	$array=array_recibe($array); 
	
	foreach ($array as $indice => $valor){ 
	
	$pdf->Cell(150,10,"$valor",1,1,'L'); 

	} */
/***********************************************************************************************************************
		CONSULTAMOS LAS ODS SELECCIONADAS (ENVIADAS)
***********************************************************************************************************************/	
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS", $co);
		
		//$aLista	=	array_keys($_POST['campos']);
  		$sQuery	=	"SELECT * FROM ingreso ORDER BY num_ing";
		//$sQuery = "SELECT * FROM ingreso WHERE num_ing = '$aLista'";
		$respQ 	= mysql_query($sQuery, $co);

		while ($vrows = mysql_fetch_array($respQ)) 
		{
			$listado[] = $vrows;
		}
		
$pdf->SetDrawColor(150,150,150);

		
//*************************** LOGO MGYT ****************************************
$pdf->Image('imagenes/logo_mgyt_c.jpg',13,4,23);
$pdf->SetY(4);

//************************* PRIMERA FILA****************************************
$pdf->Cell(30,14," ",1,0,'C'); 
$pdf->Cell(209,14,"RESUMEN DE INGRESOS",1,0,'C',$fill); 
$pdf->SetFont('Arial','',8);

$pdf->Cell(37,5,"Hora: $hr",1,1,'L'); 

$pdf->Cell(239,5," ",0,0,'C'); 
$pdf->Cell(37,5,"FECHA: $fe",1,1,'L'); 

$pdf->Cell(239,4," ",0,0,'C'); 
$pdf->Cell(37,4,"VERSION: 02",1,1,'L'); 
/*************************************************************************************************************************
			
**************************************************************************************************************************/
	$ani   = 10; // ancho Item	
	$total =  count($listado);
	$i     = 0;
	$pdf->Cell(276,2,"",1,1,'L');
	
	$pdf->SetY(27);
	$pdf->SetFillColor(240,240,240);
	$fondo = true;
	
	while($i < $total)
	{
		$numero 		= $listado[$i]['num_ing'];
		$tipo 			= $listado[$i]['tipo_ing'];
		$priori 		= $listado[$i]['nombretrabajo'];	
		$fingreso 		= $listado[$i]['fechaingreso'];	
		$fvisita 		= $listado[$i]['fechavisitaterreno'];
		$fconsulta	 	= $listado[$i]['fconsulta'];
		$frespuesta	 	= $listado[$i]['frespuesta'];
		$fentrega	 	= $listado[$i]['fechaentrega'];
		$empresa 		= $listado[$i]['empresacampo'];
		$estado 		= $listado[$i]['estado'];
		$cliente 		= $listado[$i]['clientecampo'];
		$responsable 	= $listado[$i]['responsablecampo'];
		$observa 		= $listado[$i]['observaciones'];
		
			$fe_in_ret		=	cambiarFecha($fe_in_ret, '-', '/' );
			$usuario = substr(utf8_decode($usuario), 0, 30);//cantidad de caracteres que quiero imprimir 30

			$pdf->Cell(17,6,"$numero",1,0,'L',$fondo);						
			$pdf->Cell(16,6,utf8_decode($tipo),1,0,'L',$fondo);				
			$pdf->Cell(30,6,utf8_decode($priori),1,0,'L',$fondo);	
			$pdf->Cell(20,6,"$fingreso",1,0,'L',$fondo);
			$pdf->Cell(25,6,"$fvisita",1,0,'L',$fondo);
			$pdf->Cell(20,6,"$fentrega",1,0,'L',$fondo);
			$pdf->Cell(20,6,utf8_decode($empresa),1,0,'L',$fondo);
			$pdf->Cell(20,6,utf8_decode($estado),1,0,'L',$fondo);
			$pdf->Cell(24,6,utf8_decode($cliente),1,0,'L',$fondo);
			$pdf->Cell(26,6,"$responsable",1,0,'L',$fondo);
			$pdf->Cell(58,6,"$observa",1,1,'L',$fondo);
			if($fondo == true){ $fondo = false; }else{ $fondo = true; }
			$i++;
			//$totalp = $totalp + $precio;
	}
	$pdf->Output();
?>