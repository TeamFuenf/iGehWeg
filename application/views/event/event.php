<style>
@font-face
{  
  font-family: Segoe;  
  src: url(../../css/segoeui.ttf) format("truetype");  
}  
@font-face
{  
  font-family: SegoeLight;  
  src: url(../../css/segoeuil.ttf) format("truetype");  
}  

h1
{
  padding:10px;
  font-family: SegoeLight, verdana, helvetica, sans-serif;
  color:#666;
  font-size:40px;
}

h2
{
  padding:10px;
  font-family: SegoeLight, verdana, helvetica, sans-serif;
  color:#666;
  font-size:20px;
}

ul#eventlocations
{
  width:90%;
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
        <h1>Event bearbeiten</h1>

        <style>
          .selection
          {
            font-family: SegoeLight, verdana, helvetica, sans-serif;
            font-size:1.5em;
            color:#999;
            padding-bottom:25px;
          }
      
          .selection b
          {
            font-weight: normal;
            color:#333;
            width:100px;
            display:inline-block;
          }
          
          .selection select
          {
            font-family: SegoeLight, verdana, helvetica, sans-serif;
            color:#999;
            margin:0px;
            padding:0px;
            border:0px;         
            background-color:transparent;
          }
          
          .selection input
          {
            font-family: SegoeLight, verdana, helvetica, sans-serif;
            color:#999;
            margin:0px;
            padding:0px;
            border:0px;
            background-color:transparent;
          }
          
          button.delete
          {
            background-color:red;
            color:#fff;         
          }
          
          a
          {
            text-decoration:none;
          }
          
        </style>

        <div class='selection'>
        <b>Titel:</b>
        <input id='eventname' placeholder="<gib einen Eventtitel ein>" name='eventname' value='<?php echo $event->title; ?>'/>
        </div>

        <?php        
          $from_hour = date("H", $event->begintime);
          $from_minute = date("i", $event->begintime);
          $from_day = date("j", $event->begintime);
          $from_month = date("n", $event->begintime);
          $from_year = date("Y", $event->begintime);          
          $to_hour = date("H", $event->endtime);
          $to_minute = date("i", $event->endtime);
          $to_day = date("j", $event->endtime);
          $to_month = date("n", $event->endtime);
          $to_year = date("Y", $event->endtime);          
        
          echo "<div class='selection'>";
          echo "<b>Von:</b>";          
          echo "<select id='from_hour'>";
          for ($i=0; $i < 24; $i++) {
            ($i == $from_hour) ? printf("<option selected value='%d'>%1$02d</option>", $i) : printf("<option value='%d'>%1$02d</option>", $i);
          }
          echo "</select>";          
          echo ":";
          echo "<select id='from_minute'>";
          for ($i=0; $i < 60; $i+=5)
          {
            ($i == $from_minute) ? printf("<option selected value='%d'>%1$02d</option>", $i) : printf("<option value='%d'>%1$02d</option>", $i);
          }
          echo "</select>";
          echo ", ";
          echo "<select id='from_day'>";
          for ($i=1; $i <= 31; $i++)
          {
            ($i == $from_day) ? printf("<option selected value='%d'>%1$02d</option>", $i) : printf("<option value='%d'>%1$02d</option>", $i);
          }
          echo "</select>";
          echo ".";
          echo "<select id='from_month'>";
          for ($i=1; $i <= 12; $i++)
          {
            ($i == $from_month) ? printf("<option selected value='%d'>%1$02d</option>", $i) : printf("<option value='%d'>%1$02d</option>", $i);
          }
          echo "</select>";
          echo ".";
          echo "<select id='from_year'>";
          for ($i=2012; $i < 2015; $i++)
          {
            ($i == $from_year) ? printf("<option selected value='%d'>%1$04d</option>", $i) : printf("<option value='%d'>%1$04d</option>", $i);
          }
          echo "</select>";
          echo "</div>";

          

          echo "<div class='selection'>";
          echo "<b>Bis:</b>";
          echo "<select id='to_hour'>";
          for ($i=0; $i < 24; $i++)
          {
            ($i == $to_hour) ? printf("<option selected value='%d'>%1$02d</option>", $i) : printf("<option value='%d'>%1$02d</option>", $i);
          }
          echo "</select>";
          echo ":";
          echo "<select id='to_minute'>";
          for ($i=0; $i < 60; $i+=5)
          {
            ($i == $to_minute) ? printf("<option selected value='%d'>%1$02d</option>", $i) : printf("<option value='%d'>%1$02d</option>", $i);
          }
          echo "</select>";
          echo ", ";
          echo "<select id='to_day'>";
          for ($i=1; $i <= 31; $i++)
          {
            ($i == $to_day) ? printf("<option selected value='%d'>%1$02d</option>", $i) : printf("<option value='%d'>%1$02d</option>", $i);
          }
          echo "</select>";
          echo ".";
          echo "<select id='to_month'>";
          for ($i=1; $i <= 12; $i++)
          {
            ($i == $to_month) ? printf("<option selected value='%d'>%1$02d</option>", $i) : printf("<option value='%d'>%1$02d</option>", $i);
          }
          echo "</select>";
          echo ".";
          echo "<select id='to_year'>";
          for ($i=2012; $i < 2015; $i++)
          {
            ($i == $to_year) ? printf("<option selected value='%d'>%1$02d</option>", $i) : printf("<option value='%d'>%1$02d</option>", $i);
          }
          echo "</select>";
          echo "</div>";
        ?>
        
        <button class="button" id="eventbutton_basedata_next">weiter</button>
        
        <?php 
          if (!isset($event->new))
          {
            echo "<hr>";
            echo anchor("event/delete/".$eventid, "<button class='delete'>Event löschen</button>");             
          }
        ?>

      </div>
    </li>
    
    <li>
      <div>
        <h2>Location</h2>
        <button class="button" id="eventbutton_location_prev">zurück</button>
        <hr/>
        <button>TODO: Alphabetisch</button>
        <button>TODO: nach Entfernung</button>
        <hr/>
            
        <ul id="eventlocations">            
        <?php
          foreach ($locations as $location)
          {            
            if ($location->id == $event->location)
            {
              $selectedModifier = "class='selected'";
            }
            else
            {
              $selectedModifier = "";              
            }

            echo "
            <li ".$selectedModifier." locationid='".$location->id."'>              
            <b>".$location->name."</b> (ca. ".$location->distance." m)<br/>
            ".$location->street."
            </li>
            ";
          }
        ?>
        </ul>

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
                     
            if ($member->status == "invited")
            {
              echo "<td width='200' align='right'><button status='invited' memberid='".$member->id."'>Einladung gesendet</button></td>";                                          
            }
            else
            if ($member->status == "attending")
            {
              echo "<td width='200' align='right'><button status='attending' memberid='".$member->id."'>nimmt Teil</button></td>";                                          
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
      </div>
    </li> 

  </ul>
</div>
