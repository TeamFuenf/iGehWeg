<script src="http://www.openlayers.org/api/OpenLayers.js"></script>

<style>

#event_mapsnippet iframe
{
  width:300px;
  height:300px;
  margin:0px;
  padding:0px;
}

</style>

<div id="window">
  <ul id="pages">
    <li>
      <div>
        <h1><?php echo $title; ?></h1>
        <h2>Basisdaten</h2>
        <div id="event_basedata">
        <?php echo $basedata; ?>  
        </div>
        <div id="event_mapsnippet">
          <iframe src="../map/snippet/1" frameborder="0">
            loading map
          </iframe>         
        </div>
      </div>
    </li>
    
    <li>
      <div>
        <h1><?php echo $title; ?></h1>
        <h2>Teilnehmer</h2>
        <div id="event_members">
        <?php echo $members; ?>  
        </div>      
      </div>
    </li>
    
    <li>
      <div>
        <h1><?php echo $title; ?></h1>
        <h2>Kommentare</h2>
        <div id="event_comments">          
        <?php echo $comments; ?>  
        </div>
        <div id="event_commentform">          
        <?php echo $commentForm; ?>  
        </div>
      </div>
    </li>     
    
  </ul>
</div>

<script>
/*
  // Projektionen
  var fromProj = new OpenLayers.Projection("EPSG:4326"); // transform from WGS 1984
  var toProj = new OpenLayers.Projection("EPSG:900913"); // to Spherical Mercator Projection
      
  // Icons
  var size = new OpenLayers.Size(21,25);
  var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
  var icon = new OpenLayers.Icon('http://www.openlayers.org/dev/img/marker.png',size,offset);
  
  // Bounds
  var bounds = new OpenLayers.Bounds();
  bounds.extend(new OpenLayers.LonLat(13.3699780,48.5356778));
  bounds.extend(new OpenLayers.LonLat(13.4993596,48.5855492));
  bounds.transform(fromProj, toProj);
      
  // Map
  map = new OpenLayers.Map("event_mapsnippet", {
    projection : toProj, 
    controls: []
  //      controls: [new OpenLayers.Control.Navigation(), new OpenLayers.Control.ZoomPanel()]
  });
  map.setOptions({restrictedExtent: bounds});
              
  // Layer
  var meetuppMap = new OpenLayers.Layer.OSM("meetupp", "http://dl.dropbox.com/u/948390/Tiles/${z}/${x}/${y}.png");
  var locations = new OpenLayers.Layer.Markers("Locations");
          
  // Locations
  var lon = 13.4693767;
  var lat = 48.5748142;
  var snippetPoi = new OpenLayers.Marker(new OpenLayers.LonLat(lon, lat).transform(fromProj, toProj), icon);
  locations.addMarker(snippetPoi);
  
  map.addLayer(meetuppMap);
  map.addLayer(locations);
              
  // Map einrichten
  map.setCenter(new OpenLayers.LonLat(lon, lat).transform(fromProj, toProj), 17);   
  */
</script>