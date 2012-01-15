<div id="window">
  <ul id="pages">
    <li>
        <div class="userprofile">
          <img src="<? echo $user->picture; ?>"/>
          Hallo, <?php echo $user->name; ?>
        </div>
        
        <?php echo $logoutlink; ?>
		
        <div class="contentbox">
        	<ul>
			       <li id="friend_infoa">
              <canvas id="nearestfriendsCanvas" width="640" height="640"></canvas>
              <script>
              var canvas = document.getElementById("nearestfriendsCanvas").getContext("2d");
              
              // Kreis
              canvas.lineWidth = 3;
              canvas.strokeStyle = "#9e9a93";
              canvas.beginPath();
              canvas.arc(320, 320, 250, 0, Math.PI*2, true);
              canvas.closePath();
              canvas.stroke();
              canvas.beginPath();
              canvas.arc(320, 320, 150, 0, Math.PI*2, true);
              canvas.closePath();
              canvas.stroke();
              canvas.beginPath();
              canvas.arc(320, 320, 50, 0, Math.PI*2, true);
              canvas.closePath();
              canvas.stroke();

              // User zeichnen
              <?php
              $maxdist = 750;
              $pxdist = 250;
              $scalefactor = 1000.0;
              
              foreach ($friends as $friend)
              {
                $dx = floor($scalefactor * (71.5 * ($friend->lon - $user->lon))) * $pxdist / $maxdist;
                $dy = -floor($scalefactor * (111.3 * ($friend->lat - $user->lat))) * $pxdist / $maxdist;
                $dist = floor((sqrt(pow(71.5 * ($friend->lon - $user->lon),2) + pow(111.3 * ($friend->lat - $user->lat),2))) * 1000);
                if ($dx != 0 && $dy != 0 && abs($dx) < $maxdist && abs($dy) < $maxdist)  
                {
                  echo "                                      
                    canvas.font = '20px Segoe, Arial';
                    canvas.lineWidth = 5;
                    canvas.strokeStyle = '#585049';
                    canvas.fillStyle = '#669933';
                    canvas.beginPath();
                    canvas.arc(320+".$dx.", 320+".$dy.", 15, 0, Math.PI*2, true);
                    canvas.closePath();
                    canvas.stroke();
                    canvas.fill();                              
                    canvas.fillStyle = '#585049';
                    canvas.fillText('".$friend->name.": ".$dist."m', 340+".$dx.", 325+".$dy.");
                  ";
//                  echo "console.log('".$friend->name.":".$dx."/".$dy."');";
                }
              }            
              ?>              

              // Mittelpunkt
              canvas.lineWidth = 3;
              canvas.strokeStyle = "#585049";
              canvas.fillStyle = "#585049";
              canvas.beginPath();
              canvas.arc(320, 320, 5, 0, Math.PI*2, true);
              canvas.closePath();
              canvas.stroke();
              canvas.fill();                              
              </script>			   
            </li>
        		<li>
			      	<?php
			        	if (empty($newmessages) || count($newmessages) < 1)
			            {
			              echo anchor("mail/inbox", "<img src='../../images/message.png' /><div id='button_header'>Nachrichten<br><span class='additional_text'>Du hast keine neuen Nachrichten</span></div>", 'class="button_long"');
			            }
			            else
			            {
			              // echo anchor("mail/inbox", "<img src='../../images/new_message.png' /><span id='new_messages'>&nbsp;".count($newmessages)."</span><div id='button_header'>Nachrichten<br><span class='additional_text'>Du hast ".count($newmessages)." neue Nachricht(en)</span></div>", 'class="button_long"');
						  echo anchor("mail/inbox", "<img src='../../images/new_message.png' /><div id='button_header'>Nachrichten<br><span class='additional_text'>Du hast ".count($newmessages)." neue Nachricht(en)</span></div>", 'class="button_long"');
			            }
					?>		
				</li>
				<li><?php echo $eventlink; ?></li>
				<li><?php echo $locationlink; ?></li>
			</ul>                
        </div>
    </li>
  </ul>
</div>
