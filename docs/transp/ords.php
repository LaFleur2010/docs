<?
// Necesario para ver si la session esta activa  o si se tiene permiso de accseso
require("../lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php
//
//Definimos el nivel de acceso  (esto es un bonus track para definir que ciertos usuarios puedan entrar a algunas paginas y a otras no)
// Si los usuarios normales tienen acceso=10, para que  accedan todos los usuarios le damos acceso mayor a 10.
/*$nivel_acceso =10;
if ($nivel_acceso < $_SESSION['usuario_nivel']){
	header ("Location: ../index2.php?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}*/
//Hasta aquí lo comun para todas las paginas restringidas

/*****************************************************************************************************
	SE INCLUYEN ARCHIVOS DE CONFIGURACION Y FUNCIONES
*****************************************************************************************************/
	include('../inc/config_db.php'); 	// Incluimos archivo de configuracion de la conexion
	include('../inc/lib.db.php');		// Incluimos archivo de libreria de funciones PHP
/*****************************************************************************************************	
	
/*****************************************************************************************************
******************************************************************************************************
Nombre: 		FilaGasto();
Descripcion: 	Funcion para crear filas de gastos ingresados al mostrar registros
fecha:			22/04/2011
Creador:		Pedro Troncoso M.
Parametros:		(codigo del detalle, codigo del tipo de gasto, monto del gasto, fecha del gasto)
******************************************************************************************************
//***************************************************************************************************/
function FilaGasto($cod_tods, $id_det, $cod_gasto, $monto_gas, $fe_gas, $nom_gasto)
{
	$fe_gas		=	cambiarFecha($fe_gas, '-', '/' );
	if($fe_gas 	== "00/00/0000"){$fe_gas = "";}
	
	if($_SESSION['us_tipo'] == "Administrador")
	{
		$lectura = "";
	}else{
		$lectura = "readonly ='readonly'";
	}
	
	 echo"<tr border='0' bgcolor='#FFFFFF'>
       		<td>
           		<select id='tipo_gasto' name='tipo_gasto[]' style='width: 250px' class='combos' >";

                 	$sql  = 'SELECT * FROM tb_gastos ORDER BY nom_gasto';
                                                                                
                    $rs_tb 		= dbConsulta($sql);
                    $total_tb  	= count($rs_tb);
                    echo "<option selected='selected' value='$cod_gasto'>$nom_gasto</option>";
                                                                                        
                    for ($i = 0; $i < $total_tb; $i++)
                    {
                        echo "<option value='".$rs_tb[$i]['cod_gasto']."'>".$rs_tb[$i]['nom_gasto']."</option>";								
                    }
					
				echo "</select>";
            echo "</td>
            <td>
                &nbsp;<input name='monto_gas[]' type='text' class='cajas' style='width: 100px' value='$monto_gas'/>&nbsp; 
			</td>
			<td>
                <input name='fe_gas[]' type='text' class='cajas' style='width: 80px' value='$fe_gas'/> 
				<input name='id_det[]' type='hidden' value='$id_det' style='width: 20px'/>
            </td>

		<td align='center'>";
		$tabla = "tb_gasxodst";
		$dest  = "transp/ords.php";

		echo"<a href='../eliminar_item.php?id=$id_det&cod=$cod_tods&tabla=$tabla&dest=$dest' onclick='return confirmar(\"Esta Seguro de querer eliminar el registro seleccionado? \")'>
		<img src='../imagenes/remove.png' border='0' valign='top' alt='Eliminar' />";

		echo"</td>
		<td bgcolor='#F4F4F4'>&nbsp;</td>
		
		</tr> "; 
}	
/***************************************************************************************************
	SE CARGAN VARIABLES CON LOS VALORES QUE MOSTRAMOS POR DEFECTO EN LOS SELECT
***************************************************************************************************/
$nom_coord		= "------------------------------- Seleccione -------------------------------";
$nom_dest		= "------------------------------- Seleccione -------------------------------";
$tipo_veh_tods	= "------------------------------- Seleccione -------------------------------";
$pat_veh_tods	= "------------ Seleccione ------------";
/**************************************************************************************************/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Orden de servicio transportes</title>

<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="JavaScript" src="../inc/funciones.js"></script>

<!-- CALENDARIO -->
<LINK href="../inc/epoch_styles.css" type=text/css rel=stylesheet>
<SCRIPT src="../inc/epoch_classes.js" type=text/javascript></SCRIPT>

<!-- LIBRERIA JQUERY -->
<!-- esta vercion no sirve ya para mi servidor <script type="text/javascript" src="../autocomplete/jquery-1.2.1.pack.js"></script>-->
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>

<!-- VENTANA MODAL -->
<script type="text/javascript" src="../modal/js/ventana-modal-1.3.js"></script>
<script type="text/javascript" src="../modal/js/abrir-ventana-variable.js"></script>
<script type="text/javascript" src="../modal/js/abrir-ventana-fija.js"></script>
<script type="text/javascript" src="../modal/js/abrir-ventana-alertas.js"></script>
<link href="../modal/css/ventana-modal.css" rel="stylesheet" type="text/css">
<link href="../modal/css/style.css" rel="stylesheet" type="text/css">
<!-- FIN VENTANA MODAL -->

    <style type="text/css" media="all">

    .hide {
		font: bold 6px Verdana, Arial, Helvetica, serif;
        visibility: hidden;
        display: none;
    }

    </style>

<script language="JavaScript" type="text/javascript">

/**********************************************************************************************************************
***********************************************************************************************************************
AGREGAR LINEAS
PARAMETROS:

/**********************************************************************************************************************
***********************************************************************************************************************/
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
        newDiv.innerHTML += "<div class=\"cell\"><img style=\"cursor: pointer;\" src=\"../imagenes/remove.png\" border=\"0\" onclick=\"removeFormLine(\'" + mySelf + "\'); " + f + "\"></div>";

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
        var divParent  = document.getElementById(parentName);
        var divTarget  = document.getElementById(div);
        var hasTitle   = divParent.getAttribute('cab');
        divParent.removeChild(divTarget);
        if (divParent.childNodes.length == 0){
            divParent.innerHTML = "";
        }
    }
	
