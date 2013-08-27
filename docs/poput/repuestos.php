<?php
	include('../inc/config_db.php');
	require('../inc/lib.db.php');
	$cod_ue = "Automatico"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Mantenedor de Repuestos</title>

<link href="../inc/bibliocss.css" rel="stylesheet" type="text/css">

<script type="text/javascript" LANGUAGE="JavaScript">

function carga(codigo, nombre, contrato)
{
    document.fu.cod_rep.value 	= codigo;
	document.fu.nom_rep.value 	= nombre;
	document.fu.cont_rep.value 	= contrato;
}

function mod()
{
var agree=confirm("Esta Seguro de Querer Modificar Este Registro ?");
if (agree)
	return true ;
else
	return false ;
}

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
	var c1		= document.fu.c1.value;
	var nom_rep	= document.fu.nom_rep.value;
	var cod_rep	= document.fu.cod_rep.value;
	
	if(c1 != "")
	{
		if(nom_rep != "")
		{
			var agree=confirm("Esta Seguro de Querer Ingresar Este Registro ?");
			if (agree)
				return true ;
			else
				return false ;	
		}else{
				alert("Debe Ingresar descripcion");
				document.fu.nom_rep.focus();
				return false ;
			}
	}else{
			alert("Debe seleccionar area");
			document.fu.c1.focus();
			return false ;
		}
}

function CambiaColor(esto,fondo,texto)
{
    esto.style.background=fondo;
    esto.style.color=texto;
	esto.style.cursor='hand';
}

</SCRIPT>

