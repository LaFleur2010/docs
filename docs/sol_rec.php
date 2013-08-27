<?
// Necesario para ver si la session esta activa  o si se tiene permiso de accseso
require("lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php

if($_SESSION['usd_sol_lee'] != "1")
{
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}//Hasta aquí lo comun para todas las paginas restringidas

//**********************************************************************************************************************************************************
	include('inc/config_db.php');
	include('inc/lib.db.php');
	require("../PHPMailer/class.phpmailer.php");
/***********************************************************************************************************************************************************

NOMBRE: 		CreaFilaB($cod_inf, $v_id_det, $desc_s, $cant_det, $c_um, $n_um, $v_ap_d, $v_ap_g, $rec_det, $dis_d, $col_p, $dis_g, $col_g, $dis_recepcion)
DESCRIPCION:	FUNCION PARA CREAR LAS FILAS POR CADA REGISTRO ENCONTRADO	
PARAMETRO:		
AUTOR: 			PEDRO TRONCOSO
FECHA: 			01/09/2010
************************************************************************************************************************************************************/
function CreaFilaB($cod_inf, $v_id_det, $desc_s, $cant_det,$valor_aprox,$valor_bodega, $c_um, $n_um, $v_ap_d, $v_ap_g, $v_ap_b, $rec_det, $dis_d, $col_p, $dis_g, $col_g, $dis_b, $col_b, $dis_recepcion, $cant_b, $factura)
{   
	$co=mysql_connect($GLOBALS["DNS"], $GLOBALS["USR"], $GLOBALS["PASS"]);
	mysql_select_db($GLOBALS["BDATOS"], $co);
	
	echo"<tr valign='top'>				
			<td width='186'>
				<textarea name='desc_sol[]' rows='3' id='desc_sol[]' style='width: 320px' onkeydown='cuenta_caracteres(this.value);'>$desc_s</textarea>&nbsp;
			</td>
			<td width='98'>
				<select id='un_med' name='und_med[]' style='width: 140px' class='combos'>";
					if($nom_t==''){ $trab=$trab; }else{ $trab=$nom_t;}
					if($_POST['combo3']){$ar = $_POST['combo3']; }
					if($_POST['area']){$ar = $_POST['area']; }

					$sql  	= "SELECT * FROM tb_und_med ORDER BY nom_um ";					
					$rs 	= dbConsulta($sql);
					$total  = count($rs);
																
					echo"<option selected='selected' value='$c_um'>$n_um</option>";							
					for ($i = 0; $i < $total; $i++)
					{
						$cod_um 	= $rs[$i]['cod_um'];
						$nom_um 	= $rs[$i]['nom_um'];
													
						if($planta != $nom_um)
						{
							echo "<option value='".$rs[$i]['cod_um']."'>".$rs[$i]['nom_um']."</option>";
						}
					}
			echo"</select>
			</td>
						  
			<td>
				<input type='text' name='cant_det[]' maxlength='11' style='width: 23px' value='$cant_det' />
			</td>
			<td>
				<input type='text' name='valor_aprox[]' maxlength='11' style='width: 60px' value='$valor_aprox' />
			</td>
			<td>
				<input type='text' name='valor_bodega[]' maxlength='11' style='width: 60px' value='$valor_bodega' />
			</td>";
						
			if($v_ap_d == 2){$est_check_d_si = 'checked';}
			if($v_ap_g == 2){$est_check_g_si = 'checked';}
			if($v_ap_b == 1){$est_check_b_si = 'checked';}
			
			if($v_ap_d == '1'){$est_check_d_no = 'checked';}
			if($v_ap_g == '1'){$est_check_g_no = 'checked';}
			if($v_ap_b == '2'){$est_check_b_no = 'checked';}

			
		echo"<input type='hidden' name='aux_ap_d[]' value='$v_ap_d' class='ocultas' /> 
			 <input type='hidden' name='aux_ap_g[]' value='$v_ap_g' class='ocultas' /> 
			 <input type='hidden' name='aux_ap_b[]' value='$v_ap_b' class='ocultas' />";
							
	   echo"<td>
				<input name='check_d_si[]' type='checkbox' id='check_d_si[]' style='background-color: #cccccc;' $est_check_d_si $dis_d onclick='val_check_em(this)'/>
			</td>
			<td>
				<input name='check_d_no[]' type='checkbox' id='check_d_no[]' style='background-color: #999999;' $est_check_d_no $dis_d onclick='val_check_em(this)'/>
			</td>
			<td>
				<input name='check_g_si[]' type='checkbox' id='check_g_si[]' style='background-color: #cccccc;' $est_check_g_si $dis_g onclick='val_check_em(this)'/>
			</td>
			<td>
				<input name='check_g_no[]' type='checkbox' id='check_g_no[]' style='background-color: #999999;' $est_check_g_no $dis_g onclick='val_check_em(this)'/>
			</td>
			<td>
				<input name='check_b_si[]' type='checkbox' id='check_b_si[]' style='background-color: #cccccc;' $est_check_b_si $dis_b onclick='val_check_em(this)'/>
			</td>
			<td>
				<input name='check_b_no[]' type='checkbox' id='check_b_no[]' style='background-color: #999999;' $est_check_b_no $dis_b onclick='val_check_em(this)'/>
			</td>
			<td>
				<input name='cant_b[]' type='text' style='width: 15px;height:16px;' value='$cant_b'/>
			</td>			
			<td>";
				echo"<input type='hidden' name='id[]' value='$v_id_det'/>
				<input name='recepciona' type='button' class='boton_recep' value='' onclick=\"abrirVentanaFijaSr('recepcion_fsr.php?vid=$v_id_det', 525, 276, 'ventana', 'Recepcion de productos')\"/>
			</td>
			<td>
				<input name='adquisiciones' type='button' class='boton_recep2' value='' onclick=\"abrirVentanaFijaSr('poput/oc_fsr.php?vid=$v_id_det', 330, 220, 'ventana', 'Orden de compra de productos')\"/>
			</td>	
			
			<td>
				<input name='factura' type='button' class='boton_factura' value='' onclick=\"abrirVentanaFijaSr('facturas_fsr.php?vid=$v_id_det&factura=$factura', 550, 276, 'ventana', 'Ingreso de facturas')\" />
			</td>
					  
			<td align='center'>";
				$tabla = "tb_det_sol";
				$dest  = "sol_rec.php";
			
				if($_SESSION['usd_sol_eli'] == 1)
				{ 
					echo"<a href='eliminar_item.php?id=$v_id_det&cod=$cod_inf&tabla=$tabla&dest=$dest' onclick='return confirmar(\"Esta Seguro de querer eliminar el registro seleccionado? \")'>
					<img src='imagenes/remove.png' border='0' valign='top' alt='Eliminar' />";
				} 
				echo"&nbsp;&nbsp;
			</td>
		</tr>";
}
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
<title>Solicitud de recursos</title>

<link href="inc/bibliocss.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="JavaScript" src="inc/funciones.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>

<!-- CALENDARIO -->
<LINK href="inc/epoch_styles.css" type=text/css rel=stylesheet>
<SCRIPT src="inc/epoch_classes.js" type=text/javascript></SCRIPT>

<!-- VENTANA MODAL -->
<script type="text/javascript" src="modal/js/ventana-modal-1.3.js"></script>
<script type="text/javascript" src="modal/js/abrir-ventana-variable.js"></script>
<script type="text/javascript" src="modal/js/abrir-ventana-fija.js"></script>
<script type="text/javascript" src="modal/js/abrir-ventana-fotos.js"></script>
<script type="text/javascript" src="modal/js/abrir-ventana-alertas.js"></script>
<script type="text/javascript" src="modal/js/abrir-ventana-cargando.js"></script>
<link href="modal/css/ventana-modal.css" rel="stylesheet" type="text/css">
<link href="modal/css/style.css" rel="stylesheet" type="text/css">
<!-- FIN VENTANA MODAL -->

<!-- AUTOCOMPLETE -->
<script type="text/javascript" src="autocomplete/jquery.js"></script>
<script type='text/javascript' src='autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="autocomplete/jquery.autocomplete.css" />
<!-- FIN AUTOCOMPLETE -->

<!-- AUTOCOMPLETE -->
<script type="text/javascript">
$().ready(function() {
	$("#cc_sol").autocomplete("autocomplete/get_cc_lista.php", {
		width: 380,
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
});
</script>
<!-- FIN AUTOCOMPLETE -->

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
        font: 13px Verdana, Arial, Helvetica, serif;
        border: #6D6D6D 1px solid;
        color: #000000;
        background-color: #FFFFFF;
        padding: 1px 3px 1px 3px;
    }
	
	.capa{height:200px; overflow:auto;}

    </style>

<script language="JavaScript" type="text/javascript">
/*****************************************************************************************************************
NOMBRE: 		
DESCRIPCION:	FUNCION PARA MOSTRAR EL CALENDARIO
PARAMETROS:		NO
AUTOR: 			SAN google	MODIFICADA Y ADAPTADA POR. PEDRO TRONCOSO
FECHA: 			2008
******************************************************************************************************************/
var dp_cal;
function fecha() {
	stime = new Date();

	dp_cal 	  = new Epoch('dp_cal','popup',document.getElementById('date_field'));
};

function enviar(url)
{
	document.f.action=url;
}

/*****************************************************************************************************************
NOMBRE: 		addFormLine(div, line, f);
DESCRIPCION:	FUNCION PARA CREAR FILAS DINAMICAMENTE
PARAMETRO:		
AUTOR: 			SAN google	MODIFICADA Y ADAPTADA POR. PEDRO TRONCOSO
FECHA: 			25/06/2010
******************************************************************************************************************/
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
/*****************************************************************************************************************
NOMBRE: 		removeFormLine(div);
DESCRIPCION:	FUNCION PARA ELIMINAR UNA LINEA DEL FORMULARIO
PARAMETROS:		string (div) El ID DEL DIV QUE SE QUIERE ELIMINAR
AUTOR: 			SAN google	MODIFICADA Y ADAPTADA POR. PEDRO TRONCOSO
FECHA: 			2009
******************************************************************************************************************/
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
/*******************************************************************************************************************
										FUNCIONES CONFIRM
********************************************************************************************************************/
function confirmar(msj, dest, boton)
{
	var apr_d			= document.f.aprobado_departamento.value;
	var apr_g			= document.f.aprobado_gerencia.value;
	var usuario			= document.f.usuario_nombre.value;
	var us_ing			= document.f.ingresada_por.value;
	var usd_sol_ap_dep	= document.f.usd_sol_ap_dep.value;
	var usd_sol_ap_ger	= document.f.usd_sol_ap_ger.value;
	var usd_sol_ap_bod	= document.f.usd_sol_ap_bod.value;
	
	if((apr_g == "" && (usd_sol_ap_dep == "1" || usd_sol_ap_ger == "1" )) || (apr_d == "" && us_ing == usuario) || (usd_sol_ap_bod == "1" && apr_g != ""))
	{
		if((usuario == us_ing || usd_sol_ap_dep == "1" || usd_sol_ap_ger == "1") || (usd_sol_ap_bod == "1" && apr_g != ""))
		{
			if(boton != "Eliminar" )
			{
				var agree=confirm(msj);
				if (agree){
					document.f.action=dest;
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

function Vista_Impresion_FSR()
{
	var cs = document.f.cod_sol.value;
	var us = document.f.usuario_nombre.value;
	
	if(cs != "")
	{
		abrirVentanaM("rep_fsr.php?cs="+cs+"&us="+us,"yes");
		
	}else{
		alerta('Error: Debe Ingresar Nº de Solicitud de recursos', '¡Atención!');
		document.f.cod_sol.value="";
		document.f.cod_sol.focus();
		return false;
	}
}

/*****************************************************************************************************************
NOMBRE:			creando();
DESCRIPCION: 	PARA PRUEBA DE REPORTES
FECHA: 			21/06/2010				
******************************************************************************************************************/
function creando()
{
	var cant 		= document.f.cant.value;
	var apr_g		= document.f.aprobado_gerencia.value;
	var desc_sol 	= document.getElementsByName("desc_sol[]");	
	var total   	= desc_sol.length -1;
	
	if(cant < 13)
	{
		if(total < 12)
		{
			if(apr_g == "")
			{
				if(cant > 1)
				{
					for(var x = 0; x < 11;++x)
					{
						addFormLine('myDiv', 'myLine');
					}
					document.f.cant.value = "";
				}else{
					addFormLine('myDiv', 'myLine');  
				}
			}else{
				error('No se pueden agregar Items, la solicitud ya se encuentra aprobada', '¡Error!');
			}
		}else{
			alerta('Ha completado el numero maximo de items permitidos por solicitud es (12)', '¡Atención!');
		}
	}else{
		alerta('Ha completado el numero maximo de items permitidos por solicitud es (12)', '¡Atención!');
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
	var combo1  		= document.f.combo1.value;
	var combo2  		= document.f.combo2.value;
	var combo3  		= document.f.combo3.value;
	var fe_en_obra  	= document.f.f3.value;
	var ods_sol  		= document.f.ods_sol.value;
	var cc_sol  		= document.f.cc_sol.value;
	var desc_sol 		= document.getElementsByName("desc_sol[]");	
	var und_med 		= document.getElementsByName("und_med[]");
	var cant_det 		= document.getElementsByName("cant_det[]");
	var valor_esp       = document.getElementsByName("valor_aprox[]");
	var total    		= desc_sol.length -1;
	
	if(ods_sol != "" || cc_sol != "")
	{	
		if(fe_en_obra != "" )
		{
			if(combo3 != "" && combo3 != "Seleccione..." )
			{
				for (x=0;x < total;x++)
				{
					if(desc_sol[x].value != "")
					{	
						if(und_med[x].value != "Seleccione..." )
						{
							if(cant_det[x].value != "")
							{
								if (valor_esp[x].value != "") 
								{
									if(document.f.Rorden[0].checked){
									
										if(x == total - 1)//PREGUNTAMOS SI ESTAMOS EN EL ULTIMO REGISTRO
										{
											var agree=confirm(msj);
											if (agree){
												document.f.action=dest; 
												return true ;
											}else{
												return false ;
											}
										}
									}else{
											
										if (document.f.Rorden[1].checked) {

											var agree=confirm("Esta seguro que desea ingresar la solicitud?");
											if (agree){
												document.f.action='sol_rec_sin.php'; 
												return true ;
											}else{
												return false ;
											}

										}else{
										alerta('Error: Debe seleccionar Si es Con Orden de Compra', '¡Atención!');
										return false ;
										}
									}
								}else{
									alerta('Error: Debe ingresar Valor', '¡Atención!');
									valor_esp[x].focus();
									return false ;
								}	
							}else{
								alerta('Error: Debe ingresar cantidad', '¡Atención!');
								cant_det[x].focus();
								return false ;
							}
						}else{
							alerta('Error: Debe ingresar unidad de medida', '¡Atención!');
							und_med[x].focus();
							return false ;
						}
					}else{
						alerta('Error: Debe ingresar descripcion del requerimiento', '¡Atención!');
						desc_sol[x].focus();
						return false ;
					}
						
				}// fin for(x)
			}else{
				alerta('Error: Debe seleccionar area a la cual pertenece la solicitud', '¡Atención!');
				document.f.combo3.focus();
				return false;
			}	
		}else{
			alerta('Error: Debe indicar la fecha para la cual requiere la solicitud', '¡Atención!');
			document.f.f3.focus();
			return false;
		}
	}else{
		alerta('Error: Debe ingresar ODS o Centro de costo de la solicitud', '¡Atención!');
		document.f.ods_sol.focus();
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

function validar_enter_linea(e) 
{
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13)
  {
  	document.f.inserta.focus();
  }
}

/*****************************************************************************************************************
NOMBRE: 		detecta_aprobacion();
DESCRIPCION:	FUNCION PARA DETECTAR QUIEN ESTA APROBANDO LA SOLICITUD)
AUTOR: 			PEDRO TRONCOSO	
FECHA: 			20/06/2012
******************************************************************************************************************/

function detecta_aprobacion()
{
	var check_d_si 	= document.getElementsByName("check_d_si[]");
	var check_g_si 	= document.getElementsByName("check_g_si[]");
	var check_b_si 	= document.getElementsByName("check_b_si[]");
	
	var aux_ap_d 	= document.getElementsByName("aux_ap_d[]");
	var aux_ap_g 	= document.getElementsByName("aux_ap_g[]");
	var aux_ap_b 	= document.getElementsByName("aux_ap_b[]");
	
	var usd_sol_ap_dep	= document.f.usd_sol_ap_dep.value;
	var usd_sol_ap_ger	= document.f.usd_sol_ap_ger.value;
	var usd_sol_ap_bod	= document.f.usd_sol_ap_bod.value;	
	
	var tipo_ap = "";
	
	if(usd_sol_ap_dep == '1' && check_d_si[0].disabled != true && aux_ap_d[0].value != 0)
	{
		tipo_ap = "Departamento";
	}
	
	if(usd_sol_ap_ger == 1 && check_g_si[0].disabled != true && aux_ap_g[0].value != 0)
	{
		tipo_ap = "Gerencia";
	}
	
	if(usd_sol_ap_bod == 1 && check_b_si[0].disabled != true && aux_ap_b[0].value != 0)
	{
		tipo_ap = "Bodega";
	}
	return tipo_ap;
}

/*****************************************************************************************************************
NOMBRE: 		validar_aprobacion();
DESCRIPCION:	FUNCION PARA VALIDAR LA APROBACION DE LA SOLICITUD DE RECURSOS (QUE LOS CAMPOS NO ESTEN EN BLANCO)
AUTOR: 			PEDRO TRONCOSO	
FECHA: 			25/06/2010
******************************************************************************************************************/
function validar_aprobacion()
{
	var tipo_ap	    = detecta_aprobacion();
	var cod_sol		= document.f.cod_sol.value;
	var cant 	  	= document.getElementsByName("cant_b[]");
	var valor_bod   = document.getElementsByName("valor_bodega[]");
	var total       = valor_bod.length -1;
	
	if(tipo_ap != "")
	{
		document.f.tipo_ap.value = tipo_ap;
		
		if(cod_sol != "")
		{		
			var cc_sol			= document.f.cc_sol.value;
			var apr_d			= document.f.aprobado_departamento.value;
			var apr_g			= document.f.aprobado_gerencia.value;
			var apr_b			= document.f.aprobado_bodega.value;
			var si              = document.getElementsByName("check_b_si[]");
		
			if(tipo_ap == "Departamento")
			{
				if(apr_g == "")
				{
					var agree=confirm("Esta Seguro De Querer Validar La Solicitud De Recursos ?");
					if (agree){
						document.f.action='sol_rec_p.php';
						return true ;
					}else{
						return false ;
					}
				}else{
					error('La solicitud de recursos ya se encuentra aprobada por gerencia', '¡Error!');
					return false ;
				}	
			}
			
			if(tipo_ap == "Gerencia")
			{
				if(apr_g == "")
				{
					if(cc_sol != "")
					{
						var agree=confirm("Esta Seguro De Querer Validar La Solicitud De Recursos ?");
						if (agree){
							document.f.action='sol_rec_p.php';
							return true ;
						}else{
							return false ;
						}
					}else{
						alerta('Error: Debe Ingresar centro de costo', '¡Atención!');
						document.f.cc_sol.focus();
						return false ;
					}
					
				}else{
					error('La solicitud de recursos ya se encuentra aprobada por gerencia', '¡Error!');
					return false ;
				}	
			}
			
			if(tipo_ap == "Bodega")
			{
				if(apr_g != "")
				{
					for (i = 0; i < total; i++) {
						
						if (si[i].checked) {
							
							if(cant[i].value != "0" ){
								
								if(valor_bod[i].value != "0"){
									
									if (i == total -1) {
										var agree=confirm("Esta Seguro De Querer Validar La Solicitud De Recursos ?");
										if (agree){
											document.f.action='sol_rec_p.php';
											return true ;
										}else{
											return false ;
										}
									}
								}else{
									error('Debe Ingresar el Valor', '¡Error!');
									valor_bod[i].focus();
									return false ;
								}		
							}else{
								error('Debe Ingresar la Cantidad', '¡Error!');
								cant[i].focus();
								return false ;
							}
						}else{

							var agree=confirm("Esta Seguro De Querer Validar La Solicitud De Recursos ?");
							if (agree){
								document.f.action='sol_rec_p.php';
								return true ;
							}else{
								return false ;
							}
							
						}	
					}//FIN FOR		
				}else{
					error('La solicitud de recursos aun no se encuentra aprobada por gerencia', '¡Error!');
					return false ;
				}	
			}
		}else{
			alerta('Error: Debe Ingresar Nº de solicitud', '¡Atención!');
			return false ;
		}	
	}else{
		alerta('Error: Debe aprobar o rechazar todos los items', '¡Atención!');
		return false ;
	}
		
}



function validar_desaprobacion()
{

	var agree=confirm("Esta Seguro De Querer Desvalidar La Solicitud De Recursos ?");
	if (agree){
		document.f.action='sol_rec_p.php';
		return true ;
	}else{
		return false ;
	}

}


/*****************************************************************************************************************
NOMBRE: 		seleccionar_todo_si_d();
DESCRIPCION:	FUNCION PARA SELECCIONAR TODOS LOS CHECK (APROBACION Departamento)
AUTOR: 			PEDRO TRONCOSO	
FECHA: 			25/06/2010
******************************************************************************************************************/
function seleccionar_todo_si_d()
{
	var check_d_si 	= document.getElementsByName("check_d_si[]");
	var check_d_no 	= document.getElementsByName("check_d_no[]");
	var cant_det	= document.getElementsByName("cant_det[]");
	var aux_ap_d 	= document.getElementsByName("aux_ap_d[]");
	var totala  	= cant_det.length;
	
  	for (i=0;i < totala;i++)
	{
		check_d_si[i].checked 	= 1; 
		check_d_no[i].checked 	= 0; 
		aux_ap_d[i].value 	= '2';
		
	}
}
/*****************************************************************************************************************
NOMBRE: 		seleccionar_todo_no_d();
DESCRIPCION:	FUNCION PARA SELECCIONAR TODOS LOS CHECK (APROBACION Departamento)
AUTOR: 			PEDRO TRONCOSO	
FECHA: 			25/06/2010
******************************************************************************************************************/
function seleccionar_todo_no_d()
{
	var check_d_no 	= document.getElementsByName("check_d_no[]");
	var check_d_si 	= document.getElementsByName("check_d_si[]");
	var cant_det	= document.getElementsByName("cant_det[]");
	var aux_ap_d 	= document.getElementsByName("aux_ap_d[]");
	var totala  	= cant_det.length;
	
  	for (i=0;i < totala;i++)
	{
		check_d_no[i].checked 	= 1; 
		check_d_si[i].checked 	= 0; 
		aux_ap_d[i].value 	= '1';
		
	}
}
/*****************************************************************************************************************
NOMBRE: 		deseleccionar_todo_si_d();
DESCRIPCION:	FUNCION PARA DESELECCIONAR TODOS LOS CHECK (APROBACION Departamento)
AUTOR: 			PEDRO TRONCOSO	
FECHA: 			25/06/2010
******************************************************************************************************************/
function deseleccionar_todo_si_d()
{
	var check_d_si 	= document.getElementsByName("check_d_si[]");
	var cant_det	= document.getElementsByName("cant_det[]");
	var aux_ap_d 	= document.getElementsByName("aux_ap_d[]");
	var totala  	= cant_det.length;
	
  	for (i=0;i < totala;i++)
	{
		check_d_si[i].checked 	= 0; 
		aux_ap_d[i].value 		= '0';
	}
}
/*****************************************************************************************************************
NOMBRE: 		deseleccionar_todo_no_g();
DESCRIPCION:	FUNCION PARA DESELECCIONAR TODOS LOS CHECK (APROBACION Departamento)
AUTOR: 			PEDRO TRONCOSO	
FECHA: 			25/06/2010
******************************************************************************************************************/
function deseleccionar_todo_no_d()
{
	var check_d_no 	= document.getElementsByName("check_d_no[]");
	var cant_det	= document.getElementsByName("cant_det[]");
	var aux_ap_d 	= document.getElementsByName("aux_ap_d[]");
	var totala  	= cant_det.length;
	
  	for (i=0;i < totala;i++)
	{
		check_d_no[i].checked 	= 0; 
		aux_ap_d[i].value 		= '0';
	}
}
/*****************************************************************************************************************
NOMBRE: 		seleccionar_todo_si_g();
DESCRIPCION:	FUNCION PARA SELECCIONAR TODOS LOS CHECK (APROBACION GERENCIA)
AUTOR: 			PEDRO TRONCOSO	
FECHA: 			25/06/2010
******************************************************************************************************************/
function seleccionar_todo_si_g()
{
	var check_g_si 	= document.getElementsByName("check_g_si[]");
	var check_g_no 	= document.getElementsByName("check_g_no[]");
	var cant_det	= document.getElementsByName("cant_det[]");
	var aux_ap_g 	= document.getElementsByName("aux_ap_g[]");
	var totala  	= cant_det.length;
	
  	for (i=0;i < totala;i++)
	{
		check_g_si[i].checked 	= 1; 
		check_g_no[i].checked 	= 0; 
		aux_ap_g[i].value 	    = '2';
	}
}
/*****************************************************************************************************************
NOMBRE: 		seleccionar_todo_no_g();
DESCRIPCION:	FUNCION PARA SELECCIONAR TODOS LOS CHECK (APROBACION GERENCIA)
AUTOR: 			PEDRO TRONCOSO	
FECHA: 			25/06/2010
******************************************************************************************************************/
function seleccionar_todo_no_g()
{
	var check_g_no 	= document.getElementsByName("check_g_no[]");
	var check_g_si 	= document.getElementsByName("check_g_si[]");
	var cant_det	= document.getElementsByName("cant_det[]");
	var aux_ap_g 	= document.getElementsByName("aux_ap_g[]");
	var totala  	= cant_det.length;
	
  	for (i=0;i < totala;i++)
	{
		check_g_no[i].checked 	= 1; 
		check_g_si[i].checked 	= 0; 
		aux_ap_g[i].value 	= '1';
	}
}
/*****************************************************************************************************************
NOMBRE: 		deseleccionar_todo_si_g();
DESCRIPCION:	FUNCION PARA DESELECCIONAR TODOS LOS CHECK (APROBACION GERENCIA)
AUTOR: 			PEDRO TRONCOSO	
FECHA: 			25/06/2010
******************************************************************************************************************/
function deseleccionar_todo_si_g()
{
	var check_g_si 	= document.getElementsByName("check_g_si[]");
	var cant_det	= document.getElementsByName("cant_det[]");
	var aux_ap_g 	= document.getElementsByName("aux_ap_g[]");
	var totala  	= cant_det.length;
	
  	for (i=0;i < totala;i++)
	{
		check_g_si[i].checked 	= 0; 
		aux_ap_g[i].value 	= '0';
	}
}
/*****************************************************************************************************************
NOMBRE: 		deseleccionar_todo_no_g();
DESCRIPCION:	FUNCION PARA DESELECCIONAR TODOS LOS CHECK (APROBACION GERENCIA)
AUTOR: 			PEDRO TRONCOSO	
FECHA: 			25/06/2010
******************************************************************************************************************/
function deseleccionar_todo_no_g()
{
	var check_g_no 	= document.getElementsByName("check_g_no[]");
	var cant_det	= document.getElementsByName("cant_det[]");
	var aux_ap_g 	= document.getElementsByName("aux_ap_g[]");
	var totala  	= cant_det.length;
	
  	for (i=0;i < totala;i++)
	{
		check_g_no[i].checked 	= 0; 
		aux_ap_g[i].value 	= '0';
	}
}
/*****************************************************************************************************************
NOMBRE: 		seleccionar_todo_si_b();
DESCRIPCION:	FUNCION PARA SELECCIONAR TODOS LOS CHECK (APROBACION GERENCIA)
AUTOR: 			PEDRO TRONCOSO	
FECHA: 			25/06/2010
******************************************************************************************************************/
function seleccionar_todo_si_b()
{
	var check_b_si	= document.getElementsByName("check_b_si[]");
	var check_b_no	= document.getElementsByName("check_b_no[]");
	var cant_det	= document.getElementsByName("cant_det[]");
	var aux_ap_b 	= document.getElementsByName("aux_ap_b[]");
	var totala  	= cant_det.length;
	
  	for (i=0;i < totala;i++)
	{
		check_b_si[i].checked 	= 1; 
		check_b_no[i].checked 	= 0; 
		aux_ap_b[i].value 	= '2';
	}
}
/*****************************************************************************************************************
NOMBRE: 		seleccionar_todo_no_b();
DESCRIPCION:	FUNCION PARA SELECCIONAR TODOS LOS CHECK (APROBACION GERENCIA)
AUTOR: 			PEDRO TRONCOSO	
FECHA: 			25/06/2010
******************************************************************************************************************/
function seleccionar_todo_no_b()
{
	var check_b_no	= document.getElementsByName("check_b_no[]");
	var check_b_si	= document.getElementsByName("check_b_si[]");
	var cant_det	= document.getElementsByName("cant_det[]");
	var aux_ap_b 	= document.getElementsByName("aux_ap_b[]");
	var totala  	= cant_det.length;
	
  	for (i=0;i < totala;i++)
	{
		check_b_no[i].checked 	= 1; 
		check_b_si[i].checked 	= 0; 
		aux_ap_b[i].value 	= '2';
	}
}
/*****************************************************************************************************************
NOMBRE: 		deseleccionar_todo_si_b();
DESCRIPCION:	FUNCION PARA DESELECCIONAR TODOS LOS CHECK (REVISION BODEGA)
AUTOR: 			PEDRO TRONCOSO	
FECHA: 			25/06/2010
******************************************************************************************************************/
function deseleccionar_todo_si_b()
{
	var check_b_si 	= document.getElementsByName("check_b_si[]");
	var cant_det	= document.getElementsByName("cant_det[]");
	var aux_ap_b 	= document.getElementsByName("aux_ap_b[]");
	var totala  	= cant_det.length;
	
  	for (i=0;i < totala;i++)
	{
		check_b_si[i].checked 	= 0; 
		aux_ap_b[i].value 	= '0';
	}
}
/*****************************************************************************************************************
NOMBRE: 		deseleccionar_todo_no_b();
DESCRIPCION:	FUNCION PARA DESELECCIONAR TODOS LOS CHECK (REVISION BODEGA)
AUTOR: 			PEDRO TRONCOSO	
FECHA: 			25/06/2010
******************************************************************************************************************/
function deseleccionar_todo_no_b()
{
	var check_b_no 	= document.getElementsByName("check_b_no[]");
	var cant_det	= document.getElementsByName("cant_det[]");
	var aux_ap_b 	= document.getElementsByName("aux_ap_b[]");
	var totala  	= cant_det.length;
	
  	for (i=0;i < totala;i++)
	{
		check_b_no[i].checked 	= 0; 
		aux_ap_b[i].value 	= '0';
	}
}

function val_check_em(elemento)
{
	var check_d_si 	= document.getElementsByName("check_d_si[]");
	var check_d_no 	= document.getElementsByName("check_d_no[]");
	
	var check_g_si 	= document.getElementsByName("check_g_si[]");
	var check_g_no 	= document.getElementsByName("check_g_no[]");
	
	var check_b_si 	= document.getElementsByName("check_b_si[]");
	var check_b_no 	= document.getElementsByName("check_b_no[]");
	
	var aux_ap_d 	= document.getElementsByName("aux_ap_d[]");
	var aux_ap_g 	= document.getElementsByName("aux_ap_g[]");
	var aux_ap_b 	= document.getElementsByName("aux_ap_b[]");
	
	var t = aux_ap_d.length;
   	for(var x = 0; x < t; ++x)
   	{
		// CHECK DEPARTAMENTO
		if(elemento == check_d_si[x]) 
	 	{
			if(elemento.checked == true) 
			{
				check_d_no[x].checked = false;
				aux_ap_d[x].value = '2';
			}else{
				check_d_no[x].checked = false;
				aux_ap_d[x].value = '0';
			}
		}
		
		if(elemento == check_d_no[x]) 
	 	{
			if(elemento.checked == true) 
			{
				check_d_si[x].checked = false;
				aux_ap_d[x].value = '1';
			}else{
				check_d_si[x].checked = false;
				aux_ap_d[x].value = '0';
			}
		}
		
		if(elemento == check_g_si[x]) 
	 	{
			if(elemento.checked == true) 
			{
				check_g_no[x].checked = false;
				aux_ap_g[x].value = '2';
			}else{
				check_g_no[x].checked = false;
				aux_ap_g[x].value = '0';
			}
		}
		if(elemento == check_g_no[x]) 
	 	{
			if(elemento.checked == true) 
			{
				check_g_si[x].checked = false;
				aux_ap_g[x].value = '1';
			}else{
				check_g_si[x].checked = false;
				aux_ap_g[x].value = '0';
			}
		}
		if(elemento == check_b_si[x]) 
	 	{
			if(elemento.checked == true) 
			{
				check_b_no[x].checked = false;
				aux_ap_b[x].value = '1';
			}else{
				check_b_no[x].checked = false;
				aux_ap_b[x].value = '0';
			}
		}
		if(elemento == check_b_no[x]) 
	 	{
			if(elemento.checked == true) 
			{
				check_b_si[x].checked = false;
				aux_ap_b[x].value = '2';
			}else{
				check_b_si[x].checked = false;
				aux_ap_b[x].value = '0';
			}
		}
	}
}

function buscar()
{
	abrirVentanac('buscar_fsr.php', '700', '500','yes');	
}

function crear_linea()
{
	addFormLine('myDiv', 'myLine');
}

// CARGA LA CONSULTA DEL CRITERIO DE BUSQUEDA
function carga_consulta_busca()
{
	cons=document.f.consulta.value;
	document.f.action='lista_fsr.php?consulta='+cons;
	document.f.submit();
	VentanaModal.cerrar();
}

/* COMIENZAN FUNCIONES PARA COMBOS ANIDADOS */
/********************************************/
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
				$.post("combo2.php", { elegido: elegido }, function(data){
				$("#combo3").html(data);
			});			
        });
   })
});
/* TERMINAN FUNCIONES PARA COMBOS ANIDADOS */
/********************************************/
</script>

<style type="text/css">
body {
	font-family: Helvetica;
	background-image: url();
	font-size: 11px;
	color: #000;
	background-color: <? echo $ColorFondo; ?>;
}

.Estilo8 {color: #FF0000}
.Estilo9 {color: #000000}

</style>

</head>
<body onload="fecha();<?php if($_POST['busca'] != "Buscar" and $_POST['ingresa'] == "" and $_POST['modifica'] == "" and $_POST['aprueba'] == "" and $_GET['cod'] == "" and $_POST['elimina_item'] == ""){
	echo'creando()';
	}
	?>">
			  
<?php
/***********************************************************************************************************
								BUSCAMOS LA SOLICITUD DEPENDIENDO EL FILTRO
************************************************************************************************************/
if($_POST['busca'] == "Buscar")
{	
	$query = "SELECT * FROM tb_sol_rec WHERE cod_sol = '".$_POST['cod_sol']."' ";
}
if($_POST['ingresa'] != "")
{
	$query = "SELECT * FROM tb_sol_rec WHERE cod_sol = '".$_POST['ingresa']."' ";
}
if($_POST['modifica'] != "")
{
	$query = "SELECT * FROM tb_sol_rec WHERE cod_sol='".$_POST['modifica']."' ";
}
if($_POST['aprueba'] != "")
{
	if($_POST['detecta_modal_p'] != "")
	{
		echo "<script type='text/javascript' language='Javascript'>
			parent.cerrar_ventana_modal();
		</script>";
	}
	$query = "SELECT * FROM tb_sol_rec WHERE cod_sol='".$_POST['aprueba']."' ";
}
if($_GET['cod'] != "")
{
	$query = "SELECT * FROM tb_sol_rec WHERE cod_sol='".$_GET['cod']."' ";
}

if($_POST['elimina_item'] != "")
{
	$query = "SELECT * FROM tb_sol_rec WHERE cod_sol='".$_POST['elimina_item']."' ";
}

if($_POST['busca'] == "Buscar" or $_POST['ingresa'] != "" or $_POST['modifica'] != "" or $_POST['elimina_item'] != "" or $_POST['aprueba'] != "" or $_GET['cod'] != "" )
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
			$cod_sol 		= "".$vrows['cod_sol']."";
			$ods_sol 		= "".$vrows['ods_sol']."";
			$cc_sol 		= "".$vrows['cc_sol']."";
			$empr_sol 		= "".$vrows['empr_sol']."";
			$valor_a 		= "".$vrows['area_sol']."";
			$fe_sol			= "".$vrows['fe_sol']."";
			$hr_ing_sol		= "".$vrows['hr_ing_sol']."";
			$hr_apb_sol		= "".$vrows['hr_apb_sol']."";
			$fe_aprob_g		= "".$vrows['fe_aprob_g']."";
			$fe_en_obra		= "".$vrows['fe_en_obra']."";
			$aprob_ger		= "".$vrows['aprob_ger']."";
			$aprob_dpto		= "".$vrows['aprob_dpto']."";
			$aprob_bod		= "".$vrows['aprob_bod']."";
			$prof_sol		= "".$vrows['prof_sol']."";
			$orden 			= "".$vrows['orden']."";
			$regu 			= "".$vrows['regularizasion']."";
			
			$sql_a 		= "SELECT * FROM tb_areas WHERE cod_ar = '$valor_a' ";
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
<table width="1010" height="367" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
  <tr bgcolor="#FFFFFF">
    <td width="100" height="54" align="center" valign="top"><img src="imagenes/logo2.jpg" width="127" height="60" /></td>
    <td width="810" align="center" valign="middle" class="txt01"><img src="imagenes/Titulos/Solicitud de recursos.png" width="500" height="47" /></td>
    <td width="100" align="right" valign="top"><img src="imagenes/logo_iso_c.jpg" width="100" height="52" /></td>
  </tr>
  
  <tr>
    <td height="309" colspan="3" align="center" valign="top">
    <form action="sol_rec.php" method="post" name="f" id="f">
    <table width="1008" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="1003" align="center">
        
        <table width="1006" height="45" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor=<?php echo $ColorMotivo; ?> >
          <tr>
            <td width="970" align="right">
            
            <table width="990" height="67" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="91" height="67" align="right"><input name="button8" type="submit" class="boton_inicio" id="button8" value="Inicio" onclick="enviar('index2.php', 'f')" /></td>
                  <td width="100" align="center">
                  
                  <input name="button3" type="button" class="boton_pdf" id="button9" value="Manual Usuario" onclick="alert('En Proceso...');" />
                  
                  </td>
                  <td width="287" align="center">
                  <input type="hidden" name="consulta" id="consulta" class="ocultas" />
                  <?php 
				  	if($_SESSION['usuario_rut'] == "13808479-5"){
                  		echo"<input name='des_aprueba' type='submit' class='boton_disponible' id='des_aprueba' value='Desaprobar' onclick='return validar_desaprobacion()'/>";
					}
				  ?></td>
                  <td width="105" align="right"><label>
                    <?php 
				  	if($_SESSION['usd_sol_ap_dep'] == "1" or $_SESSION['usd_sol_ap_ger'] == "1" or $_SESSION['usd_sol_ap_bod'] == "1"){
                  		echo"<input name='aprueba' type='submit' class='boton_aprob' id='aprueba' value='Aprobar' onclick='return validar_aprobacion()'/>";
					}
				  ?>
                  </label></td>
                  <td width="100" align="right"><input name="button2" type="submit" class="boton_lista_alert" id="button7" value="List. Sin Aprob." onclick="enviar('lista_fsr_sap.php')" /></td>
                  <td width="80" align="center"><input name="aprueba2" type="button" class="boton_buscar_fsr" id="aprueba2" value="Buscar fsr" onclick="abrirVentanaFijaSr('buscar_fsr.php', 724, 400, 'ventana', 'Buscar solicitud')"/></td>
                  <td width="110" align="center"><input name="button" type="submit" class="boton_lista2" id="button" value="Historial FSR" onclick="enviar('lista_fsr.php')" /></td>
                  <td width="100" align="right"><input name="button4" type="button" class="boton_print" id="button2" value="Vista impresion" onclick="Vista_Impresion_FSR()" /></td>
                  <td width="17" align="right">
                  <input type="hidden" name="usuario_nombre" id="usuario_nombre" value="<?php echo $_SESSION['usuario_nombre']; ?>" />
                  <input type="hidden" name="usd_sol_ap_dep" id="usd_sol_ap_dep" class="ocultas" value="<?php echo $_SESSION['usd_sol_ap_dep']; ?>"/> 
                  <input type="hidden" name="usd_sol_ap_ger" id="usd_sol_ap_ger" class="ocultas" value="<?php echo $_SESSION['usd_sol_ap_ger']; ?>"/> 
                  <input type="hidden" name="usd_sol_ap_bod" id="usd_sol_ap_bod" class="ocultas" value="<?php echo $_SESSION['usd_sol_ap_bod']; ?>"/> 
                  <input type="hidden" name="usd_sol_us_adq" id="usd_sol_us_adq" class="ocultas" value="<?php echo $_SESSION['usd_sol_us_adq']; ?>"/>
                  <input type="hidden" name="usd_sol_us_bod" id="usd_sol_us_bod" class="ocultas" value="<?php echo $_SESSION['usd_sol_us_bod']; ?>"/>
                  <input type="hidden" name="tipo_ap" id="tipo_ap" class="ocultas" value=""/>               
                  </td>
                </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center"><table width="1006" height="230" border="0">
          <tr>
            <td width="992" height="224" align="center" valign="top">
                <table width="992" height="202" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="992" height="39" align="center" valign="top">
                    
                    <fieldset class="txtnormalB">
                    <legend class="txtnormaln">FSR</legend>
                    <table width="986" border="0" cellpadding="0" cellspacing="0" class="txtnormal7">
                      <tr>
                        <td width="181" rowspan="2" align="left">Nº DE SOLICITUD (automatico)
                          <?php 
						if($_POST['limpia'] == "Limpiar"){$cod_sol = "";} ?>
                          <input name="cod_sol" type="text" id="cod_sol" size="6" style="width:60px;height:17px;" value="<? echo $cod_sol ?>" onkeypress="validar_enter_cod(event)" />
                          <input name="busca" type="submit" class="boton_bus" id="busca" value="Buscar"/></td>
                        <td width="34" rowspan="2" align="left">&nbsp;</td>
                        <td colspan="2" rowspan="2" align="left"><?php
						if($_POST['busca'] == "Buscar" and $cod_sol != "" or $_POST['ingresa'] != "" or $_POST['modifica'] != "" or $_POST['aprueba'] != "" or $_GET['cod'] != ""){
						?>
						<table width="427" border="0" cellspacing="0" cellpadding="0">
						  <tr>
                              <td width="116" height="44"><span class="content">FECHA INGRESO:
                                <?php 
							
							if($cod_sol != "")
							{
								$fe_sol = $fe_sol;
							}else{
								$fe_sol 	= "";
								$hr_ing_sol = "";
							}
							
							if($_POST['limpia'] == "Limpiar"){$_POST['combo2'] = "";}
						?>
                                <input name="f1" id="date_field5" style="WIDTH: 6em" disabled="disabled" value="<? echo $fe_sol; ?>" />
                                </span></td>
                              <td width="108" align="center"><span class="content">HORA INGRESO:
                                <input name="date_field6" id="date_field6" style="WIDTH: 6em" disabled="disabled" value="<? echo $hr_ing_sol; ?>" />
                                </span></td>
                              <td width="101" align="center">FECHA APROBACION
                                <?php 
							
							
							?>
                                <input type="text" name="f2" style="WIDTH: 6em" id="f2" disabled="disabled" value="<? echo $fe_aprob_g; ?>" /></td>
                              <td width="102" align="center"><span class="content">HORA APROBACION
                                  <input name="date_field" id="date_field2" style="WIDTH: 6em" disabled="disabled" value="<? echo $hr_apb_sol; ?>" />
                                </span></td>
                              </tr>
                        </table>
                          <?php
						}
						?></td>
                        <td width="116" height="25" align="left" valign="bottom">ODS </td>
                        <td width="129" align="left" valign="bottom">FECHA EN OBRA</td>
                      </tr>
                      <tr>
                        <td align="left">
                        
                        <input name="ods_sol" type="text" id="ods_sol" size="8" value="<? echo $ods_sol; ?>"/>
                        
                        </td>
                        <td width="129" align="left"><span class="content Estilo8">
                          <input id="date_field" style="WIDTH: 7em" name="f3" value="<? echo $fe_en_obra; ?>" />
                          <input type="button" class="botoncal" onclick="dp_cal.toggle();" />
                        </span></td>
                      </tr>
                      <tr>
                      	<td algin="left" colspan="6">REGULARIZACI&Oacute;N<input type="radio" name="regu" value="1" <?php if($regu == "1"){?> checked <?php }else{} ?>><span style="color:#ff0000;">(ESTO ES DE USO EXCLUSIVO PARA ESTE PROCEDIMIENTO)</span></td>
                       </tr>
                        <tr>
                        	<td colspan="6" align="left">&nbsp;</td>
                        </tr>
                      <tr>
                        <td colspan="2" align="left">GERENCIA</td>
                        <td width="214" align="left">DEPARTAMENTO</td>
                        <td width="312" align="left">AREA</td>
                        <td width="116" align="left">CENTRO DE  COSTO</td>
                        <td align="left">CONTROL DE EXISTENCIA</td>
                      </tr>
                      <tr class="txtnormal7">
                        <td colspan="2" align="left" valign="middle">
                        
                          <select name="combo1" class="combos" id="combo1" style="width: 204px;" >
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
                          <select name="combo2" class="combos" id="combo2" style="width: 204px;" >
                            <?php echo"<option selected='selected' value='$cod_dep'>$desc_dep</option>"; ?>
                          </select>
                        </td>
                        
                        <td align="left" valign="middle">
                          <select name="combo3" class="combos" id="combo3" style="width: 300px;">
                            <?php echo"<option selected='selected' value='$cod_ar'>$area_t</option>"; ?>
                          </select> 
                        </td>
                        
                        <td align="left" valign="middle">
                        <!-- <input name="cc_sol" type="text" id="cc_sol" value="<? echo $cc_sol; ?>" size="8" maxlength="8"/>-->
                         <input name="cc_sol" type="text" id="cc_sol" value="<? echo $cc_sol; ?>" size="8" maxlength="8" onkeyup="this.value=formateaccosto(this.value)" onblur="this.value=formateaccosto(this.value)" /> 
                        <span class="Estilo9">
                        <input name="agregar" type="button" class="otro" id="agregar" value="  " onclick="abrirVentanaFijaSr('lista_ccosto.php', 760, 600, 'ventana', 'Centros de costo MG&amp;T')" />
                        </span></td>
                        <td align="left" valign="middle">
                        	<input type="radio" name="Rorden" id="Rorden" <?php if($orden == "1"){?> checked <?php } ?> value="1">SI
                        	<input type="radio" name="Rorden" id="Rorden" <?php if($orden == "2"){?> checked <?php } ?> value="2">NO
                    	</td>
                      </tr>
                      <tr>
                        <td colspan="2">&nbsp;</td>
                        <td><label>
                        </label></td>
                        <td>&nbsp;</td>
                        <td colspan="2"><label>
                          
                        </label></td>
                      </tr>
                    </table>
                    </fieldset>
                    </td>
                  </tr>
                 
                  <tr>
                    <td height="123" align="center" valign="top">
                   
                    <fieldset class="txtnormalB">
                    <legend class="txtnormaln">Detalle Solicitud</legend>
                    
                    <table width="975" height="106" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="287" height="26" align="left" valign="bottom" class="txtnormal8">&nbsp;
                            <label>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CANT = 
                            <input name="cant" type="text" id="cant" size="2" onkeypress="validar_enter_linea(event)" />
                            </label>
                            <input name="inserta" type="button" class="boton_nue2" id="inserta" onclick="creando()" value="Insertar  linea" /></td>
                          <td width="693" align="left" valign="bottom" class="txtnormal8 Estilo8">MAXIMO 12 ITEMS POR SOLICITUD</td>
                        </tr>
                        <tr>
                          <td height="21" colspan="2" align="center"><table width="970" border="0" class="txtnormal">
                          	  
                              <tr bgcolor="#cedee1">
                                <td width="330" height="21" rowspan="2" bgcolor="#cedee1">Descripcion de la solicitud</td>
                                <td width="109" rowspan="2" bgcolor="#cedee1">Und de medida</td>
                                <td width="46" rowspan="2" bgcolor="#cedee1">Cant.</td>
                                <td width="81" rowspan="2" bgcolor="#cedee1"><p align="center">Valor Neto</p></td>
               					<td width="81" rowspan="2" bgcolor="#cedee1"><p align="center">Total Bod.</p></td>
               					<td width="81" rowspan="2" bgcolor="#cedee1"><p align="center">Total Ger.</p></td>
                                <td colspan="2" align="center" bgcolor="#cedee1">Dpto.</td>
                                <td colspan="2" align="center" bgcolor="#cedee1">G.Op</td>
                                <td colspan="3" align="center" bgcolor="#cedee1">Existencia</td>
                                <td align="center" bgcolor="#cedee1">&nbsp;</td>
                                <td width="23">&nbsp;</td>
                                <td width="32">&nbsp;</td>
                                <td width="28" rowspan="2" bgcolor="#F4F4F4">&nbsp;</td>
                              </tr>
                              <tr bgcolor="#cedee1">
                                <td width="17">SI</td>
                                <td width="18">NO</td>
                                <td width="17">SI</td>
                                <td width="18">NO</td>
                                <td width="13">SI</td>
                                <td width="18">NO</td>
                                <td width="32">Cant</td>
                                <td width="27">Rec</td>
                                <td width="23" align="center">OC</td>
                                <td width="32" align="center">FACT</td>
                              </tr>
                              
<?php  
/*********************************************************************************************************************************
								verificamos los permisos
*********************************************************************************************************************************/	
if ($_SESSION['usd_sol_ap_dep'] != "1"){
	$dis_d 	= "disabled";
	$col_p 	= "background-color: '#CCCCCC'";
} 
if ($_SESSION['usd_sol_ap_ger'] != "1"){
	$dis_g 	= "disabled='disabled'";
	$col_g 	= "background-color: #CCCCCC;";
}
if ($_SESSION['usd_sol_ap_bod'] != "1"){
	$dis_b 	= "disabled='disabled'";
	$col_b 	= "background-color: #CCCCCC;";
}
/*********************************************************************************************************************************
								FIN
*********************************************************************************************************************************/	


/*********************************************************************************************************************************
								CONSULTAMOS LOS ITEMS
*********************************************************************************************************************************/	

if($_POST['busca'] == "Buscar" or $_POST['ingresa'] != "" or $_POST['modifica'] != "" or $_POST['elimina_item'] != "" or $_POST['aprueba'] != "" or $_GET['cod'] != "")
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	if($cont != 0)
	{
		$sql 	= "SELECT * FROM tb_det_sol WHERE cod_sol = '$cod_sol' ORDER BY id_det";
		$resd	= mysql_query($sql,$co);
		
		while($vrows2=mysql_fetch_array($resd)){
			$items[] = $vrows2;
		}
		
		$f=0;
		$total_det = count($items);
		$filaexcel = 6;
		
		while($f < $total_det)
		{	
			$id_det			= $items[$f]['id_det'];
			$desc_sol		= $items[$f]['desc_sol'];
			$cant_det		= $items[$f]['cant_det'];
			$und_med		= $items[$f]['und_med'];
			$valor_aprox    = $items[$f]['valor_aprox'];
			$valor_bodega   = $items[$f]['valor_bodega'];
			$det_ap_d		= $items[$f]['det_ap_d'];
			$det_ap_g		= $items[$f]['det_ap_g'];
			$det_ap_b		= $items[$f]['det_ap_b'];
			$cant_b		    = $items[$f]['cant_b'];
			$rec_det		= $items[$f]['rec_det'];
			$factura		= $items[$f]['factura'];
			
			$co=mysql_connect("$DNS","$USR","$PASS");
			mysql_select_db("$BDATOS", $co);
			
			$sql_um	= "SELECT * FROM tb_und_med WHERE cod_um = '$und_med' ";
			$res_um	= mysql_query($sql_um,$co);
			while($vrows_um = mysql_fetch_array($res_um))
			{
				$cod_um 	= $vrows_um['cod_um'];
				$nom_um 	= $vrows_um['nom_um'];
			}	
			if($det_ap_d == 1 or $det_ap_d == 2){$dis_d = "disabled";}
			if($det_ap_g == 1 or $det_ap_g == 2){$dis_g = "disabled";}
			if($det_ap_b == 1 or $det_ap_b == 2){$dis_b = "disabled";}
			
			CreaFilaB($cod_sol, $id_det, $desc_sol, $cant_det,$valor_aprox,$valor_bodega, $cod_um, $nom_um, $det_ap_d, $det_ap_g, $det_ap_b, $rec_det, $dis_d, $col_p, $dis_g, $col_g, $dis_b, $col_b, $dis_recepcion, $cant_b, $factura);
			
		$f++;
		}
	}else{
		//echo"<script language='Javascript'>";
          	//alert('No Se Encontraron Registros de la fecha y area seleccionada');
			//echo"document.f10.submit();
        /*echo"</script>";*/
	}
}	
/*********************************************************************************************************************************
								verificamos los permisos
*********************************************************************************************************************************/	
	echo"<tr bgcolor='#cedee1' bordercolor='#cedee1' class='txtnormal7'>
			<td align='center' colspan='6'>&nbsp;</td>
			<td align='center'><a href='javascript:seleccionar_todo_si_d()'>";
			if ($_SESSION['usd_sol_ap_dep'] == "1" and $dis_d != "disabled")
			{
				echo "Todos";
			}
			echo "</a></td>
			<td width='' align='center'><a href='javascript:seleccionar_todo_no_d()'>";
			if ($_SESSION['usd_sol_ap_dep'] == "1" and $dis_d != "disabled")
			{
				echo "Todos";
			}
			
			echo "<td width='' align='center'><a href='javascript:seleccionar_todo_si_g()'>";
			if ($_SESSION['usd_sol_ap_ger'] == "1" and $dis_g != "disabled")
			{
				echo "Todos";
			}
			echo "</a></td>";
			
			echo "</a></td>
			<td width='' align='center'><a href='javascript:seleccionar_todo_no_g()'>";
			if ($_SESSION['usd_sol_ap_ger'] == "1" and $dis_g != "disabled")
			{
				echo "Todos";
			}
			echo "</a></td>
			
			<td width='' align='center'><a href='javascript:seleccionar_todo_si_b()'>";
			if ($_SESSION['usd_sol_ap_bod'] == "1" and $dis_b != "disabled")
			{
				echo "Todos";
			}
			echo "</a></td>
			<td width='' align='center'><a href='javascript:seleccionar_todo_no_b()'>";
			if ($_SESSION['usd_sol_ap_bod'] == "1" and $dis_b != "disabled")
			{
				echo "Todos";
			}
			
			echo "</a></td>
			<td width='' align='center' colspan='2'>&nbsp;</td>
			<td width='' align='center'>&nbsp;</td>
			</tr>
			
			<tr bgcolor='#cedee1' bordercolor='#cedee1' class='txtnormal7'>
			<td width='' align='center' colspan='6'>&nbsp;</td>
			<td width='' align='center'><a href='javascript:deseleccionar_todo_si_d()'>";
			if ($_SESSION['usd_sol_ap_dep'] == "1" and $dis_d != "disabled")
			{
				echo "Ning";
			}
			echo "</a></td>
			
			<td width='' align='center'><a href='javascript:deseleccionar_todo_no_d()'>";
			if ($_SESSION['usd_sol_ap_dep'] == "1" and $dis_d != "disabled")
			{
				echo "Ning";
			}
			echo "</a></td>
			
			<td width='' align='center'><a href='javascript:deseleccionar_todo_si_g()'>";
			if ($_SESSION['usd_sol_ap_ger'] == "1" and $dis_g != "disabled")
			{
				echo "Ning";
			}
			echo "</a></td>
			<td width='' align='center'><a href='javascript:deseleccionar_todo_no_g()'>";
			if ($_SESSION['usd_sol_ap_ger'] == "1" and $dis_g != "disabled")
			{
				echo "Ning";
			}
			echo "</a></td>
			<td width='' align='center'><a href='javascript:deseleccionar_todo_si_b()'>";
			if ($_SESSION['usd_sol_ap_bod'] == "1" and $dis_b != "disabled")
			{
				echo "Ning";
			}
			echo "</a></td>
			<td width='' align='center'><a href='javascript:deseleccionar_todo_no_b()'>";
			if ($_SESSION['usd_sol_ap_bod'] == "1" and $dis_b != "disabled")
			{
				echo "Ning";
			}
			echo "</a></td>
			<td width='' align='center' colspan='2'>&nbsp;</td>
			<td width='' align='center'>&nbsp;</td>
	</tr>";
?>
                              
                            </table>                            </td>
                        </tr>
                        <tr>
                          <td height="12" colspan="2" align="center">
                          
                          
                          <table width="970" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="970" height="21" align="left">
                              
                                  <div id="myDiv"></div>
                                  <div id="myLine" class="hide" title="Nombre Trabajador(448),CENTRO C(128),HRS N(53),50%(54),100%(56),(56)">
                                   
                                    <div>
                                    	<textarea name="desc_sol[]" rows="3" id="desc_sol[]" style="width: 255px" onkeydown="cuenta_caracteres(this.value);"></textarea>
                                    </div>
                                   <div>
                                   	&nbsp;&nbsp;&nbsp;
                                   </div>
                                    <div>
									<?php echo"<select id='und_med' name='und_med[]' style='width: 120px; height:20px;' class='combos'>";
										if($nom_t=="")
										{
											$trab=$trab;
										}else{
											$trab=$nom_t;
										}
										if($_POST['combo3']){$ar = $_POST['combo3']; }
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
										echo"</select>"; ?>                                    </div>
                                    <div>
                                      <input type="text" name="cant_det[]" maxlength="11" style="width: 23px" />
                                    </div>
                                     <div>
                                      <input type="text" name="valor_aprox[]" maxlength="11" style="width: 60px" />
                                    </div>
                                     <div>
                                      <input type="text" name="valor_bodega[]" maxlength="11" style="width: 60px" />
                                    </div>
                                    <div>
                                    	<input type="text" name="valor_gerencia[]" maxlength="11" style="width: 60px;">
                                    </div>	
                                    <div>
                                        <input name="check_d_si[]" type="checkbox" id="check_d_si[]" style="background-color: #cccccc;" onclick="val_check_em(this)" disabled="disabled"/>
                                        <input type="hidden" name="aux_ap_d[]" /> 
                                    </div>
                                    <div>
                                        <input name="check_d_no[]" type="checkbox" id="check_d_no[]" style="background-color: #999999;" onclick="val_check_em(this)" disabled="disabled"/>
                                        <input type="hidden" name="aux_ap_g[]" /> 
                                    </div>
	
                                    <div>
                                        <input name="check_g_si[]" type="checkbox" id="check_g_si[]" style="background-color: #cccccc;" onclick="val_check_em(this)" disabled="disabled"/>
                                        <input type="hidden" name="aux_ap_b[]" />
                                    </div>
                                    <div>
                                        <input name="check_g_no[]" type="checkbox" id="check_g_no[]" style="background-color: #999999;" onclick="val_check_em(this)" disabled="disabled"/>
                                    </div>
                                    <div>
                                    	&nbsp;
                                    </div>
                                    <div>
                                        <input name="check_b_si[]" type="checkbox" id="check_b_si[]" style="background-color: #cccccc;" onclick="val_check_em(this)" disabled="disabled"/>
                                    </div>

                                    <div>
                                        <input name="check_b_no[]" type="checkbox" id="check_b_no[]" style="background-color: #999999;" onclick="val_check_em(this)" disabled="disabled"/>
                                    </div>

                                    <div>
                                    	&nbsp;
                                    </div>
                                    <div>
                                        <input name="cant_b[]" type="text" style="width: 15px;height:16px;" />
                                    </div>	
                                    <div>
										<input name="recepciona" type="button" class="boton_recep" />
                                    </div>
                                    <div>
										<input name="adquisiciones" type="button" class="boton_recep2" />
                                    </div>
                                  </div>                                                             
                               </td>
                            </tr>
                          </table></td>
                        </tr>
                        
                        <tr>
                          <td height="28" colspan="2" align="center"><table width="890" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="817" height="17" align="center">
                              <?php 
							  	if($_POST['modifica'] == "Modificar" or $_POST['busca'] == "Buscar" and $cont != 0 ){
							  		$est_ing = "disabled='disabled'";
							  	}else{
							  		$est_ing = "";
							  	}
							  ?>
                                <label>
                                  &nbsp;&nbsp;
                                  <input name="ingresa" type="submit" class="boton_ing" id="button3" value="Ingresar" onclick="return ingresar('Esta seguro que desea ingresar la solicitud?', 'sol_rec_p.php')" <?php echo $est_ing; ?>/></label>
                                
&nbsp;&nbsp;
<?php 
if($_SESSION['usd_sol_ap_dep'] == "1" or $_SESSION['usd_sol_ap_ger'] == "1" or $prof_sol == $_SESSION['usuario_nombre'])
{
	echo"<label>&nbsp;&nbsp;
	<input name='modifica' type='submit' class='boton_mod' id='button4' value='Modificar' onclick=\"return confirmar('Esta seguro que desea modificar la solicitud?', 'sol_rec_p.php', this.value)\" $est; />
	</label>";
}else{
	$est = "disabled='disabled'";
} 
?> 
                                
&nbsp;&nbsp;
                                  <input name="Elimina" type="button" class="boton_eli" id="button5" value="Eliminar" onclick="return confirmar('Esta seguro que desea Eliminar la solicitud?', 'sol_rec_p.php', this.value)"<?php echo $est; ?> />
                                   &nbsp;&nbsp;<input name="limpia" type="submit" class="boton_lim" id="button6" value="Limpiar" />
                                   
                                   <input type="hidden" name="aux_valor" id="aux_valor" size="5"/>
                                   <input type="hidden" name="aprobado_departamento" id="aprobado_departamento" value="<?php echo $aprob_dpto; ?>"/>
                                   <input type="hidden" name="aprobado_bodega" id="aprobado_bodega" value="<?php echo $aprob_bod; ?>"/>
                                   <input type="hidden" name="aprobado_gerencia" id="aprobado_gerencia" value="<?php echo $aprob_ger; ?>"/>
                                   <input type="hidden" name="ingresada_por" id="ingresada_por" value="<?php echo $prof_sol; ?>" />
                                   <input type="hidden" name="detecta_modal" id="detecta_modal" value="<?php echo $_GET['cod']; ?>"/>
                                   
                                   </td>
                              </tr>
                              
                          </table></td>
                        </tr>
                    </table>
                    </fieldset>
                    
                    </td>
                  </tr>
                </table>
                <br/><?php if($prof_sol != ""){echo "SOLICITUD INGRESADA POR: ".strtoupper($prof_sol);} ?>
           </td>
          </tr>
        </table></td>
      </tr>
    </table>
     </form>
    </td>
  </tr>
  <tr>
    <td height="3" colspan="3" align="center" valign="top"><img src="imagenes/barra.gif" width="990" height="3" /></td>
  </tr>
</table>

</body>
</html>
