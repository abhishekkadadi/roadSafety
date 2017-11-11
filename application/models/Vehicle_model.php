<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Vehicle_model extends CI_Model {
    
   public function AddVehicle($NextDate)
    {        
	    $regDate = $_POST['regDate'];
	    $regNumber = $_POST['regNumber'];
	    $avgRunning=$_POST['avgRunning'];  
	    $regVehicleType=$_POST['regVehicleType']; 
	    $userId=$_POST['userId'];
	    $vehicleName=$_POST['vehicleName'];
		$newDate = date("Y-m-d", strtotime($regDate));
		$query = $this->db->get_where('vehicle',array('regNumber'=>$regNumber));
		$count = $query->num_rows() > 0;
		if(!$count>0){
	        $data=array(
	        	'userId'=>$userId,
	    		'regDate'=> $newDate,
	    		'regNumber'=>$regNumber,
	    		'avgRunning'=> $avgRunning,
	    		'regVehicleType'=> $regVehicleType,
	    		'vehicleName'=>$vehicleName,
	    		'nextService'=>$NextDate
			 );

         $this->db->insert('vehicle', $data);
         return ($this->db->affected_rows() != 1) ? false : true;
        }else{
        	return "alreadypresent";
        }
	    
    }//AddVehiclee
    
    
   public function UpdateVehicle()
    {        
	    $regDate = $_POST['regDate'];
	    $regNumber = $_POST['regNumber'];
	    $avgRunning=$_POST['avgRunning'];  
	    $regVehicleType=$_POST['regVehicleType']; 
	    $userId=$_POST['userId'];
	    $vehicleName=$_POST['vehicleName'];
	    $vehicleId=$_POST['vehicleId'];
		$newDate = date("Y-m-d", strtotime($regDate));
		$query = $this->db->get_where('vehicle',array('regNumber'=>$regNumber));
		$count = $query->num_rows() > 0;
		
		foreach ($query->result() as $key) {
			$userIdcheck=$key->userId;
		}
		 if($userIdcheck!=$userId){
		 	return 'alreadypresent';
		 }
	
	        $data=array(
	            'regDate'=> $newDate,
	    		'regNumber'=>$regNumber,
	    		'avgRunning'=> $avgRunning,
	    		'regVehicleType'=> $regVehicleType,
	    		'vehicleName'=>$vehicleName
			);
	 $this->db->where('vehicleId', $vehicleId);
         $this->db->update('vehicle', $data);
         return ($this->db->affected_rows() != 1) ? false : true;    
    }//UpdateVehicle
    
  public function FetchVehicle()
	    {        
	                     $userId=$_POST['userId'];
                	     $query=$this->db->get_where('vehicle',array('userId'=>$userId));
                         return $query;
		 }//FetchVehicle


public function DeleteVehicle()
	    {        		 

	    			$vehicleId=$_POST['vehicleId'];
    	  			$this->db->where('vehicleId', $vehicleId);
					$this->db->delete('vehicle');
	                return ($this->db->affected_rows() != 1) ? false : true;         
                	     
		 }//DeleteVehicle
}
?>