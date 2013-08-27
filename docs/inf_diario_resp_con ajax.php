<?
// Necesario para ver si la session esta activa  o si se tiene permiso de accseso
require("lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php
//
//Definimos el nivel de acceso  (esto es un bonus track para definir que ciertos usuarios puedan entrar a algunas paginas y a otras no)
// Si los usuarios normales tienen acceso=10, para que  accedan todos los usuarios le damos acceso mayor a 10.
/*$nivel_acceso =10;
if ($nivel_acceso < $_SESSION['usuario_nivel']){
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}*/
/*********************************************************************************************************************************************************
//Hasta aquí lo comun para todas las paginas restringidas
*********************************************************************************************************************************************************/
	include('inc/config_db.php');
	include('inc/lib.db.php');

/*********************************************************************************************************************************************************
	FUNCION PARA CREAR LAS FILAS POR CADA REGISTRO ENCONTRADO	
*********************************************************************************************************************************************************/
$_POST['f1']	=	cambiarFecha($_POST['f1'], '/', '-' );

function CreaFilaB($cod_inf, $v_id_d, $v_rut, $v_trab, $v_est, $v_mot, $v_ods, $v_cc, $v_hrs, $v_hh50, $v_hh75, $v_hh100, $v_total, $area_i, $fe_inf)
{
	$co=mysql_connect($GLOBALS["DNS"], $GLOBALS["USR"], $GLOBALS["PASS"]);
	mysql_select_db($GLOBALS["BDATOS"], $co);
	
	if($v_ods 	== 0)	{	$v_ods	= "";	}
	if($v_cc 	== 0)	{	$v_cc	= "";	}
	if($v_hrs 	== 0)	{	$v_hrs	= "";	} 
	if($v_hh50 	== 0)	{	$v_hh50	= "";	}
	if($v_hh100 == 0)	{	$v_hh100= "";	}  
	if($v_est == "Ausente")	{$colorf = "yellow";}else{$colorf = "";} 
	           
	echo"<tr bgcolor='$colorf'>
			<td width='186'>
				<select id='trabajadores' name='trabajadores[]' style='width: 170px'>";
				
				$sqlc  		= "SELECT * FROM trabajadores WHERE area_t = '$area_i' and est_alta = 'Vigente' ORDER BY nom_t";
				$respuesta 	= mysql_query($sqlc,$co);
				
				while($vrows=mysql_fetch_array($respuesta))
				{
					$trabj[] = $vrows;
				}
				
				$i				= 0;
				$cont_re	 	= count($trabj);
				
				echo"<option selected='selected' value='$v_rut'>$v_trab</option>";
				while($i < $cont_re)
				{
					$resto_apm = substr ($trabj[$i]['apm_t'], 0, 1); // devuelve inicial de apellido materno 
					echo"<option value='".$trabj[$i]['rut_t']."'>".$trabj[$i]['nom_t']." ".$trabj[$i]['app_t']." ".$resto_apm.".</option>";
					
				$i++;
				}
				echo"</select>
			</td>
			
			<td>
				<select id='estado' name='estado[]' style='width: 90px' onchange='validar(this)'>
					<option selected='selected' value='$v_est'>$v_est</option>
					<option value='Presente'>Presente</option>
					<option value='Ausente'>Ausente</option>
				</select>
			</td>
			<td>  
            	<select id='motivo' name='motivo[]' style='width: 190px' onchange='validar_motivo(this)'>
					<option selected='selected' value='$v_mot'>$v_mot</option>
					<option value='Dia compensado'>Dia compensado</option>
					<option value='Falla'>Falla</option>
                    <option value='Licencia'>Licencia</option>
                    <option value='Permiso a descuento'>Permiso a descuento</option>
					<option value='Permiso administrativo'>Permiso administrativo</option>
					<option value='Permiso con goze de sueldo'>Permiso con goze de sueldo</option>
                    <option value='Permiso Legal'>Permiso Legal</option>
					<option value='Permiso sindical'>Permiso sindical</option>
                    <option value='Terreno'>Terreno</option>
					<option value='Turno'>Turno</option>
                    <option value='Vacaciones'>Vacaciones</option>
				</select>
			</td>
                          
			<td><input type='text' value='$v_ods' name='ods[]' maxlength='11' style='width: 80px'/></td>
			<td><input type='text' value='$v_cc' name='cc[]' maxlength='11' style='width: 80px'/></td>
			<td><input type='text' value='$v_hrs' name='hhn[]' maxlength='11' style='width: 40px' /></td>
			<td><input type='text' value='$v_hh50' name='hh50[]' maxlength='11' style='width: 40px' /></td>
			<td><input type='text' value='$v_hh100' name='hh100[]' maxlength='11' style='width: 40px' /></td>
			<input type='hidden' name='aux[]' value='$v_mot'/>
			<td>
				<input type='text' value='$v_total' name='total[]' maxlength='11' style='width: 30px' readonly='readonly'/>
				<input type='hidden' name='id[]' value='$v_id_d'/>
				
			</td>";
			
			if($_SESSION['usuario_pyc'] == "administrador")
			{			  
				echo"<td align='center'>
				<a href='eliminar_item_infd.php?id=$v_id_d&inf=$cod_inf&f1=$fe_inf&area=$area_i' onclick='return confirmar(\"Esta Seguro de querer eliminar el registro seleccionado?\")'><img src='imagenes/remove.png' border='0' valign='top' alt='Eliminar' />&nbsp;&nbsp;</td>";
				
			}
			echo"</tr>";
}
?>
<?php
//********************************************************************************************************************************
	$trab 		= "--------- Seleccione ---------";
	$mot  		= "--------- Seleccione ---------";
	$est_dia  	= "Presente";
	$area 		= "-- Seleccione Area --";
	$fe   		= date("d/m/Y");
	$num		= 2;
//********************************************************************************************************************************
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Informe Diario Personal</title>

<link href="inc/bibliocss.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="JavaScript" src="inc/funciones.js"></script>

<LINK href="inc/epoch_styles.css" type=text/css rel=stylesheet>
<SCRIPT src="inc/epoch_classes.js" type=text/javascript></SCRIPT>

<script language="javascript" src="js/jquery-1.2.6.min.js"></script>

<script LANGUAGE="JavaScript">

$(document).ready(function(){
	
	// Parametros para e combo1
   $("#combo1").change(function () {
   		$("#combo1 option:selected").each(function () {
			//alert($(this).val());
				elegido=$(this).val();
				$.post("combo1.php", { elegido: elegido }, function(data){
				$("#combo2").html(data);
				$("#combo3").html("");
			});			
        });
   })
	// Parametros para el combo2
	$("#combo2").change(function () {
   		$("#combo2 option:selected").each(function () {
			//alert($(this).val());
				elegido=$(this).val();
				$.post("c2.php", { elegido: elegido }, function(data){
				$("#combo3").html(data);
			});			
        });
   })
});

function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

<!--
//Author: Michael Gudaitis
//e-mail: mike@gr8net.com
//You may use this script free of charge so long as
//this copyright information stays intact.
//copyright 1998
//Updated: Friday, January 29, 1999

function cala_day(form) {
	
	var fecha = form.f1.value;

	var fes		= fecha.split("/");
	var nDay 	= parseInt(fes[0]);
	var nMonth 	= parseInt(fes[1]);
	var nYear 	= parseInt(fes[2]);
	
	var nDayOfWeek = cala_weekday(nMonth, nDay, nYear)
	
	dia_retornados = day_display(form, nDayOfWeek)
	return dia_retornados;
}

function cala_weekday( x_nMonth, x_nDay, x_nYear) {

	if(x_nMonth >= 3){	
		x_nMonth -= 2;
	}
	else {
		x_nMonth += 10;
	}

	if( (x_nMonth == 11) || (x_nMonth == 12) ){
		x_nYear--;
	}

	var nCentNum = parseInt(x_nYear / 100);
	var nDYearNum = x_nYear % 100;

	var g = parseInt(2.6 * x_nMonth - .2);

	g +=  parseInt(x_nDay + nDYearNum);
	g += nDYearNum / 4;	
	g = parseInt(g);
	g += parseInt(nCentNum / 4);
	g -= parseInt(2 * nCentNum);
	g %= 7;
	
	if(x_nYear >= 1700 && x_nYear <= 1751) {
		g -= 3;
	}
	else {
		if(x_nYear <= 1699) {
			g -= 4;
		}
	}
	
	if(g < 0){
		g += 7;
	}
	
	return g;
}

function day_display(form, x_nDayOfWeek) {

	if(x_nDayOfWeek == 0) {
		dia_sem = "Domingo";
		return dia_sem;
	}
	if(x_nDayOfWeek == 1) {
		dia_sem = "Lunes";
		return dia_sem;
	}
	if(x_nDayOfWeek == 2) {
		dia_sem = "Martes";
		return dia_sem;
	}
	if(x_nDayOfWeek == 3) {
		dia_sem = "Miercoles";
		return dia_sem;
	}
	if(x_nDayOfWeek == 4) {
		dia_sem = "Jueves";
		return dia_sem;
	}
	if(x_nDayOfWeek == 5) {
		dia_sem = "Viernes";
		return dia_sem;
	}
	if(x_nDayOfWeek == 6) {
		dia_sem = "Sabado";
		return dia_sem;
	}

	dia_sem = "Error, 'Año'.";
}

<!------------------------- FIN DE FUNCIONES PARA SACAR DIA -------------------------->

/*******************************************************************************************************************
				FUNCION PARA MOSTRAR UN CALENDARIO PARA SELECCIONAR FECHA (DATAPICKER)
********************************************************************************************************************/
var dp_cal;
window.onload = function () {
	stime = new Date();

	dp_cal 	  = new Epoch('dp_cal','popup',document.getElementById('date_field'));
}; 

/*******************************************************************************************************************
				FUNCION PARA CREAR LINEAS DE REGISTROS
********************************************************************************************************************/
    // Variable de Conteo de lineas
    var lineCount = new Array();
	
    /**
     * Agrega una linea de datos a un formulario
     * @param string div El ID del div objetivo donde se agrega una linea
     * @param string line El ID del div que contiene la linea a agregar
     * @param string f Funcion extra para pasarle a los eventos
     */
    function addFormLine(div, line, f)
    {
        var f 				= (f == null) ? "" : f;
        lineCount[div] 		= lineCount[div] == null ? 1 : lineCount[div] + 1;
        var mySelf 			= div + "_line_" + lineCount[div];
        var myNum 			= lineCount[div];
        var divTarget 		= document.getElementById(div);
        var divLine 		= document.getElementById(line).innerHTML;
        var newDiv 			= document.createElement('div');
        newDiv.className 	= 'row';
        newDiv.setAttribute('id', mySelf);
        divLine 			= divLine.replace(/mySelf/g, mySelf);
        newDiv.innerHTML 	= divLine;
        newDiv.innerHTML += "<div class=\"cell\"><img style=\"cursor: pointer;\" src=\"imagenes/remove.png\" border=\"0\" onclick=\"removeFormLine(\'" + mySelf + "\'); " + f + "\"></div>";

        divTarget.setAttribute('cab', '1');

        divTarget.appendChild(newDiv);
    }

    /**
     * Elimina una linea de un formulario
     * @param string div El ID del div que se quiere eliminar
     */
    function removeFormLine(div)
    {
        var parentName = div.replace(/_line_\w+/g, '');
        var divParent = document.getElementById(parentName);
        var divTarget = document.getElementById(div);
        var hasTitle = divParent.getAttribute('cab');
        divParent.removeChild(divTarget);
        if (divParent.childNodes.length == 0){
            divParent.innerHTML = "";
        }
    }
/*******************************************************************************************************************
										FUNCIONES CONFIRM
********************************************************************************************************************/
function eli()
{
var agree=confirm("Esta Seguro de Querer Eliminar Este Registro ?");
if (agree)
	return true ;
else
	return false ;
}

function mod()
{
	var agree=confirm("Esta Seguro de Querer Modificar El Informe Diario ?");
	if (agree){
		document.f.action='inf_diario_p.php'; 
		document.f.submit();
		return true ;
	}else{
		return false ;
	}
}

function rep(url)
{
	document.f.action=url;
}

function creando()
{
	var cant = document.f.cant.value;
	
	if(cant > 1)
	{
		for(var x = 0; x < cant;++x)
		{
			addFormLine('myDiv', 'myLine');
		}
		document.f.cant.value = "";
	}else{
		addFormLine('myDiv', 'myLine');  
	}
}

function validar(elemento)
{
	var estado 	= document.getElementsByName("estado[]");
	var motivo 	= document.getElementsByName("motivo[]");
	var n_ods 	= document.getElementsByName("ods[]");
	var n_cc 	= document.getElementsByName("cc[]");
   	var n_hh  	= document.getElementsByName("hhn[]");
   	var n_hh50 	= document.getElementsByName("hh50[]");
   	var n_hh100 = document.getElementsByName("hh100[]");
	var total	= document.getElementsByName("total[]");
	var aux	    = document.getElementsByName("aux[]");
   
   var t = estado.length-1;
   for(var x = 0; x < t; ++x)
   {
	 if(elemento == estado[x]) 
	 {
	 	if(elemento.value == "Ausente")
		{
			motivo[x].disabled	= false;
			n_ods[x].readOnly	= true;
			n_cc[x].readOnly	= true;
			n_hh50[x].readOnly	= true;
			n_hh100[x].readOnly	= true;
			aux[x].value = '';
			
			n_ods[x].style.background	= '#f9b522'
			n_cc[x].style.background	= '#f9b522'
			n_hh[x].style.background	= '#FFFFFF'
			n_hh50[x].style.background	= '#f9b522'
			n_hh100[x].style.background	= '#f9b522'
			total[x].style.background	= '#f9b522'
		}else{
			motivo[x].disabled	= true;
			aux[x].value = '';
			n_ods[x].readOnly	= false;
			n_cc[x].readOnly	= false;
			n_hh50[x].readOnly	= false;
			n_hh100[x].readOnly	= false;
			
			n_ods[x].style.background	= '#FFFFFF'
			n_cc[x].style.background	= '#FFFFFF'
			n_hh[x].style.background	= '#FFFFFF'
			n_hh50[x].style.background	= '#FFFFFF'
			n_hh100[x].style.background	= '#FFFFFF'
			total[x].style.background	= '#FFFFFF'
		}
	 }
   }
}

function validar_motivo(elemento)
{
	var estado 	= document.getElementsByName("estado[]");
	var motivo 	= document.getElementsByName("motivo[]");
	var aux	    = document.getElementsByName("aux[]");
   
   var t = estado.length-1;
   for(var x = 0; x < t; ++x)
   {
	 if(elemento == motivo[x]) 
	 {
		aux[x].value = motivo[x].value;
	 }
   }
}

function ingresar()
{
	var formulario 		= document.f;
	var fecha 			= document.f.f1.value;
	var area  			= document.f.combo3.value;
	var trabajadores 	= document.getElementsByName("trabajadores[]");
	var estado 			= document.getElementsByName("estado[]");
	var motivo 			= document.getElementsByName("motivo[]");
	var n_ods 			= document.getElementsByName("ods[]");
	var n_cc 			= document.getElementsByName("cc[]");
   	var n_hh  			= document.getElementsByName("hhn[]");
   	var n_hh50 			= document.getElementsByName("hh50[]");
   	var n_hh100 		= document.getElementsByName("hh100[]");
	var total			= document.getElementsByName("total[]");
	var val_trab		= document.getElementsByName("val_trab[]");
	var nom_trab		= document.getElementsByName("nom_trab[]");
	var cantidad 		= val_trab.length;
	var t 				= trabajadores.length-1; // PARA CONTAR LAS LINEAS A INGRESAR

	DiadeInforme = cala_day(formulario);
	alert(DiadeInforme);

	if(DiadeInforme != "Sabado" && DiadeInforme != "Domingo") // Si el dia a ingresar es laboral
	{
		if(fecha != "") // Verificamos que la fecha no este en blanco
		{
			if(area != "-- Seleccione Area --" && area != "") // Verificamos si se selecciono el Area
			{
				for(var x = 0; x < cantidad; ++x) 	// INICIAMOS EL CONTADOR HASTA EL TOTAL DE TRABAJADORES POR AREA (BD)
				{	
					suma = 0;
					for(var y=0; y < t; ++y) 		// INICIALIZAMOS UN CICLO FOR HASTA LA CANTIDAD DE REGISTRO ENCONTRADOS (A INGRESAR)
					{
						if(trabajadores[y].value != "Seleccione..." )
						{
							if((estado[y].value == "Ausente" && motivo[y].value != "") ||  (estado[y].value != "Ausente"))
							{	
								if((n_ods[y].value != "" || n_cc[y].value != "") || (estado[y].value == "Ausente")) // 
								{	
									if(n_hh[y].value != "" )
									{	
										if(val_trab[x].value == trabajadores[y].value) // Comparamos a los trabajadores por area con los registros a ingresar
										{
											suma += parseFloat(n_hh[y].value);
										} 
										// Fin de comparacion de trabajadores
									}else{
										alert("Debe ingresar cantidad de horas");
										n_hh[y].focus();
										return false;
									}		
								}else{
									alert("Debe ingresar ODS o Centro de costo");
									n_ods[y].focus();
									return false;
								}			
							}else{
								alert("Debe Seleccionar motivo de la ausencia del trabajador");
								motivo[y].focus();
								return false;
							}
						}else{
							alert("Debe Seleccionar trabajador o eliminar la linea");
							trabajadores[y].focus();
							return false;
						}
						
					} // Fin del ciclo for Y
					
					if(suma > 0 && suma < 9){	alert("Al trabajador: "+nom_trab[x].value+" tiene informadas solo: "+suma+" hrs"); return false}
					if(suma > 9){				alert("El trabajador: "+nom_trab[x].value+" tiene "+suma+" hrs informadas (no puede superar las 9 hrs)"); return false}
					//if(suma == 0 || suma == ""){alert("Al trabajador: "+nom_trab[x].value+" No esta informado"); return false}
	

				} // Fin del ciclo for x
					var agree=confirm("Esta Seguro de Querer enviar los datos ?");
					if (agree)
					{
						document.f.action='inf_diario_p.php'; 
						document.f.submit();
						return true;
					}else{
						return false;
					}
			}else{
				alert("Debe Seleccionar Area");
				document.f.combo3.focus();
				return false;
			}
		}else{
			alert("Debe Seleccionar Fecha");
			document.f.f1.focus();
			return false;
		}
	}else{
		if(fecha != "") // Verificamos que la fecha no este en blanco
		{
			if(area != "-- Seleccione Area --" && area != "") // Verificamos si se selecciono el Area
			{
				for(var x = 0; x < cantidad; ++x) 	// INICIAMOS EL CONTADOR HASTA EL TOTAL DE TRABAJADORES POR AREA (BD)
				{	
					suma = 0;
					for(var y=0; y < t; ++y) 		// INICIALIZAMOS UN CICLO FOR HASTA LA CANTIDAD DE REGISTRO ENCONTRADOS (A INGRESAR)
					{
						if(trabajadores[y].value != "Seleccione..." )
						{
							if(n_hh[y].value == "" ||  n_hh[y].value == 0)
							{	
								if(n_ods[y].value != "" || n_cc[y].value != "") // 
								{	
									if(n_hh50[y].value != "" )
									{	
										if(val_trab[x].value == trabajadores[y].value) // Comparamos a los trabajadores por area con los registros a ingresar
										{
											suma += parseFloat(n_hh[y].value);
										} 
										// Fin de comparacion de trabajadores
									}else{
										alert("Debe ingresar cantidad de horas extras");
										n_hh50[y].focus();
										return false;
									}		
								}else{
									alert("Debe ingresar ODS o Centro de costo");
									n_ods[y].focus();
									return false;
								}			
							}else{
								alert("No debe ingresar hrs normales los dias festivos corresponden HRS EXTRAS");
								n_hh[y].value = "";
								n_hh50[y].focus();
								return false;
							}
						}else{
							alert("Debe Seleccionar trabajador o eliminar la linea");
							trabajadores[y].focus();
							return false;
						}
						
					} // Fin del ciclo for Y
					
					/*if(suma > 0 && suma < 9){	alert("Al trabajador: "+nom_trab[x].value+" tiene informadas solo: "+suma+" hrs"); return false}
					if(suma > 9){				alert("El trabajador: "+nom_trab[x].value+" tiene "+suma+" hrs informadas (no puede superar las 9 hrs)"); return false}
					if(suma == 0 || suma == ""){alert("Al trabajador: "+nom_trab[x].value+" No esta informado"); return false}*/
	
				} // Fin del ciclo for x
					var agree=confirm("Esta Seguro de Querer enviar los datos ?");
					if (agree)
					{
						document.f.action='inf_diario_p.php'; 
						document.f.submit();
						return true;
					}else{
						return false;
					}
			}else{
				alert("Debe Seleccionar Area");
				document.f.combo3.focus();
				return false;
			}
		}else{
			alert("Debe Seleccionar Fecha");
			document.f.f1.focus();
			return false;
		}
	}
}

function enviar(url)
{
	document.f.action=url;
}

function recargar()
{
	document.f.submit();
}

function enviar_c1()
{
	document.f.c2.value= "";
	document.f.combo3.value= "";
	document.f.submit();
}

function enviar_c2()
{
	document.f.combo3.value= "";
	document.f.submit();
}

function evento()
{
	document.f.submit();
}

function limpiar()
{
	document.f.f1.value = '';
	document.f.combo3.value = '';
	document.f.submit();
}


function rep_pdf()
{
	var cod_inf = document.f.cod_inf.value;
	abrirVentanaM("rep_inf_diario.php?c_inf="+cod_inf,"yes");	
}
</SCRIPT>

    <style type="text/css" media="all">

    .hide {
		font: bold 6px Verdana, Arial, Helvetica, serif;
        visibility: hidden;
        display: none;
    }

    div.row {
        display: table-row;
        clear: both;
        padding: 2px;
        vertical-align: top;
    }

    div.row div {
        display: table-cell;
        padding: 2px;
        vertical-align: middle;
        float:left;
        display: inline;
    }

    div.row div.title {
        display: table-cell;
        padding: 2px;
        margin: 2px;
        background-color: #527eab;
        font: bold 12px Verdana, Arial, Helvetica, serif;
        color: #153244;
        vertical-align: middle;
    }

    div.row div img{
        vertical-align: bottom;
        border:0px solid;
        padding-left: 1px;
    }

    input, textarea {
        font: 12px Verdana, Arial, Helvetica, serif;
        border: #153244 1px solid;
        color: #000000;
        background-color: #FFFFFF;
        padding: 1px 3px 1px 3px;
    }

    select {
        font: 11px Verdana, Arial, Helvetica, serif;
        border: #153244 1px solid;
        color: #000000;
        background-color: #cedee1;
    }

body {
	background-color: #527eab;
	background-image: url();
}
.Estilo5 {color: #000000}
.Estilo6 {color: #FFFFFF}
-->
</style>
</head>


<body>
 <?php			  
/**************************************************************************
	COMIENZA REPORTE EXCEL
**************************************************************************/	
	require_once("excelclass/class.writeexcel_workbookbig.inc.php");
	require_once("excelclass/class.writeexcel_worksheet.inc.php");
	require_once("excelclass/functions.writeexcel_utility.inc.php");
	
	$fname="tmp/report.xls";
	$workbook2  = & new writeexcel_workbookbig($fname);
	$hojac		=	cambiarFecha($_POST['f1'], '-', '-' ); 
	$worksheet	= & $workbook2->addworksheet($hojac);
	////formato////
	
	$formato=& $workbook2->addformat();
	$formato->set_size(8);
	$formato->set_border_color('black');
	$formato->set_top(1);
	$formato->set_bottom(1);
	$formato->set_left(1);
	$formato->set_right(1);
	
	$encabezado=& $workbook2->addformat();
	$encabezado->set_size(8);
	$encabezado->set_border_color('black');
	$encabezado->set_top(1);
	$encabezado->set_bottom(1);
	$encabezado->set_left(1);
	$encabezado->set_right(1);
	$encabezado->set_pattern();         # Set pattern to 1, i.e. solid fill
    $encabezado->set_fg_color('silver'); # Note foreground and not background
    //$encabezado->write(0, 0, "Ray", $encabezado);
	
	$for_titulo=& $workbook2->addformat();
	$for_titulo->set_bold();
	$formato2=& $workbook2->addformat();
	$formato2->set_size(10);
	$formato2->set_align('center');
	$worksheet->set_column(0,30,15);
	$worksheet->set_row(0,15);
	for($a=1;$a<100;$a++)
	{
		$worksheet->set_row($a,12);
	}
	$tit_subt=& $workbook2->addformat();
	$tit_subt->set_bold();
	$tit_subt->set_size(8);
	$tit_subt->set_border_color('black');
	
	
	// titulo
	$worksheet->write(0,4,"INFORME DIARIO DE ACTIVIDAD DE PERSONAL",$for_titulo);
	
	// ENCABEZADOS
	
	$worksheet->write(5,0,"TRABAJADOR",$encabezado);
	$worksheet->write(5,1,"RUT",$encabezado);
	$worksheet->write(5,2,"ESTADO",$encabezado);
	$worksheet->write(5,3,"MOTIVO",$encabezado);
	$worksheet->write(5,4,"ODS",$encabezado);
	$worksheet->write(5,5,"CC",$encabezado);
	$worksheet->write(5,6,"HHN",$encabezado);
	$worksheet->write(5,7,"HH50%",$encabezado);
	$worksheet->write(5,8,"HH100%",$encabezado);
	$worksheet->write(5,9,"TOTAL",$encabezado);
	
/**************************************************************************
	
**************************************************************************/	 
$_POST['f1']	=	cambiarFecha($_POST['f1'], '-', '/' );

$worksheet->write(2,0,"Fecha Informe: ",$formato); 
$worksheet->write(2,1,$_POST['f1'],$formato); 
$worksheet->write(3,0,"Area Informe: ",$formato); 
$worksheet->write(3,1,$_POST['combo3'],$formato); 

$_POST['f1']	=	cambiarFecha($_POST['f1'], '/', '-' );
/***********************************************************************************************************
								BUSCAMOS UN INFORME POR SU FECHA Y AREA
************************************************************************************************************/
if($_POST['busca'] == "Buscar")
{	
	$query="SELECT * FROM inf_diario2 WHERE fecha_inf = '".$_POST['f1']."' and area_inf = '".$_POST['combo3']."' ";
}
if($_GET['cod'] != "")
{	
	$query="SELECT * FROM inf_diario2 WHERE cod_inf = '".$_GET['cod']."' ";
}
if($_POST['ingresa'] != "")
{
	$query = "SELECT * FROM inf_diario2, detalle_inf2 WHERE inf_diario2.cod_inf='".$_POST['ingresa']."' ";
}
if($_POST['modifica'] != "")
{
	$query = "SELECT * FROM inf_diario2 WHERE cod_inf='".$_POST['modifica']."' ";
}
if($_POST['elimina_item'] != "")
{
	$query = "SELECT * FROM inf_diario2 WHERE cod_inf='".$_POST['elimina_item']."' ";
}
if($_POST['combo3'] != "")
{
	$query="SELECT * FROM inf_diario2 WHERE fecha_inf = '".$_POST['f1']."' and area_inf = '".$_POST['combo3']."' ";
}
if($_POST['busca'] == "Buscar" or $_POST['ingresa'] != "" or $_POST['modifica'] != "" or $_POST['elimina_item'] != "" or $_POST['combo3'] != "" or $_GET['cod'] != "")
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sqlc	= $query;
	$res	= mysql_query($sqlc,$co);
	$cont 	= mysql_num_rows($res);
	
	if($_POST['busca'] == "Buscar" and $cont == 0){alert("  No se encontraron registros del dia y area seleccionada  ");}
	if($cont != 0)
	{
		while($vrows=mysql_fetch_array($res)){
			$cod 		= "".$vrows['cod_inf']."";
			$area_inf	= "".$vrows['area_inf']."";
			$fe_inf		= "".$vrows['fecha_inf']."";
			$env_por	= "".$vrows['env_por']."";
			/****************************************************************/
			/****************************************************************/
			$sql_a 		= "SELECT * FROM tb_areas WHERE cod_ar = '$area_inf' ";
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
			
			
		}
	}
}
?>
<table width="944" height="367" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
  <tr>
    <td width="100" height="54" align="center" valign="top"><img src="images/logo_c.jpg" width="100" height="60" /></td>
    <td width="744" align="center" valign="middle" bgcolor="#FFFFFF"><img src="imagenes/Titulos/inf_diario.gif" width="500" height="45" /></td>
    <td width="100" align="center" valign="top"><img src="imagenes/logo_iso_c.jpg" width="100" height="52" /></td>
  </tr>
  
  <tr>
    <td height="309" colspan="3" align="center" valign="top">
    <form action="" method="post" name="f" id="f">
    <table width="926" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"><table width="921" height="45" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CEDEE1">
          <tr>
            <td align="right"><table width="905" height="60" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="95" height="60" align="right">
                  <input name="button8" type="submit" class="boton_inicio" id="button8" value="Inicio" onclick="enviar('index2.php')" /></td>
                  <td width="193" align="right"></td>
                  <td width="99" align="right"></td>
                  <td width="99" align="right"></td>
                  <td width="99" align="right">&nbsp;</td>
                  <td width="99" align="center">&nbsp;</td>
                  <td width="102" align="center"><input name="button4" type="button" class="boton_pdf" id="button7" value="Pdf" onclick="rep_pdf()" /></td>
                  <td width="102" align="right"><input name="button2" type="submit" class="boton_lista2" id="button9" value="Listado Inf." onclick="enviar('lista_infd.php')" /></td>
                  <td width="17" align="right">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center"><table width="921" height="230" border="0">
          <tr>
            <td width="911" height="224" align="center" valign="top">
                <table width="916" height="202" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="916" height="39" align="center" valign="top">
                    
                    <fieldset class="txtnormalB">
                    <legend class="txtnormaln">Informes Diarios</legend><br />
                    <table width="909" border="0" cellpadding="0" cellspacing="0" class="txtnormal7">
                      <tr>
                        <td width="24" align="left">&nbsp;</td>
                        <td width="186" align="left"><span class="content">FECHA : </span></td>
                        <td width="192" align="left">GERENCIA</td>
                        <td width="189" align="left">DEPARTAMENTO</td>
                        <td width="194" align="left">AREA</td>
                        <td width="124">&nbsp;</td>
                      </tr>
                      <tr class="txtnormal">
                        <td width="24" align="left" valign="middle">&nbsp;</td>
                        <td width="186" align="left" valign="middle"><span class="content"><span class="content Estilo8">
                          <?php 
									if($_POST['f1'] != "" and $_POST['fecha'] == ""){$fec = $_POST['f1'];}
									if($_POST['fecha'] != ""){$fec = $_POST['fecha'];}
                   					$fec	=	cambiarFecha($fec, '-', '/' ); 
								?>
                          </span>
                          <input id="date_field" style="WIDTH: 7em" name="f1" value="<? echo $fec; ?>" />
                          <input type="button" class="botoncal" onclick="dp_cal.toggle();" value="..." />
                        </span></td>
                        <td width="192" align="left" valign="middle">
                        
                        <select name="combo1" class="combos" id="combo1" style="width: 180px;" >
                          <?php
                              //*******************************************************************************************************
								$sql  = "SELECT cod_ger, desc_ger FROM tb_gerencia ORDER BY desc_ger ";
	
								$rs 	= dbConsulta($sql);
								$total  = count($rs);
								echo"<option selected='selected' value='$cod_ger'>$desc_ger</option>";
										
								for ($i = 0; $i < $total; $i++)
								{
									$desc_ger = $rs[$i]['desc_ger'];
									if($sel != $desc_ger){
										echo "<option value='".$rs[$i]['cod_ger']."'>".$rs[$i]['desc_ger']."</option>";
									}
								}
							?>
                        </select>
                        </td>
                        <td align="left" valign="middle">
                        
                        <select name="combo2" class="combos" id="combo2" style="width: 180px;" >
                          <?php echo"<option selected='selected' value='$cod_dep'>$desc_dep</option>"; ?>
                        </select>
                        
                        </td>
                        <td align="left" valign="middle"><select name="combo3" class="combos" id="combo3" style="width: 180px;">
                          
                          <?php echo"<option selected='selected' value='$cod_ar'>$area_t</option>"; ?>
                        </select>
                        
                        </td>
                        <td align="left" valign="middle">
                        
                        <input name="busca" type="submit" class="boton_bus" id="busca" value="Buscar" onclick="return buscar()"/>
                        <input type="hidden" name="usuario_nombre" id="usuario_nombre" value="<?php echo $_SESSION['usuario_nombre']; ?> " /></td>
                      </tr>
                      <tr>
                        <td colspan="2">&nbsp;</td>
                        <td width="192">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                    </table>
                    </fieldset>
                    
                    </td>
                  </tr>
                 
                  <tr>
                    <td height="123" align="center" valign="top">
                   
                    <fieldset class="txtnormalB">
                    <legend class="txtnormaln">Detalle Informes</legend>
                    <label></label>
                    <br>
                    
                    <table width="907" height="148" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="326" height="25" align="left" valign="bottom" class="txtnormal8">&nbsp;
                            <label>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CANT = 
                            <input name="cant" type="text" id="cant" size="2" />
                            </label>
                            <input type="button" class="boton_nue2" value="Insertar  linea" onclick="creando();" /></td>
                          <td width="581" align="left" valign="bottom" class="txt01">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="21" colspan="2" align="center"><table width="893" height="24" border="0" cellpadding="0" class="txtnormal8">
                              <tr bgcolor="#cedee1">
                                <td width="181">TRABAJADOR</td>
                                <td width="94">ESTADO</td>
                                <td width="192">MOTIVO</td>
                                <td width="89">ODS</td>
                                <td width="88">CC</td>
                                <td width="50">HRS</td>
                                <td width="50">HH 50</td>
                                <td width="51">HH 100</td>
                                <td width="47">TOTAL</td>
                                <td width="29" bgcolor="#F4F4F4" class="txtnormaln Estilo6">&nbsp;</td>
                              </tr>
                              
<?php 

if($_POST['busca'] == "Buscar" or $_POST['ingresa'] != "" or $_POST['modifica'] != "" or $_POST['elimina_item'] != "" or $_POST['combo3'] != "" or $_GET['cod'] != "")
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	if($_POST['busca'] == "Buscar" and $cont == 0){alert("  No se encontraron registros del dia y area seleccionada  ");}
	if($cont != 0)
	{
		$sql = "SELECT * FROM detalle_inf2, trabajadores WHERE detalle_inf2.cod_inf = '$cod' and detalle_inf2.rut_t = trabajadores.rut_t ORDER BY detalle_inf2.id_det";
		$resd=mysql_query($sql,$co);
		
		while($vrows2=mysql_fetch_array($resd)){
			$items[] = $vrows2;
		}
		
		echo"<input type='hidden' name='cod_inf' id='cod_inf' value='$cod' />"; // CAMPO QUE GUARDA Y ENVIA EL CODIGO DEL INFORME

		$f=0;
		$total_det = count($items);
		$filaexcel = 6;

		while($f < $total_det)
		{	
			$nom  		= $items[$f]['nom_t'];
			$app  		= $items[$f]['app_t'];
			$apm_t 		= $items[$f]['apm_t'];
			$rut  		= $items[$f]['rut_t'];
			$id_d  		= $items[$f]['id_det'];

			$resto_apm = substr ($apm_t, 0, 1); // devuelve inicial de apellido materno 
			
			$trab		= $nom." ".$app." ".$resto_apm.".";
			$estado_as	= $items[$f]['estado_as'];
			$mot		= $items[$f]['motivo'];
			$ods		= $items[$f]['ods'];
			$cc			= $items[$f]['cc'];
			$hrs		= $items[$f]['hrs'];
			$hh50		= $items[$f]['hh50'];
			$hh100		= $items[$f]['hh100'];
			$total		= $items[$f]['total'];
			
			$worksheet->write($filaexcel,0,utf8_decode($trab),$formato); 
			$worksheet->write($filaexcel,1,$rut,$formato);
			$worksheet->write($filaexcel,2,$est_dia,$formato);
			$worksheet->write($filaexcel,3,$mot,$formato);
			$worksheet->write($filaexcel,4,$ods,$formato);
			$worksheet->write($filaexcel,5,$cc,$formato);
			$worksheet->write($filaexcel,6,$hrs,$formato);
			$worksheet->write($filaexcel,7,$hh50,$formato);
			$worksheet->write($filaexcel,8,$hh100,$formato);
			$worksheet->write($filaexcel,9,$total,$formato);
			$filaexcel++;
			
			CreaFilaB($cod, $id_d, $rut, $trab, $estado_as, $mot, $ods, $cc, $hrs, $hh50, $hh75, $hh100, $total, $area_inf, $fe_inf);
			
		$f++;
		}
	}else{
		//echo"<script language='Javascript'>";
          	//alert('No Se Encontraron Registros de la fecha y area seleccionada');
			//echo"document.f10.submit();
        /*echo"</script>";*/
	}
}	
$workbook2->close();
/*********************************************************************************************************************************
								MODIFICAMOS LA ODS
*********************************************************************************************************************************/	
if($_POST['elimina'] == "Eliminar")
{
	/*$sqld="DELETE FROM contratos WHERE ods='".$_POST['t1']."' ";
	mysql_query($sqld,$co);*/
}
$_POST['f1']	=	cambiarFecha($_POST['f1'], '/', '-' ); 
?>
                              
                            </table>                            </td>
                        </tr>
                        <tr>
                          <td height="12" colspan="2" align="center">
                          
                          
                          <table width="891" border="0">
                            <tr>
                              <td width="885" height="21" align="left">
                              
                                  <div id="myDiv"></div>
                                  
                                  <div id="myLine" class="hide" title="Nombre Trabajador(170),Estado(88),Motivo(150),Nº ODS(80),CENTRO C(84),HRS N(53),50%(54),100%(56),x(56)">
                                    <div>                                    </div>
                                    <div>
                                      <select id="trabajadores" name="trabajadores[]" style="width: 170px" >
                            		<?php
 
										if($nom_t == "")
										{
											$trab = $trab;
										}else{
											$trab = $nom_t;
										}
										if($_POST['combo3']){$ar = $_POST['combo3']; }
										if($_POST['area']){$ar = $_POST['area']; }
										//*******************************************************************************************************
											$sql  = "SELECT * FROM trabajadores WHERE area_t = '$ar' ORDER BY nom_t ";
																		
											$rs_tb 		= dbConsulta($sql);
											$total_tb  	= count($rs_tb);
											echo"<option selected='selected' value='Seleccione...'>Seleccione...</option>";
																				
											for ($i = 0; $i < $total_tb; $i++)
											{
												$nom 		= $rs_tb[$i]['nom_t'];
												$app_t 		= $rs_tb[$i]['app_t'];
												$apm_t 		= $rs_tb[$i]['apm_t'];
												$fe_nulo 	= $rs_tb[$i]['fe_nulo'];
												$est_alta 	= $rs_tb[$i]['est_alta'];
													
												$resto_apm = substr ($apm_t, 0, 1); // Devuelve inicial de apellido materno 
												
												$resul = comparar_fechas($_POST['f1'], $fe_nulo);
												//alert($resul."  ".$app_t);
												//if($resul == "Menor" or $fe_nulo == "0000-00-00")
												if($est_alta == "Vigente")
												{	
													if($planta != $nom){
														echo "<option value='".$rs_tb[$i]['rut_t']."'>".$rs_tb[$i]['nom_t']." ".$rs_tb[$i]['app_t']." ".$resto_apm.".</option>";										
													}
												}
											}
										?>
                                      </select>
                                    </div>
                                    <div>
                                      <select id="estado[]" name="estado[]" style="width: 90px" onchange="validar(this)">
                                        <option value="Presente">Presente</option>
                                        <option value="Ausente">Ausente</option>
                                      </select>
                                    </div>
                                    <div>
                                      <select id="motivo" name="motivo[]" style="width: 190px" disabled="disabled" onchange="validar_motivo(this)" >
                                        <?php echo"<option selected='selected' value=''>-------- Seleccione --------</option>"; ?>
                                        <option value="Dia compensado">Dia compensado</option>
                                        <option value="Falla">Falla</option>
                                        <option value="Licencia">Licencia</option>
                                        <option value="Permiso a descuento">Permiso a descuento</option>
                                        <option value="Permiso administrativo">Permiso administrativo</option>
                                        <option value="Permiso con goze de sueldo">Permiso con goze de sueldo</option>
                                        <option value="Permiso Legal">Permiso Legal</option>
                                        <option value="Permiso sindical">Permiso sindical</option>
                                        <option value="Terreno">Terreno</option>
                                        <option value="Turno">Turno</option>
                                        <option value="Vacaciones">Vacaciones</option>
                                      </select>
                                    </div>
                                    <div>
                                      <input type="text" id="ods" name="ods[]" maxlength="11" style="width: 80px" />
                                    </div>
                                    <div>
                                      <input type="text" name="cc[]" maxlength="11" style="width: 80px" />
                                    </div>
                                    <div>
                                      <input type="text" name="hhn[]" maxlength="11" style="width: 40px" />
                                    </div>
                                    <div>
                                      <input type="text" name="hh50[]" maxlength="11" style="width: 40px" />
                                    </div>
                                    <div>
                                      <input type="text" name="hh100[]" maxlength="11" style="width: 40px" />
                                      <input type="hidden" name="aux[]" />
                                    </div>
                                    <div>
                                      <input type="text" name="total[]" maxlength="11" style="width: 30px" readonly="readonly"/>
                                    </div>
                                  </div>                                  </td>
                            </tr>
                          </table></td>
                        </tr>
                        
                        <tr>
                          <td height="22" colspan="2" align="center"><table width="655" border="1" bordercolor="#FFFFFF">
                              <tr>
                                <td width="754" height="37" align="center">
                                
                                <?php 
							  
							  if($_SESSION['usuario_pyc'] != "administrador"){
							  	$est = "disabled='disabled'";
							  }else{
							  $est = "";
							  }
							  
							  if($_POST['modifica'] == "Modificar" or $_POST['busca'] == "Buscar" and $cont != 0 ){
							  	$est_ing = "disabled='disabled'";
							  }else{
							  $est_ing = "";
							  }
							  	?>
                                <label>
                                  &nbsp;&nbsp;<input name="ingresa" type="submit" class="boton_ing" id="button3" value="Ingresar" onclick="return ingresar()" <?php echo $est_ing; ?>/>
                                  
                                  &nbsp; &nbsp;<input name="modifica" type="submit" class="boton_mod" id="button4" value="Modificar" onclick="return mod()" <?php echo $est; ?> />
								</label>
                                  &nbsp;&nbsp;
                                  <input name="Elimina" type="submit" class="boton_eli" id="button5" value="Eliminar" onclick="return eli()" <?php echo $est; ?> />
                                   &nbsp;&nbsp;<input name="limpia" type="submit" class="boton_lim" id="button6" value="Limpiar" onclick="limpiar()" />&nbsp;&nbsp;
								<?php

for ($i = 0; $i < $total_tb; $i++)
{
		$nom 		= 	$rs_tb[$i]['nom_t'];
		$app_t 		= 	$rs_tb[$i]['app_t'];
		$apm_t 		= 	$rs_tb[$i]['apm_t'];
		$rut 		= 	$rs_tb[$i]['rut_t'];
		$fe_nulo	= 	$rs_tb[$i]['fe_nulo'];
		$est_alta	= 	$rs_tb[$i]['est_alta'];
		
		$resto_apm 	= substr ($rs_tb[$i]['apm_t'], 0, 1); // devuelve inicial de apellido materno
		$nombre 	= $nom." ".$app_t." ".$resto_apm.".";
		
		$resul = comparar_fechas($_POST['f1'], $fe_nulo);
		
		if($resul == "Menor" or $fe_nulo == "0000-00-00")
		{	
			echo "<input type='hidden' name='val_trab[]' id='val_trab[]' value='$rut'/>
			<input type='hidden' name='nom_trab[]' id='nom_trab[]' value='$nombre'/>";	
		}
}

?></td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td height="23" colspan="2" align="center" class="txtnormal8"><?php if($env_por != ""){echo "INFORME INGRESADO POR: ".strtoupper($env_por);} ?></td>
                        </tr>
                    </table>
                    </fieldset>
                    
                    </td>
                  </tr>
                </table>
           </td>
          </tr>
        </table></td>
      </tr>
    </table>
     </form>
    </td>
  </tr>
  <tr>
    <td height="3" colspan="3" align="center" valign="top"><img src="imagenes/barra.gif" width="942" height="3" /></td>
  </tr>
</table>
</body>
</html>
