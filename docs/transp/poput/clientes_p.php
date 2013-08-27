<?php
//*********************************************************************************************************************************
	include('../inc/config_db.php');	// CONECCION A LA BASE DE DATOS
	require('../inc/lib.db.php');
	$fecha	= date("Y-m-d");		// FECHA DE HOY
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Procesando.....</title>
<script language="javascript">
function Enviar()
{
	document.formu.submit();
}
</script>
</head>

<body>
<form id="formu" name="formu" method="post" action="clientes.php">

<?php				
 $cont_r	 = count($_POST['nom_cont']);	
 
 $cont_cont  = ($cont_r - 1);
/*********************************************************************************************************************************
								INGRESAMOS LA NUEVA ODS
**********************************************************************************************************************************/			
if($_POST['ingresa'] == "Ingresar")
{
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS",$co);
/**********************************************************************************************************************************
								PREGUNTAMOS SI EL CLIENTE DEL RUT YA EXISTE
**********************************************************************************************************************************/
		$query  = "SELECT * FROM tb_clientes WHERE rut_cli ='".$_POST['rut_cli']."' ";
		$result = mysql_query($query,$co);
		$cant   = mysql_num_rows($result);
		
		if($cant == 0)// SI NO ENCONTRO NINGUN REGISTRO ENTONCES LO INGRESAMOS
		{
			$sqli = "INSERT INTO tb_clientes (rut_cli, razon_s, nom_fant_cli, giro_cli, comuna_cli, ciudad_cli, fono_cli, mail_cli, web_cli, direc_cli) 
												VALUES(	'".$_POST['rut_cli']."', 
														'".$_POST['razon_s']."', 
														'".$_POST['nom_fant_cli']."', 
														'".$_POST['giro_cli']."', 
														'".$_POST['comuna_cli']."', 
														'".$_POST['ciudad_cli']."',
														'".$_POST['fono_cli']."',
														'".$_POST['mail_cli']."',
														'".$_POST['web_cli']."',
														'".$_POST['direc_cli']."' )";					
			if(dbExecute($sqli))
			{	
				$x=0;				// VARIABLE PARA INICIALIZAR EL CONTADOR	
				while($x < $cont_cont)
				{
					if($_POST['nom_cont'][$x] != "" )
					{
						$co=mysql_connect("$DNS","$USR","$PASS");
						mysql_select_db("$BDATOS",$co);
						
						$Sql_rep = "INSERT INTO tb_contacto_cli (rut_cc, nom_cont, mail_cont, fono_cont) VALUES('".$_POST['rut_cli']."','".$_POST['nom_cont'][$x]."', '".$_POST['mail_cont'][$x]."', '".$_POST['fono_cont'][$x]."')";
						dbExecute($Sql_rep);
					}
				$x++;
				}
/**********************************************************************************************************************************
			SI EL REGISTRO SE INGRESO CORRECTAMENTE ENVIAMOS UN MENSAJE Y REGRESAMOS
**********************************************************************************************************************************/
				echo"<input type='hidden' name='ingresa' id='ingresa' value='".$_POST['rut_cli']."' />";		
				echo "<script language='Javascript'>
					alert('El cliente Fue Ingresado Correctamente');
					document.formu.submit();
				 </script>";
//********************************************************************************************************************************
			}else{
				echo"<input type='hidden' name='ingresa' id='ingresa' value='".$_POST['rut_cli']."' />";	
				echo $sqli;
				echo "<script language='Javascript'>
					alert('¡ERROR! El Cliente no fue ingresado');
					document.formu.submit();
				 </script>";
			} 
		
		}else{
			echo"<input type='hidden' name='ingresa' id='ingresa' value='".$_POST['rut_cli']."' />";		
			echo "<script language='Javascript'>
				alert('No se puede ingresar el cliente, debido a que ya Existe en la base de datos');
				document.formu.submit();
			</script>";
		}
}
/*********************************************************************************************************************************
/*********************************************************************************************************************************
***								MODIFICAMOS LA ODS                                                                             ***
**********************************************************************************************************************************	
*********************************************************************************************************************************/	
if($_POST['modifica'] == "Modificar")
{
	$rut_cli = $_POST['rut_cli'];
	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS",$co);
	
	$SqlCont = "SELECT * FROM tb_contacto_cli WHERE rut_cc = '".$_POST['rut_cli']."' ";
	$ResCont = dbExecute($SqlCont);
	while ($vrows_cont = mysql_fetch_array($ResCont)) 
	{
    	$ContxCli[] = $vrows_cont;
	}
	$tot_cxc = count($ContxCli);
	
	$sql = "UPDATE tb_clientes SET 	razon_s			= '".$_POST['razon_s']."',
									nom_fant_cli 	= '".$_POST['nom_fant_cli']."', 
									giro_cli		= '".$_POST['giro_cli']."', 
									comuna_cli		= '".$_POST['comuna_cli']."', 
									ciudad_cli		= '".$_POST['ciudad_cli']."',
									fono_cli		= '".$_POST['fono_cli']."',
									mail_cli		= '".$_POST['mail_cli']."',
									web_cli			= '".$_POST['web_cli']."',
									direc_cli		= '".$_POST['direc_cli']."' 
									
									WHERE rut_cli 	= '".$_POST['rut_cli']."' ";				
	if(dbExecute($sql))
	{
		$x=0;	// VARIABLE PARA INICIALIZAR EL CONTADOR	
		while($x < $cont_cont)
		{
			$co=mysql_connect("$DNS","$USR","$PASS");
			mysql_select_db("$BDATOS",$co);
				
			$Sql_rep = "UPDATE tb_contacto_cli SET 	nom_cont		= '".ucwords($_POST['nom_cont'][$x])."',
													mail_cont 		= '".$_POST['mail_cont'][$x]."',
													fono_cont 		= '".$_POST['fono_cont'][$x]."'
													WHERE id_det 	= '".$_POST['id_det'][$x]."' ";
														
			mysql_query($Sql_rep, $co);
			$x++;
		}
				
		if($cont_cont > $tot_cxc)
		{
			$z = $tot_cxc;					// VARIABLE PARA INICIALIZAR EL CONTADOR	
			while($z < $cont_cont)
			{
				if($_POST['nom_cont'][$z] != "" )
				{
					$co=mysql_connect("$DNS","$USR","$PASS");
					mysql_select_db("$BDATOS",$co);
							
					$Sql_cont_c = "INSERT INTO tb_contacto_cli (rut_cc, nom_cont, mail_cont, fono_cont) VALUES('".$_POST['rut_cli']."','".$_POST['nom_cont'][$z]."', '".$_POST['mail_cont'][$z]."', '".$_POST['fono_cont'][$z]."')";
					dbExecute($Sql_cont_c);		
				}
				$z++;
			}
		}
				
		echo"<input type='hidden' name='modifica' id='modifica' value='$rut_cli' />";
		echo "<script language='Javascript'>
		
           		alert('La Modificacion se Realizo Correctamente');
				document.formu.submit();
        </script>";
	}else{
		echo"<input type='hidden' name='modifica' id='modifica' value='$rut_cli' />";
		echo "<script language='Javascript'>
		
           	alert('Error Al Modificar La ODS');
			document.formu.submit();
        </script>";
	}
}	

