<style>
#mapsnippet
{
  margin:0px;
  padding:0px;
}  
</style>
<script src="http://www.openlayers.org/api/OpenLayers.js"></script>
<div id="mapsnippet">
</div>
<script>
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
    map = new OpenLayers.Map("mapsnippet", {
      projection : toProj, 
      controls: []
//      controls: [new OpenLayers.Control.Navigation(), new OpenLayers.Control.ZoomPanel()]
    });
    map.setOptions({restrictedExtent: bounds});
                
    // Layer
    var meetuppMap = new OpenLayers.Layer.OSM("meetupp", "http://dl.dropbox.com/u/948390/Tiles/${z}/${x}/${y}.png");
    var locations = new OpenLayers.Layer.Markers("Locations");
            
    // Locations
    var lon = <?php echo $lon; ?>;
    var lat = <?php echo $lat; ?>;
    var snippetPoi = new OpenLayers.Marker(new OpenLayers.LonLat(lon, lat).transform(fromProj, toProj), icon);
    locations.addMarker(snippetPoi);

    map.addLayer(meetuppMap);
    map.addLayer(locations);
                
    // Map einrichten
    map.setCenter(new OpenLayers.LonLat(lon, lat).transform(fromProj, toProj), 16);
</script>
