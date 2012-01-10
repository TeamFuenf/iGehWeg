<style>
  div.olControlAttribution
  {
    display:none;
  }
</style>

<script>
     
var map, selectControl;
        
var markerStyle = new OpenLayers.StyleMap({
  pointRadius: 15,
  externalGraphic: "<?php echo base_url()."images/marker.png"; ?>"
});

var fromProj = new OpenLayers.Projection("EPSG:4326"); // WGS84
var toProj = new OpenLayers.Projection("EPSG:900913"); // Spherical Mercator

var locationUrl = "<?php echo site_url("map/map/getlocations"); ?>";

function initMap()
{                         
  var bounds = new OpenLayers.Bounds();
  bounds.extend(new OpenLayers.LonLat(13.3699780,48.5356778));
  bounds.extend(new OpenLayers.LonLat(13.4993596,48.5855492));
  bounds.transform(fromProj, toProj);

  map = new OpenLayers.Map("map");
  map.setOptions({restrictedExtent: bounds});

  var originalMap = new OpenLayers.Layer.OSM();
  //map.addLayer(originalMap);

  var meetuppMap = new OpenLayers.Layer.OSM("meetupp", "http://images.rawsteel.de.s3.amazonaws.com/meetupp/tiles/${z}/${x}/${y}.png");
  meetuppMap.isBaseLayer = true;
  map.addLayer(meetuppMap);
            
  map.setCenter(new OpenLayers.LonLat(13.46, 48.6).transform(fromProj, toProj), 15);
  map.pan(1,1);

  var strategy = new OpenLayers.Strategy.Cluster();

  var style = new OpenLayers.Style({
    pointRadius: "${radius}",
    fillColor: "#ffcc66",
    fillOpacity: 0.8,
    strokeColor: "#cc6633",
    strokeWidth: "${width}",
    strokeOpacity: 0.8,
    externalGraphic: "<?php echo base_url()."images/marker.png"; ?>"
  }, {
    context: {
      width: function(feature) {
        return (feature.cluster) ? 2 : 1;
      },
      radius: function(feature) {
        var pix = 10;
        if(feature.cluster) {
          pix = Math.min(feature.attributes.count, 7) + 10;
        }
        return pix;
      }
    }
  });

  strategy = new OpenLayers.Strategy.Cluster();

  locations = new OpenLayers.Layer.Vector("Clusters", {
    strategies: [strategy],
    styleMap: new OpenLayers.StyleMap({
      "default": style,
      "select": {
        fillColor: "#8aeeef",
        strokeColor: "#32a8a9"
      }
    })
  });                    
  
  map.addLayer(locations);
  
  OpenLayers.loadURL(locationUrl, {}, null, function(r) {
     var geojsonFormat = new OpenLayers.Format.GeoJSON({
      "internalProjection": toProj,
      "externalProjection": fromProj
      });
     var features = geojsonFormat.read(r.responseText);
     locations.addFeatures(features);  
  });

  selectControl = new OpenLayers.Control.SelectFeature(
    [locations], { clickout: true, toggle: false, multiple: false, hover: false}
  );
  map.addControl(selectControl);
  selectControl.activate();
  
  locations.events.on({
    "featureselected": function(event) {
      openPreviewPopup(event.feature);
    },
    "featureunselected": function(event) {
      closePreviewPopup();
    }
  });          
}

function openPreviewPopup(feature)
{
  var buffer = "";
  for (var i=0; i < feature.cluster.length; i++)
  {
    var locationName = feature.cluster[i].attributes.name;
    buffer += locationName+"\n";
  }
  alert(buffer);
}

function closePreviewPopup()
{
}

</script>

<div id="window">
  <ul id="pages">
    <li>
		<div id="map"></div>
		<script>
		  initMap();
		</script>
    </li>
  </ul>
</div>


