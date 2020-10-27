<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct(){
		
		parent::__construct();

		// Load Modal
		$this->load->model('users_model');
	}

	//index
	public function index(){
		
		$data['users_arr'] = $this->users_model->get_users($this->input->post());
		$this->load->view('users',$data);

	}//end index

	//add_users
	public function add_users($id=''){

		$this->users_model->add_users($this->input->post(),$id);
		echo "1";
		exit;

	}//end add_users

	//delete_user
	public function delete_user($id){

		$this->users_model->delete_user($id);
		echo "1";
		exit;

	}//end delete_user

	//get_user_by_id
	public function get_user_by_id($id){

		$user_arr = $this->users_model->get_user_by_id($id);
		echo json_encode($user_arr);
		exit;

	}//end get_user_by_id

	//get_users
	public function get_users(){

		$users_arr = $this->users_model->get_users($this->input->post());
		$response = '';
		if( count($users_arr)){

			foreach ($users_arr as $key => $value) {
				
				$response .= '<tr>
			        <td>'.$value['name'].'</td>
			        <td>'.$value['designation'].'</td>
			        <td>'.$value['sort'].'</td>
			        <td><button class="btn btn-danger" id="edit_user" data-id="'.$value['id'].'" >Edit</button></td>
                	<td><button class="btn btn-danger" id="delete_user" data-id="'.$value['id'].'" >Delete</button></td>
			    </tr>';
			}

		}else{
			$response = '<tr><td colspan="4">No Record Found</td></tr>';
		}

		echo $response;
		exit;

	}//end get_users

	


}
