<?
// Necesario para ver si la session esta activa  o si se tiene permiso de accseso
require("lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php

if ($_SESSION['us_tipo'] != "Administrador"){
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}
//Hasta aquí lo comun para todas las paginas restringidas

/*****************************************************************************************************
	SE INCLUYEN ARCHIVOS DE CONFIGURACION Y FUNCIONES
*****************************************************************************************************/
	include('inc/config_db.php'); 	// Incluimos archivo de configuracion de la conexion
	include('inc/lib.db.php');		// Incluimos archivo de libreria de funciones PHP
/*****************************************************************************************************	
/*****************************************************************************************************
							Inicializamos las variables de los combos
*****************************************************************************************************/	
	$linea		="---------------------------";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mantenedor de Usuarios</title>

<!-- HOJA DE ESTILO -->
<link href="inc/bibliocss.css" rel="stylesheet" type="text/css">

<!-- MENU -->
<script type="text/javascript" language="JavaScript1.2" src="inc/stmenu.js"></script>

<script type="text/javascript" language="JavaScript" src="inc/funciones.js"></script>

<!-- CALENDARIO -->
<LINK href="inc/epoch_styles.css" type=text/css rel=stylesheet>
<SCRIPT src="inc/epoch_classes.js" type=text/javascript></SCRIPT>

<SCRIPT type=text/javascript>
var dp_cal,dp_cal2;      
window.onload = function () {
	stime = new Date();

	dp_cal   = new Epoch('dp_cal','popup',document.getElementById('date_field'));
	dp_cal2   = new Epoch('dp_cal2','popup',document.getElementById('date_field2'));
}; 
</SCRIPT>

<!-- CONFIRMACIONES -->
<script LANGUAGE="JavaScript">
function eli()
{
var agree=confirm("Esta Seguro de Querer Eliminar Este Registro ?");
if (agree)
	return true ;
else
	return false ;
}

function ing()
{
	var agree=confirm("Esta Seguro Que desea Ingresar El Registro ?");
	if (agree){
		document.formus.action='procesa.php'; 
		document.formus.submit();
		return true ;
	}else{
		return false ;
	}
}


function mod()
{
	var agree=confirm("Esta Seguro Que desea Modificar El Registro ?");
	if (agree){
		document.formus.action='procesa.php'; 
		document.formus.submit();
		return true ;
	}else{
		return false ;
	}
}

function CambiaColor(esto, fondo, texto)
{
    esto.style.background=fondo;
    esto.style.color=texto;
	esto.style.cursor='hand';
}

			
function carga(us_id, us_rut, us_nombre, us_cargo, us_usuario, us_pass, us_correo, us_tipo, us_ing_internet, sol_lee, sol_ing, sol_ap_dep, sol_ap_ger, sol_ap_bod, sol_us_bod, sol_us_adq, cot_lee, cot_ing, cot_mod, cot_eli)
{
    document.fformus.us_id.value 			= us_id;
	document.fformus.us_rut.value 			= us_rut;
	document.fformus.us_nombre.value 		= us_nombre;
	document.fformus.us_cargo.value 		= us_cargo;
	document.fformus.us_usuario.value 		= us_usuario;
	document.fformus.us_pass.value 			= us_pass;
	document.fformus.us_correo.value 		= us_correo;
	document.fformus.us_tipo.value 			= us_tipo;
	document.fformus.us_ing_internet.value 	= us_ing_internet;
	
	if(sol_lee == 1){document.fformus.sol_lee.checked 		= true; }else{document.fformus.sol_lee.checked = false; }
	if(sol_ing == 1){document.fformus.sol_ing.checked 		= true; }else{document.fformus.sol_ing.checked = false; }
	if(sol_ap_dep == 1){document.fformus.sol_ap_dep.checked = true; }else{document.fformus.sol_ap_dep.checked = false; }
	if(sol_ap_ger == 1){document.fformus.sol_ap_ger.checked = true; }else{document.fformus.sol_ap_ger.checked = false; }
	if(sol_ap_bod == 1){document.fformus.sol_ap_bod.checked = true; }else{document.fformus.sol_ap_bod.checked = false; }
	if(sol_us_bod == 1){document.fformus.sol_us_bod.checked = true; }else{document.fformus.sol_us_bod.checked = false; }
	if(sol_us_adq == 1){document.fformus.sol_us_adq.checked = true; }else{document.fformus.sol_us_adq.checked = false; }
	if(cot_lee == 1){document.fformus.cot_lee.checked 		= true; }else{document.fformus.cot_lee.checked = false; }
	if(cot_ing == 1){document.fformus.cot_ing.checked 		= true; }else{document.fformus.cot_ing.checked = false; }
	if(cot_mod == 1){document.fformus.cot_mod.checked 		= true; }else{document.fformus.cot_mod.checked = false; }
	if(cot_eli == 1){document.fformus.cot_eli.checked 		= true; }else{document.fformus.cot_eli.checked = false; }
	
}
/**********************************************************************************
						FIN FUNCION PARA CREAR LINEAS
**********************************************************************************/
function enviar(url)
{
	document.fformus.action=url;
}

</SCRIPT>
<style type="text/css">
<!--
body {
	background-color: rgb(90, 136, 183);
}
.Estilo8 {font-size: 10px}
.Estilo9 {font-size: 10}
-->
</style>
</head>

<body>
<?php
/***********************************************************************************************************
								BUSCAMOS EL TRABAJADOR
************************************************************************************************************/
if($_POST['busca'] == "Buscar")
{	
	$identificador = $_POST['us_id'];
}
if($_POST['ingresa'] != "")
{
	$identificador = $_POST['ingresa'];
}
if($_POST['modifica'] != "")
{
	$identificador = $_POST['modifica'];
}
if($_POST['elimina'] != "")
{
	$identificador = $_POST['elimina'];
}
/***********************************************************************************************************
								
************************************************************************************************************/
if($_POST['busca'] == "Buscar" or $_POST['ingresa'] != "" or $_POST['modifica'] != "" or $_POST['elimina'] != "")
{
		$cone=mysql_connect("$DNS","$USR","$PASS");
		mysql_select_db("$BDATOS",$cone);
		
		$ssql = "SELECT * FROM tb_usuarios WHERE us_id ='$identificador' ";
		$resp = mysql_query($ssql,$cone);
		$nreg = mysql_num_rows($resp);
		
		while($vrows=mysql_fetch_array($resp))
		{
			$us_id				= "".$vrows['us_id']."";
			$us_usuario			= "".$vrows['us_usuario']."";
			$us_pass 			= "".$vrows['us_pass']."";
			$us_rut 			= "".$vrows['us_rut']."";
			$us_nombre 			= "".$vrows['us_nombre']."";
			$us_cargo 			= "".$vrows['us_cargo']."";
			$us_correo 			= "".$vrows['us_correo']."";
			$us_ing_internet 	= "".$vrows['us_ing_internet']."";
			$us_tipo 			= "".$vrows['us_tipo']."";
			
			$usd_sol_lee 		= "".$vrows['usd_sol_lee']."";
			$usd_sol_ing 		= "".$vrows['usd_sol_ing']."";
			$usd_sol_ap_dep 	= "".$vrows['usd_sol_ap_dep']."";
			$usd_sol_ap_ger 	= "".$vrows['usd_sol_ap_ger']."";
			$usd_sol_ap_bod 	= "".$vrows['usd_sol_ap_bod']."";
			$usd_sol_us_bod 	= "".$vrows['usd_sol_us_bod']."";
			$usd_sol_us_adq 	= "".$vrows['usd_sol_us_adq']."";
			$usd_cot_lee		= "".$vrows['usd_cot_lee']."";
			$usd_cot_ing		= "".$vrows['usd_cot_ing'].""; 
			$usd_cot_mod 		= "".$vrows['usd_cot_mod']."";
			$usd_cot_eli		= "".$vrows['usd_cot_eli']."";
		}
		
		if($usd_cot_eli 	== "1"){ $sol_lee 		= "checked"; }else{$sol_lee 	= ""; }
		if($usd_sol_ing 	== "1"){ $sol_ing 		= "checked"; }else{$sol_ing 	= ""; }
		
		if($usd_sol_ap_dep 	== "1"){ $sol_ap_dep 	= "checked"; }else{$sol_ap_dep 	= ""; }
		if($usd_sol_ap_ger 	== "1"){ $sol_ap_ger 	= "checked"; }else{$sol_ap_ger 	= ""; }
		if($usd_sol_ap_bod 	== "1"){ $sol_ap_bod 	= "checked"; }else{$sol_ap_bod 	= ""; }
		
		if($usd_sol_us_bod 	== "1"){ $sol_us_bod 	= "checked"; }else{$sol_us_bod 	= ""; }
		if($usd_sol_us_adq 	== "1"){ $sol_us_adq 	= "checked"; }else{$sol_us_adq 	= ""; }
		
		if($usd_cot_lee 	== "1"){ $cot_lee 		= "checked"; }else{$cot_lee 	= ""; }
		if($usd_cot_ing 	== "1"){ $cot_ing 		= "checked"; }else{$cot_ing 	= ""; }
		if($usd_cot_mod 	== "1"){ $cot_mod 		= "checked"; }else{$cot_mod 	= ""; }
		if($usd_cot_eli 	== "1"){ $cot_eli 		= "checked"; }else{$cot_eli 	= ""; }
}
?>
<table width="961" height="418" border="0" align="center" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="100" height="54" align="center" valign="top"><img src="imagenes/logo2.jpg" width="127" height="60" /></td>
    <td width="747" align="center" valign="middle"><img src="imagenes/Titulos/USUARIOS.png" width="500" height="47" /></td>
    <td width="100" align="center" valign="top"><img src="imagenes/logo_iso_c.jpg" width="100" height="52" /></td>
  </tr>
  
  <tr>
    <td height="357" colspan="3" align="center" valign="top">

    <form id="formus" name="fformus" method="post" action="">
    <table width="947" height="334" border="0" class="txtnormal">
    <tr>
      <td height="68" align="center" valign="top">
      
      <table width="941" height="70" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="<?php echo $ColorMotivo; ?>">
        <tr>
          <td width="937" height="68" align="center"><table width="899" height="66" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="82" height="62" align="center"><input name="Volver2" type="submit" class="boton_volver" id="Volver2" value="Volver" onclick="enviar('index2.php');" /></td>
              <td width="82" align="right"><input name="Volver4" type="submit" class="boton_actualizar" id="Volver4" value="Actualizar" /></td>
              <td width="112" align="center"><!-- &nbsp;<a href="#dialog" name="modal">Reportes De No Conformidades</a>--></td>
              <td width="96" align="center">&nbsp;</td>
              <td width="110" align="center">&nbsp;</td>
              <td width="100" align="center">&nbsp;</td>
              <td width="102" align="center">&nbsp;</td>
              <td width="215" align="right"><span class="txtnormaln">
                <input name="consulta" type="submit" class="boton_lista2" value="Listar Usuarios" />
              </span></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
    <tr>
        <td width="941" height="252" align="center" valign="top">
          <table width="941" height="218" border="1" bordercolor="#FFFFFF" bgcolor="#cedee1">
            <tr>
              <td width="931" height="212" align="center"><table width="919" border="0" cellpadding="3" cellspacing="0" class="txtnormal">
                <tr>
                  <td colspan="6" align="center" class="txtnormaln">&nbsp;</td>
                  </tr>
                <tr>
                  <td width="176" align="left" class="txtnormaln">&nbsp;&nbsp;Codigo</td>
                  <td colspan="2" align="left">
                    <input name="us_id" type="text" class="txtnormal" id="us_id" size="10" value="<? echo $us_id; ?>"/>
                    <input name="busca" type="submit" class="boton_bus" id="button" value="Buscar" />
                  </td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                </tr>
                <tr>
                  <td width="176" align="left">&nbsp;&nbsp;Rut</td>
                  <td colspan="2" align="left"><input name="us_rut" type="text" class="txtnormal" id="us_rut" size="10" value="<? echo $us_rut; ?>" onchange="Valida_Rut(this)" />
                    <span class="Estilo8">&nbsp;Ej. 13876345-3</span></td>
                  <td align="left">&nbsp;&nbsp;Nombre </td>
                  <td colspan="2" align="left"><input name="us_nombre" type="text" class="txtnormal" id="us_nombre" size="50" value="<? echo $us_nombre; ?>" /></td>
                  </tr>
                <tr>
                  <td align="left" class="txtnormal">&nbsp;&nbsp;Cargo</td>
                  <td colspan="2" align="left"><input name="us_cargo" type="text" class="txtnormal" id="us_cargo" size="50" value="<? echo $us_cargo; ?>" /></td>
                  <td width="135" align="left">&nbsp;&nbsp;Correo</td>
                  <td colspan="2" align="left"><input name="us_correo" type="text" class="txtnormal" id="us_correo" size="50" value="<? echo $us_correo; ?>" /></td>
                </tr>
                <tr>
                  <td align="left" class="txtnormal">&nbsp;&nbsp;Usuario</td>
                  <td colspan="2" align="left"><input name="us_usuario" type="text" class="txtnormal" id="us_usuario" size="50" value="<? echo $us_usuario; ?>" /></td>
                  <td align="left">&nbsp;&nbsp;Password</td>
                  <td colspan="2" align="left"><input name="us_pass" type="text" class="txtnormal" id="us_pass" size="50" value="<? echo $us_pass; ?>" /></td>
                </tr>
                <tr>
                  <td align="left" class="txtnormal">&nbsp;&nbsp;Tipo Usuario</td>
                  
                  <td colspan="2" align="left">
                  
                  <select name="us_tipo" id="us_tipo" style="width:150px;">
                    <?php echo"<option selected='selected' value='$us_tipo'>$us_tipo</option>"; ?>
                    <option value="Administrador">Administrador</option>
                    <option value="Coordinador">Coordinador</option>
                    <option value="Supervisor">Supervisor</option>
                    <option value="Estandart" selected>Estandart</option>
                  </select>
                  
                  </td>
                  
                  <td align="left">&nbsp; Acceso desde internet</td>
                  
                  <td colspan="2" align="left">
                  <select name="us_ing_internet" id="us_ing_internet" style="width:50px;">
                    <?php echo"<option selected='selected' value='$us_ing_internet'>$us_ing_internet</option>"; ?>
                    <option value="Si" selected>Si</option>
                    <option value="No">No</option>
                  </select>
                  </td>
                  
                </tr>
                <tr>
                  <td align="left">&nbsp;</td>
                  <td colspan="2" align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td colspan="2" align="left">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" class="txtnormaln">&nbsp;&nbsp;Acceso a Cotizaciones</td>
                  <td width="144" align="left">
                  <label><input type="checkbox" name="cot_lee" id="cot_lee" <?php echo $cot_lee ?> />Lectura</label>
                  </td>
                  <td width="136" align="left">&nbsp;
                  <label><input type="checkbox" name="cot_ing" id="cot_ing" <?php echo $cot_ing ?> >Ingresar</label>
                  </td>
                  <td align="left">&nbsp;
                  <label><input type="checkbox" name="cot_mod" id="cot_mod" <?php echo $cot_mod ?> />Modificar</label>
                  </td>
                  <td width="151" align="left">&nbsp;
                  <label><input type="checkbox" name="cot_eli" id="cot_eli" <?php echo $cot_eli ?> />Eliminar</label>
                  </td>
                  <td width="141" align="left">&nbsp;</td>
                  </tr>
                <tr>
                  <td align="left" class="txtnormaln">&nbsp;&nbsp;Acceso a Solicitudes</td>
                  <td align="left">
                  <label><input type="checkbox" name="sol_lee" id="sol_lee" <?php echo $sol_lee ?> />Lectura</label>
                  </td>
                  <td align="left">&nbsp;
                    <label><input type="checkbox" name="sol_ing" id="sol_ing" <?php echo $sol_ing ?> />Ingresar</label>
                  </td>
                  <td align="left">&nbsp;
                    <label><input type="checkbox" name="sol_ap_dep" id="sol_ap_dep" <?php echo $sol_ap_dep ?> />Aprobar Dpto.</label>
                  </td>
                  <td align="left">&nbsp;
                    <label><input type="checkbox" name="sol_ap_ger" id="sol_ap_ger" <?php echo $sol_ap_ger ?> />Aprobar Gerencia</label>
                  </td>
                  <td align="left">&nbsp;
                    <label><input type="checkbox" name="sol_ap_bod" id="sol_ap_bod" <?php echo $sol_ap_bod ?> />Aprobar Bodega</label>
                  </td>
                  </tr>
                <tr>
                  <td align="left" class="txtnormaln">&nbsp;</td>
                  <td align="left">
                  <label><input type="checkbox" name="sol_us_bod" id="sol_us_bod" <?php echo $sol_us_bod ?> />Rebajar Solicitudes</label>
				  </td>
                  <td align="left">&nbsp;
                    <label><input type="checkbox" name="sol_us_adq" id="sol_us_adq" <?php echo $sol_us_adq ?> />Ingreso de OC</label>
				  </td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  </tr>
                <tr>
                  <td align="left" class="txtnormaln">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  </tr>
                <tr>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          </table>
          <table width="940" border="1" bordercolor="#FFFFFF" bgcolor="#cedee1">
            <tr>
              <td width="840" align="center"><label>
              
                  <input name="ingresaUs" type="submit" class="boton_ing" id="button3" value="Ingresar" onclick="return ing()" />
                  &nbsp;
                  
              </label>
                <label>
                
                <input name="modificaUs" type="submit" class="boton_mod" id="modifica" value="Modificar" onclick="return mod()" />
                </label>
                &nbsp;&nbsp;
                <label>
                
                <input name="elimina" type="submit" class="boton_eli" id="elimina" value="Eliminar" onclick="return eli()" />
				</label>
                &nbsp;&nbsp;
                
                <input name="limpia" type="submit" class="boton_lim" id="button6" value="Limpiar" onclick="limpia();" />
                &nbsp;&nbsp;&nbsp;</td>
            </tr>
          </table>
          <label></label>
               
        </td>
      </tr>
      
    </table>
    </form> 

    <table width="941" border="1" bordercolor="#FFFFFF" bgcolor="#999999" class="txtnormal" cellspacing="1" cellpadding="0">
      <tr bgcolor="#CCCCCC" class="txtnormaln">
        <td width="3%" align="left" bgcolor="#CCCCCC" >.......</td> 
        <td width="5%" align="left" bgcolor="#CCCCCC">Codigo</td>
        <td width="8%" align="left" bgcolor="#CCCCCC">Rut</td>
        <td width="16%" align="left" bgcolor="#CCCCCC">Usuario</td>
        <td width="27%" align="left" bgcolor="#CCCCCC">Password</td>
        <td width="20%" align="left" bgcolor="#CCCCCC">Nombre</td>
        <td width="21%" align="left" bgcolor="#CCCCCC">Tipo de usuario</td>
<?php
$nuevo=$_POST["t10"];	
/***********************************************************************************************************************
											ELIMINAMOS EL USUARIO
***********************************************************************************************************************/	
if($_POST['elimina'] == "Eliminar")
{
	if($_POST['us_id'] != "")
	{
		$sql = "DELETE FROM tb_usuarios WHERE us_id='".$_POST['us_id']."'";
		dbExecute($sql);
		alert("Eusuario eliminado con exito");
	}else{
		alert("Debe cargar usuario a eliminar");
	}

}
/***********************************************************************************************************************
										LISTAMOS TODOS LOS USUARIOS
***********************************************************************************************************************/
if($_POST['consulta'] == "Listar Usuarios")
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sql		= "SELECT * FROM tb_usuarios ORDER BY us_nombre";
	$respuesta	= mysql_query($sql,$co);
	$color		= "#ffffff";
	
	while($vrows=mysql_fetch_array($respuesta))
	{
			$us_id				= "".$vrows['us_id']."";
			$us_usuario			= "".$vrows['us_usuario']."";
			$us_pass 			= "".$vrows['us_pass']."";
			$us_rut 			= "".$vrows['us_rut']."";
			$us_nombre 			= "".$vrows['us_nombre']."";
			$us_cargo 			= "".$vrows['us_cargo']."";
			$us_correo 			= "".$vrows['us_correo']."";
			$us_ing_internet 	= "".$vrows['us_ing_internet']."";
			$us_tipo			= "".$vrows['us_tipo']."";
			
			$usd_sol_lee 		= "".$vrows['usd_sol_lee']."";
			$usd_sol_ing 		= "".$vrows['usd_sol_ing']."";
			$usd_sol_ap_dep 	= "".$vrows['usd_sol_ap_dep']."";
			$usd_sol_ap_ger 	= "".$vrows['usd_sol_ap_ger']."";
			$usd_sol_ap_bod 	= "".$vrows['usd_sol_ap_bod']."";
			$usd_sol_us_bod 	= "".$vrows['usd_sol_us_bod']."";
			$usd_sol_us_adq 	= "".$vrows['usd_sol_us_adq']."";
			$usd_cot_lee		= "".$vrows['usd_cot_lee']."";
			$usd_cot_ing		= "".$vrows['usd_cot_ing'].""; 
			$usd_cot_mod 		= "".$vrows['usd_cot_mod']."";
			$usd_cot_eli		= "".$vrows['usd_cot_eli']."";

		printf("<tr bgcolor=$color onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000') align='left'>	
					<td bgcolor='#ffc561'>&nbsp;<a href='#' onclick = 'carga(\"$us_id\", \"$us_rut\", \"$us_nombre\", \"$us_cargo\", \"$us_usuario\", \"$us_pass\", \"$us_correo\", \"$us_tipo\", \"$us_ing_internet\", \"$usd_sol_lee\", \"$usd_sol_ing\", \"$usd_sol_ap_dep\", \"$usd_sol_ap_ger\", \"$usd_sol_ap_bod\", \"$usd_sol_us_bod\", \"$usd_sol_us_adq\", \"$usd_cot_lee\", \"$usd_cot_ing\", \"$usd_cot_mod\", \"$usd_cot_eli\")';> <img src='imagenes/edit.png' border='0' valign='top' alt='Editar'/></a></td>
					<td>$us_id</td>
					<td>$us_rut</td>
					<td>$us_usuario</td>
					<td>$us_pass</td>
					<td>$us_nombre</td>
					<td>$us_tipo</td>
				</tr> ");
									
				if($color == "#ffffff"){ $color = "#ededed"; }
				else{ $color = "#ffffff"; }
	}
	mysql_close($co);
}	

?>

    </table></td>
  </tr>
  <tr>
    <td height="5" colspan="3" align="center" valign="top"><img src="imagenes/barra.gif" alt="" width="940" height="3" /></td>
  </tr>
</table>
</body>
</html>
