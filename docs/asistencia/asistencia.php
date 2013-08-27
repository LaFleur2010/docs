<?
/**********************************************************************************************************************************
			NECESARIO PARA VER SI LA SESION ESTA ACTIVA O SI TIENE PERMISOS DE ACCESO
**********************************************************************************************************************************/
require("../lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php
//
//Definimos el nivel de acceso  (esto es un bonus track para definir que ciertos usuarios puedan entrar a algunas paginas y a otras no)
// Si los usuarios normales tienen acceso=10, para que  accedan todos los usuarios le damos acceso mayor a 10.
if($_SESSION['us_tipo'] != "Administrador" AND $_SESSION['us_tipo'] != "Supervisor")
{
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}//Hasta aquí lo comun para todas las paginas restringidas
//Hasta aquí lo comun para todas las paginas restringidas
//*********************************************************************************************************************************

//*********************************************************************************************************************************
	include('../inc/config_db.php');	// CONECCION A LA BASE DE DATOS
	require('../inc/lib.db.php');
	$fe		= date("d/m/Y");
	$sel 	= "Seleccione...";
//********************************************************************************************************************************

//comparo la fecha de hoy con la fecha limite
/*function comparar_fechas($fecha_hoy, $fecha_baja)
{
	list ($dia_hoy, $mes_hoy, $anio_hoy) = split("/", $fecha_hoy); //separo laos dias, los meses y los años
	list ($dia_limite, $mes_limite, $anio_limite) = split("/", $fecha_baja);
	
	//comparo primero los años para saber si es mayor igual o menor
	if($anio_hoy > $anio_limite) $resp="Mayor";
		elseif ($anio_hoy < $anio_limite) $resp="Menor";
			elseif($mes_hoy > $mes_limite) $resp="Mayor";
				elseif ($mes_hoy < $mes_limite) $resp="Menor";  
					elseif($dia_hoy > $dia_limite) $resp="Mayor";
						elseif ($dia_hoy < $dia_limite) $resp="Menor"; 
							else $resp="Igual";
							
							return $resp;
} 
*/
function encabezado()
{
	echo"<table width='883' border='1' cellpadding='0' cellspacing='0' bordercolor='#FFFFFF'>
                              <tr class='txtnormaln' bgcolor='#5a88b7'>
                                <td width='26' rowspan='2' align='center'>Nº</td>
                                <td width='219' rowspan='2' align='center'>NOMBRE TRABAJADOR</td>
                                <td colspan='2' align='center'>ESTADO</td>
                                <td width='149' rowspan='2' align='center'>MOTIVO</td>
                                <td width='365' rowspan='2' align='center'>OBSERVACION</td>
                                </tr>
                              <tr class='txtnormalb'>
                                <td width='57' align='center' bgcolor='#003366'>Presente</td>
                                <td width='53' align='center' bgcolor='#003366'>Ausente</td>
                              </tr>";
}
	
function fin()
{
	echo"<tr bgcolor='#5a88b7' bordercolor='#5a88b7'>
<td height='12' align='center'>&nbsp;</td>
<td height='12' align='left'>&nbsp;</td>
<td width='50' align='center'><a href='javascript:seleccionar_todo_p()'>Todos</a></td>
<td width='62' align='center'><a href='javascript:seleccionar_todo_a()'>Todos</a></td>
<td width='149' align='center'>&nbsp;</td>
<td width='365' align='center'>&nbsp;</td>
</tr>

<tr bgcolor='#5a88b7' bordercolor='#5a88b7'>
<td height='12' align='center'>&nbsp;</td>
<td height='12' align='left'>&nbsp;</td>
<td width='50' align='center'><a href='javascript:deseleccionar_todo_p()'>Ninguno</a></td>
<td width='62' align='center'><a href='javascript:deseleccionar_todo_a()'>Ninguno</a></td>
<td width='149' align='center'>&nbsp;</td>
<td width='365' align='center'>&nbsp;</td>
</tr>
</table><br>";
}

function filanm($num, $cod_det_as, $nom_tf, $app_tf, $apm_tf, $rut_det_as, $estado_det_as, $motivo_det_as, $observ_det_as, $check1, $check2, $color, $cod_as, $area )
{
	echo"<tr bgcolor=$color bordercolor=$color onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000')>
	<td height='12' align='center'>$num</td>
    <td height='12' align='left'>&nbsp;&nbsp;".$nom_tf." ".$app_tf." ".$apm_tf."</td>
    <td width='50' align='center'><input name='presente[]' type='checkbox' class='cajas' id='checkbox[]' onclick='cambiar(this)' $check1 /></td>
    <td width='62' align='center'><input name='ausente[]' type='checkbox' class='cajas' id='checkbox[]' onclick='cambiar(this)' $check2 /></td>
	
    <td width='149' align='center'>							
	<select name='motivo[]' class='combos' id='motivo' style='width: 140px' onchange='fmot(this);' >
    	<option selected='selected' value='$motivo_det_as'>$motivo_det_as</option>
		<option value='Dia compensado'>Dia compensado</option>
        <option value='Falla'>Falla</option>
        <option value='Licencia'>Licencia</option>
        <option value='Permiso a descuento'>Permiso a descuento</option>
        <option value='Permiso Legal'>Permiso Legal</option>
		<option value='Permiso Sindical'>Permiso Sindical</option>
        <option value='Terreno'>Terreno</option>
		<option value='Turno'>Turno</option>
        <option value='Vacaciones'>Vacaciones</option>
   	</select>					
	</td>
	
	<td width='365' align='center'>
		<input name='obs[]' type='text' class='cajas' id='textfield' size='55' value='$observ_det_as' />
		<input type='hidden' name='id[]' value='$cod_det_as' />
		<input name='aux[]' type='hidden' id='aux[]' value='$estado_det_as'/>
		<input name='aux_mot[]' type='hidden' id='aux_mot[]' value='$motivo_det_as'/>
		<input name='cod' type='hidden' class='cajas' id='textfield' size='5' value='$cod_as' />
		<input name='area[]' type='hidden' class='cajas' id='textfield' size='5' value='$area' />
		<input name='rut[]' type='hidden' id='rut[]' value='$rut_det_as'/>
		</td>
	</td>
	</tr>"; 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Asistencia Rockmine</title>

<script type="text/javascript" language="JavaScript" src="inc/funciones.js"></script>

<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">
<LINK href="../inc/epoch_styles.css" type=text/css rel=stylesheet>
<SCRIPT src="../inc/epoch_classes.js" type=text/javascript></SCRIPT>
<script type="text/JavaScript" src="curvycorners.src.js"></script>

<script language="javascript" src="js/jquery-1.2.6.min.js"></script>

<script language="javascript">

function CambiaColor(esto,fondo,texto)
{
    esto.style.background=fondo;
    esto.style.color=texto;
}
 
function ir(url)
{
	document.f.action=url;
}

var dp_cal;
window.onload = function () {
	stime = new Date();
	dp_cal 	  = new Epoch('dp_cal','popup',document.getElementById('date_field'));
}; 

function validar(e) 
{
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13)
  {
  	document.f.busca.focus();
   	document.f.action ='contratos.php';
	document.f.submit();
  }
}

function mod()
{
	var agree=confirm("Esta Seguro de Querer Modificar Este Registro ?");
	if (agree){
		document.f.action='procesa_a.php'; 
		document.f.submit();
		return true ;
	}else{
		return false ;
	}
}

function eli()
{
	var agree=confirm("Esta Seguro de Querer Eliminar Este Informe ?");
	if (agree){
		document.f.action='procesa_a.php'; 
		document.f.submit();
		return true ;
	}else{
		return false ;
	}
}

function gen()
{
	var agree=confirm("Esta Seguro Que desea Ingresar la ODS ?");
	if (agree){
		document.f.action='procesa_a.php'; 
		document.f.submit();
		return true ;
	}else{
		return false ;
	}
}

function enviar_c1()
{
	document.f.c2.value= "";
	document.f.c3.value= "";
	document.f.submit();
}
function enviar()
{
	document.f.submit();
}
function enviar_c2()
{
	document.f.c3.value= "";
	document.f.submit();
}

function seleccionar_todo_p()
{
	var presente 	= document.getElementsByName("presente[]");
	var ausente 	= document.getElementsByName("ausente[]");
	var motivo 		= document.getElementsByName("motivo[]");
	var aux 		= document.getElementsByName("aux[]");
	var aux_mot 	= document.getElementsByName("aux_mot[]");
	var total       = presente.length;
	
  	for (i=0;i < total;i++)
	{
		motivo[i].disabled=true;
		presente[i].checked=1; 
		ausente[i].checked=0; 
		aux[i].value = 'Presente';
		aux_mot[i].value = '';
	}
} 

function fmot(valor)
{
	var motivo 	= document.getElementsByName("motivo[]");
	var aux_mot = document.getElementsByName("aux_mot[]");
	var total 	= aux_mot.length;
	
	aux_mot.value = valor;
	for(var x = 0; x < total; ++x)
   	{
		if(valor == motivo[x]) 
	 	{
			aux_mot[x].value = motivo[x].value;
		}
	}
}
function prueba()
{
	var motivo 		= document.getElementsByName("motivo[]");
	
	var t = motivo.length;
	
   	for(var x = 0; x < t; ++x)
   	{
		alert(motivo[x].value);
	}
}

function deseleccionar_todo_p(){ 
   for (i=0;i<document.f.elements.length;i++){
      	if(document.f.elements[i].type == "checkbox" && document.f.elements[i].name == "presente[]" ){
         	document.f.elements[i].checked=0; 
		} 
	}
} 

function seleccionar_todo_a()
{
	var presente 	= document.getElementsByName("presente[]");
	var ausente 	= document.getElementsByName("ausente[]");
	var motivo 		= document.getElementsByName("motivo[]");
	var aux 		= document.getElementsByName("aux[]");
	var aux_mot 	= document.getElementsByName("aux_mot[]");
	var obs	 		= document.getElementsByName("obs[]");
	var totala      = obs.length;
	
  	for (i=0;i < totala;i++)
	{
		motivo[i].disabled=false;
		presente[i].checked=0; 
		ausente[i].checked=1; 
		aux[i].value = 'Ausente';
		aux_mot[i].value = motivo[i].value;
	}
}

function deseleccionar_todo_a(){ 
   for (i=0;i<document.f.elements.length;i++){
      	if(document.f.elements[i].type == "checkbox" && document.f.elements[i].name == "ausente[]" ){
         	document.f.elements[i].checked=0 
		} 
	}
}

function cambiar(elemento)
{
	var presente 	= document.getElementsByName("presente[]");
	var ausente 	= document.getElementsByName("ausente[]");
	var motivo 		= document.getElementsByName("motivo[]");
	var aux 		= document.getElementsByName("aux[]");
	var aux_mot 	= document.getElementsByName("aux_mot[]");
	
	var t = aux.length;
   	for(var x = 0; x < t; ++x)
   	{
		if(elemento == presente[x]) 
	 	{
			if(elemento.checked == true) 
			{
				motivo[x].value	= '';
				motivo[x].disabled	=true;
				ausente[x].checked	=false;
				aux[x].value = 'Presente';
				aux_mot[x].value = '';
			}else{
				motivo[x].disabled	=false;
			}
		}
		if(elemento == ausente[x]) 
	 	{
			if(elemento.checked == true) 
			{
				motivo[x].disabled	=false;
				presente[x].checked	=false;
				aux[x].value = 'Ausente';
			}else{
				motivo[x].disabled	=true;
			}
		}
	}
}

/***********************************************************************************************************************

***********************************************************************************************************************/
function cambiar2()
{
	var presente 	= document.getElementsByName("presente[]");
	var ausente 	= document.getElementsByName("ausente[]");
	var aux		 	= document.getElementsByName("aux[]");
	var aux		 	= document.getElementsByName("aux[]");
	var motivo 		= document.getElementsByName("motivo[]");
	
	var t = aux.length;
   	for(var x = 0; x < t; ++x)
   	{
		if(presente[x].checked == true) 
		{
			aux[x].value = 'Presente';
			motivo[x].disabled	=true;
		}else{
			aux[x].value = 'Ausente';
			aux_mot[x].value = motivo[x].value;
		}
	}
}

  addEvent(window, 'load', initCorners);

  function initCorners() {
    var settings = {
      tl: { radius: 25 },
      tr: { radius: 25 },
      bl: { radius: 0 },
      br: { radius: 0 },
      antiAlias: true
    }
    //curvyCorners(settings, "#myBox");
	curvyCorners(settings, "#myBox2");
	//curvyCorners(settings, "#myBox3");
  }
 
</script>

<style type="text/css" media="all">

#myBox2 {
    color: #fff;
    width: 97%;
    padding: 4px;
    text-align: justify;
    background-color: #cedee1;
    border: 3px solid #fff;
}

