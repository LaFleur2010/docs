<?php
require('fpdf.php');

$pdf=new FPDF();
$pdf->SetTopMargin(100);
$pdf->AddPage();

include ('../inc/config_db.php');
include ('../inc/DeNumero_a_Letras.php');

$fe	=	date("d/m/Y");

//$pdf->SetAutoPageBreak(0, -100);

class PDF extends FPDF
{
	// Cabecera de pagina
	function Header()
	{
		//*************** LOGO MGYT *****************************
		$this->Image('../imagenes/fondo_cot.jpg',1,3,208);
		
		$this->Image('../imagenes/logo2.jpg',10,10,30);
		$this->Image('../imagenes/logo_iso_c.jpg',40,10,30);
		$this->Line(10, 27, 201, 27); // PRIMERA LINA HORIZONTAL
		//************** PRIMERA FILA ***************************
		$this->Ln(25);
	}
	function Footer()
	{
		//Posición: a 1,5 cm del final
		$this->SetY(-15);
		// Color de texto
		$this->SetTextColor(100, 100, 100);
		
		//Arial Black de 8
		$this->SetFont('Arial','B',8);
		$this->Text(10,286,"Isla Norte 380 Codegua - Rancagua");
		$this->Text(10,290,"Fono (56+72)2977720 - 2977740");
		
		$this->SetFont('Arial','IB',14);
		$this->Text(155, 290, 'WWW.ROCKMINE.CL');
		
		// Color de texto
		//$this->SetTextColor(0, 0, 0);
		
		//Arial Black de 10
		$this->SetFont('Arial','',10);
		//Número de página
		$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
	}
	
	function dibujarLinea($desdeVert, $hastaVert, $desdeHori, $hastaHori)
	{
		$this->SetLineWidth(0.4);
		$this->Line($desdeHori, $desdeVert, $hastaHori, $desdeVert); // Horizontal
		$this->Line($desdeHori, $desdeVert, $desdeHori, $hastaVert); // Vertical
		$this->Line($desdeHori, $hastaVert, $hastaHori, $hastaVert); // Horizontal
		$this->Line($hastaHori, $desdeVert, $hastaHori, $hastaVert); // Vertical
		$this->SetLineWidth(0.2);	
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
  //return $diassemanaN[$diasemana].", $dia de ". $mesesN[$mes] ." de $ano";***  ORIGINAL ***
   return "$dia de ". $mesesN[$mes] ." de $ano";
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
//$pdf->SetDrawColor(167,167,167); 
$pdf->SetLineWidth(0.4);
$pdf->SetMargins(12,7);

$co=mysql_connect("$DNS","$USR","$PASS");
mysql_select_db("$BDATOS", $co);
	
$num_cot	= $_GET['num_cot'];
$opcion     = $_POST['Copcion'];
	
	$sqll = "SELECT comentario From tb_obserbacion where numero = '$num_cot' ";
	$rs   = mysql_query($sqll,$co);

	while ($row = mysql_fetch_array($rs)) {
		
		$comenn = $row['comentario'];
	}
	if ($comenn == 1) {
		$hola = "El contratista no será responsable por los errores de diseño, cálculo y especialidades que pudiera contener los bienes, procesos y planes objeto del servicio.";
	}else{
		$hola = "";
	}

	
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
			$resp_cot2      = "".$vrows['resp_general']."";
			$obs_cot		= "".$vrows['obs_cot']."";
			$ing_por_cot	= "".$vrows['ing_por_cot']."";
			$fe_ingr_cot	= "".$vrows['fe_ingr_cot']."";
			$transp_cot		= "".$vrows['transp_cot']."";
			$moneda_cot		= "".$vrows['moneda_cot']."";
			$conpag_cot		= "".$vrows['conpag_cot']."";
			$plazoent_cot	= "".$vrows['plazoent_cot']."";
			$garantia_cot	= "".$vrows['garantia_cot']."";			
			$valof_cot		= "".$vrows['valof_cot']."";
			$multas         = "".$vrows['por_multas']."";
			$modificaciones = "".$vrows['por_modificaciones']."";	
		}
			$co=mysql_connect("$DNS","$USR","$PASS");
			mysql_select_db("$BDATOS", $co);

