<?php 
session_id("protal");
session_start();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$logname = $_SESSION["logname"];

?>
<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>PAYSO - Employee Portal</title>

	<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</head>
<body>-->



	<!-- begin HEADER -->
	<?php require("inc/header.php"); ?>
	<!-- end HEADER -->


	<!-- begin LEFT PANEL -->
	<div id="leftpanel" class="leftpanel">

		<?php require("inc/leftpanel.php"); ?>

		<!-- sub buttons -->
		<!--
		<ul class="subbuttons">
			<div class="leftpanel-title"><b>COMMANDS</b></div>
			<li><button><span class="fas fa-key"></span> Change Password</button></li>
			<li><button><span class="fas fa-sign-out-alt"></span> Logout</button></li>
		</ul>
		-->

	</div>
	<!-- end LEFT PANEL -->




	<!-- begin HEADER -->
	<?php require("inc/header.php"); ?>
	<!-- end HEADER -->




	<!-- begin DASHBOARD -->
	<div class="mainpanel dashboard">
		<div class="container-fluid">


			<!-- TITLE -->
			<div class="row">
				<div class="col=lg-8 col-md-8 col-sm-12 col-xs-12">
					<div class="dashboard-maintitle"><i class="far fa-id-card color-orange"></i> <?php echo $logname;?></div>
				</div>
			</div>




			<!-- ROW 1 -->
			<div class="row">
				<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
					<div class="dashboard-content">
						<div class="dashboard-title"><i class="far fa-calendar-alt"></i> Schedule</div>
						<div>
							<table class="dashboard-table" border="1">
								<tr>
									<th>Day Type</th>
									<th>Date</th>
									<th>Day</th>
									<th>Shift Type</th>
									<th class="green">Start Time</th>
									<th class="red">End Time</th>
								</tr>
								<tr class="rowA">
									<td>Regular</td>
									<td>1/20/2020</td>
									<td>Monday</td>
									<td>Opening</td>
									<td>9:00am</td>
									<td>6:00pm</td>
								</tr>
								<tr class="rowB">
									<td>Special Holiday</td>
									<td>1/21/2020</td>
									<td>Monday</td>
									<td>Opening</td>
									<td>9:00am</td>
									<td>6:00pm</td>
								</tr>
								<tr class="rowA">
									<td>Regular</td>
									<td>1/22/2020</td>
									<td>Tuesday</td>
									<td>Opening</td>
									<td>9:00am</td>
									<td>6:00pm</td>
								</tr>
								<tr class="rowB">
									<td>Regular</td>
									<td>1/23/2020</td>
									<td>Wednesday</td>
									<td>Opening</td>
									<td>9:00am</td>
									<td>6:00pm</td>
								</tr>
								<tr class="rowA">
									<td>Regular</td>
									<td>1/24/2020</td>
									<td>Thursday</td>
									<td>Opening</td>
									<td>9:00am</td>
									<td>6:00pm</td>
								</tr>
								<tr class="rowB">
									<td>Regular</td>
									<td>1/25/2020</td>
									<td>Friday</td>
									<td>Closing</td>
									<td>1:00pm</td>
									<td>10:00pm</td>
								</tr>
								<tr class="rowA">
									<td>Regular</td>
									<td>1/26/2020</td>
									<td>Saturday</td>
									<td>Opening</td>
									<td>9:00am</td>
									<td>6:00pm</td>
								</tr>
							</table>
						</div>
					</div>
				</div>

				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
					<div class="dashboard-content">
						<div class="dashboard-title"><i class="fas fa-user-check"></i> Attendance</div>
						<table class="dashboard-table" border="1">
								<tr>
									<th>Date</th>
									<th class="green" width="23%">Start Time</th>
									<th class="red" width="23%">End Time</th>
								</tr>
								<tr class="rowA">
									<td>1/20/2020</td>
									<td>9:15am</td>
									<td>6:03pm</td>
								</tr>
								<tr class="rowB">
									<td>1/20/2020</td>
									<td>9:15am</td>
									<td>6:03pm</td>
								</tr>
								<tr class="rowA">
									<td>1/20/2020</td>
									<td>9:15am</td>
									<td>6:03pm</td>
								</tr>
								<tr class="rowB">
									<td>1/20/2020</td>
									<td>9:15am</td>
									<td>6:03pm</td>
								</tr>
								<tr class="rowA">
									<td>1/20/2020</td>
									<td>9:15am</td>
									<td>6:03pm</td>
								</tr>
								<tr class="rowB">
									<td>1/20/2020</td>
									<td>9:15am</td>
									<td>6:03pm</td>
								</tr>
								<tr class="rowA">
									<td>1/20/2020</td>
									<td>9:15am</td>
									<td>6:03pm</td>
								</tr>
							</table>
					</div>
				</div>
			</div>



			<!-- ROW 2 -->
			<div class="row">
				<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
					<div class="dashboard-content">
						<div class="dashboard-title"><i class="far fa-user-circle"></i> Personal Information</div>
						<hr>
						<div>
							<table>
								<tr>
									<!-- left -->
									<td width="250px;">
										<div class="dashboard-pic"><img src="images/pic.jpg"></div>
									</td>
									<!-- right -->
									<td valign="top">
										<div class="dashboard-item">
											<span class="dashboard-minititle">Full Name:</span>
											<b class="dashboard-bigtext">Juan Dela Cruz</b>
										</div>
										<div class="dashboard-item">
											<span class="dashboard-minititle">Position:</span>
											<span class="dashboard-bigtext">Construction</span>
										</div>
										<div>
											<span class="dashboard-minititle">Birthdate:</span>
											<span class="dashboard-bigtext">1/12/2020</span>
										</div>
										<div>
											<span class="dashboard-minititle">Regularization:</span>
											<span class="dashboard-bigtext">1/12/2020</span>
										</div>
										<div>
											<span class="dashboard-minititle">Address:</span>
											<span class="dashboard-bigtext">#1 Lorem ipsum dolor sit amet, adipiscing elit. Q.C.</span>
										</div>
										<div>
											<span class="dashboard-minititle">Phone Number:</span>
											<span class="dashboard-bigtext">+63 916 123 4567</span>
										</div>
									</td>
								</tr>
							</table>
						</div>
						<br><hr>
						<div>
							<table>
								<tr>
									<td width="33%" valign="top">
										<div>
											<span class="dashboard-minititle-xl">Bank Account:</span>
											<span class="dashboard-bigtext">1230567834579</span>
										</div>
										<div>
											<span class="dashboard-minititle-xl">Employment Status:</span>
											<span class="dashboard-bigtext">Regular</span>
										</div>
									</td>
									<td width="33%" valign="top">
										<div>
											<span class="dashboard-minititle-sm">PhilHealth:</span>
											<span class="dashboard-bigtext">1230567834579</span>
										</div>
										<div>
											<span class="dashboard-minititle-sm">Pag-ibig:</span>
											<span class="dashboard-bigtext">345346324</span>
										</div>
									</td>
									<td width="33%" valign="top">
										<div>
											<span class="dashboard-minititle-xs">TIN:</span>
											<span class="dashboard-bigtext">23474563463457</span>
										</div>
										<div>
											<span class="dashboard-minititle-xs">SSS:</span>
											<span class="dashboard-bigtext">3453478923</span>
										</div>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>


				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
					<button class="btn btn-success dashboard-btn-big">
						<i class="fas fa-file-export fa-2x"></i><br>
						File a<br>Leave
					</button>
					<button class="btn btn-warning dashboard-btn-big" onclick="location.href = 'overtimeform.php';">
						<i class="far fa-clock fa-2x"></i><br>
						File an<br>Overtime
					</button>
					<button class="btn btn-primary dashboard-btn-big">
						<i class="fas fa-file-invoice fa-2x"></i><br>
						Generate<br>Payslip
					</button>
				</div>
			</div>





		</div>
	</div>
	<!-- end MAINPANEL -->


	<!-- begin [JAVASCRIPT] -->
	<script type="text/javascript" src="js/custom.js"></script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>