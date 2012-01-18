<!DOCTYPE>
<!--<html manifest="<?php echo site_url("cache.manifest")?>">-->
<html>
  <head>
    <title>meetupp</title>
    <meta charset="utf-8">

    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="viewport" content="user-scalable=no, width=device-width"/>
    
    <link rel="apple-touch-icon" href="../images/apple-touch-icon.png" />
    <link rel="apple-touch-startup-image" href="../images/startup.png" />
    
    <?php
    foreach ($css as $link)
    {
      echo $link;  
    }

    foreach ($javascript as $link)
    {
      echo $link;  
    }
    ?>
    
  </head>

  <script>
	  $(function () {
	  	$("body").on("click", "a:not(.external, .internal)", function(event){
	  		event.preventDefault();
	  		var url = $(this).attr('href');
	  		console.log(url);
	  		$.ajax({
	  			url: url,
	  			success: function(data) {
	  				$('body').html(data);
	  			}
	  		})
	  	})
	  });
	  
	  function BlockMove(event)
	  {
	    // Tell Safari not to move the window.
	    //event.preventDefault() ;
	  }
  </script>

  <body ontouchmove="BlockMove(event);">
    <div id="content">
