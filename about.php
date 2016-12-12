<?php @session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="icon" type="image/png" href="images/logo_small.png">
	<title>Orenda | About Us</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./css/navigation.css">
	<link rel="stylesheet" type="text/css" href="./css/main+video.css">
	<link rel="stylesheet" type="text/css" href="./css/footer.css">
	<link rel="stylesheet" type="text/css" href="./css/feedback.css">
	<link rel="stylesheet" type="text/css" href="./css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Raleway:400' rel='stylesheet' type='text/css'>
	<style type="text/css">

		* {
			box-sizing: border-box;
			margin: 0;
			padding: 0;
		}

		body {
			padding: 0;
		}

		.main-body {
			transition: transform 0.4s cubic-bezier(.25,.46,.45,.94);
			z-index: -3;
		}
	
		.inner-toggle {
			transform: translate3d(-270px,0px,0px);
		}
		


		.About-us .about-text h3, .About-us .about-text p {
			text-align: left;
			font-family: "Whitney SSm A", "Whitney SSm B", "Avenir", "Helvetica Neue", "Segoe UI", Helvetica, Arial, "Ubuntu", sans-serif;
			color: rgb(25,55,75);
		}

		.About-us .about-text h3 {
			font-weight: 400;
		}

		.About-us .about-text p {
			font-size: 16px;
		}


		.About-us .developers h3 {
			text-align: left;
	    font-family: "Whitney SSm A", "Whitney SSm B", "Avenir", "Helvetica Neue", "Segoe UI", Helvetica, Arial, "Ubuntu", sans-serif;
	    color: rgb(25,55,75);
	    font-weight: 400;
	    font-size: 26px;
		}

		.About-us .developers .images {
			margin-top: 50px;
		}

		.About-us .developers .images .dev-img {
			position: relative; 
			max-width: 283px; 
			display: inline-block;
		}

		.About-us .developers .images .dev-img img {
			width: 100%;
			height: auto;
		}

		.About-us .developers .images .description {
			margin: 0;
			text-align: left;
			padding: 10px 0;
		}

		.About-us .developers .images .description h4 {
			font-size: 2rem;
	    font-family: "Whitney SSm A", "Whitney SSm B", "Avenir", "Helvetica Neue", "Segoe UI", Helvetica, Arial, "Ubuntu", sans-serif;
	    font-weight: 600;
	    margin-bottom: 10px;
	    margin-top: 15px;
	    color: rgb(25,55,75);
		}

		.About-us .developers .images .description h5 {
			font-size: 1.8rem;
	    font-family: sans-serif;
	    color: rgb(25,55,75);
	    font-weight: 500;
	    margin: 0;
	    margin-bottom: 20px;
	    line-height: 22px;
		}

		.About-us .developers .images .description p {
			margin: 0;
	    color: rgb(110,110,120);
	    position: relative;
	    z-index: 12;
	    font-size: 1.8rem;
		}

		.About-us .developers .images .description p:nth-child(1) {
			font-size: 18px;
		}

		.About-us .developers .images .img-cover {
			position: absolute;
	    top: 0;
	    bottom: 0;
	    right: 0;
	    left: 0;

	    display: block;
	    background: rgba(0,0,0,0.8);
	    z-index: 10;
	    opacity: 0;
	    transition: opacity 0.7s;
		}

		.About-us .developers .dev-img .dev-media-links a {
			display: inline-block;
			margin: 0 auto;
			width: 24px;
	    display: inline-block;
	    margin: 0 auto;
	    font-size: 24px;
	    text-align: center;
	    color: white;
	    text-decoration: none;
		}

		.About-us .developers .dev-media-links {
			position: absolute;
			display: block;
			top: calc(50%);
			left: calc(50% - 31px); 
			opacity: 0;
			transition: opacity 0.7s, transform 0.7s;
		}

		.About-us .developers .dev-media-links .fa-facebook:hover {
			opacity: 0.7;
		}

		.About-us .developers .dev-media-links .fa-linkedin:hover {
			opacity: 0.7;
		}

		.images .dev-img:hover .img-cover {
			opacity: 1;
		}

		.images .dev-img:hover .dev-media-links {
			opacity: 1;
			transform: translateY(-12px);
			z-index: 11;
		}

		@media (max-width: 768px) {
			.developers .images {
				text-align: center;
			}

			.About-us .developers .images .description {
				text-align: center;
			}

			.About-us .developers .images {
				margin-top: 70px;
			}
		}

		.About-us .about-header h1 {
			font-family: "Whitney SSm A", "Whitney SSm B", "Avenir", "Helvetica Neue", "Segoe UI", Helvetica, Arial, "Ubuntu", sans-serif;
			text-align: center;
			font-weight: 400;
			padding: 100px 20px 50px;
			font-size: 50px;
			color: rgb(25,55,75);
			margin-top: 0;
		}
		
		
		
		@media (max-width:600px) {
			.About-us .about-header h1 {
				font-size: 40px;
			}
		}
		
		.contact-form .modal-body .feedback-body form .btn.btn-success {
			background: rgb(60,148,139);
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

	<?php  require("header.php"); ?>

	<div class="main-body">

		<div class="cover-element"></div>
	
		<div class="About-us">
			<div class="about-header">
				<h1>We Believe In<br>Free Education For Everyone.</h1>
			</div>
			<div class="about-text" style="background: rgb(234,234,235); padding: 50px 0 50px">
				<div class="container">
					<div class="row">
						<div class="col-sm-6">
							<h3>About Orenda</h3>
							<p>Orenda is the hidden powers in you, which can only be used when you have knowledge. Here at Orenda, we are trying to give free education to everyone so that they can gain kowledge to discover themselves and do something for the betterment of the world.</p>
						</div>

						<div class="col-sm-6">
							<h3>Our Inspiration</h3>
							<p>Our college authorities were the real inspiration to us, in begining who didn<!--'-->'t gave us the permission to teach our college juniors in a traditional way, so we decided to make this website using which we can spread our knowledge to everyone out there who is willing to learn.</p>
						</div>
					</div>
				</div>
			</div>

			<div class="developers" style="padding: 60px 0 70px">
				<div class="container">
					<h3 style="text-align: center">Our Team</h3>
					<div class="row">

<!-- 						<div class="images col-md-3 col-sm-5 col-sm-offset-1 col-md-offset-0">
							<div class="dev-img" style="">
								<div class="img-cover">
								</div>
								<img src="images/rishabh.jpg">
									<div class="dev-media-links">
										<a href="#" target="_blank" class="fa fa-facebook" style="margin-right: 10px"></a>
										<a href="#" target="_blank" class="fa fa-linkedin"></a>
									</div>
								</div>
							<div class="description">
								<h4>Rishabh Shukla</h4>
								<h5>&nbsp;</h5>
								<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
							</div>
						</div> -->

						<div class="images col-md-3 col-sm-5 col-md-offset-0">
							<div class="dev-img" style="">
								<div class="img-cover">
								</div>
								<img src="images/raghav.jpg">
									<div class="dev-media-links">
										<a href="https://fb.com/raghav.garg.1257" target="_blank" class="fa fa-facebook" style="margin-right: 10px"></a>
										<a href="https://linkedin.com/in/raghav-garg-8885468a" target="_blank" class="fa fa-linkedin"></a>
									</div>
								</div>
							<div class="description">
								<h4>Raghav Garg</h4>
								<h5>Backend & UX Developer</h5>
								<p>He is our only backend guy, who created this website<!--'-->'s backend solely from the scratch and works real hard towards improving the user experience at every step of the user in this website.</p>
							</div>
						</div>
						
						<div class="images col-md-3 col-sm-5 col-md-offset-0">
							<div class="dev-img" style="">
								<div class="img-cover">
								</div>
								<img src="images/shubham.jpg">
									<div class="dev-media-links">
										<a href="#" target="_blank" class="fa fa-facebook" style="margin-right: 10px"></a>
										<a href="#" target="_blank" class="fa fa-linkedin"></a>
									</div>
								</div>
							<div class="description">
								<h4>Shubham Jain</h4>
								<h5>Front End Developer</h5>
								<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
							</div>
						</div>

						<div class="images col-md-3 col-sm-5 col-sm-offset-1 col-md-offset-0">
							<div class="dev-img" style="">
								<div class="img-cover">
								</div>
								<img src="images/kartik.png">
									<div class="dev-media-links">
										<a href="#" target="_blank" class="fa fa-facebook" style="margin-right: 10px"></a>
										<a href="#" target="_blank" class="fa fa-linkedin"></a>
									</div>
								</div>
							<div class="description">
								<h4>Kartik Bansal</h4>
								<h5>UI/UX Designer &<br>Front End Developer</h5>
								<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
							</div>
						</div>

						<div class="images col-md-3 col-sm-5 col-md-offset-0">
							<div class="dev-img" style="">
								<div class="img-cover">
								</div>
								<img src="images/imageedit_2_2428478572.jpg">
									<div class="dev-media-links">
										<a href="https://www.facebook.com/anmol93" target="_blank" class="fa fa-facebook" style="margin-right: 10px"></a>
									</div>
								</div>
							<div class="description">
								<h4>Anmol Singh</h4>
								<h5>Web Designer</h5>
								<p>I love how the web works.After decades of its establishment,i find it just amazing that how easier things have become with the help of web. I am always trying to learn new web technologies and designs.</p>
							</div>
						</div>

					</div>
				</div>
			</div>

		</div>

		<?php require("footer.php"); ?>

	</div>	
	
	<?php require("contact_modal.php"); ?>


	<script type="text/javascript" src="./js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="./js/bootstrap.min.js"></script>
	<script type="text/javascript" src="./js/navigation.min.js"></script>


</body>
</html>
						
			
