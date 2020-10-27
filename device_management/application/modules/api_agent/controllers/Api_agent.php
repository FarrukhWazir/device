<?php
ini_set('memory_limit', '-1');
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_agent extends MX_Controller {

	public function __construct(){
		
		parent::__construct();

		// error_reporting(E_ALL);
		// ini_set('display_errors', E_ALL);

		$this->load->library('Dahua');
		$this->load->library('hikvision');
	}

	//index
	public function index(){
		
		//Call view
		$this->load->view('api_agent');

	}//end index

	//get_firmware_version
	public function get_firmware_version(){
		
		$auth_token = $this->input->post('auth_token');
		$company = $this->input->post('brand');

		if($auth_token !='' && $auth_token == AUTH_TOKEN){

			if($company == 'dahua'){

				$dahua = new Dahua();
				$dahua->get_firmware_version($this->input->post());
				exit;
			}else if($company == 'hikvision'){

				$hikvision = new hikvision();
				$hikvision->get_firmware_version($this->input->post());
				exit;

			}else{
				echo 'please add correct brand name in post field brand';
			}
		}else{

			echo 'Invalid token!';
		}

		exit;

	}//end get_firmware_version

	//reboot
	public function reboot(){
		
		$auth_token = $this->input->post('auth_token');
		$company = $this->input->post('brand');
		

		if($auth_token !='' && $auth_token == AUTH_TOKEN){

			if($company == 'dahua'){

				$dahua = new Dahua();
				$dahua->reboot($this->input->post());
				exit;
			}else if($company == 'hikvision'){

				$hikvision = new hikvision();
				$hikvision->reboot($this->input->post());
				exit;

			}else{
				echo 'please add correct brand name in post field brand';
			}
		}else{

			echo 'Invalid token!';
		}

		exit;

	}//end reboot

	//get_time
	public function get_time(){
		
		$auth_token = $this->input->post('auth_token');
		$company = $this->input->post('brand');
		

		if($auth_token !='' && $auth_token == AUTH_TOKEN){

			if($company == 'dahua'){

				$dahua = new Dahua();
				$dahua->get_time($this->input->post());
				exit;
			}else if($company == 'hikvision'){

				$hikvision = new hikvision();
				$hikvision->get_time($this->input->post());
				exit;

			}else{
				echo 'please add correct brand name in post field brand';
			}
		}else{

			echo 'Invalid token!';
		}

		exit;

	}//end get_time

	//get_all_users
	public function get_all_users(){
		
		$auth_token = $this->input->post('auth_token');
		$company = $this->input->post('brand');
		

		if($auth_token !='' && $auth_token == AUTH_TOKEN){

			if($company == 'dahua'){

				$dahua = new Dahua();
				$dahua->get_all_users($this->input->post());
				exit;
			}else if($company == 'hikvision'){

				$hikvision = new hikvision();
				$hikvision->get_all_users($this->input->post());
				exit;

			}else{
				echo 'please add correct brand name in post field brand';
			}
		}else{

			echo 'Invalid token!';
		}

		exit;

	}//end get_all_users

	//add_new_user
	public function add_new_user(){
		
		$auth_token = $this->input->post('auth_token');
		$company = $this->input->post('brand');
		

		if($auth_token !='' && $auth_token == AUTH_TOKEN){

			if($company == 'dahua'){

				$dahua = new Dahua();
				$dahua->add_new_user($this->input->post());
				exit;
			}else if($company == 'hikvision'){

				$hikvision = new hikvision();
				$hikvision->add_new_user($this->input->post());
				exit;

			}else{
				echo 'please add correct brand name in post field brand';
			}
		}else{

			echo 'Invalid token!';
		}

		exit;

	}//end add_new_user

	//delete_user
	public function delete_user(){
		
		$auth_token = $this->input->post('auth_token');
		$company = $this->input->post('brand');
		

		if($auth_token !='' && $auth_token == AUTH_TOKEN){

			if($company == 'dahua'){

				$dahua = new Dahua();
				$dahua->delete_user($this->input->post());
				exit;
			}else if($company == 'hikvision'){

				$hikvision = new hikvision();
				$hikvision->delete_user($this->input->post());
				exit;

			}else{
				echo 'please add correct brand name in post field brand';
			}
		}else{

			echo 'Invalid token!';
		}

		exit;

	}//end delete_user

	//unistall_app
	public function unistall_app(){
		
		$auth_token = $this->input->post('auth_token');
		$company = $this->input->post('brand');
		

		if($auth_token !='' && $auth_token == AUTH_TOKEN){

			if($company == 'dahua'){

				$dahua = new Dahua();
				$dahua->unistall_app($this->input->post());
				exit;
			}else{
				echo 'please add correct brand name in post field brand';
			}
		}else{

			echo 'Invalid token!';
		}

		exit;

	}//end unistall_app

	//download_app_log
	public function download_app_log(){
		
		$auth_token = $this->input->post('auth_token');
		$company = $this->input->post('brand');
		

		if($auth_token !='' && $auth_token == AUTH_TOKEN){

			if($company == 'dahua'){

				$dahua = new Dahua();
				$dahua->download_app_log($this->input->post());
				exit;
			}else{
				echo 'please add correct brand name in post field brand';
			}
		}else{

			echo 'Invalid token!';
		}

		exit;

	}//end download_app_log

	//start_stop_app
	public function start_stop_app(){
		
		$auth_token = $this->input->post('auth_token');
		$company = $this->input->post('brand');
		

		if($auth_token !='' && $auth_token == AUTH_TOKEN){

			if($company == 'dahua'){

				$dahua = new Dahua();
				$dahua->start_stop_app($this->input->post());
				exit;
			}else{
				echo 'please add correct brand name in post field brand';
			}
		}else{

			echo 'Invalid token!';
		}

		exit;

	}//end start_stop_app

	//get_upgrade_state
	public function get_upgrade_state(){
		
		$auth_token = $this->input->post('auth_token');
		$company = $this->input->post('brand');
		

		if($auth_token !='' && $auth_token == AUTH_TOKEN){

			if($company == 'dahua'){

				$dahua = new Dahua();
				$dahua->get_upgrade_state($this->input->post());
				exit;
			}else if($company == 'hikvision'){

				$hikvision = new hikvision();
				$hikvision->get_upgrade_state($this->input->post());
				exit;

			}else{
				echo 'please add correct brand name in post field brand';
			}
		}else{

			echo 'Invalid token!';
		}

		exit;

	}//end get_upgrade_state



	//update_firmware
	public function update_firmware(){
		
		$auth_token = $this->input->post('auth_token');
		$company = $this->input->post('brand');

		

		if($auth_token !='' && $auth_token == AUTH_TOKEN){

			if($company == 'dahua'){

				$dahua = new Dahua();
				$dahua->update_firmware($_FILES,$this->input->post());
				exit;
			}else if($company == 'hikvision'){

				$hikvision = new hikvision();
				//$hikvision->update_firmware($_FILES,$this->input->post());
				$hikvision->updatefirmware_testing();
				exit;

			}else{
				echo 'please add correct brand name in post field brand';
			}
		}else{

			echo 'Invalid token!';
		}

		exit;

	}//end update_firmware

	//update_firmware_from_url
	public function update_firmware_from_url(){
		
		$auth_token = $this->input->post('auth_token');
		$company = $this->input->post('brand');

		

		if($auth_token !='' && $auth_token == AUTH_TOKEN){

			if($company == 'dahua'){

				$dahua = new Dahua();
				$dahua->update_firmware_from_url($this->input->post());
				exit;
			}else if($company == 'hikvision'){

				

			}else{
				echo 'please add correct brand name in post field brand';
			}
		}else{

			echo 'Invalid token!';
		}

		exit;

	}//end update_firmware_from_url


	//installapp
	public function installapp(){
		
		$auth_token = $this->input->post('auth_token');
		$company = $this->input->post('brand');

		

		if($auth_token !='' && $auth_token == AUTH_TOKEN){

			if($company == 'dahua'){

				$dahua = new Dahua();
				$dahua->installapp($this->input->post());
				exit;
			}else if($company == 'hikvision'){

				

			}else{
				echo 'please add correct brand name in post field brand';
			}
		}else{

			echo 'Invalid token!';
		}

		exit;

	}//end installapp

	//uninstallapp
	public function uninstallapp(){
		
		$auth_token = $this->input->post('auth_token');
		$company = $this->input->post('brand');

		

		if($auth_token !='' && $auth_token == AUTH_TOKEN){

			if($company == 'dahua'){

				$dahua = new Dahua();
				$dahua->uninstallapp($this->input->post());
				exit;
			}else if($company == 'hikvision'){

				

			}else{
				echo 'please add correct brand name in post field brand';
			}
		}else{

			echo 'Invalid token!';
		}

		exit;

	}//end installapp



	

	


}
