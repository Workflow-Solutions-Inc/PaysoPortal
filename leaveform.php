<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
$user = $_SESSION["portaluser"];
$dataareaid = $_SESSION["portaldefaultdataareaid"];
$logbio = $_SESSION["portallogbio"];
$lognum = $_SESSION["portallognum"];
if(isset($_SESSION['portalWKNum']))
{
	$wkid = $_SESSION['portalWKNum'];
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
	<title>Leave</title>

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
					<li id="pla" onClick="reply_click(this.id)"><a href="leaveform.php?list=pla"><span class="fas fa-hourglass"></span>  Pending Leave Application</a></li>
					<li id="ala" onClick="reply_click(this.id)"><a href="approvedleaveform.php?list=ala"><span class="fas fa fa-check"></span>  Posted Leave Application</a></li>
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
							<span class="fa fa-archive"></span> Leave Details
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
									  

										<td><input list="SearchId" class="search">
										<?php
											$query = "SELECT distinct leaveid FROM portalleavefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status = 0";
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
											$query = "SELECT distinct name FROM portalleavefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status = 0";
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
											$query = "SELECT distinct leavedate FROM portalleavefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status = 0";
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
											$query = "SELECT distinct details FROM portalleavefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status = 0";
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
											$query = "SELECT distinct starttime FROM portalleavefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status = 0";
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
											$query = "SELECT distinct endtime FROM portalleavefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status = 0";
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
											$query = "SELECT distinct leavetype FROM portalleavefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status = 0";
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
											$query = "SELECT distinct daytype FROM portalleavefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status = 0";
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
											$query = "SELECT distinct status FROM portalleavefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status = 0";
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
											$query = "SELECT distinct date_format(createddatetime, '%Y-%m-%d') as datefiled FROM portalleavefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status = 0";
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

									FROM portalleavefile where dataareaid = '$dataareaid' and workerid = '$lognum'
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
									$query2 = "SELECT format(balance,2) balance FROM leavefile 
									where workerid = '$lognum' and dataareaid = '$dataareaid' and leavetype = 'VL'";
									$result2 = $conn->query($query2);
									while ($row2 = $result2->fetch_assoc())
									{ 
											

											$wkvl = $row2['balance'];
											

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
									<input type="hidden" id="hide">
									<input type="hidden" id="hideval" value="<?php echo $wkvl;?>">
									<input type="hidden" id="hide3" value="<?php echo $sample;?>">	
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
				<form name="myForm" accept-charset="utf-8" action="leaveformprocess.php" method="get">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Leave ID:</label>
							<div id="resultid">
								<input type="text" value="" placeholder="Leave" name ="OTId" id="add-otid" class="modal-textarea" required="required">
							</div>

							<label>Leave Type:</label>
							<select value="" value="" placeholder="Period" name ="OTleavetype" id="add-leavetype" class="modal-textarea" style="width:100%;height: 28px;"  required="required" onchange="filterleave()">
								<option value="" selected="selected"></option>
								<?php
									$query = "SELECT distinct leavetypeid,description FROM leavetype";
									$result = $conn->query($query);			
									  	
										while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["leavetypeid"];?>"><?php echo $row["description"];?></option>
									<?php } ?>
							</select>

							<label>Day Type:</label>
							<select value="" value="" placeholder="Period" name ="OTdaytype" id="add-daytype" class="modal-textarea" style="width:100%;height: 28px;"  required="required">
									<option value=""></option>
									<option value="0">Whole Day</option>
									<option value="1">Half Day</option>
							</select>

							<label>Details:</label>
							<textarea id="add-details" name="OTdetails" class="textarea1" required="required" placeholder="Leave Details"></textarea>
							

							
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Leave From Date:</label>
							<input type="date" value="" placeholder="" id="add-otfromdate" name="OTfromdate" class="modal-textarea" required="required" onchange="filterleave()">

							<div id='FWtodatediv'>
							<label>Leave To Date:</label>
							<input type="date" value="" placeholder="" id="add-ottodate" name="OTtodate" class="modal-textarea" required="required" onchange="filterleave()">
							</div>

							<label>Start Time:</label>
							<input type="time" value="" placeholder="" id="add-otstarttime" name="OTstart" class="modal-textarea" required="required">
						
							<label>End Time:</label>
							<input type="time" value="" placeholder="" id="add-otendtime" name="OTend" class="modal-textarea" required="required">

							
						</div>

						<div id="resultfilter">
								<input type="hidden" value="" name ="lcredit" id="add-lcredit" class="modal-textarea" >
								<input type="hidden" value="" name ="lpaid" id="add-lpaid" class="modal-textarea" >
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
			    document.getElementById("FWtodatediv").style.display = "none";
				document.getElementById("add-otid").value = so;
				document.getElementById("add-otfromdate").value = locLeavedate.toString();
				document.getElementById("add-ottodate").value = locLeavedate.toString();
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
		function filterleave()
		{
			//alert(document.getElementById("add-leavetype").value);
			var action = "filterleave";
			var lfilter = document.getElementById("add-leavetype").value;
			var ldate = document.getElementById("add-otfromdate").value;
			var ltodate = document.getElementById("add-ottodate").value;
			//var OTstart = document.getElementById("add-otstarttime").value;
			//var OTend = document.getElementById("add-otendtime").value;
		    $.ajax({
						type: 'GET',
						url: 'leaveformprocess.php',
						data:{action:action , lfilter:lfilter, ldate:ldate, ltodate:ltodate},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							//$("#resultfilter").html('<img src="img/loading.gif" width="300" height="300">');
			
						},
						success: function(data){
							$('#resultfilter').html(data);
							//$("#add-otid").prop('readonly', true); 
				}
			});
		}

		var myId = [];
		function checkExistForm()
		{
			
			//window.location.href='employee2.php';
			var ldt = document.getElementById("t3").value;
			myId = ldt.toLowerCase().split(",");
			var n = myId.includes(document.getElementById("add-otfromdate").value.toLowerCase());

			var vleavetype = document.getElementById("add-leavetype").value;
			var vDaytype = 	document.getElementById("add-daytype").value;

			var cont = document.getElementById("add-lcredit").value;
			var lday = document.getElementById("add-ldays").value;
			//var lded = document.getElementById("add-lded").value;
			var ispaid = document.getElementById("add-lpaid").value;
			//alert(lday);
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
			/*alert(lday);
			if(lday > 1)
			{
				cont = Math.trunc( cont );
			}
			alert(cont);*/

			var d = new Date();
			var d2 = new Date(document.getElementById("add-otfromdate").value.toLowerCase());
			d.setDate(d.getDate() - 7);
			//alert(x);
			if(ispaid == "false")
			{
				if(n == true){
					alert("The date selected has a leave file!");
					return false;
				}
				else
				{

					/*if(d > d2)
		 			{
		 				alert("Invalid! Leave filing exceeded 7 days!!!");
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
				//alert(x);
				if(cont > 0){
					//alert("Continue Saving...");
					if(n == true){
						alert("The date selected has a leave file!");
						return false;
					}
					else
					{

			 			if(lday > cont)
			 			{
			 				if(confirm("Only "+cont+" remaining leave can filled as "+vleavetype+". Do you want to continue?")) {
						    	//alert("saved");
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
					//return true;
				}
				else
				{
					
					alert("Insufficient Leave Credit");
					return false;
				}
				//return false;	
			}
			
			
			
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
				document.getElementById("add-otfromdate").value = "";
				document.getElementById("add-ottodate").value = "";
				document.getElementById("add-details").value =  "";
				document.getElementById("add-otstarttime").value =  "";
				document.getElementById("add-otendtime").value =  "";
				document.getElementById("add-othours").value =  "";
				document.getElementById("add-otminutes").value =  "";
			}
			else
			{
				document.getElementById("add-otfromdate").value = "";
				document.getElementById("add-ottodate").value = "";
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
							url: 'leaveformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, NumId:so},
							beforeSend:function(){
									
							$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							//$('#datatbl').html(data);
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