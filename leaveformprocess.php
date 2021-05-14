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
	 
	 $id=$_GET["OTId"];
	 $otfromdate=$_GET["OTfromdate"];
	 $ottodate=$_GET["OTtodate"];
	 $otdetails=$_GET["OTdetails"];
	 $otstart=$_GET["OTstart"];
	 $otend=$_GET["OTend"];
	 $otleavetype=$_GET["OTleavetype"];
	 $otdaytype=$_GET["OTdaytype"];
	 $paid=$_GET["lpaid"];
	 $ldays=$_GET["ldays"];
	 $lcredit=$_GET["lcredit"];
	 //$lcredit=14;
	 
	 echo "credit=".$lcredit."<br>";
	 if($ldays > $lcredit)
	 {
	 	$lcredit=$lcredit-1;
	 	$ottodate = date ("Y-m-d", strtotime("+".$lcredit." days", strtotime($otfromdate)));
	 }
	
	 

	 while (strtotime($otfromdate) <= strtotime($ottodate)) {
	    echo $otfromdate."</br>";
	    

	    if($id != ""){
	

		 $query2 = "SELECT * FROM numbersequence where dataareaid = '$dataareaid' and id='leave'";
						$result2 = $conn->query($query2);
						$row2 = $result2->fetch_assoc();
						$prefix = $row2["prefix"];
						$first = $row2["first"];
						$last = $row2["last"];
						$format = $row2["format"];
						$next = $row2["next"];
						$suffix = $row2["suffix"];
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
								WHERE id = 'leave'
								and dataareaid = '$dataareaid'";
						//mysqli_query($conn,$sql);	
						if(mysqli_query($conn,$sql))
						{
							//echo "Rec Updated";
							
								$sql2 = "INSERT INTO portalleavefile (leaveid,leavedate,details,starttime,endtime,leavetype,daytype,name,workerid,status,dataareaid,createdby,createddatetime)
										values 
										('$sequence','$otfromdate','$otdetails','$otstart','$otend','$otleavetype','$otdaytype','$logname','$lognum',0, '$dataareaid', '$userlogin', now())";
								if(mysqli_query($conn,$sql2))
								{
									//echo $sql2;
									$starttimestamp = strtotime($otstart);
									$endtimestamp = strtotime($otend);
									$deduct = abs($endtimestamp - $starttimestamp)/3600;
									if($deduct >= 9)
									{
										$deduct = $deduct - 1;
									}
									$deduct = $deduct/8;
									if($paid == "true")
									{
										$sql2 = "UPDATE leavefile SET
											balance = balance - $deduct,
											
											modifiedby = '$userlogin',
											modifieddatetime = now()
											WHERE workerid = '$lognum'
											and dataareaid = '$dataareaid'
											and leavetype = '$otleavetype'";

												if(mysqli_query($conn,$sql2))
												{
													echo "Rec Updated";
												}
												else
												{
													echo "error".$sql2."<br>".$conn->error;
												}
									}
								}
								else
								{
									echo "error".$sql2."<br>".$conn->error;
								}
							

							 
						}
						else
						{
							echo "error".$sql."<br>".$conn->error;
						}
			
		}
		$otfromdate = date ("Y-m-d", strtotime("+1 days", strtotime($otfromdate)));
	}

	 
	/* if($id != ""){
	 $sql = "INSERT INTO portalleavefile (leaveid,leavedate,details,starttime,endtime,leavetype,daytype,name,workerid,status,dataareaid,createdby,createddatetime)
			values 
			('$id','$otdate','$otdetails','$otstart','$otend','$otleavetype','$otdaytype','$logname','$lognum',0, '$dataareaid', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
			

			$starttimestamp = strtotime($otstart);
			$endtimestamp = strtotime($otend);
			$deduct = abs($endtimestamp - $starttimestamp)/3600;
			if($deduct >= 9)
			{
				$deduct = $deduct - 1;
			}
			$deduct = $deduct/8;
			if($paid == "true")
			{
				$sql2 = "UPDATE leavefile SET
					balance = balance - $deduct,
					
					modifiedby = '$userlogin',
					modifieddatetime = now()
					WHERE workerid = '$lognum'
					and dataareaid = '$dataareaid'
					and leavetype = '$otleavetype'";

						if(mysqli_query($conn,$sql2))
						{
							echo "Rec Updated";
						}
						else
						{
							echo "error".$sql2."<br>".$conn->error;
						}
			}

			
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }*/
	//echo $minutes = $otstart->diff($otend);
	 
	//echo $difference/8;
	header('location: leaveform.php');
	
}
else if(isset($_GET["update"])) {
	 
	 $id=$_GET["OTId"];
	 $otfromdate=$_GET["OTfromdate"];
	 $otdetails=$_GET["OTdetails"];
	 $otstart=$_GET["OTstart"];
	 $otend=$_GET["OTend"];
	 $otleavetype=$_GET["OTleavetype"];
	 $otdaytype=$_GET["OTdaytype"];
	 
	 if($id != ""){

	 	$query = "SELECT * FROM leavefile lf left join portalleavefile pl on lf.leavetype = pl.leavetype and lf.dataareaid = pl.dataareaid and lf.workerid = pl.workerid
					where leaveid = '$id'";
			$result = $conn->query($query);
			while ($row = $result->fetch_assoc())
			{

				$userid=$row["workerid"];
				$leaveid=$row["leaveid"];
				$leavetype=$row["leavetype"];
				$Ldaytype = $row['daytype'];

				$otstart2 = $row['starttime'];
				$otend2 = $row['endtime'];

				$paid = $row['ispaid'];

			}

			$starttimestamp2 = strtotime($otstart2);
			$endtimestamp2 = strtotime($otend2);
			$deduction = abs($endtimestamp2 - $starttimestamp2)/3600;
			if($deduction >= 9)
			{
				$deduction = $deduction - 1;
			}
			$deduction = $deduction/8;
			//echo  $deduction;

			$sql3 = "UPDATE leavefile lf2 SET
				lf2.balance = lf2.balance + $deduction,
				
				lf2.modifiedby = '$userlogin',
				lf2.modifieddatetime = now()
				WHERE lf2.workerid = '$userid'
				and lf2.dataareaid = '$dataareaid'
				and lf2.leavetype = '$leavetype'";

					if(mysqli_query($conn,$sql3))
					{
						echo $sql3."</br>";
					}
					else
					{
						echo "error".$sql3."<br>".$conn->error;
					}

			$sql = "UPDATE portalleavefile SET
				leavedate = '$otfromdate',
				details = '$otdetails',
				starttime = '$otstart',
				endtime = '$otend',
				leavetype = '$otleavetype',
				daytype = '$otdaytype',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE leaveid = '$id'
				and dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Updated";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

			

			$starttimestamp = strtotime($otstart);
			$endtimestamp = strtotime($otend);
			$deduct = abs($endtimestamp - $starttimestamp)/3600;
			if($deduct >= 9)
			{
				$deduct = $deduct - 1;
			}
			$deduct = $deduct/8;

			//echo "<br>".$deduct."<br>".$paid;

			if($paid == "1")
			{
				$sql2 = "UPDATE leavefile lf SET
					lf.balance = lf.balance - $deduct,
					
					lf.modifiedby = '$userlogin',
					lf.modifieddatetime = now()
					WHERE lf.workerid = '$lognum'
					and lf.dataareaid = '$dataareaid'
					and lf.leavetype = '$otleavetype'";

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
	 
	header('location: leaveform.php');
	
}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["NumId"];

		if($id != ""){

			$query = "SELECT * FROM portalleavefile

						where leaveid = '$id'";
			$result = $conn->query($query);
			while ($row = $result->fetch_assoc())
			{

				$userid=$row["workerid"];
				$leaveid=$row["leaveid"];
				$leavetype=$row["leavetype"];
				$Ldaytype = $row['daytype'];

				$otstart = $row['starttime'];
				$otend = $row['endtime'];
				
				

					$starttimestamp = strtotime($otstart);
					$endtimestamp = strtotime($otend);
					$deduct = abs($endtimestamp - $starttimestamp)/3600;
					if($deduct >= 9)
					{
						$deduct = $deduct - 1;
					}
					$deduct = $deduct/8;


					$sql2 = "UPDATE leavefile SET
						balance = balance + $deduct,
						
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
							}
			}


			$sql = "DELETE from portalleavefile where leaveid = '$id'";
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
										date_format(createddatetime, '%Y-%m-%d') as datefiled

									FROM portalleavefile where dataareaid = '$dataareaid'
									 and workerid = '$lognum' and (leaveid like '%$id%') and (name like '%$name%') and (leavedate like '%$overtimedate%')
										and status = 0
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
				<td style="width:10%;">'.$row["leaveid"].'</td>
				<td style="width:14%;">'.$row["name"].'</td>
				<td style="width:10%;">'.$row["leavedate"].'</td>
				<td style="width:25%;">'.$row["details"].'</td>
				<td style="width:7%;">'.$row["timein"].'</td>
				<td style="width:7%;">'.$row["timeout"].'</td>
				<td style="width:5%;">'.$row["leavetype"].'</td>
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
	 $query = "SELECT * FROM numbersequence where dataareaid = '$dataareaid' and id='leave'";
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
	 /*$increment=$next+1;
	 $sql = "UPDATE numbersequence SET
				next = '$increment',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE id = 'leave'
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
		}*/
	 
	 $output .= '
				 <input type="text" value="'.$sequence.'" placeholder="Overtime" name ="OTId" id="add-otid" class="modal-textarea" required="required">
				 ';
	 echo $output;
	
}

else if($_GET["action"]=="filterleave"){
	 $output='';
	 $wkvl=0;
	 $ispaid=0;
	 $cntdays=0;
	 $deduct = 0;
	 $ldeduct=0;
	 $paidleave='false';
	 /*if($_GET["OTstart"] !='' && $_GET["OTend"] != '')
	 {
	 	$otstart=$_GET["OTstart"];
		$otend=$_GET["OTend"];

		 $starttimestamp = strtotime($otstart);
			$endtimestamp = strtotime($otend);
			$deduct = abs($endtimestamp - $starttimestamp)/3600;
			if($deduct >= 9)
			{
				$deduct = $deduct - 1;
			}
			$deduct = $deduct/8;
	 }*/

	 
	 if($_GET["ldate"] != '')
	 {
	 	$leavedate = $_GET["ldate"];
	 	$leavetodate = $_GET["ltodate"];
	 	$leavedifdate = $leavedate;
	 	while (strtotime($leavedifdate) <= strtotime($leavetodate)) {
	 	
	    //echo $leavedifdate."</br>";
	    $leavedifdate = date ("Y-m-d", strtotime("+1 days", strtotime($leavedifdate)));
	    $cntdays=$cntdays+1;
	    //$ldeduct=$ldeduct+$deduct;
	   // echo $cntdays;


		}
	 }
	 else
	 {
	 	$leavedate = date("Y-m-d");
	 }

	 $leavefilter=$_GET["lfilter"];

	 
	 if($cntdays > 1)
	 {
	 	$query2 = "SELECT format(balance,0) balance,ispaid FROM leavefile 
		where workerid = '$lognum' and dataareaid = '$dataareaid' and leavetype = '$leavefilter' and  (fromdate <= '$leavedate' and todate >= '$leavedate')";
	 }
	 else
	 {
	 	 $query2 = "SELECT format(balance,4) balance,ispaid FROM leavefile 
		where workerid = '$lognum' and dataareaid = '$dataareaid' and leavetype = '$leavefilter' and  (fromdate <= '$leavedate' and todate >= '$leavedate')";
	 }
	 

	

		$result2 = $conn->query($query2);
		while ($row2 = $result2->fetch_assoc())
		{ 
				

				$wkvl = $row2['balance'];
				$ispaid = $row2['ispaid'];
				

		}

		
		if($ispaid == 1)
		{
			$paidleave = "true";
		}
		else
		{
			$paidleave = "false";
		}


		$output .= '
				 <input type="input" value="'.$wkvl.'"  name ="lcredit" id="add-lcredit" class="modal-textarea">
				 <input type="input" value="'.$paidleave.'" name ="lpaid" id="add-lpaid" class="modal-textarea">
				 <input type="input" value="'.$cntdays.'" name ="ldays" id="add-ldays" class="modal-textarea">
				 
				 ';
				 //<input type="input" value="'.$ldeduct.'" name ="lded" id="add-lded" class="modal-textarea">
	
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