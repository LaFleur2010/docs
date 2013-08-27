<?
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
/*****************************************************************************************************	
	
/*****************************************************************************************************
******************************************************************************************************
Nombre: 		FilaDetalle();
Descripcion: 	Funcion para crear filas de gastos ingresados al mostrar registros
fecha:			22/04/2011
Creador:		Pedro Troncoso M.
Parametros:		(codigo del detalle, codigo del tipo de gasto, monto del gasto, fecha del gasto)
******************************************************************************************************
//***************************************************************************************************/
function FilaDetalle($id_det, $num_cot, $desc_detc, $cant_detc, $und_detc, $unit_detc, $nom_um)
{	
	$total_detc = $cant_detc * $unit_detc;
	if($_SESSION['usuario_bod'] == "Administrador")
	{
		$lectura = "";
	}else{
		$lectura = "readonly ='readonly'";
	}
	
	 echo"<tr border='0' bgcolor='#FFFFFF' valign='top'>
	 	<td> 
     		<textarea name='desc_detc[]' rows='4' id='desc_detc[]' style='width: 550px' onkeydown='cuenta_caracteres(this.value);'>$desc_detc</textarea> 
     	</td>
     	<td> 
     		<select id='und_med' name='und_med[]'>";

			$sql  = 'SELECT * FROM tb_und_med ORDER BY nom_um';
																		
			$rs 	= dbConsulta($sql);
			$total  = count($rs);
			echo "<option selected='selected' value='$und_detc'>$nom_um</option>";
																				
			for ($i = 0; $i < $total; $i++)
			{
				echo "<option value='".$rs[$i]['cod_um']."'>".$rs[$i]['nom_um']."</option>";
			}
			echo "</select>  
   		</td>                            
		<td>
			<input name='cant_detc[]' type='text' class='cajas' style='width: 50px' value='$cant_detc' />
		</td>
		<td>
			<input name='unit_detc[]' type='text' class='cajas' style='width: 80px' value='$unit_detc'/> 
		</td>
		<td>
			<input name='total_detc[]' type='text' class='cajas' style='width: 80px' value='$total_detc'/>
			<input name='id_det[]' type='hidden' value='$id_det' style='width: 20px' />
        </td>

		<td align='center'>";
		$tabla = "tb_cot_det";
		$dest  = "Licitaciones/cotizaciones.php";

		echo"<a href='../eliminar_item.php?id=$id_det&cod=$num_cot&tabla=$tabla&dest=$dest' onclick='return confirmar(\"Esta Seguro de querer eliminar el registro seleccionado? \")'>
		<img src='../imagenes/remove.png' border='0' valign='top' alt='Eliminar' />";

		echo"</td>
		
		</tr> "; 
}

function FilaAlcance($id_alc, $num_cot, $desc_alcc, $tipo_alcc)
{		
	if($tipo_alcc == 1)
	{
		$estado = "checked"; 
		$color = "bgcolor='#cedee1' bordercolor='#cedee1'";
		$colortextarea = "background-color: #cedee1;border: 0px solid;";
	}else{
		$color = "bgcolor='#FFFFFF' bordercolor='#FFFFFF' ";
	}
	
	 echo"<tr border='0' $color valign='top'>
	 	<td> 
     		<textarea name='desc_alcc[]' rows='2' id='desc_alcc[]' style=\"width: 830px; $colortextarea\">$desc_alcc</textarea> 
			<input name='id_alc[]' type='hidden' value='$id_alc' style='width: 20px' />
     	</td>                
		<td>
		&nbsp;<label><input type='checkbox' name='tipo_alcc[]' id='tipo_alcc[]' onclick='validarcheck(this)' $estado />&nbsp;Titulo&nbsp;&nbsp;</label>
		<input type='hidden' name='auxcheck[]' id='auxcheck[]' value='$tipo_alcc' />
	    </td>

		<td align='center'>";
		$tabla = "tb_cot_det";
		$dest  = "Licitaciones/cotizaciones.php";

		echo"<a href='../eliminar_item.php?id=$id_det&cod=$num_cot&tabla=$tabla&dest=$dest' onclick='return confirmar(\"Esta Seguro de querer eliminar el registro seleccionado? \")'>
		<img src='../imagenes/remove.png' border='0' valign='top' alt='Eliminar' />";

		echo"</td>
		
		</tr> "; 
}
	
/**************************************************************************************************
				INICALIZAMOS LAS VARIABLES DE LOS COMBOS
**************************************************************************************************/
$fe					=	date("d/m/Y");
$cliente_cot		= "------------------------------ Seleccione ------------------------------";
$resp_cot			= "------------------------------ Seleccione ------------------------------";
$contacto_cot		= "------------------------------ Seleccione ------------------------------";
$emp_cot			= "------------------------------ Seleccione ------------------------------";
$estado_cot			= "------------------------------ Seleccione ------------------------------";
$nom_emps			= "------------------------------ Seleccione ------------------------------";
$tipo_ing			= "----- Seleccione -----";
$op_venta  			= "----- Seleccione -----";
$resp_cot2  		= "----- Seleccione -----";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ingreso de Cotizaciones/Licitaciones</title>

<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="JavaScript" src="../inc/funciones.js"></script>


<!-- CALENDARIO -->
<LINK href="inc/epoch_styles.css" type="text/css" rel="stylesheet">
<SCRIPT src="inc/epoch_classes.js" type="text/javascript"></SCRIPT>

<!--FANCY BOX-->

<script type="text/javascript" src="../lib/jquery-1.7.1.min.js"></script>  
<script type="text/javascript" src="../source/jquery.fancybox.pack.js"></script>  
<link rel="stylesheet" type="text/css" href="../source/jquery.fancybox.css" /> 

	    <script type="text/javascript">  
			
	    	/*
			---------------------------------------------------------------------------
			FANCY BOX HTML  MODAL
			---------------------------------------------------------------------------
			*/


				$(function() {

		    	$('#objetivo').click(function() {

		        $.fancybox({
		            'width': 800,
		            'height': 600,
		            'autoScale': true,
		            'transitionIn': 'fade',
		            'transitionOut': 'fade',
		            'href': 'objetivo.php?tipo='+$("#tipo_ing").val()+'&num='+$("#num_cot").val(),
		            'type': 'iframe',
		            'onClosed': function() {
		             window.location.href = "objetivo.php";
		            }

		        });

		        return false;
		    });

		});

			/*
			---------------------------------------------------------------------------
			FIN FANCY BOX HTML  MODAL
			---------------------------------------------------------------------------
			*/   

		</script>	
    <!--FIN FANCY BOX -->

<SCRIPT type="text/javascript">
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

