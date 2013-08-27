<?php
	include('inc/config_db.php');	// CONECCION A LA BASE DE DATOS
	require("inc/lib.db.php");		// FUNCIONES VARIAS
/***********************************************************************************************************************
							Inicializamos las variables de los combos
***********************************************************************************************************************/	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Buscar Solicitudes</title>

<!-- HOJA DE ESTILO -->
<link href="inc/bibliocss.css" rel="stylesheet" type="text/css">

<script type="text/javascript" language="JavaScript" src="inc/funciones.js"></script>

<!-- CALENDARIO -->
<LINK href="inc/epoch_styles.css" type=text/css rel=stylesheet>
<SCRIPT src="inc/epoch_classes.js" type=text/javascript></SCRIPT>

<!-- AUTOCOMPLETE -->
<script type="text/javascript" src="autocomplete/jquery.js"></script>
<script type='text/javascript' src='autocomplete/jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="autocomplete/jquery.autocomplete.css" />
<!-- FIN AUTOCOMPLETE -->

<script language="javascript" type="text/javascript">

var dp_cal,dp_cal2,dp_cal3;      
window.onload = function () {
	stime = new Date();

	dp_cal   = new Epoch('dp_cal','popup',document.getElementById('date_field'));
	dp_cal2   = new Epoch('dp_cal2','popup',document.getElementById('date_field2'));
	dp_cal3   = new Epoch('dp_cal3','popup',document.getElementById('date_field3'));

}; 

function enviar(url)
{
	document.formus.action=url;
}

function validar(elemento)
{
	var radiopor 	= document.getElementsByName("radiopor[]");
	var valor	 	= document.getElementsByName("valor[]");
   	var total		= radiopor.length;
   
   for(var x = 0; x < total; ++x)
   {
	 if(elemento == radiopor[x] ) 
	 {
		valor[x].style.background='#FFFFFF';
		valor[x].style.border='1px solid red';
		
		 if(elemento == radiopor[0] ) 
		 {	
			document.formus.date_field2.style.background='#FFFFFF';
			document.formus.date_field3.style.background='#FFFFFF';
			valor[x].style.background='#cedee1';
		 }else{
			document.formus.date_field2.style.background='#cedee1';
			document.formus.date_field3.style.background='#cedee1';
			valor[x].style.background='#FFFFFF';
		 }
		 if(elemento == radiopor[1] ) 
		 {	
			document.formus.date_field.style.background='#FFFFFF';
			valor[x].style.background='#cedee1';
		 }else{
			document.formus.date_field.style.background='#cedee1';
		 }
	 }else{
	 	valor[x].style.background='#cedee1';
		valor[x].style.border='0px';
		valor[x].value = "";
	 }
   }
}

function CambiaColor(esto,fondo,texto)
{
    esto.style.background=fondo;
    esto.style.color=texto;
}

/*****************************************************************************************************************
NOMBRE: 		
DESCRIPCION:	FUNCION PARA MOSTRAR EL AUTOCOMPLETE
AUTOR: 			WWW.GOOGLE.COM	
FECHA: 			22/12/2010
******************************************************************************************************************/
$().ready(function() {
	$("#descripcion_sol").autocomplete("autocomplete/get_desc_fsr.php", {
		width: 521,
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});
});
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

<form id="formus" name="fformus" method="post" action="">
<table width="700" height="236" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  
  <tr>
    <td width="700" height="232" align="center" valign="top">
    
    <table width="700" height="230" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
      <tr>
        <td width="700" height="226" align="center" valign="top">
        
          <table width="700" height="232" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#cedee1" class="txtnormal7">
            <tr>
              <td width="696" height="39" align="center" bgcolor="#FFFFFF"><table width="696" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="37" align="center">BUSCAR SOLICITUD DE RECURSOS</td>
                  </tr>
              </table>                </td>
            </tr>
            <tr>
              <td height="182" align="center">
              <table width="694" height="268" border="0" class="txtnormalnn">
                <tr>
                  <td width="1" height="28" align="left">&nbsp;</td>
                  <td width="115" align="left" valign="top">&nbsp;<label>
                  <input name="radiopor[]" type="radio" id="0" value="0" onclick="validar(this);"/> 
                    ENTRE FECHAS</label></td>
                  <td width="240" align="left" valign="top">
                  <div id="valor[]" style="WIDTH: 95%;">
                    <input id="date_field2" style="WIDTH: 7em;background-color:#cedee1;border:0;" name="fe1" value="<? echo $fe1; ?>" />&nbsp;&nbsp;&nbsp;
                    <input id="date_field3" style="WIDTH: 7em;background-color:#cedee1;border:0;" name="fe2" value="<? echo $fe2; ?>" />
                  </div>                  </td>
                  <td width="117" align="left" valign="top"><label>
                    <input name="radiopor[]" type="radio" id="1" value="1" onclick="validar(this);"/> 
                    POR FECHA<span style="WIDTH: 47%;">
                    <? $fe=cambiarFecha( $fe, '-', '/' ); ?>
                    </span></label></td>
                  <td width="199" align="left" valign="top">
                  <div id="valor[]" style="WIDTH: 47%;">
                    <input id="date_field" style="WIDTH: 7em;background-color:#cedee1;border:0;" name="fe3" value="<? echo $fe; ?>" />
                  </div></td>
                </tr>
                <tr>
                  <td height="27" align="left">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;<label>
