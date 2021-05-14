<?php
session_id("protal");
session_start();
session_regenerate_id();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$logname = $_SESSION["logname"];
$logbio = $_SESSION["logbio"];
$lognum = $_SESSION["lognum"];
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
			$_SESSION['userpass'] = $upass;
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	
	header('location: employee.php');
	
}