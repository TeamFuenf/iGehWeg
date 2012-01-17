<script>
$("body").on("touchstart click", "a#locationeditlink", function() {
  var locationId = $(this).attr("locationeditid");
  $.post("<?php echo site_url("location/edit"); ?>/" + locationId, function(data) {
    $("#locationdetailsedit").html(data);
  });
  pageNext();
});
</script>

<button id='button-location-edit' class='buttonlocation' type='button' onclick='pagePrev()'>Zurück</button>
<a id="locationeditlink" locationeditid='<?php echo $location->id; ?>'>Bearbeiten</a>
<h2><div id='name'><?php echo $location->name; ?></div></h2>
<div id='street'><?php echo $location->street; ?></div></br>
<div id='city'><?php echo $location->city; ?></div></br>
<div id='type'><?php echo $location->type; ?></div></br>
<div id='internet'><?php echo $location->internet; ?></div></br>
<div id='email'><?php echo $location->email; ?></div>