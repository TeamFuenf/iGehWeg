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
          "<li>"+
          "<div class=\"sender\"><?php echo "<img class='userimage' src='".$user->picture."'>".$user->name; ?></div>"+
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
  font-family: SegoeLight, verdana, helvetica, sans-serif;
  color:#666;
  font-size:40px;
}

h2
{
  font-family: SegoeLight, verdana, helvetica, sans-serif;
  color:#666;
  font-size:20px;
}

#event_mapsnippet iframe
{
  width:300px;
  height:300px;
  margin:0px;
  padding:0px;
}

#event_members ul
{
  margin:0px;
  padding:0px;
  list-style-type:none;
}

#event_members li img,
#event_creator img
{
  color:#666;
  width:64px;
  height:64px;
  border-radius:10px;
  -moz-border-radius:10px;
  margin-right:25px;
  vertical-align:middle; 
}
 
#event_members li
{
  height:70px;
  padding-bottom:10px;
}

#event_members li.invited img
{
  opacity:0.3;
}

#event_members li.invited
{
  color:#ccc;
}

.userimage
{
  width:64px;
  height:64px;
  border-radius:10px;
  vertical-align:middle;
}

#event_comments ul
{
  margin:0px;
  padding:0px;
  list-style-type:none;
}

#event_comments ul li
{
  padding-bottom:10px;
}

#event_comments div.sender
{
  width:200px;
  float:left;
}

#event_comments div.comment
{
  float:left;
}

#event_comments textarea
{
  resize: none;
  width:350px;
  height:150px;
}

</style>

<div id="window">
  <ul id="pages">
    <li>
      <div>
        
        <?php
          if ($event->creator == $user->id)
          {
            $linkAttributes["class"] = "button";
            echo anchor("event/edit/".$event->id, "Event bearbeiten", $linkAttributes);
          }
        ?>
        
        <div id="event_basedata">
          <table border="0" width="90%">
            <tr>
              <td colspan="2">
                <h1><?php echo $event->title; ?></h1>
              </td>
              <td width="200" height="200" rowspan="5">               
                <?php 
                  $linkAtts["class"] = "external";
                  echo anchor("event/ical/".$event->id, "iCal Download", $linkAtts);
                ?>
                <!--
                <iframe src="../../map/snippet/10" width="250" height="250" frameborder="0">
                </iframe>
                -->
              </td>              
            <tr><td colspan="2"><h2>Details</h2></td></tr>
            <tr>
              <td>Location</td>
              <td><?php echo $location; ?></td>
            </tr>
            <tr>
              <td>Von</td>
              <td><?php echo date("H:i j.n.Y", $event->begintime); ?></td>
            </tr>
            <tr>
              <td>Bis</td>
              <td><?php echo date("H:i j.n.Y", $event->endtime); ?></td>
            </tr>
          </table>
        </div>

        <h2>Veranstalter</h2>
        <div id="event_creator">
		    <?php echo img($creator->picture).$creator->name; ?>               	
        </div>

        <h2>Teilnehmer</h2>
        <div id="userid" style="display:none;" userid="<?php echo $user->id ?>"></div>
        <div id="event_members">
          <ul>          
          <?php
          foreach ($members as $member)
          {
            if ($member->status == "invited")
            {
              echo "<li class='invited'>";
            }
            else
            {
              echo "<li>";            
            }
            echo img($member->picture).$member->name;

            // Teilnehmer in der Nähe ?
            // member lon/lat für Distanz ?
            // member lastupdate für letzte Position
            // Distanz nur anzeigen wenn Event x Minuten vorher ?
  
            if ($member->id == $user->id && ($member->status == "invited"))
            {
              echo "<button class='acceptevent' eventid='".$event->id."'>Teilnehmen</button>";
            }
            echo "</li>";
          }
          ?>
          </ul>
        </div>
        
        <div id="event_comments">
        <h2>Kommentare</h2>
          <ul id="comments">
            <?php
            foreach ($comments as $comment)
            {
              echo "
              <li>
                <div class=\"sender\"><img class='userimage' src='".$comment->picture."'/>".$comment->name."</div>
                <div class=\"comment\">".nl2br($comment->comment)."</div>
                <div style=\"clear:both\"></div>
              </li>              
              ";              
            }            
            ?>
          </ul>
          <ul>
            <li>
              <div class="sender">
              <?php 
                echo "<img class='userimage' src='".$user->picture."'>".$user->name;
              ?></div>
              <div class="comment">
                <textarea></textarea><br/>
                <button name="send_comment">absenden</button>
              </div>
              <div style="clear:both"></div>              
            </li>
          </ul>
        </div>
        
      </div>
    </li>
  </ul>
</div>