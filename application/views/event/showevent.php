<script>
$(document).ready(function()
{

  $("button[name=post_comment]").on("click", function()
  {
    var comment = $("textarea[name=comment]").val();
    if (comment != "")
    {
      $.post("<?php echo $commentUrl; ?>", {
        eventid: "<?php echo $event->id; ?>",
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

@font-face
{  
  font-family: Segoe;  
  src: url(../../css/segoeui.ttf) format("truetype");  
}  
@font-face
{  
  font-family: SegoeLight;  
  src: url(../../css/segoeuil.ttf) format("truetype");  
}  

h1
{
  font-family: SegoeLight, verdana, helvetica, sans-serif;
  color:#666;
  font-size:40px;
}

h2
{
  font-family: SegoeLight, verdana, helvetica, sans-serif;
  color:#666;
  font-size:20px;
}

#event_mapsnippet iframe
{
  width:300px;
  height:300px;
  margin:0px;
  padding:0px;
}

#event_members ul
{
  list-style-type:none;
}

#event_members li img
{
  color:#666;
  width:64px;
  height:64px;
  border-radius:10px;
  -moz-border-radius:10px;
  margin-right:25px;
  vertical-align:middle; 
}
 
#event_members li
{
  height:70px;
  padding-bottom:10px;
}

#event_members li.invited img
{
  opacity:0.3;
}

#event_members li.invited
{
  color:#ccc;
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
                <h1><?php echo $event->title; ?></h1>
              </td>
              <td width="200" height="200" rowspan="5">
                <iframe src="../../map/snippet/10" width="250" height="250" frameborder="0">
                </iframe>
              </td>              
            <tr><td colspan="2"><h2>Details</h2></td></tr>
            <tr>
              <td>Ersteller</td>
              <td><?php echo $event->creator; ?></td>
            </tr>
            <tr>
              <td>Location</td>
              <td><?php echo $location; ?></td>
            </tr>
            <tr>
              <td>Von</td>
              <td><?php echo date("H:i j.n.Y", $event->begintime); ?></td>
            </tr>
            <tr>
              <td>Bis</td>
              <td><?php echo date("H:i j.n.Y", $event->endtime); ?></td>
            </tr>
          </table>
        </div>

        <h2>Teilnehmer</h2>
        <div id="event_members">
        <ul>          
        <?php
        foreach ($members as $member)
        {
          if ($member->status == "invited")
          {
            echo "<li class='invited'>";
          }
          else
          {
            echo "<li>";            
          }
          echo img($member->picture).$member->name;
          // member lon/lat für Distanz ?
          // member lastupdate für letzte Position
          // Distanz nur anzeigen wenn Event x Minuten vorher ?
          echo "</li>";
        }
        ?>
        </ul>
        </div>      
    
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
  var meetuppMap = new OpenLayers.Layer.OSM("meetupp", "http://images.rawsteel.de.s3.amazonaws.com/meetupp/tiles/${z}/${x}/${y}.png");
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