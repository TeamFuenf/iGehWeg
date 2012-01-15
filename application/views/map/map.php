<style>
  div.olControlAttribution
  {
    display:none;
  }

  div.olMapViewport
  {
    z-index: 0;
  }

  div#map
  {
    width:400px
    height:400px;
    margin:0px;
    padding:0px;
  }
  
  div#popup
  {
    display:none;
    width:500px;
    background-color:#fff;
    position:absolute;
    z-index:999;
    border-radius:5px;
    padding:10px;
    margin:0px;
  }
  
  button.button-location-new
  {
    display:none;
  }
  
</style>

<script>




OpenLayers.Control.Click = OpenLayers.Class(OpenLayers.Control, {
    defaultHandlerOptions: {
      'single': true,
      'double': false,
      'pixelTolerance': 0,
      'stopSingle': false,
      'stopDouble': false
    },

    initialize: function(options) {
      this.handlerOptions = OpenLayers.Util.extend(
        {}, this.defaultHandlerOptions
      );
      OpenLayers.Control.prototype.initialize.apply(
        this, arguments
      );
      this.handler = new OpenLayers.Handler.Click(
        this, {
          'click': this.trigger
        }, this.handlerOptions
      );
    },
    
    trigger: function(e) {
      var lonlat = map.getLonLatFromViewPortPx(e.xy);
      lonlat.transform(toProj, fromProj);
      var newLocationUrl = "<?php echo site_url("location/location/getnewlocation/"); ?>/" + lonlat.lon + "/" + lonlat.lat;
      newlocation.removeAllFeatures();
      loadGeoJSON(newLocationUrl, newlocation);
      newlocation.redraw();
    }
    
  });
  
var map, selectControl, clickControl;

var fromProj = new OpenLayers.Projection("EPSG:4326"); // WGS84
var toProj = new OpenLayers.Projection("EPSG:900913"); // Spherical Mercator

var locationUrl = "<?php echo site_url("map/map/getlocations"); ?>";
var friendsUrl = "<?php echo site_url("map/map/getfriends"); ?>";

var locations, friends, newlocation;

function initMap()
{                         
// --- Map Setup --------------------------------------------------------------

  var bounds = new OpenLayers.Bounds();
  bounds.extend(new OpenLayers.LonLat(13.3699780,48.5356778));
  bounds.extend(new OpenLayers.LonLat(13.4993596,48.5855492));
  bounds.transform(fromProj, toProj);

  map = new OpenLayers.Map("map", {
    controls: [
      new OpenLayers.Control.Navigation()
    ]
  });
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
        return feature.attributes.lineColor;
      },
      pointcolor: function(feature)
      {
        return feature.attributes.lineColor;
      }
    }
  });

// --- Layers -----------------------------------------------------------------
    
  locations = new OpenLayers.Layer.Vector("Locations", {
    visibility: true,
    strategies: [locationsStrategy],
    styleMap: locationStyle
  });
  
  friends = new OpenLayers.Layer.Vector("Friends", {
    visibility: true,
    strategies: [friendsStrategy],
    styleMap: friendsStyle
  });
 
  var buslinien = new OpenLayers.Layer.Vector("Buslinien", {
 //   strategies: [buslinesStrategy],
    styleMap: buslinienStyle
  });
  
  newlocation = new OpenLayers.Layer.Vector("newLocation", {
    visibility: false,
    styleMap: locationStyle
  });   

  

  map.addLayer(buslinien);
  
  map.addLayer(locations);
  // locations muss als erstes auf die map, sonst überlagern die Sterne die Benutzerbilder
  map.addLayer(friends);
  map.addLayer(newlocation);


  selectControl = new OpenLayers.Control.SelectFeature(
    [friends, locations, newlocation], { clickout: true, toggle: false, multiple: false, hover: false}
  );
  
  map.addControl(selectControl);
  selectControl.activate();
  
  clickControl = new OpenLayers.Control.Click();
  map.addControl(clickControl);
  clickControl.deactivate();
  
    
