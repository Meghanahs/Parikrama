<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library('Ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('event_model');
        $this->load->model('settings/settings_model');
        $this->load->library('upload');
        $this->lang->load('system_syntax');
        $this->load->model('ion_auth_model');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->in_group(array('admin', 'Instructor', 'Student', 'Employee'))) {
            redirect('home/permission');
        }
    }

    public function index() {

        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['events'] = $this->event_model->getEventByPageNumber($page_number);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['p_n'] = '0';
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('event', $data);
        $this->load->view('home/footer'); // just the header file
    }
    
    function upcoming(){
         $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['events'] = $this->event_model->getEventByPageNumber($page_number);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['p_n'] = '0';
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('upcoming', $data);
        $this->load->view('home/footer'); // just the header file
    }
    
    function ongoing(){
         $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['events'] = $this->event_model->getEventByPageNumber($page_number);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['p_n'] = '0';
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('ongoing', $data);
        $this->load->view('home/footer'); // just the header file
    }
    

    public function eventByPageNumber() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['events'] = $this->event_model->getEventByPageNumber($page_number);
        $data['pagee_number'] = $page_number;
        $data['p_n'] = $page_number;
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('event', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function searchEvent() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $key = $this->input->get('key');
        $data['events'] = $this->event_model->getEventByKey($page_number, $key);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['key'] = $key;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('event', $data);
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
        $title = $this->input->post('title');
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Title Field
        $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        // Validating Start Field
        $this->form_validation->set_rules('start', 'Start', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        // Validating End Field   
        $this->form_validation->set_rules('end', 'End', 'trim|required|min_length[5]|max_length[500]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            if (!empty($id)) {
                redirect("event/editEvent?id=$id");
            } else {
                $data['settings'] = $this->settings_model->getSettings();
                $this->load->view('home/dashboard', $data); // just the header file
                $this->load->view('add_new');
                $this->load->view('home/footer'); // just the header file
            }
        } else {

            $data = array();
            $data = array(
                'title' => $title,
                'start' => $start,
                'end' => $end
            );

            if (empty($id)) {     // Adding New Event
                $this->event_model->insertEvent($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else { // Updating Event
                $this->event_model->updateEvent($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            // Loading View
            redirect('event');
        }
    }

    function getEvent() {
        $data['events'] = $this->event_model->getEvent();
        $this->load->view('event', $data);
    }
    
    

    function calendar() {
        $data = array();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('calendar', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function getEventByJason() {
        $query = $this->event_model->getEventForCalendar();

     //   $jsonevents = array();

        foreach ($query as $entry) {
            
            $start_string = explode('-', $entry->start);
            $start_time = implode(' ', $start_string);
            $start_time = strtotime($start_time);
            
            $end_string = explode('-', $entry->end);
            $end_time = implode(' ', $end_string);
            $end_time = strtotime($end_time);
            

            $jsonevents[] = array(
                'id' => $entry->id,
                'title' => $entry->title,
                'start' => $start_time,
                'end' => $end_time,
               // 'color' => 'green',
            );
        }

        echo json_encode($jsonevents);
    }

    function editEvent() {
        $data = array();
        $id = $this->input->get('id');
        $data['event'] = $this->event_model->getEventById($id);
        $this->load->view('home/dashboard'); // just the header file
        $this->load->view('add_new', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function editEventByJason() {
        $id = $this->input->get('id');
        $data['event'] = $this->event_model->getEventById($id);
        echo json_encode($data);
    }

    function delete() {
        $id = $this->input->get('id');
        $this->event_model->delete($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('event');
    }

}

/* End of file event.php */
/* Location: ./application/modules/event/controllers/event.php */
