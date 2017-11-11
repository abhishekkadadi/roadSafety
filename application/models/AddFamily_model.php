<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AddFamily_model extends CI_Model {
	    public function AddFamilyMember()
	    {   
	    $parentUserNameSingelUser="";     
	    $memberName = $_POST['memberName'];
	    $memberEmail = $_POST['memberEmail'];
	    $memberContact=$_POST['memberContact'];
	    $parentUserId=$_POST['userId'];
	    $parentUserName=$this->getUserName($_POST['userId']);
	    foreach ($parentUserName as $Name) {
			         if(!empty($Name)){
			         $parentUserNameSingelUser=$Name['userName'];
                              }
	                  }  
	    $query = $this->db->get_where('userprofile', array('userEmail' => $memberEmail, 
		       	                                           'userContact' => $memberContact,
		       	                                           'isEmailVerify'=>'1'));
	    $count = $query->num_rows() > 0;
		
		        
		        if($count==1){
		        	foreach ( $query->result() as $key) {

		        	$childUserId=$key->userId;
		        }
		        $query2=$this->db->get_where('memberlink', array('parentId' => $parentUserId, 
		       	                                           'childId' => $childUserId));
		         $count2 = $query2->num_rows() > 0;
		         if($count2==0){
			        $data=array(
			        	array(
				    		'parentId'=> $parentUserId,
				    		'childId'=>$childUserId
				    		),
			        	array(
			        		'parentId'=> $childUserId,
				    		'childId'=>$parentUserId
				    		)
						 );

	                $this->db->insert_batch('memberlink', $data);
	                
	                $xml_data ='<?xml version="1.0"?>
				<parent>
				<child>
				<user>safety12</user>
				<key>bd8ce243dbXX</key>
				<mobile>'.$memberContact.'</mobile>
				<message>Your Ashoka Road Safety account is linked to '.$parentUserNameSingelUser.' ,For Download android app : http://bit.ly/2tT5aCw ,IOS app: http://apple.co/2xlmO3e</message>
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
				
	                 //$send_mail=$this->sendMail($memberName,$memberEmail,$parentUserNameSingelUser);	                
				    return ($this->db->affected_rows() != 2) ? false : true;
		        }else{return 'alreadylinked';}
		        }else{
		         $xml_data ='<?xml version="1.0"?>
				<parent>
				<child>
				<user>safety12</user>
				<key>bd8ce243dbXX</key>
				<mobile>'.$memberContact.'</mobile>
				<message>'.$parentUserNameSingelUser.' has invited you to join ashok road sefty app,For Download android app : http://bit.ly/2tT5aCw ,IOS app: http://apple.co/2xlmO3e</message>
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
		        return 'wrong';}
		 }//AddFamilyMember
		 
		 
		 public function getUserName($userId)
	    {     
	    	                        $userId=$_POST['userId'];
					$this->db->select('up.userName');
					$this->db->from('userprofile as up');					
					$this->db->where('up.userId',$userId);
					$query = $this->db->get()->result_array();
					return $query;
					

	    }//AddLocationDetails
		
		public function sendMail($userName,$userEmail,$parentUserNameSingelUser){
  ini_set('max_execution_time', 108000);
                $userId=urlencode(base64_encode($userId));
                $result['sitelink']= site_url("Verifyemail/Verify/$userId");
              $result['email']=$userEmail;
              $result['name']=$userName;
              $result['parentUserNameSingelUser']=$parentUserNameSingelUser;
              $html=$this->load->view('emailtempletforaddmember', $result, true);
              $this->load->library('email');
              $this->email->set_mailtype("html");
              $this->email->from('webamosapps@gmail.com', 'RoadSafety');
              $this->email->to($userEmail);
              $this->email->subject('Ashoka Road Safety - you got mail from '.$parentUserNameSingelUser.'');
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
		 
	public function FetchMember()
	    {        
	                     $userId=$_POST['userId'];
                	     $this->db->select('up.*,ml.*');
						 $this->db->from('userprofile as up');
						 $this->db->join('memberlink as ml', 'ml.childId = up.userId');
						 $this->db->where('ml.parentId', $userId);
						 $this->db->group_by('ml.childId');
						 $query = $this->db->get();
                         return $query;
		 }//FetchMember
		 
	public function unlinkFamilyMember()
	    {        
	                     $userId=$_POST['userId'];
                	     $unlinkId=$_POST['memberId'];
                	     $this->db->where('parentId',$userId);
                	     $this->db->where('childId',$unlinkId);
                         $this->db->delete('memberlink');
                         $this->db->flush_cache();
                         //unlink viceversa
                         $this->db->where('childId',$userId);
                	     $this->db->where('parentId',$unlinkId);
                	     if($this->db->delete('memberlink')){
                	     	return true;
                	     }else{
                	     	return false;
                	     }
                	    
                         
		 }//unlinkFamilyMember
}