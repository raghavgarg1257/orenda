<?php 
	@session_start();
	
	if (isset($_SESSION['u_id'])) {
		$user_id = $_SESSION['u_id'];
	}

	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db); 

	$video_id = $_POST['video_id'];
?>
<div class="comments">
<h3>Comments</h3>
</div>
<div class="text-left"></div>

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
		<!--	Comment Form	-->
		<div class="text-left">
			<div class="form-inline">
				<div class="form-group">
					<form method="post" action="#" name="comment_submit_form" id="comment_submit_form" style="display: inline-block;">
						<img 
							<?php	
							if ($user_fb_id != 0) {	
								echo "src='http://graph.facebook.com/$user_fb_id/picture'";
							} else if($user_g_id != 0){
								echo "src=$user_profile_pic";					
							} else { 	
								echo "src='images/users/$user_profile_pic'";
							}	
							?>
							width="50px"
							style="float:left;"
						/>
						<span class="disp_name"><?php echo $user_name; ?></span>
						<input type="hidden" name="comment_video_id" id="comment_video_id" value="<?php echo $video_id; ?>" />
						<input type="text" name="comment_written" id="comment_written" class="form-control"  placeholder="Comment here..!!" />
						<input type="submit" name="submit_comment" id="submit_comment" class="btn btn-default"  value="Send" />
					</form>
				</div>
			</div>
		</div>
<?php	}	?>

<div id="all_comments" style="margin-bottom:50px;">
	<?php 
		$query = "SELECT `time`, `id`, `user_id`, `detail` FROM `video_comment` WHERE `video_id`=? ORDER BY `time` DESC";
		$statement = mysqli_prepare($link, $query);
		mysqli_stmt_bind_param($statement, 'i', $video_id);
		mysqli_stmt_execute($statement);
		mysqli_stmt_bind_result($statement, $cmnt_time, $cmnt_id, $cmnt_user_id, $cmnt_details);
		
		$i=1; $k=0;

		while(mysqli_stmt_fetch($statement)) {
			$cmntr_link = mysqli_connect($_srvr, $_user, $_pass, $_db);
			$cmntr_query = "SELECT `name`, `profile_pic`, `fb_id`, `g_id` FROM `users` WHERE `id`=?";
			$cmntr_statement = mysqli_prepare($cmntr_link, $cmntr_query);
			mysqli_stmt_bind_param($cmntr_statement, 'i', $cmnt_user_id);
			mysqli_stmt_execute($cmntr_statement);
			mysqli_stmt_bind_result($cmntr_statement, $cmntr_name, $cmntr_profile_pic, $cmntr_fb_id, $cmntr_g_id);
			mysqli_stmt_fetch($cmntr_statement);
			mysqli_stmt_close($cmntr_statement);
			mysqli_close($cmntr_link);
			?>
			<div class="welldone text-left col-lg-12 rply_bx">
				<div id="cmnt_<?php echo $cmnt_id;?>" class="indv_cmnt">
					<div>
						<img 
							<?php	
							if ($cmntr_fb_id != 0) {	
								echo "src='http://graph.facebook.com/$cmntr_fb_id/picture'";
							} else if($cmntr_g_id != 0){
								echo "src=$cmntr_profile_pic";					
							} else { 	
								echo "src='images/users/$cmntr_profile_pic'";
							}	
							?>
							width="50px"
							style="float:left;"
						/>
						<span class="disp_name"><?php echo $cmntr_name; ?></span>
						<span class="disp_time_stamp">at <?php echo $cmnt_time; ?></span>
					</div>
					<div>
						<div>
							<span class="disp_details"><?php echo nl2br($cmnt_details); ?></span>
						</div>
						<?php	if ($cmnt_user_id == $user_id) {	?>
							<div id="clr_cmnt_<?php echo $cmnt_id;?>" class="clr_cmnt disp_del" style="margin:-20px 0; color:#808080; font-size:12px;">delete</div>
						<?php	}	?>
					</div>
				</div><!--end of individual comment-->

				<div id="load_reply_<?php echo $cmnt_id; ?>" class="replies"></div>	

			</div>
			<?php
			++$i;
			@$k = $k.",".$cmnt_id;
		}
		mysqli_stmt_close($statement);
	?>
</div>
<?php mysqli_close($link); ?>
<script type="text/javascript">
	$(document).ready(function(){
		var data = '<?php echo $k; ?>';
		var ids = data.split(",");
	//	console.log(ids);

		for (var j=1 ; j<<?php echo $i; ?> ; j++) {
			var id = "#load_reply_" + ids[j];
//			console.log("reply id: " + id);
//			console.log("ids: " + ids[j]);

			$(id).load("video_reply.php",{
				cmnt_id: ids[j]
			});
		}
	});
</script>
<script type="text/javascript">

	$(document).ready(function(){

		//$("#replies").load("video_reply.php", { cmnt_id:<?php echo $cmnt_id; ?> });

		$(".clr_cmnt").hide();

		$("#all_comments").on("mouseenter",".indv_cmnt",function(){
			//$(this).children().last().show();
			$(this).find(".clr_cmnt").show();
		});

		$("#all_comments").on("mouseleave",".indv_cmnt",function(){
			//$(this).children().last().hide();
			$(this).find(".clr_cmnt").hide();
		});

		$("#all_comments").on("click",".clr_cmnt",function(){
			var clr_cmnt_no = $(this).attr("id");
			var cmnt_no = clr_cmnt_no.replace("clr_","");
			var comment_id = clr_cmnt_no.replace("clr_cmnt_","");
			//alert(cmnt_no);
			
			var formData = {
				'comment_id': comment_id
			};

			$.ajax({
				type: "POST",
				url: "clear_video_comment.php",
				data: formData,
				success: function(data){
					//alert(data);
					$("#" + cmnt_no).parent(".rply_bx").hide();
					$("#" + cmnt_no).siblings(".replies").hide();
					$("#" + cmnt_no).hide();
				}
			});
		});

		$("#comment_submit_form").on("submit",function(e){

			e.preventDefault();

			var comment_video_id = $("#comment_video_id").val();
			var comment_written = $("#comment_written").val();

			//alert(comment_video_id + "<br/>" + comment_written);

			if (comment_written == "") {
				alert("Please write comment first");
			}
			else{
				var formData = {
					'comment_video_id': comment_video_id,
					'comment_written': comment_written
				};

				$.ajax({
					type: "POST",
					url: "submit_video_comment.php",
					data: formData,
					success: function(data){
						//alert(data);
						var tempData = data.split("&");
						var cmntId = tempData[0];
						var rplyId = "#load_reply_" + cmntId;
						var newHtml = tempData[1];	

						$("#comment_written").val("");
						$("#all_comments").prepend(newHtml);
						/*
						$(rplyId).load("video_reply.php",{
							cmnt_id: cmntId
						});
						*/


					}
				});
			}
		});
	});
</script>