// --- Eventhandlers ----------------------------------------------------------
  
  locations.events.on({
    "featureselected": function(evt) {
      openLocationPreviewPopup(evt);
    },
    "featureunselected": function(evt) {
      closePreviewPopup();
    }
  });          

  friends.events.on({
    "featureselected": function(evt) {
      openFriendsPreviewPopup(evt);
    },
    "featureunselected": function(evt) {
      closePreviewPopup();
    }
  });          

  loadGeoJSON(locationUrl, locations);
  loadGeoJSON(friendsUrl, friends);

  loadGPX("http://localhost/gpx/linie1.gpx", buslinien);
  loadGPX("http://localhost/gpx/linie2.gpx", buslinien);
  loadGPX("http://localhost/gpx/linie5.gpx", buslinien);
  loadGPX("http://localhost/gpx/linie6.gpx", buslinien);
  loadGPX("http://localhost/gpx/linie7.gpx", buslinien);
  loadGPX("http://localhost/gpx/linie8.gpx", buslinien);
  loadGPX("http://localhost/gpx/linie9.gpx", buslinien);
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
    
    for (var i=0; i < features.length; i++)
    {
      features[i].attributes.lineName = lineName;
      features[i].attributes.lineColor = lineColor;
    }

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

function openLocationPreviewPopup(evt)
{
  var feature = evt.feature;
  var buffer = "";
  for (var i=0; i < feature.cluster.length; i++)
  {
    var locationName = feature.cluster[i].attributes.name;
    
    buffer += "<a href='#'>" + locationName + "</a><br>";
  }
  $("#popup")
    .html(buffer)
    .show();
}


function openFriendsPreviewPopup(evt)
{
  console.log(evt.xy);
  var feature = evt.feature;
  var buffer = "";
  for (var i=0; i < feature.cluster.length; i++)
  {
    var friendName = feature.cluster[i].attributes.name;
    var friendPicture = feature.cluster[i].attributes.picture;    
    buffer += "<img width='64px' height='64px' style='border-radius:10px' src='" + friendPicture + "'/>" + friendName+"<br>";
  }
  var padding = 25;
  $("#popup")
    .html(buffer)
    .show();
}


function closePreviewPopup()
{
  $("#popup").hide();
}
  
  
function addNewLocation()
{
  locations.setVisibility(false);
  friends.setVisibility(false);
  newlocation.setVisibility(true);
  $(".button-location-new").show();
  $("#button-location-new").hide();
  selectControl.deactivate();
  clickControl.activate();
}


function cancel()
{
  locations.setVisibility(true);
  friends.setVisibility(true);
  newlocation.setVisibility(false);
  newlocation.removeAllFeatures();
  $(".button-location-new").hide();
  $("#button-location-new").show();
  clickControl.deactivate();
  selectControl.activate();
}


function next()
{
  //redirect zu location/addNewLocationForm oder so
  //locations.setVisibility(true);
  //friends.display(true);
  //newlocation.display(false);
  //$(".button-map-location-edit").hide();
  //$("#button-location-new").show();
  pageNext();
}

$("button#button-location-new-next").on("click", function() {
  // mach was
  pageNext();
});

</script>

<div id="window">
  <ul id="pages">
    <li>
      <div id="popup">Popup</div>
      
      <div id="map">
        <button id="button-location-new" type="button" onclick="addNewLocation()">+ Location</button>
        <button id="button-location-new-cancel" class="button-location-new" type="button" onclick="cancel()">Abbrechen</button>
        <button id="button-location-new-next" class="button-location-new" type="button">Weiter</button>
        <a class="button internal" id="22" href="javascript:pageNext()">weiterlink</a>
      </div>
      <script>initMap();</script>
    </li>
    <li>
<!--  neue Location anlegen      -->
      <button id="button-location-add-back" class="button-location-add" type="button" onclick="back()">Zurück</button>
      <button id="button-location-add-cancel" class="button-location-add" type="button" onclick="cancel()">Abbrechen</button>
      <button id="button-location-add-save" class="button-location-add" type="button" onclick="addLocation()">Fertig</button>
      <?php echo site_url("location/location/getnewlocationform/"); ?>
    </li>
    <li>
<!--  bestehende Location bearbieten/löschen      -->
      <button id="button-location-edit-back" class="button-map-location-edit" type="button" onclick="back()">Zurück</button>
      <?php echo site_url("location/location/geteditlocationform/"); ?>
    </li>
  </ul>
</div>