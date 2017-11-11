<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panic extends CI_Controller {

	public function Distress(){
	    $userName=$_POST['userName'];
	  	$this->load->model('Panic_model');
	    $data=$this->Panic_model->getFamilyToken();
	    $FamilyMobileNumbers=$this->Panic_model->getFamilyMobileNumbers();
	    $FamilyEmailId=$this->Panic_model->getFamilyEmailId();
 $tokens=array();
	     foreach ($data as $key) {
	     if(!empty($key)){
	               $tokens[]=$key['token'];
	               }
	          }
	          
	        //print_r($tokens);
	     if(!empty($tokens)){
	     			$data='null';
	                  $message=Distress_message($userName);
	                  $notify=push_notify($tokens,$message,$data);
                          foreach ($FamilyMobileNumbers as $MobileNumbers) {
			         if(!empty($MobileNumbers)){
			           $xml_data ='<?xml version="1.0"?>
				<parent>
				<child>
				<user>safety12</user>
				<key>bd8ce243dbXX</key>
				<mobile>'.$MobileNumbers['userContact'].'</mobile>
				<message>'.$userName.' needs your help urgently.</message>
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
    
		     		 
			               
			               }
	                  }  
	                  
	                  foreach ($FamilyEmailId as $EmailId) {
			         if(!empty($EmailId)){
			         $send_mail=$this->sendMail($userName,$EmailId['userEmail'],$EmailId['userName']);
                              }
	                  }  
                            
	                  $final_data['status']=panic_success();
             	          $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
	            }else{

	            	 $final_data['status']=failed();
             		 $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
 }
             

   }
   
   
    public function sendMail($userName,$userEmail,$usenEmailName){
  ini_set('max_execution_time', 108000);
                $userId=urlencode(base64_encode($userId));
                $result['sitelink']= site_url("Verifyemail/Verify/$userId");
              $result['email']=$userEmail;
              $result['name']=$userName;
              $result['usenEmailName']=$usenEmailName;
              $html=$this->load->view('emailfornotifytmplate', $result, true);
              $this->load->library('email');
              $this->email->set_mailtype("html");
              $this->email->from('webamosapps@gmail.com', 'RoadSafety');
              $this->email->to($userEmail);
              $this->email->subject('Need Help To Your Friend');
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
}