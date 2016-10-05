<?php 

	function htmlchar($data){
		$data = htmlspecialchars($data, ENT_QUOTES);
		$data = str_replace("[br]","<br>",$data);
		$data = str_replace("[em]","<em>",$data);
		$data = str_replace("[/em]","</em>",$data);
		$data = str_replace("[strong]","<strong>",$data);
		$data = str_replace("[/strong]","</strong>",$data);
		$data = str_replace("[code]","<code style='display:block; white-space:pre-wrap'>",$data);
		$data = str_replace("[/code]","</code>",$data);
		$data = str_replace("[space]","&nbsp;",$data);
		$data = nl2br($data); 
		return $data;
	}
	$video_id = $_POST['video_id'];

//	$video_id = 5;
	
	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db);

	$query = "SELECT `id`, `details`, `options`, `answer`, `course_id` FROM `video_question` WHERE `video_id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'i', $video_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $question_id, $question_details, $question_options, $question_answer, $question_course_id);
	
	mysqli_stmt_store_result($statement);
	
	if(mysqli_stmt_num_rows($statement) == 0){
		die;
	}
?>
<style type="text/css">
	.quiz ul {
	    list-style: none;
	    padding: 0;
	    margin-bottom: 0;
	  }
	
	  .quiz form p {
	    font-family: 'Raleway', sans-serif;
	    font-size: 16px;
	
	  }
	
	  .quiz ul p {
	    font-family: 'Raleway', sans-serif;
	    font-size: 16px;
	  }
	
	  .quiz .options {
	    display: inline-block;
	    width: 80%;
	    margin-left: 10px;
	    font-size: 15px;
	    font-family: 'Raleway', sans-serif;
	    letter-spacing: 1px;
	
	  }
	
	  .quiz label {
	    width: 100%;
	    padding: 10px;
	    border: 1px solid rgb(250,250,250);
	    margin-bottom: 2px;
	    cursor: pointer;
	  }
	
	  .quiz label:hover {
	    background: rgb(245,245,245);
	  }
	
	  .quiz label input[type="radio"] {
	    vertical-align: top;
	  }
	
	  .quiz label input[type="radio"]:checked + label {
	    background: red;
	  }
	
	  .quiz label input[type="radio"]:not(old) {
	   
	    width : 15px;
	    height : 15px;
	  }
	
	  .quiz .correctAns {
	    padding: 10px;
	    color: rgb(72,172,88);
	    font-size: 20px;
	    font-weight: 900;
	    letter-spacing: 1px;
	  }
	
	  .quiz i {
	    margin-right: 10px;
	  }
	  
	  .quiz .noAns {
	    padding: 10px;
	    color: rgb(204, 200, 28);
	    font-size: 20px;
	    font-weight: 900;
	    letter-spacing: 1px;
	  }
	  
	  .quiz .wrongAns {
	    padding: 10px;
	    color: rgb(234,67,53);
	    font-size: 20px;
	    font-weight: 900;
	    letter-spacing: 1px;
	  }
	  
	  .quiz .showAns {
	    padding: 10px;
	    color: rgb(60, 31, 216);
	    font-size: 20px;
	    font-weight: 900;
	    letter-spacing: 1px;
	  }
	
	  .quiz .btns {
	    font-family: 'Raleway', sans-serif;
	    padding: 6px 21px;
	    letter-spacing: 1px;
	  }
</style>
<div class="quiz" style="text-align: left;">
	<h3 style="margin-bottom: 20px">Quiz</h3>
	<form method="POST" action="#" name="radiosel" id="radiosel">
		<?php $i=0; $k=0; $a; while(mysqli_stmt_fetch($statement)){ $i++ ?>
			<ul>
				<p><?php echo htmlchar($question_details); ?></p>
				<?php 
					$options = explode(",",$question_options);
					for($j=0; $j<4; ++$j){ 
				?>
						<li>
							<label>
								<input type="radio" name="option_<?php echo $question_id; ?>" value="<?php echo htmlchar($options[$j]); ?>">
								<span class="options"><?php echo htmlchar($options[$j]); ?></span>
							</label>
						</li>
				<?php } ?>
				<div id="question_<?php echo $i; ?>"></div>
			</ul>
		<?php @$k = $k.",".$question_id; $a = $a.",".$question_answer; } mysqli_stmt_close($statement); ?>                     
		<?php if($i != 0) { ?>                     
			<input type="Submit" value="SUBMIT" class="btns" style="margin-right: 15px">
			<button class="btns" id="show_answer">SHOW ANSWER</button>
		<?php } ?>
	</form>
</div>
<script src="js/jquery-2.1.4.min.js"></script>
<script type="text/javascript">

	$("#radiosel").on("submit",function(e){
		e.preventDefault();
		
		var r = "<?php echo $k; ?>";
		var ids = r.split(",");
		
		var a = "<?php echo $a; ?>";
		var answers = a.split(",");
		
		for (var j=1 ; j<=<?php echo $i; ?> ; j++) {
			var id = "#question_" + j;
			var question_name = "option_" + ids[j];
			var user_answer = $("input[name="+question_name+"]:checked").val();
		
			if(typeof user_answer == 'undefined'){
				$(id).html("<p class='noAns'><i class='glyphicon glyphicon-exclamation-sign'></i>No Answer Given</p>");
			} else if(user_answer != answers[j]) {
				$(id).html("<p class='wrongAns'><i class='glyphicon glyphicon-remove-sign'></i>Wrong Answer</p>");
			} else {
				$(id).html("<p class='correctAns'><i class='glyphicon glyphicon-ok-sign'></i>Correct Answer</p>");
				if(user_answer == answers[j]){	
					var formData = {
						'question_id': ids[j],
						'video_id': <?php echo $video_id; ?>,
						'course_id': <?php echo $question_course_id; ?>
					};
				
					$.ajax({
						type: "POST",
						url: "save_video_answers.php",
						data: formData,
						success: function(data){
						//	console.log(data);
						}
					});
				}				
			}
		}
	});
	
	$("#show_answer").on("click",function(e){
		e.preventDefault();
		
		var rsa = "<?php echo $k; ?>";
		var idssa = rsa.split(",");
		
		var asa = "<?php echo $a; ?>";
		var answerssa = asa.split(",");
		
		for (var j=1 ; j<=<?php echo $i; ?> ; j++) {
			var id = "#question_" + j;
			var question_name = "option_" + idssa[j];
			var user_answer = $("input[name="+question_name+"]:checked").val();
			
			if(typeof user_answer == 'undefined'){
				$(id).html("<p class='noAns'><i class='glyphicon glyphicon-exclamation-sign'></i>No Answer Given</p><p class='showAns'>"+answerssa[j]+"</p>");
			} else if(user_answer != answerssa[j]) {
				$(id).html("<p class='wrongAns'><i class='glyphicon glyphicon-remove-sign'></i>Wrong Answer</p><p class='showAns'>"+answerssa[j]+"</p>");
			}
		}
	});
	
</script>
<?php  mysqli_close($link);  ?>