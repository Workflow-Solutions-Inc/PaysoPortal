<?php
session_id("protal");
session_start();
session_regenerate_id();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$logname = $_SESSION["logname"];
$logbio = $_SESSION["logbio"];
$lognum = $_SESSION["lognum"];
include("dbconn.php");

if(isset($_GET["save"])) {
	 
	 $id=$_GET["FWId"];
	 $fwdate=$_GET["FWdate"];
	 $fwdetails=$_GET["FWdetails"];
	 $fwstart=$_GET["FWstart"];
	 $fwend=$_GET["FWend"];
	 $fwdaytype=$_GET["FWaytype"];
	 $workersel=$_GET["WKId"];

	 $query = "SELECT * FROM worker where dataareaid = '$dataareaid' and workerid='$workersel'";
	 $result = $conn->query($query);
	 $row = $result->fetch_assoc();
	 $wkname = $row["name"];

	 
	 if($id != ""){
	 $sql = "INSERT INTO portalfieldwork (fieldworkid,fieldworkdate,details,starttime,endtime,daytype,name,workerid,status,dataareaid,createdby,createddatetime)
			values 
			('$id','$fwdate','$fwdetails','$fwstart','$fwend','$fwdaytype','$wkname','$workersel',0, '$dataareaid', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: approverfieldworkform.php');
	
}
else if(isset($_GET["update"])) {
	 
	 $id=$_GET["FWId"];
	 $fwdate=$_GET["FWdate"];
	 $fwdetails=$_GET["FWdetails"];
	 $fwstart=$_GET["FWstart"];
	 $fwend=$_GET["FWend"];
	 $fwdaytype=$_GET["FWaytype"];
	 $workersel=$_GET["WKId"];
	 
	 if($id != ""){
	 $sql = "UPDATE portalfieldwork SET
				fieldworkdate = '$fwdate',
				details = '$fwdetails',
				starttime = '$fwstart',
				endtime = '$fwend',
				daytype = '$fwdaytype',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE fieldworkid = '$id'
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
	 
	header('location: approverfieldworkform.php');
	
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
		header('location: approverfieldworkform.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["slocFieldId"];
		$name=$_GET["slocName"];
		$fielddatedate=$_GET["slocFieldDate"];
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT *,TIME_FORMAT(pf.starttime,'%h:%i %p') as timein,TIME_FORMAT(pf.endtime,'%h:%i %p') as timeout,
									case when pf.status = 0 then 'Created'
										when pf.status = 1 then 'Approved' 
										when pf.status = 2 then 'Disapproved' 
										when pf.status = 3 then 'Posted' end as otstatus,
									case when pf.daytype = 0 then 'Whole Day'
										when pf.daytype = 1 then 'Half Day' end as daytypes,
										date_format(pf.createddatetime, '%Y-%m-%d') as datefiled

									FROM portalfieldwork pf
									left join organizationalchart org on org.workerid = pf.workerid and org.dataareaid = pf.dataareaid
									where pf.dataareaid = '$dataareaid' and org.repotingid = '$lognum'
									
									 and (pf.fieldworkid like '%$id%') and (pf.name like '%$name%') and (pf.fieldworkdate like '%$fielddatedate%')
										and pf.status = 0
									order by pf.fieldworkid";
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
				 	value="'.$row['fieldworkid'].'"></td>
				<td style="width:10%;">'.$row["fieldworkid"].'</td>
				<td style="width:14%;">'.$row["name"].'</td>
				<td style="width:10%;">'.$row["fieldworkdate"].'</td>
				<td style="width:25%;">'.$row["details"].'</td>
				<td style="width:7%;">'.$row["timein"].'</td>
				<td style="width:7%;">'.$row["timeout"].'</td>

				<td style="width:5%;">'.$row["daytypes"].'</td>
				<td style="width:7%;">'.$row["otstatus"].'</td>
				<td style="width:10%;">'.$row["datefiled"].'</td>
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
else if($_GET["action"]=="add"){
	 $output='';
	 $sequence='';
	 $query = "SELECT * FROM numbersequence where dataareaid = '$dataareaid' and id='fieldwork'";
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
				WHERE id = 'fieldwork'
				and dataareaid = '$dataareaid'";
	 //mysqli_query($conn,$sql);	
		if(mysqli_query($conn,$sql))
		{
			$output .= '
				 <input type="text" value="'.$sequence.'" placeholder="Overtime" name ="FWId" id="add-fwid" class="modal-textarea" required="required">
				 ';
		}
		else
		{
			$output .= "error".$sql."<br>".$conn->error;
		}
	 
	 
	 echo $output;
	
}
else if($_GET["action"]=="approve"){
	 
	 
	$id=$_GET["SelectedVal"];
	
	 if($id != ""){
	 $sql = "UPDATE portalfieldwork set status = 1, 

				modifiedby = '$userlogin',
				modifieddatetime = now(),
				approvedby = '$userlogin',
				approvaldatetime = now()
				WHERE fieldworkid in ($id)
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
	 
	header('location: approverfieldworkform.php');
	
}
else if($_GET["action"]=="disapprove"){
	 
	 
	$id=$_GET["SelectedVal"];
	
	 if($id != ""){
	 $sql = "UPDATE portalfieldwork set status = 2, 

				modifiedby = '$userlogin',
				modifieddatetime = now(),
				approvedby = '$userlogin',
				approvaldatetime = now()
				WHERE fieldworkid in ($id)
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
	 
	header('location: approverfieldworkform.php');
	
}
?>

<script  type="text/javascript">
		var so='';
	  	//var locWorkerId = "";
		var locName = "";
		var locFieldDate = "";
		var locDetails = "";
		var locStartTime = "";
		var locEndTime = "";
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
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locName = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locFieldDate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locDetails = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				locStartTime = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(11)").text();
				locEndTime = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(12)").text();
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
</script>