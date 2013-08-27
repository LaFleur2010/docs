<?
// Necesario para ver si la session esta activa  o si se tiene permiso de accseso
require("../lg/lg_controlar.php");
// Si no es correcto, se mada a la página que lo llamo con la variable de $error_login definida con el nº de error segun el array de  lg_errores.php

if($_SESSION['usd_sol_lee'] != "1")
{
	header ("Location: $redir?error_login=5");
	exit; //Como no podemos entrar nos vamos de esta página.
}//Hasta aquí lo comun para todas las paginas restringidas

//**********************************************************************************************************************
	include('../inc/config_db.php');	// CONECCION A LA BASE DE DATOS
	require("../inc/lib.db.php");		// FUNCIONES VARIAS
/***********************************************************************************************************************
							Inicializamos las variables de los combos
***********************************************************************************************************************/	
if ($_SESSION['usd_sol_us_adq'] != "1"){
	$dis_oc 	= "disabled";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Recepcion</title>

<!-- HOJA DE ESTILO -->
<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">

<script type="text/javascript" language="JavaScript" src="../inc/funciones.js"></script>

<SCRIPT type="text/javascript" language="javascript">
/*******************************************************************************************************************
										FUNCIONES CONFIRM
********************************************************************************************************************/
function confirmar(msj, dest, boton)
{
	var apr_d			= parent.document.f.aprobado_departamento.value;
	var apr_g			= parent.document.f.aprobado_gerencia.value;
	var usuario			= parent.document.f.usuario_nombre.value;
	var us_ing			= parent.document.f.ingresada_por.value;
	var usd_sol_us_adq	= parent.document.f.usd_sol_us_adq.value;
	var num_oc			= document.formus.num_oc.value;
	
	if(usd_sol_us_adq == "1")
	{
		if((apr_g != ""))
		{
			if(num_oc != "")
			{
				var agree=confirm(msj);
				if (agree){
					document.formus.action=dest;
					return true ;
				}else{
					return false ;
				}
			}else{
				alert("Error: Debe ingresar Nº de OC");
				return false;
				document.formus.fe_rec.focus()
			}
		}else{
			alert("Error: la solicitud aun no se encuentra aprobada");
		return false;
		}
	}else{
		alert("Error: No esta autorizado a modificar el Nº de OC");
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
			$num_oc 	= "".$vrows['num_oc']."";
		}
	}
}
?>
  <table width="304" height="140" border="0" align="center" cellpadding="0" cellspacing="0" class="txtnormal">
    <tr>
    
    <form id="formus" name="formus" method="post" action="">
      <td width="304" height="140" align="center" valign="top">
      
        <table width="304" height="140" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#cedee1" class="txtnormal7">
          <tr>
            <td width="300" height="26" align="center" bgcolor="#FFFFFF"><table width="277" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="24" align="center">ASIGNAR ORDEN DE COMPRA A PRODUCTO</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="112" align="center"><table width="300" height="88" border="0" class="txtnormalnn">
                <tr>
                  <td width="121" height="11" align="left">&nbsp;</td>
                  <td width="169" align="left" valign="middle">&nbsp;</td>
                </tr>
                <tr>
                  <td width="121" height="12" align="left">Nº ORDEN DE COMPRA</td>
                  <td align="left" valign="middle"><input name="num_oc" type="text" class="cajas" id="num_oc" style="width: 78px" value="<? echo $num_oc; ?>" />
                  <?php echo"<a href=\"../sw/rep_oc.php?cod=$num_oc&emp=$empr_sol\" target='blank'>Ver OC</a>"; ?>
                  
                  </td>
                </tr>
                
                <tr>
                  <td height="57" colspan="2" align="center" class="txtnormaln">
                   <input type="hidden" name="id" value="<?php echo $_GET['vid']; ?>"/>
                   <?php 
					if ($_SESSION['usd_sol_us_adq'] == 1)
					{
						echo"&nbsp;&nbsp;<label><input name='adquisiciones' type='submit' class='boton_mod' id='button10' value='Modificar' onclick=\"return confirmar('Esta seguro que desea modificar el Nº de OC?', 'oc_fsr_p.php', this.value)\" $dis_oc; /> </label>"; 
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
