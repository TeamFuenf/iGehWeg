    </div>  
  </body>
  <script language="JavaScript">
    if (navigator.geolocation)
    {
      navigator.geolocation.getCurrentPosition(function(position)
      {      
        var lon = position.coords.longitude;
        var lat = position.coords.latitude;        
        $.post("<?php echo site_url("helper/geo/update") ?>/"+ lon +"/"+ lat);
      });
    }
  </script>
</html>