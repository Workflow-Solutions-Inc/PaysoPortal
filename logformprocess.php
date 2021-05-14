<?php
session_start();
session_regenerate_id();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$logname = $_SESSION["logname"];
$logbio = $_SESSION["logbio"];
$lognum = $_SESSION["lognum"];
include("dbconn.php");

if(isset($_GET["save"])) {
	 
	 $id=$_GET["LCId"];
	 $lcdate=$_GET["LCdate"];
	 $lcdetails=$_GET["LCdetails"];
	 $lctime=$_GET["LCtime"];
	 $lctype=$_GET["LCytype"];


	 
	 if($id != ""){
	 $sql = "INSERT INTO logcorrection (logid,invaliddate,details,logtime,logtype,name,workerid,status,dataareaid,createdby,createddatetime)
			values 
			('$id','$lcdate','$lcdetails','$lctime','$lctype','$logname','$lognum',0, '$dataareaid', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: logform.php');
	
}
else if(isset($_GET["update"])) {
	 
	 $id=$_GET["LCId"];
	 $lcdate=$_GET["LCdate"];
	 $lcdetails=$_GET["LCdetails"];
	 $lctime=$_GET["LCtime"];
	 $lctype=$_GET["LCytype"];
	 
	 if($id != ""){
	 $sql = "UPDATE logcorrection SET
				invaliddate = '$lcdate',
				details = '$lcdetails',
				logtime = '$lctime',
				logtype = '$lctype',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE logid = '$id'
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
	 
	header('location: logform.php');
	
}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["NumId"];

		if($id != ""){
			$sql = "DELETE from logcorrection where logid = '$id'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: logform.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["sloclogid"];
		$name=$_GET["slocName"];
		$invaliddate=$_GET["slocinvaliddate"];
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT *,TIME_FORMAT(logtime,'%h:%i %p') as logtimes,
									case when status = 0 then 'Created'
										when status = 1 then 'Approved' 
										when status = 2 then 'Disapproved' 
										when status = 3 then 'Posted' end as otstatus,
									case when logtype = 0 then 'Time In'
										when logtype = 1 then 'Time Out' 
										when logtype = 3 then 'Break Out' 
										when logtype = 4 then 'Break In'
										end as logtypes,
										date_format(createddatetime, '%Y-%m-%d') as datefiled

									FROM logcorrection where dataareaid = '$dataareaid'
									 and workerid = '$lognum' and (logid like '%$id%') and (name like '%$name%') and (invaliddate like '%$invaliddate%')
										and status = 0
									order by logid";
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
				<td style="width:10%;">'.$row["logid"].'</td>
				<td style="width:14%;">'.$row["name"].'</td>
				<td style="width:10%;">'.$row["invaliddate"].'</td>
				<td style="width:25%;">'.$row["details"].'</td>
				<td style="width:7%;">'.$row["logtimes"].'</td>


				<td style="width:5%;">'.$row["logtypes"].'</td>
				<td style="width:7%;">'.$row["otstatus"].'</td>
				<td style="width:10%;">'.$row["datefiled"].'</td>
				<td style="display:none;width:1%;">'.$row["logtime"].'</td>
				<td style="display:none;width:1%;">'.$row["logtype"].'</td>

				
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
	 $query = "SELECT * FROM numbersequence where dataareaid = '$dataareaid' and id='log'";
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
				WHERE id = 'log'
				and dataareaid = '$dataareaid'";
	 //mysqli_query($conn,$sql);	
		if(mysqli_query($conn,$sql))
		{
			$output .= '
				 <input type="text" value="'.$sequence.'" placeholder="Overtime" name ="LCId" id="add-lcid" class="modal-textarea" required="required">
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