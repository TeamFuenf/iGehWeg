<button id='button-location-edit' class='buttonlocation' type='button' onclick='pagePrev()'>zurück</button>
<form>
<a href="<?php echo site_url('location/edit'); echo '/'.$location->id; ?>">Details bearbeiten</a>
<h2><?php echo $location->name; ?></h2>
Straße: <?php echo $location->street; ?><br>
Stadt: <?php echo $location->city; ?><br>
Typ: <?php echo $location->type; ?><br>
Internet: <?php echo $location->internet; ?><br>
E-Mail: <?php echo $location->email; ?>
</form>