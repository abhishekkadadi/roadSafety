<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Crons_model extends CI_Model {
	    public function SendServiceNotification()
	    { 
    		 $this->db->select('up.token, v.regNumber');
			 $this->db->from('userprofile as up');
			 $this->db->join('vehicle as v','v.userId=up.userId');
			 $this->db->where('v.nextService',date("Y-m-d"));
			 $query = $this->db->get();
			 return $query->result_array();
                
	    }//SendServiceNotification


	    public function getVehicles()
	    { 
	    	 $query=$this->db->get_where('vehicle',array('nextService'=>date("Y-m-d")));
			 return $query->result_array();   
	    }//UpdateNextServiceDate

	    public function updateServiceDate($nextdateofservice,$id)
	    { 
	    	//$escaped=$this->db->escape_str($storeDataForUpdate);
	    	 $this->db->where('vehicleId',$id);
	    	 $this->db->update('vehicle', $nextdateofservice);
	    	 return; 
	    	 //$this->db->update_batch('vehicle',$storeDataForUpdate,'vehicleId');
	    }//UpdateNextServiceDate
}
?>