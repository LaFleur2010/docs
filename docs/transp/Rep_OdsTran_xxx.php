<?php

require('../fpdf.php');
$pdf=new FPDF();
$pdf->AddPage();
	include('../inc/config_db.php'); 	// Incluimos archivo de configuracion de la conexion
	include('../inc/lib.db.php');		// Incluimos archivo de libreria de funciones PHP
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


$ods	= $_GET['vods'];
//$ods		= $_POST['vods'];

	$co=mysql_connect("$DNS","$USR","$PASS") or die ("No se puede conectar al Servidor");
	mysql_select_db("$BDATOS",$co) or die("No Se Puede Conectar a la Base de Datos");
	
	$sql="SELECT * FROM contratos, plantas, usuario_e, equipos WHERE contratos.ods = '$ods' and contratos.usuario=usuario_e.cod_ue and contratos.planta=plantas.cod_p and equipos.cod_eq=contratos.desc_eq_scont ";
	$resp=mysql_query($sql,$co);
	while ($rows = mysql_fetch_array($resp)) {
    	$ods			="".$rows['ods']."";
		$area			="".$rows['area']."";
		$priori			="".$rows['priori']."";
		$estado			="".$rows['estado']."";
		$est_inf		="".$rows['est_inf']."";
		$planta			="".$rows['nom_p']."";
		$usuario		="".$rows['nom_ue']."";
		$fe_in_ret		="".$rows['fe_in_ret']."";
		$guia_desp_det	="".$rows['guia_desp_det']."";
		$cant			="".$rows['cant']."";
		$fam_eq			="".$rows['fam_eq']."";
		$desc_eq_sguia	="".$rows['desc_eq_sguia']."";
		$desc_eq_scont	="".$rows['nom_eq']."";
		$desc_falla		="".$rows['desc_falla']."";
		$observ			="".$rows['observ']."";
		
		$fe_env_inf		="".$rows['fe_env_inf']."";
		$fe_aprov		="".$rows['fe_aprov']."";
		$fe_ent_rep		="".$rows['fe_ent_rep']."";
		$fe_ent_rep2	="".$rows['fe_ent_rep2']."";
		$fe_ent_rep3	="".$rows['fe_ent_rep3']."";
		$dias_rep		="".$rows['dias_rep']."";
		$fe_ent_aprox	="".$rows['fe_ent_aprox']."";
		
		$fe_ter_prod	="".$rows['fe_ter_prod']."";
		$guia_mgyt_ent	="".$rows['guia_mgyt_ent']."";
		$ent_par1		="".$rows['ent_par1']."";
		$ent_par2		="".$rows['ent_par2']."";
		$ent_par3		="".$rows['ent_par3']."";
		$ent_par4		="".$rows['ent_par4']."";
		$ent_par5		="".$rows['ent_par5']."";
		$fe_cierre_ods_fact	="".$rows['fe_cierre_ods_fact']."";
		$fe_fact		="".$rows['fe_fact']."";
		$precio			="".$rows['precio']."";
		$botar_rises	="".$rows['botar_rises']."";
	}
		if($fe_in_ret  			== "0000-00-00"){$fe_in_ret  		="";}
		if($fe_env_inf  		== "0000-00-00"){$fe_env_inf   		="";}
		if($fe_aprov	  		== "0000-00-00"){$fe_aprov  		="";}
		if($fe_ent_rep  		== "0000-00-00"){$fe_ent_rep   		="";}
		if($fe_ent_rep2  		== "0000-00-00"){$fe_ent_rep2   	="";}
		if($fe_ent_rep3  		== "0000-00-00"){$fe_ent_rep3   	="";}
		if($fe_ent_aprox  		== "0000-00-00"){$fe_ent_aprox   	="";}
		if($fe_ter_prod  		== "0000-00-00"){$fe_ter_prod 		="";}
		if($ent_par1  			== "0000-00-00"){$ent_par1  		="";}
		if($ent_par2  			== "0000-00-00"){$ent_par2    		="";}
		if($ent_par3  			== "0000-00-00"){$ent_par3    		="";}
		if($ent_par4 			== "0000-00-00"){$ent_par4 			="";}
		if($ent_par5 			== "0000-00-00"){$ent_par5  		="";}
		if($fe_cierre_ods_fact 	== "0000-00-00"){$fe_cierre_ods_fact="";}
		if($fe_fact				== "0000-00-00"){$fe_fact 			="";}
		
		$fe_in_ret			=	cambiarFecha($fe_in_ret, '-', '/' );
		$fe_env_inf			=	cambiarFecha($fe_env_inf, '-', '/' );
		$fe_aprov			=	cambiarFecha($fe_aprov, '-', '/' );
		$fe_ent_rep			=	cambiarFecha($fe_ent_rep, '-', '/' );
		$fe_ent_rep2		=	cambiarFecha($fe_ent_rep2, '-', '/' );
		$fe_ent_rep3		=	cambiarFecha($fe_ent_rep3, '-', '/' );
		$fe_ent_aprox		=	cambiarFecha($fe_ent_aprox, '-', '/' );
		$fe_ter_prod		=	cambiarFecha($fe_ter_prod, '-', '/' );
		$ent_par1			=	cambiarFecha($ent_par1, '-', '/' );
		$ent_par2			=	cambiarFecha($ent_par2, '-', '/' );
		$ent_par3			=	cambiarFecha($ent_par3, '-', '/' );
		$ent_par4			=	cambiarFecha($ent_par4, '-', '/' );
		$ent_par5			=	cambiarFecha($ent_par5, '-', '/' );
		$fe_cierre_ods_fact	=	cambiarFecha($fe_cierre_ods_fact, '-', '/' );
		$fe_fact			=	cambiarFecha($fe_fact, '-', '/' );
	
	$sqlf="SELECT * FROM items_oti WHERE num_oti='$num_oti' ";
	$respuesta=mysql_query($sqlf,$co);
	while ($row2 = mysql_fetch_array($respuesta)) {
            $consulta[] = $row2; 
	}
	mysql_close($co);
		
	
