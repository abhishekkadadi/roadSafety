<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
  public function LoginCheck(){
      $this->load->model('Login_model');
          $data=$this->Login_model->check();
          if($data){
                  
                  foreach ($data->result() as $row) {
                      $userDetails=array(
                                'studentName'=>$row->studentName,
                                'studentId'=>$row->studentId
                               
                                );
                              
                 }//foreach

               
                 
				 $userdata['status']=array('status'=>'1','message'=>'Successfully logged in');
                 $userdata['userData']=$userDetails;
                 
                 
                 $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
          }else{
               $final_data=array('status'=>'0','message'=>'Please check your credentials or Contact your society manager');
               $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
               }
         }
         
         
         
    public function generateOtp(){
    
    
    $phone=$_POST['phone'];
    
     $this->load->model('User_model');
     $data=$this->User_model->checkDuplicate();
    
    if($data==='emailpresent'){
    	 $userdata['status']=array('status'=>'-1','message'=>'You are already registered with us');
    	  $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
    
    }else if($data==='phonepresent'){
    	 $userdata['status']=array('status'=>'-1','message'=>'You are already registered with us');
    	  $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
    	
    }else{
    
    $randome=rand(1000,9999);
    
    
    $xml_data ='<?xml version="1.0"?>
<parent>
<child>
<user>safety12</user>
<key>bd8ce243dbXX</key>
<mobile>'.$phone.'</mobile>
<message>Your OTP for Ashoka road safety registration is = '.$randome.'</message>
<senderid>SAFETY</senderid>
<accusage>1</accusage>
</child>
</parent>';

$URL = "http://sms.whitesms.in/submitsms.jsp?"; 

			$ch = curl_init($URL);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
			curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			curl_close($ch);
    
    
     		 $userdata['status']=array('status'=>'1','message'=>'OTP Sent');
                 $userdata['otpnumber']=array('otp'=>$randome);
  		 $this->output->set_content_type('application/json')->set_output(json_encode($userdata));
    
    
    
    
   }
    
    }//generateOtp
         
         
         
         
}//Login

?>