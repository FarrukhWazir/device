<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Hikvision {

	protected $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function reboot($data)
	{ 
		extract($data); 

		$endpoint = $host .'/ISAPI/System/reboot';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$endpoint);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80); //timeout after 30 seconds
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_USERPWD, $user.":".$password);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
		$xml=(curl_exec($ch));
		curl_close($ch);
		echo $xml;
		exit;


	}

	public function get_firmware_version($data)
	{ 
		extract($data); 
		
		$endpoint = $host .'/ISAPI/System/deviceInfo';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$endpoint);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80); //timeout after 30 seconds
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_USERPWD, $user.":".$password);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
		$xml=(curl_exec($ch));
		curl_close($ch);
		echo $xml;
		exit;


	}


	public function get_all_users($data)
	{ 
		extract($data);
		
		$endpoint = $host .'/cgi-bin/userManager.cgi?action=getUserInfoAll';
		$url	=	$endpoint;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$endpoint);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80); //timeout after 30 seconds
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_USERPWD, $user.":".$password);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); //get status code

		$response = curl_exec($ch);
		echo $response;

		curl_close($ch); 

	}

	public function add_new_user($data)
	{ 
		extract($data);
		
		$endpoint = $host .'/cgi-bin/userManager.cgi?action=addUser&user.Name='.$userName.'&user.Password='.$userPassword.'&user.Group='.$userGroup.'&user.Sharable='.$userSharable.'&user.Reserved='.$userReserved;
		$url	=	$endpoint;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$endpoint);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80); //timeout after 30 seconds
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_USERPWD, $user.":".$password);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); //get status code

		$response = curl_exec($ch);
		echo $response;

		curl_close($ch); 

	}

	public function delete_user($data)
	{ 
		extract($data);
		
		$endpoint = $host .'/cgi-bin/userManager.cgi?action=deleteUser&name='.$userName;
		$url	=	$endpoint;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$endpoint);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80); //timeout after 30 seconds
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_USERPWD, $user.":".$password);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); //get status code

		$response = curl_exec($ch);
		echo $response;

		curl_close($ch); 

	}

	public function unistall_app($data)
	{ 
		extract($data);
		
		$endpoint = $host .'/cgi-bin/dhop.cgi?action=uninstall&appName='.$appName;
		$url	=	$endpoint;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$endpoint);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80); //timeout after 30 seconds
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_USERPWD, $user.":".$password);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); //get status code

		$response = curl_exec($ch);
		echo $response;

		curl_close($ch); 

	}

	public function download_app_log($data)
	{ 
		extract($data);
		
		$endpoint = $host .'/cgi-bin/dhop.cgi?action=downloadLog&appName='.$appName;
		$url	=	$endpoint;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$endpoint);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80); //timeout after 30 seconds
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_USERPWD, $user.":".$password);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); //get status code

		$response = curl_exec($ch);
		echo $response;

		curl_close($ch); 

	}

	public function start_stop_app($data)
	{ 
		extract($data);

		$endpoint = $host .'/cgi-bin/installManager.cgi?action='.$action.'&appname='.$appName.'&appid='.$appId;
		$url	=	$endpoint;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$endpoint);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80); //timeout after 30 seconds
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_USERPWD, $user.":".$password);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); //get status code

		$response = curl_exec($ch);
		echo $response;

		curl_close($ch); 

	}


	public function update_firmware($file_arr,$data){

		extract($data);
		$endpoint = $host.'/ISAPI/System/updateFirmware';

		$target_dir 		=	"assets/img/";
		$file 				= 	$target_dir . basename($file_arr["file"]["name"]);
		$image_file_type 	= 	strtolower(pathinfo($file,PATHINFO_EXTENSION));
		if($image_file_type !='dav')
		{
		 die('Invalid File.');
		}
		else
		{
			move_uploaded_file($file_arr["file"]["tmp_name"],$file);
		}
		//$file="digicap.dav";
		$data = fopen ($file, 'rb');
		$size=filesize ($file);
		$contents= fread ($data, $size);
		fclose ($data);
		//$encoded= strigToBinary($string).PHP_EOL;

		//$encoded= base64_encode($contents); 
		
		$encoded = base64_encode(gzdeflate( gzencode($contents)) );

		//unlink($file);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$endpoint);
		curl_setopt($ch, CURLOPT_TIMEOUT, 0); //timeout after 30 seconds
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($ch, CURLOPT_ENCODING, "" );
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$encoded);  
		curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/octet-stream'));
		curl_setopt($ch, CURLOPT_USERPWD, $user.":".$password);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
		$xml=(curl_exec($ch));
		curl_close($ch);
		echo $xml;
		exit;

	}

	public function updatefirmware_testing(){

		
		$endpoint = 'http://192.168.0.64/ISAPI/System/updateFirmware';

		$file 				= 	'assets/img/digicap.dav';
		$gzfile 			= 	'assets/img/digicap.dav.gz';

		

		$data = fopen ($file, 'rb');
		$size=filesize ($file);
		$contents= fread ($data, $size);
		fclose ($data);
		
		//$encoded= base64_encode($contents); 
		//$encoded= gzencode(gzdeflate($contents, 9),9 );


		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://192.168.0.64/ISAPI/System/updateFirmware",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "PUT",
		  CURLOPT_POSTFIELDS =>$contents,
		  CURLOPT_HTTPAUTH => CURLAUTH_ANY,
		  CURLOPT_USERPWD => "admin:hik12345",
		  CURLOPT_VERBOSE => true,
		  CURLOPT_HTTPHEADER => array(
		  	"Accept: text/html, application/xhtml+xml",
			"Accept-Language: zh-CN",
			"Content-Type: multipart/form-data;",
			"Accept-Encoding: gzip, deflate, br",
			"Content-Length: 9907",
			"connection Keep-Alive",
			"Cache-Control: no-cache",
		  	'Content-disposition:form-data; name="updateFile";',
		    "Content-Type:application/octet-stream",
		    "Connection:keep-alive"

		  ),
		));
		

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;
		exit;
	}

	public function get_upgrade_state($data){

		extract($data); 
		
		$endpoint = $host .'/cgi-bin/upgrader.cgi?action=getState';
		$url	=	$endpoint;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$endpoint);
		curl_setopt($ch, CURLOPT_TIMEOUT, 80); //timeout after 30 seconds
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_USERPWD, $user.":".$password);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); //get status code

		$response = curl_exec($ch);
		echo $response;

		curl_close($ch); 

	}


}