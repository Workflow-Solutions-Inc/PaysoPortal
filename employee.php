<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
$user = $_SESSION["portaluser"];
$dataareaid = $_SESSION["portaldefaultdataareaid"];

$startdate = '';
$enddate = '';
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








	<!-- begin DASHBOARD -->
	<div class="mainpanel dashboard">
		<div class="container-fluid">


			<!-- TITLE -->
			<div class="row">
				<div class="col=lg-8 col-md-8 col-sm-12 col-xs-12">
					<div class="dashboard-maintitle"><i class="far fa-id-card color-orange"></i> Employee Portal</div>
				</div>
			</div>




			<!-- ROW 1 -->
			<div class="row">
				<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
					<div class="dashboard-content">
						<div class="dashboard-title">
							<div class="dashboard-title-left"><i class="far fa-calendar-alt"></i> Schedule</div>
							<div class="dashboard-title-right">
								<?php
										
										$queryFilter = "SELECT STR_TO_DATE(startdate, '%Y-%m-%d') startdate,STR_TO_DATE(enddate, '%Y-%m-%d') enddate 

														FROM payrollperiod where STR_TO_DATE(startdate, '%Y-%m-%d') <= curdate() and STR_TO_DATE(enddate, '%Y-%m-%d') >= curdate()
														and dataareaid = '$dataareaid'";
										$resultFilter = $conn->query($queryFilter);
										while ($rowFilter = $resultFilter->fetch_assoc())
										{ 	
											$startdate = $rowFilter['startdate'];
											$enddate = $rowFilter['enddate'];
										}

								?>
								
								<b class="dashboard-title-mini">FROM</b> <input type="date" id="add-schedfromdate" name="schedfromdate" value = '<?php echo $startdate;?>'> 
								<b class="dashboard-title-mini">TO</b> <input type="date" id="add-schedtodate" name="schedtodate" value = '<?php echo $enddate;?>'> 
								<button class="btn btn-info dashboard-title-btn" onClick="RefreshSched();"><i class="fas fa-sync-alt"></i></button>
							</div>
						</div>
						<div>
							<div id="container1" class="half">
								<table class="dashboard-table" border="1" id="datatbl">
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
													where #date between DATE_SUB(curdate(), INTERVAL 30 DAY) and DATE_ADD(curdate(), INTERVAL 30 DAY)
													date between '$startdate' and '$enddate'
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

											$chkr = "";
											$chkr2 = "";
											$chkr3 = "";
											$chkr4 = "";
											if($row['daytype']=="Restday"){
												$chkr = "background-color:#90EE90";
												$chkr2 = "";
												$chkr3 = "";
												$chkr4 = "";
											}else{
												//$chkr = "background-color:#00FF00";
												$chkr2 = $row["shifttype"];
												$chkr3 = $row["starttime"];
												$chkr4 = $row["endtime"];
											}
											?>
											<tr class="<?php echo $rowclass; ?>" style = "<?php echo $chkr; ?>">
												<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
												<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
												<td style="width:16%;"><?php echo $row['daytype'];?></td>
												<td style="width:16%;"><?php echo $row['date'];?></td>
												<td style="width:16%;"><?php echo $row['day'];?></td>
												<td style="width:16%;"><?php echo $chkr2;?></td>
												<td style="width:16%;"><?php echo $chkr3;?></td>
												<td style="width:16%;"><?php echo $chkr4;?></td>
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
							<!--<div class="dashboard-title-right">
								<b class="dashboard-title-mini">FROM</b> <input type="date" id="add-attfromdate" name="attfromdate">
								<b class="dashboard-title-mini">TO</b> <input type="date" id="add-atttodate" name="atttodate"> 
								<button class="btn btn-info dashboard-title-btn" onClick="RefeshAtt();"><i class="fas fa-sync-alt"></i></button>
							</div>-->
						</div>
						<div id="container1" class="half">
							<table class="dashboard-table" border="1">
								<thead>	
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:33%;">Date</td>
										<td style="width:33%;" class="green">Time In</td>
										<td style="width:33%;" class="green">Break Out</td>
										<td style="width:33%;" class="green">Break In</td>
										<td style="width:33%;" class="red">Time Out</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
								</thead>
								<tbody id="result2">

									<?php					
									$query = "SELECT DATE_FORMAT(mt.date, '%m/%d/%Y') as 'date',
	TIME_FORMAT(min(case when mt.type = 0 then mt.Time else null end),'%h:%i %p') as 'timein',
        TIME_FORMAT(min(case when mt.type = 4 then mt.Time else null end),'%h:%i %p') as 'breakout',
        TIME_FORMAT(min(case when mt.type = 3 then mt.Time else null end),'%h:%i %p') as 'breakin',
	TIME_FORMAT(max(case when mt.type = 1 then mt.Time else null end),'%h:%i %p') as 'timeout', 
        mt.Name as bioid
	from monitoringtable mt 
		left join worker wk ON mt.Name = wk.BioId 
		left join payrolldetails pd on wk.workerid = pd.workerid and wk.dataareaid = pd.dataareaid 
		left join payrollheader ph on pd.payrollid = ph.payrollid and wk.dataareaid = ph.dataareaid 
	
    where mt.name = '$logbio' and mt.date between '".$startdate."' and '".$enddate."'
	group by mt.date order by mt.date asc";
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
											<td style="width:33%;"><?php echo $row['breakout'];?></td>
											<td style="width:33%;"><?php echo $row['breakin'];?></td>
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



			<!-- ROW 2 -->
			<div class="row">
				<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
					<div class="dashboard-content">
						<div class="dashboard-title"><i class="far fa-user-circle"></i> Personal Information</div>
						<hr>
						<div>
							<?php 
									$query = "SELECT wk.workerid,wk.name,pos.name as 'position',
													format(wk.serviceincentiveleave,2) as serviceincentiveleave,
													format(wk.birthdayleave,2) as birthdayleave,wk.birdeclared,
													lastname,firstname,middlename,
													STR_TO_DATE(birthdate, '%Y-%m-%d') birthdate,
													STR_TO_DATE(regularizationdate, '%Y-%m-%d') regularizationdate,
													STR_TO_DATE(inactivedate, '%Y-%m-%d') inactivedate,
													bankaccountnum,address,contactnum
													,STR_TO_DATE(datehired, '%Y-%m-%d') as datehired,
													phnum,pagibignum,tinnum,sssnum
													,case when wk.employmentstatus = 0 then 'Normal' 
													when wk.employmentstatus = 1 then 'New'
													when wk.employmentstatus = 2 then 'Separated'
													else '' end as employmentstatus
													,wk.employmentstatus as employmentstatusid
													,wk.inactive

													FROM worker wk
													left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid 
													where wk.dataareaid = '$dataareaid' and wk.workerid = '$lognum'";
									$result = $conn->query($query);
									$rowclass = "rowA";
									$rowcnt = 0;
									while ($row = $result->fetch_assoc())
									{ 
											$wkname = $row['name'];
											$wkposition = $row['position'];
											$wkbirthday = $row['birthdate'];
											$wkregdate = $row['regularizationdate'];
											$wkaddress = $row['address'];
											$wkphonenum = $row['contactnum'];

											$wkbank = $row['bankaccountnum'];
											$wkempstatus = $row['employmentstatus'];
											$wkph = $row['phnum'];
											$wkpbg = $row['pagibignum'];
											$wktin = $row['tinnum'];
											$wksss = $row['sssnum'];

											$wkvl = $row['serviceincentiveleave'];
											$wksl = $row['birthdayleave'];

									}?>
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
											<b class="dashboard-bigtext"><?php echo $wkname;?></b>
										</div>
										<div class="dashboard-item">
											<span class="dashboard-minititle">Position:</span>
											<span class="dashboard-bigtext"><?php echo $wkposition;?></span>
										</div>
										<div>
											<span class="dashboard-minititle">Birthdate:</span>
											<span class="dashboard-bigtext"><?php echo $wkbirthday;?></span>
										</div>
										<div>
											<span class="dashboard-minititle">Regularization:</span>
											<span class="dashboard-bigtext"><?php echo $wkregdate;?></span>
										</div>
										<div>
											<span class="dashboard-minititle">Address:</span>
											<span class="dashboard-bigtext"><?php echo $wkaddress;?></span>
										</div>
										<div>
											<span class="dashboard-minititle">Phone Number:</span>
											<span class="dashboard-bigtext"><?php echo $wkphonenum;?></span>
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
											<span class="dashboard-bigtext"><?php echo $wkbank;?></span>
										</div>
										<div>
											<span class="dashboard-minititle-xl">Employment Status:</span>
											<span class="dashboard-bigtext"><?php echo $wkempstatus;?></span>
										</div>
									</td>
									<td width="33%" valign="top">
										<div>
											<span class="dashboard-minititle-sm">PhilHealth:</span>
											<span class="dashboard-bigtext"><?php echo $wkph;?></span>
										</div>
										<div>
											<span class="dashboard-minititle-sm">Pag-ibig:</span>
											<span class="dashboard-bigtext"><?php echo $wkpbg;?></span>
										</div>
									</td>
									<td width="33%" valign="top">
										<div>
											<span class="dashboard-minititle-xs">TIN:</span>
											<span class="dashboard-bigtext"><?php echo $wktin;?></span>
										</div>
										<div>
											<span class="dashboard-minititle-xs">SSS:</span>
											<span class="dashboard-bigtext"><?php echo $wksss;?></span>
										</div>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>

				
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<!-- blue -->
					<div class="dashboard-menu dashboard-menu-green">
						<div class="dashboard-menu-title text-bold">
							Service Incetive Leave
						</div>
						<?php 
									/*$query = "SELECT case when daytype = 1 then count(leaveid) / 2
												else count(leaveid) end as leavecount FROM portalleavefile where status in (0,1,3) 
													and leavetype = 'VL' and dataareaid = 'DEF' and workerid = '$lognum' group by daytype";*/
									$query = "SELECT format(sum(balance),2) balance FROM leavefile where workerid = '$lognum' and dataareaid = '$dataareaid' and ispaid = '1' and (STR_TO_DATE(fromdate, '%Y-%m-%d') <= curdate() and STR_TO_DATE(todate, '%Y-%m-%d') >= curdate()) ";	

									$result = $conn->query($query);
									$rowclass = "rowA";
									$vl = 0;
									while ($row = $result->fetch_assoc())
									{ 
											$vl = $row['balance'];
											

									}
									$query2 = "SELECT case when daytype = 1 then count(leaveid) / 2
												else count(leaveid) end as leavecount FROM portalleavefile where status in (0,1,3) 
													 and dataareaid = '$dataareaid' and workerid = '$lognum' group by daytype";	

									$result2 = $conn->query($query2);
									$rowclass = "rowA";
									$usedleave = 0;
									while ($row2 = $result2->fetch_assoc())
									{ 
											$usedleave = $usedleave + $row2['leavecount'];
											

									}

									?>
						<div class="dashboard-menu-content">
							<b class="dashboard-menu-content-sm">available:</b> <?php echo $vl;?>
							<!-- <b class="dashboard-menu-content-sm">&nbsp;|&nbsp;</b>
							<b class="dashboard-menu-content-sm">used:</b> <?php echo $usedleave;?> -->
						</div>
					</div>
				</div>


				<!--
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					
					<div class="dashboard-menu dashboard-menu-blue">
						<div class="dashboard-menu-title text-bold">
							Sick Leave
						</div>
						<div class="dashboard-menu-content">
							<b class="dashboard-menu-content-sm">available:</b> <?php echo $wkvl;?>
							<b class="dashboard-menu-content-sm">&nbsp;|&nbsp;</b>
							<b class="dashboard-menu-content-sm">used:</b> 0
						</div>
					</div>
				</div>-->


				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<br>
					<button class="btn btn-success dashboard-btn-big" onclick="location.href = 'leaveform.php';">
						<i class="fas fa-file-export fa-2x"></i><br>
						File a<br>Leave
					</button>
					<button class="btn btn-warning dashboard-btn-big" onclick="location.href = 'overtimeform.php';">
						<i class="far fa-clock fa-2x"></i><br>
						File an<br>Overtime
					</button>
					<button class="btn btn-primary dashboard-btn-big" onclick="location.href = 'fieldworkform.php';">
						<i class="fas fa-file-invoice fa-2x"></i><br>
						File A<br>Field Work
					</button>
				</div>
			</div>





		</div>
	</div>
	<!-- end MAINPANEL -->


