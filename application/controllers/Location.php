<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends CI_Controller {

  /*public function AddLocationDetails(){
  	$userId=$_POST['userId'];
  	$this->load->model('Location_model');
        $data=$this->Location_model->AddLocationDetails();
        //After Update
        $speed=$_POST['speed'];
       
        $final_data['status']=updated_success();	
        $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
	 $this->load->model('Panic_model');
  }//AddLocationDetails*/
  
  public function AddLocationDetails() {
        $userId = $_POST['userId'];
        $this->load->model('Location_model');
        $this->load->model('Panic_model');
        $data = $this->Location_model->AddLocationDetails();
        //After Update
        $speed = $_POST['speed'];
        if ($speed > 100) {
            $FamilyMobileNumbers = $this->Panic_model->getFamilyMobileNumbers();
            $userName = $this->Panic_model->getUserDetails();



            foreach ($userName as $key1) {
                $FinalUserName = $key1['userName'];
            }

            $data = 'null';
            $message = Speed_message($FinalUserName);
            //$notify=push_notify($tokens,$message,$data);
            foreach ($FamilyMobileNumbers as $MobileNumbers) {
                if ($MobileNumbers) {
                    $xml_data = '<?xml version="1.0"?>
				<parent>
				<child>
				<user>safety12</user>
				<key>bd8ce243dbXX</key>
				<mobile>' . $MobileNumbers['userContact'] . '</mobile>
				<message>' . $FinalUserName . ' driving rash and exceed his vehicle speed over 100 km/hr</message>
				<senderid>SAFETY</senderid>
				<accusage>1</accusage>
				</child>
				</parent>';

                    $URL = "http://sms.whitesms.in/submitsms.jsp?";

                    $ch = curl_init($URL);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $output = curl_exec($ch);
                    curl_close($ch);
                }
            }
            $final_data['status'] = updated_success();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
        } else {
            $final_data['status'] = updated_success();
            $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
        }
    }
  
  public function SendLocationDetails(){
    $userId=$_POST['userId'];
    $this->load->model('Location_model');
    $data1=$this->Location_model->sendChildrenData($userId);
    $data2=$this->Location_model->yourLocation($userId);
    // want child location so no if else
   $final_data['status']=updated_success();
   $final_data['yourLocation']=$data2;
   $final_data['memberLocation']=$data1;
   $this->output->set_content_type('application/json')->set_output(json_encode($final_data));
  }//SendLocationDetails



}
?>