<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Task_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertTask($data) {
        $this->db->insert('task', $data);
    }

    function getTask() {
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('task');  
        return $query->result();
    }
    
    function getTaskByStatus($status) {
        $this->db->where('status', $status);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('task');
        return $query->result(); 
    }

    function getTaskById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('task');
        return $query->row();
    }
    
    function taskAssignedByUser($user){
        $this->db->where('requested_by', $user);
        $query = $this->db->get('task');
        return $query->result();
    }
    
    function taskAssignedForUser($user){
        $this->db->where('requested_for', $user);
        $query = $this->db->get('task');
        return $query->result();
    }

    function updateTask($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('task', $data);
    }

    function insertTaskCategory($data) {

        $this->db->insert('task_category', $data);
    }

    function getTaskCategory() {
        $query = $this->db->get('task_category');
        return $query->result();
    }

    function getTaskCategoryById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('task_category');
        return $query->row();
    }

    function updateTaskCategory($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('task_category', $data);
    }

    function deleteTask($id) {
        $this->db->where('id', $id);
        $this->db->delete('task');
    }

    function deleteTaskCategory($id) {
        $this->db->where('id', $id);
        $this->db->delete('task_category');
    }

}
