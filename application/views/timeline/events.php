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
        <table id="ownevents">
        <?php 
          foreach ($ownevents as $event)
          {
            echo "<tr>";
            echo "<td>".$event->title."</td>";              
            echo "<td width='200' align='right'><a href='".site_url("event/edit")."/".$event->id."'><button status='none' eventid='".$event->id."'>bearbeiten</button></a></td>";              
            echo "</tr>";
          }
        ?>
        </table>      
        Fremde Events:
        <table id="participatingevents">
        <?php 
          if (count($participatingeventsts) > 0)
          {
            foreach ($participatingeventsts as $event)
            {
              echo "<tr>";
              echo "<td>".$event->title."</td>";              
              echo "<td width='200' align='right'>";
              if ($event->status == "attending")
              {
                echo "<button class='declineevent' eventid='".$event->id." button_normal'>nicht mehr teilnehmen</button></td>";                                              
              }
              else
              {
                echo "<button class='acceptevent' eventid='".$event->id." button_normal'>teilnehmen</button>";
                echo "<button class='declineevent' eventid='".$event->id." button_normal'>absagen</button></td>";                              
              }
              echo "</tr>";
            }
          }
        ?>
        </table>      
      </div>
    </li>
  </ul>
</div>
