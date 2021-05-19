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
	<title>Log Correction</title>

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
					<li id="pla" onClick="reply_click(this.id)"><a href="approverlogform.php?list=pla"><span class="fas fa-hourglass"></span>  Pending Log Correction Application</a></li>
					<li id="ala" onClick="reply_click(this.id)"><a href="approverviewlogform.php?list=ala"><span class="fas fa fa-check"></span>  Posted Log Correction Application</a></li>
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
			<li><button onClick="RevertLC();"><span class="fa fa-history"></span> Revert</button></li>
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
							<span class="fa fa-archive"></span> Log Correction Details
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
										<td style="width:10%;">Log ID</td>
										<td style="width:14%;">Name</td>
										<td style="width:10%;">Invalid Date</td>
										<td style="width:22%;">Details</td>
										<td style="width:7%;">Log Time</td>
										<td style="width:5%;">Log Type</td>
										<td style="width:7%;">Status</td>
										<td style="width:10%;">Approval Date</td>
										<td style="width:10%;">Approved By</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
									  
									  	<td><center><input id="selectAll" type="checkbox"></span></center></td>
										<td><input list="SearchId" class="search">
										<?php
											$query = "SELECT distinct logid FROM logcorrection where dataareaid = '$dataareaid' and status != 0";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchId">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["logid"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchName" class="search" >
										<?php
											$query = "SELECT distinct name FROM logcorrection where dataareaid = '$dataareaid' and status != 0";
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
									  <td><input list="SearchInvalidDate" class="search">
										<?php
											$query = "SELECT distinct invaliddate FROM logcorrection where dataareaid = '$dataareaid' and status != 0";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchInvalidDate">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["invaliddate"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchDetails" class="search" disabled>
										<?php
											$query = "SELECT distinct details FROM logcorrection where dataareaid = '$dataareaid' and status != 0";
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
									  <td><input list="SearchLogtime" class="search" disabled>
										<?php
											$query = "SELECT distinct logtime FROM logcorrection where dataareaid = '$dataareaid' and status != 0";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchLogtime">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["logtime"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchLogtype" class="search" disabled>
										<?php
											$query = "SELECT distinct logtype FROM logcorrection where dataareaid = '$dataareaid' and status != 0";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchLogtype">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["logtype"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchStatus" class="search" disabled>
										<?php
											$query = "SELECT distinct status FROM logcorrection where dataareaid = '$dataareaid' and status != 0";
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
											$query = "SELECT distinct date_format(approvaldatetime, '%Y-%m-%d') as datefiled FROM logcorrection where dataareaid = '$dataareaid' and status != 0";
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
									  <td><span></span></td>
									</tr>
								</thead>
								<tbody id="result">
									<?php					
									$query = "SELECT *,TIME_FORMAT(lc.logtime,'%h:%i %p') as logtimes,
									case when lc.status = 0 then 'Created'
										when lc.status = 1 then 'Approved' 
										when lc.status = 2 then 'Disapproved' 
										when lc.status = 3 then 'Posted' end as otstatus,
									case when lc.logtype = 0 then 'Time In'
										when lc.logtype = 1 then 'Time Out' 
										when lc.logtype = 3 then 'Break Out' 
										when lc.logtype = 4 then 'Break In'
										end as logtypes,
										date_format(lc.approvaldatetime, '%Y-%m-%d') as datefiled

									FROM logcorrection lc
									left join organizationalchart org on org.workerid = lc.workerid and org.dataareaid = lc.dataareaid
									where lc.dataareaid = '$dataareaid' 
									and org.repotingid = '$lognum'
										and lc.status != 0
									order by lc.logid";
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
												value="<?php echo $row['logid'];?>"></td>
											<td style="width:10%;"><?php echo $row['logid'];?></td>
											<td style="width:14%;"><?php echo $row['name'];?></td>
											<td style="width:10%;"><?php echo $row['invaliddate'];?></td>
											<td style="width:22%;"><?php echo $row['details'];?></td>
											<td style="width:7%;"><?php echo $row['logtimes'];?></td>
											
											<td style="width:5%;"><?php echo $row['logtypes'];?></td>
											<td style="width:7%;"><?php echo $row['otstatus'];?></td>
											<td style="width:10%;"><?php echo $row['datefiled'];?></td>
											<td style="width:10%;"><?php echo $row['approvedby'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['logtime'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['logtype'];?></td>
											
											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
											
										</tr>
									<?php }?>

									

									<?php 
									
									$query4 = "SELECT *,TIME_FORMAT(logtime,'%h:%i %p') as logtime,
									case when status = 0 then 'Created'
										when status = 1 then 'Approved' 
										when status = 2 then 'Disapproved' 
										when status = 3 then 'Posted' end as otstatus,
									case when logtype = 0 then 'Time In'
										when logtype = 1 then 'Time Out' end as logtypes,
										date_format(createddatetime, '%Y-%m-%d') as datefiled

									FROM logcorrection where dataareaid = '$dataareaid' and workerid = '$lognum'
										
									order by logid";
									$result4 = $conn->query($query4);
									$collection2 = '';
									while ($row4 = $result4->fetch_assoc())
									{ 
										$collection2 = $collection2.','.$row4['invaliddate'];
										
									}
									?>




								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide">
									<input type="hidden" id="hide3" value="<?php echo $sample;?>">	
									<div style="display:none;width:1%;"><textarea id="t3" value = "<?php echo substr($collection2,1);?>"><?php echo substr($collection2,1);?></textarea></div>
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
	<!-- end MAINPANEL -->

<!-- The Modal -->
<div id="myModal" class="modal">
	<!-- Modal content -->
	<div class="modal-container">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-lg-6">Log Correction Details</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm" accept-charset="utf-8" action="logformprocess.php" method="get">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Log ID:</label>
							<div id="resultid">
								<input type="text" value="" placeholder="Log Id" name ="LCId" id="add-lcid" class="modal-textarea" required="required">
							</div>
							

							<label>Invalid Date:</label>
							<input type="date" value="" placeholder="" id="add-lcdate" name="LCdate" class="modal-textarea" required="required">
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Details:</label>
							<input type="text" value="" placeholder="Log Correction Details" id="add-details" name="LCdetails" class="modal-textarea" required="required">

							<label>Log Time:</label>
							<input type="time" value="" placeholder="" id="add-lctime" name="LCtime" class="modal-textarea" required="required">
						</div>

						
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Log Type:</label>
							<select value="" value="" placeholder="Period" name ="LCytype" id="add-lctype" class="modal-textarea" style="width:100%;height: 28px;"  required="required">
									<option value=""></option>
									<option value="0">Time In</option>
									<option value="1">Time Out</option>
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
		var locinvaliddate = "";
		var locDetails = "";
		var loclogtime = "";
		var loclogtype = "";
		var locStatus= "";
		var locDateFile = "";
		var loclogtypenum = "";
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locName = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locinvaliddate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locDetails = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				loclogtime = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
				locStatus = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(7)").text();
				locDateFile = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
				loclogtypenum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(11)").text();

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

		/*// Get the modal -------------------
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
						url: 'logformprocess.php',
						data:{action:action},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							//$("#result").html('<img src="img/loading.gif" width="300" height="300">');
			
						},
						success: function(data){
							$('#resultid').html(data);
							$("#add-fwid").prop('readonly', true); 
				}
			});
		}
		UpdateBtn.onclick = function() {
			if(so != '') {
			    modal.style.display = "block";
			    $("#add-fwid").prop('readonly', true);

				document.getElementById("add-lcid").value = so;
				document.getElementById("add-lcdate").value = locinvaliddate.toString();
				document.getElementById("add-details").value = locDetails.toString();
				document.getElementById("add-lctime").value = loclogtime;
				document.getElementById("add-lctype").value = loclogtypenum.toString();
				
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
		}*/
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

			var sloclogid = "";
			var slocName = "";
			var slocinvaliddate = "";
			var slocDetails = "";
			var sloclogtime = "";
			var sloclogtype = "";
			var slocStatus= "";
			var slocDateFile = "";
			var sloclogtypenum = "";

			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 sloclogid = data[0];
			 slocName = data[1];
			 slocinvaliddate = data[2];
			
			 $.ajax({
						type: 'GET',
						url: 'approverviewlogformprocess.php',
						data:{action:action, actmode:actionmode, sloclogid:sloclogid, slocName:slocName, slocinvaliddate:slocinvaliddate},
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

		function RevertLC()
		{

			var SelectedVal = $('#inchide').val();
			var action = "revert";
			var actionmode = "userform";
			//alert(document.getElementById("add-include").value);
			$.ajax({	
					type: 'GET',
					url: 'approverviewlogformprocess.php',
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
				document.getElementById("add-lcdate").value =  "";
				document.getElementById("add-details").value =  "";
				document.getElementById("add-lctime").value =  "";
				document.getElementById("add-lctype").value =  "";
			}
			else
			{
				document.getElementById("add-lcdate").value =  "";
				document.getElementById("add-details").value =  "";
				document.getElementById("add-lctime").value =  "";
				document.getElementById("add-lctype").value =  "";
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