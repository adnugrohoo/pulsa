<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->library(array('session','form_validation','pagination'));
        $this->load->model('User_model','queries');
        
    }

    public function index(){
        //$this->load->view('viki');
        $logged_in = $this->session->userdata('adminb2c_logged_in') && ($this->session->userdata('adminb2c_level')=='admin');
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
            $hasil = $this->queries->validatelogin($data);
                    if ($hasil->num_rows() == 1){
                        foreach ($hasil->result() as $sess) {
                            $sess_data['adminb2c_logged_in'] = 'Sudah Loggin';
                            $sess_data['adminb2c_user_id']   = $sess->user_id;
                            $sess_data['adminb2c_user_name']  = $sess->user_name;
                            $sess_data['adminb2c_email']     = $sess->email;
                            $sess_data['adminb2c_level']     = 'admin';
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
}