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
        <div class="notice">
          Du siehst eine Zusammenfassung eines geplanten Events. Um Teilzunehmen oder um eigene Events zu planen <?php echo anchor("/","melde dich jetzt an"); ?>!
        </div>
        
        <div id="event_basedata">
          <table border="0" width="90%">
            <tr>
              <td colspan="2">
                <h1><?php echo $event->title; ?></h1>
              </td>
              <td width="200" height="200" rowspan="5">               
                <?php 
                  $linkAtts["class"] = "external button";                 
                  $link = site_url("event/".$event->id);
                  $twittermsg = urlencode("Ich nehme an ".$event->title." teil: ".$link);
                  $mailmsg = urlencode(
                    $event->title."\n".
                    "Am:".date("j.m.Y", $event->begintime)."\n".
                    "Von:".date("H:i:s", $event->begintime)."-".date("H:i:s", $event->endtime)
                  );
                  echo anchor("event/ical/".$event->id, "iCal Download", $linkAtts)."<br/><br/>";
                  echo anchor("http://twitter.com/?status=".$twittermsg, "Twitter", $linkAtts)."<br/><br/>";
                  echo mailto("?subject=".$event->title."&body=".$mailmsg, "E-Mail", $linkAtts);
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
        </div>
        
      </div>
    </li>
  </ul>
</div>