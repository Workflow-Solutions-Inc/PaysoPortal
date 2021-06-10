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
		$locworker=$_GET["slocworker"];
		$locbioid=$_GET["slocbio"];

		$output='';
		//$output .= '<tbody>';
		$query = "SELECT daytype,date,weekday as day,shifttype,TIME_FORMAT(starttime,'%h:%i %p') as starttime,TIME_FORMAT(endtime,'%h:%i %p') as endtime 
					FROM shiftschedule
						where date between '$fromdate' and '$todate'
						and workerid = '$locworker'
						and dataareaid = '$dataareaid'
						order by date";
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
				<td style="width:20%;">'.$row["daytype"].'</td>
				<td style="width:20%;">'.$row["date"].'</td>
				<td style="width:20%;">'.$row["day"].'</td>
				<td style="width:20%;">'.$row["shifttype"].'</td>
				<td style="width:20%;">'.$row["starttime"].'</td>
				<td style="width:20%;">'.$row["endtime"].'</td>
				
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
	else if($_GET["actmode"]=="attendance"){
		$fromdateAtt=$_GET["slocFromdate"];
		$todateAtt=$_GET["slocTodate"];
		$locworker=$_GET["slocworker"];
		$locbioid=$_GET["slocbio"];
		$output2='';
		//$output .= '<tbody>';
		/*$query2 = "SELECT consol.date,TIME_FORMAT(intbl.timein,'%h:%i %p') as timein,TIME_FORMAT(outtbl.timeout,'%h:%i %p') as timeout,consol.bioid
					FROM 
						consolidationtable consol
						left join (select date,MAX(time) as timeout,bioid,type from consolidationtable where type = 1
						group by date,bioid,type) outtbl on consol.BioId = outtbl.bioid and consol.Date = outtbl.date

						left join (select date,MIN(time) as timein,bioid,type from consolidationtable where type = 0
						group by date,bioid,type) intbl on consol.BioId = intbl.bioid and consol.Date = intbl.date

						where consol.bioid = '$locbioid' and consol.date between '$fromdateAtt' and '$todateAtt'

						group by consol.date,consol.bioid";*/

		$query2 = "SELECT DATE_FORMAT(mt.date, '%m/%d/%Y') as 'date',DATE_FORMAT(mt.date,'%W') as weekday,
								TIME_FORMAT(min(case when mt.type = 0 then mt.Time else null end),'%h:%i %p') as 'timein',
						        TIME_FORMAT(min(case when mt.type = 3 then mt.Time else null end),'%h:%i %p') as 'breakout',
						        TIME_FORMAT(max(case when mt.type = 4 then mt.Time else null end),'%h:%i %p') as 'breakin',
								TIME_FORMAT(max(case when mt.type = 1 then mt.Time else null end),'%h:%i %p') as 'timeout',  
						        mt.Name as bioid
							from monitoringtable mt 
								left join worker wk ON mt.Name = wk.BioId 
								
							
						    where mt.name = '$locbioid' and mt.date between '$fromdateAtt' and '$todateAtt'
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
				<td style="width:33%;">'.$row2["weekday"].'</td>
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
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["sLocId"];
		$name=$_GET["slocName"];
		$postion=$_GET["slocPosition"];

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
																,DATE_SUB(curdate(), INTERVAL 0 DAY) getfromdate
																,DATE_ADD(curdate(), INTERVAL 0 DAY) gettodate

					FROM worker wk
					left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid 
					left join contract con on con.workerid = wk.workerid and con.dataareaid = wk.dataareaid
					left join department dep on dep.departmentid = con.departmentid and dep.dataareaid = wk.dataareaid
					left join branch bra on bra.branchcode = wk.branch and bra.dataareaid = wk.dataareaid
					left join organizationalchart org on org.workerid = wk.workerid and org.dataareaid = wk.dataareaid

					 where (wk.workerid like '%$id%') and (wk.name like '%$name%') and (pos.name like '%$postion%') and wk.dataareaid = '$dataareaid'
					 and wk.inactive = 0
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
				<td style="width:25%;">'.$row["workerid"].'</td>
				<td style="width:25%;">'.$row["Name"].'</td>
				<td style="width:25%;">'.$row["position"].'</td>
				<td style="width:25%;">'.$row["department"].'</td>
				<td style="width:25%;">'.$row["branch"].'</td>
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
		//header('location: process.php');
	}
}