function creando()
{
	addFormLine('myDiv', 'myLine');
}

/**********************************************************************************************************************
***********************************************************************************************************************
CARGAR COMBO CLIENTES SIN RECARGAR LA PAGINA
PARAMETROS:
- Div donde esta el combo
- Div para mostrar el resultado
- Comando = campo hidden
- Nombre del combo ya actualizado
/**********************************************************************************************************************
***********************************************************************************************************************/
var comando;
var resultado;

function CargarDatos(valor) 
{
	 if (valor != 0) 
	 {
		comando 	= "accion=carga_datos&id=" + valor;
		resultado 	= "DivDatos";
		Ajax();
	 }
}

function CargarNombres()
{
	 comando 	= "accion=carga_nombres";
	 resultado 	= "DivNombres";
	 Ajax();
}

function Ajax() 
{
 	crearObjeto();
 	if (objeto.readyState != 0) 
	{
   		alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
 	}else {
   		if (!comando) {
 		// si no hay comando.. es porque se esta mandando llamar de la ventana emergente
     	comando = document.getElementById("ComandoRemoto").value;
   }
// indicar la funcion que procesa el resultado
   objeto.onreadystatechange = procesaResultado;
// enviar los datos - el "random" es porque se puede detectar que intentas leer los mismos datos; entonces, alenviarle
// un numero en random es como si pidieras los datos nuevos (no los que estan en memoria)
   objeto.open("GET", "combo_coord.php?" + comando + "&random=" + Math.random(), true);
// ni idea para que es esto (pero si no lo pones no funciona) tongue.gif
   objeto.send(null);
 }
}

function procesaResultado() 
{
	if (objeto.readyState == 1) 
	{
   		// cargando..
	}
	if (objeto.readyState == 4) 
	{
		// poner el resultado en "datos"
			datos = objeto.responseText;
		// poner el resultado en el Div que corresponde
		   	document.getElementById(resultado).innerHTML = datos;
		// limpiar las acciones
			comando = "";
			document.getElementById("ComandoRemoto").value = "";
	}
}
// inicio - conexion
var objeto = false;

function crearObjeto() {
 try { objeto = new ActiveXObject("Msxml2.XMLHTTP"); }
 catch (e) {
   try { objeto = new ActiveXObject("Microsoft.XMLHTTP"); }
   catch (E) { objeto = false; }
 }
 if (!objeto && typeof XMLHttpRequest!='undefined') {
   objeto = new XMLHttpRequest();
 }
}
// fin - conexion

<!-- hasta aqui termina el codigo de ajax-->
/**********************************************************************************************************************
**********************************************************************************************************************/

/**********************************************************************************************************************
***********************************************************************************************************************
CARGAR COMBO RESPONSABLE 	SIN RECARGAR LA PAGINA
PARAMETROS:
- Div donde esta el combo
- Div para mostrar el resultado
- Comando = campo hidden
- Nombre del combo ya actualizado
/**********************************************************************************************************************
***********************************************************************************************************************/
var comando4;
var resultado4;

function CargarDatos4(valor) 
{
	 if (valor != 0) 
	 {
		comando4 	= "accion=carga_datos&id=" + valor;
		resultado4 	= "DivDatos4";
		Ajax4();
	 }
}

function CargarNombres4()
{
	 comando4 	= "accion=carga_nombres4";
	 resultado4 = "DivNombres4";
	 Ajax4();
}

function Ajax4() 
{
 	crearObjeto();
 	if (objeto.readyState != 0) 
	{
   		alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
 	}else {
   		if (!comando4) {
 		// si no hay comando.. es porque se esta mandando llamar de la ventana emergente
     	comando4 = document.getElementById("ComandoRemoto4").value;
   }
// indicar la funcion que procesa el resultado
   objeto.onreadystatechange = procesaResultado4;
// enviar los datos - el "random" es porque se puede detectar que intentas leer los mismos datos; entonces, alenviarle
// un numero en random es como si pidieras los datos nuevos (no los que estan en memoria)
   objeto.open("GET", "combo_veh.php?" + comando4 + "&random=" + Math.random(), true);
// ni idea para que es esto (pero si no lo pones no funciona) tongue.gif
   objeto.send(null);
 }
}

function procesaResultado4() 
{
	if (objeto.readyState == 1) 
	{
   		// cargando..
	}
	if (objeto.readyState == 4) 
	{
		// poner el resultado en "datos"
			datos = objeto.responseText;
		// poner el resultado en el Div que corresponde
		   	document.getElementById(resultado4).innerHTML = datos;
		// limpiar las acciones
			comando4 = "";
			document.getElementById("ComandoRemoto4").value = "";
	}
}
// inicio - conexion
var objeto = false;

function crearObjeto() {
 try { objeto = new ActiveXObject("Msxml2.XMLHTTP"); }
 catch (e) {
   try { objeto = new ActiveXObject("Microsoft.XMLHTTP"); }
   catch (E) { objeto = false; }
 }
 if (!objeto && typeof XMLHttpRequest!='undefined') {
   objeto = new XMLHttpRequest();
 }
}
// fin - conexion

<!-- hasta aqui termina el codigo de ajax-->
/**********************************************************************************************************************
**********************************************************************************************************************/

/**********************************************************************************************************************
***********************************************************************************************************************
CARGAR COMBO EMPRESA SIN RECARGAR LA PAGINA
PARAMETROS:
- Div donde esta el combo
- Div para mostrar el resultado
- Comando = campo hidden
- Nombre del combo ya actualizado
/**********************************************************************************************************************
***********************************************************************************************************************/
var comando3;
var resultado3;

