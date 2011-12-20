<script>

$(document).ready(function()
{

  $(".day").has(".event").each(function(index)
  {
    var begin = $(this).find(".event").attr("begin");
    var end = $(this).find(".event").attr("end");
    $(this).css("height", "480px");
    $(this).append("<div class='eventEntry' style='top:" + begin + "px;height:"+(end-begin)+"px'></div>");

    $(this).find(".event").css("top",begin-25+"px");
    
  });

  

});  
  
</script>

<style>

.eventEntry
{
  position:absolute;
  display:block;
  width:100px;
  background-color:rgba(25, 100, 175, 0.75);
  width:50px;
  color:red;
}

.dayevent
{
  height:480px;
}

.day 
{
  position:relative;
  top:0px;
  left:40%;
  min-height:50px;
  text-align:center;
  line-height:50px;
  width:50px;
  font-size:12px;
  color:#fff;
}

.day:nth-child(even)
{
  background-color:#bbb;
}

.day:nth-child(odd)
{
  background-color:#ccc;
}

.day a
{
  text-decoration:none;
  color:#fff;
}

.today
{
  border:10px solid white;
  margin-left:-10px;
}


.event
{
  font-size:14px;
  position:absolute;
  left:-300px;
  top:0px;
  background-color:#666;
  text-align:left;
  padding-left:20px;
  color:#eee;
  width:255px;
  height:50px;
}

.event a
{
  text-decoration:none;
  color:#eee;
}

.event i
{
  color:#ddd;
  font-size:18px;
}


.event:after
{
  position:absolute;
  left:275px;
  border-color: transparent transparent transparent #666;
  border-style:solid;
  border-width:25px;
  height:0px;
  width:0px;
  content:"";
}

</style>

<div id="window">
  <ul id="pages">
    <li>
      <div id="timeline">        
      <?php
        $daysInAdvance = 15;
        $events = array_merge($ownevents, $participatingeventsts);

/*
        $lastEvent = 0;        
        foreach ($events as $event)
        {
          if ($event->begintime > $lastEvent)
          {
            $lastEvent = $event->begintime;
          }
        }         
        $daysToLastEvent = floor(($lastEvent - time())/(24*60*60));
*/

        for ($i = 0; $i < $daysInAdvance; $i++)
        {
          if ($i == 0)
          {
            echo "<div class='day today'>";                        
          }
          else
          {
            echo "<div class='day'>";            
          }
          
          $eventsOnThisDay = array();
          foreach ($events as $event)
          {
            $thisDay = strtotime("+".$i." day");
            $delta = floor(($event->begintime - $thisDay)/86400);
            if ($delta == 0)
            {
              $eventsOnThisDay[] = $event;
            }
          }
          
          if (count($eventsOnThisDay) > 0)
          {            
            echo anchor("event/new", "<b>".date("d.m.", strtotime("+".$i." day"))."</b>");
            for ($j=0; $j < count($eventsOnThisDay); $j++)
            {
              $event = $eventsOnThisDay[$j];
//              $duration = floor(($event->endtime - $event->begintime)/60);
              $dayStart = mktime(0,0,0, date("n", $event->begintime), date("j", $event->begintime), date("Y", $event->begintime));
              $begin = floor(($event->begintime - $dayStart)/(60*3));
              $end = floor(($event->endtime - $dayStart)/(60*3));
              
              //echo "<br>".$begin." / ".$end;
              //echo anchor("event/edit/".$event->id, $event->title);
         
              echo "<div class='event' begin='".$begin."' end='".$end."'>";
              echo "<i>".date("H:i", $event->begintime)."-".date("H:i", $event->endtime)."</i>&nbsp;&nbsp;&nbsp;".anchor("event/edit/".$event->id, $event->title);
              echo "</div>";  
            }

          }
          else
          {
            echo anchor("event/new", date("d.m.", strtotime("+".$i." day")));
          }                    
          echo "</div>";
        }

      ?>
      </div>
    </li>
  </ul>
</div>
