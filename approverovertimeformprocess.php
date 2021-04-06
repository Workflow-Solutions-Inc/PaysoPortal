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

else if($_GET["action"]=="getOT"){
	 $output='';
	 $endtimehour=0;
	 $endtimemins=0;
	 $late='false';
	 $leavefilter=$_GET["lfilter"];
	 $leaveTypefilter=$_GET["Typefilter"];
	 $otworker=$_GET["WKId"];
	// echo($userlogin);
	 $queryconsolidate = "call sp_testing('$userlogin','$leavefilter','$dataareaid')";
	 if(mysqli_query($conn,$queryconsolidate))
		{
			//alert(1);
		}
		else
		{
			//alert(2);
		}
	$conn->close();
    include("dbconn.php");
	 $queryWK = "SELECT * FROM worker where dataareaid = '$dataareaid' and workerid='$otworker'";
	 $resultWK = $conn->query($queryWK);
	 $rowWK = $resultWK->fetch_assoc();
	 $logbio=$rowWK["BioId"];

         if($leaveTypefilter == 0)
         {
         	/*$query2 = "SELECT consol.date,
					ifnull(TIME_FORMAT(outtbl.timeout,'%H:%i'),'00:00') as timeout,
					consol.bioid,wk.workerid

					,ifnull(TIME_FORMAT(pw.endtime,'%H:%i'),'00:00') field_work 
					,ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00') log_correction

					#,TIME_FORMAT(ss.endtime,'%H:%i') as endtime 

					,TIME_FORMAT(TIMEDIFF(case 
					when ifnull(TIME_FORMAT(outtbl.timeout,'%H:%i'),'00:00') >= ifnull(TIME_FORMAT(pw.endtime,'%H:%i'),'00:00') 
					and ifnull(TIME_FORMAT(outtbl.timeout,'%H:%i'),'00:00') >= ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00')
					then ifnull(TIME_FORMAT(outtbl.timeout,'%H:%i'),'00:00') 

					when ifnull(TIME_FORMAT(pw.endtime,'%H:%i'),'00:00') >= ifnull(TIME_FORMAT(outtbl.timeout,'%H:%i'),'00:00') 
					and ifnull(TIME_FORMAT(pw.endtime,'%H:%i'),'00:00') >= ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00')
					then ifnull(TIME_FORMAT(pw.endtime,'%H:%i'),'00:00')

					when ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00') >= ifnull(TIME_FORMAT(outtbl.timeout,'%H:%i'),'00:00') 
					and ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00')  >= ifnull(TIME_FORMAT(pw.endtime,'%H:%i'),'00:00') 
					then ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00')
					else '00:00'
					end, 


					TIME_FORMAT(ss.endtime,'%H:%i')),'%H') as endtimehour
					,TIME_FORMAT(TIMEDIFF(case 
					when ifnull(TIME_FORMAT(outtbl.timeout,'%H:%i'),'00:00') >= ifnull(TIME_FORMAT(pw.endtime,'%H:%i'),'00:00') 
					and ifnull(TIME_FORMAT(outtbl.timeout,'%H:%i'),'00:00') >= ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00')
					then ifnull(TIME_FORMAT(outtbl.timeout,'%H:%i'),'00:00') 

					when ifnull(TIME_FORMAT(pw.endtime,'%H:%i'),'00:00') >= ifnull(TIME_FORMAT(outtbl.timeout,'%H:%i'),'00:00') 
					and ifnull(TIME_FORMAT(pw.endtime,'%H:%i'),'00:00') >= ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00')
					then ifnull(TIME_FORMAT(pw.endtime,'%H:%i'),'00:00')

					when ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00') >= ifnull(TIME_FORMAT(outtbl.timeout,'%H:%i'),'00:00') 
					and ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00')  >= ifnull(TIME_FORMAT(pw.endtime,'%H:%i'),'00:00') 
					then ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00')
					else '00:00'
					end, 


					TIME_FORMAT(ss.endtime,'%H:%i')),'%i') as endtimemins

					,case 
					when ifnull(TIME_FORMAT(outtbl.timeout,'%H:%i'),'00:00') > ifnull(TIME_FORMAT(pw.endtime,'%H:%i'),'00:00') and ifnull(TIME_FORMAT(outtbl.timeout,'%H:%i'),'00:00') > ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00')
					then ifnull(TIME_FORMAT(outtbl.timeout,'%H:%i'),'00:00') 

					when ifnull(TIME_FORMAT(pw.endtime,'%H:%i'),'00:00') > ifnull(TIME_FORMAT(outtbl.timeout,'%H:%i'),'00:00') and ifnull(TIME_FORMAT(pw.endtime,'%H:%i'),'00:00') > ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00')
					then ifnull(TIME_FORMAT(pw.endtime,'%H:%i'),'00:00')

					when ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00') > ifnull(TIME_FORMAT(outtbl.timeout,'%H:%i'),'00:00') and ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00')  > ifnull(TIME_FORMAT(pw.endtime,'%H:%i'),'00:00') 
					then ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00')
					else '00:00'
					end as official_out


					FROM 
					consolidationtable consol
					left join (select date,MAX(time) as timeout,bioid,type from consolidationtable where type = 1
					group by date,bioid,type) outtbl on consol.BioId = outtbl.bioid and consol.Date = outtbl.date

					left join worker wk on wk.BioId = consol.BioId and wk.dataareaid = consol.Dataareaid

					left join portalfieldwork pw on pw.workerid = wk.workerid and pw.fieldworkdate = consol.Date
					and pw.dataareaid = consol.Dataareaid

					left join logcorrection lc on lc.workerid = wk.workerid and lc.invaliddate = consol.Date
					and lc.dataareaid = consol.Dataareaid and lc.logtype = 1

					left join shiftschedule ss on ss.date = consol.date and ss.workerid = wk.workerid and ss.dataareaid = consol.Dataareaid

					where consol.bioid = '$logbio' and consol.date = '$leavefilter' and consol.Dataareaid = '$dataareaid'

					group by consol.date,consol.bioid";*/
					$query2 = "SELECT consol.date,
					ifnull(TIME_FORMAT(outtbl.timeout,'%H:%i'),'00:00') as timeout,
                    ifnull(TIME_FORMAT(outtbl2.timeout,'%H:%i'),'00:00') as timeout2,
                    ifnull(TIME_FORMAT(intbl.timein,'%H:%i'),'00:00') as timein,
					consol.bioid,wk.workerid#,outtbl.timeout,outtbl2.timeout

					,ifnull(TIME_FORMAT(pw.endtime,'%H:%i'),'00:00') field_work 
					,ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00') log_correction

					#,TIME_FORMAT(ss.endtime,'%H:%i') as endtime 
                    #,ss.endtime,ss.starttime
                    ,TIME_FORMAT(subtime(TIMEDIFF(ifnull(outtbl.timeout,outtbl2.timeout), intbl.timein),CONVERT('09:00:00', TIME)),'%H') as renderedtime

					,case when ss.endtime is null 
                    then
						TIME_FORMAT(subtime(TIMEDIFF(ifnull(outtbl.timeout,outtbl2.timeout), intbl.timein),CONVERT('09:00:00', TIME)),'%H')
					else
                    
                    TIME_FORMAT(TIMEDIFF(case 
					when ifnull(ifnull(outtbl.timeout,outtbl2.timeout),'00:00') >= ifnull(pw.endtime,'00:00') 
					and ifnull(ifnull(outtbl.timeout,outtbl2.timeout),'00:00') >= ifnull(lc.logtime,'00:00')
					then ifnull(ifnull(outtbl.timeout,outtbl2.timeout),'00:00')

					when ifnull(pw.endtime,'00:00') >= ifnull(ifnull(outtbl.timeout,outtbl2.timeout),'00:00')
					and ifnull(pw.endtime,'00:00') >= ifnull(lc.logtime,'00:00')
					then ifnull(pw.endtime,'00:00')

					when ifnull(lc.logtime,'00:00') >= ifnull(ifnull(outtbl.timeout,outtbl2.timeout),'00:00')
					and ifnull(lc.logtime,'00:00')  >= ifnull(pw.endtime,'00:00') 
					then ifnull(lc.logtime,'00:00')
					else '00:00'
					end, 


					ss.endtime),'%H') end as endtimehour
					,case when ss.endtime is null 
                    then
						TIME_FORMAT(subtime(TIMEDIFF(outtbl.timeout, intbl.timein),CONVERT('09:00:00', TIME)),'%i')
					else
                    
                    TIME_FORMAT(TIMEDIFF(case 
					when ifnull(ifnull(outtbl.timeout,outtbl2.timeout),'00:00') >= ifnull(pw.endtime,'00:00') 
					and ifnull(ifnull(outtbl.timeout,outtbl2.timeout),'00:00') >= ifnull(lc.logtime,'00:00')
					then ifnull(ifnull(outtbl.timeout,outtbl2.timeout),'00:00')

					when ifnull(pw.endtime,'00:00') >= ifnull(ifnull(outtbl.timeout,outtbl2.timeout),'00:00')
					and ifnull(pw.endtime,'00:00') >= ifnull(lc.logtime,'00:00')
					then ifnull(pw.endtime,'00:00')

					when ifnull(lc.logtime,'00:00') >= ifnull(ifnull(outtbl.timeout,outtbl2.timeout),'00:00')
					and ifnull(lc.logtime,'00:00')  >= ifnull(pw.endtime,'00:00') 
					then ifnull(lc.logtime,'00:00')
					else '00:00'
					end, 


					ss.endtime),'%i') end as endtimemins

					,case 
					when ifnull(TIME_FORMAT(outtbl.timeout,'%H:%i'),'00:00') > ifnull(TIME_FORMAT(pw.endtime,'%H:%i'),'00:00') and ifnull(TIME_FORMAT(outtbl.timeout,'%H:%i'),'00:00') > ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00')
					then ifnull(TIME_FORMAT(outtbl.timeout,'%H:%i'),'00:00') 

					when ifnull(TIME_FORMAT(pw.endtime,'%H:%i'),'00:00') > ifnull(TIME_FORMAT(outtbl.timeout,'%H:%i'),'00:00') and ifnull(TIME_FORMAT(pw.endtime,'%H:%i'),'00:00') > ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00')
					then ifnull(TIME_FORMAT(pw.endtime,'%H:%i'),'00:00')

					when ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00') > ifnull(TIME_FORMAT(outtbl.timeout,'%H:%i'),'00:00') and ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00')  > ifnull(TIME_FORMAT(pw.endtime,'%H:%i'),'00:00') 
					then ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00')
					else '00:00'
					end as official_out


					FROM 
					consolidationtable consol
					left join (select date,concat(date, ' ', MAX(time)) as timeout,bioid,type from consolidationtable where type = 1
					group by date,bioid,type) outtbl on consol.BioId = outtbl.bioid and consol.Date = outtbl.date
                    
                    
                    
                    
					left join (select date,concat(date, ' ', min(time)) as timein,bioid,type from consolidationtable where type = 0
					group by date,bioid,type) intbl on consol.BioId = intbl.bioid and consol.Date = intbl.date

					left join worker wk on wk.BioId = consol.BioId and wk.dataareaid = consol.Dataareaid

					left join portalfieldwork pw on pw.workerid = wk.workerid and pw.fieldworkdate = consol.Date
					and pw.dataareaid = consol.Dataareaid

					left join logcorrection lc on lc.workerid = wk.workerid and lc.invaliddate = consol.Date
					and lc.dataareaid = consol.Dataareaid and lc.logtype = 1

					left join shiftschedule ss on ss.date = consol.date and ss.workerid = wk.workerid and ss.dataareaid = consol.Dataareaid
                    
                    left join shiftschedule ss2 on ss2.date = date_add(consol.Date, Interval 1 day) and ss2.workerid = wk.workerid and ss2.dataareaid = consol.Dataareaid
                    
                    left join (select date,concat(date, ' ' , min(time)) as timeout,bioid,type from consolidationtable where type = 1
					group by date,bioid,type) outtbl2 on consol.BioId = outtbl2.bioid and date_add(consol.Date, Interval 1 day) = outtbl2.date
						and outtbl2.timeout < ss2.starttime

					where consol.bioid = '$logbio' and consol.date = '$leavefilter' and consol.Dataareaid = '$dataareaid'

					group by consol.date,consol.bioid";
         }
        else
        {
        	$query2 = "SELECT consol.date,
						ifnull(TIME_FORMAT(intbl.timein,'%H:%i'),'00:00') as timein,
						consol.bioid,wk.workerid

						,ifnull(TIME_FORMAT(pw.starttime,'%H:%i'),'00:00') field_work 
						,ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00') log_correction

						,TIME_FORMAT(ss.starttime,'%H:%i') as endtime 

						,TIME_FORMAT(TIMEDIFF(TIME_FORMAT(ss.starttime,'%H:%i'),
						case 
						when ifnull(TIME_FORMAT(intbl.timein,'%H:%i'),'24:00') < ifnull(TIME_FORMAT(pw.starttime,'%H:%i'),'24:00') 
						and ifnull(TIME_FORMAT(intbl.timein,'%H:%i'),'24:00') < ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'24:00')
						then ifnull(TIME_FORMAT(intbl.timein,'%H:%i'),'24:00') 

						when ifnull(TIME_FORMAT(pw.starttime,'%H:%i'),'24:00') < ifnull(TIME_FORMAT(intbl.timein,'%H:%i'),'24:00') 
						and ifnull(TIME_FORMAT(pw.starttime,'%H:%i'),'24:00') < ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'24:00')
						then ifnull(TIME_FORMAT(pw.starttime,'%H:%i'),'24:00')

						when ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'24:00') < ifnull(TIME_FORMAT(intbl.timein,'%H:%i'),'24:00') 
						and ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'24:00')  < ifnull(TIME_FORMAT(pw.starttime,'%H:%i'),'24:00') 
						then ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'24:00')
						else '00:00'
						end


						),'%H') as endtimehour

						,TIME_FORMAT(TIMEDIFF(TIME_FORMAT(ss.starttime,'%H:%i'),
						case 
						when ifnull(TIME_FORMAT(intbl.timein,'%H:%i'),'00:00') < ifnull(TIME_FORMAT(pw.starttime,'%H:%i'),'00:00') 
						and ifnull(TIME_FORMAT(intbl.timein,'%H:%i'),'00:00') < ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00')
						then ifnull(TIME_FORMAT(intbl.timein,'%H:%i'),'00:00') 

						when ifnull(TIME_FORMAT(pw.starttime,'%H:%i'),'00:00') < ifnull(TIME_FORMAT(intbl.timein,'%H:%i'),'00:00') 
						and ifnull(TIME_FORMAT(pw.starttime,'%H:%i'),'00:00') < ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00')
						then ifnull(TIME_FORMAT(pw.starttime,'%H:%i'),'00:00')

						when ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00') < ifnull(TIME_FORMAT(intbl.timein,'%H:%i'),'00:00') 
						and ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00')  < ifnull(TIME_FORMAT(pw.starttime,'%H:%i'),'00:00') 
						then ifnull(TIME_FORMAT(lc.logtime,'%H:%i'),'00:00')
						else '00:00'
						end


						),'%i') as endtimemins



						FROM 
						consolidationtable consol
						left join (select date,MIN(time) as timein,bioid,type from consolidationtable where type = 0
						group by date,bioid,type) intbl on consol.BioId = intbl.bioid and consol.Date = intbl.date

						left join worker wk on wk.BioId = consol.BioId and wk.dataareaid = consol.Dataareaid

						left join portalfieldwork pw on pw.workerid = wk.workerid and pw.fieldworkdate = consol.Date
						and pw.dataareaid = consol.Dataareaid

						left join logcorrection lc on lc.workerid = wk.workerid and lc.invaliddate = consol.Date
						and lc.dataareaid = consol.Dataareaid and lc.logtype = 0

						left join shiftschedule ss on ss.date = consol.date and ss.workerid = wk.workerid and ss.dataareaid = consol.Dataareaid

						where consol.bioid = '$logbio' and consol.date = '$leavefilter' and consol.Dataareaid = '$dataareaid'

						group by consol.date,consol.bioid";
        }

		$result2 = $conn->query($query2);
		while ($row2 = $result2->fetch_assoc())
		{ 
				

				$endtimehour = (int)$row2['endtimehour'];
				$endtimemins = (int)$row2['endtimemins'];
			

		}

		
	/*	if($ispaid == 1)
		{
			$paidleave = "true";
		}
		else
		{
			$paidleave = "false";
		}*/

		

		$output .= '
				 <input type="hidden" value="'.$endtimehour.'"  name ="myHrs" id="otHRS" class="modal-textarea">
				 <input type="hidden" value="'.$endtimemins.'" name ="myMins" id="otMINS" class="modal-textarea">
				 ';

	
	 echo $output;
	
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