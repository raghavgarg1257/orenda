<?php 
	@session_start();
	
//	$_SESSION['u_id'] = 1;

	if(!isset($_SESSION['u_id'])) {
		header("Location:login.php");
	} else {
		$user_id = $_SESSION['u_id'];
	}

	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db);

	$query = "SELECT `name`, `email`, `profile_pic`, `fb_id`, `g_id` FROM `users` WHERE `id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'i', $user_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $user_name, $user_email, $user_profile_pic, $user_fb_id, $user_g_id);
	mysqli_stmt_fetch($statement);
	mysqli_stmt_close($statement);
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="icon" type="image/png" href="images/logo_small.png">
	<title><?php echo $user_name; ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="./css/profilePage.min.css">
	<link href='https://fonts.googleapis.com/css?family=Raleway:400' rel='stylesheet' type='text/css'>
	
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

<?php require "header.php"; ?>

<div class="main-body">

	<div class="cover-element"></div>

	<div class="profile">
		
		<div class="container user-info">
			<div class="user-image">
				<img 
					<?php	
					if ($user_fb_id != 0) {	
						echo "src='http://graph.facebook.com/$user_fb_id/picture?type=large'";
					} else if($user_g_id != 0){
						$temp_pic = explode("?sz=50",$user_profile_pic);
						$user_profile_pic = $temp_pic[0]."?sz=200";
						echo "src=$user_profile_pic";					
					} else { 	
						echo "src='images/users/$user_profile_pic'";
					}	
					?>
				/>
			</div>
			<div class="profile-info">
				<div class="current-info">
					<h3 id="disp_user_name" style="font-size: 20px"><?php echo $user_name; ?></h3>
					<p><?php echo $user_email; ?></p>
					<button class="edit">EDIT PROFILE</button>
				</div>
				<div class="update-info">
				
					<form method="POST" action="#" name="update_user_info" id="update_user_info" style="background-color:white;" >
						<h3 style="margin-top: 0">Change Username</h3>
						<input type="text" name="update_user_new_name" id="update_user_new_name" value="<?php echo $user_name?>" placeholder="New Username" style="padding-right:10px;"><br>
						
						<?php if ( (!isset($_SESSION['fb_id'])) && ($user_g_id == 0) ) { ?>
							<h3>Change Password</h3>
							<input type="password" name="user_new_pass" id="user_new_pass"placeholder="New Password" style="padding-right:10px;" /><br>
							<input type="password" name="user_confirm_new_pass" id="user_confirm_new_pass" placeholder="Confirm New Password" style="margin-top:6px; padding-right:10px;" /><br>
							<p id="pass_error_box" style="font-size:16px; color:red; margin:2px 0 12px 0"></p>
						<?php	}	?>	
						
						<button id="update_save" style="background: rgb(52,179,160)">Save Changes</button>
						<button id="update_cancel" style="background: rgb(25,55,75)">Cancel</button>
					</form>
					
				</div>
			</div>
		</div>

		<div class="skills-info-links">
			<div class="links1" style="cursor: pointer">
				<a data-target="#os" class="link-active" style="padding: 10px 18px">In-Progress Courses</a>
				<a  data-target="#cs">Completed Courses</a>
			</div>

			<div class="skills-info" style="padding: 25px 0; background: rgb(212,213,214)">

				<div class="ongoing-skills container info-active" id="os"></div>
	
				<div class="completed-skills container" id="cs"></div>

			</div>

		</div>

	</div>

	<?php require "footer.php"; ?>

	</div>
	
	<?php require "contact_modal.php";?>

	<script type="text/javascript" src="./js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="./js/bootstrap.min.js"></script>
	<script type="text/javascript" src="./js/navigation.min.js"></script>
	<script type="text/javascript">var main=function(){$(".profile .skills-info-links .links1 a").click(function(){$(".profile .skills-info-links .links1 a.link-active").removeClass("link-active");$(this).addClass("link-active");$(".info-active").removeClass("info-active");$($(this).attr("data-target")).addClass("info-active")});$(".profile .user-info button.edit").click(function(){$(".profile .user-info .current-info").hide();$(".profile .user-info .update-info").show()})};$(document).ready(main);</script>
	
	<script type="text/javascript">
		$(document).ready(function() {
			$('.profile .skills-info-links .links1 a').click( function() {
				var currentlink =  $('.profile .skills-info-links .links1 a.link-active');
				currentlink.removeClass('link-active');
				$(this).addClass('link-active');
				var current = $('.info-active');
				current.removeClass('info-active');
				$($(this).attr('data-target')).addClass('info-active');
			});

			$('.profile .user-info button.edit').click(function() {
				$('.profile .user-info .current-info').hide();
				$('.profile .user-info .update-info').show();
			});
		});
	</script>
	
	<script type="text/javascript">
		$(document).ready(function() {
			var os_c = 0, cs_c = 0;
			for (var i=1 ; i<=3 ; i++) {
			
				var infoFormData = {
					'course_id': i
				};
				
				$.ajax({
					type: "POST",
					url: "load_course_profile_progress.php",
					data: infoFormData,
					success: function(data){
						if(data.indexOf("progress") > -1) {
							$("#os").append(data);
							os_c = 1;
						} else if(data.indexOf("Completed") > -1) {
							$("#cs").append(data);
							cs_c = 1;
						}
					}
				});
			}
			/*
			if(os_c == 0){
				$("#os").append("<div class='row'><div class='col-sm-4 c-title'><p>No course to show..!!</p></div><div class='col-sm-5 status'><p></p></div><div class='fa fa-angle-right arrow'></div></div>");
			}
			
			if(cs_c == 0){
				$("#cs").append("<div class='row'><div class='col-sm-4 c-title'><p>No course to show..!!</p></div><div class='col-sm-5 status'><p></p></div><div class='fa fa-angle-right arrow'></div></div>");
			}
			*/
		});
	</script>
	
	
	<script type="text/javascript">
		$("#update_cancel").on("click",function(e){
			e.preventDefault();
			$('.profile .user-info .update-info').hide();
			$('.profile .user-info .current-info').show();
		});
		
		var confirm_new_password = false;

		$("#user_confirm_new_pass").on("keyup",function(){
			if($(this).val() != "") {
				if ($(this).val() == $("#user_new_pass").val()) {
					confirm_new_password = true;
				} else {
					confirm_new_password = false;
				}				
			}
		});
		
		$("#update_user_info").on("submit",function(e){
			e.preventDefault();
			
			var update_user_new_name = $("#update_user_new_name").val();
			
			var user_new_pass = $("#user_new_pass").val();
			
			if (user_new_pass == "") {
				confirm_new_password = true;
			}
				
			if (update_user_new_name == "") {
				$("#pass_error_box").html("Please Enter Your Full Name");
			} else if (!confirm_new_password) {
				$("#pass_error_box").html("Password didn't match, Please try again.");
			} else {
			
				var infoFormData = {
					'update_user_new_name': update_user_new_name
				};
				
				$.ajax({
					type: "POST",
					url: "update_user_info.php",
					data: infoFormData,
					success: function(data){
						$("#disp_user_name").html(update_user_new_name);
						document.title = update_user_new_name;
					}
				});
				
				
				if (user_new_pass != "") {
					
					var passFormData = {
						'user_new_pass': user_new_pass
					};
	
					$.ajax({
						type: "POST",
						url: "update_user_password.php",
						data: passFormData,
						success: function(data){
							console.log(data);
							if (data == "go") {					
								$("#pass_error_box").html("password successfully changed..!!");
								$("#user_new_pass").val("");
								$("#user_confirm_new_pass").val("");
								$("#user_confirm_new_pass").blur();
								setTimeout(function(){
									$("#pass_error_box").html("");
								},3000);
							} else if (data == "halt") {
								$("#pass_error_box").html("Password must contain both characters and numeric..!!");
								$("#user_new_pass").val("");
								$("#user_confirm_new_pass").val("");
								$("#user_confirm_new_pass").css("border-color","");
							}
						}
					});
				}
				
				
				if (user_new_pass != "") {
					setTimeout(function(){		
						$(".update-info").hide();			
						$(".current-info").show();
					},3000);
				} else {
					$(".update-info").hide();			
					$(".current-info").show();
				}
			}
		});
	</script>

</body>
</html>
<?php mysqli_close($link); ?>
						
							    