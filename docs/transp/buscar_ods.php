<?php
  include('../inc/config_db.php');  // Incluimos archivo de configuracion de la conexion
  include('../inc/lib.db.php');   // Incluimos archivo de libreria de funciones PHP
/***********************************************************************************************************************
							Inicializamos las variables de los combos
***********************************************************************************************************************/	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Buscar Guias</title>

<!-- HOJA DE ESTILO -->
<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">

<!-- MENU -->
<script type="text/javascript" language="JavaScript1.2" src="inc/stmenu.js"></script>

<script type="text/javascript" language="JavaScript" src="inc/funciones.js"></script>

<!-- CALENDARIO -->
<LINK href="../Inc/epoch_styles.css" type=text/css rel=stylesheet>
<SCRIPT src="../inc/epoch_classes.js" type=text/javascript></SCRIPT>

<!--<script type="text/javascript" src="../autoComplete/jquery-1.2.1.pack.js"></script>-->
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>

<SCRIPT type=text/javascript>
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
NOMBRE: 		lookup(inputString);
DESCRIPCION:	FUNCION PARA MOSTRAR EL AUTOCOMPLETE CON AJAX (JQUERY)
AUTOR: 			WWW.GOOGLE.COM	
FECHA: 			25/06/2010
******************************************************************************************************************/
function lookup(inputString) {
	/*var desc_sol 	= document.getElementsByName("desc_sol[]");
	var t = desc_sol.length;
   	for(var x = 0; x < t; ++x)
   	{*/
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#suggestions').hide();
		} else {
			$.post("autoComplete/rpc_buscar.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#suggestions').show();
					$('#autoSuggestionsList').html(data);
				}
			});
		}
		
	//}//fin for	
		
} // lookup
	
function fill(thisValue) {
	$('#inputString').val(thisValue);
	setTimeout("$('#suggestions').hide();", 200);
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
	
	.suggestionsBox {
		position: relative;
		left: 2px;
		margin: 10px 0px 0px 0px;
		width: 500px;
		background-color: #212427;
		-moz-border-radius: 7px;
		-webkit-border-radius: 7px;
		border: 2px solid #000;	
		color: #fff;
	}
	
	.suggestionList {
		margin: 0px;
		padding: 0px;
	}
	
	.suggestionList li {
		
		margin: 0px 0px 3px 0px;
		padding: 3px;
		cursor: pointer;
	}
	
	.suggestionList li:hover {
		background-color: #659CD8;
	}
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
                  <td width="49" height="37" align="left"><img src="../imagenes/v.png" width="44" height="37" /></td>
                  <td width="680" align="center">BUSCAR ORDEN DE SERVICIO (TRANSPORTES)</td>
                  <td width="45" align="center"><img src="../imagenes/bus.gif" width="45" height="33" /></td>
                </tr>
              </table>                </td>
            </tr>
            <tr>
              <td height="182" align="center"><table width="694" height="268" border="0" class="txtnormalnn">
                <tr>
                  <td width="1" height="28" align="left">&nbsp;</td>
                  <td width="125" align="left" valign="top">&nbsp;
                    <label>
                  <input name="radiopor[]" type="radio" id="0" value="0" onclick="validar(this);"/> 
                    ENTRE FECHAS</label></td>
                  <td width="203" align="left" valign="top">
                  <div id="valor[]" style="WIDTH: 95%;">
                    <input id="date_field2" style="WIDTH: 7em;background-color:#cedee1;border:0;" name="fe1" value="<? echo $fe1; ?>" />&nbsp;&nbsp;&nbsp;
                    <input id="date_field3" style="WIDTH: 7em;background-color:#cedee1;border:0;" name="fe2" value="<? echo $fe2; ?>" />
                  </div>                  </td>
                  <td width="112" align="left" valign="top"><label>
                    <input name="radiopor[]" type="radio" id="1" value="1" onclick="validar(this);"/> 
                    POR FECHA<span style="WIDTH: 47%;">
                    <? $fe=cambiarFecha( $fe, '-', '/' ); ?>
                    </span></label></td>
                  <td width="231" align="left" valign="top">
                  <div id="valor[]" style="WIDTH: 47%;">
                    <input id="date_field" style="WIDTH: 7em;background-color:#cedee1;border:0;" name="fe3" value="<? echo $fe; ?>" />
                  </div></td>
                </tr>
                <tr>
                  <td height="27" align="left">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;<label>
<input name="radiopor[]" type="radio" id="radiopor[]" value="2" onclick="validar(this);"/>                  
POR Nº ORDEN</label></td>
                  <td align="left" valign="top"><input name="valor[]" type="text" id="textfield" size="30" style="background-color:#cedee1;border:0;"/></td>
                  <td align="left" valign="top"><label>
                      <input name="radiopor[]" type="radio" id="radiopor[]" value="3" onclick="validar(this);"/> 
                  POR CONDUCTOR</label></td>
                  <td align="left" valign="top"><input name="valor[]" type="text" id="textfield7" size="35" style="background-color:#cedee1;border:0;"/></td>
                </tr>
                <tr>
                  <td height="30" align="left">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;<label>
                    <input name="radiopor[]" type="radio" id="radiopor[]" value="4" onclick="validar(this);"/>
                    POR CORDINADOR</label></td>
                  <td colspan="3" align="left" valign="top">
                  <input name="valor[]" id="inputString" type="text" size="84" style="background-color:#cedee1;border:0;" onkeyup="lookup(this.value);" onblur="fill();"/>
                    <div class="suggestionsBox" id="suggestions" style="display: none;">
                    <img src="autoComplete/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
                    <div class="suggestionList" id="autoSuggestionsList">&nbsp;                    </div>
                    </div>                    </td>
                  </tr>
                <tr>
                  <td height="97" colspan="5" align="left"><label></label></td>
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
