<?php
session_start();
session_regenerate_id();
$userlogin = $_SESSION["portaluser"];
$dataareaid = $_SESSION["portaldefaultdataareaid"];
$logname = $_SESSION["portallogname"];
$logbio = $_SESSION["portallogbio"];
$lognum = $_SESSION["portallognum"];
include("dbconn.php");

if(isset($_GET["save"])) {
	 
	 $id=$_GET["OTId"];
	 $otdate=$_GET["OTdate"];
	 $otdetails=$_GET["OTdetails"];
	 $otstart=$_GET["OTstart"];
	 $otend=$_GET["OTend"];
	 $otleavetype=$_GET["OTleavetype"];
	 $otdaytype=$_GET["OTdaytype"];

	 
	 if($id != ""){
	 $sql = "INSERT INTO portalleavefile (leaveid,leavedate,details,starttime,endtime,leavetype,daytype,name,workerid,status,dataareaid,createdby,createddatetime)
			values 
			('$id','$otdate','$otdetails','$otstart','$otend','$otleavetype','$otdaytype','$logname','$lognum',0, '$dataareaid', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: leaveform.php');
	
}
else if(isset($_GET["update"])) {
	 
	 $id=$_GET["OTId"];
	 $otdate=$_GET["OTdate"];
	 $otdetails=$_GET["OTdetails"];
	 $otstart=$_GET["OTstart"];
	 $otend=$_GET["OTend"];
	 $otleavetype=$_GET["OTleavetype"];
	 $otdaytype=$_GET["OTdaytype"];
	 
	 if($id != ""){
	 $sql = "UPDATE portalleavefile SET
				leavedate = '$otdate',
				details = '$otdetails',
				starttime = '$otstart',
				endtime = '$otend',
				leavetype = '$otleavetype',
				daytype = '$otdaytype',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE leaveid = '$id'
				and dataareaid = '$dataareaid'
				and createdby = '$userlogin'";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Updated";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: leaveform.php');
	
}
else if($_GET["action"]=="deletexx"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["LoanId"];

		if($id != ""){
			$sql = "DELETE from loantype where loantypeid = '$id'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: loanfileform.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["slocOvertimeId"];
		$name=$_GET["slocName"];
		$overtimedate=$_GET["slocOvertimedate"];
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT *,TIME_FORMAT(starttime,'%h:%i %p') as timein,TIME_FORMAT(endtime,'%h:%i %p') as timeout,
									case when status = 0 then 'Created'
										when status = 1 then 'Approved' 
										when status = 2 then 'Disapproved' 
										when status = 3 then 'Posted' end as otstatus,
									case when daytype = 0 then 'Whole Day'
										when daytype = 1 then 'Half Day' end as daytypes,
										date_format(approvaldatetime, '%Y-%m-%d') as datefiled

									FROM portalleavefile pl
									left join organizationalchart org on org.workerid = pl.workerid and org.dataareaid = pl.dataareaid
									where pl.dataareaid = '$dataareaid'
									 and (leaveid like '%$id%') and (name like '%$name%') and (leavedate like '%$overtimedate%')
										and status != 0 and org.repotingid = '$lognum'
									order by leaveid";
		$result = $conn->query($query);
		$rowclass = "rowA";
		$rowcnt = 0;
		while ($row = $result->fetch_assoc())
		{
			$rowcnt++;
				if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
				else { $rowclass = "rowA";}
			$output .= '
			<tr class="'.$rowclass.'">
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:5%;"><input type="checkbox" id="chkbox" name="chkbox" class="checkbox"
				 	value="'.$row['leaveid'].'" '.($row["status"]==3 ? 'disabled' : '').'></td>
				<td style="width:10%;">'.$row["leaveid"].'</td>
				<td style="width:13%;">'.$row["name"].'</td>
				<td style="width:8%;">'.$row["leavedate"].'</td>
				<td style="width:20%;">'.$row["details"].'</td>
				<td style="width:7%;">'.$row["timein"].'</td>
				<td style="width:7%;">'.$row["timeout"].'</td>
				<td style="width:5%;">'.$row["leavetype"].'</td>
				<td style="width:5%;">'.$row["daytypes"].'</td>
				<td style="width:7%;">'.$row["otstatus"].'</td>
				<td style="width:8%;">'.$row["datefiled"].'</td>
				<td style="width:10%;">'.$row["approvedby"].'</td>
				<td style="display:none;width:1%;">'.$row["starttime"].'</td>
				<td style="display:none;width:1%;">'.$row["endtime"].'</td>
				<td style="display:none;width:1%;">'.$row["daytype"].'</td>

				
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}
else if($_GET["action"]=="revert"){
	 
	 
	$id=$_GET["SelectedVal"];
	
	 if($id != ""){

	 	$query = "SELECT * FROM portalleavefile

						where leaveid in ($id)";
			$result = $conn->query($query);
			while ($row = $result->fetch_assoc())
			{

				$userid=$row["workerid"];
				$leaveid=$row["leaveid"];
				$leavetype=$row["leavetype"];
				$query2 = "SELECT *

							from portalleavefile 
							where dataareaid = '$dataareaid' and workerid = '$userid' and leaveid = '$leaveid'";

					$result2 = $conn->query($query2);
				
					while ($row2 = $result2->fetch_assoc())
					{ 
							

							$userid=$row2["workerid"];
							$leaveid=$row2["leaveid"];
							$leavetype=$row2["leavetype"];
							$Ldaytype = $row2['daytype'];

							$otstart = $row2['starttime'];
							$otend = $row2['endtime'];

							$status = $row2['status'];

							$query3 = "SELECT format(balance,4) balance,ispaid FROM leavefile 
							where workerid = '$userid' and dataareaid = '$dataareaid' and leavetype = '$leavetype'";
							$result3 = $conn->query($query3);
							while ($row3 = $result3->fetch_assoc())
							{ 
									

									$wkvl = $row3['balance'];
									$ispaid = $row3['ispaid'];
									

							}

							
							if($ispaid == 1 && $status == 2)
							{
							
							

								$starttimestamp = strtotime($otstart);
								$endtimestamp = strtotime($otend);
								$deduct = abs($endtimestamp - $starttimestamp)/3600;
								if($deduct >= 9)
								{
									$deduct = $deduct - 1;
								}
								$deduct = $deduct/8;


								$sql2 = "UPDATE leavefile SET
									balance = balance - $deduct,
									
									modifiedby = '$userlogin',
									modifieddatetime = now()
									WHERE workerid = '$userid'
									and dataareaid = '$dataareaid'
									and leavetype = '$leavetype'";

										if(mysqli_query($conn,$sql2))
										{
											echo $sql2;
										}
										else
										{
											echo "error".$sql2."<br>".$conn->error;
										}
							

							}
							

					}

					/*$deduct = 1;
					if($Ldaytype == 0)
					{
						$deduct = 1;
					}
					else
					{
						$deduct = $deduct/2;
					}

					$sql2 = "UPDATE leavefile SET
						balance = balance - $deduct,
						
						modifiedby = '$userlogin',
						modifieddatetime = now()
						WHERE workerid = '$userid'
						and dataareaid = '$dataareaid'
						and leavetype = '$leavetype'";

							if(mysqli_query($conn,$sql2))
							{
								echo "Rec Updated";
							}
							else
							{
								echo "error".$sql2."<br>".$conn->error;
							}*/
			}

	 $sql = "UPDATE portalleavefile set status = 0, 

				modifiedby = '$userlogin',
				modifieddatetime = now(),
				approvedby = '$userlogin',
				approvaldatetime = now()
				WHERE leaveid in ($id)
				and dataareaid = '$dataareaid'";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Updated";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: approverviewovertimeform.php');
	
}
?>

<script  type="text/javascript">
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
			    	$('[name=chkbox]:not(:disabled)').prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
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
</script>