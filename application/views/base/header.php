<html>
  <head>
    <title>meetupp</title>
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
  <body>
    <div id="content">
