<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index() {

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        
        if ($this->form_validation->run() == false){
            
            $data['title'] = 'Login';
            $this->load->view('templates/auth/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth/auth_footer');
        } else {

            // validasinya sukses
            $this->_login();
        }
    }

    private function _login() {

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user= $this->db->get_where('user', ['email' => $email])->row_array();
        
        if($user) {

            if($user['is_active'] == 1) {
                if(password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    if($user['role_id'] == 1) {
                        redirect('admin/dashboard');
                    } else {
                        redirect('user/landingpage');
                    }
                    
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Password salah </div>');
                    error_log(password_verify($password, $user['password']));
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Email not activated </div>');
                redirect('auth');
            }
        } else {

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Email belum terdaftar </div>');
            redirect('auth');
        }
    }

    public function registration() {

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has ready registered'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont matches!',
            'min_length' => 'Password to short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if( $this->form_validation->run() == false) {
            
            $data['title'] = 'Lazizmu Registration';
            $this->load->view('templates/auth/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth/auth_footer');
        } else {
            
            $email = $this->input->post('email', true);
            $data = [
                'username' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($email),
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 0,
                'date_created' => time()
            ];

            // TOKEN
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);
            $this->db->insert('user_token', $user_token);

            $this->_sendEmail($token, 'verify');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Registrasi berhasil. silahkan Aktivasi akun anda</div>');
            redirect('auth');
        }

    }

    public function _sendEmail($token, $type) {

        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'eefmekel@gmail.com',
            'smtp_pass' => 'ujvbeldtrrsslwxl',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'UTF-8',
            'newline' => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);
        $to_email = $this->input->post('email');

        $this->email->from('eefmekel@gmail.com', 'SASNA');
        $this->email->to($to_email);
        

        if($type == 'verify') {
            $this->email->subject('Aktivasi akun');
            $this->email->message('Click this link to <b>verify</b> your account : <a href="'. base_url() . 'auth/verify?email='. $to_email . '&token=' . urlencode($token) . '">Activate </a>');
        } else if($type == 'forgot') {
            $this->email->subject('Forgot Password');
            $this->email->message('Click this link to <b>reset your password</b> : <a href="'. base_url() . 'auth/resetpassword?email='. $to_email . '&token=' . urlencode($token) . '">Reset Password</a>');
        }

        if($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    public function verify() {

        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array(); 

        if($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if($user_token) {
                if(time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$email.' has been activated! Please Login</div>');
                    redirect('auth');
                } else {

                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Aktivasi akun gagal! Activasi Expaired</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Token Invalid</div>');
                redirect('auth');
            }

        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Aktivasi akun gagal! email salah</div>');
            redirect('auth');
        }
    }

    public function logout() {

        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Anda telah keluar</div>');
        redirect('auth');
    }

    public function blocked() {
        $this->load->view('auth/blocked');
    }

    public function forgotPassword() {

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        if($this->form_validation->run() == false) {

            $data['title'] = 'Forgot Password';
            $this->load->view('templates/auth/auth_header', $data);
            $this->load->view('auth/forgot-password');
            $this->load->view('templates/auth/auth_footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

            if($user) {
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];

                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token, 'forgot');

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Silahkan Cek email untuk reset password anda</div>');
                redirect('auth');

            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email tidak terdaftar atau belum di aktivasi!</div>');
                redirect('auth/forgotpassword');
            }
        }
    }

    public function resetPassword() {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if($user_token) {
                $this->session->set_userdata('reset_email', $email);
                $this->changePassword();
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset Password Gagal! Token Salah</div>');
                redirect('auth');
            }

        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset Password Gagal! Email salah</div>');
            redirect('auth');
        }
    }

    public function changePassword() {

        if(!$this->session->userdata('reset_email')) {
            redirect('auth');
        }

        $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[3]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[3]|matches[password1]');

        if($this->form_validation->run() == false) {

            $data['title'] = 'Forgot Password';
            $this->load->view('templates/auth/auth_header', $data);
            $this->load->view('auth/change-password');
            $this->load->view('templates/auth/auth_footer');
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->unset_userdata('reset_email');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password telah diganti! silahkan login</div>');
            redirect('auth');
        }

    }
}