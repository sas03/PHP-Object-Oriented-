<?php
/**
 * Created by PhpStorm.
 * User: sumo stephane
 * Date: 17/02/2018
 * Time: 15:03
 */
?>

<!DOCTYPE html>
<html>
  <head>
    <style>
       #map {
        height: 300px;
        width: 50%;
        margin-left: 350px;
       }
    </style>
  </head>
  <body>
    <h3>My Google Maps Demo</h3>
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
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtjJUiJZMM0UI5XprqKCrUOdFyibNVYIE&callback=initMap">
    </script>
    <!-- AIzaSyBOjPK54KIqRvrg8KkRpa5jfDp9EMgqGuE -->
  </body>
</html>