<?php
require_once('function.php'); 
sleep(1);
define('API_HOST', 'http://192.168.0.108'); 
define('API_USER', 'admin');
define('API_PASSWORD', 'dha12345'); 
$endpoint = API_HOST .'/cgi-bin/magicBox.cgi?action=getSoftwareVersion';
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

//exploding response string to get version information
$response_arr1 = explode(',', $response);
$response_arr2 = explode('=', $response_arr1[0]);
$software_version = $response_arr2[1];

echo 'software_version = '.$software_version;

curl_close($ch);
 

?>