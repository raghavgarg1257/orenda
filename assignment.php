<?php 
	@session_start();

	if(isset($_SESSION['u_id'])) {
		$user_id = $_SESSION['u_id'];
	} else {
		header("Location:login.php");
	}

	if (isset($_SESSION['fb_id'])) {
		$user_fb_id = $_SESSION['fb_id'];
	}

	if ($_GET['name'] == "" ) {
		header("Location:index.php");
		die;
	} else {
		$assignment_id = str_replace('virtut', '', base64_decode($_GET['name']));
	}

	require("db.php");
	$link = mysqli_connect($_srvr, $_user, $_pass, $_db);

	$query = "SELECT `title`, `details`, `question` FROM `assignments` WHERE `id`=?";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'i', $assignment_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $assignment_title, $assignment_details, $assignment_question);

	mysqli_stmt_store_result($statement);
	if ( mysqli_stmt_num_rows($statement) == 0 ) {
		header("Location:courses.php");
		die;
	}
	
	mysqli_stmt_fetch($statement);
	mysqli_stmt_close($statement);

	$query = "SELECT `id`, `title`, `link` FROM `videos` WHERE `assignment_id`=? ORDER BY `order` ASC";
	$statement = mysqli_prepare($link, $query);
	mysqli_stmt_bind_param($statement, 'i', $assignment_id);
	mysqli_stmt_execute($statement);
	mysqli_stmt_bind_result($statement, $video_id, $video_title, $video_link);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    
    <link rel="icon" type="image/png" href="images/logo_small.png">
    <title>Orenda | <?php echo $assignment_title; ?></title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>

      <script src="js/respond.min.js"></script>
    <![endif]-->
    
    
	<link rel="stylesheet" type="text/css" href="css/simple-sidebar.css">
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="./css/homepage.min.css">
	<link href='https://fonts.googleapis.com/css?family=Raleway:400' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300' rel='stylesheet' type='text/css'>
	<style type="text/css">
	* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			padding: 0;
			overflow-x: hidden;
		}

		.main-body {
			transition: transform 0.4s cubic-bezier(.25,.46,.45,.94);
			
		}
	
		

		.inner-toggle {
			transform: translate3d(-270px,0px,0px);
		}
		img{
			border-radius: 50px;
		}
		.disp_name{
			margin: 0 5px 0 10px;
			font-size: 15px;
			font-weight: 600;
		}
		.disp_time_stamp{
			color: #808080; 
			font-size: 12px;
		}
		.disp_details{
			margin: 10px;
		}
		.welldone{
			min-height: 20px;
			padding: 10px;
			margin-bottom: 10px;
			background-color: #f5f5f5;
			border-radius: 5px
		}
		.disp_del{
			cursor: pointer;
			color: #636363;
			float: right;
		}
		.replies{
			margin: 0 20px 0 50px ;
		}
	  
	  .container-fluid{
	    padding-top: 10px;
	  }
	  /*.video-button{
	    position: fixed;
	    bottom: 0;
	    right: 0;
	    width: 100%;
	    display: none;
	    background: rgb(25,55,75);
	    color: white;
	    z-index: 10;
	    padding: 5px;
	    
	  }
	  .video-button .glyphicon{
	    padding: 5px 5px 0 5px;
	  }
	
	  .video-button h3{
	    margin: auto;
	
	  }*/
	  .video-button{
	  	
	    position: fixed;
	    bottom: 20px;
	    left:57px;
	    display: none;
	    background: rgb(25,55,75);
	    color: white;
	    
	    padding: 0px 21px 3px 23px;
    	    border-radius: 0 25px 25px 0;
	  }
	  .video-button .glyphicon{
	    position: absolute;
	    padding: 20px;
	    border-radius: 50%;
	    top: -17px;
	    background: rgb(25,55,75);
	    border: 1px solid;
	    left: -47px;
	  }
	  
	  #assignment_title_bar {
	  	font-size: 16px;
    		font-family: 'Raleway', sans-serif;
    		letter-spacing: 1px;
    	}
	  
	  .description p{
	    font-size: 1.2em;
	    font-family: font-family: "Whitney SSm A", "Whitney SSm B", "Avenir", "Helvetica Neue", "Segoe UI", Helvetica, Arial, "Ubuntu", sans-serif;
	  }
	  .comments{
	    margin-top: 5%;
	    margin-bottom: 20px;
	  }
	  .comments p{
	    font-family: "Whitney SSm A", "Whitney SSm B", "Avenir", "Helvetica Neue", "Segoe UI", Helvetica, Arial, "Ubuntu", sans-serif;
	    font-size:1.05em;
	  }
	  .main-comment p{
	    margin-left: 11%;
	  }
	  .comments img{
	    border-radius: 100%;
	  }
	  .video-head h2,.comments h3,.comments h4{
	    text-align: center;
	      font-family: "Whitney SSm A", "Whitney SSm B", "Avenir", "Helvetica Neue", "Segoe UI", Helvetica, Arial, "Ubuntu", sans-serif;
	      color: rgb(25,55,75);
	  }
	  
	  
	  .post-comment{
	    margin-bottom: 1.7em;
	    margin-top: 2em;
	  }
	  .post-comment input[type="text"]
	  {
	    padding: 8px;
	    font-family: "Whitney SSm A", "Whitney SSm B", "Avenir", "Helvetica Neue", "Segoe UI", Helvetica, Arial, "Ubuntu", sans-serif;
	    font-size: 1.2em;
	    border: 1px solid #ccc;
	    outline: none;
	    box-shadow: none;
	    height: 2.5em;
	    border-radius: 0;
	    width: 75%;
	  }
	  .post-comment input[type="submit"]
	  {
	    padding: 8px;
	    font-family: "Whitney SSm A", "Whitney SSm B", "Avenir", "Helvetica Neue", "Segoe UI", Helvetica, Arial, "Ubuntu", sans-serif;
	    font-size: 1.2em;
	    background: rgba(25,55,75,.9);
	    border: 1px solid rgb(25,55,75);
	    color: white;
	    border-radius: 2px;
	    height: 2.5em;
	    width: 15%;
	  }
	  .post-comment input[type="submit"]:hover{
	    opacity: .8;
	  }
	  .comments h4{
	    margin-left: 2%;
	  }
	  .reply p{
	    margin-left: 13%;
	  }
	  @media(max-width:1200px){
	    .video-button{
	      display: block;
	      font-size: 1.6em;
	    }
	    .post-comment input[type="text"]{
	
	    }
	    .post-comment input[type="submit"]{
	      width: 40%;
	    }
	  }
	  .description{
	  	margin-bottom: 50px;
	  }
	  code{
	  	padding:2px 50px;
	  }
	  
	  @media (min-width: 768px) {
	  	nav {
	   		border-bottom: 1px solid rgb(240,240,240);
	  	}
	  }
	  
	  @media (max-width: 767px) {
	  	.nav-header {
	  		background: rgb(250,250,250);
	  	}
	  	
	  	.nav-header.remove-bg {
	  		background: 0 0;
	  	}
	  }
	  
	
	</style>
	
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
    <?php require "header.php";?>
    
	<div class="main-body" style="min-height: 100vh">
	 <div class="cover-element"></div>
    <div id="wrapper" style="overflow:hidden;">
    
	
	
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
		<ul class="sidebar-nav">
			<li id="instructions" class="sidebar_brand" style="cursor:pointer;"><a style="text-align: center; font-weight: 700;"><?php echo $assignment_title; ?></a></li>
			<?php while (mysqli_stmt_fetch($statement)) {	?>
				<li class="all_videos" style="cursor:pointer;" id="<?php echo $video_id; ?>">
				<a>
					<div id="video_<?php echo $video_id; ?>"><?php echo $video_title ?></div>
					<!--
					<img src="http://img.youtube.com/vi/<?php// echo $video_link; ?>/hqdefault.jpg" width="60px"; height="45px";>
					-->
				</a>
				</li>
			<?php	}	mysqli_stmt_close($statement);	?>
			<li  id="question"style="cursor:pointer;"><a>Assignment to do</a></li>
		</ul>
        </div>
        <!-- /#sidebar-wrapper -->

	

		

        <!-- Page Content -->
        <div id="page-content-wrapper">
       
            <div class="container-fluid">
            
            	<div id="load_data">
			<div class="text-center video-head"><h2>Instructions</h2></div>
			
			<div class="description"><p>
				<?php 
					$assignment_details = htmlspecialchars($assignment_details, ENT_QUOTES);
					$assignment_details = str_replace("[br]","<br>",$assignment_details);
					$assignment_details = str_replace("[em]","<em>",$assignment_details);
					$assignment_details = str_replace("[/em]","</em>",$assignment_details);
					$assignment_details = str_replace("[strong]","<strong>",$assignment_details);
					$assignment_details = str_replace("[/strong]","</strong>",$assignment_details);
					$assignment_details = str_replace("[code]","<code style='display:block; white-space:pre-wrap'>",$assignment_details);
					$assignment_details = str_replace("[/code]","</code>",$assignment_details);
					$assignment_details = nl2br($assignment_details); 
					echo $assignment_details;
				?>
			</p></div>
            	</div>
            	
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->
    
    <div class="video-button">
		<span id="menu-toggle">
			<span class="glyphicon glyphicon-menu-hamburger"></span>
			<span id="assignment_title_bar"><?php echo $assignment_title; ?></span>
		</span>
	</div>
    </div>
    <?php
    // require "footer.php";
    ?>
	

    <!-- Menu Toggle Script -->
    <script type="text/javascript" src="./js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="./js/bootstrap.min.js"></script>
	<script type="text/javascript" src="./js/navigation.min.js"></script>

    <script type="text/javascript">
    	
    	
	    	$(document).ready(function() {
	    		$('.menu-icon').click(function() {
			
				$('.nav-header').toggleClass('remove-bg');
			
		});
    	})
    
	$(function(){
	
		$("#menu-toggle").on("click",function(e) {
			e.preventDefault();
			$("#wrapper").toggleClass("toggled");
		});
		
		$("#instructions").on("click", function(){
			$("#load_data").load("assignment_instruction.php", {
				assignment_details:"<?php echo $assignment_details; ?>"
			}, function(){	
				if( $(document).width() <=1200) {
					$("#wrapper").toggleClass("toggled");
				}
				$("#assignment_title_bar").html("<?php echo $assignment_title; ?>");
			});
		});

		$(".all_videos").on("click",function(){
			//console.log($(this).attr('id')); 
			var video_id = "#video_" + $(this).attr('id');
			$("#load_data").load("video.php", {
				video_id: $(this).attr('id')
			}, function(){
				if( $(document).width() <= 1200) {
					$("#wrapper").toggleClass("toggled");
				}
				var vid_tit = $(video_id).html();
				$("#assignment_title_bar").html(vid_tit);
			});
		});

		$("#question").on("click", function(){
			$("#load_data").load("assignment_question.php", {
			//	assignment_question:"<?php echo $assignment_question; ?>"
				assignment_id:"<?php echo $assignment_id; ?>"
			}, function(){	
				if( $(document).width() <= 1200) {
					$("#wrapper").toggleClass("toggled");
				}
				$("#assignment_title_bar").html("Assignment");
			});
		});

		$.getScript('http://www.youtube.com/player_api');	
		function onYouTubePlayerAPIReady(){ console.log('youtube api is ready..!!'); }

	});
    </script>

  </body>
</html>
<?php mysqli_close($link); ?>