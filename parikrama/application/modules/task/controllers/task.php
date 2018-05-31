<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Task extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->lang->load('system_syntax');
        $this->load->model('employee/employee_model');
        $this->load->model('task_model');
        $this->load->model('settings/settings_model');

        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->in_group(array('admin', 'Employee', 'Instructor'))) {
            redirect('home/permission');
        }
    }

    public function index() {

        if (!$this->ion_auth->in_group(array('admin'))) {
            $data['current_user'] = $this->ion_auth->get_user_id();
        }
        $data['tasks'] = $this->task_model->getTask();
        $data['categories'] = $this->task_model->getTaskCategory();
        $data['employees'] = $this->employee_model->getEmployee();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('task', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addTaskView() {
        $data = array();
        $data['current_user'] = $this->ion_auth->get_user_id();
        $data['settings'] = $this->settings_model->getSettings();
        $data['employees'] = $this->employee_model->getEmployee();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_task_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewTask() {
        $id = $this->input->post('id');
        $date = $this->input->post('date');
        $requested_by = $this->input->post('requested_by');
        $requested_for = $this->input->post('requested_for');
        $to_do = $this->input->post('to_do');
        $timeline = $this->input->post('timeline');
        $status = $this->input->post('status');
        if ((empty($id))) {
            $add_date = date('m/d/y');
        } else {
            $add_date = $this->db->get_where('task', array('id' => $id))->row()->add_date;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Name Field
        $this->form_validation->set_rules('date', 'Date', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Category Field
        $this->form_validation->set_rules('requested_by', 'Requested By', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Purchase Price Field
        $this->form_validation->set_rules('requested_for', 'Requested For', 'trim|required|min_length[1]|max_length[1000]|xss_clean');
        // Validating Store Box Field
        $this->form_validation->set_rules('to_do', 'To Do', 'trim|min_length[1]|max_length[1000]|xss_clean');
        // Validating Selling Price Field
        $this->form_validation->set_rules('timeline', 'Timeline', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Generic Name Field
        $this->form_validation->set_rules('status', 'Status', 'trim|required|min_length[1]|max_length[100]|xss_clean');


        if ($this->form_validation->run() == FALSE) {
            $data = array();
            $data['employees'] = $this->employee_model->getEmployee();
            $data['categories'] = $this->task_model->getTaskCategory();
            $data['settings'] = $this->settings_model->getSettings();
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('add_new_task_view', $data);
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            $data = array(
                'date' => $date,
                'requested_by' => $requested_by,
                'requested_for' => $requested_for,
                'to_do' => $to_do,
                'timeline' => $timeline,
                'status' => $status,
                'add_date' => $add_date,
            );
            if (empty($id)) {
                $this->task_model->insertTask($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else {
                $this->task_model->updateTask($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            redirect('task');
        }
    }

    function editTask() {
        $data = array();
        $data['employees'] = $this->employee_model->getEmployee();
        $data['categories'] = $this->task_model->getTaskCategory();
        $id = $this->input->get('id');
        $data['task'] = $this->task_model->getTaskById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_task_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editTaskByJason() {
        $id = $this->input->get('id');
        $data['task'] = $this->task_model->getTaskById($id);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->task_model->deleteTask($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('task');
    }

    function done() {
        $status = '2';
        $data['tasks'] = $this->task_model->getTaskByStatus($status);
        $data['employees'] = $this->employee_model->getEmployee();
        $data['categories'] = $this->task_model->getTaskCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('done_tasks', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function open() {
        $status = '1';
        $data['tasks'] = $this->task_model->getTaskByStatus($status);
        $data['employees'] = $this->employee_model->getEmployee();
        $data['categories'] = $this->task_model->getTaskCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('open_tasks', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function myTask() {
        $data['tasks'] = $this->task_model->getTask();
        $data['employees'] = $this->employee_model->getEmployee();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('my_task', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function myDone() {
        $status = '2';
        $data['tasks'] = $this->task_model->getTaskByStatus($status);
        $data['categories'] = $this->task_model->getTaskCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('my_done_task', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function myOpen() {
        $status = '1';
        $data['tasks'] = $this->task_model->getTaskByStatus($status);
        $data['categories'] = $this->task_model->getTaskCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('my_open_task', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function taskCategory() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['categories'] = $this->task_model->getTaskCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('task_category', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function addReport() {
        $task_id = $this->input->post('task_id');
        $report = $this->input->post('to_do_report');
        $data = array();
        $data = array('to_do_report' => $report);
        $this->task_model->updateTask($task_id, $data);
        $this->session->set_flashdata('feedback', 'Report Added');
        if ($this->ion_auth->in_group(array('admin'))) {
            redirect('task');
        } else {
            $current_user = $this->ion_auth->get_user_id();
            $task_details = $this->task_model->getTaskById($task_id);
            if ($current_user == $task_details->requested_for) {
                redirect('task/myTask');
            } else {
                redirect('task');
            }
        }
    }

    public function addCategoryView() {
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_category_view');
        $this->load->view('home/footer'); // just the header file
    }

    public function addNewCategory() {
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        $description = $this->input->post('description');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Category Name Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Description Field
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $data['settings'] = $this->settings_model->getSettings();
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('add_new_category_view');
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            $data = array('category' => $category,
                'description' => $description
            );
            if (empty($id)) {
                $this->task_model->insertTaskCategory($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else {
                $this->task_model->updateTaskCategory($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            redirect('task/taskCategory');
        }
    }

    function edit_category() {
        $data = array();
        $id = $this->input->get('id');
        $data['task'] = $this->task_model->getTaskCategoryById($id);
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_new_category_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editTaskCategoryByJason() {
        $id = $this->input->get('id');
        $data['taskcategory'] = $this->task_model->getTaskCategoryById($id);
        echo json_encode($data);
    }

    function deleteTaskCategory() {
        $id = $this->input->get('id');
        $this->task_model->deleteTaskCategory($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('task/taskCategory');
    }

}

/* End of file task.php */
/* Location: ./application/modules/task/controllers/task.php */
