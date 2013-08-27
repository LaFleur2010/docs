<?php
include('config_db.php');
/************************************************************************************************************************************
					
*************************************************************************************************************************************/	
require('../fpdf.php');
$pdf=new FPDF();
$pdf->AddPage();

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

//SetMargins("10", "10", "10") 

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
$pdf->SetFont('Arial','',10);
$pdf->SetY(10);
//$pdf->SetDrawColor(254, 0, 0); 

//$pdf->SetFillColor(254,1,1);

$cod_sol = $_GET['cod'];
/*if($_GET['emp'] == "Mgyt")
{*/
	$empresa = "SOCIEDAD COMERCIAL Y MINERA ROCKMINE S.A.";
//}

/************************************************************************************************************************************
					
*************************************************************************************************************************************/	
	$co=mssql_connect("$SERVER","$USR","$PASS");
	mssql_select_db("$BDATOS", $co);
	
	$sql = "SELECT * FROM softland.owordencom, softland.owordendet, softland.cwtauxi WHERE owordencom.NumOC = '$cod_sol' and owordencom.NumInterOC = owordendet.NumInterOC and softland.cwtauxi.CodAux = softland.owordencom.CodAux ORDER BY owordencom.NumOC";
	
	/*$sql = 	"SELECT softland.owordencom.NumInterOC, softland.owordencom.NumOC, CONVERT(varchar, softland.owordencom.FechaOC, 103) AS FechaOC, 
                      	softland.owordencom.CodEstado, Etapa.CodEtapa, softland.cwtauxi.NomAux, CONVERT(varchar, softland.owordencom.FecFinalOC, 103) AS FecFinalOC,
                       	softland.owordencom.CodArn, softland.owordencom.CodMon, softland.owordencom.EquivMonOC, softland.owordencom.ValorTotOC, 
                      	softland.cwtmone.SimMon, softland.cwtmone.DecMon, softland.owordencom.ValorTotMB, CASE WHEN (OWOrdenCom.CodiCC IS NULL) OR
                      	LTrim(OWOrdenCom.CodiCC) = '' THEN NULL ELSE OWOrdenCom.CodiCC END AS CodiCC, CASE WHEN (CWTCCOS.DescCC IS NULL) OR
                      	LTrim(CWTCCOS.DescCC) = '' THEN NULL ELSE CWTCCOS.DescCC END AS DescCC, softland.owordencom.FechaOC AS FechaOrden
							FROM softland.cwtmone INNER JOIN
                      	softland.cwtauxi INNER JOIN
                      	softland.owordencom ON softland.cwtauxi.CodAux = softland.owordencom.CodAux ON 
                      	softland.cwtmone.CodMon = softland.owordencom.CodMon INNER JOIN
                      	softland.OW_vsnpTraeEstadoEtapaOrdenCom AS Etapa ON Etapa.NumInterOC = softland.owordencom.NumInterOC LEFT OUTER JOIN
                      	softland.cwtccos ON softland.cwtccos.CodiCC = softland.owordencom.CodiCC";*/
	
	$resp=mssql_query($sql,$co);
	while ($rows = mssql_fetch_assoc($resp)) {
	
		$detalle[] = $rows; 
	
    	$NumOC			= "".$rows['NumOC']."";
		$FechaOC		= "".$rows['FechaOC']."";
		$NomAux			= "".$rows['NomAux']."";
		$DetProd		= "".$rows['DetProd']."";
		$NomCon			= "".$rows['NomCon']."";
		$CodAux			= "".$rows['CodAux']."";
		$CodiCC			= "".$rows['CodiCC']."";
		$NetoAfecto		= "".$rows['NetoAfecto']."";
		$ValorFlete		= "".$rows['ValorFlete']."";
		$ValorTotOC		= "".$rows['ValorTotOC']."";
		$SubTotalOC		= "".$rows['SubTotalOC']."";
		$ValDesc01		= "".$rows['ValDesc01']."";
		$ValDesc02		= "".$rows['ValDesc02']."";
		$RutAux			= "".$rows['RutAux']."";
		$NomAux			= "".$rows['NomAux']."";
		$DirAux			= "".$rows['DirAux']."";
		$FonAux1		= "".$rows['FonAux1']."";
		$FaxAux1		= "".$rows['FaxAux1']."";
		$ComAux			= "".$rows['ComAux']."";
		$CiuAux			= "".$rows['CiuAux']."";
	}
	
	$sql_u 	= "SELECT * FROM softland.cwtcomu WHERE softland.cwtcomu.ComCod = '$ComAux'";
	$res	= mssql_query($sql_u,$co);
	while($vrows=mssql_fetch_assoc($res))
	{
		$ComDes		= "".$vrows['ComDes']."";
	}
	
	$sql_u 		= "SELECT * FROM softland.cwtciud WHERE softland.cwtciud.CiuCod = '$CiuAux'";
	$res		= mssql_query($sql_u,$co);
	while($vrows_c=mssql_fetch_assoc($res))
	{
		$CiuDes		= "".$vrows_c['CiuDes']."";
	}

	
	/*if($fe_aprov 	== "0000-00-00"){ $fe_aprov  	= "";}
	if($fe_ent_rep 	== "0000-00-00"){ $fe_ent_rep  	= "";}
	
	$sqlf = "SELECT * FROM items_oti WHERE num_oti = '$num_oti' ORDER BY id ";
	$respuesta=mssql_query($sqlf,$co);
	while ($row2 = mssql_fetch_assoc($respuesta)) {
            $consulta[] = $row2; 
	}
	
	$sql_u = "SELECT * FROM usuario_e WHERE cod_ue = '$usuario' ";
	$res=mssql_query($sql_u,$co);
	while($vrows=mssql_fetch_assoc($res))
	{
		$usuario	= "".$vrows['nom_ue']."";
	}
	
	$sql_pl = "SELECT * FROM plantas WHERE cod_p = '$planta' ";
	$respl=mssql_query($sql_pl,$co);
	while($vrows=mssql_fetch_assoc($respl))
	{
		$planta	= "".$vrows['nom_p']."";
	}
	
	$sql3 = "SELECT * FROM equipos WHERE cod_eq = '$desc_eq_scont' ";
	$resp3 	= mssql_query($sql3, $co);
	while ($vrows3 = mssql_fetch_assoc($resp3)) 
	{
    	$desc_eq_scont = "".$vrows3['nom_eq']."";
	}*/
		
	
