<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
form {border: 3px solid #f1f1f1;}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

button {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

img.avatar {
  width: 40%;
  border-radius: 50%;
}

.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
</style>
<body>

<h2>Online Biometrics with Map Directory</h2>

  <div class="container">

    <button type="submit" onclick="checkTimeIn()" id="timeIn">Time-In</button>
    <button type="submit" onclick="checkTimeOut()" id="timeOut">Time-Out</button>

    <?php 
					if(isset($_GET['invalid'])) 
						{ 
							if($_GET["invalid"] == 1) 
							{
								//echo "<div>https://www.google.com/maps/dir/".$_GET["mylocation"]."</div>"; 
								echo " <a href='https://www.google.com/maps/dir/".$_GET["mylocation"]."'>Get your Location and Directions Here.</a>"; 
							}
							
						}
	?>

  </div>
<div class="container" style="background-color:#f1f1f1">
</div>

<?php
 $latV2 = '14.681283';//office start
 $lonV2 = '121.084078';//office end
 ?>

 <?php

    $lat1 = $profile_viewer_uid = $_COOKIE['mylat'];//my location start
    $lon1 = $profile_viewer_uid = $_COOKIE['mylong'];//my location end


   // $lat1 = '14.6815996';//my location start
  //  $lon1 = '121.0842547';//my location end
    $lat2 = '14.6809799';//office start
    $lon2 = '121.0839854';//office end
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
                              $dist = acos($dist);
                              $dist = rad2deg($dist);
                              $miles= $dist * 60 * 1.1515;
                              $unit = 'K';
                                $km   = $miles*1.609344;
                          //    echo number_format($km,2)*1000;
?>
<script>


var x = document.getElementById("demo");
var y = document.getElementById("demo2");


function checkTimeIn()
{
	 getLocation();
		 document.cookie="mylat="+localStorage.getItem("myLatitude")+"";
		 document.cookie="mylong="+localStorage.getItem("myLongitude")+"";

		 var myCurrentMeters = '<?php echo number_format($km,2)*1000; ?>';
		 var myOfficeLat = '<?php echo $lat2; ?>';
		 var myOfficeLong = '<?php echo $lon2; ?>';
		 var myOfficeLatSet = localStorage.setItem("myAccidparam",myOfficeLat);
		 var myOfficeLongSet = localStorage.setItem("myAccidparam2",myOfficeLong);
		 var myLocationSearchFrom = ""+localStorage.getItem("myLatitude")+","+localStorage.getItem("myLongitude")+"";
		 var myLocationSearchTo = "/"+localStorage.getItem("myAccidparam",myOfficeLat)+","+localStorage.getItem("myAccidparam2",myOfficeLongSet)+"";
		 var myLocationQry = myLocationSearchFrom + myLocationSearchTo;
		 //var myQryLocation = "https://www.google.com/maps/dir/"+myLocationQry+"";
		// const encoded = new Buffer(myQryLocation).toString('hex');
		 //alert(encoded);
		 if (myCurrentMeters > 100)
		 {
		 	alert("Time In is available in between 100 meters distance from office.You are "+myCurrentMeters+" meters away from office.");
		 	window.location.href="OnlineBiometrics.php?invalid=1&mylocation="+myLocationQry+"";
		 }
		 else
		 {
		 	alert("Time In Successful");
		 }
		 //alert(myLocationSearchTo);
		/*let newWindow = 
		 open("https://www.google.com/maps/dir/"+myLocationQry+"", "My Location");
          myWindow= window.open();*/
}


function checkTimeOut()
{
	 getLocation();
		 document.cookie="mylat="+localStorage.getItem("myLatitude")+"";
		 document.cookie="mylong="+localStorage.getItem("myLongitude")+"";

		 var myCurrentMeters = '<?php echo number_format($km,2)*1000; ?>';
		 var myOfficeLat = '<?php echo $lat2; ?>';
		 var myOfficeLong = '<?php echo $lon2; ?>';
		 var myOfficeLatSet = localStorage.setItem("myAccidparam",myOfficeLat);
		 var myOfficeLongSet = localStorage.setItem("myAccidparam2",myOfficeLong);
		 var myLocationSearchFrom = ""+localStorage.getItem("myLatitude")+","+localStorage.getItem("myLongitude")+"";
		 var myLocationSearchTo = "/"+localStorage.getItem("myAccidparam",myOfficeLat)+","+localStorage.getItem("myAccidparam2",myOfficeLongSet)+"";
		 var myLocationQry = myLocationSearchFrom + myLocationSearchTo;
		 //var myQryLocation = "https://www.google.com/maps/dir/"+myLocationQry+"";
		// const encoded = new Buffer(myQryLocation).toString('hex');
		 //alert(encoded);
		 if (myCurrentMeters > 100)
		 {
		 	alert("Time Out is available in between 100 meters distance from office.You are "+myCurrentMeters+" meters away from office.");
		 	window.location.href="OnlineBiometrics.php?invalid=1&mylocation="+myLocationQry+"";
		 }
		 else
		 {
		 	alert("Time In Successful");
		 }
		 //alert(myLocationSearchTo);
		/*let newWindow = 
		 open("https://www.google.com/maps/dir/"+myLocationQry+"", "My Location");
          myWindow= window.open();*/
}

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else { 
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
	localStorage.setItem("myLatitude",position.coords.latitude);
	localStorage.setItem("myLongitude",position.coords.longitude);
	alert(position.coords.longitude);
}
</script>

</html>
