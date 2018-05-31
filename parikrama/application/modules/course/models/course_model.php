<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Course_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertCourse($data) {
        $this->db->insert('course', $data);
    }

    function getCourse() {
        $query = $this->db->get('course');
        return $query->result();
    }

    function getCourseById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('course');
        return $query->row();
    }

    function getCourseByPageNumber($page_number) {
        $data_range_1 = 50 * $page_number;
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('course', 50, $data_range_1);
        return $query->result();
    }

    function getCourseByKey($page_number, $key) {
        $data_range_1 = 50 * $page_number;
        $this->db->like('name', $key);
        $this->db->or_like('topic', $key);
        $this->db->or_like('course_id', $key);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('course', 50, $data_range_1);
        return $query->result();
    }

    function updateCourse($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('course', $data);
    }

    function insertCourseMaterial($data) {
        $this->db->insert('course_material', $data);
    }

    function getCourseMaterial() {
        $query = $this->db->get('course_material');
        return $query->result();
    }

    function getCourseMaterialById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('course_material');
        return $query->row();
    }

    function getCourseMaterialByCourseId($id) {
        $this->db->where('course', $id);
        $query = $this->db->get('course_material');
        return $query->result();
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('course');
    }
    
     function deleteCourseMaterial($id) {
        $this->db->where('id', $id);
        $this->db->delete('course_material');
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
