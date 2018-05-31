<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Student_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertStudent($data) {
        $this->db->insert('student', $data);
    }

    function getStudent() {
        $query = $this->db->get('student');
        return $query->result();
    }
    
    function getStudentByKeyforBatch($key) {
        $this->db->like('name', $key);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('student');
        return $query->result();
    }
    
     function getBatchByStudentId($student_id) {
        $this->db->where('student', $student_id);
        $student_batchs = $this->db->get('student_batch')->result(); 
        $expected_batches = array();
        foreach ($student_batchs as $student_batch) {
            $expected_batches[] = $student_batch->batch;
        }

        return $expected_batches;
    }

    function getStudentById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('student');
        return $query->row();
    }
    
     function getStudentByPageNumber($page_number) {
        $data_range_1 = 50 * $page_number;
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('student', 50, $data_range_1);
        return $query->result();
    }
    
    
    function getStudentByKey($page_number, $key) {
        $data_range_1 = 50 * $page_number;
        $this->db->like('name', $key);
        $this->db->or_like('phone', $key);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('student', 1, $data_range_1);
        return $query->result();
    }

    function updateStudent($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('student', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('student');
    }

    function updateIonUser($username, $email, $password, $ion_user_id) {
        $uptade_ion_user = array(
            'username' => $username,
            'email' => $email,
            'password' => $password
        );
        $this->db->where('id', $ion_user_id);
        $this->db->update('users', $uptade_ion_user);
    }

}
