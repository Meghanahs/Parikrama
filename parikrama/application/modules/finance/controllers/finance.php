<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Finance extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->lang->load('system_syntax');
        $this->load->model('finance_model');
        $this->load->model('course/course_model');
        $this->load->model('batch/batch_model');
        $this->load->model('student/student_model');
        $this->load->model('settings/settings_model');
        $data['settings'] = $this->settings_model->getSettings();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        if (!$this->ion_auth->in_group(array('admin', 'Employee', 'Student', 'Instructor'))) {
            redirect('home/permission');
        }
    }

    public function index() {
        redirect('finance/financial_report');
    }

    public function payment() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['settings'] = $this->settings_model->getSettings();
        $data['payments'] = $this->finance_model->getPaymentByPageNumber($page_number);

        $data['pagee_number'] = $page_number;
        $data['p_n'] = '0';

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('payment', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function paymentByPageNumber() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['payments'] = $this->finance_model->getPaymentByPageNumber($page_number);
        $data['pagee_number'] = $page_number;
        $data['p_n'] = $page_number;
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('payment', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addPaymentView() {
        $data = array();
        $data['courses'] = $this->course_model->getCourse();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_payment_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addPaymentViewDebug() {
        $data = array();
        $data['discount_type'] = $this->finance_model->getDiscountType();
        $data['settings'] = $this->settings_model->getSettings();
        $data['medicines'] = $this->medicine_model->getMedicine();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_payment_view_new', $data);
        $this->load->view('home/footer'); // just the header file
    }

   
    function getPaymentByBatchIdByStudentIdByJason() {
        $batch_id = $this->input->get('batch_id');
        $student_id = $this->input->get('student_id');
        $data['payments'] = $this->finance_model->getPaymentByBatchIdByStudentId($batch_id, $student_id);
        $data['currency'] = $this->settings_model->getSettings()->currency;
        echo json_encode($data);
    }

    function searchPayment() {
        $page_number = $this->input->get('page_number');
        if (empty($page_number)) {
            $page_number = 0;
        }
        $data['p_n'] = $page_number;
        $key = $this->input->get('key');
        $data['payments'] = $this->finance_model->getPaymentByKey($page_number, $key);
        $data['settings'] = $this->settings_model->getSettings();
        $data['pagee_number'] = $page_number;
        $data['key'] = $key;
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('payment', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addPayment() {
        $id = $this->input->post('id');
        $student = $this->input->post('student');
        $batch = $this->input->post('batch_id');
        $course = $this->input->post('course');
        $amount = $this->input->post('amount');
        $discount = $this->input->post('discount');
        $date = time();

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Course Field
         $this->form_validation->set_rules('course', 'batch', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Student Field
         $this->form_validation->set_rules('student', 'Student', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Student Field
         $this->form_validation->set_rules('batch', 'batch', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Amount Field
        $this->form_validation->set_rules('amount', 'Amount', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Discount Field
        $this->form_validation->set_rules('discount', 'Discount', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            echo 'form validate noe nai re';
            // redirect('accountant/add_new'); 
        } else {


            if (!empty($discount)) {
                $gross_total = $amount - $discount;
            } else {
                $gross_total = $amount;
            }

            $data = array();
            $data = array(
                'course' => $course,
                'batch' => $batch,
                'student' => $student,
                'amount' => $amount,
                'discount' => $discount,
                'gross_total' => $gross_total,
                'date' => $date
            );
            if (empty($id)) {
                $this->finance_model->insertPayment($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else {

                $this->finance_model->updatePayment($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            redirect("finance/addPaymentView");
        }
    }

    public function addpaymentFromStudentProfile() {
        $id = $this->input->post('id');
        $batch_course_array = array();
        $student = $this->input->post('student_id');
        $batch_course = $this->input->post('batch_course');
        $batch_course_array = explode('*', $batch_course);
        $batch = $batch_course_array[0];
        $course = $batch_course_array[1];
        $amount = $this->input->post('amount');
        $discount = $this->input->post('discount');
        $date = time();

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Validating Batch - Course Field
        // $this->form_validation->set_rules('batch_course', 'Batch - Course', 'trim|min_length[2]|max_length[100]|xss_clean');
        // Validating Amount Field
        $this->form_validation->set_rules('amount', 'Amount', 'trim|min_length[1]|max_length[100]|xss_clean');
        // Validating Discount Field
        $this->form_validation->set_rules('discount', 'Discount', 'trim|min_length[1]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            echo 'form validate noe nai re';
            // redirect('accountant/add_new'); 
        } else {


            if (!empty($discount)) {
                $gross_total = $amount - $discount;
            } else {
                $gross_total = $amount;
            }

            $data = array();
            $data = array(
                'course' => $course,
                'batch' => $batch,
                'student' => $student,
                'amount' => $amount,
                'discount' => $discount,
                'gross_total' => $gross_total,
                'date' => $date
            );
            if (empty($id)) {
                $this->finance_model->insertPayment($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else {

                $this->finance_model->updatePayment($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            redirect("student/details?student_id=" . $student);
        }
    }

    function delete() {
        if ($this->ion_auth->in_group('admin')) {
            $id = $this->input->get('id');
            $student_id = $this->finance_model->getStudentByPaymentId($id)->student;
            $this->finance_model->deletePayment($id);
            $this->session->set_flashdata('feedback', 'Deleted');
            redirect('finance/payment');
        }
    }

    public function expense() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['settings'] = $this->settings_model->getSettings();
        $data['expenses'] = $this->finance_model->getExpense();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('expense', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addExpenseView() {
        $data = array();
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->finance_model->getExpenseCategory();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_expense_view', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addExpense() {
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        $date = time();
        $amount = $this->input->post('amount');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Category Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Generic Name Field
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required|min_length[1]|max_length[100]|xss_clean');
        // Validating Company Name Field
        if ($this->form_validation->run() == FALSE) {
            $data = array();
            $data['settings'] = $this->settings_model->getSettings();
            $data['categories'] = $this->finance_model->getExpenseCategory();
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('add_expense_view', $data);
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            if (empty($id)) {
                $data = array(
                    'category' => $category,
                    'date' => $date,
                    'amount' => $amount
                );
            } else {
                $data = array(
                    'category' => $category,
                    'amount' => $amount
                );
            }
            if (empty($id)) {
                $this->finance_model->insertExpense($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else {
                $this->finance_model->updateExpense($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            redirect('finance/expense');
        }
    }

    function editExpense() {
        $data = array();
        $data['categories'] = $this->finance_model->getExpenseCategory();
        $data['settings'] = $this->settings_model->getSettings();
        $id = $this->input->get('id');
        $data['expense'] = $this->finance_model->getExpenseById($id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_expense_view', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function deleteExpense() {
        $id = $this->input->get('id');
        $this->finance_model->deleteExpense($id);
           $this->session->set_flashdata('feedback', 'Deleted');
        redirect('finance/expense');
    }

    public function expenseCategory() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $data['settings'] = $this->settings_model->getSettings();
        $data['categories'] = $this->finance_model->getExpenseCategory();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('expense_category', $data);
        $this->load->view('home/footer'); // just the header file
    }

    public function addExpenseCategoryView() {
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_expense_category');
        $this->load->view('home/footer'); // just the header file
    }

    public function addExpenseCategory() {
        $id = $this->input->post('id');
        $category = $this->input->post('category');
        $description = $this->input->post('description');

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        // Validating Category Name Field
        $this->form_validation->set_rules('category', 'Category', 'trim|required|min_length[2]|max_length[100]|xss_clean');
        // Validating Description Field
        $data['settings'] = $this->settings_model->getSettings();
        $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[5]|max_length[100]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('home/dashboard', $data); // just the header file
            $this->load->view('add_expense_category');
            $this->load->view('home/footer'); // just the header file
        } else {
            $data = array();
            $data = array('category' => $category,
                'description' => $description
            );
            if (empty($id)) {
                $this->finance_model->insertExpenseCategory($data);
                $this->session->set_flashdata('feedback', 'Added');
            } else {
                $this->finance_model->updateExpenseCategory($id, $data);
                $this->session->set_flashdata('feedback', 'Updated');
            }
            redirect('finance/expenseCategory');
        }
    }

    function editExpenseCategory() {
        $data = array();
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['category'] = $this->finance_model->getExpenseCategoryById($id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('add_expense_category', $data);
        $this->load->view('home/footer'); // just the footer file
    }

    function deleteExpenseCategory() {
        $id = $this->input->get('id');
        $this->finance_model->deleteExpenseCategory($id);
        $this->session->set_flashdata('feedback', 'Deleted');
        redirect('finance/expenseCategory');
    }

    function invoice() {
        $id = $this->input->get('id');
        $data['settings'] = $this->settings_model->getSettings();
        $data['discount_type'] = $this->finance_model->getDiscountType();
        $data['payment'] = $this->finance_model->getPaymentById($id);
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('invoice', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

 

   

    function todaySales() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $hour = 0;
        $today = strtotime($hour . ':00:00');
        $today_last = strtotime($hour . ':00:00') + 24 * 60 * 60;
        $data['settings'] = $this->settings_model->getSettings();
        $data['payments'] = $this->finance_model->getPaymentByDate($today, $today_last);

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('today_sales', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function todayExpense() {
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $hour = 0;
        $today = strtotime($hour . ':00:00');
        $today_last = strtotime($hour . ':00:00') + 24 * 60 * 60;
        $data['settings'] = $this->settings_model->getSettings();
        $data['expenses'] = $this->finance_model->getExpenseByDate($today, $today_last);

        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('today_expenses', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function todayNetCash() {
        $data['today_sales_amount'] = $this->finance_model->todaySalesAmount();
        $data['today_expenses_amount'] = $this->finance_model->todayExpensesAmount();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('today_net_cash', $data);
        $this->load->view('home/footer'); // just the header file
    }

    function salesPerMonth() {

        $payments = $this->finance_model->getPayment();
        foreach ($payments as $payment) {
            $date = $payment->date;
            $month = date('m', $date);
            $year = date('y', $date);
            if ($month = '01') {
                
            }
        }
    }
    
     function courseWiseIncomeReportView(){
        $data['courses'] = $this->course_model->getCourse();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('course_wise_payment_report_view', $data);
        $this->load->view('home/footer'); // just the footer fi
    }
    
    
    function courseWiseIncomeReport(){
        $course = $this->input->post('course');
        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 24 * 60 * 60;
        }
        $data = array();
        
        $data['course_id'] = $course;
        $data['batchs'] = $this->batch_model->getBatch();


        $data['payments'] = $this->finance_model->getPaymentByDate($date_from, $date_to);

        $data['from'] = $this->input->post('date_from');
        $data['to'] = $this->input->post('date_to');
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('course_wise_payment_report', $data);
        $this->load->view('home/footer'); // just the footer fi
    }
    
    function expenseReport() {
        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 24 * 60 * 60;
        }
        $data = array();
        $data['expense_categories'] = $this->finance_model->getExpenseCategory();


        // if(empty($date_from)&&empty($date_to)) {
        //    $data['payments']=$this->finance_model->get_payment();
        //     $data['ot_payments']=$this->finance_model->get_ot_payment();
        //     $data['expenses']=$this->finance_model->get_expense();
        // }
        // else{

        $data['expenses'] = $this->finance_model->getExpenseByDate($date_from, $date_to);
        // } 
        $data['from'] = $this->input->post('date_from');
        $data['to'] = $this->input->post('date_to');
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('expense_report', $data);
        $this->load->view('home/footer'); // just the footer fi
    }
    
    function batchWiseIncomeReportView(){
        $data['courses'] = $this->course_model->getCourse();
        $data['batchs'] = $this->batch_model->getBatch();
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('batch_wise_payment_report_view', $data);
        $this->load->view('home/footer'); // just the footer fi
    }
    
    
    function batchWiseIncomeReport(){
        $course = $this->input->post('course');
        $batch = $this->input->post('batch_id');
        $data['students'] = $this->student_model->getStudent();
        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 24 * 60 * 60;
        }
        $data = array();
        
        $data['course_id'] = $course;
        $data['batch_id'] = $batch;
        $data['batchs'] = $this->batch_model->getBatch();


        $data['payments'] = $this->finance_model->getPaymentByDate($date_from, $date_to);

        $data['from'] = $this->input->post('date_from');
        $data['to'] = $this->input->post('date_to');
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('batch_wise_payment_report', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

    function financialReport() {
        $date_from = strtotime($this->input->post('date_from'));
        $date_to = strtotime($this->input->post('date_to'));
        if (!empty($date_to)) {
            $date_to = $date_to + 24 * 60 * 60;
        }
        $data = array();
        $data['batchs'] = $this->batch_model->getBatch();
        $data['expense_categories'] = $this->finance_model->getExpenseCategory();


        // if(empty($date_from)&&empty($date_to)) {
        //    $data['payments']=$this->finance_model->get_payment();
        //     $data['ot_payments']=$this->finance_model->get_ot_payment();
        //     $data['expenses']=$this->finance_model->get_expense();
        // }
        // else{

        $data['payments'] = $this->finance_model->getPaymentByDate($date_from, $date_to);
        $data['expenses'] = $this->finance_model->getExpenseByDate($date_from, $date_to);
        // } 
        $data['from'] = $this->input->post('date_from');
        $data['to'] = $this->input->post('date_to');
        $data['settings'] = $this->settings_model->getSettings();
        $this->load->view('home/dashboard', $data); // just the header file
        $this->load->view('financial_report', $data);
        $this->load->view('home/footer'); // just the footer fi
    }

}

/* End of file finance.php */
/* Location: ./application/modules/finance/controllers/finance.php */