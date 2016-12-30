<?php

// Put your device token here (without spaces):
//$deviceToken = '626e4c17c7883a3511a511276299131cf4f278876003b472c43198094b5b384e';
//$deviceToken = '38893243cc2daf82c7a4ec969b9ab03dece632b3e6f32c3f1fd84018255596dd';
$deviceToken = '38893243cc2daf82c7a4ec969b9ab03dece632b3e6f32c3f1fd84018255596dd';

// Put your private key's passphrase here:
$passphrase = 'd1str1qt';

// Put your alert message here:
$message = 'Notificação the test message';

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
$body['aps'] = array(
	'alert' => $message,
	'badge' => 0,
	'sound' => 'fx05.caf'
	);

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
