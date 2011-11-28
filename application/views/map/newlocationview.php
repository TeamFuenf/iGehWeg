<html>

<body>
<script src="../javascript/jquery.js"></script>
<a href="/map">Back</a>
<br>
<script>

var lat;
var lon;

navigator.geolocation.getCurrentPosition(function(position)
{       	 
	lat = position.coords.latitude;
	lon = position.coords.longitude;
	$(function()
	{
		$("a#actpos").attr("href", "addCurrentPos?lat=" + lat + "&lon=" + lon);
	});
});

/*
          //  document.getElementById('anzeige').innerHTML="Latitude: " + position.coords.latitude + "   Longitude: " +
          //  position.coords.longitude + "<p>";
var lonLat = new OpenLayers.LonLat(position.coords.longitude, position.coords.latitude)
                      .transform(
                                  new OpenLayers.Projection("EPSG:4326"), //transform from WGS 1984
                                              map.getProjectionObject() //to Spherical Mercator Projection
                                            );
                                            
            markers.addMarker(new OpenLayers.Marker(lonLat));
      
            map.setCenter(lonLat, 14 // Zoom level
            );         
        });
*/
</script>

<a id="actpos" href="addCurrentPos">über aktuelle Position</a>
<br>
<a href="addAdress">über Adresseingabe</a>

</body>
</html>