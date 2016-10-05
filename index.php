<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="icon" type="image/png" href="images/logo_small.png">
	<title>Orenda | Where Knowledge Brings Real Power</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="language" content="english">
	<meta name="description" content="Learn programming and much more for free through video tutorials and exciting quizzes.">
	<meta name="keywords" content="Orenda, techorenda, orendatech, virtual tutorials, short videos, unique course, great learning 		 platform, develop smart devices, easy learn to code, programming, web development, web designing, videos and documentation, learn to code, Courses, Learn, knowledge, learn programming, journey">  
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/homepage.min.css">
	<link rel="stylesheet" type="text/css" href="css/coursePage.min.css">
	<link href='https://fonts.googleapis.com/css?family=Raleway:400' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300' rel='stylesheet' type='text/css'>
	
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

	<img class="web_egg" src="images/easter-logo.gif" style="z-index:10000; position:fixed; width:100%; height:100%; display:none;" alt="Web Easter Egg">

	<?php  require("header.php"); ?>

	<div class="main-body">

	<div class="cover-element"></div>

		<div class="feedback-form" style="background: rgb(230,230,230)">
			<button class="btn btn-primary feedback-btn" type="submit">Feedback</button>
			<h3>Leave us a feedback</h3>
			<div class="feedback-body">
				<form method="POST" action="#" name="feedback_form" id="feedback_form">
					<input type="email" name="feedback_email" id="feedback_email" placeholder="Email" autocomplete="on" class="input-field" required><br>
					<input type="text" name="feedback_name" id="feedback_name" placeholder="Name" autocomplete="on" class="input-field" required><br>
					<textarea name="feedback_msg" id="feedback_msg" placeholder="Enter Your Message" class="input-field" rows="5" required></textarea><br>
					<input type="submit" name="feedback_form_submit" id="feedback_form_submit" value="SUBMIT" class="btn btn-success input-field">
				</form>
			</div>
			<div class="feedback-footer" >
				<h1>Thank you for your feedback.<br><span>We appreciate your contribution!</span></h1>
			</div>	
		</div>

		<div class="main-section">
			<div class="cover-section" style="display: table">
				<div class="container-1">
					<p style="margin-bottom: 0; line-height: 1.2" id="heading">Learn programming and much more, for free.</p>
					<p id="sub-heading">Start your journey with us within seconds.</p>
					<a href="courses.php"><button class="btn btn-success" style="font-size: 18px; padding: 12px 20px; font-weight: 500; letter-spacing: 1px; margin-top: 20px; border-radius: 2px">Start Learning Now</button></a>
				</div>	
			</div>
		</div>

		<!--- <div class="video-section" id="123">
			<div class="container">
				<div class="col-md-4">
					<h2>Why you should learn programming?</h2>
					<p>Hear from our founders about how programming can change your life </p>
				</div>
				<div class="col-md-8">
					<video controls>
						<source src="#" type="video/mp4">
					</video>
				</div>
			</div>
		</div> --->
		
		<?php
			require("db.php");
			$link = mysqli_connect($_srvr, $_user, $_pass, $_db);
			
			$query = "SELECT `id`, `title`, `details` , `icon` FROM `courses`";
			$statement = mysqli_prepare($link, $query);
			mysqli_stmt_execute($statement);
			mysqli_stmt_bind_result($statement, $course_id, $course_title, $course_details, $course_icon);
			
		?>
	
		<div class="courses">
		<div class="container">
		<header>
			<h1>Stuff that we teach here</h1>
			<p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.</p>
		</header>
			<div class="row">
	
				<?php	$count_course = 0;	
					while (mysqli_stmt_fetch($statement)) {	
						$count_course++;	
				?>			
					<div class="col-md-4 col-sm-6 course">
						<a 
							<?php if ($course_id == 3){    ?>
								href=""
								id="rasp_pi"
							<?php    } else {    ?>
								href="course.php?name=<?php echo str_replace('==', '', base64_encode($course_id.'virtut')); ?>"
							<?php    }    ?>
						>
							<div class="course-image">
								<img src="images/courses/<?php echo $course_icon; ?>" alt="course - <?php echo $course_title; ?>">
							</div>
							<div class="course-info">
								<h3><?php echo $course_title; ?></h3>
								<p><?php echo $course_details; ?></p>
							</div>
							
							<div id="load_prog_<?php echo $course_id; ?>" style="display:block"></div>
						</a>
					</div>
		
				<?php	}	mysqli_stmt_close($statement);	mysqli_close($link);		?>
			</div>
		</div>
		</div>
	
		<div class="quote">
			<div class="container">
				<h1>"Everybody in this country should learn how to program a computer...<br> because it teaches you how to think."</h1>
				<p>Steve Jobs</p>
			</div>
		</div>
	
		<?php require("footer.php"); ?>
	
	</div>	
	
	<?php require("contact_modal.php"); ?>
	
	<script type="text/javascript" src="./js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="./js/bootstrap.min.js"></script>
	<script type="text/javascript" src="./js/navigation.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".feedback-btn").click(function(){
				$(".feedback-form").toggleClass("slide");
			});
			
			for (var i=1 ; i<=<?php echo $count_course; ?> ; i++) {
				var load_prog_id = "#load_prog_"+i;
				$(load_prog_id).load(
					"load_course_progress.php",{
						course_id : i
					});
			}
			
			$("rasp_pi").on("click",function(e){
				e.preventDefault();
			});
	
			$("#feedback_form").on("submit",function(e){	
				e.preventDefault();// prevent native form submission here

				var formData = {
					'email': $('#feedback_email').val(),
					'name': $('#feedback_name').val(),
					'msg': $('#feedback_msg').val() 
				};
				
				console.log($('#feedback_email').val());
				console.log($('#feedback_name').val());
				console.log($('#feedback_msg').val());
				
				if ( ($('#feedback_email').val() != "") && ($('#feedback_name').val() != "") && ($('#feedback_msg').val() != "") ) {
					$.ajax({
						type: "POST",
						url: "save_contact_msg.php",
						data: formData,
						success: function(data){
							console.log("conntact: " + data);
							if (data == "not_valid") {
								$('#feedback_email').val("");
							}
							if (data == "saved") {
								$(".feedback-footer").addClass("slidein");
								
								$('#feedback_email').val("");
								$('#feedback_name').val("");
								$('#feedback_msg').val("");
								
								setTimeout(function(){
									$(".feedback-form").removeClass("slide");
									$(".feedback-footer").removeClass("slidein");
								},2000);						
							}
						}
					});
				}	
			});
			
			$.ajax({url: "save_visitor_details.php"});
		});
	</script>
	<script type="text/javascript">
		var secret = "ORENDA"; 
		var input = "";
		var timer;
		$(document).keyup(function(e) {
			input += String.fromCharCode(e.which); 
			clearTimeout(timer);
			timer = setTimeout(function() { input = ""; }, 1000);
			if(input == secret) {
				console.log("You found me");
				$(".web_egg").show();
				setTimeout(function(){ $(".web_egg").hide(); }, 7000);
			}
		});
	</script>

</body>
</html>