<?php
function detecta_ip_isp()
{
	if (getenv("HTTP_X_FORWARDED_FOR"))
	{
		$ip = getenv("HTTP_X_FORWARDED_FOR");
		$client = gethostbyaddr($_SERVER['HTTP_X_FORWARDED_FOR']);
	}else{
		$ip = getenv("REMOTE_ADDR");
		$client = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	}
	$str = preg_split("/\./", $client);
	$i = count($str);
	$x = $i - 1;
	$n = $i - 2;
	$isp = $str[$n] . "." . $str[$x];
	
	//return $ip;
	return $isp;
}

function detecta_usuario()
{
	if (getenv("HTTP_X_FORWARDED_FOR"))
	{
		$ip_usuario = getenv("HTTP_X_FORWARDED_FOR");
	}else{
		$ip_usuario = getenv("REMOTE_ADDR");
	}
	
	$ip_ini_Ran 	= "192.168.3.1";
	$ip_fin_Ran 	= "192.168.3.254";
	
	$ip_ini_Cod 	= "192.168.2.1";
	$ip_fin_Cod 	= "192.168.2.254";
	
	//$ip_usuario 	= "192.168.1.255";
	$startlong_C 	= ip2long($ip_ini_Cod);
	$endlong_C 		= ip2long($ip_fin_Cod);
	$startlong_R 	= ip2long($ip_ini_Ran);
	$endlong_R 		= ip2long($ip_fin_Ran);
	
	$targetlong = ip2long($ip_usuario);
	
	if(($startlong_C <= $targetlong AND $targetlong <= $endlong_C) or ($startlong_R <= $targetlong AND $targetlong <= $endlong_R))
	{
		$resultado = "Aceptado";
	}else{
		$resultado = "Rechazado";
	}
	return $resultado;
}
?>