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

tr:nth-child(even)
{
  background-color:#ccc;
}

tr:nth-child(odd)
{
  background-color:#ddd;
}

a
{
  color:#666;
  text-decoration:none;
}

td:not(:first-child)
{
  padding-left:20px;
  padding-right:20px;
  color:#ccc;
}

</style>

<div id="window">
  <ul id="pages">
    <li>
      <div>
        <h1>Posteingang</h1>
        
        <table border=0 width="100%">
        <?php
        global $month;
        foreach ($messages as $message)
        {
          $messagepreview = $message->body;
          if (strlen($messagepreview) > 30)
          {
            $messagepreview = substr($messagepreview, 0, 30)."...";  
          }
          if ($message->status == "unread")
          {
            $messagepreview = "<b>".$messagepreview."</b>";  
          }
          
          $messagelink = $message->userid;
          $time = date("j.", $message->time)." ".$month[date("n", $message->time)];


          
          echo "<tr>";
          echo "<td><a href='".$messagelink."'>".img("helper/images/user/plain/".$message->userid)."</td>";
          echo "<td style='white-space:nowrap'><a href='".$messagelink."'>".$message->name." am ".$time."</a></td>";
          echo "<td width='90%'><a href='".$messagelink."'>".$messagepreview."</a></td>";
          echo "</tr>";
        }        
        ?>
        </table>
        
        <hr>
          <div id="messagestatus"></div>
             
          Neue Nachricht an 
          <select id="receiver" name="receiver">
            <?php
            foreach($receivers as $receiver)
            {
              echo "<option value='".$receiver->id."'>".$receiver->name."</option>";
            }
            ?>
          </select>
          <textarea id="messagebox" style="resize:none; width:100%;height:200px"></textarea><br>
          <button id="sendmessage_inbox">senden</button>
    
          </div>
    </li>
  </ul>
</div>