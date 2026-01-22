<?php
session_start();
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	try {
		//Server settings
		//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
		$mail->isSMTP();                                            //Send using SMTP
		$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		$mail->Username   = 'parcellhorse@gmail.com';                     //SMTP username
		$mail->Password   = 'lkptbznqlacsbjke';                               //SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
		$mail->Port       = 465; 
		
		$name = $_POST['name'];
		$email = $_POST['email'];
		$subject = $_POST['phone'];
		$message = $_POST['message'];

		
		$full_message = "Name: $name\nEmail: $email\n Mobile Number:\n$subject\nMessage:\n$message";
		
		//Recipients
		$mail->setFrom('parcellhorse@gmail.com', 'Parcel Horse');
		$mail->addAddress('parcellhorse@gmail.com', 'Parcel Horse');     //Add a recipient
    

   
		//Content
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = 'New Lead';
		$mail->Body    = $full_message;
		
		if ($mail->send()) {
			$_SESSION['status']=true;
			header("Location: {$_SERVER['HTTP_REFERER']}");
			exit(0);
			
		} else {
			$_SESSION['status']=false;
			header("Location: {$_SERVER['HTTP_REFERER']}");
			exit(0);
			
		}
	}
	catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}
?>
