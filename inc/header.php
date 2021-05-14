<?php
$userpasshd = $_SESSION['userpass'];
if(!isset($_SESSION['lognum']) || !isset($_SESSION['defaultdataareaid']))
{
	header('location: index.php');
}
?>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<link rel="stylesheet" type="text/css" href="css/form.css" />
	<link rel="stylesheet" type="text/css" href="css/modal.css" />
	<script src="js/jquery.min.js"></script>

</head>
<body>


<div class="mainpanel-top">
	<a id="myChangeBtn" class="btn btn-warning"><i class="fas fa-key"></i> Change Password</a>
	<a href="loginprocess.php?out" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
	<input type="hidden" id="hidepasshd" value="<?php echo $userpasshd;?>">
</div>



<!-- The Modal -->
<div id="myModal2" class="modal">
	<!-- Modal content -->
	<div class="modal-container">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-lg-6">Change Password</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close-1"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm2" accept-charset="utf-8" action="changepass.php" method="get">
					<div class="row">

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<label>Old Password:</label>
							<input type="text" value="" placeholder="Old Password" name ="oldpass" id="add-oldpass" class="modal-textarea" required="required">
							
							<label>New Password:</label>
							<input type="text" value="" placeholder="New Password" id="add-newpass" name="newpass" class="modal-textarea" required="required">

							<label>Re-Type New Password:</label>
							<input type="text" value="" placeholder="Re-Type New Password" id="add-renewpass" name="renewpass" class="modal-textarea" minlength="2" required="required">
						</div>


					</div>

					<div class="button-container">
						<!--<button id="csaddbt" name="save" value="save" class="btn btn-primary btn-action" onclick="return checkExistForm()">Save</button>-->
						<button id="csupbt" name="changepass" value="changepass" class="btn btn-success btn-action" onclick="return validateForm1()">Change</button>
						<button onClick="ClearPass();" type="button" value="Reset" class="btn btn-danger">Clear</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- end modal-->

<script src="js/ajax.js"></script>
<script  type="text/javascript">
		// Get the modal -------------------
		var modal2 = document.getElementById('myModal2');
		// Get the button that opens the modal
		//var CreateBtn = document.getElementById("myAddBtn");
		var myChangeBtn = document.getElementById("myChangeBtn");
		// Get the <span> element that closes the modal
		var span1 = document.getElementsByClassName("modal-close-1")[0];
		// When the user clicks the button, open the modal 
		
		myChangeBtn.onclick = function() {

		    modal2.style.display = "block";
		    
			
		    //document.getElementById("csaddbt").style.visibility = "hidden";
		    document.getElementById("csupbt").style.visibility = "visible";
			
		}
		// When the user clicks on <span> (x), close the modal
		span1.onclick = function() {
		    modal2.style.display = "none";
		}
		// When the user clicks anywhere outside of the modal, close it
		/*window.onclick = function(event) {
		    if (event.target == modal || event.target == modal2) {
		        modal.style.display = "none";
		        Clear();
		        
		    }
		}*/
		//end modal ---------------------------


		function validateForm1() {
		  var x = document.forms["myForm2"]["changepass"].value;
		  var locOldPass = $('#add-oldpass').val();
		  var locNewPass = $('#add-newpass').val();
		  var locReNewPass = $('#add-renewpass').val();
		  var syspass = $('#hidepasshd').val();
		  //alert($userpassx);
		  if (x == "changepass") {
		  	if(confirm("Are you sure you want to change this password?")) {
		    	if(syspass == locOldPass){

		    		if(locNewPass == locReNewPass){
		    			return true;
		    		}
		    		else 
		    		{
		    			alert("Password Dont Match!");
		    			ClearPass();
		    			return false;
		    		}
		    		
		    	}
		    	else
		    	{
		    		alert("You Must Enter the Correct Old Password");
		    		ClearPass();
		    		return false;
		    	}
		   
		    	
		    }
		    else
		    {
		    	//modal.style.display = "none";
		    	ClearPass();
		    	return false;
		    }
		  }
		}

		function ClearPass()
		{
			document.getElementById("add-oldpass").value = '';
			document.getElementById("add-newpass").value = '';
			document.getElementById("add-renewpass").value = '';
		}

</script>
<script type="text/javascript" src="js/custom.js"></script>