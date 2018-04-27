<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Starter extends CI_Controller {	

	function __construct(){
    parent::__construct();
    // $this->load->library(array('session'));
  }

  public function index(){  
    $logged_in = $this->session->userdata('adminb2c_logged_in') && ($this->session->userdata('adminb2c_level')=='admin');
    if($logged_in){
      $this->load->view('template/v_header');
      $this->load->view('template/v_top_nav');
      $this->load->view('template/v_control_sidebar');
      $this->load->view('template/v_main_nav');
      $this->load->view('template/v_content');
      $this->load->view('template/v_footer');
    }else{ 
      redirect("Admin/dashboardlogin");
    }
  }
}
