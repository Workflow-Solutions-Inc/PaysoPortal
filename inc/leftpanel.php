<?php
$userpassx = $_SESSION['portaluserpass'];
$logbio = $_SESSION["portallogbio"];
$lognum = $_SESSION["portallognum"];
$dataareaid = $_SESSION["portaldefaultdataareaid"];
?>
<!-- begin LEFT PANEL -->
<style type="text/css" media="screen">
	.dropright:hover>.dropdown-menu { display: block !important; }
</style>
	<!-- head -->
	<div class="head">
		<img src="images/logo-employee-white.png">
		<button id="mobile-hide-nav" class="fas fa-bars btn-danger visible-xs"></button>
		<!--<input type="input" id="hidepass" value="<?php echo $userpassx;?>">-->
	</div>


	<!-- main buttons -->
	<ul class="mainbuttons">
		<!--<div class="leftpanel-title"><b>MAIN MENU</b></div>-->
		<div class="leftpanel-title"><b>COMMANDS</b></div>
		<li><a href="employee.php"><span class="fas fa-tachometer-alt"></span> Dashboard</a></li>
		<!--<li><button onclick="location.href = 'leaveform.php';"><i class="fas fa-file-export"></i> File Leave</button></li>
		<li><button onclick="location.href = 'overtimeform.php';"><i class="far fa-clock"></i> File Overtime</button></li>
		<li><button onclick="location.href = 'fieldworkform.php';"><i class="fas fa-file-invoice"></i> File Field Work</button></li>
		<li><button onclick="location.href = 'logform.php';"><i class="fas fa-file-export"></i> File Log Correction</button></li>-->
		<li><button onclick="location.href = 'loanfileform.php';"><i class="fas fa-file-export"></i> View Loan History</button></li>
		<li>
			<div class="btn-group dropright mainbuttons-dropdown-group">
				<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="far fa-file-alt fa"></span> Filing Forms <span class="fas fa-angle-right right"></span>
				</button>
				<div class="dropdown-menu mainbuttons-dropdown-menu">
					<!-- sub link -->
					<ul>
						<li><button onclick="location.href = 'leaveform.php';"><i class="fas fa-file-export"></i> File Leave</button></li>
						<li><button onclick="location.href = 'overtimeform.php';"><i class="far fa-clock"></i> File Overtime</button></li>
						<li><button onclick="location.href = 'fieldworkform.php';"><i class="fas fa-file-invoice"></i> File Field Work</button></li>
						<li><button onclick="location.href = 'logform.php';"><i class="fas fa-file-export"></i> File Log Correction</button></li>
					</ul>
				</div>
			</div>
		</li>
		<li><button onclick="location.href = 'payslip.php';"><i class="fas fa-file-export"></i> View Payslip</button></li>
		<li><button onclick="location.href = 'cert.php';"><i class="fas fa-file-alt"></i> Request Certificate</button></li>
	</ul>
	<?php 
		
		$query = "SELECT pos.isapprover 
					from worker wk
					left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid  

					where wk.workerid = '$lognum'
					and wk.dataareaid = '$dataareaid'";

		$result = $conn->query($query);
		$accessid = '';
		$access = "none";
		while ($row = $result->fetch_assoc())
		{ 
			$accessid = $row['isapprover'];
			
		}

		if($accessid == 1)
		{
			$access = "block";
		}
		else
		{
			$access = "none";
		}

		//$access = "block"
	?>
	<div id="incharge" style="display:<?php echo $access;?>">
		<ul class="subbuttons">
				<div class="leftpanel-title"><b>Officer In Charge</b></div>
				<!--<li><a href="#"><span class="fas fa-file-export"></span>  Worker Leave</a></li>-->
				<li><a href="userselectionot.php"><span class="fas fa-clock"></span>  Worker Overtime</a></li>
				<!--<li><a href="#"><span class="fas fa-file-invoice"></span>  Worker Field Work</a></li>
				<li><a href="#"><span class="fas fa-file-export"></span>  Worker Log Correction</a></li>-->

				<!--<li><button onclick="location.href = 'dashboard.php';"><i class="fas fa-eye"></i> Staff Attendance</button></li>
				<li><button onclick="location.href = 'approverleaveform.php';"><i class="fas fa-file-export"></i> Approve Leave</button></li>
				<li><button onclick="location.href = 'approverovertimeform.php';"><i class="far fa-clock"></i> Approve Overtime</button></li>
				<li><button><i class="fas fa-file-invoice"></i> Approve Field Work</button></li>-->

		</ul>
	</div>


	<div id="approver" style="display:<?php echo $access;?>">
		<ul class="subbuttons">
				<div class="leftpanel-title"><b>Manager</b></div>
				<li><a href="dashboard.php"><span class="fas fa-eye"></span> Staff Attendance</a></li>
				<li><a href="approverleaveform.php"><span class="fas fa-file-export"></span>  Approve Leave</a></li>
				<li><a href="approverovertimeform.php"><span class="fas fa-clock"></span>  Approve Overtime</a></li>
				<li><a href="approverfieldworkform.php"><span class="fas fa-file-invoice"></span>  Approve Field Work</a></li>
				<li><a href="approverlogform.php"><span class="fas fa-file-export"></span>  Approve Log Correction</a></li>

				<!--<li><button onclick="location.href = 'dashboard.php';"><i class="fas fa-eye"></i> Staff Attendance</button></li>
				<li><button onclick="location.href = 'approverleaveform.php';"><i class="fas fa-file-export"></i> Approve Leave</button></li>
				<li><button onclick="location.href = 'approverovertimeform.php';"><i class="far fa-clock"></i> Approve Overtime</button></li>
				<li><button><i class="fas fa-file-invoice"></i> Approve Field Work</button></li>-->

		</ul>
	</div>

	
	<!--<ul class="mainbuttons">
		<div class="leftpanel-title"><b><br>ACCOUNT</b></div>
		<li><button id=""><i class="fas fa-key"></i> Change Password</button></li>-->
		<!--<li><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Record</button></li>-->
		<!--<li><a href="loginprocess.php?out"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
	</ul>-->


