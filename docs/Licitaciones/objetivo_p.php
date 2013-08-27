<?php
// Necesario para ver si la session esta activa  o si se tiene permiso de accseso
require("../lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php

if($_SESSION['usd_cot_lee'] != "1")
{
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}//Hasta aquí lo comun para todas las paginas restringidas

/*****************************************************************************************************
	SE INCLUYEN ARCHIVOS DE CONFIGURACION Y FUNCIONES
*****************************************************************************************************/
	include('../inc/config_db.php'); 	// Incluimos archivo de configuracion de la conexion
	include('../inc/lib.db.php');		// Incluimos archivo de libreria de funciones PHP
?>

<?php



//operacionales
$materiales		= $_POST['Cmateriales'];
$mantencion		= $_POST['Cmantencion'];
$combustible	= $_POST['Ccombustible'];
$maquinarias	= $_POST['Cmaquinarias'];
$seguridad		= $_POST['Cseguridad'];
$externos		= $_POST['Cexternos'];
$colaciones		= $_POST['Ccolaciones'];

//Remuneraciones
$sueldos		= $_POST['Csueldos'];
$bonos			= $_POST['Cbonos'];
$finiquitos		= $_POST['Cfiniquitos'];
$h_extras		= $_POST['Ch_extras'];

//gastos generales
$g_generales	= $_POST['Cg_general'];
$otros			= $_POST['Cotros_gastos'];
$bancarios		= $_POST['Cg_bancarios'];

$fecha			= date('d/m/Y');
$tipo 			= $_POST['tipo_ing'];
$num 			= $_POST['num'];

if($_POST['ingresa'] == "Ingresar")
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS",$co);

/**********************************************************************************************************************************
								SI SE MARCO EL RADIO DE CODIGO AUTOMATICO
**********************************************************************************************************************************/	
	if($tipo == "Cotizacion")
	{	
		$mayor =0;					
		$consulta		= "SELECT aux_cot FROM tb_cotizaciones WHERE tipo_ing = 'Cotizacion' "; 
		$resp			= mysql_query($consulta, $co);
		while($vrows 	= mysql_fetch_array($resp))
		{	
		
			$cadena = $vrows['aux_cot'];
			$numero = "";
		
			for( $index = 0; $index < strlen($cadena); $index++ )
			{
				if( is_numeric($cadena[$index]) )
				{
					$numero .= $cadena[$index];
				}
			}
		
			if($numero > $mayor )
			{
				$mayor = $numero;
			}
		}
		$n			=	$mayor + 1;
		$num_cot	=	"1500-".$n;
		
	}
					
	if($tipo == "Licitacion")
	{						
		$mayor =0;					
		$consulta		= "SELECT num_cot FROM tb_cotizaciones WHERE tipo_ing = 'Licitacion' "; 
		$resp			= mysql_query($consulta, $co);
		while($vrows 	= mysql_fetch_array($resp))
		{	
		
			$cadena = $vrows['num_cot'];
			$numero = "";
		
			for( $index = 0; $index < strlen($cadena); $index++ )
			{
				if( is_numeric($cadena[$index]) )
				{
					$numero .= $cadena[$index];
				}
			}
		
			if($numero > $mayor )
			{
				$mayor = $numero;
			}
		}
		$n			=	$mayor + 1;
		$num_cot	=	$n;

	}

	$sql = "SELECT * FROM tb_p_objetivo where num_cot = '$num_cot'";
	$rs  = mysql_query($sql,$co);
	$val = mysql_num_rows($rs);

	if ($val == 0) {
		
		if ($_SESSION['us_tipo']=="Coordinador" or $_SESSION['us_tipo'] == "Administrador" and $_POST['num'] == "Automatico") {

			$sql = "INSERT INTO tb_p_objetivo (materiales,
											   mantencion,
											   combustibles,
											   arri_maquinarias,
											   imp_seguridad,
											   serv_externos,
											   colaciones,
											   sueldos,
											   bonos,
											   finiquitos,
											   horas_extras,
											   gastos_generales,
											   otros_gastos,
											   gastos_bancarios,
											   num_cot,
											   fecha)
										VALUES('$materiales',
											   '$mantencion',
											   '$combustible',
											   '$maquinarias',
											   '$seguridad',
											   '$externos',
											   '$colaciones',
											   '$sueldos',
											   '$bonos',
											   '$finiquitos',
											   '$h_extras',
											   '$g_generales',
											   '$otros',
											   '$bancarios',
											   '$num_cot',
											   '$fecha')";
			mysql_query($sql,$co);
			echo "<script>alert('Datos Almacenado Correctamente');</script>";
			echo "<script>Location.href='cotizaciones.php';</script>";
			echo "<script>parent.$.fancybox.close();</script>";

		}else{
			echo "<script>alert('Error: Ya Existe esta informacion');</script>";
			echo "<script>Location.href='cotizaciones.php';</script>";
			echo "<script>parent.$.fancybox.close();</script>";
		}

	}else{
		echo "<script>alert('Error: Ya Existe esta informacion');</script>";
		echo "<script>Location.href='cotizaciones.php';</script>";
		echo "<script>parent.$.fancybox.close();</script>";
	}


}
?>	