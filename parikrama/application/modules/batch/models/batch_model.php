<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Batch_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertBatch($data) {
        $this->db->insert('batch', $data);
    }

    function getBatch() {
        $query = $this->db->get('batch');
        return $query->result();
    }

    function getBatchById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('batch');
        return $query->row();
    }

    function getBatchByPageNumber($page_number) {
        $data_range_1 = 50 * $page_number;
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('batch', 50, $data_range_1);
        return $query->result();
    }

    function getBatchQuantityByCourseId($course_id) {
        $this->db->where('course', $course_id);
        $query = $this->db->get('batch')->result();
        $i = 0;
        foreach ($query as $batch) {
            if ($batch->course == $course_id) {
                $i = $i + 1;
            }
        }

        return $i;
    }

    function checkExistInBatch($batch_id, $student_id) {
        $this->db->where('batch', $batch_id);
        $this->db->where('student', $student_id);
        $student_batchs = $this->db->get('student_batch')->result();
        return $student_batchs;
    }

    function getBatchByCourseId($course_id) {
        $this->db->where('course', $course_id);
        $query = $this->db->get('batch')->result();
        return $query;
    }

    function getBatchByKey($page_number, $key) {
        $data_range_1 = 50 * $page_number;
        $this->db->like('batch_id', $key);
        $this->db->or_like('course', $key);
        $this->db->or_like('instructor', $key);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('batch', 1, $data_range_1);
        return $query->result();
    }

    function insertStudentToBatch($data) {
        $this->db->insert('student_batch', $data);
    }

    function getStudentsByBatchId($batch_id) {
        $this->db->where('batch', $batch_id);
        $student_batchs = $this->db->get('student_batch')->result();
        $expected_students = array();
        foreach ($student_batchs as $student_batch) {
            $expected_students[] = $student_batch->student;
        }

        return $expected_students;
    }
    
    function getStudentsNumberByBatchId($batch_id) {
        $this->db->where('batch', $batch_id);
        $student_batchs = $this->db->get('student_batch')->result();
        $expected_students = array();
        $i = 0;
        foreach ($student_batchs as $student_batch) {
            $expected_students[] = $student_batch->student;
            $i = $i + 1;
        }

        return $i;
    }

    function updateBatch($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('batch', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('batch');
    }

    function deleteStudentFromBatch($student_id, $batch_id) {
        $this->db->where('student', $student_id);
        $this->db->where('batch', $batch_id);
        $this->db->delete('student_batch');
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
