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
	 
	 $id=$_GET["LCId"];
	 $lcdate=$_GET["LCdate"];
	 $lcdetails=$_GET["LCdetails"];
	 $lctime=$_GET["LCtime"];
	 $lctype=$_GET["LCytype"];
	 $workersel=$_GET["WKId"];

	 $query = "SELECT * FROM worker where dataareaid = '$dataareaid' and workerid='$workersel'";
	 $result = $conn->query($query);
	 $row = $result->fetch_assoc();
	 $wkname = $row["name"];
	 
	 if($id != ""){
	 $sql = "INSERT INTO logcorrection (logid,invaliddate,details,logtime,logtype,name,workerid,status,dataareaid,createdby,createddatetime)
			values 
			('$id','$lcdate','$lcdetails','$lctime','$lctype','$wkname','$workersel',0, '$dataareaid', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: approverlogform.php');
	
}
else if(isset($_GET["update"])) {
	 
	 $id=$_GET["LCId"];
	 $lcdate=$_GET["LCdate"];
	 $lcdetails=$_GET["LCdetails"];
	 $lctime=$_GET["LCtime"];
	 $lctype=$_GET["LCytype"];
	 $workersel=$_GET["WKId"];
	 
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
	 
	header('location: approverlogform.php');
	
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
		$id=$_GET["sloclogid"];
		$name=$_GET["slocName"];
		$invaliddate=$_GET["slocinvaliddate"];
		$output='';
		//$output .= '<tbody>';
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
										date_format(lc.createddatetime, '%Y-%m-%d') as datefiled

									FROM logcorrection lc
									left join organizationalchart org on org.workerid = lc.workerid and org.dataareaid = lc.dataareaid

									where lc.dataareaid = '$dataareaid'
									 and (lc.logid like '%$id%') and (lc.name like '%$name%') and (lc.invaliddate like '%$invaliddate%')
										and lc.status = 0
										and org.repotingid = '$lognum'
									order by lc.logid";
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
				 	value="'.$row['logid'].'"></td>
				<td style="width:10%;">'.$row["logid"].'</td>
				<td style="width:15%;">'.$row["name"].'</td>
				<td style="width:11%;">'.$row["invaliddate"].'</td>
				<td style="width:27%;">'.$row["details"].'</td>
				<td style="width:8%;">'.$row["logtimes"].'</td>


				<td style="width:6%;">'.$row["logtypes"].'</td>
				<td style="width:8%;">'.$row["otstatus"].'</td>
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

else if($_GET["action"]=="approve"){
	 
	 
	$id=$_GET["SelectedVal"];
	
	 if($id != ""){
	 $sql = "UPDATE logcorrection set status = 1, 

				modifiedby = '$userlogin',
				modifieddatetime = now(),
				approvedby = '$userlogin',
				approvaldatetime = now()
				WHERE logid in ($id)
				and dataareaid = '$dataareaid'";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Updated";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

		$sql2 = "insert into consolidationtable (Date,bioid,time,type,dataareaid)
				SELECT log.invaliddate,wk.bioid,Time_Format(log.logtime,'%H:%i:%s') as  'logTime',log.logtype,log.dataareaid  FROM logcorrection log
                left join worker wk on
				log.workerid = wk.workerid and
				log.dataareaid = wk.dataareaid
				where log.logid in ($id) ";
		if(mysqli_query($conn,$sql2))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql2."<br>".$conn->error;
		}

	 }
	 
	header('location: approverlogform.php');
	
}
else if($_GET["action"]=="disapprove"){
	 
	 
	$id=$_GET["SelectedVal"];
	
	 if($id != ""){
	 $sql = "UPDATE logcorrection set status = 2, 

				modifiedby = '$userlogin',
				modifieddatetime = now(),
				approvedby = '$userlogin',
				approvaldatetime = now()
				WHERE logid in ($id)
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
	 
	header('location: approverlogform.php');
	
}
?>

<script  type="text/javascript">
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
</script>