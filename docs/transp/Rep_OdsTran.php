<?php
/************************************************************************************************************************************
					
*************************************************************************************************************************************/	
require('../fpdf.php');
$pdf=new FPDF();
$pdf->AddPage();
	include('../inc/config_db.php'); 	// Incluimos archivo de configuracion de la conexion

$fe		=	date("d/m/Y");
$fecha	=	date("Y-m-d");

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

/************************************************************************************************************************************
					
*************************************************************************************************************************************/	
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

/*********************************************************************************************************
	Función Para Cambiar el Formato de la Fecha
**********************************************************************************************************/
function cambiarFecha( $sFecha, $sSimboloInicial, $sSimboloFinal )
{
	return implode( $sSimboloFinal, array_reverse( explode( $sSimboloInicial, $sFecha ) ) ) ; 
} 
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
$pdf->SetFont('Arial','',12);
$pdf->SetY(10);
//$pdf->SetDrawColor(254, 0, 0); 
$pdf->SetLineWidth(0.4);
//$pdf->SetFillColor(254,1,1);


//************** SEGUNDA FILA ***************************
$pdf->Line(10, 25, 10, 210);	
$pdf->Line(195, 25, 195, 210);									
$pdf->Line(10, 210, 195, 210);	
								
$pdf->Line(35, 195, 85, 195);	
$pdf->Line(115, 195, 165, 195);	

$cod_tods	= $_GET['vods'];

/************************************************************************************************************************************
					
*************************************************************************************************************************************/	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS",$co);
	
	$sql	= "SELECT * FROM tb_tranods WHERE cod_tods = '".$_GET['vods']."' ";
	$resp	= mysql_query($sql,$co);
	while ($vrows = mysql_fetch_array($resp)) {
	
    	$cod_tods 		= "".$vrows['cod_tods']."";
		$fe_tods 		= "".$vrows['fe_tods']."";
		$cond_tods 		= "".$vrows['cond_tods']."";
		$coord_tods 	= "".$vrows['coord_tods']."";
		$cc_tods 		= "".$vrows['cc_tods']."";
		$dest_tods 		= "".$vrows['dest_tods']."";
		$tipo_veh_tods 	= "".$vrows['tipo_veh_tods']."";
		$pat_veh_tods 	= "".$vrows['pat_veh_tods']."";
		$kmini_tods 	= "".$vrows['kmini_tods']."";
		$kmlleg_tods 	= "".$vrows['kmlleg_tods']."";
		$carg_tods 		= "".$vrows['carg_tods']."";
		$hrsal_tods 	= "".$vrows['hrsal_tods']."";
		$hrlleg_tods 	= "".$vrows['hrlleg_tods']."";
		$tothrs_tods 	= "".$vrows['tothrs_tods']."";
		$doc_tods 		= "".$vrows['doc_tods']."";
		$obs_tods 		= "".$vrows['obs_tods']."";
	}
		
		$sql_coord = "SELECT * FROM tb_coordinador WHERE cod_coord = '$coord_tods' ";
		$res = mysql_query($sql_coord,$co);
		while($vrowscoord=mysql_fetch_array($res))
		{
			$nom_coord = "".$vrowscoord['nom_coord']."";
		}
		$sql_dest = "SELECT * FROM tb_destino WHERE cod_dest  = '$dest_tods' ";
		$res = mysql_query($sql_dest ,$co);
		while($vrowsdest = mysql_fetch_array($res))
		{
			$nom_dest  = "".$vrowsdest ['nom_dest']."";
			$cod_dest  = "".$vrowsdest ['cod_dest']."";
		}
		$sql_veh = "SELECT * FROM tb_vehiculos WHERE cod_veh  = '$patente_tods' ";
		$res_veh = mysql_query($sql_veh ,$co);
		while($vrowsveh = mysql_fetch_array($res_veh))
		{
			$nom_veh  = "".$vrowsveh ['nom_veh']."";
			$cod_veh  = "".$vrowsveh ['cod_veh']."";
		}
	
	if($fe_tods 	== "0000-00-00"){ $fe_tods  	= "";}
//*************** LOGO MGYT *****************************
$pdf->Image('../imagenes/empresas.jpg',12,14,34);

//************** PRIMERA FILA ***************************
$pdf->Cell(37,15," ",1,0,'C'); 
$pdf->Cell(111,15,"ORDEN DE SERVICIO",1,0,'C'); 
$pdf->SetFont('Arial','',7);

$pdf->Cell(12,5,"COD.",1,0,'C'); 
$pdf->Cell(25,5,"SGI-TRA-R-112",1,1,'L'); 

$pdf->SetY(15);

$pdf->Cell(148,5,"",0,0,'C'); 
$pdf->Cell(12,5,"REV.",1,0,'C'); 
$pdf->Cell(25,5,"002",1,1,'L'); 

$pdf->Cell(148,5," ",0,0,'C'); 
$pdf->Cell(12,5,"Fecha",1,0,'C'); 
$pdf->Cell(25,5,"23/04/2009",1,1,'L'); 

