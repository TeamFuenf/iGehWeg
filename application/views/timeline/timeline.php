<script>

$(document).ready(function()
{

});  
  
</script>

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
  width:40%;
  padding:10px;
  font-family: SegoeLight, verdana, helvetica, sans-serif;
  color:#666;
  font-size:40px;
}

div
{
  font-family:Segoe UI;
}

.day
{
  box-shadow:inset 2px 0px 8px #ccc;
  position:relative;
  left:45%;
  color:#999;
  width:25px;
  min-height:50px
}

a
{
  text-decoration:none;
  color:#999;
}

.day span.date
{
  position:relative;
  top:0px;
  left:0px;
  border-top:1px solid #ccc;
  padding-left:50px;
  color:#ccc;
}

.day:nth-child(even)
{
  background-color:#e6e6e6;
}

.day:nth-child(odd)
{
  background-color:#e0e0e0;
}

.event
{
  box-shadow:inset 2px 0px 8px #999;
  position:absolute;
  background-color:#2bc0e8;
  color:#fff;
  width:25px;
  display:block;
}

.eventlabel
{
  position:absolute;
  width:200px;
  left:-200px;
  display:block;
  border-left:1px dotted #ccc;
  padding-left:10px;
  color:#999;
}

.eventmembers
{
  position:absolute;
  width:300px;
  left:150px;
  display:block;
  padding-right:10px;
  color:#999;
}

.eventmembers img
{
  float:left;
  width:48px;
  height:48px;
  margin:10px;
  border-radius:5px;
}

</style>

<div id="window">
  <ul id="pages">
    <li>
      <div id="timeline">        
        <h1>Timeline</h1>
      <?php
      echo anchor("event","<button>zu den Events</button>");
      
      $showDaysInAdvance = 14;
      for ($i=0; $i <= $showDaysInAdvance; $i++)
      {
        $date = strtotime("+".$i." day");
        $todaysEvents = array();
        foreach($events as $event)
        {
          if ($event->day == date("j", $date))
          {
            $todaysEvents[] = $event;            
          }
        }

        if (count($todaysEvents) > 0)
        {
          echo "<div class='day' style='height:480px'>";
        }
        else
        {
          echo "<div class='day'>";          
        }
        
        echo "<span class='date'>".date("d.m.Y", $date)."</span>";
                
        foreach ($todaysEvents as $event)
        {
          $top = $event->offset1+20;
          $height = $event->offset2 - $event->offset1;
          
          $begin = date("H:i", $event->begintime);
          $end = date("H:i", $event->endtime);
          echo "<div class='event' style='top:".$top."px; height:".$height."px'>";
          echo "</div>";          

          echo "<div class='eventlabel' style='top:".$top."px; height:".$height."px'>";
          echo anchor("event/edit/".$event->id, "<b>".$begin."-".$end."</b><br/>".$event->title);
          echo "</div>";          

          echo "<div class='eventmembers' style='top:".$top."px; height:".$height."px'>";
          foreach($eventmembers[$event->id] as $member)
          {
            if ($member->id == $userid)
            {
              echo "<img src='".$member->picture."'>";            
            }
            else
            {
              echo anchor("mail/".$member->id,"<img src='".$member->picture."'>");
            }
          }
          echo "</div>";          
        }
        
        echo "</div>";        
      }
      
      ?>
      </div>
    </li>
  </ul>
</div>
