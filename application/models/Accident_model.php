<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Accident_model extends CI_Model {
	    public function addAccidentData()
	    {        
	    	
	    	 $accidentTitle=$_POST['accidentTitle'];
			 $accidentDescription=$_POST['accidentDescription'];
			 $accidentLat=$_POST['accidentLat'];
			 $accidentLong=$_POST['accidentLong'];
			 $postedBy=$_POST['postedBy'];
			 $reportType=$_POST['reportType'];

				  if(isset($_FILES['url1'])){

				  		if(!empty($_FILES['url1'])){

				  			$url1="url1";
				  		    $path1=$this->do_upload($url1); 
				  		     
				  		}
				    }

				  if(isset($_FILES['url2'])){
				  		if(!empty($_FILES['url2'])){
				  			$url2="url2";
				  		    $path2=$this->do_upload($url2);   
				  		}
				    }

				  if(isset($_FILES['url3'])){
				  		if(!empty($_FILES['url3'])){
				  			$url3="url3";
				  		    $path3=$this->do_upload($url3); 
				  		}  
				  	}   

				  if(isset($_FILES['url4'])){
				  		if(!empty($_FILES['url4'])){
				  			$url4="url4";
				  		    $path4=$this->do_upload($url4);
				  		}   
				  	}
			$data=array(
				    		'accidentTitle'=> $accidentTitle,
				    		'accidentDescription'=>$accidentDescription,
				    		'postedBy'=> $postedBy,
				    		'accidentLat'=> $accidentLat,
				    		'accidentLong'=> $accidentLong,
				    		'reportType'=>$reportType
    					);

    				if(isset($path1)){
    					if($path1=='0'){return "uploadfail";}
    					else{$data['url1']=base_url("/accident_pic/$path1");}
    				}
    				if(isset($path2)){
    					if($path2=='0'){return "uploadfail";}
    					else{$data['url2']=base_url("/accident_pic/$path2");}
    				}
    				if(isset($path3)){
    					if($path3=='0'){return "uploadfail";}
    					else{$data['url3']=base_url("/accident_pic/$path3");}					
    				}
    				if(isset($path4)){
    					if($path4=='0'){return "uploadfail";}
    					else{$data['url4']=base_url("/accident_pic/$path4");}
    				}	
				    $this->db->insert('accidentinformation', $data);

				    $insert_id = $this->db->insert_id();

				    //return ($this->db->affected_rows() != 1) ? false : true;
				     return $insert_id;
		}//addaccident


		  public function do_upload($url)
        {
                $config['upload_path']          = './accident_pic/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 100000;
                $config['max_width']            = 2048;
                $config['max_height']           = 2048;
                $this->load->library('upload', $config);
                $new_name = uniqid().$_FILES[$url]['name'];
				$config['file_name'] = $new_name;
                if (!$this->upload->do_upload($url))
                {      

                        $error = array('error' => $this->upload->display_errors());
                        //print_r($error);
                        return '0';
                        //$this->load->view('upload_form', $error);
                }
                else
                {       echo "string";
                        $data = array('upload_data' => $this->upload->data());
                        return $data['upload_data']['file_name'];
                       //print_r($data);
                }
               
        }//do_upload
        
         public function FetchAccidents(){
 						$limitNumber=$_POST['limitNumber'];
						$start=10 * $limitNumber;
						$this->db->select('ai.*,up.userName');
						$this->db->from('accidentinformation as ai');
						$this->db->limit(10,$start);
						$this->db->join('userprofile as up', 'up.userId = ai.postedBy');
						$this->db->order_by('accidentId', 'desc');
						$query = $this->db->get()->result_array();
						return $query;
		}//FetchAccidents
		
	public function FetchIndividualAccident(){
         $accidentId=$_POST['accidentId'];					
		 //$query=$this->db->get_where('accidentinformation',array('accidentId'=>$accidentId));

				$this->db->select('ai.*,up.userName');
				$this->db->from('accidentinformation as ai');
		        $this->db->where('ai.accidentId',$accidentId);
				$this->db->join('userprofile as up', 'up.userId = ai.postedBy');
				$query = $this->db->get()->result_array();
		 		return $query;
		}//FetchIndividualAccident
		
		
	public function getIds($my_latitude,$my_longitude){// fetch tokens of people within 50 km radius of accident
        $search_radius=50;
	 	$query = $this->db->query("SELECT *,(((acos(sin((".$my_latitude."*pi()/180)) * sin((`latitude`*pi()/180))+cos((".$my_latitude."*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((".$my_longitude."-`longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344) as distance FROM location having distance<=".$search_radius."");
	 	return $query;
        }//getIds
        
        public function getTokens($userIds)
                {       
                	 $user_ids= explode(',', $userIds);
                     //$user_ids= explode(',', $userIds);
            		 $this->db->select('up.token');
					 $this->db->from('userprofile as up');
					 $this->db->where_in('up.userId',$user_ids);
					 $query = $this->db->get();
					 return $query->result_array();
                }//getTokens
}
?>