$pdf->SetLineWidth(0.2);
$pdf->SetY(25);
//************** SEGUNDA FILA ***************************
//$pdf->Line(10, 28, 10, 40);	
$pdf->SetLineWidth(0.3);										// Linea del costado de descripcion
//$pdf->Line(11, 34, 29, 34);	
$pdf->SetLineWidth(0.2);	
								
$pdf->Cell(185,10,"",0,1,'C'); 									// Separacion de encabezado con la columna siguiente

//$desc_s_c = cortar($desc_eq_scont,60);
$fe_tods	=	cambiarFecha($fe_tods, '-', '/' );

//************* TERCERA FILA ****************************
$pdf->Cell(7,6,"",0,0,'L');
$pdf->Cell(30,6,"Nº DE ORDEN:",1,0,'L');
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(25,6,"$cod_tods",1,0,'l');

$pdf->Cell(10,6,"",0,0,'L');
$pdf->Cell(15,6,"FECHA",1,0,'L');
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(20,6,"$fe_tods",1,1,'L');

$pdf->Cell(185,3,"",0,1,'L');

$pdf->Cell(7,6,"",0,0,'L');
$pdf->Cell(30,6,"Conductor",1,0,'L'); 
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(75,6,"$cond_tods",1,0,'L'); 
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(25,6,"HORA SALIDA",1,0,'L');
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(25,6,"$hrsal_tods",1,1,'l');

$pdf->Cell(185,2,"",0,1,'L');

$pdf->Cell(7,6,"",0,0,'L');
$pdf->Cell(30,6,"Coordinador (es)",1,0,'L'); 
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(75,6,"$nom_coord",1,0,'L'); 
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(25,6,"HORA LLEGADA",1,0,'L');
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(25,6,"$hrlleg_tods",1,1,'l');

$pdf->Cell(185,2,"",0,1,'L');

$pdf->Cell(7,6,"",0,0,'L');
$pdf->Cell(30,6,"Centro costo",1,0,'L'); 
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(75,6,"$cc_tods",1,0,'L'); 
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(25,6,"TOTAL HORAS",1,0,'L');
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(25,6,"$tothrs_tods",1,1,'l');

$pdf->Cell(185,2,"",0,1,'L');

$pdf->Cell(7,6,"",0,0,'L');
$pdf->Cell(30,6,"Tipo vehiculo",1,0,'L'); 
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(75,6,"$tipo_veh_tods",1,0,'L'); 
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(25,6,"PATENTE",1,0,'L');
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(25,6,"$pat_veh_tods",1,1,'l');

$pdf->Cell(185,2,"",0,1,'L');

$pdf->Cell(7,6,"",0,0,'L');
$pdf->Cell(30,6,"Destino",1,0,'L'); 
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(135,6,"$nom_dest",1,0,'L'); 
$pdf->Cell(20,6,"",0,1,'L');

$pdf->Cell(185,2,"",0,1,'L');

$pdf->Cell(7,6,"",0,0,'L');
$pdf->Cell(30,6,"Km Inicio",1,0,'L'); 
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(30,6,"$kmini_tods",1,0,'L'); 

$pdf->Cell(15,6,"",0,0,'L');

$pdf->Cell(30,6,"Km Termino",1,0,'L'); 
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(25,6,"$kmlleg_tods",1,0,'L'); 

$pdf->Cell(20,6,"",0,1,'L');

$pdf->Cell(185,2,"",0,1,'L');

$pdf->Cell(7,6,"",0,0,'L');
$pdf->Cell(30,6,"Carga o materiales",1,0,'L'); 
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(135,6,"$carg_tods",1,0,'L'); 
$pdf->Cell(20,6,"",0,1,'L');

$pdf->Cell(185,10,"",0,1,'L');
/************************************************************************************************************************************
					
*************************************************************************************************************************************/	
$pdf->Cell(7,6,"",0,0,'L');
$pdf->Cell(170,4,"DOCUMENTOS",1,1,'C');
$pdf->Cell(7,6,"",0,0,'L');
$pdf->MultiCell(170,6,utf8_decode($doc_tods



),1,1,'L');
//************************************************************************************************************************************
$pdf->Cell(180,3,"",0,1,'C');
//************************************************************************************************************************************
$pdf->Cell(7,6,"",0,0,'L');
$pdf->Cell(170,4,"OBSERVACIONES",1,1,'C');
$pdf->Cell(7,6,"",0,0,'L');
$pdf->MultiCell(170,6,utf8_decode($obs_tods



),1,1,'L');

$pdf->Cell(185,20,"",0,1,'C');

$pdf->Cell(7,20,"",0,0,'L');
$pdf->Cell(85,20,"COORDINADOR",0,0,'C'); $pdf->Cell(15,20,"",0,0,'C'); $pdf->Cell(50,20,"JEFE TRANSPORTES",0,0,'C');


	$pdf->Output();
?>