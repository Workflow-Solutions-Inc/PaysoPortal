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
	<title>Certificate</title>

	<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<script src="js/jquery.min.js"></script>

</head>
<body>-->



	<!-- begin HEADER -->
	<?php require("inc/header.php"); ?>

	<!-- <div class="header">
		<div class="header-content">

		<div class="header-nav">
				
		</div>

		</div>
	</div>

	<div class="spacer">&nbsp;</div> -->

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
			<li><button id="myAddBtn"><span class="fa fa-plus"></span> Request Certificate</button></li>
			<li><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Request</button></li>
			<li><button onClick="download();"><span class="fa fa-download"></span> Download File</button></li>
			<li><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li>
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
							<span class="fa fa-archive"></span>Certificate
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
										
										<td style="width:25%;">Certificate ID</td>
										<td style="width:25%;">Purpose</td>
										<td style="width:25%;">Certifcate Type</td>
										<td style="width:25%;">Status</td>
										<td style="width:25%;">Date Requested</td>
										<td style="width:18px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
								
								</thead>
								<tbody id="result">
									<?php					
									$query = "SELECT certificateid,details,
													case when certificatetype = 0 then 'Certificate Of Employment'
											        when certificatetype = 1 then 'SSS Certificate'
											        when certificatetype = 2 then 'PhilHealth Certificate'
											        when certificatetype = 3 then 'PAG-IBIG Certificate'
											        end as certtype,
											        case when status = 0 then 'Created'
													when status = 1 then 'Approved' 
													when status = 2 then 'Disapproved' 
													when status = 3 then 'Posted' end as status,
											        date_format(createddatetime, '%Y-%m-%d') as reqdate,
											        certificatetype,
											        certfile
											 FROM certificate;
										";
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
											
											<td style="width:25%;"><?php echo $row['certificateid'];?></td>
											<td style="width:25%;"><?php echo $row['details'];?></td>
											<td style="width:25%;"><?php echo $row['certtype'];?></td>
											<td style="width:25%;"><?php echo $row['status'];?></td>
											<td style="width:25%;"><?php echo $row['reqdate'];?></td>
											<td style="width:0%;"><?php echo $row['certificatetype'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['certfile'];?></td>

											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
											
										</tr>
									<?php }?>

								

								</tbody>
							
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
				<div class="col-lg-6">Certificate</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm" accept-charset="utf-8" action="certprocess.php" method="get">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Certificate ID:</label>
							<div id="resultid">
								<input type="text" value="" placeholder="Certficate ID" name ="CertId" id="add-certid" class="modal-textarea" required="required">
							</div>

							<label>Purpose:</label>
							<textarea id="add-purpose" name="Purpose" class="textarea1" required="required" placeholder="Purpose"></textarea>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Certificate Type:</label>
							<select value="" value="" placeholder="Cerificate Type" name ="CertType" id="add-certtype" class="modal-textarea" style="width:100%;height: 28px;" required="required">
									<option value=""></option>
									<option value="0">Certificate Of Employment</option>
									<option value="1">SSS Certificate</option>
									<option value="2">PhilHealth Certificate</option>
									<option value="3">PAG-IBIG Certificate</option>
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
			
		var loccertid='';
	  	var locdetails = "";
		var loctype = "";
		var locfile = "";
		var locstatus='';
		
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var certid = $("#datatbl tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
				locdetails = $("#datatbl tr:eq("+ ($(this).index()+1) +") td:eq(2)").text();
				locstatus = $("#datatbl tr:eq("+ ($(this).index()+1) +") td:eq(4)").text();
				loctype = $("#datatbl tr:eq("+ ($(this).index()+1) +") td:eq(6)").text();
				locfile = $("#datatbl tr:eq("+ ($(this).index()+1) +") td:eq(7)").text();
				loccertid = certid.toString();
				//document.getElementById("hide").value = so;

				//alert(document.getElementById("hide").value);
				//alert(loccertid);	
					  
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
		    //modal.style.display = "block";
		    $("#myModal").stop().fadeTo(500,1);
		    /*$("#add-branch").prop('readonly', false);
		    document.getElementById("add-branch").value = '';*/
		    document.getElementById("upbt").style.visibility = "hidden";
		    document.getElementById("addbt").style.visibility = "visible";
		    var action = "add";
		    $.ajax({
						type: 'GET',
						url: 'certprocess.php',
						data:{action:action},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							//$("#result").html('<img src="img/loading.gif" width="300" height="300">');
			
						},
						success: function(data){
							$('#resultid').html(data);
							$("#add-certid").prop('readonly', true); 
				}
			});
		}
		UpdateBtn.onclick = function() {
			if(loccertid != '') {
			    //modal.style.display = "block";
			    $("#myModal").stop().fadeTo(500,1);
			    $("#add-certid").prop('readonly', true);
			    document.getElementById("add-certid").value = loccertid.toString();
				document.getElementById("add-purpose").value = locdetails.toString();
				document.getElementById("add-certtype").value = loctype.toString();
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


		function Delete()
		{
			
			var action = "delete";
			var actionmode = "userform";
			//alert(so);
			if(loccertid != '') {
				if(confirm("Are you sure you want to remove this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'certprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, loccertid:loccertid},
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

		function download()
		{
			//alert(locfile);
			if(locfile != '')
			{
				if(locstatus != "Posted")
				{
					alert("Status must be Posted before can be downloaded");
				}
				else
				{
					window.open('certprocess.php?file_id='+locfile, "_blank");
				}
			}
			else
			{
				alert("Please select record you want to download.")
			}
			
			
		
		}
	
	</script>
<script type="text/javascript" src="js/custom.js"></script>
<!-- end [JAVASCRIPT] -->

</body>
</html>