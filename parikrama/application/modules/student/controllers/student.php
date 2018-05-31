<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Student extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library('Ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('student_model');
        $this->load->model('settings/settings_model');
        $this->load->library('upload');
        $this->load->model('batch/batch_model');
        $this->load->model('finance/finance_model');
        $this->load->model('course/course_model');
        $this->load->model('instructor/instructor_model');
        $this->lang->load('system_syntax');
        $this->load->model('ion_auth_model');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->in_group(array('admin', 'Student', 'Instructor'))) {
            redirect('home/permission');
        }
    }

    public function index() {

        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['students'] = $this->student_model->getStudentByPageNumber($page_number);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['p_n'] = '0';
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('student', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function studentByPageNumber() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['students'] = $this->student_model->getStudentByPageNumber($page_number);
        $data['pagee_number'] = $page_number;
        $data['p_n'] = $page_number;
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('student', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function searchStudent() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $key = $this->input->get('key');
        $data['students'] = $this->student_model->getStudentByKey($page_number, $key);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['key'] = $key;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('student', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewView() {
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new');
        $this->load->view('home/footer'); // just the header file
    }

    public function addNew() {

        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $phone = $this->input->post('phone');
        if (empty($id)) {
            $add_date = time();
        } else {
            $previous_add_date = $this->student_model->getStudentById($id)->add_date;
            if (!empty($previous_add_date)) {
                $add_date = $previous_add_date;
            } else {
                $add_date = time();
            }
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        // Validating Password Field
        if (empty($id)) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        }
        // Validating Email Field
        $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        // Validating Address Field   
        $this->form_validation->set_rules('address', 'Address', 'trim|required|min_length[5]|max_length[500]|xss_clean');
        // Validating Phone Field           
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[5]|max_length[50]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("student/editStudent?id=$id");
            } else {
                $data['settings'] = $this->settings_model->getSettings();
                $this->load->view('home/dashboard', $data); // just the header file
                $this->load->view('add_new');
                $this->load->view('home/footer'); // just the header file
            }
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
                $data = array(
                    'img_url' => $img_url,
                    'name' => $name,
                    'email' => $email,
                    'address' => $address,
                    'phone' => $phone,
                    'add_date' => $add_date
                );
            } else {
                //$error = array('error' => $this->upload->display_errors());
                $data = array();
                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'address' => $address,
                    'phone' => $phone,
                    'add_date' => $add_date
                );
            }

            $username = $this->input->post('name');

            if (empty($id)) {     // Adding New Student
                if ($this->ion_auth->email_check($email)) {
                    $this->session->set_flashdata('feedback', 'This Email Address Is Already Registered');
                    redirect('student/addNewView');
                } else {
                    $dfg = 5;
                    $this->ion_auth->register($username, $password, $email, $dfg);
                    $user_id = $this->db->insert_id();
                    $ion_user_id = $this->db->get_where('users_groups', array('id' => $user_id))->row()->user_id;
                    $this->student_model->insertStudent($data);
                    $student_user_id = $this->db->insert_id();
                    $id_info = array('ion_user_id' => $ion_user_id);
                    $this->student_model->updateStudent($student_user_id, $id_info);
                    $this->session->set_flashdata('feedback', 'Added');
                }
            } else { // Updating Student
                $ion_user_id = $this->db->get_where('student', array('id' => $id))->row()->ion_user_id;
                if (empty($password)) {
                    $password = $this->db->get_where('users', array('id' => $ion_user_id))->row()->password;
                } else {
                    $password = $this->ion_auth_model->hash_password($password);
                }
                $this->student_model->updateIonUser($username, $email, $password, $ion_user_id);
                $this->student_model->updateStudent($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            // Loading View
            redirect('student');
        }
    }

    function getStudent() {
        $data['students'] = $this->student_model->getStudent();
        $this->load->view('student', $data);
    }

    function details() {
        $student_id = $this->input->get('student_id');
        if ($this->ion_auth->in_group(array('Student'))) {
            $user = $this->ion_auth->get_user_id();
            $student_table_id = $this->db->get_where('student', array('ion_user_id' => $user))->row()->id;
            if ($student_id != $student_table_id) {
                redirect('home/permission');
            }
        }

        $data['batches'] = $this->student_model->getBatchByStudentId($student_id);
        $data['payments'] = $this->finance_model->getPaymentByStudentId($student_id);
        $data['settings'] = $this->settings_model->getSettings();
        $data['student_details'] = $this->student_model->getStudentById($student_id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('student_details', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editStudent() {
        $data = array();
        $id = $this->input->get('id');
        $data['student'] = $this->student_model->getStudentById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editStudentByJason() {
        $id = $this->input->get('id');
        $data['student'] = $this->student_model->getStudentById($id);
        echo json_encode($data);
    }

    function delete() {
        $data = array();
        $id = $this->input->get('id');
        $user_data = $this->db->get_where('student', array('id' => $id))->row();
        $path = $user_data->img_url;

        if (!empty($path)) {
            unlink($path);
        }
        $ion_user_id = $user_data->ion_user_id;
        $this->db->where('id', $ion_user_id);
        $this->db->delete('users');
        $this->student_model->delete($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('student');
    }

}

/* End of file student.php */
/* Location: ./application/modules/student/controllers/student.php */
