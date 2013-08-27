<?php
	include('../inc/config_db.php');	// CONECCION A LA BASE DE DATOS
	require('../inc/lib.db.php');
	
function filan($id_det, $rut_cc, $nom_cont, $mail_cont, $fono_cont)
{
	if($_SESSION['usuario_pyc'] == "administrador")
	{
		$lectura = "";
	}else{
		$lectura = "readonly ='readonly'";
	}
	
	 echo"<tr border='0' bgcolor='#ffffff'>
        <td>
        	<input name='nom_cont[]' type='text' class='cajas' style='width: 240px' value='$nom_cont'/>&nbsp; 
		</td>
        <td>
         	<input name='mail_cont[]' type='text' class='cajas' style='width: 240px' value='$mail_cont'/>&nbsp; 
		</td>
        <td>
        	<input name='fono_cont[]' type='text' class='cajas' style='width: 100px' value='$fono_cont'/>&nbsp;
			<input name='id_det[]' type='hidden' value='$id_det' style='width: 20px'/>
        </td>
		
		<td align='center'>";
		$tabla = "tb_contacto_cli";
		$dest  = "poput/clientes.php";

		echo"<a href='../eliminar_item.php?id=$id_det&cod=$rut_cc&tabla=$tabla&dest=$dest' onclick='return confirmar(\"Esta Seguro de querer eliminar el registro seleccionado? \")'>
		<img src='../imagenes/remove.png' border='0' valign='top' alt='Eliminar' />";

		echo"</td>
		
		</div></tr> "; 
}
/**********************************************************************************************************************************
Inicializamos las variables de los combos
**********************************************************************************************************************************/	
		$planta 		=	"--------------  Seleccione Planta --------------";
		$desc_eq_scont 	=	"--------------------------------------------------------------------  Seleccione Equipo --------------------------------------------------------------------";
		$V_desc_eq_scont 	=	"*";
		$cli_cot 		=	"---------  Seleccione  ---------";
		$estado_cot 	=	"---------  Seleccione  ---------";
		$usuario 		=	"---------  Seleccione  ---------";
		$rises	 		=	"---------  Seleccione  ---------";
		$area 			=	"---------  Seleccione  ---------";
		$estado 		=	"---------  Seleccione  ---------";
		$priori 		=	"---------  Seleccione  ---------";
		$est_inf 		=	"---  Seleccione  ---";
		$fe				=	date("d/m/Y");
//********************************************************************************************************************************
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Clientes</title>

<!-- Barra de progreso -->
<link href="../progressBar/lib/style.css" rel="stylesheet" type="text/css" media="screen" />
<script language="javascript" type="text/javascript" src="../progressBar/lib/prototype.js"></script>
<script language="javascript" type="text/javascript" src="../progressBar/lib/progress.js"></script>

<script type="text/javascript" language="JavaScript" src="../inc/funciones.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="../inc/stmenu.js"></script>
<!-- <script language="javascript" src="js/jquery-1.2.6.min.js"></script>-->

<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">
<LINK href="../inc/epoch_styles.css" type=text/css rel=stylesheet>
<SCRIPT src="../inc/epoch_classes.js" type=text/javascript></SCRIPT>

<script language="javascript">

var dp_cal;
window.onload = function () {
	stime = new Date();

	dp_cal 	  = new Epoch('dp_cal','popup',document.getElementById('date_field'));
}; 


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
        var divParent = document.getElementById(parentName);
        var divTarget = document.getElementById(div);
        var hasTitle = divParent.getAttribute('cab');
        divParent.removeChild(divTarget);
        if (divParent.childNodes.length == 0){
            divParent.innerHTML = "";
        }
    }
	
function creando()
{
	addFormLine('myDiv', 'myLine');
}

function ingresar()
{
	var agree=confirm("Esta Seguro de Querer enviar los datos ?");
	if (agree)
	{
		document.f.action='clientes_p.php'; 
		document.f.submit();
		return true;
	}else{
		return false;
	}
}

