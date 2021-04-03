<?php

session_start();
include("dbconn.php");

if(isset($_POST["submit"])) {

	$username = $_POST["username"];
	$password = $_POST["password"];
	$dataareaid = '';

if($username && $password){

	$sql = "SELECT userid,cast(aes_decrypt(password,'password') as char(50)) as pass,defaultdataareaid,name,bioid,workerid from userportal where userid='$username'";
	$result = $conn->query($sql);

	//if($numrows!=0)
	if ($result->num_rows > 0){
		//code to login
		while ($row = $result->fetch_assoc())
		{
			$dbusername = $row['userid'];
			$dbpassword = $row['pass'];
			$dataareaid = $row['defaultdataareaid'];
			$loginname = $row['name'];
			$loginbioid = $row['bioid'];
			$loginworkerid = $row['workerid'];

			//echo $dbusername;
			//echo $dbpassword;
			//echo $username;
			//echo $password;
			}
			//check to see if they match!
			if($username == $dbusername && $password == $dbpassword)
			{
				//echo "Login successful! <a href='index.php'>Click</a> here to enter the member page!";
				$_SESSION['user'] = $dbusername;
				$_SESSION['userpass'] = $dbpassword;
				$_SESSION['defaultdataareaid'] = $dataareaid;
				$_SESSION['logname'] = $loginname;
				$_SESSION['logbio'] = $loginbioid;
				$_SESSION['lognum'] = $loginworkerid;
				header('location: employee.php');
			}
			else{
				header('location: index.php?invalid=1');
				//echo "Login successful! ";
				?>
					<script type="text/javascript">
					//alert("Invalid Login!")
					window.location="index.php?invalid=2"
					</script>
				<?php
			}
	}
	else {
		/*die("That user doesn't exist!");*/
		?>
			<script type="text/javascript">
			//alert("That user doesn't exist!")
			window.location="index.php?invalid=2"
			</script>
		<?php 
   }
}
else 
	die("Please enter a username and a password!");
}
/*
else if($_GET["action"] == "logout"){
	session_unset();
	header('location:index.php');
}
*/

/*
else if(isset($_POST["submitlogout"])) {
	session_unset();
	header('location:index.php');
}
*/
else if(isset($_GET["out"])) {
	session_unset();
	header('location:index.php');
}


?>






<?php
/*
session_start();
include("dbconn.php");

if($_GET["action"] == "login"){
$username = $_GET['user'];
$password = $_GET['pass'];
$dataareaid = '';
if($username && $password){

	$sql = "SELECT userid,cast(aes_decrypt(password,'password') as char(50)) as pass,defaultdataareaid from userfile where userid='$username'";
	$result = $conn->query($sql);

	//if($numrows!=0)
	if ($result->num_rows > 0){
		//code to login
		while ($row = $result->fetch_assoc())
		{
			$dbusername = $row['userid'];
			$dbpassword = $row['pass'];
			$dataareaid = $row['defaultdataareaid'];
			//echo $dbusername;
			//echo $dbpassword;
			//echo $username;
			//echo $password;
			}
			//check to see if they match!
			if($username == $dbusername && $password == $dbpassword)
			{
				//echo "Login successful! <a href='index.php'>Click</a> here to enter the member page!";
				$_SESSION['user'] = $dbusername;
				$_SESSION['defaultdataareaid'] = $dataareaid;
				header('location: menu.php');
			}
			else{
				header('location: index.php?wrongpassword');
				//echo "Login successful! ";
				?>
					<script type="text/javascript">
					alert("Invalid Login!")
					window.location="index.php?invalid"
					</script>
				<?php
			}
	}
	else {
		?>
			<script type="text/javascript">
			alert("That user doesn't exist!")
			window.location="index.php?invalid"
			</script>
		<?php 
   }
}

else 
	die("Please enter a username and a password!");
}
else if($_GET["action"] == "logout"){
	session_unset();
	header('location:index.php');
}
*/

?>