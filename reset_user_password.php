<?php  
	@session_start();
	
	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db);

	function sanitize($data) {
		global $link;
		$data = trim($data);
		$data = mysqli_real_escape_string($link, $data);
		return $data;
	}

	function regularpassword($password) {
		if (preg_match('/[A-Za-z]/', $password) && preg_match('/[0-9]/', $password))
			return true;
		else
			return false;
	}

	function update($id, $password) {
		global $link;

		$password = sanitize($password);
		$password = md5($password."lairotut");	//	salt word 

		$query = "UPDATE `user_auth` SET `password`=?, `reset_token`='' WHERE `id`=?";
		$statement = mysqli_prepare($link, $query);
		mysqli_stmt_bind_param($statement,'si', $password, $id);
		mysqli_stmt_execute($statement);
		mysqli_stmt_close($statement);
		
		$query = "SELECT `email` FROM `users` WHERE `id`=?";
		$statement = mysqli_prepare($link, $query);
		mysqli_stmt_bind_param($statement,'i', $id);
		mysqli_stmt_execute($statement);
		mysqli_stmt_bind_result($statement, $email);
		mysqli_stmt_fetch($statement);
		mysqli_stmt_close($statement);
		
		return $email;
	}

	$user_new_pass = sanitize($_POST['user_new_pass']);
	$user_id = sanitize($_POST['user_id']);

	if (regularpassword($user_new_pass)) {
		$email = update($user_id,$user_new_pass);
	
		$tempData = explode("@", $email);
		$username = $tempData[0];
		
		$to      = $email;
		$subject = "Your Password has changed | Orenda";
	
		$message = "Hello ".$username.",<br><br>";
		$message .= "We wanted to let you know that your Orenda password was changed.<br><br>";
		$message .= "If you did not perform this action, you can recover access by entering ".$email." into the form at <a href='http://techorenda.com/forgot-password.php'>Forgot Password</a><br><br>";
		$message .= "You can also teach on orenda. Just fill the form and we will contact you. <a href='http://techorenda.com/new_instructor.php'>Apply as Instructor</a><br>";
		$message .= "If you have any query or just want to say hello, write us to welcome@techorenda.com.<br><br>";
		$message .= "Thanks,<br>Team Orenda";
		
		$headers = "From: Orenda<support@techorenda.com>\r\n";
		$headers .= "Reply-To: Orenda<welcome@techorenda.com>\r\n";
		$headers .= "X-Mailer: PHP/".phpversion();
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		mail($to, $subject, $message, $headers);
	
		echo "go";
	} else {
		echo "halt";
	}

	mysqli_close($link);	//	close the sql connection
 ?>