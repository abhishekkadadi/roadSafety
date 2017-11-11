<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crons extends CI_Controller {

public function SendServiceNotification(){
	
		 $this->load->model('Crons_model');
		 $data=$this->Crons_model->SendServiceNotification();
		 if(!empty($data))
		  foreach ($data as $key) {
		  			$tokens=array();
		  	 		$data='null';
		  	 		$tokens[]=$key['token'];//sending single tokens
	                $message=vehicle_service($key['regNumber']);
				    $notify=push_notify($tokens,$message,$data);
	          }
			      
}//SendServiceNotification

public function UpdateNextServiceDate(){
	
		 $this->load->model('Crons_model');
		 $data=$this->Crons_model->getVehicles();
		 $Ids=array();//for bacth update
		 if($data){
		 	foreach ($data as $key) {
		 		$avgRunning=$key['avgRunning'];
		 		$monthsDays=30;
		 		if($key['regVehicleType']=='2 Wheeler'){
		 			 	$ThresholdValue=3000;//statically taken for 2 wheelers
				        $DaysToNextService=($ThresholdValue/$avgRunning)*$monthsDays;
				        $roundUpNumber=ceil($DaysToNextService);
				        $NextDate=date('Y-m-d', strtotime("+$roundUpNumber days"));
				        //$storeDataForUpdate[]=array('vehicleId'=>$key['vehicleId'],'nextService'=>$NextDate);
		 		}else if($key['regVehicleType']=='4 Wheeler'){
		 				$ThresholdValue=6000;//statically taken for 4 wheelers
				        $DaysToNextService=($ThresholdValue/$avgRunning)*$monthsDays;
				        $roundUpNumber=ceil($DaysToNextService);
				        $NextDate=date('Y-m-d', strtotime("+$roundUpNumber days"));
				       // $storeDataForUpdate[]=array('vehicleId'=>$key['vehicleId'],'nextService'=>$NextDate);
		 		}else if($key['regVehicleType']=='Heavy Vehicle'){
		 				$ThresholdValue=10000;//statically taken for heavy v
				        $DaysToNextService=($ThresholdValue/$avgRunning)*$monthsDays;
				        $roundUpNumber=ceil($DaysToNextService);
				        $NextDate=date('Y-m-d', strtotime("+$roundUpNumber days"));
				        
		 		}
		 		$nextdateofservice=array('nextService'=>$NextDate);
		 	    $this->Crons_model->updateServiceDate($nextdateofservice,$key['vehicleId']);//code igniter batchupdate bug open so not working
		 	}

		 		//$this->Crons_model->updateServiceDate($Ids);
		 		//print_r($storeDataForUpdate);
		 }
		
			      
}//SendServiceNotification

}



?>