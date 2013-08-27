<?php
	include('../inc/config_db.php');	// CONECCION A LA BASE DE DATOS
	require('../inc/lib.db.php');
	
function filan($id_det, $id_cli, $rut_cli, $nom_cont, $mail_cont, $cargo_cont, $fono_cont)
{
	if($_SESSION['usuario_pyc'] == "administrador")
	{
		$lectura = "";
	}else{
		$lectura = "readonly ='readonly'";
	}
	
	 echo"<tr border='0' bgcolor='#ffffff'>
        <td>
        	<input name='nom_cont[]' type='text' class='cajas' style='width: 180px' value='$nom_cont'/>&nbsp; 
		</td>
        <td>
         	<input name='mail_cont[]' type='text' class='cajas' style='width: 180px' value='$mail_cont'/>&nbsp; 
		</td>
		<td>
         	<input name='cargo_cont[]' type='text' class='cajas' style='width: 180px' value='$cargo_cont'/>&nbsp; 
		</td>
        <td>
        	<input name='fono_cont[]' type='text' class='cajas' style='width: 100px' value='$fono_cont'/>&nbsp;
			<input name='id_det[]' type='hidden' value='$id_det' style='width: 20px'/>
        </td>
		
		<td align='center'>";
		$tabla = "tb_contacto_cli";
		$dest  = "poput/clientes.php";

		echo"<a href='../eliminar_item.php?id=$id_det&cod=$id_cli&tabla=$tabla&dest=$dest' onclick='return confirmar(\"Esta Seguro de querer eliminar el registro seleccionado? \")'>
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

<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">

<script language="javascript">

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
	rut_cli = document.f.rut_cli.value;
	if(rut_cli  != "")
	{
		addFormLine('myDiv', 'myLine');
	}else{
		alert("Debe seleccionar cliente");
	}
}

function gen()
{
	var agree=confirm("Esta Seguro Que desea Ingresar el Cliente ?");
	if (agree){
		document.f.action='clientes_p.php'; 
		document.f.submit();
		return true ;
	}else{
		return false ;
	}
}

function ingresar()
{
	var rut_cli			= document.f.rut_cli.value;
	var razon_s			= document.f.razon_s.value;
	var direc_cli		= document.f.direc_cli.value;
	/*var fe_ing_cot		= document.f.fe_ing_cot.value;
	var fe_ent_cot		= document.f.fe_ent_cot.value;	
	var cliente_cot		= document.f.c1.value;
	var contacto_cot	= document.f.c2.value;	
	var emp_cot			= document.f.c3.value;
	var resp_cot		= document.f.c4.value;	
	var estado_cot		= document.f.c5.value;	*/
	
	if(rut_cli != "")
	{
		if(razon_s != "")
		{
			if(direc_cli != "")
			{
				/*if(fe_ent_cot != "")
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
									{*/
										return gen();
									/*}else{
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
					alert("Debe Ingresar fecha de entrega");
					document.form1.fe_ent_cot.focus();
				return false ;
				}*/
			}else{
				alert("Debe Ingresar Direccion del Cliente");
				document.f.direc_cli.focus();
				return false ;
			}
		}else{
			alert("Debe Ingresar Razon Social del cliente");
			document.f.razon_s.focus();
			return false ;
		}
	}else{
		alert("Debe Ingresar Rut del Cliente");
		document.f.rut_cli.focus();
		return false ;
	}
}