function carga(rut)
{
    document.f.rut_cli.value = rut;
	document.f.submit();
}
/*******************************************************************************************************************
										FUNCIONES CONFIRM
********************************************************************************************************************/
function confirmar(msj, dest, boton)
{
	var agree=confirm(msj);
		if (agree)
		{
			document.f.action=dest; 
			document.f.submit();
			return true ;
		}else{
			return false ;
		}
}
function CambiaColor(esto,fondo,texto)
{
    esto.style.background=fondo;
    esto.style.color=texto;
	esto.style.cursor='hand'
}
</script>

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
body {
	background-color: #527eab;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}

.Estilo8 {color: #000000}
#demo {margin : 0 auto;
width:100%;
margin:20px;
}

</style>
   
</head>

<body>
<?php 		
/**********************************************************************************************************************************
	
**********************************************************************************************************************************/
if($_POST['limpia'] != "Limpiar" and $_POST['elimina'] != "Eliminar")
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
/**********************************************************************************************************************************
			CARGAMOS LOS DATOS DEL RUT QUE NOS ENVIO LA LISTA
**********************************************************************************************************************************/	
	if($_POST['rut_cli'] != "")
	{
		$llave = $_POST['rut_cli'];
	}
	if($_POST['elimina_item'] != "")
	{
		$llave = $_POST['elimina_item'];
	}
	if($_POST['busca'] == "Buscar")
	{	
		$llave = $_POST['rut_cli'];
	}
	if($_POST['modifica'] != "")
	{	
		$llave = $_POST['modifica'];
	}
	if($_POST['ingresa'] != "")
	{
		//$llave = $_POST['ingresa'];
		echo"<script language='Javascript'>
			window.opener.CargarNombres();
			window.close();
		</script>";
	}
	
	$sqlc		=	"SELECT * FROM tb_clientes WHERE rut_cli = '$llave' ";
	$respuesta	=	mysql_query($sqlc,$co);
	while($vrows=	mysql_fetch_array($respuesta))
	{
		$rut_cli				= "".$vrows['rut_cli']."";
		$razon_s				= "".$vrows['razon_s']."";
		$nom_fant_cli			= "".$vrows['nom_fant_cli']."";
		$comuna_cli				= "".$vrows['comuna_cli']."";
		$ciudad_cli				= "".$vrows['ciudad_cli']."";
		$fono_cli				= "".$vrows['fono_cli']."";
		$direc_cli				= "".$vrows['direc_cli']."";
		$giro_cli				= "".$vrows['giro_cli']."";		
		$mail_cli				= "".$vrows['mail_cli']."";	
		$web_cli				= "".$vrows['web_cli']."";					
	}	
		$SqlCont = "SELECT * FROM tb_contacto_cli WHERE rut_cc = '$rut_cli' ORDER BY nom_cont ";
		$ResCont = dbExecute($SqlCont);
		while ($VrsCont = mysql_fetch_array($ResCont)) 
		{
    		$ContCli[] = $VrsCont;
		}	
}
//********************************************************************************************************************************

