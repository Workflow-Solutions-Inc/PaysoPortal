<?php

session_start();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];

include("dbconn.php");

if($_GET["action"]=="save"){
	if($_GET["actmode"]=="overtime"){
	 
		$id=$_GET["SelectedVal"];
		$otdate=$_GET["locOvertimedate"];
		$otdetails=$_GET["locDetails"];
		$ottype=$_GET["locType"];
		$otstart=$_GET["locStarttime"];
		$otend=$_GET["locEndtime"];
		$othours=$_GET["locHours"];
		$otminutes=$_GET["locMins"];
		$sequence='';
		$checkot='';
		
		if($id != ""){
			$query = "SELECT * FROM worker

						where workerid in ($id)";
			$result = $conn->query($query);
			while ($row = $result->fetch_assoc())
			{
				$userid=$row["workerid"];
				$username=$row["name"];
				$query3 = "SELECT * FROM overtimefile where dataareaid = '$dataareaid' and workerid='$userid' and overtimedate='$otdate'";
					$result3 = $conn->query($query3);
					$row3 = $result3->fetch_assoc();
					$checkot = $row3["overtimeid"];
					if($checkot == '')
					{
						$query2 = "SELECT * FROM numbersequence where dataareaid = '$dataareaid' and id='overtime'";
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
								WHERE id = 'overtime'
								and dataareaid = '$dataareaid'";
						//mysqli_query($conn,$sql);	
						if(mysqli_query($conn,$sql))
						{
							echo "Rec Updated";
							
								$sql2 = "INSERT INTO overtimefile (overtimeid,overtimedate,details,overtimetype,starttime,endtime,hours,minutes,name,workerid,status,dataareaid,createdby,createddatetime)
										values 
									('$sequence','$otdate','$otdetails','$ottype','$otstart','$otend','$othours','$otminutes','$username','$userid', 0, '$dataareaid', '$userlogin', now())";
								if(mysqli_query($conn,$sql2))
								{
									echo "New Rec Created";
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
				
				 
			}

		}
		 
		header('location: userselectionot.php');
	}
}

else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["sLocId"];
		$name=$_GET["slocName"];
		$postion=$_GET["slocPosition"];
		$department=$_GET["sLocDepartment"];
		$branch=$_GET["slocbranch"];
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT wk.workerid,wk.Name,pos.name as 'position',dep.name as 'department',bra.name	as 'branch'

					FROM worker wk
					left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid 
					left join contract con on con.workerid = wk.workerid and con.dataareaid = wk.dataareaid
					left join department dep on dep.departmentid = con.departmentid and dep.dataareaid = wk.dataareaid
					left join branch bra on bra.branchcode = wk.branch and bra.dataareaid = wk.dataareaid
					left join organizationalchart org on org.workerid = wk.workerid and org.dataareaid = wk.dataareaid

					  where (wk.workerid like '%$id%') and (wk.name like '%$name%') and (pos.name like '%$postion%') and (dep.name like '%$department%') and (bra.name like '%$branch%') and wk.dataareaid = '$dataareaid'

					 order by wk.workerid";
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
			
			$output .= '
			<tr id="'.$row["workerid"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'" >
				<td style="width:20px;"><span class="fa fa-angle-right"></span></td>
				<td style="width:5%;"><input type="checkbox" id="chkbox" name="chkbox" class="checkbox"
				 	value="'.$row['workerid'].'" ></td>
				<td style="width:19%;">'.$row["workerid"].'</td>
				<td style="width:19%;">'.$row["Name"].'</td>
				<td style="width:19%;">'.$row["position"].'</td>
				<td style="width:19%;">'.$row["department"].'</td>
				<td style="width:19%;">'.$row["branch"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}

?>

<script  type="text/javascript">
	var so='';
	var locAccName;

		$(document).ready(function(){
		$('#datatbl tbody tr').click(function(){
			//$('table tbody tr').css('background-color','');
			//$(this).css('background-color','#ffe6cb');
			$('table tbody tr').css("color","black");
			$(this).css("color","red");
			$('table tbody tr').removeClass("info");
			$(this).addClass("info");
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			var AcInc = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
			locAccName = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();

			so = usernum.toString();
			document.getElementById("hide").value = so;				  
		});
	});

	//var allVals = [];
	//var uniqueNames = [];
	//var remVals = [];
	//var remValsEx = [];
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