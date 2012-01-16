<style>
  div.olControlAttribution
  {
    display:none;
  }

  .olControlScaleLine
  {
    width:100px;
    position:relative;
    bottom:0px;
    left:540px;
    padding: 4px;
  }

  div.olControlScaleLineTop
  {
    color:#000;
    font-size:20px;
  }

  div.olControlScaleLineBottom
  {
    display:none;
  }
      
  div.olMapViewport
  {
    z-index: 0;
  }
  
  div#map
  {
    width:640px;
  }
  
  div#popup
  {
    display:none;
    width:540px;
    background-color:#fff;
    position:absolute;
    left:50px;
    top:50px;
    z-index:999;
    border-radius:5px;
    padding:0px;
    margin:0px;
    overflow:hidden;
  
    -webkit-box-shadow: 25px 5px 300px 5px rgba(0, 0, 0, 0.5);
    -moz-box-shadow: 25px 5px 300px 5px rgba(0, 0, 0, 0.5);
    box-shadow: 25px 5px 300px 5px rgba(0, 0, 0, 0.5); 
  }
  
  div#popup p
  {
    padding:10px;
  }
  
  div#popup ul
  {
    margin:0px;
    padding:0px;
    list-style-type:none;
  }
  
  div#popup input
  {
    width:40px;
    height:40px;
  }
  
  div#popup li
  {
    padding:20px;
  }
  
  div#popup li:not(:last-child)
  {
    border-bottom:1px solid #999;
  }
  
  div#popup a
  {
    text-decoration:none;
    color:#999;
  }
  
  div#popup li img
  {
    padding-right:20px;
    vertical-align:middle;
  }

  div#popup li.layer
  {
    padding:5px;
    border:0px;
  }

  div#popup li.layer[show=true]
  {
    color:#666;
  }

  div#popup li.layer[show=false]
  {
    color:#ddd;
  }
  
  button#button-location-add
  {
    position:absolute;
    top:10px;
    left:10px;
    z-index:990;
  }
  
  button#button-location-new-cancel, button#button-location-new-next, div#popupErrorMsg
  {
    display:none;
  }

  button#layerswitcher
  {
    position:absolute;
    top:650px;
    left:10px;
    z-index:990;
  }
  
</style>

<script>
  
var map, selectControl, clickControl;

var fromProj = new OpenLayers.Projection("EPSG:4326"); // WGS84
var toProj = new OpenLayers.Projection("EPSG:900913"); // Spherical Mercator

var locationUrl = "<?php echo site_url("map/map/getlocations"); ?>";
var friendsUrl = "<?php echo site_url("map/map/getfriends"); ?>";
var eventsUrl = "<?php echo site_url("map/map/getevents"); ?>";

var locations, friends, events, newlocation, newlocationlonlat;
var buslinie1, buslinie2, buslinie5, buslinie6, buslinie7, buslinie8, buslinie9;

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
      newlocationlonlat = map.getLonLatFromViewPortPx(e.xy);
      newlocationlonlat.transform(toProj, fromProj);
      var newLocationUrl = "<?php echo site_url("location/getnewlocation/"); ?>/" + newlocationlonlat.lon + "/" + newlocationlonlat.lat;
      newlocation.removeAllFeatures();
      loadGeoJSON(newLocationUrl, newlocation);
      newlocation.redraw();
    }
    
  });


