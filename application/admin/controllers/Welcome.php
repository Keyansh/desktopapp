<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CMS_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Adminmodel');
        $this->load->helper('captcha');
        $this->rand = random_string('numeric', 5);
        $vals = array(
            'word' => $this->rand,
            'img_path' => './captcha/',
            'img_url' => base_url() . 'captcha/',
            'font_path' => './system/fonts/texb.ttf',
            'img_width' => '150',
            'img_height' => 30,
            'expiration' => 7200,
        );

        $this->cap = create_captcha($vals);
    }

    public function captcha_check()
    {
        if ($this->input->post('captcha') != $this->input->post('captcha-val')) {
            $this->form_validation->set_message('captcha_check', 'Wrong captcha code, hmm are you the Terminator?');
            return false;
        }
        return true;
    }

    public function login_check($str)
    {
        //        $this->db->where('username', $this->input->post('username', TRUE));
        $email = $this->input->post('username', true);
        $query = $this->db->query('SELECT * FROM br_user where (email="' . $email . '" OR username="' . $email . '") AND user_is_active = 1 AND (profile_id = 3 OR profile_id = 0)');
        //        $this->db->where('user_is_active', 1);
        //        $query = $this->db->get('user');
        //        e($this->db->last_query());
        if ($query && $query->num_rows() == 1) {
            $row = $query->row_array();
            if ($this->encrypt->decode($row['passwd']) === $this->input->post('passwd', true)) {
                return true;
            }
        }
        $this->form_validation->set_message('login_check', 'Login failed');
        return false;
    }

    public function username_check($str)
    {
        $this->db->where('username', $str);
        $query = $this->db->get('user');
        if ($query && $query->num_rows() == 1) {
            return true;
        }

        $this->form_validation->set_message('username_check', 'No such user found!');
        return false;
    }

    public function index()
    {
        $admin_id = $this->session->userdata('USER_ID');
        if ($admin_id) {
            $this->load->model('user/Usermodel');
            $user = $this->Usermodel->fetchByID($admin_id);
            if ($user) {
                redirect('user/dashboard');
                exit();

                return true;
            }
        }

        //echo $this->encrypt->encode('admin');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('passwd', 'Password', 'trim|required|callback_login_check');
        $this->form_validation->set_rules('captcha', 'Captcha', 'trim|required|callback_captcha_check');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == false) {
            $data = array();
            $data['captcha'] = $this->cap;
            $this->load->view('login', $data);
        } else {
            $email = $this->input->post('username', true);
            //            $query = $this->db->query('SELECT * FROM br_user where (email="' . $email . '" OR username="' . $email . '") AND user_is_active = 1 AND (profile_id = 3 OR profile_id = 0)');
            $query = $this->db->query('SELECT * FROM br_user where (email="' . $email . '" OR username="' . $email . '") AND user_is_active = 1 AND (role_id = 1 OR role_id = 0)');
            if ($query->num_rows() == 1) {
                $row = $query->row_array();
                if ($this->encrypt->decode($row['passwd']) == $this->input->post('passwd', true)) {
                    $user = $query->row_array();
                    $sess = array();
                    $sess['USER_ID'] = $user['user_id'];
                    $this->session->set_userdata($sess);

                    //For TinyBrowser
                    session_start();
                    $_SESSION['ENABLE_IMAGE_MANAGER'] = true;
                    $_SESSION['IMAGE_MANAGER_PATH'] = str_replace('\\', '/', realpath(BASEPATH . '/../')) . '/upload/';
                    $_SESSION['DWS_BASE_URL'] = $this->config->item('site_url');
                    session_write_close();

                    //Enter Last Login Time
                    $data = array();
                    $data['last_login'] = time();
                    $this->db->where('user_id', $user['user_id']);
                    $this->db->update('user', $data);

                    if ($this->session->userdata('REDIR_URL') == "") {
                        redirect('user/dashboard');
                        exit();
                    } else {
                        $url = $this->session->userdata('REDIR_URL');
                        $this->session->unset_userdata('REDIR_URL');
                        redirect($url);
                        exit();
                    }
                }
            }

            redirect('welcome');
            exit();
        }
    }

    public function lostpasswd()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_username_check');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->form_validation->run() == false) {
            $inner = array();
            $page = array();
            $page['content'] = $this->load->view('user/lostpasswd-form', $inner, true);
            $this->load->view('shell', $page);
        } else {
            $this->Adminmodel->issuePassword($this->input->post('username', true));
            header("location: " . base_url() . "welcome/password_sent/");
            exit();
        }
    }

    public function password_sent()
    {
        $data = array();
        $data['content'] = $this->load->view('user/lostpasswd-success', array(), true);
        $this->load->view('shell', $data);
    }

    public function getmigrationtime()
    {
        echo date('Ymdhis');
    }

    public function test()
    {
        calibrateCategoryDepth();
    }
}