function CargarDatos3(valor) 
{
	 if (valor != 0) 
	 {
		comando3 	= "accion=carga_datos&id=" + valor;
		resultado3 	= "DivDatos3";
		Ajax3();
	 }
}

function CargarNombres3()
{
	 comando3 	= "accion=carga_nombres3";
	 resultado3 = "DivNombres3";
	 Ajax3();
}

function Ajax3() 
{
 	crearObjeto();
 	if (objeto.readyState != 0) 
	{
   		alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
 	}else {
   		if (!comando3) {
 		// si no hay comando.. es porque se esta mandando llamar de la ventana emergente
     	comando3 = document.getElementById("ComandoRemoto3").value;
   }
// indicar la funcion que procesa el resultado
   objeto.onreadystatechange = procesaResultado3;
// enviar los datos - el "random" es porque se puede detectar que intentas leer los mismos datos; entonces, alenviarle
// un numero en random es como si pidieras los datos nuevos (no los que estan en memoria)
   objeto.open("GET", "combo_dest.php?" + comando3 + "&random=" + Math.random(), true);
// ni idea para que es esto (pero si no lo pones no funciona) tongue.gif
   objeto.send(null);
 }
}

function procesaResultado3() 
{
	if (objeto.readyState == 1) 
	{
   		// cargando..
	}
	if (objeto.readyState == 4) 
	{
		// poner el resultado en "datos"
			datos = objeto.responseText;
		// poner el resultado en el Div que corresponde
		   	document.getElementById(resultado3).innerHTML = datos;
		// limpiar las acciones
			comando3 = "";
			document.getElementById("ComandoRemoto3").value = "";
	}
}
// inicio - conexion
var objeto = false;

function crearObjeto() {
 try { objeto = new ActiveXObject("Msxml2.XMLHTTP"); }
 catch (e) {
   try { objeto = new ActiveXObject("Microsoft.XMLHTTP"); }
   catch (E) { objeto = false; }
 }
 if (!objeto && typeof XMLHttpRequest!='undefined') {
   objeto = new XMLHttpRequest();
 }
}
// fin - conexion

<!-- hasta aqui termina el codigo de ajax-->
/**********************************************************************************************************************
**********************************************************************************************************************/
/*****************************************************************************************************************
NOMBRE: 		
DESCRIPCION:	FUNCION PARA MOSTRAR EL CALENDARIO
PARAMETROS:		NO
AUTOR: 			SAN google	MODIFICADA Y ADAPTADA POR. PEDRO TRONCOSO
FECHA: 			2008
******************************************************************************************************************/
var dp_cal;
window.onload = function () {
	stime = new Date();

	dp_cal 	  = new Epoch('dp_cal','popup',document.getElementById('date_field'));
};
/*******************************************************************************************************************
										FUNCIONES CONFIRM
********************************************************************************************************************/
function confirmar(msj, dest, boton)
{
	var apr_p		= document.f.aprobado_produccion.value;
	var apr_g		= document.f.aprobado_gerencia.value;
	var usuario		= document.f.usuario_nombre.value;
	var us_ing		= document.f.ingresada_por.value;
	var tipo_us_sol	= document.f.usuario_sol_rec.value;
	
	if((apr_g == "" && apr_p == "") || (tipo_us_sol == "Bodega" && apr_g != ""))
	{
		if((usuario == us_ing || tipo_us_sol == "Produccion" || tipo_us_sol == "Operaciones") || (tipo_us_sol == "Bodega" && apr_g != ""))
		{
			if(boton != "Eliminar" )
			{
				var agree=confirm(msj);
				if (agree){
					document.f.action=dest; 
					document.f.submit();
				return true ;
				}else{
					return false ;
				}
			}else{
				error('No se puede eliminar la solicitud', '¡Error!');
				return false ;
			}
		}else{
			error('No tiene permisos para modificar la solicitud', '¡Error!');
		}
	}else{
		error('La solicitud ya se encuentra aprobada', '¡Error!');
		return false;
	}
}

function rep()
{
	var cs = document.f.cod_tods.value;
	
	if(cs != "")
	{
		abrirVentanaM("Rep_OdsTran.php?vods="+cs,"yes");
		
	}else{
		alerta('Error: Debe Ingresar Nº de Orden', '¡Atención!');
		document.f.cod_tods.value="";
		document.f.cod_tods.focus();
		return false;
	}
}