<style type="text/css">
<!--
body {
	background-color: #999999;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>

    <style type="text/css" media="all">

    input, textarea {
        font: 12px Verdana, Arial, Helvetica, serif;
        border: #153244 1px solid;
        color: #000000;
        background-color: #FFFFFF;
        padding: 1px 3px 1px 3px;
    }

    select {
        font: 11px Verdana, Arial, Helvetica, serif;
        border: #153244 1px solid;
        color: #000000;
        background-color: #F2F2F2;
    }

    .Estilo8 {color: #000000}
    </style>
</head>
<body>

<table width="670" height="231" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="txtnormal2">
  <tr>
    <td width="670" height="27" align="center" valign="middle" class="txt01">Repuestos</td>
  </tr>
  
  <tr>
    <td height="140" align="center" valign="top">
    
    <table width="660" border="0" cellpadding="0" cellspacing="0" class="txtnormal">
      <tr>
        <td width="660" height="183" align="center" valign="top">
        
            <form name="fu" action="" method="POST">
        
          <table width="660" height="145" border="1" bordercolor="#FFFFFF" bgcolor="#cedee1">
            <tr>
              <td width="462" height="141" align="center" valign="top"><table width="638" border="0" cellpadding="1" cellspacing="0" class="txtnormal">
                  
                  <tr>
                    <td width="129" align="left">&nbsp;</td>
                    <td width="505" colspan="2" align="left">&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td width="129" height="23" align="left">Codigo : <span class="txtnormaln">
<?php
 if($_POST['busca']== "Buscar")
 {
 	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sqlc="SELECT * FROM tb_repuestos WHERE cod_rep='".$_POST['cod_rep']."' ORDER BY nom_rep";
	$respuesta=mysql_query($sqlc,$co);
	while($vrows=mysql_fetch_array($respuesta))
	{
		$nom_rep	="".$vrows['nom_rep']."";
		$cod_rep	="".$vrows['cod_rep']."";  
		$cont_rep	="".$vrows['cont_rep']."";	  							
	}
 }                              
?>
                    </span></td>
                    <td colspan="2" align="left"><input name="cod_rep" type="text" id="cod_rep" size="18" value="<?php echo $cod_rep ?>" />
                      <input name="busca" type="submit" class="boton_bus" id="busca" value="Buscar" /></td>
                  </tr>
                  <tr>
                    <td width="129" height="19" align="left">Area/Cont :</td>
                    <td colspan="2" align="left"><span class="Estilo8">
                      <select name="cont_rep" id="cont_rep" style="width: 300px;" >
                        <? echo"<option selected='selected' value='$cont_rep'>$cont_rep</option>";?>
                        <option value="Carros SQM">Carros SQM</option>
                        <!-- <option value="Cilindros">Cilindros</option>-->
                        <!-- <option value="Desgaste">Desgaste</option>-->
                        <!--<option value="Ventiladores">Ventiladores</option>-->
                        <option value="Carros Metaleros 80 Ton.">Carros Metaleros 80 Ton.</option>
                        <option value="GMIN">GMIN</option>
                        <option value="Otros Maestranza">Otros Maestranza</option>
                        <option value="Paradas de ruedas">Paradas de ruedas</option>
                        <option value="Paradas Transap">Paradas Transap</option>
                        <option value="Reparacion de carros">Reparacion de carros</option>
                        <option value="Trabajos MGYT">Trabajos MGYT</option>
                        <option value="Trabajos Menores Rockmine">Trabajos Menores Rockmine</option>
                        <option value="Ventiladores Gmin">Ventiladores Gmin</option>
                      </select>
                    </span></td>
                  </tr>
                  
                  <tr>
                    <td height="23" align="left">Descripcion (nombre)</td> 
                    <td colspan="2" align="left"><label>
                    <input name="nom_rep" type="text" id="nom_rep" size="78" value="<?php echo $nom_rep ?>" />
                    </label></td>
                  </tr>
                  <tr>
                    <td height="12" colspan="3" align="center">&nbsp;</td>
                    </tr>
                  <tr>
                    <td height="24" colspan="3" align="center">
                    
                     <input name="ingresa" type="submit" class="boton_ing" id="button3" value="Ingresar" onclick="return ing()" />
                     <input name="modifica" type="submit" class="boton_mod" id="button4" value="Modificar" onclick="return mod()" />
                     <input name="elimina" type="submit" class="boton_eli" id="button5" value="Eliminar" onclick="return eli()" />
                     
                     </td>
                  </tr>
              </table></td>
            </tr>
          </table>
          <div id="listado">
            
            <table width="655" border="0" bordercolor="#FFFFFF" bgcolor="#cedee1" class="txtnormal8" cellspacing="1" cellpadding="0" >
              <tr>
                <td width="5%" align="left">EDIT</td>
                <td width="15%" align="left">CODIGO</td>
                <td width="21%" align="left">CONTRATO</td>
                <td width="59%" align="left"><span class="Estilo8">NOMBRE</span></td>
<? 
/*********************************************************************************************************************
                               INGRESO DE REGISTROS  											    
**********************************************************************************************************************/
if($_POST['ingresa'] == "Ingresar")
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS",$co);
						
	$sql  = "SELECT nom_rep FROM tb_repuestos WHERE nom_rep = '".$_POST['nom_rep']."' ";
	$resp = mysql_query($sql, $co);
	$cant = mysql_num_rows($resp);
	if($cant < 1)
	{
		$sql  = "INSERT INTO tb_repuestos (cod_rep, cont_rep, nom_rep, stock_rep) VALUES ('".$_POST['cod_rep']."', '".$_POST['cont_rep']."', '".ucwords($_POST['nom_rep'])."', 0)";
		if(dbExecute($sql))
		{				
			echo"<script type='text/javascript' language='Javascript'>
				var ods = window.opener.f.t1.value;
				window.opener.f.submit();
				window.close();
			</script>";
		}else{
			alert("El Ingreso a fallado");
		}
	}else{
			alert("El Repuesto ya se encuentra ingresado");
		 }
}    
/********************************************************************************************************************                                
				MODIFICAR REGISTROS  											    
*********************************************************************************************************************/	

if($_POST['modifica'] == "Modificar")
{
	$sql="UPDATE tb_repuestos SET nom_rep='".$_POST['nom_rep']."', cont_rep='".$_POST['cont_rep']."' WHERE cod_rep = '".$_POST['cod_rep']."' ";
	if(dbExecute($sql))
	{
		alert("La Modificacion se Realizo Correctamente");
		echo"<script type='text/javascript' language='Javascript'>
			window.opener.f.submit();
			window.close();
        </script>";
	}else{
		alert("Error: La Modificacion a Fallado");
	}
	
}
//*******************************************************
//                 Eliminar Archivo    					*
//*******************************************************
if($_POST['elimina']=="Eliminar")
{ 	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sqlCons 	= "SELECT id_det FROM tb_detrep WHERE cod_rep = '".$_POST['cod_rep']."' ";
	$res		= mysql_query($sqlCons, $co);
	$cant		= mysql_num_rows($res);
	if($cant < 1)
	{
		$sqld = "DELETE FROM tb_repuestos WHERE cod_rep= '".$_POST['cod_rep']."' ";
		if(dbExecute($sqld))
		{
			echo"<script type='text/javascript' language='Javascript'>
				window.opener.f.submit();
				window.close();
			</script>";
		}else{
			alert("La Eliminacion a Fallado");
		}
	}else{
		alert("¡No se puede eliminar el Repuesto! Tiene Ingresos o Egresos Asociados");
	}
}
/********************************************************************************************************************
			LISTAMOS LOS REPUESTOS INGRESADOS
********************************************************************************************************************/
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);

	$sql		= "SELECT * FROM tb_repuestos ORDER BY nom_rep";
	$respuesta	= mysql_query($sql,$co);
	$color 		= "#ffffff";
	
	while($vrows	= mysql_fetch_array($respuesta))
	{		
		$cod_rep 	= $vrows['cod_rep'];
		$nom_rep 	= $vrows['nom_rep'];
		$cont_rep 	= $vrows['cont_rep'];
		
	echo("<tr bgcolor=$color class='txtnormal8' onMouseOver=CambiaColor(this,'#cccccc','#000000') onMouseOut=CambiaColor(this,'$color','#000000') onDblClick=\"javascript:muestra('$ods')\" >
		
			<td bgcolor='#cedee1' align='left'><a href='#' onclick='carga(\"$cod_rep\", \"$nom_rep\", \"$cont_rep\")'><img src='../imagenes/edit.png' border='0' valign='top' alt='Editar'/></a></td>
			<td align='left' width='5%'>&nbsp;&nbsp;&nbsp;$cod_rep</td>
			<td align='left' width='8%'>&nbsp;$cont_rep</td>
			<td align='left' width='7%'>&nbsp;$nom_rep</td>
		</tr> ");	
									
			if($color == "#ffffff"){ $color = "#ddeeee"; }
			else{ $color = "#ffffff"; }			
	}	
?>
              </tr>
            </table>
          </div>
          <br>
            </form>        </td>
      </tr>
    </table>    </td>
  </tr>
</table>
</body>
</html>