//*************** LOGO ROCKMINE *****************************
$pdf->Image('../imagenes/logo2.jpg',15,10,20);

//************** PRIMERA FILA ***************************
$pdf->Cell(40,12," ",1,0,'C'); 
$pdf->Cell(115,12,"ORDEN DE COMPRA",1,0,'C'); 
$pdf->SetFont('Arial','',6);

$pdf->Cell(13,3,"COD.",1,0,'C'); 
$pdf->Cell(25,3,"SGI-GER-R-036",1,1,'L'); 

$pdf->Cell(155,3," ",0,0,'C'); 
$pdf->Cell(13,3,"REV.",1,0,'C'); 
$pdf->Cell(25,3,"002",1,1,'L'); 

$pdf->Cell(155,3," ",0,0,'C'); 
$pdf->Cell(13,3,"Fecha",1,0,'C'); 
$pdf->Cell(25,3,"01/06/2010",1,1,'L'); 

$pdf->Cell(155,3," ",0,0,'C'); 
$pdf->Cell(38,3,"Hoja 1 de 1",1,1,'R'); 

//************* TERCERA FILA ****************************
$pdf->SetFont('Arial','',7);
$pdf->Cell(30,7,"EMPRESA",1,0,'L');	
$pdf->SetFont('Arial','B',7);
$pdf->Cell(100,7,"$empresa",1,0,'C');
$pdf->SetFont('Arial','',7);
$pdf->Cell(25,7,"Nº O. C.",1,0,'l');
$pdf->SetFont('Arial','B',7);
$pdf->Cell(38,7,"$NumOC",1,1,'C');
$pdf->SetFont('Arial','',7);
$pdf->Cell(30,7,"RUT EMPRESA",1,0,'L');	
$pdf->SetFont('Arial','B',7);				
$pdf->Cell(100,7,"$RutAux",1,0,'L');
$pdf->SetFont('Arial','',7);
$pdf->Cell(25,7,"FECHA",1,0,'L');
$pdf->Cell(38,7,"$FechaOC",1,1,'C');

$pdf->Cell(30,4,"Nombre proveedor",1,0,'L');
$pdf->Cell(163,4,"$NomAux",1,1,'L');

