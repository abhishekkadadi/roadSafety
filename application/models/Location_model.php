<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Location_model extends CI_Model {

	    public function AddLocationDetails()
	    {   
	    	       $userId=$_POST['userId'];
	    	       $latitude=$_POST['latitude'];
	    	       $longitude=$_POST['longitude'];
	    	       $speed=$_POST['speed'];
					$this->db->where('userId',$userId);
					$q = $this->db->get('location');
					$updateLocation=array(
			   						  'latitude'=>$latitude,
			   						  'longitude'=>$longitude,
			   						  'speed'=>$speed,
			   						  'userId'=>$userId);           
					if ( $q->num_rows() > 0 ){
							$this->db->where('userId',$userId);
							$this->db->update('location',$updateLocation);

					}else{
						  $this->db->insert('location',$updateLocation);	
					}
					return ($this->db->affected_rows() != 1) ? false : true;
					

	    }//AddLocationDetails


	    public function sendChildrenData($userId)
	    {     
					$this->db->select('ml.*,up.userName,l.*');
					$this->db->from('memberlink as ml');
					$this->db->join('userprofile as up', 'up.userId = ml.childId');
					$this->db->join('location as l', 'l.userId = ml.childId');
					$this->db->where('ml.parentId',$userId);
					$query = $this->db->get()->result_array();
					return $query;
					

	    }//AddLocationDetails
	    
	    
	      public function yourLocation($userId)
	    {     $query=$this->db->get_where('location',array('userId'=>$userId));
			  return $query->result_array();
					

	    }//AddLocationDetails



}
?>