<input name="radiopor[]" type="radio" id="radiopor[]" value="2" onclick="validar(this);"/>                  
POR ODS</label></td>
                  <td align="left" valign="top"><input name="valor[]" type="text" id="textfield" size="30" style="background-color:#cedee1;border:0;"/></td>
                  <td align="left" valign="top"><label>
                      <input name="radiopor[]" type="radio" id="radiopor[]" value="3" onclick="validar(this);"/> 
                  POR C. COSTO</label></td>
                  <td align="left" valign="top"><input name="valor[]" type="text" id="textfield7" size="30" style="background-color:#cedee1;border:0;"/></td>
                </tr>
                <tr>
                  <td height="30" align="left">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;<label>
                    <input name="radiopor[]" type="radio" id="radiopor[]" value="4" onclick="validar(this);"/>
                    POR PRODUCTO</label></td>
                  <td colspan="3" align="left" valign="top">
                  
                  	<input name="valor[]" id="descripcion_sol" type="text" size="84" style="background-color:#cedee1;border:0;"/>
                    
                    </td>
                  </tr>
                <tr>
                  <td height="97" colspan="5" align="left">&nbsp;</td>
                  </tr>
                <tr>
                  <td height="74" colspan="5" align="center" class="txtnormaln"><input name="busca" type="submit" class="boton_bus" id="busca" value="Buscar" /></td>
                  </tr>
<?php
	$_POST['fe1']	= cambiarFecha( $_POST['fe1'], '/', '-' ); 
	$_POST['fe2']	= cambiarFecha( $_POST['fe2'], '/', '-' ); 
	$_POST['fe3']	= cambiarFecha( $_POST['fe3'], '/', '-' );

if($_POST['busca'] == "Buscar")
{
	if($_POST['radiopor'][0] == "0")
	{ 
		$filtro = "and tb_sol_rec.fe_sol BETWEEN '".$_POST['fe1']."' and '".$_POST['fe2']."' ";
		echo"<script language='Javascript'>
				parent.document.f.consulta.value= \"$filtro\" ;
				parent.carga_consulta_busca();
        	</script>";	
	}
	if($_POST['radiopor'][0] == "1")
	{ 
		$filtro = "and tb_sol_rec.fe_sol = '".$_POST['fe3']."' ";
		echo"<script language='Javascript'>
			parent.document.f.consulta.value= \"$filtro\" ;
			parent.carga_consulta_busca();
        </script>";
	}
	if($_POST['radiopor'][0] == "2")
	{ 
		$filtro = "and tb_sol_rec.ods_sol = '".$_POST['valor'][0]."' ";
		echo"<script language='Javascript'>
			parent.document.f.consulta.value= \"$filtro\" ;
			parent.carga_consulta_busca();
        </script>";
	}
	if($_POST['radiopor'][0] == "3")
	{ 
		$filtro = "and tb_sol_rec.cc_sol = '".$_POST['valor'][1]."' ";
		echo"<script language='Javascript'>
			parent.document.f.consulta.value= \"$filtro\" ;
			parent.carga_consulta_busca();
        </script>";
	}
	if($_POST['radiopor'][0] == "4")
	{ 
		$texto_busca = $_POST['valor'][2];
		$filtro = "and tb_det_sol.desc_sol LIKE '$texto_busca%'";
		echo"<script language='Javascript'>
			parent.document.f.consulta.value= \"$filtro\" ;
			parent.carga_consulta_busca();
        </script>";
	}	
}
?>

              </table></td>
            </tr>
          </table>
          <label></label>
            </td>
      </tr>
    </table>    
    </td>
  </tr>
  <tr>
    <td height="2" align="center" valign="top"><img src="imagenes/barra.gif" alt="" width="698" height="2" /></td>
  </tr>
</table>
</form>
</body>
</html>
