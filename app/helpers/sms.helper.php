<?php

use Twilio\Rest\Client;

function sendSMS($to, $message) {
	$SID = $_ENV['TWILIO_ACCOUNT_SID'];
	$TOKEN = $_ENV['TWILIO_AUTH_TOKEN'];
	$Twilio = new Client($SID, $TOKEN);
	$to = '+63'.substr($to, 1);

	$message = $Twilio->messages->create($to, ['body' => $message, 'from' => $_ENV['TWILIO_ACCOUNT_NUMBER']]);
}

?>