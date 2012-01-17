<script>
$("body").on("touchstart click", "a#locationeditlink", function() {
  var locationId = $(this).attr("locationeditid");
  $.post("<?php echo site_url("location/edit"); ?>/" + locationId, function(data) {
    $("#locationdetailsedit").html(data);
  });
  pageNext();
});
</script>

<button id='button-location-edit' class='buttonlocation' type='button' onclick='pagePrev()'>zurück</button>
<form>
<a id="locationeditlink" locationeditid='<?php echo $location->id; ?>'>Bearbeiten</a>
<h2><?php echo $location->name; ?></h2>
Straße: <?php echo $location->street; ?><br>
Stadt: <?php echo $location->city; ?><br>
Typ: <?php echo $location->type; ?><br>
Internet: <?php echo $location->internet; ?><br>
E-Mail: <?php echo $location->email; ?>
</form>