function creando2()
{
	addFormLine('myDiv2', 'myLine2');
}
/**********************************************************************************

**********************************************************************************/
var dp_cal, dp_cal2, dp_cal3, dp_cal4, dp_cal5;
window.onload = function () 
{
	stime = new Date();
	dp_cal 	  = new Epoch('dp_cal','popup',document.getElementById('date_field'));
	dp_cal2   = new Epoch('dp_cal2','popup',document.getElementById('date_field2'));
	dp_cal3   = new Epoch('dp_cal3','popup',document.getElementById('date_field3'));
	dp_cal4   = new Epoch('dp_cal4','popup',document.getElementById('date_field4'));
	dp_cal5   = new Epoch('dp_cal5','popup',document.getElementById('date_field5'));
};  

function enviar(url)
{
	document.form1.action=url;
}
/*******************************************************************************************************************
										FUNCIONES CONFIRM
********************************************************************************************************************/
function confirmar(msj, dest, boton)
{
	var agree=confirm(msj);
		if (agree)
		{
			document.form1.action=dest; 
			document.form1.submit();
			return true ;
		}else{
			return false ;
		}
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
   objeto.open("GET", "../poput/combo_cli.php?" + comando + "&random=" + Math.random(), true);
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
   objeto.open("GET", "../poput/combo_resp.php?" + comando4 + "&random=" + Math.random(), true);
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
   objeto.open("GET", "../poput/combo_emp.php?" + comando3 + "&random=" + Math.random(), true);
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

//hasta aqui termina el codigo de ajax-->
/**********************************************************************************************************************
**********************************************************************************************************************/
function gen()
{
	var agree=confirm("Esta Seguro Que desea Ingresar el registro ?");
	if (agree){
		document.form1.action='cotizaciones_p.php';//TENGO QUE CONCATENAR LA PUTA VARIABLE! 
		document.form1.submit();
		return true ;
	}else{
		return false ;
	}
}

function valida_ing()
{
	var num_cot			= document.form1.num_cot.value;
	var tipo_ing		= document.form1.tipo_ing.value;
	//var check_t 		= document.getElementsByName("radio[]");	
	var desc_cot		= document.form1.desc_cot.value;
	var fe_ing_cot		= document.form1.fe_ing_cot.value;
	/*var fe_sal_cot    = document.form1.fe_sal_cot.value;
	var fe_cons_cot		= document.form1.fe_cons_cot.value;	
	var fe_resp_cot		= document.form1.fe_resp_cot.value;*/
	var fe_ent_cot		= document.form1.fe_ent_cot.value;	
	var cliente_cot		= document.form1.c1.value;
	var contacto_cot	= document.form1.c2.value;	
	var emp_cot			= document.form1.c3.value;
	var resp_cot		= document.form1.c4.value;	
	var estado_cot		= document.form1.c5.value;
	var resp_cot2       = document.form1.c8.value;
	var op_venta       	= document.form1.otro2.value;
	var ref_venta       = document.form1.otro.value;
	var valor_cot       = document.form1.valor_cot.value;
	var p_objetivo      = document.form1.Pobjetivo.value;	
	/*var obs_cot			= document.form1.obs_cot.value;	*/
	
	if(document.form1.radio.checked == true &&  num_cot.length < 6){alert("Debe ingresar Numero de Cotizacion/Licitacion");document.form1.num_cot.focus();return false;}
	
	if(tipo_ing != "----- Seleccione -----")
	{//alert(document.form1.radio[1].checked + " " + num_cot);return false;
		if(desc_cot != "")
		{
			if(fe_ing_cot != "")
			{
				if(fe_ent_cot != "")
				{
					if (op_venta != "----- Seleccione -----") 
					{
						if (ref_venta != "") 
						{
							if (resp_cot2 !="----- Seleccione -----") 
							{
								if(cliente_cot != "------------------------------ Seleccione ------------------------------" && cliente_cot != "")
									{
										if(contacto_cot != "------------------------------ Seleccione ------------------------------" && contacto_cot != "")
										{
											if(emp_cot != "------------------------------ Seleccione ------------------------------" && emp_cot != "")
											{
												if(resp_cot != "------------------------------ Seleccione ------------------------------" && resp_cot != "")
												{
													if(estado_cot != "------------------------------ Seleccione ------------------------------" && estado_cot != "")
													{
															return gen();
														}else{
														alert("Debe Seleccionar Estado");
														document.form1.c5.focus();
														return false;
														}
													}else{
													alert("Debe Seleccionar Responsable");
													document.form1.c4.focus();
													return false;
													}	
												}else{
												alert("Debe Seleccionar Empresa");
												document.form1.c3.focus();
												return false ;
												}
											}else{
											alert("Debe seleccionar contacto");
											document.form1.c2.focus();
											return false ;
										}
									}else{
									alert("Debe seleccionar cliente");
									document.form1.c1.focus();
									return false ;
								}
							}else{
								alert("Debe seleccionar a un Responsable General");
								document.form1.c8.focus();
								return false ;
							}
						}else{
							alert("Debe Describir una referencia");
							document.form1.otro.focus();
							return false ;
						}		
					}else{
						alert("Debe seleccionar opcion");
						document.form1.otro2.focus();
						return false ;
					}	
				}else{
					alert("Debe Ingresar fecha de entrega");
					document.form1.fe_ent_cot.focus();
				return false ;
				}
			}else{
				alert("Debe Ingresar fecha de ingreso");
				document.form1.fe_ing_cot.focus();
				return false ;
			}
		}else{
			alert("Debe Ingresar Descripcion");
			document.form1.desc_cot.focus();
			return false ;
		}
	}else{
		alert("Debe Seleccionar Tipo");
		document.form1.tipo_ing.focus();
		return false ;
	}
}

function val_check()
{
	tipo_ing   = document.form1.tipo_ing.value;
	var prueba = $("#tipo_ing").val();	
	


	if (tipo_ing == "Licitacion" || tipo_ing == "Cotizacion")  // Si se selecciono Auto 
	{
		document.form1.num_cot.value = "Automatico";
	}
}



function documentos()
{
	var num_cot = document.form1.num_cot.value;
	if(num_cot != "")
	{
		document.form1.action='documentos.php'; 
		document.form1.submit();
	}else{
		alert("Debe Ingresar Nº de C/L");
		return false;
	}
}

function rep(url)
{
	var num_cot =document.form1.num_cot.value;
	
	
	if(num_cot != "")
	{
		abrirVentanaM(url+"?num_cot="+num_cot,"yes");
		
	}else{
		alert("Debe Ingresar Nº de Cotizacion");
		document.form1.num_cot.focus();
		return false;
	}
}

function sumar(elemento)
{
	var cant_detc 	= document.getElementsByName("cant_detc[]");
	var unit_detc	= document.getElementsByName("unit_detc[]");
	var total_detc	= document.getElementsByName("total_detc[]");
	
   	var total		= cant_detc.length-1;
	var resultado	= 0;
   
   for(var x = 0; x < total; ++x)
   {
	 if(elemento == unit_detc[x] ) 
	 {
		var resultado = eval(cant_detc[x].value + '*' + unit_detc[x].value); 
		total_detc[x].value = resultado ; 
	 }
	 	//document.f.patente.value = eval(document.f.patente.value + '+' + total_item[x].value);
   }
}

function validar(e) 
{
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13)
  {
  	document.form1.busca.focus();
   	//document.form1.action ='contratos.php';
	document.form1.submit();
  }
}

