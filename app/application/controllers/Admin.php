<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->library(array('session','form_validation','pagination'));
        $this->load->model('User_model','mUser');
        
    }

    public function index(){
        //$this->load->view('viki');
        $logged_in = $this->session->userdata('adminpmi_logged_in') && ($this->session->userdata('adminpmi_level')=='admin');
        if($logged_in){
            redirect('Starter');
        }else{ 
            redirect("Admin/dashboardlogin");
        }   
    }

    public function dashboardlogin()
    {
        $this->load->view('admin/login/v_header');
        $this->load->view('admin/login/v_login');
        $this->load->view('admin/login/v_footer');
    }
    
    public function login() {
        
        // set validation rules
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('_strpass', 'Strpass', 'required');
        
        if ($this->form_validation->run() == FALSE){
            
            echo "<script>alert('Lengkapi Data Anda dengan Benar');history.go(-1);</script>";

        }else{

            $data = array('email' => $this->input->post('email', TRUE),
                          '_strpass' => md5($this->input->post('_strpass', TRUE)),
                          'status' => '1'
                        );
            //$this->load->model('User_model');
            $hasil = $this->mUser->validatelogin($data);
                    if ($hasil->num_rows() == 1){
                        foreach ($hasil->result() as $sess) {
                            $sess_data['adminpmi_logged_in'] = 'Sudah Loggin';
                            $sess_data['adminpmi_user_id']   = $sess->user_id;
                            $sess_data['adminpmi_user_name']  = $sess->user_name;
                            $sess_data['adminpmi_email']     = $sess->email;
                            $sess_data['adminpmi_level']     = 'admin';
                            $sess_data = $this->security->xss_clean($sess_data);
                            $this->session->set_userdata($sess_data);
                            redirect('Starter');
                        }
                    }
                    else {
                            echo "<script>alert('Gagal login: Cek E-Mail, password!');history.go(-1);</script>";
                    }
        }
            
    }
    
    public function logout() {
        $this->session->sess_destroy();
        redirect('Admin/dashboardlogin');
    }

    public function get_ajax_users($page,$keyword='')
    {
        $type="'users'";
        $limit=10;
        $start =($page*10)-$limit;
        $data['users'] =$this->mUser->show_all_users($start,$limit,$keyword);
        $config['base_url'] = '#';
        $data['total_rows'] =$this->mUser->total_rows_users($keyword);
            //config for bootstrap pagination class integration
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('onclick' => 'get_data(this,'.$type.')','keyword' => $keyword);
        $config['attributes']['rel'] = FALSE;

        $this->pagination->initialize($config);
        $data['pagination']=$this->pagination->create_links();

        echo $this->load->view("users/v_users",$data);
    }
}