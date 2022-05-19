<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends MX_Controller {

	public function __construct()
   	{
       parent :: __construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('Admin_Model');
        $this->load->library('session');
        
   	}
   	public function index(){
   	    $this->load->admintemplate('mainpage');
   	}

    public function RegisterUser()
    {
        $this->form_validation->set_rules('firstname','First Name','trim|required');
        $this->form_validation->set_rules('lastname','Last Name','trim|required');
        $this->form_validation->set_rules('username','User Name','trim|required|is_unique[user.username]');
        $this->form_validation->set_rules('email','Email','trim|required|is_unique[user.email]');
        $this->form_validation->set_rules('password','Password','trim|required|min_length[5]|max_length[10]');
        $this->form_validation->set_rules('number','number','trim|required|numeric');
        if($this->input->post())
        {
            if($this->form_validation->run() == false)
            {
                echo validation_errors();
            }
            else{
                $data = array(
                    'firstname' => $this->input->post('firstname'),
                    'lastname' => $this->input->post('lastname'),
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
                    'password' => $this->input->post('password'),
                    'number' => $this->input->post('number'),
                    'user_type' => $this->input->post('user_type'),
                );
                $this->Admin_Model->RegisterUsers($data);
                $this->session->set_flashdata('success', $data);
            }
        }
        redirect(base_url('Dashboard'));
    }
    public function logout() {
        $sess_array = array('username' => '');
        $this->session->unset_userdata('logged_in', $sess_array);
        redirect(base_url());
    }
    public function load_style(){
        
        $this->load->view('load_style');
    }
    public function load_script(){
        $data['js'] =  [
                'validate'   =>'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js',
                'sweetjslink'   =>'https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js',
                'validation'  =>'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js',
                'myvalidate' => 'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js'
                
            ];
        $this->load->view('load_script',$data);
    }
    
}
