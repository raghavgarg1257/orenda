<?php 
	@session_start();

	if(isset($_SESSION['u_id'])) {
		$user_id = $_SESSION['u_id'];
	} 
//	else {
//		header("Location:login.php");
//	}

	if (isset($_SESSION['fb_id'])) {
		$user_fb_id = $_SESSION['fb_id'];
	}
	
	if (isset($_SESSION['g_id'])) {
		$user_g_id = $_SESSION['g_id'];
	}

	if ($_GET['name'] == "" ) {
		header("Location:index.php");
	} else {
		$course_id = str_replace('virtut', '', base64_decode($_GET['name']));
	}

	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db);

	$query = "SELECT `title`, `icon`, `details`, `instructor_name`, `instructor_pic_link`, `instructor_details`, `instructor_links` FROM `courses` WHERE `id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'i', $course_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $course_title, $course_icon, $course_details, $instructor_name, $instructor_pic_link, $instructor_details, $instructor_links);

	mysqli_stmt_store_result($statement);
	if ( mysqli_stmt_num_rows($statement) == 0 ) {
		header("Location:courses.php");
	}
	
	mysqli_stmt_fetch($statement);
	mysqli_stmt_close($statement);	

	$query = "SELECT `id`, `title`, `brief` FROM `assignments` WHERE `course_id`=? ORDER BY `order` ASC";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'i', $course_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $assignment_id, $assignment_title, $assignment_brief);

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="icon" type="image/png" href="images/logo_small.png">
	<title>Orenda | <?php echo $course_title; ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/aboutCourse.min.css">
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

	<?php  require "header.php"; ?>
	
	<div class="main-body">

		<div class="cover-element"></div>
		
		<div class="about-course">
			
			<header style="position: relative; padding-bottom: 30px; padding-top: 100px">
				<div class="course-heading">
					<h3><?php echo $course_title; ?></h3>
					<p><?php echo $course_details; ?></p>
					<div id="load_prog"></div>
				</div>
				
				<?php mysqli_stmt_fetch($statement); $ass_link = $assignment_id; ?>
				<a href="assignment.php?name=<?php echo str_replace('==', '', base64_encode($assignment_id.'virtut')); ?>">
					<div class="strt-btn" style="text-align:center; display:none;" id="course_start">
						<button style="margin-top: 8px">Start Now</button>
					</div>
				</a>
			</header>
			
			<div class="row" style="width: 100%; margin: 0; background: rgb(234,234,235)">
				<div class="assignments col-md-8">
				<div class="assign">
					<ul style="list-style: none; margin: 0; margin-top: 100px">
		
						<?php $i=1; $k=0; do{	?>
							<a href="assignment.php?name=<?php echo str_replace('==', '', base64_encode($assignment_id.'virtut')); ?>">
								<li class="container">
									<div class="col-xs-3 col-sm-2">
										<div id="assignment_<?php echo $i; ?>" class="check"></div>
									</div>
									<div class="col-xs-10">
										<h3><?php echo $assignment_title ?></h3>
										<p><?php echo $assignment_brief ?></p>
									</div>
								</li>
							</a>
						<?php		$i++; @$k = $k.",".$assignment_id;	
							}while (mysqli_stmt_fetch($statement));		mysqli_stmt_close($statement);	?>
					</ul>
				</div>
			</div>
			
			<div class="col-md-4 ins-info">
				<div class="about-instructor">
					<h3 style="padding-top: 20px; padding-bottom: 20px; width: 100%" class="heading">Meet the Instructor</h3>
					<div class="container" style="width: 100%"> 
						<div  style="margin-top: 25px; padding-bottom: 50px">
			
							<div class="description">
								<img src="images/users/<?php echo $instructor_pic_link ?>"  alt="Instructor - <?php echo $instructor_name; ?>">
								<h3><?php echo $instructor_name; ?></h3>
								<div class="row ins-media-links" style="margin: 0">
									<?php 
										$links = explode(" ", $instructor_links);
										$facebook = 0;	$linkedin = 0;	$google = 0;
										if($links[0] != ""){
											if(strstr($links[0],"facebook"))
												$facebook = 1;
										}
										if($links[1] != ""){
											if(strstr($links[1],"linkedin"))
												$linkedin = 1;
										}
										if($links[2] != ""){
											if(strstr($links[2],"google"))
												$google = 1;
										}
										
										$count = $facebook + $linkedin + $google;
										if($count != 0) {
											$partition = 12/$count;
										} else {
											$partition = 12;
										}
													
										if($facebook == 1){
									?>
										<div class="col-xs-<?php echo $partition; ?>">
											<a href="<?php echo $links[0]; ?>">
												<i class="fa fa-facebook" style="background: rgb(55,82,141)"></i><p style="background: rgb(59,89,152)">Facebook</p>
											</a>
										</div>
									<?php 
										}
										if($linkedin == 1){
									?>
										<div class="col-xs-<?php echo $partition; ?>">
											<a href="<?php echo $links[1]; ?>">
												<i class="fa fa-linkedin" style="background: rgb(1,119,181)"></i><p style="background: rgba(1,119,181,0.9)">Linkedin</p>
											</a>
										</div>
									<?php 
										}
										if($google == 1){
									?>
										<div class="col-xs-<?php echo $partition; ?>">
											<a href="<?php echo $links[2]; ?>">
												<i class="fa fa-google-plus" style="background: rgb(205,69,53)"></i><p style="background: rgb(221,75,57)">Google</p>
											</a>
										</div>
									<?php	
										} 
									?>
								</div>
								<p><?php echo $instructor_details; ?></p>
							</div>
			
						</div>
					</div>
				</div>
			</div>	
			
		</div>	
		
		<?php require "footer.php"; ?>
	</div>	
	
	
	<?php require "contact_modal.php"; ?>
	
	<script type="text/javascript" src="./js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="./js/bootstrap.min.js"></script>
	<script type="text/javascript" src="./js/navigation.min.js"></script>
	<script type="text/javascript" src="./js/aboutCourse.min.js"></script>
	<script type="text/javascript">

		$(document).ready(function() {
		
			console.log("loaded progress..!!");

			$("#load_prog").load(
				"load_course_assignment_progress.php",{
					course_id : <?php echo $course_id; ?>,
					assignment_id: <?php echo $ass_link;?>
				},function(response){
					if(response == ""){
						$("#course_start").show();
					} else {
						$("#course_start").html("");
					}
				});

			var rtg = "<?php echo $k; ?>";
			var ids = rtg.split(",");
			for (var j=1 ; j<<?php echo $i; ?> ; j++) {
				var id = "#assignment_" + j;
				var asgnmnt_link = ids[j];
				$(id).load(
					"load_assignment_progress.php",{
						assignment_id: ids[j]
					},function(response, status, xhr){
						if($('#load_prog').html() != ""){
							if($('#load_prog').html().indexOf("progress-info") > -1){
								$.ajax({
									type: 'POST',
									url: 'load_cnt_btn.php',
									data: { 'asgnmnt_link': asgnmnt_link },
									success: function(data){
										$("#course_start").html(data);
										$("#course_start").show();
									}
								});
							}
						}
					});
			}
		});
	</script>
	
	
</body>
</html>
<?php mysqli_close($link); ?>