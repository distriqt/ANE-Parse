<?php

// Put your device token here (without spaces):
//$deviceToken = '626e4c17c7883a3511a511276299131cf4f278876003b472c43198094b5b384e';
$deviceToken = '7d59640b5d9a5ef59fd23a6a4de11f805fa60e39e64a180ec6627e1938451c0e';
// Put your private key's passphrase here:
$passphrase = 'd1str1qt';

// Put your alert message here:
$message = 'the test message';

////////////////////////////////////////////////////////////////////////////////

$ctx = stream_context_create();
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

// Open a connection to the APNS server
$fp = stream_socket_client(
	'ssl://gateway.sandbox.push.apple.com:2195', $err,
	$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS' . PHP_EOL;

// Create the payload body
$body = array(
	'aps' => array(
		'alert' => $message,
		'badge' => 5,
		'sound' => 'default'
		),
	'test' => array( 'testing' => 'additional' )
	);
//$body['test'] = array( 'testing' => 'additional' );

// Encode the payload as JSON
$payload = json_encode($body);

// Build the binary notification
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
$result = fwrite($fp, $msg, strlen($msg));

if (!$result)
	echo 'Message not delivered' . PHP_EOL;
else
	echo 'Message successfully delivered' . PHP_EOL;

// Close the connection to the server
fclose($fp);