body {
	background-color: #5a88b7;
}

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
    </style>

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
<?php 	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);		
//**********************************************************************************************************************************/
if(($_POST['limpia'] != "Limpiar" and $_POST['elimina'] != "Eliminar"))
{
/**********************************************************************************************************************************
			CARGAMOS LOS DATOS DEL CODIGO QUE NOS ENVIO LA GRILLA
**********************************************************************************************************************************/	

	if($_POST['Mod_a'] != "")
	{
		$llave = $_POST['Mod_a'];
	}
	if($_POST['Ing_a'] != "")
	{
		$llave = $_POST['Ing_a'];
	}
	if($_POST['elimina'] != "")
	{
		$llave = $_POST['elimina'];
	}
	if($_POST['busca'] != "")
	{
		$llave = $_POST['busca'];
	}
// SI SE SELECCIONO UN INFORME DE LA LISTA
	if($_GET['cod'] != "")
	{
		$llave = $_GET['cod'];
	}
	
	$sqlc="SELECT * FROM asistencia WHERE cod_as = '$llave' ";
	$respuesta=mysql_query($sqlc,$co);
	while($vrows=mysql_fetch_array($respuesta))
	{
		$cod_as		= "".$vrows['cod_as']."";
		$area_as	= "".$vrows['area_as']."";
		$fecha_as	= "".$vrows['fecha_as']."";
		$ing_as		= "".$vrows['ing_as']."";  							
	}
		
		$sqlrep = "SELECT * FROM detalle_as WHERE cod_as = '$cod_as'";
		$resrep = dbExecute($sqlrep);
		while ($vrows_rep = mysql_fetch_array($resrep)) 
		{
    		$det_as[] = $vrows_rep;
		}
		
		if($fecha_as  == "0000-00-00"){$fecha_as  		="";}
}
?>
<table width="944" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#f2f2f2">
<tr>
      <td align="center">
        <table width="931" height="362" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F2F2F2">
          <tr>
            <td width="100" height="54" align="left" valign="top"><img src="../imagenes/logo2.jpg" width="100" height="60" /></td>
            <td width="739" align="center" valign="middle"><img src="../imagenes/Titulos/ASISTENCIA.png" width="400" height="40" /></td>
            <td width="100" align="left" valign="top"><img src="../imagenes/logo_iso_c.jpg" width="100" height="52" /></td>
          </tr>
          <tr>
            <td height="3" colspan="3" align="center" valign="top"><img src="../imagenes/barra.gif" width="100%" height="3" /></td>
          </tr>
          <tr>
            <td height="297" colspan="3" align="center" valign="top"><table width="939" height="297" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
                <tr>
                  <td width="933" height="274" align="center" valign="top"><form id="f" name="f" method="post" action="">
                    <table width="918" height="342" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
                      <tr>
                        <td height="51" align="center"><label></label>
                            <div  id="myBox2" class="txtnormal">
                              <table width="898" height="66" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td width="100" height="62" align="right"><label>
                                    <input name="in" type="submit" class="boton_inicio" id="in" value="Produccion" onclick="ir('../index2.php')" />
                                  </label></td>
                                  <td width="181" align="right">&nbsp;</td>
                                  <td width="100" align="center">&nbsp;</td>
                                  <td width="100" align="center">&nbsp;</td>
                                  <td width="100" align="center"><input name="button5" type="submit" class="boton_usuariosG" id="button9" value="Trabajadores" onclick="ir('../trabajadores.php')"  /></td>
                                  <td width="100" align="center"><label>
                                    <input name="button2" type="submit" class="boton_repg" id="button7" value="Mantenedores" onclick="ir('m_mant.php')"  />
                                  </label></td>
                                  <td width="100" align="center"><input name="button11" type="submit" class="boton_report" id="button14" value="Reportes" onclick="ir('lista.php')"  /></td>
                                  <td width="100" align="center"><input name="button4" type="button" class="boton_print" id="button2" value="Imprimir" onclick="rep()" disabled="disabled" /></td>
                                  <td width="17" align="right"><input type="hidden" name="usuario_nombre" id="usuario_nombre" value="<?php echo $_SESSION['usuario_nombre']; ?> " /></td>
                                </tr>
                              </table>
                          </div></td>
                      </tr>
                      <tr>
                        <td height="225" align="center" valign="top"><table width="902" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#cedee1">
                          <tr>
                            <td width="898" align="center"><table width="895" height="213" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="3" rowspan="3">&nbsp;</td>
                                <td width="84" height="7" align="left" class="txtnormal">&nbsp;</td>
                                <td width="145" align="left" class="txtnormal"><label></label></td>
                                <td width="33" rowspan="3" align="left" class="txtnormal"><span class="content"> </span></td>
                                <td width="92" rowspan="3" align="left" class="txtnormal">&nbsp;</td>
                                <td width="124" rowspan="3" align="left" class="txtnormal"><label></label></td>
                                <td width="92" rowspan="3" align="left" class="txtnormal">&nbsp;</td>
                                <td width="320" rowspan="3" align="left" class="txtnormal"><label></label></td>
                              </tr>
                              <tr>
                                <td height="8" align="left" class="txtnormal">FECHA</td>
                                <td width="145" align="left" class="txtnormal"><span class="content">
                                  <? $ent_par1	=	cambiarFecha($ent_par1, '-', '/' ); 
								  if($_POST['f1'] != ""){$fe = $_POST['f1']; }
								  
								  ?>
                                  <input name="f1" class="cajas" id="date_field" style="WIDTH: 7em" value="<? echo $fe; ?>" />
                                  <input type="button" class="botoncal" onclick="dp_cal.toggle();"  onmouseup="oculta('aux')" />
                                  </span></td>
                              </tr>
                              <tr>
                                <td height="15" align="left" class="txtnormal">&nbsp;</td>
                                <td width="145" align="left" class="txtnormal">&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="3" rowspan="2">&nbsp;</td>
                                <td height="0" colspan="2" align="left" class="txtnormal">
                                  GERENCIA</td>
                                <td colspan="3" align="left" class="txtnormal">DEPARTAMENTO&nbsp;</td>
                                <td colspan="2" align="left" class="txtnormal">AREA&nbsp; </td>
                                </tr>
                              <tr>
                                <td height="15" colspan="2" align="left" class="txtnormal"><?
								if($_POST['c1'] != "" ){
									$co=mysql_connect("$DNS","$USR","$PASS");
									mysql_select_db("$BDATOS", $co);
						
									$sql_g	= "SELECT * FROM tb_gerencia WHERE cod_ger = '".$_POST['c1']."' ";
									$res_g	= mysql_query($sql_g,$co);
									while($vrowsg=mysql_fetch_array($res_g))
									{
										$ger_d	= "".$vrowsg['desc_ger']."";
										$ger_c	= "".$vrowsg['cod_ger']."";
									}
								}
								  if($ger == "" ){$ger = "Selecione...";}
								  
								?>
                                  <select name="c1" class="combos" id="c1" style="width: 180px; background-color:#FFF" onchange="enviar_c1()" >
                                    <?php
                              //*******************************************************************************************************
								$sql  = "SELECT cod_ger, desc_ger FROM tb_gerencia ORDER BY desc_ger ";
	
								$rs 	= dbConsulta($sql);
								$total  = count($rs);
								echo"<option selected='selected' value='$ger_c'>$ger_d</option>";
										
								for ($i = 0; $i < $total; $i++)
								{
									$desc_ger = $rs[$i]['desc_ger'];
									if($sel != $desc_ger){
										echo "<option value='".$rs[$i]['cod_ger']."'>".$rs[$i]['desc_ger']."</option>";
									}
								}
							?>
                                  </select></td>
                                <td colspan="3" align="left" class="txtnormal"><?
								if($_POST['limpia'] == "Limpiar"){$_POST['c2'] = "";}
								  if($_POST['c2'] != "" ){
									$co=mysql_connect("$DNS","$USR","$PASS");
									mysql_select_db("$BDATOS", $co);
							
									$sql_g	= "SELECT * FROM tb_dptos WHERE cod_dep = '".$_POST['c2']."' ";
									$res_g	= mysql_query($sql_g,$co);
									while($vrowsg=mysql_fetch_array($res_g))
									{
										$dpto_d	= "".$vrowsg['desc_dep']."";
										$dpto_c	= "".$vrowsg['cod_dep']."";
									}
								  }
								  
								  if($dpto == "" ){$dpto = "Selecione...";}
								  
								?>
                                  <select name="c2" class="combos" id="c2" style="width: 180px; background-color:#FFF" onchange="enviar_c2()">
                                    <?php 
                                $sql  = "SELECT * FROM tb_dptos WHERE cod_ger = '".$_POST["c1"]."' ORDER BY desc_dep";
										
                                $rs 	= dbConsulta($sql);
								$total  = count($rs);
								echo"<option selected='selected' value='$dpto_c'>$dpto_d</option>";
										
								for ($i = 0; $i < $total; $i++)
								{
									$desc_dep = $rs[$i]['desc_dep'];
									//if($sel != $desc_ar){
										echo "<option value='".$rs[$i]['cod_dep']."'>".$rs[$i]['desc_dep']."</option>";
									//}
								}
								?>
                                  </select></td>
                                <td colspan="2" align="left" class="txtnormal"><?
								  if($_POST['limpia'] == "Limpiar"){$_POST['c3'] = "";}
								  
								  if($_POST['c3'] != "" ){
									$co=mysql_connect("$DNS","$USR","$PASS");
									mysql_select_db("$BDATOS", $co);
						
									$sql_g	= "SELECT * FROM tb_areas WHERE cod_ar = '".$_POST['c3']."' ";
									$res_g	= mysql_query($sql_g,$co);
									while($vrowsg=mysql_fetch_array($res_g))
									{
										$area_d	= "".$vrowsg['desc_ar']."";
										$area_c = "".$vrowsg['cod_ar']."";
									}
								  }
								  
								  if($dpto == "" ){$dpto = "Selecione...";}
								  
								?>
                                  <select name="c3" class="combos" id="c3" style="width: 400px; background-color:#FFF" onchange="enviar()">
                                    <?php 
                                $sql  = "SELECT * FROM tb_areas WHERE cod_dep = '".$_POST["c2"]."' ORDER BY desc_ar";
										
                                $rs 	= dbConsulta($sql);
								$total  = count($rs);
								echo"<option selected='selected' value='$area_c'>$area_d</option>";
										
								for ($i = 0; $i < $total; $i++)
								{
									$desc_ar = $rs[$i]['desc_ar'];
									//if($sel != $desc_ar){
										echo "<option value='".$rs[$i]['cod_ar']."'>".$rs[$i]['desc_ar']."</option>";
									//}
								}
								?>
                                  </select></td>
                                </tr>
                              <tr>
                                <td width="3">&nbsp;</td>
                                <td height="24" align="left" class="txtnormal">&nbsp;</td>
                                <td width="145" align="left" class="txtnormal">&nbsp;</td>
                                <td align="left" class="txtnormal">&nbsp;</td>
                                <td align="left" class="txtnormal">&nbsp;</td>
                                <td width="124" align="left" class="txtnormal"><label></label></td>
                                <td width="92" align="left" class="txtnormal">&nbsp;</td>
                                <td width="320" align="left" class="txtnormal">&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="3" height="22">&nbsp;</td>
                                <td colspan="7" rowspan="3" align="center" valign="top" class="txtnormal">
								
