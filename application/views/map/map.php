<style>

  div.olControlAttribution
  {
    display:none;
  }       

  #pages ul
  {
    margin:0px;
    padding:0px;
    list-style-type:none;
  }

  #pages ul li
  {
    padding-top:1em;
    padding-bottom:1em;
  }

  #pages a
  {
    color:#666;
    text-decoration:none;
  }

</style>

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

        var locationIconSize = new OpenLayers.Size(24,24);
        var locationOffset = new OpenLayers.Pixel(-(locationIconSize.w/2), -locationIconSize.h);
        var locationicon = new OpenLayers.Icon('<?php echo base_url("images/marker_event.png");; ?>',locationIconSize,locationOffset);

        var friendIconSize = new OpenLayers.Size(44,44);
        var friendIconOffset = new OpenLayers.Pixel(-(friendIconSize.w/2), -friendIconSize.h);
        //var friendIcon123 = new OpenLayers.Icon("../helper/images/user/marker/123", friendIconSize, friendIconOffset);
        //var friendIcon124 = new OpenLayers.Icon("../helper/images/user/marker/124", friendIconSize, friendIconOffset);
        //var friendIcon125 = new OpenLayers.Icon("../helper/images/user/marker/125", friendIconSize, friendIconOffset);

        var eventIconSize = new OpenLayers.Size(32,32);
        var eventIconOffset = new OpenLayers.Pixel(-(eventIconSize.w/2), -eventIconSize.h);
        var eventIcon = new OpenLayers.Icon('http://www.openlayers.org/dev/img/marker.png',eventIconSize,eventIconOffset);

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
        <?php echo $markerLocations; ?>

        // Friends
        <?php echo $markerFriends; ?>

        // Events
        <?php echo $markerEvents; ?>
        

        
        
        
        map.addLayer(originalMap);
        map.addLayer(meetuppMap);
        
        map.addLayer(locations);
        map.addLayer(friends);
        map.addLayer(events);
        
        
        
      // var textfile = "lat\t lon\t title\t description\t iconSize\t iconOffset\t icon\n 48.5744110\t 13.4672211\t title\t description\t 21,25\t -10,-25\t http://www.openlayers.org/dev/img/marker.png";

        
        
        //var pois = new OpenLayers.Layer.Text( "My Points",
          //          { location: textfile,
            //          projection: map.displayProjection
              //      });
        
        //map.addLayer(pois);
                

        // Map einrichten
        map.setCenter(new OpenLayers.LonLat(13.4635546,48.5738242).transform(fromProj, toProj), 13);
        map.addControl(new OpenLayers.Control.LayerSwitcher());
        //map.addControl(new OpenLayers.Control.Attribution());
        
      };

</script>

</head>

<div id="window">
  <ul id="pages">
    <li>

		<div id="map"></div>
		<script>
		  init();
		</script>

    </li>
    <li>
      <div>
        <h1>Seite 2</h1>
        Location Details
      </div>
    </li>
    <li>
      <div>
        <h1>Seite 3</h1>
        neue Location hinzufügen
      </div>
    </li>
  </ul>
</div>


