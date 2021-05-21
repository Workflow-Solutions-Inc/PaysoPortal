<?php
session_start();
session_regenerate_id();
$userlogin = $_SESSION["portaluser"];
$dataareaid = $_SESSION["portaldefaultdataareaid"];
$logname = $_SESSION["portallogname"];
$logbio = $_SESSION["portallogbio"];
$lognum = $_SESSION["portallognum"];
include("dbconn.php");


if($_GET["action"]=="refresh"){
	if($_GET["actmode"]=="schedule"){
		$fromdate=$_GET["slocFromdate"];
		$todate=$_GET["slocTodate"];

		$output='';
		//$output .= '<tbody>';
		$query = "SELECT daytype,date,weekday as day,shifttype,TIME_FORMAT(starttime,'%h:%i %p') as starttime,TIME_FORMAT(endtime,'%h:%i %p') as endtime 
					FROM shiftschedule
						where date between '$fromdate' and '$todate'
						and workerid = '$lognum'
						order by date";
		$result = $conn->query($query);
		$rowclass = "rowA";
		$rowcnt = 0;
		while ($row = $result->fetch_assoc())
		{
			$rowcnt++;
				if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
				else { $rowclass = "rowA";}
				$chkr = "";
				$chkr2 = "";
				$chkr3 = "";
				$chkr4 = "";
				if($row['daytype']=="Restday"){
					$chkr = "background-color:#90EE90";
					$chkr2 = "";
					$chkr3 = "";
					$chkr4 = "";
				}else{
					//$chkr = "background-color:#00FF00";
					$chkr2 = $row["shifttype"];
					$chkr3 = $row["starttime"];
					$chkr4 = $row["endtime"];
				}
			$output .= '
			<tr class="'.$rowclass.'" style = "'.$chkr.'">
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:16%;">'.$row["daytype"].'</td>
				<td style="width:16%;">'.$row["date"].'</td>
				<td style="width:16%;">'.$row["day"].'</td>
				<td style="width:16%;">'.$chkr2.'</td>
				<td style="width:16%;">'.$chkr3.'</td>
				<td style="width:16%;">'.$chkr4.'</td>
				
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
	else if($_GET["actmode"]=="attendance"){
		$fromdateAtt=$_GET["slocFromdate"];
		$todateAtt=$_GET["slocTodate"];

		$output2='';
		//$output .= '<tbody>';
		$query2 = "SELECT DATE_FORMAT(mt.date, '%m/%d/%Y') as 'date',

		TIME_FORMAT(min(case when mt.type = 0 then mt.Time else null end),'%h:%i %p') as 'timein',
        TIME_FORMAT(min(case when mt.type = 4 then mt.Time else null end),'%h:%i %p') as 'breakout',
        TIME_FORMAT(max(case when mt.type = 3 then mt.Time else null end),'%h:%i %p') as 'breakin',
		TIME_FORMAT(max(case when mt.type = 1 then mt.Time else null end),'%h:%i %p') as 'timeout',
        mt.Name as bioid
	from monitoringtable mt 
		left join worker wk ON mt.Name = wk.BioId 
		left join payrolldetails pd on wk.workerid = pd.workerid and wk.dataareaid = pd.dataareaid 
		left join payrollheader ph on pd.payrollid = ph.payrollid and wk.dataareaid = ph.dataareaid
	
    where mt.name = '$logbio' and mt.date between '".$fromdateAtt."' and '".$todateAtt."'
	group by mt.date order by mt.date asc";
		$result2 = $conn->query($query2);
		$rowclass = "rowA";
		$rowcnt = 0;
		while ($row2 = $result2->fetch_assoc())
		{
			$rowcnt++;
				if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
				else { $rowclass = "rowA";}
			$output2 .= '
			<tr class="'.$rowclass.'">
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:33%;">'.$row2["date"].'</td>
				<td style="width:33%;">'.$row2["timein"].'</td>
				<td style="width:33%;">'.$row2["breakout"].'</td>
				<td style="width:33%;">'.$row2["breakin"].'</td>
				<td style="width:33%;">'.$row2["timeout"].'</td>
				
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output2;
		//header('location: process.php');
	}
}
