<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertEvent($data) {
        $this->db->insert('event', $data);
    }

    function getEvent() {
        $query = $this->db->get('event');
        return $query->result();
    }
    
    function getEventForCalendar() {
        $query = $this->db->get('event');
        return $query->result();
    }

    function getEventById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('event');
        return $query->row();
    }
    
     function getEventByPageNumber($page_number) {
        $data_range_1 = 50 * $page_number;
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('event', 50, $data_range_1);
        return $query->result();
    }
    
    
    function getEventByKey($page_number, $key) {
        $data_range_1 = 50 * $page_number;
        $this->db->like('name', $key);
        $this->db->or_like('phone', $key);
        $this->db->order_by('id', 'asc');
        $query = $this->db->get('event', 1, $data_range_1);
        return $query->result();
    }

    function updateEvent($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('event', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('event');
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
