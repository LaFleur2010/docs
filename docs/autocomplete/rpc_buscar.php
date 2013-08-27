<?php
		/*$DNS		= "192.168.2.7/SOFTLAND";
		$USR		= "sa";
		$PASS		= "softland";
		$BDATOS		= "MGYT3";*/
		include ('../inc/config_db.php');
		
		$co=mysql_connect("$DNS","$USR","$PASS") or die (" Imposible conectar a la base de datos ");
		mysql_select_db("$BDATOS", $co);
		
		// Is there a posted query string?
		if(isset($_POST['queryString'])) 
		{
			$queryString = mysql_real_escape_string($_POST['queryString']);
			
			// Is the string length greater than 0?
			
			if(strlen($queryString) >0) 
			{
				$query 	= "SELECT desc_sol FROM tb_det_sol WHERE desc_sol LIKE '%$queryString%' LIMIT 10";
				//$query 	= "SELECT DesProd FROM iw_tprod WHERE DesProd LIKE '$queryString%' LIMIT 10";
				$resp	= mysql_query($query, $co);
				
				if($resp) 
				{
					while ($result = mysql_fetch_array($resp))
					{
	         			echo '<li onClick="fill(\''.$result['desc_sol'].'\');">'.$result['desc_sol'].'</li>';
					}
	         	}
				
			} else {
				echo 'ERROR: Problemas con la consulta.';
			}
			
		}
?>