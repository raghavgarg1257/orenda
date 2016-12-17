<?php
	if( !empty($_FILES['instrctr_resume']) &&
	    !empty($_POST['instrctr_name']) &&
	    !empty($_POST['instrctr_email']) &&
	    !empty($_POST['course_name']) ) {
	    
		function regular_name($name){
			$rexSafety = "/[\^<,\"@\/\{\}\(\)\*\$%\?=>:\|;#]+/i";
			if (!preg_match($rexSafety, $name))
				return true;
			else
				return false;
		}
		function regular_email($email){
			if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email)) {
// 				list($user_name, $mail_domain) = split("@", $email);
// 				if (checkdnsrr($mail_domain,"MX"))
					return true;
// 				else
// 					return false;
			}
			else
				return false;
		}
		function regular_phone($phone){
			if (preg_match("/([1-9]{1})([0-9]{9})/", $phone))
				return true;
			else
				return false;
		}
		function regular_uri($uri){
			if (preg_match("/^(?:https?:\/\/)?(?:[a-z0-9-]+\.)*((?:[a-z0-9-]+\.)[a-z]+)/", $uri))
				return true;
			else
				return false;
		}
		
		$file_ext = strtolower( end( explode('.', $_FILES['instrctr_resume']['name']) ) );
		$extensions = array("txt", "pdf", "doc", "docx", "odt", "sxw", "rtf"); 		
		if (!in_array($file_ext, $extensions)) {
			echo "ext_halt";
			die;
		} else if ($_FILES['instrctr_resume']['size'] > 1048576) {
			echo "size_halt";
			die;
		} else if (!regular_name($_POST['instrctr_name'])) {
			echo "inst_name_halt";
			die;
		} else if (!regular_email($_POST['instrctr_email'])) {
			echo "inst_email_halt";
			die;
		} else if (!regular_name($_POST['course_name'])) {
			echo "crs_name_halt";
			die;
		}
		
		$instrctr_name = $_POST['instrctr_name'];
		$instrctr_email = $_POST['instrctr_email'];
		$course_name = $_POST['course_name'];
		$instrctr_phone = 0;
		$linkedin_uri = "";
		$facebook_uri = "";
		$portfolio_uri = "";
		$others_uri = "";
		$course_details = "";
		$personal_details = "";
		
		if(!empty($_POST['instrctr_phone'])) {
			if (!regular_phone($_POST['instrctr_phone'])) {
				echo "inst_phone_halt";
				die;
			} else {
				$instrctr_phone = $_POST['instrctr_phone'];
			}
		}
		if(!empty($_POST['linkedin_uri'])) {
			if (!regular_uri($_POST['linkedin_uri'])) {
				echo "linkedin_uri_halt";
				die;
			} else {
				$linkedin_uri = $_POST['linkedin_uri'];
			}
		}
		if(!empty($_POST['facebook_uri'])) {
			if (!regular_uri($_POST['facebook_uri'])) {
				echo "facebook_uri_halt";
				die;
			} else {
				$facebook_uri = $_POST['facebook_uri'];
			}
		}
		if(!empty($_POST['portfolio_uri'])) {
			if (!regular_uri($_POST['portfolio_uri'])) {
				echo "portfolio_uri_halt";
				die;
			} else {
				$portfolio_uri = $_POST['portfolio_uri'];
			}
		}
		if(!empty($_POST['others_uri'])) {
			if (!regular_uri($_POST['others_uri'])) {
				echo "others_uri_halt";
				die;
			} else {
				$others_uri = $_POST['others_uri'];
			}
		}
		if(!empty($_POST['course_details'])) {
			$course_details = $_POST['course_details'];
		}
		if(!empty($_POST['personal_details'])) {
			$personal_details = $_POST['personal_details'];
		}
		
		require("db.php");
		$link = mysqli_connect($_srvr, $_user, $_pass, $_db);
	
		function sanitize($data) {
			global $link;
			$data = trim($data);
			$data = mysqli_real_escape_string($link, $data);
			return $data;
		}
		
		$resume_uploads_dir = 'documents/instructor_resume';		
		$resume_name = $instrctr_email."-".md5(microtime(true)).".".strtolower(end(explode('.', $_FILES['instrctr_resume']['name'])));
		$resume_tmp_name = $_FILES["instrctr_resume"]["tmp_name"];
		move_uploaded_file($resume_tmp_name, "$resume_uploads_dir/$resume_name");
		
		$resume_link = $resume_uploads_dir."/".$resume_name;
		$instrctr_name = sanitize($instrctr_name);
		$instrctr_email = sanitize($instrctr_email);
		$course_name = sanitize($course_name);
		$instrctr_phone = sanitize($instrctr_phone);
		$linkedin_uri = sanitize($linkedin_uri);
		$facebook_uri = sanitize($facebook_uri);
		$portfolio_uri = sanitize($portfolio_uri);
		$others_uri = sanitize($others_uri);
		$course_details = sanitize($course_details);
		$personal_details = sanitize($personal_details);
		
		$query = "INSERT INTO `instructor`(`resume_link`, `name`, `email`, `phone`, `course_name`, `linkedin_url`, `facebook_url`, `portfolio_url`, `other_url`, `course_details`, `personal_details`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
		$statement = mysqli_prepare($link,$query);
		mysqli_stmt_bind_param($statement,'sssdsssssss',
			$resume_link,
			$instrctr_name,
			$instrctr_email,
			$instrctr_phone,
			$course_name,
			$linkedin_uri,
			$facebook_uri,
			$portfolio_uri,
			$others_uri,
			$course_details,
			$personal_details
		);
		mysqli_stmt_execute($statement);
		mysqli_stmt_close($statement);	//	close the prepared statement
		mysqli_close($link);	//	close the connection
		
		echo "go";
		
		// Mail
		//,ansraghav100@gmail.com
		$to = "shubh_jain94@yahoo.in,kartikbansal945@gmail.com";
	
		$subject = "Orenda | New Instructor Application";
		
		$message = "# Instructor\r\nName: $instrctr_name\r\nEmail: $instrctr_email\r\nPhone: $instrctr_phone\r\n\r\n";
		$message .= "# Course\r\nName: $course_name\r\n\r\n";
		$message .= "# Link\r\nLinkedin: $linkedin_uri\r\nFacebook: $facebook_uri\r\nPortfoilio: $portfolio_uri\r\nOther: $others_uri\r\n\r\n";
		$message .= "# Additional Info\r\nCourse Details: $course_details\r\nPersonal Details: $personal_details\r\n\r\n";
		$message .= "Regards,\r\nRaghav Garg\r\nBack End Developer";	
		
		$mail_file_tmp_name = $_FILES['instrctr_resume']['tmp_name'];
		$mail_file_size = $_FILES['instrctr_resume']['size'];
		$mail_file_name = $_FILES['instrctr_resume']['name'];
		$mail_file_type = $_FILES['instrctr_resume']['type'];
		$file_open = fopen($mail_file_tmp_name, "r");
		$file_content = fread($file_open, $mail_file_size);
		fclose($file_open);
		$encoded_file_content = chunk_split(base64_encode($file_content));
		
		$boundary = md5($mail_file_name.microtime(true));
		//plain text 
		$body = "--$boundary\r\n";
		$body .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
		$body .= "Content-Transfer-Encoding: base64\r\n\r\n"; 
		$body .= chunk_split(base64_encode($message)); 
		//attachment
		$body .= "--$boundary\r\n";
		$body .="Content-Type: $mail_file_type; name=\"$mail_file_name\"\r\n";
		$body .="Content-Disposition: attachment; filename=\"$mail_file_name\"\r\n";
		$body .="Content-Transfer-Encoding: base64\r\n";
		$body .="X-Attachment-Id: ".rand(1000,99999)."\r\n\r\n"; 
		$body .= $encoded_file_content; 
		
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "From: no-reply@techorenda.com"."\r\n";
		$headers .= "Content-Type: multipart/mixed; boundary = $boundary\r\n\r\n";
	
		mail($to, $subject, $body, $headers);
		
	} else {
		echo "halt";	
	}
	
?>
