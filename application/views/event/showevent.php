<script>
$(document).ready(function()
{

  $("button[name=post_comment]").on("click", function()
  {
    var comment = $("textarea[name=comment]").val();
    if (comment != "")
    {
      $.post("<?php echo $commentUrl; ?>", {
        eventid: "<?php echo $eventid; ?>",
        comment: comment
      }, 
      function(data) 
      {
        $("div#event_comments").html(data);
        $("textarea").val("");
      });
    }    
  });
});

</script>
<style>

#event_mapsnippet iframe
{
  width:300px;
  height:300px;
  margin:0px;
  padding:0px;
}

ul#comments
{
  width:auto;
  margin:0px;
  padding:0px;
  padding-right:20px;
  list-style-type:none;  
}

ul#comments li
{
  margin-bottom:15px;
}

ul
{
  margin:0px;
  padding:0px;
  list-style-type:none;
}

.userprofile
{
  -moz-border-radius: 0.25em;
  border-radius: 0.25em;
  color:rgba(0,0,0,0.5);
  position:relative;
  width:auto;
  height:2.5em;
  line-height:2.5em;
  font-size:1em;
  padding-left:2.5em;
  padding-right:0.5em;
  margin-bottom:10px;
}

.userprofile img
{
  border-radius:0.25em;
  -moz-border-radius:0.25em;
  position:absolute;
  top:0px;
  left:0px;
  height:100%;
  max-width:2em;
  max-height:2em;
}
  
</style>

<div id="window">
  <ul id="pages">
    <li>
      <div>
        <div id="event_basedata">
          <table border="0" width="90%">
            <tr>
              <td colspan="2">
                <h1><?php echo $basedata->title; ?></h1>
              </td>
              <td width="200" height="200" rowspan="5">
                <iframe src="../map/snippet/10" width="250" height="250" frameborder="0">
                </iframe>
              </td>              
            <tr>
              <td>Ersteller</td>
              <td><?php echo $basedata->creator; ?></td>
            </tr>
            <tr>
              <td>Location</td>
              <td><?php echo $basedata->location; ?></td>
            </tr>
            <tr>
              <td>Von</td>
              <td><?php echo $basedata->from; ?></td>
            </tr>
            <tr>
              <td>Bis</td>
              <td><?php echo $basedata->to; ?></td>
            </tr>
          </table>
        </div>

        <h2>Teilnehmer</h2>
        <div id="event_members">
        <?php echo $members; ?>  
        </div>      

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