<?php
/**
 * Created by PhpStorm.
 * User: sumo stephane
 * Date: 17/02/2018
 * Time: 15:03
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Document</title>
	<style>
        #map {
        	height: 300px;
        	width: 50%;
        	margin-left: 350px;
        	margin-top: 100px;
        }

		#button:hover{
			cursor: pointer;
		}

		body {margin: 0;}

		ul.topnav {
    		list-style-type: none;
    		margin: 0;
    		padding: 0;
    		overflow: hidden;
    		background-color: #333;
		}

		ul.topnav li {float: left;}

		ul.topnav li a {
    		display: block;
    		color: white;
    		text-align: center;
    		padding: 14px 16px;
    		text-decoration: none;
		}

		ul.topnav li a:hover:not(.active) {background-color: #111;}

		ul.topnav li a.active {background-color: #4CAF50;}

		ul.topnav li.right {float: right;}

		@media screen and (max-width: 600px){
    		ul.topnav li.right, 
    		ul.topnav li {float: none;};
		}
	</style>
</head>
<body style="background-image:url('http://d2dvoxuuazwqi2.cloudfront.net/wp-content/uploads/2017/03/arnaque_telephone_voyage.jpg'); background-repeat: no-repeat; background-size: 100% 100%">

	<ul class="topnav">
  		<li><a class="active" href="#home">Home</a></li>
  		<li><a href="#news">News</a></li>
  		<li><a href="#contact">Contact</a></li>
  		<li class="right"><a href="#about">About</a></li>
	</ul>
	<center style="margin-top: 100px; font-family: Gill Sans,Gill Sans MT,Calibri; color: black; text-shadow: 2px 2px #FF0000; width: 100%">
		<span><img src="https://media-cdn.tripadvisor.com/media/photo-s/0e/44/eb/43/trip-advisor-2017-winner.jpg" id="tripadvisor" style="width: 150px; height: 150px; margin-left: 1050px"></span> 
		<h2>Welcome to PlannedOdysee</h2>
		<form action="api.php" method="POST">
			<input type="text" name="lookout" id="search_term" placeholder="Search..." style="padding: 15px; margin-right: 5px">
			<input type="submit" id="button" style="padding: 15px; background-color: #16a085; border: 2px solid #16a085; border-radius: 5px" value="Submit">
		</form>
	</center>
	<script>
		function activatePlacesSearch(){
			var input = document.getElementById('search_term');
			var autocomplete = new google.maps.places.Autocomplete(input);
		}
	</script>

	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtjJUiJZMM0UI5XprqKCrUOdFyibNVYIE&libraries=places&callback=activatePlacesSearch"></script>


    <div id="map"></div>
    <script>
      function initMap() {
        var uluru = {lat: -25.363, lng: 131.044};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 4,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBOjPK54KIqRvrg8KkRpa5jfDp9EMgqGuE&callback=initMap">
    </script>

<!--
	<table border="0">
		<tr>
			<td>Name</td>
			<td align="center"><input type="text" name="username" size="30" /></td>
		</tr>

		<tr>
			<td>Address</td>
			<td align="center"><input type="text" name="streetaddress" size="30" /></td>
		</tr>

		<tr>
			<td>City</td>
			<td align="center"><input type="text" name="cityaddress" size="30" /></td>			
		</tr>

		<tr>
			<td colspan="2" align="center"><input type="submit" value="Submit" /></td>
		</tr>
	</table>

	<div id="blocktext" style="border-radius: 10px; border: 1px solid black; float: left; margin-right: 500px; background-color: gold; padding: 20px;">Lien1</div>
	<div id="blocktext" style="border-radius: 10px; border: 1px solid black; float: left; margin-right: 100px; background-color: gold; padding: 20px;">Lien2</div> 
	<div id="blocktext" style="border-radius: 10px; border: 1px solid black; float: right; margin-right: 100px; background-color: gold; padding: 20px; margin-bottom: 10px;">Lien3</div>
	<div id="blocktext" style="border-radius: 10px; border: 1px solid black; float: left; margin-right: 500px; background-color: gold; padding: 20px; clear: both;">Lien4</div>
	<div id="blocktext" style="border-radius: 10px; border: 1px solid black; float: left; margin-right: 100px; background-color: gold; padding: 20px">Lien5</div>	
	<div id="blocktext" style="border-radius: 10px; border: 1px solid black; float: right; margin-right: 100px; background-color: gold; padding: 20px; margin-bottom: 10px">Lien6</div>
-->
	<footer style="clear: both; background-color: black; margin-top: 150px">
		<div style="background-color: black; color: silver; text-align: center; padding: 20px; border-radius: 5px">Copyright 2018</div>
	</footer>
</body>
</html>


<?php 
//	echo $_GET['longueur'];
?>
<!-- <a href="api.php?longueur=10">Lien 1</a> -->


<!--<script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyDtjJUiJZMM0UI5XprqKCrUOdFyibNVYIE&callback=initMap">
	
new google.maps.places.Autocomplete(document.getElementById('autocomplete'));

</script>-->

