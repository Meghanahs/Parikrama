<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Course extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library('Ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('course_model');
        $this->load->model('batch/batch_model');
        $this->load->model('instructor/instructor_model');
        $this->load->model('settings/settings_model');
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

        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['courses'] = $this->course_model->getCourseByPageNumber($page_number);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['p_n'] = '0';
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('course', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function courseByPageNumber() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['courses'] = $this->course_model->getCourseByPageNumber($page_number);
        $data['pagee_number'] = $page_number;
        $data['p_n'] = $page_number;
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('course', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function course_details() {

        $course_id = $this->input->get('course_id');
        $data['batchs'] = $this->batch_model->getBatchByCourseId($course_id);
        $data['settings'] = $this->settings_model->getSettings();
        $data['course_id'] = $course_id;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('course_details', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function searchCourse() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $key = $this->input->get('key');
        $data['courses'] = $this->course_model->getCourseByKey($page_number, $key);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['key'] = $key;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('course', $data);
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
        $course_id = $this->input->post('course_id');
        $name = $this->input->post('name');
        $topic = $this->input->post('topic');
        $duration = $this->input->post('duration');
        $course_fee = $this->input->post('course_fee');
        $phone = $this->input->post('phone');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Name Field
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        // Validating Password Field
        if (empty($id)) {
            $this->form_validation->set_rules('course_id', 'Course Id', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        }
        // Validating Email Field
        $this->form_validation->set_rules('topic', 'Topic', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        // Validating Address Field   
        $this->form_validation->set_rules('duration', 'Duration', 'trim|required|min_length[5]|max_length[500]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("course/editCourse?id=$id");
            } else {
                $data['settings'] = $this->settings_model->getSettings();
                $this->load->view('home/dashboard', $data); // just the header file
                $this->load->view('add_new');
                $this->load->view('home/footer'); // just the header file
            }
        } else {

            //$error = array('error' => $this->upload->display_errors());
            $data = array();
            $data = array(
                'course_id' => $course_id,
                'name' => $name,
                'topic' => $topic,
                'duration' => $duration,
                'course_fee' => $course_fee,
            );
            if (empty($id)) {     // Adding New Course    
                $this->course_model->insertCourse($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else { // Updating Course
                $this->course_model->updateCourse($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            // Loading View
            redirect('course');
        }
    }

    function courseMaterial() {
        $data = array();
        $id = $this->input->get('course');
        $data['settings'] = $this->settings_model->getSettings();
        $data['course'] = $this->course_model->getCourseById($id);
        $data['course_materials'] = $this->course_model->getCourseMaterialByCourseId($id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('course_material', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function addCourseMaterial() {
        $title = $this->input->post('title');
        $course_id = $this->input->post('course');
        $img_url = $this->input->post('img_url');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Course Field
        $this->form_validation->set_rules('course', 'Course', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating File Field           
        //  $this->form_validation->set_rules('img_url', 'Material', 'trim|required|min_length[1]|max_length[1000]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('feedback', 'Validation Error !');
            redirect("course/courseMaterial?course=" . $course_id);
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
                    'title' => $title,
                    'url' => $img_url,
                    'course' => $course_id,
                );
            } else {
                $this->session->set_flashdata('feedback', 'Upload Error !');
                redirect("course/courseMaterial?course=" . $course_id);
            }

            $this->course_model->insertCourseMaterial($data);
            $this->session->set_flashdata('feedback', 'Added');


            redirect("course/courseMaterial?course=" . $course_id);
        }
    }

    function getCourse() {
        $data['courses'] = $this->course_model->getCourse();
        $this->load->view('course', $data);
    }

    function editCourse() {
        $data = array();
        $data['settings'] = $this->settings_model->getSettings();
        $id = $this->input->get('id');
        $data['course'] = $this->course_model->getCourseById($id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editCourseByJason() {
        $id = $this->input->get('id');
        $data['course'] = $this->course_model->getCourseById($id);
        echo json_encode($data);
    }

    function deleteCourseMaterial() {
        $id = $this->input->get('id');
        $course_material = $this->course_model->getCourseMaterialById($id);
        $path = $course_material->url;
        if (!empty($path)) {
            unlink($path);
        }
        $this->course_model->deleteCourseMaterial($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect("course/courseMaterial?course=" . $course_material->course);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->course_model->delete($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('course');
    }

}

/* End of file course.php */
/* Location: ./application/modules/course/controllers/course.php */