?>
<table width="900" height="459" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td width="100" height="54" align="center" valign="top"><img src="../imagenes/logo_mgyt_c.jpg" border="0" width="100" height="52" /></td>
    <td width="700" align="center" valign="middle" class="txtnormal3n"><table width="601" height="66" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="80" height="62" align="center"><input name="button8" type="submit" class="boton_inicio" id="button8" value="Inicio" onclick="enviar('index2.php')" /></td>
        <td width="436" align="center">CLIENTES</td>
        <td width="85" align="center">&nbsp;</td>
      </tr>
    </table></td>
    <td width="100" align="right" valign="top"><img src="../imagenes/logo_iso_c.jpg" width="100" height="52" /></td>
  </tr>
  <tr>
    <td height="3" colspan="3" align="center" valign="top"><img src="../imagenes/barra.gif" alt="" width="100%" height="1" /></td>
  </tr>
  <tr>
    <td height="400" colspan="3" align="center" valign="top">
    
    <table width="800" height="400" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
      <tr>
        <td width="933" height="289" align="center" valign="top">
        
        <form id="f" name="f" method="post" action="">
          <table width="880" height="289" border="0" align="center" cellpadding="0" cellspacing="0" class="txtnormal">
            <tr>
              <td width="752" height="62" align="center">
                
                
                                <fieldset class="txtnormal8">
                  <legend>DATOS DE CLIENTE </legend>
                  <table width="880" height="167" border="0" align="center" cellspacing="0" class="txtnormal8">
                    <tr>
                      <td height="17" colspan="4" align="center">&nbsp;</td>
                      </tr>
                    <tr>
                      <td width="122" height="16" align="left">RUT</td>
                      <td width="301" align="left"><input type="text" name="rut_cli" id="rut_cli" value="<? echo $rut_cli; ?>" />
                        <input name="busca" type="submit" class="boton_bus" id="button" value="Buscar" /></td>
                      <td width="84">&nbsp;</td>
                      <td width="365">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="6" align="left">RAZON SOCIAL</td>
                      <td colspan="3" align="left"><input name="razon_s" type="text" id="razon_s" value="<? echo $razon_s; ?>" size="100"/></td>
                      </tr>
                    <tr>
                      <td height="8" align="left">NOM. FANTASIA</td>
                      <td colspan="3" align="left"><input name="nom_fant_cli" type="text" id="nomf_cli" value="<? echo $nom_fant_cli; ?>" size="100"/></td>
                      </tr>
                    <tr>
                      <td height="24" align="left">GIRO</td>
                      <td colspan="3" align="left"><input name="giro_cli" type="text" id="giro_cli" value="<? echo $giro_cli; ?>" size="100"/></td>
                      </tr>
                    <tr>
                      <td height="24" align="left">DIRECCION</td>
                      <td colspan="3" align="left"><input name="direc_cli" type="text" id="direc_cli" value="<? echo $direc_cli; ?>" size="100"/></td>
                      </tr>
                    <tr>
                      <td height="24" align="left">COMUNA </td>
                      <td align="left"><input name="comuna_cli" type="text" id="com_cli" value="<? echo $comuna_cli; ?>" size="35"/></td>
                      <td align="left">CIUDAD</td>
                      <td align="left"><input name="ciudad_cli" type="text" id="ciu_cli" value="<? echo $ciudad_cli; ?>" size="35"/></td>
                      </tr>
                    <tr>
                      <td height="24" align="left">FONO</td>
                      <td align="left"><input type="text" name="fono_cli" id="fono_cli" value="<? echo $fono_cli; ?>" /></td>
                      <td align="left">EMAIL</td>
                      <td align="left"><input name="mail_cli" type="text" id="mail_cli" value="<? echo $mail_cli; ?>" size="35"/></td>
                      </tr>
                    <tr>
                      <td height="24" align="left">WEB</td>
                      <td align="left"><input name="web_cli" type="text" id="web_cli" value="<? echo $web_cli; ?>" size="35"/></td>
                      <td align="left">&nbsp;</td>
                      <td align="left">&nbsp;</td>
                      </tr>
                    </table>
                  </fieldset>

                
                </td>
            </tr>
            <tr>
              <td height="14" align="center" valign="middle" class="txtnormal8">&nbsp;
               
               
                <fieldset>
                  <legend>CONTACTOS POR CLIENTE </legend>
                  <BR />
                  <table width="751" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
                    <tr>
                      <td width="751" align="center"><table width="741" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="260" height="23" align="left" valign="middle"><label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <input type="button" class="boton_nue2" value=" Agregar contacto" onclick="creando();" />
                            <!-- <a href="javascript:creando(); ">Agregar Linea +</a>-->
                            <br/></td>
                          <td width="351" align="center" valign="middle" class="txtnormal3n">&nbsp;</td>
                          <td width="130" align="center" valign="middle" class="txtnormal3n"><!-- <div id='basic-modal'><input type='button' name='basic' value='Subir documentos' class='basic demo' onclick="val_sub()"/></div>--></td>
                        </tr>
                        <tr>
                          <td height="19" colspan="3" align="left" valign="bottom"><div id="recargado">
                            <table width="668" border="1" cellpadding="1" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#cedee1">
                              <tr>
                                <td width="258">&nbsp;&nbsp;&nbsp;&nbsp;NOMBRE</td>
                                <td width="252">&nbsp;CORREO</td>
                                <td width="112">FONO</td>
                                <td width="20" bgcolor="#FFFFFF">&nbsp;</td>
                                </tr>
                              <?php
	$i				= 0;
	$Contador_c	 	= count($ContCli);

/*************************************************************************************
			COMENZAMOS EL WHILE DE TRABAJADORES POR SECCION
********************************************************************************************************************************/
	while($i < $Contador_c)
	{
		$id_det 		= $ContCli[$i]['id_det'];
		$rut_cc 		= $ContCli[$i]['rut_cc'];
		$nom_cont 		= $ContCli[$i]['nom_cont'];
		$mail_cont 		= $ContCli[$i]['mail_cont'];
		$fono_cont 		= $ContCli[$i]['fono_cont'];
		
		filan($id_det, $rut_cc, $nom_cont, $mail_cont, $fono_cont);
		
		$i++;
	}
