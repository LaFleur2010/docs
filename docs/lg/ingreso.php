<?
/**********************************************************************************************************************************
			NECESARIO PARA VER SI LA SESION ESTA ACTIVA O SI TIENE PERMISOS DE ACCESO
**********************************************************************************************************************************/
require("../lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php
//
//Definimos el nivel de acceso  (esto es un bonus track para definir que ciertos usuarios puedan entrar a algunas paginas y a otras no)
// Si los usuarios normales tienen acceso=10, para que  accedan todos los usuarios le damos acceso mayor a 10.
$nivel_acceso =5;
if ($nivel_acceso < $_SESSION['usuario_nivel']){
	header ("Location: index.php?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}
//Hasta aquí lo comun para todas las paginas restringidas
//*********************************************************************************************************************************
?>
<?
include('funciones/conexion.php'); // CONECCION A LA BASE DE DATOS
require('funciones/librerias.php');
	
/*********************************************************************
				INICALIZAMOS LAS VARIABLES DE LOS COMBOS
*********************************************************************/
$seleccione 		=	"---------  Seleccione  -------";
$auto 				= 	"  Automatico";
$fe					=	date("d/m/Y");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ingresos</title>

<link href="funciones/bibliocss.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="JavaScript" src="funciones/funciones.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="funciones/stmenu.js"></script>
<LINK href="funciones/epoch_styles.css" type=text/css rel=stylesheet>
<SCRIPT src="funciones/epoch_classes.js" type=text/javascript></SCRIPT>

<SCRIPT type=text/javascript>
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
</SCRIPT>
<SCRIPT type=text/javascript>
function gen()
{
	var agree=confirm("Esta Seguro Que desea Ingresar el Registro ?");
	if (agree){ 
		document.form1.submit();
		return true ;
	}else{
		return false ;
	}
}
function limpia()
{
	var agree=confirm("Esta Seguro de querer limpiar los datos ?");
	if(agree){
		document.form1.t1.value="";
		document.form1.t2.value="";
		document.form1.f1.value="";
		document.form1.f2.value="";
		document.form1.f3.value="";
		document.form1.f4.value="";
		document.form1.f5.value="";
		document.form1.c.value="$seleccione";
		document.form1.c1.value="$seleccione";
		document.form1.c2.value="$seleccione";
		document.form1.c3.value="$seleccione";
		document.form1.c4.value="$seleccione";
		document.form1.t7.value="";
		return true ;
	}else{
		return false ;
		}
}
function valida()
{
	var radio1	= document.form1.radio[0].checked;
	var radio2	= document.form1.radio[1].checked;
	var t1 		= document.form1.t1.value;
	var t2 		= document.form1.t2.value;
	var f1 		= document.form1.f1.value;
	var f3 		= document.form1.f3.value;
	var c 		= document.form1.c.value;
	var c1 		= document.form1.c1.value;
	var c2 		= document.form1.c2.value;
	var c3 		= document.form1.c3.value;
	var c4		= document.form1.c4.value;
if(radio1 || radio2 != "")
{	
	if(t1 != "")
	{
		if(t2 != "" )
		{
			if(f1 != "" )
			{
				if(f3 != "" )
				{
					if(c4 != "" && c4 != "---------  Seleccione  -------")
					{
						if(c != "" && c != "---------  Seleccione  -------")
						{
							if(c1 != "" && c1 != "---------  Seleccione  -------")
							{
								if(c2 != "" && c2 != "---------  Seleccione  -------")
								{
									if(c3 != "" && c3 != "---------  Seleccione  -------")
									{	
										return gen();
									}else{
										alert("ERROR DEBES INGRESAR EL RESPONSABLE");
										document.form1.c3.focus();
										return false;
										}
								}else{
									alert("ERROR DEBES INGRESAR EL CONTACTO");
									document.form1.c2.focus();
									return false;
									}
							}else{
								alert("ERROR DEBES INGRESAR EL CLIENTE");
								document.form1.c1.focus();
								return false;
								}
						}else{
							alert("ERROR DEBES INGRESAR EL ESTADO");
							document.form1.c.focus();
							return false;
						}
					}else{
						alert("ERROR DEBES INGRESAR LA EMPRESA DEL SERVICIO");
						document.form1.c4.focus();
						return false;
						}
				}else{
					alert("ERROR DEBES INGRESAR LA FECHA DE ENTREGA");
					document.form1.f3.focus();
					return false;
					}
			}else{
				alert("ERROR DEBES INGRESAR LA FECHA DE INGRESO");
				document.form1.f1.focus();
				return false;
			}
		}else{
			alert("ERROR DEBES INGRESAR EL NOMBRE DEL TRABAJO");
			document.form1.t2.focus();
			return false;
		}
	}else{
		alert("ERROR DEBES INGRESAR EL NUMERO QUE CONTINUA O QUE CORRESPONDA");
		document.form1.t1.focus();
		return false;
	}
}else{
	alert("ERROR DEBES SELECCIONAR LICITACION O COTIZACION");
	document.form1.radio[1].focus();
	return false;
}
}
function cliente()
{
	abrirVentanac('cliente.php','485','250','no','yes');
}
function contacto()
{
	abrirVentanac('contacto.php','560','250','no','yes');
}
function responsable()
{
	abrirVentanac('responsable.php','490','250','no','yes');
}
function empresa()
{
	abrirVentanac('empresa.php','490','250','no','yes');
}
function val_check()
{	
	if(document.form1.manual.checked)
	{
		if (document.form1.radio[0].checked) 
		{	
			var nlici = ""
			document.form1.t1.value = nlici;
			document.form1.t1.focus();
		}else
		{
			var ncoti = "1500-"
			document.form1.t1.value = ncoti;
			document.form1.t1.focus();
		}
	}else
	{
			var aut = "Automatico"
			document.form1.t1.value = aut;	
	}
}
</SCRIPT>

<script language="JavaScript">
var comando;
var resultado;
function Agregar() 
{
	// aqui tu codigo para abrir la ventana emergente
 	cliente();
}
function CargarCliente(valor)
{
	if (valor != 0)
 	{
   	comando = "accion=carga_datos&id=" + valor;
	resultado = "DivDatos";
   	Ajax();
	}
}
function CargarNombres()
{
	comando = "accion=carga_nombres";
	resultado = "DivNombres";
 	Ajax();
}
function Ajax()
{
	crearObjeto();
	if (objeto.readyState != 0)
	{
   		alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
 	}else
	{
   		if (!comando)
		{
 			// si no hay comando.. es porque se esta mandando llamar de la ventana emergente
     		comando = document.getElementById("ComandoRemoto").value;
   		}
	// indicar la funcion que procesa el resultado
   	objeto.onreadystatechange = procesaResultado;
	// enviar los datos - el "random" es porque se puede detectar que intentas leer los mismos datos; entonces, alenviarle
	// un numero en random es como si pidieras los datos nuevos (no los que estan en memoria)
   	objeto.open("GET", "combo_pl.php?" + comando + "&random=" + Math.random(), true);
	// ni idea para que es esto (pero si no lo pones no funciona) tongue.gif
   	objeto.send(null);
 	}
}
</SCRIPT>
<script language="JavaScript">
var comando4;
var resultado4;
//AQUI SE CARGA EL COMBO DE LOS CONTACTOS
function Agregar4()
{
	// aqui tu codigo para abrir la ventana emergente
 	empresa();
}
function CargarEmpresa(valor)
{
	if (valor != 0)
 	{
   		comando4 = "accion=carga_datos&id=" + valor;
		resultado4 = "DivDatos";
   		Ajax4();
 	}
}
function CargarNombres4()
{
	comando4 = "accion=carga_usuarios";
	resultado4 = "DivUsuarios";
 	Ajax4();
}
function Ajax4()
{
 	crearObjeto();
 	if (objeto.readyState != 0)
	{
   		alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
 	}else
	{
   		if(!comando4)
		{
 			// si no hay comando.. es porque se esta mandando llamar de la ventana emergente
     		comando4 = document.getElementById("ComandoRemoto4").value;
   		}
	// indicar la funcion que procesa el resultado
  	objeto.onreadystatechange = procesaResultado4;
	// enviar los datos - el "random" es porque se puede detectar que intentas leer los mismos datos; entonces, alenviarle
	// un numero en random es como si pidieras los datos nuevos (no los que estan en memoria)
   	objeto.open("GET", "combo_us.php?" + comando2 + "&random=" + Math.random(), true);
	// ni idea para que es esto (pero si no lo pones no funciona) tongue.gif
   objeto.send(null);
 	}
}
</SCRIPT>
<script language="JavaScript">
var comando2;
var resultado2;
//AQUI SE CARGA EL COMBO DE LOS CONTACTOS
function Agregar2()
{
	// aqui tu codigo para abrir la ventana emergente
 	contacto();
}
function CargarContacto(valor)
{
	if (valor != 0)
 	{
   		comando2 = "accion=carga_datos&id=" + valor;
		resultado2 = "DivDatos";
   		Ajax2();
 	}
}
function CargarNombres2()
{
	comando2 = "accion=carga_usuarios";
	resultado2 = "DivUsuarios";
 	Ajax2();
}
function Ajax2()
{
 	crearObjeto();
 	if (objeto.readyState != 0)
	{
   		alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
 	}else
	{
   		if(!comando2)
		{
 			// si no hay comando.. es porque se esta mandando llamar de la ventana emergente
     		comando2 = document.getElementById("ComandoRemoto2").value;
   		}
	// indicar la funcion que procesa el resultado
  	objeto.onreadystatechange = procesaResultado2;
	// enviar los datos - el "random" es porque se puede detectar que intentas leer los mismos datos; entonces, alenviarle
	// un numero en random es como si pidieras los datos nuevos (no los que estan en memoria)
   	objeto.open("GET", "combo_us.php?" + comando2 + "&random=" + Math.random(), true);
	// ni idea para que es esto (pero si no lo pones no funciona) tongue.gif
   objeto.send(null);
 	}
}
</SCRIPT>
<script language="JavaScript">
var comando3;
var resultado3;
function Agregar3()
{
	// aqui tu codigo para abrir la ventana emergente
 	responsable();
}
function CargarResponsable(valor)
{
	if (valor != 0)
 	{
   		comando3 = "accion=carga_datos&id=" + valor;
		resultado3 = "DivDatos";
   		Ajax3();
 	}
}
function CargarNombres3()
{
	comando3 = "accion=carga_nombres";
	resultado3 = "DivNombres";
	Ajax3();
}
function Ajax3()
{
 	crearObjeto();
 	if (objeto.readyState != 0)
	{
   		alert('Error al crear el objeto XML. El Navegador no soporta AJAX');
 	}else
	{
   		if(!comando3)
		{
 			// si no hay comando.. es porque se esta mandando llamar de la ventana emergente
     		comando3 = document.getElementById("ComandoRemoto3").value;
   		}
	// indicar la funcion que procesa el resultado
   	objeto.onreadystatechange = procesaResultado3;
	// enviar los datos - el "random" es porque se puede detectar que intentas leer los mismos datos; entonces, alenviarle
	// un numero en random es como si pidieras los datos nuevos (no los que estan en memoria)
   	objeto.open("GET", "combo_us.php?" + comando3 + "&random=" + Math.random(), true);
	// ni idea para que es esto (pero si no lo pones no funciona) tongue.gif
   	objeto.send(null);
 	}
}

function crearObjeto()
{
 	try{ objeto = new ActiveXObject("Msxml2.XMLHTTP"); }
 	catch(e){
   				try{ objeto = new ActiveXObject("Microsoft.XMLHTTP"); }
   				catch(E){ objeto = false; }
 	}
	if(!objeto && typeof XMLHttpRequest!='undefined')
	{
   		objeto = new XMLHttpRequest();
	}
}
function objetoAjax()
{
	var xmlhttp=false;
	try{
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	}catch(e){
		try{
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}catch (E){
				xmlhttp = false;
  			}
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined')
	{
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function MostrarConsulta(num)
{
	divResultado = document.getElementById('resultado');
	ajax=objetoAjax();
	ajax.open("GET", "consultacontacto.php?valor="+num, true);
	ajax.onreadystatechange=function()
	{
		if (ajax.readyState==4)
		{
			divResultado.innerHTML = ajax.responseText
		}
	}
	ajax.send(null)
}
function enviar()
{
	var indice = document.form1.c2.selectedIndex;
	var valor = document.form1.c2.options[indice].value;
	MostrarConsulta(valor);
}
function volver()
{
	document.form1.action = 'listado.php';
	document.form1.submit();
}
function volver3()
{
	document.form1.action = '../index2.php';
	document.form1.submit();
}
</SCRIPT>
<style type="text/css">
<!--
body {
	background-color: #0099FF;
}
-->
</style>

  <style type="text/css">
  <!--
     body {
	scrollbar-3dlight-color:#0099FF;
	scrollbar-arrow-color:white;
	scrollbar-track-color:silver;
	scrollbar-darkshadow-color:black;
	scrollbar-face-color:#0099FF;
    scrollbar-highlight-color:;
    scrollbar-shadow-color:;
	background-image: url();
	background-color: #5a88b7;
}
.Estilo8 {color: #000000}
.Estilo9 {color: #FFFFFF}
   -->
  </style> 
</head>

<body>
<?
if($_POST['bus'] != "Buscar" and $_POST['mod'] != "Modificar" and $_POST['eli'] != "Eliminar" and $_POST['ing'] != "Ingresar")
{ 
	$co=mysql_connect("$DNS","$USR","$PASS");
 	mysql_select_db("$BDATOS", $co);
 	
 $sqlc="SELECT * FROM ingreso WHERE num_ing= '".$_GET['numero']."'";
 $respuesta=mysql_query("$sqlc",$co);
 while($vrows=mysql_fetch_array($respuesta))
 {
	$nl			="".$vrows['num_ing']."";
	$nt			="".$vrows['nombretrabajo']."";
	$fi			="".$vrows['fechaingreso']."";
	$fv			="".$vrows['fechavisitaterreno']."";
	$fentrega	="".$vrows['fechaentrega']."";
	$fconsulta	="".$vrows['fconsulta']."";
	$frespuesta ="".$vrows['frespuesta']."";
	$ccampo		="".$vrows['clientecampo']."";
	$cempresa	="".$vrows['empresacampo']."";
	$ccontacto	="".$vrows['contactocampo']."";
	$es			="".$vrows['estado']."";  	  
	$rc			="".$vrows['responsablecampo']."";
	$ob			="".$vrows['observaciones']."";							
 }
}
?>
<table width="944" height="650" align="center" cellpadding="0" cellspacing="0" bgcolor="#F2F2F2">
  <tr>
    <td width="100" height="54" align="center" valign="top"><a href="index2.php">
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="100" height="52">
    <param name="movie" value="imagenes/logomgyt.swf">
    <param name="quality" value="high">
    <embed src="imagenes/logomgyt.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="120" height="50"></embed></object>
	</a></td>
    <td width="742" align="center" valign="middle">INGRESO DE DOCUMENTOS</td>
    <td width="100" align="right" valign="top">
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="100" height="52">
    <param name="movie" value="imagenes/logomgyt2.swf">
    <param name="quality" value="high">
    <embed src="imagenes/logomgyt2.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="120" height="50"></embed></object>
	</td>
  </tr>
  <tr>
    <td height="3" colspan="3" align="center" valign="top"><img src="imagenes/barra.gif" alt="" width="940" height="3" /></td>
  </tr>
  <tr>
    <td height="624" colspan="3" align="center" valign="top">  
    <table width="939" height="650" border="0" class="txtnormal">
        <tr>
        <td width="933" height="650" align="center" valign="top">
		<form name="form1" method="post" action="">
          <table width="926" height="650" border="0" cellpadding="0" cellspacing="0" class="tablas">
            <tr>
              <td width="920" height="650" align="center" valign="top"><table width="918" height="650" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
                <tr>
                  <td height="51" align="center"><table width="916" height="56" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#cedee1">
                    <tr>
                      <td align="right"><table width="906" height="66" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="100" height="62" align="right"><label>
                                      <input name="button8" type="button" class="boton_inicio" id="button8" value="Inicio" onclick="volver3()"/>
                          </label></td>
                          <td width="181" align="right">&nbsp;</td>
                          <td width="100" align="center"><input name="button10" type="button" class="boton_lista" id="button13" value="Listado" onclick="volver()" /></td>
                          <td width="100" align="center"><label></label></td>
                          <td width="100" align="center">&nbsp;</td>
                          <td width="25" align="right"><input type="hidden" name="usuario_nombre" id="usuario_nombre" value="<?php echo $_SESSION['usuario_nombre']; ?> " /></td>
                        </tr>
                      </table>
					  </td>
                    </tr>
                  </table><label></label>
				  </td>
                  </tr>
                <tr>
                  <td height="250" align="center"><table width="916" border="1" cellpadding="0" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
                    <tr>
                      <td height="250" align="center"><table width="857" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td height="44" colspan="2" align="center" valign="bottom">DATOS INTERNOS</td>
                            <td colspan="3" align="center" valign="bottom">DATOS DEL CLIENTE</td>
                          </tr>
                          <tr>
                            <td colspan="5" align="center"><font color="#FF0000">(*) Datos Obligatorios</font></td>
                            </tr>
                          <tr>
                            <td colspan="2" align="left"><span class="Estilo8">Manual&nbsp;</span>
                              <input type="checkbox" name="manual" id="manu" /></td>
                            <td colspan="3" align="left">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="163" align="left"><label>Licitacion&nbsp;<font color="#FF0000">(*)</font>
                                <input type="radio" name="radio" value="Licitacion" onclick="val_check()"/>
                            </label></td>
                            <td width="228" align="left"><label>Cotizacion&nbsp;<font color="#FF0000">(*)</font>
                                <input type="radio" name="radio" value="Cotizacion" onclick="val_check()"/>
                            </label></td>
                            <td width="154" align="left"><span class="Estilo8">
                              <label>Cliente&nbsp;<font color="#FF0000">(*)</font></label>
                            </span></td>
                            <td width="273" align="left">
                            <select name="c1" id="c2" onchange="CargarCliente(this.value)" style="width:250px;">
                              <?php
						  //*******************************************************************************************************
						  $sql  = "SELECT numerocliente, clientecampo FROM cliente ORDER BY clientecampo ";						
						  $rs 	= dbConsulta($sql);
						  $total  = count($rs);
						  echo"<option selected='selected' value='$seleccione'>$seleccione</option>";
						  if($_POST['bus']== "Buscar")
						  {
							echo"<option selected='selected'>$ccampo</option>";
							for ($i = 0; $i < $total; $i++)
							{
								$nom = $rs[$i]['clientecampo'];
								if($clientecampo != $nom)
								{
								  echo "<option value='".$rs[$i]['numerocliente']."'>".$rs[$i]['clientecampo']."</option>"; 
								}	
							}	
						  }else
						  {								
							for ($i = 0; $i < $total; $i++)
							{
								$nom = $rs[$i]['clientecampo'];
								if($clientecampo != $nom)
								{
								  echo "<option value='".$rs[$i]['numerocliente']."'>".$rs[$i]['clientecampo']."</option>";
								}	
							}
						  }
						  ?>
                            </select>
&nbsp;</td>
                            <td width="39" align="left"><input name="button2" type="button" class="otro" id="agregar" value=" ? " onclick="Agregar()" /></td>
                          </tr>
                          <tr>
                            <td align="left"><span class="Estilo8">Numero/Asignado&nbsp;<font color="#FF0000">(*)</font></span></td>
                            <td align="left"><span class="content Estilo8">
                              <?
						  $vart1 = $_POST['t1']; 
						  ?>
                              <input name="t1" type="text" size="10" maxlength="10" style="background-color:#0099FF" value="<?php echo $vart1; ?>"/>
                            </span></td>
                            <td align="left"><span class="Estilo8">Contacto&nbsp;<font color="#FF0000">(*)</font></span></td>
                            <td align="left"><span class="txtnormaln">
                              <select name="c2" id="Nombres" onchange="enviar()" style="width:250px;">
                                <?php
								include('libreias.php');						
								//*******************************************************************************************************
								$sql  = "SELECT * FROM contacto ORDER BY contactocampo";							
								$rs 	= dbConsulta($sql);
								$total  = count($rs);
								echo"<option selected='selected' value='$seleccione'>$seleccione</option>";								
								if($_POST['bus']== "Buscar")
								{
									echo"<option selected='selected'>$ccontacto</option>";
									for($i = 0; $i < $total; $i++)
									{
									$cc = $rs[$i]['contactocampo'];
									$nc = $rs[$i]['numerocontacto'];
									echo "<option value='$nc'>$cc</option>";
									}	
								}else
								{
									for ($i = 0; $i < $total; $i++)
									{		
										$cc = $rs[$i]['contactocampo'];
										$nc = $rs[$i]['numerocontacto'];
										echo "<option value='$nc'>$cc</option>";		
									}
								}
							?>
                              </select>
&nbsp;</span></td>
                            <td align="left"><span class="txtnormaln">
                              <input name="button" type="button" class="otro" id="button7" value=" ? " onclick="Agregar2()" />
                            </span></td>
                          </tr>
                          <tr>
                            <td align="left"><span class="Estilo8">Nombre/Trabajo&nbsp;<font color="#FF0000">(*)</font></span></td>
                            <td align="left"><?php $vart2 = $_POST['t2']; ?>
                              <input type="text" name="t2" size="30" maxlength="80" value="<?php echo $vart2;?>" /></td>
                            <td align="left"><span class="Estilo8">Empresa del Servicio&nbsp;<font color="#FF0000">(*)</font></span></td>
                            <td align="left"><span class="content Estilo8">
                              <select name="c4" id="c" onchange="CargarEmpresa(this.value)" style="width:250px;">
                                <?php
						  //*******************************************************************************************************
						  $sql  = "SELECT nempresa, empresacampo FROM empresa ORDER BY empresacampo ";						
						  $rs 	= dbConsulta($sql);
						  $total  = count($rs);
						  echo"<option selected='selected' value='$seleccione'>$seleccione</option>";
						  if($_POST['bus']== "Buscar")
						  {
							echo"<option selected='selected'>$cempresa</option>";
							for ($i = 0; $i < $total; $i++)
							{
								$nom = $rs[$i]['empresacampo'];
								if($empresacampo != $nom)
								{
								  echo "<option value='".$rs[$i]['nempresa']."'>".$rs[$i]['empresacampo']."</option>"; 
								}	
							}	
						  }else
						  {								
							for ($i = 0; $i < $total; $i++)
							{
								$nom = $rs[$i]['empresacampo'];
								if($empresacampo != $nom)
								{
								  echo "<option value='".$rs[$i]['nempresa']."'>".$rs[$i]['empresacampo']."</option>";
								}	
							}
						  }
						  ?>
                              </select>
&nbsp;</span></td>
                            <td align="left"><span class="content Estilo8">
                              <input name="button4" type="button" class="otro" id="button" value=" ? " onclick="Agregar4()" />
                            </span></td>
                          </tr>
                          <tr>
                            <td align="left"><span class="Estilo8">Fecha/Ingreso&nbsp;<font color="#FF0000">(*)</font></span></td>
                            <td align="left"><?php $varf1 = $_POST['f1']; ?>
                              <span class="content Estilo8">
                              <? $fe_in_ret	=	cambiarFecha($fe_in_ret, '-', '/' ); ?>
                              <input id="date_field" style="WIDTH: 7em" name="f1" value="<? echo $fe_in_ret; ?><?php echo $varf1;?>" readonly="readonly"/>
                              <input type="button" class="botoncal" onclick="dp_cal.toggle();" />
                              </span></td>
                            <td colspan="3" align="left">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left"><span class="Estilo8">Fecha Salida/terreno</span></td>
                            <td align="left"><?php $varf2 = $_POST['f2']; ?>
                              <span class="content Estilo8">
                              <? $fe_env_inf = cambiarFecha($fe_env_inf, '-', '/' ); ?>
                              <input id="date_field2" style="WIDTH: 7em;background-color: #00cc00" name="f2" value="<? echo $fe_env_inf; ?><?php echo $varf2;?>" readonly="readonly"/>
                              <input type="button" class="botoncal" onclick="dp_cal2.toggle();" />
                              </span></td>
                            <td colspan="3" align="left">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left"><span class="Estilo8">Fecha Consulta </span></td>
                            <td align="left"><?php $varf4 = $_POST['f4']; ?>
                              <span class="content Estilo8">
                              <? $fe_in_ret	=	cambiarFecha($fe_in_ret, '-', '/' ); ?>
                              <input id="date_field4" style="WIDTH: 7em" name="f4" value="<? echo $fe_in_ret; ?><?php echo $varf4;?>" readonly="readonly"/>
                              <input name="button6" type="button" class="botoncal" onclick="dp_cal4.toggle();" />
                              </span><span class="Estilo8"> </span> </td>
                            <td colspan="3" align="left">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left"><span class="Estilo8">Fecha Respuesta </span></td>
                            <td align="left"><?php $varf5 = $_POST['f5']; ?>
                              <span class="content Estilo8">
                              <? $fe_in_ret	=	cambiarFecha($fe_in_ret, '-', '/' ); ?>
                              <input id="date_field5" style="WIDTH: 7em" name="f5" value="<? echo $fe_in_ret; ?><?php echo $varf5;?>" readonly="readonly"/>
                              <input name="button7" type="button" class="botoncal" onclick="dp_cal5.toggle();" />
                              </span><span class="Estilo8"> </span> </td>
                            <td colspan="3" align="left">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left"><span class="Estilo8">Fecha 
                            Entrega&nbsp;<font color="#FF0000">(*)</font></span></td>
                            <td align="left"><?php $varf3 = $_POST['f3'];?>
                              <span class="content Estilo8"> </span><span class="content Estilo8">
                              <? $fe_in_ret	=	cambiarFecha($fe_in_ret, '-', '/' ); ?>
                              <input id="date_field3" style="WIDTH: 7em" name="f3" value="<? echo $fe_in_ret; ?><?php echo $varf3;?>" readonly="readonly"/>
                              <input name="button5" type="button" class="botoncal" onclick="dp_cal3.toggle();" />
                              </span><span class="Estilo8"> </span> <span class="Estilo8"> </span> </td>
                            <td colspan="3" align="left">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left">&nbsp;</td>
                            <td align="left">&nbsp;</td>
                            <td colspan="3" align="left">&nbsp;</td>
                          </tr>

                        </table></td>
                    </tr>
                  </table>
				  </td>
                  </tr>
                <tr>
                  <td height="19" align="center" valign="bottom"><label></label>
                    <table width="916" border="1" bordercolor="#FFFFFF" bgcolor="#CCCCCC">
                      <tr>
                        <td width="909" height="203" align="center">
						<table width="800" border="0" cellpadding="0" cellspacing="0">
                                  <tr> 
                                    <td width="144" height="15" align="center" class="txtnormal" colspan="8">DATOS 
                                      INTERNOS</td>
                                  </tr>
                                  <tr> 
                                    <td height="15" colspan="8" align="left" class="txtnormal"> 
                                    </td>
                                  </tr>
                                  <tr> 
                                    <td height="15" align="left" class="txtnormal"> 
                                      <span class="Estilo8">Estado&nbsp;<font color="#FF0000">(*)</font></span> </td>
                                    <td align="left" class="txtnormal" colspan="2"> 
                                    </td>
                                    <td align="right" class="txtnormal" colspan="2"> 
                                      <span class="Estilo8"> 
                                      Responsable/Estudio&nbsp;<font color="#FF0000">(*)</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                                    <td align="left" class="txtnormal" colspan="3"> 
                                    </td>
                                  </tr>
                                  <tr> 
                                    <td height="15" align="left" class="txtnormal"><span class="Estilo8">
									  <?php $varc = $_POST['c']; ?> 
                                      <select name="c" size="1" value="">
                                        <? 
										if($_POST['bus']== "Buscar")
										{
											echo"<option selected='selected'>$es</option>";
										}else
										{
											if($_POST['refresh'] == "Refresh")
											{
												echo"<option selected='selected' value='$seleccione'>$varc</option>";
											}else
											{
												echo"<option selected='selected' value='$seleccione'>$seleccione</option>";
											}
										}?>
                                        <option value="No Estudio">No Estudio</option>
                                        <option value="Estudio">Estudio</option>
                                        <option value="En Espera">En Espera</option>
                                        <option value="No Adjudicado">No Adjudicado</option>
                                        <option value="Adjudicado">Adjudicado</option>
                                      </select>
                                      <input type="hidden" name="estado" id="hiddenField" value="<?php echo $estado ?>" />
                                      </span> </td>
                                    <td align="left" class="txtnormal" colspan="2"> 
                                    </td>
                                    <td align="right" class="txtnormal" colspan="2"><span class="Estilo8"> 
                                      <select  name="c3" id="c3" onChange="CargarResponsable(this.value)">
                                        <?php
										include('libreias.php');
										//*******************************************************************************************************
										$sql  = "SELECT numeroresponsable, responsablecampo FROM responsable ORDER BY responsablecampo ";						
										$rs 	= dbConsulta($sql);
										$total  = count($rs);
										echo"<option selected='selected' value='$seleccione'>$seleccione</option>";
										if($_POST['bus']== "Buscar")
										{
											echo"<option selected='selected'>$rc</option>";
											for ($i = 0; $i < $total; $i++)
											{
												$nom = $rs[$i]['responsablecampo'];
												if($responsablecampo != $nom)
												{
													echo "<option value='".$rs[$i]['numeroresponsable']."'>".$rs[$i]['responsablecampo']."</option>";
												}
											}	
										}else
										{									
											for ($i = 0; $i < $total; $i++)
											{
												$nom = $rs[$i]['responsablecampo'];
												if($responsablecampo != $nom)
												{
													echo "<option value='".$rs[$i]['numeroresponsable']."'>".$rs[$i]['responsablecampo']."</option>";
												}
											}
										}
										?>
                                      </select>
                                      &nbsp; 
                                      <input name="button3" type="button" class="otro" id="agregar3" value=" ? " onclick="Agregar3()" />
                                      <input type="hidden" name="ComandoRemoto3" id="ComandoRemoto3" />
                                      </span> </td>
                                    <td align="left" class="txtnormal" colspan="3"> 
                                    </td>
                                  </tr>
                                  <tr> 
                                    <td height="15" align="center" class="txtnormal" colspan="8"><span class="Estilo8">Obsevaciones</span> 
                                    </td>
                                  </tr>
                                  <tr> 
                                    <td width="144" height="15" align="center" class="txtnormal" colspan="8">
									<?php $vart7 = $_POST['t7']; ?>
									<textarea name="t7" cols="100" rows="5" value=""><?php echo $vart7;?></textarea>
									</td>
                                  </tr>
								  <tr>
								  	<td height="15" colspan="8" align="left" class="txtnormal"> 
                                    </td>
								  </tr>
                                </table>
						</td>
                      </tr>
                    </table>
					</td>
                  </tr>
                <tr>
                  <td height="37" align="center" valign="bottom">
                  <input name="ing" type="submit" class="boton_ing" id="ing" value="Ingresar" onclick="return valida()"/>
                  <input name="lim" type="submit" class="boton_lim" id="lim" value="Limpiar" onclick="return limpia()"/>
				  <input name="refresh" type="submit" class="boton_ref" value="Refresh"/> 
                  </td>
                </tr>
              </table></td>
            </tr>
          </table>
        </form>
		</td>
      </tr>
      <tr>
        <td height="17" align="center" valign="top">&nbsp;</td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td height="5" colspan="3" align="center" valign="top"><img src="imagenes/barra.gif" alt="" width="940" height="3" /></td>
  </tr>
</table>
<?php
/***********************************************************************************
										INGRESAR
***********************************************************************************/
if($_POST['ing'] == "Ingresar")
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$c2		= $_POST['c2'];
	$sql2 = "select contactocampo from contacto where numerocontacto = $c2";
	$resp2 = mysql_query($sql2,$co);
	while($vrows=mysql_fetch_array($resp2))
	{
		$c2 	= "".$vrows['contactocampo']."";
	}
	$c1		=$_POST['c1'];
	$sql3 ="select clientecampo from cliente where numerocliente = $c1";
	$resp3 = mysql_query($sql3,$co);
	while($vrows=mysql_fetch_array($resp3))
	{
		$c1 	= "".$vrows['clientecampo']."";
	}
	$c3		=$_POST['c3'];
	$sql4 ="select responsablecampo from responsable where numeroresponsable = $c3";
	$resp4 = mysql_query($sql4,$co);
	while($vrows=mysql_fetch_array($resp4))
	{
		$c3 	= "".$vrows['responsablecampo']."";
	}
	$c4		=$_POST['c4'];
	$sql5 ="select empresacampo from empresa where nempresa = $c4";
	$resp5 = mysql_query($sql5,$co);
	while($vrows=mysql_fetch_array($resp5))
	{
		$c4 	= "".$vrows['empresacampo']."";
	}	
	if($_POST['radio'] == "Cotizacion")
	{
		$tipo = "Cotizacion";
	}
	if($_POST['radio'] == "Licitacion")
	{
		$tipo = "Licitacion";
	}
	if($_POST['manual'] == "on")
	{
		$N_ing = $_POST['t1'];
	}else
	{
		if($_POST['radio'] == "Licitacion")
		{
			$consulta=mysql_query("SELECT max(num_ing) FROM ingreso WHERE tipo_ing='$tipo'"); 
			$M_ing = mysql_result($consulta,0);
			$N_ing=($M_ing + 1);
		}
		if($_POST['radio'] == "Cotizacion")
		{
			$consulta=mysql_query("SELECT max(num_ing) FROM ingreso WHERE tipo_ing='$tipo'"); 
			$M_ing 	= mysql_result($consulta,0);
			$M_ing	= substr($M_ing,-4);
			$M_ing 	= $M_ing;

			if($M_ing >="1000")
			{
				$x=1500;
				$M_ing2=$M_ing + 1;
				$N_ing=($x."-".$M_ing2);
				echo "<script language='javascript'>
				alert('Adentro');
			</script>";
			}else
			{
				//$consulta=mysql_query("SELECT max(num_ing) FROM ingreso WHERE tipo_ing='$tipo'"); 
				//$M_ing = mysql_result($consulta,0);
				$M_ing= substr($M_ing,-3);
				$x=1500;
				$M_ing2=$M_ing + 1;
				$N_ing=($x."-".$M_ing2);
			}
		}
	}
	$f1		=$_POST['f1'];
	$f2		=$_POST['f2'];
	$f4		=$_POST['f4'];
	$f5		=$_POST['f5'];
	$f3		=$_POST['f3'];
	$c		=$_POST['c'];
	$clc	=$c1;
	$cc		=$c2;
	$cr		=$c3;
	$ce		=$c4;
	$t7		=$_POST['t7'];
	$t2		=$_POST['t2'];
	$sql_i = "INSERT INTO ingreso (num_ing,tipo_ing,fechaingreso,fechavisitaterreno,fconsulta,frespuesta,fechaentrega,empresacampo,clientecampo,contactocampo,estado,responsablecampo,observaciones,nombretrabajo) 
			VALUES ('$N_ing','$tipo','$f1','$f2','$f4','$f5','$f3','$ce','$clc','$cc','$c','$cr','$t7','$t2')";
	if(mysql_query($sql_i,$co))
	{
	/*****************************************************************
	//			SE CREA LA CARPETA DE CADA LICITACION
	******************************************************************/
		$dir=$N_ing;
		$carp=$N_ing;
		if($_POST['radio'] == "Licitacion")
		{			
				if(!is_dir($carp))// Preguntamos si la carpeta No Existe
				{
				@mkdir("./Ingresos/Licitaciones/".$carp, 0777); // si no existe la creamos
				unset($N_ing);//Eliminamos la variable
				unset($N_ing);
				}else{ 
					?><script>alert("La Carpeta Ya Existe");</script><?
				}
		}else
		{
				if(!is_dir($carp))// Preguntamos si la carpeta No Existe
				{
				@mkdir("./Ingresos/Cotizaciones/".$carp, 0777); // si no existe la creamos
				unset($N_ing);//Eliminamos la variable
				unset($N_ing);
				}else{ 
					?><script>alert("La Carpeta Ya Existe");</script><?
				}
		}
		echo "<script language='javascript'>
				alert('Los datos fueron ingresados correctamente');
				
			</script>";
	}else{
		echo "<script language='javascript'>
				alert('Error al ingresar los datos');
				alert($sql_i);
			</script>";
	}
/*****************************************************************
//			FIN DE LA CREACION DE CARPETA DE CADA LICITACION
******************************************************************/			
}
?>
</body>
</html>