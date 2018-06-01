<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Signup_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

public function	createTeacher($teacherDetails){
		 
        $db=$this->load->database();
        $this->db->insert("users",$teacherDetails);
        echo "<script>console.log('Success');</script>";
    }
	
public function mail($username,$mail,$reg){
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: Parikrama <info@siddhrans.com>' . "\r\n";
        $query1 =$this->db->query("SELECT * FROM users where mail='$mail'");
        $row=$query1->result_array();
        if ($query1->num_rows()>0)

            $mail_message='Dear '.$row[0]['username'].','."\r\n";
            $mail_message.='Thanks for for registration,<br>'.' Click '.'
            <a href="auth/verify?mail='.$mail.'&reg='.$reg.'">Here</a>'.' to Activate your account<br>';
            $mail_message.='<br>Thanks & Regards';
            $mail_message.='<br>Parikrama';
            mail($mail,"Account activation ".$mail,$mail_message,$headers);
            $this->load->view('success');
    }
	
  public function verify($username,$id){
     $q="select * from users where mail='$name' and reg_id='$id'";
     $confirm = $this->db->query($q); 
     $rows=$confirm->num_rows();
       if($rows>0){
          $q = "UPDATE users SET active='active' where mail='$name' and reg_id='$id'";
          $this->db->query($q);
          $this->load->view('activationMsg');
          /*header("Refresh: 5; url=http://movies.siddhrans.com/");*/
        }
       else {
       echo"unauthorized user";
   }
    }
	
	
}
/*  function insertStudent($data) {
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
    } */

}
