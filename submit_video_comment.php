<?php 
	@session_start();

	if (isset($_SESSION['u_id'])) {
		$user_id = $_SESSION['u_id'];
	}

	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db);

	function sanitize($data) {
		global $link;
		$data = trim($data);
		$data = mysqli_real_escape_string($link, $data);
		return $data;
	}

	$comment_video_id = sanitize($_POST['comment_video_id']);
	$comment_written = sanitize($_POST['comment_written']);
	$comment_timestamp = date("Y-m-d H:i:s");

	$query = "INSERT INTO `video_comment`(`time`, `user_id`, `video_id`, `detail`) VALUES (?,?,?,?)";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'siis', $comment_timestamp, $user_id , $comment_video_id, $comment_written);
	mysqli_stmt_execute($statement);
	mysqli_stmt_close($statement);

	$query = "SELECT `id` FROM `video_comment` WHERE `time`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 's', $comment_timestamp);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $comment_id);
	mysqli_stmt_fetch($statement);
	mysqli_stmt_close($statement);

	$query = "SELECT `name`, `profile_pic`, `fb_id`, `g_id` FROM `users` WHERE `id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'i', $user_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $cmntr_user_name, $cmntr_user_profile_pic, $cmntr_user_fb_id, $cmntr_user_g_id);
	mysqli_stmt_fetch($statement);
	mysqli_stmt_close($statement);

	echo "
		$comment_id&
		<div class='welldone text-left col-lg-12 rply_bx'>
			<div id='cmnt_$comment_id' class='indv_cmnt'>
				<div>
					<img 
				";	
						if ($cmntr_user_fb_id != 0) {	
							echo "src='http://graph.facebook.com/$cmntr_user_fb_id/picture'";
						} else if($cmntr_user_g_id != 0){
							echo "src=$cmntr_user_profile_pic";
						} else { 	
							echo "src='images/users/$cmntr_user_profile_pic'";
						}	
				echo "	width='50px'
					class=''
					style='float:left'
					/>
					<span class='disp_name'>$cmntr_user_name</span>
					<span class='disp_time_stamp'>at $comment_timestamp</span>
				</div>
				<div>
					<span class='disp_details'>".nl2br($comment_written)."</span>
				</div>
				<div id='clr_cmnt_$comment_id' class='clr_cmnt disp_del' style='display:none; margin:-20px 0; color:#808080; font-size:12px;'>delete</div>
			</div>
			<div id='load_reply_$comment_id' class='replies'></div>
		</div>
	";

	mysqli_close($link);
?>

<script type="text/javascript">
	$(document).ready(function(){
		$("#load_reply_<?php echo $comment_id; ?>").load("video_reply.php",{
			cmnt_id : <?php echo $comment_id; ?>
		});
	});
</script>