function validarcheck(elemento)
{
	var tipo_alcc 	= document.getElementsByName("tipo_alcc[]");
	var desc_alcc 	= document.getElementsByName("desc_alcc[]");
	var auxcheck 	= document.getElementsByName("auxcheck[]");
	
	var t = auxcheck.length;
   	for(var x = 0; x < t; ++x)
   	{
		if(elemento == tipo_alcc[x]) 
	 	{
			if(elemento.checked == true) 
			{
				auxcheck[x].value = 1;
				desc_alcc[x].style.backgroundColor='#cedee1';
				desc_alcc[x].style.border='0';
				desc_alcc[x].style.bordercolor='#cedee1';
			}else{
				auxcheck[x].value = 0;
				desc_alcc[x].style.backgroundColor='#fff';
				desc_alcc[x].style.border='#153244 1px solid';
			}
		}
	}
}


//ESTA GRAN Y SENCILLA FUNCION ES MARAVILLOSA :) MUESTRA UN IMPUT DEPENDIENDO DE LA OPCION SELECCIONADA A TRAVEZ DE UN SELECT

function mostrarReferencia(){
//Si la opcion con id Conocido_1 (dentro del documento > formulario con name fcontacto >     y a la vez dentro del array de Conocido) esta activada
var op = document.getElementById('1').value; 

if (op == "1") {
document.getElementById('desdeotro').style.display='block';
} 
if (op == "2") {
document.getElementById('desdeotro').style.display='block';
}
if (op == "3") {
document.getElementById('desdeotro').style.display='block';
}
}



</SCRIPT>

<style type="text/css">
<!--
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
body {
	background-color:#5A88B7;
}
a{
	text-decoration: none;
}
.Estilo8 {color: #000000}
.Estilo9 {color: #FFFFFF}
-->
</style>
</head>


<body>
<?php
/***********************************************************************************************************
								BUSCAMOS LA SOLICITUD DEPENDIENDO EL FILTRO
************************************************************************************************************/
if($_POST['ingresa'] != "")
{
	$query = "SELECT * FROM tb_cotizaciones WHERE num_cot = '".$_POST['ingresa']."' ";
}
if($_POST['modifica'] != "")
{
	$query = "SELECT * FROM tb_cotizaciones WHERE num_cot = '".$_POST['modifica']."' ";
}
if($_GET['cod'] != "")
{
	$query = "SELECT * FROM tb_cotizaciones WHERE num_cot = '".$_GET['cod']."' ";
}
if($_POST['busca'] == "Buscar")
{	
	$query = "SELECT * FROM tb_cotizaciones WHERE num_cot = '".$_POST['num_cot']."' ";
}
if($_POST['elimina_item'] != "")
{
	$query = "SELECT * FROM tb_cotizaciones WHERE num_cot = '".$_POST['elimina_item']."' ";
}
/**************************************************************************************/
if($_POST['busca'] == "Buscar" or $_POST['ingresa'] != "" or $_POST['modifica'] != "" or $_POST['elimina_item'] != "" or $_GET['cod'] != "" and $_POST['limpia'] != "Limpiar")
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sqlc	= $query;
	$res	= mysql_query($sqlc, $co);
	$cont 	= mysql_num_rows($res);
	
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
			
			$transp_cot		= "".$vrows['transp_cot']."";
			$moneda_cot		= "".$vrows['moneda_cot']."";
			$conpag_cot		= "".$vrows['conpag_cot']."";
			$plazoent_cot	= "".$vrows['plazoent_cot']."";
			$garantia_cot	= "".$vrows['garantia_cot']."";			
			$valof_cot		= "".$vrows['valof_cot']."";	
			$valor_cot		= "".$vrows['valor_cot']."";
			$modificaiones  = "".$vrows['por_modificaciones']."";
			$multas 		= "".$vrows['por_multas']."";
			$op_venta		= "".$vrows['op_venta']."";
			$ref_venta      = "".$vrows['ref_venta']."";
			$resp_cot2      = "".$vrows['resp_general']."";
		}
			$SqlDet = "SELECT * FROM tb_cot_det, tb_und_med WHERE tb_cot_det.num_cot = '$num_cot' and tb_cot_det.und_detc = tb_und_med.cod_um ORDER BY tb_cot_det.id_det";
			$ResDet = dbExecute($SqlDet);
			while ($VrsDet = mysql_fetch_array($ResDet)) 
			{
				$Det_Cot[] = $VrsDet;
			}
			
			$SqlAlc = "SELECT * FROM tb_cot_alc WHERE num_cot = '$num_cot' ORDER BY id_alc";
			$ResAlc = dbExecute($SqlAlc);
			while ($VrsAlc = mysql_fetch_array($ResAlc)) 
			{
				$Det_Alc[] = $VrsAlc;
			}

			$sql_cli = "SELECT razon_s, id_cli FROM tb_clientes WHERE id_cli = '$cliente_cot' ";
			$res=mysql_query($sql_cli,$co);
			while($vrowsc=mysql_fetch_array($res))
			{
				$cliente_cot	= "".$vrowsc['razon_s']."";
			}
			
			$sql_res = "SELECT nom_resp FROM tb_responsable WHERE rut_resp = '$resp_cot'";
			$res = mysql_query($sql_res,$co);
			while($vrowsr = mysql_fetch_array($res))
			{
				$resp_cot	= "".$vrowsr['nom_resp']."";
			}

			$sql_res2 = "SELECT nom_resp FROM tb_responsable WHERE rut_resp = '$resp_cot2' ";
			$res = mysql_query($sql_res2,$co);
			while($vrowsr = mysql_fetch_array($res))
			{
				$resp_cot2	= "".$vrowsr['nom_resp']."";
			}
			
			$sql_emp = "SELECT nom_emps FROM tb_empresaserv WHERE rut_emps = '$emp_cot' ";
			$res_emp = mysql_query($sql_emp,$co);
			while($vrow_emp = mysql_fetch_array($res_emp))
			{
				$nom_emps	= "".$vrow_emp['nom_emps']."";
			}

			$sql_pre = "SELECT venta,estudio,objetivo FROM tb_presupuesto WHERE num = '$num_cot' ";
			$rs      = mysql_query($sql_pre,$co);
			while($vrow_pre = mysql_fetch_array($rs)){
				$Pventa 	= $vrow_pre['venta'];
				$Pobjetivo  = $vrow_pre['objetivo'];
				$Pestudio   = $vrow_pre['estudio'];
			}

			$sql_obserbacion = "SELECT comentario FROM tb_obserbacion where numero = '$num_cot'";
			$rs_obserbacion = mysql_query($sql_obserbacion,$co);
			while ($vrow_obser = mysql_fetch_array($rs_obserbacion)) {
				$op = $vrow_obser['comentario'];
			}
			if ($op == 1) {
				$opi = "checked";
			}else{
				$opi = "nochecked";
			}

			$sql = "SELECT * FROM tb_p_objetivo where num_cot = '$num_cot'";
			$rs  = mysql_query($sql,$co);
			$val = mysql_num_rows($rs);

				while ($row = mysql_fetch_array($rs)) {
					
					//operacionales
					$materiales 	= $row['materiales'];
					$mantencion		= $row['mantencion'];
					$combustible	= $row['combustibles'];
					$maquinarias	= $row['arri_maquinarias'];
					$seguridad		= $row['imp_seguridad'];
					$externos		= $row['serv_externos'];
					$colaciones		= $row['colaciones'];
					//Remuneraciones
					$sueldos		= $row['sueldos'];
					$bonos			= $row['bonos'];
					$finiquitos		= $row['finiquitos'];
					$h_extras		= $row['horas_extras'];
					//gastos generales
					$g_generales	= $row['gastos_generales'];
					$otros			= $row['otros_gastos'];
					$bancarios		= $row['gastos_bancarios'];
					$fecha 			= $row['fecha'];

				}
				$p_obe = $materiales + $mantencion + $combustible + $maquinarias + $seguridad+
						 $externos + $colaciones + $sueldos + $bonos + $finiquitos + $h_extras +
						 $g_generales + $otros + $bancarios ;	
	}
}

	
/******************************************************************************************
	FORMATEAMOS LAS FECHAS
******************************************************************************************/
$fe_sol		=	cambiarFecha($fe_sol, '-', '/' ); 
$fe_aprob_g	=	cambiarFecha($fe_aprob_g, '-', '/' ); 
$fe_en_obra	=	cambiarFecha($fe_en_obra, '-', '/' );

