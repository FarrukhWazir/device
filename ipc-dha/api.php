<?php
sleep(2);
define('API_HOST', 'http://192.168.0.78'); 
define('API_USER', 'admin');
define('API_PASSWORD', 'bilo420$$$'); 
$endpoint = API_HOST .$_POST['api']; //'/ISAPI/System/workingstatus/capabilities?format=json';
$url	=	$endpoint;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$endpoint);
curl_setopt($ch, CURLOPT_TIMEOUT, 80); //timeout after 30 seconds
//curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_USERPWD, API_USER.":".API_PASSWORD);
//curl_setopt($ch, CURLOPT_VERBOSE, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		"Cache-Control: no-cache",
		"Content-Type: application/json"
	)
);
$result=curl_exec ($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
curl_close ($ch);


