<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Settings extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('settings_model');
        $this->load->library('upload');
        $this->lang->load('system_syntax');
        $this->load->model('ion_auth_model');

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->in_group('admin')) {
            redirect('home/permission');
        }
    }

    public function index() {
        $data = array();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('settings', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    public function update() {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $title = $this->input->post('title');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        $currency = $this->input->post('currency');
        $discount = $this->input->post('discount');
        $date_format = $this->input->post('date_format');
        $login_title = $this->input->post('login_title');
        $login_logoo = $this->input->post('login_logo');
        $language = $this->input->post('language');
        $buyer = $this->input->post('buyer');
        $p_code = $this->input->post('p_code');

        if (!empty($email)) {
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            // Validating Name Field
            $this->form_validation->set_rules('name', 'System Name', 'trim|required|min_length[5]|max_length[100]|xss_clean');
            // Validating Title Field
            $this->form_validation->set_rules('title', 'Title', 'rtrim|required|min_length[5]|max_length[100]|xss_clean');
            // Validating Email Field
            $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[100]|xss_clean');
            // Validating Address Field   
            $this->form_validation->set_rules('address', 'Address', 'trim|required|min_length[5]|max_length[500]|xss_clean');
            // Validating Phone Field           
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[5]|max_length[50]|xss_clean');
            // Validating Date Format Field   
            $this->form_validation->set_rules('date_format', 'Date Format', 'trim|required|min_length[1]|max_length[3]|xss_clean');
            // Validating Login Title Field   
            $this->form_validation->set_rules('login_title', 'Login Title', 'trim|min_length[5]|max_length[500]|xss_clean');
            // Validating Login Logoo Field           
            $this->form_validation->set_rules('login_logoo', 'Login Logoo', 'trim|min_length[5]|max_length[50]|xss_clean');
        
            $this->form_validation->set_rules('language', 'Language', 'trim|min_length[1]|max_length[50]|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data = array();
                $data['settings'] = $this->settings_model->getSettings();
                $this->load->view('home/dashboard', $data); // just the header file
                $this->load->view('settings', $data);
                $this->load->view('home/footer'); // just the footer file
            } else {


                $file_name = $_FILES['img_url']['name'];
                $file_name_pieces = explode('_', $file_name);
                $new_file_name = '';
                $count = 1;
                foreach ($file_name_pieces as $piece) {
                    if ($count !== 1) {
                        $piece = ucfirst($piece);
                    }

                    $new_file_name .= $piece;
                    $count++;
                }
                $config = array(
                    'file_name' => $new_file_name,
                    'upload_path' => "./uploads/",
                    'allowed_types' => "gif|jpg|png|jpeg|pdf",
                    'overwrite' => False,
                    'max_size' => "20480000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    'max_height' => "1768",
                    'max_width' => "2024"
                );

                $this->load->library('Upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('img_url')) {
                    $path = $this->upload->data();
                    $img_url = "uploads/" . $path['file_name'];
                    $data = array();

                    //$error = array('error' => $this->upload->display_errors());
                    $data = array();
                    $data = array(
                        'system_vendor' => $name,
                        'title' => $title,
                        'address' => $address,
                        'phone' => $phone,
                        'email' => $email,
                        'date_format' => $date_format,
                        'login_title' => $login_title,
                        'login_logoo' => $img_url,
                    );
                } else {
                    $data = array();
                    $data = array(
                        'system_vendor' => $name,
                        'title' => $title,
                        'address' => $address,
                        'phone' => $phone,
                        'email' => $email,
                        'date_format' => $date_format,
                        'login_title' => $login_title,
                    );
                }
                $this->settings_model->updateSettings($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
                // Loading View
                redirect('settings');
            }
        } else {
            $this->session->set_flashdata('feedback', 'Email Required!');
            redirect('settings', 'refresh');
        }
    }

}

/* End of file settings.php */
/* Location: ./application/modules/settings/controllers/settings.php */


