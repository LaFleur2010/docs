<?php
require('fpdf.php');
$pdf=new FPDF();
$pdf->AddPage();

include('../inc/config_db.php');

$fe	=	date("d/m/Y");

class PDF extends FPDF
{
	// Cabecera de pagina
	function Header()
	{
		global $title;

		if($this->PageNo() == 1){$this->Ln(66);}else{$this->Ln(10);}
		//Arial bold 15
		$this->SetFont('Arial','B',6);
		
		//Colores de los bordes, fondo y texto
		$this->SetDrawColor(150,150,150);
		$this->SetFillColor(120,120,120);
		$this->SetTextColor(255,255,255);
		
		$this->Cell(16,6,"NUMERO",1,0,'L',true);						
		$this->Cell(18,6,"TIPO",1,0,'L',true);				
		$this->Cell(98,6,"DESCRIPCION",1,0,'L',true);	
		$this->Cell(17,6,"FECHA ING",1,0,'L',true);
		$this->Cell(17,6,"FECHA ENT.",1,0,'L',true);
		$this->Cell(20,6,"ESTADO",1,0,'L',true);
		$this->Cell(60,6,"CLIENTE",1,0,'L',true);
		$this->Cell(30,6,"RESPONSABLE",1,1,'L',true);
		
		$this->Cell(276,1,"",1,1,'L');
	}
	
