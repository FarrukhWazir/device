<?php
require_once('function.php'); 
define('API_HOST', 'http://192.168.0.78'); 
define('API_USER', 'admin');
define('API_PASSWORD', 'bilo420$$$'); 
$endpoint = API_HOST .'/ISAPI/System/updateFirmware';



$target_dir 		=	"temp-uploads/";
$file 				= 	$target_dir . basename($_FILES["file"]["name"]);
$image_file_type 	= 	strtolower(pathinfo($file,PATHINFO_EXTENSION));
if($image_file_type !='dav')
{
 die('Invalid File.');
}
else
{
	move_uploaded_file($_FILES["file"]["tmp_name"],$file);
}
//$file="digicap.dav";
$data = fopen ($file, 'rb');
$size=filesize ($file);
$contents= fread ($data, $size);
fclose ($data);
//$encoded= strigToBinary($string).PHP_EOL;
$encoded= base64_encode($contents); 

 unlink($file);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$endpoint);
curl_setopt($ch, CURLOPT_TIMEOUT, 80); //timeout after 30 seconds
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_POST,           1 );
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_POSTFIELDS,$encoded);  
curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: text/plain'));
curl_setopt($ch, CURLOPT_USERPWD, API_USER.":".API_PASSWORD);
curl_setopt($ch, CURLOPT_VERBOSE, true);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
$xml=(curl_exec($ch));
curl_close($ch);
//echo htmlentities($xml); 
$result 			=	(array)	new SimpleXMLElement($xml);
$result['count']	= strlen($encoded);	
//$result['binay']	= ($encoded);		
//die(json_encode($result));
//echo "<pre>";
//print_r($result);
if($result['statusCode']=='2')
{
 	echo "Firmware is Upgrading.";
}
else
{
	echo $result['subStatusCode'];
}
exit;
/*****************Reboot*********************/
/*$endpoint = API_HOST .'/ISAPI/System/reboot';
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
curl_close($ch);*/
echo "<p align='center'>Firmware updated successfully.</p>";
//echo htmlentities($xml); 
?>