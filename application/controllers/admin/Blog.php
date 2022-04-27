<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

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
		$query=$this->db->query("SELECT * FROM `articles` ORDER BY blogid DESC ");
	
		
		$data['result']=$query->result_array();
		print($data['result'][0]['status']);

		$this->load->view('adminpanel/viewblog',$data);
	}
	function addBlog(){
		$this->load->view('adminpanel/addblog.php');
	}

	function editblogpost(){
		print_r($_POST);
		print_r($_FILES);
		if($_FILES['file']['name']){
			$config['upload_path']='./assets/uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('file'))
                {
                        $error = array('error' => $this->upload->display_errors());
                        die('Error');
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());

						$fileurl="assets/uploads/".$data['upload_data']['file_name'];
						$blog_title=$_POST['blog_title'];
						$desc=$_POST['desc'];
						$blogid=$_POST['blogid'];
						$publish_unpublish=$_POST['publish_unpublish'];
					    $query=	$this->db->query("
						UPDATE `articles` SET `blog_title`='$blog_title',`blog_desc`='$desc',`blog_img`='$fileurl',
						`status`='$publish_unpublish' WHERE `blogid`= '$blogid'");
						 if($query){
							 $this->session->set_flashdata('inserted','yes');
							 redirect('admin/blog');
						 }else{
							
								$this->session->set_flashdata('inserted','no');
								redirect('admin/blog');
							
						 }






                }

		}
		else{
			
						$blog_title=$_POST['blog_title'];
						$desc=$_POST['desc'];
						$blogid=$_POST['blogid'];
						$publish_unpublish=$_POST['publish_unpublish'];
					    $query=	$this->db->query("
						UPDATE `articles` SET `blog_title`='$blog_title',`blog_desc`='$desc',
						`status`='$publish_unpublish'  WHERE 
						`blogid`= '$blogid'");
						 if($query){
							 $this->session->set_flashdata('inserted','yes');
							 redirect('admin/blog');
						 }else{
							
								$this->session->set_flashdata('inserted','no');
								redirect('admin/blog');
							
						 }
		}
	}
	function addBlog_post(){

		if(isset($_FILES)){
			$config['upload_path']='./assets/uploads/';
                $config['allowed_types']        = 'gif|jpg|png';
                

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('file'))
                {
                        $error = array('error' => $this->upload->display_errors());
                        die('Error');
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());
						$fileurl="assets/uploads/".$data['upload_data']['file_name'];
						$blog_title=$_POST['blog_title'];
						$desc=$_POST['desc'];
					    $query=	$this->db->query("
						INSERT INTO `articles`( `blog_title`, `blog_desc`, `blog_img`)
						 VALUES ('$blog_title','$desc','$fileurl')");
						 if($query){
							 $this->session->set_flashdata('inserted','yes');
							 redirect('admin/blog/addblog');
						 }else{
							
								$this->session->set_flashdata('inserted','no');
								redirect('admin/blog/addblog');
							
						 }

                }

		}else{

		}
	}

   public function editblog($blogid){
	  $query= $this->db->query("SELECT  `blog_title`, `blog_desc`, `blog_img` ,`status`
	   FROM `articles` WHERE `blogid` = '$blogid';");
	   $data['result']= $query->result_array();
	   $data['blogid']=$blogid;
		$this->load->view('adminpanel/editblog',$data);
	}
	function delete($number){
		


		$qu=$this->db->query("DELETE FROM `articles` WHERE `blogid` ='$number'");
		if($qu){
			echo 1;
		}else{
			echo 0;
		}
	}


	
}
