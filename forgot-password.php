<?php
	@session_start();
	if (isset($_SESSION['u_id'])) {
		header("Location:profile.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="images/logo_small.png">
	<title>Orenda | Forgot Password</title>

	<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./css/fontawesome/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="./css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="./css/footer.css">
	<link rel="stylesheet" type="text/css" href="./css/navigation.css">
	
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>

	<style type="text/css">
		*{
			font-family: 'Montserrat', sans-serif;
			/*
			font-family: 'Raleway', sans-serif;
			*/
		}
		body{
			font-size: 16px;
		}
		.form-control{
			margin:10px;
		}
		.form-field{
			display: block;
			margin: auto;
			
			width: 90%;
			padding: 10px 10px 10px 10px;
			margin-top: 5px;
			border: 1px solid #c2c7d0;
    		border-radius: 5px;
    		font-size: 16px;
    		line-height: 1.5em;
    		font-family: "Whitney SSm A", "Whitney SSm B", "Avenir", "Helvetica Neue", "Segoe UI", Helvetica, Arial, "Ubuntu", sans-serif;
    		outline: none;			
		}
		footer{
		position: absolute;
    width: 100%;
    bottom: 0;
    right: 0;
		}
	</style>
	
	<script type="text/javascript">
		paceOptions = {
			elements: true,
			restartOnRequestAfter:false,
			restartOnPushState:false
		};
	</script>
	<script type="text/javascript" src="js/pace.min.js"></script>
	<link rel="stylesheet" href="css/pace-theme.css" />

</head>
<body>
	<!--	Header	-->
	<?php require '/header.php'; ?>

	<div class="container" style="margin-top: 75px;">
		<div class="row">
			<div class="col-lg-4"></div>
			<div class="col-lg-4">	
				<div style="margin:10px 10px 30px;" class="text-center">You will be sent an email on your email exchanger with password reset instruction. Please enter your email id with which you are registered with us.</div>
				<form method="post" action="#" name="forgot_password_form" id="forgot_password_form">
					<div class="form-group">
						<input type="email" name="forgot_email" id="forgot_email" class=" form-field" placeholder="Enter Email">
						<input type="submit" name="forgot_send_instr" id="forgot_send_instr" value="Send Email" class="form-field" style="background: rgb(45,195,100); color: white;">
					</div>
				</form>
				<span id="forgot_error"></span>
				<a href="" id="email_link"></a>
				<div id="temp_link"></div>
			</div>
			<div class="col-lg-4"></div>
		</div>
	</div>

	<!--	Footer	-->
	<?php require '/footer.php'; ?>

	<!--	Javascript Files	-->
	<script type="text/javascript" src="./js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="./js/bootstrap.min.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function(){
			console.log("You can't even remember your password..??");
			
			$("#forgot_password_form").on("submit",function(e){
				e.preventDefault();
				
				if ( $("#forgot_email").val() != "" ) {
					var formData = {
						'email': $("#forgot_email").val()
					};
	
					$.ajax({
						type: "POST",
						url: "check_enter_email.php",
						data: formData,
						success: function(data){
							
							var forgotPassData = {
								email: $("#forgot_email").val(),
							};
								
							if (data == "login") {	
								$.ajax({
									type: "POST",
									url: "send_forgot_pass_instr.php",
									data: forgotPassData,
									success: function(data){
									//	window.location.replace();
									//	$("#temp_link").html(data);
										console.log("success..!!");
									}
								});
							}
							if (data == "signin") {	
								$.ajax({
									type: "POST",
									url: "send_login_instr.php",
									data: forgotPassData,
									success: function(data){
									//	window.location.replace();
									//	$("#temp_link").html(data);
										console.log("success..!!");
									}
								});
							}
							
							var email = $("#forgot_email").val();
							var tempData = email.split("@");
							var email_exchngr = "http://" + tempData[1];
							$("#forgot_error").html("Instruction have been send to your email. Please visit ");
							$("#email_link").attr("href",email_exchngr);
							$("#email_link").html(tempData[1]);
							
						}
					});
				} else {
					$("#forgot_error").html("Please enter the email..!!");
				}
			});
		});
	</script>
</body>
</html>