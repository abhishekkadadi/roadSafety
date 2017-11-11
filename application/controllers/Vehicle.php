<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle extends CI_Controller {

  public function AddVehicle(){
     $this->load->model('Vehicle_model');
     $regVehicleType=$_POST['regVehicleType']; 
     $avgRunning=$_POST['avgRunning'];  
     //calculating next servicing date
     $monthsDays=30;//each month is considered of 30 days
     if($regVehicleType=='2 Wheeler'){
        $ThresholdValue=3000;//statically taken for 2 wheelers
        $DaysToNextService=($ThresholdValue/$avgRunning)*$monthsDays;
        $roundUpNumber=ceil($DaysToNextService);
        $NextDate=date('Y-m-d', strtotime("+$roundUpNumber days"));
     }else if($regVehicleType=='4 Wheeler'){
        $ThresholdValue=6000;//statically taken for 4 wheelers
        $DaysToNextService=($ThresholdValue/$avgRunning)*$monthsDays;
        $roundUpNumber=ceil($DaysToNextService);
        $NextDate=date('Y-m-d', strtotime("+$roundUpNumber days"));
     }else if($regVehicleType=='Heavy Vehicle'){
        $ThresholdValue=10000;//statically taken for heavy v
        $DaysToNextService=($ThresholdValue/$avgRunning)*$monthsDays;
        $roundUpNumber=ceil($DaysToNextService);
        $NextDate=date('Y-m-d', strtotime("+$roundUpNumber days"));
     }
//calculating next servicing date over

     $data=$this->Vehicle_model->AddVehicle($NextDate);
     if ($data==='alreadypresent'){
          $final_data['status']=vehicle_already_preset();
          $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
     }else if($data){
            $final_data['status']=vehicle_added();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
           $final_data['status']=failed();
           $this->output->set_content_type('application/json')->set_output(json_encode($final_data));    
    }
  }//Vehicle

  
  public function UpdateVehicle(){
     $this->load->model('Vehicle_model');
     $data=$this->Vehicle_model->UpdateVehicle();
     if ($data==='alreadypresent'){
          $final_data['status']=vehicle_already_preset();
          $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
     }else if($data){
            $final_data['status']=vehicle_updated();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
    }else{
           $final_data['status']=failed();
           $this->output->set_content_type('application/json')->set_output(json_encode($final_data));    
    }
  }//UpdateVehicle
  
 public function FetchVehicle(){
    $final_data=array();
      $this->load->model('Vehicle_model');
          $data=$this->Vehicle_model->FetchVehicle();
          if($data->num_rows() > 0){
          foreach ($data->result() as $row) {
            $sortContacts=array(
                      'vehicleId'=>$row->vehicleId,
                      'regDate'=>$row->regDate,
                      'regNumber'=>$row->regNumber,
                      'avgRunning'=>$row->avgRunning,
                      'regVehicleType'=>$row->regVehicleType,
                      'vehicleName'=>$row->vehicleName
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
        
  }//FetchVehicle
  
public function DeleteVehicle(){
      $this->load->model('Vehicle_model');
      $data=$this->Vehicle_model->DeleteVehicle();
      if($data){
            $final_data['status']=deleteData_successfully();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
      }else{
            $final_data['status']=failed();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
      }
  }//DeleteVehicle

}
?>