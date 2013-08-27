<?
// Necesario para ver si la session esta activa  o si se tiene permiso de accseso
require("lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php

if($_SESSION['usd_sol_lee'] != "1")
{
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}//Hasta aquí lo comun para todas las paginas restringidas

//**********************************************************************************************************************
	include('inc/config_db.php');	// CONECCION A LA BASE DE DATOS
	require("inc/lib.db.php");		// FUNCIONES VARIAS
/***********************************************************************************************************************
							Inicializamos las variables de los combos
***********************************************************************************************************************/	
if ($_SESSION['usd_sol_us_bod'] != "1"){
	$dis_recepcion 	= "disabled";
}

$rec_det = "----- Seleccione -----";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Recepcion</title>

<!-- HOJA DE ESTILO -->
<link href="inc/bibliocss.css" rel="stylesheet" type="text/css">

<script type="text/javascript" language="JavaScript" src="inc/funciones.js"></script>

<script type="text/javascript" src="autoComplete/jquery-1.2.1.pack.js"></script>

<SCRIPT type=text/javascript>
function enviar(url)
{
	document.formus.action=url;
}

/*******************************************************************************************************************
										FUNCIONES CONFIRM
********************************************************************************************************************/
function confirmar(msj, dest, boton)
{
	var apr_d			= parent.document.f.aprobado_departamento.value;
	var apr_g			= parent.document.f.aprobado_gerencia.value;
	var usuario			= parent.document.f.usuario_nombre.value;
	
	var us_ing			= parent.document.f.ingresada_por.value;
	
	var usd_sol_us_bod	= parent.document.f.usd_sol_us_bod.value;

	var motivo    		= document.formus.motivo.value;
	
	var fe_rec			= document.formus.fe_rec.value;
	var cant_rec		= document.formus.cant_rec.value;
	var rec_det			= document.formus.rec_det.value;
	var val_fecha		= fe_rec.length;
	
	if(usd_sol_us_bod == "1")
	{
		if((apr_g != ""))
		{
			if((rec_det == "Parcial" || rec_det == "Completa") && (rec_det != "----- Seleccione -----"))
			{
				if((fe_rec != "" && val_fecha != 9))
				{	
					if(cant_rec != 0)
					{
						var agree=confirm(msj);
						if (agree){
							document.formus.action=dest;
							return true ;
						}else{
							return false ;
						}
					}else{
						alert("Error: Debe ingresar cantidad recepcionada");
						return false;
						document.formus.fe_rec.focus()
					}
				}else{
					alert("Error: Debe ingresar fecha de recepcion");
					return false;
					document.formus.fe_rec.focus()
				}
			}
			
			if(rec_det == "----- Seleccione -----")
			{
				alert("Error: Debe seleccionar estado");
				return false;
				document.formus.rec_det.focus();
			}
			
			if(rec_det == "Rechazado" || rec_det == "Anulado")
			{
				if(motivo != "")
				{
					var agree=confirm(msj);
					if (agree){
						document.formus.action=dest;
						return true ;
					}else{
						return false ;
					}
				}else{
					alert("Error: Debe ingresar Motivo o Nota");
					return false;
					document.formus.motivo.focus()
				}
			}
			
		}else{
			alert("Error: la solicitud aun no se encuentra aprobada");
		return false;
		}
	}else{
		alert("Error: No esta autorizado a modificar el estado de recepcion");
		return false;
	}
}
</SCRIPT>

<style type="text/css" media="all">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-image: url(imagenes/fondo.jpg);
}
.Estilo8 {font-size: 10px}
.Estilo9 {font-size: 10}
-->
    

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
        padding: 2px 3px 2px 3px;
    }

    select {
        font: 11px Verdana, Arial, Helvetica, serif;
        border: #153244 1px solid;
        color: #000000;
        background-color: #EFEBE7;
    }
	.capa{height:250px; overflow:auto;}

</style>
</head>

<body>
<?php 
/***********************************************************************************************************
								BUSCAMOS LA SOLICITUD DEPENDIENDO EL FILTRO
************************************************************************************************************/
if($_POST['modifica'] != "")
{
	$query = "SELECT * FROM tb_det_sol WHERE id_det='".$_POST['modifica']."' ";
}
if($_GET['vid'] != "")
{
	$query = "SELECT * FROM tb_det_sol WHERE id_det='".$_GET['vid']."' ";
}

