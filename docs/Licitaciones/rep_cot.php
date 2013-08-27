<?php
require('fpdf.php');
$pdf=new FPDF();
$pdf->AddPage();
include ('inc/config_db.php');
$fe	=	date("d/m/Y");

class PDF extends FPDF
{
	// Cabecera de pagina
	function Header()
	{
	
	}
	function Footer()
	{
		//Posición: a 1,5 cm del final
		$this->SetY(-25);
		//Arial Black de 10
		$this->SetFont('Arial','',10);
		//Número de página
		$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

$pdf=new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFillColor(200,220,255);
/*********************************************************************************************************
	Función Para Cambiar el Formato de la Fecha
**********************************************************************************************************/
function cambiarFecha( $sFecha, $sSimboloInicial, $sSimboloFinal )
{
	return implode( $sSimboloFinal, array_reverse( explode( $sSimboloInicial, $sFecha ) ) ) ; 
} 

function FechaFormateada2($FechaStamp)
{ 
  $ano = date('Y',$FechaStamp);
  $mes = date('n',$FechaStamp);
  $dia = date('d',$FechaStamp);
  $diasemana = date('w',$FechaStamp);

  $diassemanaN= array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"); $mesesN=array(1=>"Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  return $diassemanaN[$diasemana].", $dia de ". $mesesN[$mes] ." de $ano";
}
//********************************************************************************************************


/*********************************************************************************************************
	Función Para cortar una cadena en un numero de partes
**********************************************************************************************************/
function cortar($texto,$largo)
{
	$linea=array();
	$i=0;
	
	$aux	= explode(" ",$texto);
	foreach($aux as $palabra)
	{
		$aux2=$linea[$i].$palabra." ";
		
		if(strlen($aux2) > $largo)
		{
			$i++;
		}
		$linea[$i] .= $palabra." ";
	}
	return $linea;
}
//********************************************************************************************************
$fecha = time();
$pdf->SetFont('Arial','',12);
$pdf->SetY(10); 
$pdf->SetDrawColor(167,167,167); 
$pdf->SetLineWidth(0.4);
$pdf->SetMargins(12,7);

$co=mysql_connect("$DNS","$USR","$PASS");
mysql_select_db("$BDATOS", $co);
	
$num_cot	= $_GET['num_cot'];
	
	$sqlc		= "SELECT * FROM tb_cotizaciones WHERE num_cot = '".$_GET['num_cot']."' ";
	$res		= mysql_query($sqlc, $co);
	$cont 		= mysql_num_rows($res);
	
	if($cont != 0)
	{
		while($vrows=mysql_fetch_array($res))
		{
			$num_cot		= "".$vrows['num_cot']."";
			$tipo_ing		= "".$vrows['tipo_ing']."";
			$desc_cot		= "".$vrows['desc_cot']."";
			$fe_ing_cot		= "".$vrows['fe_ing_cot']."";
			$fe_sal_cot		= "".$vrows['fe_sal_cot']."";
			$fe_cons_cot	= "".$vrows['fe_cons_cot']."";
			$fe_resp_cot	= "".$vrows['fe_resp_cot']."";
			$fe_ent_cot		= "".$vrows['fe_ent_cot']."";
			$emp_cot		= "".$vrows['emp_cot']."";
			$estado_cot		= "".$vrows['estado_cot']."";
			$cliente_cot	= "".$vrows['cliente_cot']."";
			$contacto_cot	= "".$vrows['contacto_cot']."";
			$resp_cot		= "".$vrows['resp_cot']."";
			$obs_cot		= "".$vrows['obs_cot']."";
			$ing_por_cot	= "".$vrows['ing_por_cot']."";
			$fe_ingr_cot	= "".$vrows['fe_ingr_cot']."";
		}
			$sql_cli = "SELECT razon_s FROM tb_clientes WHERE rut_cli = '$cliente_cot' ";
			$res=mysql_query($sql_cli,$co);
			while($vrowsc=mysql_fetch_array($res))
			{
				$cliente_cot	= "".$vrowsc['razon_s']."";
			}
			
			$sql_res = "SELECT nom_resp FROM tb_responsable WHERE rut_resp = '$resp_cot' ";
			$res = mysql_query($sql_res,$co);
			while($vrowsr = mysql_fetch_array($res))
			{
				$resp_cot	= "".$vrowsr['nom_resp']."";
			}
	}
$fe_ing_cot		=	cambiarFecha($fe_ing_cot, '-', '/' );
$fe_sal_cot		=	cambiarFecha($fe_sal_cot, '-', '/' );
$fe_cons_cot	=	cambiarFecha($fe_cons_cot, '-', '/' );
$fe_resp_cot	=	cambiarFecha($fe_resp_cot, '-', '/' );
$fe_ent_cot		=	cambiarFecha($fe_ent_cot, '-', '/' );
	mysql_close($co);
//*************** LOGO MGYT *****************************
$pdf->Image('../imagenes/logo_mgyt_c.jpg',12,10,30);
//************** PRIMERA FILA ***************************

$pdf->Cell(30,15," ",0,0,'C'); 
$pdf->Cell(128,15,strtoupper($tipo_ing),0,0,'C'); 
$pdf->SetFont('Arial','B',7);

$pdf->Cell(12,5,"",0,0,'C'); 
$pdf->Cell(25,5,"",0,1,'L'); 

$pdf->SetY(15);

$pdf->Cell(148,5," ",0,0,'C'); 
$pdf->Cell(12,5,"",0,0,'C'); 
$pdf->Cell(25,5,"",0,1,'L'); 

$pdf->Cell(148,5," ",0,0,'C'); 
$pdf->Cell(37,5,FechaFormateada2($fecha),0,1,'C'); 
$pdf->Cell(148,5," ",0,0,'C'); 
$pdf->Cell(37,5,"Rokcmine S.A.",0,1,'C'); 

$pdf->SetLineWidth(0.2);
$pdf->SetY(25);
//************** SEGUNDA FILA ***************************															
$pdf->ln(15);								
//************* TERCERA FILA ****************************

/****************************************************************************************************************************************************************************
		DIBUJAMOS LOS CUADRADOS 
*****************************************************************************************************************************************************************************/
$pdf->SetLineWidth(0.4);
$pdf->Line(10, 34, 201, 34);
$pdf->Line(10, 34, 10, 250); // Vertical
$pdf->Line(10, 250, 201, 250);
$pdf->Line(201, 34, 201, 250); // Vertical
$pdf->SetLineWidth(0.2);	
/****************************************************************************************************************************************************************************
****************************************************************************************************************************************************************************/
$pdf->Cell(40,6,"Descripcion Trabajo",0,0,'L');	
$pdf->Cell(145,6,utf8_decode($desc_cot),1,1,'L');
$pdf->ln(1);

$pdf->Cell(40,6,"Cliente",0,0,'L');	
$pdf->Cell(145,6,utf8_decode($cliente_cot),1,1,'L');

$pdf->ln(1);

$pdf->Cell(40,6,"Contacto",0,0,'L');	
$pdf->Cell(145,6,utf8_decode($contacto_cot),1,1,'L');
$pdf->ln(1);

$pdf->Cell(40,6,"Empresa",0,0,'L');	
$pdf->Cell(145,6,utf8_decode($emp_cot),1,1,'L');
$pdf->ln(1);

$pdf->Cell(40,6,"Responsable",0,0,'L');	
$pdf->Cell(145,6,utf8_decode($resp_cot),1,1,'L');
$pdf->ln(1);

$pdf->Cell(40,6,"Estado",0,0,'L');
$pdf->Cell(50,6,"$estado_cot",1,0,'L');
$pdf->Cell(5,6,"",0,0,'L');

$pdf->Cell(40,6,"Fecha Ingreso",0,0,'L');

$pdf->Cell(50,6,"$fe_ing_cot",1,1,'l');
$pdf->ln(1);

$pdf->Cell(40,6,"Fecha Salida Terreno",0,0,'L');	
$pdf->Cell(50,6,"$fe_sal_cot",1,0,'L');
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(40,6,"Fecha Consulta",0,0,'L');
$pdf->Cell(50,6,"$fe_cons_cot",1,1,'l');
$pdf->ln(1);

$pdf->Cell(40,6,"Fecha Respuesta",0,0,'L');	
$pdf->Cell(50,6,"$fe_resp_cot",1,0,'L');
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(40,6,"Fecha Entrega",0,0,'L');
$pdf->Cell(50,6,"$fe_ent_cot",1,1,'l');
$pdf->ln(1);

$pdf->Cell(40,6,"Observaciones",0,0,'L');	
$pdf->MultiCell(145,5,utf8_decode($obs_cot),1,'L'); 

$pdf->Output();
?>