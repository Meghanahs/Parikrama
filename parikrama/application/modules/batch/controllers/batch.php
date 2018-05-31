<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Batch extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library('Ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('batch_model');
        $this->load->model('course/course_model');
        $this->load->model('routine/routine_model');
        $this->load->model('instructor/instructor_model');
        $this->load->model('student/student_model');
        $this->load->model('settings/settings_model');
        $this->load->library('upload');
        $this->lang->load('system_syntax');
        $this->load->model('ion_auth_model');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->in_group(array('admin', 'Instructor','Student', 'Employee'))) {
            redirect('home/permission');
        }
    }

    public function index() {

        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['courses'] = $this->course_model->getCourse();
        $data['instructors'] = $this->instructor_model->getInstructor();
        $data['batchs'] = $this->batch_model->getBatchByPageNumber($page_number);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['p_n'] = '0';
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('batch', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function batchByPageNumber() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['batchs'] = $this->batch_model->getBatchByPageNumber($page_number);
        $data['courses'] = $this->course_model->getCourse();
        $data['instructors'] = $this->instructor_model->getInstructor();
        $data['pagee_number'] = $page_number;
        $data['p_n'] = $page_number;
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('batch', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function searchBatch() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $key = $this->input->get('key');
        $data['batchs'] = $this->batch_model->getBatchByKey($page_number, $key);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['key'] = $key;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('batch', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewView() {
        $data['settings'] = $this->settings_model->getSettings();
        $data['instructors'] = $this->instructor_model->getInstructor();
        $data['courses'] = $this->course_model->getCourse();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new');
        $this->load->view('home/footer'); // just the header file
    }

    public function addNew() {

        $id = $this->input->post('id');
        $batch_id = $this->input->post('batch_id');
        $course = $this->input->post('course');
        $instructor = $this->input->post('instructor');
        $course_fee = $this->input->post('course_fee');
        if (empty($course_fee)) {
            $course_fee = $this->course_model->getCourseById($course)->course_fee;
        }
        $start_date = $this->input->post('start_date');
        if (!empty($start_date)) {
            $start_date = strtotime($start_date);
        }
        $end_date = $this->input->post('end_date');
        if (!empty($end_date)) {
            $end_date = strtotime($end_date);
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Course Id Field
        $this->form_validation->set_rules('course', 'Course', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Email Field
        $this->form_validation->set_rules('instructor', 'Instructor', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Address Field   
        $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required|min_length[5]|max_length[500]|xss_clean');
        // Validating Phone Field           
        $this->form_validation->set_rules('end_date', 'End Date', 'trim|required|min_length[5]|max_length[50]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("batch/editBatch?id=$id");
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
                'batch_id' => $batch_id,
                'course' => $course,
                'instructor' => $instructor,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'course_fee' => $course_fee
            );

            if (empty($id)) {     // Adding New Batch
                $this->batch_model->insertBatch($data);
            } else { // Updating Batch
                $this->batch_model->updateBatch($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            // Loading View
            redirect('batch');
        }
    }

    function batchByCourseId() {
        $course_id = $this->input->get('course_id');
        $data['batchs'] = $this->batch_model->getBatchByCourseId($course_id);
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('batch', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function students() {

        $batch_id = $this->input->get('batch_id');
        $data['students'] = $this->batch_model->getStudentsByBatchId($batch_id);
        $data['settings'] = $this->settings_model->getSettings();
        $data['batch_id'] = $batch_id;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('batch_details', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function getBatch() {
        $data['batchs'] = $this->batch_model->getBatch();
        $this->load->view('batch', $data);
    }

    function getStudentByKey() {
        $key = $this->input->get('keyword');
        $students = $this->student_model->getStudentByKeyforBatch($key);

        $data[] = array();
        $options = array();
        foreach ($students as $student) {
            $options[] = '<option class="ooppttiioonn"    value="' . $student->id . '">' . $student->name . '</option>';
        }
        $data['opp'] = $options;
        $options = NULL;
        echo json_encode($data);
    }

    function getStudentsByBatchIdByJason() {
        $id = $this->input->get('id');
        $students = $this->batch_model->getStudentsByBatchId($id);
        foreach ($students as $key => $value) {
            $all_students[] = $this->student_model->getStudentById($value);
        }
        $data['students'] = $all_students;
        echo json_encode($data);
    }

    function addStudentToBatch() {

        $batch_id = $this->input->post('batch_id');
        $student_id = $this->input->post('student');

        $student_exist = $this->batch_model->checkExistInBatch($batch_id, $student_id);
        if (!empty($student_exist)) {
            $this->session->set_flashdata('feedback', 'This Student Already Exist');
            redirect('batch/students?batch_id=' . $batch_id);
            die();
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Batch Id Field
        $this->form_validation->set_rules('batch_id', 'Batch', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Student Field 
        $this->form_validation->set_rules('student', 'Student', 'trim|required|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            redirect("batch/students?batch_id=$batch_id");
        } else {

            $data = array();
            $data = array(
                'batch' => $batch_id,
                'student' => $student_id,
            );
            $this->batch_model->insertStudentToBatch($data);
            // Loading View
            $this->session->set_flashdata('feedback', 'Student Added To This Batch');
            redirect('batch/students?batch_id=' . $batch_id);
        }
    }

    function editBatch() {
        $data = array();
        $id = $this->input->get('id');
        $data['batch'] = $this->batch_model->getBatchById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editBatchByJason() {
        $id = $this->input->get('id');
        $data['batch'] = $this->batch_model->getBatchById($id);
        echo json_encode($data);
    }

    function getBatchByCourseIdByJason() {
        $id = $this->input->get('id');
        $data['batches'] = $this->batch_model->getBatchByCourseId($id);
        echo json_encode($data);
    }

    function getCourseFeeByCourseIdByJason() {
        $id = $this->input->get('id');
        $data['course_fee'] = $this->course_model->getCourseById($id)->course_fee;
        echo json_encode($data);
    }

    function deleteStudentFromBatch() {
        $data = array();
        $student_id = $this->input->get('student_id');
        $batch_id = $this->input->get('batch_id');
        $this->batch_model->deleteStudentFromBatch($student_id, $batch_id);
        $this->session->set_flashdata('feedback', '<span class="color: maroon">Removed</span>');
        redirect('batch/students?batch_id=' . $batch_id);
    }

    function delete() {
        $data = array();
        $id = $this->input->get('id');
        $this->routine_model->deleteRoutineByBatchId($id);
        $this->batch_model->delete($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('batch');
    }

}

/* End of file batch.php */
/* Location: ./application/modules/batch/controllers/batch.php */
