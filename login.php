<?php 
//	header("Location:index.php");
//	die;
	
	@session_start();

	if (isset($_SESSION['u_id'])) {
		//header("Location:index.php");
		header("Location:profile.php");
	}
	
	$s_or_l = 1;
	if(isset($_GET['in'])) {
		if($_GET['in'] == "signup")
			$s_or_l = 0;	
	}
	
	$auth_passed = false;
	
	if (isset($_GET['auth_token'])) {
		$auth_token = $_GET['auth_token'];	

		require("db.php");
		$link = mysqli_connect($_srvr, $_user, $_pass, $_db);
	
		$query = "SELECT `id`, `email` FROM `user_auth` WHERE `auth_tkn_sts`=?";
		$statement = mysqli_prepare($link, $query);
		mysqli_stmt_bind_param($statement, 's', $auth_token);
		mysqli_stmt_execute($statement);
		mysqli_stmt_bind_result($statement, $user_id, $user_email);
		mysqli_stmt_fetch($statement);
		mysqli_stmt_close($statement);
		
		if ($user_id != "") {
			$query = "UPDATE `user_auth` SET `auth_tkn_sts`=1 WHERE `id`=?";
			$statement = mysqli_prepare($link, $query);
			mysqli_stmt_bind_param($statement, 'i', $user_id);
			mysqli_stmt_execute($statement);
			mysqli_stmt_close($statement);
			
			$auth_passed = true;
		}
				
		mysqli_close($link);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="icon" type="image/png" href="images/logo_small.png">
	<title>Orenda | Login/Register</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/fontawesome/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<style type="text/css">

		.login-form{
			font-family: "Whitney SSm A", "Whitney SSm B", "Avenir", "Helvetica Neue", "Segoe UI", Helvetica, Arial, "Ubuntu", sans-serif;			
			width: 450px;
			border: 1px solid #c2c7d0;
    		margin: auto;
    		
		}
		.l-form,.s-form{
			padding: 40px 30px 30px 30px;
			display: none;
		}
		.l-form p a{
			float: right;
			margin: 8px 0 15px 0;
			
		}

		.login-form .login-links a{
			color: #979faf;
			text-decoration: none;
			font-weight: 500;
			font-size: 25px;
			display: inline-block;
			font-family: "Whitney SSm A", "Whitney SSm B", "Avenir", "Helvetica Neue", "Segoe UI", Helvetica, Arial, "Ubuntu", sans-serif;
			padding: 10px 0;

		}
		.sign-link,.login-link{
			border: 1px solid #C2C7D0;
			font-family: "Whitney SSm A", "Whitney SSm B", "Avenir", "Helvetica Neue", "Segoe UI", Helvetica, Arial, "Ubuntu", sans-serif;
			background: #fafafa;
			border-top: 0;

		}
		.sign-link{
			border-left:0;
		}
		.login-link{
			border-right: 0;
			border-left: 0;
		}
		.login-form .login-links .active-link{
			background:#fff;
			border-bottom:0; 
		}
		.login-links .active-link a{
			color: black;
		}
		.info-active{
			display: block;
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
	    		color:#000;	
		}
		.form-button{
			background: #3ca750;
			opacity: .9;
			outline: none;
			border: 1px solid #3ca750;
			font-weight: 500;
			color: #fff;
			display: block;
			margin: auto;
			width: 30%;
		    padding: 10px;
		    margin-bottom: 0;
		    font-size: 14px;
		    line-height: 18px;
		    text-decoration: none;
		    vertical-align: middle;
		    margin-top: 10px;
		    border-radius: 3px;
		    clear: both;
    		font-family: "Whitney SSm A", "Whitney SSm B", "Avenir", "Helvetica Neue", "Segoe UI", Helvetica, Arial, "Ubuntu", sans-serif;
		}
		.form-footer{
			margin-bottom: 30px;
			padding: 0 10px 0 10px;
    		font-family: "Whitney SSm A", "Whitney SSm B", "Avenir", "Helvetica Neue", "Segoe UI", Helvetica, Arial, "Ubuntu", sans-serif;
		}
		.form-footer a{
			font-family: "Whitney SSm A", "Whitney SSm B", "Avenir", "Helvetica Neue", "Segoe UI", Helvetica, Arial, "Ubuntu", sans-serif;
			font-size: 1.1em;
		}

		.form-footer p{
			text-align: center;
		}
		.login-links div{
			display: inline-block;
			width: 50%;
			
			text-align: center;

		}
		hr{
			border-color: #c2c7d0; 
		}
		.login-links a{
			cursor: pointer;
			
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

	<a href="index.php" style="display: block;margin:30px auto 35px auto;"><img src="images/logo_big.png" width="180" class="center-block img-responsive" alt="Website Logo" /></a>

		<div class="login-form">
			<div class="login-links">
				<a href="#s-form"><div class="sign-link <?php echo ($s_or_l) ? '' : 'active-link'; ?>"><a data-target="#s-form" style="width: 100%">Sign Up</a></div></a><a href="#l-form"><div class="login-link <?php echo ($s_or_l) ? 'active-link' : ''; ?>"><a data-target="#l-form" class=""  style="width: 100%">Log In</a></div></a>
			</div>
			<div class="l-form <?php echo ($s_or_l) ? 'info-active' : ''; ?>" id="l-form">
				<form method="POST" action="#" name="login_form" id="login_form">
				
					<input type="email" name="login_email" id="login_email" class="center-block form-field" placeholder="Login Email">
					<input type="password" name="login_password" id="login_password" class="center-block form-field" placeholder="Password">
					
					<p><a href="forgot-password.php" style="float: right; outline: none">Forgot your password?</a></p>
					
					<input type="submit" value="Login" class="center-block form-field" style="background: rgb(45,195,100); color:white;">
				</form>
			</div>
			<div class="s-form <?php echo ($s_or_l) ? '' : 'info-active'; ?>" id="s-form">
				<form method="POST" action="#" name="signin_form" id="signin_form">
				
					<input type="text" name="signin_name" id="signin_name" class="center-block form-field" placeholder="Name">
					<input type="email" name="signin_email" id="signin_email" class="center-block form-field" placeholder="Signup Email">
					
					<input type="password" name="signin_password" id="signin_password" class="center-block form-field" placeholder="Password">
					<input type="password" name="signin_confirm_password" id="signin_confirm_password" class="center-block form-field" placeholder="Confirm Password">
					
					<input type="submit" value="Create Account" class="center-block form-field" style="background: rgb(45,195,100); color: white; margin-top: 30px">
				</form>
			</div>
			<div id="error_box" class="text-center"></div>
			<hr style="margin-top: 0">
			<div class="form-footer text-center">
				<p>Or Connect using</p>
				<a href="#" class="btn btn-primary" style="background:#3b5998; margin-right:10px;" onclick="FBLogin()"><span class="fa fa-facebook"> &nbsp;Facebook</span></a>
				<a href="#" class="btn btn-danger" style="background:#dd4b39;" onclick="GLogin()"><span class="fa fa-google"> &nbsp;Google</span></a>
			</div>
		</div>

	<script type="text/javascript" src="./js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="./js/bootstrap.min.js"></script>
	
	<!-- Script to change the tabs -->
	<script type="text/javascript">
		$(document).ready(function() {
			$('.login-form .login-links a').click( function() {
				var currentlink =  $('.login-form .login-links .active-link ');
				currentlink.removeClass('active-link');
				$(this).parent().addClass('active-link').css('color','black');
				
				var current = $('.info-active');
				current.removeClass('info-active');
				$($(this).attr('data-target')).addClass('info-active');
			});
		});
	</script>
	
	<!--  Script for Normal Entry -->
	<script type="text/javascript">
		$(document).ready(function(){
			
			//	Login Script
			$("#login_form").on("submit",function(e){

				e.preventDefault();// prevent native form submission here
				
				if(($('input[name=login_email]').val() != "") && ($('input[name=login_password]').val() != "")) {
					
					$("#error_box").html("");
					
					var formData = {
						'email': $('input[name=login_email]').val(),
						'password': $('input[name=login_password]').val() 
					};
	
					$.ajax({
						type: "POST",
						url: "login_for_user.php",
						data: formData,
						success: function(data){
							//console.log("login: " + data);
							if (data == "auth_prb") {
								$("#error_box").html("Your account is not authorized please visit your email exchanger.");
							} else if (data == "halt") {
								$("#error_box").html("ID-Password didn't match");
								$('input[name=login_email]').val("");
								$('input[name=login_password]').val("");
							}
							else{
							//	console.log(data);
							//	window.location.replace(data);
								window.location.replace("courses.php");
							}
						}
					});
					
				} else {
					$("#error_box").html("Please fill every field correctly");
				}
				
			});
			
			//	Signup Script
			var confirm_password = false;

			$("#signin_confirm_password").on("keyup",function(){
				//console.log($(this).val());
				if($(this).val() != "") {
					if ($(this).val() == $("#signin_password").val()) {
						$(this).css("border-color","green");
						confirm_password = true;
					} else {
						$(this).css("border-color","red");
						confirm_password = false;
					}				
				} else {
					$(this).css("border-color","#ccc");	
				}
			});

			$("#signin_form").on("submit",function(e){

				e.preventDefault();// prevent native form submission here
				
				var newEmail = false;
				
				var checkEmailData = {
			            'email': $('input[name=signin_email]').val()
		        	};
		        	
				$.ajax({
					type: "POST",
					url: "check_enter_email.php",
					data: checkEmailData,
					success: function(data){
						if (data == "signin") {
							newEmail = true;
						}
						console.log("checking: " + newEmail);
						console.log("checked: " + newEmail);
						
						if(newEmail) {
						
							if(	($('input[name=signin_name]').val() != "") && 
								($('input[name=signin_email]').val() != "") && 
								($('input[name=signin_password]').val() != "") && 
								confirm_password
							) {
			
								var formData = {
							            'email': $('input[name=signin_email]').val(),
							            'name': $('input[name=signin_name]').val(),
							            'password': $('input[name=signin_password]').val()
						        	};
						        
								$.ajax({
									type: "POST",
									url: "signin_for_user.php",
									data: formData,
									success: function(data){
										console.log("signin: " + data);
										if (data == "go") {
										//	window.location.replace("profile.php");
											$('input[name=signin_password]').val("");
											$('input[name=signin_confirm_password]').val("");
											$('input[name=signin_email]').val("");
											$('input[name=signin_name]').val("");
											$('input[name=signin_confirm_password]').css("border-color","#ccc");
											
											$("#error_box").html("We have send an email for authorization.<br>Please visit your Email Exchanger.");
										}
										
										if (data == "Ehalt") {
											$("#error_box").html("Email is not correct.");
											$('input[name=signin_name]').val("");
											$('input[name=signin_emai]').val("");
											$('input[name=signin_password]').val("");
											$('input[name=signin_confirm_password]').val("");
											
											$('input[name=signin_confirm_password]').css("border-color","#ccc");
											$('input[name=signin_email]').focus();
										}
			
										if (data == "Phalt") {
											$("#error_box").html("In password add numeric and character both..!!");
											$('input[name=signin_password]').val("");
											$('input[name=signin_password]').focus();
											$('input[name=signin_confirm_password]').val("");
											$('input[name=signin_confirm_password]').css("border-color","#ccc");
										}
									}
								});
			
							} else {
								$("#error_box").html("Please fill every field correctly");
							}
						} else {
							$("#error_box").html("Email already used. Please login");
						}
						
						
					}
				});
				
			});
		});
	</script>
	
	<!--  Script for Google login  -->
	<script type="text/javascript">
		
		var checking_g_redirect = false;

		function loginCallback(result) {
			if (result['status']['signed_in']) {
				var request = gapi.client.plus.people.get({	'userId': 'me'	});
				request.execute(function (response) {
					console.log(response['emails'][0]['value']);
					console.log(response['displayName']);
					console.log(response['id']);
					console.log(response['image']['url']);

					var formData = {
						"email": response['emails'][0]['value'],
						"name": response['displayName'],
						"id": response['id'],
						"pic": response['image']['url']
					};
					$.ajax({
						type: "POST",
						data: formData,
						url: 'check_g_user.php',
						success: function(msg) {
							console.log(msg);
							if(msg == "halt") {
								console.log('Something Went Wrong!');
							} else if (checking_g_redirect) {
								window.location.replace(msg);
							}
						}
					});

				});
			}
		}

		function GLogout() {
		    gapi.auth.signOut();
		    location.reload();
		}

		function GLogin() {
			checking_g_redirect = true;
			var myParams = {
				'clientid' : '79148391890-ofdqh7sgii9fu47h12vbrhem07stuv5o.apps.googleusercontent.com',	//	Client ID
				'cookiepolicy' : 'single_host_origin',
				'callback' : 'loginCallback',
				'scope' : 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/plus.profile.emails.read'
			};
			gapi.auth.signIn(myParams);
		}

		function onLoadCallback() {
		    gapi.client.setApiKey('AIzaSyDB5ox0fh93ceUYCFzOGrsEni8ZqgoTBX0');	//	API KEY
		    gapi.client.load('plus', 'v1',function(){});
		}
	  
		(function() {
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/client.js?onload=onLoadCallback';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	 	})();
	</script>

	<!--  Script for Facebook login  -->
	<script type="text/javascript">

		var checking_fb_redirect = false;

		function getUserInfo() {
			FB.api('/me?fields=email,name,id', function(response) {

				console.log(JSON.stringify(response));

				var arr = Object.keys(response).map(function(data) { return response[data] });		
				console.log(arr);
				var formData = {"email": arr[0], "name": arr[1], "id": arr[2]};

				$.ajax({
					type: "POST",
					data: formData,
					url: 'check_fb_user.php',
					success: function(msg) {
						if(msg == "halt") {
							console.log('Something Went Wrong!');
						} else if (checking_fb_redirect) {
							window.location.replace(msg);
						} else {
							console.log("here");
						}
					}
				});

			});
		}

		function statusChangeCallback(response) {

			if (response.status === 'connected') {
				console.log("connected");
				//getUserInfo();
			} else if (response.status === 'not_authorized') {
				console.log('Please log into this app.');
			} else {
				console.log('You can also login thorugh facebook.');
			}
		}

		window.fbAsyncInit = function() {
			FB.init({
				appId: '184132751926305',
				cookie: true,  // enable cookies to allow the server to access 
				xfbml: true,  // parse social plugins on this page
				version: 'v2.3' // use version 2.3
			});

			FB.getLoginStatus(function(response) {
				statusChangeCallback(response);
			});
		};

		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));


		function FBLogout() {
			FB.logout(function(response) {
				console.log(logout);
			});
		}

		function FBLogin() {

			checking_fb_redirect = true;

			FB.login(function(response) {
				if (response.authResponse) {
					getUserInfo();
				} 
				else {
					console.log('Authorization failed.');
				}
			},{scope: 'public_profile,email'});
		}
	</script>
</body>
</html>