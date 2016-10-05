<?php @session_start();

	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db) or die ("<html><script language='JavaScript'>alert('Failed')</script></html>");
	
	if(isset($_SESSION['u_id'])) {
		$user_id = $_SESSION['u_id'];
		$query = "SELECT `name` FROM `users` WHERE `id`=?";
		$statement = mysqli_prepare($link,$query);
		mysqli_stmt_bind_param($statement,'i', $user_id);
		mysqli_stmt_execute($statement);
		mysqli_stmt_bind_result($statement, $user_name);
		mysqli_stmt_fetch($statement);
		mysqli_stmt_close($statement);	
	}

	$query = "SELECT `id`, `title`, `details` , `icon` FROM `courses`";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $course_id, $course_title, $course_details, $course_icon);

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="icon" type="image/png" href="images/logo_small.png">
	<title>Orenda | All Courses</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/coursePage.min.css">
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
	<?php  require("header.php"); ?>

	<div class="main-body">

	<div class="cover-element"></div>
	
	<div class="courses" style="padding-top: 100px">
	<div class="container">
	<header>
		<?php if(isset($_SESSION['u_id'])) { ?>
			<h1>Welcome <b><?php echo $user_name; ?></b>!</h1>
		<?php } else{ ?>
			<h1>Welcome!</h1>
		<?php } ?>
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
						<img src="images/courses/<?php echo $course_icon; ?>" alt="Course - <?php echo $course_title; ?>">
					</div>
					<div class="course-info">
						<h3><?php echo $course_title; ?></h3>
						<p><?php echo $course_details; ?></p>
					</div>
					
					<div id="load_prog_<?php echo $course_id; ?>" style="display:block"></div>
				</a>
			</div>

		<?php	}	mysqli_stmt_close($statement);		?>

	</div>
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
		});
	</script>
	
</body>
</html>
<?php mysqli_close($link); ?>