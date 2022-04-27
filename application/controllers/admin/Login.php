<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		if(isset($_SESSION['user_id'])){
			
			redirect('admin/dashboard');
		}
		$data=[];
		if(isset($_SESSION['error'])){
			
			$data['error']=$_SESSION['error'];
		}else{
			$data['error']=' no error';
		}
		$this->load->view('adminpanel/adminview',$data);
	}
	 public function validate(){
		 if(isset($_POST)){
			 $username = $_POST['username'];
			 $password = $_POST['password'];
			 $query=$this->db->query("SELECT * FROM `backenduser` WHERE `username` ='$username' AND `password`= '$password'");
			 if($query->num_rows()){
             $result=$query->result_array();
			 echo "<pre>";
			 print_r($result) ;
			
			$this->session->set_userdata('user_id',$result[0]['uid']);
			redirect('admin/dashboard');
			 }else{
//invalid credential
				$this->session->set_flashdata('error','invalid credentials');
				redirect('admin/login');
			 }
		 }else{
			 die("Invalid input");
		 }
		 
	}

	function logout(){
		session_destroy();
		redirect('admin/login');
	}
}