$pdf->Cell(30,4,"Nº rut proveedor",1,0,'L');
$pdf->Cell(163,4,"$RutAux",1,1,'L');

$pdf->Cell(30,4,"Direccion proveedor",1,0,'L');
$pdf->Cell(100,4,"$DirAux",1,0,'L');
$pdf->Cell(25,4,"Ciudad",1,0,'l');
$pdf->Cell(38,4,"$CiuDes",1,1,'L');

$pdf->Cell(30,4,"Telefono proveedor",1,0,'L');
$pdf->Cell(100,4,"$FonAux1",1,0,'L');
$pdf->Cell(25,4,"Comuna",1,0,'l');
$pdf->Cell(38,4,"$ComDes",1,1,'L');

$pdf->Cell(30,4,"Atencion contacto",1,0,'L');
$pdf->Cell(100,4,"$NomCon",1,0,'L');
$pdf->Cell(25,4,"Nº Fax",1,0,'l');
$pdf->Cell(38,4,"$FaxAux1",1,1,'L');

$pdf->Cell(193,2,"",1,1,'L');

	$pdf->Cell(10,4,"Nº Item",1,0,'C'); 
	$pdf->Cell(20,4,"Codigo",1,0,'C'); 
	$pdf->Cell(100,4,"Descripcion material",1,0,'L');
	$pdf->Cell(15,4,"Un",1,0,'C'); 
	$pdf->Cell(8,4,"Cant",1,0,'C'); 
	$pdf->Cell(20,4,"Valor",1,0,'C'); 
	$pdf->Cell(20,4,"Total",1,1,'C'); 

	$ani	= 4; // ancho Item	
	$i		= 0;
	$total 	= count($detalle);
	$y		= 58;
	
	if($total >= 27)
	{
		$total = $total;
	}else{
		$total=27;
	}
	
	while($i < $total)
	{
		$num_item 	= $i+1;
		$DetProd 	= $detalle[$i]['DetProd'];
		$CodProd 	= $detalle[$i]['CodProd'];
		$PrecioUnit = $detalle[$i]['PrecioUnit'];
		$ValorTotal = $detalle[$i]['ValorTotal'];
		$Cantidad	= $detalle[$i]['Cantidad'];
			
		
		$pdf->Cell(10,$ani,"$num_item",1,0,'C'); 
		$pdf->Cell(20,$ani,"$CodProd",1,0,'C'); 
		$pdf->Cell(100,4,"$DetProd",1,0,'L');
		$pdf->Cell(15,4,"",1,0,'C'); 
		$pdf->Cell(8,4,"$Cantidad",1,0,'C'); 
		
		$PrecioUnit = number_format($PrecioUnit, 0, ",", ".");
		$ValorTotal = number_format($ValorTotal, 0, ",", ".");
		
		if($PrecioUnit == 0){$PrecioUnit = "";}
		if($ValorTotal == 0){$ValorTotal = "";}
		
		$pdf->Cell(20,4,$PrecioUnit,1,0,'C'); 
		$pdf->Cell(20,4,$ValorTotal,1,1,'C'); 
		
		$i++;
	}	

$pdf->Cell(30,8,"Fecha solicitud",1,0,'L'); 
$pdf->Cell(30,8,"",1,0,'L'); 
$pdf->Cell(85,8,"",1,0,'L'); 
$pdf->Cell(28,4,"Sub-Total $",1,0,'L'); 
$pdf->Cell(20,4,number_format($SubTotalOC, 0, ",", "."),1,1,'R'); 

$pdf->Cell(145,8,"",0,0,'L'); 
$pdf->Cell(28,4,"Flete",1,0,'L'); 
$pdf->Cell(20,4,"$ValorFlete",1,1,'R'); 

$pdf->Cell(30,4,"Forma de pago",1,0,'L'); 
$pdf->Cell(115,4,"",1,0,'L'); 
$pdf->Cell(28,4,"Descuento 1 $ ",1,0,'L'); 
$pdf->Cell(20,4,"$ValDesc01",1,1,'R');  	

$pdf->Cell(30,4,"Plazo de entrega",1,0,'L'); 
$pdf->Cell(115,4,"",1,0,'L'); 
$pdf->Cell(28,4,"Descuento 2 $ ",1,0,'L'); 
$pdf->Cell(20,4,"$ValDesc02",1,1,'R');  	

