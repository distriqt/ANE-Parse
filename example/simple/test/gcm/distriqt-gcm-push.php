<?php

/**
 * This is a test script to send a message to an GCM Android device, i.e. an Android device using Google Cloud Messaging. 
 * 
 * To use this script you need to set the following pieces of information
 *  - device registration id
 *  - api key (this is the browser API key)
 * 
 * The message you send is up to you to format and process. If you want to use the built in notification area icon you'll need
 *  to supply at a minimum the "tickerText" and "contentTitle" value which is used to place text in the notification bar 
 *  and area respectively.
 *  
 * Content title and text are placed in the notification area, whereas message is an example parameter that is passed 
 * 	through to your application.
 *
 *  - message
 *  - ticker text
 *  - content title
 *  - content text
 *
 * Then run it using php: 
 * <code> php simplepush.php </code> 
 *
 */

// Message to send
$message      = "çãö the test message";
$tickerText   = "çãö ticker text message";
$contentTitle = "çãö content title";
$contentText  = "çãö content body";

// Put your device token here (without spaces):
$registrationId = 'APA91bHa976w5RcNOdWAz3HRcFam_Dg-NRqo_pUagabBnk8cTYXapgeP44It8bMg5CbKpyd9oaqcaPu2knQYAmRwjRmpXcmRTmx10UA-eKf25JQESKOpLb1-VuDgDaZbyL57LVJAPExfu6NUkIe9HfSnxLw2RHkx-nmQud1VajJdOdSPF3r6GrA';

// GCM API Key
$apiKey = "AIzaSyCyF0ncL8wayv2qunagHXEyJi0kxwRRKg4";


$response = sendNotification( 
	$apiKey, 
	array($registrationId), 
	array(
		'id' => 2,
		'message' => $message, 
		'tickerText' => $tickerText, 
		'contentTitle' => $contentTitle, 
		"contentText" => $contentText,
		'sound' => 'default',
		'vibrate' => 'true'
		
		) );

echo $response;
echo "\ncomplete...\n";





////////////////////////////////////////////////////////////////////////////////
//	
//

/**
 * The following function will send a GCM notification using curl.
 * 
 * @param $apiKey				[string] 	The Browser API key string for your GCM account
 * @param $registrationIdsArray [array] 	An array of registration ids to send this notification to
 * @param $messageData			[array]		An named array of data to send as the notification payload
 */
function sendNotification( $apiKey, $registrationIdsArray, $messageData )
{
    print_r($messageData);
	print_r($registrationIdsArray);

    $headers = array("Content-Type:" . "application/json", "Authorization:" . "key=" . $apiKey);
    $data = array(
        'data' => $messageData,
        'registration_ids' => $registrationIdsArray
    );

    $ch = curl_init();

    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers ); 
    curl_setopt( $ch, CURLOPT_URL, "https://android.googleapis.com/gcm/send" );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($data) );

    $response = curl_exec($ch);
    curl_close($ch);

//     error_log(json_encode($data));
//     error_log($response);
    
    return $response;
}

