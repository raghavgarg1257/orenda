<?php
	@session_start();
	
	if (isset($_SESSION['u_id'])) {
		header("Location:profile.php");
	}
	
	if ($_GET['token'] == "") {
		header("Location:index.php");
	} else {
		$reset_token = $_GET['token'];
		
		require("db.php");
		$link = mysqli_connect($_srvr, $_user, $_pass, $_db);		
		$query = "SELECT `id` FROM `user_auth` WHERE `reset_token`=?";
		$statement = mysqli_prepare($link, $query);
		mysqli_stmt_bind_param($statement, 's', $reset_token);
		mysqli_stmt_execute($statement);
		mysqli_stmt_bind_result($statement, $user_id);
		mysqli_stmt_fetch($statement);
		mysqli_stmt_close($statement);	//	close the prepared statement
		mysqli_close($link);	//	close the sql connection
		
		if($user_id == ""){
			header("Location:index.php");
		}

	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="images/logo_small.png">
	<title>Orenda | Reset Password</title>

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
	<?php require 'header.php'; ?>

	<div class="container" style="margin-top: 75px;">
		<div class="row">
			<div class="col-lg-4"></div>
			<div class="col-lg-4" id="pass_reset">	
				<div style="margin:10px 10px 30px;" id="">Enter Your New Password</div>
				<form method="post" action="#" name="reset_password_form" id="reset_password_form">
					<div class="form-group">
						<input type="password" name="reset_password" id="reset_password" class="form-control" placeholder="New Password">
						<input type="password" name="confirm_reset_password" id="confirm_reset_password" class="form-control" placeholder="Confirm New Password">
						<input type="submit" name="save_reset_password" id="save_reset_password" value="Reset Password" class="form-control btn btn-default">
					</div>
				</form>
				<span id="reset_error"></span>
			</div>
			<div class="col-lg-4"></div>
		</div>
	</div>

	<!--	Footer	-->
	<?php require 'footer.php'; ?>

	<!--	Javascript Files	-->
	<script type="text/javascript" src="./js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="./js/bootstrap.min.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function(){
			console.log("You can't even remember your password..??");
			
			var confirm_new_password = false;
	
			$("#confirm_reset_password").on("keyup",function(){
				//console.log($(this).val());
				if($(this).val() != "") {
					if ($(this).val() == $("#reset_password").val()) {
						$(this).css("border-color","green");
						confirm_new_password = true;
					} else {
						$(this).css("border-color","red");
						confirm_new_password = false;
					}				
				} else {
					$(this).css("border-color","#ccc");	
				}
			});
			
			$("#reset_password_form").on("submit",function(e){
				e.preventDefault();
				
				if ( ($("#reset_password").val() == "") || ($("#confirm_reset_password").val() == "") ) {
					$("#reset_error").html("Please enter both fields.");
				} else if (confirm_new_password == false) {
					$("#reset_error").html("Password didn't match, Please try again.");
				} else {
					var formData = {
						'user_new_pass': $("#confirm_reset_password").val(),
						'user_id': '<?php echo $user_id; ?>'
					};
	
					$.ajax({
						type: "POST",
						url: "reset_user_password.php",
						data: formData,
						success: function(data){
							console.log(data);
							if (data == "go") {
								$("#pass_reset").html("Password changed successfully..!! <br><br> Please Wait while we transfer you to login page.");
								setTimeout(function(){
									window.location.replace("login.php");
								},4000);
							} else if (data == "halt") {
								$("#reset_error").html("Password must contain both characters and numeric..!!");
								$("#reset_password").val("");
								$("#confirm_reset_password").val("");
								$("#confirm_reset_password").css("border-color","#ccc");
							}
						}
					});
				}
			});
		});
	</script>
</body>
</html>