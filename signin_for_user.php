<?php 

	@session_start();

	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db);

	$signin_email = $_POST['email']; 
	$signin_name = $_POST['name'];
	$signin_password = $_POST['password'];
	$pic_letter = str_split($signin_name);
	$signin_profile_pic = "user_pic_".strtolower($pic_letter[0]).".png";

	function sanitize($data)
	{
		global $link;
		$data = trim($data);
		$data = mysqli_real_escape_string($link, $data);
		return $data;
	}
	
	function regularemail($emailid)
	{
		//if(preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/', $emailid)) {
		if(ereg("^[A-Za-z0-9\.|-|_]*[@]{1}[A-Za-z0-9\.|-|_]*[.]{1}[a-z]{2,5}$", $emailid)) {
// 			list($user_name, $mail_domain) = split("@", $emailid);
// 			if (checkdnsrr($mail_domain,"MX"))
				return true;
// 			else
// 				return false;
		}
		else
			return false;
	}

	function regularpassword($password)
	{
		if (preg_match('/[A-Za-z]/', $password) && preg_match('/[0-9]/', $password))
			return true;
		else
			return false;
	}

	function register($name, $email, $password, $profile_pic)
	{
		global $link;
		
		$email = sanitize($email);
		$name = sanitize($name);
		$name = ucwords(strtolower($name));
		
		$password = sanitize($password);
		$password = md5($password."lairotut");	//	salt word
		
		$strtocnvrt = "orenda".microtime(true).$email;
		$token = md5($strtocnvrt);
		
		$query = " INSERT INTO `users`(`email`, `name`, `profile_pic`) VALUES (?,?,?) ";
		$statement = mysqli_prepare($link,$query);
		mysqli_stmt_bind_param($statement,'sss', $email, $name, $profile_pic);
		mysqli_stmt_execute($statement);
		mysqli_stmt_close($statement);

		$query = " INSERT INTO `user_auth`(`email`, `password`, `auth_tkn_sts`) VALUES (?,?,?) ";
		$statement = mysqli_prepare($link,$query);
		mysqli_stmt_bind_param($statement,'sss', $email, $password, $token);
		mysqli_stmt_execute($statement);
		mysqli_stmt_close($statement);
				
		return $token;
	}
	
	if (regularemail($signin_email)) {
	
		if (regularpassword($signin_password)) {	
			//send mail and ask to authenticate		
			$auth_token = register($signin_name, $signin_email, $signin_password, $signin_profile_pic);
			
			$tempData = explode("@", $signin_email);
			$username = $tempData[0];
			
			$to      = $signin_email;
			$subject = "Account Authentication | Orenda";
			
			$message = "Hello ".$username.",<br><br>";
			$message .= "We are glad to have you onboard with us.<br><br>";
			$message .= "Please confirm your email-id using the following link: <a href='http://techorenda.com/login.php?username=$username&auth_token=$auth_token'>Authenticate Your Account</a>.<br><br>";
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
			echo "Phalt";
		}
	
	} else {
		echo "Ehalt";	
	}

	mysqli_close($link);	//	close the connection

 ?>
