<?php
require_once('function.php'); 
//sleep(1);
define('API_HOST', 'http://192.168.0.78'); 
define('API_USER', 'admin');
define('API_PASSWORD', 'bilo420$$$'); 
$endpoint = API_HOST .'/ISAPI/System/reboot';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$endpoint);
curl_setopt($ch, CURLOPT_TIMEOUT, 80); //timeout after 30 seconds
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_USERPWD, API_USER.":".API_PASSWORD);
curl_setopt($ch, CURLOPT_VERBOSE, true);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
$xml=(curl_exec($ch));
curl_close($ch);
//echo htmlentities($xml); 
$result 	=	(array)	new SimpleXMLElement($xml);
if($result['statusCode']==1)
{
	echo "<p align='center'>Rebooted successfully.</p>";
}
else
{
	echo "<p  align='center'>Reboot Failed.</p>";
}
?>