?>
                            </table>
                          </div></td>
                        </tr>
                        <tr>
                          <td colspan="4" align="center"><div id="myDiv"></div>
                            <div id="myLine" class="hide">
                                  <div>
                                    <input name="cod[]" type="hidden" class="cajas" style="width: 43px" />
                                    &nbsp; </div>
                                  <div>
                                    <input name="nom_cont[]" type="text" class="cajas" style="width: 240px" />
                                    &nbsp; </div>
                                  <div>
                                    <input name="mail_cont[]" type="text" class="cajas" style="width: 240px"/>
                                    &nbsp; </div>
                                  <div>
                                    <input name="fono_cont[]" type="text" class="cajas" style="width: 100px"/>
                                    &nbsp;
                                  </div>
                               </div>
                            </td>
                        </tr>
                        <tr>
                          <td height="15" colspan="3" align="center">&nbsp;</td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
                </fieldset>
                
                
                </td>
            </tr>
            <tr>
              <td height="18" align="center" valign="middle">&nbsp;<br/>
                <!-- FIN CODIGO PARA CONTROL DE AVANCE --></td>
            </tr>
            <tr>
              <td height="5" align="center" valign="bottom"><label>
                <?php 
				if($_SESSION['usuario_nivel'] > 1)
				{
					$est = "disabled='disabled'";
				}else{
					$est = "";
				}
				?>
                <input name="ingresa" type="submit" class="boton_ing" id="button3" value="Ingresar" onclick="return ingresar()" <?php echo $est; ?>/>
                &nbsp; </label>
                <input name="modifica" type="submit" class="boton_mod" id="button5" value="Modificar" onclick="return confirmar('Esta seguro que desea Modificar los datos del cliente?', 'clientes_p.php', this.value)"<?php echo $est; ?> />
                &nbsp;
                <input name="elimina" type="submit" class="boton_eli" id="elimina" value="Eliminar" onclick="return eli()" <?php echo $est; ?>/></td>
            </tr>
            <tr>
              <td height="6" align="center" valign="bottom">&nbsp;</td>
            </tr>
            <tr>
              <td height="11" align="center" valign="bottom">
              
              <table width="898" border="0" bordercolor="#FFFFFF" class="txtnormal" cellspacing="0" cellpadding="0">
                <tr bgcolor="#cedee1" class="txtnormaln">
                  <td width="3%" height="20" align="left">.......</td>
                  <td width="12%" align="left">Rut</td>
                  <td width="33%" align="left">Razon Social</td>
                  <td width="16%" align="left">Giro</td>
                  <td width="25%" align="left">Direccion</td>
                  <td width="11%" align="left">Fono</td>
<? 		
/***********************************************************************************************************************
										LISTAMOS TODOS LOS USUARIOS
***********************************************************************************************************************/	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sql="SELECT * FROM tb_clientes ORDER BY razon_s";
	$respuesta=mysql_query($sql,$co);
	$color="#ffffff";
	while($vrowsc=mysql_fetch_array($respuesta))
	{
		$rut_cli	= $vrowsc['rut_cli'];
		$razon_s	= $vrowsc['razon_s'];
		$giro_cli 	= $vrowsc['giro_cli'];
		$direc_cli	= $vrowsc['direc_cli'];
		$fono_cli	= $vrowsc['fono_cli'];
		
		echo"<tr bgcolor=$color class='txtnormal' onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000') onclick=carga('$rut_cli');>
				<td bgcolor='#ffc561'>&nbsp;<a href='#' onclick=carga('$rut_cli');><img src='../imagenes/edit.png' border='0' valign='top' alt='Editar'/></a></td>
				<td align='left'>&nbsp;$rut_cli</td>
				<td align='left'>$razon_s</td>
				<td align='left'>$giro_cli</td>
				<td align='left'>$direc_cli</td>
				<td align='left'>$fono_cli</td>
			</tr>";
									
			if($color == "#ffffff"){ $color = "#ddeeee"; }
			else{ $color = "#ffffff"; }	
	}
	mysql_close($co);

?>
                </tr>
              </table></td>
            </tr>
            
            
            
            
            
          </table>
        </form>        </td>
      </tr>
      <tr>
        <td height="15" align="center" valign="top">&nbsp;</td>
      </tr>
    </table>
    </td>
  </tr>
</table>
</body>
</html>