if($_GET['vid'] != "" or $_POST['modifica'] != "")
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
			$rec_det 	= "".$vrows['rec_det']."";
			$fe_rec 	= "".$vrows['fe_rec']."";
			$cant_rec 	= "".$vrows['cant_rec']."";
			$id_det 	= "".$vrows['id_det']."";
			$cant_det 	= "".$vrows['cant_det']."";
			$motivo 	= "".$vrows['motivo']."";
			if($cant_rec == 0){$cant_rec = "";}
		}
	}
}
/******************************************************************************************
	FORMATEAMOS LAS FECHAS
******************************************************************************************/
$fe_rec		=	cambiarFecha($fe_rec, '-', '/' ); 

if($fe_rec == "00/00/0000"){$fe_rec = "";}
if($rec_det == "" or $rec_det == "Pendiente"){$rec_det = "----- Seleccione -----";}
?>
  <table width="332" height="172" border="0" align="center" cellpadding="0" cellspacing="0" class="txtnormal">
    <tr><form id="formus" name="formus" method="post" action="">
      <td width="332" height="172" align="center" valign="top">
      
        <table width="500" height="172" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#cedee1" class="txtnormal7">
          <tr>
            <td width="500" height="26" align="center" bgcolor="#FFFFFF"><table width="328" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td height="24" align="center">RECEPCION DE PRODUCTOS</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="143" align="center"><table width="496" height="168" border="0" cellspacing="0" class="txtnormalnn">
                <tr>
                  <td width="123" height="11" align="left">&nbsp;</td>
                  <td width="369" align="left" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                  <td width="123" height="12" align="left">&nbsp;ESTADO RECEPCION</td>
                  <td align="left" valign="middle">
                  <select name="rec_det" id="select">
                  	<? echo"<option selected='selected' value='$rec_det'>$rec_det</option>";?>
                      <option value="Anulado">Anulado</option>
                      <option value="Pendiente">Pendiente</option>
                      <option value="Completa">Completa</option>
                      <option value="Parcial">Parcial</option>
                      <option value="Rechazado">Rechazado</option>
                    </select></td>
                </tr>
                <tr>
                  <td height="13" align="left">&nbsp;FECHA RECEPCION </td>
                  <td align="left" valign="middle"><input name="fe_rec" type="text" class="cajas" style="width: 78px" onkeyup="this.value=formateafecha(this.value)" value="<? echo $fe_rec; ?>" />
                  DIA/MES/AÑO</td>
                </tr>
                <tr>
                  <td height="5" align="left">&nbsp;CANT. RECEPCIONADA</td>
                  <td align="left" valign="middle">
                  <label>
                    <input name="cant_rec" type="text" id="textfield" size="5" value="<? echo $cant_rec; ?>" />
                    <span class="txtnormal7">
                    DE: <?php echo $cant_det; ?>                                        
                  </span></label>
                 </td>
                </tr>
                <tr>
                  <td height="7" align="left">&nbsp;MOTIVO RECHAZO / NOTA</td>
                  <td align="left" valign="middle"><textarea name="motivo" cols="55" rows="3" id="textfield2"><? echo $motivo; ?></textarea></td>
                </tr>
                
                <tr>
                  <td height="32" colspan="2" align="center" class="txtnormaln">
                   <input type="hidden" name="id" value="<?php echo $_GET['vid']; ?>"/>
                   <?php 
					if ($_SESSION['usd_sol_us_bod'] == 1)
					{
						echo"&nbsp;&nbsp;<label><input name='bodega' type='submit' class='boton_mod' id='button10' value='Modificar' onclick=\"return confirmar('Esta seguro que desea modificar el estado de recepcion?', 'recepcion_fsr_p.php', this.value)\" $dis_recepcion; /> </label>"; 
					}?></td>
                </tr>
            </table></td>
          </tr>
        </table>
      
      
      </td></form>
    </tr>
</table>


</body>
</html>
