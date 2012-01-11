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
var friendsUrl = "<?php echo site_url("map/map/getfriends"); ?>";

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

  var friendsStrategy = new OpenLayers.Strategy.Cluster();
  friendsStrategy.distance = 50;

  var locationsStrategy = new OpenLayers.Strategy.Cluster();
  locationsStrategy.distance = 30;
  locationsStrategy.threshold = 1;

  var locationStyle = new OpenLayers.Style({
    pointRadius: "${radius}",
    fillOpacity: 0.5,
    externalGraphic: "<?php echo base_url()."images/marker_star.png"; ?>"
  }, {
    context: {
      radius: function(feature) {
        var pix = 10;
        if(feature.cluster) {
          pix = Math.min(feature.attributes.count, 7) + 10;
        }
        return pix;
      }
    }
  });
  
  var friendsStyle = new OpenLayers.Style({
    pointRadius: "20",
    fillColor: "#ffcc66",
    externalGraphic: "${image}"
  }, {
    context: {
      image: function(feature) {        
        if (feature.cluster.length == 1)
        {
          var imgurl = feature.cluster[0].attributes.picture;
        }
        else
        {
          var imgurl = "<?php echo base_url()."images/marker_friends.png"; ?>";
        }
        return imgurl;
      }
    }
  });
  
  var locations = new OpenLayers.Layer.Vector("Locations", {
    strategies: [locationsStrategy],
    styleMap: locationStyle
  });                    
  
  var friends = new OpenLayers.Layer.Vector("Friends", {
    strategies: [friendsStrategy],
    styleMap: friendsStyle
  });
 
  map.addLayer(locations);
  map.addLayer(friends);
  
  loadGeoJSON(locationUrl, locations);
  loadGeoJSON(friendsUrl, friends);

  selectControl = new OpenLayers.Control.SelectFeature(
    [friends, locations], { clickout: true, toggle: false, multiple: false, hover: false}
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

  friends.events.on({
    "featureselected": function(event) {
      openPreviewPopup(event.feature);
    },
    "featureunselected": function(event) {
      closePreviewPopup();
    }
  });          

}

function loadGeoJSON(url, layer)
{
  OpenLayers.loadURL(url, {}, null, function(r) {
     var geojsonFormat = new OpenLayers.Format.GeoJSON({
      "internalProjection": toProj,
      "externalProjection": fromProj
      });
     var features = geojsonFormat.read(r.responseText);
     layer.addFeatures(features);  
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


