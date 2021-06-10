<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>PAYSO - Employee Portal</title>

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</head>
<body class="login">




	<!-- begin LOGIN -->
	<div class="login-container" id="conttables">
		<div class="login-outercontainer">
			<div class="login-leftpanel">

				<!-- begin [SLIDESHOW] -->
				<section class="slideshow">
					<div class="container">
					<div class="row">
						<div id="myCarousel" class="carousel slide" data-ride="carousel">

							<!-- begin (indicators) -->
							<ol class="carousel-indicators">
								<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
								<li data-target="#myCarousel" data-slide-to="1"></li>
								<li data-target="#myCarousel" data-slide-to="2"></li>
							</ol>
							<!-- end (indicators) -->

							<!-- begin (wrapper for slides) -->
							<div class="carousel-inner" role="listbox">
								<div class="item active">
								<img src="images/login-slide/slide1.jpg" alt="Slide 1">
									<div class="carousel-caption">
									<h3 class="hidden-xs">Managed Payroll Service</h3>
									<p class="hidden-xs">All-in-One Payroll Management Solutions. Manage Payroll Effortlessly. Trusted & Affordable Timekeeping & Payroll System Built for your Business.</p>
									<p><a href="https://sypro-it.com.ph/wp/" class="btn btn-default" target="_blank">Learn more</a></p>
									</div>
								</div>
								<div class="item">
								<img src="images/login-slide/slide2.jpg" alt="Slide 2">
									<div class="carousel-caption">
									<h3 class="hidden-xs">Compliance</h3>
									<p class="hidden-xs">Influencing employees for the right compliance.</p>
									<p><a href="#" class="btn btn-default">Help</a></p>
									</div>
								</div>
								<div class="item">
								<img src="images/login-slide/slide3.jpg" alt="Slide 3">
									<div class="carousel-caption">
									<h3 class="hidden-xs">Professional Monitoring</h3>
									<p class="hidden-xs">Enabling businesses by managed technologies.</p>
									<p><a href="https://sypro-it.com.ph/wp/" class="btn btn-default" target="_blank">Contact Us</a></p>
									</div>
								</div>
							</div>
							<!-- end (wrapper for slides) -->

							<!-- begin (Left and right controls) -->
							<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
								<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
								<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
								<span class="sr-only">Next</span>
							</a>
							<!-- end (Left and right controls) -->

						</div>
					</div>
					</div>
				</section>
				<!-- end [SLIDESHOW] -->

			</div>
			<div class="login-rightpanel">
				<div class="login-logo">
					<div><img src="images/logo-employee.png"></div>
					<div class="text-center">Employee Portal</div>
				</div>
				
				<?php
				if(isset($_GET["invalid"])) {
					if($_GET["invalid"] == 2) {
						echo "<div class='login-notify'><span class='fas fa-info-circle'></span> Invalid username or password. Please enter again.</div>";
					}
					else if($_GET["invalid"] == 1) {
						echo "<div class='login-notify'><span class='fas fa-info-circle'></span> Invalid password. Please enter again.</div>";
					}
					else if($_GET["invalid"] == 3) {
						echo "<div class='login-notify'><span class='fas fa-info-circle'></span> Account has been Disabled.</div>";
					}
				}
				?>
				
				<form accept-charset="utf-8" action="loginprocess.php" method="post">
					<div class="logintext">
						<input type="text" class="logintext-user" value="" minlength="2" maxlength="30" placeholder="Username" id="login-name" name="username" required="required" pattern="[^*()/><\][\\\x22,;|]+" autofocus>
					</div>
					<div class="logintext-pass">
						<input type="password" id="passInput" class="logintext-password" value="" minlength="2" maxlength="30" placeholder="Password" id="login-pass" name="password" required="required" pattern="[^*()/><\][\\\x22,;|]+">
						<span id="passtoggle" class="pass-toggle fas fa-eye-slash" onclick="showPassword()"></span>
					</div>
					<div class="login-forgotpass"><a href="#">Forgot password?</a></div>
					<div class="loginbtn">
						<!--<a class="btn btn-primary btn-lg" href="#"onClick="logIn()">login</a>-->
						<input type="submit" name="submit" value="Sign in" class="btn btn-primary btn-lg">
						<input type="reset" value="Clear" class="btn btn-warning btn-lg">
					</div>
				</form>

			</div>
		</div>
	</div>
	<!-- end LOGIN -->





	<!-- begin [JAVASCRIPT] -->
	<script type="text/javascript">
		function showPassword() {
			$('#passtoggle').toggleClass('fa-eye-slash fa-eye');
			var ps = document.getElementById("passInput");
			if (ps.type === "password") {
				ps.type = "text";
			} else {
				ps.type = "password";
			}
		}
	</script>
	<script src="js/ajax.js"></script>
	<script type="text/javascript" src="js/custom.js"></script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>