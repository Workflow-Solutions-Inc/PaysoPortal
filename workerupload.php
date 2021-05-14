<?php
session_id("protal");
session_start();
session_regenerate_id();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");
if(isset($_POST["saveUpload"])){
 
 		$cnt=0;
 		//echo "asd";
		//echo $filename=$_FILES["myfile"]["tmp_name"];
 		$filename=$_FILES["myfile"]["tmp_name"];
 
		 if($_FILES["myfile"]["size"] > 0)
		 {
 
		  	$file = fopen($filename, "r");
	         while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
	         {
 				$sequence='';
 				$cnt++;
 				//echo $cnt;
 				if($cnt != 1)
 				{

					 $query = "SELECT * FROM numbersequence where dataareaid = '$dataareaid' and id='worker'";
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
							WHERE id = 'worker'
							and dataareaid = '$dataareaid'";
				 //mysqli_query($conn,$sql);	
					if(mysqli_query($conn,$sql))
					{
						
					}
					else
					{
						$output = "error".$sql."<br>".$conn->error;
					}

					/*echo $sequence;
 					echo $emapData[0];
 					echo $emapData[1];
 					echo $emapData[2];
 					echo $emapData[3];*/
 					$internalid = $emapData[0];
 					$fname = $emapData[1];
 					$mname = $emapData[2];
 					$lname = $emapData[3];
 					$bday = $emapData[4];
 					$address = $emapData[5];
 					$contact = $emapData[6];
 					$SSS = $emapData[7];
 					$philnum = $emapData[8];
 					$pibig = $emapData[9];
 					$tin = $emapData[10];
 					$bankacc = $emapData[11];
 					$branch = $emapData[12];
 					$position = $emapData[13];
 					$datehired = $emapData[14];
 					$empstatus = $emapData[15];
 					$regdate = $emapData[16];
 					$bioid = $emapData[17];
 					if($emapData[18] == "Weekly")
 					{
 						$payrollgroup = 0;
 					}
 					else
 					{
 						$payrollgroup = 1;
 					}
 					
 					

 					$fullname = $emapData[3].' '.$emapData[1].' '.substr($emapData[2],0,1);
 					//It wiil insert a row to our subject table from our csv file`
 					$sql = "INSERT INTO worker
	  				(workerid,name,lastname,firstname,middlename,address,contactnum,birthdate,regularizationdate,bankaccountnum,sssnum,phnum,pagibignum,tinnum,branch,position,datehired,employmentstatus,serviceincentiveleave,birthdayleave,inactive,inactivedate,BioId,internalId,activeonetimeded,payrollgroup,dataareaid,createdby,createddatetime)
					values 
					('$sequence','$fullname','$lname','$fname','$mname','$address','$contact',STR_TO_DATE('$bday','%Y-%m-%d'),STR_TO_DATE('$regdate','%Y-%m-%d'),'$bankacc','$SSS','$philnum','$pibig','$tin','$branch','$position',STR_TO_DATE('$datehired','%Y-%m-%d'),'$empstatus','0','1','0',STR_TO_DATE('1900-01-01', '%Y-%m-%d'),'$bioid','$internalid', '0', '$payrollgroup', '$dataareaid', '$userlogin', now())";

				//echo $sql;
				//we are using mysql_query function. it returns a resource on true else False on error
				
		          $result = mysqli_query( $conn, $sql );
					if(! $result )
					{
						

						/*echo "<script type=\"text/javascript\">
								alert(\"Invalid File:Please Upload CSV File.\");
								window.location = \"workerform.php\"
							</script>";*/
	 
					}
 				}
				 
 
	         }
	         
	         fclose($file);
	         //throws a message if data successfully imported to mysql database from excel file
	         echo "<script type=\"text/javascript\">
						alert(\"CSV File has been successfully Imported.\");
						window.location = \"workerform.php\"
					</script>";
 
 
 
			 //close of connection
			mysqli_close($conn); 
 
 
 
		 }
		 //header('location: branchform.php');
}
