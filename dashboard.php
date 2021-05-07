<?php 
session_id("protal");
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
	<title>S : Staff Dashboard</title>

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</head>
<body>

	<!-- begin HEADER -->
	<?php require("inc/header.php"); ?>
	<!-- end HEADER -->

	<!-- begin LEFT PANEL -->
	<div id="leftpanel" class="leftpanel">

		<?php require("inc/leftpanel.php"); ?>

		<!-- sub buttons -->
		<ul class="subbuttons">
			<div class="leftpanel-title"><b>COMMANDS</b></div>
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
			<!--<li><button><span class="far fa-plus-square"></span> Create Record</button></li>
			<li><button><span class="fas fa-edit"></span> Update Record</button></li>
			<li><button><span class="far fa-trash-alt"></span> Delete Record</button></li>-->
		</ul>

		<!-- extra buttons -->
		<!--<ul class="extrabuttons">
			<div class="leftpanel-title"><b>POSITION</b></div>
			<li><button><span class="fas fa-caret-up"></span> Move Up</button></li>
			<li><button><span class="fas fa-caret-down"></span> Move Down</button></li>
		</ul>-->

	</div>
	<!-- end LEFT PANEL -->


	<!-- begin DASHBOARD -->
	<div class="mainpanel dashboard">
		<div class="container-fluid">


			<!-- TITLE -->
			<div class="row">
				<div class="col=lg-8 col-md-8 col-sm-12 col-xs-12">
					<div class="dashboard-maintitle"><i class="fas fa-tachometer-alt"></i> Staff Dashboard</div>
				</div>
				<!--<div class="col=lg-4 col-md-4 col-sm-12 col-xs-12 text-right">
					<button class="btn btn-primary"><i class="fas fa-file-alt"></i> Generate Report</button>
				</div>-->
			</div>

			<?php 
				$query = "SELECT wk.workerid
						,wk.Name
						,pos.name as 'position'
						,dep.name as 'department'
						,bra.name	as 'branch'
						
						,wk.bioid
						,DATE_SUB(curdate(), INTERVAL 50 DAY) getfromdate
						,DATE_ADD(curdate(), INTERVAL 50 DAY) gettodate

						FROM worker wk
						left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid 
						left join contract con on con.workerid = wk.workerid and con.dataareaid = wk.dataareaid
						left join ratehistory rt on con.contractid = rt.contractid and con.dataareaid = rt.dataareaid
						left join department dep on dep.departmentid = con.departmentid and dep.dataareaid = wk.dataareaid
						left join branch bra on bra.branchcode = wk.branch and bra.dataareaid = wk.dataareaid
						left join organizationalchart org on org.workerid = wk.workerid and org.dataareaid = wk.dataareaid
						
						where wk.dataareaid = '$dataareaid' and rt.status = 1 and org.repotingid = '$lognum'

						order by wk.workerid";

				
				$result2 = $conn->query($query);
				$row2 = $result2->fetch_assoc();
				$firstresultid = $row2["workerid"];
				$firstresultbio = $row2["bioid"];
				
			?>

			<?php
					$startdate = '';
					$enddate = '';
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


			<!-- ROW 1 -->
			<div class="row">

				<?php 
					$query = "SELECT count(*) as totalleave

							from portalleavefile 
							where dataareaid = '$dataareaid' and status = 0 and workerid = '$firstresultid' ";

					$result = $conn->query($query);
					$rowclass = "rowA";
					$totleave = 0;
					$mins = 0;
					while ($row = $result->fetch_assoc())
					{ 
							$totleave = $row['totalleave'];
							

					}
		
				?>
				<!-- ROW 1 - COLUMN 1 -->
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<!-- blue -->
					<div class="dashboard-menu dashboard-menu-blue">
						<div class="dashboard-menu-title text-bold">
							Leave Application:
						</div>
						<div class="dashboard-menu-content" id="leavecontent">
							<b class="dashboard-menu-content-sm">Filed:</b> <?php echo $totleave;?>  Day
						</div>
					</div>
				</div>

						<?php 
								$query = "SELECT sum(hours) as totalhour,sum(minutes) as totalmins

										from overtimefile 
										where dataareaid = '$dataareaid' and status = 0 and workerid = '$firstresultid';";

								$result = $conn->query($query);
								$rowclass = "rowA";
								$hours = 0;
								$mins = 0;
								while ($row = $result->fetch_assoc())
								{ 
										$hours = $row['totalhour'];
										$mins = $row['totalmins'];

								}

								function convertTime() {
								    $args = func_get_args();
								    switch (count($args)) {
								        case 1:     //total minutes was passed so output hours, minutes
								            $time = array();
								            $time['hours'] = floor($args[0]/60);
								            $time['mins'] = ($args[0]%60);
								            return $time;
								            break;
								        case 2:     //hours, minutes was passed so output total minutes
								            return ($args[0] * 60) + $args[1];
								    }
								}

								//test the function
								//$hours = 6;
								//$mins = 125;
								//echo 'total minutes = '.convertTime($hours,$mins);

								$totalMinutes = convertTime($hours,$mins);
								$times = convertTime($totalMinutes);
								//echo '<br /><br />Hours = '.$times['hours'].'<br />Minutes = '.$times['mins'];
							?>
				
				<!-- ROW 1 - COLUMN 2 -->
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<!-- green -->
					<div class="dashboard-menu dashboard-menu-green">
						<div class="dashboard-menu-title text-bold">
							Pending Overtime:
						</div>
						<div class="dashboard-menu-content" id="otcontent">
							<b class="dashboard-menu-content-sm">Hours:</b> <?php echo $times['hours'];?> Hr
							<b class="dashboard-menu-content-sm">&nbsp;|&nbsp;</b>
							<b class="dashboard-menu-content-sm">Minutes:</b> <?php echo $times['mins'];?> Min
						</div>
					</div>
				</div>
				<!-- Query -->
				<?php 
									$query = "SELECT ss.date,TIME_FORMAT(starttime,'%h:%i %p') as starttime,TIME_FORMAT(endtime,'%h:%i %p') as endtime,ss.workerid,wk.BioId,cons.timein,cons.timeout
												,case when TIME_TO_SEC(SUBTIME(TIME_FORMAT(cons.timein,'%H:%i'),TIME_FORMAT(ss.starttime, '%H:%i'))) > TIME_TO_SEC(CONVERT('00:00:00', TIME)) then
																TIME_TO_SEC(SUBTIME(TIME_FORMAT(cons.timein,'%H:%i'),TIME_FORMAT(ss.starttime, '%H:%i'))) / 60
														end as late
												,case when TIME_TO_SEC(SUBTIME(TIME_FORMAT(cons.timein,'%H:%i'),TIME_FORMAT(ss.starttime, '%H:%i'))) > TIME_TO_SEC(CONVERT('00:00:00', TIME)) 
										        then 1 end as latecount,
										        case when ifnull(cons.timein,0) then 1 else 0 end as daywork,
												case when ifnull(cons.timein,0) then 0 else 1 end as absent,
												1 as attcount
												
												FROM shiftschedule ss 

												left join worker wk on ss.workerid = wk.workerid AND ss.dataareaid = wk.dataareaid

												left join (SELECT consol.date,consol.bioid,intbl.timein,outtbl.timeout FROM 

												consolidationtable consol
												left join (select date,MAX(time) as timeout,bioid,type from consolidationtable where type = 1 #and bioid = '19009' #and date = '2020-01-15'
												group by date,bioid,type) outtbl on consol.BioId = outtbl.bioid and consol.Date = outtbl.date

												left join (select date,MIN(time) as timein,bioid,type from consolidationtable where type = 0 #and bioid = '19009' #and date = '2020-01-15'
												group by date,bioid,type) intbl on consol.BioId = intbl.bioid and consol.Date = intbl.date

												WHERE consol.bioid = '$firstresultbio' #and consol.date between '2020-01-15' and '2020-01-25'

												group by consol.date,consol.bioid) cons on cons.bioid = wk.BioId and cons.date = ss.date


												where 
												
												ss.date between '$startdate' and '$enddate' and
												ss.workerid = '$firstresultid'
												order by date";

									$result = $conn->query($query);
									$rowclass = "rowA";
									$usedleave = 0;
									$dayswork = 0;
									$daysabsent = 0;
									$latemin = 0;
									$latecount = 0;
									while ($row = $result->fetch_assoc())
									{ 
											$daysabsent = $daysabsent + $row['absent'];
											$dayswork = $dayswork + $row['daywork'];
											$latemin = $latemin + $row['late'];
											$latecount = $latecount + $row['latecount'];
											

									}
					?>
				
				<!-- ROW 1 - COLUMN 3 -->
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<!-- orange -->
					<div class="dashboard-menu dashboard-menu-orange">
						<div class="dashboard-menu-title text-bold">
							Late:
						</div>
						<div class="dashboard-menu-content" id="latecontent">
							<b class="dashboard-menu-content-sm">Mins:</b> <?php echo $latemin;?> Min
							<b class="dashboard-menu-content-sm">&nbsp;|&nbsp;</b>
							<b class="dashboard-menu-content-sm">Count:</b> <?php echo $latecount;?> Late
						</div>
					</div>
				</div>
				
				<!-- ROW 1 - COLUMN 4 -->
				<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
					<!-- red -->
					<div class="dashboard-menu dashboard-menu-red">
						<div class="dashboard-menu-title text-bold">
							Absent:
						</div>
						<div class="dashboard-menu-content" id="absentcontent">
							<b class="dashboard-menu-content-sm">Absent:</b> <?php echo $daysabsent;?> Day
							<b class="dashboard-menu-content-sm">&nbsp;|&nbsp;</b>
							<b class="dashboard-menu-content-sm">Worked:</b> <?php echo $dayswork;?> Day
						</div>
					</div>
				</div>
			</div>






			<!-- ROW 2 -->
			<div class="row">
				<!-- ROW 2 - COLUMN 1 -->
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<div class="dashboard-content">
						
						<div class="dashboard-title">
							<div class="dashboard-title-left"><i class="far fa-calendar-alt"></i> Schedule</div>
							<div class="dashboard-title-right">
								
								<b class="dashboard-title-mini">FROM</b> <input type="date" id="add-schedfromdate" name="schedfromdate" value = '<?php echo $startdate;?>'> 
								<b class="dashboard-title-mini">TO</b> <input type="date" id="add-schedtodate" name="schedtodate" value = '<?php echo $enddate;?>'> 
								<button class="btn btn-info dashboard-title-btn" onClick="RefreshSched();"><i class="fas fa-sync-alt"></i></button>
							</div>
						</div>

						<div>
							<div id="container1" class="half">
								<table class="dashboard-table" border="1" id="dataline1">
									<thead>	
										<tr class="rowtitle">
											<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
											<td style="width:16%;" class="blue">Day Type</td>
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
													where date between '$startdate' and '$enddate'
													and workerid = '$firstresultid'
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


				<!-- ROW 2 - COLUMN 2 -->
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
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

													where consol.bioid = '$firstresultbio' #and consol.date = '2020-01-15'

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





			<!-- ROW 3 -->
			<!--<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<div class="dashboard-content">
						<div class="dashboard-title">Duis Aute</div>
						<div>
							Irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt.
						</div>
						<hr>
						<div><button class="btn btn-primary">Dolor Sit Amet</button></div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<div class="dashboard-content">
						<div class="dashboard-title">Reprehenderit in Voluptate</div>
						<div>
							Velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa.
						</div>
						<hr>
						<div>
							<button class="btn btn-success"><i class="fas fa-check"></i> Accept</button>
							<button class="btn btn-danger"><i class="fas fa-times"></i> Decline</button>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<div class="dashboard-content">
						<div class="dashboard-title">Consectetur Adipiscing Elit</div>
						<div>
							Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
						</div>
						<hr>
						<div><button class="btn btn-warning">Lorem Ipsum</button></div>
					</div>
				</div>
			</div>-->





			<!-- ROW 4 -->
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="dashboard-content">
						<div class="row">

							<!-- start TABLE AREA -->
							<div id="tablearea1" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area" style="padding: 0px !important;">
								<div class="mainpanel-content" style="padding: 0px 15px !important; margin-top: 5px !important; background-color: #FBFBFB;">
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
												<tr class="rowB rowtitle" style="background-color: #317fdf !important; color: #FFF;">
													<td style="width:20px;"><span class="fa fa-adjust"></span></td>
													<td style="width:20%;">Worker ID</td>
													<td style="width:20%;">Name</td>
													<td style="width:20%;">Position</td>
													<td style="width:20%;">Department</td>
													<td style="width:20%;">Branch</td>
													
													<td style="width: 17px;"><span class="fas fa-arrows-alt-v"></span></td>
												</tr>
												<tr class="rowsearch">
												  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
												  
												  
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
												  <td><input style="width:100%;height: 20px;" list="SearchPosition" class="search" >
													<?php
														$query = "SELECT distinct pos.name as 'position'

																FROM worker wk
																left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid 
																where wk.dataareaid = '$dataareaid'";
														$result = $conn->query($query);	
															
												  ?>
												  <datalist id="SearchPosition">
													
													<?php 
													
														while ($row = $result->fetch_assoc()) {
													?>
														<option value="<?php echo $row["position"];?>"></option>
														
													<?php } ?>
													</datalist>
												  </td>
												  <td><input style="width:100%;height: 20px;" list="SearchDepartment" class="search" >
													<?php
														$query = "SELECT distinct name FROM department where dataareaid = '$dataareaid'";
														$result = $conn->query($query);	
															
												  ?>
												  <datalist id="SearchDepartment">
													
													<?php 
													
														while ($row = $result->fetch_assoc()) {
													?>
														<option value="<?php echo $row["name"];?>"></option>
														
													<?php } ?>
													</datalist>
												  </td>
												  <td><input style="width:100%;height: 20px;" list="SearchBranch" class="search" >
													<?php
														$query = "SELECT distinct name FROM branch where dataareaid = '$dataareaid'";
														$result = $conn->query($query);	
															
												  ?>
												  <datalist id="SearchBranch">
													
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
												$query = "SELECT wk.workerid,wk.Name,pos.name as 'position',dep.name as 'department',bra.name	as 'branch',
																format(wk.serviceincentiveleave,2) as serviceincentiveleave,
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
																,wk.bioid
																,DATE_SUB(curdate(), INTERVAL 50 DAY) getfromdate
																,DATE_ADD(curdate(), INTERVAL 50 DAY) gettodate

																FROM worker wk
																left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid 
																left join contract con on con.workerid = wk.workerid and con.dataareaid = wk.dataareaid
																left join ratehistory rt on con.contractid = rt.contractid and con.dataareaid = rt.dataareaid
																left join department dep on dep.departmentid = con.departmentid and dep.dataareaid = wk.dataareaid
																left join branch bra on bra.branchcode = wk.branch and bra.dataareaid = wk.dataareaid
																left join organizationalchart org on org.workerid = wk.workerid and org.dataareaid = wk.dataareaid
						
																where wk.dataareaid = '$dataareaid' and rt.status = 1 and org.repotingid = '$lognum'

																order by wk.workerid";
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
														<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
														<td style="width:19%;"><?php echo $row['workerid'];?></td>
														<td style="width:19%;"><?php echo $row['Name'];?></td>
														<td style="width:19%;"><?php echo $row['position'];?></td>
														<td style="width:19%;"><?php echo $row['department'];?></td>
														<td style="width:19%;"><?php echo $row['branch'];?></td>
														<td style="display:none;width:1%;"><input type="checkbox" name="chkbox" class="checkbox"  value="true" <?php echo ($row['birdeclared']==1 ? 'checked' : '');?> onclick="return false;"><div style="visibility:hidden;height: 1px;"><?php echo $row['birdeclared'];?></div></td>
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
														<td style="display:none;width:1%;"><?php echo $row['bioid'];?></td>
														<td style="display:none;width:1%;"><?php echo $row['getfromdate'];?></td>
														<td style="display:none;width:1%;"><?php echo $row['gettodate'];?></td>
													</tr>
												<?php }?>
											</tbody>
											<span class="temporary-container-input">
												<input type="hidden" id="hide" value="<?php echo $firstresultid;?>">
												<input type="hidden" id="hide2" value="<?php echo $firstresultbio;?>">
												<input type="hidden" id="hidesearch" value="false">
												
													
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


		</div>
	</div>
	<!-- end MAINPANEL -->


