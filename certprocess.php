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
	 
	 $id=$_GET["CertId"];
	 $details=$_GET["Purpose"];
	 $certtype=$_GET["CertType"];
	
	 
	 if($id != ""){
	 $sql = "INSERT INTO certificate (certificateid,details,certificatetype,status,workerid,dataareaid,createdby,createddatetime)
			values 
			('$id', '$details', '$certtype', 0, '$lognum', '$dataareaid', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: cert.php');
	
}
else if(isset($_GET["update"])) {

	 $id=$_GET["CertId"];
	 $details=$_GET["Purpose"];
	 $certtype=$_GET["CertType"];
	 
	 if($id != ""){
	 $sql = "UPDATE certificate SET
				certificateid = '$id',
				details = '$details',
				certificatetype = '$certtype'
				WHERE certificateid = '$id'
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
	 
	header('location: cert.php');
	
}
else if($_GET["action"]=="add"){
	 $output='';
	 $sequence='';
	 $query = "SELECT * FROM numbersequence where dataareaid = '$dataareaid' and id='certificate'";
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
				WHERE id = 'certificate'
				and dataareaid = '$dataareaid'";
	 //mysqli_query($conn,$sql);	
		if(mysqli_query($conn,$sql))
		{
			$output .= '
				 <input type="text" value="'.$sequence.'" placeholder="Certificate ID" name ="CertId" id="add-certid" class="modal-textarea" required="required">
				 ';
		}
		else
		{
			$output .= "error".$sql."<br>".$conn->error;
		}
	/*$output .= '
				 <input type="text" value="'.$sequence.'" placeholder="Certificate ID" name ="CertId" id="add-certid" class="modal-textarea" required="required">
				 ';*/
	 
	 echo $output;
	
}


else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["loccertid"];

		if($id != ""){
			$sql = "DELETE from certificate where certificateid = '$id' and dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: cert.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["BranchId"];
		$name=$_GET["name"];
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT * FROM branch where dataareaid = '$dataareaid' and (branchcode like '%$id%') and (name like '%$name%')";
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
			<tr id="'.$row["branchcode"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'" >
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:50%;">'.$row["branchcode"].'</td>
				<td style="width:50%;">'.$row["name"].'</td>
			</tr>';
			//echo $row["name"];
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}

if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];
     //$id= 'Jonathan Erwin Tuazon resume.pdf';
    //$id = str_replace(' ','%20',$id);
    //echo $id;
			header('Content-Description: File Transfer');
		    header('Content-Type: application/force-download');
		    header("Content-Disposition: attachment; filename=\"" . basename($id) . "\";");
		    header('Content-Transfer-Encoding: binary');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    // header('Content-Length: ' . filesize($id));
		    ob_clean();
		    flush();
		    //readfile("../PaysoPortal-2/uploads/".$id); //showing the path to the server where the file is to be download
		    ///home/u481683305/domains/sypro-it.com/public_html/uat-kontrata/process/templates/".$tempid.".docx", "Word2007
		    readfile('../Payso/uploads/'.$id);
		    //readfile('https://wfsi-dev.payso.live/uploads/'.$id);
		    //exit;

		    //header('location: uploaderform.php');

}


?>
<!-- <script src="js/ajax.js"></script>
<script  type="text/javascript">
		var locname='';
	  	var so='';
		$(document).ready(function(){
		$('#datatbl tbody tr').click(function(){
			$('table tbody tr').css("color","black");
			$(this).css("color","red");
			$('table tbody tr').removeClass("info");
			$(this).addClass("info");
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
			locname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			so = usernum.toString();
			document.getElementById("hide").value = so;
			//alert(document.getElementById("hide").value);
			//alert(so);	
						  
				});
			});
</script> -->