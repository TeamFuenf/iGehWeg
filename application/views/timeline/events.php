<style>

#events ul
{
  list-style-type:none;
  margin:0px;
  padding-left:20px;
  padding-right:20px;
  
  width:auto;
}

#events button
{
  padding:10px;
}

#events a
{
  color:#666;
  text-decoration:none;
}  

#ownevents,
#participatingevents
{
  width:97%;
  margin:0px auto;
}

</style>

<div id="window">
  <ul id="pages">
    <li>
      <div id="events">
        <div id="userid" userid="<?php echo $userid; ?>"></div>
        <?php 
        echo anchor("event/new","<button>neues Event erstellen</button>");
        ?>
        
        <h1>Eventübersicht</h1>  
        <h2>Eigene Events</h2>
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
        <h2>Fremde Events</h2>
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
                echo "<button class='declineevent' eventid='".$event->id."'>nicht mehr teilnehmen</button></td>";                                              
              }
              else
              {
                echo "<button class='acceptevent' eventid='".$event->id."'>teilnehmen</button>";
                echo "<button class='declineevent' eventid='".$event->id."'>absagen</button></td>";                              
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