//*************** LOGO MGYT *****************************
$pdf->Image('../imagenes/empresas.jpg',12,8,40);

//************** PRIMERA FILA ***************************

$pdf->Cell(30,15," ",0,0,'C'); 
$pdf->Cell(128,15,"ORDEN DE SERVICIO",0,0,'C'); 
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
$pdf->Cell(37,5,"Maestranza MGYT",0,1,'C'); 

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
$pdf->Line(10, 34, 10, 120);
$pdf->Line(10, 120, 201, 120);
$pdf->Line(201, 34, 201, 120);
$pdf->SetLineWidth(0.2);	
/****************************************************************************************************************************************************************************
****************************************************************************************************************************************************************************/
$pdf->SetLineWidth(0.4);
$pdf->Line(10, 128, 201, 128);
$pdf->Line(10, 128, 10, 159);
$pdf->Line(10, 159, 201, 159);
$pdf->Line(201, 128, 201, 159);
$pdf->SetLineWidth(0.2);	
/****************************************************************************************************************************************************************************
****************************************************************************************************************************************************************************/
$pdf->SetLineWidth(0.4);
$pdf->Line(10, 168, 201, 168);
$pdf->Line(10, 168, 10, 240);
$pdf->Line(10, 240, 201, 240);
$pdf->Line(201, 168, 201, 240);
$pdf->SetLineWidth(0.2);	
/****************************************************************************************************************************************************************************
****************************************************************************************************************************************************************************/
$pdf->Cell(40,6,"AREA",0,0,'L');	
$pdf->Cell(50,6,"$area",1,0,'L');
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(40,6,"ODS",0,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(25,6,"$ods",1,1,'l');

$pdf->ln(1);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(40,6,"PRIORIDAD",0,0,'L');	
$pdf->Cell(50,6,"$priori",1,0,'L');
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(40,6,"ESTADO",0,0,'L');
$pdf->Cell(50,6,"$estado",1,1,'l');

$pdf->ln(1);
$planta = cortar($planta,40);

$pdf->Cell(40,12,"PLANTA",0,0,'L');	
$pdf->Cell(50,6,utf8_decode($planta[0]),1,0,'L');

$pdf->Cell(5,12,"",0,0,'L');
$pdf->Cell(40,12,"USUARIO",0,0,'L');
$pdf->Cell(50,12,"$usuario",1,1,'l');

$pdf->SetY(60);
$pdf->Cell(40,12,"",0,0,'L');	
$pdf->Cell(50,6,utf8_decode($planta[1]),1,0,'L');

$pdf->ln(7);

$pdf->Cell(40,6,"FECHA ING/RETIRO",0,0,'L');
$pdf->SetFont('Arial','B',8);	
$pdf->Cell(50,6,"$fe_in_ret",1,0,'L');
$pdf->Cell(5,6,"",0,0,'L');
$pdf->SetFont('Arial','B',7);
$pdf->Cell(40,6,"GUIA DESP. DET",0,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,6,"$guia_desp_det",1,1,'l');

$pdf->ln(1);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(40,6,"CANTIDAD",0,0,'L');
$pdf->SetFont('Arial','B',8);	
$pdf->Cell(50,6,"$cant",1,0,'L');
$pdf->Cell(5,6,"",0,0,'L');
$pdf->SetFont('Arial','B',7);
$pdf->Cell(40,6,"FAMILIA EQUIPO",0,0,'L');
$pdf->Cell(50,6,utf8_decode($fam_eq),1,1,'l');

$pdf->ln(1);

$pdf->Cell(40,6,"DESC EQUIPO SEGUN GUIA",0,0,'L');
$pdf->Cell(145,6,utf8_decode($desc_eq_sguia),1,1,'l');

$pdf->ln(1);

$pdf->Cell(40,6,"DESC EQUIPO SEGUN CTO.",0,0,'L');
$pdf->Cell(145,6,utf8_decode($desc_eq_scont),1,1,'l');

$pdf->ln(1);

$pdf->Cell(40,6,"DESCRIPCION FALLA",0,0,'L');
$pdf->Cell(145,6,utf8_decode($desc_falla),1,1,'l');

$pdf->ln(1);

$observ = cortar($observ,100);

$pdf->Cell(40,12,"OBSERVACIONES",0,0,'L');
$pdf->Cell(145,4,utf8_decode($observ[0]),1,1,'l');
$pdf->Cell(40,4,"",0,0,'L');
$pdf->Cell(145,4,utf8_decode($observ[1]),1,1,'l');
$pdf->Cell(40,4,"",0,0,'L');
$pdf->Cell(145,4,utf8_decode($observ[2]),1,1,'l');

$pdf->ln(20);

$pdf->Cell(33,6,"ESTADO INF TECNICO",0,0,'L');	
$pdf->Cell(25,6,"$est_inf",1,0,'L');
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(33,6,"FECHA ENVIO INFORME",0,0,'L');	
$pdf->SetFont('Arial','B',8);
$pdf->Cell(25,6,"$fe_env_inf",1,0,'L');
$pdf->Cell(5,6,"",0,0,'L');
$pdf->SetFont('Arial','B',7);
$pdf->Cell(33,6,"FECHA APROBACION",0,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(25,6,"$fe_aprov",1,1,'l');
$pdf->SetFont('Arial','B',7);

$pdf->ln(1);

$pdf->Cell(33,6,"FECHA ENT. RPTOS",0,0,'L');
$pdf->SetFont('Arial','B',8);	
$pdf->Cell(25,6,"$fe_ent_rep",1,0,'L');
$pdf->Cell(5,6,"",0,0,'L');
$pdf->SetFont('Arial','B',7);
$pdf->Cell(33,6,"FECHA ENT. RPTOS 2",0,0,'L');
$pdf->SetFont('Arial','B',8);	
$pdf->Cell(25,6,"$fe_ent_rep2",1,0,'L');
$pdf->Cell(5,6,"",0,0,'L');
$pdf->SetFont('Arial','B',7);
$pdf->Cell(33,6,"FECHA ENT. RPTOS 3",0,0,'L');	
$pdf->SetFont('Arial','B',8);
$pdf->Cell(25,6,"$fe_ent_rep3",1,1,'L');
$pdf->SetFont('Arial','B',7);

$pdf->ln(1);

$pdf->Cell(33,6,"DIAS REPARACION",0,0,'L');
$pdf->Cell(15,6,"$dias_rep",1,0,'l');
$pdf->Cell(15,6,"",0,0,'L');
$pdf->Cell(33,6,"FECHA TERM PRODUC.",0,0,'L');	
$pdf->Cell(25,6,"$fe_ter_prod",1,0,'L');
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(33,6,"FECHA ENT APROX.",0,0,'L');
$pdf->Cell(25,6,"$fe_ent_aprox",1,1,'l');

$pdf->ln(20);

$pdf->Cell(40,6,"ENTREGA PARCIAL 1",0,0,'L');	
$pdf->Cell(27,6,"$ent_par1",1,0,'L');
$pdf->Cell(10,6," Cant",0,0,'L');	
$pdf->Cell(13,6,"",1,0,'L');
$pdf->Cell(25,6,"",0,0,'L');
$pdf->Cell(40,6,"Nº GUIA DE DESPACHO",0,0,'L');	
$pdf->Cell(30,6,"$ent_par1",1,1,'L');

$pdf->ln(1);

$pdf->Cell(40,6,"ENTREGA PARCIAL 2",0,0,'L');
$pdf->Cell(27,6,"$ent_par2",1,0,'l');
$pdf->Cell(10,6," Cant",0,0,'L');	
$pdf->Cell(13,6,"",1,0,'L');
$pdf->Cell(25,6,"",0,0,'L');
$pdf->Cell(40,6,"Nº GUIA DE DESPACHO",0,0,'L');	
$pdf->Cell(30,6,"$ent_par1",1,1,'L');

$pdf->ln(1);

$pdf->Cell(40,6,"ENTREGA PARCIAL 3",0,0,'L');	
$pdf->Cell(27,6,"$ent_par3",1,0,'L');
$pdf->Cell(10,6," Cant",0,0,'L');	
$pdf->Cell(13,6,"",1,0,'L');
$pdf->Cell(25,6,"",0,0,'L');
$pdf->Cell(40,6,"Nº GUIA DE DESPACHO",0,0,'L');	
$pdf->Cell(30,6,"$ent_par1",1,1,'L');

$pdf->ln(1);

$pdf->Cell(40,6,"ENTREGA PARCIAL 4",0,0,'L');
$pdf->Cell(27,6,"$ent_par4",1,0,'l');
$pdf->Cell(10,6," Cant",0,0,'L');	
$pdf->Cell(13,6,"",1,0,'L');
$pdf->Cell(25,6,"",0,0,'L');
$pdf->Cell(40,6,"Nº GUIA DE DESPACHO",0,0,'L');	
$pdf->Cell(30,6,"$ent_par1",1,1,'L');

$pdf->ln(1);

$pdf->Cell(40,6,"ENTREGA PARCIAL 5",0,0,'L');	
$pdf->Cell(27,6,"$ent_par5",1,0,'L');
$pdf->Cell(10,6," Cant",0,0,'L');	
$pdf->Cell(13,6,"",1,0,'L');
$pdf->Cell(25,6,"",0,0,'L');
$pdf->Cell(40,6,"Nº GUIA DE DESPACHO",0,0,'L');	
$pdf->Cell(30,6,"$ent_par1",1,1,'L');

$pdf->ln(1);

$pdf->Cell(40,6,"CIERRE ODS FACT.",0,0,'L');
$pdf->Cell(50,6,"$fe_cierre_ods_fact",1,1,'l');

$pdf->ln(1);

$pdf->Cell(40,6,"FACTURACION",0,0,'L');	
$pdf->Cell(50,6,"$fe_cierre_ods_fact",1,0,'L');
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(40,6,"PRECIO",0,0,'L');
$pdf->Cell(50,6,"$precio",1,1,'l');

$pdf->ln(1);

$pdf->Cell(40,6,"BOTAR RISES",0,0,'L');	
$pdf->Cell(50,6,"$botar_rises",1,0,'L');
$pdf->Cell(5,6,"",0,0,'L');
$pdf->Cell(40,6,"Nº GUIA DESP MGYT ENTREGA",0,0,'L');
$pdf->Cell(50,6,"$guia_mgyt_ent",1,1,'l');

	$pdf->Output();
?>