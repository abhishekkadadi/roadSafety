<?php if(!defined('BASEPATH')) exit('No direct script access allowed');





 function successful_register(){
 				 $success=1;
				 $message=array('status'=>$success,'message'=>'Successfully registered');
                 return $message;
}

 function email_present(){
 				$alreadyPresentEmail=2;
				$message=array('status'=>$alreadyPresentEmail,'message'=>'Email is already registered');
     			return $message;
}

function phone_present(){
 				$alreadyPresentPhone=3;
				$message=array('status'=>$alreadyPresentPhone,'message'=>'Phone number is already registered');
     			return $message;
}

function failed(){
				$failed=0;
				$message=array('status'=>$failed,'message'=>'Oops! Something went wrong');
     			return $message;
}



function wrong_credential(){

				$failed=-1;
				$message=array('status'=>$failed,'message'=>'Wrong credentials');
				return $message;
}

function successful_login(){

				$success=1;
				$message=array('status'=>$success,'message'=>'Successful login');
				return $message;
}

function not_verify(){
				$notverify=2;
				$message=array('status'=>$notverify,'message'=>'Email not verified');
				return $message;
}

function member_not_present(){
				$notverify=-1;
				$message=array('status'=>$notverify,'message'=>'Member You trying to add is not registered with Road Safety App');
				return $message;
}

function member_linked_already(){
				$notverify=2;
				$message=array('status'=>$notverify,'message'=>'Member You trying to add is already linked with you');
				return $message;
}

function member_added(){
				$notverify=1;
				$message=array('status'=>$notverify,'message'=>'Member successfully linked with your device');
				return $message;
}

function upload_failed(){
				$notverify=-1;
				$message=array('status'=>$notverify,'message'=>'Failed to upload files');
				return $message;
}

function success_uploaded(){
				$notverify=1;
				$message=array('status'=>$notverify,'message'=>'Data inserted successfuly');
				return $message;
}

function success_fetch(){
				$notverify=1;
				$message=array('status'=>$notverify,'message'=>'Data successfully fetched');
				return $message;
}

function nodata_fetch(){
				$notverify=0;
				$message=array('status'=>$notverify,'message'=>'No data available to fetch');
				return $message;
}

function vehicle_added(){
				$notverify=1;
				$message=array('status'=>$notverify,'message'=>'Vehicle added successfully');
				return $message;
}

function vehicle_already_preset(){
				$notverify=2;
				$message=array('status'=>$notverify,'message'=>'Vehicle already present');
				return $message;
}


function vehicle_updated(){
				$notverify=1;
				$message=array('status'=>$notverify,'message'=>'Vehicle information updated successfully');
				return $message;
}

function deleteData_successfully(){
				$notverify=1;
				$message=array('status'=>$notverify,'message'=>'Successfully deleted');
				return $message;
}

function updated_success(){
				$notverify=1;
				$message=array('status'=>$notverify,'message'=>'Data updated successfully');
				return $message;
}

function panic_success(){
				$notverify=1;
				$message=array('status'=>$notverify,'message'=>'Panic alert sent');
				return $message;
}

function mail_sent(){
				$notverify=1;
				$message=array('status'=>$notverify,'message'=>'Your password sent successfully.');
				return $message;
}

function mail_failed(){
				$notverify=-1;
				$message=array('status'=>$notverify,'message'=>'Something went wrong try again later');
				return $message;
}


function success_delete(){
				$notverify=1;
				$message=array('status'=>$notverify,'message'=>'Data deleted successfully');
				return $message;
}
?>