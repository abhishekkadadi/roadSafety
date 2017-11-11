<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

 function push_notify($managers,$message,$data){
		
// API access key from Google API's Console
   if(!defined('API_ACCESS_KEY')){
    define( 'API_ACCESS_KEY', 'AAAA-MTcD8Y:APA91bGghl0fjmFSLMksY2f5TqZOwlh3anmB7qztESEmJZCLxpwLIrSC-h6vWqS258TL7QsLXH-OJzgSXVUMdkW_B0q0wkr05ZY3h06Exnofo9H-ByGJNjl4ZRhqJ23gZLqWWGIqwvGL' );
}

$registrationIds =$managers;
// prep the bundle
$msg = array
(
    'message'   => $message,
    'title'     => '',
    'accidentId'  => $data,//this is accident inserted id
    'tickerText' => '',
    'vibrate'   => 1,
    'sound'     => 1,
    'largeIcon' => 'large_icon',
    'smallIcon' => 'small_icon'
);
$fields = array
(
    'registration_ids'  => $registrationIds,
    'data'          => $msg
);
 
$headers = array
(
    'Authorization: key=' . API_ACCESS_KEY,
    'Content-Type: application/json'
);
 
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );
return;
//print_r($msg);
}