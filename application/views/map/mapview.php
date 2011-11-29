<html>
	<head>
		<title>meetupp - map</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<style type="text/css">
		
    body
    {
      margin:0px;
      padding:0px;
    }
    
		div.olControlAttribution
		{
		  display:none;
		}
    		
/*			
			div.olControlZoomPanel {
			height: 108px;
			width: 36px;
			position: absolute;
			top: 20px;
			left: 20px;
			}
			div.olControlZoomPanel div {
			width: 36px;
			height: 36px;
			background-image: url(img/mobile-zoombar.png);
			left: 0;
			}
			div.olControlZoomPanel .olControlZoomInItemInactive {
			top: 0;
			background-position: 0 0;
			}
			div.olControlZoomPanel .olControlZoomToMaxExtentItemInactive {
			top: 36px;
			background-position: 0 -36px;
			}
			div.olControlZoomPanel .olControlZoomOutItemInactive {
			top: 72px;
			background-position: 0 -72px;
			}




			html, body {
                margin  : 0;
                padding : 0;
                height  : 100%;
                width   : 100%;
            }
            @media only screen and (max-width: 600px) {
                html, body {
                    height  : 117%;
                }
            }
            #map {
                width    : 100%;
                position : relative;
                height   : 100%;

            }
            .olControlAttribution {
                position      : absolute;
                font-size     : 10px;
                bottom        : 0 !important;
                right         : 0 !important;
                background    : rgba(0,0,0,0.1);
                font-family   : Arial;
                padding       : 2px 4px;
                border-radius : 5px 0 0 0;
            }
            div.olControlZoomPanel .olControlZoomInItemInactive,
            div.olControlZoomPanel .olControlZoomOutItemInactive {
                background: rgba(0,0,0,0.2);
                position: absolute;
            }
            div.olControlZoomPanel .olControlZoomInItemInactive {
                border-radius: 5px 5px 0 0;
            }
            div.olControlZoomPanel .olControlZoomOutItemInactive {
                border-radius: 0 0 5px 5px ;
                top: 37px;
            }
            div.olControlZoomPanel .olControlZoomOutItemInactive:after ,
            div.olControlZoomPanel .olControlZoomInItemInactive:after{
                font-weight: bold;
                content   : '+';
                font-size : 36px;
                padding:  7px;
                z-index: 2000;
                color     : #fff;
                line-height: 1em;
            }
            div.olControlZoomPanel .olControlZoomOutItemInactive:after{
                content: '–';
                line-height: 0.9em;
                padding: 0 8px;
            }
            div.olControlZoomPanel .olControlZoomToMaxExtentItemInactive {
                display: none;
            }
            #title, #tags, #shortdesc {
                display: none;
            }
*/            
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
				  controls: [new OpenLayers.Control.Navigation()]
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
        
        var scharfrichter = new OpenLayers.Marker(new OpenLayers.LonLat(13.4693767, 48.5748142).transform(fromProj, toProj), icon);
        var aquarium = new OpenLayers.Marker(new OpenLayers.LonLat(13.4635546, 48.5738242).transform(fromProj, toProj), icon.clone());
        var shamrock = new OpenLayers.Marker(new OpenLayers.LonLat(13.4604024, 48.5755427).transform(fromProj, toProj), icon.clone());        
        locations.addMarker(scharfrichter);
        locations.addMarker(aquarium);
        locations.addMarker(shamrock);

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
                
        map.addLayer(meetuppMap);
        map.addLayer(originalMap);
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
	</body>
</html>