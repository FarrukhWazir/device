<?php 
ini_set('memory_limit', '1024M');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dahua {

	protected $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function reboot($data)
	{ 
		extract($data); 
		
		$endpoint = $host .'/cgi-bin/magicBox.cgi?action=reboot';
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
		if($response !='')
			echo $response;
		else
			echo 'Reboot Failed!';

		curl_close($ch); 

	}

	public function get_time($data)
	{ 
		extract($data); 
		
		$endpoint = $host .'/cgi-bin/magicBox.cgi?action=getCurrentTime';
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
		if($response !='')
			echo '1';
		else
			echo '0';

		curl_close($ch); 

	}

	public function get_firmware_version($data)
	{ 
		extract($data); 
		
		$endpoint = $host .'/cgi-bin/magicBox.cgi?action=getSoftwareVersion';
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

		$endpoint = $host .'/cgi-bin/installManager.cgi?action='.$action.'&appname='.$appName;
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


	public function update_firmware($file,$data)
	{ 		
		$postdata = $data;
		extract($data);

		$cfile = curl_file_create($file['file']['tmp_name'],'bin',$file['file']['name']);
		$imgdata = array('file' => $cfile);
		
		$endpoint = $host .'/cgi-bin/upgrader.cgi?action=uploadFirmware';
		$url	=	$endpoint;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$endpoint);
		curl_setopt($ch, CURLOPT_TIMEOUT, 8000000); //timeout after 30 seconds
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, true); // enable posting
		curl_setopt($ch, CURLOPT_POSTFIELDS, $imgdata);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_USERPWD, $user.":".$password);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: multipart/form-data'));
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); //get status code

		$response = curl_exec($ch);
		echo $response;
		

		curl_close($ch); 

	}

	public function update_firmware_from_url($data)
	{ 		
		$postdata = $data;
		extract($data);

		$firmware_url = str_replace($tenant, 'ska', $firmware_url);

		$auth = base64_encode($auth);
		$context = stream_context_create([
		    "http" => [
		        "header" => "Authorization: Basic $auth"
		    ]
		]);
		//$data = file_get_contents("https://ska.cumulocity.com/inventory/binaries/704", false, $context );

		$data = file_get_contents($firmware_url, false, $context );

		$file = "assets/img/".time().".bin";

		$myfile = fopen($file, "w") or die("Unable to open file!");
		fwrite($myfile, $data);

		fclose($myfile);


		$cfile = curl_file_create($_SERVER['DOCUMENT_ROOT'].'/device_management/'.$file,'bin',"firmware.bin");
		$imgdata = array('file' => $cfile);

		
		$endpoint = $host .'/cgi-bin/upgrader.cgi?action=uploadFirmware';
		$url	=	$endpoint;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$endpoint);
		curl_setopt($ch, CURLOPT_TIMEOUT, 8000000); //timeout after 30 seconds
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, true); // enable posting
		curl_setopt($ch, CURLOPT_POSTFIELDS, $imgdata);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_USERPWD, $user.":".$password);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: multipart/form-data'));
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); //get status code

		$response = curl_exec($ch);
		echo $response;
		//echo $status_code;
		
		unlink($file);
		curl_close($ch); 

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

	public function installapp($data)
	{ 
		$postdata = $data;
		extract($data);

		$software_url = str_replace($tenant, 'ska', $software_url);

		$auth = base64_encode($auth);
		$context = stream_context_create([
		    "http" => [
		        "header" => "Authorization: Basic $auth"
		    ]
		]);

		$data = file_get_contents($software_url, false, $context );

		$file = "assets/img/".time().".bin";

		$myfile = fopen($file, "w") or die("Unable to open file!");
		fwrite($myfile, $data);

		fclose($myfile);


		$cfile = curl_file_create($_SERVER['DOCUMENT_ROOT'].'/device_management/'.$file,'bin',"demo.bin");
		$imgdata = array('file' => $cfile);
		
		
		$endpoint = $host .'/cgi-bin/dhop.cgi?action=uploadApp';
		$url	=	$endpoint;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$endpoint);
		curl_setopt($ch, CURLOPT_TIMEOUT, 8000000); //timeout after 30 seconds
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, true); // enable posting
		curl_setopt($ch, CURLOPT_POSTFIELDS, $imgdata);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_USERPWD, $user.":".$password);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: multipart/form-data'));
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); //get status code

		$response = curl_exec($ch);
		echo $response;
		//echo $status_code;
		
		unlink($file);
		curl_close($ch); 


	}

	public function uninstallapp($data)
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


}