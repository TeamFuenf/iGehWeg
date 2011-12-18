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
 
body
{
  font-family: Segoe, verdana, helvetica, sans-serif;
}
    
td:not(.deleteicon)
{
  padding-left:20px;
  padding-right:20px;
  color:#bbb;
}    

a
{
  text-decoration:none;
  color:#bbb;
}

b
{
  color:#999;
}

p
{
  color:#666;
}
    
h1
{
  width:40%;
  padding:10px;
  font-family: SegoeLight, verdana, helvetica, sans-serif;
  color:#666;
  font-size:40px;
}

.sent
{
  text-align:right;
}

.sent p
{
  text-align:left;
  display:inline-block;
}

.received
{
  text-align:left;
}

</style>

<div id="window">
  <ul id="pages">
    <li>
      
<div>
<h1>
Nachrichten
</h1>


<table border=0 id="messages" width="95%" style="margin:0px auto">

<?php
global $month;

foreach($messages as $message)
{
  $user = img("helper/images/user/plain/".$message->id);
  $time = date("j.", $message->time)." ".$month[date("n", $message->time)];
  $deletelink = anchor("mail/delete/".$message->messageid, "&#10005;");
  
  echo "<tr>";
  if ($message->sender == $userid)
  {
    echo "<td width='64'>&nbsp;</td>";            
    echo "<td class='sent'><b>".$message->name."</b> am ".$time."<br/><p>".nl2br($message->body)."</p></td>";
    echo "<td width='64' valign='top'>".$user."</td>";
    echo "<td class='deleteicon' width='5' valign='top'>".$deletelink."</td>";            
  }
  else
  {
    echo "<td width='64' valign='top'>".$user."</td>";
    echo "<td class='received'><b>".$message->name."</b> am ".$time."<br/><p>".nl2br($message->body)."</p></td>";
    echo "<td width='64'></td>";            
    echo "<td class='deleteicon' width='5' valign='top'>".$deletelink."</td>";            
  }
  echo "</tr>";
  echo "<tr class='messageseparator'>";
  echo "<td colspan='3'><hr/></td><td></td>";
  echo "</tr>";  
}

?>

</table>

<table border=0 id="messagecompose" width="95%" style="margin:0px auto">
<tr>
  <td width="64"></td>
  <td>
    Neue Nachricht an <?php echo $receiver->name; ?>
    <input id="sendername" name="sender" type="hidden" value="<?php echo $me->name; ?>"/>
    <input id="senderimage" name="sender" type="hidden" value="<?php echo $me->picture; ?>"/>
    <input id="receiver" name="receiver" type="hidden" value="<?php echo $receiver->id; ?>"/>
    
    <textarea id="messagebox" style="resize:none; width:100%;height:100px"></textarea><br>
    <button id="sendmessage">senden</button>
  </td>
  <td width="64" valign="top"><!--img src="http://localhost/helper/images/user/plain/124"/--></td>  
  <td class="deleteicon" width='38' valign='top'>&nbsp;</td>
</tr>
</table>

</div>

    </li>
  </ul>
</div>
