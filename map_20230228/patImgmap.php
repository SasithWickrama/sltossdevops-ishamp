<?php

session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){

    $i=0;

    include "../db/DbOperations.php";
    $db = new DbOperations;
    $areas = $_SESSION["uarea"];
    $usr = $_SESSION["uid"];
    $con = $_SESSION["ucatagory"];
    $rjctImg = $_SESSION["RjctImg"];

    $imgId = $_GET['imgId'];

}else{
    echo '<script type="text/javascript"> document.location = "../login";</script>';
}


?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>TechsPro - PAT IMG MAP VIEW</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico"/>

    <style>
   html, body {
        height: 100%;
        padding: 0;
        margin: 0;
        overflow: hidden;
        }
      #map {
       height: 100%;
       width: 100%;
       overflow: hidden;
       float: left;
       border: thin solid #333;
       }

      
    </style>
  </head>
  <body>  

	<div id="map"></div>
   
  <script> var patimg; </script>
	
	<script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACf3KGqbKylkAoI4MkjKTdwlbdoCMD-rY&libraries=drawing&callback=iniMap">
  </script>
	
	<div id="google_map">

	</div>
	
	<div style="display:none">
		<input type="text" id="imgId" value="<?php echo $imgId;?>" />
	</div>
	
	</div>

<script src="../assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="../assets/js/geoxml3.js"></script>

<script>

function iniMap() {
	
	var marker;
	
	map = new google.maps.Map(document.getElementById('map'), {
	  center: new google.maps.LatLng(7.927079, 80.761244),
	  zoom: 8,
	 // mapTypeId: 'satellite'
	});
		
  var infoWindow = new google.maps.InfoWindow();
  infowindow2 = new google.maps.InfoWindow();

	map.addListener('click', function() {
	
	var divs = document.getElementsByClassName("gm-style-iw-a"); //geoxml3_infowindow");
	console.log(divs.length);
	
	for(var i=0; i<divs.length;i++ ){
		divs[i].style.display = "none";
	}
	
	});	
	
	loadmapdata();
       
}


function loadmapdata(){
		
		var imgId = document.getElementById('imgId').value;	
		
		$.ajax({ type: "POST",url: "./kmlcreate/mapviewcreate.php", data: {imgId:imgId},success: function(result){	
      
			patimg = new geoXML3.parser({map: map});
			patimg.parse('kmlfiles/mapview.kml');
			
		}});
		
}

</script>

  </body>
</html>