<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct(){
		
		parent::__construct();

		// error_reporting(E_ALL);
		// ini_set('display_errors', E_ALL);

		//load main template
		$this->stencil->layout('admin_layout');

		//load required slices
		$this->stencil->slice('admin_header_script');
		$this->stencil->slice('front_scripts');
		$this->stencil->slice('header');

		//load libraries
		$this->load->library('Dahua');
	}

	//index
	public function index(){
		
		$data['title'] = 'index';
		//Call view
		$this->stencil->paint('index', $data);

	}//end index

	//index
	public function reboot(){
		
		$dahua = new Dahua();
		echo $dahua->reboot();

	}//end index

	

	


}
