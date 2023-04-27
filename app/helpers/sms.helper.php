<?php

// use Twilio\Rest\Client;

// function sendSMS($sms) {
// 	$SID = $_ENV['TWILIO_ACCOUNT_SID'];
// 	$TOKEN = $_ENV['TWILIO_AUTH_TOKEN'];
// 	$Twilio = new Client($SID, $TOKEN);
// 	$to = '+63'.substr($sms['to'], 1);

// 	$message = $Twilio->messages->create($to, ['body' => $sms['message'], 'from' => $_ENV['TWILIO_ACCOUNT_NUMBER']]);
// }

function sendSMS($sms) {
	
	// $basic  = new \Vonage\Client\Credentials\Basic("759b0800", "9DNZRZxP7jIlWah7");
	// $client = new \Vonage\Client($basic);

	// $to = '63'.substr($sms['to'], 1);

	// $response = $client->sms()->send(
	//     new \Vonage\SMS\Message\SMS($to, 'QCU OCAD', $sms['message'])
	// );

	// $message = $response->current();

	// if ($message->getStatus() == 0) {
	//     echo "The message was sent successfully\n";
	// } else {
	//     echo "The message failed with status: " . $message->getStatus() . "\n";
	// }

}


?>