$pdf->Cell(30,4,"Centro Costo/Contrato",1,0,'L'); 
$pdf->Cell(15,4,"$CodiCC",1,0,'L'); 
$pdf->Cell(100,4,"",1,0,'L'); 
$pdf->Cell(28,4,"Neto $ ",1,0,'L'); 
$pdf->Cell(20,4,number_format($NetoAfecto, 0, ",", "."),1,1,'R');  

$iva = $ValorTotOC - $NetoAfecto;

$pdf->Cell(30,4,"Nº ODS/ INF",1,0,'L'); 
$pdf->Cell(15,4,"",1,0,'L'); 
$pdf->Cell(100,4,"",1,0,'L'); 
$pdf->Cell(28,4,"19 % IVA",1,0,'L'); 
$pdf->Cell(20,4,number_format($iva, 0, ",", "."),1,1,'R');  

$pdf->Cell(145,8,"",1,0,'L'); 
$pdf->Cell(28,8,"Total $ ",1,0,'L'); 
$pdf->SetFont('Arial','B',7);
$pdf->Cell(20,8,number_format($ValorTotOC, 0, ",", "."),1,1,'R'); 
$pdf->SetFont('Arial','',7);

$pdf->Cell(193,4,"Observaciones",1,1,'C'); 
$pdf->MultiCell(193,12,"$DetProd",1,1,'L');  

$pdf->Cell(193,6,"Nota:  Entregar Mercaderias con Factura o Guia de despacho Indicando Nº de Orden de Compra $num_orden",1,1,'L'); 
//$pdf->MultiCell(193,6,utf8_decode($obs_oti),1,1,'L');
$pdf->Cell(156,8,"Forma de pago",1,0,'C'); 
$pdf->Cell(37,8,"Recepcionado Por:",1,1,'C');  

$pdf->Cell(32,4,"Nº Cheque",1,0,'C'); 
$pdf->Cell(32,4,"Vencimiento",1,0,'C'); 
$pdf->Cell(55,4,"Nombre del Banco",1,0,'C'); 
$pdf->Cell(37,4,"Monto Cheque",1,0,'C'); 
$pdf->Cell(37,4,"Nombre",1,1,'C'); 

$pdf->Cell(32,4,"",1,0,'C'); 
$pdf->Cell(32,4,"",1,0,'C'); 
$pdf->Cell(55,4,"",1,0,'C'); 
$pdf->Cell(37,4,"",1,0,'C'); 
$pdf->Cell(37,4,"",1,1,'C'); 

$pdf->Cell(32,4,"",1,0,'C'); 
$pdf->Cell(32,4,"",1,0,'C'); 
$pdf->Cell(55,4,"",1,0,'C'); 
$pdf->Cell(37,4,"",1,0,'C'); 
$pdf->Cell(37,4,"",1,1,'C');

$pdf->Cell(32,4,"",1,0,'C'); 
$pdf->Cell(32,4,"",1,0,'C'); 
$pdf->Cell(55,4,"",1,0,'C'); 
$pdf->Cell(37,4,"",1,0,'C'); 
$pdf->Cell(37,4,"",1,1,'C');

$pdf->Cell(32,4,"",1,0,'C'); 
$pdf->Cell(32,4,"",1,0,'C'); 
$pdf->Cell(55,4,"",1,0,'C'); 
$pdf->Cell(37,4,"",1,0,'C'); 
$pdf->Cell(37,4,"",1,1,'C');

$pdf->Cell(193,1,"",1,1,'C');

$pdf->Cell(63,12,"",1,0,'C');
$pdf->Cell(67,12,"",1,0,'C'); 
$pdf->Cell(63,12,"",1,1,'C');

$pdf->SetY(261);

$pdf->Cell(63,4,"Adquisiciones:",0,0,'C');
$pdf->Cell(67,4,"Unidad Tecnica:",0,0,'C'); 
$pdf->Cell(63,4,"Gerencia General",0,1,'C');

//$pdf->Cell(20,10,"FIRMA:",1,0,'C');
$pdf->Cell(193,10,"",1,1,'C');  

$pdf->SetY(265);
$pdf->Cell(193,5,"Soc. Com. y Minera Rockmine S.A.",0,1,'C');  
$pdf->Cell(193,5,"DIRECCION : ISLA NORTE 380 FONO: 2977720  CODEGUA",0,1,'C');  

	$pdf->Output();
?>