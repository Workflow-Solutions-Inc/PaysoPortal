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
	<title>Payslip</title>

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
			<li><button id="myAddBtn" onclick="getPayslip()"><span class="fa fa-plus"></span> View Payslip</button></li>
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
							<span class="fa fa-archive"></span>Payslip
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
										
										<td style="width:10%;">Payroll Group</td>
										<td style="width:14%;">Start Date</td>
										<td style="width:10%;">End Date</td>
										<td style="width:25%;">Payment Date</td>
										<td style="width:13px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
								
								</thead>
								<tbody id="result">
									<?php					
									$query = "select ph.payrollid as 'Payroll',case when pp.payrollgroup = 1 then 'Semi-Monthly' else 'Weekly' end as 'Payroll Group',ph.fromdate as 'Start Date',ph.todate as 'End Date',pp.payrolldate as 'Payment Date',pd.workerid
											,ph.dataareaid from payrollheader ph 
											left join payrollperiod pp on
											ph.payrollperiod = pp.payrollperiod and
											ph.dataareaid = pp.dataareaid
											left join payrolldetails pd on
											pd.payrollid = ph.payrollid and
											pd.dataareaid = ph.dataareaid
											where ph.payrollstatus = 3 and pd.workerid = '$lognum'
											group by pp.payrollgroup,ph.fromdate,ph.todate,pp.payrolldate 
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
											
											<td style="width:10%;"><?php echo $row['Payroll Group'];?></td>
											<td style="width:14%;"><?php echo $row['Start Date'];?></td>
											<td style="width:10%;"><?php echo $row['End Date'];?></td>
											<td style="width:25%;"><?php echo $row['Payment Date'];?></td>
											<td style="width:0%;"><?php echo $row['workerid'];?></td>
											<td style="width:0%;"><?php echo $row['Payroll'];?></td>
											<td style="width:0%;"><?php echo $row['dataareaid'];?></td>

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
			

		      alert(clicked_id);
		}


		  	var so='';
	  	//var locWorkerId = "";
		var workerid = "";
		var comp = "";
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+1) +") td:eq(6)").text();
				workerid = $("#datatbl tr:eq("+ ($(this).index()+1) +") td:eq(5)").text();
			
				comp = $("#datatbl tr:eq("+ ($(this).index()+1) +") td:eq(7)").text();

				so = usernum.toString();
			//	document.getElementById("hide").value = so;

				//alert(document.getElementById("hide").value);
				//alert(so);	
					  
			});
		});

		$(document).ready(function(){
    		HL = document.getElementById("hide3").value;
		    $("#"+HL+"").addClass("active");
		});


		var CreateBtn = document.getElementById("myAddBtn");


		CreateBtn.onclick = function() {
			if(so !="")
			{
				//window.location.href = 'payslip/payslip.php?payroll='+so+'&worker='+workerid+'&comp='+comp+'';
				window.open('payslip/payslip.php?payroll='+so+'&worker='+workerid+'&comp='+comp+'', "_blank");
			}
		
			else
			{
				alert("No Records selected.");
			}
		  
		}
		/*function getPayslip()
		{
				
				//window.location.href = 'employeeportal/payslip/payslip.php?payroll='+so+'';
		}*/
	
	</script>
<script type="text/javascript" src="js/custom.js"></script>
<!-- end [JAVASCRIPT] -->

</body>
</html>