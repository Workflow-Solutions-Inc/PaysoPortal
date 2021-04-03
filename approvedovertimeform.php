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
		$sample = "ao";
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
										<td style="width:25%;">Details</td>
										<td style="width:12%;">Overtime Type</td>
										
										<td style="width:5%;">Hours</td>
										<td style="width:5%;">Minutes</td>
										<td style="width:5%;">Status</td>
										<td style="width:7%;">Approval Date</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
									  

										<td><input list="SearchId" class="search">
										<?php
											$query = "SELECT distinct overtimeid FROM overtimefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status != 0";
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
											$query = "SELECT distinct name FROM overtimefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status != 0";
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
											$query = "SELECT distinct overtimedate FROM overtimefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status != 0";
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
											$query = "SELECT distinct details FROM overtimefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status != 0";
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
											$query = "SELECT distinct overtimetype FROM overtimefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status != 0";
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
											$query = "SELECT distinct hours FROM overtimefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status != 0";
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
											$query = "SELECT distinct minutes FROM overtimefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status != 0";
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
											$query = "SELECT distinct status FROM overtimefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status != 0";
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
											$query = "SELECT distinct date_format(approvaldatetime, '%Y-%m-%d') as datefiled FROM overtimefile where dataareaid = '$dataareaid' and workerid = '$lognum' and status != 0";
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
										date_format(approvaldatetime, '%Y-%m-%d') as datefiled,
                                        case when overtimetype = 0 then 'Regular Overtime'
                                        when overtimetype = 1 then 'Special Holiday Overtime'
                                        when overtimetype = 2 then 'Regular Holiday Overtime'
                                        when overtimetype = 3 then 'Sunday Overtime'
                                        end as overtimetypes 

									FROM overtimefile where dataareaid = '$dataareaid' and workerid = '$lognum'
										and status != 0
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
											<td style="width:25%;"><?php echo $row['details'];?></td>
											<td style="width:12%;"><?php echo $row['overtimetypes'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['timein'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['timeout'];?></td>
											<td style="width:5%;"><?php echo $row['hours'];?></td>
											<td style="width:5%;"><?php echo $row['minutes'];?></td>
											<td style="width:5%;"><?php echo $row['otstatus'];?></td>
											<td style="width:7%;"><?php echo $row['datefiled'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['starttime'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['endtime'];?></td>
											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
											
										</tr>
									<?php }?>
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide">
									<input type="hidden" id="hide3" value="<?php echo $sample;?>">	
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
				<div class="col-lg-6">add info</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm" accept-charset="utf-8" action="approvedovertimeformprocess.php" method="get">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Overtime ID:</label>
							<div id="resultid">
								<input type="text" value="" placeholder="Overtime" name ="OTId" id="add-otid" class="modal-textarea" required="required">
							</div>
							

							<label>Overtime Date:</label>
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

							<label>Hours:</label>
							<input type="number" step="1" min="0" value="0" placeholder="" id="add-othours" name="OThours" class="modal-textarea" required="required" onkeypress="return !(event.charCode == 46)">
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Minutes:</label>
							<input type="number" step="1" min="0" value="0" placeholder="" id="add-otminutes" name="OTminutes" class="modal-textarea" required="required" onkeypress="return !(event.charCode == 46)">

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

		

	  	var so='';
	  	//var locWorkerId = "";
		var locName = "";
		var locOvertimedate = "";
		var locDetails = "";
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
				locStartTime = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(11)").text();
				locEndTime = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(12)").text();
				locHours = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(7)").text();
				locMinutes = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
				locStatus = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
				locDateFile = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();

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
		/*var modal = document.getElementById('myModal');
		// Get the button that opens the modal
		var CreateBtn = document.getElementById("myAddBtn");
		var UpdateBtn = document.getElementById("myUpdateBtn");
		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("modal-close")[0];
		// When the user clicks the button, open the modal 
		CreateBtn.onclick = function() {
			$("#myModal").stop().fadeTo(500,1);
		    document.getElementById("upbt").style.visibility = "hidden";
		    document.getElementById("addbt").style.visibility = "visible";
		    var action = "add";
		    $.ajax({
						type: 'GET',
						url: 'overtimeformprocess.php',
						data:{action:action},
						beforeSend:function(){
			
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
			//var cont = document.getElementById("t2").value;
			//myId = cont.toLowerCase().split(",");
			//myId.push("Kiwi","Lemon","Pineapple",'asd');
			/*$.each(myId, function(i, el2){
		    	alert(el2);
			});*/
			//alert(myId.length);
			//var n = myId.includes(document.getElementById("add-dataareaid").value.toLowerCase());
			//alert(n);
			/*vlocStartTime = document.getElementById("add-otstarttime").value;
			vlocEndTime = document.getElementById("add-otendtime").value;

			if(vlocStartTime > vlocEndTime){
				alert("End Time Must be greater then Start Time!");
				return false;
			}
			else
			{
				alert("Continue Saving...");
				return false;
			}*/

			/*if(n == true){
				alert("Company already Exist!");
				return false;
			}
			else
			{
				alert("Continue Saving...");
				return false;
			}*/
			
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
						url: 'approvedovertimeformprocess.php',
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
				document.getElementById("add-prefix").value = "";
				document.getElementById("add-first").value = "";
				document.getElementById("add-last").value = "";
				document.getElementById("add-format").value = "";
				document.getElementById("add-next").value = "";
				document.getElementById("add-suffix").value = "";
			}
			else
			{
				document.getElementById("add-id").value = "";
				document.getElementById("add-prefix").value = "";
				document.getElementById("add-first").value = "";
				document.getElementById("add-last").value = "";
				document.getElementById("add-format").value = "";
				document.getElementById("add-next").value = "";
				document.getElementById("add-suffix").value = "";
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
					url: 'approvedovertimeformprocess.php',
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
							url: 'approvedovertimeformprocess.php',
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
							url: 'approvedovertimeformprocess.php',
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