if($fe_sol 		== "00/00/0000"){$fe_sol = "";}
if($fe_aprob_g 	== "00/00/0000"){$fe_aprob_g = "";}
if($fe_en_obra 	== "00/00/0000"){$fe_en_obra = "";}

?>
<table width="990" height="646" align="center" cellpadding="0" cellspacing="0" bgcolor="#F2F2F2">
  <tr>
    <td width="100" height="54" align="center" valign="top" bgcolor="#FFFFFF"><img src="../imagenes/logo2.jpg" width="127" height="60" /></td>
    <td width="793" align="center" valign="middle" bgcolor="#FFFFFF">COTIZACIONES/LICITACIONES</td>
    <td width="93" align="right" valign="top" bgcolor="#FFFFFF"><img src="../imagenes/logo_iso_c.jpg" width="110" height="56" /></td>
  </tr>
  <tr>
    <td height="3" colspan="3" align="center" valign="top">
    <img src="../imagenes/barra.gif" alt="" width="100%" height="3" /></td>
  </tr>
  <tr>
    <td height="582" colspan="3" align="center" valign="top">  
    <table width="984" height="601" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
        <tr>
        <td width="1032" height="559" align="center" valign="top">
		<form name="form1" method="post" action="">
          <table width="980" height="557" border="0" cellpadding="0" cellspacing="0" class="tablas">
            <tr>
              <td width="1003" height="557" align="center" valign="top">
              <table width="980" height="56" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor=<?php echo $ColorMotivo; ?> >
                <tr>
                  <td width="979" align="center"><table width="961" height="66" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="95" height="62" align="center"><input name="button8" type="submit" class="boton_inicio" id="button8" value="Inicio" onclick="enviar('../index2.php')"/></td>
                      <td width="94" align="center"><input name="Volver4" type="submit" class="boton_actualizar" id="Volver4" value="Actualizar" /></td>
                      <td width="153" align="center"><!-- <input name="button4" type="button" class="boton_print" id="button" value="Vista impresion" onclick="rep('rep_cot.php')" />--></td>
                      <td width="96" align="center"><label></label></td>
                      <td width="87" align="center">&nbsp;</td>
                      <td width="94" align="center"><input name="button3" type="button" class="boton_print" id="button9" value="Vista impresion" onclick="rep('imprime_cot.php')" /></td>
                      <td width="92" align="center"><input name="button10" type="submit" class="boton_lista" id="button13" value="Listado" onclick="enviar('listado.php')" /></td>
                      <td width="110" align="center"><input name="button" type="submit" class="boton_historial" id="button6" value="Historial Cot/Lic" onclick="enviar('lista_ter.php')" /></td>
                      <td width="95" align="center"><input name="button11" type="submit" class="boton_ver_doc" id="button3" value="Documentacion" onclick="return documentos()"/></td>
                      <td width="45" align="right"><input type="hidden" name="usuario_nombre" id="usuario_nombre" value="<?php echo $_SESSION['usuario_nombre']; ?> " /></td>
                    </tr>
                  </table></td>
                </tr>
              </table>
                <table width="951" height="505" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
                <tr>
                  <td width="951" height="465" align="center"><table width="970" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
                    <tr>
                      <td width="976" height="516" align="center">
                        <fieldset class="txtnormalB">
                          <legend class="txtnormaln">Ingreso de datos</legend>
                          <table width="960" border="0" cellspacing="1" cellpadding="1">
                            <tr>
                              <td colspan="2" align="left">&nbsp;</td>
                              <td colspan="3" rowspan="2" align="left"><font color="#FF0000">(*) Datos Obligatorios</font></td>
                            </tr>
                            <tr>
                              <td height="34" colspan="2" align="left" valign="top"><table width="305" border="0">
                                <tr>
                                  <td width="133"><label>
                                    <input name="radio" type="radio" id="auto" value="auto" checked="checked" onclick="val_check()" />
                                    Cod. Automatico</label></td>
                                  </tr>
                              </table></td>
                            </tr>
                            <tr>
                              <td width="161" height="39" align="left"><label>Tipo&nbsp;<font color="#FF0000">(*)</font></label></td>
                              <td width="192" align="left">
                              
                                <select name="tipo_ing" id="tipo_ing" style="width:150px;" onchange="val_check()">
                                <?php echo"<option selected='selected' value='$tipo_ing'>$tipo_ing</option>"; ?>
                                  <option value="Cotizacion">Cotizacion</option>
                                  <option value="Licitacion">Licitacion</option>
                                </select>                               </td>
                              <td width="164" align="left"><span class="Estilo8">Numero C/L&nbsp;<font color="#FF0000">(*)</font></span></td>
                              <td width="350" align="left" valign="middle"><span class="content Estilo8">
                                <input name="num_cot" type="text" id="num_cot" value="<?php echo $num_cot; ?>" size="12" onkeypress="validar(event)"/>
                                </span>
                                <input name="busca" type="submit" class="boton_bus" id="button4" value="Buscar" /></td>
                              <td width="81" align="left" valign="top">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="37" align="left"><span class="Estilo8">Nombre/Trabajo&nbsp;<font color="#FF0000">(*)</font></span></td>
                              <td colspan="4" align="left"><span class="txtnormaln">
                                <textarea name="desc_cot" cols="90"><?php echo $desc_cot;?></textarea>
                                </span></td>
                            </tr>
                            <tr>
                              <td align="left"><span class="Estilo8">Fecha/Ingreso&nbsp;<font color="#FF0000">(*)</font></span></td>
                              <td align="left"><span class="content Estilo8">
                                <? $fe_ing_cot	=	cambiarFecha($fe_ing_cot, '-', '/' ); ?>
                                <input id="date_field" style="WIDTH: 7em" name="fe_ing_cot" value="<? echo $fe_ing_cot; ?>" />
                                <input type="button" class="botoncal" onclick="dp_cal.toggle();" />
                                </span></td>
                              <td align="left"><span class="Estilo8">
                                <label>Cliente&nbsp;<font color="#FF0000">(*)</font></label>
                                </span></td>
                              <td align="left">
                                <div id="DivNombres">
                                  <select name="c1" id="c1" style="width:350px;" onchange="CargarDatos(this.value)">
                                    <?php
									$co=mysql_connect("$DNS","$USR","$PASS");
								
									$sql_c  	= "SELECT * FROM tb_clientes ORDER BY razon_s";
									$rs_c 		= dbConsulta($sql_c);
									$total_c  	= count($rs_c);
									echo"<option selected='selected' value='$cliente_cot'>$cliente_cot</option>";
											
									for ($i = 0; $i < $total_c; $i++)
									{
										$razon_s = $rs_c[$i]['razon_s'];
										if($razon_s != $cliente_cot){
											echo "<option value='".$rs_c[$i]['id_cli']."'>".htmlentities(utf8_decode($rs_c[$i]['razon_s']))."</option>";
										}
									}
							?>
                                    </select>
                                  </div>
                                
                                <div id="resultado"></div>                                </td>
                              <td align="left">
                                
                                <span class="Estilo8">
                                  <input name="clientes" type="button" class="otro" id="agregar" value="  ? " onclick="abrirVentanac('../poput/clientes.php','804','550','yes','yes');"/>
                                  <input type="hidden" name="ComandoRemoto" id="ComandoRemoto" />
                                  </span>                                </td>
                            </tr>
                            <tr>
                              <td align="left"><span class="Estilo8">Fecha Salida/terreno</span></td>
                              <td align="left"><span class="content Estilo8">
                                <? $fe_sal_cot	=	cambiarFecha($fe_sal_cot, '-', '/' ); ?>
                                <input id="date_field2" style="WIDTH: 7em" name="fe_sal_cot" value="<? echo $fe_sal_cot; ?>" />
                                <input type="button" class="botoncal" onclick="dp_cal2.toggle();" />
                              </span></td>
                              <td align="left"><span class="Estilo8">Contacto&nbsp;<font color="#FF0000">(*)</font></span></td>
                              <td align="left">
                              
                              <div id="DivNombres2">
                                <select name="c2" id="c2" style="width:350px;" onchange="CargarDatos(this.value)">
                                  <?php
									$co=mysql_connect("$DNS","$USR","$PASS");
								
									$sql_c  	= "SELECT * FROM tb_contacto_cli ORDER BY nom_cont";
									$rs_c 		= dbConsulta($sql_c);
									$total_c  	= count($rs_c);
									echo"<option selected='selected' value='$contacto_cot'>$contacto_cot</option>";
											
									for ($i = 0; $i < $total_c; $i++)
									{
										$nom_cont = $rs_c[$i]['nom_cont'];
										if($nom_cont != $contacto_cot){
											echo "<option value='".$rs_c[$i]['nom_cont']."'>".$rs_c[$i]['nom_cont']."</option>";
										}
									}
							?>
                                </select>
                              </div>
                              
                              <div id="resultado2"></div>                              </td>
                              <td align="left">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="left"><span class="Estilo8">Fecha Consulta </span></td>
                              <td align="left"><span class="content Estilo8">
                                <? $fe_cons_cot	=	cambiarFecha($fe_cons_cot, '-', '/' ); ?>
                                <input id="date_field3" style="WIDTH: 7em" name="fe_cons_cot" value="<? echo $fe_cons_cot; ?>" />
                                <input type="button" class="botoncal" onclick="dp_cal3.toggle();" />
                              </span></td>
                              <td align="left"><span class="Estilo8">Empresa del Servicio&nbsp;<font color="#FF0000">(*)</font></span></td>
                              <td align="left">
                              
                              <div id="DivNombres3">
                                <select name="c3" id="c3" style="width:350px;" onchange="CargarDatos(this.value)">
                                  <?php
									$co=mysql_connect("$DNS","$USR","$PASS");
									mysql_select_db("$BDATOS", $co);
								
									$sql_c  	= "SELECT * FROM tb_empresaserv ORDER BY nom_emps";
									$rs_c 		= dbConsulta($sql_c);
									$total_c  	= count($rs_c);
									echo"<option selected='selected' value='$nom_emps'>$nom_emps</option>";
											
									for ($i = 0; $i < $total_c; $i++)
									{
										$nom_emps = $rs_c[$i]['nom_emps'];
										if($nom_emps != $emp_cot){
											echo "<option value='".$rs_c[$i]['rut_emps']."'>".$rs_c[$i]['nom_emps']."</option>";
										}
									}
							?>
                                </select>
                                </div>
                              <div id="resultado3"></div>                              </td>
                              <td align="left"><span class="Estilo8">
                                <input name="agregar3" type="button" class="otro" id="agregar3" value="  ? " onclick="abrirVentanac('../poput/empresa.php','470','400','yes','yes');"/>
                                <input type="hidden" name="ComandoRemoto3" id="ComandoRemoto3" />
                              </span></td>
                            </tr>
                            <tr>
                              <td align="left"><span class="Estilo8">Fecha Respuesta </span></td>
                              <td align="left"><span class="content Estilo8">
                                <? $fe_resp_cot	=	cambiarFecha($fe_resp_cot, '-', '/' ); ?>
                                <input id="date_field4" style="WIDTH: 7em" name="fe_resp_cot" value="<? echo $fe_resp_cot; ?>" />
                                <input type="button" class="botoncal" onclick="dp_cal4.toggle();" />
                              </span></td>
                              <td align="left"><span class="Estilo8">Responsable/Estudio&nbsp;<font color="#FF0000">(*)</font>&nbsp;</span></td>
                              <td align="left">
                              
                              <div id="DivNombres4">
                                <select name="c4" id="c4" style="width:350px;" onchange="CargarDatos4(this.value)">
                                  <?php
									$co=mysql_connect("$DNS","$USR","$PASS");
								
									$sql_c  	= "SELECT * FROM tb_responsable ORDER BY nom_resp";
									$rs_c 		= dbConsulta($sql_c);
									$total_c  	= count($rs_c);
									echo"<option selected='selected' value='$resp_cot'>$resp_cot</option>";
											
									for ($i = 0; $i < $total_c; $i++)
									{
										$nom_resp = $rs_c[$i]['nom_resp'];
										if($nom_resp != $resp_cot){
											echo "<option value='".$rs_c[$i]['rut_resp']."'>".$rs_c[$i]['nom_resp']."</option>";
										}
									}
							?>
                                </select>
                              </div>
                              
                              <div id="resultado4"></div>                              </td>
                              <td align="left"><span class="Estilo8">
                                <input name="agregar4" type="button" class="otro" id="agregar4" value="  ? " onclick="abrirVentanac('../poput/responsable.php','470','500','yes','yes');"/>
                                <input type="hidden" name="ComandoRemoto4" id="ComandoRemoto4" />
                              </span></td>
                            </tr>
                            <tr>
                              <td align="left"><span class="Estilo8">Fecha 
                                Entrega&nbsp;<font color="#FF0000">(*)</font></span></td>
                              <td align="left"><span class="content Estilo8">
                                <? $fe_ent_cot	=	cambiarFecha($fe_ent_cot, '-', '/' ); ?>
                                <input id="date_field5" style="WIDTH: 7em" name="fe_ent_cot" value="<? echo $fe_ent_cot; ?>" />
                                <input type="button" class="botoncal" onclick="dp_cal5.toggle();" />
                              </span></td>
                              <td align="left"><span class="Estilo8">Estado&nbsp;<font color="#FF0000">(*)
                                
                              </font></span></td>
                              <td align="left"><span class="Estilo8">
                                <select name="c5" size="1" value="" style="width:350px;">
                                <?php echo"<option selected='selected' value='$estado_cot'>$estado_cot</option>"; ?>
                                  <option value="Adjudicado">Adjudicado</option>
                                  <option value="Estudio">Estudio</option>
                                  <option value="En Espera">En Espera</option>
                                  <option value="Nula">Nula</option>
                                  <option value="No Adjudicado">No Adjudicado</option>
                                  <option value="No Estudio">No Estudio</option>
                                </select>
                              </span></td>
                              <td align="left">&nbsp;</td>
                            </tr>
                            
                            <?php
							  	if($_SESSION['us_tipo'] == "Coordinador" or $_SESSION['us_tipo'] == "Administrador")
								{
							  ?>
                            <tr>
                              <td align="left">Valor final en pesos chilenos</td>
                              <td colspan="4" align="left"><span class="txtnormaln">
                                <input name="valor_cot" type="text" id="valor_cot" style="width:93px" value="<?php echo $valor_cot;?>" />
                              </span></td>
                              </tr>
                              
                              <?php
								}
							  ?>
                            <tr>
                              <td height="36" colspan="5" align="left"><span class="Estilo8">Observaciones (No se imprime en la cotizacion)</span></td>
                              </tr>
                            <tr>
                              <td colspan="5" align="left"><textarea name="obs_cot" cols="110" rows="5" value="" id="obs_cot"><?php echo $obs_cot;?></textarea></td>
                            </tr>
                            <tr>
                              <td align="left">Transporte</td>
                              <td colspan="4" align="left"><span class="txtnormaln">
                                <input name="transp_cot" type="text" style="width:735px" value="<?php echo $transp_cot;?>" />
                              </span></td>
                              </tr>
                            <tr>
                              <td align="left">Tipo Moneda</td>
                              <td colspan="4" align="left"><span class="Estilo8">
                                <select name="moneda_cot" class="combos" id="moneda_cot" >
                                  <? echo"<option selected='selected' value='$moneda_cot'>$moneda_cot</option>";?>
                                  <option value="US Dolares">US Dolares</option>
                                  <option value="Euros">Euros</option>
                                  <option value="Pesos Chilenos">Pesos Chilenos</option>
                                </select>
                              </span></td>
                              </tr>
                            <tr>
                              <td align="left">Plazo de entrega</td>
                              <td colspan="4" align="left"><span class="txtnormaln">
                                <input name="plazoent_cot" type="text" style="width:735px" value="<?php echo $plazoent_cot;?>" />
                                </span></td>
                            </tr>
                            <tr>
                              <td align="left">Garantia</td>
                              <td colspan="4" align="left"><span class="txtnormaln">
                                <input name="garantia_cot" type="text" style="width:735px" value="<?php echo $garantia_cot;?>" />
                              </span></td>
                              </tr>
                            <tr>
                              <td align="left">Validez de la oferta</td>
                              <td colspan="4" align="left"><span class="txtnormaln">
                                <input name="valof_cot" type="text" style="width:735px" value="<?php echo $valof_cot;?>" />
                              </span></td>
                              </tr>
                            <tr>
                              <td align="left">Condiciones de pago</td>
                              <td colspan="4" align="left"><span class="txtnormaln">
                                <textarea name="conpag_cot" rows="2" style="width:735px"><?php echo $conpag_cot;?></textarea>
                              </span></td>
                            </tr>

                           <tr>
                           		<td height="29" colspan="0" align="center" class="txt01">
                            		<p align="left">Responsable de Venta</p>
                            	</td>
                           </tr>
                           <tr>
                           		<td align="left">
                           			Opci&oacute;n<font color="#FF0000">&nbsp;(*)</font>
                           		</td>
                           </tr>
                           <tr>
                           		<td align="left">
                           			<select name="otro2" id="otro2">
                           			<? echo"<option selected='selected' value='$op_venta'>$op_venta</option>";?>
                           				<option value="Portal">Portal</option>
                           				<option value="Ventas">Ventas</option>
                           				<option value="Otros">Otros</option>
                           			</select>
									<p>Referencia<font color="#FF0000">&nbsp;(*)</font></p>
									<p><input type="text" name="otro" id="otro" value="<?php echo $ref_venta; ?>"class="input" /></p>
									
                           		</td>
                           </tr>
                           <tr>
							<td align="left">Responsable General.<font color="#FF0000">&nbsp;(*)</font>
                            
                          </td>
                           </tr>
                           <tr>
                           	<td>
								<select name="c8" id="c8"  onchange="CargarDatos4(this.value)">
                                  <?php
									$co=mysql_connect("$DNS","$USR","$PASS");
								
									$sql_c  	= "SELECT * FROM tb_responsable ORDER BY nom_resp";
									$rs_c 		= dbConsulta($sql_c);
									$total_c  	= count($rs_c);
									echo"<option selected='selected' value='$resp_cot2'>$resp_cot2</option>";
											
									for ($i = 0; $i < $total_c; $i++)
									{
										$nom_resp2 = $rs_c[$i]['nom_resp'];
										if($nom_resp2 != $resp_cot2){
											echo "<option value='".$rs_c[$i]['rut_resp']."'>".$rs_c[$i]['nom_resp']."</option>";
										}
									}
									?>
                                </select>
                           	</td>
                           </tr>            
                           <tr>
                              <td height="29" colspan="5" align="center" class="txt01">Alcance del servicio</td>
                              </tr>
                          </table>
                          </fieldset><br />
                          
                          <fieldset class="txtnormalB">
                          <legend class="txtnormaln">Detalle de cotizacion</legend>
                          <table width="960" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
                            <tr>
                              <td width="952" height="86" align="center">
                              
                              <table width="954" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td height="23" align="left" valign="middle"><label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <input type="button" class="boton_nue2" value=" Agregar Item" onclick="creando();" />
                                    <br/>
                                  </td>
                                </tr>
                                <tr>
                                  <td height="19" align="center" valign="bottom"><div id="recargado">
                                    <table width="942" border="1" cellpadding="1" cellspacing="0" bgcolor="#cedee1" bordercolor="#FFFFFF">
                                      <tr>
                                        <td width="550" height="19">&nbsp;&nbsp;&nbsp;&nbsp;DESCRIPCION DEL PRODUCTO</td>
                                        <td width="122">&nbsp;UND</td>
                                        <td width="57">&nbsp;CANT</td>
                                        <td width="84">&nbsp;VALOR UNIT</td>
                                        <td width="107">&nbsp;VALOR TOTAL</td>
                                      </tr>
										<?php
											$i				= 0; // Inicializamos una variable para el while
											$Contador_det	= count($Det_Cot); // Contador de gastos encontrados por la ods

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
												
												$total_det   = ($total_det + $total_item); // Calculamos el total de los gastos de la ODS
												
												FilaDetalle($id_det, $num_cot, $desc_detc, $cant_detc, $und_detc, $unit_detc, $nom_um); // Mostramos una fila por cada registro encontrado
												
												// Fila para mostrar el total de los gastos por la ODS
												if($i == ($Contador_det - 1))
												{ 
													echo "<tr class='txtnormaln'><td align='right' colspan='4'>TOTAL VALOR TOTAL NETO</td><td align='left'>&nbsp;$";echo number_format($total_det, 0, ",", "."); echo"</td><td>&nbsp;</td></tr>";
												}
												$i++;


											}
										?>
                                    </table>
                                  </div></td>
                                </tr>

                                <tr>
                                  <td colspan="2" align="center">
                                  
                                  <div id="myDiv"></div> <!-- DIV DONDE SE MOSTRARAN LOS ITEMS DE GASTOS -->
                                  
                                    <div id="myLine" class="hide">
                                      <div> 
                                       <textarea name="desc_detc[]" rows="4" id="desc_detc[]" style="width: 550px" onkeydown="cuenta_caracteres(this.value);"></textarea> 
                                      </div>
                                      <div> 
                                       <?php echo"<select id='und_med' class='combos' name='und_med[]'>";
										if($nom_t=="")
										{
											$trab=$trab;
										}else{
											$trab=$nom_t;
										}
										if($_POST['c3']){$ar = $_POST['c3']; }
										if($_POST['area']){$ar = $_POST['area']; }
										//*******************************************************************************************************
												$sql  = "SELECT * FROM tb_und_med ORDER BY nom_um";
																		
												$rs 	= dbConsulta($sql);
												$total  = count($rs);
												echo"<option selected='selected' value='Seleccione...'>Seleccione...</option>";
																				
												for ($i = 0; $i < $total; $i++)
												{
													$cod_um 	= $rs[$i]['cod_um'];
													$nom_um 	= $rs[$i]['nom_um'];
													
													if($planta != $nom_um){
														echo "<option value='".$rs[$i]['cod_um']."'>".$rs[$i]['nom_um']."</option>";
													}
												}
										echo"</select>"; ?>   
                                      </div>
                                      
                                      <div>
                                        <input name="cant_detc[]" type="text" class="cajas" style="width: 50px" />
                                      </div>
                                      <div>
                                        <input name="unit_detc[]" type="text" class="cajas" style="width: 80px" onkeyup="sumar(this)"/> 
                                      </div>
                                      <div>
                                        <input name="total_detc[]" type="text" class="cajas" style="width: 80px;background-color: #cedee1;" readonly="readonly"/>
                                      </div>
                                    </div>
                                    
                                    </td>
                                </tr>
                                <tr>
                                  <td height="15" align="center"><label for="textfield"></label></td>
                                </tr>
                              </table></td>
                            </tr>
                          </table>
                          </fieldset><br />
                            <?php
                            	if ($_SESSION['us_tipo']=="Coordinador" or $_SESSION['us_tipo'] == "Administrador") {

                            ?>
                           <fieldset class="txtnormalB">
                           <legend class="txtnormaln">Presupuestos</legend>
                            <table width="360" border="0" cellpadding="0" cellspacing="0" align="left" bordercolor="#FFFFFF">

                            <tr>
                            	<td align="left">
                            		Presupuesto de venta 
                            	</td>
                            	<td align="left">
                            		<input type="text" name="Pventa" readonly="yes"  value="<?php echo $total_det; ?>">
                            	</td align="left">
                            <tr>
                            	<td align="left">
                            		Presupuesto de estudio
                            	</td>
                            	<td align="left">
                            		<input type="text" name="Pestudio"value="<?php echo $Pestudio; ?>" >
                            	</td>

                            </tr>
                                <tr>
                            	<td align="left">
                            		Presupuesto de objetivo 
                            	</td>
                            	<td align="left">
                            		<input type="text"  name="Pobjetivo" id="Pobjetivo" readonly="1" value="<?php echo $p_obe; ?>">&nbsp;&nbsp;
                            		<?php
                            		if ($_SESSION['us_tipo']=="Coordinador" or $_SESSION['us_tipo'] == "Administrador") {

                           			 ?>
                           			 <a class="objetivo" id="objetivo" style="text-decoration: none;" ><img style="border:none;" src="../imagenes/objetivo.png" height="20"></a>
                            		<?php
                            		}
                            		?>
                            		<!--<input type="text" name="Pobjetivo" value="<?php //echo $Pobjetivo; ?>"><-->
                            	</td>
                            </tr>

                           </table>	
                           </fieldset>
                           <?php
                           }
                           ?>
                        <fieldset class="txtnormalB">
                        <legend class="txtnormaln">Alcance de cotizacion</legend>
                        <table width="960" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
                        <tr>
                          <td width="952" height="86" align="center"><table width="954" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td height="23" align="left" valign="middle"><label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                <input type="button" class="boton_nue2" value=" Agregar Item" onclick="creando2();" />
                                <br/></td>
                            </tr>
                            <tr>
                              <td height="19" align="center" valign="bottom"><div id="recargado2">
                                <table width="942" border="1" cellpadding="1" cellspacing="0" bgcolor="#cedee1" bordercolor="#FFFFFF">
                                  <tr>
                                    <td width="832" height="19">&nbsp;&nbsp;&nbsp;&nbsp;DESCRIPCION DEL ITEM</td>
                                    <td width="100">TIPO</td>
                                    <td width="30">&nbsp;</td>
                                  </tr>
								<?php
                                    $f				= 0; // Inicializamos una variable para el while
                                    $Contador_alc	= count($Det_Alc); // Contador alcances por cotizacion
                                /*************************************************************************************
                                            COMENZAMOS EL WHILE DE ALCANCES X COTIZACION
                                *************************************************************************************/
                                    while($f < $Contador_alc)
                                    {
                                        $id_alc 		= $Det_Alc[$f]['id_alc'];
                                        $num_cot 		= $Det_Alc[$f]['num_cot'];
                                        $desc_alcc 		= $Det_Alc[$f]['desc_alcc'];
                                        $tipo_alcc 		= $Det_Alc[$f]['tipo_alcc'];
                                
                                        FilaAlcance($id_alc, $num_cot, $desc_alcc, $tipo_alcc); // Mostramos una fila por cada registro encontrado
                                        
                                        $f++;
                                    }
                                ?>
                                </table>
                              </div></td>
                            </tr>
                            <tr>
                              <td colspan="2" align="center">
                              
                              <div id="myDiv2"></div>
                                <!-- DIV DONDE SE MOSTRARAN LOS ITEMS -->
                                <div id="myLine2" class="hide">
                                  <div>
                                    <textarea name="desc_alcc[]" rows="2" id="desc_alcc[]" style="width: 830px"></textarea>
                                  </div>
                                  <div>
                                    <label></label><label><input name="tipo_alcc[]" id="tipo_alcc[]" type="checkbox" onclick="validarcheck(this)"  />&nbsp;Titulo&nbsp;&nbsp;</label>
                                    <input name="auxcheck[]" id="auxcheck[]" type="hidden" />
                                  </div>
                                </div></td>
                            </tr>
                            <tr>
                              <td height="15" align="center"><label for="textfield2"></label></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table>
                      </fieldset>
                      <br>
                      <!--SE CREA LOS CAMPOS OPCIONALES PARA EL FORMATO DE CONDICIONES GENERALES Y COMERCIALES-->
                        <fieldset class="txtnormalB">
                        <legend class="txtnormaln">Opciones de Condiciones Generales y Comerciales</legend>
                        <table width="960" border="0" align="left" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
                        	<tr>
                        		<td align="left">
                        			<?php echo "<input name='Copcion' id='Copcion'  type='checkbox' value='1' $opi >"; ?>Responsabilidad de Dise&ntilde;o
                        		</td>
                        	</tr>
                        	<tr>
                        		<td align="left">
                        			<p>Porcentaje de Reparaciones/Modificaciones</p><input type="text" name="por_modificaciones" value="<?php echo $modificaiones; ?>" style="width:30px;">
                        		</td>
                        	</tr>
                        	<tr>
                        		<td align="left">
                        			<p>Porcentaje de Multas</p><input type="text" name="por_multas" value="<?php echo $multas; ?>" style="width:30px;">
                        		</td>
                        	</tr>
                        </table>
                    	</fieldset>

                        </td>
                      </tr>
                    </table>
                    </td>
                </tr>
                <tr>
                  <td height="15" align="center" valign="bottom">&nbsp;</td>
                </tr>
                <tr>
                  <td height="19" align="center" valign="bottom">
                  
                  <input name="ingresa" type="submit" class="boton_ing" id="ingresa" value="Ingresar" onclick="return valida_ing()"<?php echo $est; ?>/>
