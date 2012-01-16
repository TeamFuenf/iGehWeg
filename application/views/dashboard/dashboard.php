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
<<<<<<< HEAD
			        <?php
			          //echo "<ul>";
			          // foreach ($knearestfriends as $friend)
			          // {
			            // if ($friend->distance < 5000)
			            // {
			              // echo "<li id='friend_info'>".img($friend->picture)." ".$friend->name." (ca. ".$friend->distance."m)</li>";              
			            // }
			          // }
			          //echo "<ul>";
			        ?>
			   <li id="friend_info">
			   		
			   		<canvas id="myDrawing" width="300" height="303" style="margin-left: 170px">
						<p>Your browser doesn't support canvas.</p>
					</canvas>
			   		
			   		<script>
			   			var drawingCanvas = document.getElementById('myDrawing');
						// Check the element is in the DOM and the browser supports canvas
						if(drawingCanvas.getContext) {
							// Initaliase a 2-dimensional drawing context
							var context = drawingCanvas.getContext('2d');
							// Create the yellow face
							context.strokeStyle = "#FFFFFF";
							//context.fillStyle = "#FFFF00";
							context.beginPath();
							context.arc(150,150,145,0,Math.PI*2,true);
							context.closePath();
							context.stroke();
							//context.fill();
							
							var context1 = drawingCanvas.getContext('2d');
							// Create the yellow face
							context1.strokeStyle = "#FFFFFF";
							context1.fillStyle = "#FFFFFF";
							context1.beginPath();
							context1.arc(150,150,2,0,Math.PI*2,true);
							context1.closePath();
							context1.stroke();
							context1.fill();
							
							var context2 = drawingCanvas.getContext('2d');
							// Create the yellow face
							context2.strokeStyle = "#FFFFFF";
							context2.fillStyle = "red";
							context2.beginPath();
							context.arc(200,180,10,0,Math.PI*2,true);
							context2.closePath();
							context2.stroke();
							context2.fill();
							
							var context3 = drawingCanvas.getContext('2d');
							// Create the yellow face
							context3.strokeStyle = "#FFFFFF";
							context3.fillStyle = "green";
							context3.beginPath();
							context.arc(220,190,10,0,Math.PI*2,true);
							context3.closePath();
							context3.stroke();
							context3.fill();
						}
			   		</script>
			   </li>
        		<li class="button_long red">
=======
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
>>>>>>> b215361038ee0b6f8bcb7404628e3a9df04e5614
			      	<?php
			        	if (empty($newmessages) || count($newmessages) < 1)
			            {
			              echo anchor("mail/inbox", "<img src='../../images/new_message.png' /><div id='button_header'>Nachrichten<br><span class='additional_text'>Du hast keine neuen Nachrichten</span></div>");
			            }
			            else
			            {
			              // echo anchor("mail/inbox", "<img src='../../images/new_message.png' /><span id='new_messages'>&nbsp;".count($newmessages)."</span><div id='button_header'>Nachrichten<br><span class='additional_text'>Du hast ".count($newmessages)." neue Nachricht(en)</span></div>", 'class="button_long"');
						  echo anchor("mail/inbox", "<img src='../../images/new_message.png' /><div id='button_header'>Nachrichten<br><span class='additional_text'>Du hast ".count($newmessages)." neue Nachricht(en)</span></div>");
			            }
					?>		
				</li>
				<li class="button_long blue"><?php echo $eventlink; ?></li>
				<li class="button_long green"><?php echo $locationlink; ?></li>
			</ul>                
        </div>
    </li>
  </ul>
</div>
