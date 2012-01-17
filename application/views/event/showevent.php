<script>
$(document).ready(function()
{

  $("button[name=send_comment]").on("click", function()
  {
    var comment = $("textarea").val();
    if (comment != "")
    {
      $.post("<?php echo site_url("event/update/comment"); ?>", {
        eventid: "<?php echo $event->id; ?>",
        comment: comment
      }, 
      function(data) 
      {
        comment = comment.replace(/\n/g, '<br />');
        comment = comment.replace(/\r/g, '<br />');        
        $("ul#comments").append(
          "<li class='button_long green'>"+
          "<div class=\"sender\"><?php echo "<img class='userimage' src='".$user->picture."'>".$user->name; ?>:</div>"+
          "<div class=\"comment\">" + comment + "</div>"+
          "<div style=\"clear:both\"></div>"+
          "</li>"
        );

        $("textarea").val("");
      });
    }    
  });
});

</script>
<style>

</style>

<div id="window">
  <ul id="pages">
    <li>
      <div>
        
        
        
        <div id="event_basedata">
          <table width="70%">
            <tr>
              <td colspan="2">
                <h1 id="event_header_123"><?php echo $event->title; ?></h1>
                <?php
          if ($event->creator == $user->id)
          {
            $linkAttributes["class"] = "edit_event_button";
            echo anchor("event/edit/".$event->id, "<img src='../../images/edit.png'", $linkAttributes);
          }
        ?>
              </td>              
            <tr><td colspan="2"><h2>Details:</h2></td></tr>
            <tr>
              <td>Location:</td>
              <td><?php echo $location->name; ?></td>
            </tr>
            <tr>
              <td>von:</td>
              <td><?php echo date("H:i j.n.Y", $event->begintime); ?></td>
            </tr>
            <tr>
              <td valign="top">bis:</td>
              <td valign="top"><?php echo date("H:i j.n.Y", $event->endtime); ?></td>
            </tr>
          </table>
        </div>
		<div id="outlinks" class="button_side">
          	<?php 
                  $linkAtts["class"] = "external button";                 
                  $link = site_url("event/show/".$event->id);
                  $twittermsg = urlencode("Ich nehme an ".$event->title." teil: ".$link);
                  $mailmsg = urlencode(
                    $event->title."\n".
                    "Am:".date("j.m.Y", $event->begintime)."\n".
                    "Von:".date("H:i:s", $event->begintime)."-".date("H:i:s", $event->endtime)."\n".
                    $link
                  );
                  echo anchor("event/ical/".$event->id, "<img src='../../images/logos/ical.png' />", $linkAtts)."";
                  echo anchor("http://twitter.com/?status=".$twittermsg, "<img src='../../images/logos/twitter.png' />", $linkAtts)."";
                  echo mailto("?subject=".$event->title."&body=".$mailmsg, "<img src='../../images/logos/email.png' />", $linkAtts)."";
                  echo anchor("event/show/".$event->id, "<img src='../../images/logos/link.png' />", $linkAtts)."";
                ?>
          </div>
        <h2 class="button_side">Veranstalter:</h2>
        	<ul id="event_creator">
        		<li class='button_long'><?php echo img($creator->picture).$creator->name; ?></li>
        	</ul>

        <h2 class="button_side">Teilnehmer:</h2>
        <div id="userid" style="display:none;" userid="<?php echo $user->id ?>"></div>
        <div id="event_members">
          <ul>          
          <?php
          $color_class = "";
		  $count = 0;
          
          foreach ($members as $member)
          {
          	if($count % 2 == 0) {
					$color_class = "green";
				} else {
					$color_class = "blue";
				}
			
            if ($member->status == "invited")
            {
              echo "<li class='invited button_long ".$color_class."'>";
            }
            else
            {
              echo "<li class='button_long ".$color_class."'>";            
            }
            echo "<span class='eventmember_info'>".img($member->picture).$member->name."</span>";

            // Teilnehmer in der Nähe ?
            // member lon/lat für Distanz ?
            // member lastupdate für letzte Position
            // Distanz nur anzeigen wenn Event x Minuten vorher ?
  
            if ($member->id == $user->id && ($member->status == "invited"))
            {
              echo "<span class='acceptevent button_small' eventid='".$event->id."'><img src='../../images/accept_".$color_class.".png' /></span>";
            }
            echo "</li>";
            $count++;
          }
          ?>
          </ul>
        </div>
        
        <div id="event_comments">
        <h2 class="button_side">Kommentare:</h2>
          <ul id="comments">
            <?php
            $color_class = "";
			$count = 0;
            
            foreach ($comments as $comment)
            {
              if($count % 2 == 0) {
					$color_class = "red";
				} else {
					$color_class = "blue";
				}	
				
              echo "
              <li class='button_long ".$color_class."'>
                <div class=\"sender\"><img class='userimage' src='".$comment->picture."'/>".$comment->name.":</div>
                <div class=\"comment\">".nl2br($comment->comment)."</div>
                <div style=\"clear:both\"></div>
              </li>              
              ";       
			  $count++;       
            }            
            ?>
          </ul>
          <ul>
            <li>
              <div class="sender">
              <?php 
                // echo "<img class='userimage' src='".$user->picture."'>".$user->name;
              ?></div>
              <div class="comment">
                <textarea placeholder="Kommentar eingeben..."></textarea>
                <button class="button_normal" name="send_comment">absenden</button>
              </div>
              <div style="clear:both"></div>              
            </li>
          </ul>
        </div>
        
      </div>
    </li>
  </ul>
</div>