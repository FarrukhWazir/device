<?php
require_once('function.php'); 
sleep(1);
define('API_HOST', 'http://192.168.0.64'); 
define('API_USER', 'admin');
define('API_PASSWORD', 'hik12345'); 
$endpoint 	=	API_HOST .'/ISAPI/Event/capabilities';
$url		=	$endpoint;
$ch 		=	curl_init();
curl_setopt($ch, CURLOPT_URL,$endpoint);
curl_setopt($ch, CURLOPT_TIMEOUT, 80); //timeout after 30 seconds
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_USERPWD, API_USER.":".API_PASSWORD);
curl_setopt($ch, CURLOPT_VERBOSE, true);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
$xml=(curl_exec($ch));
curl_close($ch);
//echo htmlentities($xml);
$result 	=	(array)	new SimpleXMLElement($xml);
?>
<table class="table table-bordered">
	<tr>
	<td>HD Full</td><td><?=status_icon($result['isSupportHDFull'])?></td>
	<td>HD Error</td><td><?=status_icon($result['isSupportHDError'])?></td>
	</tr>
	<tr>
	<td>Nic Broken</td><td><?=status_icon($result['isSupportNicBroken'])?></td>
	<td>IP Conflict</td><td><?=status_icon($result['isSupportIpConflict'])?></td>
	</tr>
	<tr>
	<td>Ill Access</td><td><?=status_icon($result['isSupportIllAccess'])?></td>
	<td>Vi Exception</td><td><?=status_icon($result['isSupportViException'])?></td>
	</tr>
	<tr>
	<td>Vi Mismatch</td><td><?=status_icon($result['isSupportViMismatch'])?></td>
	<td>Record Exception</td><td><?=status_icon($result['isSupportRecordException'])?></td>
	</tr>
	<tr>
	<td>Trigger Focus</td><td><?=status_icon($result['isSupportTriggerFocus'])?></td>
	<td>Motion Detection</td><td><?=status_icon($result['isSupportMotionDetection'])?></td>
	</tr>
	<tr>
	<td>Video Loss</td><td><?=status_icon($result['isSupportVideoLoss'])?></td>
	<td>Tamper Detection</td><td><?=status_icon($result['isSupportTamperDetection'])?></td>
	</tr>
	<tr>
	<td>Person Queue Detection</td><td><?=status_icon($result['isSupportPersonQueueDetection'])?></td>
	<td>Teacher Behaviour Detect</td><td><?=status_icon($result['isSupportTeacherBehaviorDetect'])?></td>
	</tr>
	<tr>
	<td>Face Snap</td><td><?=status_icon($result['isSupportFaceSnap'])?></td>
	<td>City Management</td><td><?=status_icon($result['isSupportCityManagement'])?></td>
	</tr>
	<tr>
	<td>Mixed Target Detectection</td><td colspan='3'><?=status_icon($result['isSupportMixedTargetDetection'])?></td>
	</tr>
</table>