&nbsp;
<input name="modifica" type="submit" class="boton_mod" id="button5" value="Modificar" onclick="return confirmar('Esta seguro que desea Modificar la solicitud?', 'cotizaciones_p.php', this.value)"<?php echo $est; ?> />
                &nbsp;
                <input name="anula" type="button" class="boton_eli" id="button2" value="Anular"<?php echo $est; ?> />
                &nbsp;
                <input name="limpia" type="submit" class="boton_lim" id="limpia" value="Limpiar" onclick="return limpia()"<?php echo $est; ?>/>
</td>
                </tr>
              </table></td>
            </tr>
          </table>
        </form>
		</td>
      </tr>
      <tr>
        <td height="7" align="center" valign="top"><span class="txtnormal8"><br />
        <?php 
		   	$fe_ingr_cot	=	cambiarFecha($fe_ingr_cot, '-', '/' );
		  	if($ing_por_cot != ""){echo $tipo_ing." Ingresada Por: ".strtoupper($ing_por_cot)."  El dia: ".$fe_ingr_cot;} 
		?>
        </span></td>
      </tr>
      <tr>
        <td height="8" align="center" valign="top">&nbsp;</td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td height="5" colspan="3" align="center" valign="top"><img src="../imagenes/barra.gif" alt="" width="100%" height="3" /></td>
  </tr>
</table>

</body>
</html>