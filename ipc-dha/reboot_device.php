<?php
require_once('function.php'); 
sleep(1);


define('API_HOST', 'http://192.168.0.108'); 
define('API_USER', 'admin');
define('API_PASSWORD', 'dha12345'); 
$endpoint = API_HOST .'/cgi-bin/magicBox.cgi?action=reboot';
$url	=	$endpoint;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$endpoint);
curl_setopt($ch, CURLOPT_TIMEOUT, 80); //timeout after 30 seconds
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_USERPWD, API_USER.":".API_PASSWORD);
curl_setopt($ch, CURLOPT_VERBOSE, true);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); //get status code

$response = curl_exec($ch);
echo $response;

curl_close($ch); 

?>