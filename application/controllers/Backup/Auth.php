<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin_m');
        $this->load->model('driver_m');
    }

    public function login() {
        if ($this->session->userdata('easy_admin')) {
            redirect(base_url());
        }
        $data['error'] = FALSE;
        $this->load->view('user_login_v',$data);        
    }

    public function dologin() {
        if ($this->session->userdata('easy_admin')) {
            redirect(base_url());
        }
        $this->load->library('form_validation');
        $data['error'] = FALSE;
        $data['role'] = "administrator";
        //#1 Set Form Validation
        $this->form_validation->set_rules('username', 'Username', 'xss_clean|required|trim');
        $this->form_validation->set_rules('password', 'Password', 'xss_clean|required|trim');                       
        if ($this->form_validation->run($this) == FALSE) {
            //#2 Display Error Message
            $data['error'] = validation_errors();
        } else {
            $user = $this->input->post("username");
            $pass = $this->input->post('password');
            $respo = $this->admin_m->login($user, $pass);
            $role = "Administrator";        
            if($respo->code == "00"){
                $array = (array) $respo->data[0]; 
                $array["user_role"] = $role;
                $respo->data = (object) $array;
                $this->session->set_userdata('easy_admin',$respo->data);
                //$this->session->set_userdata('easy_admin_role',);                
                redirect(base_url(''));                           
            } else {
                $data['error'] = $respo->message;                
            }
        }
        $this->load->view('user_login_v', $data);
    }

    public function forgotpass() {
        if ($this->session->userdata('easy_admin')) {
            redirect(base_url());
        }
        $this->load->library('form_validation');
        $data['error'] = FALSE;
        $data['success'] = FALSE;
        if($this->input->post('save')){
            $this->form_validation->set_rules('email', 'Email', 'xss_clean|required|trim');               
            if ($this->form_validation->run($this) == FALSE) {
                $data['error'] = validation_errors();
            } else {
                $email = $this->input->post('email');
                $updates = array('email'=> $email, 'url'=>base_url().'auth/resetpass');                                                
                $respo = $this->admin_m->reset_password($updates);                 
                if($respo->code == "00"){                                       
                    $data['success'] = $respo->message;
                }else{
                    $data['error'] =  $respo->message;
                }
            }            
        }
        //$data['role'] = $administrator;
        $this->load->view('user_forgotpass_v', $data);    
    }
    //$email = str_replace( md5('@'),"@", $email);
    public function resetpass($email='', $token=''){      
        if ($this->session->userdata('easy_admin')) {
            redirect(base_url());
        }              
        $data['success'] = false;
        $data['error'] =  false;   
        $email = str_replace( md5('@'),"@", $email);
        $data['email'] = $email;
        $data['token'] = $token;
        if( ! ($email) && ($token)){             
            $data['error'] = "Your Activation Link was Wrong";
        }        
        if($this->input->post('save')){            
            $this->load->library('form_validation');            
            $this->form_validation->set_rules('password', 'New Password', 'required|matches[passconf]|min_length[6]');
            $this->form_validation->set_rules('passconf', 'Confirmation password', 'required');
            if ($this->form_validation->run() == FALSE){
                $data['error'] = validation_errors();
            }
            else{
                $input=array(
                    'password' => $this->input->post('password'),
                    'email'=> $email, 
                    'otp'=>$token                    
                );              
                $respo = $this->admin_m->reset_password($input);  
                if($respo->code == "00" ){             
                    $data['success']=$respo->message;                  
                } else {                
                    $data['error']=$respo->message;
                }                       
            }
        }
        $data['role'] = 'Administrator'; 
        $this->load->view('user_resetpass_v', $data);
    }

    
    function RandomString($j){
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < $j; $i++) {           
            $randstring.= $characters[rand(0, strlen($characters)-1)];          
        }
        return $randstring;
    }

    public function logout(){
        $this->session->set_userdata('easy_admin');
        redirect(base_url('auth/login'));
    }
}

/* End of file  */
/* Location: ./application/controllers/ */
