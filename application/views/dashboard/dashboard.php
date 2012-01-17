<div id="window">
  <ul id="pages">
    <li>
      
        <div class="userprofile">
          <img src="<? echo $user->picture; ?>"/>
          Hallo, <?php echo $user->name; ?>
        </div>
        
        <?php echo $logoutlink; ?>
        
		<div id="friend_info">
		  <img id="circle_background" style="position:absolute;left:-9999px;" src="<?php echo site_url("images/back_test.png")?>"/>
			  <?php 
                $width = 640;
                $height= 303; 
                $radius1 = $height/2-1;
                $radius2 = $height/2 * 0.66;
                $radius3 = $height/2 * 0.33;
                $maxdist = 750; // Maximale dargestellte Entfernung in Metern
                
                $pxdist = $height/2;
                $scalefactor = 1000.0;
                $usedcoords[][] = array();
                
              ?>			        
              <canvas id="nearestfriendsCanvas" width="640" height="<? echo $height;?>"></canvas>

              <script>
              var canvas = document.getElementById("nearestfriendsCanvas").getContext("2d");
              
              // Hintergrundbild laden
              var imgObj = document.getElementById("circle_background");

              canvas.globalCompositeOperation = "destination-under";

              // Kreis
              canvas.lineWidth = 3;
              canvas.strokeStyle = "#5A524B";
              canvas.beginPath();
              canvas.arc(<? echo $width/2;?>, <? echo $height/2;?>, <? echo $radius1; ?>, 0, Math.PI*2, true);
              canvas.closePath();
              canvas.stroke();
              canvas.beginPath();
              canvas.arc(<? echo $width/2;?>, <? echo $height/2;?>, <? echo $radius2; ?>, 0, Math.PI*2, true);
              canvas.closePath();
              canvas.stroke();
              canvas.beginPath();
              canvas.arc(<? echo $width/2;?>, <? echo $height/2;?>, <? echo $radius3; ?>, 0, Math.PI*2, true);
              canvas.closePath();
              canvas.stroke();
              
              // User zeichnen
              <?php              
              
              foreach ($friends as $friend)
              {
              	$first_name = explode(" ", $friend->name);
				
                $dx = floor($scalefactor * (71.5 * ($friend->lon - $user->lon))) * $pxdist / $maxdist;
                $dy = -floor($scalefactor * (111.3 * ($friend->lat - $user->lat))) * $pxdist / $maxdist;
                $dist = floor((sqrt(pow(71.5 * ($friend->lon - $user->lon),2) + pow(111.3 * ($friend->lat - $user->lat),2))) * 1000);
                if ($dx != 0 && $dy != 0 && abs($dx) < $maxdist && abs($dy) < $maxdist && !isset($usedcoords[$dx][$dy]))  
                {                  
                  echo "                                      
                    canvas.font = '15px Segoe, Arial';
                    canvas.lineWidth = 4;
                    canvas.strokeStyle = '#585049';
                    canvas.fillStyle = '#669933';
                    canvas.beginPath();
                    canvas.arc(".($width/2 + $dx).", ".($height/2 + $dy).", 8, 0, Math.PI*2, true);
                    canvas.closePath();
                    canvas.stroke();
                    var dx = ".($width/2 + $dx + 10).";
                    var dy = ".($height/2 + $dy - 10).";
                    canvas.fill();
                    canvas.drawImage(imgObj, dx, dy+20, 100, 20, dx, dy, 100, 20);
                    canvas.fillStyle = '#666666';
                    canvas.fillText('".$first_name[0].": ".$dist."m', dx+5, dy+15);
                  ";
//                canvas.fillRect(".($width/2 + $dx + 9).", ".($height/2 + $dy + 3).", 150, 20);                              
                  $usedcoords[$dx][$dy] = $friend->name;
                }
              }
              ?>              

              // Mittelpunkt
              canvas.lineWidth = 3;
              canvas.strokeStyle = "#585049";
              canvas.fillStyle = "#585049";
              canvas.beginPath();
              canvas.arc(<? echo $width/2;?>, <? echo $height/2;?>, 4, 0, Math.PI*2, true);
              canvas.closePath();
              canvas.stroke();
              canvas.fill();                              
              </script>			   
            </div>
		
		
        <div class="contentbox">
        	<ul>
        		<li class="button_long">
			      	<?php
			        	if (empty($newmessages) || count($newmessages) < 1)
			            {
			              echo anchor("mail/inbox", "<img src='../../images/nonew_message.png' /><div id='button_header'>Nachrichten<br><span class='additional_text'>Du hast keine neuen Nachrichten</span></div>", array( 'class' => 'list_entry'));
			            }
			            else
			            {
						  echo anchor("mail/inbox", "<img src='../../images/new_message.png' /><div id='button_header'>Nachrichten<br><span class='additional_text'>Du hast ".count($newmessages)." neue Nachricht(en)</span></div>", array( 'class' => 'list_entry'));
			            }
					?>		
				</li>
				<li class="button_long blue"><?php echo $eventlink; ?></li>
				<li class="button_long green"><?php echo $friendlink; ?></li>
			</ul>                
        </div>
    </li>
  </ul>
</div>
