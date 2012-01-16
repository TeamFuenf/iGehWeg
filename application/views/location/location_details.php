<style>

</style>
<script>
</script>

<div id='window'>
  <ul id='pages'>
    <li>
      <div id='locationdetails'>
        <button id='button-location-edit' class='buttonlocation' type='button'>Zurück</button>
        <a href="<?php echo site_url('location/edit'); echo '/'.$location->id; ?>">Bearbeiten</a>
        <h2><div id='name'><?php echo $location->name; ?></div></h2>
        <div id='street'><?php echo $location->street; ?></div></br>
        <div id='city'><?php echo $location->city; ?></div></br>
        <div id='type'><?php echo $location->type; ?></div></br>
        <div id='internet'><?php echo $location->internet; ?></div></br>
        <div id='email'><?php echo $location->email; ?></div>
      </div>
    </li>
  </ul>
</div>