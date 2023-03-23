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
	    $Mail->addAttachment('data:application/pdf;base64,JVBERi0xLjMKMyAwIG9iago8PC9UeXBlIC9QYWdlCi9QYXJlbnQgMSAwIFIKL1Jlc291cmNlcyAyIDAgUgovTWVkaWFCb3ggWzAgMCA1OTUuMjggODQxLjg5XQovQ29udGVudHMgNCAwIFI+PgplbmRvYmoKNCAwIG9iago8PC9MZW5ndGggNzM+PgpzdHJlYW0KMC41NyB3CjAgRwpCVAovRjEgMTYgVGYKMTguNCBUTAowIGcKMjguMzUgODEzLjU0IFRkCihIZWxsbywgV29ybGQhKSBUagpFVAplbmRzdHJlYW0KZW5kb2JqCjEgMCBvYmoKPDwvVHlwZSAvUGFnZXMKL0tpZHMgWzMgMCBSIF0KL0NvdW50IDEKPj4KZW5kb2JqCjUgMCBvYmoKPDwvQmFzZUZvbnQvSGVsdmV0aWNhL1R5cGUvRm9udAovRW5jb2RpbmcvV2luQW5zaUVuY29kaW5nCi9TdWJ0eXBlL1R5cGUxPj4KZW5kb2JqCjYgMCBvYmoKPDwvQmFzZUZvbnQvSGVsdmV0aWNhLUJvbGQvVHlwZS9Gb250Ci9FbmNvZGluZy9XaW5BbnNpRW5jb2RpbmcKL1N1YnR5cGUvVHlwZTE+PgplbmRvYmoKNyAwIG9iago8PC9CYXNlRm9udC9IZWx2ZXRpY2EtT2JsaXF1ZS9UeXBlL0ZvbnQKL0VuY29kaW5nL1dpbkFuc2lFbmNvZGluZwovU3VidHlwZS9UeXBlMT4+CmVuZG9iago4IDAgb2JqCjw8L0Jhc2VGb250L0hlbHZldGljYS1Cb2xkT2JsaXF1ZS9UeXBlL0ZvbnQKL0VuY29kaW5nL1dpbkFuc2lFbmNvZGluZwovU3VidHlwZS9UeXBlMT4+CmVuZG9iago5IDAgb2JqCjw8L0Jhc2VGb250L0NvdXJpZXIvVHlwZS9Gb250Ci9FbmNvZGluZy9XaW5BbnNpRW5jb2RpbmcKL1N1YnR5cGUvVHlwZTE+PgplbmRvYmoKMTAgMCBvYmoKPDwvQmFzZUZvbnQvQ291cmllci1Cb2xkL1R5cGUvRm9udAovRW5jb2RpbmcvV2luQW5zaUVuY29kaW5nCi9TdWJ0eXBlL1R5cGUxPj4KZW5kb2JqCjExIDAgb2JqCjw8L0Jhc2VGb250L0NvdXJpZXItT2JsaXF1ZS9UeXBlL0ZvbnQKL0VuY29kaW5nL1dpbkFuc2lFbmNvZGluZwovU3VidHlwZS9UeXBlMT4+CmVuZG9iagoxMiAwIG9iago8PC9CYXNlRm9udC9Db3VyaWVyLUJvbGRPYmxpcXVlL1R5cGUvRm9udAovRW5jb2RpbmcvV2luQW5zaUVuY29kaW5nCi9TdWJ0eXBlL1R5cGUxPj4KZW5kb2JqCjEzIDAgb2JqCjw8L0Jhc2VGb250L1RpbWVzLVJvbWFuL1R5cGUvRm9udAovRW5jb2RpbmcvV2luQW5zaUVuY29kaW5nCi9TdWJ0eXBlL1R5cGUxPj4KZW5kb2JqCjE0IDAgb2JqCjw8L0Jhc2VGb250L1RpbWVzLUJvbGQvVHlwZS9Gb250Ci9FbmNvZGluZy9XaW5BbnNpRW5jb2RpbmcKL1N1YnR5cGUvVHlwZTE+PgplbmRvYmoKMTUgMCBvYmoKPDwvQmFzZUZvbnQvVGltZXMtSXRhbGljL1R5cGUvRm9udAovRW5jb2RpbmcvV2luQW5zaUVuY29kaW5nCi9TdWJ0eXBlL1R5cGUxPj4KZW5kb2JqCjE2IDAgb2JqCjw8L0Jhc2VGb250L1RpbWVzLUJvbGRJdGFsaWMvVHlwZS9Gb250Ci9FbmNvZGluZy9XaW5BbnNpRW5jb2RpbmcKL1N1YnR5cGUvVHlwZTE+PgplbmRvYmoKMiAwIG9iago8PAovUHJvY1NldCBbL1BERiAvVGV4dCAvSW1hZ2VCIC9JbWFnZUMgL0ltYWdlSV0KL0ZvbnQgPDwKL0YxIDUgMCBSCi9GMiA2IDAgUgovRjMgNyAwIFIKL0Y0IDggMCBSCi9GNSA5IDAgUgovRjYgMTAgMCBSCi9GNyAxMSAwIFIKL0Y4IDEyIDAgUgovRjkgMTMgMCBSCi9GMTAgMTQgMCBSCi9GMTEgMTUgMCBSCi9GMTIgMTYgMCBSCj4+Ci9YT2JqZWN0IDw8Cj4+Cj4+CmVuZG9iagoxNyAwIG9iago8PAovUHJvZHVjZXIgKGpzUERGIDEuMC4yNzItZGVidWcgMjAxNC0wOS0yOVQxNTowOTpkaWVnb2NyKQovQ3JlYXRpb25EYXRlIChEOjIwMjMwMzIzMTcyMzAzKzA4JzAwJykKPj4KZW5kb2JqCjE4IDAgb2JqCjw8Ci9UeXBlIC9DYXRhbG9nCi9QYWdlcyAxIDAgUgovT3BlbkFjdGlvbiBbMyAwIFIgL0ZpdEggbnVsbF0KL1BhZ2VMYXlvdXQgL09uZUNvbHVtbgo+PgplbmRvYmoKeHJlZgowIDE5CjAwMDAwMDAwMDAgNjU1MzUgZiAKMDAwMDAwMDIzOCAwMDAwMCBuIAowMDAwMDAxNDM3IDAwMDAwIG4gCjAwMDAwMDAwMDkgMDAwMDAgbiAKMDAwMDAwMDExNyAwMDAwMCBuIAowMDAwMDAwMjk1IDAwMDAwIG4gCjAwMDAwMDAzODUgMDAwMDAgbiAKMDAwMDAwMDQ4MCAwMDAwMCBuIAowMDAwMDAwNTc4IDAwMDAwIG4gCjAwMDAwMDA2ODAgMDAwMDAgbiAKMDAwMDAwMDc2OCAwMDAwMCBuIAowMDAwMDAwODYyIDAwMDAwIG4gCjAwMDAwMDA5NTkgMDAwMDAgbiAKMDAwMDAwMTA2MCAwMDAwMCBuIAowMDAwMDAxMTUzIDAwMDAwIG4gCjAwMDAwMDEyNDUgMDAwMDAgbiAKMDAwMDAwMTMzOSAwMDAwMCBuIAowMDAwMDAxNjYxIDAwMDAwIG4gCjAwMDAwMDE3ODAgMDAwMDAgbiAKdHJhaWxlcgo8PAovU2l6ZSAxOQovUm9vdCAxOCAwIFIKL0luZm8gMTcgMCBSCj4+CnN0YXJ0eHJlZgoxODg0CiUlRU9G');
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