			$SqlDet = "SELECT * FROM tb_cot_det, tb_und_med WHERE tb_cot_det.num_cot = '$num_cot' and tb_cot_det.und_detc = tb_und_med.cod_um ORDER BY tb_cot_det.id_det";
			$ResDet = mysql_query($SqlDet,$co);
			while ($VrsDet = mysql_fetch_array($ResDet)) 
			{
				$Det_Cot[] = $VrsDet;
			}
			
			$SqlAlc = "SELECT * FROM tb_cot_alc WHERE num_cot = '$num_cot' ORDER BY id_alc";
			$ResAlc = mysql_query($SqlAlc,$co);
			while ($VrsAlc = mysql_fetch_array($ResAlc)) 
			{
				$Alc_Cot[] = $VrsAlc;
			}
			
			$sql_cli = "SELECT razon_s, rut_cli FROM tb_clientes WHERE id_cli = '$cliente_cot'  ";
			$res     = mysql_query($sql_cli,$co);
			while($vrowsc=mysql_fetch_array($res))
			{
				$cliente = "".$vrowsc['razon_s']."";
				$rut_cli = "".$vrowsc['rut_cli']."";
			}
			
			$sql_con = "SELECT * FROM tb_contacto_cli WHERE nom_cont = '$contacto_cot'";
			$res_con = mysql_query($sql_con, $co);
			while($vrows_con=mysql_fetch_array($res_con))
			{
				$mail_cont 	= "".$vrows_con['mail_cont']."";
				$nom_cont  	= "".$vrows_con['nom_cont']."";
				$cargo_cont = "".$vrows_con['cargo_cont']."";
				$fono_cont 	= "".$vrows_con['fono_cont']."";
			}
			
			$sql_res = "SELECT nom_resp, fono_resp, mail_resp, cargo_resp FROM tb_responsable WHERE rut_resp = '$resp_cot' ";
			$res = mysql_query($sql_res,$co);
			while($vrowsr = mysql_fetch_array($res))
			{
				$nom_resp	= "".$vrowsr['nom_resp']."";
				$fono_resp	= "".$vrowsr['fono_resp']."";
				$mail_resp	= "".$vrowsr['mail_resp']."";
				$cargo_resp	= "".$vrowsr['cargo_resp']."";
			}

			$sql_res2 = "SELECT nom_resp,cargo_resp FROM tb_responsable WHERE rut_resp = '$resp_cot2' ";
			$res = mysql_query($sql_res2,$co);
			while($vrowsr = mysql_fetch_array($res))
			{
				$nom_cot2	= "".$vrowsr['nom_resp']."";
				$cargo_resp2  = "".$vrowsr['cargo_resp']."";
			}
	}
	
$fe_ing_cot		=	cambiarFecha($fe_ing_cot, '-', '/' );
$fe_sal_cot		=	cambiarFecha($fe_sal_cot, '-', '/' );
$fe_cons_cot	=	cambiarFecha($fe_cons_cot, '-', '/' );
$fe_resp_cot	=	cambiarFecha($fe_resp_cot, '-', '/' );
$fe_ent_cot		=	cambiarFecha($fe_ent_cot, '-', '/' );

mysql_close($co);

$pdf->SetFont('Arial','B',10);

$pdf->Cell(12,5,"", $marcocelda,0,'C'); 
$pdf->Cell(25,5,"", $marcocelda,1,'L'); 

$pdf->SetY(17);

$pdf->Cell(148,5," ", $marcocelda,0,'C'); 
$pdf->Cell(12,5,"", $marcocelda,0,'C'); 
$pdf->Cell(25,5,"", $marcocelda,1,'L'); 

$pdf->ln(7);
$pdf->Cell(143,5," ", $marcocelda,0,'C'); 
$pdf->Cell(42,5,"Rancagua, ".FechaFormateada2($fecha),0,1,'C'); 

// Generales

$anchotitulo = 65;
$alto  = 8;
$marcocelda = 0;
$anchodesc= 124;
/**********************************************************
	CUADRADO NUMERO 1
**********************************************************/
$pdf->dibujarLinea(38, 60, 10, 201);
/*********************************************************/
$pdf->SetY(39);
$pdf->Cell($anchotitulo, $alto,"Cotizacion:", $marcocelda,0,'L');
$pdf->Cell($anchodesc,$alto,$num_cot, $marcocelda,1,'L'); 

