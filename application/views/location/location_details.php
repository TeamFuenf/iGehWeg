<script>
$("body").on("deactivate", "a#locationeditlink", function() {
  var locationId = $(this).attr("locationeditid");
  $.post("<?php echo site_url("location/edit"); ?>/" + locationId, function(data) {
    $("#locationdetailsedit").html(data);
  });
  pageNext();
});
</script>

<div id="location_info_wrapper">
<button id='button-location-edit' class='buttonlocation button_map' type='button' onclick='pagePrev()'>Zurück</button>
<!-- <a id="locationeditlink" locationeditid='<?php echo $location->id; ?>'>Bearbeiten</a> -->
<h1><div id='name'><?php echo $location->name; ?></div></h1>
<div id='street'><?php echo $location->street; ?></div>
<div id='city'><?php echo $location->city; ?></div>
<div id='type'><?php echo $location->type; ?></div>
<div id='internet'><?php echo $location->internet; ?></div>
<div id='email'><?php echo $location->email; ?></div>
</div>