else if($_GET["action"]=="refreshatt"){
	if($_GET["actmode"]=="lateatt"){
		$fromdatelte=$_GET["slocFromdate"];
		$todatelte=$_GET["slocTodate"];
		$locworker=$_GET["slocworker"];
		$locbioid=$_GET["slocbio"];

		$output='';
		//$output .= '<tbody>';
		/*$query = "SELECT ss.date,TIME_FORMAT(starttime,'%h:%i %p') as starttime,TIME_FORMAT(endtime,'%h:%i %p') as endtime,ss.workerid,wk.BioId,cons.timein,cons.timeout
						,case when TIME_TO_SEC(SUBTIME(TIME_FORMAT(cons.timein,'%H:%i'),TIME_FORMAT(ss.starttime, '%H:%i'))) > TIME_TO_SEC(CONVERT('00:00:00', TIME)) then
										TIME_TO_SEC(SUBTIME(TIME_FORMAT(cons.timein,'%H:%i'),TIME_FORMAT(ss.starttime, '%H:%i'))) / 60
								end as late
						,case when TIME_TO_SEC(SUBTIME(TIME_FORMAT(cons.timein,'%H:%i'),TIME_FORMAT(ss.starttime, '%H:%i'))) > TIME_TO_SEC(CONVERT('00:00:00', TIME)) 
				        then 1 end as latecount,
				        case when ifnull(cons.timein,0) then 1 else 0 end as daywork,
						case when ifnull(cons.timein,0) then 0 else 1 end as absent,
						1 as attcount
						
						FROM shiftschedule ss 

						left join worker wk on ss.workerid = wk.workerid AND ss.dataareaid = wk.dataareaid

						left join (SELECT consol.date,consol.bioid,intbl.timein,outtbl.timeout FROM 

						consolidationtable consol
						left join (select date,MAX(time) as timeout,bioid,type from consolidationtable where type = 1 #and bioid = '19009' #and date = '2020-01-15'
						group by date,bioid,type) outtbl on consol.BioId = outtbl.bioid and consol.Date = outtbl.date

						left join (select date,MIN(time) as timein,bioid,type from consolidationtable where type = 0 #and bioid = '19009' #and date = '2020-01-15'
						group by date,bioid,type) intbl on consol.BioId = intbl.bioid and consol.Date = intbl.date

						WHERE consol.bioid = '$locbioid' #and consol.date between '2020-01-15' and '2020-01-25'

						group by consol.date,consol.bioid) cons on cons.bioid = wk.BioId and cons.date = ss.date


						where 
						
						ss.date between '$fromdatelte' and '$todatelte'
						and ss.workerid = '$locworker'
						and ss.dataareaid = '$dataareaid'
						order by date";*/
			$query = "SELECT ss.date,
				TIME_FORMAT(starttime,'%h:%i %p') as starttime
				,case when TIME_TO_SEC(SUBTIME(TIME_FORMAT(MIN(case when mt.type = 0 then TIME_FORMAT(mt.Time,'%h:%i %p') else null end),'%H:%i'),TIME_FORMAT(ss.starttime, '%H:%i'))) > TIME_TO_SEC(CONVERT('00:00:00', TIME)) then
				TIME_TO_SEC(SUBTIME(TIME_FORMAT(MIN(case when mt.type = 0 then TIME_FORMAT(mt.Time,'%h:%i %p') else null end),'%H:%i'),TIME_FORMAT(ss.starttime, '%H:%i'))) / 60
				end as late
				                                
				,case when TIME_TO_SEC(SUBTIME(TIME_FORMAT(MIN(case when mt.type = 0 then TIME_FORMAT(mt.Time,'%h:%i %p') else null end),'%H:%i'),TIME_FORMAT(ss.starttime, '%H:%i'))) > TIME_TO_SEC(CONVERT('00:00:00', TIME)) 
				then 1 end as latecount,
				case when ifnull(MIN(case when mt.type = 0 then TIME_FORMAT(mt.Time,'%h:%i %p') else null end),0) = 0 
				and ifnull(MAX(case when mt.type = 1 then TIME_FORMAT(mt.Time,'%h:%i %p') else null end),0) = 0 then 1 else 0 end as absent,
				case when ifnull(MIN(case when mt.type = 0 then TIME_FORMAT(mt.Time,'%h:%i %p') else null end),0) = 0  then 0 else 1 end as daywork,
				1 as attcount
										
					FROM shiftschedule ss 

					left join worker wk on ss.workerid = wk.workerid AND ss.dataareaid = wk.dataareaid

					left join monitoringtable mt on mt.Date = ss.date and mt.Name = wk.BioId 

					where 
						
						ss.date between '$fromdatelte' and '$todatelte'
						and ss.workerid = '$locworker'
						and ss.dataareaid = '$dataareaid'
						and ss.daytype not in ('Restday','Special Holiday','Regular Holiday')
						group by ss.date,starttime
						order by ss.date asc";

			$result = $conn->query($query);
			$rowclass = "rowA";
			$usedleave = 0;
			$dayswork = 0;
			$daysabsent = 0;
			$latemin = 0;
			$latecount = 0;
			while ($row = $result->fetch_assoc())
			{ 
					$daysabsent = $daysabsent + $row['absent'];
					$dayswork = $dayswork + $row['daywork'];
					$latemin = $latemin + $row['late'];
					$latecount = $latecount + $row['latecount'];
					

			}
			$output .= '
				<b class="dashboard-menu-content-sm">Mins:  </b>'. $latemin.' Min
				<b class="dashboard-menu-content-sm">&nbsp;|&nbsp;</b>
				<b class="dashboard-menu-content-sm">Count:  </b>'. $latecount.' Late';
		
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
	else if($_GET["actmode"]=="absentatt"){
		$fromdateabs=$_GET["slocFromdate"];
		$todateabs=$_GET["slocTodate"];
		$locworker=$_GET["slocworker"];
		$locbioid=$_GET["slocbio"];

		$output2='';
		//$output .= '<tbody>';
		$query2 = "SELECT ss.date,
				case when ifnull(MIN(case when mt.type = 0 then TIME_FORMAT(mt.Time,'%h:%i %p') else null end),0) = 0 
				and ifnull(MAX(case when mt.type = 1 then TIME_FORMAT(mt.Time,'%h:%i %p') else null end),0) = 0 then 1 else 0 end as absent,
				case when ifnull(MIN(case when mt.type = 0 then TIME_FORMAT(mt.Time,'%h:%i %p') else null end),0) = 0  then 0 else 1 end as daywork,
				1 as attcount
										
					FROM shiftschedule ss 

					left join worker wk on ss.workerid = wk.workerid AND ss.dataareaid = wk.dataareaid

					left join monitoringtable mt on mt.Date = ss.date and mt.Name = wk.BioId 

					where 
						
						ss.date between '$fromdateabs' and '$todateabs'
						and ss.workerid = '$locworker'
						and ss.dataareaid = '$dataareaid'
						and ss.daytype not in ('Restday','Special Holiday','Regular Holiday')
						group by ss.date
						order by ss.date asc";

			$result2 = $conn->query($query2);
			$rowclass = "rowA";
			$usedleave = 0;
			$dayswork = 0;
			$daysabsent = 0;
			$latemin = 0;
			$latecount = 0;
			while ($row2 = $result2->fetch_assoc())
			{ 
					$daysabsent = $daysabsent + $row2['absent'];
					$dayswork = $dayswork + $row2['daywork'];
					// $latemin = $latemin + $row2['late'];
					// $latecount = $latecount + $row2['latecount'];
					

			}
		$output2 .= '
				<b class="dashboard-menu-content-sm">Absent:  </b>'. $daysabsent.' Day
				<b class="dashboard-menu-content-sm">&nbsp;|&nbsp;</b>
				<b class="dashboard-menu-content-sm">Worked:  </b>'. $dayswork.' Day';
		//$output .= '</tbody>';
		echo $output2;
		//header('location: process.php');
	}
	else if($_GET["actmode"]=="overtimeatt"){
		$fromdateabs=$_GET["slocFromdate"];
		$todateabs=$_GET["slocTodate"];
		$locworker=$_GET["slocworker"];
		$locbioid=$_GET["slocbio"];

		$output3='';
		//$output .= '<tbody>';
		$query = "SELECT sum(hours) as totalhour,sum(minutes) as totalmins

						from overtimefile 
						where dataareaid = '$dataareaid' and status = 0 and workerid = '$locworker'
						and overtimedate between '$fromdateabs' and '$todateabs'";

				$result = $conn->query($query);
				$rowclass = "rowA";
				$hours = 0;
				$mins = 0;
				while ($row = $result->fetch_assoc())
				{ 
						$hours = $row['totalhour'];
						$mins = $row['totalmins'];

				}

				function convertTime() {
				    $args = func_get_args();
				    switch (count($args)) {
				        case 1:     //total minutes was passed so output hours, minutes
				            $time = array();
				            $time['hours'] = floor($args[0]/60);
				            $time['mins'] = ($args[0]%60);
				            return $time;
				            break;
				        case 2:     //hours, minutes was passed so output total minutes
				            return ($args[0] * 60) + $args[1];
				    }
				}

				//test the function
				//$hours = 6;
				//$mins = 125;
				//echo 'total minutes = '.convertTime($hours,$mins);

				$totalMinutes = convertTime($hours,$mins);
				$times = convertTime($totalMinutes);
		$output3 .= '
				<b class="dashboard-menu-content-sm">Hours:  </b>'. $times['hours'].' Hr
				<b class="dashboard-menu-content-sm">&nbsp;|&nbsp;</b>
				<b class="dashboard-menu-content-sm">Minutes:  </b>'. $times['mins'].' Min';
		//$output .= '</tbody>';
		echo $output3;
		//header('location: process.php');
	}

	else if($_GET["actmode"]=="leaveatt"){
		$fromdateabs=$_GET["slocFromdate"];
		$todateabs=$_GET["slocTodate"];
		$locworker=$_GET["slocworker"];
		$locbioid=$_GET["slocbio"];

		$output4='';
		//$output .= '<tbody>';
		$query = "SELECT count(*) as totalleave

							from portalleavefile 
							where dataareaid = '$dataareaid' and status = 0 
							and workerid = '$locworker'
							and leavedate between '$fromdateabs' and '$todateabs'";

					$result = $conn->query($query);
					$rowclass = "rowA";
					$totleave = 0;
					$mins = 0;
					while ($row = $result->fetch_assoc())
					{ 
							$totleave = $row['totalleave'];
							

					}
		$output4 .= '<b class="dashboard-menu-content-sm">Filed:  </b>'. $totleave.' Day';
		//$output .= '</tbody>';
		echo $output4;
		//header('location: process.php');
	}

}
?>