$pdf->Cell($anchotitulo, $alto,"Referencia:", $marcocelda,0,'L');
$pdf->MultiCell($anchodesc,4,utf8_decode($desc_cot), $marcocelda,'L'); 

$pdf->SetLineWidth(0.2);
$pdf->SetY(58);												
$pdf->ln(11);								
/********************************************************
	CUADRADO Nº 2
********************************************************/
$pdf->dibujarLinea(65, 132, 10, 201);
/*********************************************************/
$pdf->SetFont('Arial','B',12);
$pdf->Cell($anchotitulo,4,"Identificacion del Cliente:", $marcocelda,1,'L');
$pdf->SetFont('Arial','B',10);
$pdf->ln(4);

$pdf->Cell($anchotitulo, $alto,"Cliente", $marcocelda,0,'L');	
$pdf->Cell($anchodesc, $alto, $cliente, $marcocelda,1,'L');
$pdf->ln(1);

$pdf->Cell($anchotitulo, $alto,"Rut", $marcocelda, 0,'L');	
$pdf->Cell($anchodesc, $alto, $rut_cli, $marcocelda, 1,'L');
$pdf->ln(1);

$pdf->Cell($anchotitulo, $alto,"Atencion:", $marcocelda,0,'L');	
$pdf->Cell($anchodesc, $alto,"$nom_cont", $marcocelda,1,'L');
$pdf->ln(1);

$pdf->Cell($anchotitulo, $alto,"Cargo:", $marcocelda,0,'L');	
$pdf->Cell($anchodesc, $alto,utf8_decode($cargo_cont),$marcocelda,1,'L');
$pdf->ln(1);

$pdf->Cell($anchotitulo, $alto,"Fono:", $marcocelda,0,'L');	
$pdf->Cell($anchodesc, $alto,"$fono_cont ", $marcocelda,1,'L');
$pdf->ln(1);

$pdf->Cell($anchotitulo, $alto,"E-mail:", $marcocelda,0,'L');	
$pdf->Cell($anchodesc, $alto,$mail_cont,$marcocelda,1,'L');
$pdf->ln(10);
/********************************************************
	CUADRADO Nº 3
********************************************************/
$pdf->dibujarLinea(137, 250, 10, 201);
/*********************************************************/
$pdf->SetFont('Arial','B',12);
$pdf->Cell($anchotitulo,4,"Identificacion del Proponente:", $marcocelda,1,'L');	
$pdf->SetFont('Arial','B',10);
$pdf->ln(4);

$pdf->Cell($anchotitulo, $alto,"Nombre / Razón Social", $marcocelda,0,'L');	
$pdf->Cell($anchodesc, $alto,"SOCIEDAD ROCKMINE S.A.", $marcocelda,1,'L');
$pdf->ln(1);

$pdf->Cell($anchotitulo, $alto,"Nombre de Fantasía", $marcocelda,0,'L');	
$pdf->Cell($anchodesc, $alto, "ROCKMINE S.A.", $marcocelda,1,'L');
$pdf->ln(1);

$pdf->Cell($anchotitulo, $alto,"Dirección comercial:", $marcocelda,0,'L');	
$pdf->Cell($anchodesc, $alto,"Codegua Isla Norte 380", $marcocelda,1,'L');
$pdf->ln(1);

$pdf->Cell($anchotitulo, $alto,"Fono:", $marcocelda,0,'L');	
$pdf->Cell($anchodesc, $alto, "(56+72)2977720 - 2977740", $marcocelda,1,'L');
$pdf->ln(1);

$pdf->Cell($anchotitulo, $alto,"Fecha Inicio de Actividades:", $marcocelda,0,'L');	
$pdf->Cell($anchodesc, $alto,"", $marcocelda,1,'L');
$pdf->ln(1);

$pdf->Cell($anchotitulo, $alto,"Pagina WEB:", $marcocelda,0,'L');	
$pdf->Cell($anchodesc, $alto,"www.rockmine.cl",$marcocelda,1,'L');
$pdf->ln(1);

$pdf->Cell($anchotitulo, $alto,"Correo electrónico:", $marcocelda,0,'L');	
$pdf->Cell($anchodesc, $alto,"info@rocminesa.com", $marcocelda,1,'L');
$pdf->ln(1);

