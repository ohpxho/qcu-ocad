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

	    // if(!empty($details['doc'])) {
	    // 	$dataurl = explode('data:application/pdf;filename=generated.pdf;base64,', $details['doc'])[1];
	    // 	$doc = base64_decode($dataurl);
	    // 	$Mail->addStringAttachment($doc, 'payslip.pdf');
	    // }

	    $Mail->isHTML(true);                       
	    $Mail->Subject = 'Notice';
	    $Mail->Body    = $details['message'];
	    $Mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	    $Mail->send();

	} catch (Exception $e) {

	    return "Message could not be sent. Mailer Error: {$Mail->ErrorInfo}";
	}

}

function formatEmailForDocumentRequest($details) {
	return "
		<div style='color: black; padding: 10px; width: 100% '>
			<p style=''>Hi, ".$details['name']."</p>
			<p style='margin-top: 10px'>".$details['message']."</p>
			<p style='margin-top: 10px'>Thank you!</p>
			
			<div style='color: black; margin-top: 30px;  line-height: 15px;'>
				Regards,<br/>
				Quezon City University<br/>
				QCU OCAD
			</div>

			<p style=margin-top: 10px>Please visit this link for more information: <a style='color: blue' href='".$details['link']."'>Link</a></p>
		</div>
	";
} 

function formatEmailForConsultation($details) {
	return "
		<div style='color: black; padding: 10px; width: 100% '>
			<p style=''>Hi, ".$details['name']."</p>
			<p style='margin-top: 10px'>".$details['message']."</p>
			<p style='margin-top: 10px'>Thank you!</p>
			
			<div style='color: black; margin-top: 30px;  line-height: 15px;'>
				Regards,<br/>
				Quezon City University<br/>
				QCU OCAD
			</div>

			<p style=margin-top: 10px>Please visit this link for more information: <a style='color: blue' href='".$details['link']."'>Link</a></p>
		</div>
	";
} 

function formatEmailForForgotPassword($details) {

} 

function formatEmailForAccountConfirmation($details) {
	return "
		<div style='color: black; padding: 10px; width: 100% '>
			<p style=''>Hi, ".$details['name']."</p>
			<p style='margin-top: 10px'>This is from <a href='http://qcuocad.online/'>QCU-OCAD</a>. We are reaching out to inform you that an account has been created for you. Your password is: ".$details['message']."</p>
			<p style='margin-top: 10px'>Please click on the confirmation link provided below to activate your account</p>

			<p style='margin-top: 10px'>Thank you!</p><br/>
			
			<a href='".$details['link']."' style='margin-top: 15px; background-color: green; color: white; padding: 10px 30px'>Confirm Account</a>

			<div style='color: black; margin-top: 30px;  line-height: 15px;'>
				Regards,<br/>
				Quezon City University<br/>
				QCU OCAD
			</div>
		</div>
	";
}

?>