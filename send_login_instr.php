<?php

	$email = $_POST['email'];
	
	$tempData = explode("@", $email);
	$username = $tempData[0];
	
	$to      = $email;
	$subject = "Password Reset | Orenda";

	$message = "Hello ".$username.",<br><br>";
	$message .= "Seems like you forgot to register first.<br>";
	$message .= "Please <a href='http://techorenda.com/login.php'>Register</a> on Orenda to get the access to loads of free fun learning videos.<br><br>";
	$message .= "You can also teach on orenda. Just fill the form and we will contact you. <a href='http://techorenda.com/new_instructor.php'>Apply as Instructor</a><br>";
	$message .= "If you have any query or just want to say hello, write us to welcome@techorenda.com.<br><br>";
	$message .= "Thanks,<br>Team Orenda";
	
	$headers = "From: Orenda<support@techorenda.com>\r\n";
	$headers .= "Reply-To: Orenda<welcome@techorenda.com>\r\n";
	$headers .= "X-Mailer: PHP/".phpversion();
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
	mail($to, $subject, $message, $headers);
	
 ?>