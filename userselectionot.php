<?php 
session_start();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];


$firstresult='';
/*if(isset($_SESSION['groupid']))
{
	$grpid = $_SESSION['groupid'];
}
else
{
	header('location: usergroupprivilegesform.php');
}*/


?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Batch Overtime</title>

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
		<ul class="subbuttons">
			<div class="leftpanel-title"><b>COMMANDS</b></div>
			<li><button onClick="Validate();"><span class="fa fa-plus fa-lg"></span> Validate Overtime</button></li>
			<li><button id='batchsave' onClick="Save();"><span class="fa fa-plus fa-lg"></span> Save Record</button></li>
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
		</ul>
		

	</div>
	<!-- end LEFT PANEL -->

	<!-- begin DASHBOARD -->
	<div class="mainpanel dashboard">
		<div class="container-fluid">
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
													<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
													<td style="width:5%;">Include</td>
													<td style="width:19%;">Worker ID</td>
													<td style="width:19%;">Name</td>
													<td style="width:19%;">Position</td>
													<td style="width:19%;">Department</td>
													<td style="width:19%;">Branch</td>
													<td style="width: 17px;"><span class="fas fa-arrows-alt-v"></span></td>
												</tr>
												<tr class="rowsearch">
												  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
												  
												  <td><center><span class="fa fa-check"></span></center></td>
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
												$query = "SELECT wk.workerid,wk.Name,pos.name as 'position',dep.name as 'department',bra.name	as 'branch'

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
														<td style="width:5%;"><input type='checkbox' id="chkbox" name="chkbox" class="checkbox" 
														value="<?php echo $row['workerid'];?>"  ></td>
														<td style="width:19%;"><?php echo $row['workerid'];?></td>
														<td style="width:19%;"><?php echo $row['Name'];?></td>
														<td style="width:19%;"><?php echo $row['position'];?></td>
														<td style="width:19%;"><?php echo $row['department'];?></td>
														<td style="width:19%;"><?php echo $row['branch'];?></td>
														
													</tr>
												<?php }?>
											</tbody>
											<span class="temporary-container-input">
												<input type="hidden" id="hide" value="<?php echo $firstresult;?>">
												<input type="hidden" id="hidefocus" value="<?php echo $rowcnt;?>">	
												<input type="hidden" id="inchide">
												<input type="hidden" id="inchide2">		
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





			<!-- ROW 4 -->
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="dashboard-content">
						<div class="row">

							<!-- start TABLE AREA -->
								<div class="mainpanel-content" style="padding: 0px 15px !important; margin-top: 5px !important; background-color: #FBFBFB;">
									<!-- title & search -->
									<div class="mainpanel-title" style="width:100%;">
										<span class="fa fa-archive"></span> Overtime Details
									</div>
									<!-- tableheader -->
									<div id="container1" class="half">
										<div class="row">

											<form name="myForm" id="myForm" accept-charset="utf-8" action="overtimeformprocess.php" method="get">
												<!-- L -->
												<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
													<!--
													<p>
														<label style="width: 90px;">Overtime ID:</label>
														<span id="resultid"><input type="text" value="" placeholder="Overtime" name ="OTId" id="add-otid" class="modal-textarea" required="required" style="width:300px;"></span>
													</p>
													-->
													<p>
														<label style="width: 90px;">Overtime Date:</label>
														<span><input type="date" value="" placeholder="" id="add-otdate" name="OTdate" class="modal-textarea" style="width:30%;height: 28px;" required="required"></span>
													</p>
													<p>
														<label style="width: 90px;">Overtime Type:</label>
														<select value=""  placeholder="Period" name ="OTtype" id="add-type" class="modal-textarea" style="width:30%;height: 28px;"  required="required">
																<option value=""></option>
																<option value="5">Early Overtime</option>
																<option value="0">Regualr Overtime</option>
																<option value="1">Special Holiday Overtime</option>
																<option value="2">Regualr Holiday Overtime</option>
																<option value="3">Sunday Overtime</option>
														</select>
													</p>
													<p style="border-top: solid 1px #DDD; padding-top: 15px">
														<!--<label style="width: 70px;">Start Time:</label>-->
														<input type="hidden" value="12:00 AM" placeholder="" id="add-otstarttime" name="OTstart" class="modal-textarea" style="width:15%;height: 28px;" required="required">
														<span style="width: 40px; display: inline-block;">&nbsp;</span>
														<!--<label style="width: 70px;">End Time:</label>-->
														<input type="hidden" value="12:00 AM" placeholder="" id="add-otendtime" name="OTend" class="modal-textarea" style="width:15%;height: 28px;" required="required">
													</p>
													<p style="border-bottom: solid 1px #DDD; padding-bottom: 15px;">
														<label style="width: 70px;">Hours:</label>
														<input type="number" step="1" min="0" value="0" placeholder="" id="add-othours" name="OThours" class="modal-textarea" required="required"
															onkeypress="return !(event.charCode == 46)" style="width:15%;height: 28px;">
														<span style="width: 30px; display: inline-block;">&nbsp; </span>&nbsp;&nbsp;&nbsp;
														<label style="width: 70px;">Minutes:</label>
														<!--<input type="number" step="1" min="0" value="0" placeholder="" id="add-otminutes" name="OTminutes" class="modal-textarea" required="required" 
															onkeypress="return !(event.charCode == 46)" style="width:15%;height: 28px;">-->
															<select value="" value="" placeholder="" name="OTminutes"  id="add-otminutes" class="modal-textarea" style="width:15%;height: 28px;" required="required">
																	
																	<option value="0" selected>0</option>
																	<option value="15">15</option>
																	<option value="30">30</option>
																	<option value="45">45</option>
															</select>
													</p>

												</div>

												<!-- R -->
												<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
													<p>
														<label>Details:</label><br>
														<textarea id="add-details" name="OTdetails" class="textarea1" required="required" placeholder="Over Time Details"></textarea>
													</p>
													<div id="resultfilter">
															<input type="hidden" value="" name ="myHrs" id="otHRS" class="modal-textarea" >
															<input type="hidden" value="" name ="myMins" id="otMINS" class="modal-textarea" >
															
													</div>
													<!--
													<p>
														<button id="addbt" name="save" value="save" class="btn btn-primary btn-action" onclick="return checkExistForm()">Save</button>
														<button id="upbt" name="update" value="update" class="btn btn-success btn-action" onclick="return validateForm()">Update</button>
														<button onClick="Clear();" type="button" value="Reset" class="btn btn-danger">Clear</button>
													</p>
												-->
												</div>
											</form>

										</div>
									</div>
								</div>
							<!-- end TABLE AREA -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end MAINPANEL -->