/*****************************************************************************************************************
NOMBRE: 		cuenta_caracteres(campo) 
DESCRIPCION:	CUENTA EL NUMERO DE CARACTERES INGRESADOS EN UN CAMPO
AUTOR: 			PEDRO TRONCOSO	
FECHA: 			08/10/2010
******************************************************************************************************************/
function cuenta_caracteres(campo) 
{
	var desc_sol 	= document.getElementsByName("desc_sol[]");
	var total    	= desc_sol.length -1;
	var numero		= campo.length;

	if(numero > 120) {
		
		alert("Ha completado el maximo de caracteres permitidos: 120");
	}

}
/*****************************************************************************************************************
NOMBRE: 		ingresar(msj, dest);
DESCRIPCION:	FUNCION PARA VALIDAR EL INGRESO DE LA SOLICITUD DE RECURSOS (QUE LOS XCAMPOS NO ESTEN EN BLANCO)
AUTOR: 			PEDRO TRONCOSO	
FECHA: 			25/06/2010
******************************************************************************************************************/
function ingresar(msj, dest)
{
	var fe_tods 		= document.f.f1.value;
	//var cond_tods  		= document.f.cond_tods.value;
	var coord_tods  	= document.f.c1.value;
	var cc_tods  		= document.f.cc_tods.value;
	var dest_tods  		= document.f.c3.value;
	var tipo_veh_tods	= document.f.c4.value;
	//var c5  			= document.f.c5.value;
	//var kmini_tods  	= document.f.kmini_tods.value;
	//var kmlleg_tods  	= document.f.kmlleg_tods.value;
	var carg_tods  		= document.f.carg_tods.value;
	//var obs_tods  		= document.f.obs_tods.value;
	var hrsal_tods  	= document.f.hrsal_tods.value;
	//var hrlleg_tods  	= document.f.hrlleg_tods.value;
	//var tothrs_tods  	= document.f.tothrs_tods.value;
	//var doc_tods  		= document.f.doc_tods.value;
	
	if(fe_tods != "" )
	{
		if(coord_tods != "" && coord_tods != "------------------------------- Seleccione -------------------------------")
		{	
			if(cc_tods != "" )
			{
				if(dest_tods != "" && dest_tods != "------------------------------- Seleccione -------------------------------" )
				{
					if(carg_tods != "")
					{	
						if(tipo_veh_tods != "" && tipo_veh_tods != "------------------------------- Seleccione -------------------------------" )
						{
							if(hrsal_tods != "" )
							{
								var agree=confirm(msj);
								if (agree){
									document.f.action=dest; 
									document.f.submit();
								return true ;
								}else{
									return false ;
								}
							}else{
								alerta('Error: Debe ingresar hora de salida', '¡Atención!');
								return false ;
								document.f.hrsal_tods.focus();
								
							}
						}else{
							alerta('Error: Debe ingresar tipo de vehiculo', '¡Atención!');
							document.f.c4.focus();	
							return false ;
						}
					}else{
						alerta('Error: Debe ingresar materiales o carga a transportar', '¡Atención!');
						document.f.carg_tods.focus();
						return false ;
					}
				}else{
					alerta('Error: Debe ingresar destino', '¡Atención!');
					document.f.c3.focus();
					return false ;
				}
			}else{
				alerta('Error: Debe indicar cc', '¡Atención!');
				document.f.cc_tods.focus();
				return false;
			}
		}else{
			alerta('Error: Debe ingresar coordinador', '¡Atención!');
			document.f.c1.focus();
			return false ;
		}
	}else{
			alerta('Error: Debe Seleccionar Fecha', '¡Atención!');
			document.f.f1.focus();
			return false ;
	}
	
}//fin Ingresar
/*****************************************************************************************************************
			*****	FIN DE FUNCION PARA VALIDAR EL INGRESO DE LA SOLICITUD	*****
******************************************************************************************************************/

function recargar()
{
	document.f.submit();
}
function enviar(url)
{
	document.f.action=url;
}

function Abrir_nueva_vantana(URL)
{
	abrirVentanaM(URL,"yes");
}


function validar_enter_cod(e) 
{
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13)
  {
  	document.f.busca.focus();
	document.f.submit();
  }
}

function buscar()
{
	abrirVentanac('buscar_fsr.php', '700', '500','yes');	
}

// CARGA LA CONSULTA DEL CRITERIO DE BUSQUEDA
function carga_consulta_busca()
{
	cons=document.f.consulta.value;
	document.f.action='lista_fsr.php?consulta='+cons;
	document.f.submit();
	VentanaModal.cerrar();
}

$(document).ready(function(){
	$("select").change(function(){
		// Vector para saber cuál es el siguiente combo a llenar

		var combos = new Array();
		combos['c4'] = "c5";
		combos['c5'] = "combo3";
		// Tomo el nombre del combo al que se le a dado el clic por ejemplo: país
		posicion = $(this).attr("name");
		// Tomo el valor de la opción seleccionada 
		valor = $(this).val()		
		// Evaluó  que si es tipo y el valor es 0, vacié los combos de productos y "?"
		if(posicion == 'c4' && valor==0){
			$("#c5").html('	<option value="0" selected="selected">----------------</option>')
			$("#combo3").html('	<option value="0" selected="selected">----------------</option>')
		}else{
		/* En caso contrario agregado el letreo de cargando a el combo siguiente
	Ejemplo: Si seleccione país voy a tener que el siguiente según mi vector combos es: estado  por qué  combos [tipo] = producto
			*/
			$("#"+combos[posicion]).html('<option selected="selected" value="0">Cargando...</option>')
			/* Verificamos si el valor seleccionado es diferente de 0 y si el combo es diferente de ciudad, esto porque no tendría caso hacer la consulta a ciudad porque no existe un combo dependiente de este */
			if(valor!="0" || posicion !='combo3'){
			// Llamamos a pagina de combos.php donde ejecuto las consultas para llenar los combos
				$.post("combos2.php",{
									combo:$(this).attr("name"), // Nombre del combo
									id:$(this).val() // Valor seleccionado
									},function(data){
													$("#"+combos[posicion]).html(data);	//Tomo el resultado de pagina e inserto los datos en el combo indicado																				
													})												
			}
		}
	})		
})
</script>

