<?php
session_start();
session_regenerate_id();
$userlogin = $_SESSION["portaluser"];
$dataareaid = $_SESSION["portaldefaultdataareaid"];
$logname = $_SESSION["portallogname"];
$logbio = $_SESSION["portallogbio"];
$lognum = $_SESSION["portallognum"];
include("dbconn.php");


if(isset($_GET["changepass"])) {
	 
	 $upass=$_GET["newpass"];
	 
	 if($upass != ""){
	 $sql = "UPDATE userportal SET
				password = aes_encrypt('$upass','password'),
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE userid = '$userlogin'";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Updated";
			$_SESSION['portaluserpass'] = $upass;
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	
	header('location: employee.php');
	
}