<script src="js/ajax.js"></script>
	  	<script  type="text/javascript">

	  	var so='';
		var locAccName;

  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				//$('table tbody tr').css('background-color','');
				//$(this).css('background-color','#ffe6cb');
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				var AcInc = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locAccName = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();

				so = usernum.toString();
				document.getElementById("hide").value = so;				  
			});
		});

	  		

		$(document).ready(function() {
		
			$("#batchsave").prop("disabled", true);
			var pos = document.getElementById("hidefocus").value;
		    //$("tr[tabindex="+pos+"]").focus();
		    //$("tr[tabindex=0]").focus();
		    //$("tr[tabindex="+pos+"]").css("color","red");  
		    //var idx = $("tr:focus").attr("tabindex");
		    //alert(idx);
		    //document.onkeydown = checkKey;
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
						url: 'userselectionprocess.php',
						data:{action:action, actmode:actionmode, sLocId:sLocId, slocName:slocName, slocPosition:slocPosition, sLocDepartment:sLocDepartment, slocbranch:slocbranch},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							$('#resulthead').html('<center><img src="img/loading.gif" width="300" height="300"></center>');
			
						},
						success: function(data){
							$('#resulthead').html(data);
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
		    	//alert(el2);
			});
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

	function Validate()
	{
		//var locHours = document.getElementById("add-othours").value;
		//var locMins = document.getElementById("add-otminutes").value;
		
		$("#batchsave").prop("disabled", false);
		$.each(uniqueNames, function(i, el){
			   // $("input[value="+el+"]").prop("checked", true);
			    var res = el.substring(1,el.length - 1, el.length);
			    getOT(res);

			});
	}

	function getOT(SelWorker)
	{
		
		//alert(SelWorker);

		var action = "getOT";
		var OTdate = document.getElementById("add-otdate").value;
		var OTtype = document.getElementById("add-type").value.toString();

		var locDetails = document.getElementById("add-details").value;
		var locHours = document.getElementById("add-othours").value;
		var locMins = document.getElementById("add-otminutes").value;

		//alert(OTdate);

		//alert(OTtype);

		if(OTtype == '')
		{
			OTtype = 0;

		}
		else if (OTtype == 5)
		{
			OTtype == 5;
		}
		else
		{
			OTtype = 0;
		}
		
		if(OTdate == '')
		{
			OTdate = '1900-01-01'
		}
	
		if(SelWorker != '')
		{
			if (OTdate == "" || document.getElementById("add-type").value == '')
			{
			    alert("All details must be filled out asd");
			    //return false;
			    //alert(OTdate);
			    //alert(locDetails);
			    //alert(OTtype);

			}
			else 
			{
			  	
			  	if(locHours ==0 && locMins == 0)
			  	{
			  		alert("Hours and Minutes must not be zero!");
			  		//return false;
			  	}
			  	else
			  	{
			  		$.ajax({
								type: 'GET',
								url: 'userselectionprocess.php',
								data:{action:action, OTdate:OTdate, OTtype:OTtype, SelWorker:SelWorker},
								beforeSend:function(){
								
									//$("#resultfilter").html('<img src="img/loading.gif" width="300" height="300">');
					
								},
								success: function(data){
									$('#resultfilter').html(data);
									checkHour(SelWorker);
									//alert(data);
									//$("#add-otid").prop('readonly', true); 
						}
					});
			  	}
			}
		}
	   
	}

	function checkHour(SelWorker)
	{
		//alert(SelWorker);
		var myWKname = document.getElementById("myWkname").value.toString();
		var locHours = document.getElementById("add-othours").value.toString();
		var locMins = document.getElementById("add-otminutes").value.toString();

		var myOtMins = document.getElementById("otMINS").value.toString();
		var	myOtHrs = document.getElementById("otHRS").value.toString();

		//SelWorker
		if (locHours > myOtHrs)
		{
			alert(myWKname+" doesnt reach:" +locHours+ " hours of OT. Please remove from the list!");
			$("#batchsave").prop("disabled", true);
		}
		else
		{
			if(locMins > myOtMins)
			{
				alert(myWKname+" doesnt reach:" +locMins+ " minutes of OT. Please remove from the list!");
				$("#batchsave").prop("disabled", true);
			}
			else
			{
				//alert(myWKname+" Saved");
			}
		}
	}

	function Save()
	{

		var SelectedVal = $('#inchide').val();
		var action = "save";
		var actmode = "overtime";
		//alert(SelectedVal);
		//var locOvertimedate = document.getElementById("add-otid").value;
		var locOvertimedate = document.getElementById("add-otdate").value;
		var locDetails = document.getElementById("add-details").value;
		var locType = document.getElementById("add-type").value;
		var locStarttime = document.getElementById("add-otstarttime").value;
		var locEndtime = document.getElementById("add-otendtime").value;
		var locHours = document.getElementById("add-othours").value;
		var locMins = document.getElementById("add-otminutes").value;
		//alert(locStarttime);
		if(SelectedVal != '')
		{
			if (locOvertimedate == "" || locDetails == "" || locType == "" || locStarttime == "" || locEndtime == "" )
			{
			    alert("All details must be filled out");
			    return false;

			}
			else 
			{
			  	
			  	if(locHours ==0 && locMins == 0)
			  	{
			  		alert("Hours and Minutes must not be zero!");
			  		return false;
			  	}
			  	else
			  	{
			  		//alert("Valid");
			  		$.ajax({	
							type: 'GET',
							url: 'userselectionprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actmode, SelectedVal:SelectedVal, locOvertimedate:locOvertimedate, locDetails,locDetails, locType,locType, locStarttime:locStarttime, locEndtime:locEndtime, locHours:locHours, locMins:locMins},
							beforeSend:function(){
									
							$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							//window.location.href='usergroupsassignment.php';	
							//$('#datatbl').html(data);
							location.reload();
							alert("Overtime Filed");					
							}
					});
			  	}
			}
		}
		else
		{
			alert("Please select Employee");
		}
		
		
		
						
	}

	
	function Cancel()
	{

		window.location.href='employee.php';		   
	}


</script>
	<!-- begin [JAVASCRIPT] -->
	<script type="text/javascript" src="js/custom.js">
		


	</script>
	<!-- end [JAVASCRIPT] -->

	

</body>
</html>