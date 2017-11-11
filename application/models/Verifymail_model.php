<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Verifymail_model extends CI_Model {

	public function updatEmailBit($userid){
		$data = array(
               'isEmailVerify' => '1'
            );
		$this->db->where('userId', $userid);
		$this->db->update('userprofile',$data); 
        return ($this->db->affected_rows() < 1) ? false : true;
	}
	
	public function UpdatePassword(){
		$newPassword=$_POST['newPassword'];
    	$userId=$_POST['userId'];

		$data = array(
               'userPassword' => md5($newPassword)
            );
		$this->db->where('userId', $userId);
		$this->db->update('userprofile',$data); 
        return ($this->db->affected_rows() < 1) ? false : true;
	}
}
    