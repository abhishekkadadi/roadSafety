<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

 function accident_nearBy(){

							$message="New notice from nearby location.";
							return $message;
}

function Distress_message($userName){

							$message="$userName needs your help urgently.";
							return $message;
}

function Speed_message($userName){

							$message="$userName need to worn. it's cross the speed limit";
							return $message;
}

function vehicle_service($userName){

							$message="Your Vehicle $userName service due";
							return $message;
}



?>