<?php
if($_POST['limpia'] != "Limpiar" and $_POST['ingresa'] != "Ingresar" and $_GET['cod'] != "" or $_POST['Ing_a'] != "" or $_POST['Mod_a'] != "")
{
	$i				= 0;
	$cont_det	 	= count($det_as);
/*************************************************************************************
			COMENZAMOS EL WHILE DE TRABAJADORES POR SECCION
********************************************************************************************************************************/
	encabezado();
	$color = "#ffffff";	
	while($i < $cont_det)
	{
		$cod_det_as			= $det_as[$i]['cod_det_as'];
		$rut_det_as			= $det_as[$i]['rut_det_as'];
		$estado_det_as 		= $det_as[$i]['estado_det_as'];
		$motivo_det_asv 	= $det_as[$i]['motivo_det_as'];
		$observ_det_as 		= $det_as[$i]['observ_det_as'];
		$num                = ($i + 1);
		
		if($estado_det_as == "Presente" )
		{
			$check1	= "checked";
		}else{
			$check1	= "";
		}
		if($estado_det_as == "Ausente" )
		{
			$check2	= "checked";
		}else{
			$check2	= "";
		}
		
		$co=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS", $co);
		
		$sql_u = "SELECT * FROM trabajadores WHERE rut_t = '$rut_det_as' ";
		$rest=mysql_query($sql_u,$co);
		
		while($vrowst=mysql_fetch_array($rest))
		{
			$nom_trab	= $vrowst['nom_t'];
			$app_trab	= $vrowst['app_t'];
			$apm_trab 	= $vrowst['apm_t'];
			$area_t 	= $vrowst['area_t'];
			$rut_t	 	= $vrowst['rut_t'];
			
			filanm($num, $cod_det_as, $nom_trab, $app_trab, $apm_trab, $rut_t, $estado_det_as, $motivo_det_asv, $observ_det_as, $check1, $check2, $color, $cod_as, $area_t);
			
			if($color == "#ffffff"){ $color = "#ededed"; }
			else{ $color = "#ffffff"; }
		}
		$i++;
	}
fin();
}