function initMap()
{                         
// --- Map Setup --------------------------------------------------------------

  var bounds = new OpenLayers.Bounds();
  bounds.extend(new OpenLayers.LonLat(13.3699780,48.5356778));
  bounds.extend(new OpenLayers.LonLat(13.4993596,48.5855492));
  bounds.transform(fromProj, toProj);

  scale = new OpenLayers.Control.ScaleLine();
  scale.geodesic = true;

  map = new OpenLayers.Map("map", {
    controls: [
      new OpenLayers.Control.Navigation(),
      scale
    ]
  });
  map.setOptions({restrictedExtent: bounds});

  var meetuppMap = new OpenLayers.Layer.OSM("meetupp", "http://images.rawsteel.de.s3.amazonaws.com/meetupp/tiles2/${z}/${x}/${y}.png");
  meetuppMap.isBaseLayer = true;
  map.addLayer(meetuppMap);
  
  var userLon = 13.46;
  var userLat = 48.6;
  
  if (navigator.geolocation)
  {
    navigator.geolocation.getCurrentPosition(
      function(position)
      {      
        userLon = position.coords.longitude;
        userLat = position.coords.latitude;        
      }
    );
  }

  map.setCenter(new OpenLayers.LonLat(userLon, userLat).transform(fromProj, toProj), 15);

// --- Cluster Strategys ------------------------------------------------------

  var friendsStrategy = new OpenLayers.Strategy.Cluster();
  friendsStrategy.distance = 50;

  var locationsStrategy = new OpenLayers.Strategy.Cluster();
  locationsStrategy.distance = 45;
  locationsStrategy.threshold = 1;

  var eventsStrategy = new OpenLayers.Strategy.Cluster();
  eventsStrategy.distance = 45;
  eventsStrategy.threshold = 1;

  var buslinesStrategy = new OpenLayers.Strategy.Cluster();

// --- Styles -----------------------------------------------------------------

  var locationStyle = new OpenLayers.StyleMap({
    "default" : new OpenLayers.Style({
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
    }),
    "selected" : new OpenLayers.Style({
      pointRadius: "25"
    })
  });
  
  var eventsStyle = new OpenLayers.StyleMap({
    "default" : new OpenLayers.Style({
      pointRadius: "${radius}",
      fillOpacity: 0.5,
      externalGraphic: "<?php echo base_url()."images/marker_clock.png"; ?>"
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
    }),
    "selected" : new OpenLayers.Style({
      pointRadius: "25"
    })
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

  var buslinienStyle = new OpenLayers.StyleMap({
    "default": new OpenLayers.Style({
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
    }),
    "select": new OpenLayers.Style({
      pointRadius: "15"
    })
  });

// --- Layers -----------------------------------------------------------------
    
  locations = new OpenLayers.Layer.Vector("Locations", {
    visibility: <? echo $layer["locations"];?>,
    strategies: [locationsStrategy],
    styleMap: locationStyle
  });
  
  friends = new OpenLayers.Layer.Vector("Friends", {
    visibility: <? echo $layer["friends"];?>,
    strategies: [friendsStrategy],
    styleMap: friendsStyle
  });

  events = new OpenLayers.Layer.Vector("Events", {
    visibility: <? echo $layer["events"];?>,
    strategies: [eventsStrategy],
    styleMap: eventsStyle
  });
  
  buslinie1 = new OpenLayers.Layer.Vector("Linie 1", { visibility: <?php echo $layer["buslinie1"]; ?>, strategies: [buslinesStrategy], styleMap: buslinienStyle });
  buslinie2 = new OpenLayers.Layer.Vector("Linie 2", { visibility: <?php echo $layer["buslinie2"]; ?>, strategies: [buslinesStrategy], styleMap: buslinienStyle });
  buslinie5 = new OpenLayers.Layer.Vector("Linie 5", { visibility: <?php echo $layer["buslinie5"]; ?>, strategies: [buslinesStrategy], styleMap: buslinienStyle });
  buslinie6 = new OpenLayers.Layer.Vector("Linie 6", { visibility: <?php echo $layer["buslinie6"]; ?>, strategies: [buslinesStrategy], styleMap: buslinienStyle });
  buslinie7 = new OpenLayers.Layer.Vector("Linie 7", { visibility: <?php echo $layer["buslinie7"]; ?>, strategies: [buslinesStrategy], styleMap: buslinienStyle });
  buslinie8 = new OpenLayers.Layer.Vector("Linie 8", { visibility: <?php echo $layer["buslinie8"]; ?>, strategies: [buslinesStrategy], styleMap: buslinienStyle });
  buslinie9 = new OpenLayers.Layer.Vector("Linie 9", { visibility: <?php echo $layer["buslinie9"]; ?>, strategies: [buslinesStrategy], styleMap: buslinienStyle });
  
  newlocation = new OpenLayers.Layer.Vector("newLocation", {
    visibility: false,
    styleMap: locationStyle
  });   

  map.addLayer(buslinie1);
  map.addLayer(buslinie2);
  map.addLayer(buslinie5);
  map.addLayer(buslinie6);
  map.addLayer(buslinie7);
  map.addLayer(buslinie8);
  map.addLayer(buslinie9);  
  map.addLayer(friends);
  map.addLayer(locations);
  map.addLayer(events);
  map.addLayer(newlocation);

  selectControl = new OpenLayers.Control.SelectFeature(
    [
      friends, 
      locations, 
      newlocation, 
      events,
      buslinie1,
      buslinie2,
      buslinie5,
      buslinie6,
      buslinie7,
      buslinie8,
      buslinie9
    ], { clickout: true, toggle: false, multiple: false, hover: false}
  );
  
  map.addControl(selectControl);
  selectControl.activate();
  
  clickControl = new OpenLayers.Control.Click();
  map.addControl(clickControl);
  clickControl.deactivate();
  
        
// --- Eventhandlers ----------------------------------------------------------
  
  locations.events.on({
    "featureselected": function(evt) {
      openLocationPopup(evt);
    },
    "featureunselected": function(evt) {
      closePopup();
    }
  });          

  friends.events.on({
    "featureselected": function(evt) {
      openFriendsPopup(evt);
    },
    "featureunselected": function(evt) {
      closePopup();
    }
  });          

  events.events.on({
    "featureselected": function(evt) {
      openEventsPopup(evt);
    },
    "featureunselected": function(evt) {
      closePopup();
    }
  });  
  
  buslinie1.events.on({"featureselected": function(evt) { openBuslinienPopup(evt); }, "featureunselected": function(evt) { closePopup(); }});
  buslinie2.events.on({"featureselected": function(evt) { openBuslinienPopup(evt); }, "featureunselected": function(evt) { closePopup(); }});
  buslinie5.events.on({"featureselected": function(evt) { openBuslinienPopup(evt); }, "featureunselected": function(evt) { closePopup(); }});
  buslinie6.events.on({"featureselected": function(evt) { openBuslinienPopup(evt); }, "featureunselected": function(evt) { closePopup(); }});
  buslinie7.events.on({"featureselected": function(evt) { openBuslinienPopup(evt); }, "featureunselected": function(evt) { closePopup(); }});
  buslinie8.events.on({"featureselected": function(evt) { openBuslinienPopup(evt); }, "featureunselected": function(evt) { closePopup(); }});
  buslinie9.events.on({"featureselected": function(evt) { openBuslinienPopup(evt); }, "featureunselected": function(evt) { closePopup(); }});
    
  loadGeoJSON(locationUrl, locations);
  loadGeoJSON(friendsUrl, friends);
  loadGeoJSON(eventsUrl, events);

  loadGPX("<?php echo site_url("gpx/linie1.gpx");?>", buslinie1);
  loadGPX("<?php echo site_url("gpx/linie2.gpx");?>", buslinie2);
  loadGPX("<?php echo site_url("gpx/linie5.gpx");?>", buslinie5);
  loadGPX("<?php echo site_url("gpx/linie6.gpx");?>", buslinie6);
  loadGPX("<?php echo site_url("gpx/linie7.gpx");?>", buslinie7);
  loadGPX("<?php echo site_url("gpx/linie8.gpx");?>", buslinie8);
  loadGPX("<?php echo site_url("gpx/linie9.gpx");?>", buslinie9);
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
//    layer.setVisibility(false);
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

function openLocationPopup(evt)
{
  var feature = evt.feature;
  var buffer = "";
  var numLocations = feature.cluster.length;
  if (numLocations > 1)
  {
    buffer = "<p>mehrere Locations:</p>";
    if (numLocations > 5 && map.getZoom() != 18)
    {
      buffer = "<p>Mehr als 5 Locations an dieser Position gefunden. Zoome näher heran um mehr Informationen zu erhalten.</p>";
    }
    else
    {
      buffer += "<ul>";
      for (var i=0; i < feature.cluster.length; i++)
      {
        var locationName = feature.cluster[i].attributes.name;
        var locationId = feature.cluster[i].attributes.id;
        buffer += "<a href='javascript:getLocationDetails(" + locationId + ")'>" + locationName + "</a><br>";
      }
      buffer += "</ul>";
    }
  }
  else
  {
    var locationName = feature.cluster[0].attributes.name;
    var locationId = feature.cluster[0].attributes.id;
    buffer += "<a href='javascript:getLocationDetails(" + locationId + ")'>" + locationName + "</a><br>";
  }
  
  $("#popup")
    .html(buffer)
    .show();
}

function openFriendsPopup(evt)
{
  var feature = evt.feature;
  var buffer = "";
  var numFriends = feature.cluster.length;
  if (numFriends > 1)
  {
    buffer = "<p>mehrere Freunde:</p>";
    if (numFriends > 5 && map.getZoom() != 18)
    {
      buffer = "<p>Mehr als 5 Freunde an dieser Position gefunden. Zoome näher heran um mehr Informationen zu erhalten.</p>";
    }
    else
    {
      buffer += "<ul>";
      for (var i=0; i < numFriends; i++)
      {
        var friendName = feature.cluster[i].attributes.name;
        var friendPicture = feature.cluster[i].attributes.picture;
        var friendId = feature.cluster[i].attributes.id;        
        var link = "<?php echo site_url("mail");?>/" + friendId;
        buffer += "<li><a href='" + link + "'><img width='64px' height='64px' style='border-radius:10px' src='" + friendPicture + "'/>" + friendName+"</a></li>";
      }
      buffer += "</ul>";
    }
  }
  else
  {
    var friendName = feature.cluster[0].attributes.name;
    var friendPicture = feature.cluster[0].attributes.picture;
    var friendId = feature.cluster[0].attributes.id;        
    var link = "<?php echo site_url("mail");?>/" + friendId;
    buffer = "<ul><li><a href='" + link + "'><img width='64px' height='64px' style='border-radius:10px' src='" + friendPicture + "'/>" + friendName+"</a></li></ul>";
  }

  $("#popup")
    .html(buffer)
    .show();
}

function openEventsPopup(evt)
{
  var feature = evt.feature;
  var buffer = "";
  var numEvents = feature.cluster.length;
  if (numEvents > 1)
  {
    buffer = "<p>mehrere Events:</p>";
    if (numEvents > 5)
    {
      buffer = "<p>Mehr als 5 Events an dieser Position gefunden. Zoome näher heran um mehr Informationen zu erhalten.</p>";
    }
    else
    {
      buffer += "<ul>";
      for (var i=0; i < numEvents; i++)
      {
        var eventId = feature.cluster[i].attributes.eventid;
        var eventTitle = feature.cluster[i].attributes.title;
        var eventLink = "<?php echo site_url("event"); ?>/" + eventId;
        buffer += "<li><a href='" + eventLink + "'>" + eventTitle + "</a></li>";
      }
      buffer += "</ul>";
    }
  }
  else
  {
    var eventId = feature.cluster[0].attributes.eventid;
    var eventTitle = feature.cluster[0].attributes.title;
    var eventLink = "<?php echo site_url("event"); ?>/" + eventId;
    buffer = "<li><a href='" + eventLink + "'>" + eventTitle + "</a></li>";
  }

  $("#popup")
    .html(buffer)
    .show();
}

function openBuslinienPopup(evt)
{
  var linie = evt.feature.attributes.lineName;
  var color = evt.feature.attributes.lineColor;
  var name = evt.feature.attributes.name;

  var buffer = "<p>Bushaltestelle:<br> " + linie + "&nbsp;<span style='color:" + color + "'>&#9679;</span><br><b>" + name + "</b></p>";

  $("#popup")
    .html(buffer)
    .show();
}

function closePopup()
{
  $("#popup").hide();
}

// --- Layerswitcher -----------------------------------------------------------------

function layermenu()
{
  var buffer = "";  
  buffer = "" +
  "Basislayer:" +
  "<ul>" +
  "<li class='layer' layer='friends' show='<?php echo $layer["friends"]; ?>'>Freunde</li>" +
  "<li class='layer' layer='events' show='<?php echo $layer["events"]; ?>'>Events</li>" +
  "<li class='layer' layer='locations' show='<?php echo $layer["locations"]; ?>'>Locations</li>" +
  "</ul>" +  
  "<hr/>" +
  "Buslinien:" +
  "<ul>" +
  "<li class='layer' layer='buslinie1' show='<?php echo $layer["buslinie1"]; ?>'>Linie 1</li>" +
  "<li class='layer' layer='buslinie2' show='<?php echo $layer["buslinie2"]; ?>'>Linie 2</li>" +
  "<li class='layer' layer='buslinie5' show='<?php echo $layer["buslinie5"]; ?>'>Linie 5</li>" +  
  "<li class='layer' layer='buslinie6' show='<?php echo $layer["buslinie6"]; ?>'>Linie 6</li>" +  
  "<li class='layer' layer='buslinie7' show='<?php echo $layer["buslinie7"]; ?>'>Linie 7</li>" +  
  "<li class='layer' layer='buslinie8' show='<?php echo $layer["buslinie8"]; ?>'>Linie 8</li>" +  
  "<li class='layer' layer='buslinie9' show='<?php echo $layer["buslinie9"]; ?>'>Linie 9</li>" +  
  "</ul>" +  
  "<hr/>" +
  "<a href='javascript:closePopup()'>close</a>";

  $("#popup")
    .html(buffer)
    .show();
}

$("body").on("click", "li.layer", function(event) {
  var layername = $(this).attr("layer");
  var show = $(this).attr("show");
  
  if (show == "true")
  {
    window[layername].setVisibility(false);
    $(this).attr("show", "false");
    $.post("<?php echo site_url("/map/map/saveLayerVisibility");?>", {layer: layername, visibility: false});
  }
  else
  {
    window[layername].setVisibility(true);
    $(this).attr("show", "true");    
    $.post("<?php echo site_url("/map/map/saveLayerVisibility");?>", {layer: layername, visibility: true});
  }
});

// --- Location -----------------------------------------------------------------------------------
  
function addNewLocation()
{
  locations.setVisibility(false);
  friends.setVisibility(false);
  newlocation.setVisibility(true);
  $("#button-location-new-cancel").show();
  $("#button-location-new-next").show();
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
  $("#button-location-new-cancel").hide();
  $("#button-location-new-next").hide();
  $("#button-location-new").show();
  clickControl.deactivate();
  selectControl.activate();
  closePopup();
}


function next()
{
  var buffer = "";  
  buffer = "" +
  "<button id='button-location-add-back' class='buttons-location-add' type='button' onclick='closePopup()'>Zurück</button>" +
  "<button id='button-location-add-cancel' class='buttons-location-add' type='button' onclick='cancel()'>Abbrechen</button>" +
  "<button id='button-location-add-save' class='buttons-location-add' type='button' onclick='addLocation()'>Fertig</button>" +
  "<br/>" +
  "Daten der neuen Location:<br/>" +
  "<input type='text' name='newlocname' id='newlocname' placeholder='Name'><br/>" + 
  "<input type='text' name='newlocstreet' id='newlocstreet' placeholder='Straße'><br/>" +
  "<input type='text' name='newloccity' id='newloccity' placeholder='Stadt'><br/>" +
  "<input type='text' name='newloctype' id='newloctype' placeholder='Typ'><br/>" +
  "<input type='url' name='newlocinternet' id='newlocinternet' placeholder='Homepage'><br/>" +
  "<input type='email' name='newlocemail' id='newlocemail' placeholder='E-Mailadresse'><br/>" +
  "<div id='popupErrorMsg'>Bitte mindestens den Namen angeben.</div>";
  
  $(".buttons-location-new")
  .hide();
  
  $("#popup")
  .html(buffer)
  .show();
}

function addLocation()
{
  var newlocname = document.getElementById('newlocname').value;
  var newlocstreet = document.getElementById('newlocstreet').value;
  var newloccity = document.getElementById('newloccity').value;
  var newloctype = document.getElementById('newloctype').value;
  var newlocinternet = document.getElementById('newlocinternet').value;
  var newlocemail = document.getElementById('newlocemail').value;
  
  if (newlocname == "") {
    $("#popupErrorMsg").show();
  } else {
    $.post("<?php echo site_url('location/add'); ?>" , {
        name: newlocname,
        street: newlocstreet,
        city: newloccity,
        type: newloctype,
        internet: newlocinternet,
        email: newlocemail,
        lon: newlocationlonlat.lon,
        lat: newlocationlonlat.lat
    });
    $.get("<?php echo site_url('map'); ?>");
  }
  
}

function getLocationDetails(id)
{
  $.post("<?php echo site_url("map/location"); ?>/" + id, function(data) {
    $("#locationdetails").html(data);
  });
  pageNext();
}



</script>

<div id='window'>
  <ul id='pages'>
    <li>
      <div id='popup'>Popup</div>
      
      <div id='map'>
        <button id='layerswitcher' type='button' onclick='layermenu()'>Layer</button>
        <button id='button-location-new' class='buttons-location-new' type='button' onclick='addNewLocation()'>+ Location</button>
        <button id='button-location-new-cancel' class='buttons-location-new' type='button' onclick='cancel()'>Abbrechen</button>
        <button id='button-location-new-next' class='buttons-location-new' type='button' onclick='next()'>Weiter</button>
      </div>
      <script>initMap();</script>
    </li>
    <li>
<!--  bestehende Location bearbieten/löschen      -->
      <div id='locationdetails'></div>
    </li>
  </ul>
</div>

<script>

var track = new Array();
loadTrack("<?php echo site_url("gpx/linie1.gpx");?>");

function loadTrack(url)
{
  OpenLayers.loadURL(url, {}, null, function(r) {
    var gpxFormat = new OpenLayers.Format.GPX({
      "extractWaypoints": false,
      "extractTracks": true,
      "extractRoutes": true,
      "extractAttributes": true,
      "internalProjection": toProj,
      "externalProjection": fromProj
    });

    var features = gpxFormat.read(r.responseText);    
    var collection = new OpenLayers.Geometry.Collection();
    
    for (var i=0; i < features.length; i++)
    {
      collection.components.push(features[i].geometry); 
      track[i+1] = features[i].geometry.getGeodesicLength(toProj);
    }
    console.log(Math.floor(collection.getGeodesicLength(toProj)) + "m in " + features.length + " Segmenten");    

    getPoint(track, collection, 0.5);
  });
}

function getPoint(track, collection, percent)
{
  var tmpLen = 0;
  var totalLen = collection.getGeodesicLength(toProj);
  var target = totalLen * percent;  
  var segments;
  
  // richtiges Segment für Detailberechnung finden
  for (var i=1; i <= collection.components.length; i++)
  {
    if (tmpLen + collection.components[i].getGeodesicLength(toProj) <= target)
    {
      tmpLen += collection.components[i].getGeodesicLength(toProj);
    }
    else
    {
      segments = i;
      break;
    }
  }
  
  var rest = target - tmpLen;
  console.log("Noch " + Math.floor(rest) + "m in " + collection.components[segments].components.length + " Segmenten zu berechnen");
  
  for (var i=0; i < collection.components[segments].components.length; i++)
  {
    var s = collection.components[segments].components[i];
    console.log(s);
  }

}

</script>
