<?php 
	@session_start();
	
	if (isset($_SESSION['u_id'])) {
		$user_id = $_SESSION['u_id'];
	}

	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db); 

	$cmnt_id = $_POST['cmnt_id'];
?>
<?php 
	if (isset($_SESSION['u_id'])) {

		$query = "SELECT `name`, `profile_pic`, `fb_id`, `g_id` FROM `users` WHERE `id`=?";
		$statement = mysqli_prepare($link, $query);
		mysqli_stmt_bind_param($statement, 'i', $user_id);
		mysqli_stmt_execute($statement);
		mysqli_stmt_bind_result($statement, $user_name, $user_profile_pic, $user_fb_id, $user_g_id);
		mysqli_stmt_fetch($statement);
		mysqli_stmt_close($statement);

		?>
		<!--	Reply Form	-->
		<div class="welldone" style="margin:0">
			<div class="form-inline">
				<div class="form-group">
					<form method="post" action="#" name="reply_submit_form" id="reply_submit_form_<?php echo $cmnt_id; ?>" style="display: inline-block;">
						<img 
							<?php	
							if ($user_fb_id != 0) {	
								echo "src='http://graph.facebook.com/$user_fb_id/picture'";
							} else if($user_g_id != 0){
								echo "src='$user_profile_pic'";
							} else { 	
								echo "src='images/users/$user_profile_pic'";
							}	
							?>
							width="50px"
							style="float:left;"
						/>
						<span class="disp_name"><?php echo $user_name; ?></span>
						<input type="hidden" name="reply_cmnt_id" id="" class="reply_cmnt_id" value="<?php echo $cmnt_id; ?>" />
						<input type="text" name="reply_written" id="" class="reply_written form-control"  placeholder="Reply here..!!" />
						<input type="submit" name="submit_reply" id="submit_reply" class="btn btn-default" value="Send" />
					</form>
				</div>
			</div>
		</div>
<?php	}	?>

<div class="all_replies">
	<?php 
		$query = "SELECT `time`, `id`, `user_id`, `detail` FROM `video_reply` WHERE `comment_id`=? ORDER BY `time` DESC";
		$statement = mysqli_prepare($link, $query);
		mysqli_stmt_bind_param($statement, 'i', $cmnt_id);
		mysqli_stmt_execute($statement);
		mysqli_stmt_bind_result($statement, $reply_time, $reply_id, $reply_user_id, $reply_details);
		
		while(mysqli_stmt_fetch($statement)) {
			$replyr_link = mysqli_connect($_srvr, $_user, $_pass, $_db);
			$replyr_query = "SELECT `name`, `profile_pic`, `fb_id`, `g_id` FROM `users` WHERE `id`=?";
			$replyr_statement = mysqli_prepare($replyr_link, $replyr_query);
			mysqli_stmt_bind_param($replyr_statement, 'i', $reply_user_id);
			mysqli_stmt_execute($replyr_statement);
			mysqli_stmt_bind_result($replyr_statement, $replyr_name, $replyr_profile_pic, $replyr_fb_id, $replyr_g_id);
			mysqli_stmt_fetch($replyr_statement);
			mysqli_stmt_close($replyr_statement);
			mysqli_close($replyr_link);
			?>
			<div id="reply_<?php echo $reply_id;?>" class="indv_reply welldone" style="padding:10px 10px 20px; background:#DADADA;">
				<div>
					<img 
						<?php	
						if ($replyr_fb_id != 0) {	
							echo "src='http://graph.facebook.com/$replyr_fb_id/picture'";
						} else if($replyr_g_id != 0){
							echo "src='$replyr_profile_pic'";					
						} else { 	
							echo "src='images/users/$replyr_profile_pic'";
						}	
						?>
						width="50px"
						style="float:left;"
					/>
					<span class="disp_name"><?php echo $replyr_name; ?></span>
					<span class="disp_time_stamp">at <?php echo $reply_time; ?></span>
				</div>
				<div>
					<span class="disp_details"><?php echo nl2br($reply_details); ?></span>
					<?php	if ($reply_user_id == $user_id) {	?>
						<div id="clr_reply_<?php echo $reply_id;?>" class="clr_reply disp_del" style="color:#808080; font-size:12px;">delete</div>
					<?php	}	?>
				</div>
			</div>
			<?php
		}
		mysqli_stmt_close($statement);
	?>
</div>
<?php mysqli_close($link); ?>

<script type="text/javascript">
	$(document).ready(function(){

		$(".clr_reply").hide();

		$(".all_replies").on("mouseenter",".indv_reply",function(){
			//$(this).children().last().show();
			$(this).find(".clr_reply").show();
		});

		$(".all_replies").on("mouseleave",".indv_reply",function(){
			//$(this).children().last().hide();
			$(this).find(".clr_reply").hide();
		});

		$(".all_replies").on("click",".clr_reply",function(){
			var clr_reply_no = $(this).attr("id");
			var reply_no = clr_reply_no.replace("clr_","");
			var reply_id = clr_reply_no.replace("clr_reply_","");
			//alert(reply_no);
			
			var formData = {
				'reply_id': reply_id
			};

			$.ajax({
				type: "POST",
				url: "clear_video_reply.php",
				data: formData,
				success: function(data){
					//alert(data);
					$("#" + reply_no).hide();
				}
			});
		});

		$("#reply_submit_form_<?php echo $cmnt_id; ?>").on("submit",function(e){

			e.preventDefault();
			var reply_cmnt_id_ele = $(this).find(".reply_cmnt_id");
			var reply_written_ele = $(this).find(".reply_written");

			var nxt = $(this).parent().parent().parent().siblings(".all_replies");

			var reply_cmnt_id = reply_cmnt_id_ele.val();
			var reply_written = reply_written_ele.val();

			console.log(reply_cmnt_id + "<br/>" + reply_written);

			if (reply_written == "") {
				alert("Please write comment first");
			}
			else{
				var formData = {
					'reply_cmnt_id': reply_cmnt_id,
					'reply_written': reply_written
				};

				$.ajax({
					type: "POST",
					url: "submit_video_reply.php",
					data: formData,
					success: function(data){
						//alert(data);
						reply_written_ele.val("");
						nxt.prepend(data);
					}
				});
			}
		});
	});
</script>