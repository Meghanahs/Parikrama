<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Routine extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library('Ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('routine_model');
        $this->load->model('settings/settings_model');
        $this->load->model('course/course_model');
        $this->load->model('batch/batch_model');
        $this->load->library('upload');
        $this->lang->load('system_syntax');
        $this->load->model('ion_auth_model');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->in_group(array('admin', 'Instructor', 'Student'))) {
            redirect('home/permission');
        }
    }

    public function index() {
        $data['courses'] = $this->course_model->getCourse();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('routine', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function routineByPageNumber() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['routines'] = $this->routine_model->getRoutineByPageNumber($page_number);
        $data['pagee_number'] = $page_number;
        $data['p_n'] = $page_number;
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('routine', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function searchRoutine() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $key = $this->input->get('key');
        $data['routines'] = $this->routine_model->getRoutineByKey($page_number, $key);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['key'] = $key;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('routine', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function viewRoutine() {
        $data['course'] = $this->input->post('course');
        $data['batch'] = (int) $this->input->post('batch');
        $routine_details = $this->routine_model->getRoutineByBatchId($data['batch']);
        $data['routine'] = $routine_details;
        if (!empty($routine_details)) {
            $data['routine_id'] = $routine_details->id;
        }
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('routine_by_batch_id', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewView() {
        $data['courses'] = $this->course_model->getCourse();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new');
        $this->load->view('home/footer'); // just the header file
    }

    public function addNew() {

        $id = $this->input->post('id');
        if (!empty($id)) {
            $routine_details = $this->routine_model->getRoutineById($id);
            $course_id = $routine_details->course;
            $batch_id = $routine_details->batch_id;
        } else {
            $course_id = $this->input->post('course');
            $batch_id = $this->input->post('batch_id');
        }


        if (empty($id)) {
            $check = $this->routine_model->getRoutineByBatchId($batch_id);
            if (!empty($check)) {
                $routine_id = $check->id;
                redirect('routine/editRoutine?id=' . $routine_id);
            }
        }

        $monday = $this->input->post('monday');
        $start_time_monday = $this->input->post('start_time_monday');
        $end_time_monday = $this->input->post('end_time_monday');


        $tuesday = $this->input->post('tuesday');
        $start_time_tuesday = $this->input->post('start_time_tuesday');
        $end_time_tuesday = $this->input->post('end_time_tuesday');


        $wednesday = $this->input->post('wednesday');
        $start_time_wednesday = $this->input->post('start_time_wednesday');
        $end_time_wednesday = $this->input->post('end_time_wednesday');


        $thursday = $this->input->post('thursday');
        $start_time_thursday = $this->input->post('start_time_thursday');
        $end_time_thursday = $this->input->post('end_time_thursday');


        $friday = $this->input->post('friday');
        $start_time_friday = $this->input->post('start_time_friday');
        $end_time_friday = $this->input->post('end_time_friday');


        $saturday = $this->input->post('saturday');
        $start_time_saturday = $this->input->post('start_time_saturday');
        $end_time_saturday = $this->input->post('end_time_saturday');

        $sunday = $this->input->post('sunday');
        $start_time_sunday = $this->input->post('start_time_sunday');
        $end_time_sunday = $this->input->post('end_time_sunday');


        $routine = array();

        if (!empty($monday)) {
            $routine[] = $monday . ',' . $start_time_monday . ',' . $end_time_monday;
        }

        if (!empty($tuesday)) {
            $routine[] = $tuesday . ',' . $start_time_tuesday . ',' . $end_time_tuesday;
        }

        if (!empty($wednesday)) {
            $routine[] = $wednesday . ',' . $start_time_wednesday . ',' . $end_time_wednesday;
        }

        if (!empty($thursday)) {
            $routine[] = $thursday . ',' . $start_time_thursday . ',' . $end_time_thursday;
        }

        if (!empty($friday)) {
            $routine[] = $friday . ',' . $start_time_friday . ',' . $end_time_friday;
        }

        if (!empty($saturday)) {
            $routine[] = $saturday . ',' . $start_time_saturday . ',' . $end_time_saturday;
        }

        if (!empty($sunday)) {
            $routine[] = $sunday . ',' . $start_time_sunday . ',' . $end_time_sunday;
        }



        $routines = implode('*', $routine);



        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Email Field
        $this->form_validation->set_rules('course', 'Course', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Address Field   
        $this->form_validation->set_rules('batch_id', 'Batch', 'trim|min_length[1]|max_length[500]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("routine/editRoutine?id=$id");
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
                //  'course' => $course_id,
                'batch_id' => $batch_id,
                'routine' => $routines,
            );



            if (empty($id)) {     // Adding New Routine
                $this->routine_model->insertRoutine($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else { // Updating Routine
                $this->routine_model->updateRoutine($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }

            redirect('routine');
        }
    }

    function getRoutine() {
        $data['routines'] = $this->routine_model->getRoutine();
        $this->load->view('routine', $data);
    }

    function editRoutine() {
        $data = array();
        $id = $this->input->get('id');
        $data['courses'] = $this->course_model->getCourse();
        $data['routine'] = $this->routine_model->getRoutineById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editRoutineByJason() {
        $id = $this->input->get('id');
        $data['routine'] = $this->routine_model->getRoutineById($id);
        echo json_encode($data);
    }

    function delete() {
        $data = array();
        $id = $this->input->get('id');
        $this->routine_model->delete($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('routine');
    }

    function deleteRoutineByBatchId() {
        $data = array();
        $id = $this->input->get('id');
        $this->routine_model->deleteRoutineByBatchId($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('routine');
    }

}

/* End of file routine.php */
/* Location: ./application/modules/routine/controllers/routine.php */
