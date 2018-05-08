<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Starter extends CI_Controller {	

	function __construct(){
    parent::__construct();
    $this->load->library(array('session'));
    $this->load->model('Menu_model','mMenu');   
  }

  public function index(){  
    $logged_in = $this->session->userdata('adminpmi_logged_in') && ($this->session->userdata('adminpmi_level')=='admin');
    if($logged_in){            
      $data['menus'] = $this->mMenu->get_menu(0);
      $data['submenus'] = $this->mMenu->get_menu(1);     
			$data['body'] = "template/v_content";
      $this->load->view('template/home', $data);
    }else{ 
      redirect("Admin/dashboardlogin");
    }
  }
}
