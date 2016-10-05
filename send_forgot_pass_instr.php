<?php

	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db);

	$email = $_POST['email'];
	
	$tempData = explode("@", $email);
	$username = $tempData[0];
	
	$strtocnvrt = $email.microtime(true)."orenda";
	
	$token = md5($strtocnvrt);
	
	$query = "UPDATE `user_auth` SET `reset_token`=? WHERE `email`=? AND `password` <> '' ";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'ss', $token, $email);
	mysqli_stmt_execute($statement);
	mysqli_stmt_close($statement);	//	close the prepared statement
	mysqli_close($link);	//	close the sql connection
			
	$to      = $email;
	$subject = "Password Reset | Orenda";

	$message = "Hello ".$username.",<br><br>";
	$message .= "We heard that you lost your Orenda password. Sorry about that!<br><br>";
	$message .= "But don’t worry! You can use the following link to reset your password: <a href='http://techorenda.com/reset-password.php?username=$username&token=$token'>Reset Your Password</a>.<br><br>";
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