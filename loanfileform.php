<?php 
session_id("protal");
session_start();
session_regenerate_id();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$logbio = $_SESSION["logbio"];
$lognum = $_SESSION["lognum"];
/*if(isset($_SESSION["lognum"]))
{
	$lognum = $_SESSION["lognum"];
}
else
{
	header('location: employee2.php');
}*/

?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Loan File</title>

	<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<script src="js/jquery.min.js"></script>

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
			<!--<div class="leftpanel-title"><b>COMMANDS</b></div>
			<li><button id="myAddBtn"><span class="fa fa-plus"></span> Create Record</button></li>-->
			<!--<li><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li>
			<li><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Record</button></li>
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>-->
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
							<span class="fa fa-archive"></span> File Loan
						</div>
						<!-- <div class="mainpanel-sub">
							
							<div class="mainpanel-sub-cmd">
								<a href="" class="cmd-create"><span class="far fa-plus-square"></a>
								<a href="" class="cmd-update"><span class="fas fa-edit"></a>
								<a href="" class="cmd-delete"><span class="far fa-trash-alt"></a>
									<span class="mainpanel-sub-space">|</span>
								<a href="" class="cmd-others"><span class="fas fa-caret-up"></a>
								<a href="" class="cmd-others"><span class="fas fa-caret-down"></a>
									<span class="mainpanel-sub-space">|</span>
								<a href="" class="cmd-print"><span class="fas fa-print"></a>
							</div>
						</div> -->
						<!-- tableheader -->
						<div id="container1" class="full">
							<table width="100%" border="0" id="datatbl" class="table table-striped mainpanel-table">
								<thead>	
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:8%;">Worker ID</td>
										<td style="width:12%;">Name</td>
										<td style="width:9%;">Voucher</td>
										<td style="width:8%;">Subtype</td>
										<td style="width:7%;">Loan Type</td>
										<td style="width:8%;">Account</td>
										<td style="width:8%;">Loan Date</td>
										<td style="width:8%;">Loan Amount</td>
										<td style="width:8%;">Amortization</td>
										<td style="width:8%;">Balance</td>
										<td style="width:8%;">From Date</td>
										<td style="width:8%;">To Date</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
									  

										<td><input list="SearchId" class="search" disabled>
										<?php
											$query = "SELECT distinct lf.workerid FROM loanfile lf
														left join worker wk on wk.workerid	= lf.workerid and wk.dataareaid = lf.dataareaid

														where lf.dataareaid = '$dataareaid' and wk.inactive = 0 and lf.workerid = '$lognum'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchId">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["workerid"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchName" class="search" disabled>
										<?php
											$query = "SELECT distinct wk.name FROM loanfile lf
														left join worker wk on wk.workerid	= lf.workerid and wk.dataareaid = lf.dataareaid

														where lf.dataareaid = '$dataareaid' and wk.inactive = 0";
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
									  <td><input list="SearchVoucher" class="search" disabled>
										<?php
											$query = "SELECT distinct voucher FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchVoucher">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["voucher"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchSubType" class="search" disabled>
										<?php
											$query = "SELECT distinct subtype FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchSubType">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["subtype"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchLoanType" class="search" disabled>
										<?php
											$query = "SELECT distinct loantype FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchLoanType">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["loantype"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchAcc" class="search" disabled>
										<?php
											$query = "SELECT distinct todate FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchAcc">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["todate"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchLoanDate" class="search" disabled>
										<?php
											$query = "SELECT distinct loandate FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchLoanDate">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["loandate"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchAmount" class="search" disabled>
										<?php
											$query = "SELECT distinct loanamount FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchAmount">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["loanamount"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchAmortization" class="search" disabled>
										<?php
											$query = "SELECT distinct amortization FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchAmortization">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["amortization"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchBalance" class="search" disabled>
										<?php
											$query = "SELECT distinct balance FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchBalance">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["balance"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchFromDate" class="search" disabled>
										<?php
											$query = "SELECT distinct fromdate FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchFromDate">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["fromdate"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchToDate" class="search" disabled>
										<?php
											$query = "SELECT distinct todate FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchToDate">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["todate"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>

									  <td><span></span></td>
									</tr>
								</thead>
								<tbody id="result">
									<?php					
									$query = "SELECT 
												lf.workerid,wk.name,lf.voucher,lf.subtype,lf.loantype,STR_TO_DATE(lf.loandate, '%Y-%m-%d') loandate,format(lf.loanamount,2) as loanamount,
												format(lf.amortization,2) as amortization,format(lf.balance,2) as balance,STR_TO_DATE(lf.fromdate, '%Y-%m-%d') as fromdate
												,STR_TO_DATE(lf.todate, '%Y-%m-%d') as todate,lf.accountid,acc.name as accname,lf.accountid
												FROM 
												loanfile lf
												left join worker wk on wk.workerid	= lf.workerid and wk.dataareaid = lf.dataareaid
												left join accounts acc on acc.accountcode = lf.accountid and acc.dataareaid = lf.dataareaid

												where lf.dataareaid = '$dataareaid' and wk.inactive = 0 and wk.workerid = '$lognum'

												order by lf.workerid";
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
											<td style="width:8%;"><?php echo $row['workerid'];?></td>
											<td style="width:12%;"><?php echo $row['name'];?></td>
											<td style="width:9%;"><?php echo $row['voucher'];?></td>
											<td style="width:8%;"><?php echo $row['subtype'];?></td>
											<td style="width:7%;"><?php echo $row['loantype'];?></td>
											<td style="width:8%;"><?php echo $row['accname'];?></td>
											<td style="width:8%;"><?php echo $row['loandate'];?></td>
											<td style="width:8%;"><?php echo $row['loanamount'];?></td>
											<td style="width:8%;"><?php echo $row['amortization'];?></td>
											<td style="width:8%;"><?php echo $row['balance'];?></td>
											<td style="width:8%;"><?php echo $row['fromdate'];?></td>
											<td style="width:8%;"><?php echo $row['todate'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['accountid'];?></td>
											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
											
										</tr>
									<?php }?>
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide">
								</span>
							</table>
						</div>
					</div>
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
				<form name="myForm" accept-charset="utf-8" action="loanfileformprocess.php" method="get">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Worker ID:</label>
							
							<select placeholder="Worker ID" id="add-id" name="LFId" class="modal-textarea" style="width:100%;height: 28px;" required="required">
								<option value="" selected="selected"></option>
								<?php
									$query = "SELECT distinct workerid,name FROM worker where dataareaid = '$dataareaid' order by name";
									$result = $conn->query($query);			
									  	
										while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["workerid"];?>"><?php echo $row["name"];?></option>
									<?php } ?>
							</select>

							<label>Voucher:</label>
							<input type="text" value="" placeholder="Voucher" id="add-voucher" name="LFvoucher" class="modal-textarea" required="required">
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Sub-Type:</label>
							<input type="text" value="" placeholder="Sub-type" id="add-subtype" name="LFsubtype" class="modal-textarea" required="required">

							<label>Loan Type:</label>
							<select placeholder="Loan Type" id="add-loantype" name="LFloantype" class="modal-textarea" style="width:100%;height: 28px;" required="required">
								<option value="" selected="selected"></option>
								<?php
									$query = "SELECT distinct loantypeid,description FROM loantype";
									$result = $conn->query($query);			
									  	
										while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["loantypeid"];?>"><?php echo $row["description"];?></option>
									<?php } ?>
							</select>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Account:</label>
							<select placeholder="Account" id="add-account" name="LFaccount" class="modal-textarea" style="width:100%;height: 28px;"  required="required">
								<option value="" selected="selected"></option>
								<?php
									$query = "SELECT distinct accountcode,name FROM accounts where dataareaid = '$dataareaid' and name like '%loan%'";
									$result = $conn->query($query);			
									  	
										while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["accountcode"];?>"><?php echo $row["name"];?></option>
									<?php } ?>
							</select>

							<label>Loan Date:</label>
							<input type="date" value="" placeholder="" id="add-loandate" name="LFloandate" class="modal-textarea">
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Loan Amount:</label>
							<input type="number" step="1.00" value="0.00" placeholder="" id="add-amount" name="LFamount" class="modal-textarea" required="required">

							<label>Amortization:</label>
							<input type="number" step="1.00" value="0.00" placeholder="" id="add-amortization" name="LFamortization" class="modal-textarea" required="required">
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Balance:</label>
							<input type="number" step="1.00" value="0.00" placeholder="" id="add-balance" name="LFbalance" class="modal-textarea" required="required">

							<label>From Date:</label>
							<input type="date" value="" placeholder="" id="add-fromdate" name="LFfromdate" class="modal-textarea">
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>To Date:</label>
							<input type="date" value="" placeholder="" id="add-todate" name="LFtodate" class="modal-textarea">
						</div>

					</div>

					<div class="button-container">
						<button id="addbt" name="save" value="save" class="btn btn-primary btn-action">Save</button>
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
		var locVoucher = "";
		var locSubtype = "";
		var locLoantype = "";
		var locAccount = "";
		var locLoandate = "";
		var locLoanamount = "";
		var locAmortization = "";
		var locBalance = "";
		var locFromdate = "";
		var locTodate = "";
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locVoucher = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locSubtype = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locLoantype = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				locAccount = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(13)").text();
				locLoandate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(7)").text();
				locLoanamount = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
				locAmortization = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
				locBalance = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
				locFromdate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(11)").text();
				locTodate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(12)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(so);	
					  
			});
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
		    $("#add-id").prop('readonly', false);
		    document.getElementById("add-id").value = '';
		    document.getElementById("upbt").style.visibility = "hidden";
		    document.getElementById("addbt").style.visibility = "visible";
		}
		UpdateBtn.onclick = function() {
			if(so != '') {
			    modal.style.display = "block";
			    $("#add-id").prop('readonly', true);
			    var conlocBalance = locBalance.replace(/[A-Za-z!@#$%^&*(),]/g, '');
			    var conlocLoanamount = locLoanamount.replace(/[A-Za-z!@#$%^&*(),]/g, '');
			    var conlocAmortization = locAmortization.replace(/[A-Za-z!@#$%^&*(),]/g, '');

				document.getElementById("add-id").value = so;
				document.getElementById("add-voucher").value = locVoucher.toString();
				document.getElementById("add-subtype").value = locSubtype.toString();
				document.getElementById("add-loantype").value = locLoantype.toString();
				document.getElementById("add-account").value = locAccount.toString();
				document.getElementById("add-loandate").value = locLoandate.toString();
				document.getElementById("add-amount").value = conlocLoanamount.toString();
				document.getElementById("add-amortization").value = conlocAmortization.toString();
				document.getElementById("add-balance").value = conlocBalance.toString();
				document.getElementById("add-fromdate").value = locFromdate.toString();
				document.getElementById("add-todate").value = locTodate.toString();
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
			var slocWorkerId = "";
			var slocName = "";
			var slocVoucher = "";
			var slocSubtype = "";
			var slocLoantype = "";
			var slocAccount = "";
			var slocLoandate = "";
			var slocLoanamount = "";
			var slocAmortization = "";
			var slocBalance = "";
			var slocFromdate = "";
			var slocTodate = "";

			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 slocWorkerId = data[0];
			 slocName = data[1];
			 slocVoucher = data[2];
			
			 $.ajax({
						type: 'GET',
						url: 'loanfileformprocess.php',
						data:{action:action, actmode:actionmode, slocWorkerId:slocWorkerId, slocName:slocName, slocVoucher:slocVoucher},
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
					url: 'numbersequenceprocess.php',
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
							url: 'numbersequenceprocess.php',
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
							url: 'numbersequenceprocess.php',
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

			window.location.href='workerform.php';		   
		}

	</script>
<script type="text/javascript" src="js/custom.js"></script>
<!-- end [JAVASCRIPT] -->

</body>
</html>