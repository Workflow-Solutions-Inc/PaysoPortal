<?php
session_start();
session_regenerate_id();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$logname = $_SESSION["logname"];
$logbio = $_SESSION["logbio"];
$lognum = $_SESSION["lognum"];
include("dbconn.php");


if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["sLocId"];
		$name=$_GET["slocName"];
		$postion=$_GET["slocPosition"];
		$department=$_GET["sLocDepartment"];
		$branch=$_GET["slocbranch"];

		$output='';
		//$output .= '<tbody>';
		$query = "SELECT wk.workerid,wk.Name,pos.name as 'position',dep.name as 'department',bra.name	as 'branch',
																format(wk.serviceincentiveleave,2) as serviceincentiveleave,
																format(wk.birthdayleave,2) as birthdayleave,wk.birdeclared,
																lastname,firstname,middlename,STR_TO_DATE(birthdate, '%Y-%m-%d') birthdate,STR_TO_DATE(regularizationdate, '%Y-%m-%d') regularizationdate,STR_TO_DATE(inactivedate, '%Y-%m-%d') inactivedate,bankaccountnum,address,contactnum
																,STR_TO_DATE(datehired, '%Y-%m-%d') as datehired,phnum,pagibignum,tinnum,sssnum
																,case when wk.employmentstatus = 0 then 'Regular' 
																when wk.employmentstatus = 1 then 'Reliever'
																when wk.employmentstatus = 2 then 'Probationary'
																when wk.employmentstatus = 3 then 'Contractual' 
																when wk.employmentstatus = 4 then 'Trainee' else '' end as employmentstatus
																,wk.employmentstatus as employmentstatusid
																,wk.inactive
																,wk.bioid
																,DATE_SUB(curdate(), INTERVAL 50 DAY) getfromdate
																,DATE_ADD(curdate(), INTERVAL 50 DAY) gettodate

					FROM worker wk
					left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid 
					left join contract con on con.workerid = wk.workerid and con.dataareaid = wk.dataareaid
					left join ratehistory rt on con.contractid = rt.contractid and con.dataareaid = rt.dataareaid 
					left join department dep on dep.departmentid = con.departmentid and dep.dataareaid = wk.dataareaid
					left join branch bra on bra.branchcode = wk.branch and bra.dataareaid = wk.dataareaid
					left join organizationalchart org on org.workerid = wk.workerid and org.dataareaid = wk.dataareaid

					 where (wk.workerid like '%$id%') and (wk.name like '%$name%') and (pos.name like '%$postion%') and (dep.name like '%$department%') and (bra.name like '%$branch%') and rt.status = 1 
					 and wk.dataareaid = '$dataareaid' and org.repotingid = '$lognum'


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
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:19%;">'.$row["workerid"].'</td>
				<td style="width:19%;">'.$row["Name"].'</td>
				<td style="width:19%;">'.$row["position"].'</td>
				<td style="width:19%;">'.$row["department"].'</td>
				<td style="width:19%;">'.$row["branch"].'</td>
				<td style="display:none;width:1%;"><input type="checkbox" name="chkbox" class="checkbox" value="true"'.($row["birdeclared"]==1 ? "checked" : "").' onclick="return false;"><div style="visibility:hidden;height: 1px;">'.$row["birdeclared"].'</div></td>
				<td style="display:none;width:1%;">'.$row['firstname'].'</td>
				<td style="display:none;width:1%;">'.$row['middlename'].'</td>
				<td style="display:none;width:1%;">'.$row['lastname'].'</td>
				<td style="display:none;width:1%;">'.$row['birthdate'].'</td>
				<td style="display:none;width:1%;">'.$row['inactivedate'].'</td>
				<td style="display:none;width:1%;">'.$row['regularizationdate'].'</td>
				<td style="display:none;width:1%;">'.$row['bankaccountnum'].'</td>
				<td style="display:none;width:1%;">'.$row['address'].'</td>
				<td style="display:none;width:1%;">'.$row['contactnum'].'</td>
				<td style="display:none;width:1%;">'.$row['datehired'].'</td>
				<td style="display:none;width:1%;">'.$row['phnum'].'</td>
				<td style="display:none;width:1%;">'.$row['pagibignum'].'</td>
				<td style="display:none;width:1%;">'.$row['tinnum'].'</td>
				<td style="display:none;width:1%;">'.$row['sssnum'].'</td>
				<td style="display:none;width:1%;">'.$row['employmentstatus'].'</td>
				<td style="display:none;width:1%;">'.$row['inactive'].'</td>
				<td style="display:none;width:1%;">'.$row['bioid'].'</td>
				<td style="display:none;width:1%;">'.$row['getfromdate'].'</td>
				<td style="display:none;width:1%;">'.$row['gettodate'].'</td>
				</tr>';
		}
		//$output .= '</tbody>';
		echo $output;

		$result2 = $conn->query($query);
		$row2 = $result2->fetch_assoc();
		$fdate = $row2["getfromdate"];
		$tdate = $row2["gettodate"];
		$wkid = $row2["workerid"];
		$bid = $row2["bioid"];
		echo $output2 = '<tr class="rowA">
							<td hidden><input type="input" id="hide3" value="'.$fdate.'"></td>
							<td hidden><input type="input" id="hide4" value="'.$tdate.'"></td>
							<td hidden><input type="input" id="hide5" value="'.$wkid.'"></td>
							<td hidden><input type="input" id="hide6" value="'.$bid.'"></td>
						</tr>';
		//header('location: process.php');
	}
}
	
?>
<script  type="text/javascript">
		/*var so='';
		var locbioid='';
		var locFromdate = '';
		var locTodate = '';
		var slocFromdate = '';
		var slocTodate = '';*/
		$(document).ready(function(){
		$('#datatbl tbody tr').click(function(){
			$('table tbody tr').css("color","black");
			$(this).css("color","red");
			$('table tbody tr').removeClass("info");
			$(this).addClass("info");
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
			locbioid = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(23)").text();
			locFromdate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(24)").text();
			locTodate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(25)").text();

			so = usernum.toString();
			document.getElementById("hide").value = so;
			document.getElementById("hide2").value = locbioid.toString();

			/*var today = new Date();
			today.setDate(today.getDate() - 30);
			var dd = String(today.getDate()).padStart(2, '0');
			var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
			var yyyy = today.getFullYear();
			today = mm + '/' + dd + '/' + yyyy;*/

			//$('#add-schedfromdate').val(today.toString());
			//today.setDate(today.getDate() - 30);
			
			//slocFromdate = today.toString();
			//slocTodate = today.toString();
			document.getElementById("add-schedfromdate").value = '';
			document.getElementById("add-schedtodate").value =  '';
			slocFromdate=locFromdate;
			//
			slocTodate=locTodate;
			//alert(slocFromdate);
			//alert(slocTodate);
			//document.getElementById("add-schedtodate").value = today;
			RefreshSched();
			
				  
				});
			});

</script>