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
// --- Map Setup --------------------------------------------------------------

  var bounds = new OpenLayers.Bounds();
  bounds.extend(new OpenLayers.LonLat(13.3699780,48.5356778));
  bounds.extend(new OpenLayers.LonLat(13.4993596,48.5855492));
  bounds.transform(fromProj, toProj);

  map = new OpenLayers.Map("map");
  map.setOptions({restrictedExtent: bounds});

  var meetuppMap = new OpenLayers.Layer.OSM("meetupp", "http://images.rawsteel.de.s3.amazonaws.com/meetupp/tiles/${z}/${x}/${y}.png");
  meetuppMap.isBaseLayer = true;
  map.addLayer(meetuppMap);
            
  map.setCenter(new OpenLayers.LonLat(13.46, 48.6).transform(fromProj, toProj), 15);
  map.pan(1,1);

// --- Cluster Strategys ------------------------------------------------------

  var friendsStrategy = new OpenLayers.Strategy.Cluster();
  friendsStrategy.distance = 50;

  var locationsStrategy = new OpenLayers.Strategy.Cluster();
  locationsStrategy.distance = 45;
  locationsStrategy.threshold = 1;

  var buslinesStrategy = new OpenLayers.Strategy.Cluster();
  locationsStrategy.distance = 25;
  locationsStrategy.threshold = 1;

// --- Styles -----------------------------------------------------------------

  var locationStyle = new OpenLayers.Style({
    pointRadius: "${radius}",
    fillOpacity: 0.5,
    externalGraphic: "<?php echo base_url()."images/marker_star.png"; ?>"
  }, {
    context: {
      radius: function(feature) {
        var pix = 15;
        if(feature.cluster) {
          pix = Math.min(feature.attributes.count, 7) + 15;
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

  var buslinienStyle = new OpenLayers.Style({
    pointRadius: "5",
    fillOpacity: "0.5",    
    fillColor: "${pointcolor}",
    strokeOpacity: "0.5",
    strokeColor: "${linecolor}"
  }, {
    context: {
      linecolor: function(feature)
      {        
        return "#ff0000";
      },
      pointcolor: function(feature)
      {
        return "#ff0000";
      }
    }
  });

// --- Layers -----------------------------------------------------------------
    
  var locations = new OpenLayers.Layer.Vector("Locations", {
    strategies: [locationsStrategy],
    styleMap: locationStyle
  });                    
  
  var friends = new OpenLayers.Layer.Vector("Friends", {
    strategies: [friendsStrategy],
    styleMap: friendsStyle
  });
 
  var buslinien = new OpenLayers.Layer.Vector("Buslinien", {
 //   strategies: [buslinesStrategy],
    styleMap: buslinienStyle
  });

  map.addLayer(locations);
  map.addLayer(friends);
  map.addLayer(buslinien);


  selectControl = new OpenLayers.Control.SelectFeature(
    [friends, locations], { clickout: true, toggle: false, multiple: false, hover: false}
  );
  
  map.addControl(selectControl);
  selectControl.activate();
    
// --- Eventhandlers ----------------------------------------------------------
  
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

  loadGeoJSON(locationUrl, locations);
  loadGeoJSON(friendsUrl, friends);

  loadGPX("http://localhost/gpx/linie1.gpx", buslinien);
/*
  loadGPX("http://localhost/gpx/linie2.gpx", buslinien);
  loadGPX("http://localhost/gpx/linie5.gpx", buslinien);
  loadGPX("http://localhost/gpx/linie6.gpx", buslinien);
*/
}

function loadGPX(url, layer)
{
  OpenLayers.loadURL(url, {}, null, function(r) {
    var gpxFormat = new OpenLayers.Format.GPX({
      "internalProjection": toProj,
      "externalProjection": fromProj
    });

    var xmlDoc = $($.parseXML(r.responseText));
    var metadata = xmlDoc.find("metadata");
  
    var lineName = metadata.find("linie").text();
    var lineColor = metadata.find("color").text();
    activeColor = lineColor;

    var features = gpxFormat.read(r.responseText);
    
    layer.addFeatures(features);  
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