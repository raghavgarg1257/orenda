<?php @session_start(); ?>

<nav style="z-index: 1000">
	<div class="container">
		
		<div class="nav-header">
			<div class="brand">
				<a href="index.php" style="display: block"><img src="images/logo_big.png" style="border-radius:0;" alt="Website Logo" /></a>
			</div>

			<button class="menu-icon visible-xs" data-click-state="0">
				<div class="lines line1" style="z-index: 4"></div>
				<div class="lines line2"></div>
				<div class="lines line3" style="z-index: 5"></div>
			</button>
		</div>

		<div class="outer-links">
			<ul class="links">
				<li><a href="courses.php" class="outer cli">Courses</a></li>
				
			<?php if(isset($_SESSION['u_id'])) { ?>
				<li><a href="profile.php" class="outer">My Profile</a></li>
				<li><a href="logout.php" class="outer">Log Out</a></li>
			<?php } else { ?>
				<li class="visible-xs"><a href="index.php" class="outer">Home</a></li>
				<li class="visible-xs"><a href="about.php" class="outer">About us</a></li>
				<li class="visible-xs"><a  data-toggle="modal" data-target="#myModal" style="cursor: pointer" class="outer" id="contact">Contact</a></li>
				<div class="login-signup">
					<li><a href="login.php" class="outer cli">Log In</a></li>
					<li><a href="login.php" class="btn btn-info" style="font-size: 18px; border-radius: 2px; font-weight: bolder; opacity: 1" id="signup">Create free account</a></li>
				</div>
			<?php } ?>
			</ul>
		</div>

	</div>
</nav>