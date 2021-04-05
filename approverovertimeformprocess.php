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
	 $ottype=$_GET["OTtype"];
	 $otstart=$_GET["OTstart"];
	 $otend=$_GET["OTend"];
	 $othours=$_GET["OThours"];
	 $otminutes=$_GET["OTminutes"];
	 $otworker=$_GET["WKId"];

	 $query = "SELECT * FROM worker where dataareaid = '$dataareaid' and workerid='$otworker'";
	 $result = $conn->query($query);
	 $row = $result->fetch_assoc();
	 $wkname = $row["name"];

	 
	 if($id != ""){
	 $sql = "INSERT INTO overtimefile (overtimeid,overtimedate,details,overtimetype,starttime,endtime,hours,minutes,name,workerid,status,dataareaid,createdby,createddatetime)
			values 
			('$id','$otdate','$otdetails','$ottype','$otstart','$otend','$othours','$otminutes','$wkname','$otworker', 0, '$dataareaid', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: approverovertimeform.php');
	
}
else if(isset($_GET["update"])) {
	 
	 $id=$_GET["OTId"];
	 $otdate=$_GET["OTdate"];
	 $otdetails=$_GET["OTdetails"];
	 $ottype=$_GET["OTtype"];
	 $otstart=$_GET["OTstart"];
	 $otend=$_GET["OTend"];
	 $othours=$_GET["OThours"];
	 $otminutes=$_GET["OTminutes"];
	 $otworker=$_GET["WKId"];
	 
	 if($id != ""){
	 $sql = "UPDATE overtimefile SET
				overtimedate = '$otdate',
				details = '$otdetails',
				overtimetype = '$ottype',
				starttime = '$otstart',
				endtime = '$otend',
				hours = '$othours',
				minutes = '$otminutes',
				modifiedby = '$userlogin',
				modifieddatetime = now(),
				approvedby = '$userlogin',
				approvaldatetime = now()
				WHERE overtimeid = '$id'
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
	 
	header('location: approverovertimeform.php');
	
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
		$query = "SELECT *,TIME_FORMAT(ot.starttime,'%h:%i %p') as timein,TIME_FORMAT(ot.endtime,'%h:%i %p') as timeout,
									case when ot.status = 0 then 'Created'
										when ot.status = 1 then 'Approved' 
										when ot.status = 2 then 'Disapproved' 
										when ot.status = 3 then 'Posted' end as otstatus,
										date_format(ot.createddatetime, '%Y-%m-%d') as datefiled,
                                        case when ot.overtimetype = 0 then 'Regular Overtime'
                                        when ot.overtimetype = 1 then 'Special Holiday Overtime'
                                        when ot.overtimetype = 2 then 'Regular Holiday Overtime'
                                        when ot.overtimetype = 3 then 'Sunday Overtime'
                                        when ot.overtimetype = 5 then 'Early Overtime'
                                        end as overtimetypes 

						FROM overtimefile ot
						left join organizationalchart org on org.workerid = ot.workerid and org.dataareaid = ot.dataareaid
					where ot.dataareaid = '$dataareaid'
						and org.repotingid = '$lognum' and (overtimeid like '%$id%') and (name like '%$name%') and (overtimedate like '%$overtimedate%')
					 and status = 0
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
				<td style="width:5%;"><input type="checkbox" id="chkbox" name="chkbox" class="checkbox"
				 	value="'.$row['overtimeid'].'"></td>
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
				<td style="display:none;width:1%;">'.$row["workerid"].'</td>
				<td style="display:none;width:1%;">'.$row["overtimetype"].'</td>
				
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

else if($_GET["action"]=="approve"){
	 
	 
	$id=$_GET["SelectedVal"];
	
	 if($id != ""){
	 $sql = "UPDATE overtimefile set status = 1, 

				modifiedby = '$userlogin',
				modifieddatetime = now(),
				approvedby = '$userlogin',
				approvaldatetime = now()
				WHERE overtimeid in ($id)
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
	 
	header('location: approverovertimeform.php');
	
}
else if($_GET["action"]=="disapprove"){
	 
	 
	$id=$_GET["SelectedVal"];
	
	 if($id != ""){
	 $sql = "UPDATE overtimefile set status = 2, 

				modifiedby = '$userlogin',
				modifieddatetime = now(),
				approvedby = '$userlogin',
				approvaldatetime = now()
				WHERE overtimeid in ($id)
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
	 
	header('location: approverovertimeform.php');
	
}
?>

<script  type="text/javascript">
		var so='';
	  	var locWorkerId = "";
		var locName = "";
		var locOvertimedate = "";
		var locDetails = "";
		var locOvertimetype = "";
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
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locName = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locOvertimedate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locDetails = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				locOvertimetype = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(16)").text();
				locStartTime = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(13)").text();
				locEndTime = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(14)").text();
				locHours = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
				locMinutes = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
				locStatus = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(11)").text();
				locDateFile = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(12)").text();
				locWorkerId = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(15)").text();
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
</script>