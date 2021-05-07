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
					<li id="po" onClick="reply_click(this.id)"><a href="overtimeform.php?list=po"><span class="fas fa-hourglass"></span>  Pending Overtime Application</a></li>
					<li id="ao" onClick="reply_click(this.id)"><a href="approvedovertimeform.php?list=ao"><span class="fas fa fa-check"></span>  Posted Overtime Application</a></li>
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

	    
	    	if($_GET['list'] == "po")
	    	{
	    		$sample = "po";
	 		}
	 		if($_GET['list'] == "ao")
	    	{
	    		$sample = "ao";
	 		}
	}
	else
	{
		$sample = "po";
	}
	?>
	<!-- end HEADER -->



	<!-- begin LEFT PANEL -->
	<div id="leftpanel" class="leftpanel">

		<?php require("inc/leftpanel.php"); ?>

		<!-- sub buttons -->
		<ul class="subbuttons">
			<div class="leftpanel-title"><b>COMMANDS</b></div>
			<li><button id="myAddBtn"><span class="fa fa-plus"></span> Create Record</button></li>
			<li><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Record</button></li>
			<li><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li>
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
							<span class="fa fa-archive"></span> Overtime Details
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
										<td style="width:10%;">Overtime ID</td>
										<td style="width:14%;">Name</td>
										<td style="width:10%;">Overtime Date</td>
										<td style="width:50%;">Details</td>
										<td style="width:9%;">Overtime Type</td>
	
										<td style="width:5%;">Hrs</td>
										<td style="width:5%;">Mins</td>
										<td style="width:5%;">Status</td>
										<td style="width:7%;">Date Filed</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
									  

										<td><input list="SearchId" class="search">
										<?php
											$query = "SELECT distinct overtimeid FROM overtimefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status = 0";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchId">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["overtimeid"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchName" class="search" >
										<?php
											$query = "SELECT distinct name FROM overtimefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status = 0";
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
											$query = "SELECT distinct overtimedate FROM overtimefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status = 0";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchOvertimeDate">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["overtimedate"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchDetails" class="search" disabled>
										<?php
											$query = "SELECT distinct details FROM overtimefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status = 0";
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
									  <td><input list="SearchOvertimeType" class="search" disabled>
										<?php
											$query = "SELECT distinct overtimetype FROM overtimefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status = 0";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchOvertimeType">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["overtimetype"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									 
									  <td><input list="SearchHours" class="search" disabled>
										<?php
											$query = "SELECT distinct hours FROM overtimefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status = 0";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchHours">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["hours"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchMinutes" class="search" disabled>
										<?php
											$query = "SELECT distinct minutes FROM overtimefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status = 0";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchMinutes">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["minutes"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchStatus" class="search" disabled>
										<?php
											$query = "SELECT distinct status FROM overtimefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status = 0";
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
											$query = "SELECT distinct date_format(createddatetime, '%Y-%m-%d') as datefiled FROM overtimefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status = 0";
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
										date_format(createddatetime, '%Y-%m-%d') as datefiled,
                                        case when overtimetype = 0 then 'Regular Overtime'
                                        when overtimetype = 1 then 'Special Holiday Overtime'
                                        when overtimetype = 2 then 'Regular Holiday Overtime'
                                        when overtimetype = 3 then 'Sunday Overtime'
                                        when overtimetype = 5 then 'Early Overtime'
                                        end as overtimetypes

									FROM overtimefile where dataareaid = '$dataareaid' and workerid = '$lognum'
										and status = 0
									order by overtimeid";
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
											<td style="width:10%;"><?php echo $row['overtimeid'];?></td>
											<td style="width:14%;"><?php echo $row['name'];?></td>
											<td style="width:10%;"><?php echo $row['overtimedate'];?></td>
											<td style="width:50%;"><?php echo $row['details'];?></td>
											<td style="width:9%;"><?php echo $row['overtimetypes'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['timein'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['timeout'];?></td>
											<td style="width:5%;"><?php echo $row['hours'];?></td>
											<td style="width:5%;"><?php echo $row['minutes'];?></td>
											<td style="width:5%;"><?php echo $row['otstatus'];?></td>
											<td style="width:7%;"><?php echo $row['datefiled'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['starttime'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['endtime'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['overtimetype'];?></td>
											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
											
										</tr>
									<?php }?>

									<?php					
									$query2 = "SELECT consol.date,TIME_FORMAT(intbl.timein,'%h:%i %p') as timein,TIME_FORMAT(outtbl.timeout,'%h:%i %p') as timeout,consol.bioid,
												hour(subtime(TIME_FORMAT(outtbl.timeout,'%h:%i %p'),TIME_FORMAT(ss.endtime,'%h:%i %p'))) as 'endtimehour',
												minute(subtime(TIME_FORMAT(outtbl.timeout,'%h:%i %p'),TIME_FORMAT(ss.endtime,'%h:%i %p'))) as 'endtimemins'

												FROM 
													consolidationtable consol
													left join (select date,MAX(time) as timeout,bioid,type from consolidationtable where type = 1
													group by date,bioid,type) outtbl on consol.BioId = outtbl.bioid and consol.Date = outtbl.date

													left join (select date,MIN(time) as timein,bioid,type from consolidationtable where type = 0
													group by date,bioid,type) intbl on consol.BioId = intbl.bioid and consol.Date = intbl.date

													left join worker wk on
                                                    consol.BioId = wk.BioId
                                                    
                                                    
                                                    left join shiftschedule ss on
                                                    wk.workerid = ss.workerid and
                                                    consol.Date = consol.Date and
                                                    wk.dataareaid = ss.dataareaid

													where consol.bioid = '$logbio' #and consol.date = '2020-01-15'

													 group by  consol.date,TIME_FORMAT(intbl.timein,'%h:%i %p'),TIME_FORMAT(outtbl.timeout,'%h:%i %p'),consol.bioid,
													subtime(TIME_FORMAT(outtbl.timeout,'%h:%i %p'),TIME_FORMAT(ss.endtime,'%h:%i %p'))";
									$result2 = $conn->query($query2);
									$collection = '';
									$endTimeHour = '';
									$endTimeMins = '';
									while ($row2 = $result2->fetch_assoc())
									{ 
										$collection = $collection.','.$row2['date'];
										$endTimeHour = $endTimeHour.','.$row2['endtimehour'];
										$endTimeMins = $endTimeMins.','.$row2['endtimemins'];
										
									}

									$query3 = "SELECT *,TIME_FORMAT(starttime,'%h:%i %p') as timein,TIME_FORMAT(endtime,'%h:%i %p') as timeout,
												case when status = 0 then 'Created'
													when status = 1 then 'Approved' 
													when status = 2 then 'Disapproved' 
													when status = 3 then 'Posted' end as otstatus 

												FROM overtimefile where dataareaid = '$dataareaid' and workerid = '$lognum'
													
												order by overtimeid";
									$result3 = $conn->query($query3);
									$collection2 = '';
									while ($row3 = $result3->fetch_assoc())
									{ 
										$collection2 = $collection2.','.$row3['overtimedate'];
										
									}
									?>


								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide">
									<input type="hidden" id="hide3" value="<?php echo $sample;?>">
									<div style="display:none;width:1%;"><textarea id="t2" value = "<?php echo substr($collection,1);?>"><?php echo substr($collection,1);?></textarea></div>

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
				<div class="col-lg-6">Overtime Details</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm" accept-charset="utf-8" action="overtimeformprocess.php" method="get">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Overtime ID:</label>
							<div id="resultid">
								<input type="text" value="" placeholder="Overtime" name ="OTId" id="add-otid" class="modal-textarea" required="required">
							</div>
							

							<label>Overtime Date:</label>
							<input type="date" value="" placeholder="" id="add-otdate" name="OTdate" class="modal-textarea" onchange="getOT()" required="required">

							<label>Details:</label>
							<textarea id="add-details" name="OTdetails" class="textarea1" required="required" placeholder="Over Time Details"></textarea>
						</div>

						

						<!-- <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">-->
							<!--	<label>Start Time:</label>-->
							<input type="hidden" value="12:00 AM" placeholder="" id="add-otstarttime" name="OTstart" class="modal-textarea">


							<!-- <label>End Time:</label>-->
							<input type="hidden" value="12:00 AM" placeholder="" id="add-otendtime" name="OTend" class="modal-textarea">							
						<!-- </div>-->

						

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							

							<label>Overtime Type:</label>
							<select value="" value="" placeholder="Period" name ="OTtype" id="add-type" class="modal-textarea" style="width:100%;height: 28px;" onchange="getOT()"  required="required">
									<option value=""></option>
									<option value="5">Early Overtime</option>
									<option value="0">Regular Overtime</option>
									<option value="1">Special Holiday Overtime</option>
									<option value="2">Regular Holiday Overtime</option>
									<option value="3">Rest Day Overtime</option>
							</select>
							
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Hours:</label>
							<input type="number" step="1" min="0" value="0" placeholder="" id="add-othours" name="OThours" class="modal-textarea" required="required" onkeypress="return !(event.charCode == 46)">

							<label>Minutes:</label>
							<select value="" value="" placeholder="" name="OTminutes"  id="add-otminutes" class="modal-textarea" style="width:100%;height: 28px;"  required="required">
									
									<option value="0" selected>0</option>
									<option value="15">15</option>
									<option value="30">30</option>
									<option value="45">45</option>
							</select>
						</div>
						<div id="resultfilter">
								<input type="input" value="" name ="myHrs" id="otHRS" class="modal-textarea" >
								<input type="hidden" value="" name ="myMins" id="otMINS" class="modal-textarea" >
								
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
		    if(clicked_id == 'po')
		    {
		  		$('#ao').removeClass("active");
				$('#po').addClass("active");
			}
			else
		    {
		  		$('#po').removeClass("active");
				$('#ao').addClass("active");
			}
			

		    //  alert(clicked_id);
		}

	  	var so='';
	  	//var locWorkerId = "";
		var locName = "";
		var locOvertimedate = "";
		var locDetails = "";
		var locOvertimetype = "";
		var locStartTime = "";
		var locEndTime = "";
		var locHours = "";
		var locMinutes = "";
		var locStatus= "";
		var locDateFile = "";
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locName = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locOvertimedate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locDetails = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locStartTime = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(12)").text();
				locEndTime = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(13)").text();
				locOvertimetype = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(14)").text();
				locHours = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
				locMinutes = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
				locStatus = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
				locDateFile = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(11)").text();

				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(locHours);	
					  
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
						url: 'overtimeformprocess.php',
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
				document.getElementById("add-otdate").value = locOvertimedate.toString();
				document.getElementById("add-details").value = locDetails.toString();
				document.getElementById("add-type").value = locOvertimetype;
				document.getElementById("add-otstarttime").value = locStartTime;
				document.getElementById("add-otendtime").value = locEndTime;
				document.getElementById("add-othours").value = locHours.toString();
				document.getElementById("add-otminutes").value = locMinutes.toString();
				
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
		var myEndTimeHour_ = [];
		var myEndTimeMin_ = [];
		var myFilled = [];

		function getOT()
		{
			//alert(document.getElementById("add-leavetype").value);

			var action = "getOT";
			var lfilter = document.getElementById("add-otdate").value;
			var Typefilter = document.getElementById("add-type").value;

			if(Typefilter == '')
			{
				Typefilter = 0;

			}
			else if (Typefilter == 5)
			{
				Typefilter == 5;
			}
			else
			{
				Typefilter = 0;
			}
			
			if(lfilter == '')
			{
				lfilter = '1900-01-01'
			}
			//alert(Typefilter);
			//alert(lfilter);

		    $.ajax({
						type: 'GET',
						url: 'overtimeformprocess.php',
						data:{action:action, lfilter:lfilter, Typefilter:Typefilter},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							//$("#resultfilter").html('<img src="img/loading.gif" width="300" height="300">');
			
						},
						success: function(data){
							$('#resultfilter').html(data);
							//alert(data);
							//$("#add-otid").prop('readonly', true); 
				}
			});
		}






		function checkExistForm()
		{
			var cont = document.getElementById("t2").value;
			myId = cont.toLowerCase().split(",");

			getOT();

			var otdt = document.getElementById("t3").value;
			myFilled = otdt.toLowerCase().split(",");
			//myId.push("Kiwi","Lemon","Pineapple",'asd');
			/*$.each(myId, function(i, el2){
		    	alert(el2);
			});*/
			//alert(myId.length);
			var d = new Date();
			var x = new Date(document.getElementById("add-otdate").value.toLowerCase());
			d.setDate(d.getDate() - 7);
 			//alert(d.toLocaleDateString());
 			//alert(x.toLocaleDateString());

			
	
			var n = myId.includes(document.getElementById("add-otdate").value.toLowerCase());
			var m = myFilled.includes(document.getElementById("add-otdate").value.toLowerCase());

			$myOtMins = document.getElementById("otMINS").value.toString();
			$myOtHrs = document.getElementById("otHRS").value.toString();

			//alert(document.getElementById("add-otdate").value.toString());
			//	alert($myOtHrs + ":" + $myOtHrs);
			if(n == true){
				//alert("Position ID already Exist!");

				/*if(m == true){
					alert("The date selected has an overtime file!");
					return false;
				}
				else
				{*/

				//return false;
					//return false;
					$myFiledOtHours = document.getElementById("add-othours").value.toString();
					$myFiledOtMins = document.getElementById("add-otminutes").value.toString();

			
					if ($myFiledOtHours == 0 &&  $myFiledOtMins == 0)
					{	
						alert("Hours and Minutes Fields cannot be equal to zero.");
						return false;
					}

					else
					{
						if ($myFiledOtHours > $myOtHrs)
						{
							alert($myOtHrs);
							alert("Excess of hours in OT.");
							return false;
						}
						else
						{
							if($myFiledOtMins > $myOtMins)
							{
								alert("Excess of minutes in OT.");
								return false;
							}
							else
							{
								//return true;
								if(d > x)
					 			{
					 				//alert("Invalid! Overtime filing exceeded 7 days!!!");
					 				return true;
					 			}
					 			else
					 			{
					 				return true;
					 			}
							}
						}
						//return true;
					//}
				   
					/*if(d > x)
		 			{
		 				alert("Invalid! Overtime filing exceeded 7 days!!!");
		 				return false;
		 			}
		 			else
		 			{
		 				return true;
		 			}*/
				}
				
			}
			else
			{
				alert("No Valid Attendance on Date Selected");
				return false;
			}
			
		}

		function validateForm() {
				getOT();
		  var x = document.forms["myForm"]["update"].value;
		  if (x == "update") {
		  	
		  	var myOtMins = document.getElementById("otMINS").value.toString();
			var myOtHrs = document.getElementById("otHRS").value.toString();
			$myFiledOtHours = document.getElementById("add-othours").value.toString();
			$myFiledOtMins = document.getElementById("add-otminutes").value.toString();

				if (myOtHrs == "" && myOtMins == "")
				{
					getOT();
					return false;
				}
				else
				{
					//alert(myOtHrs + ":" + $myFiledOtHours);
					if ($myFiledOtHours > myOtHrs)
						{
							alert("Excess of hours in OT.");
							return false;
						}
						else
						{
							if($myFiledOtMins > myOtMins)
							{
								alert("Excess of minutes in OT.");
								return false;
							}
							else
							{
							//	return false;
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
				}

			//alert(myOtHrs);

		  /* */
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
						url: 'overtimeformprocess.php',
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
			//alert(so);
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
							//alert(data);
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