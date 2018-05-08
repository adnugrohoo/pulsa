<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {	

	function __construct(){
    parent::__construct();
    $this->load->library(array('session'));
    $this->load->model('Menu_model','mMenu');   
  }

  public function index(){  
    $logged_in = $this->session->userdata('adminpmi_logged_in') && ($this->session->userdata('adminpmi_level')=='admin');
    if($logged_in){            
      $menu['menus'] = $this->mMenu->get_menu(0);
      $menu['submenus'] = $this->mMenu->get_menu(1);
      echo $this->load->view('template/v_header', $menu, true);
      $this->load->view('template/v_top_nav');
      echo $this->load->view('template/v_main_nav', $menu, true);
      $this->load->view('menu/v_menu', array());
      $this->load->view('template/v_control_sidebar');
      $this->load->view('template/v_footer');
    }else{ 
      redirect("Admin/dashboardlogin");
    }
  }

  public function menus_page()
    {

        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));


        $menus = $this->mMenu->get_datatable_menus();

        $data = array();

        foreach($menus->result() as $menu) {

            $data[] = array(
                $menu->menu,
                $menu->url,
                $menu->icon_nav,
                $menu->isParent
            );
        }

        $output = array(
            "draw" => $draw,
                "recordsTotal" => $menus->num_rows(),
                "recordsFiltered" => $menus->num_rows(),
                "data" => $data
        );
        echo json_encode($output);
        exit();
    }

  public function books_page()
    {

        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));


        $books = $this->mMenu->get_books();

        $data = array();

        foreach($books->result() as $r) {

            $data[] = array(
                $r->name,
                $r->price,
                $r->author,
                $r->rating . "/10 Stars",
                $r->publisher
            );
        }

        $output = array(
            "draw" => $draw,
                "recordsTotal" => $books->num_rows(),
                "recordsFiltered" => $books->num_rows(),
                "data" => $data
        );
        echo json_encode($output);
        exit();
    }
}