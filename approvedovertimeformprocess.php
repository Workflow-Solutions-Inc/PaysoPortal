<?php

session_start();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$logname = $_SESSION["logname"];
$logbio = $_SESSION["logbio"];
$lognum = $_SESSION["lognum"];
include("dbconn.php");

if(isset($_GET["save"])) {
	 
	 $id=$_GET["OTId"];
	 $otdate=$_GET["OTdate"];
	 $otdetails=$_GET["OTdetails"];
	 $otstart=$_GET["OTstart"];
	 $otend=$_GET["OTend"];
	 $othours=$_GET["OThours"];
	 $otminutes=$_GET["OTminutes"];

	 
	 if($id != ""){
	 $sql = "INSERT INTO overtimefile (overtimeid,overtimedate,details,starttime,endtime,hours,minutes,name,workerid,status,dataareaid,createdby,createddatetime)
			values 
			('$id','$otdate','$otdetails','$otstart','$otend','$othours','$otminutes','$logname','$lognum', 0, '$dataareaid', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: approvedovertimeform.php');
	
}
else if(isset($_GET["update"])) {
	 
	 $id=$_GET["OTId"];
	 $otdate=$_GET["OTdate"];
	 $otdetails=$_GET["OTdetails"];
	 $otstart=$_GET["OTstart"];
	 $otend=$_GET["OTend"];
	 $othours=$_GET["OThours"];
	 $otminutes=$_GET["OTminutes"];
	 
	 if($id != ""){
	 $sql = "UPDATE overtimefile SET
				overtimedate = '$otdate',
				details = '$otdetails',
				starttime = '$otstart',
				endtime = '$otend',
				hours = '$othours',
				minutes = '$otminutes',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE overtimeid = '$id'
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
	 
	header('location: approvedovertimeform.php');
	
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
										date_format(approvaldatetime, '%Y-%m-%d') as datefiled,
                                        case when overtimetype = 0 then 'Regular Overtime'
                                        when overtimetype = 1 then 'Special Holiday Overtime'
                                        when overtimetype = 2 then 'Regular Holiday Overtime'
                                        when overtimetype = 3 then 'Sunday Overtime'
                                        end as overtimetypes  
					FROM overtimefile

					where dataareaid = '$dataareaid' and workerid = '$lognum' and (overtimeid like '%$id%') and (name like '%$name%') and (overtimedate like '%$overtimedate%')
					and status != 0
					order by overtimeid";
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
				<td style="width:10%;">'.$row["overtimeid"].'</td>
				<td style="width:14%;">'.$row["name"].'</td>
				<td style="width:10%;">'.$row["overtimedate"].'</td>
				<td style="width:25%;">'.$row["details"].'</td>
				<td style="width:12%;">'.$row["overtimetypes"].'</td>
				<td style="display:none;width:1%;">'.$row["timein"].'</td>
				<td style="display:none;width:1%;">'.$row["timeout"].'</td>
				<td style="width:5%;">'.$row["hours"].'</td>
				<td style="width:5%;">'.$row["minutes"].'</td>
				<td style="width:5%;">'.$row["otstatus"].'</td>
				<td style="width:7%;">'.$row["datefiled"].'</td>
				<td style="display:none;width:1%;">'.$row["starttime"].'</td>
				<td style="display:none;width:1%;">'.$row["endtime"].'</td>
				
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}
else if($_GET["action"]=="add"){
	 $output='';
	 $sequence='';
	 $query = "SELECT * FROM numbersequence where dataareaid = '$dataareaid' and id='overtime'";
	 $result = $conn->query($query);
	 $row = $result->fetch_assoc();
	 $prefix = $row["prefix"];
	 $first = $row["first"];
	 $last = $row["last"];
	 $format = $row["format"];
	 $next = $row["next"];
	 $suffix = $row["suffix"];
	 if($last >= $next)
	 {
	 	$sequence = $prefix.substr($format,0,strlen($next)*-1).$next.$suffix;
	 }
	 else if ($last < $next)
	 {
	 	$sequence = $prefix.$next.$suffix;
	 }
	 $increment=$next+1;
	 $sql = "UPDATE numbersequence SET
				next = '$increment',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE id = 'overtime'
				and dataareaid = '$dataareaid'";
	 //mysqli_query($conn,$sql);	
		if(mysqli_query($conn,$sql))
		{
			$output .= '
				 <input type="text" value="'.$sequence.'" placeholder="Overtime" name ="OTId" id="add-otid" class="modal-textarea" required="required">
				 ';
		}
		else
		{
			$output .= "error".$sql."<br>".$conn->error;
		}
	 
	 
	 echo $output;
	
}
?>

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
</script>