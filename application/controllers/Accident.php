<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accident extends CI_Controller {

  public function AddAccident(){
    $allTokens=array();
    $accidentLat=$_POST['accidentLat'];
    $accidentLong=$_POST['accidentLong'];
  	$this->load->model('Accident_model');
    $data=$this->Accident_model->addAccidentData();
    if($data==='uploadfail'){
            $final_data['status']=upload_failed();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
          }else if($data){
          $data2=$this->Accident_model->getIds($accidentLat,$accidentLong);//ids within 100km
          foreach ($data2->result() as $key) {
              $userIds[]=$key->userId;
          }
          if(!empty($userIds)){
             $result = implode(",",$userIds);
             $data3=$this->Accident_model->getTokens($result);//get tokens for push 
                 foreach ($data3 as $key) {
                     if(!empty($key['token'])){
                          $allTokens[]=$key['token'];
                         
                     }                  
                 }
            if(!empty($allTokens)){
            
                $message=accident_nearBy();
                $notify=push_notify($allTokens,$message,$data);
            }
             
          }
             $final_data['status']=success_uploaded();
             $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
          }else{
            $final_data['status']=failed();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));     
         }
    }//AddAccident
    
 public function FetchAccidents(){

        $this->load->model('Accident_model');
        $result=$this->Accident_model->FetchAccidents(); 
        if($result){
                        $final_data['status']=success_fetch();
                        $without_url=array();
                        
                        $only_url2=array();
                        $array_merge=array();
                        foreach ($result as $key) {
                           $only_url=array();
                           $final_url=array();
                           $accidentId=$key['accidentId'];
                           $accidentTitle=$key['accidentTitle'];
                           $accidentDescription=$key['accidentDescription'];
                           $accidentLat=$key['accidentLat'];
                           $accidentLong=$key['accidentLong'];
                           $postedBy=$key['postedBy'];
                           $timeStamp=$key['timeStamp'];
                           $userName=$key['userName'];
                           $reportType=$key['reportType'];
                           $url1=$key['url1'];
                           $url2=$key['url2'];
                           $url3=$key['url3'];
                           $url4=$key['url4'];
                           $without_url=array('accidentId'=>$accidentId,'accidentTitle'=>$accidentTitle,'accidentDescription'=>$accidentDescription,'accidentLat'=>$accidentLat,'accidentLong'=>$accidentLong,'postedBy'=>$postedBy,'timeStamp'=>$timeStamp,'userName'=>$userName,'reportType'=>$reportType);
                           if(!empty($url1)){
                             $only_url[]=array('images'=>$url1);
  
                            }
                            if(!empty($url2)){
                           $only_url[]=array('images'=>$url2);
                        
                            }
                            if(!empty($url3)){
                           $only_url[]=array('images'=>$url3);
                            }
                            if(!empty($url4)){
                            $only_url[]=array('images'=>$url4);
                            }
                           $final_url['image']=$only_url;
                           $array_merge[]=array_merge($without_url,$final_url);
                           unset($only_url);
                        }
                            $final_data['data']= $array_merge;
                            
                        $this->output->set_content_type('application/json')->set_output(json_encode($final_data));      
        }else{
                        $final_data['status']=nodata_fetch();
                        $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
            }

    }//FetchComplaints
    
public function FetchIndividualAccident(){

        $this->load->model('Accident_model');
        $result=$this->Accident_model->FetchIndividualAccident(); 
        if($result){
                        $final_data['status']=success_fetch();
                       
                        $without_url=array();
                        
                        $only_url2=array();
                        $array_merge=array();
                        foreach ($result as $key) {
                            $only_url=array();
                           $final_url=array();
                           $accidentId=$key['accidentId'];
                           $accidentTitle=$key['accidentTitle'];
                           $accidentDescription=$key['accidentDescription'];
                           $accidentLat=$key['accidentLat'];
                           $accidentLong=$key['accidentLong'];
                           $postedBy=$key['postedBy'];
                           $timeStamp=$key['timeStamp'];
                           $userName=$key['userName'];
                           $reportType=$key['reportType'];
                           $url1=$key['url1'];
                           $url2=$key['url2'];
                           $url3=$key['url3'];
                           $url4=$key['url4'];
                           $without_url=array('accidentId'=>$accidentId,'accidentTitle'=>$accidentTitle,'accidentDescription'=>$accidentDescription,'accidentLat'=>$accidentLat,'accidentLong'=>$accidentLong,'postedBy'=>$postedBy,'timeStamp'=>$timeStamp,'userName'=>$userName,'reportType'=>$reportType);
                           if(!empty($url1)){
                             $only_url[]=array('images'=>$url1);
  
                            }
                            if(!empty($url2)){
                           $only_url[]=array('images'=>$url2);
                        
                            }
                            if(!empty($url3)){
                           $only_url[]=array('images'=>$url3);
                            }
                            if(!empty($url4)){
                            $only_url[]=array('images'=>$url4);
                            }
                           $final_url['image']=$only_url;
                           $array_merge[]=array_merge($without_url,$final_url);
                           unset($only_url);
                        }
                            $final_data['data']= $array_merge;
                        $this->output->set_content_type('application/json')->set_output(json_encode($final_data));      
        }else{
                        $final_data['status']=nodata_fetch();
                        $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
            }

    }//FetchIndividualAccident
    
}//Accident