	//Pie de página
	function Footer()
	{
		//Posición: a 1,5 cm del final
		$this->SetY(-20);
		//Arial Black de 10
		$this->SetFont('Arial','',9);
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

function porcentaje($cant_cum, $cant_reg) {
    return number_format($cant_cum / $cant_reg * 100,1,',','.');
}
//**********************************************************************************************************************

//$pdf->SetY(80);
$pdf->SetFont('Arial','',10);
/***********************************************************************************************************************
		CONSULTAMOS LAS ODS SELECCIONADAS (ENVIADAS)
***********************************************************************************************************************/	
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS", $co);
		
		$cant_reg		= 0;
		$adjudicado		= 0; 
		$noadjudicado 	= 0;
		$noestudio		= 0;
		$nula			= 0;
		$valorAdj		= 0;
		$valorNAdj		= 0;
		$valorNEst		= 0;
		$valorNula		= 0;
		$valor_cot		= 0;
		$$sumaTotal		= 0;
		
  		$aLista		= array_keys($_POST['campos']); 
		$cant 	= count($_POST['campos']);
		
		$sQuery		= "SELECT * FROM tb_cotizaciones WHERE id_cot IN (".implode(',',$aLista).") ORDER BY num_cot"; 
		
		$respQ 		= mysql_query($sQuery, $co);
		$cant_reg 	= mysql_num_rows($respQ);
		$x=0;
		while($Fila = mysql_fetch_array($respQ)) 
		{
			$estado_cot		= "".$Fila['estado_cot']."";
			$valor_cot		= "".$Fila['valor_cot']."";
				
			if($estado_cot == "Adjudicado"){	$adjudicado		= $adjudicado + 1; 		$valorAdj = $valorAdj + $valor_cot;}
			if($estado_cot == "No Adjudicado"){	$noadjudicado	= $noadjudicado + 1; 	$valorNAdj = $valorNAdj + $valor_cot;}
			if($estado_cot == "No Estudio"){	$noestudio		= $noestudio + 1;		$valorNEst = $valorNEst + $valor_cot;}
			if($estado_cot == "Nula"){			$nula			= $nula + 1;			$valorNula = $valorNula + $valor_cot;}
			
			$sumaTotal 		= $sumaTotal + $valor_cot;
			$lista_cot[] 	= $Fila;
			$x 				= $x +1;
		}
		
$pdf->SetDrawColor(150,150,150);
//*************************** LOGO MGYT ****************************************
$pdf->Image('../imagenes/logo_mgyt_c.jpg',13,4,23);
$pdf->SetY(4);

//************************* PRIMERA FILA****************************************
$pdf->Cell(30,14," ",1,0,'C'); 
$pdf->Cell(209,14,"HISTORIAL DE COTIZACIONES Y LICITACIONES",1,0,'C',$fill); 
$pdf->SetFont('Arial','',8);

$pdf->Cell(37,5,$num_enc,1,1,'L'); 

$pdf->Cell(239,5," ",0,0,'C'); 
$pdf->Cell(37,5,"",1,1,'L'); 

$pdf->Cell(239,4," ",0,0,'C'); 
$pdf->Cell(37,4,"",1,1,'L'); 

$pdf->Image('../graficos/cotizaciones.png',30,20,100);

$pdf->Cell(276,2,"",1,1,'L');

$pdf->Cell(276,55," ",1,1,'C'); 

$pdf->SetY(21);

$pdf->Cell(189,52,"",0,0,'L'); 

$pdf->Cell(85,52," ",1,1,'C'); 

$pdf->SetY(21);


if($adjudicado 		!= 0 or $cant_ncum != 0){$porcAdj 	= porcentaje($adjudicado, $cant_reg);}
if($noadjudicado 	!= 0 or $cant_ncum != 0){$porcNAdj 	= porcentaje($noadjudicado, $cant_reg);}
if($noestudio 		!= 0 or $cant_ncum != 0){$porcNEst 	= porcentaje($noestudio, $cant_reg);}
if($nula 			!= 0 or $cant_ncum != 0){$porcNula 	= porcentaje($nula, $cant_reg);}

$pdf->Cell(195,5,"",0,0,'L'); 
$pdf->Cell(20,5,"Fecha",0,0,'L'); 
$pdf->Cell(35,5,"$fe",0,0,'C'); 
$pdf->Cell(28,5,"",0,1,'L'); 

//Colores de los bordes, fondo y texto
$pdf->SetDrawColor(150,150,150);
$pdf->SetFillColor(120,120,120);
$pdf->SetTextColor(255,255,255);
		
$pdf->Cell(129,8,"",0,0,'L');
$pdf->Cell(60,8,"ESTADO ",1,0,'L',true); 
$pdf->Cell(20,8,"CANTIDAD",1,0,'C',true);
$pdf->Cell(15,8,"%",1,0,'C',true);
$pdf->Cell(50,8,"VALOR EN PESOS",1,1,'C',true); 

//Colores de los bordes, fondo y texto
$pdf->SetDrawColor(150,150,150);
$pdf->SetFillColor(120,120,120);
$pdf->SetTextColor(0,0,0);

$pdf->Cell(129,8,"",0,0,'L');
$pdf->Cell(60,8,"Adjudicado ",1,0,'L'); 
$pdf->Cell(20,8,"$adjudicado",1,0,'C'); 
$pdf->Cell(15,8,$porcAdj,1,0,'C'); 
$pdf->Cell(50,8,number_format($valorAdj, 0, ",", "."),1,1,'R'); 

$pdf->Cell(129,8,"",0,0,'L');
$pdf->Cell(60,8,"No Adjudicado",1,0,'L'); 
$pdf->Cell(20,8,"$noadjudicado",1,0,'C'); 
$pdf->Cell(15,8,"$porcNAdj",1,0,'C'); 
$pdf->Cell(50,8,number_format($valorNAdj, 0, ",", "."),1,1,'R'); 

$pdf->Cell(129,8,"",0,0,'L');
$pdf->Cell(60,8,"No Estudio",1,0,'L'); 
$pdf->Cell(20,8,"$noestudio",1,0,'C'); 
$pdf->Cell(15,8,"$porcNEst",1,0,'C'); 
$pdf->Cell(50,8,number_format($valorNEst, 0, ",", "."),1,1,'R'); 

$pdf->Cell(129,8,"",0,0,'L');
$pdf->Cell(60,8,"Nula",1,0,'L'); 
$pdf->Cell(20,8,"$nula",1,0,'C'); 
$pdf->Cell(15,8,"$porcNula",1,0,'C'); 
$pdf->Cell(50,8,number_format($valorNula, 0, ",", "."),1,1,'R'); 

$pdf->Cell(129,77,"",0,0,'L');
$pdf->Cell(60,7,"Total Cotizaciones/Licitaciones",1,0,'L'); 
$pdf->Cell(20,7,"$cant_reg",1,0,'C'); 
$pdf->Cell(15,7,"$ccampos",1,0,'C'); 
$pdf->Cell(50,7,number_format($sumaTotal, 0, ",", "."),1,1,'R'); 
/*************************************************************************************************************************
			
**************************************************************************************************************************/
	$ani   = 10; // ancho Item	
	$total =  count($lista_cot);
	$i     = 0;

	$pdf->SetY(83);
	$pdf->SetFillColor(240,240,240);
	$fondo = true;
	
	while($i < $total)
	{
		$num_cot 		= $lista_cot[$i]['num_cot'];
		$tipo_ing 		= $lista_cot[$i]['tipo_ing'];
		$desc_cot 		= $lista_cot[$i]['desc_cot'];	
		$fe_ing_cot 	= $lista_cot[$i]['fe_ing_cot'];	
		$fe_sal_cot 	= $lista_cot[$i]['fe_sal_cot'];
		$fe_ent_cot 	= $lista_cot[$i]['fe_ent_cot'];
		$estado_cot 	= $lista_cot[$i]['estado_cot'];
		$cliente_cot 	= $lista_cot[$i]['cliente_cot'];
		$resp_cot 		= $lista_cot[$i]['resp_cot'];
		
		$sql_cli 	= "SELECT razon_s FROM tb_clientes WHERE id_cli = '$cliente_cot' ";
		$resp		= mysql_query($sql_cli,$co);
		while($vrowscp=mysql_fetch_array($resp))
		{
			$cliente_cot = "".$vrowscp['razon_s']."";
		}
		
		$sql_res = "SELECT nom_resp FROM tb_responsable WHERE rut_resp = '$resp_cot' ";
		$res = mysql_query($sql_res,$co);
		while($vrowsr = mysql_fetch_array($res))
		{
			$resp_cot	= "".$vrowsr['nom_resp']."";
		}

		if($fe_ing_cot 	== "0000-00-00"){$fe_ing_cot 	= "";}
		if($fe_ent_cot 	== "0000-00-00"){$fe_ent_cot 	= "";}
		
		$fe_ing_cot	= cambiarFecha($fe_ing_cot, '-', '/' );
		$fe_ent_cot	= cambiarFecha($fe_ent_cot, '-', '/' );
			
		$prof_sol = substr(utf8_decode($prof_sol), 0, 30);
		
		$pdf->Cell(16,6,"$num_cot",1,0,'L',$fondo);
		$pdf->Cell(18,6,"$tipo_ing",1,0,'L',$fondo);						
		$pdf->Cell(98,6,utf8_decode($desc_cot),1,0,'L',$fondo);				
		$pdf->Cell(17,6,"$fe_ing_cot",1,0,'L',$fondo);
		$pdf->Cell(17,6,"$fe_ent_cot",1,0,'L',$fondo);
		$pdf->Cell(20,6,"$estado_cot",1,0,'L',$fondo);
		$pdf->Cell(60,6,utf8_decode($cliente_cot),1,0,'L',$fondo);
		$pdf->Cell(30,6,utf8_decode($resp_cot),1,1,'L',$fondo);
			
		if($fondo == true){ $fondo = false; }else{ $fondo = true; }

		$i++;
	}
	

	$pdf->Output();
?>