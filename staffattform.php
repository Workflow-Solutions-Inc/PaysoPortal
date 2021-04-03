<?php 
session_start();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$logbio = $_SESSION["logbio"];
$lognum = $_SESSION["lognum"];
if(isset($_SESSION['WKNum']))
{
	$wkid = $_SESSION['WKNum'];
}
else
{
	//header('location: workerform.php');
}

?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Staff Monitoring</title>

	<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<script src="js/jquery.min.js"></script>

</head>
<body>-->



	<!-- begin HEADER -->
	<?php require("inc/header.php"); ?>

	<!--<div class="header">
		<div class="header-content">

		<div class="header-nav">
				<ul>
					<li id="pla" onClick="reply_click(this.id)"><a href="leaveform.php?list=pla"><span class="fas fa-hourglass"></span>  Pending Leave Application</a></li>
					<li id="ala" onClick="reply_click(this.id)"><a href="approvedleaveform.php?list=ala"><span class="fas fa fa-check"></span>  Posted Leave Application</a></li>
				</ul>
		</div>

		</div>
	</div>-->

	<!--<div class="spacer">&nbsp;</div>-->

	<?php
	$sample = '';
	  function runMyFunction() {
	    echo 'I just ran a php function';
	  }

	  if (isset($_GET['list'])) {

	    
	    	if($_GET['list'] == "pla")
	    	{
	    		$sample = "pla";
	 		}
	 		if($_GET['list'] == "ala")
	    	{
	    		$sample = "ala";
	 		}
	}
	else
	{
		$sample = "pla";
	}
	?>
	<!-- end HEADER -->



	<!-- begin LEFT PANEL -->
	<div id="leftpanel" class="leftpanel">

		<?php require("inc/leftpanel.php"); ?>

		<!-- sub buttons -->
		<ul class="subbuttons">
			<div class="leftpanel-title"><b>COMMANDS</b></div>
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
		</ul>
		
		<!-- extra buttons -->
		<!--<ul class="extrabuttons">
			<li><button><span class="fas fa-arrow-up fa"></span> Move Up</button></li>
			<li><button><span class="fas fa-arrow-down fa"></span> Move Down</button></li>
		</ul>-->

	</div>
	<!-- end LEFT PANEL -->

	<!-- begin MAINPANEL -->
	<div id="mainpanel" class="mainpanel">
		<div class="container-fluid">
			<div class="row">

				<!-- start TABLE AREA -->
				<div id="tablearea1" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
					<div class="mainpanel-content">
						<!-- title & search -->
						<div class="mainpanel-title">
							<span class="fa fa-archive"></span> Staffs
						</div>
						<div class="mainpanel-sub">
							<!-- cmd -->
							<!--<div class="mainpanel-sub-cmd">
								<a href="" class="cmd-create"><span class="far fa-plus-square"></a>
								<a href="" class="cmd-update"><span class="fas fa-edit"></a>
								<a href="" class="cmd-delete"><span class="far fa-trash-alt"></a>
									<span class="mainpanel-sub-space">|</span>
								<a href="" class="cmd-others"><span class="fas fa-caret-up"></a>
								<a href="" class="cmd-others"><span class="fas fa-caret-down"></a>
									<span class="mainpanel-sub-space">|</span>
								<a href="" class="cmd-print"><span class="fas fa-print"></a>
							</div>-->
						</div>
						<!-- tableheader -->
						<div id="container1" class="half">
							<table width="100%" border="0" id="datatbl" class="table table-striped mainpanel-table">
								<thead>	
									<tr class="rowB rowtitle">
										<td style="width:20px;"><span class="fa fa-adjust"></span></td>
										<td style="width:19%;">Worker ID</td>
										<td style="width:19%;">Name</td>
										<td style="width:19%;">Position</td>
										<td style="width:19%;">Department</td>
										<td style="width:19%;">Birthday Leave</td>
										<td style="width:5%;">BIR</td>
										<td style="width: 17px;"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td><span class="fa fa-adjust"></span></td>
									  

									  <td><input style="width:100%;height: 20px;" list="SearchWorker" class="search">
										<?php
											$query = "SELECT distinct workerid FROM worker where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchWorker">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["workerid"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input style="width:100%;height: 20px;" list="SearchName" class="search">
										<?php
											$query = "SELECT distinct name FROM worker where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchName">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["name"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input style="width:100%;height: 20px;" list="SearchName" class="search" disabled>
										<?php
											$query = "SELECT distinct name FROM department where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchName">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["name"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input style="width:100%;height: 20px;" list="SearchName" class="search" disabled>
										<?php
											$query = "SELECT distinct name FROM department where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchName">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["name"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input style="width:100%;height: 20px;" list="SearchName" class="search" disabled>
										<?php
											$query = "SELECT distinct name FROM department where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchName">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["name"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input style="width:100%;height: 20px;" list="SearchName" class="search" disabled>
										<?php
											$query = "SELECT distinct name FROM department where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchName">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["name"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><span></span></td>
									  
									</tr>
								</thead>
								
								<tbody id="resulthead">
									<?php
									$query = "SELECT wk.workerid,wk.Name,pos.name as 'position',format(wk.serviceincentiveleave,2) as serviceincentiveleave,
													format(wk.birthdayleave,2) as birthdayleave,wk.birdeclared,
												lastname,firstname,middlename,STR_TO_DATE(birthdate, '%Y-%m-%d') birthdate,STR_TO_DATE(regularizationdate, '%Y-%m-%d') regularizationdate,STR_TO_DATE(inactivedate, '%Y-%m-%d') inactivedate,bankaccountnum,address,contactnum
													,STR_TO_DATE(datehired, '%Y-%m-%d') as datehired,phnum,pagibignum,tinnum,sssnum
													,case when wk.employmentstatus = 0 then 'Regular' 
													when wk.employmentstatus = 1 then 'Reliever'
													when wk.employmentstatus = 2 then 'Probationary'
													when wk.employmentstatus = 3 then 'Contractual' 
													when wk.employmentstatus = 4 then 'Trainee' else '' end as employmentstatus
													,wk.employmentstatus as employmentstatusid
													,wk.inactive

													FROM worker wk
													left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid 
													where wk.dataareaid = '$dataareaid'";
									$result = $conn->query($query);
									$rowclass = "rowA";
									$rowcnt = 0;
									while ($row = $result->fetch_assoc())
									{ 
										$rowcnt++;
											if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
											else { $rowclass = "rowA";}
										?>
										<tr class="<?php echo $rowclass; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;"><span class="fa fa-angle-right"></span></td>
											<td style="width:19%;"><?php echo $row['workerid'];?></td>
											<td style="width:19%;"><?php echo $row['Name'];?></td>
											<td style="width:19%;"><?php echo $row['position'];?></td>
											<td style="width:19%;"><?php echo $row['serviceincentiveleave'];?></td>
											<td style="width:19%;"><?php echo $row['birthdayleave'];?></td>
											<td style="width:5%;"><input type="checkbox" name="chkbox" class="checkbox"  value="true" <?php echo ($row['birdeclared']==1 ? 'checked' : '');?> onclick="return false;"><div style="visibility:hidden;height: 1px;"><?php echo $row['birdeclared'];?></div></td>
											<td style="display:none;width:1%;"><?php echo $row['firstname'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['middlename'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['lastname'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['birthdate'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['inactivedate'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['regularizationdate'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['bankaccountnum'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['address'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['contactnum'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['datehired'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['phnum'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['pagibignum'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['tinnum'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['sssnum'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['employmentstatus'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['inactive'];?></td>
										</tr>
									<?php }?>
								</tbody>
								<span class="temporary-container-input">
									<input type="input" id="hide">	
								</span>
							</table>
						</div>
					</div>
					<br>
				</div>
				<!-- end TABLE AREA -->
				
			</div>
		</div>
	</div>
	<!-- end MAINPANEL -->

	<!-- begin DASHBOARD -->
	<div class="mainpanel dashboard">
		<div class="container-fluid">


			<!-- TITLE -->
			<!--<div class="row">
				<div class="col=lg-8 col-md-8 col-sm-12 col-xs-12">
					<div class="dashboard-maintitle"><i class="far fa-id-card color-orange"></i> Employee Portal</div>
				</div>
			</div>-->

			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<!-- blue -->
					<div class="dashboard-menu dashboard-menu-red">
						<div class="dashboard-menu-title text-bold">
							Late
						</div>
						<?php 
									$query = "SELECT ss.date,TIME_FORMAT(starttime,'%h:%i %p') as starttime,TIME_FORMAT(endtime,'%h:%i %p') as endtime,ss.workerid,wk.BioId,cons.timein,cons.timeout
												,case when TIME_TO_SEC(SUBTIME(TIME_FORMAT(cons.timein,'%H:%i'),TIME_FORMAT(ss.starttime, '%H:%i'))) > TIME_TO_SEC(CONVERT('00:00:00', TIME)) then
																TIME_TO_SEC(SUBTIME(TIME_FORMAT(cons.timein,'%H:%i'),TIME_FORMAT(ss.starttime, '%H:%i'))) / 60
												        end as late
												,case when TIME_TO_SEC(SUBTIME(TIME_FORMAT(cons.timein,'%H:%i'),TIME_FORMAT(ss.starttime, '%H:%i'))) > TIME_TO_SEC(CONVERT('00:00:00', TIME)) then
														1
												end as latecount
												
												FROM shiftschedule ss 

												left join worker wk on ss.workerid = wk.workerid AND ss.dataareaid = wk.dataareaid

												left join (SELECT consol.date,consol.bioid,intbl.timein,outtbl.timeout FROM 

												consolidationtable consol
												left join (select date,MAX(time) as timeout,bioid,type from consolidationtable where type = 1 #and bioid = '19009' #and date = '2020-01-15'
												group by date,bioid,type) outtbl on consol.BioId = outtbl.bioid and consol.Date = outtbl.date

												left join (select date,MIN(time) as timein,bioid,type from consolidationtable where type = 0 #and bioid = '19009' #and date = '2020-01-15'
												group by date,bioid,type) intbl on consol.BioId = intbl.bioid and consol.Date = intbl.date

												WHERE consol.bioid = '19009' and consol.date between '2020-01-15' and '2020-01-25'

												group by consol.date,consol.bioid) cons on cons.bioid = wk.BioId and cons.date = ss.date


												where ss.date between '2020-01-15'  and '2020-01-25'

												
												and ss.workerid = 'TBOYWR000004'
												order by date";

									$result = $conn->query($query);
									$rowclass = "rowA";
									$usedleave = 0;
									$latemin = 0;
									while ($row = $result->fetch_assoc())
									{ 
											$usedleave = $usedleave + $row['latecount'];
											$latemin = $latemin + $row['late'];
											

									}?>
						<div class="dashboard-menu-content">
							<b class="dashboard-menu-content-sm">Total Mins:</b> <?php echo $latemin;?>
							<b class="dashboard-menu-content-sm">&nbsp;|&nbsp;</b>
							<b class="dashboard-menu-content-sm">Total Count:</b> <?php echo $usedleave;?>
						</div>
					</div>
				</div>

				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<!-- blue -->
					<div class="dashboard-menu dashboard-menu-red">
						<div class="dashboard-menu-title text-bold">
							Absent
						</div>
						<?php 
									$query = "SELECT case when daytype = 1 then count(leaveid) / 2
												else count(leaveid) end as leavecount FROM portalleavefile where status in (0,1) 
													and leavetype = 'VL' and dataareaid = 'DEF' and workerid = '$lognum' group by daytype";

									$result = $conn->query($query);
									$rowclass = "rowA";
									$usedleave = 0;
									while ($row = $result->fetch_assoc())
									{ 
											$usedleave = $usedleave + $row['leavecount'];
											

									}?>
						<div class="dashboard-menu-content">
							<b class="dashboard-menu-content-sm">Total Absent:</b> <?php echo $usedleave;?>
							
						</div>
					</div>
				</div>

			</div>



			<!-- ROW 1 -->
			<div class="row">
				<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
					<div class="dashboard-content">
						<div class="dashboard-title">
							<div class="dashboard-title-left"><i class="far fa-calendar-alt"></i> Schedule</div>
							<div class="dashboard-title-right">
								<b class="dashboard-title-mini">FROM</b> <input type="date" id="add-schedfromdate" name="schedfromdate"> 
								<b class="dashboard-title-mini">TO</b> <input type="date" id="add-schedtodate" name="schedtodate"> 
								<button class="btn btn-info dashboard-title-btn" onClick="RefreshSched();"><i class="fas fa-sync-alt"></i></button>
							</div>
						</div>
						<div>
							<div id="container1" class="half">
								<table class="dashboard-table" border="1" id="dataline1">
									<thead>	
										<tr class="rowtitle">
											<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
											<td style="width:16%;">Day Type</td>
											<td style="width:16%;">Date</td>
											<td style="width:16%;">Day</td>
											<td style="width:16%;">Shift Type</td>
											<td style="width:16%;" class="green">Start Time</td>
											<td style="width:16%;" class="red">End Time</td>
											<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
										</tr>
									</thead>
									<tbody id="result">
										<?php					
										$query = "SELECT daytype,date,weekday as day,shifttype,TIME_FORMAT(starttime,'%h:%i %p') as starttime,TIME_FORMAT(endtime,'%h:%i %p') as endtime 
													FROM shiftschedule
													where date between DATE_SUB(curdate(), INTERVAL 5 DAY) and DATE_ADD(curdate(), INTERVAL 5 DAY)
													and workerid = '$lognum'
													order by date";
										$result = $conn->query($query);
										$rowclass = "rowA";
										$rowcnt = 0;
										$rowcnt2 = 0;
										while ($row = $result->fetch_assoc())
										{ 
											$rowcnt++;
											$rowcnt2++;
												if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
												else { $rowclass = "rowA";}
											?>
											<tr class="<?php echo $rowclass; ?>">
												<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
												<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
												<td style="width:16%;"><?php echo $row['daytype'];?></td>
												<td style="width:16%;"><?php echo $row['date'];?></td>
												<td style="width:16%;"><?php echo $row['day'];?></td>
												<td style="width:16%;"><?php echo $row['shifttype'];?></td>
												<td style="width:16%;"><?php echo $row['starttime'];?></td>
												<td style="width:16%;"><?php echo $row['endtime'];?></td>
												<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
												
											</tr>
										<?php }?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
					<div class="dashboard-content">
						<div class="dashboard-title">
							<div class="dashboard-title-left"><i class="fas fa-user-check"></i> Attendance</div>
							<div class="dashboard-title-right">
								<b class="dashboard-title-mini">FROM</b> <input type="date" id="add-attfromdate" name="attfromdate">
								<b class="dashboard-title-mini">TO</b> <input type="date" id="add-atttodate" name="atttodate"> 
								<button class="btn btn-info dashboard-title-btn" onClick="RefeshAtt();"><i class="fas fa-sync-alt"></i></button>
							</div>
						</div>
						<div id="container1" class="half">
							<table class="dashboard-table" border="1">
								<thead>	
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:33%;">Date</td>
										<td style="width:33%;" class="green">Time In</td>
										<td style="width:33%;" class="red">Time Out</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
								</thead>
								<tbody id="result2">
									<?php					
									$query = "SELECT consol.date,TIME_FORMAT(intbl.timein,'%h:%i %p') as timein,TIME_FORMAT(outtbl.timeout,'%h:%i %p') as timeout,consol.bioid
												FROM 
													consolidationtable consol
													left join (select date,MAX(time) as timeout,bioid,type from consolidationtable where type = 1
													group by date,bioid,type) outtbl on consol.BioId = outtbl.bioid and consol.Date = outtbl.date

													left join (select date,MIN(time) as timein,bioid,type from consolidationtable where type = 0
													group by date,bioid,type) intbl on consol.BioId = intbl.bioid and consol.Date = intbl.date

													where consol.bioid = '$logbio' #and consol.date = '2020-01-15'

													group by consol.date,consol.bioid";
									$result = $conn->query($query);
									$rowclass = "rowA";
									$rowcnt = 0;
									$rowcnt2 = 0;
									while ($row = $result->fetch_assoc())
									{ 
										$rowcnt++;
										$rowcnt2++;
											if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
											else { $rowclass = "rowA";}
										?>
										<tr class="<?php echo $rowclass; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<td style="width:33%;"><?php echo $row['date'];?></td>
											<td style="width:33%;"><?php echo $row['timein'];?></td>
											<td style="width:33%;"><?php echo $row['timeout'];?></td>
											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
											
										</tr>
									<?php }?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			


		</div>
	</div>
	<!-- end MAINPANEL2 -->

<!-- The Modal -->
<div id="myModal" class="modal">
	<!-- Modal content -->
	<div class="modal-container">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-lg-6">Leave Details</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm" accept-charset="utf-8" action="leaveformprocess.php" method="get">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Leave ID:</label>
							<div id="resultid">
								<input type="text" value="" placeholder="Overtime" name ="OTId" id="add-otid" class="modal-textarea" required="required">
							</div>
							

							<label>Leave Date:</label>
							<input type="date" value="" placeholder="" id="add-otdate" name="OTdate" class="modal-textarea" required="required">
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Details:</label>
							<input type="text" value="" placeholder="Overt Time Details" id="add-details" name="OTdetails" class="modal-textarea" required="required">

							<label>Start Time:</label>
							<input type="time" value="" placeholder="" id="add-otstarttime" name="OTstart" class="modal-textarea" required="required">
						</div>

						
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>End Time:</label>
							<input type="time" value="" placeholder="" id="add-otendtime" name="OTend" class="modal-textarea" required="required">

							
							<label>Leave Type:</label>
							<select value="" value="" placeholder="Period" name ="OTleavetype" id="add-leavetype" class="modal-textarea" style="width:100%;height: 28px;"  required="required">
								<option value="" selected="selected"></option>
								<?php
									$query = "SELECT distinct leavetypeid,description FROM leavetype";
									$result = $conn->query($query);			
									  	
										while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["leavetypeid"];?>"><?php echo $row["description"];?></option>
									<?php } ?>
							</select>
							
						</div>
						
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Day Type:</label>
							<select value="" value="" placeholder="Period" name ="OTdaytype" id="add-daytype" class="modal-textarea" style="width:100%;height: 28px;"  required="required">
									<option value=""></option>
									<option value="0">Whole Day</option>
									<option value="1">Half Day</option>
							</select>

						</div>

					</div>

					<div class="button-container">
						<button id="addbt" name="save" value="save" class="btn btn-primary btn-action" onclick="return checkExistForm()">Save</button>
						<button id="upbt" name="update" value="update" class="btn btn-success btn-action" onclick="return validateForm()">Update</button>
						<button onClick="Clear();" type="button" value="Reset" class="btn btn-danger">Clear</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- end modal-->

<!-- begin [JAVASCRIPT] -->
<script src="js/ajax.js"></script>
	<script  type="text/javascript">

		function reply_click(clicked_id)
		{
		    if(clicked_id == 'pla')
		    {
		  		$('#ala').removeClass("active");
				$('#pla').addClass("active");
			}
			else
		    {
		  		$('#ala').removeClass("active");
				$('#pla').addClass("active");
			}
			

		    //  alert(clicked_id);
		}

	  	var so='';
	  	//var locWorkerId = "";
		var locName = "";
		var locLeavedate = "";
		var locDetails = "";
		var locStartTime = "";
		var locEndTime = "";
		var locLeavetype = "";
		var locDaytype = "";
		var locStatus= "";
		var locDateFile = "";
		var locDaytypenum = "";
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locName = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locLeavedate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locDetails = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locStartTime = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(11)").text();
				locEndTime = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(12)").text();
				locLeavetype = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(7)").text();
				locDaytype = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
				locStatus = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
				locDateFile = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
				locDaytypenum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(13)").text();

				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(so);	
					  
			});
		});



		$(document).ready(function(){
    		HL = document.getElementById("hide3").value;
		    $("#"+HL+"").addClass("active");
		});

		// Get the modal -------------------
		var modal = document.getElementById('myModal');
		// Get the button that opens the modal
		var CreateBtn = document.getElementById("myAddBtn");
		var UpdateBtn = document.getElementById("myUpdateBtn");
		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("modal-close")[0];
		// When the user clicks the button, open the modal 
		CreateBtn.onclick = function() {
			$("#myModal").stop().fadeTo(500,1);
		    //modal.style.display = "block";
		    //$("#add-otid").prop('readonly', false);
		    //document.getElementById("add-otid").value = '';
		    document.getElementById("upbt").style.visibility = "hidden";
		    document.getElementById("addbt").style.visibility = "visible";
		    var action = "add";
		    $.ajax({
						type: 'GET',
						url: 'leaveformprocess.php',
						data:{action:action},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							//$("#result").html('<img src="img/loading.gif" width="300" height="300">');
			
						},
						success: function(data){
							$('#resultid').html(data);
							$("#add-otid").prop('readonly', true); 
				}
			});
		}
		UpdateBtn.onclick = function() {
			if(so != '') {
			    modal.style.display = "block";
			    $("#add-otid").prop('readonly', true);

				document.getElementById("add-otid").value = so;
				document.getElementById("add-otdate").value = locLeavedate.toString();
				document.getElementById("add-details").value = locDetails.toString();
				document.getElementById("add-otstarttime").value = locStartTime;
				document.getElementById("add-otendtime").value = locEndTime;
				document.getElementById("add-leavetype").value = locLeavetype.toString();
				document.getElementById("add-daytype").value = locDaytypenum.toString();
				
			    document.getElementById("addbt").style.visibility = "hidden";
			    document.getElementById("upbt").style.visibility = "visible";
			}
			else 
			{
				alert("Please Select a record you want to update.");
			}
		}
		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
		    modal.style.display = "none";
		    Clear();
		}
		// When the user clicks anywhere outside of the modal, close it
		/*window.onclick = function(event) {
		    if (event.target == modal || event.target == modal2) {
		        modal.style.display = "none";
		        Clear();
		        
		    }
		}*/
		//end modal ---------------------------
		var myId = [];
		function checkExistForm()
		{
			//window.location.href='employee2.php';	
			var vleavetype = document.getElementById("add-leavetype").value;
			var vDaytype = 	document.getElementById("add-daytype").value;

			var cont = document.getElementById("hideval").value;
			var cred = 5;
			var x = 0;

			if(vleavetype == 'VL'){
				if(vDaytype == 1){
					x = cont - 0.5;
				}
				else
				{
					x = cont - 1;
				}
			}

			
			alert(x);
			if(x >= 0){
				alert("Continue Saving...");
				return true;
			}
			else
			{
				
				alert("Insufficient Leave Credit");
				return false;
			}
			//return false;	
		}

		function validateForm() {
		  var x = document.forms["myForm"]["update"].value;
		  if (x == "update") {
		    if(confirm("Are you sure you want to update this record?")) {
		    	return true;
		    }
		    else
		    {
		    	modal.style.display = "none";
		    	Clear();
		    	return false;
		    }
		  }
		}

  		//-----search-----//
		$( ".search" ).on( "keydown", function(event) {
		  if(event.which == 13){
			var search = document.getElementsByClassName('search');

			var slocOvertimeId = "";
			var slocName = "";
			var slocOvertimedate = "";
			var slocDetails = "";
			var slocStartTime = "";
			var slocEndTime = "";
			var slocHours = "";
			var slocMinutes = "";
			var slocStatus= "";
			var slocDateFile = "";

			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 slocOvertimeId = data[0];
			 slocName = data[1];
			 slocOvertimedate = data[2];
			
			 $.ajax({
						type: 'GET',
						url: 'leaveformprocess.php',
						data:{action:action, actmode:actionmode, slocOvertimeId:slocOvertimeId, slocName:slocName, slocOvertimedate:slocOvertimedate},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
			
						},
						success: function(data){
							$('#result').html(data);
				}
			}); 
			 
		  }
		});
		//-----end search-----//

		function Clear()
		{
			if(so != '') {
				//document.getElementById("add-id").value = "";
				document.getElementById("add-otdate").value =  "";
				document.getElementById("add-details").value =  "";
				document.getElementById("add-otstarttime").value =  "";
				document.getElementById("add-otendtime").value =  "";
				document.getElementById("add-othours").value =  "";
				document.getElementById("add-otminutes").value =  "";
			}
			else
			{
				document.getElementById("add-otdate").value =  "";
				document.getElementById("add-details").value =  "";
				document.getElementById("add-otstarttime").value =  "";
				document.getElementById("add-otendtime").value =  "";
				document.getElementById("add-othours").value =  "";
				document.getElementById("add-otminutes").value =  "";
			}
		}

		function Save()
		{
			
			modal.style.display = "none";
			/*var UId = document.getElementById("add-UserId");
			var UPass = document.getElementById("add-pass");
			var NM = document.getElementById("add-name");
			var DT = document.getElementById("add-dataareaid");*/
			var NumId = $('#add-id').val();
			var NumPrefix = $('#add-prefix').val();
			var NumFirst = $('#add-first').val();
			var NumLast = $('#add-last').val();
			var NumFormat = $('#add-format').val();
			var NumNext = $('#add-next').val();
			var NumSuffix = $('#add-suffix').val();
			var action = "save";
			var actionmode = "userform";
			$.ajax({	
					type: 'GET',
					url: 'overtimeformprocess.php',
					//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
					data:{action:action, actmode:actionmode, NumId:NumId, NumPrefix:NumPrefix, NumFirst:NumFirst, NumLast:NumLast, NumFormat:NumFormat, NumNext:NumNext, NumSuffix:NumSuffix},
					beforeSend:function(){
							
					$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
						
					},
					success: function(data){
					//$('#datatbl').html(data);
					location.reload();					
					}
			}); 
						
		}

		function Update()
		{
			
			modal.style.display = "none";
			/*var UId = document.getElementById("add-UserId");
			var UPass = document.getElementById("add-pass");
			var NM = document.getElementById("add-name");
			var DT = document.getElementById("add-dataareaid");*/
			var NumId = $('#add-id').val();
			var NumPrefix = $('#add-prefix').val();
			var NumFirst = $('#add-first').val();
			var NumLast = $('#add-last').val();
			var NumFormat = $('#add-format').val();
			var NumNext = $('#add-next').val();
			var NumSuffix = $('#add-suffix').val();
			var action = "update";
			var actionmode = "userform";
			if(so != '') {
				if(confirm("Are you sure you want to update this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'overtimeformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, NumId:NumId, NumPrefix:NumPrefix, NumFirst:NumFirst, NumLast:NumLast, NumFormat:NumFormat, NumNext:NumNext, NumSuffix:NumSuffix},
							beforeSend:function(){
									
							$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							//$('#conttables').html(data);
							location.reload();					
							}
					}); 
				}
				else 
				{
					return false;
				}
			}
			else 
			{
				alert("Please Select a record you want to update.");
			}			
		}

		function Delete()
		{
			
			var action = "delete";
			var actionmode = "userform";
			if(so != '') {
				if(confirm("Are you sure you want to remove this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'overtimeformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, NumId:so},
							beforeSend:function(){
									
							$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							//$('#conttables').html(data);
							location.reload();					
							}
					}); 
				}
				else 
				{
					return false;
				}
			}
			else 
			{
				alert("Please Select a record you want to delete.");
			}			
		}
		function Cancel()
		{

			window.location.href='employee.php';	
			 
		}


	</script>
<script type="text/javascript" src="js/custom.js"></script>
<!-- end [JAVASCRIPT] -->

</body>
</html>