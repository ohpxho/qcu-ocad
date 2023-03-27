<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendEmail($details) {
	$Mail = new PHPMailer(true);
	
	try {
	  
	    $Mail->isSMTP();                                            
	    $Mail->Host       = 'smtp.gmail.com';                     	
	    $Mail->SMTPAuth   = true;                                   
	    $Mail->Username   = $_ENV['GMAIL_USERNAME'];               
	    $Mail->Password   = $_ENV['GMAIL_PASS'];                   
	    $Mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
	    $Mail->Port       = 465;                                    

	    $Mail->setFrom($_ENV['GMAIL_USERNAME'], 'QCU OCAD');
	    $Mail->addAddress($details['recipient'], $details['name']);  

	    if(!empty($details['doc'])) {
	    	$dataurl = explode('data:application/pdf;filename=generated.pdf;base64,', $details['doc'])[1];
	    	$doc = base64_decode($dataurl);
	    	$Mail->addStringAttachment($doc, 'payslip.pdf');
	    }

	    $Mail->isHTML(true);                       
	    $Mail->Subject = 'Notice';
	    $Mail->Body    = $details['message'];
	    $Mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	    $Mail->send();

	} catch (Exception $e) {

	    return "Message could not be sent. Mailer Error: {$Mail->ErrorInfo}";
	}

} 

?>