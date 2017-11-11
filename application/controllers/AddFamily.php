<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AddFamily extends CI_Controller {

  public function LinkMember(){
    $final_data=array();
      $this->load->model('AddFamily_model');
          $data=$this->AddFamily_model->AddFamilyMember();
          if($data==='wrong'){
            $final_data['status']=member_not_present();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
          }else if($data==='alreadylinked'){
            $final_data['status']=member_linked_already();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
          }else if($data){
            $final_data['status']=member_added();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
          }else{
            $final_data['status']=failed();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));     
         }
         

  }//LinkMember
  
  public function FetchMember(){
    $final_data=array();
      $this->load->model('AddFamily_model');
          $data=$this->AddFamily_model->FetchMember();
          if($data->num_rows() > 0){
          foreach ($data->result() as $row) {
            $sortContacts=array(
                      'userId'=>$row->userId,
                      'userName'=>$row->userName,
                      'userEmail'=>$row->userEmail,
                      'userContact'=>$row->userContact
                       );
            $importantContacts[]=$sortContacts; 
            $final_data['status']=success_fetch();
            $final_data['data']=$importantContacts;
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
            
          }
          }else{
            $final_data['status']=nodata_fetch();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
          }
        
  }//FetchMember
  
  public function unlinkFamilyMember(){
          $this->load->model('AddFamily_model');
          $data=$this->AddFamily_model->unlinkFamilyMember();
          if($data){
              $final_data['status']=success_delete();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
          }else{
            
            $final_data['status']=failed();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
          }

  }//unlinkFamilyMember
  
  
}//AddFamily