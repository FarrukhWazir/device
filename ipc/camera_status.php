<?php
require_once('function.php'); 
sleep(1);
define('API_HOST', 'http://192.168.0.64'); 
define('API_USER', 'admin');
define('API_PASSWORD', 'hik12345'); 
$endpoint = API_HOST .'/ISAPI/System/workingstatus/capabilities?format=json';
$url	=	$endpoint;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$endpoint);
curl_setopt($ch, CURLOPT_TIMEOUT, 80); //timeout after 30 seconds
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_USERPWD, API_USER.":".API_PASSWORD);
curl_setopt($ch, CURLOPT_VERBOSE, true);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
$result=json_decode(curl_exec($ch),true);
curl_close($ch);
//print_r($result);
$channelStatus	=	$result['WorkingStatusCap']['ChanStatus'];
$hdStatus		=	$result['WorkingStatusCap']['HDStatus'];
?>
<table class="table table-bordered">
	<tr>
    	<th colspan="2"  style="text-align:center">Channel Status</th>
    </tr>
	<tr>
    	<td>Channel No</td>
        <td><?=($channelStatus['chanNo'])?></td>
    </tr>
	<tr>
    	<td>Analog Channel</td>
        <td><?=status_icon($channelStatus['enable'])?></td>
    </tr>
	<tr>
    	<td>Online Status</td>
        <td><?=status_icon($channelStatus['online'])?></td>
    </tr>
	<tr>
    	<td>Signal</td>
        <td><?=$channelStatus['signal']==1?'Normal':'Signal Loss'?></td>
    </tr>
	<tr>
    	<td>Link Number</td>
        <td><?=$channelStatus['linkNum']?></td>
    </tr>
	<tr>
    	<td>Bit Rate</td>
        <td><?=$channelStatus['bitRate']?> kbps</td>
    </tr>
    <tr>
    	<th colspan="2" style="text-align:center">HD Status</th>
    </tr>
	<tr>
    	<td> HDD No</td>
        <td><?=$hdStatus['HDNo']?></td>
    </tr>
	<tr>
    	<td>Analog Channel</td>
        <td><?=status_icon($hdStatus['enable'])?></td>
    </tr>
	<tr>
    	<td>Volume</td>
        <td><?=$hdStatus['volume']?> MB</td>
    </tr>
	<tr>
    	<td>Link Number</td>
        <td><?=$hdStatus['linkNum']?></td>
    </tr>
	<tr>
    	<td>Free Space</td>
        <td><?=$hdStatus['freeSpace']?> MD</td>
    </tr>
	<tr>
    </tr>
</table>