/*********************************************************************************************************************************
								ELIMINAMOS LA ODS
*********************************************************************************************************************************/
if($_POST['elimina']=="Eliminar")
{	
	$co=mysql_connect("$DNS","$USR","$PASS");
	mysql_select_db("$BDATOS", $co);
	
	$sqls="SELECT * FROM oti WHERE ods = '".$_POST['t1']."' ";
	$res = mysql_query($sqls,$co);
	$reg   = mysql_num_rows($res);
	if($reg == 0)// SI NO ENCONTRO NINGUNA OTI ASOCIADA A LA ODS, LA ELIMINAMOS
	{
		$sqld="DELETE FROM contratos WHERE ods='".$_POST['t1']."' ";
		mysql_query($sqld,$co);
		
		if(dbExecute($sqld))
		{
			echo"<input type='hidden' name='elimina' id='elimina' value='".$_POST['t1']."' />";
			echo "<script language='Javascript'>
		
           		alert('La ODS Fue eliminada Correctamente');
				document.formu.submit();
        	</script>";
		}else
			{ 
				echo"<input type='hidden' name='elimina' id='elimina' value='".$_POST['t1']."' />";
				echo "<script language='Javascript'>
		
           			alert('¡ERROR! Al Eliminar ODS');
					document.formu.submit();
        		</script>";
			}
	}else{
		echo"<input type='hidden' name='elimina' id='elimina' value='".$_POST['t1']."' />";
		echo "<script language='Javascript'>
		
           	alert('¡ERROR! LA ODS TIENE OTI ASOCIADAS A ELLA');
			document.formu.submit();
        </script>";
	}
}	
?>
  
</form>
</body>
</html>
