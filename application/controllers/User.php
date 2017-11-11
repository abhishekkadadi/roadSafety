<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

  public function Register(){
   $userEmail = $_POST['userEmail'];
    $final_data=array();
      $this->load->model('User_model');
          $data=$this->User_model->Register();
          if($data==='emailPresent'){
            $final_data['status']=email_present();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
          }else if($data==='phonePresent'){
            $final_data['status']=phone_present();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
           }else if($data){
             $data2=$this->User_model->getUserByMail($userEmail);
             foreach ($data2->result() as $key) {
                        $userId=$key->userId;
                        $userName=$key->userName;
             }
             $send_mail=$this->sendMail($userId,$userName,$userEmail);
            // print_r($send_mail);
             $final_data['status']=successful_register();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
           }else{
            $final_data['status']=failed();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
             
         }
  }//Register
  
  
  public function Insert_User_Note(){  
      $final_data=array();
      $this->load->model('User_model');
          $data=$this->User_model->IsertUserNote();
          if($data){             
             $final_data['status']=array('status'=>'1','message'=>"Note added sucessfully");
        	 $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
           }else{
             $final_data['status']=array('status'=>'0','message'=>"Something went wrong");
       		$this->output->set_content_type('application/json')->set_output(json_encode($final_data));
             
         }
  }//Isert User Note
  
  public function fetch_user_note()
	{
  	$this->load->model('User_model');
	$data = $this->User_model->Fetch_UserNote();
	if($data)
   	{
        	if($data == 'false')
        	{
        	$final_data['status']=array('status'=>'0','message'=>"No Record Found.");
        	$this->output->set_content_type('application/json')->set_output(json_encode($final_data));
        	}
        	else
        	{
        	$final_data['status']=array('status'=>'1','message'=>"Data Fetch Successfully.");
        	$final_data['data']=$data;    
        	$this->output->set_content_type('application/json')->set_output(json_encode($final_data));
        	}
        	
   	}
   	else
   	{
        	$final_data['status']=array('status'=>'0','message'=>'Oops! Some thing went wrong');
          	$this->output->set_content_type('application/json')->set_output(json_encode($final_data));
   	}
   	}//function Fetch Grower Details

  public function Login(){
    $final_data=array();
      $this->load->model('User_model');
          $data=$this->User_model->LoginCheck();
          if($data==='wrong'){
            $final_data['status']=wrong_credential();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
          }else if($data==='notverifyemail'){
            $final_data['status']=not_verify();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));

          }else if(!empty($data)){
                foreach ($data as $key) {
                  $userId=$key->userId;
                  $userName=$key->userName;
                  $userEmail=$key->userEmail;
                  $userContact=$key->userContact;
                }
             
             $final_data['status']=successful_login();
             $final_data['data']=array('userId'=>$userId,'userName'=>$userName,'userEmail'=>$userEmail,'userContact'=>$userContact);
             $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
           }else{
            $final_data['status']=failed();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
             
         }
  }//Login
  
  
  public function sendMail($userId,$userName,$userEmail){
  ini_set('max_execution_time', 108000);
                $userId=urlencode(base64_encode($userId));
                $result['sitelink']= site_url("Verifyemail/Verify/$userId");
              $result['email']=$userEmail;
              $result['name']=$userName;
                $html=$this->load->view('emailtemplate', $result, true);
                $this->load->library('email');
                /*$this->email->initialize(array(
                                                 'protocol' => 'smtp',
                                                'smtp_host' => 'smtp.sendgrid.net',
                                                'smtp_user' => 'akadadi',
                                                  'smtp_pass' => 'danger44',
                                                'smtp_port' => 25,
                                                'crlf' => "\r\n",
                                                'newline' => "\r\n"
                                              ));*/
                  $this->email->set_mailtype("html");
              $this->email->from('webamosapps@gmail.com', 'RoadSafety');
              $this->email->to($userEmail);
              $this->email->subject('RoadSafety App Email Verification');
              $this->email->message($html);
              if($this->email->send()){
                return;
               //echo 'sent';
              }else{
                print_r($this->email->print_debugger(), true);
                //echo 'failed';
              // return;//mail sending failed please contact software providers
              }
    }//sendmail


public function ForgotPassword(){
    $this->load->model('User_model');
    $data=$this->User_model->GetPassword();
    if($data){
              foreach ($data as $key) {
                $userName=$key->userName;
                $userPassword=$key->userPassword;
                $userEmail=$key->userEmail;
                $userContact=$key->userContact;
                $result['userPassword']=$userPassword;
                $result['name']=$userName;
              }
                $html=$this->load->view('forgotpassword', $result, true);

                $this->load->library('email');              
              $this->email->set_mailtype("html");
              $this->email->from('webamosapps@gmail.com', 'RoadSafety');
              $this->email->to($userEmail);
              $this->email->subject('RoadSafety App password request');
              $this->email->message($html);
               if($this->email->send()){
                $final_data['status']=mail_sent();
                $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
               
              }else{
                $final_data['status']=mail_failed();
                $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
               
              }
              
              $xml_data ='<?xml version="1.0"?>
				<parent>
				<child>
				<user>safety12</user>
				<key>bd8ce243dbXX</key>
				<mobile>'.$userContact.'</mobile>
				<message>Your password for Ashoka Road Safety app is '.$userPassword.'</message>
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
              
    }else{
            $final_data['status']=nodata_fetch();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }

 }//ForgotPassword
 
 public function ForgotPassword2(){
           $this->load->model('User_model');
           $data=$this->User_model->GetUserId();
           if($data){
              foreach ($data as $key){
                $userName=$key->userName;
                $userId=$key->userId;
                $userEmail=$key->userEmail;
                
              }
              //$result['userPassword']=$userPassword;
              $result['name']=$userName;

               $userId=urlencode(base64_encode($userId));
               $result['sitelink']= site_url("Verifyemail/ChangePassword/$userId");
               $html=$this->load->view('forgotpassword2', $result, true);
                 $this->load->library('email');
                /* $this->email->initialize(array(
                                                 'protocol' => 'smtp',
                                                'smtp_host' => 'smtp.sendgrid.net',
                                                'smtp_user' => 'akadadi',
                                                  'smtp_pass' => 'danger44',
                                                'smtp_port' => 587,
                                                'crlf' => "\r\n",
                                                'newline' => "\r\n"
                                              ));*/
              $this->email->set_mailtype("html");
              $this->email->from('info@whitecode.co.in', 'RoadSafety');
              $this->email->to($userEmail);
              $this->email->subject('RoadSafety App password request');
              $this->email->message($html);
               if($this->email->send()){
                $final_data['status']=mail_sent();
                $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
               
              }else{
                $final_data['status']=mail_failed();
                $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
               
              }
              
    }   
  }//forgotpassword2

}//controller

?>