function carga(id_cli)
{
    document.f.id_cli.value = id_cli;
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
	if($_POST['id_cli'] != "")
	{
		$query = "SELECT * FROM tb_clientes WHERE id_cli = '".$_POST['id_cli']."' ";
	}
	if($_POST['elimina_item'] != "")
	{
		$query = "SELECT * FROM tb_clientes WHERE id_cli = '".$_POST['elimina_item']."' ";
	}
	if($_POST['busca'] == "Buscar")
	{	
		$query = "SELECT * FROM tb_clientes WHERE id_cli = '".$_POST['id_cli']."' ";
	}
	if($_POST['modifica'] != "")
	{	
		$query = "SELECT * FROM tb_clientes WHERE id_cli = '".$_POST['modifica']."' ";
	}
	if($_POST['ingresa'] != "")
	{
		//$llave = $_POST['ingresa'];
		echo"<script language='Javascript'>
			window.opener.CargarNombres();
			window.close();
		</script>";
	}
	
	$sqlc		=	$query;
	if($sqlc != "")
	{
		$respuesta	=	mysql_query($sqlc,$co);
		while($vrows=	mysql_fetch_array($respuesta))
		{
			$id_cli					= "".$vrows['id_cli']."";
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
			$SqlCont = "SELECT * FROM tb_contacto_cli WHERE id_cli = '$id_cli' ORDER BY nom_cont ";
			$ResCont = dbExecute($SqlCont);
			while ($VrsCont = mysql_fetch_array($ResCont)) 
			{
				$ContCli[] = $VrsCont;
			}
	}	
}
//********************************************************************************************************************************

?>
<table width="771" height="449" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td height="37" align="center" valign="middle" class="txt01">MANTENEDOR DE CLIENTES</td>
  </tr>
  <tr>
    <td height="3" align="center" valign="top">
   <!-- <img src="../imagenes/barra.gif" alt="" width="100%" height="1" /> -->
    </td>
  </tr>
  <tr>
    <td height="408" align="center" valign="top">
    
    <table width="775" height="408" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
      <tr>
        <td width="775" height="289" align="center" valign="top">
        
        <form id="f" name="f" method="post" action="">
          <table width="775" height="389" border="0" align="center" cellpadding="0" cellspacing="0" class="txtnormal8">
            <tr>
              <td width="775" height="62" align="center">
                
                
                 <fieldset class="txtnormal8">
                  <legend>DATOS DE CLIENTE </legend>
                  
                  <table width="773" height="191" border="0" align="center" cellpadding="0" cellspacing="0" class="txtnormal8">
                    <tr>
                      <td height="15" colspan="4" align="center" class="hide">&nbsp;</td>
                      </tr>
                    <tr>
                      <td width="122" height="16" align="left">&nbsp;RUT
                        <span class="txtrojo">(*)                        </span>
                        <input type="hidden" name="id_cli" id="id_cli" value="<? echo $id_cli; ?>" /></td>
                      <td width="301" align="left"><input name="rut_cli" type="text" class="cajas_chicas" id="rut_cli" onchange="Valida_Rut(this)" value="<? echo $rut_cli; ?>" /></td>
                      <td width="84">&nbsp;</td>
                      <td width="258">&nbsp;</td>
                      </tr>
                    <tr>
                      <td height="6" align="left">&nbsp;RAZON SOCIAL
                        <span class="txtrojo">(*)</span></td>
                      <td colspan="3" align="left"><input name="razon_s" type="text" class="cajas_chicas" id="razon_s" value="<? echo $razon_s; ?>" size="100"/></td>
                      </tr>
                    <tr>
                      <td height="8" align="left">&nbsp;NOM. FANTASIA</td>
                      <td colspan="3" align="left"><input name="nom_fant_cli" type="text" class="cajas_chicas" id="nomf_cli" value="<? echo $nom_fant_cli; ?>" size="100"/></td>
                      </tr>
                    <tr>
                      <td height="22" align="left">&nbsp;GIRO</td>
                      <td colspan="3" align="left"><input name="giro_cli" type="text" class="cajas_chicas" id="giro_cli" value="<? echo $giro_cli; ?>" size="100"/></td>
                      </tr>
                    <tr>
                      <td height="22" align="left">&nbsp;DIRECCION
                        <span class="txtrojo">(*)</span></td>
                      <td colspan="3" align="left"><input name="direc_cli" type="text" class="cajas_chicas" id="direc_cli" value="<? echo $direc_cli; ?>" size="100"/></td>
                      </tr>
                    <tr>
                      <td height="22" align="left">&nbsp;COMUNA
                        <span class="txtrojo">(*)</span> </td>
                      <td align="left"><input name="comuna_cli" type="text" class="cajas_chicas" id="com_cli" value="<? echo $comuna_cli; ?>" size="35"/></td>
                      <td align="left">&nbsp;CIUDAD
                        <span class="txtrojo">(*)</span></td>
                      <td align="left"><input name="ciudad_cli" type="text" class="cajas_chicas" id="ciu_cli" value="<? echo $ciudad_cli; ?>" size="35"/></td>
                      </tr>
                    <tr>
                      <td height="22" align="left"> &nbsp;FONO</td>
                      <td align="left"><input name="fono_cli" type="text" class="cajas_chicas" id="fono_cli" value="<? echo $fono_cli; ?>" /></td>
                      <td align="left">&nbsp;EMAIL</td>
                      <td align="left"><input name="mail_cli" type="text" class="cajas_chicas" id="mail_cli" value="<? echo $mail_cli; ?>" size="35"/></td>
                      </tr>
                    <tr>
                      <td height="22" align="left">&nbsp;WEB</td>
                      <td align="left"><input name="web_cli" type="text" class="cajas_chicas" id="web_cli" value="<? echo $web_cli; ?>" size="35"/></td>
                      <td align="left">&nbsp;</td>
                      <td align="left">&nbsp;</td>
                      </tr>
                    </table>
                  </fieldset>                
                 
                 </td>
            </tr>
            <tr>
              <td height="95" align="center" valign="middle" class="txtnormal8">&nbsp;
               
               
                <fieldset>
                  <legend>CONTACTOS POR CLIENTE </legend>
                  <BR />
                  <table width="764" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
                    <tr>
                      <td width="764" align="center"><table width="750" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="260" height="22" align="left" valign="middle"><label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <input type="button" class="boton_nue2" value=" Agregar contacto" onclick="creando();" />
                            <!-- <a href="javascript:creando(); ">Agregar Linea +</a>-->
                            <br/></td>
                          <td width="351" align="center" valign="middle" class="txtnormal3n">&nbsp;</td>
                          <td width="130" align="center" valign="middle" class="txtnormal3n"><!-- <div id='basic-modal'><input type='button' name='basic' value='Subir documentos' class='basic demo' onclick="val_sub()"/></div>--></td>
                        </tr>
                        <tr>
                          <td height="19" colspan="3" align="left" valign="bottom"><div id="recargado">
                            <table width="741" height="17" border="1" cellpadding="1" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#cedee1">
                              <tr>
                                <td width="283">&nbsp;&nbsp;&nbsp;&nbsp;NOMBRE</td>
                                <td width="187">&nbsp;CORREO</td>
                                <td width="141">CARGO</td>
                                <td width="85">FONO</td>
                                <td width="23" bgcolor="#FFFFFF">&nbsp;</td>
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
		$id_cli 		= $ContCli[$i]['id_cli'];
		$nom_cont 		= $ContCli[$i]['nom_cont'];
		$mail_cont 		= $ContCli[$i]['mail_cont'];
		$cargo_cont 	= $ContCli[$i]['cargo_cont'];
		$fono_cont 		= $ContCli[$i]['fono_cont'];
		
		filan($id_det, $id_cli, $rut_cli, $nom_cont, $mail_cont, $cargo_cont, $fono_cont);
		
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
                                    <input name="nom_cont[]" type="text" class="cajas" style="width: 180px" />
                                    &nbsp; </div>
                                  <div>
                                    <input name="mail_cont[]" type="text" class="cajas" style="width: 180px"/>
                                    &nbsp; 
                                  </div>
                                  <div>
                                    <input name="cargo_cont[]" type="text" class="cajas" style="width: 180px"/>
                                    &nbsp; 
                                  </div>
                                  <div>
                                    <input name="fono_cont[]" type="text" class="cajas" style="width: 100px"/>
&nbsp;                            </div>
                              </div>                            </td>
                        </tr>
                        
                      </table></td>
                    </tr>
                  </table>
                </fieldset>                </td>
            </tr>
            <tr>
              <td height="15" align="center" valign="middle">&nbsp;<br/>
                <!-- FIN CODIGO PARA CONTROL DE AVANCE --></td>
            </tr>
            <tr>
              <td height="5" align="center" valign="bottom"><label>
                <?php 
				if($_POST['busca']!= "" or $_POST['id_cli'] != "")
				{
					$est = "disabled='disabled'";
				}else{
					$est = "";
				}
				?>
                <input name="ingresa" type="submit" class="boton_ing" id="button3" value="Ingresar" onclick="return ingresar()" <?php echo $est; ?>/>
                &nbsp; </label>
                <input name="modifica" type="submit" class="boton_mod" id="button5" value="Modificar" onclick="return confirmar('Esta seguro que desea Modificar los datos del cliente?', 'clientes_p.php', this.value)" />
                &nbsp;
                <input name="elimina" type="submit" class="boton_eli" id="elimina" value="Eliminar" onclick="return eli()" <?php echo $est; ?>/></td>
            </tr>
            <tr>
              <td height="6" align="center" valign="bottom">&nbsp;</td>
            </tr>
            <tr>
              <td height="11" align="center" valign="bottom">
              
               <div style="border: 1px solid #000;">
              <table width="770" border="1" bordercolor="#FFFFFF" class="txtnormal8" cellspacing="0" cellpadding="0">
                <tr bgcolor="#cedee1" class="txtnormaln">
                  <td width="3%" height="17" align="left">.......</td>
                  <td width="11%" align="left">Rut</td>
                  <td width="42%" align="left">Razon Social</td>
                  <td width="32%" align="left">Giro</td>
                  <td width="12%" align="left">Fono</td>
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
		$id_cli		= "".$vrowsc['id_cli']."";
		$rut_cli	= "".$vrowsc['rut_cli']."";
		$razon_s	= "".$vrowsc['razon_s']."";
		$giro_cli 	= "".$vrowsc['giro_cli']."";
		$direc_cli	= "".$vrowsc['direc_cli']."";
		$fono_cli	= "".$vrowsc['fono_cli']."";
		
		echo"<tr bgcolor=$color class='txtnormal8' onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000') onclick=\"carga('$id_cli')\";>
				<td bgcolor='#ffc561'>&nbsp;<a href='#' onclick=carga('$id_cli');><img src='edit.png' border='0' valign='top' alt='Editar'/></a></td>
				<td align='left'>&nbsp;$rut_cli</td>
				<td align='left'>$razon_s</td>
				<td align='left'>$giro_cli</td>
				<td align='left'>$fono_cli</td>
			</tr>";
									
			if($color == "#ffffff"){ $color = "#ddeeee"; }
			else{ $color = "#ffffff"; }	
	}
	mysql_close($co);

?>
                </tr>
              </table>
               </div>              </td>
            </tr>
          </table>
        </form>        </td>
      </tr>
      <tr>
        <td height="15" align="center" valign="top">&nbsp;</td>
      </tr>
    </table>    </td>
  </tr>
</table>
</body>
</html>