<style type="text/css">
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
        padding: 5px;
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
body {
	font-family: Helvetica;
	font-size: 11px;
	color: #000;
}
<!--
body {
	background-color: #527eab;
}
.Estilo8 {color: #FF0000}
.Estilo9 {color: #000000}
-->
</style>
</head>

<body>		  
<?php
/***********************************************************************************************************
								BUSCAMOS LA SOLICITUD DEPENDIENDO DEL FILTRO
************************************************************************************************************/
if($_POST['busca'] == "Buscar") // SI SE PRESIONO EL BOTON Buscar
{	
	$query = "SELECT * FROM tb_tranods WHERE cod_tods = '".$_POST['cod_tods']."' ";
}
if($_POST['ingresa'] != "")		// SI SE PRESIONO EL BOTON "Ingresa"
{
	$query = "SELECT * FROM tb_tranods WHERE cod_tods = '".$_POST['ingresa']."' ";
}
if($_POST['modifica'] != "")
{
	$query = "SELECT * FROM tb_tranods WHERE cod_tods='".$_POST['modifica']."' ";
}
if($_GET['cod'] != "")
{
	$query = "SELECT * FROM tb_tranods WHERE cod_tods='".$_GET['cod']."' ";
}

if($_POST['elimina_item'] != "")
{
	$query = "SELECT * FROM tb_tranods WHERE cod_tods='".$_POST['elimina_item']."' ";
}


if($_POST['busca'] == "Buscar" or $_POST['ingresa'] != "" or $_POST['modifica'] != "" or $_POST['elimina_item'] != "" or $_GET['cod'] != "" )
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sqlc	= $query;
	
	$res	= mysql_query($sqlc,$co);
	$cont 	= mysql_num_rows($res);
	
	if($cont != 0)
	{
		while($vrows=mysql_fetch_array($res))
		{
			$emp 			= "".$vrows['empr_sol']."";	
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
			$doc_tods 		= "".$vrows['doc_tods']."";
			$obs_tods 		= "".$vrows['obs_tods']."";
			$ing_por 		= "".$vrows['ing_por']."";
			$estado         = "".$vrows['estado']."";
		}	
		
		$SqlGas = "SELECT * FROM tb_gasxodst, tb_gastos WHERE tb_gasxodst.cod_tods = '$cod_tods' and tb_gasxodst.cod_gas = tb_gastos.cod_gasto ORDER BY tb_gastos.nom_gasto";
		$ResGas = dbExecute($SqlGas);
		while ($VrsGas = mysql_fetch_array($ResGas)) 
		{
			$GastosxOds[] = $VrsGas;
		}
			
		//$tothrs_tods = ($hrlleg_tods - $hrsal_tods);
		function resta($inicio, $fin)
		{
		  	$dif=date("H:i:s", strtotime("00:00:00") + strtotime($fin) - strtotime($inicio) );
		  	return $dif;
		 }
			
		if($hrlleg_tods != "00:00:00"){
			$tothrs_tods = resta($hrsal_tods, $hrlleg_tods);
		}
		$kmrec_tods  = ($kmlleg_tods - $kmini_tods);
			

		$sql_coord = "SELECT * FROM tb_coordinador WHERE cod_coord = '$coord_tods' ";
		$res_coord = mysql_query($sql_coord,$co);
		while($vrowscoord=mysql_fetch_array($res_coord))
		{
			$nom_coord = "".$vrowscoord['nom_coord']."";
			$cod_coord = "".$vrowscoord['cod_coord']."";
		}
		$sql_dest = "SELECT * FROM tb_destino WHERE cod_dest = '$dest_tods' ";
		$res_dest = mysql_query($sql_dest ,$co);
		while($vrowsdest = mysql_fetch_array($res_dest))
		{
			$nom_dest  = "".$vrowsdest['nom_dest']."";
			$cod_dest  = "".$vrowsdest['cod_dest']."";
		}
		$sql_veh = "SELECT * FROM tb_vehiculos WHERE cod_veh  = '$veh_tods' ";
		$res_veh = mysql_query($sql_veh ,$co);
		while($vrowsveh = mysql_fetch_array($res_veh))
		{
			$nom_veh  = "".$vrowsveh['nom_veh']."";
			$cod_veh  = "".$vrowsveh['cod_veh']."";
		}
	}
}
/******************************************************************************************
	FORMATEAMOS LAS FECHAS
******************************************************************************************/
$fe_tods		=	cambiarFecha($fe_tods, '-', '/' ); 

if($fe_tods 	== "00/00/0000"){$fe_tods = "";}

?>

<table width="1010" height="367" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
  <tr bgcolor="#FFFFFF">
    <td width="100" height="54" align="center" valign="top"><a href="../index2.php"><img src="../imagenes/logo2.jpg" width="100" height="60" border="0" /></a></td>
    <td width="810" align="center" valign="middle" class="txt01">ORDEN DE SERVICIO</td>
    <td width="100" align="right" valign="top"><img src="../imagenes/logo_iso_c.jpg" width="100" height="52" /></td>
  </tr>
  
  <tr>
    <td height="309" colspan="3" align="center" valign="top">
    <form action="ords.php" method="post" name="f" id="f">
    <table width="1008" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1003" align="center"><table width="1006" height="45" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#CEDEE1">
          <tr>
            <td width="970" align="right"><table width="990" height="67" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="98" height="67" align="right"><input name="button8" type="submit" class="boton_inicio" id="button8" value="Inicio" onclick="enviar('../index2.php')" /></td>
                  <td width="93" align="center"><label></label></td>
                  <td width="223" align="center"><label></label></td>
                  <td width="83" align="right">&nbsp;</td>
                  <td width="88" align="right"><label></label></td>
                  <td width="100" align="right"><input name="Volver4" type="submit" class="boton_actualizar" id="Volver4" value="Actualizar" /></td>
                  <td width="84" align="center"><input name="aprueba2" type="button" class="boton_buscar_fsr" id="aprueba2" value="Buscar Orden" onclick="abrirVentanaFijaSr('buscar_ods.php', 724, 400, 'ventana', 'Buscar solicitud')"/></td>
                  <td width="100" align="center"><input name="button" type="submit" class="boton_lista2" id="button" value="Listado de ODS" onclick="enviar('listado.php')" /></td>
                  <td width="94" align="right"><input name="button4" type="button" class="boton_print" id="button2" value="Vista impresion" onclick="rep()" /></td>
                  <td width="27" align="right">
                  <input type="hidden" name="usuario_nombre" id="usuario_nombre" value="<?php echo $_SESSION['usuario_nombre']; ?>" /></td>
                </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center"><table width="1006" height="230" border="0">
          <tr>
            <td width="992" height="224" align="center" valign="top">
                <table width="992" height="220" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="992" height="39" align="center" valign="top">
                    
                    <fieldset class="txtnormalB">
                    <legend class="txtnormaln">ORDEN DE SERVICIO</legend>
                    <table width="983" border="0" cellspacing="1" cellpadding="1">
                      <tr>
                        <td colspan="8" align="center"><font color="#FF0000">(*) Datos Obligatorios</font></td>
                      </tr>
                      <tr>
                        <td height="34" align="left" valign="top">Nº DE ORDEN (automatico)                          </td>
                        <td width="166" height="34" align="left" valign="middle"><?php 
						if($_POST['limpia'] == "Limpiar"){$cod_tods = "";} ?>
                          <input name="cod_tods" type="text" id="cod_tods" size="6" style="width:60px;height:17px;" value="<? echo $cod_tods ?>" onkeypress="validar_enter_cod(event)" />
                          <input name="busca" type="submit" class="boton_bus" id="busca" value="Buscar"/></td>
                        <td width="59" align="left" valign="middle">FECHA <font color="#FF0000">(*)</font></td>
                        <td width="127" align="left" valign="middle"><span class="content Estilo8">
                          <input id="date_field" style="WIDTH: 7em" name="f1" value="<? echo $fe_tods; ?>" />
                          <input type="button" class="botoncal" onclick="dp_cal.toggle();" />
                        </span>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="left">Empresa</td>
                        <td align="left">
                        <select name="empr_sol">
                        <? echo"<option selected='selected' value='$emp'>$emp</option>";?>
                        	<option value="Softtime">Softtime</option>
                        	<option value="Rockmine">Rockmine</option>
                        	<option value="MGYT">MGYT</option>
                        </select>
                    	</td>
                        <td colspan="3" align="left">&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="155" height="13" align="left">Estado</td>
                        <td colspan="3" align="left"><span class="Estilo9">
                          <select name="estado" id="estado" style="width:150px;">
                            <? echo"<option selected='selected' value='$estado'>$estado</option>";?>
                            <option value="En Espera">En Espera</option>
                            <option value="Realizada">Realizada</option>
                            <option value="Nula">Nula</option>
                          </select>
                        </span></td>
                        <td rowspan="2" align="left">&nbsp;</td>
                        <td rowspan="2" align="left">&nbsp;</td>
                        <td rowspan="2" align="left">Hora de salida <font color="#FF0000">(*)</font></td>
                        <td rowspan="2" align="left"><span class="content Estilo8">
                          <input name="hrsal_tods" type="text" id="hrsal_tods" value="<?php echo $hrsal_tods; ?>" size="12"/>
                        Ejemplo: 09:30</span></td>
                      </tr>
                      <tr>
                        <td width="155" height="14" align="left"><span class="Estilo9">Conductor<font color="#FF0000"></font></span></td>
                        <td colspan="3" align="left"><span class="txtnormaln">
                          <input name="cond_tods" type="text" style="width:345px;" value="<?php echo $cond_tods;?>" />
                        </span></td>
                      </tr>
                      <tr>
                        <td align="left"><span class="Estilo9">Cordinador<font color="#FF0000"> (*)</font></span></td>
                        <td colspan="3" align="left">
                          <div id="DivNombres">
                              <select name="c1" id="c1" style="width:350px;" onchange="CargarDatos(this.value)">
                                <?php
									$co=mysql_connect("$DNS","$USR","$PASS");
								
									$sql_coo  	= "SELECT * FROM tb_coordinador ORDER BY nom_coord";
									$rs_coo 	= dbConsulta($sql_coo);
									$total_coo  = count($rs_coo);
									echo"<option selected='selected' value='$nom_coord'>$nom_coord</option>";
											
									for ($i = 0; $i < $total_coo; $i++)
									{
										$nom = $rs_coo[$i]['nom_coord'];
										if($nom_coord != $nom){
											echo "<option value='".$rs_coo[$i]['cod_coord']."'>".$rs_coo[$i]['nom_coord']."</option>";
										}
									}
							?>
                              </select>
                         </div>                          
                         <div id="resultado"></div>                         </td>
                        <td width="46" align="left"><span class="Estilo9">
                          <input name="clientes" type="button" class="otro" id="agregar" value="? " onclick="abrirVentanac('coordinador.php','470','500','yes','yes');"/>
                          <input type="hidden" name="ComandoRemoto" id="ComandoRemoto" />
                        </span> </td>
                        <td width="83" align="left">&nbsp;</td>
                        <td width="88" align="left">Hora de llegada:</td>
                        <td width="234" align="left"><span class="content Estilo8">
                          <input name="hrlleg_tods" type="text" id="hrlleg_tods" value="<?php echo $hrlleg_tods; ?>" size="12"/>
                        Ejemplo: 20:15</span></td>
                      </tr>
                      <tr>
                        <td align="left">Centro costo <font color="#FF0000">(*)</font></td>
                        <td colspan="3" align="left"><span class="content Estilo8">
                          <input name="cc_tods" type="text" id="cc_tods" value="<?php echo $cc_tods; ?>" size="12"/>
                        </span></td>
                        <td align="left">&nbsp;</td>
                        <td align="left">&nbsp;</td>
                        <td align="left">Total de horas:</td>
                        <td align="left"><span class="content Estilo8">
                          <input name="tothrs_tods" type="text" id="tothrs_tods" value="<?php echo $tothrs_tods; ?>" size="12" readonly="readonly" style="background-color: #cedee1;"/>
                        Campo de solo lectura</span></td>
                      </tr>
                      <tr>
                        <td align="left"><span class="Estilo9">Destino <font color="#FF0000">(*)</font></span></td>
                        <td colspan="3" align="left">
                        
                        <div id="DivNombres3">
                              <select name="c3" id="c3" style="width:350px;" onchange="CargarDatos(this.value)">
                                <?php
									$co=mysql_connect("$DNS","$USR","$PASS");
								
									$sql_dest  	= "SELECT * FROM tb_destino ORDER BY nom_dest";
									$rs_dest  	= dbConsulta($sql_dest);
									$total_dest = count($rs_dest);
									echo"<option selected='selected' value='$nom_dest'>$nom_dest</option>";
											
									for ($i = 0; $i < $total_dest; $i++)
									{
										$nom_d 		= $rs_dest[$i]['nom_dest'];
										if($nom_d  != $nom_dest){
											echo "<option value='".$rs_dest[$i]['cod_dest']."'>".$rs_dest[$i]['nom_dest']."</option>";
										}
									}
							?>
                              </select>
                         </div>                          
                         <div id="resultado3"></div>                         </td>
                        <td align="left"><span class="Estilo9">
                          <input name="agregar3" type="button" class="otro" id="agregar3" value="? " onclick="abrirVentanac('destino.php','470','500','yes','yes');"/>
                          <input type="hidden" name="ComandoRemoto3" id="ComandoRemoto3" />
                        </span></td>
                        <td align="left">&nbsp;</td>
                        <td align="left"><span class="Estilo9">Km Inicio<font color="#FF0000"></font></span></td>
                        <td align="left"><span class="content Estilo8">
                          <input name="kmini_tods" type="text" id="kmini_tods" value="<?php echo $kmini_tods; ?>" size="12"/>
                        </span></td>
                      </tr>
                      <tr>
                        <td align="left"><span class="Estilo9">Vehiculo Tipo <font color="#FF0000">(*)</font></span></td>
                        <td colspan="3" align="left">
                        
                        <div id="DivNombres4">
                          <select name="c4" id="c4" style="width:350px;" onchange="CargarDatos(this.value)">
                            <?php
									$co=mysql_connect("$DNS","$USR","$PASS");
								
									$sql_c  	= "SELECT DISTINCT tipo_veh FROM tb_vehiculos ORDER BY tipo_veh";
									$rs_c 		= dbConsulta($sql_c);
									$total_c  	= count($rs_c);
									echo"<option selected='selected' value='$tipo_veh_tods'>$tipo_veh_tods</option>";
											
									for ($i = 0; $i < $total_c; $i++)
									{
										$nom = $rs_c[$i]['tipo_veh'];
										if($tipo_veh != $nom){
											echo "<option value='".$rs_c[$i]['tipo_veh']."'>".$rs_c[$i]['tipo_veh']."</option>";
										}
									}
							?>
                          </select>
                        </div>   
                                               
                        <div id="resultado4"></div>                        </td>
                        <td align="left"><span class="Estilo9">
                          <input name="agregar4" type="button" class="otro" id="agregar4" value="? " onclick="abrirVentanac('vehiculos.php','470','500','yes','yes');"/>
                          <input type="hidden" name="ComandoRemoto4" id="ComandoRemoto4" />
                        </span></td>
                        <td align="left">&nbsp;</td>
                        <td align="left">Km Llegada</td>
                        <td align="left"><span class="content Estilo8">
                          <input name="kmlleg_tods" type="text" id="kmlleg_tods" value="<?php echo $kmlleg_tods; ?>" size="12"/>
                        </span></td>
                      </tr>
                      <tr>
                        <td align="left">Vehiculo Patente</td>

                        <td colspan="3" align="left">
                        
                        <select id="c5" name="c5" style="width:200px;">
                        
                         <?php echo"<option selected='selected' value='$pat_veh_tods'>$pat_veh_tods</option>"; ?>
                        </select>                        </td>
                        <td align="left">&nbsp;</td>
                        <td align="left">&nbsp;</td>
                        <td align="left">Kms Recorridos</td>
                        <td align="left"><span class="content Estilo8">
                          <input name="kmrec_tods" type="text" id="kmrec_tods" value="<?php echo $kmrec_tods; ?>" size="12" readonly="readonly" style="background-color: #cedee1;"/>
                        Campo de solo lectura</span></td>
                      </tr>
                      <tr>
                        <td align="left"><span class="Estilo9">Carga o materiales <font color="#FF0000">(*)</font></span></td>
                        <td colspan="7" align="left"><span class="content Estilo8">
                          <textarea name="carg_tods" id="carg_tods" style="width:690px;"><?php echo $carg_tods; ?></textarea>
                        </span></td>
                        </tr>
                      <tr>
                        <td align="left"><span class="Estilo9">Observaciones</span></td>
                        <td colspan="7" align="left"><textarea name="obs_tods" rows="6" value="" id="obs_tods" style="width:690px;"><?php echo $obs_tods;?></textarea></td>
                        </tr>
                      <tr>
                        <td align="left">&nbsp;</td>
                        <td colspan="7" align="left">&nbsp;</td>
                      </tr>
                    </table>
                    
                    </fieldset>
                    
                    <fieldset class="txtnormalB">
                    <legend class="txtnormaln">DETALLE DE GASTOS</legend>
                    
                    <table width="983" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
                      <tr>
                        <td width="952" height="86" align="center">
                              
                              <table width="954" border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td height="23" align="left" valign="middle"><label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                      <input type="button" class="boton_nue2" value=" Agregar Linea" onclick="creando();" />
                                      <!-- <a href="javascript:creando(); ">Agregar Linea +</a>-->
                                      <br/>
                                      <!-- <div id='basic-modal'><input type='button' name='basic' value='Subir documentos' class='basic demo' onclick="val_sub()"/></div>--></td>
                                    </tr>
                                  <tr>
                                    <td height="19" align="center" valign="bottom"><div id="recargado">
                                        <table width="921" border="0" cellpadding="1"  cellspacing="0" bgcolor="#cedee1" bordercolor="#FFFFFF">
                                          <tr>
                                            <td width="250" height="19">&nbsp;&nbsp;&nbsp;&nbsp;TIPO DE GASTO</td>
                                            <td width="114">&nbsp;MONTO</td>
                                            <td width="92">&nbsp;FECHA</td>
                                            <td width="31">&nbsp;</td>
                                            <td bgcolor="#F4F4F4" border="0">&nbsp;</td>
                                            </tr>
<?php
	$i				= 0; // Inicializamos una variable para el while
	$Contador_gasto	= count($GastosxOds); // Contador de gastos encontrados por la ods

/*************************************************************************************
			COMENZAMOS EL WHILE DE GASTOS X ODS
*************************************************************************************/
	while($i < $Contador_gasto)
	{
		$id_det 		= $GastosxOds[$i]['id_det'];
		$cod_tods 		= $GastosxOds[$i]['cod_tods'];
		$cod_gas 		= $GastosxOds[$i]['cod_gas'];
		$monto_gas 		= $GastosxOds[$i]['monto_gas'];
		$fe_gas 		= $GastosxOds[$i]['fe_gas'];
		$nom_gasto 		= $GastosxOds[$i]['nom_gasto'];
		$cod_gasto 		= $GastosxOds[$i]['cod_gasto'];
		
		$total_gastos   = ($total_gastos + $monto_gas); // Calculamos el total de los gastos de la ODS
		
		FilaGasto($cod_tods, $id_det, $cod_gasto, $monto_gas, $fe_gas, $nom_gasto); // Mostramos una fila por cada registro encontrado
		
		// Fila para mostrar el total de los gastos por la ODS
		if($i == ($Contador_gasto - 1))
		{ 
			echo "<tr class='txtnormaln' height='19'><td>TOTAL GASTOS</td><td align='left'>&nbsp;$";echo number_format($total_gastos, 0, ",", "."); echo"</td><td>&nbsp;</td><td>&nbsp;</td><td bgcolor='#F4F4F4'></td></tr>";
		}
		$i++;
	}
?>
                                        </table>
                                    </div></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2">
                                    
                                    <div id="myDiv"></div> <!-- DIV DONDE SE MOSTRARAN LOS ITEMS DE GASTOS -->
                                    
                                    <div id="myLine" class="hide">
                                          <div> &nbsp;&nbsp;&nbsp;&nbsp;
                                          <select id="tipo_gasto" name="tipo_gasto[]" style="width: 250px; " class="combos" >
											<?php
                                                /************************************************************
													SELECT QUE MUESTRA LOS REGISTROS DESDE LA TABLA GASTOS
												*************************************************************/
                                                    $sql  = "SELECT * FROM tb_gastos ORDER BY nom_gasto ";
                                                                                
                                                    $rs_tb 		= dbConsulta($sql);
                                                    $total_tb  	= count($rs_tb);
                                                    echo"<option selected='selected' value='Seleccione...'>Seleccione...</option>";
                                                                                        
                                                    for ($i = 0; $i < $total_tb; $i++)
                                                    {
                                                  		echo "<option value='".$rs_tb[$i]['cod_gasto']."'>".$rs_tb[$i]['nom_gasto']."</option>";										
                                                    }
                                                ?>
                                              </select> 
                                          </div>
                                          <div>
                                            <input name="monto_gas[]" type="text" class="cajas" style="width: 100px" />
                                          </div>                                          
                                          <div>
                                            <input name="fe_gas[]" type="text" class="cajas" style="width: 80px"/>
                                            &nbsp; 
                                          </div>
                                          
                                        </div>
                                        </td>
                                  </tr>
                                  <tr>
                                    <td height="15" align="center"><label for="textfield"></label></td>
                                  </tr>
                              </table>
                        </td>
                      </tr>
                    </table>
                    </fieldset>
                    <br />
                    
                    </td>
                  </tr>
                 
                  <tr>
                    <td height="22" align="center" valign="top"><table width="890" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="817" height="17" align="center">
						<?php 
							  	if($_GET['cod'] != "" or $_POST['modifica'] == "Modificar" or $_POST['busca'] == "Buscar" and $cont != 0)
								{
							  		$est_ing = "disabled='disabled'";
							  	}else{
							  		$est_ing = "";
							  	}
								if($_SESSION['usuario_rut'] == "16223134-0" or $_SESSION['usuario_rut'] == "17507428-7" or $_SESSION['usuario_rut'] == "13503321-9")
								{
									$est_ing = "";
								}
						?>
                            <label> &nbsp;&nbsp;
                            <input name="ingresa" type="submit" class="boton_ing" id="button3" value="Ingresar" onclick="return ingresar('Esta seguro que desea ingresar la ODS?', 'ords_p.php')" <?php echo $est_ing; ?>/>
                              </label>
                          &nbsp;&nbsp;
                          <input name="modifica" type="submit" class="boton_mod" id="button4" value="Modificar" onclick="return ingresar('Esta seguro que desea modificar la ODS?', 'ords_p.php')" <?php echo $est_ing; ?>/>                          &nbsp;&nbsp;
                          <input name="Elimina" type="button" class="boton_eli" id="button5" value="Eliminar" onclick="return confirmar('Esta seguro que desea Eliminar la solicitud?', 'ords_p.php', this.value)"<?php echo $est; ?> />
                          &nbsp;&nbsp;
                          <input name="limpia" type="submit" class="boton_lim" id="button6" value="Limpiar" />
                          <label></label></td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
                <br/><?php if($ing_por != ""){echo "SOLICITUD INGRESADA POR: ".strtoupper($ing_por);} ?>
           </td>
          </tr>
        </table></td>
      </tr>
    </table>
     </form>
    </td>
  </tr>
  <tr>
    <td height="3" colspan="3" align="center" valign="top"><img src="../imagenes/barra.gif" width="100%" height="3" /></td>
  </tr>
</table>

</body>
</html>
