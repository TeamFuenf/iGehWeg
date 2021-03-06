<span id="eventid" eventid="<?php echo $eventid; ?>"></span>
<?php $time = time();?>

<div id="window">
  <ul id="pages">
    
    <li>
      <div>
        <h1 class="button_side">Event bearbeiten:</h1>

        <style>
          .selection
          {
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
            color:#999;
            margin:0px;
            padding:0px;
            border:0px;         
            background-color:transparent;
          }
          
          .selection input
          {
          	width: 80% !important;
          	display: inline-block;
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
        <input id='eventname' placeholder="Eventtitel..." name='eventname' value='<?php echo $event->title; ?>'/>
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
          echo "<b>von:</b>";          
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
          echo "<b>bis:</b>";
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
<!--
        <input name="publicevent" id="publicevent" type="checkbox">
        <label for="publicevent">Öffentliches Event</label>
-->
        <div id="checkresult" class="notice"></div>
        
        <button class="button_normal button_side" id="eventbutton_basedata_next">weiter</button>
        
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
      <div id="location_choose">
        <h1>Location:</h1>
        
        <script>
          $(function() {
          
            $("#location_order_az").on("click", function() {
              var list = $("ul#eventlocations");
              var listLi = $("li", list);
              listLi.sort(function(a, b)
              {
                var keyA = $(a).attr("name");
                var keyB = $(b).attr("name");
                return (keyA > keyB) ? 1 : 0;
              });
              
              $.each(listLi, function(index, row)
              {
                list.append(row);
              });
            });

            $("#location_order_distance").on("click", function() {
              var list = $("ul#eventlocations");
              var listLi = $("li", list);
              listLi.sort(function(a, b)
              {
                var keyA = parseInt($(a).attr("distance"));
                var keyB = parseInt($(b).attr("distance"));
                return (keyA > keyB) ? 1 : 0;
              });
              $.each(listLi, function(index, row)
              {
                list.append(row);
              });
            });
          
          });
        </script>
        
        <div id="button_wrap">
	        <span class="button_normal" id="location_order_az">a-z</span>
	        <span class="button_normal" id="location_order_distance">Distanz</span>
	        
	        <span class="button_normal" id="eventbutton_location_prev">zurück</span>
        </div>
        <hr/>
            
        <ul id="eventlocations">            
        <?php
          foreach ($locations as $location)
          {
            if ($location->id === $event->location)
            {
              $selectedModifier = "class='selected'";
            }
            else
            {
              $selectedModifier = "";              
            }

            echo "
            <li ".$selectedModifier." distance='".$location->distance."' name='".$location->name."' locationid='".$location->id."'>              
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
        <h1 class="button_side">Teilnehmer:</h1>
        <ul id="eventmembers">          
        <?php
          $count = 0;
		  $color_class = "";
        
          foreach ($members as $member)
          {
            if($count % 2 == 0) {
					$color_class = "green";
				} else {
					$color_class = "blue";
				}	
          	
            echo "<li class='button_long ".$color_class."' >";
			echo "<span class='friend_list_entry list_entry'>";
            echo "<img src='".$member->picture."'/>";
            echo $member->name;  
			echo "</span>";
                     
            if ($member->status == "invited")
            {
              echo "<span status='invited' memberid='".$member->id."'><img src='../../images/remove_".$color_class.".png' /></span>";                                          
            }
            else
            if ($member->status == "attending")
            {
              echo "<span class='button_small' status='attending' memberid='".$member->id."'>nim</span>";                                          
            }
            else
            {
              echo "<span class='button_small' status='none' memberid='".$member->id."'><img src='../../images/add_".$color_class.".png' /></span>";
            }   

            echo "</li>";
			$count++;
          }
        ?>
        </ul>
        <br/>
        <span class="button_normal button_side" id="eventbutton_members_prev">zurück</span>
      </div>
    </li> 

  </ul>
</div>
