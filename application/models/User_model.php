<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model {
	    public function LoginCheck()
	    {        
	    $username = $_POST['userName'];
	    $password = $_POST['userPassword'];
	    $token=$_POST['token'];
	    if(is_numeric($username)){
	    	$query = $this->db->get_where('userprofile', array('userContact' => $username, 
		        	                                           'userPassword' => $password));
	    }else{
	        $query = $this->db->get_where('userprofile', array('userEmail' => $username, 
		        	                                           'userPassword' => $password)  );
	    }
		        
		        $count = $query->num_rows() > 0;
		        
		        
		        if($count==1){
		        	foreach ( $query->result() as $key) {

		        	$isEmailVerify=$key->isEmailVerify;
		        }
		        	if($isEmailVerify==1){
		        			$data=array(
								    		'token'=> $token
				    					);
		        			if(is_numeric($username))
		        				{
		        					$this->db->where('userContact',$username);
		        				}
		        				else{
		        					$this->db->where('userEmail',$username);
		        			    }
		        			   		$this->db->update('userprofile', $data);
		        	  return $query->result();
		        	  }else{return 'notverifyemail';}
		        }else{return 'wrong';}
		    
		
		 }//check


	            public function Register()
                {    
	                $userName=$_POST['userName'];   
	                $userEmail = $_POST['userEmail'];
	                $userContact=$_POST['userContact'];
			        $userPassword1 = $_POST['userPassword'];
			        $userPassword=$userPassword1;
			        // $token=$_POST['token'];
			        $checkemail=$this->checkAlreadyEmail($userEmail);
			        $checkphone=$this->checkAlreadyPhone($userContact);
			        if($checkemail==1 || $checkphone==1){
			        	if($checkemail==1){
			        		return 'emailPresent';
			        	}else{
			        		return 'phonePresent';
			        	}
			        	
			        }else{	
			        

	                $data=array(
			    		'userName'=> $userName,
			    		'userEmail'=>$userEmail,
			    		'userContact'=> $userContact,
			    		'userPassword'=> $userPassword,
			    		'token'=> '1',
			    		'isEmailVerify'=>'1'
					 );

	                $this->db->insert('userprofile', $data);
				    return ($this->db->affected_rows() != 1) ? false : true;
		              }
             	}//check

             	public function checkAlreadyEmail($email){
             		$this->db->where('userEmail',$email);
				    $query = $this->db->get('userprofile');
				    if ($query->num_rows() > 0){
				        return true;
				    }
				    else{
				        return false;
				    }
             	}//checkAlreadyEmail

             	public function checkAlreadyPhone($contact){
             		$this->db->where('userContact',$contact);
				    $query = $this->db->get('userprofile');
				    if ($query->num_rows() > 0){
				        return true;
				    }
				    else{
				        return false;
				    }
             	}//checkAlreadyEmail
             	
             	
             	public function getUserByMail($userEmail){
             		$this->db->where('userEmail',$userEmail);
				    $query = $this->db->get('userprofile');
				    return $query;
             	}//checkAlreadyEmail
             	
             	
             	public function GetPassword(){

                $userEmailNumber=$_POST['userEmailNumber'];
            		if(is_numeric($userEmailNumber)){
                            $query = $this->db->get_where('userprofile',array('userContact'=>$userEmailNumber));
            		}else{
            		    $query = $this->db->get_where('userprofile',array('userEmail'=>$userEmailNumber));
            		}
			   
				  return $query->result();
             	}//ForgotPassword
             	
              public function GetUserId(){

                $userEmailNumber=$_POST['userEmailNumber'];
            		if(is_numeric($userEmailNumber)){
                      $query = $this->db->get_where('userprofile',array('userContact'=>$userEmailNumber));
            		}else{
            			 $query = $this->db->get_where('userprofile',array('userEmail'=>$userEmailNumber));
            		}
			   
				  return $query->result();
             	}//GetUserI
             	
             	
             	 public function checkDuplicate(){

                $phone=$_POST['phone'];
                $email=$_POST['email'];
                $checkEmail=$this->checkAlreadyEmail($email);
                $checkPhone=$this->checkAlreadyPhone($phone);
	                if($checkEmail){
	                	return 'emailpresent';
	                
	                }
	                if($checkPhone){
	                 
	                 	return 'phonepresent';
	                 }
	             return 'new';  
                
             	}//checkDuplicate
             	
             	
             	public function IsertUserNote()
                {    
	                $note_user_id=$_POST['userId'];   
	                $note_type= $_POST['note_type'];
	                $note_message=$_POST['note_message'];
	                $note_vehicle_no=$_POST['vehicleId'];
	                $data=array('note_user_id'=> $note_user_id,
			    	    'note_type'=>$note_type,
			    	    'note_message'=> $note_message,
			    	    'note_vehicle_no'=> $note_vehicle_no
				   );
	                $this->db->insert('user_note', $data);
		        return ($this->db->affected_rows() != 1) ? false : true;		            
             	}//IsertUserNote
             	
        public function Fetch_UserNote()
	{ 	
	        $note_user_id=$_POST['userId'];  
	        $vehicleId=$_POST['vehicleId'];    	
		$this->db->select('*');
		$this->db->from('user_note un');
		$this->db->where('note_user_id',$note_user_id);	
		$this->db->where('note_vehicle_no',$vehicleId);	
		$query1 = $this->db->get();
		if($count = $query1->num_rows() > 0)
		{			
			return $query1->result_array();
		}
		else
		{
		        return 'false';
		}
								

        }//Fetch_Product_Details
             	


}//model
?>