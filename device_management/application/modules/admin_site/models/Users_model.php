<?php
class users_model extends CI_Model {
	
	function __construct(){
		
        parent::__construct();
    }


    //add_users
	public function add_users($data,$id){

		if($id != '' ){

			$this->db->where('id',$id);
			$this->db->set($data);
			$this->db->update('tbl_users');

		}else{

			$this->db->insert('tbl_users',$data);

		}
		
		return true;
		
	}//end add_users

	//get_users
	public function get_users(){

		$this->db->order_by('sort','ASC');
		$get_users = $this->db->get('tbl_users');
		$users_arr = $get_users->result_array();
		
		return $users_arr;

	}//end get_users

	//delete_user
	public function delete_user($id){

		$this->db->where('id',$id);
		$get_users = $this->db->delete('tbl_users');
		return 1;

	}//end delete_user

	//get_user_by_id
	public function get_user_by_id($id){

		$this->db->where('id',$id);
		$get_users = $this->db->get('tbl_users');
		$users_arr = $get_users->row_array();
		
		return $users_arr;

	}//end get_user_by_id


}