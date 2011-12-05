<style>

div.olControlAttribution
{
  display:none;
}       
</style>
		
<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
<!--
    <script src="../javascript/OpenLayers.js"></script>
-->
		<script>

			var init = function()
			{
        // Projektionen
        var fromProj = new OpenLayers.Projection("EPSG:4326"); // transform from WGS 1984
        var toProj = new OpenLayers.Projection("EPSG:900913"); // to Spherical Mercator Projection
				
				// Icons
        var size = new OpenLayers.Size(21,25);
        var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
        var icon = new OpenLayers.Icon('http://www.openlayers.org/dev/img/marker.png',size,offset);
        var locationicon = new OpenLayers.Icon('http://www.openlayers.org/dev/img/marker.png',size,offset);

        var friendIconSize = new OpenLayers.Size(44,54);
        var friendIconOffset = new OpenLayers.Pixel(-(friendIconSize.w/2), -friendIconSize.h);
        var friendIcon123 = new OpenLayers.Icon("../helper/images/user/marker/123", friendIconSize, friendIconOffset);
        var friendIcon124 = new OpenLayers.Icon("../helper/images/user/marker/124", friendIconSize, friendIconOffset);
        var friendIcon125 = new OpenLayers.Icon("../helper/images/user/marker/125", friendIconSize, friendIconOffset);

        var eventIconSize = new OpenLayers.Size(32,32);
        var eventIconOffset = new OpenLayers.Pixel(-(eventIconSize.w/2), -eventIconSize.h);
        var eventIcon = new OpenLayers.Icon('http://www.openlayers.org/dev/img/marker.png',size,offset);

				// Bounds
        var bounds = new OpenLayers.Bounds();
        bounds.extend(new OpenLayers.LonLat(13.3699780,48.5356778));
        bounds.extend(new OpenLayers.LonLat(13.4993596,48.5855492));
        bounds.transform(fromProj, toProj);
				
				// Map
				map = new OpenLayers.Map("map", {
				  projection : toProj, 
				  controls: [new OpenLayers.Control.Navigation(), new OpenLayers.Control.ZoomPanel()]
				});
        map.setOptions({restrictedExtent: bounds});
        //map.zoomToMaxExtent();
                
        // Layer
				var meetuppMap = new OpenLayers.Layer.OSM("meetupp", "http://dl.dropbox.com/u/948390/Tiles/${z}/${x}/${y}.png");
        var originalMap = new OpenLayers.Layer.OSM();

        var locations = new OpenLayers.Layer.Markers("Locations");
        var friends = new OpenLayers.Layer.Markers("Friends");
        var events = new OpenLayers.Layer.Markers("Events");
            
        // Locations
        <?php echo $markerLocations; ?>;

        // Friends
        <?php echo $markerFriends; ?>;
/*        
        var friend123 = new OpenLayers.Marker(new OpenLayers.LonLat(13.4454215, 48.5631164).transform(fromProj, toProj), friendIcon123);0        
        var friend124 = new OpenLayers.Marker(new OpenLayers.LonLat(13.4632595, 48.5732856).transform(fromProj, toProj), friendIcon124);0        
        var friend125 = new OpenLayers.Marker(new OpenLayers.LonLat(13.4672211, 48.5744110).transform(fromProj, toProj), friendIcon125);0        
        friends.addMarker(friend123);
        friends.addMarker(friend124);
        friends.addMarker(friend125);
*/        
        // Events
        <?php echo $markerEvents; ?>;
                
        map.addLayer(originalMap);
        map.addLayer(meetuppMap);
        map.addLayer(locations);
        map.addLayer(friends);
        map.addLayer(events);
                

        // Map einrichten
        map.setCenter(new OpenLayers.LonLat(13.4635546,48.5738242).transform(fromProj, toProj), 13);
        map.addControl(new OpenLayers.Control.LayerSwitcher());
        map.addControl(new OpenLayers.Control.Attribution());
        
      };

		</script>
	</head>
	<body>
		<div id="map"></div>
		<script>
		  init();
		</script>
		