//********************************************************************************************************
if($_POST['limpia'] != "Limpiar" and $_GET['cod'] == "" and $_POST['c3'] != "")
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);

	$_POST['f1']	=	cambiarFecha($_POST['f1'], '/', '-' ); 
	
	unset($sqlc);
	$sqlc		= "SELECT * FROM trabajadores WHERE area_t = '".$_POST["c3"]."' ";
	$respuesta	= mysql_query($sqlc,$co);
	$cant   	= mysql_num_rows($respuesta);
	
	if($cant == 0)	// SI NO ENCONTRO NINGUN REGISTRO ENVIAMOS UN MENSAJE
	{
		//alert("No Se Encontraron Registros");
	}else{			// DE LO CONTRARIO MOSTRAMOS LOS REGISTROS
		unset($trabajadores);
		while($vrowst=mysql_fetch_array($respuesta))
		{
			$trabajadores[]	= $vrowst;							
		}

		encabezado();

		$i = 0;
		$total_t = count($trabajadores);
		$color = "#ffffff";	
		while($i < $total_t)
		{
			$rut_t	 	= $trabajadores[$i]['rut_t'];
			$nom_t		= $trabajadores[$i]['nom_t'];
			$app_t	 	= $trabajadores[$i]['app_t'];
			$apm_t		= $trabajadores[$i]['apm_t'];
			$area_t		= $trabajadores[$i]['area_t'];
			$fe_nulo	= $trabajadores[$i]['fe_nulo'];
			$num		= ($i + 1);
			// comparamos la fecha de baja del trabajador con la fecha del informe.... si la fe del informe es menor a la fecha de baja lo mostramos
			$resul = comparar_fechas($_POST['f1'], $fe_nulo);
			
			if($resul == "Menor" or $fe_nulo == "0000-00-00")
			{									
				filanm($num, $cod_det_as, $nom_t, $app_t, $apm_t, $rut_t, $estado_det_as, $motivo_det_asv, $observ_det_as, $check1, $check2, $color, $cod_as, $area_t);
			}
			
			if($color == "#ffffff"){ $color = "#ededed"; }
			else{ $color = "#ffffff"; }
			$i++;
		}
		fin();
	}
}






