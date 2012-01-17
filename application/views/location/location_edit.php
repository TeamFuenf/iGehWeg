<script>
  function save()
  {
    var name = document.getElementById('name').value;
    var street = document.getElementById('street').value;
    var city = document.getElementById('city').value;
    var type = document.getElementById('type').value;
    var internet = document.getElementById('internet').value;
    var email = document.getElementById('email').value;
  
    if (name == "") {
      $("#errorMsg")
      .html('Mindestens den Namen angeben.')
      .show();
    } else {
      $.post("<?php echo site_url('location/update').'/'.$location->id; ?>" , {
          name: name,
          street: street,
          city: city,
          type: type,
          internet: internet,
          email: email
      });
      window.location.href = "<?php echo site_url("map");?>";
    }
    
  }
</script>

<button id='button-location-cancel' class='buttonlocation' type='button' onclick='pagePrev()'>Abbrechen</button>
<button id='button-location-finish' class='buttonlocation' type='button' onclick='save()'>Fertig</button>
<input type='text' name='name' id='name' placeholder='Name' value='<?php echo $location->name; ?>'><br/>
<input type='text' name='street' id='street' placeholder='Straße' value='<?php echo $location->street; ?>'><br/>
<input type='text' name='city' id='city' placeholder='Stadt' value='<?php echo $location->city; ?>'><br/>
<input type='text' name='type' id='type' placeholder='Typ' value='<?php echo $location->type; ?>'><br/>
<input type='text' name='internet' id='internet' placeholder='Homepage' value='<?php echo $location->internet; ?>'><br/>
<input type='text' name='email' id='email' placeholder='E-Mail' value='<?php echo $location->email; ?>'><br/>
<div id='errorMsg'></div>