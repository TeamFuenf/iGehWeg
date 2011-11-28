<html>
	<head>
		<title>HTML5 geolocation with Openstreetmap and OpenLayers</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<style type="text/css">
			^
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
                
                width:480px;
                height:320px;
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
		</style>
		<!--<script src="../javascript/OpenLayers.mobile.js"></script>-->
		<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
		
		<script>
			// initialize map when page ready
			

			// Get rid of address bar on iphone/ipod
			var fixSize = function() {
				window.scrollTo(0, 0);
				document.body.style.height = '100%';
				if(!(/(iphone|ipod)/.test(navigator.userAgent.toLowerCase()))) {
					if(document.body.parentNode) {
						document.body.parentNode.style.height = '100%';
					}
				}
			};
			setTimeout(fixSize, 700);
			setTimeout(fixSize, 1500);
			
			var init = function() {
				
				var fromProj = new OpenLayers.Projection("EPSG:4326"); // transform from WGS 1984
            	var toProj = new OpenLayers.Projection("EPSG:900913"); // to Spherical Mercator Projection
				
				// create map
				map = new OpenLayers.Map("map", {projection : toProj});
				
				//var bounds = new OpenLayers.Bounds(48.5356778,13.3699780, 48.5855492,13.4993596);		
				
				var orgmap = new OpenLayers.Layer.OSM();
//				var mymap = new OpenLayers.Layer.OSM("AlexLayer", "http://dl.dropbox.com/u/948390/Tiles/${z}/${x}/${y}.png", {numZoomLevels: 6});
				var mymap = new OpenLayers.Layer.OSM("AlexLayer", "http://dl.dropbox.com/u/948390/Tiles/${z}/${x}/${y}.png");
    			map.addLayer(mymap);
    			//map.zoomToMaxExtent();
    			map.setCenter(new OpenLayers.LonLat(13.4635546,48.5738242).transform(fromProj, toProj), 14);
 
 				var bounds = new OpenLayers.Bounds();
				bounds.extend(new OpenLayers.LonLat(13.3699780,48.5356778)); //.transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913")));
				bounds.extend(new OpenLayers.LonLat(13.4993596,48.5855492)); //.transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913")));
				bounds.transform(fromProj, toProj);
 
				map.setOptions({restrictedExtent: bounds});
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