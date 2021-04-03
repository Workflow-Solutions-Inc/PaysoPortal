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
	<title>Overtime</title>

	<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<script src="js/jquery.min.js"></script>

</head>
<body>-->



	<!-- begin HEADER -->
	<?php require("inc/header.php"); ?>

	<div class="header">
		<div class="header-content">

		<div class="header-nav">
				<ul>
					<li id="pla" onClick="reply_click(this.id)"><a href="approverleaveform.php?list=pla"><span class="fas fa-hourglass"></span>  Pending Leave Application</a></li>
					<li id="ala" onClick="reply_click(this.id)"><a href="approverviewleaveform.php?list=ala"><span class="fas fa fa-check"></span>  Posted Leave Application</a></li>
				</ul>
		</div>

		</div>
	</div>

	<div class="spacer">&nbsp;</div>

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
			<!--<li><button id="myAddBtn"><span class="fa fa-plus"></span> Create Record</button></li>-->
			<!--<li><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li>-->
			<!--<li><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Record</button></li>-->
			<li><button onClick="ApproveLeave();"><span class="fa fa-thumbs-up"></span> Approve</button></li>
			<li><button onClick="DisapproveLeave();"><span class="fa fa-thumbs-down"></span> Disapprove</button></li>
			<!--<li><button><span class="fa fa-history"></span> Revert</button></li>-->
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
							<span class="fa fa-archive"></span> Leave Application
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
						<div id="container1" class="full">
							<table width="100%" border="0" id="datatbl" class="table table-striped mainpanel-table">
								<thead>	
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:5%;">Include</td>
										<td style="width:10%;">Leave ID</td>
										<td style="width:14%;">Name</td>
										<td style="width:10%;">Leave Date</td>
										<td style="width:25%;">Details</td>
										<td style="width:7%;">Start Time</td>
										<td style="width:7%;">End Time</td>
										<td style="width:5%;">Leave Type</td>
										<td style="width:5%;">Day Type</td>
										<td style="width:7%;">Status</td>
										<td style="width:10%;">Date Filed</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
									  <td><center><input id="selectAll" type="checkbox"></span></center></td>

										<td><input list="SearchId" class="search">
										<?php
											$query = "SELECT distinct leaveid FROM portalleavefile where dataareaid = '$dataareaid' and status = 0";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchId">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["leaveid"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchName" class="search" >
										<?php
											$query = "SELECT distinct name FROM portalleavefile where dataareaid = '$dataareaid' and status = 0";
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
									  <td><input list="SearchOvertimeDate" class="search">
										<?php
											$query = "SELECT distinct leavedate FROM portalleavefile where dataareaid = '$dataareaid' and status = 0";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchOvertimeDate">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["leavedate"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchDetails" class="search" disabled>
										<?php
											$query = "SELECT distinct details FROM portalleavefile where dataareaid = '$dataareaid' and status = 0";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchDetails">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["details"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchStarttime" class="search" disabled>
										<?php
											$query = "SELECT distinct starttime FROM portalleavefile where dataareaid = '$dataareaid' and status = 0";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchStarttime">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["starttime"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchEndtime" class="search" disabled>
										<?php
											$query = "SELECT distinct endtime FROM portalleavefile where dataareaid = '$dataareaid' and status = 0";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchEndtime">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["endtime"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchHours" class="search" disabled>
										<?php
											$query = "SELECT distinct leavetype FROM portalleavefile where dataareaid = '$dataareaid' and status = 0";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchHours">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["leavetype"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchMinutes" class="search" disabled>
										<?php
											$query = "SELECT distinct daytype FROM portalleavefile where dataareaid = '$dataareaid' and status = 0";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchMinutes">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["daytype"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchStatus" class="search" disabled>
										<?php
											$query = "SELECT distinct status FROM portalleavefile where dataareaid = '$dataareaid' and status = 0";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchStatus">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["status"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchDateFiled" class="search" disabled>
										<?php
											$query = "SELECT distinct date_format(createddatetime, '%Y-%m-%d') as datefiled FROM portalleavefile where dataareaid = '$dataareaid' and status = 0";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchDateFiled">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["datefiled"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><span></span></td>
									</tr>
								</thead>
								<tbody id="result">
									<?php					
									$query = "SELECT *,TIME_FORMAT(starttime,'%h:%i %p') as timein,TIME_FORMAT(endtime,'%h:%i %p') as timeout,
									case when status = 0 then 'Created'
										when status = 1 then 'Approved' 
										when status = 2 then 'Disapproved' 
										when status = 3 then 'Posted' end as otstatus,
									case when daytype = 0 then 'Whole Day'
										when daytype = 1 then 'Half Day' end as daytypes,
										date_format(createddatetime, '%Y-%m-%d') as datefiled

									FROM portalleavefile where dataareaid = '$dataareaid'
										and status = 0
									order by leaveid";
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
											<td style="width:5%;"><input type='checkbox' id="chkbox" name="chkbox" class="checkbox" 
												value="<?php echo $row['leaveid'];?>"></td>
											<td style="width:10%;"><?php echo $row['leaveid'];?></td>
											<td style="width:14%;"><?php echo $row['name'];?></td>
											<td style="width:10%;"><?php echo $row['leavedate'];?></td>
											<td style="width:25%;"><?php echo $row['details'];?></td>
											<td style="width:7%;"><?php echo $row['timein'];?></td>
											<td style="width:7%;"><?php echo $row['timeout'];?></td>
											<td style="width:5%;"><?php echo $row['leavetype'];?></td>
											<td style="width:5%;"><?php echo $row['daytypes'];?></td>
											<td style="width:7%;"><?php echo $row['otstatus'];?></td>
											<td style="width:10%;"><?php echo $row['datefiled'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['starttime'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['endtime'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['daytype'];?></td>
											
											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
											
										</tr>
									<?php }?>

									<?php 
									$query2 = "SELECT wk.workerid,wk.name,pos.name as 'position',
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
									$result2 = $conn->query($query2);
									while ($row2 = $result2->fetch_assoc())
									{ 
											

											$wkvl = $row2['serviceincentiveleave'];
											$wksl = $row2['birthdayleave'];

									}?>

									<?php 
									$query3 = "SELECT case when daytype = 1 then count(leaveid) / 2
												else count(leaveid) end as leavecount FROM portalleavefile where status in (0,1) 
													and leavetype = 'VL' and dataareaid = 'DEF' and workerid = '$lognum' group by daytype";

									$result3 = $conn->query($query3);
									$usedleave = 0;
									while ($row3 = $result3->fetch_assoc())
									{ 
											$usedleave = $usedleave + $row3['leavecount'];
											

									}
									$query4 = "SELECT *,TIME_FORMAT(starttime,'%h:%i %p') as timein,TIME_FORMAT(endtime,'%h:%i %p') as timeout,
									case when status = 0 then 'Created'
										when status = 1 then 'Approved' 
										when status = 2 then 'Disapproved' 
										when status = 3 then 'Posted' end as otstatus,
									case when daytype = 0 then 'Whole Day'
										when daytype = 1 then 'Half Day' end as daytypes

									FROM portalleavefile where dataareaid = '$dataareaid' and workerid = '$lognum'
										and status = 0
									order by leaveid";
									$result4 = $conn->query($query4);
									$collection2 = '';
									while ($row4 = $result4->fetch_assoc())
									{ 
										$collection2 = $collection2.','.$row4['leavedate'];
										
									}
									?>
								</tbody>
								<span class="temporary-container-input">
									<input type="input" id="hide">
									<input type="input" id="hideval" value="<?php echo $wkvl - $usedleave;?>">
									<input type="hidden" id="hide3" value="<?php echo $sample;?>">	
									<input type="input" id="inchide">
									<input type="input" id="inchide2">
									<div style="display:none;width:1%;"><textarea id="t3" value = "<?php echo substr($collection2,1);?>"><?php echo substr($collection2,1);?></textarea></div>	
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
				<form name="myForm" accept-charset="utf-8" action="approverleaveformprocess.php" method="get">
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
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locName = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locLeavedate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locDetails = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				locStartTime = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(12)").text();
				locEndTime = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(13)").text();
				locLeavetype = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
				locDaytype = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
				locStatus = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
				locDateFile = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(11)").text();
				locDaytypenum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(14)").text();

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
		/*
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
		window.onclick = function(event) {
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
			var ldt = document.getElementById("t3").value;
			myId = ldt.toLowerCase().split(",");
			var n = myId.includes(document.getElementById("add-otdate").value.toLowerCase());

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

			
			//alert(x);
			if(x >= 0){
				//alert("Continue Saving...");
				if(n == true){
					alert("The date selected has a leave file!");
					return false;
				}
				else
				{
					return true;
				}
				//return true;
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
						url: 'approverleaveformprocess.php',
						data:{action:action, actmode:actionmode, slocOvertimeId:slocOvertimeId, slocName:slocName, slocOvertimedate:slocOvertimedate},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
			
						},
						success: function(data){
							$('#result').html(data);
							CheckedVal();
				}
			}); 
			 
		  }
		});
		//-----end search-----//

		var allVals = [];
		var uniqueNames = [];
		var remVals = [];
		var remValsEx = [];
		$('[name=chkbox]').change(function(){
		    if($(this).attr('checked'))
		    {
	      		//document.getElementById("inchide").value = $(this).val();
	      		Add();
		    }
		    else
		    {
					         
		         //document.getElementById("inchide").value=$(this).val();
		         remVals.push("'"+$(this).val()+"'");
		         $('#inchide2').val(remVals);

		         $.each(remVals, function(i, el2){

		    		removeA(allVals, el2);
		    		removeA(uniqueNames, el2);
			    	//$("input[value="+el+"]").prop("checked", true);
			    	//alert(el);
				});
		        Add();

		    }
		 });

		$("#selectAll").change(function(){  //"select all" change 
   			 

   			 if(false == $(this).prop("checked")){ //if this item is unchecked
			        $('[name=chkbox]').prop('checked', false); //change "select all" checked status to false
			         allVals = [];
					 uniqueNames = [];
					 remVals = [];
					 remValsEx = [];
			        document.getElementById('inchide').value = '';
			        document.getElementById('inchide2').value = '';
			        //alert('sample');

			    }
			    else
			    {
			    	$(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
			    	Add();
			    }

			});

		function removeA(arr) 
		{
		    var what, a = arguments, L = a.length, ax;
		    while (L > 1 && arr.length) {
		        what = a[--L];
		        while ((ax= arr.indexOf(what)) !== -1) {
		            arr.splice(ax, 1);
		        }
		    }
		    return arr;
		}
		
		function Add() 
		{  

			
			$('#inchide').val('');
			 $('[name=chkbox]:checked').each(function() {
			   allVals.push("'"+$(this).val()+"'");
			 });

			  //remove existing rec start-----------------------
			 $('[name=chkbox]:disabled').each(function() {
			   
			   remValsEx.push("'"+$(this).val()+"'");
		         //$('#inchide2').val(remValsEx);

		         $.each(remValsEx, function(i, el2){
		         		
		    		removeA(allVals, el2);
		    		removeA(uniqueNames, el2);
			    	//"'"+"PCC"+"'"
				});
			   
			 });
			 //remove existing rec end-------------------------

			 
				$.each(allVals, function(i, el){
				    if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
				});
			
			 $('#inchide').val(uniqueNames);

		} 
		function CheckedVal()
		{ 
			$.each(uniqueNames, function(i, el){
				    $("input[value="+el+"]").prop("checked", true);
				    //alert(el);
				});
		}

		function ApproveLeave()
		{

			var SelectedVal = $('#inchide').val();
			var action = "approve";
			var actionmode = "userform";
			//alert(document.getElementById("add-include").value);
			$.ajax({	
					type: 'GET',
					url: 'approverleaveformprocess.php',
					//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
					data:{action:action, SelectedVal:SelectedVal},
					beforeSend:function(){
							
					$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
						
					},
					success: function(data){
					//window.location.href='approverovertimeform.php';	
					//$('#datatbl').html(data);
					location.reload();					
					}
			});
							
		}

		function DisapproveLeave()
		{

			var SelectedVal = $('#inchide').val();
			var action = "disapprove";
			var actionmode = "userform";
			//alert(document.getElementById("add-include").value);
			$.ajax({	
					type: 'GET',
					url: 'approverleaveformprocess.php',
					//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
					data:{action:action, SelectedVal:SelectedVal},
					beforeSend:function(){
							
					$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
						
					},
					success: function(data){
					//window.location.href='approverovertimeform.php';	
					//$('#datatbl').html(data);
					location.reload();					
					}
			});
							
		}

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

			window.location.href='employee2.php';	
			/*var vleavetype = document.getElementById("add-leavetype").value;
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

			

			if(x > 0){
				alert("Continue Saving...");
				return false;
			}
			else
			{
				
				alert("Insufficient Leave Credit");
				return false;
			}
			return false;	*/   
		}


	</script>
<script type="text/javascript" src="js/custom.js"></script>
<!-- end [JAVASCRIPT] -->

</body>
</html>