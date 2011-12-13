<style>
ul#eventlocations
{
  width:97%;
  margin:0px auto;
  padding:0px;
  list-style-type:none;
}

#eventlocations li
{
  color:#999;
  border-bottom:1px solid #ccc;
  padding:10px;
  font-size:1em;
}

#eventlocations li.selected
{
  color:#eee;
  background-color:#669933;
}

#eventlocations li b
{
  font-size:1.5em;
}

table#eventmembers 
{
  width:97%;
  margin:0px auto;
}
  
#eventmembers td:not(:first-child)
{
  padding:10px;
  font-size:1em;
}

#eventmembers tr
{
  color:#999;
  border-bottom:1px solid #ccc;
  padding:10px;
  font-size:1em;
}

#eventmembers img
{
  -moz-border-radius:10px;
  border-radius:10px;
  width:64px;
  height:64px;
}

</style>

<span id="eventid" eventid="<?php echo $eventid; ?>"></span>
<?php $time = time();?>

<div id="window">
  <ul id="pages">
    
    <li>
      <div>
        <h1><?php echo $title; ?></h1>
        <h2>Eventdaten</h2>
        <label for="eventname">Titel</label><input id="eventname" name="eventname" value="<?php echo $event->title; ?>"/>
        <br/>

        <label for="eventfromdate">Datum (Von)</label><input id="eventfromdate" name="eventfromdate" value="<?php echo date("d.m.Y", $event->begintime);?>"/>
        <label for="eventfromtime">Uhrzeit (Von)</label><input id="eventfromtime" name="eventfromtime" value="<?php echo date("H:i:s", $event->begintime);?>"/>
        <br/>
      
        <label for="eventtodate">Datum (Bis)</label><input id="eventtodate" name="eventtodate" value="<?php echo date("d.m.Y", $event->endtime);?>"/>
        <label for="eventtotime">Uhrzeit (Bis)</label><input id="eventtotime" name="eventtotime" value="<?php echo date("H:i:s", $event->endtime);?>"/>
        <br/>
        <button class="button" id="eventbutton_basedata_next">weiter</button>
      </div>
    </li>
    
    <li>
      <div>
        <h2>Location</h2>
<!--
        <label for="eventlocationsearch">Location suchen</label><input id="eventlocationsearch" name="eventlocationsearch"/> oder auswählen
-->
        <ul id="eventlocations">            
        <?php
          foreach ($locations as $location)
          {
            if ($location->id == $event->location)
            {
              echo "<li class='selected' locationid='".$location->id."'>";              
            }
            else
            {
              echo "<li locationid='".$location->id."'>";              
            }
            echo "<b>".$location->name."</b><br/>";
            echo $location->street .", ".$location->city;
            echo "</li>";
          }
        ?>
        </ul>
<!--
        oder <a href="#">Neue Location anlegen</a>
-->
        <br/>
      </div>
    </li>                 

    <li>
      <div>
        <h2>Teilnehmer</h2>
        <table id="eventmembers">          
        <?php
          foreach ($members as $member)
          {
            echo "<tr>";
            echo "<td width='64'><img src='".$member->picture."'/></td>";              
            echo "<td>".$member->name."</td>";  
                     
            if (isset($memberstatus[$member->id]))
            {
              if ($memberstatus[$member->id] == "invited")
              {
                echo "<td width='200' align='right'><button status='invited' memberid='".$member->id."'>Einladung gesendet</button></td>";                                          
              }
              else
              if ($memberstatus[$member->id] == "attending")
              {
                echo "<td width='200' align='right'><button status='attending' memberid='".$member->id."'>nimmt Teil</button></td>";                                          
              }
            } 
            else
            {
              echo "<td width='200' align='right'><button status='none' memberid='".$member->id."'>einladen</button></td>";
            }    
            echo "</tr>";
          }
        ?>
        </table>
        <br/>
        <button class="button" id="eventbutton_members_prev">zurück</button>
        <button class="button" id="eventbutton_members_next">weiter</button>
      </div>
    </li> 
          
    <li>
      <div>
        <h2>Kommentare</h2>
        <button class="button" id="eventbutton_comment_prev">zurück</button>
        <button class="button" id="eventbutton_comment_next">zurück</button>
      </div>
    </li>         

  </ul>
</div>
