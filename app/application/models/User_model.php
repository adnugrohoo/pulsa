<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	var $table = 'users';
    var $column_order = array('email','full_name','member_code','no_tlpn',null); //set column field database for datatable orderable
    var $column_search = array('email','full_name'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('id' => 'desc'); // default order

	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		
	}

	public function validatelogin($data) {
           return $this->db->get_where('user_admin',$this->security->xss_clean($data));
    }
	
	public function create_user($full_name, $no_tlpn , $email) {
		
		$data = array(
			'full_name' => $full_name,
			'no_tlpn'	=> $no_tlpn,
			'email'     => $email,
			'level'		=> "member",
			'create_on' => date('Y-m-j H:i:s'),
		);
		
		return $this->db->insert('users',$this->security->xss_clean($data));
		
	}
	/* ======================================================================================================= */
	private function _get_datatables_query()
    {
         
        $this->db->from($this->table);
 
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function total_rows_users($keyword){
        
        $this->db->like('user_id', $keyword);
        $this->db->from('users');
        return $this->db->count_all_results();
    }
    
    public function show_all_users($start,$limit,$keyword){
        
        $this->db->like('user_id', $keyword); 
        $this->db->limit($limit,$start);
        $result = $this->db->get('users');
        return $result->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
 
    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('id',$id);
        $query = $this->db->get();
 
        return $query->row();
    }
 
    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
 
    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
 
    public function delete_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }
}