<!-- begin [JAVASCRIPT] -->
<script src="js/ajax.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
	<script  type="text/javascript">

		var so='';
		var locbioid='';
		var locFromdate = '';
		var locTodate = '';
		var slocFromdate = '';
		var slocTodate = '';
		$(document).ready(function(){
		$('#datatbl tbody tr').click(function(){
			$('table tbody tr').css("color","black");
			$(this).css("color","red");
			$('table tbody tr').removeClass("info");
			$(this).addClass("info");
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
			locbioid = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(23)").text();
			//locFromdate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(24)").text();
			//locTodate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(25)").text();

			so = usernum.toString();
			document.getElementById("hide").value = so;
			document.getElementById("hide2").value = locbioid.toString();

			/*var today = new Date();
			today.setDate(today.getDate() - 30);
			var dd = String(today.getDate()).padStart(2, '0');
			var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
			var yyyy = today.getFullYear();
			today = mm + '/' + dd + '/' + yyyy;*/

			//$('#add-schedfromdate').val(today.toString());
			//today.setDate(today.getDate() - 30);
			
			//slocFromdate = today.toString();
			//slocTodate = today.toString();
			//document.getElementById("add-schedfromdate").value = '';
			//document.getElementById("add-schedtodate").value =  '';
			
			/*slocFromdate=locFromdate;
			slocTodate=locTodate;*/
			slocFromdate = $('#add-schedfromdate').val();
			slocTodate = $('#add-schedtodate').val();
			
			//document.getElementById("add-schedtodate").value = today;
			RefreshSched();
			
			
				  
				});
			});

		//-----search-----//
		$( ".search" ).on( "keydown", function(event) {
		  if(event.which == 13){
			var search = document.getElementsByClassName('search');
			var sLocId;
			var slocName;
			var slocPosition;
			var sLocDepartment;
			var slocbranch;
			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 sLocId = data[0];
			 slocName = data[1];
			 slocPosition = data[2];
			 sLocDepartment = data[3];
			 slocbranch = data[4];
			

			
			

			
			 $.ajax({
						type: 'GET',
						url: 'dashboardsearch.php',
						data:{action:action, actmode:actionmode, sLocId:sLocId, slocName:slocName, slocPosition:slocPosition, sLocDepartment:sLocDepartment, slocbranch:slocbranch},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							$('#resulthead').html('<center><img src="img/loading.gif" width="300" height="300"></center>');
			
						},
						success: function(data){
							$('#resulthead').html(data);
							slocFromdate = $('#hide3').val();
							slocTodate = $('#hide4').val();
							so = $('#hide5').val();
							locbioid = $('#hide6').val();
							document.getElementById("hidesearch").value = "true";
							/*var pos = 1;
							    $("tr[tabindex="+pos+"]").focus();
							    $("tr[tabindex="+pos+"]").css("color","red");
							    $("tr[tabindex="+pos+"]").addClass("info");*/
							//alert(so);
							//alert(locbioid);
							RefreshSched();
							
				}
			}); 
			 
		  }
		});
		//-----end search-----//

		function RefreshSched()
		{
			
			var action = "refresh";
			var actionmode = "schedule";
			var search = document.getElementById("hidesearch").value;
			if(search == "false")
			{
				if(so != '')
				{
					
					if($('#add-schedfromdate').val() != '' && $('#add-schedtodate').val() != '')
					{
						slocFromdate = $('#add-schedfromdate').val();
						slocTodate = $('#add-schedtodate').val();
					}
					

					if(slocFromdate > slocTodate){
						alert("To Date Must be greater than From Date!");
					}
					else
					{
						$.ajax({
							type: 'GET',
							url: 'dashboardprocess.php',
							data:{action:action, actmode:actionmode, slocFromdate:slocFromdate, slocTodate:slocTodate, slocworker:so, slocbio:locbioid},

							beforeSend:function(){
								//alert(slocFromdate.toString());
								$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
				
							},
							success: function(data){
								$('#result').html(data);
								RefeshAtt();
								ResfreshLate();
								ResfreshAbsent();
								ResfreshOT();
								ResfreshLeave();
							}
						}); 
					}
				}
				else
				{
					alert("Please Select a Employee.");
				}
			}
			else
			{
				if($('#add-schedfromdate').val() != '' && $('#add-schedtodate').val() != '')
					{
						slocFromdate = $('#add-schedfromdate').val();
						slocTodate = $('#add-schedtodate').val();
					}
					

					if(slocFromdate > slocTodate){
						alert("To Date Must be greater than From Date!");
					}
					else
					{
						$.ajax({
							type: 'GET',
							url: 'dashboardprocess.php',
							data:{action:action, actmode:actionmode, slocFromdate:slocFromdate, slocTodate:slocTodate, slocworker:so, slocbio:locbioid},

							beforeSend:function(){
								//alert(slocFromdate.toString());
								$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
				
							},
							success: function(data){
								$('#result').html(data);
								RefeshAtt();
								ResfreshLate();
								ResfreshAbsent();
								ResfreshOT();
								ResfreshLeave();
							}
						}); 
					}
			}
			
							
		}

		function RefeshAtt()
		{
			
			var action = "refresh";
			var actionmode = "attendance";
			//var slocFromdate = $('#add-schedfromdate').val();
			//var slocTodate = $('#add-schedtodate').val();

			if(slocFromdate > slocTodate){
				alert("To Date Must be greater than From Date!");
			}
			else
			{
			
				$.ajax({
					type: 'GET',
					url: 'dashboardprocess.php',
					data:{action:action, actmode:actionmode, slocFromdate:slocFromdate, slocTodate:slocTodate, slocworker:so, slocbio:locbioid},

					beforeSend:function(){
					
						$("#result2").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
		
					},
					success: function(data){
						$('#result2').html(data);

					}
				}); 
			}			
		}

		function ResfreshLate()
		{
			
			var action = "refreshatt";
			var actionmode = "lateatt";
			//var slocFromdate = $('#add-schedfromdate').val();
			//var slocTodate = $('#add-schedtodate').val();

			if(slocFromdate > slocTodate){
				alert("To Date Must be greater than From Date!");
			}
			else
			{
			
				$.ajax({
					type: 'GET',
					url: 'dashboardprocess.php',
					data:{action:action, actmode:actionmode, slocFromdate:slocFromdate, slocTodate:slocTodate, slocworker:so, slocbio:locbioid},

					beforeSend:function(){
					
						$("#latecontent").html('<center><img src="img/loading.gif" width="50" height="25"></center>');
		
					},
					success: function(data){
						$('#latecontent').html(data);
					}
				}); 
			}			
		}
		

		function ResfreshAbsent()
		{
			
			var action = "refreshatt";
			var actionmode = "absentatt";
			//var slocFromdate = $('#add-schedfromdate').val();
			//var slocTodate = $('#add-schedtodate').val();

			if(slocFromdate > slocTodate){
				alert("To Date Must be greater than From Date!");
			}
			else
			{
			
				$.ajax({
					type: 'GET',
					url: 'dashboardprocess.php',
					data:{action:action, actmode:actionmode, slocFromdate:slocFromdate, slocTodate:slocTodate, slocworker:so, slocbio:locbioid},

					beforeSend:function(){
					
						$("#absentcontent").html('<center><img src="img/loading.gif" width="50" height="25"></center>');
		
					},
					success: function(data){
						$('#absentcontent').html(data);
					}
				}); 
			}			
		}
		function ResfreshOT()
		{
			
			var action = "refreshatt";
			var actionmode = "overtimeatt";
			//var slocFromdate = $('#add-schedfromdate').val();
			//var slocTodate = $('#add-schedtodate').val();

			if(slocFromdate > slocTodate){
				alert("To Date Must be greater than From Date!");
			}
			else
			{
			
				$.ajax({
					type: 'GET',
					url: 'dashboardprocess.php',
					data:{action:action, actmode:actionmode, slocFromdate:slocFromdate, slocTodate:slocTodate, slocworker:so, slocbio:locbioid},

					beforeSend:function(){
					
						$("#otcontent").html('<center><img src="img/loading.gif" width="50" height="25"></center>');
		
					},
					success: function(data){
						$('#otcontent').html(data);
					}
				}); 
			}			
		}

		function ResfreshLeave()
		{
			
			var action = "refreshatt";
			var actionmode = "leaveatt";
			//var slocFromdate = $('#add-schedfromdate').val();
			//var slocTodate = $('#add-schedtodate').val();

			if(slocFromdate > slocTodate){
				alert("To Date Must be greater than From Date!");
			}
			else
			{
			
				$.ajax({
					type: 'GET',
					url: 'dashboardprocess.php',
					data:{action:action, actmode:actionmode, slocFromdate:slocFromdate, slocTodate:slocTodate, slocworker:so, slocbio:locbioid},

					beforeSend:function(){
					
						$("#leavecontent").html('<center><img src="img/loading.gif" width="50" height="25"></center>');
		
					},
					success: function(data){
						$('#leavecontent').html(data);
					}
				}); 
			}			
		}
		

		function Cancel()
		{
			/**var uri = "my test.asp?name=ståle&car=saab";
			var enc = encodeURI(uri);
			var dec = decodeURI(enc);
			var res = "Encoded URI: " + enc + "<br>" + "Decoded URI: " + dec;*/

			/*var encrypted = CryptoJS.AES.encrypt("employee2.php", "Secret Passphrase");
			//U2FsdGVkX18ZUVvShFSES21qHsQEqZXMxQ9zgHy+bu0=

			var decrypted = CryptoJS.AES.decrypt(encrypted, "Secret Passphrase");
			//4d657373616765

			//alert(encrypted);

			//var uri = "employee2.php?name=ståle&car=saab";
  			//var res = encodeURI(encrypted);

  			alert(decrypted.toString(CryptoJS.enc.Utf8));

			window.location.href=decrypted.toString(CryptoJS.enc.Utf8);*/	
			window.location.href='employee.php';	
		}
		
	</script>
	<script type="text/javascript" src="js/custom.js"></script>
<!-- end [JAVASCRIPT] -->

</body>
</html>