<div id="window">
  <ul id="pages">
    <li>
      <div id="events">
        <div id="userid" userid="<?php echo $userid; ?>"></div>
        <?php 
        echo anchor("event/new","+", "class='button_normal button_side add_event'");
        ?>
        <h1 class="button_side">Events:</h1>
        <br/>
        Eigene Events:
        <div class='contentbox contentbox_friends'>
        <ul>
        <?php 
          $color_class = "";
		  $count = 0;
        
          foreach ($ownevents as $event)
          {
          	if($count % 2 == 0) {
					$color_class = "green";
				} else {
					$color_class = "blue";
				}
			
			  echo "<li class='button_long ".$color_class."'>";
              echo "<span class='friend_list_entry groups list_entry_events'>";
              echo "<img src='../../images/newevent_".$color_class.".png'/>";
              echo $event->title;
              echo "</span>";              
			  echo "<a href='event/edit/".$event->id."' class='button_small'><span status='none' eventid='".$event->id."'><img src='../../images/accept_".$color_class.".png' /></span></a>";
              echo "</li>";
			  $count++;
          }
        ?>
        </ul>
        </div>
        
              
        Fremde Events:
        <div class='contentbox contentbox_friends'>
        <ul>
        <?php 
          $color_class = "";
          $count = 0;
		
          if (count($participatingeventsts) > 0)
          {
            foreach ($participatingeventsts as $event)
            {
			  if($count % 2 == 0) {
					$color_class = "green";
				} else {
					$color_class = "blue";
				}
			  
			  echo "<li class='button_long ".$color_class."'>";
              echo "<span class='friend_list_entry groups list_entry_events'>";
              echo "<img src='../../images/newevent_".$color_class.".png'/>";
              echo $event->title;
              echo "</span>";              
              if ($event->status == "attending")
              {
                echo "<span class='declineevent button_small' eventid='".$event->id."'><img src='../../images/delete_".$color_class.".png' /></span>";                                              
              }
              else
              {
                echo "<span class='acceptevent button_small' eventid='".$event->id."'><img src='../../images/accept_".$color_class.".png' /></span>";
                echo "<span class='declineevent button_small' eventid='".$event->id."'><img src='../../images/delete_".$color_class.".png' /></span>";                              
              }
              echo "</li>";
			  $count++;
			  
            }
          }
        ?>
        </ul>    
        </div>  
      </div>
    </li>
  </ul>
</div>
