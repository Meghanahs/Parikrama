<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Employee_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertEmployee($data) {
        $this->db->insert('employee', $data);
    }

    function getEmployee() {
        $query = $this->db->get('employee');
        return $query->result();
    }

    function getEmployeeById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('employee');
        return $query->row();
    }
    

    function getEmployeeByIonUserid($id) {
        $this->db->where('ion_user_id', $id);
        $query = $this->db->get('employee');
        return $query->row();
    }

    function getEmployeeByPageNumber($page_number) {
        $data_range_1 = 50 * $page_number;
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('employee', 50, $data_range_1);
        return $query->result();
    }

    function getEmployeeByKey($page_number, $key) {
        $data_range_1 = 50 * $page_number;
        $this->db->like('name', $key);
        $this->db->or_like('phone', $key);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('employee', 1, $data_range_1);
        return $query->result();
    }

    function updateEmployee($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('employee', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('employee');
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
