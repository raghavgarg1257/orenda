<?php 
	@session_start();

	if(isset($_SESSION['u_id'])) {
		$user_id = $_SESSION['u_id'];
	}

	if (isset($_SESSION['fb_id'])) {
		$user_fb_id = $_SESSION['fb_id'];
	}

	$video_id = $_POST['video_id'];

	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db);

	$query = "SELECT `id`, `title`, `details`, `link`, `assignment_id` FROM `videos` WHERE `id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'i', $video_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $video_id, $video_title, $video_details, $video_link, $video_assignment_id);
	mysqli_stmt_fetch($statement);
	mysqli_stmt_close($statement);
?>
<div class="text-center">
	
	<div class="text-center video-head"><h2><?php echo $video_title; ?></h2></div>
	<br>
	<div class="embed-responsive embed-responsive-16by9">
		<div id="vid_player_<?php echo $video_id; ?>"></div>
		<iframe src="http://www.youtube.com/embed/<?php echo $video_link; ?>?enablejsapi=1"allowfullscreen></iframe>
	</div>
	<br>
	<div class="description text-left"><p>
		<?php 
			$video_details= htmlspecialchars($video_details, ENT_QUOTES);
			$video_details= str_replace("[br]","<br>",$video_details);
			$video_details= str_replace("[em]","<em>",$video_details);
			$video_details= str_replace("[/em]","</em>",$video_details);
			$video_details= str_replace("[strong]","<strong>",$video_details);
			$video_details= str_replace("[/strong]","</strong>",$video_details);
			$video_details= str_replace("[code]","<code style='display:block; white-space:pre-wrap'>",$video_details);
			$video_details= str_replace("[/code]","</code>",$video_details);
			$video_details= str_replace("[space]","&nbsp;",$video_details);
			$video_details= nl2br($video_details); 
		//	echo htmlspecialchars($video_details);
			echo $video_details;
		?>
	</p></div>
	<div id="questions"></div>
	<div id="comments"></div>
	
</div>
<script type="text/javascript">
	$(function(){
		$("#questions").load("video_question.php", { video_id:"<?php echo $video_id; ?>" });
		$("#comments").load("video_comment.php", { video_id:"<?php echo $video_id; ?>" });

		$.getScript('http://www.youtube.com/player_api');	
		function onYouTubePlayerAPIReady(){ console.log('youtube api is ready..!!'); }
	});

	var player = new YT.Player( $('iframe').get(0), { 
		events: { 
			'onReady': onPlayerReady
//			'onStateChange': onPlayerStateChange 
		} 
	});

	function onPlayerReady (event) {
		console.log("video loaded");
	}
	
/*	function onPlayerStateChange(event) {
		if (event.data == YT.PlayerState.PLAYING) {
			//console.log("course started");
			var sendData = {
				'assignment_id': <?php echo $video_assignment_id; ?>
			};

			$.ajax({
				type: "POST",
				url: "start_course.php",
				data: sendData,
				success: function(data){
					console.log(data);
				}
			});
		}
	}
*/
</script>
<?php mysqli_close($link); ?>