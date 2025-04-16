<?php
// API access key from Google API's Console

function send_notification($title,$message,$topic){
	define( 'API_ACCESS_KEY', 'AAAAiH-V4_c:APA91bFuorzZ8Qukl2fM0Ikp2nQ074c3k1xxvN_S43ixaojHiDDT5fpFwovo3s9J7TWot6vYepsF52azFsbUiLTStR5ojDsztYWnfCotRO2ylqjaH6uuwBtPU6YOZ-elpHR3lTWH-U0t' );
	//$registrationIds = array( TOKENS );
	// prep the bundle
	$msg = array
	(
	    'body'  	=> $message,
	    'title'     => $title
	);

	$fields = array
	(
	    'to'  => '/topics/'.$topic,
	    'notification'          => $msg
	);

	$headers = array
	(
	    'Authorization: key=' . API_ACCESS_KEY,
	    'Content-Type: application/json'
	);

	$ch = curl_init();
	curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
	curl_setopt( $ch,CURLOPT_POST, true );
	curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	$result = curl_exec($ch );
	curl_close( $ch );
	//echo $result;
}

//send_notification("test from php","body from php","rules");
?>