$pdf->Cell($anchotitulo, $alto,"Nombre del Representante Legal:", $marcocelda,0,'L');	
$pdf->Cell($anchodesc, $alto, "LEONARDO VICTOR SOTOMAYOR QUIROZ", $marcocelda,1,'L');
$pdf->ln(1);

$pdf->Cell($anchotitulo, $alto,"RUT:", $marcocelda,0,'L');	
$pdf->Cell($anchodesc, $alto,"9.247.471-2", $marcocelda,1,'L');
$pdf->ln(1);

$pdf->Cell($anchotitulo, $alto,"Cargo:", $marcocelda,0,'L');	
$pdf->Cell($anchodesc, $alto,"Gerente General", $marcocelda,1,'L');
$pdf->ln(1);

$pdf->Cell($anchotitulo, $alto,"Email:", $marcocelda,0,'L');	
$pdf->Cell($anchodesc, $alto,"Leonardo.sotomayor@rockminesa.com", $marcocelda,1,'L');
$pdf->ln(30);

/********************************************************
	CUADRADO Nº 3
********************************************************/
$pdf->AddPage(); 
$pdf->ln(10);
$pdf->dibujarLinea(38, 138, 10, 201);
/*********************************************************/
$pdf->SetFont('Arial','B',12);
$pdf->Cell($anchotitulo,4,"Gerencia Operaciones:", $marcocelda,1,'L');	
$pdf->SetFont('Arial','B',10);
$pdf->ln(4);
	
$pdf->Cell($anchotitulo, $alto,"Contacto:", $marcocelda,0,'L');	
$pdf->Cell($anchodesc, $alto,"Miguel Rubio", $marcocelda,1,'L');
$pdf->ln(1);

$pdf->Cell($anchotitulo, $alto,"Fono:", $marcocelda,0,'L');
$pdf->Cell($anchodesc, $alto,"(56+72)2977720 - 2977740", $marcocelda,1,'L');
$pdf->ln(1);

$pdf->Cell($anchotitulo, $alto,"Celular:", $marcocelda,0,'L');
$pdf->Cell($anchodesc, $alto,"66789309", $marcocelda,1,'L');
$pdf->ln(1);

$pdf->Cell($anchotitulo, $alto,"E-mail:", $marcocelda,0,'L');
$pdf->Cell($anchodesc, $alto,"Miguel.Rubio@softtimesa.com", $marcocelda,1,'L');

$pdf->ln(8);

/********************************************************
	CUADRADO Nº 4
********************************************************/
$pdf->SetFont('Arial','B',12);
$pdf->Cell($anchotitulo,4,"Informacion Del Departamento De estudio:", $marcocelda,1,'L');	
$pdf->SetFont('Arial','B',10);
$pdf->ln(4);

$pdf->Cell($anchotitulo, $alto,"Contacto:", $marcocelda,0,'L');	
$pdf->Cell($anchodesc, $alto, utf8_decode($nom_resp), $marcocelda,1,'L');
$pdf->ln(1);

$pdf->Cell($anchotitulo, $alto,"Fono:", $marcocelda,0,'L');
$pdf->Cell($anchodesc, $alto,"(56+72)2977720 - 2977740", $marcocelda,1,'L');
$pdf->ln(1);

$pdf->Cell($anchotitulo, $alto,"Celular:", $marcocelda,0,'L');
$pdf->Cell($anchodesc, $alto,"$fono_resp", $marcocelda,1,'L');
$pdf->ln(1);

$pdf->Cell($anchotitulo, $alto,"E-mail:", $marcocelda,0,'L');
$pdf->Cell($anchodesc, $alto,"$mail_resp ", $marcocelda,1,'L');

$pdf->AddPage(); 
$pdf->ln(10);


$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(185,5,"COTIZACION DEL SERVICIO",0,'C'); 
$pdf->SetFont('Arial','B',10);

$pdf->ln(10);
$pdf->MultiCell(185,5,"Por la presente y junto con saludarle, entrego a usted cotizacion Nº ".$num_cot." correspondiente al servicio de: ".utf8_decode($desc_cot).", en considerarcion al alcance y descripcion de actividades detallado mas adelante:", $marcocelda,'J');
$pdf->ln(3);

