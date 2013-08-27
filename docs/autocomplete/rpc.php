<?php
		$DNS		= "192.168.2.7";
		$USR		= "consulta";
		$PASS		= "Con5ulta";
		$BDATOS		= "MGYT3";
		
		$co=mssql_connect("$DNS","$USR","$PASS") or die (" Imposible conectar a la base de datos ");
		mssql_select_db("$BDATOS", $co);
		
		// Is there a posted query string?
		if(isset($_POST['queryString'])) 
		{
			$queryString = $_POST['queryString'];
			//$queryString = mysql_real_escape_string($_POST['queryString']);
			// Is the string length greater than 0?
			
			if(strlen($queryString) >0) 
			{
				$query 	= "SELECT TOP 10 iw_tprod.DesProd FROM softland.iw_tprod WHERE iw_tprod.DesProd LIKE '$queryString%' ";
				$resp	= mssql_query($query, $co);
				
				if($resp) 
				{
					while ($result = mssql_fetch_assoc($resp))
					{
	         			echo '<li onClick="fill(\''.htmlentities($result['DesProd']).'\');">'.htmlentities($result['DesProd']).'</li>';
					}
	         	}
				
			} else {
				echo 'ERROR: Problemas con la consulta.';
			}
			
		}
?>