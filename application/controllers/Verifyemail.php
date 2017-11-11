<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verifyemail extends CI_Controller {
    public function Verify(){
    	$last = $this->uri->total_segments();
		$record_num = $this->uri->segment($last);
		$userid=base64_decode(urldecode($record_num));
		$this->load->model('Verifymail_model');
		$result1=$this->Verifymail_model->updatEmailBit($userid);
		if($result1){
			$this->load->view('thankyou');
		}else{
			$this->load->view('somethingwrong');
		}
	}
	
public function ChangePassword(){
    	$last = $this->uri->total_segments();
		$record_num = $this->uri->segment($last);
		$userid['userId']=base64_decode(urldecode($record_num));
		$this->load->view('changepassword',$userid);
	}//ChangePassword

	public function UpdatePassword(){
    	
    	$this->load->model('Verifymail_model');
    	$data=$this->Verifymail_model->UpdatePassword();
    	if($data){
    		        $result['success']='1';
    				$this->load->view('changepasswordsuccess',$result);
    	}else{
    				$result['success']='0';
    				$this->load->view('changepasswordsuccess',$result);
    	}
	}//UpdatePassword	

}