<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

    public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}

    public function get_menu($pParent=''){
        if ($pParent == 0){
            $this->db->where('submenu_id', $pParent);
        } else {
            $this->db->where('submenu_id != 0');
        }
        $result = $this->db->get('menu_nav');
        return $result->result_array();
    }

    public function get_datatable_menus(){
        return $this->db->get('menu_nav');
    }
    
    public function get_books()
     {
          return $this->db->get("books");
     }
}