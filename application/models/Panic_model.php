<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Panic_model extends CI_Model {
	    
          public function getFamilyToken()
	    {     
	    	        $userId=$_POST['userId'];
					$this->db->select('up.token');
					$this->db->from('userprofile as up');
					$this->db->join('memberlink as ml', 'ml.childId = up.userId');
					$this->db->where('ml.parentId',$userId);
					$query = $this->db->get()->result_array();
					return $query;
					

	    }//AddLocationDetails
	    
	     public function getFamilyMobileNumbers()
	    {     
	    	        $userId=$_POST['userId'];
					$this->db->select('up.userContact');
					$this->db->from('userprofile as up');
					$this->db->join('memberlink as ml', 'ml.childId = up.userId');
					$this->db->where('ml.parentId',$userId);
					$query = $this->db->get()->result_array();
					return $query;
					

	    }//AddLocationDetails
	    
	     public function getFamilyEmailId()
	    {     
	    	        $userId=$_POST['userId'];
					$this->db->select('up.userEmail,up.userName');
					$this->db->from('userprofile as up');
					$this->db->join('memberlink as ml', 'ml.childId = up.userId');
					$this->db->where('ml.parentId',$userId);
					$query = $this->db->get()->result_array();
					return $query;
					

	    }
	    
	    public function getUserDetails()
	    {     
	    	                        $userId=$_POST['userId'];
					$this->db->select('up.userName');
					$this->db->from('userprofile as up');					
					$this->db->where('up.userId',$userId);
					$query = $this->db->get()->result_array();
					return $query;
					

	    }//AddLocationDetails
}
?>