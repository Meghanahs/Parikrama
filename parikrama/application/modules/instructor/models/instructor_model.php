<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Instructor_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertInstructor($data) {
        $this->db->insert('instructor', $data);
    }

    function getInstructor() {
        $query = $this->db->get('instructor');
        return $query->result();
    }

    function getInstructorById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('instructor');
        return $query->row();
    }
    
    function getInstructorByIonUserId($id){
        $this->db->where('ion_user_id', $id);
        $query = $this->db->get('instructor');
        return $query->row();
    }
    
     function getInstructorByPageNumber($page_number) {
        $data_range_1 = 50 * $page_number;
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('instructor', 50, $data_range_1);
        return $query->result();
    }
    
    
    function getInstructorByKey($page_number, $key) {
        $data_range_1 = 50 * $page_number;
        $this->db->like('name', $key);
        $this->db->or_like('phone', $key);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('instructor', 1, $data_range_1);
        return $query->result();
    }

    function updateInstructor($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('instructor', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('instructor');
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
