<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth_m');
        $this->load->model('toko_m');
    }

    public function login() {
        if ($this->session->userdata('kasir01')) {
            $user = $this->session->userdata('kasir01');
            if($user->role == 'kasir'){
                redirect(base_url('kasir'));
            } else {
                redirect(base_url('dashboard'));
            }
        }
        
        $data['toko'] = $this->toko_m->get();
        $data['error'] = FALSE;
        $data['title'] = $data['toko']->nama_toko;
        $this->load->view('user_login_v',$data);        
    }

    public function dologin() {
        if ($this->session->userdata('kasir01')) {
            $user = $this->session->userdata('kasir01');
            if($user->role == 'kasir'){
                redirect(base_url('kasir'));
            } else {
                redirect(base_url('dashboard'));
            }
        }
        $data['toko'] = $this->toko_m->get();
        $data['title'] = $this->toko_m->get()->nama_toko;
        $this->load->library('form_validation');
        $data['error'] = FALSE;
        //#1 Set Form Validation
        $this->form_validation->set_rules('username', 'Username', 'xss_clean|required|trim');
        $this->form_validation->set_rules('password', 'Password', 'xss_clean|required|trim');                       
        if ($this->form_validation->run($this) == FALSE) {
            //#2 Display Error Message
            $data['error'] = validation_errors();
        } else {
            $user = $this->input->post("username");
            $pass = md5($this->input->post('password'));
            $respo = $this->auth_m->login($user, $pass);
            if($respo){
                if($respo->status != 1){
                    $data['error'] = 'Akun anda tidak aktif, silahkan menghubungi administrator';                
                } else {
                    $this->session->set_userdata('kasir01',$respo);
                    if($respo->role == 'kasir'){
                        redirect(base_url('kasir'));
                    } else {
                        redirect(base_url('dashboard'));
                    }    
                }                       
            } else {
                $data['error'] = 'Username & Password tidak terdaftar';                
            }
        }
        $this->load->view('user_login_v', $data);
    }

    public function logout(){
        $this->session->unset_userdata('kasir01');
        $this->session->unset_userdata('cart');
        redirect(base_url('auth/login'));
    }
}

/* End of file  */
/* Location: ./application/controllers/ */
