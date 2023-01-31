<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendEmail($details) {
	$Mail = new PHPMailer(true);
	
	try {
	    //$Mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
	    $Mail->isSMTP();                                            //Send using SMTP
	    $Mail->Host       = 'smtp.gmail.com';                     	//Set the SMTP server to send through
	    $Mail->SMTPAuth   = true;                                   //Enable SMTP authentication
	    $Mail->Username   = $_ENV['GMAIL_USERNAME'];               //SMTP username
	    $Mail->Password   = $_ENV['GMAIL_PASS'];                   //SMTP password
	    $Mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
	    $Mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

	    //Recipients
	    $Mail->setFrom($_ENV['GMAIL_USERNAME'], 'QCU OCAD');
	    $Mail->addAddress($details['recipient'], $details['name']);     //Add a recipient
	    //$Mail->addReplyTo('info@example.com', 'Information');

	    //Content
	    $Mail->isHTML(true);                                  //Set email format to HTML
	    $Mail->Subject = 'Here is the subject';
	    $Mail->Body    = $details['message'];
	    $Mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	    $Mail->send();
	} catch (Exception $e) {
	    echo "Message could not be sent. Mailer Error: {$Mail->ErrorInfo}";
	}

} 


?>