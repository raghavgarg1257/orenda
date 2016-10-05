<?php 
	@session_start();

	if (isset($_SESSION['u_id'])) {
		$user_id = $_SESSION['u_id'];
	}

	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db);

	$course_id = $_POST['course_id'];
	$assignment_id = $_POST['assignment_id'];

	$query = "SELECT count(`id`) FROM `assignment_question` WHERE `course_id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'i', $course_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $total_assignment_question);
	mysqli_stmt_fetch($statement);
	mysqli_stmt_close($statement);
	
	$query = "SELECT count(`id`) FROM `video_question` WHERE `course_id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'i', $course_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $total_video_question);
	mysqli_stmt_fetch($statement);
	mysqli_stmt_close($statement);
	
	$total_course_question = $total_assignment_question + $total_video_question;
	
	if($total_course_question == 0){
		$assignment_link = str_replace('==', '', base64_encode($assignment_id.'virtut'));
		echo "<a href='assignment.php?name=$assignment_link'><div class='strt-btn'><button style='margin-top: 8px'>Start Now</button></div></a>";
		die;
	}

	$query = "SELECT count(`id`) FROM `assignment_answer` WHERE `course_id`=? AND `user_id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'ii', $course_id, $user_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $total_user_assignment_answer);
	mysqli_stmt_fetch($statement);
	mysqli_stmt_close($statement);
	
	$query = "SELECT count(`id`) FROM `video_answer` WHERE `course_id`=? AND `user_id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'ii', $course_id, $user_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $total_user_video_answer);
	mysqli_stmt_fetch($statement);
	mysqli_stmt_close($statement);
	
	$total_user_course_answer = $total_user_assignment_answer + $total_user_video_answer;
	
	$perc_prog = floor(100*$total_user_course_answer/$total_course_question);

	if($perc_prog != 0) {
		if($perc_prog == 100){
			echo "<div class='complete'><i class='fa fa-check-circle' style='font-weight: 600'>&nbsp;</i><p>Completed</p></div>";
		} else {
			echo "
				<div class='progress-info' style='padding:8px 0 0; text-align:center'>
					<div class='progress' style='height: 6px; border-radius: 0; width: 77%; margin: 0; display: inline-block; vertical-align: middle'>
						<div 
							class='progress-bar' 
							role='progressbar' 
							aria-valuenow='$perc_prog' 
							aria-valuemin='0' 
							aria-valuemax='100' 
							style='min-width:0em; width:$perc_prog%;'>
						</div>
					</div>
					<p style='display: inline-block; font-size: 16px; margin: 0; vertical-align: middle; padding-left: 5px; font-weight: 600'>$perc_prog%</p>
				</div>
			";
		}
	}

	mysqli_close($link);
?>