$pdf->SetLineWidth(0.2);
//Colores de los bordes, fondo y texto
//$pdf->SetDrawColor(150,150,150);
$pdf->SetFillColor(180,180,180);
//$pdf->SetTextColor(255,255,255);

$pdf->ln(5);
$pdf->SetLineWidth(0.4);
$pdf->Cell(10,6,"ITEM",1,0,'L', TRUE);	
$pdf->Cell(96,6,"DESCRIPCION DEL PRODUCTO",1,0,'L', TRUE);
$pdf->Cell(12,6,"CANT",1,0,'L', TRUE);
$pdf->Cell(19,6,"UND",1,0,'L', TRUE);
$pdf->Cell(25,6,"VALOR UNIT",1,0,'L', TRUE);
$pdf->Cell(27,6,"VALOR TOTAL",1,1,'L', TRUE);
$pdf->SetLineWidth(0.2);

	$i				= 0; // Inicializamos una variable para el while
	$Contador_det	= count($Det_Cot); // contador de detalles
	$pdf->SetFont('Arial','',10);
/*************************************************************************************
			COMENZAMOS EL WHILE DE GASTOS X ODS
*************************************************************************************/
	while($i < $Contador_det)
	{
		$id_det 		= $Det_Cot[$i]['id_det'];
		$desc_detc 		= $Det_Cot[$i]['desc_detc'];
		$cant_detc 		= $Det_Cot[$i]['cant_detc'];
		$und_detc 		= $Det_Cot[$i]['und_detc'];
		$nom_um 		= $Det_Cot[$i]['nom_um'];
		$unit_detc 		= $Det_Cot[$i]['unit_detc'];
		
		$total_item     = $cant_detc * $unit_detc;
		$total_det   	= ($total_det + $total_item); // Calculamos el total de los gastos de la ODS
		
		$pdf->Cell(10,6,$i+1,1,0,'L');	
		$valory = $pdf->Gety();
		$pdf->SetXY(118, $valory);
		$pdf->Cell(12,6,$cant_detc,1,0,'L');
		$pdf->Cell(19,6,$nom_um,1,0,'L');
		$pdf->Cell(25,6,number_format($unit_detc, 0, ",", "."),1,0,'L');
		$pdf->Cell(27,6,number_format($total_item, 0, ",", "."),1,0,'L');
		$pdf->SetXY(22, $valory);
		$pdf->MultiCell(96,6,utf8_decode($desc_detc),1,'J');
		$valory2 = $pdf->Gety();

		
		
		
		//$pdf->SetY($valory2+1);
		if($i == ($Contador_det - 1)){$pdf->SetY($valory2);}else{$pdf->SetY($valory2 + 1);}
		
		if($pdf->GetY() >= 255){$pdf->AddPage(); $pdf->SetY(30);}
		$i++;
	}

		//$pdf->SetLineWidth(0.4);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(118,6,"",0,0,'L');
		$pdf->Cell(44,6,"VALOR TOTAL NETO ",1,0,'R', TRUE);
		$pdf->Cell(27,6,number_format($total_det, 0, ",", "."),1,1,'L', TRUE);
		$pdf->Cell(118,6,"",0,0,'L');
		$pdf->Cell(44,6,"IVA 19% ",1,0,'R', TRUE);
		$pdf->Cell(27,6,number_format($total_det * 0.19, 0, ",", "."),1,1,'L', TRUE);
		$pdf->Cell(118,6,"",0,0,'L');
		$pdf->Cell(44,6,"TOTAL ",1,0,'R', TRUE);
		$pdf->Cell(27,6,number_format($total_det * 1.19, 0, ",", "."),1,1,'L', TRUE);
		$pdf->SetLineWidth(0.2);
		
		$pdf->ln(10);
		$montototalconiva = floor(($total_det * 1.19)); // ceil
		$valorenpalabras = Numero_a_Letras($montototalconiva);
		$pdf->MultiCell(185,5,"El Servicio asciende al valor Total ($moneda_cot): $".number_format($total_det, 0, ",", ".")." - (".html_entity_decode($valorenpalabras)." $moneda_cot) + IVA", $marcocelda,'L');
		
		$pdf->ln(152);
		
		$pdf->MultiCell(185,5,"ALCANCE DEL SERVICIO",0,'J');
		$pdf->ln(3);
		
		$x				= 0; // Inicializamos una variable para el while
		$Contador_alc	= count($Alc_Cot); // contador de detalles
		$pdf->SetFont('Arial','',10);
	/*************************************************************************************
				COMENZAMOS EL WHILE DE ALCANCES POR COT/LIC
	*************************************************************************************/
		while($x < $Contador_alc)
		{
			$id_alc 		= $Alc_Cot[$x]['id_alc'];
			$desc_alcc 		= $Alc_Cot[$x]['desc_alcc'];
			$tipo_alcc 		= $Alc_Cot[$x]['tipo_alcc'];

			$valory = $pdf->Gety();
			$pdf->SetXY(12, $valory);
			
			if($tipo_alcc == 1)
			{
				$pdf->SetFont('Arial','B',10);
				$pdf->MultiCell(189,6,utf8_decode($desc_alcc),0,'J');
			}

			if($tipo_alcc == 0)
			{
				$pdf->SetFont('Arial','',10);
				$pdf->ln(3);
				$pdf->Cell(9,6,$pdf->Image('../img/punto.jpg',$pdf->GetX()+5,$pdf->GetY()+2,2),0,0,'L');
				$pdf->MultiCell(180,6,utf8_decode($desc_alcc),0,'J');	
			}
			
			
			
			$valory2 = $pdf->Gety();

			//$pdf->SetY($valory2+1);
			if($x == ($Contador_det - 1)){$pdf->SetY($valory2);}else{$pdf->SetY($valory2 + 1);}
			
			if($pdf->GetY() >= 255){$pdf->AddPage(); $pdf->SetY(30);}
			$x++;
		}
		
		

		$pdf->AddPage(); 
		$pdf->ln(10);


		$pdf->SetFont('Arial','B',12);
		$pdf->MultiCell(185,5,"CONDICIONES GENERALES Y COMERCIALES PRELIMINARES",0,'C'); 
		$pdf->SetFont('Arial','B',10);

		$pdf->ln(10);
		$pdf->MultiCell(185,5,"".$hola."", $marcocelda,'J');
		$pdf->ln(3);
		$pdf->MultiCell(185,5,"La oferta se efectúa considerando sueldos de mercado, la legislación y normativas actualmente vigentes a la fecha del contrato.", $marcocelda,'J');
		$pdf->ln(3);
		$pdf->MultiCell(185,5,"La oferta se efectúa considerando que el tope máximo de multas e indemnuzaciones será de un ".$multas."% del precio mensual del contrato, salvo en caso de dolo. De igual forma, la oferta considera que entre las partes solo habrá responsabilidad por daños directos debidamente comprabados, excluyéndose lucro cesante, daño moral y cualquier otra clase de daño colateral.", $marcocelda,'J');
		$pdf->ln(3);
		$pdf->MultiCell(185,5,"Los precios de la oferta han sido calculados tomando en cuenta las exigencias contempladas en los antecedentes de la cotización y considerando los recursos necesarios para cumplirlas bajo parámetros previsibles y rangos normales de la industria.", $marcocelda,'J');
		$pdf->ln(3);
		$pdf->MultiCell(185,5,"La oferta se efectúa considerando que las multas por incumplimiento tienen carácter compensatorio y como avaluó anticipado de perjuicios.", $marcocelda,'J');
		$pdf->ln(3);
		$pdf->MultiCell(185,5,"Aspectos relacionados a resolución de conflictos, se acordara arbitraje, dejando solo como última instancia la posibilidad de las partes a someter el caso a la competencia jurisdicción de los tribunales ordinarios de justicia.", $marcocelda,'J');
		$pdf->ln(3);
		$pdf->MultiCell(185,5,"El contratista realizara las acciones para remediar o mitigar cualquer incapacidad para cumplir sus obligaciones que sea consecuencia de un evento constitutivo de fuerza mayor, y el mandante se compromete a reembolsar los sobrecostos en que el contratista haya incurrido en la realización de dichos esfuerzos.", $marcocelda,'J');
		$pdf->ln(3);
		$pdf->MultiCell(185,5,"Los términos y detalles definitivos del contrato serán convenidos de común acuerdo entre las partes.", $marcocelda,'J');
		$pdf->ln(3);
		$pdf->Cell(9,6,$pdf->Image('../img/punto.jpg',$pdf->GetX()+5,$pdf->GetY()+2,2),0,0,'J');
		$pdf->MultiCell(180,6,"Valores unitarios en: ".utf8_decode($moneda_cot)." no incluyen IVA.", $marcocelda,'J');
		$pdf->ln(3);
		$pdf->Cell(9,6,$pdf->Image('../img/punto.jpg',$pdf->GetX()+5,$pdf->GetY()+2,2),0,0,'J');
		$pdf->MultiCell(185,5,"La oferta se efectúa considerando la legislación actualmente vigente", $marcocelda,'J');
		$pdf->ln(3);
		$pdf->Cell(9,6,$pdf->Image('../img/punto.jpg',$pdf->GetX()+5,$pdf->GetY()+2,2),0,0,'J');
		$pdf->MultiCell(180,5,"En caso que el cliente solicite reparaciones, compra de equipos o materiales, se cobrara un ".$modificaciones."% sobre el monto facturado y costos asociados por la gestión de compra.", $marcocelda,'J');
		$pdf->ln(3);
		$pdf->Cell(9,6,$pdf->Image('../img/punto.jpg',$pdf->GetX()+5,$pdf->GetY()+2,2),0,0,'J');
		$pdf->MultiCell(185,5,"Los terminos y condiciones adjuntas, forman parte integrante de la presente oferta.", $marcocelda,'J');
		$pdf->ln(3);
		$pdf->Cell(9,6,$pdf->Image('../img/punto.jpg',$pdf->GetX()+5,$pdf->GetY()+2,2),0,0,'J');
		$pdf->MultiCell(180,6,"Condiciones de pago: ".utf8_decode($conpag_cot),0,'J');
		$pdf->ln(3);
		$pdf->Cell(9,6,$pdf->Image('../img/punto.jpg',$pdf->GetX()+5,$pdf->GetY()+2,2),0,0,'J');
		$pdf->MultiCell(180,6,"Validez de la oferta: ".utf8_decode($valof_cot),0,'J');
		$pdf->ln(3);
		$pdf->Cell(9,6,$pdf->Image('../img/punto.jpg',$pdf->GetX()+5,$pdf->GetY()+2,2),0,0,'J');
		$pdf->MultiCell(180,6,"Garantia: ".utf8_decode($garantia_cot),0,'J');
		$pdf->ln(95);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(189,6,"", $marcocelda,1,'J');
		$pdf->ln(3);
		$pdf->Cell(189,6,"Favor emitir orden de compra a nombre de COMERCIAL Y MINERIA ROCKMINE S.A.", $marcocelda,1,'J');
		$pdf->Cell(189,6,"RUT 78.944.860-4, haciendo referencia al numero de esta cotización", $marcocelda,1,'L');
		$pdf->ln(3);

		//ESTO YA NO ES VALIDO
		/*if($pdf->GetY() > 260){$pdf->AddPage(); $pdf->SetY(90);}
		$pdf->ln(29);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(90,6,"", $marcocelda,0,'L');
		$pdf->Cell(10,6,"----------------------------------", $marcocelda,1,'C');
		$pdf->Cell(90,6,"", $marcocelda,0,'L');
		$pdf->Cell(10,6,utf8_decode($nom_resp),0,1,'C');
		$pdf->Cell(90,6,"", $marcocelda,0,'L');
		$pdf->Cell(10,6,utf8_decode($cargo_resp),0,1,'C');
		*/
		
		//RESPONSABLE GENERAL
		if($pdf->GetY() > 260){$pdf->AddPage(); $pdf->SetY(90);}
		$pdf->ln(49);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(90,6,"", $marcocelda,0,'L');
		$pdf->Cell(10,6,"----------------------------------", $marcocelda,1,'C');
		$pdf->Cell(90,6,"", $marcocelda,0,'L');
		$pdf->Cell(10,6,utf8_decode($nom_cot2),0,1,'C');
		$pdf->Cell(90,6,"", $marcocelda,0,'L');
		$pdf->Cell(10,6,utf8_decode($cargo_resp2),0,1,'C');
		
$pdf->Output();
?>