//********************************************************************************************************
if($_POST['limpia'] != "Limpiar" and $_GET['cod'] == "" and $_POST['c2'] != "" and $_POST['c3'] == "")
{
	encabezado();
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sqla 	= "SELECT * FROM tb_areas WHERE cod_dep = '".$_POST["c2"]."' ORDER BY desc_ar";
	$result = mysql_query($sqla,$co);
	
	while($vrowsa = mysql_fetch_array($result))
	{
		$areas[]	= $vrowsa;
	}
	
	$x				= 0;
	$cont_ar	 	= count($areas);

	while($x < $cont_ar)
	{
		$desc_ar	= $areas[$x]['desc_ar'];
		$cod_ar		= $areas[$x]['cod_ar'];
	
		unset($sqlc);
		$sqlc		= "SELECT * FROM trabajadores WHERE area_t = '$cod_ar' and est_alta = 'Vigente' ";
		
		$respuesta	= mysql_query($sqlc,$co);
		$cant   	= mysql_num_rows($respuesta);
		
		if($cant == 0)	// SI NO ENCONTRO NINGUN REGISTRO ENVIAMOS UN MENSAJE
		{
			//alert("No Se Encontraron Registros");
		}else{			// DE LO CONTRARIO MOSTRAMOS LOS REGISTROS
			unset($trabajadores);
			while($vrowst=mysql_fetch_array($respuesta))
			{
				$trabajadores[]	= $vrowst;							
			}
	
			$i = 0;
			$total_t = count($trabajadores);
			$color = "#ffffff";	
			while($i < $total_t)
			{
				$rut_t	 	= $trabajadores[$i]['rut_t'];
				$nom_t		= $trabajadores[$i]['nom_t'];
				$app_t	 	= $trabajadores[$i]['app_t'];
				$apm_t		= $trabajadores[$i]['apm_t'];
				$area_t		= $trabajadores[$i]['area_t'];
				$num		= ($i + 1);
									
				filanm($num, $cod_det_as, $nom_t, $app_t, $apm_t, $rut_t, $estado_det_as, $motivo_det_asv, $observ_det_as, $check1, $check2, $color, $cod_as, $area_t);
				
				if($color == "#ffffff"){ $color = "#ededed"; }
				else{ $color = "#ffffff"; }
				$i++;
			}
			
		}
		$x++;
	}fin();
}
?>
                                    <div id="resultado"></div><br></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td height="15">&nbsp;</td>
                              </tr>
                            </table></td>
                          </tr>
                        </table>
                        <!-- <div id="myBox" class="txtnormal">-->                          <!-- </div>--></td>
                      </tr>
                      <tr>
                       <?php  
							  if($_SESSION['usuario_nivel'] > 0 and $_SESSION['usuario_nivel'] != 11){
							  	$est = "disabled='disabled'";
							  }else{
							  $est = "";
							  }
						?>
                        <td height="37" align="center" valign="bottom"><label>
                          <input name="ingresa" type="submit" class="boton_ing" id="button3" value="Ingresar" onclick="return gen()"/>
                          &nbsp; </label>
                            <input name="modifica" type="submit" class="boton_mod" id="button4" value="Modificar" onclick="return mod()"  <?php echo $est; ?>/>
                          &nbsp;
                          <input name="elimina" type="submit" class="boton_eli" id="button5" value="Eliminar" onclick="return eli()" <?php echo $est; ?>/>
                          &nbsp;
                          <input name="limpia" type="submit" class="boton_lim" id="button6" value="Limpiar" />
                          &nbsp;
                        <!-- <input name="report2" type="button" class="boton_imp" onclick="document.f.action='rep_fsr.php'; document.f.submit()" value="Solicitud R"; /> -->&nbsp;                        </td>
                      </tr>
                    </table>
                  </form></td>
                </tr>
                <tr>
                  <td height="17" align="center" valign="top">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="5" colspan="3" align="center" valign="top"><img src="imagenes/barra.gif" alt="" width="910" height="3" /></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