<!-- begin [JAVASCRIPT] -->
<script src="js/ajax.js"></script>
	<script  type="text/javascript">
	
		function RefreshSched()
		{
			
			var action = "refresh";
			var actionmode = "schedule";
			var slocFromdate = $('#add-schedfromdate').val();
			var slocTodate = $('#add-schedtodate').val();

			if(slocFromdate > slocTodate){
				alert("To Date Must be greater than From Date!");
			}
			else
			{
				$.ajax({
					type: 'GET',
					url: 'employeeformprocess.php',
					data:{action:action, actmode:actionmode, slocFromdate:slocFromdate, slocTodate:slocTodate},

					beforeSend:function(){
					
						$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
		
					},
					success: function(data){
						$('#result').html(data);
						RefeshAtt();
					}
				}); 
			}
							
		}

		function RefeshAtt()
		{
			
			var action = "refresh";
			var actionmode = "attendance";
			var slocFromdate = $('#add-schedfromdate').val();
			var slocTodate = $('#add-schedtodate').val();

			if(slocFromdate > slocTodate){
				alert("To Date Must be greater than From Date!");
			}
			else
			{
			
				$.ajax({
					type: 'GET',
					url: 'employeeformprocess.php',
					data:{action:action, actmode:actionmode, slocFromdate:slocFromdate, slocTodate:slocTodate},

					beforeSend:function(){
					
						$("#result2").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
		
					},
					success: function(data){
						$('#result2').html(data);
					}
				}); 
			}			
		}
	</script>
	<script type="text/javascript" src="js/custom.js"></script>
<!-- end [JAVASCRIPT] -->

</body>
</html>
